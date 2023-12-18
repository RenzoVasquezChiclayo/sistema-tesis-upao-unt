<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AsesorCurso;
use App\Models\DesignacionJurados;
use App\Models\EstudianteCT2022;
use App\Models\InformeFinal;
use App\Models\SolicitudSustentacion;
use App\Models\Tesis_2022;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
Use PDF;

class SustentacionController extends Controller
{
    public function lista_solicitudes_jurados(Request $request){

                     $solicitud = DB::table('solicitud_sustentacion as ss')
                            ->join('tesis_2022 as ts','ss.cod_tesis','ts.cod_tesis')
                            ->join('estudiante_ct2022 as es','ts.cod_matricula','es.cod_matricula')
                            ->join('asesor_curso as ac','ts.cod_asesor','ac.cod_docente')
                            ->select('es.*','ac.nombres as nombresAsesor','ac.apellidos as apellidosAsesor','ss.fecha_solicitud','ss.razon_solicitud','ss.voucher','ts.cod_tesis')
                            ->where('ss.estado',1)
                            ->orderBy('es.apellidos')->get();

        return view('cursoTesis20221.director.evaluacion.listaSolicitudesDesignacionJurado',['solicitud' => $solicitud]);
    }

    public function verSolicitudSustentacion(){
        $id = auth()->user()->name;
        $aux = explode('-', $id);
        $id = $aux[0];

        $autor = DB::table('estudiante_ct2022')->where('estudiante_ct2022.cod_matricula', $id)->first();
        $tesis = Tesis_2022::where('cod_matricula',$autor->cod_matricula)
                    ->leftJoin('informe_final_asesor as ifa','ifa.cod_tesis','tesis_2022.cod_tesis')
                    ->select('tesis_2022.titulo','ifa.cod_informe_final','tesis_2022.cod_tesis')->where('tesis_2022.estado',3)->first();

        if ($tesis != null) {
            $solicitudes = SolicitudSustentacion::where('cod_tesis',$tesis->cod_tesis)->get();
            return view('cursoTesis20221.estudiante.sustentacion.verSolicitudSustentacion',['tesis'=>$tesis, 'solicitudes'=>$solicitudes]);
        }else{
            return view('cursoTesis20221.estudiante.sustentacion.verSolicitudSustentacion',['tesis'=>$tesis, 'solicitudes'=>[]]);
        }

    }

    public function guardarSolicitud(Request $request){
        try {

            $request->validate([
                'voucher' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);
            $tesis = DB::table('tesis_2022')->where('cod_tesis',$request->cod_tesis)->first();
            if($request->hasFile('voucher')){
                $voucher = $request->file('voucher');
                $destinationPath = 'cursoTesis-2022/img/alumnos-vouchers/solicitud-jurados/'.$tesis->cod_matricula;
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath,0777,true);
                }
                if ($voucher != null) {
                    $razon ="";
                    $solicitud = new SolicitudSustentacion();
                    $solicitud->cod_tesis = $request->cod_tesis;
                    $filename = $tesis->cod_matricula.'.jpg';
                    $uploadSuccess = $voucher->move($destinationPath,$filename);
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
                    $solicitud->voucher = $filename;
                    $solicitud->razon_solicitud = $razon;
                    $solicitud->fecha_solicitud = date("Y-m-d H:i:s");;
                    $solicitud->save();
                    return redirect()->route('alumno.historicoSolicitud')->with('datos','oksolicitud');
                }else{
                    return redirect()->route('alumno.historicoSolicitud')->with('datos','oknotsolicitud');
                }
            }
        } catch (\Throwable $th) {
            dd($th);
            //return redirect()->route('alumno.historicoSolicitud')->with('datos','oknotsolicitud');
        }

    }

    public function historicoSolicitud(){
        $id = auth()->user()->name;
        $aux = explode('-', $id);
        $id = $aux[0];

        $autor = DB::table('estudiante_ct2022')->where('estudiante_ct2022.cod_matricula', $id)->first();
        $tesis = Tesis_2022::where('cod_matricula',$autor->cod_matricula)->select('cod_tesis','cod_matricula')->first();
        $solicitudes = SolicitudSustentacion::where('cod_tesis',$tesis->cod_tesis)->get();
        return view('cursoTesis20221.estudiante.sustentacion.historicoSolicitud',['solicitudes'=>$solicitudes,'tesis'=>$tesis]);
    }


    public function listarAlumnosInforme(){
        $asesor = AsesorCurso::where('username',auth()->user()->name)->get();
        $estudiantes = DB::table('estudiante_ct2022 as e')
                        ->join('tesis_2022 as t', 'e.cod_matricula', '=', 't.cod_matricula')
                        ->leftJoin('informe_final_asesor as ifa','ifa.cod_tesis','t.cod_tesis')
                        ->select('e.*', 't.cod_docente', 't.estado as estadoTesis', 't.cod_tesis','ifa.cod_informe_final')
                        ->where('t.cod_docente', $asesor[0]->cod_docente)
                        ->where('t.estado', 3)
                        ->orderBy('e.apellidos', 'asc')->get();

        if (sizeof($estudiantes)>0) {
            return view('cursoTesis20221.asesor.sustentacion.listaEstudiantesInforme',['estudiantes'=>$estudiantes]);
        }else{
            return view('cursoTesis20221.asesor.sustentacion.listaEstudiantesInforme',['estudiantes'=>[]]);
        }

    }

    public function crearInformeFinal(Request $request){
        $tesis = Tesis_2022::where('cod_tesis',$request->cod_tesis)->first();
        $autor = EstudianteCT2022::find($tesis->cod_matricula);
        return view('cursoTesis20221.asesor.sustentacion.crearInformeFinal',['tesis'=>$tesis,'autor'=>$autor ]);
    }

    public function guardarInformeFinal(Request $request){
        try {
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
            return redirect()->route('asesor.listaEstudiantesInforme')->with('datos','okinforme');
        } catch (\Throwable $th) {
            return redirect()->route('asesor.listaEstudiantesInforme')->with('datos','oknotinforme');
        }

    }

    public function generarPDFInformeFinal(Request $request){
        try {
            $cod_tesis = $request->cod_tesis;
            $informe = DB::table('informe_final_asesor as ifa')
            ->join('tesis_2022 as t','t.cod_tesis','ifa.cod_tesis')
            ->join('estudiante_ct2022 as e','e.cod_matricula','t.cod_matricula')
            ->select('ifa.*','t.titulo','e.nombres','e.apellidos')
            ->where('ifa.cod_tesis',$cod_tesis)->first();
            $pdf = \PDF::loadView('cursoTesis20221.asesor.sustentacion.pdf.informePDF',['informe'=>$informe]);
            return $pdf->stream('informe_final.pdf');
        } catch (\Throwable $th) {
            return redirect()->route('asesor.listaEstudiantesInforme')->with('datos','oknotverInforme');
        }
    }

    // ----------------------------------------------------DESIGNACION DE JURADOS ----------------------------------------------------------------------------

    public function lista_tesis_aprobadas(Request $request){
        $tesis_aprobadas = DB::table('tesis_2022 as t')
        ->join('estudiante_ct2022 as es','es.cod_matricula','t.cod_matricula')
        ->join('asesor_curso as ac', 'ac.cod_docente','t.cod_asesor')
        ->leftJoin('designacion_jurados as dj','dj.cod_tesis','t.cod_tesis')
        ->select('t.cod_tesis','t.titulo','t.cod_matricula','es.nombres as nombresEstu','es.apellidos as apellidosEstu','ac.nombres as nombresAsesor','ac.apellidos as apellidosAsesor','ac.cod_docente as cod_asesor','dj.cod_jurado1','dj.cod_jurado2','dj.cod_vocal')
        ->where('t.estado',3)->where('t.condicion',"APROBADO")->get();

        $asesores = DB::table('asesor_curso as ac')->where('cod_docente','!=',$tesis_aprobadas[0]->cod_asesor)->get();
        return view('cursoTesis20221.director.evaluacion.asignacionDeJurados',['tesis_aprobadas'=>$tesis_aprobadas,'asesores'=>$asesores]);
    }

    public function save_asignacion_jurados(Request $request){
        try {
            $datos = explode(',',$request->saveJurados);
            for ($i=0;$i<count($datos);$i++){
                $jurados = explode('_',$datos[$i]);
                $new_asignacion = new DesignacionJurados();
                $new_asignacion->cod_tesis = $jurados[0];
                $new_asignacion->cod_jurado1 = $jurados[1];
                $new_asignacion->cod_jurado2 = $jurados[2];
                $new_asignacion->cod_vocal = $jurados[3];
                $new_asignacion->save();
            }
            return redirect()->route('director.listaTesisAprobadas')->with('datos','okdesigancion');
        } catch (\Throwable $th) {
           return redirect()->route('director.listaTesisAprobadas')->with('datos','oknotdesigancion');
        }
    }
    const PAGINATION3 = 10;
    public function verEditAsignacionJurados(){
        $tesis_asignadas = DB::table('tesis_2022 as t')
        ->join('estudiante_ct2022 as es','es.cod_matricula','t.cod_matricula')
        ->join('asesor_curso as ac', 'ac.cod_docente','t.cod_asesor')
        ->leftJoin('designacion_jurados as dj','dj.cod_tesis','t.cod_tesis')
        ->select('t.cod_tesis','t.titulo','t.cod_matricula','es.nombres as nombresEstu','es.apellidos as apellidosEstu','ac.nombres as nombresAsesor','ac.apellidos as apellidosAsesor','ac.cod_docente as cod_asesor','dj.cod_jurado1','dj.cod_jurado2','dj.cod_vocal')
        ->where('t.estado',3)->where('t.condicion',"APROBADO")->paginate($this::PAGINATION3);

        $asesores = DB::table('asesor_curso as ac')->get();
        return view('cursoTesis20221.director.evaluacion.editarAsignacionJurado',['tesis_asignadas'=>$tesis_asignadas,'asesores'=>$asesores]);
    }

    public function editAsignacionJurados(Request $request){
        //
        $datos = explode(',',$request->saveJurados);
        for ($i=0; $i < count($datos); $i++) {
            $jurados = explode('_',$datos[$i]);
            $asignacion = DesignacionJurados::where('cod_tesis',$jurados[0])->first();
            if($asignacion != null){
                $asignacion->cod_jurado1 = $jurados[1];
                $asignacion->cod_jurado2 = $jurados[2];
                $asignacion->cod_vocal = $jurados[3];
                $asignacion->save();
            }
        }
        return redirect()->route('director.verEditAsignacionJurados')->with('datos','okedit');
    }

}
