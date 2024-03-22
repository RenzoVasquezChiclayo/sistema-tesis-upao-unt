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
                                    <td>Codigo Tesis</td>
                                    <td>Estudiante(s)</td>
                                    <td>Título</td>
                                    <td>Nota</td>
                                    <td class="text-center">Ver</td>
                                </tr>
                            </thead>
                            <tbody>
                                @if (sizeof($tesisAgrupadas) <= 0)
                                    <tr>
                                        <td colspan="9"><i>No cuenta con tesis para sustentacion.</i></td>
                                    </tr>
                                @endif
                                @foreach ($tesisAgrupadas as $index => $tesisAgru)
                                    <tr>
                                        <td>{{ $tesisAgru[0]['cod_tesis'] }}</td>
                                        <td>
                                            @foreach ($tesisAgru[0]['autores'] as $ta)
                                                <p>{{ $ta['cod_matricula'] . ' - ' . $ta['apellidosAutor'] . ', ' . $ta['nombresAutor'] }}
                                                </p>
                                            @endforeach
                                        </td>
                                        <td>{{ $tesisAgru[0]['titulo'] }}</td>
                                        <td>

                                            @if ($tesisAgru[0]['fecha_susten'] == true)
                                                <div>
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                        data-bs-target="#mNota{{$index}}">
                                                        <i class='bx bx-search-alt-2'></i>
                                                    </button>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="">Ver detalle</a>
                                        </td>
                                    </tr>
                                    {{-- Modal para Nota --}}
                                    <div class="modal" id="mNota{{$index}}">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                            <form id="formguardarNota{{$index}}" name="formguardarNota{{$index}}">
                                                @csrf
                                                <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Nota</h4>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <div class="modal-body">
                                                        <div class="row" style="padding: 20px">
                                                            <div class="col-4">
                                                                <p>Nota</p>
                                                                <input type="hidden" name="cod_tesis"
                                                                    value="{{ $tesisAgru[0]['cod_tesis'] }}">
                                                                <input type="number" class="form-control" name="nota"
                                                                    min="0" max="20"
                                                                    value="{{ sizeof($tesisAgru) > 1 ? $tesisAgru[1]->nota : 0 }}">
                                                            </div>
                                                            <div class="col">
                                                                <p>Comentario</p>
                                                                <textarea class="form-control" name="comentario" id="taComentario" style="height: 100px; resize:none">{{ sizeof($tesisAgru) > 1 ? $tesisAgru[1]->comentario : '' }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Modal footer -->
                                                    <div class="modal-footer">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <button type="button" class="btn btn-danger">Close</button>
                                                            </div>
                                                            <div class="col-6">
                                                                <button type="button" class="btn btn-success" @if (sizeof($tesisAgru) > 1 && $tesisAgru[1]->nota != null)
                                                                    hidden
                                                                @endif
                                                                    onclick="guardarNota({{$index}});">Guardar</button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </form>
                                        </div>
                                    </div>
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
        function guardarNota(doc) {
            document.getElementById(`formguardarNota${doc}`).action = "{{ route('asesor.sustentacion.notaTesis') }}";
            document.getElementById(`formguardarNota${doc}`).method = "POST";
            document.getElementById(`formguardarNota${doc}`).submit();
        }
    </script>
@endsection
