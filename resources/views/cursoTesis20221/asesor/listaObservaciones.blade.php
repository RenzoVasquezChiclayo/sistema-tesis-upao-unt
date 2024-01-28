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
<div class="card-header">
    Historial de Proyectos de Tesis
</div>
<div class="card-body">
    <div class="row">
        <div class="col-12">
            <div class="mx-3" style="display:flex; align-items:end; justify-content:end;">
                <div class="col-12 col-md-8 col-lg-6 col-xl-4">
                    <form id="listObservacion" name="listObservacion" method="get">
                        <div class="row">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="buscarObservacion" placeholder="Buscar por código o apellidos" value="{{$buscarObservaciones}}" aria-describedby="btn-search">
                                <button class="btn btn-outline-success" type="submit" id="btn-search"><i class='bx bx-sm bx-search' style="vertical-align: middle;"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="table-responsive mx-3">
                <table id="table-formato" class="table table-bordered table-striped table-responsive-md">
                    <thead>
                        <tr>
                            <td>Grupo</td>
                            <td>Escuela</td>
                            <td>Ultima Observacion</td>
                            <td style="text-align:center;">Ver Observacion</td>
                        </tr>
                    </thead>
                    <tbody>
                        @if (sizeof($estudiantes)<=0)
                        <tr>
                            <td colspan="4"><i>No se encontró algún registro.</i></td>
                        </tr>
                        @endif

                        @foreach ($estudiantes as $estudiante)
                            <tr @if ($estudiante->estado == 3)
                                style="background-color: rgba(76, 175, 80, 0.2);"
                            @elseif ($estudiante->estado == 4)
                            style="background-color: rgba(255, 87, 51, 0.2);"
                            @endif>
                                <td>{{$estudiante->id_grupo}}</td>
                                <td>Contabilidad y Finanzas</td>
                                <td>{{$estudiante->fecha}}</td>
                                <td style="text-align:center;">
                                    <a href="{{route('asesor.verObsEstudiante',$estudiante->cod_proyectotesis)}}"><i class='bx bx-sm bx-show'></i></a>

                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
                {{$estudiantes->links()}}
            </div>
            <div class="row box-center">
                <div class="col-12">


                </div>
            </div>
        </div>

    </div>
</div>

@endsection
@section('js')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


@endsection
