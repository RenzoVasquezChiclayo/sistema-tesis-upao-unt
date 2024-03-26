@extends('plantilla.dashboard')
@section('titulo')
    Agregar Usuario
@endsection
@section('contenido')
    <div class="card-header">
        Agregar Usuario
    </div>
    <div class="card-body">
        <form id="formSaveUsuario" action="{{route('admin.saveUsuario')}}" method="post">
            @csrf
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <label for="">USUARIO</label>
                            <input type="text" class="form-control" name="usuario" id="usuario" required>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <label for="">CONTRASEÑA</label>
                            <input type="password" class="form-control" name="contraseña" id="contraseña" required>
                            <span class="password-toggle" onclick="togglePassword()" style="color: red">Mostrar</span>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <label for="">ROL</label>
                            <select class="form-control" name="rol_user" id="rol_user" required>
                                @foreach ($roles as $rol)
                                    <option value="{{$rol->id}}">{{$rol->descripcion}}</option>
                                @endforeach

                            </select>
                        </div>

                    </div>
                    <div class="row justify-content-center" style="margin-top: 10px">
                        <div class="col-4">
                            <button class="btn btn-success" type="submit">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@section('js')
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
@endsection
