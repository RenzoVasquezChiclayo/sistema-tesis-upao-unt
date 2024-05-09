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
use App\Models\Grupo_Investigacion;
use App\Models\Detalle_Grupo_Investigacion;
use Illuminate\Support\Facades\DB;
use League\CommonMark\Node\Block\Paragraph;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Settings;
use Illuminate\Pagination\Paginator;

use App\Mail\EstadoEnviadaMail;
use App\Mail\EstadoObservadoMail;
use App\Models\Cronograma;
use App\Models\Cronograma_Proyecto;
use App\Models\Designacion_Jurado;
use Illuminate\Support\Facades\Mail;

use App\Http\Controllers\PlantillaController;

use Illuminate\Http\Request;

class CursoTesisController extends Controller
{



    public function index()
    {

        $id = auth()->user()->name;
        $aux = explode('-', $id);
        $id = $aux[0];

        $autor = DB::table('estudiante_ct2022')
            ->leftJoin('detalle_grupo_investigacion as dg', 'dg.cod_matricula', '=', 'estudiante_ct2022.cod_matricula')
            ->leftJoin('grupo_investigacion as gp', 'gp.id_grupo', '=', 'dg.id_grupo_inves')
            ->select('estudiante_ct2022.*', 'gp.cod_docente', 'gp.id_grupo', 'gp.num_grupo')
            ->where('estudiante_ct2022.cod_matricula', $id)
            ->first();
        //Encontramos al autor

        if ($autor->id_grupo == null) {
            return view('cursoTesis20221.cursoTesis', ['autor' => $autor, 'tesis' => [], 'variableop' => [], 'cronogramas_py' => [], 'cronograma' => [], 'campos' => []]);
        }
        $coautor = DB::table('detalle_grupo_investigacion as dg')->rightJoin('estudiante_ct2022 as e', 'e.cod_matricula', '=', 'dg.cod_matricula')->select('e.*')->where('dg.id_grupo_inves', $autor->id_grupo)->where('e.cod_matricula', '!=', $id)->first();

        $tesis = TesisCT2022::where('id_grupo_inves', '=', $autor->id_grupo)->get(); //Encontramos la tesis
        $asesor = DB::table('asesor_curso')->leftjoin('grado_academico as ga', 'asesor_curso.cod_grado_academico', 'ga.cod_grado_academico')->leftjoin('categoria_docente as cd', 'asesor_curso.cod_categoria', 'cd.cod_categoria')->select('asesor_curso.*', 'ga.descripcion as DescGrado', 'cd.descripcion as DescCat')->where('cod_docente', $tesis[0]->cod_docente)->first();  //Encontramos al asesor
        /* Traemos informacion de las tablas*/
        $tinvestigacion = TipoInvestigacion::all();
        $fin_persigue = Fin_Persigue::all();
        $diseno_investigacion = Diseno_Investigacion::all();
        $cronograma = Cronograma::all();
        $cronogramas_py = Cronograma_Proyecto::where("cod_proyectotesis", $tesis[0]->cod_proyectotesis)->get();
        $presupuestos = Presupuesto::all();
        $tiporeferencia = TipoReferencia::all();
        $referencias = referencias::where('cod_proyectotesis', '=', $tesis[0]->cod_proyectotesis)->get(); //Por si existen referencias

        //Verificaremos que se hayan dado las observaciones y las enviaremos
        $correciones = ObservacionesProy::join('historial_observaciones', 'observaciones_proy.cod_historialObs', '=', 'historial_observaciones.cod_historialObs')
            ->select('observaciones_proy.*')->where('historial_observaciones.cod_proyectotesis', $tesis[0]->cod_proyectotesis)
            ->where('observaciones_proy.estado', 1)->get();

        $detalles = [];
        if (sizeof($correciones) > 0) {
            $detalles = Detalle_Observaciones::where('cod_observaciones', $correciones[0]->cod_observaciones)->get();
        }

        $presupuestoProy = Presupuesto_Proyecto::where('cod_proyectotesis', '=', $tesis[0]->cod_proyectotesis)->get();

        $recursos = recursos::where('cod_proyectotesis', '=', $tesis[0]->cod_proyectotesis)->get();

        $objetivos = Objetivo::where('cod_proyectotesis', '=', $tesis[0]->cod_proyectotesis)->get();

        $variableop = variableOP::where('cod_proyectotesis', '=', $tesis[0]->cod_proyectotesis)->get();

        $campos = CamposEstudiante::where('cod_proyectotesis', $tesis[0]->cod_proyectotesis)->get();

        $matriz = MatrizOperacional::where('cod_proyectotesis', '=', $tesis[0]->cod_proyectotesis)->get();

        //Obtener los archivos e imagenes que tuviese guardado.
        $detalleHistorial = [];
        //dd($tesis[0]->fecha_inicio->toDateString());
        return view('cursoTesis20221.cursoTesis', [
            'autor' => $autor,
            'presupuestos' => $presupuestos, 'fin_persigue' => $fin_persigue, 'diseno_investigacion' => $diseno_investigacion, 'tiporeferencia' => $tiporeferencia, 'tesis' => $tesis, 'asesor' => $asesor,
            'correciones' => $correciones, 'recursos' => $recursos, 'objetivos' => $objetivos, 'variableop' => $variableop,
            'presupuestoProy' => $presupuestoProy, 'detalles' => $detalles, 'tinvestigacion' => $tinvestigacion, 'campos' => $campos,
            'referencias' => $referencias, 'detalleHistorial' => $detalleHistorial, 'matriz' => $matriz, 'cronograma' => $cronograma, 'cronogramas_py' => $cronogramas_py, 'coautor' => $coautor
        ]);
    }

    public function estadoProyecto()
    {
        $id = auth()->user()->name;
        $aux = explode('-', $id);
        $id = $aux[0];
        $estudiante = EstudianteCT2022::find($id);
        $hTesis = TesisCT2022::join('asesor_curso as ac', 'ac.cod_docente', '=', 'proyecto_tesis.cod_docente')
            ->join('grupo_investigacion as g_i', 'proyecto_tesis.id_grupo_inves', '=', 'g_i.id_grupo')
            ->join('detalle_grupo_investigacion as d_g', 'd_g.id_grupo_inves', '=', 'g_i.id_grupo')
            ->select('ac.nombres as nombre_asesor', 'ac.apellidos as apellidos_asesor', 'proyecto_tesis.*')
            ->where('d_g.cod_matricula', '=', $estudiante->cod_matricula)->get();
        return view('cursoTesis20221.estadoProyecto', ['hTesis' => $hTesis]);
    }

    public function historialCorrecciones()
    {
        return view('cursoTesis20221.historialCorrecciones');
    }

    public function saveTesis(Request $request)
    {

        $id = auth()->user()->name;
        $aux = explode('-', $id);
        $id = $aux[0];
        $isSaved = $request->isSaved;
        $estudiante = EstudianteCT2022::find($id);

        $tesis = TesisCT2022::join('grupo_investigacion as g_i', 'proyecto_tesis.id_grupo_inves', '=', 'g_i.id_grupo')
            ->join('detalle_grupo_investigacion as d_g', 'd_g.id_grupo_inves', '=', 'g_i.id_grupo')
            ->select('proyecto_tesis.*')
            ->where('d_g.cod_matricula', '=', $estudiante->cod_matricula)->first();

        $estudiantes_grupo = DB::table('estudiante_ct2022 as e')
            ->join('detalle_grupo_investigacion as d_g', 'd_g.cod_matricula', '=', 'e.cod_matricula')
            ->join('grupo_investigacion as g_i', 'g_i.id_grupo', '=', 'd_g.id_grupo_inves')
            ->select('g_i.num_grupo', 'e.cod_matricula', 'e.nombres', 'e.apellidos')
            ->where('d_g.id_grupo_inves', $tesis->id_grupo_inves)->get();
        $asesor = AsesorCurso::where('cod_docente', $tesis->cod_docente)->first();
        $observacionX = ObservacionesProy::join('historial_observaciones', 'observaciones_proy.cod_historialObs', '=', 'historial_observaciones.cod_historialObs')
            ->select('observaciones_proy.*')->where('historial_observaciones.cod_proyectotesis', $tesis->cod_proyectotesis)
            ->where('observaciones_proy.estado', 1)->get();

        if (sizeof($observacionX) > 0) {
            $detalles = Detalle_Observaciones::where('cod_observaciones', $observacionX[0]->cod_observaciones)->get();
        }

        try {

            /*Si el egresado tiene una observacion pendiente, solo se guardaran los cambios solicitados*/
            if (sizeof($observacionX) > 0) {

                for ($i = 0; $i < sizeof($detalles); $i++) {
                    $tema = $detalles[$i]->tema_referido;
                    if ($tema == "localidad_institucion") {
                        $name_request = 'txtlocalidad';
                    } else {
                        $name_request = 'txt' . $tema;
                    }
                    $detalleEEG = Detalle_Observaciones::find($detalles[$i]->cod_detalleObs);

                    $detalleEEG->correccion = $request->$name_request;
                    $detalleEEG->save();
                }

                $historialX = Historial_Observaciones::where('cod_proyectotesis', '=', $tesis->cod_proyectotesis)->get();
                $historialX[0]->fecha = now();
                $historialX[0]->save();

                $observacionX[0]->estado = 2;
                $observacionX[0]->save();
            }

            /*Si elimina datos que ya existian en las tablas*/
            if ($request->listOldlrec != "") {
                $deleteRecursos = explode(",", $request->listOldlrec);
                for ($i = 0; $i < sizeof($deleteRecursos); $i++) {
                    $recDelete = recursos::find($deleteRecursos[$i]);
                    if ($recDelete != null) {
                        $recDelete->delete();
                    }
                }
            }
            if ($request->listOldlvar != "") {
                $deleteVariables = explode(",", $request->listOldlvar);
                for ($i = 0; $i < sizeof($deleteVariables); $i++) {
                    $varDelete = variableOP::find($deleteVariables[$i]);
                    if ($varDelete != null) {
                        $varDelete->delete();
                    }
                }
            }
            if ($request->listOldlobj != "") {
                $deleteObjetivos = explode(",", $request->listOldlobj);
                for ($i = 0; $i < sizeof($deleteObjetivos); $i++) {
                    $objDelete = Objetivo::find($deleteObjetivos[$i]);
                    if ($objDelete != null) {
                        $objDelete->delete();
                    }
                }
            }

            if ($request->listOldlref != "") {
                $deleteReferencias = explode(",", $request->listOldlref);
                for ($i = 0; $i < sizeof($deleteReferencias); $i++) {
                    $referenciasDelete = referencias::find($deleteReferencias[$i]);
                    if ($referenciasDelete != null) {
                        $referenciasDelete->delete();
                    }
                }
            }


            /*Proyecto de Investigacion y/o Tesis*/
            if ($request->txttitulo != "") {
                $tesis->titulo = $request->txttitulo;
            }

            //Investigacion
            if ($request->cboTipoInvestigacion != "") {
                if (strlen($request->cboTipoInvestigacion) < 4) {
                    $tesis->cod_tinvestigacion = str_repeat("0", 4 - strlen($request->cboTipoInvestigacion)) . $request->cboTipoInvestigacion;
                } else {
                    $tesis->cod_tinvestigacion = $request->cboTipoInvestigacion;
                }
            }

            if ($request->txtti_finpersigue != "") {
                $tesis->ti_finpersigue = $request->txtti_finpersigue;
            }

            if ($request->txtti_disinvestigacion != "") {
                $tesis->ti_disinvestigacion = $request->txtti_disinvestigacion;
            }


            //Desarrollo del proyecto
            if ($request->txtlocalidad != "") {
                $tesis->localidad = $request->txtlocalidad;
            }
            if ($request->txtinstitucion != "") {
                $tesis->institucion = $request->txtinstitucion;
            }
            if ($request->txtmeses_ejecucion != "") {
                $tesis->meses_ejecucion = $request->txtmeses_ejecucion;
            }
            if ($request->txtunidad_academica != "") {
                $tesis->unidad_academica = $request->txtunidad_academica;
            }
            if ($request->txtfecha_inicio != "") {
                $tesis->fecha_inicio = $request->txtfecha_inicio;
            }

            if ($request->txtfecha_termino != "") {
                $tesis->fecha_termino = $request->txtfecha_termino;
            }

            //Cronograma de trabajo
            if ($request->listMonths != "") {
                $allCronogramas = Cronograma_Proyecto::where("cod_proyectotesis", $tesis->cod_proyectotesis)->get();
                $cod_cronograma = $request->cod_cronograma; //[123,343,434]
                $cronograma = $request->listMonths; //1_2_4_1a_2_3_2a_4_3a_5_4a
                //dd($cronograma);
                $cronograma = explode("_", $cronograma); //[1,2,1a,2,3,2a,4,3a,5,4a]
                $sucesivos = true;
                $inicioSucesivo = null;
                $finSucesivo = null;
                $string_extra = ""; // 1-2, 4 ---- 1-6 ----- 1,3,5
                $contador = 0;
                foreach ($cronograma as $c) {
                    if (strpos($c, 'a') !== false) {
                        $contador++;
                    }
                }
                $exi = 0;
                for ($j = 0; $j < $contador; $j++) {
                    $new_activity = new Cronograma_Proyecto();
                    for ($i = $exi; $i < sizeof($cronograma); $i++) {
                        if (stripos($cronograma[$i], "a") !== false) {
                            if ($finSucesivo != null) {
                                $string_extra .= $inicioSucesivo . "-" . $finSucesivo;
                            } else {
                                $string_extra .= $inicioSucesivo;
                            }
                            if (sizeof($allCronogramas) > 0) {
                                $extraCrono = false;
                                foreach ($allCronogramas as $crono) {
                                    // Verificar si el 'id' del objeto coincide con el ID buscado
                                    if ($crono->cod_cronograma == $cod_cronograma[$j]) {
                                        $crono->descripcion = $string_extra;
                                        $crono->save();
                                        $extraCrono = true;
                                        break; // Puedes romper el bucle una vez que encuentres el objeto
                                    }
                                }
                                if (!$extraCrono) {
                                    $new_activity->descripcion = $string_extra;
                                    $new_activity->cod_cronograma = $cod_cronograma[$j];
                                    $new_activity->cod_proyectotesis = $tesis->cod_proyectotesis;
                                    $new_activity->save();
                                }
                            } else {
                                $new_activity->descripcion = $string_extra;
                                $new_activity->cod_cronograma = $cod_cronograma[$j];
                                $new_activity->cod_proyectotesis = $tesis->cod_proyectotesis;
                                $new_activity->save();
                            }
                            $string_extra = "";
                            $inicioSucesivo = null;
                            $finSucesivo = null;
                            $exi = $i + 1;

                            break;
                        } else {
                            if ($i > $exi && (int)$cronograma[$i] != (int)$cronograma[$i - 1] + 1) {
                                $sucesivos = false;
                                if ($inicioSucesivo == $cronograma[$i - 1]) {
                                    $string_extra .= $inicioSucesivo . ","; //1,3 ---- 4
                                } else {
                                    $string_extra .= $inicioSucesivo . "-" . $cronograma[$i - 1] . ",";
                                }
                                $inicioSucesivo = $cronograma[$i];
                                $finSucesivo = null;
                            }
                            if ($sucesivos === true) {
                                if ($inicioSucesivo == null) {
                                    $inicioSucesivo = $cronograma[$i];
                                }
                                if ($i != $exi) {
                                    $finSucesivo = $cronograma[$i];
                                }
                            } else {
                                $sucesivos = true;
                            }
                        }
                    }
                }
            }
            //Economico
            if ($request->txtfinanciamiento != "") {
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
            if ($request->txtreal_problematica != "") {
                $tesis->real_problematica = $request->txtreal_problematica;
            }
            if ($request->txtantecedentes != "") {
                $tesis->antecedentes = $request->txtantecedentes;
            }
            if ($request->txtjustificacion != "") {
                $tesis->justificacion = $request->txtjustificacion;
            }
            if ($request->txtformulacion_prob != "") {
                $tesis->formulacion_prob = $request->txtformulacion_prob;
            }

            /*Hipotesis y disenio*/
            if ($request->txtform_hipotesis != "") {
                $tesis->form_hipotesis = $request->txtform_hipotesis;
            }

            /*Material, metodos y tecnicas*/
            if ($request->txtobjeto_estudio != "") {
                $tesis->objeto_estudio = $request->txtobjeto_estudio;
            }
            if ($request->txtpoblacion != "") {
                $tesis->poblacion = $request->txtpoblacion;
            }
            if ($request->txtmuestra != "") {
                $tesis->muestra = $request->txtmuestra;
            }
            if ($request->txtmetodos != "") {
                $tesis->metodos = $request->txtmetodos;
            }
            if ($request->txttecnicas_instrum != "") {
                $tesis->tecnicas_instrum = $request->txttecnicas_instrum;
            }
            if ($request->txtdis_contrastacion != "") {
                $tesis->diseño_contrastacion = $request->txtdis_contrastacion;
            }

            /*Instrumentacion*/
            if ($request->txtinstrumentacion != "") {
                $tesis->instrumentacion = $request->txtinstrumentacion;
            }

            /*Estrateg. metodologicas*/
            if ($request->txtestg_metodologicas != "") {
                $tesis->estg_metodologicas = $request->txtestg_metodologicas;
            }

            /*Marco teorico*/
            if ($request->txtmarco_teorico != "") {
                $tesis->marco_teorico = $request->txtmarco_teorico;
            }
            if ($request->txtmarco_conceptual != "") {
                $tesis->marco_conceptual = $request->txtmarco_conceptual;
            }
            if ($request->txtmarco_legal != "") {
                $tesis->marco_legal = $request->txtmarco_legal;
            }
            if ($isSaved == "true") {
                $tesis->estado = 9;
            } else {
                $tesis->estado = 1;
                // if ($asesor->correo != null) {
                //     Mail::to($asesor->correo)->send(new EstadoEnviadaMail($request->txttitulo,$estudiantes_grupo));
                // }

            }

            /* Recursos */
            $arregloTipo = [];
            $arreglosubTipo = [];
            $arregloDescipcion = [];
            if ($request->idtipo != "") {
                $tipos = $request->idtipo;
                $subtipo = $request->idsubtipo;

                $descripcion = $request->iddescripcion;
                if (!empty($descripcion)) {

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

                    for ($i = 0; $i < count($tipos); $i++) {
                        $recurso = new recursos();
                        $recurso->tipo = $arregloTipo[$i];
                        $recurso->subtipo = $arreglosubTipo[$i];
                        $recurso->descripcion = $arregloDescipcion[$i];

                        $cadena = $cadena . $arregloTipo[$i] . ", " . $arreglosubTipo[$i] . ", " . $arregloDescipcion[$i] . ". ";

                        $recurso->cod_proyectotesis = $tesis->cod_proyectotesis;

                        $recurso->save();
                    }

                    if (sizeof($observacionX) > 0) {
                        for ($i = 0; $i < sizeof($detalles); $i++) {
                            if ($detalles[$i]->tema_referido == 'recursos') {
                                $detalleEEG = Detalle_Observaciones::find($detalles[$i]->cod_detalleObs);
                                $detalleEEG->correccion = $cadena;
                                $detalleEEG->save();
                            }
                        }
                    }
                }
            }
            /* Presupuesto */
            if ($request->precios != "") {
                $preciosP = $request->precios;
                $preciosP = explode("_", $preciosP);
                $cadena_presup = "";
                if ($preciosP != null) {
                    for ($a = 0; $a < sizeof($preciosP); $a++) {

                        if ($a == sizeof($preciosP) - 1) {
                            $cadena_presup .= $preciosP[$a];
                            break;
                        }
                        $cadena_presup .= $preciosP[$a] . ", ";
                    }
                }
                $arregloPresupuesto = Presupuesto::all();
                $existPresupuesto = Presupuesto_Proyecto::where('cod_proyectotesis', $tesis->cod_proyectotesis)->get();
                $x = 0;
                if ($existPresupuesto->count() == 0) {

                    foreach ($arregloPresupuesto as $presupuesto) {

                        $preProyect = new Presupuesto_Proyecto();
                        $preProyect->cod_presupuesto = $presupuesto->cod_presupuesto;
                        $preProyect->precio = floatval($preciosP[$x]);
                        $preProyect->cod_proyectotesis = $tesis->cod_proyectotesis;
                        $preProyect->save();

                        $x += 1;
                    }
                } else {
                    for ($i = 0; $i < sizeof($existPresupuesto); $i++) {
                        $last_presupuesto = Presupuesto_Proyecto::find($existPresupuesto[$i]->cod_presProyecto);
                        $last_presupuesto->precio = $preciosP[$i];
                        $last_presupuesto->save();
                    }
                    if (sizeof($observacionX) > 0) {
                        for ($i = 0; $i < sizeof($detalles); $i++) {
                            if ($detalles[$i]->tema_referido == 'presupuesto_proy') {
                                $detalleEEG = Detalle_Observaciones::find($detalles[$i]->cod_detalleObs);
                                $detalleEEG->correccion = $cadena_presup;
                                $detalleEEG->save();
                            }
                        }
                    }
                }
            }


            /* Objetivos */
            $arregloTipoObj = [];
            $arreglodescripcionObj = [];
            if ($request->idtipoObj != "") {
                $tipoObj = $request->idtipoObj;
                $descripcionObj = $request->iddescripcionObj;

                if (!empty($descripcionObj)) {
                    foreach ($tipoObj as $tObj) {
                        $arregloTipoObj[] = $tObj;
                    }
                    foreach ($descripcionObj as $dObj) {
                        $arreglodescripcionObj[] = $dObj;
                    }
                    $cadena = "";
                    for ($i = 0; $i <= count($tipoObj) - 1; $i++) {
                        $objetivo = new Objetivo();
                        $objetivo->tipo = $arregloTipoObj[$i];
                        $objetivo->descripcion = $arreglodescripcionObj[$i];
                        $cadena = $arregloTipoObj[$i] . ", " . $arreglodescripcionObj[$i] . ". ";
                        $objetivo->cod_proyectotesis = $tesis->cod_proyectotesis;
                        $objetivo->save();
                    }
                    if (sizeof($observacionX) > 0) {
                        for ($i = 0; $i < sizeof($detalles); $i++) {
                            if ($detalles[$i]->tema_referido == 'objetivos') {
                                $detalleEEG = Detalle_Observaciones::find($detalles[$i]->cod_detalleObs);
                                $detalleEEG->correccion = $cadena;
                                $detalleEEG->save();
                            }
                        }
                    }
                }
            }


            /* Variable Operacional */
            $arreglodescripcionVar = [];
            if ($request->iddescripcionVar != "") {
                $descripcionVar = $request->iddescripcionVar;
                if (!empty($descripcionVar)) {
                    foreach ($descripcionVar as $dVar) {
                        $arreglodescripcionVar[] = $dVar;
                    }
                    $cadena = "";
                    for ($i = 0; $i <= count($descripcionVar) - 1; $i++) {
                        $variable = new variableOP();
                        $variable->descripcion = $arreglodescripcionVar[$i];
                        $cadena = $cadena . $arreglodescripcionVar[$i] . ". ";
                        $variable->cod_proyectotesis = $tesis->cod_proyectotesis;
                        $variable->save();
                    }
                    if (sizeof($observacionX) > 0) {
                        for ($i = 0; $i < sizeof($detalles); $i++) {
                            if ($detalles[$i]->tema_referido == 'variables') {
                                $detalleEEG = Detalle_Observaciones::find($detalles[$i]->cod_detalleObs);
                                $detalleEEG->correccion = $cadena;
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

            if (empty($tipoRef) != 1) {
                foreach ($tipoRef as $tAPA) {
                    $arregloTipoRef[] = $tAPA;
                }
            }

            if (empty($autorApa) != 1) {
                foreach ($autorApa as $aut) {
                    $arregloA[] = $aut;
                }
            }

            if (empty($fPublicacion) != 1) {
                foreach ($fPublicacion as $fecha) {
                    $arreglofP[] = $fecha;
                }
            }


            if (empty($tituloTrabajo) != 1) {
                foreach ($tituloTrabajo as $tit) {
                    $arregloT[] = $tit;
                }
            }

            if (empty($fuente) != 1) {
                foreach ($fuente as $fu) {
                    $arregloF[] = $fu;
                }
            }

            if (empty($editorial) != 1) {
                foreach ($editorial as $edit) {
                    $arregloE[] = $edit;
                }
            }

            if (empty($titCapitulo) != 1) {
                foreach ($titCapitulo as $titC) {
                    $arregloTC[] = $titC;
                }
            }


            if (empty($numCapitulos) != 1) {
                foreach ($numCapitulos as $numC) {
                    $arregloNumC[] = $numC;
                }
            }



            if (empty($titRevista) != 1) {
                foreach ($titRevista as $titR) {
                    $arregloTR[] = $titR;
                }
            }
            if (empty($volumenRevista) != 1) {
                foreach ($volumenRevista as $volR) {
                    $arregloVR[] = $volR;
                }
            }
            if (empty($nombreWeb) != 1) {
                foreach ($nombreWeb as $nameW) {
                    $arregloNW[] = $nameW;
                }
            }
            if (empty($nombrePeriodista) != 1) {
                foreach ($nombrePeriodista as $nameP) {
                    $arregloNP[] = $nameP;
                }
            }
            if (empty($nombreInstitucion) != 1) {
                foreach ($nombreInstitucion as $nameIns) {
                    $arregloNI[] = $nameIns;
                }
            }
            if (empty($subtitInfo) != 1) {
                foreach ($subtitInfo as $subtit) {
                    $arregloST[] = $subtit;
                }
            }
            if (empty($nombreEditorInfo) != 1) {
                foreach ($nombreEditorInfo as $nameE) {
                    $arregloNE[] = $nameE;
                }
            }


            $aux1 = 0;
            $aux2 = 0;
            $aux3 = 0;
            $aux4 = 0;
            $aux5 = 0;
            $aux6 = 0;
            if (!empty($autorApa)) {
                for ($i = 0; $i <= count($autorApa) - 1; $i++) {
                    $referencias = new referencias();
                    $referencias->cod_tiporeferencia = $arregloTipoRef[$i];
                    $referencias->autor = $arregloA[$i];
                    $referencias->fPublicacion = $arreglofP[$i];
                    $referencias->titulo = $arregloT[$i];
                    $referencias->fuente = $arregloF[$i];
                    if ($arregloTipoRef[$i] == 1) {
                        if (empty($arregloE[$aux1]) == 1) {
                            $referencias->editorial = " ";
                        } else {
                            $referencias->editorial = $arregloE[$aux1];
                        }
                        if (empty($arregloTC[$aux1]) == 1) {
                            $referencias->title_cap = " ";
                        } else {
                            $referencias->title_cap = $arregloTC[$aux1];
                        }
                        if (empty($arregloNumC[$aux1]) == 1) {
                            $referencias->num_capitulo = " ";
                        } else {
                            $referencias->num_capitulo = $arregloNumC[$aux1];
                        }
                        $aux1++;
                    }
                    if ($arregloTipoRef[$i] == 2) {
                        if (empty($arregloTR[$aux2]) == 1) {
                            $referencias->title_revista = " ";
                        } else {
                            $referencias->title_revista = $arregloTR[$aux2];
                        }
                        if (empty($arregloVR[$aux2]) == 1) {
                            $referencias->volumen = " ";
                        } else {
                            $referencias->volumen = $arregloVR[$aux2];
                        }
                        $aux2++;
                    }
                    if ($arregloTipoRef[$i] == 3) {
                        if (empty($arregloNW[$aux3]) == 1) {
                            $referencias->name_web = " ";
                        } else {
                            $referencias->name_web = $arregloNW[$aux3];
                        }
                        $aux3++;
                    }
                    if ($arregloTipoRef[$i] == 4) {
                        if (empty($arregloNP[$aux4]) == 1) {
                            $referencias->name_periodista = " ";
                        } else {
                            $referencias->name_periodista = $arregloNP[$aux4];
                        }
                        $aux4++;
                    }
                    if ($arregloTipoRef[$i] == 5) {
                        if (empty($arregloNI[$aux5]) == 1) {
                            $referencias->name_institucion = " ";
                        } else {
                            $referencias->name_institucion = $arregloNI[$aux5];
                        }
                        $aux5++;
                    }
                    if ($arregloTipoRef[$i] == 6) {
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

            $col_matriz = MatrizOperacional::where('cod_proyectotesis', '=', $tesis->cod_proyectotesis)->get();


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
            return redirect()->route('curso.tesis20221')->with('datos', 'oknot');
        }



        return redirect()->route('curso.estado-proyecto')->with('datos', 'ok');
    }

    // Funcion para guardar el texto e imagenes
    private function getText_saveImg(Request $request, $textarea, $matricula, $cod_historial, $tipoArchivo, $name_img, $grupos_value, $txt_principal)
    {
        //Guardar archivos
        $unirtxtArea = $txt_principal;
        $grupos = [];
        $posicion = 0;
        $numero_grupo = 0;

        if ($request->hasFile($name_img)) {

            $grupos = explode(",", $grupos_value);
            $archivos = $request->$name_img;
            $text_area = $textarea;

            for ($i = 0; $i < sizeof($text_area); $i++) {
                $unirtxtArea = $unirtxtArea . "-_-" . $text_area[$i];
            }

            for ($i = 0; $i < sizeof($archivos); $i++) {

                $table = new Detalle_Archivo();
                $file = $request->file($name_img);

                $destinationPath = 'cursoTesis-2022/img/' . $matricula . '-CursoTesis/' . $tipoArchivo . '/';
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }

                $filename = ($i + 1) . '-' . $matricula . '.jpg';
                $uploadSuccess = $file[$i]->move($destinationPath, $filename);
                $table->cod_archivos = $cod_historial;
                $table->tipo = $tipoArchivo;
                $table->ruta = $filename;
                if ((int)$grupos[$posicion] == 0) {
                    $numero_grupo = $numero_grupo + 1;
                    $posicion++;
                }
                $table->grupo = $numero_grupo;
                $gruposJI[$posicion] = $grupos[$posicion] - 1;

                $table->save();
            }
        } else {
            $unirtxtArea = $textarea;
        }
        return $unirtxtArea;
    }


    /*FUNCION PARA DESCARGAR EL WORD DE LA TESIS*/
    public function descargaTesis(Request $request)
    {
        $newRequest = new \Illuminate\Http\Request();
        $newRequest->setMethod('POST');

        /*template: $newRequest->request->add(['name' => 'value']); */

        $cod_cursoTesis = $request->cod_cursoTesis;

        $tesis = TesisCT2022::where('cod_proyectotesis', $cod_cursoTesis)->get();
        $estudiantes_grupo = DB::table('estudiante_ct2022 as e')
            ->join('detalle_grupo_investigacion as d_g', 'd_g.cod_matricula', '=', 'e.cod_matricula')
            ->select('e.cod_matricula', 'e.nombres', 'e.apellidos')
            ->where('d_g.id_grupo_inves', $tesis[0]->id_grupo_inves)->get();
        $asesor = AsesorCurso::find($tesis[0]->cod_docente);
        /*Datos del Autor*/
        $text_autor = [];
        if (count($estudiantes_grupo) > 1) {
            $estudiante1 = $estudiantes_grupo[0]->nombres . ' ' . $estudiantes_grupo[0]->apellidos;
            $estudiante2 = $estudiantes_grupo[1]->nombres . ' ' . $estudiantes_grupo[1]->apellidos;
            array_push($text_autor, $estudiante1);
            array_push($text_autor, $estudiante2);
        } else {
            $estudiante1 = $estudiantes_grupo[0]->nombres . ' ' . $estudiantes_grupo[0]->apellidos;
            array_push($text_autor, $estudiante1);
        }

        $newRequest->request->add(['autores' => $text_autor]);
        $newRequest->request->add([
            'facultad' => '',
            'escuela_profesional' => ''
        ]);
        /*Datos del Asesor*/
        $nombre_asesor = $asesor->nombres . " " . $asesor->apellidos;

        $orcid_asesor = $asesor->orcid;
        $grado_asesor = $asesor->grado_academico;
        $titulo_asesor = $asesor->titulo_profesional;
        $direccion_asesor = $asesor->direccion;

        $newRequest->request->add([
            'asesor_nombre' => $nombre_asesor,
            'asesor_grado' => $asesor->grado_academico,
            'asesor_titulo' => $asesor->titulo_profesional,
            'asesor_direccion' => $asesor->direccion
        ]);

        /*Proyecto de Investigacion y/o Tesis*/
        $titulo = $tesis[0]->titulo;

        $newRequest->request->add(['titulo_proyecto' => $tesis[0]->titulo]);

        //Investigacion
        $tipo_investigacion = TipoInvestigacion::find($tesis[0]->cod_tinvestigacion);
        $cod_tinvestigacion = '';
        if ($cod_tinvestigacion != null) {
            $cod_tinvestigacion = $tipo_investigacion->descripcion;
        }
        $newRequest->request->add(['linea_investigacion' => $cod_tinvestigacion]);

        $fin_persigue = Fin_Persigue::find($tesis[0]->ti_finpersigue);
        $ti_finpersigue = "";
        if ($fin_persigue != null) {
            $ti_finpersigue = $fin_persigue->descripcion;
        }
        $newRequest->request->add(['inv_fin_persigue' => $ti_finpersigue]);

        $diseno_investigacion = Diseno_Investigacion::find($tesis[0]->ti_disinvestigacion);
        $ti_disinvestigacion = "";
        if ($diseno_investigacion != null) {
            $ti_disinvestigacion = $diseno_investigacion->descripcion;
        }
        $newRequest->request->add([
            'inv_diseno' => $ti_disinvestigacion,
            'diseno_inv' => $ti_disinvestigacion
        ]);

        //Desarrollo del proyecto
        $localidad = $tesis[0]->localidad;
        $institucion = $tesis[0]->institucion;
        $meses_ejecucion = $tesis[0]->meses_ejecucion;
        $newRequest->request->add([
            'proyecto_meses' => $tesis[0]->meses_ejecucion,
            'localidad' => $localidad,
            'institucion' => $institucion
        ]);

        //Economico
        $financiamiento = $tesis[0]->financiamiento;

        /*Realidad problematica y others*/
        $real_problematica = $tesis[0]->real_problematica;

        $antecedentes = $tesis[0]->antecedentes;
        $justificacion = $tesis[0]->justificacion;
        $formulacion_prob = $tesis[0]->formulacion_prob;

        /*Hipotesis y disenio*/
        $form_hipotesis = $tesis[0]->form_hipotesis;

        $newRequest->request->add([
            'financiamiento' => $financiamiento,
            'realidad_problematica' => $real_problematica,
            'antecedentes' => $antecedentes,
            'justificacion_inv' => $justificacion,
            'formulacion_problema' => $form_hipotesis
        ]);

        /* Objetivos */
        $objetivos = Objetivo::where('cod_proyectotesis',$tesis[0]->cod_proyectotesis)->get();
        $arrayObjetivo = [];
        for ($i=0; $i < sizeof($objetivos); $i++) {
            $arrayObjetivo[] = json_encode(array('tipo'=>$objetivos[$i]->tipo,'descripcion'=>$objetivos[$i]->descripcion));
        }
        $newRequest->request->add(['objetivos'=>$arrayObjetivo]);

        /*Material, metodos y tecnicas*/
        $objeto_estudio = $tesis[0]->objeto_estudio;
        $poblacion = $tesis[0]->poblacion;
        $muestra = $tesis[0]->muestra;
        $metodos = $tesis[0]->metodos;
        $tecnicas_instrum = $tesis[0]->tecnicas_instrum;

        $newRequest->request->add([
            'objeto_estudio' => $objeto_estudio,
            'poblacion' => $poblacion,
            'muestra' => $muestra,
            'metodos' => $metodos,
            'tecnicas_instrumentos' => $tecnicas_instrum
        ]);

        /*Instrumentacion*/
        $instrumentacion = $tesis[0]->instrumentacion;

        /*Estrateg. metodologicas*/
        $estg_metodologicas = $tesis[0]->estg_metodologicas;

        /*Marco teorico*/
        $marco_teorico = $tesis[0]->marco_teorico;
        $marco_conceptual = $tesis[0]->marco_conceptual;
        $marco_legal = $tesis[0]->marco_legal;

        $newRequest->request->add([
            'instrumentacion' => $instrumentacion,
            'estrategias_metod' => $estg_metodologicas,
            'marco_teorico' => $marco_teorico,
            'marco_conceptual' => $marco_conceptual,
            'marco_legal' => $marco_legal
        ]);

        /* Referencias */
        $text_referencias = [];

        $referencias = referencias::where('cod_proyectotesis', '=', $tesis[0]->cod_proyectotesis)->latest('cod_referencias')->get();
        if ($referencias->count() != 0) {

            foreach ($referencias as $ref) {
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

            for ($i = 0; $i <= count($referencias) - 1; $i++) {
                if ($arregloRefTipo[$i] == 1) {
                    $newText = $arregloRefA[$i]."."."(".$arregloRefP[$i].").".$arregloTCap[$i].".".$arregloRefF[$i].",".$arregloRefT[$i]." (capitulo ".$arregloNC[$i].")".$arregloEd[$i].".";
                    array_push($text_referencias,$newText);
                }
                if ($arregloRefTipo[$i] == 2) {
                    $newText = $arregloRefA[$i] . "." . "(" . $arregloRefP[$i] . ")." . $arregloRefT[$i] . "." . $arregloRefF[$i] . "." . $arregloTRev[$i] . ",pp " . $arregloV[$i] . ".";
                    array_push($text_referencias,$newText);
                }
                if ($arregloRefTipo[$i] == 3) {
                    $newText =$arregloRefA[$i] . "." . "(" . $arregloRefP[$i] . ")." . $arregloRefT[$i] . "." . $arregloRefF[$i] . "." . $arregloNWeb[$i] . ".";
                    array_push($text_referencias,$newText);
                }
                if ($arregloRefTipo[$i] == 4) {
                    $newText =$arregloRefA[$i] . "." . "(" . $arregloRefP[$i] . ")." . $arregloRefT[$i] . "." . $arregloRefF[$i] . "." . $arregloNPe[$i] . ".";
                    array_push($text_referencias,$newText);
                }
                if ($arregloRefTipo[$i] == 5) {
                    $newText =$arregloRefA[$i] . "." . "(" . $arregloRefP[$i] . ")." . $arregloRefT[$i] . "." . $arregloRefF[$i] . "." . $arregloNIn[$i] . ".";
                    array_push($text_referencias,$newText);
                }
                if ($arregloRefTipo[$i] == 6) {
                    $newText =$arregloRefA[$i] . "." . "(" . $arregloRefP[$i] . ")." . $arregloRefT[$i] . ": " . $arregloRefF[$i] . "," . $arregloS[$i] . ", " . $arregloNEd[$i] . ".";
                    array_push($text_referencias,$newText);
                }
            }
        }

        $newRequest->request->add([
            'referencias' => $text_referencias
        ]);
        /* change to new method inside other controller */

        return (new PlantillaController)->descargaWordProyectoTesisUPAO($newRequest);

        /** */
    }
    //NEWWW-------
    // ASIGNACION PARA LOS GRUPOS DE INV-----------------------------------
    const PAGINATION5 = 10;
    public function showTablaAsignacionGrupos(Request $request)
    {

        $buscarAlumno = $request->buscarAlumno;
        $filtrarSemestre = $request->filtrar_semestre;
        $semestre = DB::table('configuraciones_iniciales as c_i')->select('c_i.*')->where('c_i.estado', 1)->orderBy('c_i.cod_config_ini', 'desc')->get();
        if (count($semestre) == 0) {
            return view('cursoTesis20221.director.asignarAsesorGrupos', ['studentforGroups' => [], 'asesores' => [],'semestre' =>  $semestre, 'buscarAlumno' => $buscarAlumno]);
        } else {
            $last_semestre = DB::table('configuraciones_iniciales as c_i')->select('c_i.*')->where('c_i.estado', 1)->orderBy('c_i.cod_config_ini', 'desc')->first();
            if ($buscarAlumno != "") {
                $semestreBuscar = $request->semestre;
                $filtrarSemestre = $semestreBuscar;
                if (is_numeric($buscarAlumno)) {
                    $grupo_estudiantes = DB::table('estudiante_semestre as e_s')
                        ->join('estudiante_ct2022 as e', 'e_s.cod_matricula', 'e.cod_matricula')
                        ->leftJoin('detalle_grupo_investigacion as d_g_i', 'd_g_i.cod_matricula', '=', 'e.cod_matricula')
                        ->leftJoin('grupo_investigacion as g_i', 'g_i.id_grupo', '=', 'd_g_i.id_grupo_inves')
                        ->select('e.*', 'g_i.cod_docente', 'g_i.num_grupo', 'g_i.id_grupo')
                        ->where('e_s.cod_config_ini', $semestreBuscar)
                        ->where('e.cod_matricula', 'like', '%' . $buscarAlumno . '%')->orderBy('e.apellidos')->get();

                } else {
                    $grupo_estudiantes = DB::table('estudiante_semestre as e_s')
                        ->join('estudiante_ct2022 as e', 'e_s.cod_matricula', 'e.cod_matricula')
                        ->leftJoin('detalle_grupo_investigacion as d_g_i', 'd_g_i.cod_matricula', '=', 'e.cod_matricula')
                        ->leftJoin('grupo_investigacion as g_i', 'g_i.id_grupo', '=', 'd_g_i.id_grupo_inves')
                        ->select('e.*', 'g_i.cod_docente', 'g_i.num_grupo', 'g_i.id_grupo')
                        ->where('e_s.cod_config_ini', $semestreBuscar)
                        ->where('e.apellidos', 'like', '%' . $buscarAlumno . '%')->orderBy('e.apellidos')->get();
                }
            } else {
                if ($filtrarSemestre != null) {
                    $grupo_estudiantes = DB::table('estudiante_semestre as e_s')
                    ->join('estudiante_ct2022 as e', 'e_s.cod_matricula', 'e.cod_matricula')
                    ->join('detalle_grupo_investigacion as d_g_i', 'd_g_i.cod_matricula', '=', 'e.cod_matricula')
                    ->join('grupo_investigacion as g_i', 'g_i.id_grupo', '=', 'd_g_i.id_grupo_inves')
                    ->select('e.*', 'g_i.cod_docente', 'g_i.num_grupo', 'g_i.id_grupo')
                    ->where('e_s.cod_config_ini', 'like', '%' . $filtrarSemestre . '%')->orderBy('g_i.num_grupo')->get();
                } else {
                    $grupo_estudiantes = DB::table('estudiante_semestre as e_s')
                    ->join('estudiante_ct2022 as e', 'e_s.cod_matricula', 'e.cod_matricula')
                    ->join('detalle_grupo_investigacion as d_g_i', 'd_g_i.cod_matricula', '=', 'e.cod_matricula')
                    ->join('grupo_investigacion as g_i', 'g_i.id_grupo', '=', 'd_g_i.id_grupo_inves')
                    ->select('e.*', 'g_i.cod_docente', 'g_i.num_grupo', 'g_i.id_grupo')
                    ->where('e_s.cod_config_ini', 'like', '%' . $last_semestre->cod_config_ini . '%')->orderBy('g_i.num_grupo')->get();
                }
            }
        }



        //Code
        $lastGroup = 0;
        $extraArray = [];
        $studentforGroups = [];
        $contador = 0;
        foreach ($grupo_estudiantes as $eachStudent) {
            if ($lastGroup == 0) {
                array_push($extraArray, $eachStudent);
                $lastGroup = $eachStudent->id_grupo;
            } else {
                if ($lastGroup == $eachStudent->id_grupo) {
                    array_push($extraArray, $eachStudent);
                } else {
                    array_push($studentforGroups, $extraArray);
                    $extraArray = [];
                    array_push($extraArray, $eachStudent);
                    $lastGroup = $eachStudent->id_grupo;
                }
            }
            $contador++;
            if ($contador == sizeof($grupo_estudiantes)) {
                array_push($studentforGroups, $extraArray);
            }
        }
        $studentforGroups = new Paginator($studentforGroups, $this::PAGINATION5);
        $asesores = DB::table('asesor_curso')->select('cod_docente', 'nombres', 'apellidos')->get();
        return view('cursoTesis20221.director.asignarAsesorGrupos', ['studentforGroups' => $studentforGroups, 'asesores' => $asesores, 'buscarAlumno' => $buscarAlumno, 'semestre' => $semestre, 'filtrarSemestre' => $filtrarSemestre]);
    }

    public function saveGrupoAsesorAsignado(Request $request)
    {
        $asesorAsignado = $request->saveAsesor;
        $posicion = explode(',', $asesorAsignado); //["2_0135"] -> "idGrupo_codDocente"
        $i = 0;
        do {
            if ($posicion[$i] != null) {
                $datos = explode('_', $posicion[$i]);
                $find_grupo = Grupo_Investigacion::find($datos[0]);
                if ($find_grupo != null) {
                    $proyectoTesis = TesisCT2022::where('id_grupo_inves', $find_grupo->id_grupo)->first();
                    if ($proyectoTesis == null) {
                        $proyectoTesis = new TesisCT2022();
                        $proyectoTesis->id_grupo_inves = $find_grupo->id_grupo;
                    }
                    $grupo = Grupo_Investigacion::find($datos[0]);
                    $grupo->cod_docente = $datos[1];
                    $grupo->save();
                    $proyectoTesis->cod_docente = $datos[1];
                    $proyectoTesis->save();
                    $proyectoTesis = TesisCT2022::where('id_grupo_inves', $find_grupo->id_grupo)->first();
                    $campo = new CamposEstudiante();
                    $campo->cod_proyectotesis = $proyectoTesis->cod_proyectotesis;
                    $campo->save();
                } else {
                    return redirect()->route('director.asignarAsesorGrupos')->with('datos', 'error');
                }
            }
            $i++;
        } while ($i < count($posicion));
        return redirect()->route('director.asignarAsesorGrupos')->with('datos', 'ok');
    }

    //-------------------------------------------------------------------------

    public function showAlumnosAsignados()
    {
        $estudiantes = DB::table('estudiante_ct2022 as e')->leftJoin('detalle_grupo_investigacion as dg', 'dg.cod_matricula', '=', 'e.cod_matricula')->join('grupo_investigacion as gi', 'gi.id_grupo', '=', 'dg.id_grupo_inves')->select('e.*', 'gi.cod_docente', 'gi.id_grupo', 'gi.num_grupo')->where('gi.cod_docente', '!=', null)->orderBy('gi.id_grupo')->get();

        //Code
        $lastGroup = 0;
        $extraArray = [];
        $studentforGroups = [];
        $contador = 0;
        foreach ($estudiantes as $each) {
            if ($lastGroup == 0) {
                array_push($extraArray, $each);
                $lastGroup = $each->id_grupo;
            } else {
                if ($lastGroup == $each->id_grupo) {
                    array_push($extraArray, $each);
                } else {
                    array_push($studentforGroups, $extraArray);
                    $extraArray = [];
                    array_push($extraArray, $each);
                    $lastGroup = $each->id_grupo;
                }
            }
            $contador++;
            if ($contador == sizeof($estudiantes)) {
                array_push($studentforGroups, $extraArray);
            }
        }
        $studentforGroups = new Paginator($studentforGroups, $this::PAGINATION5);

        $asesores = DB::table('asesor_curso')->get();
        return view('cursoTesis20221.director.editarAsignacion', ['estudiantes' => $estudiantes, 'asesores' => $asesores, 'studentforGroups' => $studentforGroups]);
    }

    public function saveEdicionAsignacion(Request $request)
    {
        $asesorAsig = $request->saveAsesor;
        $posicion = explode(',', $asesorAsig);
        try {
            $i = 0;
            do {
                if ($posicion[$i] != null) {
                    $datos = explode('_', $posicion[$i]);

                    $grupo = Grupo_Investigacion::where('id_grupo', $datos[0])->first();
                    if ($grupo == null) {
                        return redirect()->route('director.editarAsignacion')->with('datos', 'oknot');
                    }
                    $grupo->cod_docente = $datos[1];
                    $grupo->save();
                    $proyectoTesis = TesisCT2022::where('id_grupo_inves', $grupo->id_grupo)->first();
                    $proyectoTesis->cod_docente = $datos[1];
                    $proyectoTesis->save();
                }
                $i++;
            } while ($i < count($posicion));
        } catch (\Throwable $th) {
            dd($th);
            //return back()->with('datos','oknot');
        }
        return redirect()->route('director.editarAsignacion')->with('datos', 'ok');
    }

    public function showEstudiantes(Request $request)
    {
        $lastGroup = 0;
        $extraArray = [];
        $studentforGroups = [];
        $contador = 0;
        // $buscarAlumno = $request->buscarAlumno;
        // $filtrarSemestre = $request->filtrar_semestre;
        $asesor = AsesorCurso::where('username', auth()->user()->name)->get();
        // $semestre = DB::table('configuraciones_iniciales as c_i')->select('c_i.*')->where('c_i.estado', 1)->orderBy('c_i.cod_configuraciones', 'desc')->get();
        // if (count($semestre) == 0) {
        //     return view('cursoTesis20221.asesor.showEstudiantes', ['studentforGroups'=> [], 'semestre' => [], 'buscarAlumno' => $buscarAlumno]);
        // } else {
        //     $last_semestre = DB::table('configuraciones_iniciales as c_i')->select('c_i.*')->where('c_i.estado', 1)->orderBy('c_i.cod_configuraciones', 'desc')->first();
        //     if ($buscarAlumno != "") {
        //         $semestreBuscar = $request->semestre;
        //         $filtrarSemestre = $semestreBuscar;
        //         if (is_numeric($buscarAlumno)) {
        //             $estudiantes = DB::table('estudiante_ct2022')
        //             ->join('detalle_grupo_investigacion as d_g','d_g.cod_matricula','=','estudiante_ct2022.cod_matricula')
        //             ->join('grupo_investigacion as g_i', 'g_i.id_grupo','=','d_g.id_grupo_inves')
        //             ->join('proyecto_tesis','d_g.id_grupo_inves','=','proyecto_tesis.id_grupo_inves')
        //             ->select('g_i.id_grupo','g_i.num_grupo','estudiante_ct2022.*','proyecto_tesis.cod_docente','proyecto_tesis.estado','proyecto_tesis.cod_proyectotesis')
        //             ->where('proyecto_tesis.cod_docente',$asesor[0]->cod_docente)->get();
        //         }
        //     }
        // }
        $estudiantes = DB::table('estudiante_ct2022')
            ->join('detalle_grupo_investigacion as d_g', 'd_g.cod_matricula', '=', 'estudiante_ct2022.cod_matricula')
            ->join('grupo_investigacion as g_i', 'g_i.id_grupo', '=', 'd_g.id_grupo_inves')
            ->join('proyecto_tesis', 'd_g.id_grupo_inves', '=', 'proyecto_tesis.id_grupo_inves')
            ->select('g_i.id_grupo', 'g_i.num_grupo', 'estudiante_ct2022.*', 'proyecto_tesis.cod_docente', 'proyecto_tesis.estado', 'proyecto_tesis.cod_proyectotesis')
            ->where('proyecto_tesis.cod_docente', $asesor[0]->cod_docente)->get();


        foreach ($estudiantes as $eachStudent) {
            if ($lastGroup == 0) {
                array_push($extraArray, $eachStudent);
                $lastGroup = $eachStudent->id_grupo;
            } else {
                if ($lastGroup == $eachStudent->id_grupo) {
                    array_push($extraArray, $eachStudent);
                } else {
                    array_push($studentforGroups, $extraArray);
                    $extraArray = [];
                    array_push($extraArray, $eachStudent);
                    $lastGroup = $eachStudent->id_grupo;
                }
            }
            $contador++;
            if ($contador == count($estudiantes)) {
                array_push($studentforGroups, $extraArray);
            }
        }
        return view('cursoTesis20221.asesor.showEstudiantes', ['studentforGroups' => $studentforGroups]);
    }
    const PAGINATION2 = 10;
    public function listaAlumnos(Request $request)
    {
        $buscarAlumno = $request->buscarAlumno;
        $filtrarSemestre = $request->filtrar_semestre;
        $semestre = DB::table('configuraciones_iniciales as c_i')->select('c_i.*')->where('c_i.estado', 1)->orderBy('c_i.cod_config_ini', 'desc')->get();
        if (count($semestre) == 0) {
            return view('cursoTesis20221.director.listaAlumnos', ['estudiantes' => [], 'semestre' => [], 'buscarAlumno' => $buscarAlumno]);
        } else {
            $last_semestre = DB::table('configuraciones_iniciales as c_i')->select('c_i.*')->where('c_i.estado', 1)->orderBy('c_i.cod_config_ini', 'desc')->first();
            if ($buscarAlumno != "") {
                $semestreBuscar = $request->semestre;
                $filtrarSemestre = $semestreBuscar;
                if (is_numeric($buscarAlumno)) {
                    $estudiantes = DB::table('estudiante_semestre as e_s')
                        ->join('estudiante_ct2022 as e', 'e_s.cod_matricula', 'e.cod_matricula')
                        ->join('escuela as es', 'es.cod_escuela', 'e.cod_escuela')
                        ->select('e.*', 'es.nombre as nombreEscuela')
                        ->where('e_s.cod_config_ini', $semestreBuscar)
                        ->where('e.cod_matricula', 'like', '%' . $buscarAlumno . '%')->orderBy('e.apellidos')->paginate($this::PAGINATION2);
                } else {
                    $estudiantes = DB::table('estudiante_semestre as e_s')
                        ->join('estudiante_ct2022 as e', 'e_s.cod_matricula', 'e.cod_matricula')
                        ->join('escuela as es', 'es.cod_escuela', 'e.cod_escuela')
                        ->select('e.*', 'es.nombre as nombreEscuela')
                        ->where('e_s.cod_config_ini', $semestreBuscar)
                        ->where('e.apellidos', 'like', '%' . $buscarAlumno . '%')->orderBy('e.apellidos')->paginate($this::PAGINATION2);
                }
            } else {
                if ($filtrarSemestre != null) {
                    $estudiantes = DB::table('estudiante_semestre as e_s')
                        ->join('estudiante_ct2022 as e', 'e_s.cod_matricula', 'e.cod_matricula')
                        ->join('escuela as es', 'es.cod_escuela', 'e.cod_escuela')
                        ->select('e.*', 'es.nombre as nombreEscuela')
                        ->where('e_s.cod_config_ini', 'like', '%' . $filtrarSemestre . '%')->orderBy('e.apellidos', 'asc')->paginate($this::PAGINATION2);
                } else {
                    $estudiantes = DB::table('estudiante_semestre as e_s')
                        ->join('estudiante_ct2022 as e', 'e_s.cod_matricula', 'e.cod_matricula')
                        ->join('escuela as es', 'es.cod_escuela', 'e.cod_escuela')
                        ->select('e.*', 'es.nombre as nombreEscuela')
                        ->where('e_s.cod_config_ini', 'like', '%' . $last_semestre->cod_config_ini . '%')->orderBy('e.apellidos', 'asc')->paginate($this::PAGINATION2);
                }
            }
        }

        return view('cursoTesis20221.director.listaAlumnos', ['estudiantes' => $estudiantes, 'buscarAlumno' => $buscarAlumno, 'semestre' => $semestre, 'filtrarSemestre' => $filtrarSemestre]);
    }

    const PAGINATION4 = 10;
    public function listaAsesores(Request $request)
    {
        $buscarAsesor = $request->buscarAsesor;
        $filtrarSemestre = $request->filtrar_semestre;
        $semestre = DB::table('configuraciones_iniciales as c_i')->select('c_i.*')->where('c_i.estado', 1)->orderBy('c_i.cod_config_ini', 'desc')->get();
        if (count($semestre) == 0) {
            return view('cursoTesis20221.director.listaAsesores', ['asesores' => [], 'buscarAsesor' => $buscarAsesor, 'semestre' => []]);
        } else {
            $last_semestre = DB::table('configuraciones_iniciales as c_i')->select('c_i.*')->where('c_i.estado', 1)->orderBy('c_i.cod_config_ini', 'desc')->first();
            if ($buscarAsesor != "") {
                $semestreBuscar = $request->semestre;
                $filtrarSemestre = $semestreBuscar;
                if (is_numeric($buscarAsesor)) {
                    $asesores = DB::table('asesor_semestre as a_s')
                        ->join('asesor_curso as a', 'a_s.cod_docente', 'a.cod_docente')
                        ->leftJoin('grado_academico', 'grado_academico.cod_grado_academico', 'a.cod_grado_academico')
                        ->leftJoin('categoria_docente', 'categoria_docente.cod_categoria', 'a.cod_categoria')
                        ->select('a.*', 'grado_academico.descripcion as DescGrado', 'categoria_docente.descripcion as DescCat')
                        ->where('a_s.cod_config_ini', $semestreBuscar)
                        ->where('a.cod_docente', 'like', '%' . $buscarAsesor . '%')->orderBy('a.apellidos', 'asc')->paginate($this::PAGINATION2);
                } else {
                    $asesores = DB::table('asesor_semestre as a_s')
                        ->join('asesor_curso as a', 'a_s.cod_docente', 'a.cod_docente')
                        ->leftJoin('grado_academico', 'grado_academico.cod_grado_academico', 'a.cod_grado_academico')
                        ->leftJoin('categoria_docente', 'categoria_docente.cod_categoria', 'a.cod_categoria')
                        ->select('a.*', 'grado_academico.descripcion as DescGrado', 'categoria_docente.descripcion as DescCat')
                        ->where('a_s.cod_config_ini', $semestreBuscar)
                        ->where('a.apellidos', 'like', '%' . $buscarAsesor . '%')->orderBy('a.apellidos', 'asc')->paginate($this::PAGINATION2);
                }
            } else {

                if ($filtrarSemestre != null) {

                    $asesores = DB::table('asesor_semestre as a_s')
                        ->join('asesor_curso as a', 'a_s.cod_docente', 'a.cod_docente')
                        ->leftJoin('grado_academico', 'grado_academico.cod_grado_academico', 'a.cod_grado_academico')
                        ->leftJoin('categoria_docente', 'categoria_docente.cod_categoria', 'a.cod_categoria')
                        ->select('a.*', 'grado_academico.descripcion as DescGrado', 'categoria_docente.descripcion as DescCat')
                        ->where('a_s.cod_config_ini', 'like', '%' . $filtrarSemestre . '%')->orderBy('a.apellidos', 'asc')->paginate($this::PAGINATION2);
                } else {

                    $asesores = DB::table('asesor_semestre as a_s')
                        ->join('asesor_curso as a', 'a_s.cod_docente', 'a.cod_docente')
                        ->leftJoin('grado_academico', 'grado_academico.cod_grado_academico', 'a.cod_grado_academico')
                        ->leftJoin('categoria_docente', 'categoria_docente.cod_categoria', 'a.cod_categoria')
                        ->select('a.*', 'grado_academico.descripcion as DescGrado', 'categoria_docente.descripcion as DescCat')
                        ->where('a_s.cod_config_ini', 'like', '%' . $last_semestre->cod_config_ini . '%')->orderBy('a.apellidos', 'asc')->paginate($this::PAGINATION2);
                }
            }
        }

        return view('cursoTesis20221.director.listaAsesores', ['asesores' => $asesores, 'buscarAsesor' => $buscarAsesor, 'semestre' => $semestre, 'filtrarSemestre' => $filtrarSemestre]);
    }

    public function verAlumnoEditar(Request $request)
    {

        $alumno = DB::table('estudiante_ct2022')->select('estudiante_ct2022.*')->where('estudiante_ct2022.cod_matricula', '=', $request->auxid)->get();

        return view('cursoTesis20221.director.editarAlumno', ['alumno' => $alumno]);
    }

    public function verAsesorEditar(Request $request)
    {

        $asesor = DB::table('asesor_curso')->select('asesor_curso.*')->where('asesor_curso.cod_docente', '=', $request->auxid)->get();
        $grados_academicos = DB::table('grado_academico')->select('*')->get();
        $categorias = DB::table('categoria_docente')->select('*')->get();
        return view('cursoTesis20221.director.editarAsesor', ['asesor' => $asesor, 'grados_academicos' => $grados_academicos, 'categorias' => $categorias]);
    }

    public function editEstudiante(Request $request)
    {

        try {
            $alumno = EstudianteCT2022::find($request->cod_matricula);
            $alumno->dni = $request->dni;
            $alumno->apellidos = $request->apellidos;
            $alumno->nombres = $request->nombres;
            $alumno->correo = $request->correo;

            $alumno->save();

            return redirect()->route('director.listaAlumnos')->with('datos', 'ok');
        } catch (\Throwable $th) {
            return back()->with('datos', 'oknot');
        }
    }

    public function editAsesor(Request $request)
    {
        try {
            $asesor = AsesorCurso::find($request->cod_docente);
            $asesor->nombres = $request->nombres;
            $asesor->apellidos = $request->apellidos;
            $asesor->orcid = $request->orcid;
            $asesor->cod_grado_academico = $request->gradAcademico;
            $asesor->cod_categoria = $request->categoria;
            $asesor->direccion = $request->direccion;
            $asesor->correo = $request->correo;

            $asesor->save();

            return redirect()->route('director.listaAsesores')->with('datos', 'ok');
        } catch (\Throwable $th) {
            return redirect()->route('director.listaAsesores')->with('datos', 'oknot');
        }
    }

    public function deleteAlumno(Request $request)
    {
        try {
            $usuario = User::where('name', $request->auxidDelete . '-C')->first();
            $usuario->delete();
            $alumno = EstudianteCT2022::where('cod_matricula', $request->auxidDelete);
            $alumno->delete();

            return redirect()->route('director.listaAlumnos')->with('datos', 'okDelete');
        } catch (\Throwable $th) {
            return redirect()->route('director.listaAlumnos')->with('datos', 'okNotDelete');
        }
    }

    //GRUPOS DE INVESTIGACION
    //HOSTING
    public function verAgregarGruposInv(Request $request)
    {
        $filtrarSemestre = $request->filtrar_semestre;
        $semestre = DB::table('configuraciones_iniciales as c_i')->select('c_i.*')->where('c_i.estado', 1)->orderBy('c_i.cod_config_ini', 'desc')->get();
        if (count($semestre) == 0) {
            return view("cursoTesis20221.director.crearGruposDeInvestigacion", ['estudiantes' => [], 'studentforGroups' => [], 'semestre'=> []]);
        } else {
            $last_semestre = DB::table('configuraciones_iniciales as c_i')->select('c_i.*')->where('c_i.estado', 1)->orderBy('c_i.cod_config_ini', 'desc')->first();
            if ($filtrarSemestre != null) {
                $grupo_estudiantes = DB::table('estudiante_semestre as e_s')
                    ->join('estudiante_ct2022 as e','e.cod_matricula','e_s.cod_matricula')
                    ->join('detalle_grupo_investigacion as d_g_i', 'd_g_i.cod_matricula', '=', 'e.cod_matricula')
                    ->join('grupo_investigacion as g_i', 'g_i.id_grupo', '=', 'd_g_i.id_grupo_inves')
                    ->select('e.*', 'g_i.num_grupo', 'g_i.id_grupo')
                    ->where('e_s.cod_config_ini', 'like', '%' . $filtrarSemestre . '%')->orderBy('g_i.id_grupo')->get();

                $estudiantes = DB::table('estudiante_semestre as e_s')
                    ->join('estudiante_ct2022 as e','e.cod_matricula','e_s.cod_matricula')
                    ->leftJoin('detalle_grupo_investigacion as d_g_i', 'd_g_i.cod_matricula', '=', 'e.cod_matricula')
                    ->select('e.*')
                    ->where('d_g_i.id_detalle_grupo', null)
                    ->where('e_s.cod_config_ini', 'like', '%' . $filtrarSemestre . '%')
                    ->orderBy('apellidos', 'ASC')->get();
            } else {
                $grupo_estudiantes = DB::table('estudiante_semestre as e_s')
                    ->join('estudiante_ct2022 as e','e.cod_matricula','e_s.cod_matricula')
                    ->join('detalle_grupo_investigacion as d_g_i', 'd_g_i.cod_matricula', '=', 'e.cod_matricula')
                    ->join('grupo_investigacion as g_i', 'g_i.id_grupo', '=', 'd_g_i.id_grupo_inves')
                    ->select('e.*', 'g_i.num_grupo', 'g_i.id_grupo')
                    ->where('e_s.cod_config_ini', 'like', '%' . $last_semestre->cod_config_ini . '%')->orderBy('g_i.id_grupo')->get();

                $estudiantes = [];
            }
        }
        //dd($grupo_estudiantes);
        $lastGroup = 0;
        $extraArray = [];
        $studentforGroups = [];
        $contador = 0;
        foreach ($grupo_estudiantes as $eachStudent) {
            if ($lastGroup == 0) {
                array_push($extraArray, $eachStudent);
                $lastGroup = $eachStudent->id_grupo;
            } else {
                if ($lastGroup == $eachStudent->id_grupo) {
                    array_push($extraArray, $eachStudent);
                } else {
                    array_push($studentforGroups, $extraArray);
                    $extraArray = [];
                    array_push($extraArray, $eachStudent);
                    $lastGroup = $eachStudent->id_grupo;
                }
            }
            $contador++;
            if ($contador == sizeof($grupo_estudiantes)) {
                array_push($studentforGroups, $extraArray);
            }
        }
        $studentforGroups = new Paginator($studentforGroups, $this::PAGINATION5);


        return view("cursoTesis20221.director.crearGruposDeInvestigacion", ['estudiantes' => $estudiantes, 'studentforGroups' => $studentforGroups, 'semestre' => $semestre,'filtrarSemestre' => $filtrarSemestre]);
    }

    public function saveGruposInves(Request $request)
    {
        $arreglo_datos = $request->arreglo_grupos;
        try {
            if ($arreglo_datos != null) {
                $grupo = explode('_', $arreglo_datos);
                $nuevo_grupo_inv = new Grupo_Investigacion();
                $nuevo_grupo_inv->num_grupo = "" . $grupo[0];
                $nuevo_grupo_inv->save();
                //Obtenemos el recien registrado
                $groupAdded = Grupo_Investigacion::where('num_grupo', $grupo[0])->first();
                $groupAdded->num_grupo = "Grupo " . $groupAdded->id_grupo;
                $groupAdded->save();
                for ($i = 0; $i < sizeof($grupo); $i++) {
                    $detalle = new Detalle_Grupo_Investigacion();
                    $detalle->id_grupo_inves = $groupAdded->id_grupo;
                    $detalle->cod_matricula = $grupo[$i];
                    $detalle->save();
                }
            }
        } catch (\Throwable $th) {
            return redirect()->route('director.verGrupos')->with('datos', 'oknot');
        }

        return redirect()->route('director.verGrupos')->with('datos', 'ok');
    }

    public function asignarTemas(Request $request)
    {
        $id = $request->id_grupo_hidden;
        $tesis = TesisCT2022::where('id_grupo_inves', $id)->first();
        if ($tesis->estado != 2) {
            $tesis->estado = 2;
            $tesis->save();
        }
        $estudiante = DB::table('campos_estudiante as ce')
            ->join('proyecto_tesis as p', 'p.cod_proyectotesis', '=', 'ce.cod_proyectotesis')
            ->join('grupo_investigacion as g_i', 'g_i.id_grupo', '=', 'p.id_grupo_inves')
            ->select('ce.*', 'g_i.num_grupo', 'g_i.id_grupo')
            ->where('ce.cod_proyectotesis', $tesis->cod_proyectotesis)->get();

        $estudiantes_grupo = DB::table('estudiante_ct2022 as e')
            ->join('detalle_grupo_investigacion as d_g', 'd_g.cod_matricula', '=', 'e.cod_matricula')
            ->select('e.cod_matricula', 'e.nombres', 'e.apellidos')
            ->where('d_g.id_grupo_inves', $id)->get();
        return view('cursoTesis20221.asesor.camposEstudiante', ['estudiante' => $estudiante, 'estudiantes_grupo' => $estudiantes_grupo]);
    }

    public function guardarTemas(Request $request)
    {

        $tesis = TesisCT2022::where('id_grupo_inves', $request->id_grupoAux)->first();
        $temas = CamposEstudiante::where('cod_proyectotesis', $tesis->cod_proyectotesis)->first();
        if ($request->chkTInvestigacion != null) $temas->tipo_investigacion = 1;
        if ($request->chkLocalidad != null)      $temas->localidad_institucion = 1;
        if ($request->chkDuracion != null)       $temas->duracion_proyecto = 1;
        if ($request->chkRecursos != null)       $temas->recursos = 1;
        if ($request->chkPresupuesto != null)    $temas->presupuesto = 1;
        if ($request->chkFinanciamiento != null) $temas->financiamiento = 1;
        if ($request->chkRealProb != null)       $temas->rp_antecedente_justificacion = 1;
        if ($request->chkProblema != null)       $temas->formulacion_problema = 1;
        if ($request->chkObjetivos != null)      $temas->objetivos = 1;
        if ($request->chkMarcos != null)         $temas->marcos = 1;
        if ($request->chkHipotesis != null)      $temas->formulacion_hipotesis = 1;
        if ($request->chkDiseno != null)         $temas->diseño_investigacion = 1;
        if ($request->chkReferencias != null)    $temas->referencias_b = 1;

        $temas->save();
        return redirect()->route('asesor.showEstudiantes')->with('datos', 'ok');
    }

    public function revisarTemas(Request $request)
    {
        $cursoTesis = [];
        $campoCursoTesis = [];
        $aux = 0;
        $aux_campo = 0;
        $isFinal = 'false';
        $camposFull = 'false';
        $camposActivos = 'false';

        $id_grupo = $request->id_grupo;
        $cursoTesis = DB::table('proyecto_tesis as p')
            ->join('grupo_investigacion as g_i', 'g_i.id_grupo', '=', 'p.id_grupo_inves')
            ->join('asesor_curso as ac', 'ac.cod_docente', '=', 'p.cod_docente')
            ->leftJoin('grado_academico as ga', 'ac.cod_grado_academico', 'ga.cod_grado_academico')
            ->leftJoin('categoria_docente as cd', 'ac.cod_categoria', 'cd.cod_categoria')
            ->select('p.*', 'ac.nombres as nombre_asesor', 'ac.apellidos as apellidos_asesor', 'ac.estado as estadoAsesor', 'ac.direccion', 'ga.descripcion as DescGrado', 'cd.descripcion as DescCat')
            ->where('g_i.id_grupo', $id_grupo)->get();
        foreach ($cursoTesis as $item) {
                unset($item->marco_legal);
                unset($item->estg_metodologicas);
            }

        $estudiantes_grupo = DB::table('estudiante_ct2022 as e')
            ->join('detalle_grupo_investigacion as d_g', 'd_g.cod_matricula', '=', 'e.cod_matricula')
            ->select('e.cod_matricula', 'e.nombres', 'e.apellidos')
            ->where('d_g.id_grupo_inves', $id_grupo)->get();

        foreach ($cursoTesis[0] as $curso) {
            $arregloAux[$aux] = $curso;
            $aux++;
        }
        for ($i = 0; $i < sizeof($arregloAux) - 11; $i++) {
            if ($i == 20) {
                break;
            } else {
                if ($arregloAux[$i] != null) {
                    $isFinal = 'true';
                } else {
                    $isFinal = 'false';
                    break;
                }
            }
        }

        $observaciones = ObservacionesProy::join('historial_observaciones', 'observaciones_proy.cod_historialObs', '=', 'historial_observaciones.cod_historialObs')
            ->select('observaciones_proy.*')->where('historial_observaciones.cod_proyectotesis', $cursoTesis[0]->cod_proyectotesis)
            ->get();

        $campos = DB::table('campos_estudiante')->select('campos_estudiante.*')->where('cod_proyectotesis', $cursoTesis[0]->cod_proyectotesis)->get();
        // $campos = CamposEstudiante::where('cod_matricula',$cursoTesis[0]->cod_matricula)->get();
        $cronogramas = Cronograma::all();
        $cronogramas_py = Cronograma_Proyecto::where("cod_proyectotesis", $cursoTesis[0]->cod_proyectotesis)->get();
        $objetivos = DB::table('objetivo')->where('cod_proyectotesis', '=', $cursoTesis[0]->cod_proyectotesis)->get();

        $recursos = DB::table('recursos')->where('cod_proyectotesis', '=', $cursoTesis[0]->cod_proyectotesis)->get();
        $variableop = DB::table('variableop')->where('cod_proyectotesis', '=', $cursoTesis[0]->cod_proyectotesis)->get();
        $referencias = DB::table('referencias')->where('cod_proyectotesis', '=', $cursoTesis[0]->cod_proyectotesis)->get();

        foreach ($campos[0] as $camposC) {
            $campoCursoTesis[$aux_campo] = $camposC;
            $aux_campo++;
        }

        for ($i = 1; $i < sizeof($campoCursoTesis); $i++) {
            if ($campoCursoTesis[$i] != 0 && sizeof($recursos) > 0 && sizeof($objetivos) > 0 && sizeof($variableop) > 0 && sizeof($referencias) > 0) {
                $camposFull = 'true';
            } else {
                $camposFull = 'false';
                break;
            }
        }
        for ($i = 1; $i < sizeof($campoCursoTesis); $i++) {
            if ($campoCursoTesis[$i] != 0) {
                $camposActivos = 'true';
            } else {
                $camposActivos = 'false';
                break;
            }
        }
        $recursos = recursos::where('cod_proyectotesis', '=', $cursoTesis[0]->cod_proyectotesis)->get();
        $tipoinvestigacion = TipoInvestigacion::where('cod_tinvestigacion', '=', $cursoTesis[0]->cod_tinvestigacion)->get();
        $fin_persigue = Fin_Persigue::where('cod_fin_persigue', '=', $cursoTesis[0]->ti_finpersigue)->get();
        $diseno_investigacion = Diseno_Investigacion::where('cod_diseno_investigacion', '=', $cursoTesis[0]->ti_disinvestigacion)->get();
        $presupuesto = Presupuesto_Proyecto::join('presupuesto', 'presupuesto.cod_presupuesto', '=', 'presupuesto_proyecto.cod_presupuesto')
            ->select('presupuesto_proyecto.*', 'presupuesto.codeUniversal', 'presupuesto.denominacion')
            ->where('presupuesto_proyecto.cod_proyectotesis', '=', $cursoTesis[0]->cod_proyectotesis)->get();



        $matriz = MatrizOperacional::where('cod_proyectotesis', '=', $cursoTesis[0]->cod_proyectotesis)->get();


        return view('cursoTesis20221.asesor.progresoEstudiante', [
            'presupuesto' => $presupuesto,
            '$observaciones' => $observaciones, 'fin_persigue' => $fin_persigue, 'diseno_investigacion' => $diseno_investigacion, 'tipoinvestigacion' => $tipoinvestigacion,
            'recursos' => $recursos, 'objetivos' => $objetivos, 'variableop' => $variableop,
            'campos' => $campos, 'cursoTesis' => $cursoTesis, 'referencias' => $referencias, 'isFinal' => $isFinal,
            'camposFull' => $camposFull, 'matriz' => $matriz, 'estudiantes_grupo' => $estudiantes_grupo, 'cronogramas' => $cronogramas,
            'cronogramas_py' => $cronogramas_py,
            'camposActivos' => $camposActivos
        ]);
    }

    public function guardarSinObservaciones(Request $request)
    {
        try {
            $cursoTesis = DB::table('proyecto_tesis as p')
                ->join('grupo_investigacion as g_i', 'g_i.id_grupo', '=', 'p.id_grupo_inves')
                ->where('g_i.id_grupo', $request->id_grupo_hidden)->first();
            $tesis = TesisCT2022::find($cursoTesis->cod_proyectotesis);
            $tesis->estado = 2;
            $tesis->save();
            return redirect()->route('asesor.showEstudiantes')->with('datos', 'ok');
        } catch (\Throwable $th) {
            return redirect()->route('asesor.showEstudiantes')->with('datos', 'oknot');
        }
    }

    public function guardarObservaciones(Request $request)
    {


        try {
            $cursoTesis = DB::table('proyecto_tesis')
                ->join('detalle_grupo_investigacion as d_g', 'd_g.id_grupo_inves', '=', 'proyecto_tesis.id_grupo_inves')
                ->join('estudiante_ct2022', 'estudiante_ct2022.cod_matricula', '=', 'd_g.cod_matricula')
                ->join('asesor_curso', 'proyecto_tesis.cod_docente', '=', 'asesor_curso.cod_docente')
                ->select('proyecto_tesis.*', 'estudiante_ct2022.nombres as nombresAutor', 'estudiante_ct2022.apellidos as apellidosAutor', 'estudiante_ct2022.correo as correoEstudi', 'asesor_curso.nombres as nombresAsesor')->where('asesor_curso.username', '=', auth()->user()->name)->where('proyecto_tesis.id_grupo_inves', $request->id_grupo_hidden)->get();


            $existHisto = Historial_Observaciones::where('cod_proyectotesis', $cursoTesis[0]->cod_proyectotesis)->get();
            if ($existHisto->count() == 0) {
                $existHisto = new Historial_Observaciones();
                $existHisto->cod_proyectotesis = $cursoTesis[0]->cod_proyectotesis;
                $existHisto->fecha = now();
                $existHisto->estado = 1;
                $existHisto->save();
            }
            $existHisto = Historial_Observaciones::where('cod_proyectotesis', $cursoTesis[0]->cod_proyectotesis)->get();

            $tesis = TesisCT2022::find($cursoTesis[0]->cod_proyectotesis);

            $cantidadObservaciones = ObservacionesProy::where('cod_historialObs', $existHisto[0]->cod_historialObs)->get();
            $posicion_obs = sizeof($cantidadObservaciones) + 1;
            $num = 'Observacion #' . $posicion_obs;

            $observaciones = new ObservacionesProy();
            $observaciones->cod_historialObs = $existHisto[0]->cod_historialObs;
            $observaciones->observacionNum = $num;
            $observaciones->fecha = now();

            if ($request->tachkCorregir1 != "") {
                $observaciones->titulo = $request->tachkCorregir1;
                $arrayThemes[] = 'titulo';
            }

            if ($request->tachkCorregir23 != "") {
                $observaciones->linea_investigacion = $request->tachkCorregir23;
                $arrayThemes[] = 'linea_investigacion';
            }

            if ($request->tachkCorregir2 != "") {
                $observaciones->localidad_institucion = $request->tachkCorregir2;
                $arrayThemes[] = 'localidad_institucion';
            }
            if ($request->tachkCorregir3 != "") {
                $observaciones->meses_ejecucion = $request->tachkCorregir3;
                $arrayThemes[] = 'meses_ejecucion';
            }
            if ($request->tachkCorregir4 != "") {
                $observaciones->recursos = $request->tachkCorregir4;
                $arrayThemes[] = 'recursos';
            }
            if ($request->tachkCorregir5 != "") {
                $observaciones->real_problematica = $request->tachkCorregir5;
                $arrayThemes[] = 'real_problematica';
            }
            if ($request->tachkCorregir6 != "") {
                $observaciones->antecedentes = $request->tachkCorregir6;
                $arrayThemes[] = 'antecedentes';
            }
            if ($request->tachkCorregir7 != "") {
                $observaciones->justificacion = $request->tachkCorregir7;
                $arrayThemes[] = 'justificacion';
            }
            if ($request->tachkCorregir8 != "") {
                $observaciones->formulacion_prob = $request->tachkCorregir8;
                $arrayThemes[] = 'formulacion_prob';
            }
            if ($request->tachkCorregir9 != "") {
                $observaciones->objetivos = $request->tachkCorregir9;
                $arrayThemes[] = 'objetivos';
            }
            if ($request->tachkCorregir10 != "") {
                $observaciones->marco_teorico = $request->tachkCorregir10;
                $arrayThemes[] = 'marco_teorico';
            }
            if ($request->tachkCorregir11 != "") {
                $observaciones->marco_conceptual = $request->tachkCorregir11;
                $arrayThemes[] = 'marco_conceptual';
            }
            if ($request->tachkCorregir12 != "") {
                $observaciones->marco_legal = $request->tachkCorregir12;
                $arrayThemes[] = 'marco_legal';
            }
            if ($request->tachkCorregir13 != "") {
                $observaciones->form_hipotesis = $request->tachkCorregir13;
                $arrayThemes[] = 'form_hipotesis';
            }
            if ($request->tachkCorregir14 != "") {
                $observaciones->objeto_estudio = $request->tachkCorregir14;
                $arrayThemes[] = 'objeto_estudio';
            }
            if ($request->tachkCorregir15 != "") {
                $observaciones->poblacion = $request->tachkCorregir15;
                $arrayThemes[] = 'poblacion';
            }
            if ($request->tachkCorregir16 != "") {
                $observaciones->muestra = $request->tachkCorregir16;
                $arrayThemes[] = 'muestra';
            }
            if ($request->tachkCorregir17 != "") {
                $observaciones->metodos = $request->tachkCorregir17;
                $arrayThemes[] = 'metodos';
            }
            if ($request->tachkCorregir18 != "") {
                $observaciones->tecnicas_instrum = $request->tachkCorregir18;
                $arrayThemes[] = 'tecnicas_instrum';
            }
            if ($request->tachkCorregir19 != "") {
                $observaciones->instrumentacion = $request->tachkCorregir19;
                $arrayThemes[] = 'instrumentacion';
            }
            if ($request->tachkCorregir20 != "") {
                $observaciones->estg_metodologicas = $request->tachkCorregir20;
                $arrayThemes[] = 'estg_metodologicas';
            }
            if ($request->tachkCorregir21 != "") {
                $observaciones->variables = $request->tachkCorregir21;
                $arrayThemes[] = 'variables';
            }
            if ($request->tachkCorregir22 != "") {
                $observaciones->referencias = $request->tachkCorregir22;
                $arrayThemes[] = 'referencias';
            }
            if ($request->tachkCorregir24 != "") {
                $observaciones->matriz_op = $request->tachkCorregir24;
                $arrayThemes[] = 'matriz_op';
            }
            if ($request->tachkCorregir25 != "") {
                $observaciones->presupuesto_proy = $request->tachkCorregir25;
                $arrayThemes[] = 'presupuesto_proy';
            }
            if ($request->tachkCorregir26 != "") {
                $observaciones->diseno_contrastacion = $request->tachkCorregir26;
                $arrayThemes[] = 'diseno_contrastacion';
            }

            $observaciones->estado = 1;
            $observaciones->save();

            $tesis->estado = 2;
            $tesis->save();

            $latestCorrecion = ObservacionesProy::where('cod_historialObs', $existHisto[0]->cod_historialObs)->where('estado', 1)->get();
            for ($i = 0; $i < sizeof($arrayThemes); $i++) {
                $detalleObs = new Detalle_Observaciones();
                $detalleObs->cod_observaciones = $latestCorrecion[0]->cod_observaciones;
                $detalleObs->tema_referido = $arrayThemes[$i];
                $detalleObs->correccion = null;
                $detalleObs->save();
            }
            return redirect()->route('asesor.verObsEstudiante', $existHisto[0]->cod_historialObs)->with('datos', 'ok');
        } catch (\Throwable $th) {
            return redirect()->route('asesor.verObsEstudiante', $existHisto[0]->cod_historialObs)->with('datos', 'oknot');
        }
    }

    public function descargaObservacionCurso(Request $request)
    {

        /* CODIGO PARA GENERAR EL WORD DE LAS CORRECCIONES */
        $correccion = ObservacionesProy::where('cod_observaciones', '=', $request->cod_observaciones)->get();
        $tesis = TesisCT2022::join('historial_observaciones', 'proyecto_tesis.cod_proyectotesis', '=', 'historial_observaciones.cod_proyectotesis')->where('historial_observaciones.cod_historialObs', $correccion[0]->cod_historialObs)->first();

        $estudiantes_grupo = DB::table('estudiante_ct2022 as e')
            ->join('detalle_grupo_investigacion as d_g', 'd_g.cod_matricula', '=', 'e.cod_matricula')
            ->select('e.cod_matricula', 'e.nombres', 'e.apellidos')
            ->where('d_g.id_grupo_inves', $tesis->id_grupo_inves)->get();

        $asesor = AsesorCurso::find($tesis->cod_docente);
        $recursosProy = recursos::where('cod_proyectotesis', '=', $tesis->cod_proyectotesis)->get();
        $presupues = DB::table('presupuesto_proyecto')->join('presupuesto', 'presupuesto_proyecto.cod_presupuesto', '=', 'presupuesto.cod_presupuesto')
            ->select('precio', 'presupuesto.codeUniversal', 'presupuesto.denominacion')
            ->where('cod_proyectotesis', '=', $tesis->cod_proyectotesis)->latest('cod_presProyecto')->get();
        $objetivosProy = Objetivo::where('cod_proyectotesis', '=', $tesis->cod_proyectotesis)->get();
        $variableopProy = variableOP::where('cod_proyectotesis', '=', $tesis->cod_proyectotesis)->get();

        if (sizeof($correccion) == 1) {
            $cantObserva = 0;
        } elseif (sizeof($correccion) == 2) {
            $cantObserva = 1;
        } else {
            $cantObserva = 2;
        }

        $cod_matricula = $tesis->cod_matricula;
        if (count($estudiantes_grupo) > 1) {
            $estudiante1 = $estudiantes_grupo[0]->nombres . ' ' . $estudiantes_grupo[0]->apellidos;
            $estudiante2 = $estudiantes_grupo[1]->nombres . ' ' . $estudiantes_grupo[1]->apellidos;
        } else {
            $estudiante1 = $estudiantes_grupo[0]->nombres . ' ' . $estudiantes_grupo[0]->apellidos;
        }


        $escuelaEgresado = "Contabilidad y Finanzas";
        $nombreAsesor = $asesor->nombres;
        $numObservacion = $correccion[$cantObserva]->observacionNum;
        $fecha = $correccion[$cantObserva]->fecha;
        $titulo = $correccion[$cantObserva]->titulo;

        $linea = $correccion[$cantObserva]->linea_investigacion;

        $localidad_institucion = $correccion[$cantObserva]->localidad_institucion;
        $meses_ejecucion = $correccion[$cantObserva]->meses_ejecucion;

        $recursos = $correccion[$cantObserva]->recursos;
        $presupuesto_proy = $correccion[$cantObserva]->presupuesto_proy;
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
        $diseno_contrastacion = $correccion[$cantObserva]->diseno_contrastacion;
        $estg_metodologicas = $correccion[$cantObserva]->estg_metodologicas;


        $variables = $correccion[$cantObserva]->variables;
        $referencias = $correccion[$cantObserva]->referencias;
        $matriz_op = $correccion[$cantObserva]->matriz_op;

        Settings::setOutputEscapingEnabled(true);
        $word = new PhpWord();

        /* Creacion de las fuentes */

        $word->setDefaultFontName('Times New Roman');
        $word->setDefaultFontSize(11);

        $titulos = 'titulos';
        $word->addFontStyle($titulos, array('bold' => true, 'size' => 12));

        $styleFecha = 'styleFecha';
        $word->addParagraphStyle($styleFecha, array('align' => 'right'));

        $styleTitulos = 'styleTitulos';
        $word->addParagraphStyle($styleTitulos, array('align' => 'center'));


        $nuevaSesion = $word->addSection();

        $nuevaSesion->addText($fecha, $titulo, $styleFecha);
        $nuevaSesion->addText('OBSERVACIONES PROYECTO DE TESIS', $titulos, $styleTitulos);
        $nuevaSesion->addText($numObservacion, $titulo, $styleTitulos);

        $nuevaSesion->addText('Codigo Egresado: ' . $cod_matricula, $titulos, $styleFecha);
        if (count($estudiantes_grupo) > 1) {
            $nuevaSesion->addText('Egresados: ' . $estudiante1 . ' & ' . $estudiante2, $titulos, $styleFecha);
        } else {
            $nuevaSesion->addText('Egresados: ' . $estudiante1, $titulos, $styleFecha);
        }
        $nuevaSesion->addText('Escuela: ' . $escuelaEgresado, $titulos, $styleFecha);
        $nuevaSesion->addText('Asesor: ' . $nombreAsesor, $titulos, $styleFecha);

        $nuevaSesion->addTextBreak(2);

        if ($titulo != "") {

            $nuevaSesion->addText("TITULO", $titulos);
            $nuevaSesion->addText($tesis->titulo);
            $nuevaSesion->addText("Observacion: " . $titulo);
        }
        if ($linea != "") {

            $nuevaSesion->addText("LINEA DE INVESTIGACION", $titulos);
            $nuevaSesion->addText($tesis->linea_investigacion);
            $nuevaSesion->addText("Observacion: " . $linea);
        }
        if ($localidad_institucion != "") {
            $nuevaSesion->addText("LOCALIDAD E INSTITUCION", $titulos);
            $nuevaSesion->addText($tesis->localidad . ", " . $tesis->institucion);
            $nuevaSesion->addText("Observacion: " . $localidad_institucion);
        }
        if ($meses_ejecucion != "") {
            $nuevaSesion->addText("DURECION DE LA EJECUCION DEL PROYECTO", $titulos);
            $nuevaSesion->addText($tesis->meses_ejecucion);
            $nuevaSesion->addText("Observacion: " . $meses_ejecucion);
        }

        if ($recursos != "") {
            $nuevaSesion->addText("RECURSOS", $titulos);
            for ($i = 0; $i < count($recursosProy); $i++) {
                $nuevaSesion->addText("Tipo: " . $recursosProy[$i]->tipo . ", Subtipo: " . $recursosProy[$i]->subtipo . ", Descripcion: " . $recursosProy[$i]->descripcion);
            }
            $nuevaSesion->addText($recursos);
        }
        if ($presupuesto_proy != "") {
            $nuevaSesion->addText("PRESUPUESTO", $titulos);
            /* Presupuesto */
            $tableStyle = array(
                'borderSize' => 6,
                'cellMargin' => 50,
                'alignMent' => 'center'
            );

            $presupuestoTable = $nuevaSesion->addTable($tableStyle);

            $presupuestoTable->addRow(400);
            $presupuestoTable->addCell(2000)->addText("CODIGO", $titulos);
            $presupuestoTable->addCell(4000)->addText("DENOMINACION", $titulos);
            $presupuestoTable->addCell(1500)->addText("PRECIO TOTAL (S/.)", $titulos);
            $totalP = 0;
            if ($presupues->count() != 0) {
                for ($i = count($presupues) - 1; $i >= 0; $i--) {
                    $presupuestoTable->addRow(400);
                    $presupuestoTable->addCell(2000)->addText($presupues[$i]->codeUniversal, $titulos);
                    $presupuestoTable->addCell(4000)->addText($presupues[$i]->denominacion, $titulos);
                    $presupuestoTable->addCell(1500)->addText($presupues[$i]->precio . ".00", $titulos);
                    $totalP += floatval($presupues[$i]->precio);
                }
            }

            $presupuestoTable->addRow(400);
            $presupuestoTable->addCell(2000)->addText("", $titulos);
            $presupuestoTable->addCell(4000)->addText("TOTAL", $titulos);
            $presupuestoTable->addCell(1500)->addText($totalP . ".00", $titulos); //x

            $nuevaSesion->addText("Observacion: " . $presupuesto_proy);
        }
        if ($real_problematica != "") {
            $nuevaSesion->addText("REALIDAD PROBLEMATICA", $titulos);
            $nuevaSesion->addText($tesis->real_problematica);
            $nuevaSesion->addText("Observacion: " . $real_problematica);
        }

        if ($formulacion_prob != "") {
            $nuevaSesion->addText("ENUNCIADO DEL PROBLEMA", $titulos);
            $nuevaSesion->addText($tesis->formulacion_prob);
            $nuevaSesion->addText("Observacion: " . $formulacion_prob);
        }
        if ($justificacion != "") {
            $nuevaSesion->addText("JUSTIFICACION", $titulos);
            $nuevaSesion->addText($tesis->justificacion);
            $nuevaSesion->addText("Observacion: " . $justificacion);
        }

        if ($objetivos != "") {
            $nuevaSesion->addText("OBJETIVOS", $titulos);
            for ($i = 0; $i < count($objetivosProy); $i++) {
                $nuevaSesion->addText("Tipo: " . $objetivosProy[$i]->tipo . ", Descripcion: " . $objetivosProy[$i]->descripcion);
            }

            $nuevaSesion->addText("Observacion: " . $objetivos);
        }
        if ($antecedentes != "") {
            $nuevaSesion->addText("ANTECEDENTES", $titulos);
            $nuevaSesion->addText($tesis->antecedentes);
            $nuevaSesion->addText("Observacion: " . $antecedentes);
        }
        if ($marco_teorico != "") {
            $nuevaSesion->addText("MARCO TEORICO", $titulos);
            $nuevaSesion->addText($tesis->marco_teorico);
            $nuevaSesion->addText("Observacion: " . $marco_teorico);
        }
        if ($marco_conceptual != "") {
            $nuevaSesion->addText("MARCO CONCEPTUAL", $titulos);
            $nuevaSesion->addText($tesis->marco_conceptual);
            $nuevaSesion->addText("Observacion: " . $marco_conceptual);
        }
        // if ($marco_legal != "") {
        //     $nuevaSesion->addText("MARCO LEGAL", $titulos);
        //     $nuevaSesion->addText($tesis->marco_legal);
        //     $nuevaSesion->addText("Observacion: " . $marco_legal);
        // }
        if ($form_hipotesis != "") {
            $nuevaSesion->addText("HIPOTESIS", $titulos);
            $nuevaSesion->addText($tesis->form_hipotesis);
            $nuevaSesion->addText("Observacion: " . $form_hipotesis);
        }
        if ($variables != "") {
            $nuevaSesion->addText("VARIABLES", $titulos);
            for ($i = 0; $i < count($variableopProy); $i++) {
                $nuevaSesion->addText("Descripcion: " . $variableopProy[$i]->descripcion);
            }
            $nuevaSesion->addText("Observacion: " . $variables);
        }
        if ($matriz_op != "") {
            $nuevaSesion->addText("MATRIZ OPERACIONAL", $titulos);
            $nuevaSesion->addText("Observacion: " . $matriz_op);
        }
        if ($objeto_estudio != "") {
            $nuevaSesion->addText("MATERIAL", $titulos);
            $nuevaSesion->addText($tesis->objeto_estudio);
            $nuevaSesion->addText("Observacion: " . $objeto_estudio);
        }
        if ($poblacion != "") {
            $nuevaSesion->addText("POBLACION", $titulos);
            $nuevaSesion->addText($tesis->poblacion);
            $nuevaSesion->addText("Observacion: " . $poblacion);
        }
        if ($muestra != "") {
            $nuevaSesion->addText("MUESTRA", $titulos);
            $nuevaSesion->addText($tesis->muestra);
            $nuevaSesion->addText("Observacion: " . $muestra);
        }
        if ($metodos != "") {
            $nuevaSesion->addText("METODOS", $titulos);
            $nuevaSesion->addText($tesis->metodos);
            $nuevaSesion->addText("Observacion: " . $metodos);
        }

        if ($diseno_contrastacion != "") {
            $nuevaSesion->addText("DISEÑO DE CONTRASTACION", $titulos);
            $nuevaSesion->addText($tesis->diseno_contrastacion);
            $nuevaSesion->addText("Observacion: " . $diseno_contrastacion);
        }
        if ($tecnicas_instrum != "") {
            $nuevaSesion->addText("TECNICAS E INTRUMENTOS DE RECOLECCION DE DATOS", $titulos);
            $nuevaSesion->addText($tesis->tecnicas_instrum);
            $nuevaSesion->addText("Observacion: " . $tecnicas_instrum);
        }
        if ($instrumentacion != "") {
            $nuevaSesion->addText("PROCESAMIENTO Y ANALISIS DE DATOS", $titulos);
            $nuevaSesion->addText($tesis->instrumentacion);
            $nuevaSesion->addText("Observacion: " . $instrumentacion);
        }
        // if ($estg_metodologicas != "") {
        //     $nuevaSesion->addText("ESTRATEGIAS METODOLOGICAS", $titulos);
        //     $nuevaSesion->addText($tesis->estg_metodologicas);
        //     $nuevaSesion->addText("Observacion: " . $estg_metodologicas);
        // }

        if ($referencias != "") {
            $nuevaSesion->addText("REFERENCIAS", $titulos);
            $nuevaSesion->addText("Observacion: " . $referencias);
        }



        $objetoEscrito = \PhpOffice\PhpWord\IOFactory::createWriter($word, 'Word2007');
        try {
            $objetoEscrito->save(storage_path('Observaciones.docx'));
        } catch (\Throwable $th) {
            $th;
        }

        return response()->download(storage_path('Observaciones.docx'));
    }

    public function aprobarProy(Request $request)
    {
        try {
            $proyecto = TesisCT2022::find($request->textcod);
            $codHistObserva = Historial_Observaciones::where('cod_proyectotesis', $request->textcod)->first();
            $proyecto->condicion = 'APROBADO';
            $proyecto->estado = 3;

            $proyecto->save();
            $this->copyProyectoToTesis($proyecto->cod_proyectotesis);
            if ($codHistObserva != null) {
                return redirect()->route('asesor.verObsEstudiante', $codHistObserva->cod_historialObs)->with('datos', 'okAprobado');
            } else {
                return redirect()->route('asesor.showEstudiantes')->with('datos', 'okAprobado');
            }
        } catch (\Throwable $th) {
            return redirect()->route('asesor.revisarTemas')->with('datos', 'okNotAprobado');
        }
    }
    public function desaprobarProy(Request $request)
    {
        try {
            $proyecto = TesisCT2022::find($request->textcod);
            $codHistObserva = Historial_Observaciones::where('cod_proyectotesis', $request->textcod)->first();
            $proyecto->condicion = 'DESAPROBADO';
            $proyecto->estado = 4;
            $proyecto->save();
            if ($codHistObserva != null) {
                return redirect()->route('asesor.verObsEstudiante', $codHistObserva->cod_historialObs)->with('datos', 'okDesaprobado');
            } else {
                return redirect()->route('asesor.showEstudiantes')->with('datos', 'okDesaprobado');
            }
        } catch (\Throwable $th) {
            return redirect()->route('asesor.revisarTemas')->with('datos', 'okNotDesAprobado');
        }
    }

    // He cambiado lo de tesis a Tesis2022 Controller.

    public function copyProyectoToTesis($id)
    {
        try {
            $proyecto = TesisCT2022::find($id);
            $tesis = Tesis_2022::where('id_grupo_inves', '=', $proyecto->id_grupo_inves)->first();
            if ($tesis == null) {
                $tesis = new Tesis_2022();
            }
            $tesis->titulo = $proyecto->titulo;
            $tesis->id_grupo_inves = $proyecto->id_grupo_inves;
            $tesis->cod_docente = null;
            $tesis->real_problematica = $proyecto->real_problematica;
            $tesis->antecedentes = $proyecto->antecedentes;
            $tesis->justificacion = $proyecto->justificacion;
            $tesis->formulacion_prob = $proyecto->formulacion_prob;
            $tesis->marco_teorico = $proyecto->marco_teorico;
            $tesis->marco_conceptual = $proyecto->marco_conceptual;
            $tesis->marco_legal = $proyecto->marco_legal;
            $tesis->form_hipotesis = $proyecto->form_hipotesis;
            $tesis->poblacion = $proyecto->poblacion;
            $tesis->muestra = $proyecto->muestra;
            $tesis->metodos = $proyecto->metodos;
            $tesis->tecnicas_instrum = $proyecto->tecnicas_instrum;
            $tesis->instrumentacion = $proyecto->instrumentacion;
            $tesis->estg_metodologicas = $proyecto->estg_metodologicas;
            $tesis->save();
        } catch (\Throwable $th) {
            dd($th);
        }
    }
}
