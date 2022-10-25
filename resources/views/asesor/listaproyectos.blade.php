@extends('plantilla.dashboard')
@section('titulo')
    Lista de Proyectos de Tesis
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
                            <form id="listProy" name="listProy" method="get">
                                <div class="row">
                                    <div class="col-9">
                                        <input type="text" class="form-control me-2" name="buscarproyecto" placeholder="Buscar proyecto" value="{{$buscarproyectos}}" aria-describedby="btn-search">
                                    </div>
                                    <div class="col-3">
                                        <input class="btn btn-outline-success" type="submit" id="btn-search" value="Search">
                                    </div>
                                </div>
                                <input type="hidden" id="allProyects" name="allProyects" value="false">
                            </form>
                        </div>
                    </div>
                    <div class="row" style="display:flex; align-items:right; justify-content:right;">
                        <div class="col-7 col-xl-4" style="text-align: right;">
                            <span id="notfound">@if (sizeof($proyectos)==0)
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
                                    <td>Codigo</td>
                                    <td>Egresado</td>
                                    <td>Escuela</td>
                                    <td>Fecha</td>
                                    <td style="text-align:center;">Ver</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($proyectos as $proyect)
                                    <tr
                                    @if ($proyect->estado == 3)
                                        style="background-color:lightgreen;"
                                    @endif
                                    >
                                        <td>{{$proyect->cod_matricula}}</td>
                                        <td>{{$proyect->apellidos.', '.$proyect->nombres}}</td>
                                        <td>{{$proyect->escuela}}</td>
                                        <td>{{$proyect->fecha}}</td>
                                        <td style="text-align:center;"><a href="{{route('asesor.showProyecto',$proyect->cod_matricula)}}"><i class="far fa-eye"></i></a></td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                        <div class="row" style="display: flex; align-items:right; justify-content:right;">
                            <div class="col-10 col-xl-5" style="text-align: right;">
                                <button style="border:0; background:none; color:blue;" onclick="setallProyects();"><u>Ver todos los proyectos registrados</u></button>
                            </div>
                        </div>
                        {{$proyectos->links()}}
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

        function setallProyects(){
            document.getElementById('allProyects').value = 'true';
            document.listProy.submit();
        }
    </script>
@endsection
