@extends('plantilla.dashboard')
@section('titulo')
    Solicitud Sustentación
@endsection
@section('contenido')
    <div class="card-header">
        Solicitud Sustentación
    </div>
    <div class="card-body">
        @if(sizeof($solicitudes)>0)
        <div class="row">
            <div class="col-12">
                <p>Existe una solicitud en progreso. Puedes darle seguimiento en el historial de tus solicitudes!</p>
            </div>
        </div>
        @elseif ($tesis->cod_informe_final==null)
            <div class="row">
                <div class="col-12">
                    <p>Esta vista se habilitara cuando su asesor envie su informe final!</p>
                </div>
            </div>
        @else
        <div class="row" style="text-align: start;">
            <form id="formSolicitud" name="formSolicitud" action="{{route('alumno.guardarSolicitud')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="col-12 mb-3">
                    <label for="">Razon de solicitud</label>
                    <select class="form-select" name="razonSolicitud" id="razonSolicitud" aria-placeholder="">
                        <option value="0" selected>-</option>
                        <option value="1">Designacion de jurados</option>
                        <option value="2">Designacion de jurados - 2da vez</option>
                        <option value="3">Designacion de jurados - Reevaluacion</option>
                    </select>
                </div>
                <div class="col-12 mb-3">
                    <label for="">Titulo de tesis</label>
                    <input type="hidden" name="cod_tesis" value="{{$tesis->cod_tesis}}">
                    <textarea class="form-control" type="text"readonly>{{$tesis->titulo}}</textarea>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <label for="">Fecha de la solicitud</label>
                        <input class="form-control" type="date" name="fechaActual" id="fechaActual" disabled>
                    </div>
                    <div class="col-6">
                        <label for="">Fecha maxima de respuesta</label>
                        <input class="form-control" type="date" id="fechaMaxima" disabled>
                    </div>
                </div>
                <div class="col-12 mb-3">
                    <label for="voucher">Subir voucher</label>
                    <input class="form-control" type="file" id="voucher" name="voucher" accept="image/*" required>
                </div>
                <button class="btn btn-success" type="button" onclick="verificarSolicitud(this);">Enviar solicitud</button>
            </form>
        </div>
        @endif
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
            const inputArchivo = document.getElementById('voucher').files.length;
            if (inputArchivo === 0) {
                alert("Debe subir la imagen del voucher");
                return false;
            }
            form.closest("#formSolicitud").submit();
        }
    </script>
@endsection
