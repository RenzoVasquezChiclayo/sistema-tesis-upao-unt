@extends('plantilla.dashboard')
@section('titulo')
    Lista Sutentacion de Tesis
@endsection
@section('css')
    <style type="text/css">

    </style>
@endsection
@section('contenido')
    <div class="card-header">
        Lista de Sustentacion de Tesis
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
                                            <option value="{{ $sem->cod_configuraciones }}" @if ($sem->cod_configuraciones == $filtrarSemestre) selected @endif>
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
                    <div class="table-responsive">
                        <table id="table-tesis" class="table table-striped table-responsive-md">
                            <thead>
                                <tr>
                                    <td>Grupo</td>
                                    <td>Estudiante(s)</td>
                                    <td>Título</td>
                                    <td>Nota</td>
                                    <td>Comentario</td>
                                    <td class="text-center">Ver</td>
                                </tr>
                            </thead>
                            <tbody>
                                @if(sizeof($tesisAgrupadas)<=0)
                                <tr>
                                    <td colspan="9"><i>No cuenta con tesis para sustentacion.</i></td>
                                </tr>
                                @endif
                                @foreach ($tesisAgrupadas as $tesisAgru)
                                    <tr
                                    <!-- @if ($tesisAgru[0]->estadoDesignacion == 3)
                                        style="background-color: rgba(76, 175, 80, 0.2);"
                                    @elseif ($tesisAgru[0]->estadoDesignacion == 4)
                                    style="background-color: rgba(255, 87, 51, 0.2);"
                                    @endif> -->
                                        <!-- <td>{{ $tesisAgru[0]->num_grupo }}</td> -->
                                        <td>
                                        @foreach ($tesisAgru as $ta)
                                            <p>{{$ta->cod_matricula.' - '.$ta->apellidosAutor.', '.$ta->nombresAutor}}</p>
                                        @endforeach
                                        </td>
                                        <td>{{ $tesisAgru[0]->titulo }}</td>
                                        <td>
                                            @if ($tesisAgru[0]->estado != 0)
                                                <form id="form-revisaTema"
                                                    action="{{ route('jurado.detalleTesisAsignada') }}"
                                                    method="POST">
                                                    @csrf
                                                    <input type="hidden" name="id_grupo" value="{{$estu[0]->id_grupo}}">
                                                    <input type="hidden" name="cod_tesis" value="{{$estu[0]->cod_tesis}}">
                                                    <a href="#" onclick="this.closest('#form-revisaTema').submit()" class=" btn @if($textButton == "Observar") btn-secondary @else btn-success @endif">{{$textButton}}</a>
                                                </form>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{route('jurado.listaTesisAsignadas',['showObservacion'=>$estu[0]->cod_tesis])}}">Ver detalle</a>
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
                            <td class="text-center">Acción</td>
                        </tr>
                    </thead>
                    <tbody>
                        @if(sizeof($observaciones)<=0)
                            <tr>
                                <td colspan="4"><p><i>No existen observaciones.</i></p></td>
                            </tr>
                        @endif
                        @foreach ($observaciones as $obs)
                            <tr>
                                <td>{{'#'.($loop->index +1)}}</td>
                                <td>{{$obs->apellidosJurado.', '.$obs->nombresJurado}}</td>
                                <td>{{$obs->fechaHistorial}}</td>
                                <td class="text-center"><a href="#"><i class='bx bx-sm bx-show'></i></a></td>
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
    @elseif (session('datos') == 'okAprobadoTesis')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'La tesis se aprobó correctamente!',
                showConfirmButton: true,
                timer: 2500
            })
        </script>
    @elseif (session('datos') == 'oknotAprobadoTesis')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Ocurrió un problema durante la aprobación de la tesis.',
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
        function aprobarTesis(chk) {
            const idchk = chk.id.split('-');
            Swal.fire({
                title: 'Estas seguro(a)?',
                text: "La tesis será aprobado/desaprobado.",
                icon: 'warning',
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: 'APROBAR',
                denyButtonText: 'DESAPROBAR',
                cancelButtonText: 'Cancelar',
            }).then((result) => {

                if (result.isConfirmed) {
                    document.getElementById(`stateAprobation-${idchk[1]}`).value = 1;
                } else if (result.isDenied) {
                    document.getElementById(`stateAprobation-${idchk[1]}`).value = 0;
                } else {
                    document.getElementById(`chkAprobado-${idchk[1]}`).checked = false;
                    return;
                }
                chk.closest('#formAprobarTesis').action = "{{ route('jurado.aprobarTesis') }}";
                chk.closest('#formAprobarTesis').method = "POST";
                chk.closest('#formAprobarTesis').submit();
            });
        }
    </script>
@endsection
