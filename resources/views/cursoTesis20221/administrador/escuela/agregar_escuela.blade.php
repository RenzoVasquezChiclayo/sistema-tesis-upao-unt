@extends('plantilla.dashboard')
@section('titulo')
    Agregar Escuela
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
        Registrar Escuela
    </div>
    <div class="card-body">
        <div class="row" style="display: flex; align-items:center;">
            <div class="row border-box">
                <!-- TODO: Modify the route -->
                <form action="{{ route('admin.guardarEscuela') }}" method="POST">
                    @csrf
                    <input type="hidden" id="aux_cod_escuela" name="aux_cod_escuela">
                    <div class="row justify-content-around align-items-center">
                        <div class="col-md-3">
                            <label for="escuela">Codigo</label>
                            <input class="form-control" type="text" minlength="4" maxlength="4" id="cod_escuela" name="cod_escuela" placeholder="Ingrese codigo" autofocus required>
                        </div>
                        <div class="col-md-5">
                            <label for="escuela">Descripción</label>
                            <input class="form-control" type="text" id="descripcion" name="descripcion"
                                placeholder="Ingrese la escuela" autofocus required>
                        </div>
                        <div class="col-md-5">
                            <label for="escuela">Facultad</label>
                            <select class="form-control" name="facultad" id="facultad">
                                @foreach ($facultad as $f)
                                    <option value="{{$f->cod_facultad}}">{{$f->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12" style="margin-top: 10px;">
                        <button id="btn_save" class="btn btn-success" type="submit">Registrar</button>

                        <a href="{{ route('admin.verEscuela') }}" type="sub"
                            class="btn btn-no-border btn-outline-danger">Cancelar</a>
                    </div>
                </form>
            </div>
            <div class="row mb-3" style="display:flex; align-items:right; justify-content:right;">
                <div class="col col-sm-8 col-md-6 col-lg-4 col-xl-3">
                    <form id="" name="" method="get">
                        <div class="row">
                            <div class="input-group">
                                <input type="text" class="form-control" name="buscarEscuela" placeholder="Escuela"
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
                            @foreach ($escuela as $e)
                                <tr>
                                    <td>{{ $e->cod_escuela }}</td>
                                    <td>{{ $e->nombre }}</td>
                                    <td>
                                        <div class="container-center">
                                            <form class="form-fit" id="formChangeStatus" name="formChangeStatus" method="post"
                                                action="{{ route('admin.changeStatusEscuela') }}">
                                                @csrf
                                                <input type="text" name="aux_escuela"
                                                    value="{{ $e->cod_escuela }}" hidden>
                                                <div class="form-check form-switch" style="width: fit-content">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                        id="flexSwitchCheckDefault" onclick="updateState(this);"
                                                        @if ($e->estado == 1) checked @endif>
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
                                                    onclick="editEscuela('{{ $e->cod_escuela }}', '{{ $e->nombre }}');">
                                                    <i class='bx bx-sm bx-edit-alt'></i>
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
            {{ $escuela->links() }}
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
        function editEscuela(code, description) {
            const inputAuxCodeEscuela = document.getElementById("aux_cod_escuela");
            inputAuxCodeEscuela.value = code;

            document.getElementById("cod_escuela").value = code;
            document.getElementById("descripcion").value = description;
            document.getElementById("btn_save").textContent = "Editar";
        }

        function updateState(form) {
            form.closest('#formChangeStatus').submit();
        }
    </script>
@endsection
