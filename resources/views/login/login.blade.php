<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Inicio de Sesion</title>
    <style type="text/css">
        body{
            background-size: 100% 210%;
            background-repeat:no-repeat;
            background-image: url('/plantilla/img/fondo-unt.jpg');
        }

        .login-form{width:400px;}
        .login-userinput{margin-bottom: 10px;}
        .login-button{
            display: inline-block;
            color : #fff;
            text-decoration: none;
            padding: 15px 35px;
            border: 3px solid #fff;
            border-radius: 10px;
            margin-top:20px;
            background-color: rgba(0, 0, 0, 0);
        }
        .login-button:hover{
            animation: pulsate 1s ease-in-out;
        }
        @keyframes pulsate {
            0%{
                box-shadow: 0 0 25px #5ddcff, 0 0 50px #fff;
            }
        }
        .login-options{margin-bottom:0px;}
        .login-forgot{float: right;}
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
        .reset-boton {
            margin-top: 10px;
            border: 0px;
            outline: none;
            text-decoration: none;
            background-color: transparent;
            border-radius: 10px;
            color: #fff;
        }
        .reset-boton:hover,
        .reset-boton:active {
            background-color: #000;
            color: red;
            }
    </style>
</head>

<body>
    {{--background:black; margin-top:170px; backdrop-filter: blur(10px);--}}
    {{-- @include('login.nav') --}}
    <div class="container login-form box" style="margin-top:150px;">
        <div class="panel panel-default ">
            <div class="panel-body">
                <form action="{{route('login.verificate')}}" method="post">
                    @csrf
                    <div class="login-userinput" align="center" style="padding-top:20px">
                        <img src="" alt="LOGO">
                    </div>
                    <div class="login-userinput">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Usuario" value="{{old('name')}}" autofocus required>
                    </div>
                    <div style="">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Contrasena" required>
                    </div>
                    <div style="text-align: left">
                        <button class="reset-boton" type="button" data-bs-toggle="modal" data-bs-target="#mReset_Password">Olvide mi contraseña</button>
                    </div>

                    <div style="text-align: right; margin-top:10px;margin-bottom:5px;">
                        <label style="color:white;">
                            <input type="checkbox" name="rememberme">
                            Recuerdame
                        </label>
                    </div>
                    @error('message')
                        <p style="color: red">{{$message}}</p>
                    @enderror
                    <div  style="padding-bottom: 20px;">
                        <button class="login-button">Iniciar Sesion</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
    {{-- Aqui va el modal --}}
    <div class="modal" id="mReset_Password">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Correo Electronico</h4>
                    <button type="button" class="btn-close"
                        data-bs-dismiss="modal"></button>
                </div>
                <!-- Modal body -->
                <form action="{{route('correo_reset')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="row" style="padding: 20px">
                            <h5>Verificacion de identidad</h5>
                            <p>Ingrese el correo que tiene registrado en su sistema para que se le envie un link de cambio de contraseña.</p>
                            <div class="row my-2">
                                <input class="form-control" type="text" id="correo_reset" name="correo_reset" required>
                            </div>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-6">
                                <button type="submit" class="btn btn-success">Enviar</button>
                            </div>
                            <div class="col-6">

                                <button type="button" class="btn btn-danger"
                                    data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('datos') == 'ok')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Se envio el correo correctamente',
                showConfirmButton: true,
                timer: 2500
            })
        </script>
    @elseif (session('datos') == 'oknot')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error al enviar el correo',
                showConfirmButton: true,
                timer: 2500
            })
        </script>
    @elseif (session('datos') == 'oknotregister')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Este correo no se encuentra registrado, comunicate con soporte (support@proytesisws.com).',
                showConfirmButton: true,
                timer: 2500
            })
        </script>
    @endif
</html>
