@extends('plantilla.dashboard')
@section('titulo')
    Agregar Asesor
@endsection
@section('contenido')
    <div class="row" style="display: flex; align-items:center; padding-top:15px;">
        <div class="col-10">
            <div class="row" style="text-align:center;">
                <h3>Registro de Asesores</h3>
            </div>
            <div class="row border-box" style="margin-bottom: 50px;">
                <form action="{{ route('director.importarAsesores') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row justify-content-end">
                        <div class="col-3">
                            <h5>Semestre académico</h5>
                        </div>
                        <div class="col-2">
                            <select class="form-select" name="semestre_academico" id="semestre_academico" onchange="select_semestre();" required>
                                <option value="0">-</option>
                                @foreach ($semestre as $sem)
                                    <option value="{{ $sem->cod_config_ini }}">{{ $sem->year }}_{{ $sem->curso }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <h5>Importar un registro Excel</h5>
                    </div>
                    <div class="row">
                        <div class="col-7">
                            <input class="form-control" type="file" name="importAsesor" id="importAsesor">
                        </div>
                        <div class="col-5">
                            <button class="btn btn-success" type="submit">Importar Registro</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="row border-box">
                <h5>Registrar por asesor</h5>
                <form class="row g-3 needs-validation" action="{{ route('director.addAsesor') }}" method="POST" novalidate>
                    @csrf
                    <input type="hidden" name="semestre_hidden" id="semestre_hidden">
                    <div class="col-6">
                        <label for="cod_docente">Codigo Institucional</label>
                        <input class="form-control" minlength="4" maxlength="4" type="text" id="cod_docente"
                            onkeypress="return (event.charCode >= 48 && event.charCode <= 57)" name="cod_docente"
                            placeholder="Ingrese su codigo de docente" autofocus required>
                    </div>
                    <div class="col-6">
                        <label for="orcid">ORCID</label>
                        <input class="form-control" minlength="19" maxlength="20" type="text" id="orcid"
                            name="orcid" placeholder="Ingrese su codigo ORCID" required>
                    </div>
                    <div class="col-12">
                        <label for="apellidos">Apellidos</label>
                        <input class="form-control" type="text" id="apellidos" name="apellidos"
                            placeholder="Ingrese sus apellidos" required>
                    </div>
                    <div class="col-12">
                        <label for="nombres">Nombres</label>
                        <input class="form-control" type="text" id="nombres" name="nombres"
                            placeholder="Ingrese su nombre" required>
                    </div>
                    <div class="col-12">
                        <label for="gradoAcademico">Categoría</label>
                        <select class="form-control" name="gradAcademico" id="gradAcademico" required>
                            <option value="0">NOMBRADO</option>
                            <option value="1">CONTRATADO</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label for="carrera">Carrera</label>
                        <select class="form-control" name="carrera" id="carrera" required>
                            <option value="0">Contabilidad y Finanzas</option>
                            <option value="1">Administracion</option>
                            <option value="2">Economia</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label for="direccion">Dirección</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="direccion" name="direccion" maxlength="30">
                            <span class="input-group-text" id="contador-caracteres">0/30</span>
                        </div>
                    </div>
                    <div class="col-12">
                        <label for="correo">Correo</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="correo" name="correo" maxlength="80">
                        </div>
                    </div>
                    <div class="col-12" style="margin-top: 10px;">
                        <button class="btn btn-success" type="submit">Registrar</button>
                        <a href="{{ route('user_information') }}" type="button" class="btn btn-danger">Cancelar</a>
                    </div>
                </form>
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
                title: 'Asesor agregado correctamente',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @elseif (session('datos') == 'oknot')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error al agregar el asesor',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @endif
    <script type="text/javascript">
        function select_semestre() {
            semestre = document.getElementById('semestre_academico');
            selected = semestre.options[semestre.selectedIndex].text;
            document.getElementById('semestre_hidden').value = selected;
        }
        const inputDireccion = document.querySelector('#direccion');
        const contadorCaracteres = document.querySelector('#contador-caracteres');

        inputDireccion.addEventListener('input', () => {
            contadorCaracteres.textContent = `${inputDireccion.value.length}/30`;
        });
    </script>
@endsection
