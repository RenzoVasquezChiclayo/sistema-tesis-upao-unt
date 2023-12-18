@extends('plantilla.dashboard')
@section('titulo')
    Historico Solicitud
@endsection
@section('contenido')
    <div class="card-header">
        Historico de Solicitud de Sustentación
    </div>
    <div class="card-body">
        <div class="row" style="display: flex; align-items:center;">
            <div class="col-12">
                <div class="table-responsive">
                    <table id="table-proyecto" class="table table-striped table-responsive-md">
                        <thead>
                            <tr>
                                <td>#</td>
                                <td>Fecha</td>
                                <td>Razon solicitud</td>
                                <td>Estado</td>
                                <td>Accion</td>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $index = 1;
                            @endphp
                            @foreach ($solicitudes as $slc)

                                    <tr>
                                        <td>{{$index}}</td>
                                        <td>{{$slc->fecha_solicitud}}</td>
                                        <td>{{$slc->razon_solicitud}}</td>
                                        <td>
                                            @php
                                                $resultado = "";
                                                if($slc->estado == 1){
                                                    $resultado = "En progreso";
                                                }else{
                                                    $resultado = "Culminado";
                                                }
                                            @endphp
                                            <p>{{$resultado}}</p>
                                        </td>
                                        <td style="text-align: center;">
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal">
                                                <i class='bx bx-show'></i>
                                            </a>
                                            <!-- Modal -->
                                            <div class="modal" id="imageModal" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-body">
                                                            <img src="cursoTesis-2022/img/alumnos-vouchers/solicitud-jurados/{{$tesis->cod_matricula}}/{{$slc->voucher}}" alt="Imagen" class="img-fluid">
                                                        </div>
                                                        <!-- Modal footer -->
                                                    <div class="modal-footer">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <button type="button" class="btn btn-danger"
                                                                    data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @php
                                        $index++;
                                    @endphp
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

    @if (session('datos') == 'oksolicitud')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Solicitud creada correctamente',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    @elseif (session('datos') == 'oknotsolicitud')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error al crear solicitud',
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

    </script>
@endsection
