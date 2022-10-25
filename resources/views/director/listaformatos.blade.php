@extends('plantilla.dashboard')
@section('titulo')
    Formatos de titulos
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
                            <form id="listFormat" name="listFormat" method="get">
                                <div class="row">
                                    <div class="col-9">
                                        <input type="text" class="form-control me-2" name="buscarformato" placeholder="Buscar formato" value="{{$buscarformato}}" aria-describedby="btn-search">
                                    </div>
                                    <div class="col-3">
                                        <input class="btn btn-outline-success" type="submit" id="btn-search" value="Search">
                                    </div>
                                </div>
                                <input type="hidden" id="allFormats" name="allFormats" value="false">
                            </form>
                        </div>
                    </div>
                    <div class="row" style="display:flex; align-items:right; justify-content:right;">
                        <div class="col-7 col-xl-4" style="text-align: right;">
                            <span id="notfound">@if (sizeof($formatos)==0)
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
                            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                                {{ session('datos') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                    @endif
                    <div class="row">
                        <table id="table-formato" class="table table-striped table-responsive-md">
                            <thead>
                                <tr>
                                    <td>Codigo</td>
                                    <td>Egresado</td>
                                    <td>Escuela</td>
                                    <td>Linea de Investigacion</td>
                                    <td>Fecha</td>
                                    <td style="text-align:center;">Ver</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($formatos as $formato)
                                    <tr @if ($formato->estado == 2)
                                        style="background-color:lightgreen;"
                                    @endif>
                                        <td>{{$formato->cod_matricula}}</td>
                                        <td>{{$formato->apellidos.', '.$formato->nombres}}</td>
                                        <td>{{$formato->nombre}}</td>
                                        <td>{{$formato->descripcion}}</td>
                                        <td>{{$formato->fecha}}</td>
                                        <td style="text-align:center;"><a href="{{route('director.showFormato',$formato->cod_matricula)}}"><i class="far fa-eye"></i></a></td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                        <div class="row" style="display: flex; align-items:right; justify-content:right;">
                            <div class="col-10 col-xl-5" style="text-align: right;">
                                <button style="border:0; background:none; color:blue;" onclick="setAllFormats();"><u>Ver todos los formatos registrados</u></button>
                            </div>
                        </div>
                        {{$formatos->links()}}
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

        function setAllFormats(){
            document.getElementById('allFormats').value = 'true';
            document.listFormat.submit();
        }
    </script>
@endsection
