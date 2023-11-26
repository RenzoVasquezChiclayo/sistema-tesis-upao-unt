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
            background-image: url('/plantilla/img/fondo-upao.jpg');
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
                        <img src="../login/img/logo-upao.png" alt="">
                    </div>
                    <div class="login-userinput">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Usuario" value="{{old('name')}}" autofocus required>
                    </div>
                    <div style="">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Contrasena" required>
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


</body>
<script type="text/javascript">

</script>
</html>
