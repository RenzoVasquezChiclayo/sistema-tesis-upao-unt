<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EvaluacionController extends Controller
{
    public function verRegistrarSustentacion()
    {
        try {
            $tesis_aprobadas = DB::table('tesis_2022 as t')
                ->join('detalle_grupo_investigacion as d_g', 'd_g.id_grupo_inves', '=', 't.id_grupo_inves')
                ->join('estudiante_ct2022', 'estudiante_ct2022.cod_matricula', '=', 'd_g.cod_matricula')
                ->join('asesor_curso', 't.cod_docente', '=', 'asesor_curso.cod_docente')
                ->join('designacion_jurados as dj', 'dj.cod_tesis', 't.cod_tesis')
                ->leftJoin('sustentacion as s','t.cod_tesis','s.cod_tesis')
                ->select('t.cod_tesis', 't.titulo', 'estudiante_ct2022.nombres as nombresAutor', 'estudiante_ct2022.cod_matricula', 'estudiante_ct2022.apellidos as apellidosAutor', 'asesor_curso.cod_docente', 'asesor_curso.nombres as nombresAsesor', 'asesor_curso.apellidos as apellidosAsesor','s.estado as estadoSustentacion','dj.cod_designacion_jurados as cod_designacion')
                ->where('dj.estado', 3)
                ->get();

            // Agrupar por cod_tesis
            $tesisAgrupadas = $tesis_aprobadas
                ->groupBy('cod_tesis')
                ->map(function ($grupo) {
                    // Combina múltiples autores en una sola tesis
                    $primerItem = $grupo->first();
                    $autor = [
                        'cod_tesis' => $primerItem->cod_tesis,
                        'titulo' => $primerItem->titulo,
                        'autores' => $grupo
                            ->map(function ($item) {
                                return [
                                    'nombresAutor' => $item->nombresAutor,
                                    'apellidosAutor' => $item->apellidosAutor,
                                    'cod_matricula' => $item->cod_matricula
                                ];
                            })
                            ->toArray(),
                        'cod_docente' => $primerItem->cod_docente,
                        'nombresAsesor' => $primerItem->nombresAsesor,
                        'apellidosAsesor' => $primerItem->apellidosAsesor,
                        'estadoSustentacion'=>$primerItem->estadoSustentacion,
                        'cod_designacion'=>$primerItem->cod_designacion
                    ];
                    return [$autor];
                })->values();
            return view('cursoTesis20221.director.sustentacion.registrarSustentacion', ['tesisAgrupadas'=>$tesisAgrupadas]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function registrarSustentacion(){
        try {
            return view('cursoTesis20221.director.sustentacion.verDetalleSustentacion',[]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }



    public function listaSustentaciones(){
        $tesis_aprobadas = DB::table('tesis_2022 as t')
                ->join('detalle_grupo_investigacion as d_g', 'd_g.id_grupo_inves', '=', 't.id_grupo_inves')
                ->join('estudiante_ct2022', 'estudiante_ct2022.cod_matricula', '=', 'd_g.cod_matricula')
                ->join('asesor_curso', 't.cod_docente', '=', 'asesor_curso.cod_docente')
                ->join('designacion_jurados as dj', 'dj.cod_tesis', 't.cod_tesis')
                ->leftJoin('sustentacion as s','t.cod_tesis','s.cod_tesis')
                ->select('t.cod_tesis', 't.titulo', 'estudiante_ct2022.nombres as nombresAutor', 'estudiante_ct2022.cod_matricula', 'estudiante_ct2022.apellidos as apellidosAutor','s.estado')
                ->where('dj.estado', 3)
                ->get();

        $tesisAgrupadas = $tesis_aprobadas
                ->groupBy('cod_tesis')
                ->map(function ($grupo) {
                    // Combina múltiples autores en una sola tesis
                    $primerItem = $grupo->first();
                    $autor = [
                        'cod_tesis' => $primerItem->cod_tesis,
                        'titulo' => $primerItem->titulo,
                        'autores' => $grupo
                            ->map(function ($item) {
                                return [
                                    'nombresAutor' => $item->nombresAutor,
                                    'apellidosAutor' => $item->apellidosAutor,
                                    'cod_matricula' => $item->cod_matricula
                                ];
                            })
                            ->toArray(),
                    ];
                    return [$autor];
                })->values();
        dd($tesisAgrupadas);
        return view('cursoTesis20221.asesor.sustentacion.listaSustentaciones');
    }
}
