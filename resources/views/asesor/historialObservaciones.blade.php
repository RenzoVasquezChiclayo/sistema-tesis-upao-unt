@extends('plantilla.dashboard')
@section('titulo')
    Historial de Observaciones
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
                    <div class="row" style="display:flex; align-items:right; justify-content:right;">
                        <div class="col-9 col-md-4">
                            <form id="listObservacion" name="listObservacion" method="get">
                                <div class="row">
                                    <div class="col-9">
                                        <input type="text" class="form-control me-2" name="buscarObservacion" placeholder="Buscar observacion" value="{{$buscarObservaciones}}" aria-describedby="btn-search">
                                    </div>
                                    <div class="col-3">
                                        <input class="btn btn-outline-success" type="submit" id="btn-search" value="Search">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row" style="display:flex; align-items:right; justify-content:right;">
                        <div class="col-7 col-xl-4" style="text-align: right;">
                            <span id="notfound">@if (sizeof($egresados)==0)
                                No se encontro algun registro
                            @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="row box-center">
                <div class="col-10 ">
                    @if (session('datos'))
                        <div id="mensaje">
                            <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
                                {{ session('datos') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                    @endif
                    <div class="row">
                        <table id="table-formato" class="table table-bordered table-striped table-responsive-md">
                            <thead>
                                <tr>
                                    <td>Codigo Matricula</td>
                                    <td>Egresado</td>
                                    <td>Escuela</td>
                                    <td>Ultima Observacion</td>
                                    <td style="text-align:center;">Ver Observacion</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($egresados as $egresado)
                                    <tr>
                                        <td>{{$egresado->cod_matricula}}</td>
                                        <td>{{$egresado->apellidos.', '.$egresado->nombres}}</td>
                                        <td>{{$egresado->escuela}}</td>
                                        <td>{{$egresado->fecha}}</td>
                                        <td style="text-align:center;">
                                            <a href="{{route('asesor.showObservaciones',$egresado->cod_historialObs)}}"><i class="far fa-eye"></i></a>
                                            {{-- <form id="form-observacion" action="{{route('asesor.showObservaciones')}}" method="POST">
                                                @csrf
                                                <input type="hidden" name="cod_historialObs" value="{{$egresado->cod_historialObs}}">
                                                <a href="#" onclick="this.closest('#form-observacion').submit()"><i class="fa fa-download"></i></a>
                                            </form> --}}
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                        {{$egresados->links()}}
                    </div>


                </div>
            </div>
        </div>

    </div>
@endsection
@section('js')
    <script>
        setTimeout(function(){
            document.querySelector('#mensaje').remove();
        },2000);

    </script>
@endsection
