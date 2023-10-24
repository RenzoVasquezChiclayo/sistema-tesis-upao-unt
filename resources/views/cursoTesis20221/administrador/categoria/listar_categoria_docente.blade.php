@extends('plantilla.dashboard')
@section('titulo')
    Lista Categorias Docente
@endsection
@section('contenido')
    <div class="row">
        <div class="col-12">
            <div class="row" style="display: flex; align-items:center;">
                <div class="col-12">
                    <div class="row" style="margin: 10px;">
                        <div class="col-8 col-md-5 col-lg-3">
                            <a href="{{ route('admin.categoriasDocente') }}" class="btn btn-success"><i
                                    class='bx bx-sm bx-message-square-add'></i>Agregar Categoria</a>
                        </div>
                    </div>
                    <div class="row mb-3" style="display:flex; align-items:right; justify-content:right;">
                        <div class="col col-sm-8 col-md-6 col-lg-4 col-xl-3">
                            <form id="" name="" method="get">
                                <div class="row">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="buscarCategoria"
                                            placeholder="Categoria" value="" aria-describedby="btn-search">
                                        <button class="btn btn-outline-primary" type="submit"
                                            id="btn-search">Buscar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="table-proyecto" class="table table-striped table-responsive-md">
                            <thead>
                                <tr>
                                    <td>Id</td>
                                    <td>Descripcion</td>
                                    <td>Estado</td>
                                    <td>Editar</td>
                                    <td>Eliminar</td>
                                </tr>
                            </thead>
                            @foreach ($lista_categorias as $l_u)
                                <tr>
                                    <td>{{ $l_u->cod_categoria }}</td>
                                    <td>{{ $l_u->descripcion }}</td>
                                    <td>{{ $l_u->estado }}</td>
                                    <td>
                                        <div class="row">
                                            <div class="col-3">
                                                <form id="form-categoria" method="post"
                                                    action="{{ route('admin.EditarcategoriasDocente') }}">
                                                    @csrf
                                                    <input type="hidden" name="auxidcategoria"
                                                        value="{{ $l_u->cod_categoria }}">
                                                    <a href="#" class="btn btn-warning"
                                                        onclick="this.closest('#form-categoria').submit();"><i
                                                            class='bx bx-sm bx-edit-alt'></i></a>
                                                </form>
                                            </div>

                                        </div>
                                    </td>
                                    <td>
                                        <div class="row">
                                            <div class="col-3">
                                                <form id="formCategoriaDelete" name="formCategoriaDelete" action="{{ route('admin.deleteCategoria') }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="auxidcategoria"
                                                        value="{{ $l_u->cod_categoria }}">
                                                    <a href="#" class="btn btn-danger btn-eliminar"
                                                        onclick="alertaConfirmacion(this);"><i
                                                            class='bx bx-message-square-x'></i></a>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $lista_categorias->links() }}
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
                title: 'Categoria editado correctamente',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    @elseif (session('datos') == 'oknot')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error al editar Categoria',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    @elseif (session('datos') == 'okdelete')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Categoria eliminado correctamente',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    @elseif (session('datos') == 'oknotdelete')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error al eliminar la Categoria',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    @endif
    <script type="text/javascript">
        // function editarAlumno(formulario, contador){
        //     formulario.closest('#form-alumno'+contador).submit();
        // }
        function alertaConfirmacion(form) {
            Swal.fire({
                title: 'Estas Seguro que deseas eliminar?',
                text: "No podras revertirlo",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Confirmar!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.closest('#formCategoriaDelete').submit();
                }
            });
        }
    </script>
@endsection
