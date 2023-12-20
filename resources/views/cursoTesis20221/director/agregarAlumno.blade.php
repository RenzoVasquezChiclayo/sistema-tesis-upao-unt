@extends('plantilla.dashboard')
@section('titulo')
    Agregar Alumno
@endsection
@section('css')
    <style type="text/css">
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
@endsection
@section('contenido')
    <div class="card-header">
        Registrar Estudiante de Contabilidad
    </div>
    <div class="card-body">
        <div class="row justify-content-around align-items-center">

            <div class="row border-box" style="margin-bottom: 30px;">
                <form action="{{ route('director.importarAlumnos') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row justify-content-center" style="margin-bottom: 20px;">
                        <div class="col-3">
                            <h5>Escuela</h5>
                            <select class="form-select" onchange="select_escuela();" name="escuela" id="escuela" required>
                                @foreach ($escuela as $e)
                                    <option value="{{ $e->cod_escuela }}">{{$e->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-2">
                            <h5>Semestre academico</h5>
                            <select class="form-select" onchange="select_semestre();" name="semestre_academico" id="semestre_academico" required>
                                @foreach ($semestre_academico as $s_a)
                                    <option value="{{ $s_a->cod_configuraciones }}">{{$s_a->año}}_{{$s_a->curso}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="card text-center shadow bg-white rounded">
                        <div class="card-body">
                            <h5 class="card-title">Importar un registro Excel</h5>
                            <div class="row justify-content-around align-items-center">
                                <div class="col-5">
                                    <input class="form-control" type="file" name="importAlumno" id="importAlumno">
                                </div>
                                <div class="col-4">
                                    <button class="btn btn-success" type="submit">Importar Registro</button>
                                    <a href="#" data-bs-toggle="tooltip"
                                        data-bs-title="El documento Excel debe tener las siguientes cabeceras: cod_matricula,dni,apellidos,nombres,correo">
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
                    <h5 class="card-title">Registrar por alumno</h5>
                    <div class="row border-box">
                        <form action="{{ route('director.addEstudiante') }}" method="POST">
                            @csrf
                            <input type="hidden" name="semestre_hidden" id="semestre_hidden">
                            <input type="hidden" name="escuela_hidden" id="escuela_hidden">
                            <div class="row justify-content-around align-items-center">
                                <div class="col-md-4">
                                    <label for="cod_matricula">Codigo de Matricula</label>
                                    <input class="form-control" minlength="10" maxlength="10" type="text"
                                        onkeypress="return (event.charCode >= 48 && event.charCode <= 57)" id="cod_matricula"
                                        name="cod_matricula" placeholder="Ingrese su codigo de matricula" autofocus required>
                                </div>
                                <div class="col-md-4">
                                    <label for="dni">Dni</label>
                                    <input class="form-control" minlength="8" maxlength="8" type="text"
                                        onkeypress="return (event.charCode >= 48 && event.charCode <= 57)" id="dni" name="dni"
                                        placeholder="Ingrese su dni" required>
                                </div>
                            </div>
                            <div class="row justify-content-around align-items-center">
                                <div class="col-md-6">
                                    <label for="apellidos">Apellidos</label>
                                    <input class="form-control" type="text" id="apellidos" name="apellidos"
                                        placeholder="Ingrese sus apellidos" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="nombres">Nombres</label>
                                    <input class="form-control" type="text" id="nombres" name="nombres"
                                        placeholder="Ingrese su nombre" required>
                                </div>
                            </div>
                            <div class="row justify-content-around align-items-center">
                                <div class="col-md-5">
                                    <label for="correo">Correo Institucional</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="correo" name="correo" maxlength="80"
                                            placeholder="Ingrese su correo">
                                    </div>
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
                title: 'Alumno agregado correctamente',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @elseif (session('datos') == 'oknot')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error al agregar el alumno',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @elseif (session('datos') == 'exists')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Ya existe un alumno con el mismo codigo de matricula',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @endif

    <script type="text/javascript">
        window.onload = function(){
            semestre = document.getElementById('semestre_academico').value;
            document.getElementById('semestre_hidden').value = semestre;

            escuela = document.getElementById('escuela').value;
            document.getElementById('escuela_hidden').value = escuela;
        }
        function select_semestre(){
                    semestre = document.getElementById('semestre_academico').value;
                    if (semestre != '0') {
                        document.getElementById('semestre_hidden').value = semestre;
                    }else{
                        Swal.fire({
                            position: "top",
                            icon: "warning",
                            title: "Seleccione otra opcion de semestre academico",
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }
                }
        function select_escuela(){
                    escuela = document.getElementById('escuela').value;
                    if (escuela != '0') {
                        document.getElementById('escuela_hidden').value = escuela;
                    }else{
                        Swal.fire({
                            position: "top",
                            icon: "warning",
                            title: "Seleccione otra opcion de escuela",
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }
                }
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    </script>
@endsection
