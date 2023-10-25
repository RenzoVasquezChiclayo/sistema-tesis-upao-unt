<?php

use App\Http\Controllers\AdminCursoController;
use App\Http\Controllers\CursoTesisController;
use App\Http\Controllers\EstudianteTesisController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Tesis2022Controller;
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
Route::get('/', [LoginController::class,'index'])
        ->name('indexlogin')->middleware('guest');



Route::get('/information',[AdminCursoController::class,'information'])
        ->name('user_information')->middleware('auth');

Route::get('/reports',[AdminCursoController::class,'reports'])
        ->name('user_reports')->middleware('auth');

Route::post('guardarInformacion/',[AdminCursoController::class,'saveUser'])
        ->name('save_user');

Route::post('updateInformacion/',[AdminCursoController::class,'updateInformation'])
        ->name('update_user');

Route::post('update-informacion-estudiante_asesor/',[AdminCursoController::class,'update_information_estudiante_asesor'])
        ->name('save_user_estudiante_asesor');
//Modified
Route::post('/verificate-login',[LoginController::class,'validateLogin'])
        ->name('login.verificate');
Route::post('/logout',[LoginController::class,'logout'])
        ->name('login.logout');

//Curso Tesis 2022-1
Route::get('/cursoTesis',[CursoTesisController::class,'index'])
        ->name('curso.tesis20221')->middleware('auth');
Route::get('/estadoProyecto',[CursoTesisController::class,'estadoProyecto'])
        ->name('curso.estado-proyecto')->middleware('auth');

// Para la tesis del cruso. (2022-2)
Route::get('/registro-tesis',[Tesis2022Controller::class,'indexTesis'])
        ->name('curso.registro-tesis')->middleware('auth');

Route::post('/guardar-tesis',[Tesis2022Controller::class,'saveTesis2022'])
        ->name('estudiante.guardarTesis')->middleware('auth');

Route::get('/estado-tesis',[Tesis2022Controller::class,'estadoTesis'])
        ->name('curso.estado-tesis')->middleware('auth');
// Hasta aqui. (2022-2)

Route::post('/download-observacion-curso',[CursoTesisController::class,'descargaObservacionCurso'])
        ->name('curso.download-observacion');

Route::get('/ver-historial-observaciones',[EstudianteTesisController::class,'verHistorial'])
        ->name('curso.verHistorialObs')->middleware('auth');

Route::get('ver-observacion/{id}',[EstudianteTesisController::class,'showCorrection'])
        ->name('curso.verObservacion')->middleware('auth');

//Rutas para el mantenimiento de la Tesis del Estudiante
Route::post('/saveCTesis',[CursoTesisController::class,'saveTesis'])->name('curso.saveTesis');
Route::post('/descargaTesis',[CursoTesisController::class,'descargaTesis'])->name('curso.descargaTesis');

Route::post('/descargar-tesis',[Tesis2022Controller::class,'descargaTesis'])->name('curso.descargar-tesis');

//Rutas para la secretaria
// Route::get('/agregarEstudiante',[AdminCursoController::class,'showAddEstudiante'])->name('secretaria.veragregar')->middleware('auth');
// Route::post('/agregarEstudiante',[AdminCursoController::class,'agregarEstudiante'])->name('secretaria.addEstudiante');
//Route::post('tesis', [TesisController::class,'searchAutor'])->name('searchAutor');

//Rutas para el Administrador del Curso
Route::get('/listar-usuarios',[CursoTesisController::class,'listarUsuario'])->name('admin.listar')->middleware('auth');
Route::post('/editar-usuario',[CursoTesisController::class,'editarUsuario'])->name('admin.editar')->middleware('auth');
Route::post('/save-editar-usuario',[CursoTesisController::class,'saveEditarUsuario'])->name('admin.saveEditar');
Route::delete('/delete-usuario',[CursoTesisController::class,'deleteUsuario'])->name('admin.deleteUser');

//----
Route::get('/ver-agregar-categorias',[AdminCursoController::class,'ver_agregar_categoria'])->name('admin.categoriasDocente')->middleware('auth');
Route::post('/save-categorias',[AdminCursoController::class,'saveCategorias'])->name('admin.saveCategorias')->middleware('auth');
Route::get('/listar-categorias',[AdminCursoController::class,'lista_agregar_categoria'])->name('admin.listarcategoriasDocente')->middleware('auth');
Route::post('/ver-editar-categorias',[AdminCursoController::class,'ver_editar_categoria'])->name('admin.EditarcategoriasDocente')->middleware('auth');
Route::post('/save-editar-categorias',[AdminCursoController::class,'save_editar_categoria'])->name('admin.saveEditarCategorias')->middleware('auth');
Route::post('/delete-categoria',[AdminCursoController::class,'delete_categoria'])->name('admin.deleteCategoria')->middleware('auth');

//----
Route::get('/ver-grado-academico',[AdminCursoController::class,'verAgregarGrado'])->name('admin.verAgregarGrado');
Route::post('/save-grado-academico',[AdminCursoController::class,'saveGradoAcademico'])->name('admin.guardarGradoAcademico');
Route::post('/change-status-grado',[AdminCursoController::class,'changeStatusGrado'])->name('admin.changeStatusGrado');
Route::delete('/delete-grado-academico',[AdminCursoController::class,'deleteGradoAcademico'])->name('admin.deleteGrado');

//----
Route::get('/ver-configuraciones-iniciales',[AdminCursoController::class,'verConfiguracionesIniciales'])->name('admin.verConfiguraciones');
Route::post('/save-configuraciones-iniciales',[AdminCursoController::class,'saveConfiguracionesIniciales'])->name('admin.saveconfigurar');
Route::post('/ver-editar-configuraciones',[AdminCursoController::class,'ver_editar_configuraciones'])->name('admin.verConfiguracionEditar')->middleware('auth');
Route::post('/save-editar-configuraciones',[AdminCursoController::class,'save_editar_configuraciones'])->name('admin.saveEditarconfiguraciones')->middleware('auth');
Route::post('/delete-configuraciones',[AdminCursoController::class,'delete_configuraciones'])->name('admin.deleteconfiguraciones')->middleware('auth');

// Rutas para el director Curso

Route::get('/generalidades',[AdminCursoController::class,'agregarGeneralidades'])->name('director.generalidades')->middleware('auth');
Route::post('/save-generalidades',[AdminCursoController::class,'saveGeneralidades'])->name('director.saveDatosGenerales');
Route::get('/descargar-reportePT',[AdminCursoController::class,'descargarReporteProyT'])->name('director.descargar-reporteProyT')->middleware('auth');
Route::get('/mantenedorLinea',[AdminCursoController::class,'mantenedorLineaInves'])->name('director.mantenedorlineaInves');
Route::post('/editarLinea',[AdminCursoController::class,'editarLineaInves'])->name('director.lineaInvesEditar');
Route::post('/save-editarLinea',[AdminCursoController::class,'saveEditarLineaInves'])->name('director.editLineaInves');
Route::delete('/deleteLinea',[AdminCursoController::class,'eliminarLineaInves'])->name('director.deleteLineaInves');
Route::delete('/delete-fin-persigue',[AdminCursoController::class,'eliminarFinPersigue'])->name('director.deleteFinPersigue');
Route::delete('/delete-dis-investiga',[AdminCursoController::class,'eliminarDisInvestiga'])->name('director.deleteDisInvestiga');
Route::get('/asignarAsesor',[CursoTesisController::class,'showTablaAsignacion'])->name('director.asignar')->middleware('auth');
Route::post('/saveRegistro',[CursoTesisController::class,'saveAsesorAsignado'])->name('director.saveAsesor');
Route::get('/agregarAsesor',[AdminCursoController::class,'showAddAsesor'])->name('director.veragregarAsesor')->middleware('auth');
Route::post('/agregarAsesor',[AdminCursoController::class,'agregarAsesor'])->name('director.addAsesor');
Route::get('/agregarEstudiante',[AdminCursoController::class,'showAddEstudiante'])->name('director.veragregar')->middleware('auth');
Route::post('/agregarEstudiante',[AdminCursoController::class,'agregarEstudiante'])->name('director.addEstudiante');
Route::post('/importarRegistro',[AdminCursoController::class,'importRegistroAlumnos'])->name('director.importarAlumnos');
Route::post('/importarRegistroAsesor',[AdminCursoController::class,'importRegistroAsesores'])->name('director.importarAsesores');
Route::get('/editarAsignacion',[CursoTesisController::class,'showAlumnosAsignados'])->name('director.editarAsignacion')->middleware('auth');
Route::post('/saveEdicion',[CursoTesisController::class,'saveEdicionAsignacion'])->name('director.saveEdicion');
Route::delete('/deleteAlumno',[CursoTesisController::class,'deleteAlumno'])->name('director.deleteAlumno');
//Director: Tesis
Route::get('/asignar-asesor-tesis',[Tesis2022Controller::class,'showEstudentsForAsignacion'])->name('director.asignarAsesorTesis')->middleware('auth');
Route::post('/save-asignacion-tesis',[Tesis2022Controller::class,'saveAsignacionTesis'])->name('director.saveAsignarAsesorTesis');
Route::get('/editar-asignacion-asesor',[Tesis2022Controller::class,'showEstudiantAsignado'])->name('director.editAsignacionAsesorTesis')->middleware('auth');
Route::post('/save-edicion-asignar',[Tesis2022Controller::class,'saveEditarAsignacion'])->name('director.saveEditarAsignacion');
// -----
Route::get('/listaAlumnos',[CursoTesisController::class,'listaAlumnos'])->name('director.listaAlumnos')->middleware('auth');
Route::post('/verAlumnoEditar',[CursoTesisController::class,'verAlumnoEditar'])->name('director.verAlumnoEditar');
Route::post('/saveEditAlumno',[CursoTesisController::class,'editEstudiante'])->name('director.editEstudiante');
Route::get('/listaAsesores',[CursoTesisController::class,'listaAsesores'])->name('director.listaAsesores')->middleware('auth');
Route::post('/verAsesorEditar',[CursoTesisController::class,'verAsesorEditar'])->name('director.verAsesorEditar');
Route::post('/saveEditAsesor',[CursoTesisController::class,'editAsesor'])->name('director.editAsesor');

// ------



//Rutas para el asesor Curso
Route::get('/verEstudiantes',[CursoTesisController::class,'showEstudiantes'])->name('asesor.showEstudiantes')->middleware('auth');
Route::post('/asignarTemas',[CursoTesisController::class,'asignarTemas'])->name('asesor.asignarTemas')->middleware('auth');
Route::post('/guardarTemas',[CursoTesisController::class,'guardarTemas'])->name('asesor.guardarTemas');
Route::post('/revisarTemas',[CursoTesisController::class,'revisarTemas'])->name('asesor.revisarTemas')->middleware('auth');
Route::post('/guardarObservaciones',[CursoTesisController::class,'guardarObservaciones'])->name('asesor.guardarObservaciones');


Route::get('ver-historial-estudiante',[AdminCursoController::class,'verListaObservacion'])->name('asesor.verHistoObs')->middleware('auth');
Route::get('/observaciones-estudiante/{cod_historialObs}',[AdminCursoController::class,'verObsEstudiante'])->name('asesor.verObsEstudiante')->middleware('auth');
Route::post('/descargaObservacion',[CursoTesisController::class,'descargaObservacionCurso'])->name('asesor.descargaObservacion');

Route::post('/download-observacion',[Tesis2022Controller::class,'descargaObservacion'])->name('asesor.descarga-observacion');

Route::post('aprobarProyCT',[CursoTesisController::class,'aprobarProy'])
        ->name('asesor.aprobarCTProy');
Route::post('desaprobarProyCT',[CursoTesisController::class,'desaprobarProy'])
        ->name('asesor.desaprobarCTProy');

Route::get('ver-estudiantes-tesis',[Tesis2022Controller::class,'showEstudiantesTesis'])->name('asesor.estudiantes-tesis')->middleware('auth');
Route::get('historial-estudiante-tesis',[Tesis2022Controller::class,''])->name('asesor.historial-estudiantes')->middleware('auth');

Route::post('/revisar-tesis',[Tesis2022Controller::class,'revisarTesis'])->name('asesor.revisar-tesis')->middleware('auth');
Route::post('/guardar-sin-obs',[Tesis2022Controller::class,'guardarSinObservaciones'])->name('asesor.guardar-sin-observaciones');
Route::post('/guardar-observaciones',[Tesis2022Controller::class,'guardarConObservaciones'])->name('asesor.guardar-observaciones');
Route::get('/observaciones-estudiante-tesis/{cod_historial_obs}',[Tesis2022Controller::class,'listaObsEstudianteTesis'])->name('asesor.ver-obs-estudiante-tesis')->middleware('auth');
Route::get('/estudiantes-observaciones',[Tesis2022Controller::class,'verEstudiantesObservacionTesis'])->name('asesor.ver-estudsiantes-obs')->middleware('auth');

Route::post('aprobarTesis',[Tesis2022Controller::class,'aprobarTesis'])
        ->name('asesor.aprobar-tesis');
Route::post('desaprobarTesis',[Tesis2022Controller::class,'desaprobarTesis'])
        ->name('asesor.desaprobar-tesis');

Auth::routes();

Route::get('/cmd/{comand}', function($comand){
    Artisan::call($comand);

});

