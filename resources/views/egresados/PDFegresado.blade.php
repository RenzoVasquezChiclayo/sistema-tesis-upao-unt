<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        div{
            font-weight: bold;
            font-size: 14px;
        }
        .titulo{
            font-family: "Time New Roman";
            text-align: center;
            font-size: 18px;
        }
        .titulo2{
            font-family: "Time New Roman";
            text-align: center;
            font-size: 18px;
            font-style: italic;
            margin-bottom: 1px;
        }
        .titulo3{
            font-family: "Time New Roman";
            text-align: center;
            font-size: 20px;
            margin-top: 10px;
        }
        .izquierda{
            float: left;
            width: 200px;
            text-align: right;
            margin: 2px 10px;
            display: inline;
        }
        p{
            font-size: 14;
            margin: 20px 10px;

        }
        .imgLogo{
            height: 70px;
            width: 130px;
            float: left;
        }
        .imgFirma{
            height: 70px;
            width: 130px;
            float: right;
        }
    </style>
</head>
<body>
        <img class="imgLogo" src="./img/logo-unt.png" alt="">
        <div class="titulo">ESCUELA PROFESIONAL DE CONTABILIDAD Y FINANZAS</div>
        <div class="titulo">Formato de Titulo Profesional</div>
        <div class="titulo">DIRECCION DE REGISTRO TECNICO       F-003-B</div>
        <div class="titulo2">UNIDAD DE GRADOS Y TITULOS</div>
        <div class="titulo3">TITULO PROFESIONAL DE: </div>
        <p align="center">{{$ultEgresado[0]->tit_profesional}}</p>
        <div class="izquierda">APELLIDOS Y NOMBRES: </div><p>{{$ultEgresado[0]->apellidos ." ". $ultEgresado[0]->nombres}}</p>
        <div class="izquierda">NUMERO DE MATRICULA: </div><p>{{$ultEgresado[0]->cod_matricula}}</p>
        <div class="izquierda">DNI: </div><p>{{$ultEgresado[0]->dni}}</p>
        <div class="izquierda">FECHA DE NACIMIENTO: </div><p>{{$ultEgresado[0]->fecha_nacimiento}}</p>
        <div class="izquierda">FACULTAD DE: </div><p>{{$ultEgresado[0]->facultad}}</p>
        <div class="izquierda">ESCUELA PROFESIONAL DE: </div><p>{{$ultEgresado[0]->escuela}}</p>
        <div class="izquierda">SEDE: </div><p>{{$ultEgresado[0]->sede}}</p>
        <div class="izquierda">UNIDAD DE 2DA ESPECIALIDAD EN: </div><p>{{$ultEgresado[0]->sgda_especialidad}}</p>
        <div style="float: left; width: 300px; margin: 2px 10px; display: inline;">PROGRAMA EXTRAORDINARIO DE FORMACION DOCENTE-SEDE: </div><p>{{$ultEgresado[0]->prog_extraordinario}}</p>
        <div class="izquierda">DOMICILIO: </div><p>{{$ultEgresado[0]->direccion}}</p>
        <div class="izquierda">TELEGONO FIJO: </div><p>{{$ultEgresado[0]->tele_fijo}}</p>
        <div class="izquierda">TELEFONO CELULAR: </div><p>{{$ultEgresado[0]->tele_celular}}</p>
        <div class="izquierda">CORREO ELECTRONICO: </div><p>{{$ultEgresado[0]->correo}}</p>
        <div class="izquierda">MODALIDAD PARA OBTENER TITULO: </div><p>{{$ultEgresado[0]->modalidad_titulo}}</p>
        <div class="izquierda">FECHA DE SUSTENTACION: </div><p>{{$ultEgresado[0]->fecha_sustentacion}}</p>
        <div class="izquierda">FECHA DE COLACION: </div><p>{{$ultEgresado[0]->fecha_colacion}}</p>
        <div class="izquierda">CENTRO DE TRABAJO: </div><p>{{$ultEgresado[0]->centro_labores}}</p>
        <div class="izquierda">PROCEDENCIA DE COLEGIO: </div><p>{{$ultEgresado[0]->colegio}}</p>
        <div class="izquierda">TIPO DE COLEGIO: </div><p>{{$ultEgresado[0]->tipo_colegio}}</p>
        <img class="imgFirma" src="./plantilla/img/firmas/{{$ultEgresado[0]->firmaIMG}}" alt="">
        <p style="text-align: right">Firma del Egresado: </p>


</body>
</html>
