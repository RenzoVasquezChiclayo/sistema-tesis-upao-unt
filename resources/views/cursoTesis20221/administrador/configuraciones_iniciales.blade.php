@extends('plantilla.dashboard')
@section('titulo')
    Configuraciones Iniciales
@endsection
@section('contenido')
    <div class="card-header">
        Configuraciones Iniciales
    </div>
    <div class="card-body">
        <form id="formconfig" method="post" action="{{ route('admin.saveconfigurar') }}">
            @csrf
            <div class="row">
                <div class="col-xl-4">
                    <h5>Año</h5>
                    <input class="form-control" type="text" minlength="4" maxlength="4" placeholder="0000" name="year">
                </div>
                <div class="col-xl-5">
                    <h5>Curso</h5>
                    <input class="form-control" type="text" placeholder="Nombre del curso" name="curso">
                </div>
                <div class="col-xl-3">
                    <h5>Ciclo</h5>
                    <input class="form-control" type="number" name="ciclo">
                </div>
            </div>
            <div class="row justify-content-around align-items-center" style="margin-top: 30px;">
                <div class="col-4">
                    <input class="btn btn-success" type="button" value="Guardar" onclick="saveConfig(this);">
                </div>

            </div>
        </form>

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
    @endif
@endsection
