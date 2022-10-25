@extends('plantilla.dashboard')
@section('titulo')
    Ver Silabos
@endsection
@section('css')
    <style type="text/css">
        .box-center{
                display: flex;
                justify-content: center;
                align-items: center;
                margin-top:10px;
                margin-bottom:10px;
            }
    </style>

@endsection
@section('contenido')
<body>
    <div class="col-12">
        <div class="row box-center">
            <div class="col-10 ">
                <div class="row">
                    <div class="row">
                        <div class="col" style="margin: 20px;">
                           <a href="{{route('docente.crearSilabo')}}" class="btn btn-success">Nuevo Silabo</a>
                        </div>
                    </div>
                    <table id="table-silabo" class="table table-striped table-responsive-md">
                        <thead>
                            <tr>
                                <td>Fecha</td>
                                <td>Curso</td>
                                <td>Escuela</td>
                                <td>Facultad</td>
                                <td>Estado</td>
                            </tr>
                        </thead>
                        <tbody>

                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>


                        </tbody>
                    </table>

                    {{-- {{$formatos->links()}} --}}
                </div>
            </div>
        </div>
    </div>
</body>
@endsection
