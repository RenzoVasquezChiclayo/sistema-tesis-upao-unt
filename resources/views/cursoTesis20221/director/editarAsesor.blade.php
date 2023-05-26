@extends('plantilla.dashboard')
@section('titulo')
    Editar Asesor
@endsection
@section('contenido')
    <div class="row" style="display: flex; align-items:center; padding-top:15px;">
        <div class="col-10">
            <div class="row border-box">
                <h5>Editar Asesor</h5>
                <form action="{{ route('director.editAsesor') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-6">
                            <label for="cod_docente">Codigo Institucional</label>
                            <input class="form-control" minlength="4" maxlength="4" type="text" id="cod_docente" name="cod_docente"
                                value="{{$asesor[0]->cod_docente}}" readonly>
                        </div>
                        <div class="col-6">
                            <label for="orcid">ORCID</label>
                            <input class="form-control" minlength="19" maxlength="20" type="text" id="orcid" name="orcid"
                                placeholder="Ingrese su codigo ORCID" required>
                        </div>
                    </div>
                    <div class="col-12">
                        <label for="nombres">Nombres</label>
                        <input class="form-control" type="text" id="nombres" name="nombres"
                            value="{{$asesor[0]->nombres}}" required>
                    </div>
                    <div class="col-12">
                        <label for="gradoAcademico">Categoria</label>
                        <select class="form-control" name="gradAcademico" id="gradAcademico" required>
                            <option value="NOMBRADO">NOMBRADO</option>
                            <option value="CONTRATADO">CONTRATADO</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label for="nombres">Direccion</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="direccion" name="direccion" maxlength="30" value="{{$asesor[0]->direccion}}">
                            <span class="input-group-text" id="contador-caracteres">0/30</span>
                        </div>
                    </div>
                    <div class="col-12">
                        <label for="correo">Correo</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="correo" name="correo" value="{{$asesor[0]->correo}}" maxlength="80">
                        </div>
                    </div>
                    <div class="col-12" style="margin-top: 10px;">
                        <button class="btn btn-success" type="submit">Guardar</button>
                        <a href="{{ route('user_information') }}" type="button" class="btn btn-danger">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('datos') == 'oknot')
        <script>
            Swal.fire({
            position: 'center',
            icon: 'error',
            title: 'Error al editar alumno',
            showConfirmButton: false,
            timer: 1200
            })
        </script>
    @endif
    <script type="text/javascript">

        const inputDireccion = document.querySelector('#direccion');
        const contadorCaracteres = document.querySelector('#contador-caracteres');

        inputDireccion.addEventListener('input', () => {
            contadorCaracteres.textContent = `${inputDireccion.value.length}/30`;
        });
    </script>
@endsection
