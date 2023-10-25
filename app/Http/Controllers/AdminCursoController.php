<?php

namespace App\Http\Controllers;

use App\Imports\AlumnosImport;
use App\Imports\AsesorImport;
use App\Models\Asesor_Semestre;
use App\Models\AsesorCurso;
use App\Models\Categoria_Docente;
use App\Models\Configuraciones_Iniciales;
use App\Models\Diseno_Investigacion;
use App\Models\Estudiante_Semestre;
use App\Models\EstudianteCT2022;
use App\Models\Fin_Persigue;
use App\Models\MatrizOperacional;
use App\Models\Objetivo;
use App\Models\ObservacionesProy;
use App\Models\ObservacionesProyCurso;
use App\Models\Grado_Academico;
use App\Models\referencias;
use App\Models\Tesis_2022;
use App\Models\TesisCT2022;
use App\Models\TipoInvestigacion;
use App\Models\TObjetivo;
use App\Models\TReferencias;
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
    public function information()
    {
        $id = auth()->user()->name;
        $aux = explode('-', $id);
        $id = $aux[0];
        if (auth()->user()->rol == 'CTesis2022-1') {
            $estudiante = DB::table('estudiante_ct2022')->where('cod_matricula', $id)->first();
            $existTesis = TesisCT2022::where('cod_matricula', $estudiante->cod_matricula)->get();
            $existTesisII = Tesis_2022::where('cod_matricula', $estudiante->cod_matricula)->get();

            if ($existTesis->count() == 0) {
                $newTesis = new TesisCT2022();
                $newTesis->cod_matricula = $estudiante->cod_matricula;
                $newTesis->save();

                $proytesis = TesisCT2022::where('cod_matricula', '=', $estudiante->cod_matricula)->first();

                $matriz = new MatrizOperacional();
                $matriz->cod_proyectotesis = $proytesis->cod_proyectotesis;
                $matriz->save();
            } else {
                $matrizxTesisFind = MatrizOperacional::where('cod_proyectotesis', $existTesis[0]->cod_proyectotesis)->get();

                if ($matrizxTesisFind->count() == 0) {
                    $matriz = new MatrizOperacional();
                    $matriz->cod_proyectotesis = $existTesis[0]->cod_proyectotesis;
                    $matriz->save();
                }
            }
            if ($existTesisII->count() == 0) {
                $newTesisII = new Tesis_2022();
                $newTesisII->cod_matricula = $estudiante->cod_matricula;
                $newTesisII->save();
            }
        }

        //FUNCION PROVICIONAL PARA COPIAR LOS DATOS DEL PROY TESIS A LA TESIS DE LOS ESTUDIANTES

        // if (auth()->user()->rol == 'd-CTesis2022-1') {
        //     $proytesisFound = DB::table("proyecto_tesis as pyt")
        //         ->select("pyt.*")->get();
        //     foreach ($proytesisFound as $key => $proy) {
        //         $objetivos_pyt = Objetivo::where('cod_proyectotesis', '=', $proy->cod_proyectotesis)->latest('cod_objetivo')->get();
        //         $referencias_pyt = referencias::where('cod_proyectotesis', '=', $proy->cod_proyectotesis)->latest('cod_referencias')->get();
        //         $tesis = Tesis_2022::where("cod_matricula",$proy->cod_matricula)->first();
        //         if ($tesis != null) {
        //             $tesis->titulo = $proy->titulo;
        //             $tesis->real_problematica = $proy->real_problematica;
        //             $tesis->antecedentes = $proy->antecedentes;
        //             $tesis->justificacion = $proy->justificacion;
        //             $tesis->formulacion_prob = $proy->formulacion_prob;
        //             try {
        //                 if ($objetivos_pyt->count() != 0) {
        //                     foreach ($objetivos_pyt as $obj) {
        //                         $objetivos_t = new TObjetivo();
        //                         $objetivos_t->tipo = $obj->tipo;
        //                         $objetivos_t->descripcion = $obj->descripcion;
        //                         $objetivos_t->cod_tesis = $tesis->cod_tesis;
        //                         $objetivos_t->save();
        //                     }
        //                 }
        //             } catch (\Throwable $th) {
        //                 //throw $th;
        //             }
        //             $tesis->marco_teorico = $tesis->marco_teorico;
        //             $tesis->marco_conceptual = $tesis->marco_conceptual;
        //             $tesis->marco_legal = $tesis->marco_legal;
        //             $tesis->form_hipotesis = $tesis->form_hipotesis;
        //             $tesis->objeto_estudio = $tesis->objeto_estudio;
        //             $tesis->poblacion = $tesis->poblacion;
        //             $tesis->muestra = $tesis->muestra;
        //             $tesis->metodos = $tesis->metodos;
        //             $tesis->tecnicas_instrum = $tesis->tecnicas_instrum;
        //             $tesis->instrumentacion = $tesis->instrumentacion;
        //             $tesis->estg_metodologicas = $tesis->estg_metodologicas;
        //             try {
        //                 if ($referencias_pyt->count() != 0) {
        //                     foreach ($referencias_pyt as $ref) {
        //                         $referencias_t = new TReferencias();
        //                         $referencias_t->cod_tiporeferencia = $ref->cod_tiporeferencia;
        //                         $referencias_t->autor = $ref->autor;
        //                         $referencias_t->fPublicacion = $ref->fPublicacion;
        //                         $referencias_t->titulo = $ref->titulo;
        //                         $referencias_t->fuente = $ref->fuente;
        //                         $referencias_t->editorial =  $ref->editorial;
        //                         $referencias_t->title_cap = $ref->title_cap;
        //                         $referencias_t->num_capitulo = $ref->num_capitulo;
        //                         $referencias_t->title_revista = $ref->title_revista;
        //                         $referencias_t->volumen = $ref->volumen;
        //                         $referencias_t->name_web = $ref->name_web;
        //                         $referencias_t->name_periodista = $ref->name_periodista;
        //                         $referencias_t->name_institucion = $ref->name_institucion;
        //                         $referencias_t->subtitle = $ref->subtitle;
        //                         $referencias_t->name_editor = $ref->name_editor;
        //                         $referencias_t->cod_tesis = $tesis->cod_tesis;
        //                         $referencias_t->save();
        //                     }
        //                 }
        //             } catch (\Throwable $th) {
        //                 //throw $th;
        //             }
        //             $tesis->save();
        //         }
        //     }
        // }


        $usuario = User::where('name', $id . '-C')->first();
        $estudiante = DB::table('estudiante_ct2022 as E')->where('E.cod_matricula', $id)->first();
        $asesor = DB::table('asesor_curso as A')->where('A.username', $id)->first();
        $img = 'profile-notfound.jpg';

        return view('user.informacion', ['usuario' => $usuario, 'img' => $img, 'estudiante' => $estudiante, 'asesor' => $asesor]);
    }

    public function updateInformation(Request $request)
    {
        $id = auth()->user()->name;
        $asesor = DB::table('asesor_curso as A')->where('A.username', $id)->first();
        try {
            $findAsesor = AsesorCurso::find($asesor->cod_docente);
            $findAsesor->direccion = $request->txtnewdireccion;
            $findAsesor->save();
            return redirect()->route('user_information')->with('datos', 'okUpdate');
        } catch (\Throwable $th) {
            return redirect()->route('user_information')->with('datos', 'oknotUpdate');
        }
    }

    public function mantenedorLineaInves(Request $request)
    {
        $buscarpor_semestre = $request->buscarpor_semestre;

        if ($buscarpor_semestre > 0) {
            $lineasInves = DB::table('tipoinvestigacion')->select('tipoinvestigacion.*')->where('tipoinvestigacion.cod_semestre_academico', 'like', '%' . $buscarpor_semestre . '%')->paginate($this::PAGINATION);
            $fin_persigue = DB::table('fin_persigue')->select('fin_persigue.*')->where('fin_persigue.cod_semestre_academico', 'like', '%' . $buscarpor_semestre . '%')->paginate($this::PAGINATION);
            $diseno_investigacion = DB::table('diseno_investigacion')->select('diseno_investigacion.*')->where('diseno_investigacion.cod_semestre_academico', 'like', '%' . $buscarpor_semestre . '%')->paginate($this::PAGINATION);
            $semestre_academico = DB::table('configuraciones_iniciales')->select('*')->where('estado',1)->get();
        } else {
            $lineasInves = DB::table('tipoinvestigacion')->select('tipoinvestigacion.*')->get();
            $fin_persigue = DB::table('fin_persigue')->select('fin_persigue.*')->get();
            $diseno_investigacion = DB::table('diseno_investigacion')->select('diseno_investigacion.*')->get();
            $semestre_academico = DB::table('configuraciones_iniciales')->select('*')->where('estado',1)->get();
        }
        return view('cursoTesis20221.director.mantenedorGeneralidades', ['lineasInves' => $lineasInves, 'fin_persigue' => $fin_persigue, 'diseno_investigacion' => $diseno_investigacion, 'buscarpor_semestre' => $buscarpor_semestre,'semestre_academico'=>$semestre_academico]);
    }

    public function agregarGeneralidades()
    {
        $escuela = DB::table('escuela')->select('escuela.*')->get();
        $linea_investigacion = DB::table('tipoinvestigacion')->select('tipoinvestigacion.*')->get();
        $fin_persigue = DB::table('fin_persigue')->select('fin_persigue.*')->get();
        $diseno_investigacion = DB::table('diseno_investigacion')->select('diseno_investigacion.*')->get();
        $semestre_academico = DB::table('configuraciones_iniciales')->select('*')->get();
        return view('cursoTesis20221.director.actualizarGeneralidades', [
            'escuela' => $escuela,
            'linea_investigacion' => $linea_investigacion, 'fin_persigue' => $fin_persigue, 'diseno_investigacion' => $diseno_investigacion,'semestre_academico'=>$semestre_academico
        ]);
    }

    public function editarLineaInves(Request $request)
    {
        $id = $request->auxid;
        $linea_find = DB::table('tipoinvestigacion')->where('cod_tinvestigacion', $id)->get();
        return view('cursoTesis20221.director.editarLineaInves', ['linea_find' => $linea_find]);
    }

    public function saveEditarLineaInves(Request $request)
    {
        $linea = TipoInvestigacion::find($request->cod_tinvestigacion);
        $linea->descripcion = $request->descripcion;
        $linea->save();
        return redirect()->route('director.mantenedorlineaInves')->with('datos', 'okEdit');
    }

    public function eliminarLineaInves(Request $request)
    {
        $linea = TipoInvestigacion::find($request->auxidDelete);
        $linea->delete();
        return redirect()->route('director.mantenedorlineaInves')->with('datos', 'okDelete');
    }

    public function eliminarFinPersigue(Request $request)
    {
        $f_p = Fin_Persigue::find($request->auxidDeleteF_P);
        $f_p->delete();
        return redirect()->route('director.mantenedorlineaInves')->with('datos', 'okDelete');
    }

    public function eliminarDisInvestiga(Request $request)
    {
        $d_i = Diseno_Investigacion::find($request->auxidDeleteD_I);
        $d_i->delete();
        return redirect()->route('director.mantenedorlineaInves')->with('datos', 'okDelete');
    }

    public function saveGeneralidades(Request $request)
    {
        $cod_escuela = $request->escuela;
        $semestre_aca = $request->semestre_academico;
        $linea_investigacion = $request->id_linea_investigacion;

        if ($request->listOldl_i != "") {
            $deletel_i = explode(",", $request->listOldl_i);
            for ($i = 0; $i < sizeof($deletel_i); $i++) {
                TipoInvestigacion::find($deletel_i[$i])->delete();
            }
        }
        if ($request->listOldf_p != "") {
            $deletef_p = explode(",", $request->listOldf_p);
            for ($i = 0; $i < sizeof($deletef_p); $i++) {
                Fin_Persigue::find($deletef_p[$i])->delete();
            }
        }
        if ($request->listOldd_i != "") {
            $deleted_i = explode(",", $request->listOldd_i);
            for ($i = 0; $i < sizeof($deleted_i); $i++) {
                Diseno_Investigacion::find($deleted_i[$i])->delete();
            }
        }

        if ($linea_investigacion != null) {
            foreach ($linea_investigacion as $l_i) {
                $datos[] = explode('_', $l_i);
            }
        }

        $fin_persigue = $request->id_fin_persigue;
        $diseno_investigacion = $request->id_diseno_investigacion;
        try {
            if ($linea_investigacion != null) {
                for ($i = 0; $i < sizeof($linea_investigacion); $i++) {
                    $new_linea_inves = new TipoInvestigacion();
                    $new_linea_inves->cod_tinvestigacion = $datos[$i][0];
                    $new_linea_inves->descripcion = $datos[$i][1];
                    $new_linea_inves->cod_escuela = $cod_escuela;
                    $new_linea_inves->cod_semestre_academico = $semestre_aca;
                    $new_linea_inves->save();
                }
            }
            if ($fin_persigue != null) {
                for ($i = 0; $i < sizeof($fin_persigue); $i++) {
                    $new_fin_persigue = new Fin_Persigue();
                    $new_fin_persigue->descripcion = $fin_persigue[$i];
                    $new_fin_persigue->cod_escuela = $cod_escuela;
                    $new_fin_persigue->cod_semestre_academico = $semestre_aca;
                    $new_fin_persigue->save();
                }
            }
            if ($diseno_investigacion != null) {
                for ($i = 0; $i < sizeof($diseno_investigacion); $i++) {
                    $new_diseno_investigacion = new Diseno_Investigacion();
                    $new_diseno_investigacion->descripcion = $diseno_investigacion[$i];
                    $new_diseno_investigacion->cod_escuela = $cod_escuela;
                    $new_diseno_investigacion->cod_semestre_academico = $semestre_aca;
                    $new_diseno_investigacion->save();
                }
            }
            return redirect()->route('director.generalidades')->with('datos', 'ok');
        } catch (\Throwable $th) {
            return redirect()->route('director.generalidades')->with('datos', 'oknot');
        }
    }

    public function reports()
    {
        $id = auth()->user()->name;
        $codigo = explode('-', $id);
        $porce = 0;
        $porcent = 0;
        $porcentaje = 0;
        $dato = "";
        $dato2 = "";
        if (sizeof($codigo) > 1) {
            $id = $codigo[0];
        }

        // ESTUDIANTES

        $proyTesis = DB::table('proyecto_tesis')
            ->where('cod_matricula', $id)->first();
        if ($proyTesis != null) {
            foreach ($proyTesis as $pt) {
                if ($pt != null) {
                    $porcentaje += 100 / 33;
                }
            }
        }
        // -------------------------------------------------------

        // ASESOR

        $asesor = DB::table('asesor_curso as ac')->where('ac.username', $id)->first();
        if ($asesor != null) {
            $MyProyTesis = DB::table('proyecto_tesis as pt')
                ->where('pt.cod_docente', $asesor->cod_docente)->get();
            $MyProyTesis->toArray();
            for ($i = 0; $i < count($MyProyTesis); $i++) {
                foreach ($MyProyTesis[$i] as $atributo) {
                    if ($atributo != null) {
                        $porcent += 100 / 33;
                    }
                }
                $dato2 .= $MyProyTesis[$i]->cod_matricula . '_' . (int)$porcent . '-';
                $porcent = 0;
            }
        }

        // ----------------------------------------------------------

        // DIRECTOR

        $totalEstudiantes = count(EstudianteCT2022::all());

        $totalAsesores = count(AsesorCurso::all());

        $AllProyTesis = DB::table('proyecto_tesis')->get();
        $AllProyTesis->toArray();
        for ($i = 0; $i < count($AllProyTesis); $i++) {
            foreach ($AllProyTesis[$i] as $atributo) {
                if ($atributo != null) {
                    $porce += 100 / 33;
                }
            }
            $dato .= $AllProyTesis[$i]->cod_matricula . '_' . (int)$porce . '-';
            $porce = 0;
        }
        // ---------------------------------------------------------
        return view('cursoTesis20221.reportes.listaReportes', [
            'porcentaje' => $porcentaje, 'totalEstudiantes' => $totalEstudiantes,
            'totalAsesores' => $totalAsesores, 'dato' => $dato, 'dato2' => $dato2
        ]);
    }

    public function descargarReporteProyT(Request $request)
    {

        // Traendo los datos del alumno y su porcentaje de la tabla reportes

        $lista_alumnos_table = $request->alumnos_porcen_table;

        foreach ($lista_alumnos_table as $fila) {
            $datos[] = explode('.', $fila);
        }
        // dd($datos);
        $fecha = Carbon::now();
        $pdf = PDF::loadView('cursoTesis20221.reportes.pdfAvanceProyT', compact('datos', 'fecha'));
        return $pdf->download('Reporte Avance Proyecto Tesis.pdf');
    }

    public function saveUser(Request $request)
    {

        $usuario = User::where('name', '=', $request->txtCodUsuario)->first();
        try {
            $usuario->password = md5($request->txtNuevaContra);
            $usuario->save();
            return redirect()->route('user_information')->with('datos', 'ok');
            //Recuerda que luego de actualizar tu contrasena, no podras volver a cambiarla hasta luego de 7 dias.
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('user_information')->with('datos', 'oknot');
        }
    }
    public function update_information_estudiante_asesor(Request $request)
    {
        $id = auth()->user()->rol;
        if ($id == 'a-CTesis2022-1') {
            $asesor = AsesorCurso::where('cod_docente', '=', $request->txtCodAsesor)->first();
            try {
                $asesor->correo = $request->correo;
                $asesor->save();
                return redirect()->route('user_information')->with('datos', 'okCorreo');
                //Recuerda que luego de actualizar tu contrasena, no podras volver a cambiarla hasta luego de 7 dias.
            } catch (\Throwable $th) {
                //throw $th;
                return redirect()->route('user_information')->with('datos', 'oknotCorreo');
            }
        } elseif ($id == 'CTesis2022-1') {
            $estudiante = EstudianteCT2022::where('cod_matricula', '=', $request->txtCodEstudiante)->first();
            try {
                $estudiante->correo = $request->correo;
                $estudiante->save();
                return redirect()->route('user_information')->with('datos', 'okCorreo');
                //Recuerda que luego de actualizar tu contrasena, no podras volver a cambiarla hasta luego de 7 dias.
            } catch (\Throwable $th) {
                //throw $th;
                return redirect()->route('user_information')->with('datos', 'oknotCorreo');
            }
        }
    }

    public function showAddEstudiante()
    {
        $semestre_academico = DB::table('configuraciones_iniciales')->select('*')->where('estado',1)->get();
        return view('cursoTesis20221.director.agregarAlumno',['semestre_academico'=>$semestre_academico]);
    }
    public function showAddAsesor()
    {
        $grados_academicos = DB::table('grado_academico')->select('*')->where('estado',1)->get();
        $categorias = DB::table('categoria_docente')->select('*')->where('estado',1)->get();
        $semestre_academico = DB::table('configuraciones_iniciales')->select('*')->where('estado',1)->get();
        return view('cursoTesis20221.director.agregarAsesor',['grados_academicos'=>$grados_academicos,'categorias'=>$categorias,'semestre_academico'=>$semestre_academico]);
    }

    public function importRegistroAlumnos(Request $request)
    {
        if ($request->hasFile('importAlumno')) {
            try {
                $semestre = $request->semestre_academico;
                $path = $request->file('importAlumno');

                Excel::import(new AlumnosImport($semestre), $path);

                return back()->with('datos', 'ok');
            } catch (\Throwable $th) {
                return back()->with('datos', 'oknot');
            }
        } else {
            return back()->with('datos', 'oknot');
        }
    }

    public function importRegistroAsesores(Request $request)
    {
        if ($request->hasFile('importAsesor')) {
            try {
                $semestre = $request->semestre_academico;
                $path = $request->file('importAsesor');
                Excel::import(new AsesorImport($semestre), $path);
                return back()->with('datos', 'ok');
            } catch (\Throwable $th) {
                dd($th);
                return back()->with('datos', 'oknot');
            }
        } else {
            return back()->with('datos', 'oknot');
        }
    }

    public function agregarAsesor(Request $request)
    {
        try {
            $data = $request->validate([
                'cod_docente' => 'required',
                'apellidos' => 'required',
                'nombres' => 'required',
                'categoria' => 'required',
                'gradAcademico' => 'required',
                'direccion' => 'required',

            ]);
            $semestre_academico = $request->semestre_hidden;
            $existAsesor = AsesorCurso::where('cod_docente', $request->cod_docente)->get();

            if ($existAsesor->count() == 0) {
                $newAsesor = new AsesorCurso();
                $newAsesor->cod_docente = $request->cod_docente;
                $newAsesor->apellidos = strtoupper($request->apellidos);
                $newAsesor->nombres = strtoupper($request->nombres);
                $newAsesor->orcid = $request->orcid;
                $newAsesor->cod_grado_academico = $request->gradAcademico;
                $newAsesor->cod_categoria = $request->categoria;
                $newAsesor->direccion = $request->direccion;
                $newAsesor->correo = $request->correo;
                $newAsesor->save();

                $new_asesor_semestre = new Asesor_Semestre();
                $new_asesor_semestre->cod_docente = $request->cod_docente;
                $new_asesor_semestre->cod_configuraciones = $semestre_academico;
                $new_asesor_semestre->save();
                return redirect()->route('director.veragregarAsesor')->with('datos', 'ok');
            }else{
                return redirect()->route('director.veragregarAsesor')->with('datos', 'oknot');
            }
        } catch (\Throwable $th) {
            dd($th);
        }




    }


    public function agregarEstudiante(Request $request)
    {
        $data = $request->validate([
            'cod_matricula' => 'required',
            'dni' => 'required',
            'apellidos' => 'required',
            'nombres' => 'required',

        ]);
        $semestre_academico = $request->semestre_hidden;
        $existEstudiante = EstudianteCT2022::where('cod_matricula', $request->cod_matricula)->get();
        if ($existEstudiante->count() == 0) {
            $newEstudiante = new EstudianteCT2022();
            $newEstudiante->cod_matricula = $request->cod_matricula;
            $newEstudiante->dni = $request->dni;
            $newEstudiante->apellidos = strtoupper($request->apellidos);
            $newEstudiante->nombres = strtoupper($request->nombres);
            $newEstudiante->correo = $request->correo;
            $newEstudiante->save();

            $new_asesor_semestre = new Estudiante_Semestre();
            $new_asesor_semestre->cod_matricula = $request->cod_matricula;
            $new_asesor_semestre->cod_configuraciones = $semestre_academico;
            $new_asesor_semestre->save();
            return redirect()->route('director.veragregar')->with('datos', 'ok');
        }
        return redirect()->route('director.veragregar')->with('datos', 'oknot');
    }


    public function verListaObservacion(Request $request)
    {
        $buscarObservaciones = $request->get('buscarObservacion');
        $id = auth()->user()->name;
        $asesor = AsesorCurso::where('username', $id)->get();
        if (is_numeric($buscarObservaciones)) {

            $estudiantes = DB::connection('mysql')->table('estudiante_ct2022')->join('proyecto_tesis', 'estudiante_ct2022.cod_matricula', '=', 'proyecto_tesis.cod_matricula')->join('historial_observaciones', 'proyecto_tesis.cod_proyectotesis', '=', 'historial_observaciones.cod_proyectotesis')
                ->select('estudiante_ct2022.*', 'proyecto_tesis.escuela', 'proyecto_tesis.estado', 'historial_observaciones.fecha', 'historial_observaciones.cod_historialObs')->where('proyecto_tesis.cod_matricula', 'like', '%' . $buscarObservaciones . '%')->where('proyecto_tesis.cod_docente', $asesor[0]->cod_docente)->paginate($this::PAGINATION);
        } else {
            $estudiantes = DB::connection('mysql')->table('estudiante_ct2022')->join('proyecto_tesis', 'estudiante_ct2022.cod_matricula', '=', 'proyecto_tesis.cod_matricula')->join('historial_observaciones', 'proyecto_tesis.cod_proyectotesis', '=', 'historial_observaciones.cod_proyectotesis')
                ->select('estudiante_ct2022.*', 'proyecto_tesis.estado', 'historial_observaciones.fecha', 'historial_observaciones.cod_historialObs')->where('estudiante_ct2022.apellidos', 'like', '%' . $buscarObservaciones . '%')->where('proyecto_tesis.cod_docente', $asesor[0]->cod_docente)->paginate($this::PAGINATION);
        }
        if (empty($estudiantes)) {
            return view('cursoTesis20221.asesor.listaObservaciones', ['buscarObservaciones' => $buscarObservaciones, 'estudiantes' => $estudiantes])->with('datos', 'No se encontro algun registro');
        } else {
            return view('cursoTesis20221.asesor.listaObservaciones', ['buscarObservaciones' => $buscarObservaciones, 'estudiantes' => $estudiantes]);
        }
    }

    public function verObsEstudiante($cod_historialObs)
    {
        $observaciones = ObservacionesProy::where('cod_historialObs', $cod_historialObs)->get();
        $estudiante = TesisCT2022::join('historial_observaciones', 'proyecto_tesis.cod_proyectotesis', '=', 'historial_observaciones.cod_proyectotesis')->select('proyecto_tesis.*')->where('historial_observaciones.cod_historialObs', $cod_historialObs)->get();
        return view('cursoTesis20221.asesor.verObservacionEstudiante', ['observaciones' => $observaciones, 'estudiante' => $estudiante]);
    }
    //Nuevas actualizaciones octubre 2023

    // CONFIGURACIONES INICIALES

    public function verConfiguracionesIniciales(){
        try {
            $lista_configuraciones = DB::table('configuraciones_iniciales')->select('*')->paginate($this::PAGINATION);
            return view('cursoTesis20221.administrador.configuraciones_iniciales.agregar_configuraciones_iniciales',['lista_configuraciones'=>$lista_configuraciones]);
        } catch (\Throwable $th) {
            dd($th);
        }

    }

    public function saveConfiguracionesIniciales(Request $request){
        try {
            $año = $request->year;
            $curso = $request->curso;
            $ciclo = $request->ciclo;
            if ($año != "" && $curso != "" && $ciclo != "") {
                $new_configuracion = new Configuraciones_Iniciales();
                $new_configuracion->año = $año;
                $new_configuracion->curso = strtoupper($curso);
                $new_configuracion->ciclo = $ciclo;
                $new_configuracion->save();
                return redirect()->route('admin.verConfiguraciones')->with('datos','ok');
            }else{
                return redirect()->route('admin.verConfiguraciones')->with('datos','okNotNull');
            }
        } catch (\Throwable $th) {
            return redirect()->route('admin.verConfiguraciones')->with('datos','okNot');
        }
    }

    public function ver_editar_configuraciones(Request $request)
    {
        try {
            $cod_configuracion = $request->auxid;
            $find_configuracion = DB::table('configuraciones_iniciales')->where('cod_configuraciones', $cod_configuracion)->first();
            return view('cursoTesis20221.administrador.configuraciones_iniciales.editar_configuraciones_iniciales', ['find_configuracion' => $find_configuracion]);
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function save_editar_configuraciones(Request $request){
        try {
            $cod_configuraciones = $request->auxid;
            $año = $request->year;
            $curso = $request->curso;
            $ciclo = $request->ciclo;
            $find_configuracion = Configuraciones_Iniciales::where('cod_configuraciones', $cod_configuraciones)->first();
            $find_configuracion->año = $año;
            $find_configuracion->curso = strtoupper($curso);
            $find_configuracion->ciclo = $ciclo;
            $find_configuracion->save();
            return redirect()->route('admin.verConfiguraciones')->with('datos','ok');
        } catch (\Throwable $th) {
            dd($th);
            return redirect()->route('admin.verConfiguraciones')->with('datos','okNot');
        }
    }

    public function changeStatusConfiguraciones(Request $request)
    {
        try {
            $cod_configuraciones = $request->aux_configuraciones;
            $find_configuraciones = Configuraciones_Iniciales::where('cod_configuraciones', $cod_configuraciones)->first();
            $find_configuraciones->estado = ($find_configuraciones->estado == 1) ? 0 : 1;
            $find_configuraciones->save();
            return redirect()->route('admin.verConfiguraciones');
        } catch (\Throwable $th) {
            return redirect()->route('admin.verConfiguraciones')->with('datos','okNotDelete');
        }
    }
    //

    // CATEGORIAS

    public function ver_agregar_categoria()
    {
        return view('cursoTesis20221.administrador.categoria.agregar_categoria_docente');
    }

    public function saveCategorias(Request $request)
    {
        try {
            $descripcion = $request->descripcion;
            $newCategoria = new Categoria_Docente();
            $newCategoria->descripcion = strtoupper($descripcion);
            $newCategoria->save();
            return redirect()->route('admin.categoriasDocente')->with('datos', 'ok');
        } catch (\Throwable $th) {
            return redirect()->route('admin.categoriasDocente')->with('datos', 'oknot');
        }
    }

    public function lista_agregar_categoria(Request $request)
    {
        $buscarCategoria = $request->buscarCategoria;
        if ($buscarCategoria != null) {
            $lista_categorias = DB::table('categoria_docente')->where('categoria_docente.descripcion', 'like', '%' . $buscarCategoria . '%')->paginate($this::PAGINATION);
        } else {
            $lista_categorias = DB::table('categoria_docente')->select('*')->paginate($this::PAGINATION);
        }
        return view('cursoTesis20221.administrador.categoria.listar_categoria_docente', ['lista_categorias' => $lista_categorias]);
    }

    public function ver_editar_categoria(Request $request)
    {
        try {
            $cod_categoria = $request->auxidcategoria;
            $find_categoria = DB::table('categoria_docente')->where('cod_categoria', $cod_categoria)->first();
            return view('cursoTesis20221.administrador.categoria.editar_categoria_docente', ['find_categoria' => $find_categoria]);
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function save_editar_categoria(Request $request)
    {
        try {
            $cod_categoria = $request->auxidcategoria;
            $descripcion = $request->descripcion;
            $find_categoria = Categoria_Docente::where('cod_categoria', $cod_categoria)->first();
            $find_categoria->descripcion = $descripcion;
            $find_categoria->save();
            return redirect()->route('admin.listarcategoriasDocente')->with('datos', 'ok');
        } catch (\Throwable $th) {
            return redirect()->route('admin.listarcategoriasDocente')->with('datos', 'oknot');
        }
    }

    public function changeStatusCategoria(Request $request)
    {
        try {
            $cod_categoria = $request->aux_categoria;
            $find_categoria = Categoria_Docente::where('cod_categoria', $cod_categoria)->first();
            $find_categoria->estado = ($find_categoria->estado == 1) ? 0 : 1;
            $find_categoria->save();
            return redirect()->route('admin.listarcategoriasDocente');
        } catch (\Throwable $th) {
            return redirect()->route('admin.listarcategoriasDocente')->with('datos', 'oknotdelete');
        }
    }

    //GRADO ACADEMICO

    public function verAgregarGrado(Request $request)
    {
        $grados_academicos = DB::table('grado_academico')->select('*')->paginate($this::PAGINATION);

        $buscarGrado = $request->get('buscarGrado');
        $grados_academicos = DB::connection('mysql')->table('grado_academico as ga')->select('ga.*')->where('ga.descripcion', 'like', '%' . $buscarGrado . '%')->paginate($this::PAGINATION);

        return view('cursoTesis20221.administrador.grado_academico.agregar_grado_academico', ['grados_academicos' => $grados_academicos]);
    }

    public function saveGradoAcademico(Request $request)
    {
        try {
            $description = strtoupper(trim($request->descripcion));
            $codGradoAcademico = $request->cod_grado_academico;

            if ($codGradoAcademico != "") {
                $grado = Grado_Academico::find($codGradoAcademico);
                $grado->descripcion = $description;
                $grado->save();
            } else {
                $existGrado = Grado_Academico::where('descripcion',$description)->first();
                if($existGrado != null){
                    return redirect()->route('admin.verAgregarGrado')->with('datos','duplicate');
                }
                $grado = new Grado_Academico();
                $grado->descripcion = $description;
                $grado->save();
            }
            return redirect()->route('admin.verAgregarGrado')->with('datos', 'ok');
        } catch (\Throwable $th) {
            return redirect()->route('admin.verAgregarGrado')->with('datos', 'oknot');
        }
    }

    public function changeStatusGrado(Request $request){
        try{
            $cod_grado = $request->aux_grado_academico;
            $find_grado = Grado_Academico::where('cod_grado_academico', $cod_grado)->first();
            $find_grado->estado = ($find_grado->estado == 1) ? 0 : 1;
            $find_grado->save();
            return redirect()->route('admin.verAgregarGrado');
        }catch(\Throwable $th){
            return redirect()->route('admin.verAgregarGrado')->with('datos', 'oknotdelete');
        }
    }

}
