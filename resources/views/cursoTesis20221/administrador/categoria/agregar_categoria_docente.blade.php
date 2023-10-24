@extends('plantilla.dashboard')
@section('titulo')
    Agregar Categoria
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
        Registrar Categoria
    </div>
    <div class="card-body">
        <div class="row" style="display: flex; align-items:center;">

            <form action="{{ route('admin.saveCategorias') }}" method="POST">
                @csrf
                <div class="row justify-content-around align-items-center">
                    <div class="col-md-4">
                        <label for="cod_matricula">Descripcion</label>
                        <input class="form-control" type="text" id="descripcion" name="descripcion"
                            placeholder="Ingrese nombre de la categoria" autofocus required>
                    </div>
                </div>

                <div class="col-12" style="margin-top: 10px;">
                    <button class="btn btn-success" type="submit">Registrar</button>
                    <a href="{{ route('user_information') }}" type="button" class="btn btn-danger">Cancelar</a>
                </div>
            </form>
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
                title: 'Categoria agregada correctamente',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @elseif (session('datos') == 'oknot')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error al agregar la categoria',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @endif
    <script type="text/javascript"></script>
@endsection
