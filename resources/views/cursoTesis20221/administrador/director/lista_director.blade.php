@extends('plantilla.dashboard')
@section('titulo')
    Lista Directores
@endsection
@section('contenido')
    <div class="card-header">
        Lista Directores
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <div class="row justify-content-around align-items-center">
                    <div class="col-12">
                        <div class="row justify-content-around align-items-center" style="margin: 10px;">
                            <div class="col-8 col-md-5 col-lg-3">
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" id="btn_agregar" onclick="status_hidden_director_code();"
                                    data-bs-target="#modalDirector"><i class='bx bx-sm bx-message-square-add'></i>Agregar
                                    Director</button>
                            </div>
                        </div>
                        <div class="row mb-3" style="display:flex; align-items:right; justify-content:right;">
                            <div class="col col-sm-8 col-md-6 col-lg-4 col-xl-3">
                                <form id="listDirector" name="listDirector" method="get">
                                    <div class="row">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="buscarDirector" placeholder="Director"
                                                value="{{ $buscarDirector }}" aria-describedby="btn-search">
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
                                        <td>Nombres</td>
                                        <td>Escuela</td>
                                        <td>Correo</td>
                                        <td>Opciones</td>
                                    </tr>
                                </thead>
                                @foreach ($directores as $director)
                                    <tr>
                                        <td>{{ $director->cod_director }}</td>
                                        <td>{{ $director->descripcion }} {{ $director->apellidos }} {{ $director->nombres }}</td>
                                        <td>{{ $director->nombre }}</td>
                                        <td>{{ $director->correo }}</td>
                                        <td>
                                            <div class="row">
                                                <div class="col-3">
                                                    <a href="#" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalDirector"
                                                        onclick="editarDirector('{{ $director->cod_director }}',
                                                        '{{ $director->cod_grado_academico }}',
                                                        '{{ $director->cod_escuela }}',
                                                        '{{ $director->correo }}',
                                                        '{{ $director->nombres }}',
                                                        '{{ $director->apellidos }}', '{{ $director->direccion }}');">
                                                    <i class='bx bx-sm bx-edit-alt'></i>
                                                </a>
                                                </div>
                                                <div class="col-3">
                                                    <form id="formDirectorDelete" name="formDirectorDelete" method="POST"
                                                        action="{{ route('admin.director.deleteDirector') }}">
                                                        @method('DELETE')
                                                        @csrf
                                                        <input type="hidden" name="auxiddirector" value="{{ $director->cod_director }}">
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
                            {{ $directores->links() }}
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </div>

    {{-- //Modal para agregar Director --}}
    <div class="modal fade" id="modalDirector" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar Director</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.director.guardarDirector') }}" method="post">
                    @csrf
                    <input type="hidden" id="aux_cod_director" name="aux_cod_director">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="descripcion" class="col-form-label">Nombres:</label>
                                <input type="text" class="form-control" id="nombres" name="nombres" required>
                            </div>
                            <div class="col-lg-6">
                                <label for="descripcion" class="col-form-label">Apellidos:</label>
                                <input type="text" class="form-control" id="apellidos" name="apellidos" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="descripcion" class="col-form-label">Grado Academico:</label>
                                <select class="form-control" name="grado_academico" id="grado_academico" required>
                                    @foreach ($grado_academico as $g_a)
                                        <option value="{{$g_a->cod_grado_academico}}">{{$g_a->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label for="descripcion" class="col-form-label">Escuela:</label>
                                <select class="form-control" name="escuela" id="escuela" required>
                                    @foreach ($escuela as $es)
                                        <option value="{{$es->cod_escuela}}">{{$es->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3">
                                <label for="descripcion" class="col-form-label">Direccion:</label>
                                <input type="text" class="form-control" id="direccion" name="direccion">
                            </div>
                            <div class="mb-3">
                                <label for="descripcion" class="col-form-label">Correo:</label>
                                <input type="text" class="form-control" id="correo" name="correo">
                            </div>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        {{-- <input type="submit" class="btn btn-primary" id="btn-guarda-editar" value="Guardar"> --}}
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
                title: 'Director editado correctamente',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    @elseif (session('datos') == 'oksave')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Director guardado correctamente',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    @elseif (session('datos') == 'oknotsave')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error al agregar director',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    @elseif (session('datos') == 'oknot')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error al editar director',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    @elseif (session('datos') == 'okdelete')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Director eliminado correctamente',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    @elseif (session('datos') == 'oknotdelete')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error al eliminar el director',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    @endif
    <script type="text/javascript">
        function editarDirector(id, grado, escuela, correo, nombres, apellidos, direccion){
            const inputAuxCodeDirector = document.getElementById("aux_cod_director");
            inputAuxCodeDirector.value = id;
            document.getElementById("nombres").value = nombres;
            document.getElementById("apellidos").value = apellidos;
            document.getElementById("grado_academico").selectedindex = grado;
            document.getElementById("escuela").selectedindex = escuela;
            document.getElementById("direccion").value = direccion;
            document.getElementById("correo").value = correo;
            document.getElementById("btn-guarda-editar").textContent = "Editar";
            document.getElementById("exampleModalLabel").textContent = "Editar Director";


        }

        function status_hidden_director_code(){
            document.getElementById("aux_cod_director").value = "";
            document.getElementById("btn_agregar").value = "";
            document.getElementById("nombres").value = "";
            document.getElementById("apellidos").value = "";
            document.getElementById("grado_academico").selectedindex = 0;
            document.getElementById("escuela").selectedindex = 0;
            document.getElementById("direccion").value = "";
            document.getElementById("correo").value = "";
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
                    document.formDirectorDelete.method = "POST";
                    e.closest('#formDirectorDelete').submit();
                }
            });
        }
    </script>
@endsection
