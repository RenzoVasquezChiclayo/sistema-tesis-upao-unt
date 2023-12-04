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
            <a class="cstm-a" href="{{ route('curso.tesis20221') }}">
                <i class='bx bx-sm bx-book-bookmark'></i>
                <span class="links_name">Proyecto Tesis</span>
            </a>
            <span class="tooltip">Proyecto Tesis</span>
        </li>
        <li>
            <a class="cstm-a" href="{{ route('curso.estado-proyecto') }}">
                <i class='bx bx-sm bx-battery'></i>
                <span class="links_name">Estado del Proyecto</span>
            </a>
            <span class="tooltip">Estado del Proyecto</span>
        </li>
        <li>
            <a class="cstm-a" href="{{ route('curso.registro-tesis') }}">
                <i class='bx bxs-graduation'></i>
                <span class="links_name">Tesis</span>
            </a>
            <span class="tooltip">Tesis</span>
        </li>
        <li>
            <a class="cstm-a" href="{{ route('curso.estado-tesis') }}">
                <i class='bx bx-sm bx-battery'></i>
                <span class="links_name">Estado de la Tesis</span>
            </a>
            <span class="tooltip">Estado de la Tesis</span>
        </li>
        {{-- <a class="cstm-a" href="{{route('curso.verHistorialObs')}}" >
        <i class="nav-icon fas fa-graduation-cap"></i>
        <span class="links_name">Historial de Correcciones</span>
    </a> --}}

    {{-- Nav para el Director del curso TESIS I --}}
    @elseif (auth()->user()->rol == 'd-CTesis2022-1' || auth()->user()->rol == 'administrador')
        @if (auth()->user()->rol == 'administrador')

            <li data-toggle="collapse" data-target="#usuarios" class="collapsed active">
                {{-- <a class="cstm-a" href="{{ route('admin.listar') }}">
                    <i class='bx bxs-user'></i>
                    <span class="links_name">Listar Usuarios</span>
                </a>
                <span class="tooltip">Listar Usuarios</span> --}}
            </li>
            <ul class="sub-menu collapse" id="usuarios">
                <li class="active"><a class="cstm-a" href="{{ route('admin.listar') }}">Listar Usuario</a></li>
            </ul>
            <li>
                <a class="cstm-a" href="{{ route('admin.verConfiguraciones') }}">
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
                    <span class="links_name">Listar Grado Académico</span>
                </a>
                <span class="tooltip">Listar Grado Académico</span>
            </li>
        @endif
        <li>
            <a class="cstm-a" data-bs-toggle="collapse" href="#collapseGeneral" role="button" aria-expanded="false" aria-controls="collapseGeneral">
                <i class='bx bx-sm bx-check-square'></i>
                <span class="links_name">General</span>
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
            <a class="cstm-a" data-bs-toggle="collapse" href="#collapseAlumno" role="button" aria-expanded="false" aria-controls="collapseAlumno">
                <i class='bx bx-sm bx-check-square'></i>
                <span class = "links_name">Alumno</span>
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
            <a class="cstm-a" data-bs-toggle="collapse" href="#collapseAsesor" role="button" aria-expanded="false" aria-controls="collapseAsesor">
                <i class='bx bx-sm bx-check-square'></i>
                <span class = "links_name">Asesores y Docentes</span>
            </a>
            <div class="cstm-collapse collapse" id="collapseAsesor">
                <a href="{{ route('director.listaAsesores') }}">
                    <span class="links_name">Lista Asesores y Docentes</span>
                </a>
                <a href="{{ route('director.veragregarAsesor') }}">
                    <span class="links_name">Agregar Asesores y Docentes</span>
                </a>
            </div>
        </li>
        <li>
            <a class="cstm-a" href="{{ route('director.asignar') }}">
                <i class='bx bx-sm bx-check-square'></i>
                <span class="links_name">Proyecto de Tesis</span>
            </a>
            <span class="tooltip">Proyecto de Tesis</span>
        </li>
        <li>
            <a class="cstm-a" href="{{ route('director.asignarAsesorTesis') }}">
                <i class='bx bx-sm bx-check-square'></i>
                <span class="links_name">Tesis</span>
            </a>
            <span class="tooltip">Tesis</span>
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

        {{-- Nav para la Secretaria, agregara estudiantes --}}
        {{-- @elseif (auth()->user()->rol == 'secretaria')

    <a href="{{route('secretaria.veragregar')}}" >
        <i class="nav-icon fas fa-graduation-cap"></i>
        <span class="links_name">Agregar estudiante</span>
    </a> --}}
    @endif

@endauth
