@extends('plantilla.dashboard')
@section('titulo')
    Agregar Grado Académico
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
        Registrar Grado Academico
    </div>
    <div class="card-body">
        <div class="row" style="display: flex; align-items:center;">

            <div class="row border-box">
                <!-- TODO: Modify the route -->
                <form action="{{ route('admin.guardarGradoAcademico') }}" method="POST">
                    @csrf
                    <div class="row justify-content-around align-items-center">
                        <div class="col-md-5">
                            <input type="number" id="cod_grado_academico" name="cod_grado_academico" hidden>
                            <label for="grado_academico">Descripción</label>
                            <input class="form-control" type="text" id="descripcion" name="descripcion"
                                placeholder="Ingrese el grado académico" autofocus required>
                        </div>
                    </div>
                    <div class="col-12" style="margin-top: 10px;">
                        <button id="btn_save" class="btn btn-success" type="submit">Registrar</button>

                        <a href="{{ route('admin.verAgregarGrado') }}" type="sub"
                            class="btn btn-no-border btn-outline-danger">Cancelar</a>
                    </div>
                </form>
            </div>
            <div class="row mb-3" style="display:flex; align-items:right; justify-content:right;">
                <div class="col col-sm-8 col-md-6 col-lg-4 col-xl-3">
                    <form id="" name="" method="get">
                        <div class="row">
                            <div class="input-group">
                                <input type="text" class="form-control" name="buscarGrado" placeholder="Grado académico"
                                    value="" aria-describedby="btn-search">
                                <button class="btn btn-outline-primary" type="submit" id="btn-search">Buscar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card text-center shadow bg-white rounded">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table-proyecto" class="table table-striped table-responsive-md">
                            <thead>
                                <tr>
                                    <td>Id</td>
                                    <td>Descripcion</td>
                                    <td>Estado</td>
                                    <td>Opciones</td>
                                </tr>
                            </thead>
                            @foreach ($grados_academicos as $grado)
                                <tr>
                                    <td>{{ $grado->cod_grado_academico }}</td>
                                    <td>{{ $grado->descripcion }}</td>
                                    <td>
                                        <div class="container-center">
                                            <form class="form-fit" id="formChangeStatus" name="formChangeStatus"
                                                method="post" action="{{ route('admin.changeStatusGrado') }}">
                                                @csrf
                                                <input type="text" name="aux_grado_academico"
                                                    value="{{ $grado->cod_grado_academico }}" hidden>
                                                <div class="form-check form-switch" style="width: fit-content">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                        id="flexSwitchCheckDefault" onclick="updateState(this);"
                                                        @if ($grado->estado == 1) checked @endif>
                                                    <label class="form-check-label"
                                                        for="flexSwitchCheckDefault">Activado</label>
                                                </div>
                                            </form>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="row" style="display: flex;">
                                            <div class="col-auto">
                                                <a href="#" class="btn btn-warning"
                                                    onclick="editGradoAcademico({{ $grado->cod_grado_academico }}, '{{ $grado->descripcion }}');">
                                                    <i class='bx bx-sm bx-edit-alt'></i>
                                                </a>
                                            </div>
                                            <div class="col-auto">
                                                <form id="form-delete-grado" method="post"
                                                    action="{{ route('admin.delete_grado') }}">
                                                    @method('DELETE')
                                                    @csrf
                                                    <input type="hidden" name="auxidgrado"
                                                        value="{{ $grado->cod_grado_academico }}">
                                                    <a href="#" class="btn btn-danger"
                                                        onclick="alertaConfirmacion(this);"><i
                                                            class='bx bx-message-square-x'></i></a>
                                                </form>

                                                </a>
                                            </div>
                                        </div>
                                    </td>

                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>

            </div>
            {{ $grados_academicos->links() }}
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
                title: 'Grado académico agregado correctamente',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @elseif (session('datos') == 'oknot')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error al agregar el grado académico',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @elseif (session('datos') == 'okdelete')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Grado academico eliminado correctamente',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @elseif (session('datos') == 'oknotdelete')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error al eliminar grado academico',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @elseif (session('datos') == 'duplicate')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'warning',
                title: 'El grado académico ya existe!',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @endif
    <script type="text/javascript">
        function editGradoAcademico(code, description) {
            const inputCodeGrado = document.getElementById("cod_grado_academico");
            inputCodeGrado.value = code;
            document.getElementById("descripcion").value = description;
            document.getElementById("btn_save").textContent = "Edit";
        }

        function updateState(form) {
            form.closest('#formChangeStatus').submit();
        }

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
                    form.closest('#form-delete-grado').submit();
                }
            });
        }
    </script>
@endsection
