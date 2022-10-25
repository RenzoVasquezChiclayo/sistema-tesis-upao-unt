@extends('plantilla.dashboard')
@section('titulo')
    Registro del egresado
@endsection
@section('css')
<style type="text/css">
    .ajusteContent{
        display:inline-block;
        margin-left:auto;
        margin-right:auto;
        text-align:left;
    }

    .campos > div >.row {
        padding-bottom:15px;
    }
</style>
@endsection
@section('contenido')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<body>
    <div class="container-fluid" style="background-color:rgb(212, 212, 212)">
        <div class="row">
            <form name="formEgresado" id="formEgresado" action="{{route('guardarEgresado')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row d-flex justify-content-md-center" style="align-items: center; text-align:center;">
                    <div class="col-11">
                        <div class="row">
                            <div class="col-7 col-md-4">
                                <img class="img-fluid" src="/img/logo-unt.png" alt="Logo de la UNT" style="max-width: 50%;">
                            </div>
                        </div>

                        <div class="row" style="text-align:center">
                            <div class="col-11">
                                <h2>ESCUELA PROFESIONAL DE CONTABILIDAD Y FINANZAS</h1>
                            </div>
                            <div class="col-11">
                                <h3>Formato de Titulo Profesional</h3>
                            </div>
                            <div class="row" style="text-align:center; padding-bottom:50px;">
                                <div class="col-11">
                                    <h2>DIRECCION DE REGISTRO TECNICO</h2>
                                    <h2>UNIDAD DE GRADOS Y TITULOS</h2>
                                </div>
                                <div class="col-1">
                                    <div class="row" style="display:flex; align-items:center; justify-content:center;margin-top:25%;">
                                        <div class="col-12" style="padding:0;">
                                            <p>F-OO3-B</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="display:flex; align-items:right; justify-content:right; padding-bottom: 20px;">
                            <div class="col-4 col-md-3" style="border: 0.5px solid gray;">
                                <div class="row" style="text-align: center;">
                                    <h6>Foto del Egresado</h6>
                                </div>
                                <div class="row">
                                    <div class="col-12" id="preview-img" name="preview-img" style="text-align:center;">
                                        <img class="img-fluid" src="
                                        @if (sizeof($formatoTitulo)!=0)
                                            /plantilla/img/{{$formatoTitulo[0]->referencia}}
                                        @endif" alt="Foto del egresado" style="height: 150px;" id="img-load">
                                    </div>
                                    <div class="col-12">
                                        <input class="form-control form-control-sm" name="fileImgEgresado" id="fileImgEgresado" type="file"
                                        @if (sizeof($formatoTitulo)!=0)
                                            hidden
                                        @else
                                            required
                                        @endif
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="padding-bottom: 15px;">
                            <div class="col">
                                <h4>TITULO PROFESIONAL DE:</h4>
                                <input class="form-control" name="txtTituloProfe" id="txtTituloProfe" type="text" value="@if (sizeof($formatoTitulo)!=0){{$formatoTitulo[0]->tit_profesional}}@endif" placeholder="Ingrese su titulo profesional"
                                @if (sizeof($formatoTitulo)!=0)
                                    readonly
                                @else
                                    required
                                @endif
                                 >
                            </div>
                        </div>
                        <div class="row campos">
                            <div class="col-12 col-md-6">
                                <div class="row">
                                    <div class="col-6 col-md-4">
                                         <h6 style="margin-top:8px;">APELLIDOS:</h6>
                                     </div>
                                     <div class="col-6 col-md-8">
                                         <input class="form-control" name="txtApellidos" id="txtApellidos" type="text" value="{{$egresado->apellidos}}" placeholder="Ingrese sus apellidos." readonly>
                                     </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="row">
                                    <div class="col-6 col-md-4">
                                        <h6 style="margin-top:8px;">NOMBRES:</h6>
                                    </div>
                                    <div class="col-6 col-md-8">
                                        <input class="form-control" name="txtNombres" id="txtNombres" type="text" value="{{$egresado->nombres}}" placeholder="Ingrese sus nombres." readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row campos">
                            <div class="col-12 col-md-6">
                                <div class="row">
                                    <div class="col-6 col-md-4">
                                        <h6 style="margin-top:8px;">NUMERO DE MATRICULA:</h6>
                                    </div>
                                    <div class="col-6 col-md-8">
                                        <input class="form-control" name="txtNumMatricula" id="txtNumMatricula" type="text" value="{{$egresado->cod_matricula}}" maxlength="10" placeholder="Ingrese su numero de matricula" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="row">
                                    <div class="col-6 col-md-4">
                                        <h6 style="margin-top:8px;">DNI:</h6>
                                    </div>
                                    <div class="col-6 col-md-8">
                                        <input class="form-control" name="txtDNI" id="txtDNI" type="text" value="{{$egresado->dni}}" maxlength="8" placeholder="Ingrese su DNI" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row campos">
                            <div class="col-12 col-md-6">
                                <div class="row">
                                    <div class="col-6 col-md-4">
                                        <h6 style="margin-top:8px;">FECHA DE NACIMIENTO:</h6>
                                    </div>
                                    <div class="col-6 col-md-8">
                                        <input class="form-control" name="txtfNacimiento" id="txtfNacimiento" type="date" value=""
                                        placeholder="Ingrese su Fecha de Nacimiento"
                                        @if ($formatoTitulo->count()>0)
                                            readonly
                                        @endif required>
                                        <input type="hidden" id="existFNacimiento" value="@if ($formatoTitulo->count()>0){{$formatoTitulo[0]->fecha_nacimiento}}@endif">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row campos">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-4 col-md-2">
                                        <h6 style="margin-top:10px;">FACULTAD DE: </h6>
                                    </div>
                                    <div class="col-8 col-md-10">
                                        <select name="cboFacultad" id="cboFacultad" class="form-select" onchange="deleteFirst(this);"
                                        @if (sizeof($formatoTitulo)!=0)
                                            disabled
                                        @else
                                            required
                                        @endif
                                        >
                                            <option id="xcboFacultad" selected>
                                                @if (sizeof($formatoTitulo)!=0)
                                                    {{$formatoTitulo[0]->facNombre}}
                                                @else
                                                    -
                                                @endif
                                                </option>
                                            @foreach ($facultad as $fac)
                                                <option value="{{$fac->cod_facultad}}">{{$fac->nombre}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row campos">
                            <div class="col-12 col-md-6">
                                <div class="row">
                                    <div class="col-6 col-md-4">
                                        <h6 style="margin-top:10px;">ESCUELA PROFESIONAL:</h6>
                                    </div>
                                    <div class="col-6 col-md-8">
                                        <select name="cboEscuela" id="cboEscuela" class="form-select" onchange="deleteFirst(this);"
                                        @if (sizeof($formatoTitulo)!=0)
                                            disabled
                                        @else
                                            required
                                        @endif
                                        >
                                            <option id="xcboEscuela" selected>
                                                @if (sizeof($formatoTitulo)!=0)
                                                    {{$formatoTitulo[0]->escNombre}}
                                                @else
                                                    -
                                                @endif
                                            </option>
                                            @foreach ($escuela as $escu)
                                                <option value="{{$escu->cod_escuela}}">{{$escu->nombre}}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="row">
                                    <div class="col-6 col-md-4">
                                        <h6 style="margin-top:10px;">SEDE:</h6>
                                    </div>
                                    <div class="col-6 col-md-8">
                                        <select name="cboSede" id="cboSede" class="form-select" onchange="deleteFirst(this);"
                                        @if (sizeof($formatoTitulo)!=0)
                                            disabled
                                        @else
                                            required
                                        @endif
                                        >
                                            <option id="xcboSede" selected required>
                                                @if (sizeof($formatoTitulo)!=0)
                                                    {{$formatoTitulo[0]->sedeNombre}}
                                                @else
                                                    -
                                                @endif
                                            </option>
                                            @foreach ($sede as $sede)
                                                <option value="{{$sede->cod_sede}}">{{$sede->nombre}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row campos">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-6 col-md-3">
                                        <h6>UNIDAD DE 2DA ESPECIALIDAD EN: </h6>
                                    </div>
                                    <div class="col-6 col-md-9">
                                        <input class="form-control" name="txt2daEsp" id="txt2daEsp" type="text" value="@if (sizeof($formatoTitulo)!=0){{$formatoTitulo[0]->sgda_especialidad}}@endif"
                                        placeholder="Ingrese su 2da especialidad"
                                        @if (sizeof($formatoTitulo)!=0)
                                            readonly
                                        @endif
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row campos">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-6 col-md-4">
                                        <h6>PROGRAMA EXTRAORDINARIO DE FORMACION DOCENTE-SEDE: </h6>
                                    </div>
                                    <div class="col-6 col-md-8">
                                        <input class="form-control" name="txtProgFormacion" id="txtProgFormacion" type="text" value="@if (sizeof($formatoTitulo)!=0){{$formatoTitulo[0]->prog_extraordinario}}@endif"
                                        placeholder="Ingrese su programa extraordinario"
                                        @if (sizeof($formatoTitulo)!=0)
                                            readonly
                                        @endif
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row campos">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-6 col-md-2">
                                        <h6 style="margin-top:10px;">DOMICILIO:</h6>
                                    </div>
                                    <div class="col-6 col-md-10">
                                        <input class="form-control" name="txtDireccion" id="txtDireccion" type="text" value="@if (sizeof($formatoTitulo)!=0){{$formatoTitulo[0]->direccion}}@endif"
                                        placeholder="Ingrese su direccion" required
                                        @if (sizeof($formatoTitulo)!=0)
                                            readonly
                                        @else
                                            required
                                        @endif
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row campos">
                            <div class="col-12 col-md-6">
                                <div class="row">
                                    <div class="col-6 col-md-4">
                                        <h6 style="margin-top:10px;">TELEFONO FIJO:</h6>
                                    </div>
                                    <div class="col-6 col-md-8">
                                        <input class="form-control" name="txtTelefonoFijo" id="txtTelefonoFijo" type="text" value="@if (sizeof($formatoTitulo)!=0){{$formatoTitulo[0]->tele_fijo}}@endif"
                                        maxlength="8" placeholder="Ingrese su telefono fijo"
                                        @if (sizeof($formatoTitulo)!=0)
                                            readonly
                                        @endif
                                        >
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="row">
                                    <div class="col-6 col-md-4">
                                        <h6 style="margin-top:10px;">TELEFONO CELULAR:</h6>
                                    </div>
                                    <div class="col-6 col-md-8">
                                        <input class="form-control" name="txtTelefonoCelular" id="txtTelefonoCelular" type="text" value="@if (sizeof($formatoTitulo)!=0){{$formatoTitulo[0]->tele_celular}}@endif"
                                        maxlength="12" placeholder="Ingrese su telefono celular"
                                        @if (sizeof($formatoTitulo)!=0)
                                            readonly
                                        @else
                                            required
                                        @endif
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row campos">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-6 col-md-2">
                                        <h6 style="margin-top:10px;">CORREO ELECTRONICO:</h6>
                                    </div>
                                    <div class="col-6 col-md-10">
                                        <input class="form-control" name="txtCorreo" id="txtCorreo" type="email" value="@if (sizeof($formatoTitulo)!=0){{$formatoTitulo[0]->correo}}@endif"
                                        placeholder="Ingrese su correo @"
                                        @if (sizeof($formatoTitulo)!=0)
                                            readonly
                                        @else
                                            required
                                        @endif
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row campos">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-6 col-md-3">
                                        <h6 style="margin-top:10px;">MODALIDAD PARA OBTENER TITULO:</h6>
                                    </div>
                                    <div class="col-6 col-md-9">
                                        <input class="form-control" name="txtModalidadTit" id="txtModalidadTit" type="text" value="@if (sizeof($formatoTitulo)!=0){{$formatoTitulo[0]->modalidad_titulo}}@endif"
                                        placeholder="Ingrese la modalidad"
                                        @if (sizeof($formatoTitulo)!=0)
                                            readonly
                                        @else
                                            required
                                        @endif
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row campos">
                            <div class="col-12 col-md-6">
                                <div class="row">
                                    <div class="col-6 col-md-4">
                                        <h6 style="margin-top:10px;">FECHA DE SUSTENTACION:</h6>
                                    </div>
                                    <div class="col-6 col-md-8">
                                        <input class="form-control" name="txtFechaSustentacion" id="txtFechaSustentacion" type="date" value="@if (sizeof($formatoTitulo)!=0){{$formatoTitulo[0]->fecha_sustentacion}}@endif"
                                        @if (sizeof($formatoTitulo)!=0)
                                            readonly
                                        @endif
                                        >
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="row">
                                    <div class="col-6 col-md-4" >
                                        <h6 style="margin-top:10px;">FECHA DE COLACION:</h6>
                                    </div>
                                    <div class="col-6 col-md-8">
                                        <input class="form-control" name="txtFechaColacion" id="txtFechaColacion" type="date" value="@if (sizeof($formatoTitulo)!=0){{$formatoTitulo[0]->fecha_colacion}}@endif"
                                        @if (sizeof($formatoTitulo)!=0)
                                            readonly
                                        @endif
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row campos">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-6 col-md-2">
                                        <h6 style="margin-top:10px;">CENTRO DE TRABAJO:</h6>
                                    </div>
                                    <div class="col-6 col-md-10">
                                        <input class="form-control" name="txtCentroTrabajo" id="txtCentroTrabajo" type="text" value="@if (sizeof($formatoTitulo)!=0){{$formatoTitulo[0]->centro_labores}}@endif"
                                        placeholder="Ingrese su centro de trabajo"
                                        @if (sizeof($formatoTitulo)!=0)
                                            readonly
                                        @endif
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row campos">
                            <div class="col-12 col-md-8">
                                <div class="row">
                                    <div class="col-6 col-md-3">
                                        <h6 style="margin-top:10px;">PROCEDENCIA DE COLEGIO:</h6>
                                    </div>
                                    <div class="col-6 col-md-9">
                                        <input class="form-control" name="txtColegio" id="txtColegio" type="text" value="@if (sizeof($formatoTitulo)!=0){{$formatoTitulo[0]->colegio}}@endif"
                                        placeholder="Ingrese su Colegio"
                                        @if (sizeof($formatoTitulo)!=0)
                                            readonly
                                        @else
                                            required
                                        @endif
                                        >
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="row">
                                    <div class="col-7 col-md-12" style="text-align: center;">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="rubroColegio" id="rbNacional" value="Nacional" style="margin-top:5px;"
                                            @if ($formatoTitulo->count()>0 && $formatoTitulo[0]->tipo_colegio=='Nacional')
                                                checked
                                            @endif
                                            @if($formatoTitulo->count()>0)
                                                disabled
                                            @endif
                                            >
                                            <label class="form-check-label" for="rbNacional">Nacional</label>
                                          </div>
                                          <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="rubroColegio" id="rbParticular" value="Particular" style="margin-top:5px;"
                                            @if ($formatoTitulo->count()>0 && $formatoTitulo[0]->tipo_colegio=='Particular')
                                                checked
                                            @endif
                                            @if($formatoTitulo->count()>0)
                                                disabled
                                            @endif
                                            >
                                            <label class="form-check-label" for="rbParticular">Particular</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row campos">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-6 col-md-4">
                                        <h6 style="margin-top:10px;">LINEA DE INVESTIGACION:</h6>
                                    </div>
                                    <div class="col-6 col-md-8">
                                        <select name="cboTInvestigacion" id="cboTInvestigacion" class="form-select" onchange="deleteFirst(this);"
                                        @if (sizeof($formatoTitulo)!=0)
                                            disabled
                                        @else
                                            required
                                        @endif
                                        >
                                            <option id="xcboTInvestigacion" selected>
                                                @if (sizeof($formatoTitulo)!=0)
                                                    {{$formatoTitulo[0]->descripcionTI}}
                                                @else
                                                    -
                                                @endif
                                            </option>
                                            @foreach ($tiposinvestigacion as $tipo)
                                                <option value="{{$tipo->cod_tinvestigacion}}">{{$tipo->descripcion}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if (sizeof($formatoTitulo)!=0)
                            @if ($validar!=true)
                                <div class="row campus">
                                    <div class="col-12 col-md-6">
                                        <div class="row">
                                            <div class="col-2">
                                                <h6 style="margin-top:10px;">ASESOR:</h6>
                                            </div>
                                        </div>
                                    </div>
                                        <div class="row border-box" id="">
                                            <div class="row" style="margin-bottom:8px">
                                                <div class="col-6">
                                                    <label for="txtNombreAsesor" class="form-label">Apellidos y Nombres</label>
                                                    <input class="form-control" name="txtNombreAsesor" id="txtNombreAsesor" type="text" value="{{$formatoTituloAsesor[0]->nombres}}" readonly>
                                                </div>
                                                <div class="col-6">
                                                    <label for="cboGrAcademicoAsesor" class="form-label">Grado Academico</label>
                                                    <input class="form-control" name="txtGrAcademicoAsesor" id="txtGrAcademicoAsesor" type="text" value="{{$formatoTituloAsesor[0]->grado_academico}}" readonly>
                                                </div>
                                            </div>
                                            <div class="row" style="margin-bottom:8px">
                                                <div class="col-6">
                                                    <label for="txtTProfesional" class="form-label">Titulo Profesional</label>
                                                    <input class="form-control" name="txtTProfesional" id="txtTProfesional" type="text" value="{{$formatoTituloAsesor[0]->titulo_profesional}}" readonly>
                                                </div>
                                                <div class="col-6">
                                                    <label for="txtDireccionAsesor" class="form-label">Dirección laboral y/o domiciliaria</label>
                                                    <input class="form-control" name="txtDireccionAsesor" id="txtDireccionAsesor" type="text" value="{{$formatoTituloAsesor[0]->direccion}}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            @endif
                        @endif


                        <div class="row">
                                <div class="col-4">
                                    @if (sizeof($formatoTitulo)!=0)
                                        <input type="button" class="btn btn-success" id="verEgresadoFUT" value="ver FUT" data-toggle="modal" data-target="#mFUT"  onclick="verFileFUT();">
                                    @else
                                        <h6 style="margin-top:10px;">FUT:</h6>
                                        <input class="form-control form-control-sm" name="fileFUT" id="fileFUT" type="file" onchange="validarFileFUT();" required>
                                    @endif
                                    <input type="hidden" name="" id="hiddenFUT" value="
                                    @if (sizeof($formatoTitulo)!=0)
                                        {{ asset('plantilla/pdf-egresado/'.$formatoTitulo[0]->fut)}}
                                    @endif
                                    ">
                                    {{-- Modal para ver el FUT --}}
                                    <div class="modal" id="mFUT">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                            <div class="modal-content" style="width: 700px">

                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <button type="button" class="btn-close" data-dismiss="modal"></button>
                                                </div>

                                                <!-- Modal body -->
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div id="visorArchivoFUT">

                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Modal footer -->
                                                <div class="modal-footer">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    @if (sizeof($formatoTitulo)!=0)
                                        <input type="button" class="btn btn-success" id="verEgresadoConstancia" value="ver Contancia de No Duplicidad" data-toggle="modal" data-target="#mConstancia" onclick="verFileConstancia();">
                                    @else
                                        <h6 style="margin-top:10px;">CONSTANCIA DE NO DUPLICIDAD:</h6>
                                        <input class="form-control form-control-sm" name="fileConstancia" id="fileConstancia" type="file" onchange="validarFileConstancia();" required>
                                    @endif
                                    <input type="hidden" name="" id="hiddenConstancia" value="
                                    @if (sizeof($formatoTitulo)!=0)
                                        {{ asset('plantilla/pdf-egresado/'.$formatoTitulo[0]->constancia)}}
                                    @endif
                                    ">
                                    {{-- Modal para ver la Constancia --}}
                                    <div class="modal" id="mConstancia">
                                        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                                            <div class="modal-content" style="width: 700px">

                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <button type="button" class="btn-close" data-dismiss="modal"></button>
                                                </div>

                                                <!-- Modal body -->
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div id="visorArchivoConstancia">

                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Modal footer -->
                                                <div class="modal-footer">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    @if (sizeof($formatoTitulo)!=0)
                                        <input type="button" class="btn btn-success" id="verEgresadoRecibo" value="ver Recibo de Pago" data-toggle="modal" data-target="#mRecibo" onclick="verFileRecibo();">
                                    @else
                                        <h6 style="margin-top:10px;">RECIBO DE PAGO:</h6>
                                        <input class="form-control form-control-sm" name="fileReciboPago" id="fileReciboPago" type="file" onchange="validarFileRecibo();" required>
                                    @endif
                                    <input type="hidden" name="" id="hiddenRecibo" value="
                                    @if (sizeof($formatoTitulo)!=0)
                                        {{ asset('plantilla/pdf-egresado/'.$formatoTitulo[0]->recibo)}}
                                    @endif
                                    ">
                                    {{-- Modal para ver la Constancia --}}
                                    <div class="modal" id="mRecibo">
                                        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                                            <div class="modal-content" style="width: 700px">

                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <button type="button" class="btn-close" data-dismiss="modal"></button>
                                                </div>

                                                <!-- Modal body -->
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div id="visorArchivoRecibo">

                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Modal footer -->
                                                <div class="modal-footer">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <br>
                        <div class="row" style="display:flex; align-items:right; justify-content:right; padding-bottom: 20px;">
                            <div class="col-4 col-md-3" style="border: 0.5px solid gray;">
                                <div class="row" style="text-align: center;">
                                    <h6>Firma del Egresado</h6>
                                </div>
                                <div class="row">
                                    <div class="col-12" id="firma-img" name="firma-img" style="text-align:center;">
                                        <img class="img-fluid" src="
                                        @if (sizeof($formatoTitulo)!=0)
                                            /plantilla/img/firmas/{{$formatoTitulo[0]->firmaIMG}}
                                        @endif"
                                        alt="Firma del egresado" style="height: 150px;" id="img-load-firma">
                                    </div>
                                    <div class="col-12">
                                        <input class="form-control form-control-sm" name="fileFirmaEgresado" id="fileFirmaEgresado" type="file"
                                        @if (sizeof($formatoTitulo)!=0)
                                            hidden
                                        @else
                                            required
                                        @endif
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row " style="padding-top: 10px; padding-left:80px; padding-bottom:20px;">
                        <div class="col-6" @if (sizeof($formatoTitulo)>0) hidden @endif>
                            <div class="row" style="text-align:left; ">
                                <div class="col-12">
                                    <input class="btn btn-success" type="button" value="Guardar registro" onclick="guardarInfo();" style="margin-right:20px;">
                                    <a href="{{route('user_information')}}" type="button" class="btn btn-danger">Cancelar</a>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </form>
            <div class="row">
                @if($formatoTitulo->count()>0)
                    <div class="col-6" style="margin:20px;">
                        <div class="row" style="text-align: left;">
                                <div class="col-10" style="margin-left:40px;">
                                    <form name="formatoDownload" id="formatoDownload" action="{{route('formato.descarga')}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="cod_formato" id="cod_formato" value="{{$formatoTitulo[0]->codigo}}">
                                        <input class="btn btn-success" type="button" onclick="enviar_formulario();" value="Descargar formato">
                                    </form>
                                </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

</body>
{{-- Modal para confirmar guardado --}}
<div class="modal" tabindex="-1" id="mConfirmar">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>CONFIRMAR</p>
        </div>
        <div class="modal-footer">

            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary">Save changes</button>

        </div>
      </div>
    </div>
  </div>
<script type="text/javascript">
    window.onload = function() {
          validateCampos();
        };

    function validateCampos(){
        const existFecha = document.getElementById('existFNacimiento').value;

        if(existFecha!=""){
            document.getElementById('txtfNacimiento').value = existFecha;
        }
    }
    function enviar_formulario(){
        document.formatoDownload.submit();

    }

    document.getElementById('fileImgEgresado').onchange = function (e) {

        let extPermitidas = /(.jpg|.png)$/i;
        if(!extPermitidas.exec(document.getElementById('fileImgEgresado').value)){
            alert('El archivo debe ser JPG o PNG');
            document.getElementById('fileImgEgresado').value = '';
        }else{
            let reader = new FileReader();
            let axus = false;
            reader.readAsDataURL(e.target.files[0]);

            reader.onload = function(){
                let preview = document.getElementById('preview-img'),
                    image = document.getElementById('img-load');
                image.src = reader.result;
                //image.width="200";
            // image.height = "200";
                //preview.innerHTML='';
                //preview.append(image);
            };
        }
    };

    document.getElementById('fileFirmaEgresado').onchange = function (e) {

        let extPermitidas = /(.jpg|.png)$/i;
        if(!extPermitidas.exec(document.getElementById('fileFirmaEgresado').value)){
            alert('El archivo debe ser JPG o PNG');
            document.getElementById('fileFirmaEgresado').value = '';
        }else{
            let reader = new FileReader();
            let axus = false;
            reader.readAsDataURL(e.target.files[0]);

            reader.onload = function(){
                let preview = document.getElementById('firma-img'),
                    image = document.getElementById('img-load-firma');
                image.src = reader.result;
                //image.width="200";
            // image.height = "200";
                //preview.innerHTML='';
                //preview.append(image);
            };
        }



    };

    // function deleteFirst(element){
    //         document.getElementById('x'+element.id).remove();
    // }

    function guardarInfo(){
        publico = document.getElementById('rbNacional').checked;
        particular = document.getElementById('rbParticular').checked;

        let input = $('#fileImgEgresado');
        let input2 = $('#fileFirmaEgresado');
        let input3 = $('#fileFUT');
        let input4 = $('#fileConstancia');
        let input5 = $('#fileReciboPago');
        if( input.val() != "" ){
            if (input3.val() != "") {
                if (input4.val() != "") {
                    if (input5.val() != "") {
                        if (input2.val() != "") {
                            if(validaForm() != false){
                                document.formEgresado.submit();
                            }else{
                                alert('Falta llenar algun(os) datos.')
                            }
                        }else{
                            alert("Falta cargar su firma.");
                        }
                    }else{
                        alert("Falta cargar el Recibo de Pago.");
                    }
                } else {
                    alert("Falta cargar la Contancia de No Duplicidad.");
                }
            } else {
                alert("Falta cargar el FUT.");
            }

        }else{
            alert("Falta cargar una imagen.");
        }
    }

    function validarFileFUT(){

        fileFUT = document.getElementById('fileFUT').value;

        extPermitidas = /(.pdf)$/i;
        if (!extPermitidas.exec(fileFUT)) {
            alert("El archivo debe ser PDF");
            document.getElementById('fileFUT').value = '';
        }

    }
    function verFileFUT(){
        rutaFUT = document.getElementById('hiddenFUT').value;
        var visor = new FileReader();
        document.getElementById('visorArchivoFUT').innerHTML ='<embed src="'+rutaFUT+'" width = "600" height = "600">';
    }
    function validarFileConstancia(){
        fileConstancia = document.getElementById('fileConstancia').value;
        extPermitidas = /(.pdf)$/i;
        if (!extPermitidas.exec(fileConstancia)) {
            alert("El archivo debe ser PDF");
            document.getElementById('fileConstancia').value = '';
        }
    }
    function verFileConstancia(){
        rutaConstancia = document.getElementById('hiddenConstancia').value;
        var visor = new FileReader();
        document.getElementById('visorArchivoConstancia').innerHTML ='<embed src="'+rutaConstancia+'" width = "600" height = "600">';
    }
    function validarFileRecibo(){
        fileReciboPago = document.getElementById('fileReciboPago').value;
        extPermitidas = /(.pdf)$/i;
        if (!extPermitidas.exec(fileReciboPago))  {
            alert("El archivo debe ser PDF");
            document.getElementById('fileReciboPago').value = '';
        }
    }
    function verFileRecibo(){
        rutaRecibo = document.getElementById('hiddenRecibo').value;
        var visor = new FileReader();
        document.getElementById('visorArchivoRecibo').innerHTML ='<embed src="'+rutaRecibo+'" width = "600" height = "600">';
    }

    function validaForm(){
        let val = 0;


        titulo = document.getElementById('txtTituloProfe').value;
        fNacimiento = document.getElementById('txtfNacimiento').value;
        facultad = document.getElementById('cboFacultad').selectedIndex;
        escuela = document.getElementById('cboEscuela').selectedIndex;
        sede = document.getElementById('cboSede').selectedIndex;
        //segundaEsp = document.getElementById('txt2daEsp').value;
        progFormacion = document.getElementById('txtProgFormacion').value;
        direccion = document.getElementById('txtDireccion').value;
        //telfijo = document.getElementById('txtTelefonoFijo').value;
        telcelular = document.getElementById('txtTelefonoCelular').value;
        correo = document.getElementById('txtCorreo').value;
        modalidadtit = document.getElementById('txtModalidadTit').value;
        //fSustentacion = document.getElementById('txtFechaSustentacion').value;
        //fColacion = document.getElementById('txtFechaColacion').value;
        //centrotrabajo = document.getElementById('txtCentroTrabajo').value;
        colegio = document.getElementById('txtColegio').value;

        linvestigacion = document.getElementById('cboTInvestigacion').selectedIndex;
        nacional = document.getElementById('rbNacional').checked;
        particular = document.getElementById('rbParticular').checked;

        if(nacional != particular){
            val = 1;
        }
        if(titulo =="" || fNacimiento=="" || facultad==0 || escuela==0 || sede ==0 || progFormacion =="" || direccion =="" || telcelular =="" || correo =="" || modalidadtit =="" || colegio =="" || linvestigacion == 0 || val == 0){
            return false;
        }else{

            return true;
        }

    }

    //function filePreview(input){
    //    if(input.files && input.files[0]){
    //        var reader = new FileReader();
    //
    //        reader.onload = function (e){
    //            $('#preview-img + img').remove();
    //            $('#preview-img').afeter('<img src="'+e.target.result+'" width="300" height="450" />');
    //        }
    //    }
    //}
</script>
@endsection
