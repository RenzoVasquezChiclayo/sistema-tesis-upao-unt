<?php

namespace App\Http\Controllers;

use App\Models\Archivo_Tesis_ct2022;
use App\Models\AsesorCurso;
use App\Models\Detalle_Archivo;
use App\Models\EstudianteCT2022;
use App\Models\referencias;
use App\Models\TDetalleKeyword;
use App\Models\TDetalleObservacion;
use App\Models\Tesis_2022;
use App\Models\THistorialObservaciones;
use App\Models\TipoReferencia;
use App\Models\TKeyword;
use App\Models\TObjetivo;
use App\Models\TObservacion;
use App\Models\TReferencias;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Settings;

class Tesis2022Controller extends Controller
{
    // ------------------------------------------------------------------------------------------------------------------------
    // ------------------------------------------------TESIS-------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------------------------------

    public function indexTesis(){
        $id = auth()->user()->name;
        $aux = explode('-',$id);
        $id = $aux[0];

        $estudiante = EstudianteCT2022::find($id);
        $tesis = Tesis_2022::where('cod_matricula',$id)->first();
        $asesor = AsesorCurso::find($tesis->cod_docente);

        $correciones = TObservacion::join('t_historial_observaciones','t_observacion.cod_historial_observacion','=','t_historial_observaciones.cod_historial_observacion')
                        ->select('t_observacion.*')->where('t_historial_observaciones.cod_tesis',$tesis->cod_tesis)
                        ->where('t_observacion.estado',1)->get();

        $detalles = [];
        if(sizeof($correciones)>0){
            $detalles = TDetalleObservacion::where('id_observacion',$correciones[0]->cod_historial_observacion)->get();
        }
        $objetivos = TObjetivo::where('cod_tesis','=',$tesis->cod_tesis)->get();
        $tiporeferencia = TipoReferencia::all();
        $keywords = TDetalleKeyword::join('t_keyword','t_keyword.id_keyword','=','t_detalle_keyword.id_keyword')->select('t_detalle_keyword.*')->where('t_keyword.cod_tesis',$tesis->cod_tesis)->get();

        $resultadosImg = Detalle_Archivo::join('archivos_proy_tesis as at','at.cod_archivos','=','detalle_archivos.cod_archivos')->select('detalle_archivos.*')->where('at.cod_tesis',$tesis->cod_tesis)->where('tipo','resultados')->orderBy('grupo', 'ASC')->get();
        $anexosImg = Detalle_Archivo::join('archivos_proy_tesis as at','at.cod_archivos','=','detalle_archivos.cod_archivos')->select('detalle_archivos.*')->where('at.cod_tesis',$tesis->cod_tesis)->where('tipo','anexos')->orderBy('grupo', 'ASC')->get();
        $referencias = TReferencias::where('cod_tesis',$tesis->cod_tesis)->get();
        return view('cursoTesis20221.estudiante.tesis.tesis',['estudiante'=>$estudiante,'objetivos'=>$objetivos,
        'correciones' => $correciones,'detalles'=>$detalles,'asesor'=>$asesor,'tesis'=>$tesis,
        'tiporeferencia'=>$tiporeferencia,'keywords'=>$keywords, 'resultadosImg'=>$resultadosImg,
        'anexosImg'=>$anexosImg, 'referencias'=>$referencias]);
    }

    public function estadoTesis(){
        $id = auth()->user()->name;
        $aux = explode('-',$id);
        $id = $aux[0];
        $estudiante = EstudianteCT2022::find($id);
        $hTesis = Tesis_2022::where('cod_matricula','=',$estudiante->cod_matricula)->get();
        $asesor = AsesorCurso::find($hTesis[0]->cod_docente);
        return view('cursoTesis20221.estudiante.tesis.estadoTesis',['hTesis'=>$hTesis,'asesor'=>$asesor]);
    }

    public function saveTesis2022(Request $request){
        $isSaved = $request->isSaved;

        $tesis = Tesis_2022::find($request->txtcod_tesis);

        $observacionX = TObservacion::join('t_historial_observaciones','t_observacion.cod_historial_observacion','=','t_historial_observaciones.cod_historial_observacion')
                ->select('t_observacion.*')->where('t_historial_observaciones.cod_Tesis',$tesis->cod_tesis)
                ->where('t_observacion.estado',1)->get();

        if(sizeof($observacionX)>0){
            $detalles = TDetalleObservacion::where('id_observacion',$observacionX[0]->cod_historial_observacion)->get();
        }

        try{

            /*Si el egresado tiene una observacion pendiente, solo se guardaran los cambios solicitados*/
            if(sizeof($observacionX)>0){

                for($i=0; $i<sizeof($detalles);$i++){
                    $tema = $detalles[$i]->tema_referido;
                    $name_request='txt'.$tema;
                    $detalleEEG=TDetalleObservacion::find($detalles[$i]->id_detalle_observacion);

                    $detalleEEG->correccion=$request->$name_request;
                    $detalleEEG->save();
                }

                $historialX = THistorialObservaciones::where('cod_Tesis','=',$tesis->cod_tesis)->get();
                $historialX[0]->fecha = now();
                $historialX[0]->save();

                $observacionX[0]->estado = 2;
                $observacionX[0]->save();
            }
            if($request->listOldlobj!=""){
                $deleteObjetivos = explode(",",$request->listOldlobj);
                for($i = 0; $i<sizeof($deleteObjetivos);$i++){
                    TObjetivo::find($deleteObjetivos[$i])->delete();
                }
            }

            $tesis->titulo = $request->txttitulo;
            $tesis->cod_matricula = $request->txtCodMatricula;
            $tesis->cod_docente = $request->txtCodDocente;
            $tesis->dedicatoria = $request->txtdedicatoria ?: null;
            $tesis->agradecimiento = $request->txtagradecimiento ?: null;
            if ($request->txtpresentacion != ""){ $tesis->presentacion = $request->txtpresentacion;}
            if ($request->txtresumen != ""){ $tesis->resumen = $request->txtresumen;}


            if($request->list_keyword!=""){
                $tkeyword = TKeyword::where('cod_tesis',$request->txtcod_tesis)->first();
                if($tkeyword == null){
                    $tkeyword = new TKeyword();
                    $tkeyword->fecha_update = now();
                    $tkeyword->cod_tesis = $request->txtcod_tesis;
                    $tkeyword->save();
                    $tkeyword = TKeyword::where('cod_tesis',$request->txtcod_tesis)->first();
                }
                $list_keyword = explode(",",$request->list_keyword);
                foreach($list_keyword as $keyword){
                    $detalle_keyword = new TDetalleKeyword();
                    $detalle_keyword->id_keyword = $tkeyword->id_keyword;
                    $detalle_keyword->keyword = $keyword;
                    $detalle_keyword->save();
                }
            }
            if ($request->txtintroduccion != "") { $tesis->introduccion = $request->txtintroduccion; }

            /*Realidad problematica y others*/
            if($request->txtreal_problematica!=""){$tesis->real_problematica = $request->txtreal_problematica;}
            if($request->txtantecedentes!=""){$tesis->antecedentes = $request->txtantecedentes;}
            if($request->txtjustificacion!=""){$tesis->justificacion = $request->txtjustificacion;}
            if($request->txtformulacion_prob!=""){$tesis->formulacion_prob = $request->txtformulacion_prob;}

            /* Objetivos */
            $arregloTipoObj = [];
            $arreglodescripcionObj = [];
            if($request->idtipoObj!=""){
                $tipoObj = $request->idtipoObj;
                $descripcionObj = $request->iddescripcionObj;

                if(!empty($descripcionObj)){
                    foreach ($tipoObj as $tObj) {
                        $arregloTipoObj[] = $tObj;
                    }
                    foreach ($descripcionObj as $dObj) {
                        $arreglodescripcionObj[] = $dObj;
                    }
                    $cadena = "";
                    for ($i=0; $i <= count($tipoObj)-1 ; $i++) {
                        $objetivo = new TObjetivo();
                        $objetivo->tipo = $arregloTipoObj[$i];
                        $objetivo->descripcion = $arreglodescripcionObj[$i];
                        $cadena = $arregloTipoObj[$i].", ".$arreglodescripcionObj[$i].". ";
                        $objetivo->cod_tesis = $tesis->cod_tesis;
                        $objetivo->save();
                    }
                    if(sizeof($observacionX)>0){
                        for($i=0; $i<sizeof($detalles);$i++){
                            if($detalles[$i]->tema_referido == 'objetivos'){
                                $detalleEEG=TDetalleObservacion::find($detalles[$i]->cod_detalleObs);
                                $detalleEEG->correccion=$cadena;
                                $detalleEEG->save();
                            }

                        }
                    }
                }
            }


            /*Marco teorico*/
            if($request->txtmarco_teorico!=""){$tesis->marco_teorico = $request->txtmarco_teorico;}
            if($request->txtmarco_conceptual!=""){$tesis->marco_conceptual = $request->txtmarco_conceptual;}
            if($request->txtmarco_legal!=""){$tesis->marco_legal = $request->txtmarco_legal;}

            /*Hipotesis y disenio*/
            if($request->txtform_hipotesis!=""){$tesis->form_hipotesis = $request->txtform_hipotesis;}

            /*Material, metodos y tecnicas*/
            if($request->txtobjeto_estudio!=""){$tesis->objeto_estudio = $request->txtobjeto_estudio;}
            if($request->txtpoblacion!=""){$tesis->poblacion = $request->txtpoblacion;}
            if($request->txtmuestra!=""){$tesis->muestra = $request->txtmuestra;}
            if($request->txtmetodos!=""){$tesis->metodos = $request->txtmetodos;}
            if($request->txttecnicas_instrum!=""){$tesis->tecnicas_instrum = $request->txttecnicas_instrum;}

            /*Instrumentacion*/
            if($request->txtinstrumentacion!=""){$tesis->instrumentacion = $request->txtinstrumentacion;}

            /*Estrateg. metodologicas*/
            if($request->txtestg_metodologicas!=""){$tesis->estg_metodologicas = $request->txtestg_metodologicas;}

            /*Guarda texto de resultado*/
            $tesis->resultados = implode('%&%',$request->txtresultados);

            /*Guarda imagenes de resultados*/
            if($request->resultados_sendRow != ""){
                $list_row = [];
                $tamRow = strlen($request->resultados_sendRow);
                $historialArchivos = Archivo_Tesis_ct2022::where('cod_tesis',$tesis->cod_tesis)->first();
                if($historialArchivos == null){
                    $historialArchivos = new Archivo_Tesis_ct2022();
                    $historialArchivos->cod_tesis = $tesis->cod_tesis;
                    $historialArchivos->save();
                    $historialArchivos = Archivo_Tesis_ct2022::where('cod_tesis',$tesis->cod_tesis)->first();
                }
                if($tamRow>1){
                    $sendRow = explode(",",$request->resultados_sendRow);
                    foreach($sendRow as $row){
                        array_push($list_row,'resultados_img_'.$row);
                    }
                    for($i = 0; $i < sizeof($list_row) ; $i++){
                        $extra_img = $list_row[$i];
                        if($request->hasFile($extra_img)){
                            $file = $request->file($extra_img);
                            $destinationPath = 'cursoTesis-2022/img/'.$tesis->cod_matricula.'-Tesis/resultados/';
                            if (!file_exists($destinationPath)) {
                                mkdir($destinationPath,0777,true);
                            }
                            for($j = 0; $j<sizeof($file);$j++){
                                $posImg = $j;
                                $listDetalle = Detalle_Archivo::where('cod_archivos',$historialArchivos->cod_archivos)->where('grupo',$i)->where('tipo','resultados')->get();
                                if(sizeof($listDetalle)>0) $posImg = sizeof($listDetalle);
                                $det_archivo = new Detalle_Archivo();
                                $filename = $i.$posImg.'-'.$tesis->cod_matricula.'.jpg';
                                $uploadSuccess = $file[$j]->move($destinationPath,$filename);
                                $det_archivo->cod_archivos = $historialArchivos->cod_archivos;
                                $det_archivo->tipo = 'resultados';
                                $det_archivo->ruta = $filename;
                                $det_archivo->grupo = $i;
                                $det_archivo->save();
                            }
                        }
                    }
                }else{
                    $sendRow = $request->resultados_sendRow;
                    $fieldname = 'resultados_img_'.$sendRow;
                    $det_archivo = new Detalle_Archivo();
                    $file = $request->file($fieldname);

                    $destinationPath = 'cursoTesis-2022/img/'.$tesis->cod_matricula.'-Tesis/resultados/';
                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath,0777,true);
                    }
                    for($j = 0; $j<sizeof($file);$j++){
                        $posImg = $j;
                        $listDetalle = Detalle_Archivo::where('cod_archivos',$historialArchivos->cod_archivos)->where('grupo','0')->where('tipo','resultados')->get();
                        if(sizeof($listDetalle)>0) $posImg = sizeof($listDetalle);
                        $filename = '0'.$posImg.'-'.$tesis->cod_matricula.'.jpg';
                        $uploadSuccess = $file[$j]->move($destinationPath,$filename);
                        $det_archivo->cod_archivos = $historialArchivos->cod_archivos;
                        $det_archivo->tipo = 'resultados';
                        $det_archivo->ruta = $filename;
                        $det_archivo->grupo = 0;
                        $det_archivo->save();
                    }
                }
            }

            /*Guarda texto de anexos*/
            $tesis->anexos = implode('%&%',$request->txtanexos);

            /*Guarda imagenes de anexos*/
            if($request->anexos_sendRow != ""){
                $list_row = [];
                $tamRow = strlen($request->anexos_sendRow);
                $historialArchivos = Archivo_Tesis_ct2022::where('cod_tesis',$tesis->cod_tesis)->first();
                if($historialArchivos == null){
                    $historialArchivos = new Archivo_Tesis_ct2022();
                    $historialArchivos->cod_tesis = $tesis->cod_tesis;
                    $historialArchivos->save();
                    $historialArchivos = Archivo_Tesis_ct2022::where('cod_tesis',$tesis->cod_tesis)->first();
                }
                if($tamRow>1){
                    $sendRow = explode(",",$request->anexos_sendRow);
                    foreach($sendRow as $row){
                        array_push($list_row,'anexos_img_'.$row);
                    }
                    for($i = 0; $i < sizeof($list_row) ; $i++){
                        $extra_img = $list_row[$i];
                        if($request->hasFile($extra_img)){
                            $file = $request->file($extra_img);
                            $destinationPath = 'cursoTesis-2022/img/'.$tesis->cod_matricula.'-Tesis/anexos/';
                            if (!file_exists($destinationPath)) {
                                mkdir($destinationPath,0777,true);
                            }
                            for($j = 0; $j<sizeof($file);$j++){
                                $posImg = $j;
                                $listDetalle = Detalle_Archivo::where('cod_archivos',$historialArchivos->cod_archivos)->where('grupo',$i)->where('tipo','anexos')->get();
                                if(sizeof($listDetalle)>0) $posImg = sizeof($listDetalle);
                                $det_archivo = new Detalle_Archivo();
                                $filename = $i.$posImg.'-'.$tesis->cod_matricula.'.jpg';
                                $uploadSuccess = $file[$j]->move($destinationPath,$filename);
                                $det_archivo->cod_archivos = $historialArchivos->cod_archivos;
                                $det_archivo->tipo = 'anexos';
                                $det_archivo->ruta = $filename;
                                $det_archivo->grupo = $i;
                                $det_archivo->save();
                            }
                        }
                    }
                }else{
                    $sendRow = $request->anexos_sendRow;
                    $fieldname = 'anexos_img_'.$sendRow;
                    $det_archivo = new Detalle_Archivo();
                    $file = $request->file($fieldname);

                    $destinationPath = 'cursoTesis-2022/img/'.$tesis->cod_matricula.'-Tesis/anexos/';
                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath,0777,true);
                    }
                    for($j = 0; $j<sizeof($file);$j++){
                        $posImg = $j;
                        $listDetalle = Detalle_Archivo::where('cod_archivos',$historialArchivos->cod_archivos)->where('grupo','0')->where('tipo','anexos')->get();
                        if(sizeof($listDetalle)>0) $posImg = sizeof($listDetalle);
                        $filename = '0'.$posImg.'-'.$tesis->cod_matricula.'.jpg';
                        $uploadSuccess = $file[$j]->move($destinationPath,$filename);
                        $det_archivo->cod_archivos = $historialArchivos->cod_archivos;
                        $det_archivo->tipo = 'anexos';
                        $det_archivo->ruta = $filename;
                        $det_archivo->grupo = 0;
                        $det_archivo->save();
                    }
                }
            }

            // Discucion
            if($request->txtdiscucion!=""){$tesis->discusion = $request->txtdiscucion;}

            // Conclusiones
            if($request->txtconclusiones!=""){$tesis->conclusiones = $request->txtconclusiones;}

            // Recomendaciones
            if($request->txtrecomendaciones!=""){$tesis->recomendaciones = $request->txtrecomendaciones;}

            /*Referencias bibliograficas*/
            $arregloTipoRef = [];
            $arregloA = [];
            $arreglofP = [];
            $arregloT = [];
            $arregloF = [];
            $arregloE = [];
            $arregloTC = [];
            $arregloNumC = [];
            $arregloTR = [];
            $arregloVR = [];
            $arregloNW = [];
            $arregloNP = [];
            $arregloNI = [];
            $arregloST = [];
            $arregloNE = [];

            //Valores del request para posteriormente llenarlo en los arreglos
            $tipoRef = $request->idtipoAPA;
            $autorApa = $request->idautorApa;
            $fPublicacion = $request->idfPublicacion;
            $tituloTrabajo = $request->idtituloTrabajo;
            $fuente = $request->idfuente;
            $editorial = $request->ideditorial;
            $titCapitulo = $request->idtitCapitulo;
            $numCapitulos = $request->idnumCapitulos;
            $titRevista = $request->idtitRevista;
            $volumenRevista = $request->idvolumenRevista;
            $nombreWeb = $request->idnombreWeb;
            $nombrePeriodista = $request->idnombrePeriodista;
            $nombreInstitucion = $request->idnombreInstitucion;
            $subtitInfo = $request->idsubtitInfo;
            $nombreEditorInfo = $request->idnombreEditorInfo;

            if (empty($tipoRef)!=1) {
                foreach($tipoRef as $tAPA)
                {
                    $arregloTipoRef[] = $tAPA;
                }
            }

            if (empty($autorApa)!=1) {
                foreach($autorApa as $aut)
                {
                    $arregloA[] = $aut;
                }
            }

            if (empty($fPublicacion)!=1) {
                foreach($fPublicacion as $fecha)
                {
                    $arreglofP[] = $fecha;
                }
            }


            if (empty($tituloTrabajo)!=1) {
                foreach($tituloTrabajo as $tit)
                {
                    $arregloT[] = $tit;
                }
            }

            if (empty($fuente)!=1) {
                foreach($fuente as $fu)
                {
                    $arregloF[] = $fu;
                }
            }

            if (empty($editorial)!=1) {
                foreach($editorial as $edit)
                {
                    $arregloE[] = $edit;
                }
            }

            if (empty($titCapitulo)!=1) {
                foreach($titCapitulo as $titC)
                {
                    $arregloTC[] = $titC;
                }
            }


            if (empty($numCapitulos)!=1) {
                foreach($numCapitulos as $numC)
                {
                    $arregloNumC[] = $numC;
                }
            }



            if (empty($titRevista) != 1) {
                foreach($titRevista as $titR)
                {
                    $arregloTR[] = $titR;
                }
            }
            if (empty($volumenRevista) != 1) {
                    foreach($volumenRevista as $volR)
                {
                    $arregloVR[] = $volR;
                }
            }
            if (empty($nombreWeb) != 1) {
                foreach($nombreWeb as $nameW)
                {
                    $arregloNW[] = $nameW;
                }
            }
            if (empty($nombrePeriodista) != 1) {
                    foreach($nombrePeriodista as $nameP)
                {
                    $arregloNP[] = $nameP;
                }
            }
            if (empty($nombreInstitucion) != 1) {
                foreach($nombreInstitucion as $nameIns)
                {
                    $arregloNI[] = $nameIns;
                }
            }
            if (empty($subtitInfo) != 1) {
                    foreach($subtitInfo as $subtit)
                {
                    $arregloST[] = $subtit;
                }
            }
            if (empty($nombreEditorInfo) != 1) {
                foreach($nombreEditorInfo as $nameE)
                {
                    $arregloNE[] = $nameE;
                }
            }


            $aux1 = 0;
            $aux2 = 0;
            $aux3 = 0;
            $aux4 = 0;
            $aux5 = 0;
            $aux6 = 0;
            if(!empty($autorApa)){
                for ($i=0; $i <= count($autorApa)-1 ; $i++) {
                    $referencias = new TReferencias();
                    $referencias->cod_tiporeferencia = $arregloTipoRef[$i];
                    $referencias->autor = $arregloA[$i];
                    $referencias->fPublicacion = $arreglofP[$i];
                    $referencias->titulo = $arregloT[$i];
                    $referencias->fuente = $arregloF[$i];
                    if ($arregloTipoRef[$i] == 1) {
                        if (empty($arregloE[$aux1]) == 1) {
                            $referencias->editorial = " ";
                        }else {
                            $referencias->editorial = $arregloE[$aux1];
                        }
                        if (empty($arregloTC[$aux1])== 1) {
                            $referencias->title_cap = " ";
                        }else {
                            $referencias->title_cap = $arregloTC[$aux1];
                        }
                        if (empty($arregloNumC[$aux1]) == 1) {
                            $referencias->num_capitulo = " ";
                        } else {
                            $referencias->num_capitulo = $arregloNumC[$aux1];
                        }
                        $aux1++;
                    }
                    if($arregloTipoRef[$i] == 2) {
                        if (empty($arregloTR[$aux2]) == 1) {
                            $referencias->title_revista = " ";
                        } else {
                            $referencias->title_revista = $arregloTR[$aux2];
                        }
                        if (empty($arregloVR[$aux2])== 1) {
                            $referencias->volumen = " ";
                        } else {
                            $referencias->volumen = $arregloVR[$aux2];
                        }
                        $aux2++;
                    }
                    if($arregloTipoRef[$i] == 3) {
                        if (empty($arregloNW[$aux3]) == 1) {
                            $referencias->name_web = " ";
                        } else {
                            $referencias->name_web = $arregloNW[$aux3];
                        }
                        $aux3++;
                    }
                    if($arregloTipoRef[$i] == 4) {
                        if (empty($arregloNP[$aux4]) == 1) {
                            $referencias->name_periodista = " ";
                        } else {
                            $referencias->name_periodista = $arregloNP[$aux4];
                        }
                        $aux4++;
                    }
                    if($arregloTipoRef[$i] == 5) {
                        if (empty($arregloNI[$aux5]) == 1) {
                            $referencias->name_institucion = " ";
                        } else {
                            $referencias->name_institucion = $arregloNI[$aux5];
                        }
                        $aux5++;
                    }
                    if($arregloTipoRef[$i] == 6) {
                        if (empty($arregloST[$aux6]) == 1) {
                            $referencias->subtitle = " ";
                        } else {
                            $referencias->subtitle = $arregloST[$aux6];
                        }
                        if (empty($arregloNE[$aux6]) == 1) {
                            $referencias->name_editor = " ";
                        } else {
                            $referencias->name_editor = $arregloNE[$aux6];
                        }
                        $aux6++;
                    }
                    $referencias->cod_tesis = $tesis->cod_tesis;
                    $referencias->save();

                }
            }

            if($isSaved == "true"){
                $tesis->estado = 9;
            }else{
                $tesis->estado = 1;
            }
            $tesis->fecha_update = now();
            $tesis->save();

        }catch(Exception $th){
            return redirect()->route('curso.registro-tesis')->with('datos','oknot');

        }

        return redirect()->route('curso.estado-tesis')->with('datos','ok');
    }

    const PAG_ASIGNACION=10;
    public function showEstudentsForAsignacion(Request $request){
        $buscar_estudiante = $request->buscar_estudiante;
        if($buscar_estudiante!=""){
            if (is_numeric($buscar_estudiante)) {
                $estudiantes = DB::table('estudiante_ct2022 as e')->leftJoin('tesis_2022 as t','t.cod_matricula','=','e.cod_matricula')
                ->select('e.*', 't.cod_docente')
                ->where('e.cod_matricula','like','%'.$buscar_estudiante.'%')
                ->paginate($this::PAG_ASIGNACION);
            } else {
                $estudiantes = DB::table('estudiante_ct2022 as e')->leftJoin('tesis_2022 as t','t.cod_matricula','=','e.cod_matricula')
                ->select('e.*', 't.cod_docente')
                ->where('e.apellidos','like','%'.$buscar_estudiante.'%')->paginate($this::PAG_ASIGNACION);
            }
        }else{
            $estudiantes = DB::table('estudiante_ct2022 as e')->leftJoin('tesis_2022 as t','t.cod_matricula','=','e.cod_matricula')
            ->select('e.*','t.cod_docente')
            ->paginate($this::PAG_ASIGNACION);
        }
        $asesores = AsesorCurso::all();
        return view('cursoTesis20221.director.tesis.asignarAsesorTesis',['estudiantes'=>$estudiantes,'asesores'=>$asesores,'buscar_estudiante'=>$buscar_estudiante]);
    }

    public function saveAsignacionTesis(Request $request){

        $asesor_asignado = $request->saveAsesor;
        $posicion = explode(',',$asesor_asignado);
        $i = 0;
        do {
            if ($posicion[$i]!=null) {
                $datos = explode('_',$posicion[$i]);
                $estudiante = EstudianteCT2022::find($datos[0]);
                //Crear una registro de Tesis para asignar el asesor.
                $tesisFound = Tesis_2022::where('cod_matricula',$estudiante->cod_matricula)->first();
                if($tesisFound==null){
                    $tesis = new Tesis_2022();
                    $tesis->cod_matricula = $estudiante->cod_matricula;

                }
                $tesisFound->cod_docente = $datos[1];
                $tesisFound->fecha_create = now();
                $tesisFound->fecha_update = now();
                $tesisFound->save();
            }
            $i++;
        } while ($i<count($posicion));

        return redirect()->route('director.asignarAsesorTesis')->with('datos','ok');
    }

    public function showEstudiantAsignado(){
        $estudiantes = DB::table('estudiante_ct2022 as e')->leftJoin('tesis_2022 as t','t.cod_matricula','=','e.cod_matricula')->select('e.*','t.cod_docente')->where('t.cod_docente','!=',null)->paginate($this::PAG_ASIGNACION);
        $asesores = AsesorCurso::all();
        return view('cursoTesis20221.director.tesis.editarAsignarAsesor',['estudiantes'=>$estudiantes,'asesores'=>$asesores]);
    }

    public function saveEditarAsignacion(Request $request){
        $asesor_asignado = $request->saveAsesor;
        $posicion = explode(',',$asesor_asignado);
        $i = 0;
        do {
            if ($posicion[$i]!=null) {
                $datos = explode('_',$posicion[$i]);
                $estudiante = EstudianteCT2022::find($datos[0]);
                $tesis = Tesis_2022::where('cod_matricula',$estudiante->cod_matricula)->first();
                $tesis->cod_docente = $datos[1];
                $tesis->save();
            }
            $i++;
        } while ($i<count($posicion));

        return redirect()->route('director.asignarAsesorTesis')->with('datos','ok');
    }

    public function showEstudiantesTesis(){

        $estudiantes = DB::table('estudiante_ct2022')->join('tesis_2022 as t','estudiante_ct2022.cod_matricula','=','t.cod_matricula')
                            ->join('asesor_curso as ac','t.cod_docente','=','ac.cod_docente')
                            ->select('estudiante_ct2022.*','t.estado','t.cod_tesis')->where('ac.username','=',auth()->user()->name)->get();

        return view('cursoTesis20221.asesor.tesis.lista-estudiantes-tesis',['estudiantes'=>$estudiantes]);
    }

    public function revisarTesis(Request $request){
        $Tesis = [];
        $campoTesis = [];
        $aux = 0;
        $aux_campo = 0;
        $isFinal = 'false';
        $camposFull = 'false';

        $cod_matricula = $request->cod_matricula;
        $Tesis = DB::table('tesis_2022 as t')
                            ->join('estudiante_ct2022 as et','et.cod_matricula','=','t.cod_matricula')
                            ->join('asesor_curso as ac','t.cod_docente','=','ac.cod_docente')
                            ->select('t.*','et.nombres as nombresAutor','et.apellidos as apellidosAutor','ac.*')->where('et.cod_matricula',$cod_matricula)->get();

        $validaTesis = DB::table('tesis_2022')->join('estudiante_ct2022','estudiante_ct2022.cod_matricula','=','tesis_2022.cod_matricula')->select('tesis_2022.*')->where('estudiante_ct2022.cod_matricula',$cod_matricula)->get();

        foreach ($validaTesis[0] as $curso) {
            $arregloAux[$aux] = $curso;
            $aux++;
        }
        for ($i=0; $i < sizeof($arregloAux)-4; $i++) {
            if ($arregloAux[$i]!=null) {
                $isFinal = 'true';
            }else{
                $isFinal = 'false';
                break;
            }
        }

        /*Recoger imagenes de resultados*/
        $resultadosImg = Detalle_Archivo::join('archivos_proy_tesis as at','at.cod_archivos','=','detalle_archivos.cod_archivos')->select('detalle_archivos.*')->where('at.cod_tesis',$Tesis[0]->cod_tesis)->where('tipo','resultados')->orderBy('grupo', 'ASC')->get();

        /*Recoger imagenes de anexos*/
        $anexosImg = Detalle_Archivo::join('archivos_proy_tesis as at','at.cod_archivos','=','detalle_archivos.cod_archivos')->select('detalle_archivos.*')->where('at.cod_tesis',$Tesis[0]->cod_tesis)->where('tipo','anexos')->orderBy('grupo', 'ASC')->get();

        $keywords = TDetalleKeyword::join('t_keyword','t_keyword.id_keyword','=','t_detalle_keyword.id_keyword')->select('t_detalle_keyword.*')->where('t_keyword.cod_tesis',$Tesis[0]->cod_tesis)->get();

        $observaciones = TObservacion::join('t_historial_observaciones as ho','ho.cod_historial_observacion','=','t_observacion.cod_historial_observacion')->select('t_observacion.*')->where('ho.cod_tesis',$Tesis[0]->cod_tesis)->get();

        $objetivos = TObjetivo::where('cod_tesis','=',$Tesis[0]->cod_tesis)->get();

        $referencias = TReferencias::where('cod_tesis','=',$Tesis[0]->cod_tesis)->get();
        return view('cursoTesis20221.asesor.tesis.progreso-estudiante',['Tesis'=>$Tesis,'keywords'=>$keywords,'objetivos'=>$objetivos,'$observaciones' => $observaciones,'isFinal'=>$isFinal,'referencias'=>$referencias, 'resultadosImg'=>$resultadosImg, 'anexosImg'=>$anexosImg]);

    }

    public function guardarSinObservaciones(Request $request){
        $idTesis = $request->textcod;
        try {
            $tesis = Tesis_2022::find($idTesis);
            $tesis->estado = 2;
            $tesis->save();

        } catch (\Throwable $th) {
            $th;
        }


        return redirect()->route('asesor.estudiantes-tesis');
    }

    public function guardarConObservaciones(Request $request){
        $idTesis = $request->textcod;

        $Tesis = DB::table('tesis_2022 as t')
                       ->join('estudiante_ct2022','estudiante_ct2022.cod_matricula','=','t.cod_matricula')
                       ->join('asesor_curso','t.cod_docente','=','asesor_curso.cod_docente')
                       ->select('t.*','estudiante_ct2022.nombres as nombresAutor','estudiante_ct2022.apellidos as apellidosAutor')->where('asesor_curso.username','=',auth()->user()->name)->where('estudiante_ct2022.cod_matricula',$request->cod_matricula_hidden)->get();



        $existHisto = THistorialObservaciones::where('cod_Tesis',$Tesis[0]->cod_tesis)->get();
        if($existHisto->count()==0){
            $existHisto = new THistorialObservaciones();
            $existHisto->cod_Tesis = $Tesis[0]->cod_tesis;
            $existHisto->fecha=now();
            $existHisto->estado=1;
            $existHisto->save();
        }

        $existHisto = THistorialObservaciones::where('cod_Tesis',$Tesis[0]->cod_tesis)->get();


        try {
            $observaciones = new TObservacion();
            // $observaciones->cod_tesis = $Tesis[0]->cod_tesis;
            $observaciones->cod_historial_observacion = $existHisto[0]->cod_historial_observacion;
            $observaciones->fecha_create = now();

            // if($request->tachkCorregir1!=""){
            //     $observaciones->titulo = $request->tachkCorregir1;
            //     $arrayThemes[]='titulo';
            // }
            // if($request->tachkCorregir2!=""){
            //     $observaciones->dedicatoria = $request->tachkCorregir2;
            //     $arrayThemes[]='dedicatoria';
            // }

            // if($request->tachkCorregir3!=""){
            //     $observaciones->agradecimiento = $request->tachkCorregir3;
            //     $arrayThemes[]='agradecimiento';
            // }

            if($request->tachkCorregir4!=""){
                $observaciones->presentacion = $request->tachkCorregir4;
                $arrayThemes[]='presentacion';
            }
            if($request->tachkCorregir5!=""){
                $observaciones->resumen = $request->tachkCorregir5;
                $arrayThemes[]='resumen';
            }
            if($request->tachkCorregir6!=""){
                $observaciones->introduccion = $request->tachkCorregir6;
                $arrayThemes[]='introduccion';
            }

            if($request->tachkCorregir7!=""){
                $observaciones->real_problematica = $request->tachkCorregir7;
                $arrayThemes[]='real_problematica';
            }
            if($request->tachkCorregir8!=""){
                $observaciones->antecedentes = $request->tachkCorregir8;
                $arrayThemes[]='antecedentes';
            }
            if($request->tachkCorregir9!=""){
                $observaciones->justificacion = $request->tachkCorregir9;
                $arrayThemes[]='justificacion';
            }
            if($request->tachkCorregir10!=""){
                $observaciones->formulacion_prob = $request->tachkCorregir10;
                $arrayThemes[]='formulacion_prob';
            }
            if($request->tachkCorregir11!=""){
                $observaciones->objetivos = $request->tachkCorregir11;
                $arrayThemes[]='objetivos';
            }
            if($request->tachkCorregir12!=""){
                $observaciones->marco_teorico = $request->tachkCorregir12;
                $arrayThemes[]='marco_teorico';
            }

            if($request->tachkCorregir13!=""){
                $observaciones->marco_conceptual = $request->tachkCorregir13;
                $arrayThemes[]='marco_conceptual';
            }
            if($request->tachkCorregir14!=""){
                $observaciones->marco_legal = $request->tachkCorregir14;
                $arrayThemes[]='marco_legal';
            }
            if($request->tachkCorregir15!=""){
                $observaciones->form_hipotesis = $request->tachkCorregir15;
                $arrayThemes[]='form_hipotesis';
            }
            if($request->tachkCorregir16!=""){
                $observaciones->objeto_estudio = $request->tachkCorregir16;
                $arrayThemes[]='objeto_estudio';
            }
            if($request->tachkCorregir17!=""){
                $observaciones->poblacion = $request->tachkCorregir17;
                $arrayThemes[]='poblacion';
            }
            if($request->tachkCorregir18!=""){
                $observaciones->muestra = $request->tachkCorregir18;
                $arrayThemes[]='muestra';
            }
            if($request->tachkCorregir19!=""){
                $observaciones->metodos = $request->tachkCorregir19;
                $arrayThemes[]='metodos';
            }
            if($request->tachkCorregir20!=""){
                $observaciones->tecnicas_instrum = $request->tachkCorregir20;
                $arrayThemes[]='tecnicas_instrum';
            }
            if($request->tachkCorregir21!=""){
                $observaciones->instrumentacion = $request->tachkCorregir21;
                $arrayThemes[]='instrumentacion';
            }
            if($request->tachkCorregir22!=""){
                $observaciones->estg_metodologicas = $request->tachkCorregir22;
                $arrayThemes[]='estg_metodologicas';
            }
            if($request->tachkCorregir23!=""){
                $observaciones->resultados = $request->tachkCorregir23;
                $arrayThemes[]='resultados';
            }
            if($request->tachkCorregir24!=""){
                $observaciones->discusion = $request->tachkCorregir24;
                $arrayThemes[]='discusion';
            }
            if($request->tachkCorregir25!=""){
                $observaciones->conclusiones = $request->tachkCorregir25;
                $arrayThemes[]='conclusiones';
            }
            if($request->tachkCorregir26!=""){
                $observaciones->recomendaciones = $request->tachkCorregir26;
                $arrayThemes[]='recomendaciones';
            }
            if($request->tachkCorregir27!=""){
                $observaciones->referencias = $request->tachkCorregir27;
                $arrayThemes[]='referencias';
            }
            $observaciones->estado = 1;

            $observaciones->save();
            $tesis = Tesis_2022::find($idTesis);
            $tesis->estado = 2;
            $tesis->save();

        } catch (\Throwable $th) {
            dd($th);
        }

        $latestCorrecion = TObservacion::where('cod_historial_observacion',$existHisto[0]->cod_historial_observacion)->where('estado',1)->get();
        for($i = 0; $i<sizeof($arrayThemes);$i++){
            $detalleObs = new TDetalleObservacion();
            $detalleObs->id_observacion=$latestCorrecion[0]->cod_historial_observacion;
            $detalleObs->tema_referido = $arrayThemes[$i];
            $detalleObs->correccion = null;
            $detalleObs->save();
        }
        // return redirect()->route('asesor.verHistoObs')->with('datos','ok');
        return redirect()->route('asesor.ver-obs-estudiante-tesis',$existHisto[0]->cod_historial_observacion)->with('datos','ok');

    }


    public function listaObsEstudianteTesis($cod_historial_observacion){
        $observaciones = TObservacion::where('cod_historial_observacion',$cod_historial_observacion)->get();
        $estudiante = Tesis_2022::join('t_historial_observaciones','tesis_2022.cod_tesis','=','t_historial_observaciones.cod_Tesis')
                                ->join('estudiante_ct2022','estudiante_ct2022.cod_matricula','tesis_2022.cod_matricula')
                                ->select('tesis_2022.*','estudiante_ct2022.*')->where('t_historial_observaciones.cod_historial_observacion',$cod_historial_observacion)->get();

        return view('cursoTesis20221.asesor.tesis.lista-obs-estudiante',['observaciones'=>$observaciones,'estudiante'=>$estudiante]);
    }
    const PAGINATION = 10;
    public function verEstudiantesObservacionTesis(Request $request){
        $buscarObservaciones = $request->get('buscarObservacion');
        $id = auth()->user()->name;
        $asesor = AsesorCurso::where('username',$id)->get();
        if (is_numeric($buscarObservaciones)) {
            $estudiantes = DB::connection('mysql')->table('estudiante_ct2022')->join('tesis_2022','estudiante_ct2022.cod_matricula','=','tesis_2022.cod_matricula')->join('t_historial_observaciones','tesis_2022.cod_tesis','=','t_historial_observaciones.cod_tesis')
                            ->select('estudiante_ct2022.*','t_historial_observaciones.fecha','t_historial_observaciones.cod_historial_observacion')->where('tesis_2022.cod_matricula','like','%'.$buscarObservaciones.'%')->where('tesis_2022.cod_docente',$asesor[0]->cod_docente)->paginate($this::PAGINATION);
        } else {
            $estudiantes = DB::connection('mysql')->table('estudiante_ct2022')->join('tesis_2022','estudiante_ct2022.cod_matricula','=','tesis_2022.cod_matricula')->join('t_historial_observaciones','tesis_2022.cod_tesis','=','t_historial_observaciones.cod_Tesis')
                            ->select('estudiante_ct2022.*','t_historial_observaciones.fecha','t_historial_observaciones.cod_historial_observacion')->where('estudiante_ct2022.apellidos','like','%'.$buscarObservaciones.'%')->where('tesis_2022.cod_docente',$asesor[0]->cod_docente)->paginate($this::PAGINATION);
        }

        if(empty($estudiantes)){
            return view('cursoTesis20221.asesor.tesis.estudiantes-obs',['buscarObservaciones'=>$buscarObservaciones,'estudiantes'=>$estudiantes])->with('datos','No se encontro algun registro');
        }else{
            return view('cursoTesis20221.asesor.tesis.estudiantes-obs',['buscarObservaciones'=>$buscarObservaciones,'estudiantes'=>$estudiantes]);
        }

    }

    /*FUNCION PARA DESCARGAR EL WORD DE LA TESIS*/
    public function descargaTesis(Request $request){

        $cod_Tesis = $request->cod_Tesis;
        $lineKeywords = "";
        $tesis = Tesis_2022::join('asesor_curso','tesis_2022.cod_docente','=','asesor_curso.cod_docente')
                            ->join('estudiante_ct2022','tesis_2022.cod_matricula','=','estudiante_ct2022.cod_matricula')
                            ->select('tesis_2022.*','asesor_curso.*','estudiante_ct2022.nombres as nombresAutor','estudiante_ct2022.apellidos as apellidosAutor')
                            ->where('cod_tesis',$cod_Tesis)->get();
            // Dedicatoria
            $dedicatoria = $tesis[0]->dedicatoria;
            // Agradecimiento
            $agradecimiento = $tesis[0]->agradecimiento;
            // Presentacion
            $presentacion = $tesis[0]->presentacion;
            // Resumen
            $resumen = $tesis[0]->resumen;
            // Keywords
            $keywords = TDetalleKeyword::join('t_keyword','t_detalle_keyword.id_keyword','=','t_keyword.id_keyword')
                                        ->join('tesis_2022','t_keyword.cod_tesis','=','tesis_2022.cod_tesis')
                                        ->select('t_detalle_keyword.*')->get();

            foreach ($keywords as $key) {
                $lineKeywords .= $key->keyword.',';
            }

            // Introduccion
            $introduccion = $tesis[0]->introduccion;
            /*Datos del Autor*/
            $nombres =$tesis[0]->nombresAutor.' '.$tesis[0]->apellidosAutor;

            /*Datos del Asesor*/
            $nombre_asesor = $tesis[0]->nombres;
            $grado_asesor = $tesis[0]->grado_academico;
            $titulo_asesor = $tesis[0]->titulo_profesional;
            $direccion_asesor =$tesis[0]->direccion;

            /*Proyecto de Investigacion y/o Tesis*/
            $titulo = $tesis[0]->titulo;

            /*Realidad problematica y others*/
            $real_problematica = $tesis[0]->real_problematica;

            $antecedentes = $tesis[0]->antecedentes;
            $justificacion = $tesis[0]->justificacion;
            $formulacion_prob = $tesis[0]->formulacion_prob;

            /*Hipotesis y disenio*/
            $form_hipotesis = $tesis[0]->form_hipotesis;

            /*Material, metodos y tecnicas*/
            $objeto_estudio = $tesis[0]->objeto_estudio;
            $poblacion = $tesis[0]->poblacion;
            $muestra = $tesis[0]->muestra;
            $metodos = $tesis[0]->metodos;
            $tecnicas_instrum = $tesis[0]->tecnicas_instrum;

            /*Instrumentacion*/
            $instrumentacion = $tesis[0]->instrumentacion;

            /*Estrateg. metodologicas*/
            $estg_metodologicas = $tesis[0]->estg_metodologicas;

            /*Marco teorico*/
            $marco_teorico = $tesis[0]->marco_teorico;
            $marco_conceptual = $tesis[0]->marco_conceptual;
            $marco_legal = $tesis[0]->marco_legal;

            $resultados = $tesis[0]->resultados;
            $anexos = $tesis[0]->anexos;

            $discusion = $tesis[0]->discusion;
            $conclusiones = $tesis[0]->conclusiones;
            $recomendaciones = $tesis[0]->recomendaciones;

            Settings::setOutputEscapingEnabled(true);

            $word = new PhpWord();

            /* Creacion de las fuentes */
            $word->setDefaultFontName('Times New Roman');
            $word->setDefaultFontSize(11);


            $titulos = 'titulos';
            $word->addFontStyle($titulos,array('bold'=>true));

            /* Estilos de la caratula */
            $styleCaratula1 = 'styleCaratula1';
            $word->addParagraphStyle($styleCaratula1,array('align'=>'center','spacing' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.08)));

            $styleCaratula2 = 'styleCaratula2';
            $word->addParagraphStyle($styleCaratula2,array('align'=>'left','spacing' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.08)));

            $styleTitulo = 'styleTitulo';
            $word->addParagraphStyle($styleTitulo,array('align'=>'center','spacing' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.08)));

            $styleContenido = 'styleContenido';
            $word->addParagraphStyle($styleContenido,array('align'=>'left','spacing' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.08)));

            $tituloCaratula = 'tituloCaratula';
            $word->addFontStyle($tituloCaratula,array('name'=>'Arial','bold'=>true,'size'=>20,'position'=>'raised'));

            $subtitCaratula1 = 'subtitCaratual1';
            $word->addFontStyle($subtitCaratula1,array('name'=>'Arial','bold'=>true,'size'=>16,'align'=>'center'));
            $subtitCaratula2 = 'subtitCaratual2';
            $word->addFontStyle($subtitCaratula2,array('name'=>'Arial','bold'=>true,'size'=>14,'align'=>'center'));

            $titProyCaratula = 'titProyCaratula';
            $word->addFontStyle($titProyCaratula,array('name'=>'Arial','bold'=>true,'size'=>18,'align'=>'justify'));

            $styleImage = array('align'=>'center','width'=>280,'height'=>200);

            /* ------------------------------- */

            /* CARATULA */

            $caratulaSesion = $word->addSection();



            $caratulaSesion->addText("UNIVERSIDAD NACIONAL DE TRUJILLO",$tituloCaratula,$styleCaratula1);
            $caratulaSesion->addText("FACULTAD DE CIENCIAS ECONOMICAS",$subtitCaratula1,$styleCaratula1);
            $caratulaSesion->addText("ESCUELA PROFESIONAL DE CONTABILIDAD Y FINANZAS",$subtitCaratula2,$styleCaratula1);

            $caratulaSesion->addImage("img/logoUNTcaratula.png",$styleImage);

            $caratulaSesion->addText($titulo,$titProyCaratula,$styleCaratula1);
            $caratulaSesion->addTextBreak(1.5);

            $caratulaSesion->addText("TESIS",array('name'=>'Arial','bold'=>true,'size'=>16),$styleCaratula1);
            $caratulaSesion->addText("Para obtener el Titulo Profesional de:",array('name'=>'Arial','bold'=>true,'size'=>16),$styleCaratula1);

            $caratulaSesion->addText("Contabilidad y Finanzas",array('name'=>'Arial','bold'=>true,'size'=>18),$styleCaratula1);

            $caratulaSesion->addTextBreak(2);

            $caratulaSesion->addText($nombres,array('name'=>'Arial','bold'=>true,'size'=>16),$styleCaratula1);
            $caratulaSesion->addText("Bachiller en Ciencias Economicas",array('name'=>'Arial','bold'=>true,'size'=>16),$styleCaratula1);

            $caratulaSesion->addText("Asesor: ".$nombre_asesor,array('name'=>'Arial','bold'=>true,'size'=>16),$styleCaratula2);

            $caratulaSesion->addTextBreak(2);
            $caratulaSesion->addText("Trujillo - Peru",array('name'=>'Arial','bold'=>true,'size'=>16),$styleCaratula1);
            $caratulaSesion->addText("2022",array('name'=>'Arial','bold'=>true,'size'=>16),$styleCaratula1);

            /* ------------------------------------------ */
            if ($dedicatoria != null) {
                $SesionDedica = $word->addSection();

                $SesionDedica->addListItem("DEDICATORIA",0.5,$titulos,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
                $SesionDedica->addText($dedicatoria,null,$styleContenido);
            }

            if ($agradecimiento != null) {
                $SesionAgradece = $word->addSection();
                $SesionAgradece->addListItem("AGRADECIMIENTO",0.5,$titulos,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
                $SesionAgradece->addText($agradecimiento,null,$styleContenido);
            }

            $SesionPresenta = $word->addSection();
            $SesionPresenta->addListItem("PRESENTACION",0.5,$titulos,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
            $SesionPresenta->addText($presentacion,null,$styleContenido);

            $SesionResumen = $word->addSection();
            $SesionResumen->addListItem("RESUMEN",0.5,$titulos,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
            $SesionResumen->addText($resumen,null,$styleContenido);
            $SesionResumen->addText("Palabras clave: ".$lineKeywords,null,$styleContenido);

            // for ($i=0; $i < count($keywords); $i++) {
            //     if (!empty($keywords[$i+1])) {
            //         $SesionResumen->addText("Palabras clave: ".$keywords[$i]->keyword.', '.$keywords[$i+1]->keyword,null,$styleContenido);
            //     }
            // }

            $SesionIntroduccion = $word->addSection();
            $SesionIntroduccion->addListItem("INTRODUCCION",0.5,$titulos,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
            $SesionIntroduccion->addText($introduccion,null,$styleContenido);

            $nuevaSesion = $word->addSection();
            $nuevaSesion->addText("I. GENERALIDADES",$titulos);

            $nuevaSesion->addListItem("1. TITULO",0.5,$titulos,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
            $nuevaSesion->addText("'".$titulo."'",null,$styleTitulo);

            $nuevaSesion->addListItem("2. AUTOR",0.5,$titulos,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
            $nuevaSesion->addText($nombres,null,$styleContenido);

            $nuevaSesion->addListItem("3. ASESOR",0.5,$titulos,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
            $nuevaSesion->addText($nombre_asesor,null,$styleContenido);
            $nuevaSesion->addText($grado_asesor,null,$styleContenido);
            $nuevaSesion->addText($titulo_asesor,null,$styleContenido);
            $nuevaSesion->addText($direccion_asesor,null,$styleContenido);



            /* ------------------------------------------ */



            $nuevaSesion->addText("II. PLAN DE INVESTIGACION",$titulos,$styleContenido);

            $nuevaSesion->addListItem("1. REALIDAD PROBLEMATICA",0.5,$titulos,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
            $nuevaSesion->addText($real_problematica,null,$styleContenido);

            $nuevaSesion->addListItem("2. ANTECEDENTES",0.5,$titulos,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
            $nuevaSesion->addText($antecedentes,null,$styleContenido);

            $nuevaSesion->addListItem("3. JUSTIFICACION",0.5,$titulos,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
            $nuevaSesion->addText($justificacion,null,$styleContenido);

            $nuevaSesion->addListItem("4. FORMULACION DEL PROBLEMA",0.5,$titulos,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
            $nuevaSesion->addText($formulacion_prob,null,$styleContenido);

            /* Objetivos */
            $objetivos = TObjetivo::where('cod_tesis','=',$tesis[0]->cod_tesis)->latest('cod_objetivo')->get();

            $nuevaSesion->addListItem("5. OBJETIVOS",0.5,$titulos,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
            if($objetivos->count()!=0){
                $arregloObjetivo = [];

                $arregloObjTipo = [];
                foreach ($objetivos as $obj) {
                    $arregloObjTipo[] = $obj->tipo;
                    $arregloObjetivo[] = $obj->descripcion;
                }

                $cont4 = 0;
                $cont5 = 0;
                for ($i=count($objetivos)-1; $i >=0 ; $i--) {
                    if ($arregloObjTipo[$i] == 'General') {
                        if ($cont4 == 0) {
                            $nuevaSesion->addListItem("5.1. General: ",1,null,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
                        }
                        $nuevaSesion->addListItem("5.1.".($cont4+1).". ".$arregloObjetivo[$i],2,null,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
                        $cont4++;
                    }
                    if ($arregloObjTipo[$i] == 'Especifico') {
                        if ($cont5 == 0) {
                            $nuevaSesion->addListItem("5.2. Especifico: ",1,null,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
                        }
                        $nuevaSesion->addListItem("5.2.".($cont5+1).". ".$arregloObjetivo[$i],2,null,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
                        $cont5++;
                    }
                }
            }

            /* ------------------------ */
            $nuevaSesion->addListItem("6. MARCO TEORICO",0.5,$titulos,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
            $nuevaSesion->addText($marco_teorico,null,$styleContenido);

            $nuevaSesion->addListItem("7. MARCO CONCEPTUAL",0.5,$titulos,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
            $nuevaSesion->addText($marco_conceptual,null,$styleContenido);

            $nuevaSesion->addListItem("8. MARCO LEGAL",0.5,$titulos,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
            $nuevaSesion->addText($marco_legal,null,$styleContenido);

            $nuevaSesion->addListItem("9. FORMULACION DE LA HIPOTESIS",0.5,$titulos,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
            $nuevaSesion->addText($form_hipotesis,null,$styleContenido);

            $nuevaSesion->addListItem("10. DISENO DE INVESTIGACION",0.5,$titulos,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
            $nuevaSesion->addListItem("10.1. OBJETO DE ESTUDIO",1,$titulos,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
            $nuevaSesion->addText($objeto_estudio,null,$styleContenido);
            $nuevaSesion->addListItem("10.2. POBLACION",1,$titulos,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
            $nuevaSesion->addText($poblacion,null,$styleContenido);
            $nuevaSesion->addListItem("10.3. MUESTRA",1,$titulos,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
            $nuevaSesion->addText($muestra,null,$styleContenido);
            $nuevaSesion->addListItem("10.4. METODOS",1,$titulos,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
            $nuevaSesion->addText($metodos,null,$styleContenido);
            $nuevaSesion->addListItem("10.5. TECNICAS E INTRUMENTOS DE RECOLECCION DE DATOS",1,$titulos,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
            $nuevaSesion->addText($tecnicas_instrum,null,$styleContenido);


            $nuevaSesion->addListItem("10.6. INSTRUMENTACION",1,$titulos,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
            $nuevaSesion->addText($instrumentacion,null,$styleContenido);

            $nuevaSesion->addListItem("10.7. ESTRATEGIAS METODOLOGICAS",1,$titulos,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
            $nuevaSesion->addText($estg_metodologicas,null,$styleContenido);


            /* ---------------------------- */

            // Resultados

            $img_resultado = DB::table('detalle_archivos as DA')->join('archivos_proy_tesis as AP','DA.cod_archivos','=','AP.cod_archivos')
                                                ->where('AP.cod_tesis','=',$tesis[0]->cod_tesis)->where('DA.tipo','=','resultados')->get();
            // dd($img_resultado);
            $nuevaSesion->addListItem("11. RESULTADOS",0.5,$titulos,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);

            $texto = explode('%&%',$resultados);

            if (count($texto) != 0) {
                for ($i=0; $i < count($texto); $i++) {
                    $nuevaSesion->addText($texto[$i],null,$styleContenido);
                    if (count($img_resultado)!=0) {
                        for ($j=0; $j < count($img_resultado); $j++) {
                            if ($img_resultado[$j]->grupo==$i) {
                                $nuevaSesion->addImage("cursoTesis-2022/img/".$tesis[0]->cod_matricula."-Tesis/resultados/".$img_resultado[$j]->ruta,$styleImage);
                            }
                        }
                    }

                }
            }

            // Discusion

            $nuevaSesion->addListItem("12. DISCUSION",0.5,$titulos,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
            $nuevaSesion->addText($discusion,null,$styleContenido);

            // Conclusiones

            $nuevaSesion->addListItem("13. CONCLUSIONES",0.5,$titulos,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
            $nuevaSesion->addText($conclusiones,null,$styleContenido);

            // Recomendaciones

            $nuevaSesion->addListItem("14. RECOMENDACIONES",0.5,$titulos,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
            $nuevaSesion->addText($recomendaciones,null,$styleContenido);

            /* Regerencias Bibliograficas */

            $referencia = TReferencias::where('cod_tesis','=',$tesis[0]->cod_tesis)->latest('cod_referencias')->get();

            $arregloRefTipo = [];
            $arregloRefA = [];
            $arregloRefP = [];
            $arregloRefT = [];
            $arregloRefF = [];

            $arregloEd = [];
            $arregloTCap = [];
            $arregloNC = [];
            $arregloTRev = [];
            $arregloV = [];
            $arregloNWeb = [];
            $arregloNPe = [];
            $arregloNIn = [];
            $arregloS = [];
            $arregloNEd = [];
            if($referencia->count()!=0){

                foreach ($referencia as $ref) {
                    $arregloRefTipo[] = $ref->cod_tiporeferencia;
                    $arregloRefA[] = $ref->autor;
                    $arregloRefP[] = $ref->fPublicacion;
                    $arregloRefT[] = $ref->titulo;
                    $arregloRefF[] = $ref->fuente;
                    $arregloEd[] =  $ref->editorial;
                    $arregloTCap[] = $ref->title_cap;
                    $arregloNC[] = $ref->num_capitulo;
                    $arregloTRev[] = $ref->title_revista;
                    $arregloV[] = $ref->volumen;
                    $arregloNWeb[] = $ref->name_web;
                    $arregloNPe[] = $ref->name_periodista;
                    $arregloNIn[] = $ref->name_institucion;
                    $arregloS[] = $ref->subtitle;
                    $arregloNEd[] = $ref->name_editor;
                }


                $nuevaSesion->addListItem("15. REFERENCIAS BIBLOIGRAFICAS",0.5,$titulos,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);

                for ($i=0; $i <= count($referencia) - 1; $i++) {
                    if ($arregloRefTipo[$i] == 1) {
                        $nuevaSesion->addText($arregloRefA[$i]."."."(".$arregloRefP[$i].").".$arregloTCap[$i].".".$arregloRefF[$i].",".$arregloRefT[$i]." (capitulo ".$arregloNC[$i].")".$arregloEd[$i].".",null,$styleContenido);
                    }
                    if ($arregloRefTipo[$i] == 2) {
                        $nuevaSesion->addText($arregloRefA[$i]."."."(".$arregloRefP[$i].").".$arregloRefT[$i].".".$arregloRefF[$i].".".$arregloTRev[$i].",pp ".$arregloV[$i].".",null,$styleContenido);
                    }
                    if ($arregloRefTipo[$i] == 3) {
                        $nuevaSesion->addText($arregloRefA[$i]."."."(".$arregloRefP[$i].").".$arregloRefT[$i].".".$arregloRefF[$i].".".$arregloNWeb[$i].".",null,$styleContenido);
                    }
                    if ($arregloRefTipo[$i] == 4) {
                        $nuevaSesion->addText($arregloRefA[$i]."."."(".$arregloRefP[$i].").".$arregloRefT[$i].".".$arregloRefF[$i].".".$arregloNPe[$i].".",null,$styleContenido);
                    }
                    if ($arregloRefTipo[$i] == 5) {
                        $nuevaSesion->addText($arregloRefA[$i]."."."(".$arregloRefP[$i].").".$arregloRefT[$i].".".$arregloRefF[$i].".".$arregloNIn[$i].".",null,$styleContenido);
                    }
                    if ($arregloRefTipo[$i] == 6) {
                        $nuevaSesion->addText($arregloRefA[$i]."."."(".$arregloRefP[$i].").".$arregloRefT[$i].": ".$arregloRefF[$i].",".$arregloS[$i].", ".$arregloNEd[$i].".",null,$styleContenido);
                    }
                }
            }

            // Anexos

            $img_anexos = DB::table('detalle_archivos as DA')->join('archivos_proy_tesis as AP','DA.cod_archivos','=','AP.cod_archivos')
                                                ->where('AP.cod_tesis','=',$tesis[0]->cod_tesis)->where('DA.tipo','=','anexos')->get();
            // dd($img_resultado);
            $nuevaSesion->addListItem("16. ANEXOS",0.5,$titulos,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);

            $textoAnexo = explode('%&%',$anexos);

            if (count($textoAnexo) != 0) {
                for ($i=0; $i < count($textoAnexo); $i++) {
                    $nuevaSesion->addText($textoAnexo[$i],null,$styleContenido);
                    if (count($img_anexos)!=0) {
                        for ($j=0; $j < count($img_anexos); $j++) {
                            if ($img_anexos[$j]->grupo==$i) {
                                $nuevaSesion->addImage("cursoTesis-2022/img/".$tesis[0]->cod_matricula."-Tesis/anexos/".$img_anexos[$j]->ruta,$styleImage);
                            }
                        }
                    }

                }
            }

            /* ------------------------------------------------------- */

            $objetoEscrito = \PhpOffice\PhpWord\IOFactory::createWriter($word,'Word2007');
            try {
                $objetoEscrito->save(storage_path('Tesis.docx'));
            } catch (\Throwable $th) {
                $th;
            }

            return response()->download(storage_path('Tesis.docx'));
    }

    public function descargaObservacion(Request $request){

        /* CODIGO PARA GENERAR EL WORD DE LAS CORRECCIONES */
        $correccion = TObservacion::where('id_observacion','=',$request->cod_observaciones)->get();
        $tesis = Tesis_2022::join('t_historial_observaciones','tesis_2022.cod_tesis','=','t_historial_observaciones.cod_Tesis')
                                ->join('estudiante_ct2022','tesis_2022.cod_matricula','=','estudiante_ct2022.cod_matricula')
                                ->join('asesor_curso','tesis_2022.cod_docente','=','asesor_curso.cod_docente')
                                ->select('tesis_2022.*','asesor_curso.nombres','estudiante_ct2022.nombres as nombresAutor','estudiante_ct2022.apellidos as apellidosAutor','t_historial_observaciones.*')
                                ->where('t_historial_observaciones.cod_historial_observacion',$correccion[0]->cod_historial_observacion)->first();

        $objetivosTesis = TObjetivo::where('cod_tesis','=',$tesis->cod_tesis)->get();



        //dd('here');
        if (sizeof($correccion)==1) {
            $cantObserva = 0;
        }elseif(sizeof($correccion)==2){
            $cantObserva = 1;
        }else{
            $cantObserva = 2;
        }

        $cod_matricula = $tesis->cod_matricula;
        $nombreEgresado = $tesis->nombresAutor.' '.$tesis->apellidosAutor;
        $escuelaEgresado = "Contabilidad y Finanzas";
        $nombreAsesor = $tesis->nombres;
        $numObservacion = $correccion[$cantObserva]->observacionNum;
        $fecha = $correccion[$cantObserva]->fecha_create;
        $titulo = $correccion[$cantObserva]->titulo;

        $presentacion = $correccion[$cantObserva]->presentacion;
        $resumen = $correccion[$cantObserva]->resumen;
        $introduccion = $correccion[$cantObserva]->introduccion;

        $real_problematica = $correccion[$cantObserva]->real_problematica;
        $antecedentes = $correccion[$cantObserva]->antecedentes;
        $justificacion = $correccion[$cantObserva]->justificacion;
        $formulacion_prob = $correccion[$cantObserva]->formulacion_prob;

        $objetivos = $correccion[$cantObserva]->objetivos;

        $marco_teorico = $correccion[$cantObserva]->marco_teorico;
        $marco_conceptual = $correccion[$cantObserva]->marco_conceptual;
        $marco_legal = $correccion[$cantObserva]->marco_legal;


        $form_hipotesis = $correccion[$cantObserva]->form_hipotesis;
        $objeto_estudio = $correccion[$cantObserva]->objeto_estudio;
        $poblacion = $correccion[$cantObserva]->poblacion;
        $muestra = $correccion[$cantObserva]->muestra;
        $metodos = $correccion[$cantObserva]->metodos;
        $tecnicas_instrum = $correccion[$cantObserva]->tecnicas_instrum;
        $instrumentacion = $correccion[$cantObserva]->instrumentacion;

        $estg_metodologicas = $correccion[$cantObserva]->estg_metodologicas;

        $resultados = $correccion[$cantObserva]->resultados;
        $discusion = $correccion[$cantObserva]->discusion;
        $conclusiones = $correccion[$cantObserva]->conclusiones;
        $recomendaciones = $correccion[$cantObserva]->recomendaciones;

        $referencias = $correccion[$cantObserva]->referencias;

        $word = new PhpWord();

        /* Creacion de las fuentes */

        $word->setDefaultFontName('Times New Roman');
        $word->setDefaultFontSize(11);

        $titulos = 'titulos';
        $word->addFontStyle($titulos,array('bold'=>true,'size'=>12));

        $styleFecha = 'styleFecha';
        $word->addParagraphStyle($styleFecha,array('align'=>'right'));

        $styleTitulos = 'styleTitulos';
        $word->addParagraphStyle($styleTitulos,array('align'=>'center'));


        $nuevaSesion = $word->addSection();

        $nuevaSesion->addText($fecha,$titulo,$styleFecha);
        $nuevaSesion->addText('OBSERVACIONES PROYECTO DE TESIS',$titulos,$styleTitulos);
        $nuevaSesion->addText($numObservacion,$titulo,$styleTitulos);

        $nuevaSesion->addText('Codigo Egresado: '.$cod_matricula,$titulos,$styleFecha);
        $nuevaSesion->addText('Egresado: '.$nombreEgresado,$titulos,$styleFecha);
        $nuevaSesion->addText('Escuela: '.$escuelaEgresado,$titulos,$styleFecha);
        $nuevaSesion->addText('Asesor: '.$nombreAsesor,$titulos,$styleFecha);

        $nuevaSesion->addTextBreak(2);

        if ($titulo != "") {

            $nuevaSesion->addText("TITULO",$titulos);
            $nuevaSesion->addText($tesis->titulo);
            $nuevaSesion->addText("Observacion: ".$titulo);
        }

        if ($presentacion != "") {

            $nuevaSesion->addText("PRESENTACION",$titulos);
            $nuevaSesion->addText($tesis->presentacion);
            $nuevaSesion->addText("Observacion: ".$presentacion);
        }

        if ($resumen != "") {

            $nuevaSesion->addText("RESUMEN",$titulos);
            $nuevaSesion->addText($tesis->resumen);
            $nuevaSesion->addText("Observacion: ".$resumen);
        }

        if ($introduccion != "") {

            $nuevaSesion->addText("INTRODUCCION",$titulos);
            $nuevaSesion->addText($tesis->introduccion);
            $nuevaSesion->addText("Observacion: ".$introduccion);
        }

        if ($real_problematica!= "") {
            $nuevaSesion->addText("REALIDAD PROBLEMATICA",$titulos);
            $nuevaSesion->addText($tesis->real_problematica);
            $nuevaSesion->addText("Observacion: ".$real_problematica);
        }
        if ($antecedentes!= "") {
            $nuevaSesion->addText("ANTECEDENTES",$titulos);
            $nuevaSesion->addText($tesis->antecedentes);
            $nuevaSesion->addText("Observacion: ".$antecedentes);
        }
        if ($justificacion!= "") {
            $nuevaSesion->addText("JUSTIFICACION",$titulos);
            $nuevaSesion->addText($tesis->justificacion);
            $nuevaSesion->addText("Observacion: ".$justificacion);
        }
        if ($formulacion_prob!= "") {
            $nuevaSesion->addText("FORMULACION DEL PROBLEMA",$titulos);
            $nuevaSesion->addText($tesis->formulacion_prob);
            $nuevaSesion->addText("Observacion: ".$formulacion_prob);
        }
        if ($objetivos != "") {
            $nuevaSesion->addText("OBJETIVOS",$titulos);
            for ($i=0; $i < count($objetivosTesis); $i++) {
                $nuevaSesion->addText("Tipo: ".$objetivosTesis[$i]->tipo.", Descripcion: ".$objetivosTesis[$i]->descripcion);
            }

            $nuevaSesion->addText("Observacion: ".$objetivos);
        }
        if ($marco_teorico!= "") {
            $nuevaSesion->addText("MARCO TEORICO",$titulos);
            $nuevaSesion->addText($tesis->marco_teorico);
            $nuevaSesion->addText("Observacion: ".$marco_teorico);
        }
        if ($marco_conceptual!= "") {
            $nuevaSesion->addText("MARCO CONCEPTUAL",$titulos);
            $nuevaSesion->addText($tesis->marco_conceptual);
            $nuevaSesion->addText("Observacion: ".$marco_conceptual);
        }
        if ($marco_legal!= "") {
            $nuevaSesion->addText("MARCO LEGAL",$titulos);
            $nuevaSesion->addText($tesis->marco_legal);
            $nuevaSesion->addText("Observacion: ".$marco_legal);
        }
        if ($form_hipotesis!= "") {
            $nuevaSesion->addText("FORMULACION DE LA HIPOTESIS",$titulos);
            $nuevaSesion->addText($tesis->form_hipotesis);
            $nuevaSesion->addText("Observacion: ".$form_hipotesis);
        }
        if ($objeto_estudio!= "") {
            $nuevaSesion->addText("OBJETO DE ESTUDIO",$titulos);
            $nuevaSesion->addText($tesis->objeto_estudio);
            $nuevaSesion->addText("Observacion: ".$objeto_estudio);
        }
        if ($poblacion!= "") {
            $nuevaSesion->addText("POBLACION",$titulos);
            $nuevaSesion->addText($tesis->poblacion);
            $nuevaSesion->addText("Observacion: ".$poblacion);
        }
        if ($muestra!= "") {
            $nuevaSesion->addText("MUESTRA",$titulos);
            $nuevaSesion->addText($tesis->muestra);
            $nuevaSesion->addText("Observacion: ".$muestra);
        }
        if ($metodos!= "") {
            $nuevaSesion->addText("METODOS",$titulos);
            $nuevaSesion->addText($tesis->metodos);
            $nuevaSesion->addText("Observacion: ".$metodos);
        }
        if ($tecnicas_instrum!= "") {
            $nuevaSesion->addText("TECNICAS E INTRUMENTOS DE RECOLECCION DE DATOS",$titulos);
            $nuevaSesion->addText($tesis->tecnicas_instrum);
            $nuevaSesion->addText("Observacion: ".$tecnicas_instrum);
        }
        if ($instrumentacion!= "") {
            $nuevaSesion->addText("INSTRUMENTACION",$titulos);
            $nuevaSesion->addText($tesis->instrumentacion);
            $nuevaSesion->addText("Observacion: ".$instrumentacion);
        }
        if ($estg_metodologicas != "") {
            $nuevaSesion->addText("ESTRATEGIAS METODOLOGICAS",$titulos);
            $nuevaSesion->addText($tesis->estg_metodologicas);
            $nuevaSesion->addText("Observacion: ".$estg_metodologicas);
        }

        if ($resultados != "") {
            $nuevaSesion->addText("RESULTADOS",$titulos);

            $nuevaSesion->addText("Observacion: ".$resultados);
        }

        if ($discusion != "") {
            $nuevaSesion->addText("DISCUSION",$titulos);

            $nuevaSesion->addText("Observacion: ".$discusion);
        }

        if ($conclusiones != "") {
            $nuevaSesion->addText("CONCLUSIONES",$titulos);

            $nuevaSesion->addText("Observacion: ".$conclusiones);
        }

        if ($recomendaciones != "") {
            $nuevaSesion->addText("RECOMENDACIONES",$titulos);

            $nuevaSesion->addText("Observacion: ".$recomendaciones);
        }

        if ($referencias != "") {
            $nuevaSesion->addText("REFERENCIAS",$titulos);

            $nuevaSesion->addText("Observacion: ".$referencias);
        }


        $objetoEscrito = \PhpOffice\PhpWord\IOFactory::createWriter($word,'Word2007');
        try {
            $objetoEscrito->save(storage_path('ObservacionesTesis.docx'));
        } catch (\Throwable $th) {
            $th;
        }

        return response()->download(storage_path('ObservacionesTesis.docx'));
    }

    public function aprobarTesis(Request $request){

        $tesis = Tesis_2022::find($request->textcod);

        $tesis->condicion = 'APROBADO';
        $tesis->estado = 3;

        $tesis->save();
        return redirect()->route('asesor.ver-obs-estudiante-tesis',$tesis->cod_tesis)->with('datos','okAprobado');
    }
    public function desaprobarTesis(Request $request){
        $tesis = Tesis_2022::find($request->textcod);

        $tesis->condicion = 'DESAPROBADO';
        $tesis->estado = 4;
        $tesis->save();
        return redirect()->route('asesor.ver-obs-estudiante-tesis',$tesis->cod_tesis)->with('datos','okDesaprobado');
    }

}
