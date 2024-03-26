{{-- @extends('plantilla.dashboard')
@section('titulo')
    Agregar Asesor
@endsection
@section('contenido')
    <div class="row" style="text-align:left; justify-content:center; padding-top:15px; padding-bottom:15px;">
        <div class="col-10">
            <div class="row" style="text-align:center;">
                <h3>Registro de Asesores</h3>
            </div>
            <div class="row border-box" style="margin-bottom: 50px;">
                <form action="{{ route('director.importarAsesores') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row justify-content-end">
                        <div class="col-3">
                            <h5>Semestre académico</h5>
                        </div>
                        <div class="col-2">
                            <select class="form-select" name="semestre_academico" id="semestre_academico" onchange="select_semestre();" required>
                                <option value="0">-</option>
                                @foreach ($semestre_academico as $sem)
                                    <option value="{{ $sem->cod_config_ini }}">{{ $sem->year }}_{{ $sem->curso }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <h5>Importar desde registro excel</h5>
                    </div>
                    <div class="row">
                        <div class="col-7">
                            <input class="form-control" type="file" name="importAsesor" id="importAsesor">
                        </div>
                        <div class="col-5">
                            <button class="btn btn-success" type="submit">Importar Registro</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="row border-box" style="justify-content:center;">
                <div class="col-12" style="text-align:center;">
                    <h5>Registro de asesor</h5>
                </div>
                <form class="row g-3 needs-validation" action="{{ route('director.addAsesor') }}" method="POST" novalidate>
                    @csrf
                    <input type="hidden" name="semestre_hidden" id="semestre_hidden">
                    <div class="col-6">
                        <label for="cod_docente">Codigo Institucional</label>
                        <input class="form-control" minlength="4" maxlength="4" type="text" id="cod_docente"
                            onkeypress="return (event.charCode >= 48 && event.charCode <= 57)" name="cod_docente"
                            placeholder="Ingrese su codigo de docente" autofocus required>
                    </div>
                    <div class="col-6">
                        <label for="orcid">ORCID</label>
                        <input class="form-control" minlength="19" maxlength="20" type="text" id="orcid"
                            name="orcid" placeholder="Ingrese su codigo ORCID" required>
                    </div>
                    <div class="col-12">
                        <label for="apellidos">Apellidos</label>
                        <input class="form-control" type="text" id="apellidos" name="apellidos"
                            placeholder="Ingrese sus apellidos" required>
                    </div>
                    <div class="col-12">
                        <label for="nombres">Nombres</label>
                        <input class="form-control" type="text" id="nombres" name="nombres"
                            placeholder="Ingrese su nombre" required>
                    </div>
                    <div class="col-12">
                        <label for="gradoAcademico">Categoría</label>
                        <select class="form-control" name="gradAcademico" id="gradAcademico" required>
                            <option value="0">NOMBRADO</option>
                            <option value="1">CONTRATADO</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label for="carrera">Carrera</label>
                        <select class="form-control" name="carrera" id="carrera" required>
                            <option value="0">Contabilidad y Finanzas</option>
                            <option value="1">Administracion</option>
                            <option value="2">Economia</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label for="direccion">Dirección</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="direccion" name="direccion" maxlength="30">
                            <span class="input-group-text" id="contador-caracteres">0/30</span>
                        </div>
                    </div>
                    <div class="col-12">
                        <label for="correo">Correo</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="correo" name="correo" maxlength="80">
                        </div>
                    </div>
                    <div class="col-12" style="margin-top: 10px;">
                        <button class="btn btn-success" type="submit">Registrar</button>
                        <a href="{{ route('user_information') }}" type="button" class="btn btn-danger">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('datos') == 'ok')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Asesor agregado correctamente',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @elseif (session('datos') == 'oknot')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error al agregar el asesor',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @endif
    <script type="text/javascript">
        function select_semestre() {
            semestre = document.getElementById('semestre_academico');
            selected = semestre.options[semestre.selectedIndex].text;
            document.getElementById('semestre_hidden').value = selected;
        }
        const inputDireccion = document.querySelector('#direccion');
        const contadorCaracteres = document.querySelector('#contador-caracteres');

        inputDireccion.addEventListener('input', () => {
            contadorCaracteres.textContent = `${inputDireccion.value.length}/30`;
        });
    </script>
@endsection --}}
@extends('plantilla.dashboard')
@section('titulo')
    Agregar Asesores y Docentes
@endsection
@section('contenido')
    <div class="card-header">
        Registrar Asesores y Docentes
    </div>
    <div class="card-body">
        <div class="row justify-content-around align-items-center">
            <div class="row border-box" style="margin-bottom: 30px;">
                <form action="{{ route('director.importarAsesores') }}" method="post" enctype="multipart/form-data" id="form-asesor">
                    @csrf
                    <div class="row justify-content-center" style="margin-bottom: 20px;">
                        <div class="col-3">
                            <h5>Escuela</h5>
                            <select class="form-select" onchange="select_escuela(this);" name="escuela" id="escuela"
                                required>
                                @foreach ($escuela as $e)
                                    <option value="{{ $e->cod_escuela }}">{{ $e->nombre }}</option>
                                @endforeach
                            </select>
                            <span id="span_escuela" style="color: red"></span>
                        </div>
                        <div class="col-3">
                            <h5>Semestre academico</h5>
                            <select class="form-select" onchange="select_semestre(this);" name="semestre_academico"
                                id="semestre_academico" required>
                                @foreach ($semestre_academico as $s_a)
                                    <option value="{{ $s_a->cod_config_ini }}">{{ $s_a->year }}_{{ $s_a->curso }}
                                    </option>
                                @endforeach
                            </select>
                            <span id="span_semestre" style="color: red"></span>
                        </div>
                    </div>
                    <div class="card text-center shadow bg-white rounded">
                        <div class="card-body">
                            <h5 class="card-title">Importar un registro Excel</h5>
                            <div class="row justify-content-around align-items-center">
                                <div class="col-md-5">
                                    <input class="form-control" type="file" name="importAsesor" id="importAsesor">
                                </div>
                                <div class="col-md-3">
                                    <button class="btn btn-success" type="submit">Importar Registro</button>
                                    <a href="#" data-bs-toggle="tooltip"
                                        data-bs-title="El documento Excel debe tener las siguientes cabeceras: cod_docente,nombres,orcid,categoria,carrera,direccion,correo">
                                        <i class='bx bx-info-circle'></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <div class="card text-center shadow bg-white rounded">
                <div class="card-body">
                    <h5 class="card-title">Registrar por asesor y docente</h5>
                    <div class="row border-box">
                        <form class="row g-3 needs-validation" action="{{ route('director.addAsesor') }}" method="POST">
                            @csrf
                            <input type="hidden" name="semestre_hidden" id="semestre_hidden">
                            <input type="hidden" name="escuela_hidden" id="escuela_hidden">
                            <div class="row justify-content-around align-items-center">
                                <div class="col-4">
                                    <label for="cod_docente">Codigo Institucional</label>
                                    <input class="form-control" minlength="4" maxlength="4" type="text"
                                        id="cod_docente" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)"
                                        name="cod_docente" placeholder="Ingrese su codigo de docente" autofocus required>
                                </div>
                                <div class="col-4">
                                    <label for="orcid">ORCID</label>
                                    <input class="form-control" minlength="19" maxlength="20" type="text" id="orcid"
                                        name="orcid" placeholder="Ingrese su codigo ORCID" required>
                                </div>
                            </div>
                            <div class="row justify-content-around align-items-center">

                                <div class="col-md-4">
                                    <label for="nombres">Nombres</label>
                                    <input class="form-control" type="text" id="nombres" name="nombres"
                                        placeholder="Ingrese su nombre" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="apellidos">Apellidos</label>
                                    <input class="form-control" type="text" id="apellidos" name="apellidos"
                                        placeholder="Ingrese sus apellidos" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="gradoAcademico">Grado Academico</label>
                                    <select class="form-control" name="gradAcademico" id="gradAcademico" required>
                                        @foreach ($grados_academicos as $g_a)
                                            <option value="{{ $g_a->cod_grado_academico }}">{{ $g_a->descripcion }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row justify-content-around align-items-center">
                                <div class="col-md-3">
                                    <label for="categoria">Categoria</label>
                                    <select class="form-control" name="categoria" id="categoria" required>
                                        @foreach ($categorias as $c)
                                            <option value="{{ $c->cod_categoria }}">{{ $c->descripcion }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="direccion">Direccion</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="direccion" name="direccion"
                                            maxlength="30" required>
                                        <span class="input-group-text" id="contador-caracteres">0/30</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="correo">Correo Institucional</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="correo" name="correo"
                                            maxlength="80">
                                    </div>
                                </div>
                            </div>

                            <div class="col-12" style="margin-top: 10px;">
                                <button class="btn btn-success" type="submit">Registrar</button>
                                <a href="{{ route('user_information') }}" type="button"
                                    class="btn btn-danger">Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('js')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('datos') == 'ok')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Asesor y Docente agregado correctamente',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @elseif (session('datos') == 'oknot')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error al agregar el asesor y docente',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @elseif (session('datos') == 'exists')
    <script>
        Swal.fire({
            position: 'center',
            icon: 'error',
            title: 'Ya existe un asesor con el mismo codigo institucional',
            showConfirmButton: false,
            timer: 1500
        })
    </script>
    @endif
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
                document.getElementById("form-asesor").addEventListener('submit', validarFormulario);
            });

        function validarFormulario(evento) {
            evento.preventDefault();
            let semestre = document.getElementById('semestre_academico').value;
            let escuela = document.getElementById('escuela').value;
            if(semestre.length == 0) {
                document.getElementById("span_semestre").innerHTML = "* Debe seleccionar semestre academico";
                return;
            }
            if(escuela.length == 0) {
                document.getElementById("span_escuela").innerHTML = "* Debe seleccionar escuela";
                return;
            }
            this.submit();
        }
        window.onload = function() {
            semestre = document.getElementById('semestre_academico').value;
            document.getElementById('semestre_hidden').value = semestre;

            escuela = document.getElementById('escuela').value;
            document.getElementById('escuela_hidden').value = escuela;
        }

        function select_semestre() {
            semestre = document.getElementById('semestre_academico').value;
            if (semestre != '0') {
                document.getElementById('semestre_hidden').value = semestre;
            } else {
                Swal.fire({
                            position: "top",
                            icon: "warning",
                            title: "Seleccione otra opcion de semestre academico",
                            showConfirmButton: false,
                            timer: 2000
                        });
            }
        }

        function select_escuela() {
            escuela = document.getElementById('escuela').value;
            if (escuela != '0') {
                document.getElementById('escuela_hidden').value = escuela;
            } else {
                Swal.fire({
                            position: "top",
                            icon: "warning",
                            title: "Seleccione otra opcion de escuela",
                            showConfirmButton: false,
                            timer: 2000
                        });
            }
        }

        const inputDireccion = document.querySelector('#direccion');
        const contadorCaracteres = document.querySelector('#contador-caracteres');

        inputDireccion.addEventListener('input', () => {
            contadorCaracteres.textContent = `${inputDireccion.value.length}/30`;
        });

        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    </script>
@endsection
