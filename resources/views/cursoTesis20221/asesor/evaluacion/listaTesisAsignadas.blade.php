@extends('plantilla.dashboard')
@section('titulo')
    Lista de Tesis asignadas
@endsection
@section('css')
    <style type="text/css">

    </style>
@endsection
@section('contenido')
<div class="card-header">
    Lista de Tesis asignadas (EVALUACION)
</div>
<div class="card-body">
    <div class="row justify-content-around align-items-center">
        <div class="col-12">
            {{-- <div class="row justify-content-end">
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
                                    <input type="text" class="form-control" name="buscarAlumno"
                                        placeholder="Codigo de matricula o Apellidos"
                                        value="{{ $buscarAlumno }}" aria-describedby="btn-search">
                                    <button class="btn btn-outline-primary" type="button" onclick="saveStateSemestre(this);"
                                        id="btn-search">Buscar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div> --}}
            <div class="row" style="display: flex; align-items:center;">
                <div class="col-12">
                        <table id="table-proyecto" class="table table-striped table-responsive-md">
                            <thead>
                                <tr>
                                    <td>Grupo</td>
                                    <td>Estudiantes</td>
                                    <td>Titulo</td>
                                    <td>Asesor</td>
                                    <td>JURADO</td>
                                    <td>Revision</td>
                                    <td>Descargar</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($studentforGroups as $estu)
                                    <tr
                                    {{-- @if ($estu[0]->estado == 3)
                                        style="background-color: #7BF96E;"
                                    @elseif ($estu[0]->estado == 4)
                                        style="background-color: #FA6A56;"
                                    @endif --}}
                                    >
                                        <td>{{$estu[0]->num_grupo}}</td>
                                        @if (count($estu)>1)
                                            <td>{{$estu[0]->nombresAutor.' '.$estu[0]->apellidosAutor.' & '.$estu[0]->nombresAutor.' '.$estu[0]->apellidosAutor}}</td>
                                        @else
                                            <td>{{$estu[0]->nombresAutor.' '.$estu[0]->apellidosAutor}}</td>
                                        @endif
                                        <td>{{$estu[0]->titulo}}</td>
                                        <td>{{$estu[0]->nombresAsesor.' '.$estu[0]->apellidosAsesor}}</td>
                                        <td>
                                            @if ($estu[0]->cod_jurado1 == $asesor->cod_docente)
                                                PRESIDENTE
                                            @elseif($estu[0]->cod_jurado2 == $asesor->cod_docente)
                                                2do JURADO
                                            @elseif($estu[0]->cod_jurado3 == $asesor->cod_docente)
                                                VOCAL
                                            @elseif($estu[0]->cod_jurado4 == $asesor->cod_docente)
                                                RESERVA
                                            @endif
                                        </td>
                                        <td>
                                            @if($estu[0]->estado != 0)
                                            <form id="form-revisaTema" action="{{route('asesor.evaluacion.detalleTesisAsignada')}}" method="POST">
                                                @csrf
                                                <input type="hidden" name="id_grupo" value="{{$estu[0]->id_grupo}}">
                                                <a href="#" onclick="this.closest('#form-revisaTema').submit()" class="btn btn-success">Revisar</a>
                                            </form>
                                            @endif
                                        </td>
                                        {{-- <td>
                                            @if($tesis->estado != 0)
                                                <form id="form-revisaTema" action="{{route('asesor.revisarTemas')}}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="id_grupo" value="{{$estu[0]->id_grupo}}">
                                                    @if ($estu[0]->estado == 1)
                                                        <a href="#" onclick="this.closest('#form-revisaTema').submit()" class="btn btn-success">Revisar</a>
                                                    @else
                                                        <a href="#" onclick="this.closest('#form-revisaTema').submit()" class="btn btn-secondary">Observar</a>
                                                    @endif
                                                </form>
                                            @endif
                                            <a href="{{route('asesor.revisarTemas',$estu->cod_matricula)}}" class="btn btn-success">Revisar</a>
                                        </td> --}}
                                        <td style="text-align: center;">
                                            <form id="proyecto-download" action="{{route('curso.descargaTesis')}}" method="POST">
                                                @csrf
                                                <input type="hidden" name="cod_cursoTesis" value="{{$estu[0]->cod_tesis}}">
                                                <a href="#" onclick="this.closest('#proyecto-download').submit()"><i class='bx bx-sm bx-download'></i></a>
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
