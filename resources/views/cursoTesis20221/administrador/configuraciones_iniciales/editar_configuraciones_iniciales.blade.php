@extends('plantilla.dashboard')
@section('titulo')
    Editar Configuraciones Iniciales
@endsection
@section('contenido')
    <div class="card-header">
        Editar Configuraciones Iniciales
    </div>
    <div class="card-body">
        <div class="row">
            <form id="form_edit_config" method="post" action="{{ route('admin.saveEditarconfiguraciones') }}">
                @csrf
                <input type="hidden" name="auxid" value="{{$find_configuracion->cod_configuraciones}}">
                <div class="row">
                    <div class="col-xl-4">
                        <h5>Año</h5>
                        <input class="form-control" type="text" minlength="4" maxlength="4" placeholder="0000" name="year" value="{{$find_configuracion->año}}" required>
                    </div>
                    <div class="col-xl-5">
                        <h5>Curso</h5>
                        <input class="form-control" type="text" placeholder="Nombre del curso" name="curso" value="{{$find_configuracion->curso}}" required>
                    </div>
                    <div class="col-xl-3">
                        <h5>Ciclo</h5>
                        <input class="form-control" type="number" name="ciclo" value="{{$find_configuracion->ciclo}}" required>
                    </div>
                </div>
                <div class="row justify-content-around align-items-center" style="margin-top: 30px;">
                    <div class="col-4">
                        <input class="btn btn-success" type="submit" value="Guardar">
                    </div>

                </div>
            </form>

        </div>
    </div>
@endsection

