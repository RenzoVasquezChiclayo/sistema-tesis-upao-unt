<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Designacion_Jurado;
use App\Models\Jurado;
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
        $extraArray=[];
        $studentforGroups=[];
        $contador = 0;
        $asesor = DB::table('asesor_curso')->select('asesor_curso.cod_docente')->where('asesor_curso.username', auth()->user()->name)->first();
        $lista_tesis = DB::table('designacion_jurados as d_j')->join('tesis_2022 as ts', 'd_j.cod_tesis', 'ts.cod_tesis')
            ->join('grupo_investigacion as g_i', 'ts.id_grupo_inves', 'g_i.id_grupo')
            ->join('detalle_grupo_investigacion as d_g_i', 'g_i.id_grupo', 'd_g_i.id_grupo_inves')
            ->join('estudiante_ct2022 as es', 'd_g_i.cod_matricula', 'es.cod_matricula')
            ->join('asesor_curso as a_c', 'ts.cod_docente', 'a_c.cod_docente')
            ->select('g_i.id_grupo','g_i.num_grupo', 'd_g_i.cod_matricula', 'ts.cod_tesis', 'ts.titulo', 'a_c.nombres as nombresAsesor', 'a_c.apellidos as apellidosAsesor', 'es.nombres as nombresAutor', 'es.apellidos as apellidosAutor','d_j.cod_jurado1','d_j.cod_jurado2','d_j.cod_jurado3','d_j.cod_jurado4')
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
        return view('cursoTesis20221.asesor.evaluacion.listaTesisAsignadas', ['studentforGroups' => $studentforGroups,'asesor'=>$asesor]);
    }
}
