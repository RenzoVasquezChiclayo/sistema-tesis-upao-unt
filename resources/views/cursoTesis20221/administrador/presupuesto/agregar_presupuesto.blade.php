@extends('plantilla.dashboard')
@section('titulo')
    Agregar Presupuesto
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
        Registrar Presupuesto
    </div>
    <div class="card-body">
        <div class="row" style="display: flex; align-items:center;">

            <div class="row border-box">
                <!-- TODO: Modify the route -->
                <form action="{{ route('admin.guardarPresupuesto') }}" method="POST">
                    @csrf
                    <input type="hidden" id="aux_cod_presupuesto" name="aux_cod_presupuesto">
                    <div class="row justify-content-around align-items-center">
                        <div class="col-md-3">
                            <label for="CodeUniversal">CodeUniversal</label>
                            <input class="form-control" type="text" id="cod_codeUniversal" name="cod_codeUniversal" placeholder="Ingrese codigo" autofocus required>
                        </div>
                        <div class="col-md-5">
                            <label for="facultad">Denominacion</label>
                            <input class="form-control" type="text" id="descripcion" name="descripcion"
                                placeholder="Ingrese la denominacion" autofocus required>
                        </div>
                    </div>
                    <div class="col-12" style="margin-top: 10px;">
                        <button id="btn_save" class="btn btn-success" type="submit">Registrar</button>

                        <a href="{{ route('admin.verPresupuesto') }}" type="sub"
                            class="btn btn-no-border btn-outline-danger">Cancelar</a>
                    </div>
                </form>
            </div>
            <div class="row mb-3" style="display:flex; align-items:right; justify-content:right;">
                <div class="col col-sm-8 col-md-6 col-lg-4 col-xl-3">
                    <form id="" name="" method="get">
                        <div class="row">
                            <div class="input-group">
                                <input type="text" class="form-control" name="buscarPresupuesto" placeholder="Codigo del Presupuesto"
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
                                    <td>CodeUniversal</td>
                                    <td>Descripcion</td>
                                    <td>Opciones</td>
                                </tr>
                            </thead>
                            @foreach ($presupuesto as $p)
                                <tr>
                                    <td>{{ $p->codeUniversal }}</td>
                                    <td>{{ $p->denominacion }}</td>
                                    <td>
                                        <div class="row justify-content-center" style="display: flex;">
                                            <div class="col-auto">
                                                <a href="#" class="btn btn-warning"
                                                    onclick="editPresupuesto('{{ $p->cod_presupuesto }}','{{ $p->codeUniversal }}', '{{ $p->denominacion }}');">
                                                    <i class='bx bx-sm bx-edit-alt'></i>
                                                </a>
                                            </div>
                                            <div class="col-auto">
                                                <form id="form-delete-presupuesto" method="post"
                                                    action="{{ route('admin.delete_presupuesto') }}">
                                                    @method('DELETE')
                                                    @csrf
                                                    <input type="hidden" name="auxidpresupuesto"
                                                        value="{{ $p->cod_presupuesto }}">
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
            {{ $presupuesto->links() }}
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
        function editPresupuesto(cod,code, description) {
            const inputAuxCodePresupuesto = document.getElementById("aux_cod_presupuesto");
            inputAuxCodePresupuesto.value = cod;
            document.getElementById("cod_codeUniversal").value = code;
            document.getElementById("descripcion").value = description;
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
                    form.closest('#form-delete-presupuesto').submit();
                }
            });
        }
    </script>
@endsection
