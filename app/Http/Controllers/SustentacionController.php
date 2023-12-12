<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AsesorCurso;
use App\Models\EstudianteCT2022;
use App\Models\InformeFinal;
use App\Models\SolicitudSustentacion;
use App\Models\Tesis_2022;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SustentacionController extends Controller
{
    public function lista_solicitudes_jurados(Request $request){
        // $filtrarSemestre = $request->filtrar_semestre;
        $semestre = DB::table('configuraciones_iniciales as ci')->where('ci.estado',1)->orderBy('ci.cod_configuraciones', 'desc')->get();
        if (count($semestre) == 0) {
            return view('cursoTesis20221.director.evaluacion.listaSolicitudesDesignacionJurado', ['estudiantes' => [], 'semestre' => []]);
        }else{
            $semestreBuscar = $request->semestre;
            $last_semestre = DB::table('configuraciones_iniciales as c_i')->select('c_i.*')->where('c_i.estado', 1)->orderBy('c_i.cod_configuraciones', 'desc')->first();
            // if ($filtrarSemestre != null) {
            //     $solicitud = DB::table('solicitud_sustentacion as ss')
            //                 ->join('tesis_2022 as ts','ss.cod_tesis','ts.cod_tesis')
            //                 ->join('estudiante_ct2022 as es','ts.cod_matricula','es.cod_matricula')
            //                 ->join('asesor_curso as ac','ts.cod_asesor','ac.cod_docente')
            //                 ->join('configuraciones_inciales as ci','')
            //                 ->select('es.*','ac.nombres as nombresAsesor','ac.apellidos as apellidosAsesor','ss.fecha_solicitud')
            //                 ->where('ss.estado',1)
            //                 ->where('e_s.cod_configuraciones', 'like', '%' . $semestreBuscar . '%')
            //                 //->where('e.cod_matricula', 'like', '%' . $buscarAlumno . '%')
            //                 ->orderBy('e.apellidos')->get();
            // } else {
                     $solicitud = DB::table('solicitud_sustentacion as ss')
                            ->join('tesis_2022 as ts','ss.cod_tesis','ts.cod_tesis')
                            ->join('estudiante_ct2022 as es','ts.cod_matricula','es.cod_matricula')
                            ->join('asesor_curso as ac','ts.cod_asesor','ac.cod_docente')
                            ->select('es.*','ac.nombres as nombresAsesor','ac.apellidos as apellidosAsesor','ss.fecha_solicitud')
                            ->where('ss.estado',1)
                            //->where('e.cod_matricula', 'like', '%' . $buscarAlumno . '%')
                            ->orderBy('es.apellidos')->get();
            //}
        }

        return view('cursoTesis20221.director.evaluacion.listaSolicitudesDesignacionJurado',['solicitud' => $solicitud, 'semestre' => $semestre]);
    }






    public function verSolicitudSustentacion(){
        $id = auth()->user()->name;
        $aux = explode('-', $id);
        $id = $aux[0];

        $autor = DB::table('estudiante_ct2022')->where('estudiante_ct2022.cod_matricula', $id)->first();
        $tesis = Tesis_2022::where('cod_matricula',$autor->cod_matricula)->first();

        $solicitudes = SolicitudSustentacion::where('cod_tesis',$tesis->cod_tesis)->get();
        return view('cursoTesis20221.estudiante.sustentacion.verSolicitudSustentacion',['tesis'=>$tesis, 'solicitudes'=>$solicitudes]);
    }

    public function guardarSolicitud(Request $request){
        $razon ="";
        $solicitud = new SolicitudSustentacion();
        $solicitud->cod_tesis = $request->cod_tesis;
        $solicitud->voucher = "";
        if($request->razonSolicitud != 0){
            switch($request->razonSolicitud){
                case 1:
                    $razon = "Designación de jurados";
                    break;
                case 2:
                    $razon = "Designación de jurados - 2da vez";
                    break;
                case 3:
                    $razon = "Designación de jurados - Reevaluacion";
                    break;
            }
        }
        $solicitud->razon_solicitud = $razon;
        $solicitud->fecha_solicitud = date("Y-m-d H:i:s");;
        $solicitud->save();
        return redirect()->route('user_information');

    }

    public function historicoSolicitud(){
        $id = auth()->user()->name;
        $aux = explode('-', $id);
        $id = $aux[0];

        $autor = DB::table('estudiante_ct2022')->where('estudiante_ct2022.cod_matricula', $id)->first();
        $tesis = Tesis_2022::where('cod_matricula',$autor->cod_matricula)->first();
        $solicitudes = SolicitudSustentacion::where('cod_tesis',$tesis->cod_tesis)->get();
        return view('cursoTesis20221.estudiante.sustentacion.historicoSolicitud',['solicitudes'=>$solicitudes]);
    }


    public function listarAlumnosInforme(){
        $asesor = AsesorCurso::where('username',auth()->user()->name)->get();
        $estudiantes = DB::table('estudiante_ct2022 as e')
                        ->join('tesis_2022 as t', 'e.cod_matricula', '=', 't.cod_matricula')
                        ->select('e.*', 't.cod_docente', 't.estado as estadoTesis', 't.cod_tesis')
                        ->where('t.cod_docente', $asesor[0]->cod_docente)->orderBy('e.apellidos', 'asc')->get();
        return view('cursoTesis20221.asesor.sustentacion.listaEstudiantesInforme',['estudiantes'=>$estudiantes]);
    }

    public function crearInformeFinal(Request $request){
        $tesis = Tesis_2022::where('cod_tesis',$request->cod_tesis)->first();
        $autor = EstudianteCT2022::find($tesis->cod_matricula);
        return view('cursoTesis20221.asesor.sustentacion.crearInformeFinal',['tesis'=>$tesis,'autor'=>$autor ]);
    }

    public function guardarInformeFinal(Request $request){
        $id = auth()->user()->name;
        $asesor = DB::table('asesor_curso as a')->select('a.*')->where('a.username',$id)->get();
        $informe = new InformeFinal();
        $informe->introduccion = $request->taIntroduccion;
        $informe->aporte_investigacion = $request->taAporte;
        $informe->metodologia_empleada = $request->taMetodologia;
        $informe->fecha_informe = date("Y-m-d H:i:s");
        $informe->cod_asesor = $asesor[0]->cod_docente;
        $informe->cod_tesis = $request->cod_tesis;
        $informe->save();
        return redirect()->route('asesor.listaEstudiantesInforme');
    }

}
