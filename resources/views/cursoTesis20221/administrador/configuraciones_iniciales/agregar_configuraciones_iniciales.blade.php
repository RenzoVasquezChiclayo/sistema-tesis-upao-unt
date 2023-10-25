@extends('plantilla.dashboard')
@section('titulo')
    Configuraciones Iniciales
@endsection
@section('contenido')
    <div class="card-header">
        Semestre Academico
    </div>
    <div class="card-body">
        <div class="row justify-content-around align-items-center">
            <form id="formconfig" method="post" action="{{ route('admin.saveconfigurar') }}">
                @csrf
                <div class="row">
                    <div class="col-xl-4">
                        <h5>Año</h5>
                        <input class="form-control" type="text" minlength="4" maxlength="4" placeholder="0000"
                            name="year" required>
                    </div>
                    <div class="col-xl-5">
                        <h5>Curso</h5>
                        <input class="form-control" type="text" placeholder="Nombre del curso" name="curso" required>
                    </div>
                    <div class="col-xl-3">
                        <h5>Ciclo</h5>
                        <input class="form-control" type="number" name="ciclo" required>
                    </div>
                </div>
                <div class="row justify-content-around align-items-center" style="margin-top: 30px;">
                    <div class="col-4">
                        <input class="btn btn-success" type="button" value="Guardar" onclick="saveConfig(this);">
                    </div>

                </div>
            </form>

        </div>
        <div class="row">
            <div class="table-responsive">
                <table id="table-proyecto" class="table table-striped table-responsive-md" style="font-size: 14px;">
                    <thead>
                        <tr>
                            <td>Id</td>
                            <td>Año</td>
                            <td>Curso</td>
                            <td>Ciclo</td>
                            <td>Estado</td>
                            <td>Editar</td>
                            <td>Eliminar</td>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $cont = 0;
                        @endphp
                        @foreach ($lista_configuraciones as $l_c)
                            <tr>
                                <td>{{ $l_c->cod_configuraciones }}</td>
                                <td>{{ $l_c->año }}</td>
                                <td>{{ $l_c->curso }}</td>
                                <td>{{ $l_c->ciclo }}</td>
                                <td>{{ $l_c->estado }}</td>
                                <td>
                                    <form id="form-configuracion" method="post"
                                        action="{{ route('admin.verConfiguracionEditar') }}">
                                        @csrf
                                        <input type="hidden" name="auxid" value="{{ $l_c->cod_configuraciones }}">
                                        <a href="#" class="btn btn-warning"
                                            onclick="this.closest('#form-configuracion').submit();"><i
                                                class='bx bx-sm bx-edit-alt'></i></a>
                                    </form>
                                </td>
                                <td>
                                    <form id="formConfiguracionDelete" name="formConfiguracionDelete" method="post"
                                        action="{{ route('admin.deleteconfiguraciones') }}">
                                        @csrf
                                        <input type="hidden" name="auxidDelete" value="{{ $l_c->cod_configuraciones }}">
                                        <a href="#" class="btn btn-danger btn-eliminar"
                                            onclick="alertaConfirmacion(this);"><i
                                                class='bx bx-sm bxs-trash'></i></a>
                                    </form>
                                </td>

                            </tr>
                            @php
                                $cont++;
                            @endphp
                        @endforeach
                    </tbody>
                </table>
                {{ $lista_configuraciones->links() }}
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        function saveConfig(form) {
            Swal.fire({
                title: 'Estas seguro?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, guardar!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.closest('#formconfig').submit();
                }
            })
        }


        function alertaConfirmacion(form) {
            Swal.fire({
                title: 'Estas seguro?',
                text: "No podras revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminar!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.closest('#formConfiguracionDelete').submit();
                }
            })
        }
    </script>
    @if (session('datos') == 'okNotNull')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Complete todos los campos',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    @elseif (session('datos') == 'ok')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Guardado correctamente',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    @elseif (session('datos') == 'okNot')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error al guardar',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    @elseif (session('datos') == 'okDelete')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Configuracion eliminado correctamente',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    @elseif (session('datos') == 'okNotDelete')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error al eliminar la Configuracion',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    @endif
@endsection
