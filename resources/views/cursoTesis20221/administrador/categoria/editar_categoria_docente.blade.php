@extends('plantilla.dashboard')
@section('titulo')
    Editar Categoria
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
    <div class="row" style="display: flex; align-items:center;">

        <div class="col-10">
            <h3>Editar Categoria</h3>
            <div class="row border-box">
                <form action="{{ route('admin.saveEditarCategorias') }}" method="POST">
                    @csrf
                    <input type="hidden" name="auxidcategoria" value="{{$find_categoria->cod_categoria}}">
                    <div class="col-6">
                        <label for="cod_matricula">Descripcion</label>
                        <input class="form-control" type="text" id="descripcion" name="descripcion"
                            placeholder="Ingrese nombre de la categoria" value="{{ $find_categoria->descripcion }}" autofocus required>
                    </div>
                    <div class="col-12" style="margin-top: 10px;">
                        <button class="btn btn-warning" type="submit">Editar</button>
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
    <script type="text/javascript">

    </script>
@endsection
