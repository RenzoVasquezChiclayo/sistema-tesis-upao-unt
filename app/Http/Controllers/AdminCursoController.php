<?php

namespace App\Http\Controllers;

use App\Imports\AlumnosImport;
use App\Imports\AsesorImport;

use App\Models\AsesorCurso;
use App\Models\EstudianteCT2022;
use App\Models\MatrizOperacional;
use App\Models\ObservacionesProy;
use App\Models\ObservacionesProyCurso;
use App\Models\Tesis_2022;
use App\Models\TesisCT2022;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;


class AdminCursoController extends Controller
{
    public function information(){
        $id = auth()->user()->name;
        $aux = explode('-',$id);
        $id = $aux[0];
        if(auth()->user()->rol == 'CTesis2022-1'){
            $estudiante = EstudianteCT2022::find($id);
            $existTesis = TesisCT2022::where('cod_matricula',$estudiante->cod_matricula)->get();
            $existTesisII = Tesis_2022::where('cod_matricula',$estudiante->cod_matricula)->get();

            if($existTesis->count()==0){
                $newTesis = new TesisCT2022();
                $newTesis->cod_matricula = $estudiante->cod_matricula;
                $newTesis->nombres = $estudiante->nombres.' '.$estudiante->apellidos;
                $newTesis->save();

                $tesis = TesisCT2022::where('cod_matricula','=',$estudiante->cod_matricula)->get();

                $matriz = new MatrizOperacional();
                $matriz->cod_tesis = $tesis[0]->cod_proyectotesis;
                $matriz->save();



            }
            if ($existTesisII->count()==0) {
                $newTesisII = new Tesis_2022();
                $newTesisII->cod_matricula = $estudiante->cod_matricula;
                // $newTesisII->nombres = $estudiante->nombres.' '.$estudiante->apellidos;
                $newTesisII->save();
            }

        }
        //$egresado = Egresado::find($id);
        $usuario = User::where('name',$id.'-C')->first();
        $estudiante = DB::table('estudiante_ct2022 as E')->where('E.cod_matricula',$id)->first();
        $asesor = DB::table('asesor_curso as A')->where('A.username',$id)->first();
        //dd($aux);
        $img = 'profile-notfound.jpg';
        // $imagen = ImgEgresado::find($id);
        // if($imagen != null){
        //     $img=$imagen->referencia;
        // }
        return view('user.informacion',['usuario'=>$usuario,'img'=>$img,'estudiante'=>$estudiante,'asesor'=>$asesor]);
    }

    public function updateInformation(Request $request){
        $id = auth()->user()->name;
        $asesor = DB::table('asesor_curso as A')->where('A.username',$id)->first();
        try {
            $findAsesor = AsesorCurso::find($asesor->cod_docente);
            $findAsesor->direccion = $request->txtnewdireccion;
            $findAsesor->save();
            return redirect()->route('user_information')->with('datos','okUpdate');
        } catch (\Throwable $th) {
            return redirect()->route('user_information')->with('datos','oknotUpdate');
        }


    }

    public function saveUser(Request $request){

        $usuario = User::where('name','=',$request->txtCodUsuario)->first();
        try {
            $usuario->password = md5($request->txtNuevaContra);
            $usuario->save();
            return redirect()->route('user_information')->with('datos','ok');
            //Recuerda que luego de actualizar tu contrasena, no podras volver a cambiarla hasta luego de 7 dias.
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('user_information')->with('datos','oknot');
        }

    }


    public function showAddEstudiante(){
        return view('cursoTesis20221.director.agregarAlumno');
    }
    public function showAddAsesor(){
        return view('cursoTesis20221.director.agregarAsesor');
    }

    public function importRegistroAlumnos(Request $request){
        if ($request->hasFile('importAlumno')) {
            try {

                $path = $request->file('importAlumno');

                Excel::import(new AlumnosImport,$path);

                return back()->with('datos','ok');
            } catch (\Throwable $th) {
                return back()->with('datos','oknot');

            }



        }else {
            return back()->with('datos','oknot');
        }

    }

    public function importRegistroAsesores(Request $request){
        if ($request->hasFile('importAsesor')) {
            try {
                $path = $request->file('importAsesor');
                Excel::import(new AsesorImport,$path);

                return back()->with('datos','ok');
            } catch (\Throwable $th) {
                return back()->with('datos','oknot');
            }



        }else {
            return back()->with('datos','oknot');
        }

    }

    public function agregarAsesor(Request $request){

        $data = $request->validate([
            'cod_docente'=>'required',
            'apellidos' => 'required',
            'nombres'=> 'required',
            'carrera'=>'required',
            'gradAcademico'=>'required',
            'direccion'=>'required',

        ]);
        $existAsesor = AsesorCurso::where('cod_docente',$request->cod_docente)->get();
        if($existAsesor->count()==0){
            $newAsesor=new AsesorCurso();
            $newAsesor->cod_docente = $request->cod_docente;
            $newAsesor->nombres = strtoupper($request->apellidos).' '.strtoupper($request->nombres);
            switch ($request->gradAcademico) {
                case 0:
                    $newAsesor->grado_academico = 'NOMBRADO';
                    break;
                case 1:
                    $newAsesor->grado_academico = 'CONTRATADO';
                    break;
            }
            switch ($request->carrera) {
                case 0:
                    $newAsesor->titulo_profesional = 'CONTABILIDAD Y FINANZAS';
                    break;
                case 1:
                    $newAsesor->titulo_profesional = 'ADMINISTRACION';
                    break;
                case 2:
                    $newAsesor->titulo_profesional = 'ECONOMIA';
                    break;
            }
            $newAsesor->direccion = $request->direccion;
            $newAsesor->save();

            return redirect()->route('director.veragregarAsesor')->with('datos','ok');

        }


        return redirect()->route('director.veragregarAsesor')->with('datos','oknot');
    }


    public function agregarEstudiante(Request $request){
        $data = $request->validate([
            'cod_matricula'=>'required',
            'dni'=>'required',
            'apellidos' => 'required',
            'nombres'=> 'required',

        ]);
        $existEstudiante = EstudianteCT2022::where('cod_matricula',$request->cod_matricula)->get();
        if($existEstudiante->count()==0){
            $newEstudiante=new EstudianteCT2022();
            $newEstudiante->cod_matricula = $request->cod_matricula;
            $newEstudiante->dni = $request->dni;
            $newEstudiante->apellidos = $request->apellidos;
            $newEstudiante->nombres = $request->nombres;
            $newEstudiante->save();

            return redirect()->route('director.veragregar')->with('datos','ok');
        }
        return redirect()->route('director.veragregar')->with('datos','oknot');
    }

    const PAGINATION = 10;
    public function verListaObservacion(Request $request){
        $buscarObservaciones = $request->get('buscarObservacion');
        $id = auth()->user()->name;
        $asesor = AsesorCurso::where('username',$id)->get();
        if (is_numeric($buscarObservaciones)) {
            $estudiantes = DB::connection('mysql')->table('estudiante_ct2022')->join('proyecto_tesis','estudiante_ct2022.cod_matricula','=','proyecto_tesis.cod_matricula')->join('historial_observaciones','proyecto_tesis.cod_proyectotesis','=','historial_observaciones.cod_proyectotesis')
                            ->select('estudiante_ct2022.*','proyecto_tesis.escuela','historial_observaciones.fecha','historial_observaciones.cod_historialObs')->where('proyecto_tesis.cod_matricula','like','%'.$buscarObservaciones.'%')->where('proyecto_tesis.cod_docente',$asesor[0]->cod_docente)->paginate($this::PAGINATION);
        } else {
            $estudiantes = DB::connection('mysql')->table('estudiante_ct2022')->join('proyecto_tesis','estudiante_ct2022.cod_matricula','=','proyecto_tesis.cod_matricula')->join('historial_observaciones','proyecto_tesis.cod_proyectotesis','=','historial_observaciones.cod_proyectotesis')
                            ->select('estudiante_ct2022.*','historial_observaciones.fecha','historial_observaciones.cod_historialObs')->where('estudiante_ct2022.apellidos','like','%'.$buscarObservaciones.'%')->where('proyecto_tesis.cod_docente',$asesor[0]->cod_docente)->paginate($this::PAGINATION);
        }

        if(empty($estudiantes)){
            return view('cursoTesis20221.asesor.listaObservaciones',['buscarObservaciones'=>$buscarObservaciones,'estudiantes'=>$estudiantes])->with('datos','No se encontro algun registro');
        }else{
            return view('cursoTesis20221.asesor.listaObservaciones',['buscarObservaciones'=>$buscarObservaciones,'estudiantes'=>$estudiantes]);
        }

    }

    public function verObsEstudiante($cod_historialObs){
        $observaciones = ObservacionesProy::where('cod_historialObs',$cod_historialObs)->get();
        $estudiante = TesisCT2022::join('historial_observaciones','proyecto_tesis.cod_proyectotesis','=','historial_observaciones.cod_proyectotesis')->select('proyecto_tesis.*')->where('historial_observaciones.cod_historialObs',$cod_historialObs)->get();
        return view('cursoTesis20221.asesor.verObservacionEstudiante',['observaciones'=>$observaciones,'estudiante'=>$estudiante]);
    }

}
