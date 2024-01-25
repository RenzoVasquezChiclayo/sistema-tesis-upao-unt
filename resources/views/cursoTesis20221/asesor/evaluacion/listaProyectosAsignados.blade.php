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
    Lista de Proyectos de Tesis asignados (EVALUACIÓN)
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
                                    <td>Estudiante(s)</td>
                                    <td>Titulo</td>
                                    <td>Asesor</td>
                                    <td>Tipo Jurado</td>
                                    <td>Revisión</td>
                                    <td>Aprobación</td>
                                    <td>Observacion(es)</td>
                                    <td>Descargar</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($studentforGroups as $estu)
                                    <tr
                                    @if ($estu[0]->estadoDesignacion == 3)
                                        style="background-color: rgba(76, 175, 80, 0.2);"
                                    @elseif ($estu[0]->estadoDesignacion == 4)
                                    style="background-color: rgba(255, 87, 51, 0.2);"
                                    @endif>
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
                                            @php
                                                $textButton = "";
                                                if($estu[0]->numObs > 0 || $estu[0]->estadoDesignacion > 1){
                                                    $textButton = "Observar";
                                                }elseif($estu[0]->estadoDesignacion == 0){
                                                    $textButton = "Iniciar revisión";
                                                }elseif ($estu[0]->estadoDesignacion == 1) {
                                                    $textButton = "Revisar";
                                                }else
                                            @endphp
                                            @if($estu[0]->estado != 0)
                                                <form id="form-revisaTema" action="{{route('jurado.evaluarProyectoTesis')}}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="id_grupo" value="{{$estu[0]->id_grupo}}">
                                                    <input type="hidden" name="cod_proyectotesis" value="{{$estu[0]->cod_proyectotesis}}">
                                                    <a href="#" onclick="this.closest('#form-revisaTema').submit()" class="btn btn-success">{{$textButton}}</a>
                                                </form>
                                            @endif
                                        </td>
                                        <td>
                                            <form id="formAprobarProyecto" name="formAprobarProyecto" action="" method="">
                                                @csrf
                                                <input type="hidden" name="cod_proyectotesis" value="{{$estu[0]->cod_proyectotesis}}">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="" id="chkAprobado" onclick="aprobarProyecto(this);" @if($estu[0]->estadoDesignacion > 1 || $estu[0]->numObs > 0)disabled @endif @if($estu[0]->estadoDesignacion == 3) checked @endif>
                                                    <label class="form-check-label" for="chkAprobado">
                                                      Aprobado
                                                    </label>
                                                </div>
                                            </form>
                                        </td>
                                        <td><a href="{{route('jurado.listaProyectosAsignados',['showObservacion'=>$estu[0]->cod_proyectotesis])}}">Ver detalle</a></td>
                                        <td style="text-align: center;">
                                            <form id="proyecto-download" action="{{route('curso.descargaTesis')}}" method="POST">
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
@if ($observaciones != null)
<div class="card shadow bg-white rounded">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <td># Observación</td>
                        <td>Jurado</td>
                        <td>Fecha</td>
                        <td>Acción</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($observaciones as $obs)
                        <tr>
                            <td>{{'#'.($loop->index +1)}}</td>
                            <td>{{$obs->cod_jurado}}</td>
                            <td>{{$obs->fechaHistorial}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif

@endsection
@section('js')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('datos') == 'oknotevaluacion')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Ocurrio un error. Intentelo nuevamente.',
                showConfirmButton: true,
                timer: 2500
            })
        </script>
    @elseif (session('datos') == 'okevaluacion')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Los cambios/observaciones se guardaron correctamente!',
                showConfirmButton: true,
                timer: 2500
            })
        </script>
    @elseif (session('datos') == 'okAprobadoProyecto')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'El proyecto se aprobó correctamente!',
                showConfirmButton: true,
                timer: 2500
            })
        </script>
    @elseif (session('datos') == 'oknotAprobadoProyecto')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Ocurrió un problema durante la aprobación del proyecto de tesis.',
                showConfirmButton: true,
                timer: 2500
            })
        </script>
    @elseif (session('datos') == 'okobservacion')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'La observacion se guardo correctamente!',
                showConfirmButton: true,
                timer: 2500
            })
        </script>
    @elseif (session('datos') == 'oknotobservacion')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Ocurrió un problema. Intentelo nuevamente.',
                showConfirmButton: true,
                timer: 2500
            })
        </script>
    @endif
    <script type="text/javascript">
        function aprobarProyecto(chk){
            Swal.fire({
                title: 'Estas seguro(a)?',
                text: "El proyecto será aprobado.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, APROBAR!',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.formAprobarProyecto.action = "{{ route('jurado.aprobarProyectoTesis') }}";
                    document.formAprobarProyecto.method = "POST";
                    document.formAprobarProyecto.submit();
                }else{
                    document.getElementById(chk.id).checked = false;
                }
            })
        }
    </script>
@endsection
