<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .contenedor-imagenes {
            display: flex;
        }

        .contenedor-imagenes img:first-child {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="contenedor-imagenes">
        <img src="./img/logoUNTcaratula.png" alt="UNT" width="100px" height="100px">
        <img src="./plantilla/img/--.jpg" alt="UNT" width="100px" height="100px" align="right">
      </div>

    <h4 style="text-align: right">{{$fecha}}</h4>
    <h1>Reporte de % de Avance del Proyecto de Tesis</h1>
    <table border="1">
        <thead>
            <tr>
                <th height="30" width="250">Codigo</th>
                <th height="30" width="250">Procentaje de Avance</th>
            </tr>

        </thead>
        <tbody>

            @foreach ($datos as $fila)
                <tr style="text-align: center">
                    <td>{{$fila[0]}}</td>
                    <td>{{$fila[1]}} %</td>
                </tr>

            @endforeach

        </tbody>
    </table>
</body>
</html>
