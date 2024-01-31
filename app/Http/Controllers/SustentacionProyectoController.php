<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AsesorCurso;
use App\Models\CamposEstudiante;
use App\Models\Cronograma;
use App\Models\Cronograma_Proyecto;
use App\Models\Designacion_Jurado;
use App\Models\DesignacionJuradoProyecto;
use App\Models\Detalle_Observaciones;
use App\Models\DetalleObsSustentacionProy;
use App\Models\Diseno_Investigacion;
use App\Models\EstudianteCT2022;
use App\Models\Fin_Persigue;
use App\Models\Historial_Observaciones;
use App\Models\Jurado;
use App\Models\MatrizOperacional;
use App\Models\Objetivo;
use App\Models\ObservacionesProy;
use App\Models\ObservacionSustentacionProyecto;
use App\Models\Presupuesto;
use App\Models\Presupuesto_Proyecto;
use App\Models\recursos;
use App\Models\referencias;
use App\Models\ResultadoJuradoProyecto;
use App\Models\TesisCT2022;
use App\Models\TipoInvestigacion;
use App\Models\TipoReferencia;
use App\Models\variableOP;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class SustentacionProyectoController extends Controller
{
    /* ADMIN / DIRECTOR*/
    public function lista_proyectos_aprobados(Request $request)
    {

        $proyectos_aprobados = DB::table('proyecto_tesis as pt')
            ->join('detalle_grupo_investigacion as d_g', 'pt.id_grupo_inves', '=', 'd_g.id_grupo_inves')
            ->join('estudiante_ct2022 as e', 'd_g.cod_matricula', '=', 'e.cod_matricula')
            ->join('asesor_curso as a', 'pt.cod_docente', '=', 'a.cod_docente')
            ->leftJoin('designacion_jurado_proyecto as dj', 'pt.cod_proyectotesis', 'dj.cod_proyectotesis')
            ->select('pt.cod_proyectotesis', 'pt.titulo', 'e.cod_matricula', 'e.nombres as nombresAutor', 'e.apellidos as apellidosAutor', 'a.cod_docente', 'a.nombres as nombresAsesor', 'a.apellidos as apellidosAsesor', 'dj.cod_jurado1', 'dj.cod_jurado2', 'dj.cod_jurado3', 'dj.cod_jurado4')
            ->where('pt.estado', 3)->where('pt.condicion', "APROBADO")->get();

        // Agrupar por cod_tesis

        $proyectosAgrupados = $proyectos_aprobados->groupBy('cod_proyectotesis')->map(function ($grupo) {
            // Combina múltiples autores en una sola tesis
            $primerItem = $grupo->first();
            $autor = [
                'cod_proyectotesis' => $primerItem->cod_proyectotesis,
                'titulo' => $primerItem->titulo,
                'autores' => $grupo->map(function ($item) {
                    return [
                        'nombresAutor' => $item->nombresAutor,
                        'apellidosAutor' => $item->apellidosAutor,
                        'cod_matricula' => $item->cod_matricula
                    ];
                })->toArray(),
                'cod_docente' => $primerItem->cod_docente,
                'nombresAsesor' => $primerItem->nombresAsesor,
                'apellidosAsesor' => $primerItem->apellidosAsesor,
                'cod_jurado1' => $primerItem->cod_jurado1,
                'cod_jurado2' => $primerItem->cod_jurado2,
                'cod_jurado3' => $primerItem->cod_jurado3,
                'cod_jurado4' => $primerItem->cod_jurado4,
            ];
            $asesores = DB::table('jurado as j')->leftJoin('asesor_curso as ac', 'j.cod_docente', '=', 'ac.cod_docente')->select('ac.nombres', 'ac.apellidos', 'j.cod_docente')
                ->where('j.cod_docente', '!=', $primerItem->cod_docente)->get();
            return [$autor, $asesores];
        })->values();


        return view('cursoTesis20221.director.evaluacion.asignacionJuradoProyecto', ['proyectosAgrupados' => $proyectosAgrupados]);
    }

    public function saveAsignacionJuradoProyecto(Request $request)
    {
        try {
            $datos = explode(',', $request->saveJurados);
            for ($i = 0; $i < count($datos); $i++) {
                if ($datos[$i] != null) {
                    $jurados = explode('_', $datos[$i]);
                    $new_asignacion = new DesignacionJuradoProyecto();
                    $new_asignacion->cod_proyectotesis = $jurados[0];
                    $new_asignacion->cod_jurado1 = $jurados[1];
                    $new_asignacion->cod_jurado2 = $jurados[2];
                    $new_asignacion->cod_jurado3 = $jurados[3];
                    $new_asignacion->cod_jurado4 = $jurados[4];
                    $new_asignacion->save();
                    $existHisto = Historial_Observaciones::where('cod_proyectotesis', $jurados[0])->where('sustentacion', true)->where('estado', 1)->get();
                    if ($existHisto->count() == 0) {
                        $existHisto = new Historial_Observaciones();
                        $existHisto->cod_proyectotesis = $jurados[0];
                        $existHisto->fecha = now();
                        $existHisto->sustentacion = true;
                        $existHisto->estado = 1;
                        $existHisto->save();
                    }
                }
            }
            return redirect()->route('director.listaProyectosAprobados')->with('datos', 'okdesignacion');
        } catch (\Throwable $th) {
            dd($th);
            return redirect()->route('director.listaProyectosAprobados')->with('datos', 'oknotdesignacion');
        }
    }
    /* JURADO */
    public function listaProyectosAsignados($showObservacion = null)
    {
        try {
            $lastGroup = 0;
            $extraArray = [];
            $studentforGroups = [];
            $contador = 0;
            $asesor = DB::table('asesor_curso')->select('asesor_curso.cod_docente')->where('asesor_curso.username', auth()->user()->name)->first();
            $jurado = Jurado::where('cod_docente', $asesor->cod_docente)->first();
            $lista_tesis = DB::table('designacion_jurado_proyecto as dj')->join('proyecto_tesis as pt', 'dj.cod_proyectotesis', 'pt.cod_proyectotesis')
                ->join('grupo_investigacion as gi', 'pt.id_grupo_inves', 'gi.id_grupo')
                ->join('detalle_grupo_investigacion as d_g_i', 'gi.id_grupo', 'd_g_i.id_grupo_inves')
                ->join('estudiante_ct2022 as es', 'd_g_i.cod_matricula', 'es.cod_matricula')
                ->join('asesor_curso as ac', 'pt.cod_docente', 'ac.cod_docente')
                ->join('historial_observaciones as ho', function ($join) {
                    $join->on('pt.cod_proyectotesis', '=', 'ho.cod_proyectotesis')
                        ->where('ho.sustentacion', true);
                })
                ->leftJoin('observacion_sustentacionproy as os', function ($join) use ($jurado) {
                    $join->on('ho.cod_historialObs', '=', 'os.cod_historialObs')
                        ->where('os.cod_jurado', $jurado->cod_jurado)
                        ->where('os.estado', 1);
                })
                ->leftJoin('resultado_jurado_proyecto as rj', function ($join) use ($jurado) {
                    $join->on('dj.cod_designacion_proyecto', '=', 'rj.cod_designacion_proyecto')
                        ->where('rj.cod_jurado', $jurado->cod_jurado);
                })
                ->select('gi.id_grupo', 'gi.num_grupo', 'd_g_i.cod_matricula', 'pt.cod_proyectotesis', 'pt.titulo', 'ac.nombres as nombresAsesor', 'ac.apellidos as apellidosAsesor', 'es.nombres as nombresAutor', 'es.apellidos as apellidosAutor', 'dj.cod_jurado1', 'dj.cod_jurado2', 'dj.cod_jurado3', 'dj.cod_jurado4', 'pt.estado', 'dj.estado as estadoDesignacion', DB::raw('count(os.cod_observacion) as numObs'), 'rj.estado as estadoResultado')
                ->where('dj.cod_jurado1', $asesor->cod_docente)
                ->orWhere('dj.cod_jurado2', $asesor->cod_docente)
                ->orWhere('dj.cod_jurado3', $asesor->cod_docente)
                ->groupBy('gi.id_grupo', 'gi.num_grupo', 'd_g_i.cod_matricula', 'pt.cod_proyectotesis', 'pt.titulo', 'ac.nombres', 'ac.apellidos', 'es.nombres', 'es.apellidos', 'dj.cod_jurado1', 'dj.cod_jurado2', 'dj.cod_jurado3', 'dj.cod_jurado4', 'pt.estado', 'dj.estado', 'rj.estado')
                ->get();

            $observaciones = null;
            if ($showObservacion != null) {
                $observaciones = ObservacionSustentacionProyecto::join('historial_observaciones as ho', 'observacion_sustentacionproy.cod_historialObs', 'ho.cod_historialObs')->join('jurado as j', 'observacion_sustentacionproy.cod_jurado', 'j.cod_jurado')->join('asesor_curso as ac', 'j.cod_docente', 'ac.cod_docente')->where('ho.cod_proyectotesis', $showObservacion)->where('ho.sustentacion', true)->select('observacion_sustentacionproy.*', 'ho.fecha as fechaHistorial', 'ac.nombres as nombresJurado', 'ac.apellidos as apellidosJurado')->orderBy('observacion_sustentacionproy.created_at', 'ASC')->get();
            }

            foreach ($lista_tesis as $tesis) {
                if ($lastGroup == 0) {
                    array_push($extraArray, $tesis);
                    $lastGroup = $tesis->id_grupo;
                } else {
                    if ($lastGroup == $tesis->id_grupo) {
                        array_push($extraArray, $tesis);
                    } else {
                        array_push($studentforGroups, $extraArray);
                        $extraArray = [];
                        array_push($extraArray, $tesis);
                        $lastGroup = $tesis->id_grupo;
                    }
                }
                $contador++;
                if ($contador == count($lista_tesis)) {
                    array_push($studentforGroups, $extraArray);
                }
            }
            return view('cursoTesis20221.asesor.evaluacion.listaProyectosAsignados', ['studentforGroups' => $studentforGroups, 'asesor' => $asesor, 'observaciones' => $observaciones]);
        } catch (\Throwable $th) {
            dd($th);
            return;
        }
    }

    public function evaluarProyectoTesis(Request $request)
    {
        $cursoTesis = [];
        $campoCursoTesis = [];
        $aux = 0;
        $aux_campo = 0;
        $isFinal = 'false';
        $camposFull = 'false';
        $camposActivos = 'false';

        $id_grupo = $request->id_grupo;
        $cod_proyectotesis = $request->cod_proyectotesis;
        $jurado = Jurado::join('asesor_curso as ac', 'jurado.cod_docente', 'ac.cod_docente')->select('jurado.*')->where('ac.username', auth()->user()->name)->first();
        $cursoTesis = DB::table('proyecto_tesis as p')
            ->join('grupo_investigacion as g_i', 'g_i.id_grupo', '=', 'p.id_grupo_inves')
            ->join('asesor_curso as ac', 'ac.cod_docente', '=', 'p.cod_docente')
            ->join('designacion_jurado_proyecto as dj', 'p.cod_proyectotesis', 'dj.cod_proyectotesis')
            ->leftJoin('grado_academico as ga', 'ac.cod_grado_academico', 'ga.cod_grado_academico')
            ->leftJoin('categoria_docente as cd', 'ac.cod_categoria', 'cd.cod_categoria')
            ->select('p.*', 'ac.nombres as nombre_asesor', 'ac.apellidos as apellidos_asesor', 'ac.estado as estadoAsesor', 'ac.direccion', 'ga.descripcion as DescGrado', 'cd.descripcion as DescCat', 'dj.estado as estadoDesignacion', 'dj.cod_designacion_proyecto')
            ->where('p.cod_proyectotesis', $cod_proyectotesis)
            ->get();
        $verifyObs = DB::table('historial_observaciones as ho')
            ->leftJoin('observacion_sustentacionproy as os', function ($join) use ($jurado) {
                $join->on('ho.cod_historialObs', '=', 'os.cod_historialObs')
                    ->where('os.cod_jurado', $jurado->cod_jurado)
                    ->where('os.estado', 1);
            })
            ->select('ho.cod_proyectotesis', 'ho.estado as estadoHistorial', DB::raw('count(os.cod_observacion) as numObs'))
            ->where('ho.cod_proyectotesis', $cod_proyectotesis)
            ->where('ho.sustentacion', true)
            ->groupBy('ho.cod_proyectotesis', 'ho.estado')
            ->first();
        //dd($verifyObs);
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
        $resultado = ResultadoJuradoProyecto::where('cod_designacion_proyecto', $cursoTesis[0]->cod_designacion_proyecto)->where('cod_jurado', $jurado->cod_jurado)->get();

        return view('cursoTesis20221.asesor.evaluacion.evaluarProyectoTesis', [
            'presupuesto' => $presupuesto, 'fin_persigue' => $fin_persigue, 'diseno_investigacion' => $diseno_investigacion, 'tipoinvestigacion' => $tipoinvestigacion,
            'recursos' => $recursos, 'objetivos' => $objetivos, 'variableop' => $variableop,
            'campos' => $campos, 'cursoTesis' => $cursoTesis, 'referencias' => $referencias, 'isFinal' => $isFinal,
            'camposFull' => $camposFull, 'matriz' => $matriz, 'estudiantes_grupo' => $estudiantes_grupo, 'cronogramas' => $cronogramas,
            'cronogramas_py' => $cronogramas_py,
            'camposActivos' => $camposActivos,
            'verifyObs' => $verifyObs,
            'resultado' => $resultado
        ]);
    }

    public function guardarObservacionProyecto(Request $request)
    {
        try {
            $jurado = Jurado::join('asesor_curso as ac', 'jurado.cod_docente', 'ac.cod_docente')->where('ac.username', auth()->user()->name)->first();

            $designacion = DesignacionJuradoProyecto::where('cod_proyectotesis', $request->cod_proyectotesis)->first();

            $existHisto = Historial_Observaciones::where('cod_proyectotesis', $request->cod_proyectotesis)->where('sustentacion', true)->where('estado', 1)->get();
            if ($existHisto->count() == 0) {
                $existHisto = new Historial_Observaciones();
                $existHisto->cod_proyectotesis = $request->cod_proyectotesis;
                $existHisto->fecha = now();
                $existHisto->sustentacion = true;
                $existHisto->estado = 1;
                $existHisto->save();
            }
            $existHisto = Historial_Observaciones::where('cod_proyectotesis', $request->cod_proyectotesis)->where('sustentacion', true)->where('estado', 1)->get();

            $observaciones = new ObservacionSustentacionProyecto();
            $observaciones->cod_historialObs = $existHisto[0]->cod_historialObs;
            $observaciones->cod_jurado = $jurado->cod_jurado;
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

            $observaciones->estado = 1;
            $observaciones->save();

            $findObs = ObservacionSustentacionProyecto::where('cod_historialObs', $existHisto[0]->cod_historialObs)->where('estado', 1)->get();
            if (sizeof($findObs) >= 3) {
                $existHisto[0]->estado = 2;
                $existHisto[0]->save();
                $designacion->estado = 2;
                $designacion->save();
            }

            $latestCorrecion = ObservacionSustentacionProyecto::where('cod_historialObs', $existHisto[0]->cod_historialObs)->where('cod_jurado', $jurado->cod_jurado)->where('estado', 1)->get();
            $exisDetalle = DetalleObsSustentacionProy::join('observacion_sustentacionproy as os', 'detalle_obs_sustentacionproy.cod_observacion', 'os.cod_observacion')->join('historial_observaciones as ho', 'os.cod_historialObs', 'ho.cod_historialObs')->select('detalle_obs_sustentacionproy.cod_detalleObs', 'detalle_obs_sustentacionproy.tema_referido')->where('ho.cod_historialObs', $existHisto[0]->cod_historialObs)->get();
            //dd($exisDetalle);
            for ($i = 0; $i < sizeof($arrayThemes); $i++) {
                $exist = false;
                foreach ($exisDetalle as $edetalle) {
                    if ($edetalle->tema_referido == $arrayThemes[$i]) {
                        $exist = true;
                    }
                }
                if (!$exist) {
                    $detalleObs = new DetalleObsSustentacionProy();
                    $detalleObs->cod_observacion = $latestCorrecion[0]->cod_observacion;
                    $detalleObs->tema_referido = $arrayThemes[$i];
                    $detalleObs->correccion = null;
                    $detalleObs->estado = 1;
                    $detalleObs->save();
                }
            }
            return redirect()->route('jurado.listaProyectosAsignados')->with('datos', 'okobservacion');
        } catch (\Throwable $th) {
            dd($th);
            //return redirect()->route('jurado.listaProyectosAsignados')->with('datos', 'oknotobservacion');
        }
    }

    public function aprobarProyectoTesis(Request $request)
    {
        try {
            $jurado = Jurado::join('asesor_curso as ac', 'jurado.cod_docente', 'ac.cod_docente')->where('ac.username', auth()->user()->name)->first();
            $designacion = DesignacionJuradoProyecto::where('cod_proyectotesis', $request->cod_proyectotesis)->first();
            $resultadoHistorial = ResultadoJuradoProyecto::where('cod_designacion_proyecto', $designacion->cod_designacion_proyecto)->get();
            $newResultado = new ResultadoJuradoProyecto();
            $newResultado->cod_designacion_proyecto = $designacion->cod_designacion_proyecto;
            $newResultado->cod_jurado = $jurado->cod_jurado;
            $newResultado->estado = $request->stateAprobation;
            $newResultado->save();
            if (sizeof($resultadoHistorial) >= 2) {
                $resultadoHistorial = ResultadoJuradoProyecto::where('cod_designacion_proyecto', $designacion->cod_designacion_proyecto)->where('estado', 1)->get();
                $designacion->estado = (sizeof($resultadoHistorial) >= 3) ? 3 : 4;
                $designacion->save();
            }

            return redirect()->route('jurado.listaProyectosAsignados')->with('datos', 'okAprobadoProyecto');
        } catch (\Throwable $th) {
            dd($th);
            return redirect()->route('jurado.listaProyectosAsignados')->with('datos', 'oknotAprobadoProyecto');
        }
    }


    /* ESTUDIANTE */

    public function viewEvaluacionProyecto()
    {
        try {

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
                return view('cursoTesis20221.cursoTesis', ['autor' => $autor, 'tesis' => []]);
            }
            $coautor = DB::table('detalle_grupo_investigacion as dg')->rightJoin('estudiante_ct2022 as e', 'e.cod_matricula', '=', 'dg.cod_matricula')->select('e.*')->where('dg.id_grupo_inves', $autor->id_grupo)->where('e.cod_matricula', '!=', $id)->first();

            $tesis = TesisCT2022::where('id_grupo_inves', '=', $autor->id_grupo)->join('designacion_jurado_proyecto as dj', 'proyecto_tesis.cod_proyectotesis', 'dj.cod_proyectotesis')->select('proyecto_tesis.*', 'dj.estado as estadoDesignacion', 'dj.cod_jurado1', 'dj.cod_jurado2', 'dj.cod_jurado3')->get(); //Encontramos la tesis
            /*Encontramos los jurados */
            $jurados = AsesorCurso::where('cod_docente', $tesis[0]->cod_jurado1)->orWhere('cod_docente', $tesis[0]->cod_jurado2)->orWhere('cod_docente', $tesis[0]->cod_jurado3)->get();
            /**/
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
            $observaciones = ObservacionSustentacionProyecto::join('historial_observaciones as ho', 'observacion_sustentacionproy.cod_historialObs', '=', 'ho.cod_historialObs')->join('jurado as j', 'observacion_sustentacionproy.cod_jurado', 'j.cod_jurado')->join('asesor_curso as ac', 'j.cod_docente', 'ac.cod_docente')->select('observacion_sustentacionproy.*', 'ac.nombres as nombresAsesor', 'ac.apellidos as apellidosAsesor')->where('ho.cod_proyectotesis', $tesis[0]->cod_proyectotesis)->where('observacion_sustentacionproy.estado', 1)->where('ho.sustentacion', true)->where('ho.estado', 2)->get();

            //dd($observaciones);

            $detalles = [];
            if (sizeof($observaciones) > 0) {
                $detalles = DetalleObsSustentacionProy::where('cod_observacion', $observaciones[0]->cod_observacion)->get();
            }

            $presupuestoProy = Presupuesto_Proyecto::where('cod_proyectotesis', '=', $tesis[0]->cod_proyectotesis)->get();

            $recursos = recursos::where('cod_proyectotesis', '=', $tesis[0]->cod_proyectotesis)->get();

            $objetivos = Objetivo::where('cod_proyectotesis', '=', $tesis[0]->cod_proyectotesis)->get();

            $variableop = variableOP::where('cod_proyectotesis', '=', $tesis[0]->cod_proyectotesis)->get();

            $campos = CamposEstudiante::where('cod_proyectotesis', $tesis[0]->cod_proyectotesis)->get();

            $matriz = MatrizOperacional::where('cod_proyectotesis', '=', $tesis[0]->cod_proyectotesis)->get();

            //Obtener los archivos e imagenes que tuviese guardado.
            $detalleHistorial = [];

            $enabledView = DesignacionJuradoProyecto::where('cod_proyectotesis', $tesis[0]->cod_proyectotesis)->get();

            return view('cursoTesis20221.estudiante.evaluacionProyecto.proyectoTesis', [
                'autor' => $autor,
                'presupuestos' => $presupuestos, 'fin_persigue' => $fin_persigue, 'diseno_investigacion' => $diseno_investigacion, 'tiporeferencia' => $tiporeferencia, 'tesis' => $tesis, 'asesor' => $asesor,
                'observaciones' => $observaciones, 'recursos' => $recursos, 'objetivos' => $objetivos, 'variableop' => $variableop,
                'presupuestoProy' => $presupuestoProy, 'detalles' => $detalles, 'tinvestigacion' => $tinvestigacion, 'campos' => $campos,
                'referencias' => $referencias, 'detalleHistorial' => $detalleHistorial, 'matriz' => $matriz, 'cronograma' => $cronograma, 'cronogramas_py' => $cronogramas_py, 'coautor' => $coautor, 'enabledView' => $enabledView, 'jurados' => $jurados
            ]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function viewEstadoEvaluacionProyecto()
    {
        try {
            $id = auth()->user()->name;
            $aux = explode('-', $id);
            $id = $aux[0];
            $estudiante = EstudianteCT2022::find($id);
            $proyecto = TesisCT2022::join('asesor_curso as ac', 'ac.cod_docente', '=', 'proyecto_tesis.cod_docente')->join('grupo_investigacion as g_i', 'proyecto_tesis.id_grupo_inves', '=', 'g_i.id_grupo')->join('detalle_grupo_investigacion as d_g', 'd_g.id_grupo_inves', '=', 'g_i.id_grupo')->join('designacion_jurado_proyecto as dj','proyecto_tesis.cod_proyectotesis','dj.cod_proyectotesis')->select('ac.nombres as nombre_asesor', 'ac.apellidos as apellidos_asesor','proyecto_tesis.cod_proyectotesis', 'proyecto_tesis.updated_at','proyecto_tesis.titulo','dj.estado')->where('d_g.cod_matricula', '=', $estudiante->cod_matricula)->first();
            return view('cursoTesis20221.estudiante.evaluacionProyecto.estadoProyecto', ['proyecto' => $proyecto]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function actualizarProyectoTesis(Request $request)
    {
        try {
            $id = auth()->user()->name;
            $aux = explode('-', $id);
            $id = $aux[0];
            $isSaved = $request->isSaved;

            $tesis = TesisCT2022::find($request->cod_proyectotesis);

            $estudiantes_grupo = DB::table('estudiante_ct2022 as e')
                ->join('detalle_grupo_investigacion as d_g', 'd_g.cod_matricula', '=', 'e.cod_matricula')
                ->join('grupo_investigacion as g_i', 'g_i.id_grupo', '=', 'd_g.id_grupo_inves')
                ->select('g_i.num_grupo', 'e.cod_matricula', 'e.nombres', 'e.apellidos')
                ->where('d_g.id_grupo_inves', $tesis->id_grupo_inves)->get();
            $asesor = AsesorCurso::where('cod_docente', $tesis->cod_docente)->first();
            $observacionX = ObservacionSustentacionProyecto::join('historial_observaciones as ho', 'observacion_sustentacionproy.cod_historialObs', 'ho.cod_historialObs')
                ->select('observacion_sustentacionproy.*')->where('ho.cod_proyectotesis', $tesis->cod_proyectotesis)
                ->where('observacion_sustentacionproy.estado', 1)->get();
            $designacion = DesignacionJuradoProyecto::where('cod_proyectotesis', $request->cod_proyectotesis)->where('estado', 2)->first();
            if (sizeof($observacionX) > 0) {
                $detalles = DetalleObsSustentacionProy::join('observacion_sustentacionproy as os', 'detalle_obs_sustentacionproy.cod_observacion', 'os.cod_observacion')->join('historial_observaciones as ho', function ($join) use ($tesis) {
                    $join->on('os.cod_historialObs', '=', 'ho.cod_historialObs')
                        ->where('ho.cod_proyectotesis', $tesis->cod_proyectotesis)
                        ->where('ho.estado', 2);
                })->select('detalle_obs_sustentacionproy.*')->where('detalle_obs_sustentacionproy.estado', 1)->get();
            }

            /*Si el egresado tiene una observacion pendiente, solo se guardaran los cambios solicitados*/
            if (sizeof($observacionX) > 0) {

                for ($i = 0; $i < sizeof($detalles); $i++) {
                    $tema = $detalles[$i]->tema_referido;
                    if ($tema == "localidad_institucion") {
                        $name_request = 'txtlocalidad';
                    } else {
                        $name_request = 'txt' . $tema;
                    }
                    $detalleEEG = DetalleObsSustentacionProy::find($detalles[$i]->cod_detalleObs);

                    $detalleEEG->correccion = $request->$name_request;
                    $detalleEEG->estado = 2;
                    $detalleEEG->save();
                }

                $historialX = Historial_Observaciones::where('cod_proyectotesis', '=', $tesis->cod_proyectotesis)->where('sustentacion', true)->where('estado', 2)->get();
                $historialX[0]->fecha = now();
                $historialX[0]->estado = 1;
                $historialX[0]->save();
                foreach ($observacionX as $obs) {
                    $obs->fecha = now();
                    $obs->estado = 2;
                    $obs->save();
                }
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
                $designacion->estado = 9;
            } else {
                $designacion->estado = 1;
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
                                $detalleEEG = DetalleObsSustentacionProy::find($detalles[$i]->cod_detalleObs);
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
                                $detalleEEG = DetalleObsSustentacionProy::find($detalles[$i]->cod_detalleObs);
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
                                $detalleEEG = DetalleObsSustentacionProy::find($detalles[$i]->cod_detalleObs);
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
                                $detalleEEG = DetalleObsSustentacionProy::find($detalles[$i]->cod_detalleObs);
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

            $designacion->save();
            return redirect()->route('user_information')->with('datos', 'okActualizacionProyecto');
        } catch (\Throwable $th) {
            dd($th);
            return redirect()->route('user_information')->with('datos', 'oknotActualizacionProyecto');
        }
    }

    /* Fin  proyecto*/
}
