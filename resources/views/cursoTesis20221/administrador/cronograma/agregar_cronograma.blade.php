@extends('plantilla.dashboard')
@section('titulo')
    Agregar Cronograma
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
        Cronograma
    </div>
    <div class="card-body">
        <div class="row" style="display: flex; align-items:center;">

            <div class="row border-box">
                <!-- TODO: Modify the route -->
                <form action="{{ route('admin.guardarCronograma') }}" method="POST">
                    @csrf
                    <input type="hidden" id="aux_cod_cronograma" name="aux_cod_cronograma">
                    <div class="row justify-content-center" style="margin-bottom: 20px;">
                        <div class="col-md-5">
                            <h5>Actividad</h5>
                            <input class="form-control" type="text" id="descripcion" name="descripcion"
                                placeholder="Ingrese la actividad" autofocus required>
                        </div>
                        <div class="col-3">
                            <h5>Escuela</h5>
                            <select class="form-select" onchange="select_escuela();" name="escuela" id="escuela" required>
                                @foreach ($escuela as $e)
                                    <option value="{{ $e->cod_escuela }}">{{ $e->nombre }}</option>
                                @endforeach
                            </select>
                            <span id="span_escuela" style="color: red"></span>
                        </div>
                        <div class="col-3">
                            <h5>Semestre academico</h5>
                            <select class="form-select" onchange="select_semestre();" name="semestre_academico"
                                id="semestre_academico" required>
                                @foreach ($semestre as $s_a)
                                    <option value="{{ $s_a->cod_config_ini }}">{{ $s_a->year }}_{{ $s_a->curso }}
                                    </option>
                                @endforeach
                            </select>
                            <span id="span_semestre" style="color: red"></span>
                        </div>
                    </div>

                    <div class="col-12" style="margin-top: 10px;">
                        <button id="btn_save" class="btn btn-success" type="submit">Registrar</button>

                        <a href="{{ route('admin.verCronograma') }}" type="sub"
                            class="btn btn-no-border btn-outline-danger">Cancelar</a>
                    </div>
                </form>
            </div>
            <div class="row mb-3" style="display:flex; align-items:right; justify-content:right;">
                <div class="col col-sm-8 col-md-6 col-lg-4 col-xl-3">
                    <form id="" name="" method="get">
                        <div class="row">
                            <div class="input-group">
                                <input type="text" class="form-control" name="buscarActividad" placeholder="Actividad"
                                    value="" aria-describedby="btn-search" request>
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
                                    <td>Actividad</td>
                                    <td>Escuela</td>
                                    <td>Semestre</td>
                                    <td>Opciones</td>
                                </tr>
                            </thead>
                            @foreach ($cronograma as $c)
                                <tr>
                                    <td>{{ $c->cod_cronograma }}</td>
                                    <td>{{ $c->actividad }}</td>
                                    <td>{{ $c->nombre }}</td>
                                    <td>{{ $c->year }}_{{ $c->curso }}</td>
                                    <td>
                                        <div class="row justify-content-center" style="display: flex;">
                                            <div class="col-auto">
                                                <a href="#" class="btn btn-warning"
                                                    onclick="editCronograma('{{ $c->cod_cronograma }}', '{{ $c->actividad }}','{{$c->cod_escuela}}','{{$c->cod_config_ini}}');">
                                                    <i class='bx bx-sm bx-edit-alt'></i>
                                                </a>
                                            </div>
                                            <div class="col-auto">
                                                <form id="form-delete-cronograma" method="post"
                                                    action="{{ route('admin.delete_cronograma') }}">
                                                    @method('DELETE')
                                                    @csrf
                                                    <input type="hidden" name="auxidcronograma"
                                                        value="{{ $c->cod_cronograma }}">
                                                    <a href="#" class="btn btn-danger"
                                                        onclick="alertaConfirmacion(this);"><i
                                                            class='bx bx-message-square-x'></i></a>
                                                </form>
                                            </div>
                                        </div>

                                    </td>

                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>

            </div>
            {{ $cronograma->links() }}
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
                title: 'Actividad agregado correctamente',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @elseif (session('datos') == 'oknot')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error al agregar la actividad',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @elseif (session('datos') == 'duplicate')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'warning',
                title: 'La Actividad ya existe!',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @endif
    <script type="text/javascript">
        function editCronograma(code, description,cod_escuela,cod_semestre) {
            const inputAuxCodeCronograma = document.getElementById("aux_cod_cronograma");
            inputAuxCodeCronograma.value = code;
            document.getElementById("descripcion").value = description;
            document.getElementById("semestre_academico").value = cod_semestre;
            document.getElementById("escuela").value = cod_escuela;
            document.getElementById("btn_save").textContent = "Editar";
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
                    form.closest('#form-delete-cronograma').submit();
                }
            });
        }

        function select_semestre() {
            semestre = document.getElementById('semestre_academico').value;
            if (semestre != '0') {
                document.getElementById('semestre_hidden').value = semestre;
            } else {
                Swal.fire({
                            position: "top",
                            icon: "warning",
                            title: "Seleccione otra opcion de semestre academico",
                            showConfirmButton: false,
                            timer: 2000
                        });
            }
        }

        function select_escuela() {
            escuela = document.getElementById('escuela').value;
            if (escuela != '0') {
                document.getElementById('escuela_hidden').value = escuela;
            } else {
                Swal.fire({
                            position: "top",
                            icon: "warning",
                            title: "Seleccione otra opcion de escuela",
                            showConfirmButton: false,
                            timer: 2000
                        });
            }
        }
    </script>
@endsection
