@extends('plantilla.dashboard')
@section('titulo')
    Editar Alumno
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
        <h3>Editar Estudiante</h3>
        <div class="row border-box">
            <form action="{{route('director.editEstudiante')}}" method="POST">
                @csrf

                <div class="col-6">
                    <label for="cod_matricula">Codigo de Matricula</label>
                    <input class="form-control" type="text" minlength="8" maxlength="10"  value="{{$alumno[0]->cod_matricula}}" id="cod_matricula" name="cod_matricula" placeholder="Ingrese su codigo de matricula" readonly>
                </div>

                <div class="col-12">
                    <label for="dni">Dni</label>
                    <input class="form-control" minlength="8" maxlength="8" type="text" value="{{$alumno[0]->dni}}" id="dni" name="dni" placeholder="Ingrese su dni" required>
                </div>
                <div class="col-12">
                    <label for="apellidos">Apellidos</label>
                    <input class="form-control" type="text" value="{{$alumno[0]->apellidos}}" id="apellidos" name="apellidos" placeholder="Ingrese sus apellidos" required>
                </div>
                <div class="col-12">
                    <label for="nombres">Nombres</label>
                    <input class="form-control" type="text" value="{{$alumno[0]->nombres}}" id="nombres" name="nombres" placeholder="Ingrese su nombre" required>
                </div>
                <div class="col-12" style="margin-top: 10px;">
                    <button class="btn btn-success" type="submit">Guardar</button>
                    <a href="{{route('user_information')}}" type="button" class="btn btn-danger">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('js')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        setTimeout(function(){
            document.querySelector('#mensaje').remove();
        },2000);
    </script>
    @if (session('datos') == 'oknot')
            <script>
                Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error al editar alumno',
                showConfirmButton: false,
                timer: 1200
                })
            </script>
    @endif
@endsection
