@extends('plantilla.dashboard')
@section('titulo')
    Editar Linea Investigacion
@endsection
@section('contenido')
<div class="row" style="display: flex; align-items:center;">

    <div class="col-10">
        <h3>Editar Linea Investigacion</h3>
        <div class="row border-box">
            <form action="{{route('director.editLineaInves')}}" method="POST">
                @csrf
                <div class="col-6">
                    <label for="cod_matricula">Codigo</label>
                    <input class="form-control" type="text" value="{{$linea_find[0]->cod_tinvestigacion}}" id="cod_tinvestigacion" name="cod_tinvestigacion" placeholder="Ingrese su codigo de matricula" readonly>
                </div>
                <div class="col-6">
                    <label for="cod_matricula">Descripcion</label>
                    <input class="form-control" type="text" value="{{$linea_find[0]->descripcion}}" id="descripcion" name="descripcion">
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

    @if (session('datos') == 'oknot')
            <script>
                Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error al editar linea',
                showConfirmButton: false,
                timer: 1200
                })
            </script>
    @endif
@endsection
