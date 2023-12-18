@extends('plantilla.dashboard')
@section('titulo')
    Historial de Informe final
@endsection
@section('contenido')
    <div class="card-header">
        Historial de Informe final
    </div>
    <div class="card-body">
        <div class="row" style="display: flex; align-items:center;">
            <div class="col-12">
                <div class="table-responsive">
                    <table id="table-proyecto" class="table table-striped table-responsive-md">
                        <thead>
                            <tr>
                                <td>Numero Matricula</td>
                                <td>DNI</td>
                                <td>Nombre completo</td>
                                <td>Accion</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($estudiantes as $estu)
                                    <tr>
                                        <td>{{$estu->cod_matricula}}</td>
                                        <td>{{$estu->dni}}</td>
                                        <td>{{$estu->nombres.' '.$estu->apellidos}}</td>
                                        <td style="text-align: center;">
                                            @if ($estu->cod_informe_final == null)
                                                <form id="formInforme" action="{{route('asesor.crearInformeFinal')}}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="cod_tesis" value="{{$estu->cod_tesis}}">
                                                    <a href="#" onclick="this.closest('#formInforme').submit()" class="btn btn-success">Crear informe</a>
                                                </form>
                                            @else
                                                <form id="verInforme" action="{{route('asesor.pdfInformeFinal')}}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="cod_tesis" value="{{$estu->cod_tesis}}">
                                                    <a href="#" onclick="this.closest('#verInforme').submit()"><i class='bx bx-show'></i></a>
                                                </form>
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
                title: 'Alumno editado correctamente',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    @elseif (session('datos') == 'oknot')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error al editar alumno',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    @elseif (session('datos') == 'oknotverInforme')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error al abrir el pdf',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    @elseif (session('datos') == 'okDelete')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Alumno eliminado correctamente',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    @elseif (session('datos') == 'okNotDelete')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error al eliminar el alumno',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    @endif
    <script type="text/javascript">

        // Obtener la fecha actual
        let fechaActual = new Date();

        // Formatear la fecha para asignarla al campo de entrada
        let formatoFecha = [
            fechaActual.getFullYear(),
            ('0' + (fechaActual.getMonth() + 1)).slice(-2),
            ('0' + fechaActual.getDate()).slice(-2)
        ].join('-');

        let fechaMaxima = fechaActual;
        fechaMaxima.setDate(fechaActual.getDate() + 10);

        let formatoFechaMaxima = [
            fechaMaxima.getFullYear(),
            ('0' + (fechaMaxima.getMonth() + 1)).slice(-2),
            ('0' + fechaMaxima.getDate()).slice(-2)
        ].join('-');

        // Asignar la fecha formateada al campo de entrada
        document.getElementById('fechaMaxima').value = formatoFechaMaxima;

        // Asignar la fecha formateada al campo de entrada
        document.getElementById('fechaActual').value = formatoFecha;

        function verificarSolicitud(form){
            const razonSolicitud = document.getElementById("razonSolicitud").value;
            if(razonSolicitud == 0){
                alert("Selecciona la razon de la solicitud");
                return false;
            }
            const inputArchivo = document.getElementById('miArchivo').files.length;
            if (inputArchivo === 0) {
                alert("Debe subir la imagen del voucher");
                return false;
            }
            form.submit();
        }
    </script>
@endsection
