<?php

namespace App\Http\Controllers;

use App\Models\Asesor;
use App\Models\Detalle_Observaciones;
use App\Models\Egresado;
use App\Models\Escuela;
use App\Models\FormatoTitulo;
use App\Models\Historial_Observaciones;
use App\Models\Objetivo;
use App\Models\ObservacionesProy;
use App\Models\Presupuesto;
use App\Models\Presupuesto_Proyecto;
use App\Models\recursos;
use App\Models\referencias;
use App\Models\Tesis;
use App\Models\TipoInvestigacion;
use App\Models\TipoReferencia;
use App\Models\Usuario;
use App\Models\variableOP;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use League\CommonMark\Node\Block\Paragraph;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\ListItem;

class TesisController extends Controller
{

    public function dashboard($id){

        $usuario = Usuario::find($id);
        return view('plantilla.dashboard',['id'=>$id]);
    }

    public function index(){

        $id = auth()->user()->name;
        //Encontramos al autor
        $autor = Egresado::find($id);


        //Encontramos el formato
        $formato = FormatoTitulo::join('tipoinvestigacion','tipoinvestigacion.cod_tinvestigacion','=','formato_titulo.cod_tinvestigacion')->join('escuela','escuela.cod_escuela','=','formato_titulo.cod_escuela')
        ->select('formato_titulo.*','escuela.nombre AS name_escuela','tipoinvestigacion.descripcion')->where('cod_matricula','=',$autor->cod_matricula)->get();

        if(sizeof($formato)==0) {
            $validar = true;
            $correciones = [];
            $tesis =[];
            return view('tesis.formTesis',['validar'=>$validar,'id'=>$id,'correciones'=>$correciones,'tesis'=>$tesis]);

        }else{
            $validar = false;

            //Encontramos la tesis
            $tesis = Tesis::where('cod_matricula','=',$autor->cod_matricula)->get();

            $asesor = Asesor::find($formato[0]->cod_docente);

            $presupuestos = Presupuesto::all();
            $tiporeferencia = TipoReferencia::all();

            //Verificaremos que se hayan dado las observaciones y las enviaremos
            $correciones = ObservacionesProy::join('historial_observaciones','observaciones_proy.cod_historialObs','=','historial_observaciones.cod_historialObs')->where('historial_observaciones.cod_proyinvestigacion','=',$tesis[0]->cod_proyinvestigacion)->where('observaciones_proy.estado','=',1)->get();

            $detalles = [];
            if(sizeof($correciones)>0){
                $detalles = Detalle_Observaciones::where('cod_observaciones',$correciones[sizeof($correciones)-1]->cod_observaciones)->get();
            }

            $presupuestoProy = Presupuesto_Proyecto::where('cod_proyinvestigacion','=',$tesis[0]->cod_proyinvestigacion)->get();

            $recursos = recursos::where('cod_proyinvestigacion','=',$tesis[0]->cod_proyinvestigacion)->get();

            $objetivos = Objetivo::where('cod_proyinvestigacion','=',$tesis[0]->cod_proyinvestigacion)->get();

            $variableop = variableOP::where('cod_proyinvestigacion','=',$tesis[0]->cod_proyinvestigacion)->get();

            $referencias = referencias::where('cod_proyinvestigacion','=',$tesis[0]->cod_proyinvestigacion)->get();

            return view('tesis.formTesis',['autor'=>$autor,
            'presupuestos'=>$presupuestos,'tiporeferencia'=>$tiporeferencia,'tesis'=>$tesis,'asesor'=>$asesor,
            'formato'=>$formato, 'correciones' => $correciones,'validar'=>$validar,'recursos'=>$recursos,'objetivos'=>$objetivos,'variableop'=>$variableop,
            'presupuestoProy'=>$presupuestoProy,'detalles'=>$detalles,'referencias'=>$referencias]);


        }


    }




    public function guardar(Request $request)
    {
        $tesis = Tesis::where('cod_matricula','=',$request->txtCodMatricula)->get();

        $observacionX = ObservacionesProy::join('historial_observaciones','observaciones_proy.cod_historialObs','=','historial_observaciones.cod_historialObs')->where('historial_observaciones.cod_proyinvestigacion','=',$tesis[0]->cod_proyinvestigacion)
                                            ->where('observaciones_proy.estado','=',1)->get();

        if(sizeof($observacionX)>0){
            $detalles = Detalle_Observaciones::where('cod_observaciones',$observacionX[0]->cod_observaciones)->get();
        }

        try {
            /*Si el egresado tiene una observacion pendiente, solo se guardaran los cambios solicitados*/
            if(sizeof($observacionX)>0){

                for($i=0; $i<sizeof($detalles);$i++){
                    $tema = $detalles[$i]->tema_referido;
                    $name_request='txt'.$tema;
                    $detalleEEG=Detalle_Observaciones::find($detalles[$i]->cod_detalleObs);
                    $detalleEEG->correccion=$request->$name_request;
                    $detalleEEG->save();
                }

                $historialX = Historial_Observaciones::where('cod_proyinvestigacion','=',$tesis[0]->cod_proyinvestigacion)->get();
                $historialX[0]->fecha = now();

                $historialX[0]->save();

                $tesis[0]->estado = 1;
                $observacionX[0]->estado = 2;
                $observacionX[0]->save();
            }

            /*Si elimina datos que ya existian en las tablas*/
            if($request->listOldlrec!=""){
                $deleteRecursos = explode(",",$request->listOldlrec);
                //dd($deleteRecursos);
                for($i = 0; $i<sizeof($deleteRecursos);$i++){
                    recursos::find($deleteRecursos[$i])->delete();
                }
            }
            if($request->listOldlvar!=""){
                $deleteVariables = explode(",",$request->listOldlvar);
                for($i = 0; $i<sizeof($deleteVariables);$i++){
                    variableOP::find($deleteVariables[$i])->delete();
                }
            }
            if($request->listOldlobj!=""){
                $deleteObjetivos = explode(",",$request->listOldlobj);
                for($i = 0; $i<sizeof($deleteObjetivos);$i++){
                    Objetivo::find($deleteObjetivos[$i])->delete();
                }
            }


            /*Datos del Autor*/
            $tesis[0]->cod_matricula = $request->txtCodMatricula;
            $tesis[0]->nombres =$request->txtNombreAutor." ".$request->txtApellidoAutor ;
            $tesis[0]->direccion = $request->txtDireccionAutor;
            $tesis[0]->escuela = $request->txtEscuelaAutor;

             /*Datos del Asesor*/
            $tesis[0]->nombre_asesor = $request->txtNombreAsesor;
            $tesis[0]->grado_asesor = $request->txtGrAcademicoAsesor;
            $tesis[0]->titulo_asesor = $request->txtTProfesional;
            $tesis[0]->direccion_asesor = $request->txtDireccionAsesor;

            /*Proyecto de Investigacion y/o Tesis*/
            $tesis[0]->titulo = $request->txttitulo;//x

            //Investigacion
            $tesis[0]->cod_tinvestigacion = $request->txtTipoInvestigacion;
            if($request->txtti_finpersigue!="" && $request->txtti_disinvestigacion!=""){
                $tesis[0]->ti_finpersigue = $request->txtti_finpersigue;
                $tesis[0]->ti_disinvestigacion = $request->txtti_disinvestigacion;
            }

            //Desarrollo del proyecto
            $tesis[0]->localidad = $request->txtlocalidad;
            $tesis[0]->institucion = $request->txtinstitucion;
            $tesis[0]->meses_ejecucion = $request->txtmeses_ejecucion;

            //Cronograma de trabajo
            $cronograma = $request->listMonths;
            $cronograma = explode("_",$cronograma);
            $last = $cronograma[0];
            for($i=0; $i< sizeof($cronograma); $i++ ){
                if($cronograma[$i]=="1a"){
                    $tesis[0]->t_ReparacionInstrum = $last."-".$cronograma[$i-1];
                    $last = $cronograma[$i+1];
                }else if($cronograma[$i]=="2a"){
                    $tesis[0]->t_RecoleccionDatos = $last."-".$cronograma[$i-1];
                    $last = $cronograma[$i+1];
                }else if($cronograma[$i]=="3a"){
                    $tesis[0]->t_AnalisisDatos = $last."-".$cronograma[$i-1];
                    $last = $cronograma[$i+1];
                }else if($cronograma[$i]=="4a"){
                    $tesis[0]->t_ElaboracionInfo = $last."-".$cronograma[$i-1];
                }
            }

            //Economico
            if($request->txtfinanciamiento!=""){
                $tesis[0]->financiamiento = $request->txtfinanciamiento;
            }

            /*Realidad problematica y others*/
            $tesis[0]->real_problematica = $request->txtreal_problematica;//x
            $tesis[0]->antecedentes = $request->txtantecedentes;
            $tesis[0]->justificacion = $request->txtjustificacion;//x
            $tesis[0]->formulacion_prob = $request->txtformulacion_prob;

            /*Hipotesis y disenio*/
            $tesis[0]->form_hipotesis = $request->txtform_hipotesis;

            /*Material, metodos y tecnicas*/
            $tesis[0]->objeto_estudio = $request->txtobjeto_estudio;
            $tesis[0]->poblacion = $request->txtpoblacion;
            $tesis[0]->muestra = $request->txtmuestra;
            $tesis[0]->metodos = $request->txtmetodos;
            $tesis[0]->tecnicas_instrum = $request->txttecnicas_instrum;

            /*Instrumentacion*/
            $tesis[0]->instrumentacion = $request->txtinstrumentacion;

            /*Estrateg. metodologicas*/
            $tesis[0]->estg_metodologicas = $request->txtestg_metodologicas;

            /*Marco teorico*/
            $tesis[0]->marco_teorico = $request->txtmarco_teorico;
            $tesis[0]->marco_conceptual = $request->txtmarco_conceptual;
            $tesis[0]->marco_legal = $request->txtmarco_legal;
            $tesis[0]->estado = 1;


            /* Recursos */
            $arregloTipo = [];
            $arreglosubTipo = [];
            $arregloDescipcion = [];

            $tipos = $request->idtipo;
            $subtipo = $request->idsubtipo;
            $descripcion = $request->iddescripcion;
            if(!empty($descripcion)){
                foreach ($tipos as $tipo) {
                    $arregloTipo[] = $tipo;
                }
                foreach ($subtipo as $stipo) {
                    $arreglosubTipo[] = $stipo;
                }
                foreach ($descripcion as $des) {
                    $arregloDescipcion[] = $des;
                }
                $cadena = "";
                for ($i=0; $i <= count($subtipo)-1 ; $i++) {
                    $recurso = new recursos();
                    $recurso->tipo = $arregloTipo[$i];
                    $recurso->subtipo = $arreglosubTipo[$i];
                    $recurso->descripcion = $arregloDescipcion[$i];
                    $cadena = $cadena.$arregloTipo[$i].", ".$arreglosubTipo[$i].", ".$arregloDescipcion[$i].". ";
                    $recurso->cod_proyinvestigacion = $tesis[0]->cod_proyinvestigacion;
                    $recurso->save();
                }
                if(sizeof($observacionX)>0){
                    for($i=0; $i<sizeof($detalles);$i++){
                        if($detalles[$i]->tema_referido == 'recursos'){
                            $detalleEEG=Detalle_Observaciones::find($detalles[$i]->cod_detalleObs);
                            $detalleEEG->correccion=$cadena;
                            $detalleEEG->save();
                        }

                    }
                }
            }

            /* Presupuesto */
            $preciosP = $request->precios;
            $preciosP = explode("_",$preciosP);

            $arregloPresupuesto = Presupuesto::all();
            $x=0;
            if(sizeof($observacionX)==0){
                if(sizeof($preciosP)>0){
                    foreach ($arregloPresupuesto as $presupuesto) {
                        $preProyect = new Presupuesto_Proyecto();
                        $preProyect->cod_presupuesto = $presupuesto->cod_presupuesto;
                        $preProyect->precio = floatval($preciosP[$x]);
                        $preProyect->cod_proyinvestigacion = $tesis[0]->cod_proyinvestigacion;
                        $preProyect->save();
                        $x +=1;
                    }

                }
            }

            /* Objetivos */
            $arregloTipoObj = [];
            $arreglodescripcionObj = [];

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
                    $objetivo = new Objetivo();
                    $objetivo->tipo = $arregloTipoObj[$i];
                    $objetivo->descripcion = $arreglodescripcionObj[$i];
                    $cadena = $arregloTipoObj[$i].", ".$arreglodescripcionObj[$i].". ";
                    $objetivo->cod_proyinvestigacion = $tesis[0]->cod_proyinvestigacion;
                    $objetivo->save();
                }
                if(sizeof($observacionX)>0){
                    for($i=0; $i<sizeof($detalles);$i++){
                        if($detalles[$i]->tema_referido == 'objetivos'){
                            $detalleEEG=Detalle_Observaciones::find($detalles[$i]->cod_detalleObs);
                            $detalleEEG->correccion=$cadena;
                            $detalleEEG->save();
                        }

                    }
                }
            }


            /* Variable Operacional */
            $arreglodescripcionVar = [];

            $descripcionVar = $request->iddescripcionVar;
            if(!empty($descripcionVar)){
                foreach ($descripcionVar as $dVar) {
                    $arreglodescripcionVar[] = $dVar;
                }
                $cadena ="";
                for ($i=0; $i <= count($descripcionVar)-1 ; $i++) {
                    $variable = new variableOP();
                    $variable->descripcion = $arreglodescripcionVar[$i];
                    $cadena = $cadena.$arreglodescripcionVar[$i].". ";
                    $variable->cod_proyinvestigacion = $tesis[0]->cod_proyinvestigacion;
                    $variable->save();
                }
                if(sizeof($observacionX)>0){
                    for($i=0; $i<sizeof($detalles);$i++){
                        if($detalles[$i]->tema_referido == 'variables'){
                            $detalleEEG=Detalle_Observaciones::find($detalles[$i]->cod_detalleObs);
                            $detalleEEG->correccion=$cadena;
                            $detalleEEG->save();
                        }

                    }
                }
            }




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

            if (empty($tipoRef)==1) {
                $arregloTipoRef[]="";
            } else {
                foreach($tipoRef as $tAPA)
                {
                    $arregloTipoRef[] = $tAPA;
                }
            }

            if (empty($autorApa)==1) {
                $arregloA[] = "";
            } else {
                foreach($autorApa as $aut)
                {
                    $arregloA[] = $aut;
                }
            }

            if (empty($fPublicacion)==1) {
                $arreglofP[] = "";
            } else {
                foreach($fPublicacion as $fecha)
                {
                    $arreglofP[] = $fecha;
                }
            }


            if (empty($tituloTrabajo)==1) {
                $arregloT[] = "";
            } else {
                foreach($tituloTrabajo as $tit)
                {
                    $arregloT[] = $tit;
                }
            }

            if (empty($fuente)==1) {
                $arregloF[] = "";
            } else {
                foreach($fuente as $fu)
                {
                    $arregloF[] = $fu;
                }
            }

            if (empty($editorial)==1) {
                $arregloE[]="";
            } else {
                foreach($editorial as $edit)
                {
                    $arregloE[] = $edit;
                }
            }

            if (empty($titCapitulo)==1) {
                $arregloTC[] = "";
            } else {
                foreach($titCapitulo as $titC)
                {
                    $arregloTC[] = $titC;
                }
            }


            if (empty($numCapitulos)==1) {
                $arregloNumC[] = "";
            } else {
                foreach($numCapitulos as $numC)
                {
                    $arregloNumC[] = $numC;
                }
            }



            if (empty($titRevista) == 1) {
                $arregloTR[] = "";
            }else{
                foreach($titRevista as $titR)
                {
                    $arregloTR[] = $titR;
                }
            }
            if (empty($volumenRevista) == 1) {
                $arregloVR[] = "";
            } else {
                    foreach($volumenRevista as $volR)
                {
                    $arregloVR[] = $volR;
                }
            }
            if (empty($nombreWeb) == 1) {
                $arregloVR[] = "";
            } else {
                foreach($nombreWeb as $nameW)
                {
                    $arregloNW[] = $nameW;
                }
            }
            if (empty($nombrePeriodista) == 1) {
                $arregloVR[] = "";
            } else {
                    foreach($nombrePeriodista as $nameP)
                {
                    $arregloNP[] = $nameP;
                }
            }
            if (empty($nombreInstitucion) == 1) {
                $arregloVR[] = "";
            } else {
                foreach($nombreInstitucion as $nameIns)
                {
                    $arregloNI[] = $nameIns;
                }
            }
            if (empty($subtitInfo) == 1) {
                $arregloVR[] = "";
            } else {
                    foreach($subtitInfo as $subtit)
                {
                    $arregloST[] = $subtit;
                }
            }
            if (empty($nombreEditorInfo) == 1) {
                $arregloVR[] = "";
            } else {
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
                    $referencias = new referencias();
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

                    $referencias->cod_proyinvestigacion = $tesis[0]->cod_proyinvestigacion;
                    $referencias->save();
                }
            }
            $tesis[0]->fecha = now();


            $tesis[0]->save();

            return redirect()->route('verRegistroHistorial')->with('datos','Proyecto de tesis registrado correctamente!');

            /* --------------------------------------------------------------- */


        } catch (\Throwable $th) {
            //throw $th;
            return $th;
        }


    }
    const PAGINATION=10;
    public function index_formato(Request $request){
        $buscarformato=$request->get('buscarformato');
        if($request->allFormats != 'true'){
            if(is_numeric($buscarformato)){
                $formatos = DB::connection('mysql')->table('formato_titulo')->join('egresado','formato_titulo.cod_matricula','=','egresado.cod_matricula')->join('escuela','formato_titulo.cod_escuela','=','escuela.cod_escuela')->join('tipoinvestigacion','formato_titulo.cod_tinvestigacion','=','tipoinvestigacion.cod_tinvestigacion')
                ->select('formato_titulo.cod_matricula','formato_titulo.estado','formato_titulo.fecha','egresado.apellidos','egresado.nombres','escuela.nombre','tipoinvestigacion.descripcion')->where('formato_titulo.cod_matricula','like','%'.$buscarformato.'%')->where('formato_titulo.estado','=',1)->paginate($this::PAGINATION);
            }else{
                $formatos = DB::connection('mysql')->table('formato_titulo')->join('egresado','egresado.cod_matricula','=','formato_titulo.cod_matricula')->join('escuela','escuela.cod_escuela','=','formato_titulo.cod_escuela')->join('tipoinvestigacion','tipoinvestigacion.cod_tinvestigacion','=','formato_titulo.cod_tinvestigacion')
                ->select('formato_titulo.cod_matricula','formato_titulo.estado','formato_titulo.fecha','egresado.apellidos','egresado.nombres','escuela.nombre','tipoinvestigacion.descripcion')->where('egresado.apellidos','like','%'.$buscarformato.'%')->where('formato_titulo.estado','=',1)->paginate($this::PAGINATION);
            }
        }else{
            $formatos = DB::connection('mysql')->table('formato_titulo')->join('egresado','formato_titulo.cod_matricula','=','egresado.cod_matricula')->join('escuela','formato_titulo.cod_escuela','=','escuela.cod_escuela')->join('tipoinvestigacion','formato_titulo.cod_tinvestigacion','=','tipoinvestigacion.cod_tinvestigacion')
                ->select('formato_titulo.cod_matricula','formato_titulo.estado','formato_titulo.fecha','egresado.apellidos','egresado.nombres','escuela.nombre','tipoinvestigacion.descripcion')->where('formato_titulo.cod_matricula','like','%'.$buscarformato.'%')->paginate($this::PAGINATION);
        }


        $rol = 'director';
        if(empty($formatos)){
            return view('director.listaformatos',['buscarformato'=>$buscarformato,'formatos'=>$formatos,'rol'=>$rol])->with('datos','No se encontro algun registro');;
        }else{
            return view('director.listaformatos',['buscarformato'=>$buscarformato,'formatos'=>$formatos,'rol'=>$rol]);
        }
        //return view('director.listaformatos',['buscarformato'=>$buscarformato,'formatos'=>$formatos,'rol'=>$rol]);
    }

    public function index_proyectos(Request $request){
        $buscarproyectos = $request->get('buscarproyectos');
        if ($request->allProyects != 'true') {
            if (is_numeric($buscarproyectos)) {
                $proyectos = DB::connection('mysql')->table('proyinvestigacion')->join('egresado','proyinvestigacion.cod_matricula','=','egresado.cod_matricula')
                                ->select('proyinvestigacion.cod_matricula','proyinvestigacion.fecha','egresado.apellidos','egresado.nombres','proyinvestigacion.escuela','proyinvestigacion.estado')->where('proyinvestigacion.cod_matricula','like','%'.$buscarproyectos.'%')->where('proyinvestigacion.estado','=',1)->paginate($this::PAGINATION);
            } else {
                $proyectos = DB::connection('mysql')->table('proyinvestigacion')->join('egresado','proyinvestigacion.cod_matricula','=','egresado.cod_matricula')
                                ->select('proyinvestigacion.cod_matricula','proyinvestigacion.fecha','egresado.apellidos','egresado.nombres','proyinvestigacion.escuela','proyinvestigacion.estado')->where('egresado.apellidos','like','%'.$buscarproyectos.'%')->where('proyinvestigacion.estado','=',1)->paginate($this::PAGINATION);
            }
        } else {
            $proyectos = DB::connection('mysql')->table('proyinvestigacion')->join('egresado','proyinvestigacion.cod_matricula','=','egresado.cod_matricula')
                                ->select('proyinvestigacion.cod_matricula','proyinvestigacion.fecha','egresado.apellidos','egresado.nombres','proyinvestigacion.escuela','proyinvestigacion.estado')->where('proyinvestigacion.estado','!=',0)->paginate($this::PAGINATION);
        }


        $rol = 'asesor';

        if(empty($proyectos)){
            return view('asesor.listaproyectos',['buscarproyectos'=>$buscarproyectos,'proyectos'=>$proyectos,'rol'=>$rol])->with('datos','No se encontro algun registro');
        }else{
            return view('asesor.listaproyectos',['buscarproyectos'=>$buscarproyectos,'proyectos'=>$proyectos,'rol'=>$rol]);
        }
    }

    public function showProyecto($id){

        $proyecto = DB::connection('mysql')->table('proyinvestigacion')->join('asesor','asesor.nombres','=','proyinvestigacion.nombre_asesor')->join('egresado','proyinvestigacion.cod_matricula','=','egresado.cod_matricula')->join('tipoinvestigacion','proyinvestigacion.cod_tinvestigacion','=','tipoinvestigacion.cod_tinvestigacion')
                       ->join('formato_titulo','proyinvestigacion.cod_matricula','=','formato_titulo.cod_matricula')
                       ->select('proyinvestigacion.*','asesor.cod_docente as cod_asesor','egresado.nombres as nombresAutor','egresado.apellidos as apellidosAutor','tipoinvestigacion.descripcion')
                       ->where('proyinvestigacion.cod_matricula','=',$id)->get();
        $id = $proyecto[0]->cod_matricula;

        $observaciones = ObservacionesProy::join('historial_observaciones','observaciones_proy.cod_historialObs','=','historial_observaciones.cod_historialObs')
                                    ->where('historial_observaciones.cod_proyinvestigacion','=',$proyecto[0]->cod_proyinvestigacion)->get();

        $recursos = recursos::where('cod_proyinvestigacion','=',$proyecto[0]->cod_proyinvestigacion)->get();

        $presupuesto = Presupuesto_Proyecto::join('presupuesto','presupuesto.cod_presupuesto','=','presupuesto_proyecto.cod_presupuesto')->select('presupuesto_proyecto.*','presupuesto.codeUniversal','presupuesto.denominacion')->where('presupuesto_proyecto.cod_proyinvestigacion','=',$proyecto[0]->cod_proyinvestigacion)->get();

        $objetivos = Objetivo::where('cod_proyinvestigacion','=',$proyecto[0]->cod_proyinvestigacion)->get();
        $variableop = variableOP::where('cod_proyinvestigacion','=',$proyecto[0]->cod_proyinvestigacion)->get();
        $referencias = referencias::where('cod_proyinvestigacion','=',$proyecto[0]->cod_proyinvestigacion)->get();
        $lastObservacion = ObservacionesProy::join('historial_observaciones','observaciones_proy.cod_historialObs','=','historial_observaciones.cod_historialObs')
                            ->where('historial_observaciones.cod_proyinvestigacion','=',$proyecto[0]->cod_proyinvestigacion)->where('observaciones_proy.estado','=',1)->get();
        return view('asesor.lookProyecto',['lastObservacion'=>$lastObservacion,'proyecto'=>$proyecto,'recursos'=>$recursos,'presupuesto'=>$presupuesto,'objetivos'=>$objetivos,'variableop'=>$variableop,'referencias'=>$referencias,'observaciones'=>$observaciones,'id'=>$id]);
    }
    public $arrayThemes = [];

    public function guardarObservaciones(Request $request){

        $tesis = Tesis::find($request->textcod);

        $existHistorial = Historial_Observaciones::where('cod_proyinvestigacion',$tesis->cod_proyinvestigacion)->get();
        if($existHistorial->count()==0){
            $historialObs = new Historial_Observaciones();
            $historialObs->cod_proyinvestigacion = $tesis->cod_proyinvestigacion;
            $historialObs->estado = 0;
            $historialObs->save();
        }
        $existHistorial = Historial_Observaciones::where('cod_proyinvestigacion',$tesis->cod_proyinvestigacion)->get();

        $cantidadObservaciones = ObservacionesProy::join('historial_observaciones','observaciones_proy.cod_historialObs','=','historial_observaciones.cod_historialObs')->select('observaciones_proy.*')->where('historial_observaciones.cod_proyinvestigacion','=',$request->textcod)->get();

        if (sizeof($cantidadObservaciones) == 0) {
            $num = '1era observacion';
        }elseif(sizeof($cantidadObservaciones) == 1){
            $num = '2da observacion';
        }else{
            $num = '3era observacion';
        }

        // $proyecto = DB::connection('mysql')->table('proyinvestigacion')->join('asesor','asesor.nombres','=','proyinvestigacion.nombre_asesor')->join('egresado','proyinvestigacion.cod_matricula','=','egresado.cod_matricula')->join('tipoinvestigacion','proyinvestigacion.cod_tinvestigacion','=','tipoinvestigacion.cod_tinvestigacion')
        //                ->join('formato_titulo','proyinvestigacion.cod_matricula','=','formato_titulo.cod_matricula')
        //                ->select('proyinvestigacion.*','asesor.cod_docente as cod_asesor','egresado.nombres as nombresAutor','egresado.apellidos as apellidosAutor','tipoinvestigacion.descripcion')
        //                ->where('proyinvestigacion.cod_matricula','=',$request->txtCodMatricula)->get();

        $observaciones = new ObservacionesProy();
        try {
            $observaciones->cod_historialObs = $existHistorial[0]->cod_historialObs;
            $observaciones->observacionNum = $num;
            $observaciones->fecha = now();

            if($request->tachkCorregir1!=""){
                $observaciones->titulo = $request->tachkCorregir1;
                $arrayThemes[]='titulo';
            }

            if($request->tachkCorregir2!=""){
                $observaciones->localidad_institucion = $request->tachkCorregir2;
                $arrayThemes[]='localidad_institucion';
            }
            if($request->tachkCorregir3!=""){
                $observaciones->meses_ejecucion = $request->tachkCorregir3;
                $arrayThemes[]='meses_ejecucion';
            }
            if($request->tachkCorregir4!=""){
                $observaciones->recursos = $request->tachkCorregir4;
                $arrayThemes[]='recursos';
            }
            if($request->tachkCorregir5!=""){
                $observaciones->real_problematica = $request->tachkCorregir5;
                $arrayThemes[]='real_problematica';
            }
            if($request->tachkCorregir6!=""){
                $observaciones->antecedentes = $request->tachkCorregir6;
                $arrayThemes[]='antecedentes';
            }
            if($request->tachkCorregir7!=""){
                $observaciones->justificacion = $request->tachkCorregir7;
                $arrayThemes[]='justificacion';
            }
            if($request->tachkCorregir8!=""){
                $observaciones->formulacion_prob = $request->tachkCorregir8;
                $arrayThemes[]='formulacion_prob';
            }
            if($request->tachkCorregir9!=""){
                $observaciones->objetivos = $request->tachkCorregir9;
                $arrayThemes[]='objetivos';
            }
            if($request->tachkCorregir10!=""){
                $observaciones->marco_teorico = $request->tachkCorregir10;
                $arrayThemes[]='marco_teorico';
            }
            if($request->tachkCorregir11!=""){
                $observaciones->marco_conceptual = $request->tachkCorregir11;
                $arrayThemes[]='marco_conceptual';
            }
            if($request->tachkCorregir12!=""){
                $observaciones->marco_legal = $request->tachkCorregir12;
                $arrayThemes[]='marco_legal';
            }
            if($request->tachkCorregir13!=""){
                $observaciones->form_hipotesis = $request->tachkCorregir13;
                $arrayThemes[]='form_hipotesis';
            }
            if($request->tachkCorregir14!=""){
                $observaciones->objeto_estudio = $request->tachkCorregir14;
                $arrayThemes[]='objeto_estudio';
            }
            if($request->tachkCorregir15!=""){
                $observaciones->poblacion = $request->tachkCorregir15;
                $arrayThemes[]='poblacion';
            }
            if($request->tachkCorregir16!=""){
                $observaciones->muestra = $request->tachkCorregir16;
                $arrayThemes[]='muestra';
            }
            if($request->tachkCorregir17!=""){
                $observaciones->metodos = $request->tachkCorregir17;
                $arrayThemes[]='metodos';
            }
            if($request->tachkCorregir18!=""){
                $observaciones->tecnicas_instrum = $request->tachkCorregir18;
                $arrayThemes[]='tecnicas_instrum';
            }
            if($request->tachkCorregir19!=""){
                $observaciones->instrumentacion = $request->tachkCorregir19;
                $arrayThemes[]='instrumentacion';
            }
            if($request->tachkCorregir20!=""){
                $observaciones->estg_metodologicas = $request->tachkCorregir20;
                $arrayThemes[]='estg_metodologicas';
            }
            if($request->tachkCorregir21!=""){
                $observaciones->variables = $request->tachkCorregir21;
                $arrayThemes[]='variables';
            }
            if($request->tachkCorregir22!=""){
                $observaciones->referencias = $request->tachkCorregir22;
                $arrayThemes[]='referencias';
            }


            //Si el estado es 1, es porque esta por ser corregido aun.
            $observaciones->estado = 1;
            $observaciones->save();

            /*Creamos el historial*/

            $obsRecently = ObservacionesProy::where('cod_historialObs',$existHistorial[0]->cod_historialObs)->orderByDesc('cod_observaciones')->get();

            for($i = 0; $i<sizeof($arrayThemes);$i++){
                $detalleObs = new Detalle_Observaciones();
                $detalleObs->cod_observaciones=$obsRecently[0]->cod_observaciones;
                $detalleObs->tema_referido = $arrayThemes[$i];
                $detalleObs->correccion = null;
                $detalleObs->save();

            }

            $existHistorial[0]->fecha = $obsRecently[0]->fecha;
            $existHistorial[0]->estado = 1;
            $existHistorial[0]->save();

            $tesis->estado = 2;

            $tesis->save();

            return redirect()->route('asesor.showObservaciones',$existHistorial[0]->cod_historialObs);
            //Cambiarx
        } catch (\Throwable $th) {
            $th;
        }



    }

    public function aprobarProy(Request $request){

        $proyecto = Tesis::find($request->textcod);

        $proyecto->condicion = 'APROBADO';
        $proyecto->estado = 3;

        $proyecto->save();
        return redirect()->route('asesor.proyectos')->with('datos','Proyecto APROBADO');
    }
    public function desaprobarProy(Request $request){
        $proyecto = Tesis::find($request->textcod);

        $proyecto->condicion = 'DESAPROBADO';
        $proyecto->estado = 4;
        $proyecto->save();
        return redirect()->route('asesor.proyectos')->with('datos','Proyecto DESAPROBADO');
    }

}
