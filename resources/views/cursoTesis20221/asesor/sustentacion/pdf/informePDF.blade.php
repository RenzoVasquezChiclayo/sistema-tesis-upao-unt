<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>

    </style>
</head>
<body>
    <h1>INFORME FINAL</h1>
    <p>Estudiante: {{$informe->nombres.' '.$informe->apellidos}}</p>
    <p>Titulo: {{$informe->titulo}}</p>
    <p>Introduccion: {{$informe->introduccion}}</p>
    <p>Aporte de la investigacion: {{$informe->aporte_investigacion}}</p>
    <p>Metodologia empleada: {{$informe->metodologia_empleada}}</p>
</body>
</html>
