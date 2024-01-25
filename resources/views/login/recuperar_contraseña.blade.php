<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Recuperar Contraseña</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        body{
            background-size: 100% 210%;
            background-repeat:no-repeat;
            background-image: url('/plantilla/img/fondo-unt.jpg');
        }
        .box{
            background-color: rgba(0, 0, 0, 0.6);
            border-radius: 5px;
            font-family: sans-serif;
            text-align: center;
            line-height: 1;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: black solid 1px;
        }
        .reset-form{width:400px;}

        h2, p{
            color: white;
        }
        hr{
            background-color: white;
            height: 5px;
        }
        button{
            margin-bottom: 10px;
        }
        span{
            color: white;

        }
    </style>
</head>
<body>
    <div class="container box reset-form" style="margin-top:150px;">
        <div class="row justify-content-center">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-12">
                                <h2>Recuperar Contraseña</h2>
                            </div>
                        </div>
                        <hr>
                        <form action="{{route('guardar_reset_contra')}}" method="post">
                            @csrf
                            <input type="hidden" name="name_usuario" id="name_usuario" value="{{$name_usuario}}">
                            <input type="hidden" name="auxcodigo" id="auxcodigo" value="{{$codigo}}">
                            <div class="row">
                                <div class="col-12">
                                    <p>Hola {{$nombres}}, aqui podras crear tu nueva contraseña. Después de crear tu contraseña, permanecerás conectado. </p>
                                    <br>
                                    <input class="form-control" type="password" name="nueva_contraseña" id="nueva_contraseña" placeholder="Nueva contraseña" required>
                                    <span class="password-toggle" onclick="togglePassword()">Mostrar</span>
                                </div>
                            </div>
                            <br>
                            <div class="row justify-content-center">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-success">Confirmar</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>

            </div>

        </div>
    </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
<script>
    function togglePassword() {
            const passwordInput = document.getElementById('nueva_contraseña');
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
@if (session('datos') == 'oknotresetcontra')
            <script>
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Error al actualizar su contraseña',
                    showConfirmButton: false,
                    timer: 1200
                })
    </script>
@endif
</html>
