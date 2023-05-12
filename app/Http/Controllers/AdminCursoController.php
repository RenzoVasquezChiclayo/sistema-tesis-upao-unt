<?php

namespace App\Http\Controllers;

use App\Imports\AlumnosImport;
use App\Imports\AsesorImport;

use App\Models\AsesorCurso;
use App\Models\Diseno_Investigacion;
use App\Models\EstudianteCT2022;
use App\Models\Fin_Persigue;
use App\Models\MatrizOperacional;
use App\Models\ObservacionesProy;
use App\Models\ObservacionesProyCurso;
use App\Models\Tesis_2022;
use App\Models\TesisCT2022;
use App\Models\TipoInvestigacion;
use App\Models\User;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Carbon\Carbon;


class AdminCursoController extends Controller
{
    const PAGINATION = 10;
    public function information(){
        $id = auth()->user()->name;
        $aux = explode('-',$id);
        $id = $aux[0];
        if(auth()->user()->rol == 'CTesis2022-1'){
            $estudiante = DB::table('estudiante_ct2022')->where('cod_matricula',$id)->first();
            $existTesis = TesisCT2022::where('cod_matricula',$estudiante->cod_matricula)->get();
            $existTesisII = Tesis_2022::where('cod_matricula',$estudiante->cod_matricula)->get();

            if($existTesis->count()==0){
                $newTesis = new TesisCT2022();
                $newTesis->cod_matricula = $estudiante->cod_matricula;
                $newTesis->save();

                $proytesis = TesisCT2022::where('cod_matricula','=',$estudiante->cod_matricula)->first();

                $matriz = new MatrizOperacional();
                $matriz->cod_proyectotesis = $proytesis->cod_proyectotesis;
                $matriz->save();

            }else{
                $matrizxTesisFind = MatrizOperacional::where('cod_proyectotesis',$existTesis[0]->cod_proyectotesis)->get();

                if ($matrizxTesisFind->count()==0) {
                    $matriz = new MatrizOperacional();
                    $matriz->cod_proyectotesis = $existTesis[0]->cod_proyectotesis;
                    $matriz->save();
                }
            }
            if ($existTesisII->count()==0) {
                $newTesisII = new Tesis_2022();
                $newTesisII->cod_matricula = $estudiante->cod_matricula;
                $newTesisII->save();
            }

        }
        $usuario = User::where('name',$id.'-C')->first();
        $estudiante = DB::table('estudiante_ct2022 as E')->where('E.cod_matricula',$id)->first();
        $asesor = DB::table('asesor_curso as A')->where('A.username',$id)->first();
        $img = 'profile-notfound.jpg';

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

    public function mantenedorLineaInves(Request $request){
        $buscarpor_semestre = $request->buscarpor_semestre;

        if($buscarpor_semestre!=""){
            $lineasInves = DB::table('tipoinvestigacion')->select('tipoinvestigacion.*')->where('tipoinvestigacion.semestre_academico','like','%'.$buscarpor_semestre.'%')->paginate($this::PAGINATION);
            $fin_persigue = DB::table('fin_persigue')->select('fin_persigue.*')->where('fin_persigue.semestre_academico','like','%'.$buscarpor_semestre.'%')->paginate($this::PAGINATION);
            $diseno_investigacion = DB::table('diseno_investigacion')->select('diseno_investigacion.*')->where('diseno_investigacion.semestre_academico','like','%'.$buscarpor_semestre.'%')->paginate($this::PAGINATION);
        }else{
            $lineasInves = DB::table('tipoinvestigacion')->select('tipoinvestigacion.*')->get();
            $fin_persigue = DB::table('fin_persigue')->select('fin_persigue.*')->get();
            $diseno_investigacion = DB::table('diseno_investigacion')->select('diseno_investigacion.*')->get();
        }
        return view('cursoTesis20221.director.mantenedorGeneralidades',['lineasInves'=>$lineasInves,'fin_persigue'=>$fin_persigue,'diseno_investigacion'=>$diseno_investigacion,'buscarpor_semestre'=>$buscarpor_semestre]);



    }

    public function agregarGeneralidades(){
        $escuela = DB::table('escuela')->select('escuela.*')->get();
        $linea_investigacion = DB::table('tipoinvestigacion')->select('tipoinvestigacion.*')->get();
        $fin_persigue = DB::table('fin_persigue')->select('fin_persigue.*')->get();
        $diseno_investigacion = DB::table('diseno_investigacion')->select('diseno_investigacion.*')->get();
        return view('cursoTesis20221.director.actualizarGeneralidades',['escuela'=>$escuela,
                        'linea_investigacion'=>$linea_investigacion,'fin_persigue'=>$fin_persigue,'diseno_investigacion'=>$diseno_investigacion]);
    }

    public function editarLineaInves(Request $request){
        $id = $request->auxid;
        $linea_find = DB::table('tipoinvestigacion')->where('cod_tinvestigacion',$id)->get();
        return view('cursoTesis20221.director.editarLineaInves',['linea_find'=>$linea_find]);
    }

    public function saveEditarLineaInves(Request $request){
        $linea = TipoInvestigacion::find($request->cod_tinvestigacion);
        $linea-> descripcion = $request->descripcion;
        $linea->save();
        return redirect()->route('director.mantenedorlineaInves')->with('datos','okEdit');
    }

    public function eliminarLineaInves(Request $request){
        $linea = TipoInvestigacion::find($request->auxidDelete);
        $linea->delete();
        return redirect()->route('director.mantenedorlineaInves')->with('datos','okDelete');
    }

    public function eliminarFinPersigue(Request $request){
        $f_p = Fin_Persigue::find($request->auxidDeleteF_P);
        $f_p->delete();
        return redirect()->route('director.mantenedorlineaInves')->with('datos','okDelete');
    }

    public function eliminarDisInvestiga(Request $request){
        $d_i = Diseno_Investigacion::find($request->auxidDeleteD_I);
        $d_i->delete();
        return redirect()->route('director.mantenedorlineaInves')->with('datos','okDelete');
    }

    public function saveGeneralidades(Request $request){
        $cod_escuela = $request->escuela;
        $semestre_aca = $request->semestre_academico;
        $linea_investigacion = $request->id_linea_investigacion;
        if ($linea_investigacion != null) {
            foreach ($linea_investigacion as $l_i) {
                $datos[] = explode('_',$l_i);
            }
        }

        $fin_persigue = $request->id_fin_persigue;
        $diseno_investigacion = $request->id_diseno_investigacion;
        try {
            if ($linea_investigacion != null) {
                for ($i=0; $i < sizeof($linea_investigacion); $i++) {
                    $new_linea_inves = new TipoInvestigacion();
                    $new_linea_inves->cod_tinvestigacion = $datos[$i][0];
                    $new_linea_inves->descripcion = $datos[$i][1];
                    $new_linea_inves->cod_escuela = $cod_escuela;
                    $new_linea_inves->semestre_academico = $semestre_aca;
                    $new_linea_inves->save();
                }
            }
            if ($fin_persigue != null) {
                for ($i=0; $i < sizeof($fin_persigue); $i++) {
                    $new_fin_persigue = new Fin_Persigue();
                    $new_fin_persigue->descripcion = $fin_persigue[$i];
                    $new_fin_persigue->cod_escuela = $cod_escuela;
                    $new_fin_persigue->semestre_academico = $semestre_aca;
                    $new_fin_persigue->save();
                }
            }
            if ($diseno_investigacion != null) {
                for ($i=0; $i < sizeof($diseno_investigacion); $i++) {
                    $new_diseno_investigacion = new Diseno_Investigacion();
                    $new_diseno_investigacion->descripcion = $diseno_investigacion[$i];
                    $new_diseno_investigacion->cod_escuela = $cod_escuela;
                    $new_diseno_investigacion->semestre_academico = $semestre_aca;
                    $new_diseno_investigacion->save();
                }
            }
            return redirect()->route('director.generalidades')->with('datos','ok');
        } catch (\Throwable $th) {
            dd($th);
        }


    }

    public function reports(){
        $id = auth()->user()->name;
        $codigo = explode('-',$id);
        $porce = 0;
        $porcent = 0;
        $porcentaje = 0;
        $dato = "";
        $dato2 = "";
        if (sizeof($codigo)>1) {
            $id = $codigo[0];
        }

        // ESTUDIANTES

        $proyTesis = DB::table('proyecto_tesis')
                            ->where('cod_matricula',$id)->first();
        if ($proyTesis != null) {
            foreach ($proyTesis as $pt) {
                if ($pt!=null) {
                    $porcentaje += 100/33;
                }
            }
        }
        // -------------------------------------------------------

        // ASESOR

        $asesor = DB::table('asesor_curso as ac')->where('ac.username',$id)->first();
        if ($asesor != null) {
            $MyProyTesis = DB::table('proyecto_tesis as pt')
                            ->where('pt.cod_docente',$asesor->cod_docente)->get();
            $MyProyTesis->toArray();
            for ($i=0; $i < count($MyProyTesis); $i++) {
                foreach ($MyProyTesis[$i] as $atributo) {
                    if ($atributo!=null) {
                        $porcent += 100/33;
                    }
                }
                $dato2 .= $MyProyTesis[$i]->cod_matricula.'_'.(int)$porcent.'-';
                $porcent = 0;
            }
        }

        // ----------------------------------------------------------

        // DIRECTOR

        $totalEstudiantes = count(EstudianteCT2022::all());

        $totalAsesores = count(AsesorCurso::all());

        $AllProyTesis = DB::table('proyecto_tesis')->get();
        $AllProyTesis->toArray();
        for ($i=0; $i < count($AllProyTesis); $i++) {
            foreach ($AllProyTesis[$i] as $atributo) {
                if ($atributo!=null) {
                    $porce += 100/33;
                }
            }
            $dato .= $AllProyTesis[$i]->cod_matricula.'_'.(int)$porce.'-';
            $porce = 0;
        }
        // ---------------------------------------------------------
        return view('cursoTesis20221.reportes.listaReportes',['porcentaje'=>$porcentaje,'totalEstudiantes'=>$totalEstudiantes,
                                'totalAsesores'=>$totalAsesores,'dato'=>$dato,'dato2'=>$dato2]);
    }

    public function descargarReporteProyT(Request $request){

        // Traendo los datos del alumno y su porcentaje de la tabla reportes

        $lista_alumnos_table = $request->alumnos_porcen_table;

        foreach ($lista_alumnos_table as $fila) {
            $datos[] = explode('.',$fila);
        }
        // dd($datos);
        $fecha = Carbon::now();
        $pdf = PDF::loadView('cursoTesis20221.reportes.pdfAvanceProyT',compact('datos','fecha'));
        return $pdf->download('Reporte Avance Proyecto Tesis.pdf');
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
                $semestre = $request->semestre_academico;
                $path = $request->file('importAlumno');

                Excel::import(new AlumnosImport($semestre),$path);

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
                $semestre = $request->semestre_academico;
                $path = $request->file('importAsesor');
                Excel::import(new AsesorImport($semestre),$path);
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
        $semestre_academico = $request->semestre_hidden;
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
            $newAsesor->semestre_academico = $semestre_academico;
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
        $semestre_academico = $request->semestre_hidden;
        $existEstudiante = EstudianteCT2022::where('cod_matricula',$request->cod_matricula)->get();
        if($existEstudiante->count()==0){
            $newEstudiante=new EstudianteCT2022();
            $newEstudiante->cod_matricula = $request->cod_matricula;
            $newEstudiante->dni = $request->dni;
            $newEstudiante->apellidos = $request->apellidos;
            $newEstudiante->nombres = $request->nombres;
            $newEstudiante->semestre_academico = $semestre_academico;
            $newEstudiante->save();

            return redirect()->route('director.veragregar')->with('datos','ok');
        }
        return redirect()->route('director.veragregar')->with('datos','oknot');
    }


    public function verListaObservacion(Request $request){
        $buscarObservaciones = $request->get('buscarObservacion');
        $id = auth()->user()->name;
        $asesor = AsesorCurso::where('username',$id)->get();
        if (is_numeric($buscarObservaciones)) {

            $estudiantes = DB::connection('mysql')->table('estudiante_ct2022')->join('proyecto_tesis','estudiante_ct2022.cod_matricula','=','proyecto_tesis.cod_matricula')->join('historial_observaciones','proyecto_tesis.cod_proyectotesis','=','historial_observaciones.cod_proyectotesis')
                            ->select('estudiante_ct2022.*','proyecto_tesis.escuela','proyecto_tesis.estado','historial_observaciones.fecha','historial_observaciones.cod_historialObs')->where('proyecto_tesis.cod_matricula','like','%'.$buscarObservaciones.'%')->where('proyecto_tesis.cod_docente',$asesor[0]->cod_docente)->paginate($this::PAGINATION);
        } else {
            $estudiantes = DB::connection('mysql')->table('estudiante_ct2022')->join('proyecto_tesis','estudiante_ct2022.cod_matricula','=','proyecto_tesis.cod_matricula')->join('historial_observaciones','proyecto_tesis.cod_proyectotesis','=','historial_observaciones.cod_proyectotesis')
                            ->select('estudiante_ct2022.*','proyecto_tesis.estado','historial_observaciones.fecha','historial_observaciones.cod_historialObs')->where('estudiante_ct2022.apellidos','like','%'.$buscarObservaciones.'%')->where('proyecto_tesis.cod_docente',$asesor[0]->cod_docente)->paginate($this::PAGINATION);
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
