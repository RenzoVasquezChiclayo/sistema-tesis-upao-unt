@extends('plantilla.dashboard')
@section('titulo')
    Observaciones del Egresado
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
    <div class="row">
        <div class="col-12">
            <div class="row box-center">
                <div class="col-10">
                    <h4><b>{{$egresado[0]->nombres}}</b></h4>
                    <h6>{{$egresado[0]->escuela}}</h6>
                </div>
                @if($egresado[0]->estado == 3)
                    <div class="col-10" style="background-color: green; padding-top:10px;">
                        <p style="color: white">Este proyecto fue APROBADO!</p>
                    </div>
                @elseif ($egresado[0]->estado == 4)
                    <div class="col-10" style="background-color: red; padding-top:10px;">
                        <p style="color: white">Este proyecto fue DESAPROBADO!</p>
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
                                @endphp
                                @foreach ($observaciones as $observacion)
                                    <tr>
                                        <td>{{$observacion->observacionNum}}</td>
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
                                            @endphp
                                            {{$estado}}</td>
                                        <td>{{$observacion->fecha}}</td>
                                        <td style="text-align: center;">
                                            <form id="observacion-download" action="{{route('asesor.downloadObservacion')}}" method="POST">
                                                @csrf
                                                <input type="hidden" name="cod_observaciones" value="{{$observacion->cod_observaciones}}">
                                                <a href="#" onclick="this.closest('#observacion-download').submit()"><i class="fa fa-download"></i></a>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('js')
    <script>


    </script>
@endsection
