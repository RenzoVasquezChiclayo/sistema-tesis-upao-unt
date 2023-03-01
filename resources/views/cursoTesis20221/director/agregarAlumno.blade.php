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

    input[type=number] { -moz-appearance:textfield; }
</style>
@endsection
@section('contenido')
<div class="row" style="display: flex; align-items:center;">

    <div class="col-10">
        <h3>Registro de Estudiante</h3>
        <div class="row border-box" style="margin-bottom: 50px;">
            <div class="col-12">
                <h4>Curso</h4>
                <p><i><b>Tesis I 2022-1</b></i></p>
                <h5>Importar un registro Excel</h5>
            </div>
            <form action="{{route('director.importarAlumnos')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-7">
                        <input class="form-control" type="file" name="importAlumno" id="importAlumno">
                    </div>
                    <div class="col-5">
                        <button class="btn btn-success" type="submit">Importar Registro</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="row border-box">
            <h5>Registrar por alumno</h5>
            <form action="{{route('director.addEstudiante')}}" method="POST">
                @csrf

                <div class="col-6">
                    <label for="cod_matricula">Codigo de Matricula</label>
                    <input class="form-control"  minlength="10" maxlength="10" type="text" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)" id="cod_matricula" name="cod_matricula" placeholder="Ingrese su codigo de matricula" autofocus required>
                </div>
                <div class="col-12">
                    <label for="dni">Dni</label>
                    <input class="form-control" minlength="8" maxlength="8" type="text" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)" id="dni" name="dni" placeholder="Ingrese su dni" required>
                </div>
                <div class="col-12">
                    <label for="apellidos">Apellidos</label>
                    <input class="form-control" type="text" id="apellidos" name="apellidos" placeholder="Ingrese sus apellidos" required>
                </div>
                <div class="col-12">
                    <label for="nombres">Nombres</label>
                    <input class="form-control" type="text" id="nombres" name="nombres" placeholder="Ingrese su nombre" required>
                </div>
                <div class="col-12" style="margin-top: 10px;">
                    <button class="btn btn-success" type="submit">Registrar</button>
                    <a href="{{route('user_information')}}" type="button" class="btn btn-danger">Cancelar</a>
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
    @endif
    <script type="text/javascript">

        const input = document.getElementById('cod_matricula');



        setTimeout(function(){
            document.querySelector('#mensaje').remove();
        },2000);


    </script>
@endsection
