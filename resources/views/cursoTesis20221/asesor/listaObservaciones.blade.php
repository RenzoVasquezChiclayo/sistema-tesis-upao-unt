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
            <div class="row box-center">
                <div class="col-10">
                    <div class="row justify-content-end">
                        <div class="row mb-3 justify-content-end align-items-center">
                            <div class="col-md-3">
                                <h5>Filtrar</h5>
                                <form id="filtrarAlumno" name="filtrarAlumno" method="get">
                                    <div class="row">
                                        <div class="input-group">
                                            <select class="form-select" name="filtrar_semestre"
                                                id="filtrar_semestre" required>
                                                @foreach ($semestre as $sem)
                                                    <option value="{{ $sem->cod_configuraciones }}" @if($sem->cod_configuraciones == $filtrarSemestre) selected @endif>
                                                        {{ $sem->año }}_{{ $sem->curso }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <button class="btn btn-outline-primary" type="submit"
                                                id="btn-search">Filtrar</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                            <div class="col col-sm-8 col-md-6">
                                <h5>Buscar alumno</h5>
                                <form id="listAlumno" name="listAlumno" method="get">
                                    <div class="row">
                                        <input name="semestre" id="semestre" type="text" hidden>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="buscarObservacion"
                                                placeholder="Codigo de matricula o Apellidos"
                                                value="{{ $buscarObservaciones }}" aria-describedby="btn-search">
                                            <button class="btn btn-outline-primary" type="button" onclick="saveStateSemestre(this);"
                                                id="btn-search">Buscar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="display:flex; align-items:right; justify-content:right;">
                        <div class="col-7 col-xl-4" style="text-align: right;">
                            <span id="notfound">@if (sizeof($estudiantes)==0)
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
                    <div class="row">
                        <div class="table-responsive">
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
                                    @foreach ($estudiantes as $estudiante)
                                        <tr
                                        @if ($estudiante->estado == 3)
                                            style= "background-color: #7BF96E;"
                                        @elseif ($estudiante->estado == 4)
                                            style= "background-color: #FA6A56;"
                                        @endif
                                        >
                                            <td>{{$estudiante->cod_matricula}}</td>
                                            <td>{{$estudiante->apellidos.', '.$estudiante->nombres}}</td>
                                            <td>Contabilidad y Finanzas</td>
                                            <td>{{$estudiante->fecha}}</td>
                                            <td style="text-align:center;">
                                                <a href="{{route('asesor.verObsEstudiante',$estudiante->cod_historialObs)}}"><i class='bx bx-sm bx-show'></i></a>

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

    </div>
</div>

@endsection
@section('js')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        function saveStateSemestre(form){
                    const semestreSelect = document.getElementById("filtrar_semestre");
                    const selectedSemestre = semestreSelect.options[semestreSelect.selectedIndex];
                    document.getElementById("semestre").value = selectedSemestre.value;
                    form.closest("#listAlumno").submit();
                }
    </script>

@endsection
