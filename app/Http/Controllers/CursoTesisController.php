<?php

namespace App\Http\Controllers;
use App\Models\Detalle_Archivo;
use App\Models\AsesorCurso;
use App\Models\CamposEstudiante;
use App\Models\Detalle_Observaciones;
use App\Models\EstudianteCT2022;
use App\Models\TipoInvestigacion;
use App\Models\Historial_Observaciones;
use App\Models\Objetivo;
use App\Models\ObservacionesProy;
use App\Models\Presupuesto;
use App\Models\Presupuesto_Proyecto;
use App\Models\recursos;
use App\Models\referencias;
use App\Models\TesisCT2022;
use App\Models\TipoReferencia;
use App\Models\Archivo_Tesis_ct2022;
use App\Models\MatrizOperacional;
use App\Models\Tesis_2022;
use App\Models\User;
use App\Models\variableOP;
use App\Models\Fin_Persigue;
use App\Models\Diseno_Investigacion;
use Illuminate\Support\Facades\DB;
use League\CommonMark\Node\Block\Paragraph;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Settings;

use Illuminate\Http\Request;

class CursoTesisController extends Controller
{

    // Administrador
    const PAGINATION = 10;
    public function listarUsuario(){
        $usuarios = User::where('rol','!=','administrador')->paginate($this::PAGINATION);;
        return view('cursoTesis20221.administrador.listarUsuarios',['usuarios'=>$usuarios]);
    }

    public function editarUsuario(Request $request){
        $iduser = $request->auxiduser;
        $find_user = User::find($iduser);
        // dd($find_user);
        return view('cursoTesis20221.administrador.editarUsuario',['find_user'=>$find_user]);
    }

    public function saveEditarUsuario(Request $request){
        $iduser = $request->auxiduser;
        $find_user = User::find($iduser);
        try {
            $find_user->name = $request->txtusuario;
            $find_user->rol = $request->rol_user;
            $find_user->save();
            return redirect()->route('admin.listar')->with('datos','ok');
        } catch (\Throwable $th) {
            return redirect()->route('admin.listar')->with('datos','oknot');
        }

    }

    public function deleteUsuario(Request $request){
        $iduser = $request->auxiduser;

        try {

            $usuario = User::where('id',$iduser);
            $usuario->delete();

            return redirect()->route('admin.listar')->with('datos','okdelete');
        } catch (\Throwable $th) {
            return redirect()->route('admin.listar')->with('datos','oknotdelete');
        }
    }
    // -------------------------------------------------------------------

    public function index(){

        $id = auth()->user()->name;
        $aux = explode('-',$id);
        $id = $aux[0];

        $autor = DB::table('estudiante_ct2022')->leftJoin('proyecto_tesis as p','p.cod_matricula','=','estudiante_ct2022.cod_matricula')->select('estudiante_ct2022.*','p.cod_docente')->where('estudiante_ct2022.cod_matricula',$id)->first();   //Encontramos al autor

        $tesis = TesisCT2022::where('cod_matricula','=',$autor->cod_matricula)->get(); //Encontramos la tesis

        $asesor = DB::table('asesor_curso')->where('cod_docente',$tesis[0]->cod_docente)->first();  //Encontramos al asesor
        /* Traemos informacion de las tablas*/
        $tinvestigacion = TipoInvestigacion::all();
        $fin_persigue = Fin_Persigue::all();
        $diseno_investigacion = Diseno_Investigacion::all();
        $presupuestos = Presupuesto::all();
        $tiporeferencia = TipoReferencia::all();
        $referencias = referencias::where('cod_proyectotesis','=',$tesis[0]->cod_proyectotesis)->get(); //Por si existen referencias

        //Verificaremos que se hayan dado las observaciones y las enviaremos
        $correciones = ObservacionesProy::join('historial_observaciones','observaciones_proy.cod_historialObs','=','historial_observaciones.cod_historialObs')
                        ->select('observaciones_proy.*')->where('historial_observaciones.cod_proyectotesis',$tesis[0]->cod_proyectotesis)
                        ->where('observaciones_proy.estado',1)->get();
        $detalles = [];
        if(sizeof($correciones)>0){
            $detalles = Detalle_Observaciones::where('cod_observaciones',$correciones[0]->cod_observaciones)->get();
        }

        $presupuestoProy = Presupuesto_Proyecto::where('cod_proyectotesis','=',$tesis[0]->cod_proyectotesis)->get();

        $recursos = recursos::where('cod_proyectotesis','=',$tesis[0]->cod_proyectotesis)->get();

        $objetivos = Objetivo::where('cod_proyectotesis','=',$tesis[0]->cod_proyectotesis)->get();

        $variableop = variableOP::where('cod_proyectotesis','=',$tesis[0]->cod_proyectotesis)->get();

        $campos = CamposEstudiante::where('cod_proyectotesis',$tesis[0]->cod_proyectotesis)->get();

        $matriz = MatrizOperacional::where('cod_proyectotesis','=',$tesis[0]->cod_proyectotesis)->get();

        //Obtener los archivos e imagenes que tuviese guardado.
        $detalleHistorial = [];

        return view('cursoTesis20221.cursoTesis',['autor'=>$autor,
                'presupuestos'=>$presupuestos,'fin_persigue'=>$fin_persigue,'diseno_investigacion'=>$diseno_investigacion,'tiporeferencia'=>$tiporeferencia,'tesis'=>$tesis,'asesor'=>$asesor,
                'correciones' => $correciones,'recursos'=>$recursos,'objetivos'=>$objetivos,'variableop'=>$variableop,
                'presupuestoProy'=>$presupuestoProy,'detalles'=>$detalles,'tinvestigacion'=>$tinvestigacion,'campos'=>$campos,
                'referencias'=>$referencias, 'detalleHistorial'=>$detalleHistorial,'matriz'=>$matriz
            ]);
    }

    public function estadoProyecto(){
        $id = auth()->user()->name;
        $aux = explode('-',$id);
        $id = $aux[0];
        $estudiante = EstudianteCT2022::find($id);
        $hTesis = TesisCT2022::join('asesor_curso as ac','ac.cod_docente','=','proyecto_tesis.cod_docente')->select('ac.nombres as nombre_asesor','proyecto_tesis.*')->where('cod_matricula','=',$estudiante->cod_matricula)->get();
        return view('cursoTesis20221.estadoProyecto',['hTesis'=>$hTesis]);
    }

    public function historialCorrecciones(){
        return view('cursoTesis20221.historialCorrecciones');
    }

    public function saveTesis(Request $request){
        $id = auth()->user()->name;
        $aux = explode('-',$id);
        $id = $aux[0];
        $isSaved = $request->isSaved;
        $estudiante = EstudianteCT2022::find($id);
        $tesis = TesisCT2022::where('cod_matricula','=',$estudiante->cod_matricula)->first();

        $observacionX = ObservacionesProy::join('historial_observaciones','observaciones_proy.cod_historialObs','=','historial_observaciones.cod_historialObs')
                    ->select('observaciones_proy.*')->where('historial_observaciones.cod_proyectotesis',$tesis->cod_proyectotesis)
                    ->where('observaciones_proy.estado',1)->get();

        if(sizeof($observacionX)>0){
            $detalles = Detalle_Observaciones::where('cod_observaciones',$observacionX[0]->cod_observaciones)->get();
        }

        try {
            /*Si el egresado tiene una observacion pendiente, solo se guardaran los cambios solicitados*/
            if(sizeof($observacionX)>0){

                for($i=0; $i<sizeof($detalles);$i++){
                    $tema = $detalles[$i]->tema_referido;
                    if ($tema == "localidad_institucion") {
                        $name_request='txtlocalidad';
                    }else{
                        $name_request='txt'.$tema;
                    }
                    $detalleEEG=Detalle_Observaciones::find($detalles[$i]->cod_detalleObs);

                    $detalleEEG->correccion=$request->$name_request;
                    $detalleEEG->save();
                }

                $historialX = Historial_Observaciones::where('cod_proyectotesis','=',$tesis->cod_proyectotesis)->get();
                $historialX[0]->fecha = now();
                $historialX[0]->save();

                $observacionX[0]->estado = 2;
                $observacionX[0]->save();
            }

            /*Si elimina datos que ya existian en las tablas*/
            if($request->listOldlrec!=""){
                $deleteRecursos = explode(",",$request->listOldlrec);
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

            /*Proyecto de Investigacion y/o Tesis*/
            if($request->txttitulo!=""){$tesis->titulo = $request->txttitulo;}

            //Investigacion
            if($request->cboTipoInvestigacion!=""){
                if(strlen($request->cboTipoInvestigacion)<4){
                    $tesis->cod_tinvestigacion = str_repeat("0", 4 - strlen($request->cboTipoInvestigacion)).$request->cboTipoInvestigacion;
                }else{
                    $tesis->cod_tinvestigacion = $request->cboTipoInvestigacion;
                }
            }

            if($request->txtti_finpersigue!="" && $request->txtti_disinvestigacion!=""){
                $tesis->ti_finpersigue = $request->txtti_finpersigue;
                $tesis->ti_disinvestigacion = $request->txtti_disinvestigacion;
            }

            //Desarrollo del proyecto
            if($request->txtlocalidad!=""){$tesis->localidad = $request->txtlocalidad;}
            if($request->txtinstitucion!=""){$tesis->institucion = $request->txtinstitucion;}
            if($request->txtmeses_ejecucion!=""){$tesis->meses_ejecucion = $request->txtmeses_ejecucion;}

            //Cronograma de trabajo
            if($request->listMonths!=""){
                $cronograma = $request->listMonths;
                $cronograma = explode("_",$cronograma);
                $last = $cronograma[0];
                for($i=0; $i< sizeof($cronograma); $i++ ){
                    if($cronograma[$i]=="1a"){
                        $tesis->t_ReparacionInstrum = $last."-".$cronograma[$i-1];
                        $last = $cronograma[$i+1];
                    }else if($cronograma[$i]=="2a"){
                        $tesis->t_RecoleccionDatos = $last."-".$cronograma[$i-1];
                        $last = $cronograma[$i+1];
                    }else if($cronograma[$i]=="3a"){
                        $tesis->t_AnalisisDatos = $last."-".$cronograma[$i-1];
                        $last = $cronograma[$i+1];
                    }else if($cronograma[$i]=="4a"){
                        $tesis->t_ElaboracionInfo = $last."-".$cronograma[$i-1];
                    }
                }
            }

            //Economico
            if($request->txtfinanciamiento!=""){
                $tesis->financiamiento = $request->txtfinanciamiento;
            }

            //Guardar los grupos $request->gruposFotosRP
            // $historialArchivosT = Archivo_Tesis_ct2022::where('cod_proyectotesis','=',$tesis->cod_proyectotesis)->get();

            // if (sizeof($historialArchivosT)==0) {
            //     $historialArchivos = new Archivo_Tesis_ct2022();
            //     $historialArchivos->cod_proyectotesis = $tesis->cod_proyectotesis;
            //     $historialArchivos->save();
            // }

            // // COEMNTADO PARA PRESENTACION AL PROFESOR, LUEGO DESCOMENTAR.
            // $historialArchivosX = Archivo_Tesis_ct2022::where('cod_proyectotesis',$tesis->cod_proyectotesis)->get();

            // //Guardar archivos de Realidad Problematica
            // $unirtxtAreaRP = $this->getText_saveImg($request,$request->txtAreaRP,$estudiante->cod_matricula,
            //         $historialArchivosX[0]->cod_archivos, "Realidad-Problematica","imagenesRP",$request->gruposRP,$request->txtreal_problematica);

            // //Guardar archivos de Antecedentes
            // $unirtxtAreaANT = $this->getText_saveImg($request,$request->txtAreaANT,$estudiante->cod_matricula,
            //         $historialArchivosX[0]->cod_archivos, "Antecedentes","imagenesANT",$request->gruposANT,$request->txtantecedentes);

            // //Guardar archivos de Justificacion de la Investigacion
            // $unirtxtAreaJI = $this->getText_saveImg($request,$request->txtAreaJI,$estudiante->cod_matricula,
            //         $historialArchivosX[0]->cod_archivos, "Justificacion-I","imagenesJI",$request->gruposJI,$request->txtjustificacion);

            // //Guardar archivos de Formulacion del Problema
            // $unirtxtAreaFP = $this->getText_saveImg($request,$request->txtAreaFP,$estudiante->cod_matricula,
            //         $historialArchivosX[0]->cod_archivos, "Formulacion-P","imagenesFP",$request->gruposFP,$request->txtformulacion_prob);

            // cAMBIAR LOS TXT POR LOS UNIRTXT
            /*Realidad problematica y others*/
            if($request->txtreal_problematica!=""){$tesis->real_problematica = $request->txtreal_problematica;}
            if($request->txtantecedentes!=""){$tesis->antecedentes = $request->txtantecedentes;}
            if($request->txtjustificacion!=""){$tesis->justificacion = $request->txtjustificacion;}
            if($request->txtformulacion_prob!=""){$tesis->formulacion_prob = $request->txtformulacion_prob;}

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

            /*Marco teorico*/
            if($request->txtmarco_teorico!=""){$tesis->marco_teorico = $request->txtmarco_teorico;}
            if($request->txtmarco_conceptual!=""){$tesis->marco_conceptual = $request->txtmarco_conceptual;}
            if($request->txtmarco_legal!=""){$tesis->marco_legal = $request->txtmarco_legal;}
            if($isSaved == "true"){
                $tesis->estado = 9;
            }else{
                $tesis->estado = 1;
            }


            /* Recursos */
            $arregloTipo = [];
            $arreglosubTipo = [];
            $arregloDescipcion = [];
            if($request->idtipo!=""){
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

                    for ($i=0; $i < count($tipos) ; $i++) {
                        $recurso = new recursos();
                        $recurso->tipo = $arregloTipo[$i];
                        $recurso->subtipo = $arreglosubTipo[$i];
                        $recurso->descripcion = $arregloDescipcion[$i];

                        $cadena = $cadena.$arregloTipo[$i].", ".$arreglosubTipo[$i].", ".$arregloDescipcion[$i].". ";

                        $recurso->cod_proyectotesis = $tesis->cod_proyectotesis;

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
            }
            /* Presupuesto */
            if($request->precios!=""){
                $preciosP = $request->precios;
                $preciosP = explode("_",$preciosP);

                $arregloPresupuesto = Presupuesto::all();
                $existPresupuesto = Presupuesto_Proyecto::where('cod_proyectotesis',$tesis->cod_proyectotesis)->get();
                $x=0;
                if($existPresupuesto->count()==0){


                    foreach ($arregloPresupuesto as $presupuesto) {

                        $preProyect = new Presupuesto_Proyecto();
                        $preProyect->cod_presupuesto = $presupuesto->cod_presupuesto;
                        $preProyect->precio = floatval($preciosP[$x]);
                        $preProyect->cod_proyectotesis = $tesis->cod_proyectotesis;
                        $preProyect->save();

                        $x +=1;
                    }

                }else{
                    for($i=0; $i<sizeof($existPresupuesto);$i++){
                        $last_presupuesto=Presupuesto_Proyecto::find($existPresupuesto[$i]->cod_presProyecto);
                        $last_presupuesto->precio=$preciosP[$i];
                        $last_presupuesto->save();
                    }
                }
            }


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
                        $objetivo = new Objetivo();
                        $objetivo->tipo = $arregloTipoObj[$i];
                        $objetivo->descripcion = $arreglodescripcionObj[$i];
                        $cadena = $arregloTipoObj[$i].", ".$arreglodescripcionObj[$i].". ";
                        $objetivo->cod_proyectotesis = $tesis->cod_proyectotesis;
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
            }


            /* Variable Operacional */
            $arreglodescripcionVar = [];
            if($request->iddescripcionVar!=""){
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
                        $variable->cod_proyectotesis = $tesis->cod_proyectotesis;
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
                    $referencias->cod_proyectotesis = $tesis->cod_proyectotesis;
                    $referencias->save();

                }
            }

            // Guardar la matriz

            $col_matriz = MatrizOperacional::where('cod_proyectotesis','=',$tesis->cod_proyectotesis)->get();


            $col_matriz[0]->variable_I = $request->i_varI;
            $col_matriz[0]->def_conceptual_I = $request->i_dc;
            $col_matriz[0]->def_operacional_I = $request->i_do;
            $col_matriz[0]->dimensiones_I = $request->i_dim;
            $col_matriz[0]->indicadores_I = $request->i_ind;
            $col_matriz[0]->escala_I = $request->i_esc;

            $col_matriz[0]->variable_D = $request->d_varD;
            $col_matriz[0]->def_conceptual_D = $request->d_dc;
            $col_matriz[0]->def_operacional_D = $request->d_do;
            $col_matriz[0]->dimensiones_D = $request->d_dim;
            $col_matriz[0]->indicadores_D = $request->d_ind;
            $col_matriz[0]->escala_D = $request->d_esc;
            $col_matriz[0]->save();


            $tesis->fecha = now();
            $tesis->save();


        } catch (\Throwable $th) {
            return redirect()->route('curso.tesis20221')->with('datos','oknot');
        }



        return redirect()->route('curso.estado-proyecto')->with('datos','ok');
    }

    // Funcion para guardar el texto e imagenes
    private function getText_saveImg(Request $request,$textarea, $matricula,$cod_historial, $tipoArchivo, $name_img, $grupos_value,$txt_principal){
        //Guardar archivos
        $unirtxtArea = $txt_principal;
        $grupos = [];
        $posicion = 0;
        $numero_grupo = 0;

        if ($request->hasFile($name_img)) {

            $grupos = explode(",",$grupos_value);
            $archivos = $request->$name_img;
            $text_area = $textarea;

            for ($i=0; $i < sizeof($text_area); $i++) {
                $unirtxtArea = $unirtxtArea."-_-".$text_area[$i];
            }

            for ($i=0; $i < sizeof($archivos); $i++) {

                $table = new Detalle_Archivo();
                $file = $request->file($name_img);

                $destinationPath = 'cursoTesis-2022/img/'.$matricula.'-CursoTesis/'.$tipoArchivo.'/';
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath,0777,true);
                }

                $filename = ($i+1).'-'.$matricula.'.jpg';
                $uploadSuccess = $file[$i]->move($destinationPath,$filename);
                $table->cod_archivos = $cod_historial;
                $table->tipo = $tipoArchivo;
                $table->ruta = $filename;
                if((int)$grupos[$posicion] == 0 ){
                    $numero_grupo = $numero_grupo +1;
                    $posicion++;
                }
                $table->grupo = $numero_grupo;
                $gruposJI[$posicion]= $grupos[$posicion]-1;

                $table->save();
            }

        }else{
            $unirtxtArea = $textarea;
        }
        return $unirtxtArea;
    }


    /*FUNCION PARA DESCARGAR EL WORD DE LA TESIS*/
    public function descargaTesis(Request $request){

        $cod_cursoTesis = $request->cod_cursoTesis;

        $tesis = TesisCT2022::where('cod_proyectotesis',$cod_cursoTesis)->get();
        $estudiante = EstudianteCT2022::find($tesis[0]->cod_matricula);
        $asesor = AsesorCurso::find($tesis[0]->cod_docente);
            /*Datos del Autor*/
            $nombres =$estudiante->nombres.' '.$estudiante->apellidos;
            /* $tesis->grado_academico = $request->cboGrAcademicoAutor; */
            /*'cod_docente',
        'nombres',
        'grado_academico',
        'titulo_profesional',
        'direccion',*/
            /*Datos del Asesor*/
            $nombre_asesor = $asesor->nombres;
            $grado_asesor = $asesor->grado_academico;
            $titulo_asesor = $asesor->titulo_profesional;
            $direccion_asesor =$asesor->direccion;

            /*Proyecto de Investigacion y/o Tesis*/
            $titulo = $tesis[0]->titulo;

            //Investigacion
            $cod_tinvestigacion = TipoInvestigacion::find($tesis[0]->cod_tinvestigacion);
            if($cod_tinvestigacion!=null){
                $cod_tinvestigacion = $cod_tinvestigacion->descripcion;
            }

            $fin_persigue = Fin_Persigue::find($tesis[0]->ti_finpersigue);
            if($fin_persigue!=null){
                $ti_finpersigue =$fin_persigue->descripcion;
            }

            $diseno_investigacion = Diseno_Investigacion::find($tesis[0]->ti_disinvestigacion);
            if($diseno_investigacion!=null){
                $ti_disinvestigacion =$diseno_investigacion->descripcion;
            }

            //Desarrollo del proyecto
            $localidad = $tesis[0]->localidad;
            $institucion = $tesis[0]->institucion;
            $meses_ejecucion = $tesis[0]->meses_ejecucion;

            //Cronograma
            $reparacionInstrum = $tesis[0]->t_ReparacionInstrum;
            $reparacionInstrum = explode("-",$reparacionInstrum);

            //dd($reparacionInstrum);

            $recoleccionDatos = $tesis[0]->t_RecoleccionDatos;
            $recoleccionDatos = explode("-",$recoleccionDatos);

            $analisisDatos = $tesis[0]->t_AnalisisDatos;
            $analisisDatos = explode("-",$analisisDatos);

            $elaboracionInfo = $tesis[0]->t_ElaboracionInfo;
            $elaboracionInfo = explode("-",$elaboracionInfo);

            //Economico
            $financiamiento = $tesis[0]->financiamiento;


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
            $nuevaSesion = $word->addSection();


            $caratulaSesion->addText("UNIVERSIDAD NACIONAL DE TRUJILLO",$tituloCaratula,$styleCaratula1);
            $caratulaSesion->addText("FACULTAD DE CIENCIAS ECONOMICAS",$subtitCaratula1,$styleCaratula1);
            $caratulaSesion->addText("ESCUELA PROFESIONAL DE CONTABILIDAD Y FINANZAS",$subtitCaratula2,$styleCaratula1);

            $caratulaSesion->addImage("img/logoUNTcaratula.png",$styleImage);

            $caratulaSesion->addText($titulo,$titProyCaratula,$styleCaratula1);
            $caratulaSesion->addTextBreak(1.5);

            $caratulaSesion->addText("PROYECTO DE TESIS",array('name'=>'Arial','bold'=>true,'size'=>16),$styleCaratula1);
            $caratulaSesion->addText("Para obtener el Titulo Porfesional de:",array('name'=>'Arial','bold'=>true,'size'=>16),$styleCaratula1);

            $caratulaSesion->addText("Contabilidad y Finanzas",array('name'=>'Arial','bold'=>true,'size'=>18),$styleCaratula1);

            $caratulaSesion->addTextBreak(2);

            $caratulaSesion->addText($nombres,array('name'=>'Arial','bold'=>true,'size'=>16),$styleCaratula1);
            $caratulaSesion->addText("Bachiller en Ciencias Economicas",array('name'=>'Arial','bold'=>true,'size'=>16),$styleCaratula1);

            $caratulaSesion->addText("Asesor: ".$nombre_asesor,array('name'=>'Arial','bold'=>true,'size'=>16),$styleCaratula2);

            $caratulaSesion->addTextBreak(2);
            $caratulaSesion->addText("Trujillo - Peru",array('name'=>'Arial','bold'=>true,'size'=>16),$styleCaratula1);
            $caratulaSesion->addText("2022",array('name'=>'Arial','bold'=>true,'size'=>16),$styleCaratula1);

            /* ------------------------------------------ */





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

            $nuevaSesion->addListItem("4. TIPO DE INVESTIGACION",0.5,$titulos,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
            $nuevaSesion->addText($cod_tinvestigacion,null,$styleContenido);
            $nuevaSesion->addText("De acuerdo al fin que se persigue: ".$ti_finpersigue,null,$styleContenido);
            $nuevaSesion->addText("De acuerdo al diseño de investigacion: ".$ti_disinvestigacion,null,$styleContenido);

            $nuevaSesion->addListItem("5. LOCALIDAD E INSTITUCION DONDE SE DESARROLLO EL PROYECTO",0.5,$titulos,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
            $nuevaSesion->addText("Localidad: ".$localidad,null,$styleContenido);
            $nuevaSesion->addText("Institucion: ".$institucion,null,$styleContenido);

            $nuevaSesion->addListItem("6. DURECION DE LA EJECUCION DEL PROYECTO",0.5,$titulos,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
            $nuevaSesion->addText($meses_ejecucion." MESES",null,$styleContenido);

            /* Tabla del Cronograma de Trabajo */
            /* Estilo de la table */
            $tableStyle = array(
                'borderSize' => 6,
                'cellMargin' => 50,
                'alignMent' => 'center'
            );

            $nuevaSesion->addListItem("7. CRONOGRAMA DE TRABAJO",0.5,$titulos,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);

            $cronogramaTable = $nuevaSesion->addTable($tableStyle);

            $cronogramaTable->addRow(400);
            $cronogramaTable->addCell(3500)->addText('ACTIVIDAD',$titulos);
            $cronogramaTable->addCell(1500)->addText('MES INICIO',$titulos);
            $cronogramaTable->addCell(1500)->addText('MES TERMINO',$titulos);


            $cronogramaTable->addRow(400);
            $cronogramaTable->addCell(3500)->addText('Preparacion de instrumentos de recoleccion de datos',$titulos);
            for ($i=0; $i <= count($reparacionInstrum)-1 ; $i++) {
                $cronogramaTable->addCell(2000)->addText($reparacionInstrum[$i]);
            }


            $cronogramaTable->addRow(400);
            $cronogramaTable->addCell(3500)->addText('Recoleccion de datos',$titulos);
            for ($i=0; $i <= count($recoleccionDatos)-1 ; $i++) {
                $cronogramaTable->addCell(2000)->addText($recoleccionDatos[$i]);
            }

            $cronogramaTable->addRow(400);
            $cronogramaTable->addCell(3500)->addText('Analisis de Datos',$titulos);
            for ($i=0; $i <= count($analisisDatos)-1 ; $i++) {
                $cronogramaTable->addCell(2000)->addText($analisisDatos[$i]);
            }

            $cronogramaTable->addRow(400);
            $cronogramaTable->addCell(3500)->addText('Elaboracion del Informe',$titulos);
            for ($i=0; $i <= count($elaboracionInfo)-1 ; $i++) {
                $cronogramaTable->addCell(2000)->addText($elaboracionInfo[$i]);
            }


            /* ------------------------------------------ */

            /* Recursos */

            $recursos = recursos::where('cod_proyectotesis','=',$tesis[0]->cod_proyectotesis)->latest('cod_recurso')->get();

            $arregloRecursos = [];

            $nuevaSesion->addListItem("8. RECURSOS",0.5,$titulos,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);

            $arregloRecTipo = [];
            if($recursos->count()!=0){
                foreach ($recursos as $rec) {
                    $arregloRecTipo[] = $rec->tipo;
                    $arregloRecursos[] = $rec->descripcion;
                }

                $cont1 = 0;
                $cont2 = 0;
                $cont3 = 0;
                for ($i=count($recursos)-1; $i >=0 ; $i--) {
                    if ($arregloRecTipo[$i] == 'Personal') {
                        if ($cont1 == 0) {
                            $nuevaSesion->addListItem("8.1. Personal: ",1,null,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
                        }
                        $nuevaSesion->addListItem("8.1.".($cont1+1).". ".$arregloRecursos[$i],2,null,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
                        $cont1++;
                    }
                    if ($arregloRecTipo[$i] == 'Bienes') {
                        if ($cont2 == 0) {
                            $nuevaSesion->addListItem("8.2. Bienes: ",1,null,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
                        }
                        $nuevaSesion->addListItem("8.2.".($cont2+1).". ".$arregloRecursos[$i],2,null,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
                        $cont2++;
                    }
                    if ($arregloRecTipo[$i] == 'Servicios') {
                        if ($cont3 == 0) {
                            $nuevaSesion->addListItem("8.3. Servicios: ",1,null,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
                        }
                        $nuevaSesion->addListItem("8.3.".($cont3+1).". ".$arregloRecursos[$i],2,null,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
                        $cont3++;
                    }
                }
            }

            /* ---------------- */

            $nuevaSesion->addListItem("9. PRESUPUESTO",0.5,$titulos,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);

            /* Presupuesto */
            $presupues = DB::table('presupuesto_proyecto')->join('presupuesto','presupuesto_proyecto.cod_presupuesto','=','presupuesto.cod_presupuesto')
                                                            ->select('precio','presupuesto.codeUniversal','presupuesto.denominacion')
                                                            ->where('cod_proyectotesis','=',$tesis[0]->cod_proyectotesis)->latest('cod_presProyecto')->get();

            $presupuestoTable = $nuevaSesion->addTable($tableStyle);

            $presupuestoTable->addRow(400);
            $presupuestoTable->addCell(2000)->addText("CODIGO",$titulos);
            $presupuestoTable->addCell(4000)->addText("DENOMINACION",$titulos);
            $presupuestoTable->addCell(1500)->addText("PRECIO TOTAL (S/.)",$titulos);
            $totalP = 0;
            if($presupues->count()!=0){
                for ($i=count($presupues)-1; $i >= 0; $i--) {
                    $presupuestoTable->addRow(400);
                    $presupuestoTable->addCell(2000)->addText($presupues[$i]->codeUniversal,$titulos);
                    $presupuestoTable->addCell(4000)->addText($presupues[$i]->denominacion,$titulos);
                    $presupuestoTable->addCell(1500)->addText($presupues[$i]->precio.".00",$titulos);
                    $totalP += floatval($presupues[$i]->precio);
                }
            }

            $presupuestoTable->addRow(400);
            $presupuestoTable->addCell(2000)->addText("",$titulos);
            $presupuestoTable->addCell(4000)->addText("TOTAL",$titulos);
            $presupuestoTable->addCell(1500)->addText($totalP.".00",$titulos);//x


            /* ----------------------------------- */


            $nuevaSesion->addListItem("10. FINANCIAMIENTO",0.5,$titulos,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
            $nuevaSesion->addText($financiamiento);

            $nuevaSesion->addPageBreak();

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
            $objetivos = Objetivo::where('cod_proyectotesis','=',$tesis[0]->cod_proyectotesis)->latest('cod_objetivo')->get();

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

            /* Variables */
            $variables = variableOP::where('cod_proyectotesis','=',$tesis[0]->cod_proyectotesis)->latest('cod_variable')->get();
            $nuevaSesion->addListItem("10.8. OPERACIONALIZACION DE VARIABLES Y MATRIZ DE CONSISTENCIA",1,$titulos,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);

            if($variables->count()!=0){

                $arregloVariable = [];


                foreach ($variables as $var) {
                    $arregloVariable[] = $var->descripcion;
                }

                for ($i=0; $i <= count($variables)-1 ; $i++) {
                    $nuevaSesion->addListItem("10.8.".($i+1).". ".$arregloVariable[$i],2,null,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
                }
            }

            $footer = $nuevaSesion->addFooter();

            $footer->addPreserveText(1);

            /* ---------------------------- */

            /* Regerencias Bibliograficas */

            $referencia = referencias::where('cod_proyectotesis','=',$tesis[0]->cod_proyectotesis)->latest('cod_referencias')->get();

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

            $nuevaSesion->addListItem("11. REFERENCIAS BIBLIOGRAFICAS",0.5,$titulos,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);

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

            // Matriz Operacional

            $nuevaSesion->addText("MATRIZ DE OPERACIONALIZACION",null,$titulos);

            $matriz = DB::table('matriz_operacional')->select('matriz_operacional.*')->where('cod_proyectotesis','=',$tesis[0]->cod_proyectotesis)->get();

            $matrizTable = $nuevaSesion->addTable($tableStyle);
            $matrizTable->addRow();
            $matrizTable->addCell()->addText("VARIABLES",$titulos);
            $matrizTable->addCell()->addText("DEFINICION CONCEPTUAL",$titulos);
            $matrizTable->addCell()->addText("DEFINICION OPERACIONAL",$titulos);
            $matrizTable->addCell()->addText("DIMENSIONES",$titulos);
            $matrizTable->addCell()->addText("INDICADORES",$titulos);
            $matrizTable->addCell()->addText("Escala",$titulos);

            if($matriz->count()!=0){
                $matrizTable->addRow();
                $matrizTable->addCell()->addText($matriz[0]->variable_I);
                $matrizTable->addCell()->addText($matriz[0]->def_conceptual_I);
                $matrizTable->addCell()->addText($matriz[0]->def_operacional_I);
                $matrizTable->addCell()->addText($matriz[0]->dimensiones_I);
                $matrizTable->addCell()->addText($matriz[0]->indicadores_I);
                $matrizTable->addCell()->addText($matriz[0]->escala_I);

                $matrizTable->addRow();
                $matrizTable->addCell()->addText($matriz[0]->variable_D);
                $matrizTable->addCell()->addText($matriz[0]->def_conceptual_D);
                $matrizTable->addCell()->addText($matriz[0]->def_operacional_D);
                $matrizTable->addCell()->addText($matriz[0]->dimensiones_D);
                $matrizTable->addCell()->addText($matriz[0]->indicadores_D);
                $matrizTable->addCell()->addText($matriz[0]->escala_D);
            }


            /* ------------------------------------------------------- */

            $objetoEscrito = \PhpOffice\PhpWord\IOFactory::createWriter($word,'Word2007');
            try {
                $objetoEscrito->save(storage_path('ProyectoTesis.docx'));
            } catch (\Throwable $th) {
                $th;
            }

            return response()->download(storage_path('ProyectoTesis.docx'));
    }
    const PAGINATION3=10;
    public function showTablaAsignacion(Request $request){

        $buscarAlumno = $request->buscarAlumno;
        if($buscarAlumno!=""){
            if (is_numeric($buscarAlumno)) {

                $estudiantes = DB::table('estudiante_ct2022 as e')->leftJoin('proyecto_tesis as p','p.cod_matricula','=','e.cod_matricula')->select('e.*','p.cod_docente')->where('e.cod_matricula','like','%'.$buscarAlumno.'%')->paginate($this::PAGINATION3);
            } else {
                $estudiantes = DB::table('estudiante_ct2022 as e')->leftJoin('proyecto_tesis as p','p.cod_matricula','=','e.cod_matricula')->select('e.*','p.cod_docente')->where('e.apellidos','like','%'.$buscarAlumno.'%')->paginate($this::PAGINATION3);
            }
        }else{

            $estudiantes = DB::table('estudiante_ct2022 as e')->leftJoin('proyecto_tesis as p','p.cod_matricula','=','e.cod_matricula')->select('e.*','p.cod_docente')->paginate($this::PAGINATION3);
        }
        $asesores = DB::table('asesor_curso')->select('cod_docente','nombres')->get();
        return view('cursoTesis20221.director.asignarAsesor',['estudiantes'=>$estudiantes,'asesores'=>$asesores,'buscarAlumno'=>$buscarAlumno]);
    }

    public function showAlumnosAsignados(){

        $estudiantes = DB::table('estudiante_ct2022 as e')->leftJoin('proyecto_tesis as p','p.cod_matricula','=','e.cod_matricula')->select('e.*','p.cod_docente')->where('cod_docente','!=',null)->paginate($this::PAGINATION3);
        $asesores = AsesorCurso::all();
        return view('cursoTesis20221.director.editarAsignacion',['estudiantes'=>$estudiantes,'asesores'=>$asesores]);
    }

    public function saveAsesorAsignado(Request $request){

        $asesorAsignado = $request->saveAsesor;

        $posicion = explode(',',$asesorAsignado);
        $i = 0;
        do {
            if ($posicion[$i]!=null) {
                $datos = explode('_',$posicion[$i]);
                $estudiante = DB::table('estudiante_ct2022')->where('cod_matricula',$datos[0])->first();
                if($estudiante!=null){
                    $proyectoTesis = TesisCT2022::where('cod_matricula',$estudiante->cod_matricula)->first();
                    if ($proyectoTesis==null){
                        $proyectoTesis = new TesisCT2022();
                        $proyectoTesis->cod_matricula = $estudiante->cod_matricula;
                    }
                    $proyectoTesis->cod_docente = $datos[1];
                    $proyectoTesis->save();
                    $proyectoTesis = TesisCT2022::where('cod_matricula',$estudiante->cod_matricula)->first();
                    $campo = new CamposEstudiante();
                    $campo->cod_proyectotesis = $proyectoTesis->cod_proyectotesis;
                    $campo->save();
                }else{
                    return redirect()->route('director.asignar')->with('datos','error');
                }
            }
            $i++;
        } while ($i<count($posicion));

        return redirect()->route('director.asignar')->with('datos','ok');
    }

    public function saveEdicionAsignacion(Request $request){
        $asesorAsig = $request->saveAsesor;

            $posicion = explode(',',$asesorAsig);

            $i = 0;
            do {
                if ($posicion[$i]!=null) {
                    $datos = explode('_',$posicion[$i]);

                    $estudiante = DB::table('estudiante_ct2022')->where('cod_matricula',$datos[0])->first();
                    if($estudiante!=null){
                        $proyectoTesis = TesisCT2022::where('cod_matricula',$estudiante->cod_matricula)->first();
                        $proyectoTesis->cod_docente = $datos[1];
                        $proyectoTesis->save();
                    }else{
                        return redirect()->route('director.editarAsignacion')->with('datos','error');
                    }

                }
                $i++;
            } while ($i<count($posicion));

        return redirect()->route('director.editarAsignacion')->with('datos','ok');
    }

    public function showEstudiantes(){
        $asesor = AsesorCurso::where('username',auth()->user()->name)->get();
        $estudiantes = DB::table('estudiante_ct2022')
                            ->join('proyecto_tesis','estudiante_ct2022.cod_matricula','=','proyecto_tesis.cod_matricula')
                            ->select('estudiante_ct2022.*','proyecto_tesis.cod_docente','proyecto_tesis.estado','proyecto_tesis.cod_proyectotesis')
                            ->where('proyecto_tesis.cod_docente',$asesor[0]->cod_docente)->get();

        return view('cursoTesis20221.asesor.showEstudiantes',['estudiantes'=>$estudiantes]);
    }
    const PAGINATION2 = 10;
    public function listaAlumnos(Request $request){
        $buscarAlumno = $request->buscarAlumno;
        if($buscarAlumno!=""){
            if (is_numeric($buscarAlumno)) {

                $estudiantes = DB::table('estudiante_ct2022')->select('estudiante_ct2022.*')->where('estudiante_ct2022.cod_matricula','like','%'.$buscarAlumno.'%')->paginate($this::PAGINATION2);
            } else {
                $estudiantes = DB::table('estudiante_ct2022')->select('estudiante_ct2022.*')->where('estudiante_ct2022.apellidos','like','%'.$buscarAlumno.'%')->paginate($this::PAGINATION2);
            }
        }else{

            $estudiantes = DB::table('estudiante_ct2022')->select('estudiante_ct2022.*')->paginate($this::PAGINATION2);
        }
        return view('cursoTesis20221.director.listaAlumnos',['estudiantes'=>$estudiantes,'buscarAlumno'=>$buscarAlumno]);
    }

    const PAGINATION4 = 10;
    public function listaAsesores(Request $request){
        $buscarAsesor = $request->buscarAsesor;
        if($buscarAsesor!=""){
            if (is_numeric($buscarAsesor)) {

                $asesores = DB::table('asesor_curso')->select('asesor_curso.*')->where('asesor_curso.cod_docente','like','%'.$buscarAsesor.'%')->paginate($this::PAGINATION4);
            } else {
                $asesores = DB::table('asesor_curso')->select('asesor_curso.*')->where('asesor_curso.apellidos','like','%'.$buscarAsesor.'%')->paginate($this::PAGINATION4);
            }
        }else{

            $asesores = DB::table('asesor_curso')->select('asesor_curso.*')->paginate($this::PAGINATION4);
        }
        return view('cursoTesis20221.director.listaAsesores',['asesores'=>$asesores,'buscarAsesor'=>$buscarAsesor]);
    }

    public function verAlumnoEditar(Request $request){

        $alumno = DB::table('estudiante_ct2022')->select('estudiante_ct2022.*')->where('estudiante_ct2022.cod_matricula','=',$request->auxid)->get();

        return view('cursoTesis20221.director.editarAlumno',['alumno'=>$alumno]);
    }

    public function verAsesorEditar(Request $request){

        $asesor = DB::table('asesor_curso')->select('asesor_curso.*')->where('asesor_curso.cod_docente','=',$request->auxid)->get();

        return view('cursoTesis20221.director.editarAsesor',['asesor'=>$asesor]);
    }

    public function editEstudiante(Request $request){

        try {
            $alumno = EstudianteCT2022::find($request->cod_matricula);
            $alumno->dni = $request->dni;
            $alumno->apellidos = $request->apellidos;
            $alumno->nombres = $request->nombres;

            $alumno->save();

            return redirect()->route('director.listaAlumnos')->with('datos','ok');
        } catch (\Throwable $th) {
            return back()->with('datos','oknot');
        }

    }

    public function editAsesor(Request $request){

        try {
            $asesor = AsesorCurso::find($request->cod_docente);
            $asesor->nombres = $request->nombres;
            $asesor->grado_academico = $request->gradAcademico;
            $asesor->direccion = $request->direccion;

            $asesor->save();

            return redirect()->route('director.listaAsesores')->with('datos','ok');
        } catch (\Throwable $th) {
            return back()->with('datos','oknot');
        }

    }

    public function deleteAlumno(Request $request){
        try {
            $usuario = User::where('name',$request->auxidDelete.'-C')->first();
            $usuario->delete();
            $alumno = EstudianteCT2022::where('cod_matricula',$request->auxidDelete);
            $alumno->delete();

            return redirect()->route('director.listaAlumnos')->with('datos','okDelete');
        } catch (\Throwable $th) {
            return redirect()->route('director.listaAlumnos')->with('datos','okNotDelete');
        }
    }

    public function asignarTemas(Request $request){
        $id = $request->cod_matricula_hidden;
        $tesis = TesisCT2022::where('cod_matricula',$id)->first();
        if($tesis->estado !=2){
            $tesis->estado = 2;
            $tesis->save();
        }
        $estudiante = DB::table('campos_estudiante as ce')
                            ->join('proyecto_tesis as p','p.cod_proyectotesis','=','ce.cod_proyectotesis')
                            ->join('estudiante_ct2022 as e','e.cod_matricula','=','p.cod_matricula')
                            ->select('ce.*','e.nombres as estudiante_nombres','e.apellidos as estudiante_apellidos','e.cod_matricula')
                            ->where('ce.cod_proyectotesis',$tesis->cod_proyectotesis)->get();
        return view('cursoTesis20221.asesor.camposEstudiante',['estudiante'=>$estudiante]);
    }

    public function guardarTemas(Request $request){
        $tesis = TesisCT2022::where('cod_matricula',$request->cod_matriculaAux)->first();
        $temas = CamposEstudiante::where('cod_proyectotesis',$tesis->cod_proyectotesis)->first();
        if($request->chkTInvestigacion != null) $temas->tipo_investigacion = 1;
        if($request->chkLocalidad != null)      $temas->localidad_institucion = 1;
        if($request->chkDuracion != null)       $temas->duracion_proyecto = 1;
        if($request->chkRecursos != null)       $temas->recursos = 1;
        if($request->chkPresupuesto != null)    $temas->presupuesto = 1;
        if($request->chkFinanciamiento != null) $temas->financiamiento = 1;
        if($request->chkRealProb != null)       $temas->rp_antecedente_justificacion = 1;
        if($request->chkProblema != null)       $temas->formulacion_problema = 1;
        if($request->chkObjetivos != null)      $temas->objetivos = 1;
        if($request->chkMarcos != null)         $temas->marcos = 1;
        if($request->chkHipotesis != null)      $temas->formulacion_hipotesis = 1;
        if($request->chkDiseno != null)         $temas->diseño_investigacion = 1;
        if($request->chkReferencias != null)    $temas->referencias_b = 1;

        $temas->save();
        return redirect()->route('asesor.showEstudiantes')->with('datos','ok');
    }

    public function revisarTemas(Request $request){
        $cursoTesis = [];
        $campoCursoTesis = [];
        $aux = 0;
        $aux_campo = 0;
        $isFinal = 'false';
        $camposFull = 'false';

        $cod_matricula = $request->cod_matricula;
        $cursoTesis = DB::table('proyecto_tesis as p')
                            ->join('estudiante_ct2022 as e','e.cod_matricula','=','p.cod_matricula')
                            ->join('asesor_curso as ac','ac.cod_docente','=','p.cod_docente')
                            ->select('p.*','e.nombres as nombresAutor','e.apellidos as apellidosAutor','ac.nombres as nombre_asesor','ac.*')
                            ->where('e.cod_matricula',$cod_matricula)->get();

        foreach ($cursoTesis[0] as $curso) {
            $arregloAux[$aux] = $curso;
            $aux++;
        }
        for ($i=0; $i < sizeof($arregloAux)-11; $i++) {
            if ($arregloAux[$i]!=null) {
                $isFinal = 'true';
            }else{
                $isFinal = 'false';
                break;
            }
        }

        $observaciones = ObservacionesProy::join('historial_observaciones','observaciones_proy.cod_historialObs','=','historial_observaciones.cod_historialObs')
                            ->select('observaciones_proy.*')->where('historial_observaciones.cod_proyectotesis',$cursoTesis[0]->cod_proyectotesis)
                            ->get();

        $campos = DB::table('campos_estudiante')->select('campos_estudiante.*')->where('cod_proyectotesis',$cursoTesis[0]->cod_proyectotesis)->get();
        // $campos = CamposEstudiante::where('cod_matricula',$cursoTesis[0]->cod_matricula)->get();

        $objetivos = DB::table('objetivo')->where('cod_proyectotesis','=',$cursoTesis[0]->cod_proyectotesis)->get();

        $recursos = DB::table('recursos')->where('cod_proyectotesis','=',$cursoTesis[0]->cod_proyectotesis)->get();
        $variableop = DB::table('variableop')->where('cod_proyectotesis','=',$cursoTesis[0]->cod_proyectotesis)->get();
        $referencias = DB::table('referencias')->where('cod_proyectotesis','=',$cursoTesis[0]->cod_proyectotesis)->get();

        foreach ($campos[0] as $camposC){
            $campoCursoTesis[$aux_campo] = $camposC;
            $aux_campo++;
        }

        for ($i=1; $i < sizeof($campoCursoTesis); $i++) {
            if ($campoCursoTesis[$i]!=0 && sizeof($recursos) > 0 && sizeof($objetivos) > 0 && sizeof($variableop) > 0 && sizeof($referencias) > 0 ) {
                $camposFull = 'true';
            }else{
                $camposFull = 'false';
                break;
            }
        }

        $recursos = recursos::where('cod_proyectotesis','=',$cursoTesis[0]->cod_proyectotesis)->get();
        $tipoinvestigacion = TipoInvestigacion::where('cod_tinvestigacion','=',$cursoTesis[0]->cod_tinvestigacion)->get();
        $fin_persigue = Fin_Persigue::where('cod_fin_persigue','=',$cursoTesis[0]->ti_finpersigue)->get();
        $diseno_investigacion = Diseno_Investigacion::where('cod_diseno_investigacion','=',$cursoTesis[0]->ti_disinvestigacion)->get();
        $presupuesto = Presupuesto_Proyecto::join('presupuesto','presupuesto.cod_presupuesto','=','presupuesto_proyecto.cod_presupuesto')
        ->select('presupuesto_proyecto.*','presupuesto.codeUniversal','presupuesto.denominacion')
        ->where('presupuesto_proyecto.cod_proyectotesis','=',$cursoTesis[0]->cod_proyectotesis)->get();



        $matriz = MatrizOperacional::where('cod_proyectotesis','=',$cursoTesis[0]->cod_proyectotesis)->get();


        return view('cursoTesis20221.asesor.progresoEstudiante',['presupuesto'=>$presupuesto,
                '$observaciones' => $observaciones,'fin_persigue'=>$fin_persigue,'diseno_investigacion'=>$diseno_investigacion
                ,'tipoinvestigacion'=>$tipoinvestigacion,
                'recursos'=>$recursos,'objetivos'=>$objetivos,'variableop'=>$variableop,
                'campos'=>$campos,'cursoTesis'=>$cursoTesis,'referencias'=>$referencias,'isFinal'=>$isFinal,
                'camposFull'=>$camposFull,'matriz'=>$matriz
        ]);

    }

    public function guardarObservaciones(Request $request){


        $cursoTesis = DB::table('proyecto_tesis')
                       ->join('estudiante_ct2022','estudiante_ct2022.cod_matricula','=','proyecto_tesis.cod_matricula')
                       ->join('asesor_curso','proyecto_tesis.cod_docente','=','asesor_curso.cod_docente')
                       ->select('proyecto_tesis.*','estudiante_ct2022.nombres as nombresAutor','estudiante_ct2022.apellidos as apellidosAutor')->where('asesor_curso.username','=',auth()->user()->name)->where('estudiante_ct2022.cod_matricula',$request->cod_matricula_hidden)->get();

        // dd($cursoTesis[0]);
        $existHisto = Historial_Observaciones::where('cod_proyectotesis',$cursoTesis[0]->cod_proyectotesis)->get();
        if($existHisto->count()==0){
            $existHisto = new Historial_Observaciones();
            $existHisto->cod_proyectotesis = $cursoTesis[0]->cod_proyectotesis;
            $existHisto->fecha=now();
            $existHisto->estado=1;
            $existHisto->save();
        }
        $existHisto = Historial_Observaciones::where('cod_proyectotesis',$cursoTesis[0]->cod_proyectotesis)->get();

        $tesis = TesisCT2022::find($cursoTesis[0]->cod_proyectotesis);

        $cantidadObservaciones = ObservacionesProy::where('cod_historialObs',$existHisto[0]->cod_historialObs)->get();
        $posicion_obs = sizeof($cantidadObservaciones) + 1;
        $num = 'Observacion #'.$posicion_obs;

        try {
            $observaciones = new ObservacionesProy();
            $observaciones->cod_historialObs = $existHisto[0]->cod_historialObs;
            $observaciones->observacionNum = $num;
            $observaciones->fecha = now();

            if($request->tachkCorregir1!=""){
                $observaciones->titulo = $request->tachkCorregir1;
                $arrayThemes[]='titulo';
            }

            if($request->tachkCorregir23!=""){
                $observaciones->linea_investigacion = $request->tachkCorregir23;
                $arrayThemes[]='linea_investigacion';
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
            if($request->tachkCorregir24!=""){
                $observaciones->matriz_op = $request->tachkCorregir24;
                $arrayThemes[]='matriz_op';
            }

            $observaciones->estado = 1;
            $observaciones->save();

            $tesis->estado = 2;
            $tesis->save();

        } catch (\Throwable $th) {
            $th;
        }

        //$historialLastest = Historial_Observaciones::where('cod_proyectotesis',$tesis->cod_proyectotesis)->get();
        $latestCorrecion = ObservacionesProy::where('cod_historialObs',$existHisto[0]->cod_historialObs)->where('estado',1)->get();
        for($i = 0; $i<sizeof($arrayThemes);$i++){
            $detalleObs = new Detalle_Observaciones();
            $detalleObs->cod_observaciones=$latestCorrecion[0]->cod_observaciones;
            $detalleObs->tema_referido = $arrayThemes[$i];
            $detalleObs->correccion = null;
            $detalleObs->save();
        }
        // return redirect()->route('asesor.verHistoObs')->with('datos','ok');
        return redirect()->route('asesor.verObsEstudiante',$existHisto[0]->cod_historialObs)->with('datos','ok');

        //return redirect()->route
    }

    public function descargaObservacionCurso(Request $request){

            /* CODIGO PARA GENERAR EL WORD DE LAS CORRECCIONES */
            $correccion = ObservacionesProy::where('cod_observaciones','=',$request->cod_observaciones)->get();
            $tesis = TesisCT2022::join('historial_observaciones','proyecto_tesis.cod_proyectotesis','=','historial_observaciones.cod_proyectotesis')->where('historial_observaciones.cod_historialObs',$correccion[0]->cod_historialObs)->first();
            $estudiante = EstudianteCT2022::find($tesis->cod_matricula);
            $asesor = AsesorCurso::find($tesis->cod_docente);
            $recursosProy = recursos::where('cod_proyectotesis','=',$tesis->cod_proyectotesis)->get();

            $objetivosProy = Objetivo::where('cod_proyectotesis','=',$tesis->cod_proyectotesis)->get();
            $variableopProy = variableOP::where('cod_proyectotesis','=',$tesis->cod_proyectotesis)->get();

            if (sizeof($correccion)==1) {
                $cantObserva = 0;
            }elseif(sizeof($correccion)==2){
                $cantObserva = 1;
            }else{
                $cantObserva = 2;
            }

            $cod_matricula = $tesis->cod_matricula;
            $nombreEgresado = $estudiante->nombres.' '.$estudiante->apellidos;
            $escuelaEgresado = "Contabilidad y Finanzas";
            $nombreAsesor = $asesor->nombres;
            $numObservacion = $correccion[$cantObserva]->observacionNum;
            $fecha = $correccion[$cantObserva]->fecha;
            $titulo = $correccion[$cantObserva]->titulo;

            $linea = $correccion[$cantObserva]->linea_investigacion;

            $localidad_institucion = $correccion[$cantObserva]->localidad_institucion;
            $meses_ejecucion = $correccion[$cantObserva]->meses_ejecucion;

            $recursos = $correccion[$cantObserva]->recursos;

            $real_problematica = $correccion[$cantObserva]->real_problematica;
            $antecedentes = $correccion[$cantObserva]->antecedentes;
            $justificacion = $correccion[$cantObserva]->justificacion;
            $formulacion_prob = $correccion[$cantObserva]->formulacion_prob;

            $marco_teorico = $correccion[$cantObserva]->marco_teorico;
            $marco_conceptual = $correccion[$cantObserva]->marco_conceptual;
            $marco_legal = $correccion[$cantObserva]->marco_legal;

            $objetivos = $correccion[$cantObserva]->objetivos;

            $form_hipotesis = $correccion[$cantObserva]->form_hipotesis;
            $objeto_estudio = $correccion[$cantObserva]->objeto_estudio;
            $poblacion = $correccion[$cantObserva]->poblacion;
            $muestra = $correccion[$cantObserva]->muestra;
            $metodos = $correccion[$cantObserva]->metodos;
            $tecnicas_instrum = $correccion[$cantObserva]->tecnicas_instrum;
            $instrumentacion = $correccion[$cantObserva]->instrumentacion;

            $estg_metodologicas = $correccion[$cantObserva]->estg_metodologicas;


            $variables = $correccion[$cantObserva]->variables;
            $referencias = $correccion[$cantObserva]->referencias;
            $matriz_op = $correccion[$cantObserva]->matriz_op;

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
            if ($linea != "") {

                $nuevaSesion->addText("LINEA DE INVESTIGACION",$titulos);
                $nuevaSesion->addText($tesis->linea_investigacion);
                $nuevaSesion->addText("Observacion: ".$linea);
            }
            if ($localidad_institucion!= "") {
                $nuevaSesion->addText("LOCALIDAD E INSTITUCION",$titulos);
                $nuevaSesion->addText($tesis->localidad.", ".$tesis->institucion);
                $nuevaSesion->addText("Observacion: ".$localidad_institucion);
            }
            if ($meses_ejecucion!= "") {
                $nuevaSesion->addText("DURECION DE LA EJECUCION DEL PROYECTO",$titulos);
                $nuevaSesion->addText($tesis->meses_ejecucion);
                $nuevaSesion->addText("Observacion: ".$meses_ejecucion);
            }

            if ($recursos != "") {
                $nuevaSesion->addText("RECURSOS",$titulos);
                for ($i=0; $i < count($recursosProy); $i++) {
                    $nuevaSesion->addText("Tipo: ".$recursosProy[$i]->tipo.", Subtipo: ".$recursosProy[$i]->subtipo.", Descripcion: ".$recursosProy[$i]->descripcion);
                }
                $nuevaSesion->addText($recursos);

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
                for ($i=0; $i < count($objetivosProy); $i++) {
                    $nuevaSesion->addText("Tipo: ".$objetivosProy[$i]->tipo.", Descripcion: ".$objetivosProy[$i]->descripcion);
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
            if ($variables != "") {
                $nuevaSesion->addText("VARIABLES",$titulos);
                for ($i=0; $i < count($variableopProy); $i++) {
                    $nuevaSesion->addText("Descripcion: ".$variableopProy[$i]->descripcion);
                }
                $nuevaSesion->addText("Observacion: ".$variables);
            }
            if ($referencias != "") {
                $nuevaSesion->addText("REFERENCIAS",$titulos);
                $nuevaSesion->addText("Observacion: ".$referencias);
            }
            if ($matriz_op != "") {
                $nuevaSesion->addText("MATRIZ OPERACIONAL",$titulos);
                $nuevaSesion->addText("Observacion: ".$matriz_op);
            }


            $objetoEscrito = \PhpOffice\PhpWord\IOFactory::createWriter($word,'Word2007');
            try {
                $objetoEscrito->save(storage_path('Observaciones.docx'));
            } catch (\Throwable $th) {
                $th;
            }

            return response()->download(storage_path('Observaciones.docx'));
    }

    public function aprobarProy(Request $request){
        $proyecto = TesisCT2022::find($request->textcod);
        $codHistObserva = Historial_Observaciones::where('cod_proyectotesis',$request->textcod)->first();
        $proyecto->condicion = 'APROBADO';
        $proyecto->estado = 3;

        $proyecto->save();

        return redirect()->route('asesor.verObsEstudiante',$codHistObserva->cod_historialObs)->with('datos','okAprobado');
    }
    public function desaprobarProy(Request $request){
        $proyecto = TesisCT2022::find($request->textcod);
        $codHistObserva = Historial_Observaciones::where('cod_proyectotesis',$request->textcod)->first();
        $proyecto->condicion = 'DESAPROBADO';
        $proyecto->estado = 4;
        $proyecto->save();
        return redirect()->route('asesor.verObsEstudiante',$codHistObserva->cod_historialObs)->with('datos','okDesaprobado');
    }

    // He cambiado lo de tesis a Tesis2022 Controller.
}
