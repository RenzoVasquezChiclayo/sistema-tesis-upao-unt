<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Designacion_Jurado;
use App\Models\Detalle_Archivo;
use App\Models\Jurado;
use App\Models\Observaciones_Sustentacion;
use App\Models\TDetalleKeyword;
use App\Models\TDetalleObservacion;
use App\Models\Tesis_2022;
use App\Models\THistorialObservaciones;
use App\Models\TObservacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SustentacionController extends Controller
{


    public function verRegistrarJurado()
    {
        $asesores = DB::table('asesor_curso as ac')->leftJoin('jurado as j', 'ac.cod_docente', "=", 'j.cod_docente')->select('ac.*')->whereNull('j.cod_docente')->get();
        $tipoInvestigacion = DB::table('tipoinvestigacion')->get();
        $jurados = DB::table('jurado as j')->join('tipoinvestigacion as ti', 'j.cod_tinvestigacion', 'ti.cod_tinvestigacion')->leftJoin('asesor_curso as ac', 'j.cod_docente', '=', 'ac.cod_docente')->select('ac.nombres', 'ac.apellidos', 'j.*', 'ti.descripcion')->get();
        return view('cursoTesis20221.director.evaluacion.registrarJurado', ['asesores' => $asesores, 'tipoInvestigacion' => $tipoInvestigacion, 'jurados' => $jurados]);
    }
    public function registrarJurado(Request $request)
    {
        try {
            $asesor = DB::table('asesor_curso')->where('cod_docente', $request->selectAsesor)->get();
            $tipoInvestigacion = DB::table('tipoinvestigacion')->where('cod_tinvestigacion', $request->selectTInvestigacion)->get();

            $jurado = new Jurado();
            $jurado->cod_docente = $asesor[0]->cod_docente;
            $jurado->cod_tinvestigacion = $tipoInvestigacion[0]->cod_tinvestigacion;
            $jurado->save();
            return redirect()->route('director.verRegistrarJurado')->with('datos', 'ok');
        } catch (\Throwable $e) {
            dd($e);
            return redirect()->route('director.verRegistrarJurado')->with('datos', 'oknot');
        }
    }

    // ----------------------------------------------------DESIGNACION DE JURADOS ----------------------------------------------------------------------------

    public function lista_tesis_aprobadas(Request $request)
    {

        $tesis_aprobadas = DB::table('tesis_2022 as t')
            ->join('detalle_grupo_investigacion as d_g', 'd_g.id_grupo_inves', '=', 't.id_grupo_inves')
            ->join('estudiante_ct2022', 'estudiante_ct2022.cod_matricula', '=', 'd_g.cod_matricula')
            ->join('asesor_curso', 't.cod_docente', '=', 'asesor_curso.cod_docente')
            ->leftJoin('designacion_jurados as dj', 'dj.cod_tesis', 't.cod_tesis')
            ->select('t.cod_tesis', 't.titulo', 'estudiante_ct2022.nombres as nombresAutor', 'estudiante_ct2022.apellidos as apellidosAutor', 'asesor_curso.cod_docente', 'asesor_curso.nombres as nombresAsesor', 'asesor_curso.apellidos as apellidosAsesor', 'dj.cod_jurado1', 'dj.cod_jurado2', 'dj.cod_jurado3', 'dj.cod_jurado4')
            ->where('t.estado', 3)->where('t.condicion', "APROBADO")->get();

        // Agrupar por cod_tesis

        $tesisAgrupadas = $tesis_aprobadas->groupBy('cod_tesis')->map(function ($grupo) {
            // Combina múltiples autores en una sola tesis
            $primerItem = $grupo->first();
            $autor = [
                'cod_tesis' => $primerItem->cod_tesis,
                'titulo' => $primerItem->titulo,
                'autores' => $grupo->map(function ($item) {
                    return [
                        'nombresAutor' => $item->nombresAutor,
                        'apellidosAutor' => $item->apellidosAutor,
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
        // foreach ($tesisAgrupadas as $key => $ta) {
        //     //dd($ta);
        //     foreach ($ta[1] as $key => $autor) {
        //         dd($autor->cod_docente);
        //     }
        // }


        return view('cursoTesis20221.director.evaluacion.asignacionDeJurados', ['tesisAgrupadas' => $tesisAgrupadas]);
    }

    public function save_asignacion_jurados(Request $request)
    {
        try {
            $datos = explode(',', $request->saveJurados);
            for ($i = 0; $i < count($datos); $i++) {
                if ($datos[$i] != null) {
                    $jurados = explode('_', $datos[$i]);
                    $new_asignacion = new Designacion_Jurado();
                    $new_asignacion->cod_tesis = $jurados[0];
                    $new_asignacion->cod_jurado1 = $jurados[1];
                    $new_asignacion->cod_jurado2 = $jurados[2];
                    $new_asignacion->cod_jurado3 = $jurados[3];
                    $new_asignacion->cod_jurado4 = $jurados[4];
                    $new_asignacion->save();
                }
            }
            return redirect()->route('director.listaTesisAprobadas')->with('datos', 'okdesignacion');
        } catch (\Throwable $th) {
            dd($th);
            return redirect()->route('director.listaTesisAprobadas')->with('datos', 'oknotdesignacion');
        }
    }


    //ASESOR

    public function lista_tesis_asignadas(Request $request)
    {
        $lastGroup = 0;
        $extraArray = [];
        $studentforGroups = [];
        $contador = 0;
        $asesor = DB::table('asesor_curso')->select('asesor_curso.cod_docente')->where('asesor_curso.username', auth()->user()->name)->first();
        $lista_tesis = DB::table('designacion_jurados as d_j')->join('tesis_2022 as ts', 'd_j.cod_tesis', 'ts.cod_tesis')
            ->join('grupo_investigacion as g_i', 'ts.id_grupo_inves', 'g_i.id_grupo')
            ->join('detalle_grupo_investigacion as d_g_i', 'g_i.id_grupo', 'd_g_i.id_grupo_inves')
            ->join('estudiante_ct2022 as es', 'd_g_i.cod_matricula', 'es.cod_matricula')
            ->join('asesor_curso as a_c', 'ts.cod_docente', 'a_c.cod_docente')
            ->select('g_i.id_grupo', 'g_i.num_grupo', 'd_g_i.cod_matricula', 'ts.cod_tesis', 'ts.titulo', 'a_c.nombres as nombresAsesor', 'a_c.apellidos as apellidosAsesor', 'es.nombres as nombresAutor', 'es.apellidos as apellidosAutor', 'd_j.cod_jurado1', 'd_j.cod_jurado2', 'd_j.cod_jurado3', 'd_j.cod_jurado4', 'ts.estado')
            ->where('d_j.cod_jurado1', $asesor->cod_docente)
            ->orWhere('d_j.cod_jurado2', $asesor->cod_docente)
            ->orWhere('d_j.cod_jurado3', $asesor->cod_docente)
            ->orWhere('d_j.cod_jurado4', $asesor->cod_docente)
            ->get();
        //dd($lista_tesis);



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
        //dd($studentforGroups);
        return view('cursoTesis20221.asesor.evaluacion.listaTesisAsignadas', ['studentforGroups' => $studentforGroups, 'asesor' => $asesor]);
    }


    public function detalleTesisAsignada(Request $request)
    {
        $Tesis = [];
        $camposFull = false;

        $id_grupo = $request->id_grupo;
        $Tesis = DB::table('tesis_2022 as t')
            ->join('grupo_investigacion as gi', 't.id_grupo_inves', '=', 'gi.id_grupo')
            ->join('asesor_curso as ac', 't.cod_docente', '=', 'ac.cod_docente')->leftJoin('grado_academico as gc', 'ac.cod_grado_academico', '=', 'gc.cod_grado_academico')
            ->select('t.*', 'ac.nombres as nombre_asesor', 'ac.cod_docente', 'ac.direccion as direccion_asesor', 'gc.descripcion as grado_academico')
            ->where('gi.id_grupo', $id_grupo)->get();

        $estudiantes_grupo = DB::table('estudiante_ct2022 as e')
            ->join('detalle_grupo_investigacion as d_g', 'd_g.cod_matricula', '=', 'e.cod_matricula')
            ->select('e.cod_matricula', 'e.nombres', 'e.apellidos')
            ->where('d_g.id_grupo_inves', $id_grupo)->get();

        $objetivos = DB::table('t_objetivo')->where('cod_tesis', '=', $Tesis[0]->cod_tesis)->get();
        $t_keywords = DB::table('t_keyword')->where('cod_tesis', '=', $Tesis[0]->cod_tesis)->get();
        $referencias = DB::table('t_referencias')->where('cod_tesis', '=', $Tesis[0]->cod_tesis)->get();

        $validatesis = DB::table('tesis_2022')
            ->select('titulo', 'presentacion', 'resumen', 'introduccion', 'real_problematica', 'antecedentes', 'justificacion', 'formulacion_prob', 'marco_teorico', 'marco_conceptual', 'marco_legal', 'form_hipotesis', 'objeto_estudio', 'poblacion', 'muestra', 'metodos', 'tecnicas_instrum', 'instrumentacion', 'estg_metodologicas', 'discusion', 'conclusiones', 'recomendaciones', 'resultados', 'anexos')
            ->where('cod_tesis', '=', $Tesis[0]->cod_tesis)->first();
        foreach ($validatesis as $atri) {
            if ($atri != null && sizeof($t_keywords) > 0 && sizeof($objetivos) > 0 && sizeof($referencias) > 0) {
                $camposFull = true;
            } else {
                $camposFull = false;
                break;
            }
        }

        /*Recoger imagenes de resultados*/
        $resultadosImg = Detalle_Archivo::join('archivos_proy_tesis as at', 'at.cod_archivos', '=', 'detalle_archivos.cod_archivos')->select('detalle_archivos.*')->where('at.cod_tesis', $Tesis[0]->cod_tesis)->where('tipo', 'resultados')->orderBy('grupo', 'ASC')->get();

        /*Recoger imagenes de anexos*/
        $anexosImg = Detalle_Archivo::join('archivos_proy_tesis as at', 'at.cod_archivos', '=', 'detalle_archivos.cod_archivos')->select('detalle_archivos.*')->where('at.cod_tesis', $Tesis[0]->cod_tesis)->where('tipo', 'anexos')->orderBy('grupo', 'ASC')->get();

        $keywords = TDetalleKeyword::join('t_keyword', 't_keyword.id_keyword', '=', 't_detalle_keyword.id_keyword')->select('t_detalle_keyword.*')->where('t_keyword.cod_tesis', $Tesis[0]->cod_tesis)->get();

        $observaciones = TObservacion::join('t_historial_observaciones as ho', 'ho.cod_historial_observacion', '=', 't_observacion.cod_historial_observacion')->select('t_observacion.*')->where('ho.cod_tesis', $Tesis[0]->cod_tesis)->get();

        return view('cursoTesis20221.asesor.evaluacion.detalleTesisAsignada', ['Tesis' => $Tesis, 'keywords' => $keywords, 'objetivos' => $objetivos, '$observaciones' => $observaciones, 'camposFull' => $camposFull, 'referencias' => $referencias, 'resultadosImg' => $resultadosImg, 'anexosImg' => $anexosImg, 'estudiantes_grupo' => $estudiantes_grupo]);
    }

    public function guardarObservacionSustentacion(Request $request)
    {
        $idTesis = $request->textcod;

        $asesor = DB::table('asesor_curso as ac')->join('jurado as j', 'ac.cod_docente', 'j.cod_docente')->select('ac.cod_docente', 'j.cod_jurado')->where('ac.username', auth()->user()->name)->first();

        $Tesis = DB::table('tesis_2022 as t')
            ->select('t.*')
            ->where('t.cod_tesis', $idTesis)
            ->first();

        $existHisto = THistorialObservaciones::where('cod_Tesis', $Tesis->cod_tesis)->get();
        if ($existHisto->count() == 0) {
            $existHisto = new THistorialObservaciones();
            $existHisto->cod_Tesis = $Tesis->cod_tesis;
            $existHisto->sustentacion = true;
            $existHisto->fecha = now();
            $existHisto->estado = 1;
            $existHisto->save();
        }

        $existHisto = THistorialObservaciones::where('cod_Tesis', $Tesis->cod_tesis)->get();


        try {
            $observaciones = new Observaciones_Sustentacion();
            // $observaciones->cod_tesis = $Tesis[0]->cod_tesis;
            $observaciones->cod_historial_observacion = $existHisto[0]->cod_historial_observacion;
            $observaciones->cod_jurado = $asesor->cod_jurado;
            $observaciones->fecha_create = now();

            if ($request->tachkCorregir4 != "") {
                $observaciones->presentacion = $request->tachkCorregir4;
                $arrayThemes[] = 'presentacion';
            }
            if ($request->tachkCorregir5 != "") {
                $observaciones->resumen = $request->tachkCorregir5;
                $arrayThemes[] = 'resumen';
            }
            if ($request->tachkCorregir6 != "") {
                $observaciones->introduccion = $request->tachkCorregir6;
                $arrayThemes[] = 'introduccion';
            }

            if ($request->tachkCorregir7 != "") {
                $observaciones->real_problematica = $request->tachkCorregir7;
                $arrayThemes[] = 'real_problematica';
            }
            if ($request->tachkCorregir8 != "") {
                $observaciones->antecedentes = $request->tachkCorregir8;
                $arrayThemes[] = 'antecedentes';
            }
            if ($request->tachkCorregir9 != "") {
                $observaciones->justificacion = $request->tachkCorregir9;
                $arrayThemes[] = 'justificacion';
            }
            if ($request->tachkCorregir10 != "") {
                $observaciones->formulacion_prob = $request->tachkCorregir10;
                $arrayThemes[] = 'formulacion_prob';
            }
            if ($request->tachkCorregir11 != "") {
                $observaciones->objetivos = $request->tachkCorregir11;
                $arrayThemes[] = 'objetivos';
            }
            if ($request->tachkCorregir12 != "") {
                $observaciones->marco_teorico = $request->tachkCorregir12;
                $arrayThemes[] = 'marco_teorico';
            }

            if ($request->tachkCorregir13 != "") {
                $observaciones->marco_conceptual = $request->tachkCorregir13;
                $arrayThemes[] = 'marco_conceptual';
            }
            if ($request->tachkCorregir14 != "") {
                $observaciones->marco_legal = $request->tachkCorregir14;
                $arrayThemes[] = 'marco_legal';
            }
            if ($request->tachkCorregir15 != "") {
                $observaciones->form_hipotesis = $request->tachkCorregir15;
                $arrayThemes[] = 'form_hipotesis';
            }
            if ($request->tachkCorregir16 != "") {
                $observaciones->objeto_estudio = $request->tachkCorregir16;
                $arrayThemes[] = 'objeto_estudio';
            }
            if ($request->tachkCorregir17 != "") {
                $observaciones->poblacion = $request->tachkCorregir17;
                $arrayThemes[] = 'poblacion';
            }
            if ($request->tachkCorregir18 != "") {
                $observaciones->muestra = $request->tachkCorregir18;
                $arrayThemes[] = 'muestra';
            }
            if ($request->tachkCorregir19 != "") {
                $observaciones->metodos = $request->tachkCorregir19;
                $arrayThemes[] = 'metodos';
            }
            if ($request->tachkCorregir20 != "") {
                $observaciones->tecnicas_instrum = $request->tachkCorregir20;
                $arrayThemes[] = 'tecnicas_instrum';
            }
            if ($request->tachkCorregir21 != "") {
                $observaciones->instrumentacion = $request->tachkCorregir21;
                $arrayThemes[] = 'instrumentacion';
            }
            if ($request->tachkCorregir22 != "") {
                $observaciones->estg_metodologicas = $request->tachkCorregir22;
                $arrayThemes[] = 'estg_metodologicas';
            }
            if ($request->tachkCorregir23 != "") {
                $observaciones->resultados = $request->tachkCorregir23;
                $arrayThemes[] = 'resultados';
            }
            if ($request->tachkCorregir24 != "") {
                $observaciones->discusion = $request->tachkCorregir24;
                $arrayThemes[] = 'discusion';
            }
            if ($request->tachkCorregir25 != "") {
                $observaciones->conclusiones = $request->tachkCorregir25;
                $arrayThemes[] = 'conclusiones';
            }
            if ($request->tachkCorregir26 != "") {
                $observaciones->recomendaciones = $request->tachkCorregir26;
                $arrayThemes[] = 'recomendaciones';
            }
            if ($request->tachkCorregir27 != "") {
                $observaciones->referencias = $request->tachkCorregir27;
                $arrayThemes[] = 'referencias';
            }
            $observaciones->estado = 1;

            $observaciones->save();
            $tesis = Tesis_2022::find($idTesis);
            $tesis->estado = 3;
            $tesis->save();
            // if ($Tesis->correoEstudi != null) {
            //     $titulo = $Tesis->titulo;
            //     $asesor = $Tesis->nombresAsesor;
            //     Mail::to($Tesis[0]->correoEstudi)->send(new EstadoObservadoTesisMail($titulo,$asesor));
            // }

        } catch (\Throwable $th) {
            dd($th);
            return redirect()->route('asesor.revisar-tesis')->with('datos', 'oknot');
        }

        return redirect()->route('asesor.ver-obs-estudiante-tesis', $existHisto[0]->cod_historial_observacion)->with('datos', 'ok');
    }

    public function lista_observaciones_evaluacion()
    {
        $datos = explode('-', auth()->user()->name);
        $observaciones = DB::table('observacion_sustentacion as o_s')
            ->join('t_historial_observaciones as t_h_o', 'o_s.cod_historial_observacion', 't_h_o.cod_historial_observacion')
            ->join('tesis_2022 as t', 't_h_o.cod_tesis', 't.cod_tesis')
            ->join('grupo_investigacion as g_i', 't.id_grupo_inves', 'g_i.id_grupo')
            ->join('detalle_grupo_investigacion as d_g_i', 'g_i.id_grupo', 'd_g_i.id_grupo_inves')
            ->join('jurado as j','o_s.cod_jurado','j.cod_jurado')
            ->join('asesor_curso as ac','j.cod_docente','ac.cod_docente')
            ->select('o_s.*','ac.nombres','ac.apellidos')
            ->where('d_g_i.cod_matricula', $datos[0])
            ->get();
        //dd($observaciones);


        return view('cursoTesis20221.estudiante.evaluacion.listaObservacionesSustentacion', ['observaciones' => $observaciones]);
    }
}
