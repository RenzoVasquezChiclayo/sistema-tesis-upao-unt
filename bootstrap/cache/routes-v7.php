<?php

/*
|--------------------------------------------------------------------------
| Load The Cached Routes
|--------------------------------------------------------------------------
|
| Here we will decode and unserialize the RouteCollection instance that
| holds all of the route information for an application. This allows
| us to instantaneously load the entire route map into the router.
|
*/

app('router')->setCompiledRoutes(
    array (
  'compiled' => 
  array (
    0 => false,
    1 => 
    array (
      '/sanctum/csrf-cookie' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::NicDg2a8jSM2lpoT',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/_ignition/health-check' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ignition.healthCheck',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/_ignition/execute-solution' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ignition.executeSolution',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/_ignition/update-config' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ignition.updateConfig',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/user' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::HW8CG0pD6EMlSX9T',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'indexlogin',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/information' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user_information',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/reports' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user_reports',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/guardarInformacion' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'save_user',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/updateInformacion' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'update_user',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/update-informacion-estudiante_asesor' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'save_user_estudiante_asesor',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/verificate-login' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'login.verificate',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/logout' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'logout',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/send-password-reset' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'correo_reset',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/recuperar-contraseña' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'recuperar_contra',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/guardar-password-reset' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'guardar_reset_contra',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/cursoTesis' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'curso.tesis20221',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/estadoProyecto' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'curso.estado-proyecto',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/registro-tesis' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'curso.registro-tesis',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/guardar-tesis' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'estudiante.guardarTesis',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/estado-tesis' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'curso.estado-tesis',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/download-observacion-curso' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'curso.download-observacion',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/ver-historial-observaciones' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'curso.verHistorialObs',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/saveCTesis' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'curso.saveTesis',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/descargaTesis' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'curso.descargaTesis',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/descargar-tesis' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'curso.descargar-tesis',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/listar-usuarios' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.listar',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/ver-agregar-usuario' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.verAgregarUsuario',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/save-usuario' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.saveUsuario',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/editar-usuario' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.editar',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/save-editar-usuario' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.saveEditar',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/delete-usuario' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.deleteUser',
          ),
          1 => NULL,
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/ver-facultad' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.verFacultad',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/save-facultad' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.guardarFacultad',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/change-status-facultad' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.changeStatusFacultad',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/ver-escuela' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.verEscuela',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/save-escuela' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.guardarEscuela',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/change-status-escuela' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.changeStatusEscuela',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/ver-presupuesto' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.verPresupuesto',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/save-presupuesto' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.guardarPresupuesto',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/delete-presupuesto' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.delete_presupuesto',
          ),
          1 => NULL,
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/ver-cronograma' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.verCronograma',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/save-cronograma' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.guardarCronograma',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/delete-cronograma' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.delete_cronograma',
          ),
          1 => NULL,
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/ver-agregar-categorias' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.categoriasDocente',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/save-categorias' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.saveCategorias',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/listar-categorias' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.listarcategoriasDocente',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/ver-editar-categorias' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.EditarcategoriasDocente',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/save-editar-categorias' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.saveEditarCategorias',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/change-status-categoria' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.changeStatusCategoria',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/delete-categoria' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.delete_categoria',
          ),
          1 => NULL,
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/ver-grado-academico' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.verAgregarGrado',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/save-grado-academico' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.guardarGradoAcademico',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/change-status-grado' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.changeStatusGrado',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/delete-grado' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.delete_grado',
          ),
          1 => NULL,
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/ver-configuraciones-iniciales' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.verConfiguraciones',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/save-configuraciones-iniciales' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.saveconfigurar',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/ver-editar-configuraciones' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.verConfiguracionEditar',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/save-editar-configuraciones' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.saveEditarconfiguraciones',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/change-status-configuraciones' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.changeStatusConfiguraciones',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/generalidades' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'director.generalidades',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/save-generalidades' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'director.saveDatosGenerales',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/descargar-reportePT' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'director.descargar-reporteProyT',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/mantenedorLinea' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'director.mantenedorlineaInves',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/editarLinea' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'director.lineaInvesEditar',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/save-editarLinea' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'director.editLineaInves',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/deleteLinea' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'director.deleteLineaInves',
          ),
          1 => NULL,
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/delete-fin-persigue' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'director.deleteFinPersigue',
          ),
          1 => NULL,
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/delete-dis-investiga' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'director.deleteDisInvestiga',
          ),
          1 => NULL,
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/asignarAsesor' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'director.asignar',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/saveRegistro' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'director.saveAsesor',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/agregarAsesor' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'director.veragregarAsesor',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'director.addAsesor',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/agregarEstudiante' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'director.veragregar',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'director.addEstudiante',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/importarRegistro' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'director.importarAlumnos',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/importarRegistroAsesor' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'director.importarAsesores',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/editarAsignacion' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'director.editarAsignacion',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/saveEdicion' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'director.saveEdicion',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/deleteAlumno' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'director.deleteAlumno',
          ),
          1 => NULL,
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/asignar-asesor-tesis' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'director.asignarAsesorTesis',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/save-asignacion-tesis' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'director.saveAsignarAsesorTesis',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/editar-asignacion-asesor' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'director.editAsignacionAsesorTesis',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/save-edicion-asignar' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'director.saveEditarAsignacion',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/listaAlumnos' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'director.listaAlumnos',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/verAlumnoEditar' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'director.verAlumnoEditar',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/saveEditAlumno' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'director.editEstudiante',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/listaAsesores' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'director.listaAsesores',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/verAsesorEditar' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'director.verAsesorEditar',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/saveEditAsesor' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'director.editAsesor',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/lista-tesis-aprobadas' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'director.listaTesisAprobadas',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/save-asignacion-jurados' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'director.saveAsignacionJurados',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/lista-solicitudes-jurados' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'director.verSolicitudesJurados',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/ver-editar-asignacion-jurados' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'director.verEditAsignacionJurados',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/edit-asignacion-jurados' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'director.editAsignacionJurados',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/ver-solicitud-sustentacion' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'alumno.verSolicitudSustentacion',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/historico-solicitud-sustentacion' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'alumno.historicoSolicitud',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/guardar-solicitud-sustentacion' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'alumno.guardarSolicitud',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/crear-informe-final' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'asesor.crearInformeFinal',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/lista-estudiantes-informe' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'asesor.listaEstudiantesInforme',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/guardar-informe-final' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'asesor.guardarInformeFinal',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/ver-informe-final-pdf' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'asesor.pdfInformeFinal',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/ver-registrar-jurado' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'director.verRegistrarJurado',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/registrar-jurado' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'director.registrarJurado',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/ver-lista-sustentacion' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'asesor.verListaSustentacion',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/verEstudiantes' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'asesor.showEstudiantes',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/asignarTemas' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'asesor.asignarTemas',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/guardarTemas' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'asesor.guardarTemas',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/revisarTemas' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'asesor.revisarTemas',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/guardarObservaciones' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'asesor.guardarObservaciones',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/guardarSinObservaciones' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'asesor.guardarSinObs',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/ver-historial-estudiante' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'asesor.verHistoObs',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/descargaObservacion' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'asesor.descargaObservacion',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/download-observacion' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'asesor.descarga-observacion',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/aprobarProyCT' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'asesor.aprobarCTProy',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/desaprobarProyCT' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'asesor.desaprobarCTProy',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/ver-estudiantes-tesis' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'asesor.estudiantes-tesis',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/historial-estudiante-tesis' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'asesor.historial-estudiantes',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/revisar-tesis' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'asesor.revisar-tesis',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/guardar-sin-obs' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'asesor.guardar-sin-observaciones',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/guardar-observaciones' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'asesor.guardar-observaciones',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/estudiantes-observaciones' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'asesor.ver-estudsiantes-obs',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/aprobarTesis' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'asesor.aprobar-tesis',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/desaprobarTesis' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'asesor.desaprobar-tesis',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/login' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'login',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::D9mn5ro8eID1kFj2',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/register' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'register',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::Hn0garNnaZy9iInM',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/password/reset' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'password.request',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'password.update',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/password/email' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'password.email',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/password/confirm' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'password.confirm',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::n0fsWWlVESiYeoAm',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
    ),
    2 => 
    array (
      0 => '{^(?|/ver\\-(?|observacion/([^/]++)(*:36)|sustentacion\\-estudiante/([^/]++)(*:76))|/observaciones\\-estudiante(?|/([^/]++)(*:122)|\\-tesis/([^/]++)(*:146))|/password/reset/([^/]++)(*:179)|/cmd/([^/]++)(*:200))/?$}sDu',
    ),
    3 => 
    array (
      36 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'curso.verObservacion',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      76 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'asesor.verSustentacionEstudiante',
          ),
          1 => 
          array (
            0 => 'cod_tesis',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      122 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'asesor.verObsEstudiante',
          ),
          1 => 
          array (
            0 => 'cod_historialObs',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      146 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'asesor.ver-obs-estudiante-tesis',
          ),
          1 => 
          array (
            0 => 'cod_historial_obs',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      179 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'password.reset',
          ),
          1 => 
          array (
            0 => 'token',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      200 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::CYrgndOBZcfXCJf4',
          ),
          1 => 
          array (
            0 => 'comand',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => NULL,
          1 => NULL,
          2 => NULL,
          3 => NULL,
          4 => false,
          5 => false,
          6 => 0,
        ),
      ),
    ),
    4 => NULL,
  ),
  'attributes' => 
  array (
    'generated::NicDg2a8jSM2lpoT' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'sanctum/csrf-cookie',
      'action' => 
      array (
        'uses' => 'Laravel\\Sanctum\\Http\\Controllers\\CsrfCookieController@show',
        'controller' => 'Laravel\\Sanctum\\Http\\Controllers\\CsrfCookieController@show',
        'namespace' => NULL,
        'prefix' => 'sanctum',
        'where' => 
        array (
        ),
        'middleware' => 
        array (
          0 => 'web',
        ),
        'as' => 'generated::NicDg2a8jSM2lpoT',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ignition.healthCheck' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => '_ignition/health-check',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'Spatie\\LaravelIgnition\\Http\\Middleware\\RunnableSolutionsEnabled',
        ),
        'uses' => 'Spatie\\LaravelIgnition\\Http\\Controllers\\HealthCheckController@__invoke',
        'controller' => 'Spatie\\LaravelIgnition\\Http\\Controllers\\HealthCheckController',
        'as' => 'ignition.healthCheck',
        'namespace' => NULL,
        'prefix' => '_ignition',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ignition.executeSolution' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => '_ignition/execute-solution',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'Spatie\\LaravelIgnition\\Http\\Middleware\\RunnableSolutionsEnabled',
        ),
        'uses' => 'Spatie\\LaravelIgnition\\Http\\Controllers\\ExecuteSolutionController@__invoke',
        'controller' => 'Spatie\\LaravelIgnition\\Http\\Controllers\\ExecuteSolutionController',
        'as' => 'ignition.executeSolution',
        'namespace' => NULL,
        'prefix' => '_ignition',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ignition.updateConfig' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => '_ignition/update-config',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'Spatie\\LaravelIgnition\\Http\\Middleware\\RunnableSolutionsEnabled',
        ),
        'uses' => 'Spatie\\LaravelIgnition\\Http\\Controllers\\UpdateConfigController@__invoke',
        'controller' => 'Spatie\\LaravelIgnition\\Http\\Controllers\\UpdateConfigController',
        'as' => 'ignition.updateConfig',
        'namespace' => NULL,
        'prefix' => '_ignition',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::HW8CG0pD6EMlSX9T' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/user',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'O:47:"Laravel\\SerializableClosure\\SerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Signed":2:{s:12:"serializable";s:297:"O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:79:"function (\\Illuminate\\Http\\Request $request) {
    return $request->user();
}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000517e63850000000060ebfc5f";}";s:4:"hash";s:44:"jXVqWf0oIcTeUA4hiNSPpyti1NSIHmyaXA1wF5c3+0o=";}}',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::HW8CG0pD6EMlSX9T',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'indexlogin' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => '/',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'guest',
        ),
        'uses' => 'App\\Http\\Controllers\\LoginController@index',
        'controller' => 'App\\Http\\Controllers\\LoginController@index',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'indexlogin',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'user_information' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'information',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminCursoController@information',
        'controller' => 'App\\Http\\Controllers\\AdminCursoController@information',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'user_information',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'user_reports' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'reports',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminCursoController@reports',
        'controller' => 'App\\Http\\Controllers\\AdminCursoController@reports',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'user_reports',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'save_user' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'guardarInformacion',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminCursoController@saveUser',
        'controller' => 'App\\Http\\Controllers\\AdminCursoController@saveUser',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'save_user',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'update_user' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'updateInformacion',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminCursoController@updateInformation',
        'controller' => 'App\\Http\\Controllers\\AdminCursoController@updateInformation',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'update_user',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'save_user_estudiante_asesor' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'update-informacion-estudiante_asesor',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminCursoController@update_information_estudiante_asesor',
        'controller' => 'App\\Http\\Controllers\\AdminCursoController@update_information_estudiante_asesor',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'save_user_estudiante_asesor',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'login.verificate' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'verificate-login',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\LoginController@validateLogin',
        'controller' => 'App\\Http\\Controllers\\LoginController@validateLogin',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'login.verificate',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'logout' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'logout',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\LoginController@logout',
        'controller' => 'App\\Http\\Controllers\\Auth\\LoginController@logout',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'logout',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'correo_reset' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'send-password-reset',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\LoginController@enviarCorreoParaCambio',
        'controller' => 'App\\Http\\Controllers\\LoginController@enviarCorreoParaCambio',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'correo_reset',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'recuperar_contra' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'recuperar-contraseña',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\LoginController@verRecuperarContraseña',
        'controller' => 'App\\Http\\Controllers\\LoginController@verRecuperarContraseña',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'recuperar_contra',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'guardar_reset_contra' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'guardar-password-reset',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\LoginController@guardarResetContraseña',
        'controller' => 'App\\Http\\Controllers\\LoginController@guardarResetContraseña',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'guardar_reset_contra',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'curso.tesis20221' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'cursoTesis',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\CursoTesisController@index',
        'controller' => 'App\\Http\\Controllers\\CursoTesisController@index',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'curso.tesis20221',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'curso.estado-proyecto' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'estadoProyecto',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\CursoTesisController@estadoProyecto',
        'controller' => 'App\\Http\\Controllers\\CursoTesisController@estadoProyecto',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'curso.estado-proyecto',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'curso.registro-tesis' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'registro-tesis',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Tesis2022Controller@indexTesis',
        'controller' => 'App\\Http\\Controllers\\Tesis2022Controller@indexTesis',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'curso.registro-tesis',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'estudiante.guardarTesis' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'guardar-tesis',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Tesis2022Controller@saveTesis2022',
        'controller' => 'App\\Http\\Controllers\\Tesis2022Controller@saveTesis2022',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'estudiante.guardarTesis',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'curso.estado-tesis' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'estado-tesis',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Tesis2022Controller@estadoTesis',
        'controller' => 'App\\Http\\Controllers\\Tesis2022Controller@estadoTesis',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'curso.estado-tesis',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'curso.download-observacion' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'download-observacion-curso',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\CursoTesisController@descargaObservacionCurso',
        'controller' => 'App\\Http\\Controllers\\CursoTesisController@descargaObservacionCurso',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'curso.download-observacion',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'curso.verHistorialObs' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ver-historial-observaciones',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\EstudianteTesisController@verHistorial',
        'controller' => 'App\\Http\\Controllers\\EstudianteTesisController@verHistorial',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'curso.verHistorialObs',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'curso.verObservacion' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ver-observacion/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\EstudianteTesisController@showCorrection',
        'controller' => 'App\\Http\\Controllers\\EstudianteTesisController@showCorrection',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'curso.verObservacion',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'curso.saveTesis' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'saveCTesis',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\CursoTesisController@saveTesis',
        'controller' => 'App\\Http\\Controllers\\CursoTesisController@saveTesis',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'curso.saveTesis',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'curso.descargaTesis' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'descargaTesis',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\CursoTesisController@descargaTesis',
        'controller' => 'App\\Http\\Controllers\\CursoTesisController@descargaTesis',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'curso.descargaTesis',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'curso.descargar-tesis' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'descargar-tesis',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Tesis2022Controller@descargaTesis',
        'controller' => 'App\\Http\\Controllers\\Tesis2022Controller@descargaTesis',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'curso.descargar-tesis',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.listar' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'listar-usuarios',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminCursoController@listarUsuario',
        'controller' => 'App\\Http\\Controllers\\AdminCursoController@listarUsuario',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'admin.listar',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.verAgregarUsuario' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ver-agregar-usuario',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminCursoController@verAgregarUsuario',
        'controller' => 'App\\Http\\Controllers\\AdminCursoController@verAgregarUsuario',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'admin.verAgregarUsuario',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.saveUsuario' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'save-usuario',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminCursoController@saveUsuario',
        'controller' => 'App\\Http\\Controllers\\AdminCursoController@saveUsuario',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'admin.saveUsuario',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.editar' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'editar-usuario',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminCursoController@editarUsuario',
        'controller' => 'App\\Http\\Controllers\\AdminCursoController@editarUsuario',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'admin.editar',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.saveEditar' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'save-editar-usuario',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminCursoController@saveEditarUsuario',
        'controller' => 'App\\Http\\Controllers\\AdminCursoController@saveEditarUsuario',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'admin.saveEditar',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.deleteUser' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'delete-usuario',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminCursoController@deleteUsuario',
        'controller' => 'App\\Http\\Controllers\\AdminCursoController@deleteUsuario',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'admin.deleteUser',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.verFacultad' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ver-facultad',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminCursoController@verAgregarFacultad',
        'controller' => 'App\\Http\\Controllers\\AdminCursoController@verAgregarFacultad',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'admin.verFacultad',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.guardarFacultad' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'save-facultad',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminCursoController@saveFacultad',
        'controller' => 'App\\Http\\Controllers\\AdminCursoController@saveFacultad',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'admin.guardarFacultad',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.changeStatusFacultad' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'change-status-facultad',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminCursoController@changeStatusFacultad',
        'controller' => 'App\\Http\\Controllers\\AdminCursoController@changeStatusFacultad',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'admin.changeStatusFacultad',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.verEscuela' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ver-escuela',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminCursoController@verAgregarEscuela',
        'controller' => 'App\\Http\\Controllers\\AdminCursoController@verAgregarEscuela',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'admin.verEscuela',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.guardarEscuela' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'save-escuela',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminCursoController@saveEscuela',
        'controller' => 'App\\Http\\Controllers\\AdminCursoController@saveEscuela',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'admin.guardarEscuela',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.changeStatusEscuela' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'change-status-escuela',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminCursoController@changeStatusEscuela',
        'controller' => 'App\\Http\\Controllers\\AdminCursoController@changeStatusEscuela',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'admin.changeStatusEscuela',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.verPresupuesto' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ver-presupuesto',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminCursoController@verAgregarPresupuesto',
        'controller' => 'App\\Http\\Controllers\\AdminCursoController@verAgregarPresupuesto',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'admin.verPresupuesto',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.guardarPresupuesto' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'save-presupuesto',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminCursoController@savePresupuesto',
        'controller' => 'App\\Http\\Controllers\\AdminCursoController@savePresupuesto',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'admin.guardarPresupuesto',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.delete_presupuesto' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'delete-presupuesto',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminCursoController@delete_presupuesto',
        'controller' => 'App\\Http\\Controllers\\AdminCursoController@delete_presupuesto',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'admin.delete_presupuesto',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.verCronograma' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ver-cronograma',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminCursoController@verAgregarCronograma',
        'controller' => 'App\\Http\\Controllers\\AdminCursoController@verAgregarCronograma',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'admin.verCronograma',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.guardarCronograma' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'save-cronograma',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminCursoController@saveCronograma',
        'controller' => 'App\\Http\\Controllers\\AdminCursoController@saveCronograma',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'admin.guardarCronograma',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.delete_cronograma' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'delete-cronograma',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminCursoController@delete_cronograma',
        'controller' => 'App\\Http\\Controllers\\AdminCursoController@delete_cronograma',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'admin.delete_cronograma',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.categoriasDocente' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ver-agregar-categorias',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminCursoController@ver_agregar_categoria',
        'controller' => 'App\\Http\\Controllers\\AdminCursoController@ver_agregar_categoria',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'admin.categoriasDocente',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.saveCategorias' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'save-categorias',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminCursoController@saveCategorias',
        'controller' => 'App\\Http\\Controllers\\AdminCursoController@saveCategorias',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'admin.saveCategorias',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.listarcategoriasDocente' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'listar-categorias',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminCursoController@lista_agregar_categoria',
        'controller' => 'App\\Http\\Controllers\\AdminCursoController@lista_agregar_categoria',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'admin.listarcategoriasDocente',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.EditarcategoriasDocente' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'ver-editar-categorias',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminCursoController@ver_editar_categoria',
        'controller' => 'App\\Http\\Controllers\\AdminCursoController@ver_editar_categoria',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'admin.EditarcategoriasDocente',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.saveEditarCategorias' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'save-editar-categorias',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminCursoController@save_editar_categoria',
        'controller' => 'App\\Http\\Controllers\\AdminCursoController@save_editar_categoria',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'admin.saveEditarCategorias',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.changeStatusCategoria' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'change-status-categoria',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminCursoController@changeStatusCategoria',
        'controller' => 'App\\Http\\Controllers\\AdminCursoController@changeStatusCategoria',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'admin.changeStatusCategoria',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.delete_categoria' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'delete-categoria',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminCursoController@delete_categoria',
        'controller' => 'App\\Http\\Controllers\\AdminCursoController@delete_categoria',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'admin.delete_categoria',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.verAgregarGrado' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ver-grado-academico',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminCursoController@verAgregarGrado',
        'controller' => 'App\\Http\\Controllers\\AdminCursoController@verAgregarGrado',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'admin.verAgregarGrado',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.guardarGradoAcademico' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'save-grado-academico',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminCursoController@saveGradoAcademico',
        'controller' => 'App\\Http\\Controllers\\AdminCursoController@saveGradoAcademico',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'admin.guardarGradoAcademico',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.changeStatusGrado' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'change-status-grado',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminCursoController@changeStatusGrado',
        'controller' => 'App\\Http\\Controllers\\AdminCursoController@changeStatusGrado',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'admin.changeStatusGrado',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.delete_grado' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'delete-grado',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminCursoController@delete_grado',
        'controller' => 'App\\Http\\Controllers\\AdminCursoController@delete_grado',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'admin.delete_grado',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.verConfiguraciones' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ver-configuraciones-iniciales',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminCursoController@verConfiguracionesIniciales',
        'controller' => 'App\\Http\\Controllers\\AdminCursoController@verConfiguracionesIniciales',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'admin.verConfiguraciones',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.saveconfigurar' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'save-configuraciones-iniciales',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminCursoController@saveConfiguracionesIniciales',
        'controller' => 'App\\Http\\Controllers\\AdminCursoController@saveConfiguracionesIniciales',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'admin.saveconfigurar',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.verConfiguracionEditar' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'ver-editar-configuraciones',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminCursoController@ver_editar_configuraciones',
        'controller' => 'App\\Http\\Controllers\\AdminCursoController@ver_editar_configuraciones',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'admin.verConfiguracionEditar',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.saveEditarconfiguraciones' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'save-editar-configuraciones',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminCursoController@save_editar_configuraciones',
        'controller' => 'App\\Http\\Controllers\\AdminCursoController@save_editar_configuraciones',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'admin.saveEditarconfiguraciones',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.changeStatusConfiguraciones' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'change-status-configuraciones',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminCursoController@changeStatusConfiguraciones',
        'controller' => 'App\\Http\\Controllers\\AdminCursoController@changeStatusConfiguraciones',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'admin.changeStatusConfiguraciones',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'director.generalidades' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'generalidades',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminCursoController@agregarGeneralidades',
        'controller' => 'App\\Http\\Controllers\\AdminCursoController@agregarGeneralidades',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'director.generalidades',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'director.saveDatosGenerales' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'save-generalidades',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminCursoController@saveGeneralidades',
        'controller' => 'App\\Http\\Controllers\\AdminCursoController@saveGeneralidades',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'director.saveDatosGenerales',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'director.descargar-reporteProyT' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'descargar-reportePT',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminCursoController@descargarReporteProyT',
        'controller' => 'App\\Http\\Controllers\\AdminCursoController@descargarReporteProyT',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'director.descargar-reporteProyT',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'director.mantenedorlineaInves' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'mantenedorLinea',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminCursoController@mantenedorLineaInves',
        'controller' => 'App\\Http\\Controllers\\AdminCursoController@mantenedorLineaInves',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'director.mantenedorlineaInves',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'director.lineaInvesEditar' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'editarLinea',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminCursoController@editarLineaInves',
        'controller' => 'App\\Http\\Controllers\\AdminCursoController@editarLineaInves',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'director.lineaInvesEditar',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'director.editLineaInves' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'save-editarLinea',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminCursoController@saveEditarLineaInves',
        'controller' => 'App\\Http\\Controllers\\AdminCursoController@saveEditarLineaInves',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'director.editLineaInves',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'director.deleteLineaInves' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'deleteLinea',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminCursoController@eliminarLineaInves',
        'controller' => 'App\\Http\\Controllers\\AdminCursoController@eliminarLineaInves',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'director.deleteLineaInves',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'director.deleteFinPersigue' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'delete-fin-persigue',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminCursoController@eliminarFinPersigue',
        'controller' => 'App\\Http\\Controllers\\AdminCursoController@eliminarFinPersigue',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'director.deleteFinPersigue',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'director.deleteDisInvestiga' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'delete-dis-investiga',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminCursoController@eliminarDisInvestiga',
        'controller' => 'App\\Http\\Controllers\\AdminCursoController@eliminarDisInvestiga',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'director.deleteDisInvestiga',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'director.asignar' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'asignarAsesor',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\CursoTesisController@showTablaAsignacion',
        'controller' => 'App\\Http\\Controllers\\CursoTesisController@showTablaAsignacion',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'director.asignar',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'director.saveAsesor' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'saveRegistro',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\CursoTesisController@saveAsesorAsignado',
        'controller' => 'App\\Http\\Controllers\\CursoTesisController@saveAsesorAsignado',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'director.saveAsesor',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'director.veragregarAsesor' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'agregarAsesor',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminCursoController@showAddAsesor',
        'controller' => 'App\\Http\\Controllers\\AdminCursoController@showAddAsesor',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'director.veragregarAsesor',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'director.addAsesor' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'agregarAsesor',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminCursoController@agregarAsesor',
        'controller' => 'App\\Http\\Controllers\\AdminCursoController@agregarAsesor',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'director.addAsesor',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'director.veragregar' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'agregarEstudiante',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminCursoController@showAddEstudiante',
        'controller' => 'App\\Http\\Controllers\\AdminCursoController@showAddEstudiante',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'director.veragregar',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'director.addEstudiante' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'agregarEstudiante',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminCursoController@agregarEstudiante',
        'controller' => 'App\\Http\\Controllers\\AdminCursoController@agregarEstudiante',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'director.addEstudiante',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'director.importarAlumnos' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'importarRegistro',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminCursoController@importRegistroAlumnos',
        'controller' => 'App\\Http\\Controllers\\AdminCursoController@importRegistroAlumnos',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'director.importarAlumnos',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'director.importarAsesores' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'importarRegistroAsesor',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminCursoController@importRegistroAsesores',
        'controller' => 'App\\Http\\Controllers\\AdminCursoController@importRegistroAsesores',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'director.importarAsesores',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'director.editarAsignacion' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'editarAsignacion',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\CursoTesisController@showAlumnosAsignados',
        'controller' => 'App\\Http\\Controllers\\CursoTesisController@showAlumnosAsignados',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'director.editarAsignacion',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'director.saveEdicion' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'saveEdicion',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\CursoTesisController@saveEdicionAsignacion',
        'controller' => 'App\\Http\\Controllers\\CursoTesisController@saveEdicionAsignacion',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'director.saveEdicion',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'director.deleteAlumno' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'deleteAlumno',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\CursoTesisController@deleteAlumno',
        'controller' => 'App\\Http\\Controllers\\CursoTesisController@deleteAlumno',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'director.deleteAlumno',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'director.asignarAsesorTesis' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'asignar-asesor-tesis',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Tesis2022Controller@showEstudentsForAsignacion',
        'controller' => 'App\\Http\\Controllers\\Tesis2022Controller@showEstudentsForAsignacion',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'director.asignarAsesorTesis',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'director.saveAsignarAsesorTesis' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'save-asignacion-tesis',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Tesis2022Controller@saveAsignacionTesis',
        'controller' => 'App\\Http\\Controllers\\Tesis2022Controller@saveAsignacionTesis',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'director.saveAsignarAsesorTesis',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'director.editAsignacionAsesorTesis' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'editar-asignacion-asesor',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Tesis2022Controller@showEstudiantAsignado',
        'controller' => 'App\\Http\\Controllers\\Tesis2022Controller@showEstudiantAsignado',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'director.editAsignacionAsesorTesis',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'director.saveEditarAsignacion' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'save-edicion-asignar',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Tesis2022Controller@saveEditarAsignacion',
        'controller' => 'App\\Http\\Controllers\\Tesis2022Controller@saveEditarAsignacion',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'director.saveEditarAsignacion',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'director.listaAlumnos' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'listaAlumnos',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\CursoTesisController@listaAlumnos',
        'controller' => 'App\\Http\\Controllers\\CursoTesisController@listaAlumnos',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'director.listaAlumnos',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'director.verAlumnoEditar' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'verAlumnoEditar',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\CursoTesisController@verAlumnoEditar',
        'controller' => 'App\\Http\\Controllers\\CursoTesisController@verAlumnoEditar',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'director.verAlumnoEditar',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'director.editEstudiante' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'saveEditAlumno',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\CursoTesisController@editEstudiante',
        'controller' => 'App\\Http\\Controllers\\CursoTesisController@editEstudiante',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'director.editEstudiante',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'director.listaAsesores' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'listaAsesores',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\CursoTesisController@listaAsesores',
        'controller' => 'App\\Http\\Controllers\\CursoTesisController@listaAsesores',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'director.listaAsesores',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'director.verAsesorEditar' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'verAsesorEditar',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\CursoTesisController@verAsesorEditar',
        'controller' => 'App\\Http\\Controllers\\CursoTesisController@verAsesorEditar',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'director.verAsesorEditar',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'director.editAsesor' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'saveEditAsesor',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\CursoTesisController@editAsesor',
        'controller' => 'App\\Http\\Controllers\\CursoTesisController@editAsesor',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'director.editAsesor',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'director.listaTesisAprobadas' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'lista-tesis-aprobadas',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\SustentacionController@lista_tesis_aprobadas',
        'controller' => 'App\\Http\\Controllers\\SustentacionController@lista_tesis_aprobadas',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'director.listaTesisAprobadas',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'director.saveAsignacionJurados' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'save-asignacion-jurados',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\SustentacionController@save_asignacion_jurados',
        'controller' => 'App\\Http\\Controllers\\SustentacionController@save_asignacion_jurados',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'director.saveAsignacionJurados',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'director.verSolicitudesJurados' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'lista-solicitudes-jurados',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\SustentacionController@lista_solicitudes_jurados',
        'controller' => 'App\\Http\\Controllers\\SustentacionController@lista_solicitudes_jurados',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'director.verSolicitudesJurados',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'director.verEditAsignacionJurados' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ver-editar-asignacion-jurados',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\SustentacionController@verEditAsignacionJurados',
        'controller' => 'App\\Http\\Controllers\\SustentacionController@verEditAsignacionJurados',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'director.verEditAsignacionJurados',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'director.editAsignacionJurados' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'edit-asignacion-jurados',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\SustentacionController@editAsignacionJurados',
        'controller' => 'App\\Http\\Controllers\\SustentacionController@editAsignacionJurados',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'director.editAsignacionJurados',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'alumno.verSolicitudSustentacion' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ver-solicitud-sustentacion',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\SustentacionController@verSolicitudSustentacion',
        'controller' => 'App\\Http\\Controllers\\SustentacionController@verSolicitudSustentacion',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'alumno.verSolicitudSustentacion',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'alumno.historicoSolicitud' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'historico-solicitud-sustentacion',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\SustentacionController@historicoSolicitud',
        'controller' => 'App\\Http\\Controllers\\SustentacionController@historicoSolicitud',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'alumno.historicoSolicitud',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'alumno.guardarSolicitud' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'guardar-solicitud-sustentacion',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\SustentacionController@guardarSolicitud',
        'controller' => 'App\\Http\\Controllers\\SustentacionController@guardarSolicitud',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'alumno.guardarSolicitud',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'asesor.crearInformeFinal' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'crear-informe-final',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\SustentacionController@crearInformeFinal',
        'controller' => 'App\\Http\\Controllers\\SustentacionController@crearInformeFinal',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'asesor.crearInformeFinal',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'asesor.listaEstudiantesInforme' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'lista-estudiantes-informe',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\SustentacionController@listarAlumnosInforme',
        'controller' => 'App\\Http\\Controllers\\SustentacionController@listarAlumnosInforme',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'asesor.listaEstudiantesInforme',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'asesor.guardarInformeFinal' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'guardar-informe-final',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\SustentacionController@guardarInformeFinal',
        'controller' => 'App\\Http\\Controllers\\SustentacionController@guardarInformeFinal',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'asesor.guardarInformeFinal',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'asesor.pdfInformeFinal' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'ver-informe-final-pdf',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\SustentacionController@generarPDFInformeFinal',
        'controller' => 'App\\Http\\Controllers\\SustentacionController@generarPDFInformeFinal',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'asesor.pdfInformeFinal',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'director.verRegistrarJurado' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ver-registrar-jurado',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\SustentacionController@verRegistrarJurado',
        'controller' => 'App\\Http\\Controllers\\SustentacionController@verRegistrarJurado',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'director.verRegistrarJurado',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'director.registrarJurado' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'registrar-jurado',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\SustentacionController@registrarJurado',
        'controller' => 'App\\Http\\Controllers\\SustentacionController@registrarJurado',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'director.registrarJurado',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'asesor.verListaSustentacion' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ver-lista-sustentacion',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\SustentacionController@verListaSustentacion',
        'controller' => 'App\\Http\\Controllers\\SustentacionController@verListaSustentacion',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'asesor.verListaSustentacion',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'asesor.verSustentacionEstudiante' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ver-sustentacion-estudiante/{cod_tesis}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\SustentacionController@verSustentacionEstudiante',
        'controller' => 'App\\Http\\Controllers\\SustentacionController@verSustentacionEstudiante',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'asesor.verSustentacionEstudiante',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'asesor.showEstudiantes' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'verEstudiantes',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\CursoTesisController@showEstudiantes',
        'controller' => 'App\\Http\\Controllers\\CursoTesisController@showEstudiantes',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'asesor.showEstudiantes',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'asesor.asignarTemas' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'asignarTemas',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\CursoTesisController@asignarTemas',
        'controller' => 'App\\Http\\Controllers\\CursoTesisController@asignarTemas',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'asesor.asignarTemas',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'asesor.guardarTemas' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'guardarTemas',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\CursoTesisController@guardarTemas',
        'controller' => 'App\\Http\\Controllers\\CursoTesisController@guardarTemas',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'asesor.guardarTemas',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'asesor.revisarTemas' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'revisarTemas',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\CursoTesisController@revisarTemas',
        'controller' => 'App\\Http\\Controllers\\CursoTesisController@revisarTemas',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'asesor.revisarTemas',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'asesor.guardarObservaciones' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'guardarObservaciones',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\CursoTesisController@guardarObservaciones',
        'controller' => 'App\\Http\\Controllers\\CursoTesisController@guardarObservaciones',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'asesor.guardarObservaciones',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'asesor.guardarSinObs' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'guardarSinObservaciones',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\CursoTesisController@guardarSinObservaciones',
        'controller' => 'App\\Http\\Controllers\\CursoTesisController@guardarSinObservaciones',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'asesor.guardarSinObs',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'asesor.verHistoObs' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ver-historial-estudiante',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminCursoController@verListaObservacion',
        'controller' => 'App\\Http\\Controllers\\AdminCursoController@verListaObservacion',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'asesor.verHistoObs',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'asesor.verObsEstudiante' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'observaciones-estudiante/{cod_historialObs}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminCursoController@verObsEstudiante',
        'controller' => 'App\\Http\\Controllers\\AdminCursoController@verObsEstudiante',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'asesor.verObsEstudiante',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'asesor.descargaObservacion' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'descargaObservacion',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\CursoTesisController@descargaObservacionCurso',
        'controller' => 'App\\Http\\Controllers\\CursoTesisController@descargaObservacionCurso',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'asesor.descargaObservacion',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'asesor.descarga-observacion' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'download-observacion',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Tesis2022Controller@descargaObservacion',
        'controller' => 'App\\Http\\Controllers\\Tesis2022Controller@descargaObservacion',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'asesor.descarga-observacion',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'asesor.aprobarCTProy' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'aprobarProyCT',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\CursoTesisController@aprobarProy',
        'controller' => 'App\\Http\\Controllers\\CursoTesisController@aprobarProy',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'asesor.aprobarCTProy',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'asesor.desaprobarCTProy' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'desaprobarProyCT',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\CursoTesisController@desaprobarProy',
        'controller' => 'App\\Http\\Controllers\\CursoTesisController@desaprobarProy',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'asesor.desaprobarCTProy',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'asesor.estudiantes-tesis' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ver-estudiantes-tesis',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Tesis2022Controller@showEstudiantesTesis',
        'controller' => 'App\\Http\\Controllers\\Tesis2022Controller@showEstudiantesTesis',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'asesor.estudiantes-tesis',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'asesor.historial-estudiantes' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'historial-estudiante-tesis',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Tesis2022Controller@',
        'controller' => 'App\\Http\\Controllers\\Tesis2022Controller@',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'asesor.historial-estudiantes',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'asesor.revisar-tesis' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'revisar-tesis',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Tesis2022Controller@revisarTesis',
        'controller' => 'App\\Http\\Controllers\\Tesis2022Controller@revisarTesis',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'asesor.revisar-tesis',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'asesor.guardar-sin-observaciones' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'guardar-sin-obs',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Tesis2022Controller@guardarSinObservaciones',
        'controller' => 'App\\Http\\Controllers\\Tesis2022Controller@guardarSinObservaciones',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'asesor.guardar-sin-observaciones',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'asesor.guardar-observaciones' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'guardar-observaciones',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Tesis2022Controller@guardarConObservaciones',
        'controller' => 'App\\Http\\Controllers\\Tesis2022Controller@guardarConObservaciones',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'asesor.guardar-observaciones',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'asesor.ver-obs-estudiante-tesis' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'observaciones-estudiante-tesis/{cod_historial_obs}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Tesis2022Controller@listaObsEstudianteTesis',
        'controller' => 'App\\Http\\Controllers\\Tesis2022Controller@listaObsEstudianteTesis',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'asesor.ver-obs-estudiante-tesis',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'asesor.ver-estudsiantes-obs' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'estudiantes-observaciones',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Tesis2022Controller@verEstudiantesObservacionTesis',
        'controller' => 'App\\Http\\Controllers\\Tesis2022Controller@verEstudiantesObservacionTesis',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'asesor.ver-estudsiantes-obs',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'asesor.aprobar-tesis' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'aprobarTesis',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Tesis2022Controller@aprobarTesis',
        'controller' => 'App\\Http\\Controllers\\Tesis2022Controller@aprobarTesis',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'asesor.aprobar-tesis',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'asesor.desaprobar-tesis' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'desaprobarTesis',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Tesis2022Controller@desaprobarTesis',
        'controller' => 'App\\Http\\Controllers\\Tesis2022Controller@desaprobarTesis',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'asesor.desaprobar-tesis',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'login' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'login',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\LoginController@showLoginForm',
        'controller' => 'App\\Http\\Controllers\\Auth\\LoginController@showLoginForm',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'login',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::D9mn5ro8eID1kFj2' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'login',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\LoginController@login',
        'controller' => 'App\\Http\\Controllers\\Auth\\LoginController@login',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::D9mn5ro8eID1kFj2',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'register' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'register',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\RegisterController@showRegistrationForm',
        'controller' => 'App\\Http\\Controllers\\Auth\\RegisterController@showRegistrationForm',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'register',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::Hn0garNnaZy9iInM' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'register',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\RegisterController@register',
        'controller' => 'App\\Http\\Controllers\\Auth\\RegisterController@register',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::Hn0garNnaZy9iInM',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'password.request' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'password/reset',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\ForgotPasswordController@showLinkRequestForm',
        'controller' => 'App\\Http\\Controllers\\Auth\\ForgotPasswordController@showLinkRequestForm',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'password.request',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'password.email' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'password/email',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\ForgotPasswordController@sendResetLinkEmail',
        'controller' => 'App\\Http\\Controllers\\Auth\\ForgotPasswordController@sendResetLinkEmail',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'password.email',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'password.reset' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'password/reset/{token}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\ResetPasswordController@showResetForm',
        'controller' => 'App\\Http\\Controllers\\Auth\\ResetPasswordController@showResetForm',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'password.reset',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'password.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'password/reset',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\ResetPasswordController@reset',
        'controller' => 'App\\Http\\Controllers\\Auth\\ResetPasswordController@reset',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'password.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'password.confirm' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'password/confirm',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\ConfirmPasswordController@showConfirmForm',
        'controller' => 'App\\Http\\Controllers\\Auth\\ConfirmPasswordController@showConfirmForm',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'password.confirm',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::n0fsWWlVESiYeoAm' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'password/confirm',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\ConfirmPasswordController@confirm',
        'controller' => 'App\\Http\\Controllers\\Auth\\ConfirmPasswordController@confirm',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::n0fsWWlVESiYeoAm',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::CYrgndOBZcfXCJf4' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'cmd/{comand}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:47:"Laravel\\SerializableClosure\\SerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Signed":2:{s:12:"serializable";s:295:"O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:77:"function($comand){
    \\Illuminate\\Support\\Facades\\Artisan::call($comand);

}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000517e63080000000060ebfc5f";}";s:4:"hash";s:44:"J6QDj/OhklQqJ448Ded3SEFOv5pHFLqFIJSbm5X01FU=";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::CYrgndOBZcfXCJf4',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
  ),
)
);
