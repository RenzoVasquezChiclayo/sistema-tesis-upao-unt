@auth
    <li>
        <a class="cstm-a" href="{{ route('user_information') }}">
            <i class='bx bx-sm bx-user-circle'></i>
            <span class="links_name">Perfil</span>
        </a>
        <span class="tooltip">Perfil</span>
    </li>
    <li>
        <a class="cstm-a" href="{{ route('user_reports') }}">
            <i class='bx bxs-report'></i>
            <span class="links_name">Reportes</span>
        </a>
        <span class="tooltip">Reportes</span>
    </li>

    {{-- Nav para el Egresado --}}
    @if (auth()->user()->rol == 'estudiante')
        <li>
            <a class="cstm-a" href="{{ route('egresadoindex') }}">
                <i class='bx bx-sm bx-memory-card'></i>
                <span class="links_name">Formato del Egresado</span>
            </a>
            <span class="tooltip">Egresado</span>
        </li>
        <li>
            <a class="cstm-a" href="{{ route('index') }}">
                <i class='bx bx-sm bx-book-bookmark'></i>
                <span class="links_name">Proyecto de Tesis</span>
            </a>
            <span class="tooltip">Proyecto de Tesis</span>
        </li>
        {{-- Para obtener las propiedades del user --}}
        {{-- auth()->user()->name --}}
        <li>
            <a class="cstm-a" href="{{ route('verRegistroHistorial') }}">
                <i class='bx bx-sm bx-history'></i>
                <span class="links_name">Historial de Correcciones</span>
            </a>
            <span class="tooltip">Correcciones</span>
        </li>

        {{-- Nav para el Director de escuela --}}
    @elseif (auth()->user()->rol == 'director')
        <li>
            <a class="cstm-a" href="{{ route('director.formatos') }}">
                <i class='bx bx-sm bx-memory-card'></i>
                <span class="links_name">Formatos de titulos</span>
            </a>
            <span class="tooltip">Formatos de titulos</span>
        </li>

        {{-- Nav para el Asesor de las tesis --}}
    @elseif (auth()->user()->rol == 'asesor')
        <li>
            <a class="cstm-a" href="{{ route('asesor.proyectos') }}">
                <i class="nav-icon fas fa-graduation-cap"></i>
                <span class="links_name">Proyectos de tesis</span>
            </a>
            <span class="tooltip">Proyectos de tesis</span>
        </li>
        <li>
            <a class="cstm-a" href="{{ route('asesor.historial_observaciones') }}">
                <i class='bx bx-sm bx-history'></i>
                <span class="links_name">Historial de Observaciones</span>
            </a>
            <span class="tooltip">Observaciones</span>
        </li>

        {{-- Nav para los Docentes, vista Silabo --}}
    @elseif (auth()->user()->rol == 'docente')
        <li>
            <a class="cstm-a" href="{{ route('docente.showSilabos') }}">
                <i class="nav-icon fas fa-graduation-cap"></i>
                <span class="links_name">Silabo</span>
            </a>
            <span class="tooltip">Silabo</span>
        </li>

        {{-- Nav para el Alumnos del curso TESIS I --}}
    @elseif (auth()->user()->rol == 'CTesis2022-1')
        <li>
            <a class="cstm-a menu-a" data-bs-toggle="collapse" href="#collapseProyectoTesis" role="button"
                aria-expanded="false" aria-controls="collapseProyectoTesis">
                <div class="menu-into-a">
                    <i class='bx bx-group'></i>
                    <span class = "links_name">Proyecto de tesis</span>
                </div>
                <i class='bx bx-xs bxs-chevron-down'></i>
            </a>
            <div class="cstm-collapse collapse" id="collapseProyectoTesis">
                <a href="{{ route('curso.tesis20221') }}">
                    <span class="links_name">Documento</span>
                </a>
                <a href="{{ route('curso.estado-proyecto') }}">
                    <span class="links_name">Estado</span>
                </a>
            </div>
        </li>
        <li>
            <a class="cstm-a menu-a" data-bs-toggle="collapse" href="#collapseProyectoTesisE" role="button"
                aria-expanded="false" aria-controls="collapseProyectoTesisE">
                <div class="menu-into-a">
                    <i class='bx bx-group'></i>
                    <span class = "links_name">Evaluación Proyecto</span>
                </div>
                <i class='bx bx-xs bxs-chevron-down'></i>
            </a>
            <div class="cstm-collapse collapse" id="collapseProyectoTesisE">
                <a href="{{ route('estudiante.evaluacion.proyecto-tesis') }}">
                    <span class="links_name">Documento</span>
                </a>
                <a href="{{ route('estudiante.evaluacion.estado-proyecto-tesis') }}">
                    <span class="links_name">Estado</span>
                </a>
            </div>
        </li>
        <li>
            <a class="cstm-a menu-a" data-bs-toggle="collapse" href="#collapseTesisA" role="button"
                aria-expanded="false" aria-controls="collapseTesisA">
                <div class="menu-into-a">
                    <i class='bx bx-group'></i>
                    <span class = "links_name">Tesis</span>
                </div>
                <i class='bx bx-xs bxs-chevron-down'></i>
            </a>
            <div class="cstm-collapse collapse" id="collapseTesisA">
                <a href="{{ route('curso.registro-tesis') }}">
                    <span class="links_name">Documento</span>
                </a>
                <a href="{{ route('curso.estado-tesis') }}">
                    <span class="links_name">Estado</span>
                </a>
            </div>
        </li>
        <li>
            <a class="cstm-a menu-a" data-bs-toggle="collapse" href="#collapseTesisE" role="button"
                aria-expanded="false" aria-controls="collapseTesisE">
                <div class="menu-into-a">
                    <i class='bx bx-group'></i>
                    <span class = "links_name">Evaluación Tesis</span>
                </div>
                <i class='bx bx-xs bxs-chevron-down'></i>
            </a>
            <div class="cstm-collapse collapse" id="collapseTesisE">
                <a href="{{ route('estudiante.evaluacion.view-tesis') }}">
                    <span class="links_name">Documento</span>
                </a>
                <a href="{{ route('estudiante.evaluacion.estado-tesis') }}">
                    <span class="links_name">Estado</span>
                </a>
            </div>
        </li>

        <li>
            <a class="cstm-a menu-a" data-bs-toggle="collapse" href="#collapseSolicitud" role="button"
                aria-expanded="false" aria-controls="collapseSolicitud">
                <div class="menu-into-a">
                    <i class='bx bx-group'></i>
                    <span class = "links_name">Sustentacion</span>
                </div>
                <i class='bx bx-xs bxs-chevron-down'></i>
            </a>
            <div class="cstm-collapse collapse" id="collapseSolicitud">
                <a href="#">
                    <span class="links_name">Solicitud sustentación</span>
                </a>
                <a href="#">
                    <span class="links_name">Historico sustentacion</span>
                </a>
                @if ($exist_obs == true)
                    <a href="{{ route('estudiante.evaluacion.listaObservacionesTesis') }}">
                        <span class="links_name">Observaciones Tesis</span>
                    </a>
                @endif
            </div>
        </li>

        {{-- <a href="{{route('curso.verHistorialObs')}}" >
        <i class="nav-icon fas fa-graduation-cap"></i>
        <span class="links_name">Historial de Correcciones</span>
    </a> --}}

        {{-- Nav para el Director del curso TESIS I --}}
    @elseif (auth()->user()->rol == 'd-CTesis2022-1' || auth()->user()->rol == 'administrador')
        @if (auth()->user()->rol == 'administrador')
            <li>
                <a class="cstm-a" href="{{ route('admin.listar') }}">
                    <i class='bx bxs-user'></i>
                    <span class="links_name">Listar Usuarios</span>
                </a>
                <span class="tooltip">Listar Usuarios</span>
            </li>
            <li>
                <a class="cstm-a" href="{{ route('admin.configurar') }}">
                    <i class='bx bxs-cog'></i>
                    <span class="links_name">Semestre Académico</span>
                </a>
                <span class="tooltip">Semestre Académico</span>
            </li>
            <li>
                <a class="cstm-a" href="{{ route('admin.listarcategoriasDocente') }}">
                    <i class='bx bx-sm bx-list-ol'></i>
                    <span class="links_name">Listar Categorias Docente</span>
                </a>
                <span class="tooltip">Listar Categorias Docente</span>
            </li>
            <li>
                <a class="cstm-a" href="{{ route('admin.verAgregarGrado') }}">
                    <i class='bx bx-sm bx-list-ol'></i>
                    <span class="links_name">Grado Academico</span>
                </a>
                <span class="tooltip">Grado Academico</span>
            </li>
        @endif
        <li>
            <a class="cstm-a menu-a" data-bs-toggle="collapse" href="#collapseGeneral" role="button"
                aria-expanded="false" aria-controls="collapseGeneral">
                <div class="menu-into-a">
                    <i class='bx bx-sm bx-check-square'></i>
                    <span class="links_name">General</span>
                </div>
                <i class='bx bx-xs bxs-chevron-down'></i>
            </a>
            <div class="cstm-collapse collapse" id="collapseGeneral">
                <a href="{{ route('director.generalidades') }}">
                    <span class="links_name">Generalidades</span>
                </a>
                <a href="{{ route('director.mantenedorlineaInves') }}">
                    <span class="links_name">Mantenedor Generalidades</span>
                </a>
                <a href="{{ route('admin.verFacultad') }}">
                    <span class="links_name">Facultad</span>
                </a>
                <a href="{{ route('admin.verEscuela') }}">
                    <span class="links_name">Escuela</span>
                </a>
                <a href="{{ route('admin.verCronograma') }}">
                    <span class="links_name">Cronograma</span>
                </a>
                <a href="{{ route('admin.verPresupuesto') }}">
                    <span class="links_name">Presupuesto</span>
                </a>
            </div>
        </li>
        <li>
            <a class="cstm-a" href="{{ route('director.verGrupos') }}">
                <i class='bx bxs-group'></i>
                <span class="links_name">Grupos de Investigacion</span>
            </a>
            <span class="tooltip">Grupos de Investigacion</span>
        </li>
        <li>
            <a class="cstm-a menu-a" class="cstm-a" data-bs-toggle="collapse" href="#collapseAlumno" role="button"
                aria-expanded="false" aria-controls="collapseAlumno">
                <div class="menu-into-a">
                    <i class='bx bx-group'></i>
                    <span class = "links_name">Alumno</span>
                </div>
                <i class='bx bx-xs bxs-chevron-down'></i>
            </a>
            <div class="cstm-collapse collapse" id="collapseAlumno">
                <a href="{{ route('director.listaAlumnos') }}">
                    <span class="links_name">Lista Alumnos</span>
                </a>
                <a href="{{ route('director.veragregar') }}">
                    <span class="links_name">Agregar Alumno</span>
                </a>
            </div>
        </li>
        <li>
            <a class="cstm-a menu-a" class="cstm-a" data-bs-toggle="collapse" href="#collapseAsesor" role="button"
                aria-expanded="false" aria-controls="collapseAsesor">
                <div class="menu-into-a">
                    <i class='bx bx-male-female'></i>
                    <span class = "links_name">Asesores</span>
                </div>
                <i class='bx bx-xs bxs-chevron-down'></i>
            </a>
            <div class="cstm-collapse collapse" id="collapseAsesor">
                <a href="{{ route('director.listaAsesores') }}">
                    <span class="links_name">Lista Asesores</span>
                </a>
                <a href="{{ route('director.veragregarAsesor') }}">
                    <span class="links_name">Agregar Asesores</span>
                </a>
            </div>
        </li>
        <li>
            <a class="cstm-a menu-a" class="cstm-a" data-bs-toggle="collapse" href="#collapseJurado" role="button"
                aria-expanded="false" aria-controls="collapseJurado">
                <div class="menu-into-a">
                    <i class='bx bx-group'></i>
                    <span class = "links_name">Jurado</span>
                </div>
                <i class='bx bx-xs bxs-chevron-down'></i>
            </a>
            <div class="cstm-collapse collapse" id="collapseJurado">
                <a href="{{ route('director.verRegistrarJurado') }}">
                    <span class="links_name">Registrar jurado</span>
                </a>
            </div>
            <div class="cstm-collapse collapse" id="collapseJurado">
                <a href="{{ route('director.listaTesisAprobadas') }}">
                    <span class="links_name">Asignar Jurados</span>
                </a>
            </div>
        </li>
        <li>
            <a class="cstm-a menu-a" class="cstm-a" data-bs-toggle="collapse" href="#collapseProyectoTesis"
                role="button" aria-expanded="false" aria-controls="collapseProyectoTesis">
                <div class="menu-into-a">
                    <i class='bx bx-group'></i>
                    <span class = "links_name">Proyecto de Tesis</span>
                </div>
                <i class='bx bx-xs bxs-chevron-down'></i>
            </a>
            <div class="cstm-collapse collapse" id="collapseProyectoTesis">
                <a href="{{ route('director.asignarAsesorGrupos') }}">
                    <span class="links_name">Asignar asesor</span>
                </a>
            </div>
            <div class="cstm-collapse collapse" id="collapseProyectoTesis">
                <a href="{{ route('director.listaProyectosAprobados') }}">
                    <span class="links_name">Asignar jurado</span>
                </a>
            </div>
        </li>
        <li>
            <a class="cstm-a menu-a" class="cstm-a" data-bs-toggle="collapse" href="#collapseTesis" role="button"
                aria-expanded="false" aria-controls="collapseTesis">
                <div class="menu-into-a">
                    <i class='bx bx-group'></i>
                    <span class = "links_name">Tesis</span>
                </div>
                <i class='bx bx-xs bxs-chevron-down'></i>
            </a>
            <div class="cstm-collapse collapse" id="collapseTesis">
                <a href="{{ route('director.asignarAsesorGruposTesis') }}">
                    <span class="links_name">Asignar asesor</span>
                </a>
            </div>
            <div class="cstm-collapse collapse" id="collapseTesis">
                <a href="{{ route('director.listaTesisAprobadas') }}">
                    <span class="links_name">Asignar jurado</span>
                </a>
            </div>
        </li>

        {{-- Nav para el Asesor del curso TESIS I --}}
    @elseif (auth()->user()->rol == 'a-CTesis2022-1')
        <li>
            <a class="cstm-a" href="{{ route('asesor.showEstudiantes') }}">
                <i class='bx bx-sm bx-group'></i>
                <span class="links_name">Estudiantes Proyecto</span>
            </a>
            <span class="tooltip">Estudiantes</span>
        </li>
        <li>
            <a class="cstm-a" href="{{ route('asesor.verHistoObs') }}">
                <i class='bx bx-sm bx-history'></i>
                <span class="links_name">Historial Proyecto</span>
            </a>
            <span class="tooltip">Observaciones</span>
        </li>
        <li>
            <a class="cstm-a" href="{{ route('asesor.estudiantes-tesis') }}">
                <i class='bx bx-sm bx-group'></i>
                <span class="links_name">Estudiantes Tesis</span>
            </a>
            <span class="tooltip">Estudiantes</span>
        </li>
        <li>
            <a class="cstm-a" href="{{ route('asesor.ver-estudsiantes-obs') }}">
                <i class='bx bx-sm bx-history'></i>
                <span class="links_name">Historial Tesis</span>
            </a>
            <span class="tooltip">Estudiantes</span>
        </li>
        @if ($exists_jurado == true)
            <li>
                <a class="cstm-a menu-a" class="cstm-a" data-bs-toggle="collapse" href="#collapseJurado" role="button"
                    aria-expanded="false" aria-controls="collapseJurado">
                    <div class="menu-into-a">
                        <i class='bx bx-group'></i>
                        <span class = "links_name">Jurado</span>
                    </div>
                    <i class='bx bx-xs bxs-chevron-down'></i>
                </a>
                <div class="cstm-collapse collapse" id="collapseJurado">
                    <a href="{{ route('jurado.listaProyectosAsignados') }}">
                        <span class="links_name">Lista de proyectos(Evaluación)</span>
                    </a>
                    <a href="{{ route('jurado.listaTesisAsignadas') }}">
                        <span class="links_name">Lista de tesis(Evaluación)</span>
                    </a>
                </div>
            </li>
        @endif
        {{-- Nav para la Secretaria, agregara estudiantes --}}
        {{-- @elseif (auth()->user()->rol == 'secretaria')

    <a href="{{route('secretaria.veragregar')}}" >
        <i class="nav-icon fas fa-graduation-cap"></i>
        <span class="links_name">Agregar estudiante</span>
    </a> --}}
    @endif

@endauth
