<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        a{
            padding: 10px;
            background-color: black;
            color: white !important;
            border-radius: 7px;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <h1>TU CONTRASEÑA</h1>
    <p>Hola {{$nombres}},</p>
    <p>¿quieres cambiar la contraseña vinculada a esta cuenta? Si es así, confirma la solicitud.</p>
    <br>
    <p>Si no tienes intención de cambiar tu contraseña, ignora este email. No te preocupes. Tu cuenta está segura.</p>
    <br>
    <a href="{{$url}}" >CONFIRMAR</a>
</body>
</html>
