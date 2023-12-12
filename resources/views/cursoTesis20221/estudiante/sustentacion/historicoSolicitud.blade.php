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
                                            <button class="btn btn-secondary">Observar</button>
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

    </script>
@endsection
