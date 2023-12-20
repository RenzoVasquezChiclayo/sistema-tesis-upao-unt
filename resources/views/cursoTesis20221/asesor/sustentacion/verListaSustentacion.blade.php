@extends('plantilla.dashboard')
@section('titulo')
    Lista de Sustentaciones
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
    Lista de Sustentaciones
</div>
<div class="card-body">
    <div class="row justify-content-end mb-4">
        <div class="col-12 px-4 col-lg-6" style="text-align:start;">
            <form id="listAlumno" name="listAlumno" method="get">
                <label for="" class="ps-2">Buscar estudiante</label>
                <input name="semestre" id="semestre" type="text" hidden>
                <div class="input-group has-validation">
                    <input type="text" class="form-control @if(sizeof($estudiantes)==0 && $buscarAlumno != '') is-invalid @endif" name="validationSearch" value="{{$buscarAlumno}}" placeholder="Apellidos del estudiante" id="validationSearch" aria-describedby="btn-search">
                    <button class="btn btn-outline-primary" type="button" onclick="submitSearchForm(this);" id="btn-search">Buscar</button>
                    <div id="validationServerUsernameFeedback" class="invalid-feedback">No se ha encontrado.</div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-12 px-4 justify-content-center">
            <div class="table-responsive">
                <table id="table-formato" class="table table-bordered table-striped table-responsive-md">
                    <thead>
                        <tr>
                            <td>Codigo Matricula</td>
                            <td>Egresado</td>
                            <td>Escuela</td>
                            <td>Ultima Observacion</td>
                            <td>Acciones</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($estudiantes as $estudiante)
                            <tr @if($estudiante->estado == 3) style= "background-color: #7BF96E;" @elseif ($estudiante->estado == 4) style= "background-color: #FA6A56;" @endif >
                                <td>{{$estudiante->cod_matricula}}</td>
                                <td>{{$estudiante->apellidos.', '.$estudiante->nombres}}</td>
                                <td>Contabilidad y Finanzas</td>
                                <td style="text-align:center;">
                                    <a href="{{route('asesor.verSustentacionEstudiante',$estudiante->cod_tesis)}}"><i class='bx bx-sm bx-show'></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="row">

            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        function submitSearchForm(form){
            form.closest("#listAlumno").submit();
        }
    </script>

@endsection
