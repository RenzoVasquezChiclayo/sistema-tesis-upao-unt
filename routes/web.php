<?php

use App\Http\Controllers\AdminCursoController;
use App\Http\Controllers\CursoTesisController;
use App\Http\Controllers\EstudianteTesisController;
use App\Http\Controllers\EvaluacionController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\SustentacionController;
use App\Http\Controllers\SustentacionProyectoController;
use App\Http\Controllers\Tesis2022Controller;
use App\Models\EstudianteCT2022;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [LoginController::class, 'index'])
    ->name('indexlogin')->middleware('guest');
Route::controller(LoginController::class)->group(function () {

    //Modified
    Route::post('/verificate-login', 'validateLogin')
        ->name('login.verificate');
    Route::post('/logout', 'logout')
        ->name('login.logout');


    Route::post('send-password-reset/', 'enviarCorreoParaCambio')
        ->name('correo_reset');

    Route::get('recuperar-contraseña/', 'verRecuperarContraseña')
        ->name('recuperar_contra');

    Route::post('guardar-password-reset/', 'guardarResetContraseña')
        ->name('guardar_reset_contra');
});

/* Agrupamos las rutas que tienen acceso 'auth' */
Route::middleware('auth')->group(function () {
    Route::controller(RolController::class)->group(function () {
        Route::get('/listar-roles', 'listarRoles')->name('rol.listar');
        Route::post('/guardar-rol',  'guardarRol')->name('rol.guardarRol');
        Route::delete('/delete-rol',  'deleteRol')->name('rol.deleteRol');
    });

    /* Agrupamos las rutas del AdminController */
    Route::controller(AdminCursoController::class)->group(function () {



        Route::get('/reports', 'reports')
            ->name('user_reports');

        Route::post('guardarInformacion/', 'saveUser')
            ->name('save_user');

        Route::post('updateInformacion/', 'updateInformation')
            ->name('update_user');
        Route::get('/information', [AdminCursoController::class, 'information'])
            ->name('user_information')->middleware('auth');
        Route::post('update-informacion-estudiante_asesor/', 'update_information_estudiante_asesor')
            ->name('save_user_estudiante_asesor');

        Route::get('/listar-usuarios', 'listarUsuario')->name('admin.listar');
        Route::get('/ver-agregar-usuario', 'verAgregarUsuario')->name('admin.verAgregarUsuario');
        Route::post('/save-usuario',  'saveUsuario')->name('admin.saveUsuario');
        Route::post('/editar-usuario', 'editarUsuario')->name('admin.editar');
        Route::post('/save-editar-usuario',  'saveEditarUsuario')->name('admin.saveEditar');
        Route::delete('/delete-usuario',  'deleteUsuario')->name('admin.deleteUser');

        Route::get('/configuraciones-iniciales', 'configuraciones')->name('admin.configurar');
        Route::post('/save-configuraciones-iniciales',  'saveConfiguraciones')->name('admin.saveconfigurar');
        Route::post('/change-status-configuraciones', 'changeStatusConfiguraciones')->name('admin.changeStatusConfiguraciones');
        Route::post('/ver-editar-configuraciones',  'ver_editar_configuraciones')->name('admin.verConfiguracionEditar');
        Route::post('/save-editar-configuraciones', 'save_editar_configuraciones')->name('admin.saveEditarconfiguraciones');


        Route::get('/listar-directores', 'listarDirectores')->name('admin.director.listar');
        Route::post('/guardar-director',  'guardarDirector')->name('admin.director.guardarDirector');
        Route::delete('/delete-director',  'deleteDirector')->name('admin.director.deleteDirector');

        //----
        Route::get('/ver-facultad',  'verAgregarFacultad')->name('admin.verFacultad');
        Route::post('/save-facultad', 'saveFacultad')->name('admin.guardarFacultad');
        Route::post('/change-status-facultad', 'changeStatusFacultad')->name('admin.changeStatusFacultad');
        //

        //----
        Route::get('/ver-escuela', 'verAgregarEscuela')->name('admin.verEscuela');
        Route::post('/save-escuela',  'saveEscuela')->name('admin.guardarEscuela');
        Route::post('/change-status-escuela',  'changeStatusEscuela')->name('admin.changeStatusEscuela');
        //

        //----
        Route::get('/ver-presupuesto',  'verAgregarPresupuesto')->name('admin.verPresupuesto');
        Route::post('/save-presupuesto',  'savePresupuesto')->name('admin.guardarPresupuesto');
        Route::delete('/delete-presupuesto',  'delete_presupuesto')->name('admin.delete_presupuesto');
        //

        //----
        Route::get('/ver-grado-academico',  'verAgregarGrado')->name('admin.verAgregarGrado');
        Route::post('/save-grado-academico',  'saveGradoAcademico')->name('admin.guardarGradoAcademico');
        Route::post('/change-status-grado',  'changeStatusGrado')->name('admin.changeStatusGrado');
        Route::delete('/delete-grado',  'delete_grado')->name('admin.delete_grado');


        Route::get('/ver-agregar-categorias',  'ver_agregar_categoria')->name('admin.categoriasDocente');
        Route::post('/save-categorias', 'saveCategorias')->name('admin.saveCategorias');
        Route::get('/listar-categorias', 'lista_agregar_categoria')->name('admin.listarcategoriasDocente');
        Route::post('/ver-editar-categorias', 'ver_editar_categoria')->name('admin.EditarcategoriasDocente');
        Route::post('/save-editar-categorias', 'save_editar_categoria')->name('admin.saveEditarCategorias');
        Route::post('/change-status-categoria',  'changeStatusCategoria')->name('admin.changeStatusCategoria');
        Route::delete('/delete-categoria', 'delete_categoria')->name('admin.delete_categoria');

        //----
        Route::get('/ver-cronograma', 'verAgregarCronograma')->name('admin.verCronograma');
        Route::post('/save-cronograma',  'saveCronograma')->name('admin.guardarCronograma');
        Route::delete('/delete-cronograma',  'delete_cronograma')->name('admin.delete_cronograma');

        // Rutas para el director Curso

        Route::get('/generalidades',  'agregarGeneralidades')->name('director.generalidades');
        Route::post('/save-generalidades',  'saveGeneralidades')->name('director.saveDatosGenerales');
        Route::get('/descargar-reportePT', 'descargarReporteProyT')->name('director.descargar-reporteProyT');
        Route::get('/mantenedorLinea',  'mantenedorLineaInves')->name('director.mantenedorlineaInves');
        Route::post('/editarLinea',  'editarLineaInves')->name('director.lineaInvesEditar');
        Route::post('/save-editarLinea',  'saveEditarLineaInves')->name('director.editLineaInves');
        Route::delete('/deleteLinea',  'eliminarLineaInves')->name('director.deleteLineaInves');
        Route::delete('/delete-fin-persigue', 'eliminarFinPersigue')->name('director.deleteFinPersigue');
        Route::delete('/delete-dis-investiga', 'eliminarDisInvestiga')->name('director.deleteDisInvestiga');
        /** */
        Route::get('/agregarAsesor', 'showAddAsesor')->name('director.veragregarAsesor');
        Route::post('/agregarAsesor', 'agregarAsesor')->name('director.addAsesor');
        Route::get('/agregarEstudiante', 'showAddEstudiante')->name('director.veragregar');
        Route::post('/agregarEstudiante', 'agregarEstudiante')->name('director.addEstudiante');
        Route::post('/importarRegistro', 'importRegistroAlumnos')->name('director.importarAlumnos');
        Route::post('/importarRegistroAsesor', 'importRegistroAsesores')->name('director.importarAsesores');

        /** */
        Route::get('ver-historial-estudiante', 'verListaObservacion')->name('asesor.verHistoObs');
        Route::get('/observaciones-estudiante/{cod_tesis}', 'verObsEstudiante')->name('asesor.verObsEstudiante');
    });

    Route::controller(CursoTesisController::class)->group(function () {
        //Curso Tesis 2022-1
        Route::get('/cursoTesis', 'index')
            ->name('curso.tesis20221');
        Route::get('/estadoProyecto', 'estadoProyecto')
            ->name('curso.estado-proyecto');

        Route::post('/download-observacion-curso', 'descargaObservacionCurso')
            ->name('curso.download-observacion');
        //Rutas para el mantenimiento de la Tesis del Estudiante
        Route::post('/saveCTesis', 'saveTesis')->name('curso.saveTesis');
        Route::post('/descargaTesis', 'descargaTesis')->name('curso.descargaProyTesis');
        //HOSTING

        Route::get('/ver-agregar-grupos', 'verAgregarGruposInv')->name('director.verGrupos');
        Route::post('/save-grupos-inv', 'saveGruposInves')->name('director.saveGruposInvestigacion');
        //PROYECTO TESIS
        Route::get('/ver-asignar-asesor-grupos', 'showTablaAsignacionGrupos')->name('director.asignarAsesorGrupos');
        Route::post('/save-asignar-asesor-grupos', 'saveGrupoAsesorAsignado')->name('director.saveAsesorAsignadoGrupos');
        //---
        // Route::get('/asignarAsesor',[CursoTesisController::class,'showTablaAsignacion'])->name('director.asignar');
        // Route::post('/saveRegistro',[CursoTesisController::class,'saveAsesorAsignado'])->name('director.saveAsesor');

        Route::get('/editarAsignacion', 'showAlumnosAsignados')->name('director.editarAsignacion');
        Route::post('/saveEdicion', 'saveEdicionAsignacion')->name('director.saveEdicion');
        Route::delete('/deleteAlumno', 'deleteAlumno')->name('director.deleteAlumno');

        Route::get('/listaAlumnos', 'listaAlumnos')->name('director.listaAlumnos');
        Route::post('/verAlumnoEditar', 'verAlumnoEditar')->name('director.verAlumnoEditar');
        Route::post('/saveEditAlumno', 'editEstudiante')->name('director.editEstudiante');
        Route::get('/listaAsesores', 'listaAsesores')->name('director.listaAsesores');
        Route::post('/verAsesorEditar', 'verAsesorEditar')->name('director.verAsesorEditar');
        Route::post('/saveEditAsesor', 'editAsesor')->name('director.editAsesor');

        //Rutas para el asesor Curso
        Route::get('/verEstudiantes', 'showEstudiantes')->name('asesor.showEstudiantes');
        Route::post('/asignarTemas', 'asignarTemas')->name('asesor.asignarTemas');
        Route::post('/guardarTemas',  'guardarTemas')->name('asesor.guardarTemas');
        Route::post('/revisarTemas', 'revisarTemas')->name('asesor.revisarTemas');
        Route::post('/guardarObservaciones', 'guardarObservaciones')->name('asesor.guardarObservaciones');
        Route::post('/guardarSinObservaciones', 'guardarSinObservaciones')->name('asesor.guardarSinObs');



        Route::post('/descargaObservacion', 'descargaObservacionCurso')->name('asesor.descargaObservacion');

        Route::post('aprobarProyCT', 'aprobarProy')
            ->name('asesor.aprobarCTProy');
        Route::post('desaprobarProyCT', 'desaprobarProy')
            ->name('asesor.desaprobarCTProy');
    });
    Route::controller(Tesis2022Controller::class)->group(function () {
        // Para la tesis del cruso. (2022-2)
        Route::get('/registro-tesis', 'indexTesis')
            ->name('curso.registro-tesis');

        Route::post('/guardar-tesis', 'saveTesis2022')
            ->name('estudiante.guardarTesis');

        Route::get('/estado-tesis', 'estadoTesis')
            ->name('curso.estado-tesis');
        // Hasta aqui. (2022-2)

        Route::post('/descargar-tesis', 'descargaTesis')->name('curso.descargar-tesis');

        //Director: Tesis
        Route::get('/ver-asignar-asesor-grupos-tesis', 'showTablaAsignacionGruposTesis')->name('director.asignarAsesorGruposTesis');
        Route::post('/save-asignar-asesor-grupos-tesis', 'saveGrupoAsesorAsignadoTesis')->name('director.saveAsesorAsignadoGruposTesis');
        Route::get('/editar-asignacion-asesor', 'showEstudiantAsignado')->name('director.editAsignacionAsesorTesis');
        Route::post('/save-edicion-asignar', 'saveEditarAsignacion')->name('director.saveEditarAsignacion');
        // -----
        Route::post('/download-observacion', 'descargaObservacion')->name('asesor.descarga-observacion');



        Route::get('ver-estudiantes-tesis', 'showEstudiantesTesis')->name('asesor.estudiantes-tesis');
        Route::get('historial-estudiante-tesis', '')->name('asesor.historial-estudiantes');

        Route::post('/revisar-tesis', 'revisarTesis')->name('asesor.revisar-tesis');
        Route::post('/guardar-sin-obs', 'guardarSinObservaciones')->name('asesor.guardar-sin-observaciones');
        Route::post('/guardar-observaciones', 'guardarConObservaciones')->name('asesor.guardar-observaciones');
        Route::get('/observaciones-estudiante-tesis/{cod_tesis}', 'listaObsEstudianteTesis')->name('asesor.ver-obs-estudiante-tesis');
        Route::get('/estudiantes-observaciones', 'verEstudiantesObservacionTesis')->name('asesor.ver-estudsiantes-obs');

        Route::post('aprobarTesis', 'aprobarTesis')
            ->name('asesor.aprobar-tesis');
        Route::post('desaprobarTesis', 'desaprobarTesis')
            ->name('asesor.desaprobar-tesis');
    });

    Route::controller(EstudianteTesisController::class)->group(function () {
        Route::get('/ver-historial-observaciones', 'verHistorial')
            ->name('curso.verHistorialObs');

        Route::get('ver-observacion/{id}', 'showCorrection')
            ->name('curso.verObservacion');
    });


    Route::controller(SustentacionController::class)->group(function () {
        // EVALUACION ESTUDIANTE
        Route::get('/lista-observaciones-tesis-evaluacion', 'lista_observaciones_evaluacion')->name('estudiante.evaluacion.listaObservacionesTesis');
        //JURADO
        Route::get('/ver-registrar-jurado', 'verRegistrarJurado')->name('director.verRegistrarJurado');
        Route::post('/registrar-jurado', 'registrarJurado')->name('director.registrarJurado');
        // 2.Tesis
        Route::get('/lista-tesis-aprobadas', 'lista_tesis_aprobadas')->name('director.listaTesisAprobadas');
        Route::post('/save-asignacion-jurados', 'save_asignacion_jurados')->name('director.saveAsignacionJurados');
        Route::get('/ver-editar-asignacion-jurados', 'verEditAsignacionJurados')->name('director.verEditAsignacionJurados');
        Route::post('/edit-asignacion-jurados', 'editAsignacionJurados')->name('director.editAsignacionJurados');

        /* Evaluacion Tesis (Jurados)*/
        Route::get('/lista-tesis-asignadas/{showObservacion?}',  'lista_tesis_asignadas')->name('jurado.listaTesisAsignadas');
        Route::post('/detalle-tesis-asignada',  'detalleTesisAsignada')->name('jurado.detalleTesisAsignada');
        Route::post('/guardar-observacion-jurado-tesis', 'guardarObservacionSustentacion')->name('jurado.guardarObservacionTesis');
        Route::post('/aprobar-tesis-jurado', 'aprobarTesisEvaluacion')->name('jurado.aprobarTesis');


        /* Evaluacion Tesis (Estudiante)*/
        Route::get('/view-evaluacion-tesis', 'viewEvaluacionTesis')->name('estudiante.evaluacion.view-tesis');
        Route::get('/view-estado-tesis', 'viewEstadoEvaluacionTesis')->name('estudiante.evaluacion.estado-tesis');
        Route::post('/guardar-tesis-evaluacion', 'actualizarTesis')->name('estudiante.evaluacion.actualizarTesis');
    });

    Route::controller(SustentacionProyectoController::class)->group(function () {
        //Designacion de jurados --------------------------------------
        // 1.Proyecto de tesis
        Route::get('/lista-proyectos-aprobados', 'lista_proyectos_aprobados')->name('director.listaProyectosAprobados');
        Route::post('/save-asignacion-jurados-proyecto', 'saveAsignacionJuradoProyecto')->name('director.saveAsignacionJuradosProyecto');




        /* Evaluacion Proyecto de tesis (Estudiante)*/
        Route::get('/view-evaluacion-proyecto', 'viewEvaluacionProyecto')->name('estudiante.evaluacion.proyecto-tesis');
        Route::get('/view-estado-evaluacion-proyecto', 'viewEstadoEvaluacionProyecto')->name('estudiante.evaluacion.estado-proyecto-tesis');
        Route::post('/guardar-proyecto-evaluacion', 'actualizarProyectoTesis')->name('estudiante.evaluacion.actualizarProyectoTesis');
        /* Evaluacion Proyecto de tesis (Jurados)*/
        Route::get('/lista-proyectos-asignados/{showObservacion?}', 'listaProyectosAsignados')->name('jurado.listaProyectosAsignados');
        Route::post('/evaluar-proyecto-tesis', 'evaluarProyectoTesis')->name('jurado.evaluarProyectoTesis');
        Route::post('/guardar-observacion-jurado', 'guardarObservacionProyecto')->name('jurado.guardarObservacionProyecto');
        Route::post('/aprobar-proyecto-jurado', 'aprobarProyectoTesis')->name('jurado.aprobarProyectoTesis');
    });

    //Rutas para la secretaria
    // Route::get('/agregarEstudiante',[AdminCursoController::class,'showAddEstudiante'])->name('secretaria.veragregar');
    // Route::post('/agregarEstudiante',[AdminCursoController::class,'agregarEstudiante'])->name('secretaria.addEstudiante');
    //Route::post('tesis', [TesisController::class,'searchAutor'])->name('searchAutor');

    Route::controller(EvaluacionController::class)->group(function () {
        /*Director */
        Route::get('/ver-registro-sustentacion', 'verRegistrarSustentacion')->name('director.sustentacion.verRegistrarSustentacion');
        Route::get('/ver-detalle-sustentacion/{cod_designacion}', 'verDetalleSustentacion')->name('director.sustentacion.verDetalleSustentacion');
        Route::post('/actualizar-sustentacion', 'actualizarSustentacion')->name('director.sustentacion.actualizarSustentacion');

        /*Asesor */
        Route::get('/ver-lista-sustentacion', 'listaSustentaciones')->name('asesor.sustentacion.listaSustentacion');
        Route::post('/nota-tesis-jurado', 'guardarNotaTesis')->name('asesor.sustentacion.notaTesis');
    });
});

Auth::routes();

Route::get('/cmd/{comand}', function ($comand) {
    Artisan::call($comand);
});
