<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AsesorCurso;
use App\Models\DetalleSustentacion;
use App\Models\EstudianteCT2022;
use App\Models\Jurado;
use App\Models\Sustentacion;
use App\Models\Tesis_2022;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Exception;
use Throwable;

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
                ->leftJoin('sustentacion as s', 't.cod_tesis', 's.cod_tesis')
                ->select('t.cod_tesis', 't.titulo', 'estudiante_ct2022.nombres as nombresAutor', 'estudiante_ct2022.cod_matricula', 'estudiante_ct2022.apellidos as apellidosAutor', 'asesor_curso.cod_docente', 'asesor_curso.nombres as nombresAsesor', 'asesor_curso.apellidos as apellidosAsesor', 's.estado as estadoSustentacion', 'dj.cod_designacion_jurados as cod_designacion', 's.cod as codSustentacion')
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
                        'estadoSustentacion' => $primerItem->estadoSustentacion,
                        'cod_designacion' => $primerItem->cod_designacion
                    ];
                    return [$autor];
                })->values();
            //dd($tesisAgrupadas);
            return view('cursoTesis20221.director.sustentacion.registrarSustentacion', ['tesisAgrupadas' => $tesisAgrupadas]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function verDetalleSustentacion($cod_designacion)
    {
        try {
            $existSusentacion = Sustentacion::where('cod', $cod_designacion)->get();
            $tesis = Tesis_2022::join('designacion_jurados as dj', 'tesis_2022.cod_tesis', 'dj.cod_tesis')->join('asesor_curso as ac', 'tesis_2022.cod_docente', 'ac.cod_docente')->select('dj.*', 'tesis_2022.*', 'ac.nombres as nombresAsesor', 'ac.apellidos as apellidosAsesor')->where('dj.cod_designacion_jurados', $cod_designacion)->first();
            $jurados = Jurado::join('asesor_curso as ac', 'jurado.cod_docente', 'ac.cod_docente')->select('ac.*', 'jurado.cod_jurado')->where('ac.cod_docente', '!=', $tesis->cod_docente)->get();
            $juradoSustentacion = Jurado::join('asesor_curso as ac', 'jurado.cod_docente', 'ac.cod_docente')->join('detalle_sustentacion as ds', 'jurado.cod_jurado', 'ds.cod_jurado')->select('ac.*', 'jurado.cod_jurado')->where('ds.cod_sustentacion', sizeof($existSusentacion) > 0 ? $existSusentacion[0]->cod : null)->get();
            $autores = EstudianteCT2022::join('detalle_grupo_investigacion as dg', 'estudiante_ct2022.cod_matricula', 'dg.cod_matricula')->select('estudiante_ct2022.*')->where('dg.id_grupo_inves', $tesis->id_grupo_inves)->get();
            return view('cursoTesis20221.director.sustentacion.verDetalleSustentacion', ['jurados' => $jurados, 'existSustentacion' => $existSusentacion, 'autores' => $autores, 'tesis' => $tesis, 'juradoSustentacion' => $juradoSustentacion]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function actualizarSustentacion(Request $request)
    {
        try {
            $datetime_stt = $this->getDateTime(
                $date = $request->fecha_stt,
                $time = $request->hora_stt
            );
            if ($request->codSustentacion != null) {
                $sustentacion = Sustentacion::find($request->codSustentacion);
            } else {
                $sustentacion = new Sustentacion();
                $sustentacion->cod_tesis = $request->codTesis;
            }
            $sustentacion->modalidad = $request->modalidad;
            $sustentacion->comentario = $request->comentarioModalidad;
            $sustentacion->fecha_stt = $datetime_stt;
            $sustentacion->save();

            $recentlySustentacion = Sustentacion::where('cod_tesis', $request->codTesis)->first();
            for ($i = 1; $i <= 4; $i++) {
                $nameField = 'cboJurado' . $i;
                $posJurado = '';
                switch ($i) {
                    case "1":
                        $posJurado = '1er Jurado';
                        break;
                    case "2":
                        $posJurado = '2do Jurado';
                        break;
                    case "3":
                        $posJurado = 'Vocal';
                        break;
                    case "4":
                        $posJurado = 'Extra';
                        break;

                    default:
                        throw new Exception("Not defined a Jurado");
                }
                $existDetalle = DetalleSustentacion::where('pos_jurado',$posJurado)->where('cod_sustentacion',$recentlySustentacion->cod)->first();
                if($existDetalle==null){
                    $detalle = new DetalleSustentacion();
                    $detalle->cod_sustentacion = $recentlySustentacion->cod;
                    $detalle->cod_jurado = $request->$nameField;
                    $detalle->pos_jurado = $posJurado;
                    $detalle->save();
                }else{
                    if($existDetalle->cod_jurado != $request->$nameField){
                        $existDetalle->cod_jurado = $request->$nameField;
                        $existDetalle->nota = null;
                        $existDetalle->comentario = null;
                        $existDetalle->save();
                    }
                }
            }
            return redirect()->route('director.sustentacion.verRegistrarSustentacion')->with('datos', 'okSustentacion');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function listaSustentaciones()
    {
        $asesor = DB::table('asesor_curso as ac')->join('jurado as j','ac.cod_docente','j.cod_docente')->select('j.*')->where('ac.username', auth()->user()->name)->first();
        $tesis_aprobadas = DB::table('tesis_2022 as t')
            ->join('detalle_grupo_investigacion as d_g', 'd_g.id_grupo_inves', '=', 't.id_grupo_inves')
            ->join('estudiante_ct2022', 'estudiante_ct2022.cod_matricula', '=', 'd_g.cod_matricula')
            ->join('designacion_jurados as dj', 'dj.cod_tesis', 't.cod_tesis')
            ->join('sustentacion as s', 't.cod_tesis', 's.cod_tesis')
            ->join('detalle_sustentacion as ds','s.cod','ds.cod_sustentacion')
            ->select('t.cod_tesis', 't.titulo', 's.cod', 'estudiante_ct2022.nombres as nombresAutor', 'estudiante_ct2022.cod_matricula', 'estudiante_ct2022.apellidos as apellidosAutor', 's.fecha_stt')
            ->where('s.estado','>=',0)
            ->where('ds.cod_jurado',$asesor->cod_jurado)
            ->get();
        //dd($tesis_aprobadas);
        $tesisAgrupadas = $tesis_aprobadas
            ->groupBy('cod_tesis')
            ->map(function ($grupo) use ($asesor) {
                // Combina múltiples autores en una sola tesis
                $primerItem = $grupo->first();
                $autor = [
                    'cod_tesis' => $primerItem->cod_tesis,
                    'titulo' => $primerItem->titulo,
                    'fecha_susten' => $primerItem->fecha_stt == null ? "" : $primerItem->fecha_stt,
                    'valida_fecha' => $primerItem->fecha_stt < Carbon::now() ? true : false,
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
                $detalle_susten = DB::table('detalle_sustentacion as ds')->where('ds.cod_sustentacion', $primerItem->cod)->where('ds.cod_jurado',$asesor->cod_jurado)->first();
                if ($detalle_susten == null) {
                    return [$autor];
                }
                return [$autor, $detalle_susten];
            })->values();

            //dd($tesisAgrupadas);
        // foreach ($tesisAgrupadas as $key => $tesisagru) {
        //     dd(count($tesisagru)>1);
        // }
        return view('cursoTesis20221.asesor.sustentacion.listaSustentaciones', ['tesisAgrupadas' => $tesisAgrupadas]);
    }

    public function guardarNotaTesis(Request $request)
    {
        try {
            $cod_tesis = $request->cod_tesis;
            $sustentacion = DB::table('sustentacion as s')->select('s.cod')->where('s.cod_tesis', $cod_tesis)->first();

            $detalle_sustentacion = DetalleSustentacion::where('cod_sustentacion', $sustentacion->cod)->first();
            //dd($detalle_sustentacion);
            $detalle_sustentacion->nota = $request->nota;
            $detalle_sustentacion->comentario = $request->comentario;
            $detalle_sustentacion->estado = 1;
            $detalle_sustentacion->save();
            return redirect()->route('asesor.sustentacion.listaSustentacion')->with('datos', 'okNota');
        } catch (\Throwable $th) {
            dd($th);
            //return redirect()->route('asesor.sustentacion.listaSustentacion')->with('datos','okNotNota');
        }
    }

    private function getDateTime($date, $time)
    {
        $dateObject = Carbon::parse($date);
        $timeObject = Carbon::parse($time);
        $dateObject->hour($timeObject->hour);
        $dateObject->minute($timeObject->minute);
        return $dateObject;
    }
}
