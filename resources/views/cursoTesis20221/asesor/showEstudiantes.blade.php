@extends('plantilla.dashboard')
@section('titulo')
    Estudiantes con Proyectos
@endsection
@section('contenido')
<div class="card-header">
    En proceso (PROYECTO DE TESIS)
</div>
<div class="card-body">
    <div class="row">
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
                                    <td colspan="2" style="text-align: center;">Estudiantes</td>
                                    <td>Revision</td>
                                    <td>Descargar</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($studentforGroups as $estu)
                                    <tr
                                    @if ($estu[0]->estado == 3)
                                        style="background-color: rgba(76, 175, 80, 0.2);"
                                    @elseif ($estu[0]->estado == 4)
                                    style="background-color: rgba(255, 87, 51, 0.2);"
                                    @endif>
                                        <td>{{$estu[0]->num_grupo}}</td>
                                        <td colspan="2">
                                            <table class="table table-borderless mb-0">
                                                <tbody>
                                                    @foreach ($estu as $e)
                                                    <tr>
                                                        <td>{{$e->cod_matricula}}</td>
                                                        <td>{{$e->apellidos.' '.$e->nombres}}</td>
                                                    </tr>
                                                    @endforeach

                                                </tbody>
                                            </table>
                                        </td>
                                        <td>
                                            @if($estu[0]->estado != 0)
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

                                        </td>
                                        <td style="text-align: center;">
                                            <form id="proyecto-download" action="{{route('curso.descargaProyTesis')}}" method="POST">
                                                @csrf
                                                <input type="hidden" name="cod_cursoTesis" value="{{$estu[0]->cod_proyectotesis}}">
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
@section('js')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('datos')=='ok')
        <script>
            Swal.fire(
                'Guardado!',
                'Asignacion de campos guardados correctamente',
                'success'
            )
        </script>
    @elseif (session('datos') == 'okAprobado')
        <script>
            Swal.fire(
                'Guardado!',
                'El proyecto fue APROBADO',
                'success'
            )
        </script>
    @elseif (session('datos') == 'okDesaprobado')
        <script>
            Swal.fire(
                'Guardado!',
                'El proyecto fue DESAPROBADO',
                'success'
            )
        </script>
    @endif
    <script type="text/javascript">
        function saveStateSemestre(form){
                    const semestreSelect = document.getElementById("filtrar_semestre");
                    const selectedSemestre = semestreSelect.options[semestreSelect.selectedIndex];
                    document.getElementById("semestre").value = selectedSemestre.value;
                    form.closest("#listAlumno").submit();
                }
    </script>
@endsection
