@extends('plantilla.dashboard')
@section('titulo')
    Observaciones del Estudiante
@endsection
@section('css')
    <style type="text/css">
        .box-search{
            display: flex;
            justify-content: right;
            align-items: right;
            margin-top:15px;
            margin-bottom:10px;
        }
        .box-center{
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top:10px;
            margin-bottom:10px;
        }

        #table-formato > thead > tr > td{
            color: rgb(40, 52, 122);
            font-style: italic;
        }

    </style>
@endsection
@section('contenido')
<div class="card-header">
    Observaciones del estudiante
</div>
<div class="card-body">
    <div class="row">
        <div class="col-12">
            <div class="row box-center">
                <div class="col-10">
                    <h4><b>{{$estudiante[0]->nombres." ".$estudiante[0]->apellidos}}</b></h4>
                    <h6>{{$estudiante[0]->escuela}}</h6>
                </div>
                @if($estudiante[0]->estado == 3)
                    <div class="col-10" style="background-color: green; padding-top:10px;">
                        <p style="color: white">Esta Tesis fue APROBADO!</p>
                    </div>
                @elseif ($estudiante[0]->estado == 4)
                    <div class="col-10" style="background-color: red; padding-top:10px;">
                        <p style="color: white">Esta Tesis fue DESAPROBADO!</p>
                    </div>
                @endif
                <div class="col-10 ">
                    <br>
                    <div class="row">
                        <table id="table-formato" class="table table-bordered table-striped table-responsive-md">
                            <thead>
                                <tr>
                                    <td>Numero</td>
                                    <td>Estado</td>
                                    <td>Fecha</td>
                                    <td style="text-align:center;">Descargar</td>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $estado = 'Sin iniciar';
                                    $contadorObs = 1;
                                @endphp
                                @foreach ($observaciones as $observacion)
                                    <tr>
                                        <td>{{$contadorObs}}</td>
                                        <td>
                                            @php
                                                switch($observacion->estado){
                                                    case 1:
                                                        $estado = 'Sin corregir';
                                                        break;
                                                    case 2:
                                                        $estado = 'Corregido';
                                                        break;
                                                }
                                                $contadorObs++;
                                            @endphp
                                            {{$estado}}</td>
                                        <td>{{$observacion->fecha_create}}</td>

                                        <td style="text-align: center;">
                                            <form id="observacion-download" action="{{route('asesor.descarga-observacion')}}" method="POST">
                                                @csrf
                                                <input type="hidden" name="cod_observaciones" value="{{$observacion->id_observacion}}">
                                                <a href="#" onclick="this.closest('#observacion-download').submit()"><i class='bx bx-sm bx-download'></i></a>

                                            </form>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-10">
                    <br>
                    <!-- <input type="button" class="btn btn-warning" onclick="history.back()" name="volver atrás" value="Volver"> -->
                    <a href="{{route('user_information')}}" type="button" class="btn btn-danger" style="margin-left:20px;">Volver</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('datos')=='ok')
        <script>
            Swal.fire(
            'Guardado!',
            'La observaciones se guardaron correctamente',
            'success'
            )
        </script>
    @elseif (session('datos')=='okAprobado')
        <script>
            Swal.fire(
            'Guardado!',
            'La Tesis fue APROBADA',
            'success'
            )
        </script>
    @elseif (session('datos')=='okDesaprobado')
        <script>
            Swal.fire(
            'Guardado!',
            'La Tesis fue DESAPROBADA',
            'success'
            )
        </script>
    @endif

@endsection
