@extends('plantilla.dashboard')
@section('titulo')
    Editar Usuario
@endsection
@section('contenido')
    <div class="card-header">
        Editar Usuario
    </div>
    <div class="card-body">
        <div class="row" style="display: flex; align-items:center;">
            <form action="{{ route('admin.saveEditar') }}" method="POST">
                @csrf
                <div class="row justify-content-around align-items-center">
                    <div class="col-md-3">
                        <label for="cod_matricula">Usuario</label>
                        <input class="form-control" type="text" value="{{ $find_user->name }}" id="txtusuario"
                            name="txtusuario" placeholder="Ingrese nuevo el usuario" required>
                    </div>
                    <input type="hidden" name="auxiduser" value="{{ $find_user->id }}">
                    <div class="col-md-3">
                        <label for="dni">ROL</label>
                        <select class="form-control" name="rol_user" id="rol_user" required>
                            <option value="d-CTesis2022-1" @if ($find_user->rol == 'd-CTesis2022-1') selected @endif>Director
                            </option>
                            <option value="a-CTesis2022-1" @if ($find_user->rol == 'a-CTesis2022-1') selected @endif>Asesor</option>
                            <option value="CTesis2022-1" @if ($find_user->rol == 'CTesis2022-1') selected @endif>Estudiante
                            </option>
                        </select>
                    </div>
                        <div class="col-md-3">
                            <label for="">CONTRASEÑA</label>
                            <input type="password" class="form-control" name="contraseña" id="contraseña" required>
                            <span class="password-toggle" onclick="togglePassword()" style="color: red">Mostrar</span>
                        </div>
                </div>
                <div class="col-12" style="margin-top: 10px;">
                    <button class="btn btn-success" type="submit">Guardar</button>
                    <a href="{{ route('user_information') }}" type="button" class="btn btn-danger">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('js')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        function togglePassword() {
            const passwordInput = document.getElementById('contraseña');
            const passwordToggle = document.querySelector('.password-toggle');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordToggle.textContent = 'Ocultar';
            } else {
                passwordInput.type = 'password';
                passwordToggle.textContent = 'Mostrar';
            }
        }
    </script>
@endsection
