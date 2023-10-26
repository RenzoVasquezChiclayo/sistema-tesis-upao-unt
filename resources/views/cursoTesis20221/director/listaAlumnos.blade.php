@extends('plantilla.dashboard')
@section('titulo')
    Lista Alumnos
@endsection
@section('contenido')
    <div class="card-header">
        Lista de alumnos
    </div>
    <div class="card-body">
        <div class="row justify-content-around align-items-center">
            <div class="col-12">
                <div class="row justify-content-around align-items-center">
                    <div class="col-12">
                        <div class="card text-center shadow bg-white rounded">
                            <div class="card-body">
                                <div class="row justify-content-around align-items-center" style="margin: 10px;">
                                    <div class="col-md-5">
                                        <a href="{{ route('director.veragregar') }}" class="btn btn-success"><i
                                                class='bx bx-sm bx-message-square-add'></i>Nuevo Alumno</a>
                                    </div>
                                </div>
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
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table id="table-proyecto" class="table table-striped table-responsive-md">
                                <thead>
                                    <tr>
                                        <td>Numero Matricula</td>
                                        <td>DNI</td>
                                        <td>Nombre</td>
                                        <td>Editar</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $cont = 0;
                                    @endphp
                                    @foreach ($estudiantes as $est)
                                        <tr>
                                            <td>{{ $est->cod_matricula }}</td>
                                            <td>{{ $est->dni }}</td>
                                            <td>{{ $est->apellidos . ' ' . $est->nombres }}.</td>
                                            <td>
                                                <form id="form-alumno" method="post"
                                                    action="{{ route('director.verAlumnoEditar') }}">
                                                    @csrf
                                                    <input type="hidden" name="auxid" value="{{ $est->cod_matricula }}">
                                                    <a href="#" class="btn btn-warning"
                                                        onclick="this.closest('#form-alumno').submit();"><i
                                                            class='bx bx-sm bx-edit-alt'></i></a>
                                                </form>
                                            </td>
                                            @if (auth()->user()->rol == 'administrador' || auth()->user()->rol == 'd-CTesis2022-1')
                                                <td>
                                                    <form id="formAlumnoDelete" name="formAlumnoDelete" method="POST"
                                                        action="{{ route('director.deleteAlumno') }}">
                                                        @method('DELETE')
                                                        @csrf

                                                        <input type="hidden" name="auxidDelete"
                                                            value="{{ $est->cod_matricula }}">
                                                        <a href="#" class="btn btn-danger btn-eliminar"
                                                            onclick="alertaConfirmacion(this);"><i
                                                                class='bx bx-message-square-x'></i></a>
                                                    </form>
                                                </td>
                                            @endif

                                        </tr>
                                        @php
                                            $cont++;
                                        @endphp
                                    @endforeach
                                    <input type="hidden" name="saveAsesor" id="saveAsesor">
                                    <input type="hidden" id="cantidadEstudiantes" value="{{ count($estudiantes) }}">
                                </tbody>
                            </table>
                            @if (!empty($estudiantes))
                                {{ $estudiantes->appends(request()->input())->links() }}
                            @endif

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('datos') == 'ok')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Alumno editado correctamente',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    @elseif (session('datos') == 'oknot')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error al editar alumno',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    @elseif (session('datos') == 'okDelete')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Alumno eliminado correctamente',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    @elseif (session('datos') == 'okNotDelete')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error al eliminar el alumno',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    @endif
    <script type="text/javascript">

        function editarAlumno(formulario, contador) {
            formulario.closest('#form-alumno' + contador).submit();
        }

        function alertaConfirmacion(form) {
            Swal.fire({
                title: 'Estas seguro?',
                text: "No podras revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminar!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.closest('#formAlumnoDelete').submit();
                }
            })
        }

        function saveStateSemestre(form){
            const semestreSelect = document.getElementById("filtrar_semestre");
            const selectedSemestre = semestreSelect.options[semestreSelect.selectedIndex];
            document.getElementById("semestre").value = selectedSemestre.value;
            form.closest("#listAlumno").submit();
        }
    </script>
@endsection
