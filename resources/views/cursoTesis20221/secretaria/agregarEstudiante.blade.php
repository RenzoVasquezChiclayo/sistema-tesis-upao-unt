@extends('plantilla.dashboard')
@section('titulo')
    Agregar Estudiante
@endsection
@section('css')
    <style type="text/css">
        .border-box{
            margin-top:20px;
            margin-left:5px;
            border: 0.5px solid rgba(0, 0, 0, 0.2);
            border-radius:20px;
            padding-top:5px;
            padding-bottom:10px;
        }

    </style>
@endsection
@section('contenido')
<div class="row" style="display: flex; align-items:center;">
    <div class="col-10">
        @if (session('datos'))
            <div id="mensaje">
                <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
                    {{ session('datos') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        @endif
    </div>
    <div class="col-10">
        <h3>Registro de Estudiante</h3>
        <div class="row border-box">
            <form action="{{route('secretaria.addEstudiante')}}" method="POST">
                @csrf
                <div class="col-12">
                    <h4>Curso</h4>
                    <p><i><b>Tesis I 2022-1</b></i></p>
                </div>
                <div class="col-6">
                    <label for="cod_matricula">Codigo de Matricula</label>
                    <input class="form-control" type="number" maxlength="10" min="0" id="cod_matricula" name="cod_matricula" placeholder="Ingrese su codigo de matricula" autofocus required>
                </div>
                <div class="col-12">
                    <label for="dni">Dni</label>
                    <input class="form-control" type="text" id="dni" name="dni" placeholder="Ingrese su dni" required>
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
    <script type="text/javascript">
        setTimeout(function(){
            document.querySelector('#mensaje').remove();
        },2000);
    </script>
@endsection
