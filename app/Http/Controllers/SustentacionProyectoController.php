<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AsesorCurso;
use App\Models\CamposEstudiante;
use App\Models\Cronograma;
use App\Models\Cronograma_Proyecto;
use App\Models\DesignacionJuradoProyecto;
use App\Models\Detalle_Observaciones;
use App\Models\DetalleObsSustentacionProy;
use App\Models\Diseno_Investigacion;
use App\Models\Fin_Persigue;
use App\Models\Jurado;
use App\Models\MatrizOperacional;
use App\Models\Objetivo;
use App\Models\ObservacionesProy;
use App\Models\ObservacionSustentacionProyecto;
use App\Models\Presupuesto;
use App\Models\Presupuesto_Proyecto;
use App\Models\recursos;
use App\Models\referencias;
use App\Models\TesisCT2022;
use App\Models\TipoInvestigacion;
use App\Models\TipoReferencia;
use App\Models\variableOP;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SustentacionProyectoController extends Controller
{
    //Proyecto de Tesis
    public function lista_proyectos_aprobados(Request $request)
    {

        $proyectos_aprobados = DB::table('proyecto_tesis as pt')
            ->join('detalle_grupo_investigacion as d_g', 'pt.id_grupo_inves', '=', 'd_g.id_grupo_inves')
            ->join('estudiante_ct2022 as e', 'd_g.cod_matricula', '=', 'e.cod_matricula')
            ->join('asesor_curso as a', 'pt.cod_docente', '=', 'a.cod_docente')
            ->leftJoin('designacion_jurado_proyecto as dj', 'pt.cod_proyectotesis', 'dj.cod_proyectotesis')
            ->select('pt.cod_proyectotesis', 'pt.titulo', 'e.nombres as nombresAutor', 'e.apellidos as apellidosAutor', 'a.cod_docente', 'a.nombres as nombresAsesor', 'a.apellidos as apellidosAsesor', 'dj.cod_jurado1', 'dj.cod_jurado2', 'dj.cod_jurado3', 'dj.cod_jurado4')
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

    public function viewEvaluacionProyecto()
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
            return view('cursoTesis20221.cursoTesis', ['autor' => $autor, 'tesis' => []]);
        }
        $coautor = DB::table('detalle_grupo_investigacion as dg')->rightJoin('estudiante_ct2022 as e', 'e.cod_matricula', '=', 'dg.cod_matricula')->select('e.*')->where('dg.id_grupo_inves', $autor->id_grupo)->where('e.cod_matricula', '!=', $id)->first();

        $tesis = TesisCT2022::where('id_grupo_inves', '=', $autor->id_grupo)->join('designacion_jurado_proyecto as dj','proyecto_tesis.cod_proyectotesis','dj.cod_proyectotesis')->select('proyecto_tesis.*','dj.estado as estadoDesignacion','dj.cod_jurado1','dj.cod_jurado2','dj.cod_jurado3','dj.cod_jurado4')->get(); //Encontramos la tesis
        /*Encontramos los jurados */
        $jurados = AsesorCurso::where('cod_docente',$tesis[0]->cod_jurado1)->orWhere('cod_docente',$tesis[0]->cod_jurado2)->orWhere('cod_docente',$tesis[0]->cod_jurado3)->get();
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
        $observaciones = ObservacionSustentacionProyecto::join('historial_observaciones as ho', 'observacion_sustentacionproy.cod_historialObs', '=', 'ho.cod_historialObs')
            ->select('observacion_sustentacionproy.*')->where('ho.cod_proyectotesis', $tesis[0]->cod_proyectotesis)
            ->where('observacion_sustentacionproy.estado', 1)->where('ho.sustentacion',true)->get();

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

        $enabledView = DesignacionJuradoProyecto::where('cod_proyectotesis',$tesis[0]->cod_proyectotesis)->get();

        return view('cursoTesis20221.estudiante.evaluacionProyecto.proyectoTesis', [
            'autor' => $autor,
            'presupuestos' => $presupuestos, 'fin_persigue' => $fin_persigue, 'diseno_investigacion' => $diseno_investigacion, 'tiporeferencia' => $tiporeferencia, 'tesis' => $tesis, 'asesor' => $asesor,
            'observaciones' => $observaciones, 'recursos' => $recursos, 'objetivos' => $objetivos, 'variableop' => $variableop,
            'presupuestoProy' => $presupuestoProy, 'detalles' => $detalles, 'tinvestigacion' => $tinvestigacion, 'campos' => $campos,
            'referencias' => $referencias, 'detalleHistorial' => $detalleHistorial, 'matriz' => $matriz, 'cronograma' => $cronograma, 'cronogramas_py' => $cronogramas_py, 'coautor' => $coautor, 'enabledView'=>$enabledView,'jurados'=>$jurados
        ]);
    }

    public function viewEstadoEvaluacionProyecto(){
        return;
    }

    public function saveAsignacionJuradoProyecto(Request $request){
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
                }
            }
            return redirect()->route('director.listaProyectosAprobados')->with('datos', 'okdesignacion');
        } catch (\Throwable $th) {
            dd($th);
            return redirect()->route('director.listaProyectosAprobados')->with('datos', 'oknotdesignacion');
        }
    }

    /* Fin  proyecto*/
}
