@extends('plantilla.dashboard')
@section('titulo')
    Lista Usuario
@endsection
@section('contenido')
<div class="card-header">
    Lista Usuario
</div>
<div class="card-body">
    <div class="row">
        <div class="col-12">
            <div class="row justify-content-around align-items-center">
                <div class="col-12">
                    <div class="row justify-content-around align-items-center" style="margin: 10px;">
                        <div class="col-8 col-md-5 col-lg-3">
                            <a href="" class="btn btn-success"><i class='bx bx-sm bx-message-square-add'></i>Agregar Usuario</a>
                        </div>
                    </div>
                    <div class="row mb-3" style="display:flex; align-items:right; justify-content:right;">
                        <div class="col col-sm-8 col-md-6 col-lg-4 col-xl-3">
                            <form id="" name="" method="get">
                                <div class="row">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="buscarAlumno" placeholder="Usuario" value="" aria-describedby="btn-search">
                                        <button class="btn btn-outline-primary" type="submit" id="btn-search">Buscar</button>
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
                                    <td>Usuario</td>
                                    <td>Rol</td>
                                    <td>Opciones</td>
                                </tr>
                            </thead>
                                @foreach ($usuarios as $user)
                                    <tr>
                                        <td>{{$user->id}}</td>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->rol}}.</td>
                                        <td>
                                            <div class="row">
                                                <div class="col-3">
                                                    <form id="form-usuario" method="post" action="{{ route('admin.editar') }}">
                                                        @csrf
                                                        <input type="hidden" name="auxiduser" value="{{$user->id}}">
                                                        <a href="#" class="btn btn-warning" onclick="this.closest('#form-usuario').submit();"><i class='bx bx-sm bx-edit-alt'></i></a>
                                                    </form>
                                                </div>
                                                <div class="col-3">
                                                    <form id="formUsuarioDelete" name="formUsuarioDelete" method="POST" action="{{ route('admin.deleteUser') }}">
                                                        @method('DELETE')
                                                        @csrf
                                                        <input type="hidden" name="auxiduser" value="{{$user->id}}">
                                                        <a href="#" class="btn btn-danger btn-eliminar" onclick="alertaConfirmacion(this);"><i class='bx bx-message-square-x' ></i></a>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{$usuarios->links()}}
                    </div>

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
                title: 'Usuario editado correctamente',
                showConfirmButton: false,
                timer: 1200
                })
            </script>
    @elseif (session('datos') == 'oknot')
            <script>
                Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error al editar usuario',
                showConfirmButton: false,
                timer: 1200
                })
            </script>
    @elseif (session('datos') == 'okdelete')
            <script>
                Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Usuario eliminado correctamente',
                showConfirmButton: false,
                timer: 1200
                })
            </script>
    @elseif (session('datos') == 'oknotdelete')
            <script>
                Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error al eliminar el Usuario',
                showConfirmButton: false,
                timer: 1200
                })
            </script>
    @endif
<script type="text/javascript">
    // function editarAlumno(formulario, contador){
    //     formulario.closest('#form-alumno'+contador).submit();
    // }
    function alertaConfirmacion(e){
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
                document.formUsuarioDelete.action ="{{ route('admin.deleteUser') }}";
                document.formUsuarioDelete.method = "POST";
                e.closest('#formUsuarioDelete').submit();
            }
        });
    }

</script>
@endsection
