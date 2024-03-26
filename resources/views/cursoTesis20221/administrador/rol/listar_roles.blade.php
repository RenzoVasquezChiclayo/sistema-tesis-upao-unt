@extends('plantilla.dashboard')
@section('titulo')
    Lista Roles
@endsection
@section('contenido')
    <div class="card-header">
        Lista Roles
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <div class="row justify-content-around align-items-center">
                    <div class="col-12">
                        <div class="row justify-content-around align-items-center" style="margin: 10px;">
                            <div class="col-8 col-md-5 col-lg-3">
                                <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                    data-bs-target="#modalRol"><i class='bx bx-sm bx-message-square-add'></i>Agregar
                                    Rol</button>
                            </div>
                        </div>
                        <div class="row mb-3" style="display:flex; align-items:right; justify-content:right;">
                            <div class="col col-sm-8 col-md-6 col-lg-4 col-xl-3">
                                <form id="listRol" name="listRol" method="get">
                                    <div class="row">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="buscarRol" placeholder="Rol"
                                                value="{{ $buscarRol }}" aria-describedby="btn-search">
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
                                        <td>Rol</td>
                                        <td>Opciones</td>
                                    </tr>
                                </thead>
                                @foreach ($roles as $rol)
                                    <tr>
                                        <td>{{ $rol->id }}</td>
                                        <td>{{ $rol->descripcion }}</td>
                                        <td>
                                            <div class="row">
                                                <div class="col-3">
                                                    <a href="#" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalRol"
                                                        onclick="editarRol('{{ $rol->id }}','{{ $rol->descripcion }}');">
                                                    <i class='bx bx-sm bx-edit-alt'></i>
                                                </a>
                                                </div>
                                                <div class="col-3">
                                                    <form id="formRolDelete" name="formRolDelete" method="POST"
                                                        action="{{ route('rol.deleteRol') }}">
                                                        @method('DELETE')
                                                        @csrf
                                                        <input type="hidden" name="auxidrol" value="{{ $rol->id }}">
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
                            {{ $roles->links() }}
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </div>

    {{-- //Modal para agregar Rol --}}
    <div class="modal fade" id="modalRol" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar Rol</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('rol.guardarRol') }}" method="post">
                    @csrf
                    <input type="hidden" id="aux_cod_rol" name="aux_cod_rol">
                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="descripcion" class="col-form-label">Descripcion:</label>
                            <input type="text" class="form-control" id="descripcion" name="descripcion" required>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="btn-guarda-editar">Guardar</button>
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
                title: 'Rol editado correctamente',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    @elseif (session('datos') == 'oksave')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Rol guardado correctamente',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    @elseif (session('datos') == 'oknotsave')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error al agregar rol',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    @elseif (session('datos') == 'oknot')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error al editar rol',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    @elseif (session('datos') == 'okdelete')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Rol eliminado correctamente',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    @elseif (session('datos') == 'oknotdelete')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error al eliminar el rol',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    @endif
    <script type="text/javascript">
        function editarRol(id, descripcion){
            const inputAuxCodeRol = document.getElementById("aux_cod_rol");
            inputAuxCodeRol.value = id;
            document.getElementById("descripcion").value = descripcion;
            document.getElementById("btn-guarda-editar").textContent = "Editar";
            document.getElementById("exampleModalLabel").textContent = "Editar Rol";


        }
        function alertaConfirmacion(e) {
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
                    document.formRolDelete.method = "POST";
                    e.closest('#formRolDelete').submit();
                }
            });
        }
    </script>
@endsection
