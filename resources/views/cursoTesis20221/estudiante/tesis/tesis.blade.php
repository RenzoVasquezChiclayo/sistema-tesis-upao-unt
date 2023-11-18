@extends('plantilla.dashboard')
@section('titulo')
    Tesis
@endsection
@section('css')
<link rel="stylesheet" href="./css/tesis_body.css">
@endsection
@section('contenido')
<title>Tesis</title>
    <style type="text/css">
        .border-box {
            border: 0.5px solid rgba(0, 0, 0, 0.2);
            border-radius: 20px;
            padding: 10px 0px;
            margin: 0;
        }

        .item-card2 {
            flex: 1 1 500px;
            margin-bottom: 10px;
        }

        .alert-correction {
            border: 1px solid green;
            border-radius: 10px;
        }

        /* Cambios */
        .contenedor-img {
            border-radius: 6px;
            background-color: azure;
            border: 1px solid gray;
        }

        .img-tarjeta {
            justify-content: center;
            text-align: center;
        }

        .img-buttons {
            justify-content: center;
            margin: 10px;
        }

        .galerias {
            display: grid;
            padding-top: 10px;
            padding-bottom: 10px;
            grid-template-rows: repeat(1, 250px);
            grid-auto-flow: column;
            overflow-x: auto;
            grid-auto-columns: auto;
        }

        .card-img-top {
            height: 140px;
        }


        .btn-delete-group {
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .btn-delete-group a {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 5px;
            color: red;
            text-decoration: none;
        }

        .btn-delete-group a:hover {

            border-radius: 5px;
            background: rgba(0, 0, 0, 0.1);
        }

        .title-p{
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.35);
        }

        .agrega_text {
            width: 100%;
        }
        .agrega_text tr td{
            max-width: 0;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .td_descripcion{
            width: 60%;
        }
        .input-counter{
            border:none;
            width:90px;
        }
    </style>
    @if ($tesis->cod_docente == null)
        <div class="row d-flex" style="align-items:center; justify-content: center;">
            <div class="col-8 border-box mt-3">
                <div class="row">
                    <div class="col">
                        <h4 style="color:red;">Aviso!</h4>
                        <hr style="border: 1px solid black;" />
                    </div>
                    <div class="col">
                        <p>Esta vista estara habilitada cuando se te designe algun asesor para el curso.
                            Si existe algun inconveniente y/o queja envia un correo a <a href="#">
                                <u>example@unitru.edu.pe</u>
                            </a> para mas informacion.</p>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="col-12">
            @if ($tesis->condicion == 'APROBADO')
                <div class="row p-2" style="background-color: rgb(77, 153, 77);">
                    <div class="col alert-correction" style="text-align: center;">
                        <p>TESIS APROBADO!</p>
                    </div>
                </div>
            @elseif($tesis->condicion == 'DESAPROBADO')
                <div class="row p-2" style="background-color: rgb(148, 91, 91);">
                    <div class="col col-md-6 alert-correction" style="text-align: center;">
                        <p>TESIS DESAPROBADO!</p>
                    </div>
                </div>
            @elseif (sizeof($correciones) != 0)
                <div class="row p-2" style="text-align:center;">
                    <div class="col col-md-6 alert-correction">
                        <p>Se realizaron las correciones correspondientes.</p>
                    </div>
                </div>
            @endif
            <div class="card-header">
                Registro de Proyectos
            </div>
            <div class="card-body">
                <div class="row py-3" style="text-align: center;">
                    <div class="col" style="align-items: center">
                        <h2 class="title-p"><strong>Registro de Tesis</strong></h2>
                    </div>
                </div>
                <div class="row">
                    <form id="formTesis2022" name="formTesis2022" action="{{route('estudiante.guardarTesis')}}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="col">
                            <h4>ESTRUCTURA</h4>
                            <hr style="border:1 px black; width: 70%;">

                            <input id="verificaCorrect" type="hidden"
                                value="">
                            <input type="hidden" name="txtcod_tesis" value="{{$tesis->cod_tesis}}">
                            <input type="hidden" id="txtValuesObs" value="">
                        </div>
                        <div class="col-12 mb-3">
                            <input type="hidden" name="textcod" value="{{$tesis->cod_tesis}}">
                            <div class="row">
                                <h5>Titulo</h5>
                                <div class="col">
                                    <div class="row">
                                        <div class="col-12 col-md-10">
                                            <div class="row gy-1 gy-sm-0">
                                                <div class="col-12 col-sm-9">
                                                    <input class="form-control" name="txttitulo" id="txttitulo" type="text"
                                                        value="@if ($tesis->titulo != null){{$tesis->titulo}}@endif"
                                                        placeholder="Ingrese el titulo de la tesis">
                                                    <span class="ps-2" id="validateTitle" name="validateTitle"
                                                        style="color: red"></span>
                                                </div>
                                                <div class="col-12 col-sm-3">
                                                    <input type="button" value="Verificar" onclick="validaText();"
                                                        class="btn btn-success">
                                                </div>
                                            </div>
                                        </div>
                                        {{-- @if (sizeof($correciones) != 0 && $tesis->condicion == null)
                                            @if ($correciones[0]->titulo != null)
                                                <div class="col-2">
                                                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                                        data-bs-target="#mCorreccionTitulo">Correccion</button>
                                                </div>
                                            @endif --}}
                                            {{-- Aqui va el modal --}}
                                            {{-- <div class="modal" id="mCorreccionTitulo">
                                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                    <div class="modal-content">
                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Correccion del titulo</h4>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <!-- Modal body -->
                                                        <div class="modal-body">
                                                            <div class="row" style="padding: 20px">
                                                                <p>{{ $correciones[0]->titulo }}</p>
                                                            </div>
                                                        </div>
                                                        <!-- Modal footer -->
                                                        <div class="modal-footer">
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <button type="button" class="btn btn-danger"
                                                                        data-bs-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif --}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col mb-3">
                            <h5>Autor</h5>
                            <div class="row my-2">
                                <div class="row">
                                    <div style="width:auto;">
                                        <input class="form-control" name="txtCodMatricula" id="txtCodMatricula" type="search"
                                            value="{{$estudiante->cod_matricula}}" placeholder="Codigo de Matricula" readonly>
                                    </div>
                                </div>
                            </div>
                            {{-- Informacion del egresado --}}
                            <div class="row border-box">
                                <div class="col-12 col-sm-6">
                                    <label for="txtNombreAutor" class="form-label">Nombres</label>
                                    <input class="form-control" name="txtNombreAutor" id="txtNombreAutor" type="text"
                                        value="{{$estudiante->nombres}}" placeholder="Nombres" readonly>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <label for="txtApellidoAutor" class="form-label">Apellidos</label>
                                    <input class="form-control" name="txtApellidoAutor" id="txtApellidoAutor" type="text"
                                        value="{{$estudiante->apellidos}}" placeholder="Apellidos" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col mb-3">
                            <h5>Asesor</h5>
                            <div class="row my-2">
                                <div class="row">
                                    <div style="width:auto;">
                                        <input class="form-control" name="txtCodAsesor" id="txtCodAsesor" type="text"
                                            value="{{$tesis->cod_asesor}}" placeholder="Codigo del Asesor" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row border-box">
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                    <label for="txtNombreAsesor" class="form-label">Apellidos y Nombres</label>
                                    <input class="form-control" name="txtNombreAsesor" id="txtNombreAsesor" type="text"
                                        value="{{$asesor->apellidos.' '.$asesor->nombres}}" placeholder="Apellidos y nombres" readonly>
                                </div>
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                    <label for="cboGrAcademicoAsesor" class="form-label">Grado Academico</label>
                                    <input class="form-control" name="txtGrAcademicoAsesor" id="txtGrAcademicoAsesor"
                                        type="text" value="{{$asesor->DescGrado}}" placeholder="Grado academico"
                                        readonly>
                                </div>
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                    <label for="txtTProfesional" class="form-label">Categoria</label>
                                    <input class="form-control" name="txtTProfesional" id="txtTProfesional" type="text"
                                        value="{{$asesor->DescCat}}" placeholder="Categoria" readonly>
                                </div>
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                    <label for="txtDireccionAsesor" class="form-label">Dirección laboral y/o
                                        domiciliaria</label>
                                    <input class="form-control" name="txtDireccionAsesor" id="txtDireccionAsesor"
                                        type="text" value="{{$asesor->direccion}}"
                                        placeholder="Direccion laboral y/o domiciliaria" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col mb-3">
                            <h5>Docente</h5>
                            <div class="row my-2">
                                <div class="row">
                                    <div style="width:auto;">
                                        <input class="form-control" name="txtCodDocente" id="txtCodDocente" type="text"
                                            value="{{$tesis->cod_docente}}" placeholder="Codigo del Docente" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row border-box">
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                    <label for="txtNombreDocente" class="form-label">Apellidos y Nombres</label>
                                    <input class="form-control" name="txtNombreDocente" id="txtNombreDocente" type="text"
                                        value="{{$docente->nombres}}" placeholder="Apellidos y nombres" readonly>
                                </div>
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                    <label for="cboGrAcademicoDocente" class="form-label">Grado Academico</label>
                                    <input class="form-control" name="txtGrAcademicoDocente" id="txtGrAcademicoDocente"
                                        type="text" value="{{$docente->DescGrado}}" placeholder="Grado academico"
                                        readonly>
                                </div>
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                    <label for="txtTProfesional" class="form-label">Categoria</label>
                                    <input class="form-control" name="txtTProfesional" id="txtTProfesional" type="text"
                                        value="{{$docente->DescCat}}" placeholder="Categoria" readonly>
                                </div>
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                    <label for="txtDireccionDocente" class="form-label">Dirección laboral y/o
                                        domiciliaria</label>
                                    <input class="form-control" name="txtDireccionDocente" id="txtDireccionDocente"
                                        type="text" value="{{$docente->direccion}}"
                                        placeholder="Direccion laboral y/o domiciliaria" readonly>
                                </div>
                            </div>
                        </div>


                        <div class="row" style=" margin-bottom:20px;">
                            <div class="col col-sm-9">
                                <h5>Dedicatoria</h5>
                            </div>
                            <div class="col-3">
                                <button @if ($tesis->dedicatoria == null) hidden @endif id="icon-dedicatoria" type="button" class="btn btn-danger" onclick="displayOptional(this);"><i class='bx bx-xs bx-minus'></i></button>
                            </div>
                            <div class="row mt-2" style="margin-bottom:8px">
                                <div class="col-12 col-md-10">
                                    <button id="btn-dedicatoria" class="btn btn-primary" type="button" onclick="displayOptional(this);" @if($tesis->dedicatoria != null) hidden @endif>Agregar</button>
                                    <div id="d-dedicatoria" class="form-floating" @if ($tesis->dedicatoria == null) hidden @endif>
                                        <textarea class="form-control" name="txtdedicatoria" id="txtdedicatoria" style="height: 150px;">@if ($tesis->dedicatoria != null){{$tesis->dedicatoria}}@endif</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row" style=" margin-bottom:20px;">
                            <div class="col col-sm-9">
                                <h5>Agradecimiento</h5>
                            </div>
                            <div class="col-3">
                                <button @if($tesis->agradecimiento == null) hidden @endif id="icon-agradecimiento" type="button" class="btn btn-danger" onclick="displayOptional(this);"><i class='bx bx-xs bx-minus'></i></button>
                            </div>
                            <div class="row mt-2" style="margin-bottom:8px">
                                <div class="col-12 col-md-10">
                                    <button id="btn-agradecimiento" class="btn btn-primary" type="button" onclick="displayOptional(this);" @if($tesis->agradecimiento != null) hidden @endif>Agregar</button>
                                    <div id="d-agradecimiento" class="form-floating" @if ($tesis->agradecimiento == null) hidden @endif>
                                        <textarea class="form-control" name="txtagradecimiento" id="txtagradecimiento" style="height: 150px;">@if ($tesis->agradecimiento != null){{$tesis->agradecimiento}}@endif</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style=" margin-bottom:20px;">
                            <h5>Presentacion</h5>
                            <div class="row" style="margin-bottom:8px">
                                <div class="col-12 col-md-10">
                                    <textarea class="form-control" name="txtpresentacion" id="txtpresentacion" >@if ($tesis->presentacion != null){{$tesis->presentacion}}@endif</textarea>
                                </div>
                                @if (sizeof($correciones) != 0 && $tesis->condicion == null)
                                    @if ($correciones[0]->presentacion != null)
                                        <div class="col-2">
                                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                                data-bs-target="#mCorreccionPresenta">Correccion</button>
                                        </div>
                                    @endif
                                    {{-- Aqui va el modal --}}
                                    <div class="modal" id="mCorreccionPresenta">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Correccion de Presentacion</h4>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <!-- Modal body -->
                                                <div class="modal-body">
                                                    <div class="row" style="padding: 20px">
                                                        <div class="row my-2">
                                                            <textarea class="form-control" name="taNone" id="taNone" style="height: 200px; resize:none" readonly>{{ $correciones[0]->presentacion }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Modal footer -->
                                                <div class="modal-footer">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <button type="button" class="btn btn-danger"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                        </div>
                        <div class="row" style=" margin-bottom:20px;">
                            <h5>Resumen</h5>
                            <div class="row" style="margin-bottom:8px">
                                <div class="col-12 col-md-10">
                                    <textarea class="form-control" name="txtresumen" id="txtresumen" >@if ($tesis->resumen != null){{$tesis->resumen}}@endif</textarea>
                                </div>
                                @if (sizeof($correciones) != 0 && $tesis->condicion == null)
                                    @if ($correciones[0]->resumen != null)
                                        <div class="col-2">
                                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                                data-bs-target="#mCorreccionResumen">Correccion</button>
                                        </div>
                                    @endif
                                    {{-- Aqui va el modal --}}
                                    <div class="modal" id="mCorreccionResumen">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Correccion de Resumen</h4>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <!-- Modal body -->
                                                <div class="modal-body">
                                                    <div class="row" style="padding: 20px">
                                                        <div class="row my-2">
                                                            <textarea class="form-control" name="taNone" id="taNone" style="height: 200px; resize:none" readonly>{{ $correciones[0]->resumen }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Modal footer -->
                                                <div class="modal-footer">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <button type="button" class="btn btn-danger"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                        </div>
                        <div class="row" style=" margin-bottom:20px;">
                            <h5>Abstract</h5>
                            <div class="row" style="margin-bottom:8px">
                                <div class="col-12 col-md-10">
                                    <textarea class="form-control" name="txtabstract" id="txtabstract" >@if ($tesis->abstract != null){{$tesis->abstract}}@endif</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row" style=" margin-bottom:20px;">
                            <h5>Palabras claves</h5>
                            <div class="col col-sm-4">
                                <div class="input-group">
                                    <input class="form-control" type="text" id="i_keyword" placeholder="Palabra clave">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-success" id="btn_agregark" onclick="addKeyword();">Agregar</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3 ms-1" id="chips">
                                <input id="get_keyword" type="hidden" @if(sizeof($keywords)>0)value="{{$keywords}}"@endif>
                                <input id="list_keyword" name="list_keyword" type="hidden">
                                <input type="hidden" name="deleted_keyword" id="deleted_keyword">
                                <!-- Se crea mediante js -->
                            </div>
                        </div>
                        <div class="row" style=" margin-bottom:20px;">
                            <h5>Introduccion</h5>
                            <div class="row" style="margin-bottom:8px">
                                <div class="col-12 col-md-10">
                                    <textarea class="form-control" name="txtintroduccion" id="txtintroduccion" >@if ($tesis->introduccion != null){{$tesis->introduccion}}@endif</textarea>
                                </div>
                                @if (sizeof($correciones) != 0 && $tesis->condicion == null)
                                    @if ($correciones[0]->introduccion != null)
                                        <div class="col-2">
                                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                                data-bs-target="#mCorreccionIntro">Correccion</button>
                                        </div>
                                    @endif
                                    {{-- Aqui va el modal --}}
                                    <div class="modal" id="mCorreccionIntro">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Correccion de Introduccion</h4>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <!-- Modal body -->
                                                <div class="modal-body">
                                                    <div class="row" style="padding: 20px">
                                                        <div class="row my-2">
                                                            <textarea class="form-control" name="taNone" id="taNone" style="height: 200px; resize:none" readonly>{{ $correciones[0]->introduccion }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Modal footer -->
                                                <div class="modal-footer">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <button type="button" class="btn btn-danger"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                        </div>


                        {{-- Indice para cada button y box donde se iran agregando los elementos. --}}
                        @php
                            $iGRUPO = 0;
                        @endphp
                        <div class="row" style=" margin-bottom:20px">
                            <div class="col-8">
                                <h4>PLAN DE INVESTIGACION</h4>
                                <hr style="border:1 px black;">
                            </div>


                            <h5>Realidad problematica </h5>


                            <div class="row" style="margin-bottom:8px">
                                <div class="col-12 col-md-10">
                                    <textarea class="form-control" name="txtreal_problematica" id="txtreal_problematica" >@if ($tesis->real_problematica != null){{$tesis->real_problematica}}@endif</textarea>
                                </div>


                                @if (sizeof($correciones) != 0 && $tesis->condicion == null)
                                    @if ($correciones[0]->real_problematica != null)
                                        <div class="col-2">
                                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                                data-bs-target="#mCorreccionRProbl">Correccion</button>
                                        </div>
                                    @endif
                                    {{-- Aqui va el modal --}}
                                    <div class="modal" id="mCorreccionRProbl">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Correccion de Realidad problematica</h4>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <!-- Modal body -->
                                                <div class="modal-body">
                                                    <div class="row" style="padding: 20px">
                                                        <div class="row my-2">
                                                            <textarea class="form-control" name="taNone" id="taNone" style="height: 200px; resize:none" readonly>{{ $correciones[0]->real_problematica }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Modal footer -->
                                                <div class="modal-footer">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <button type="button" class="btn btn-danger"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="row" style=" margin-bottom:20px">
                            <h5>Antecedentes</h5>
                            <div class="row" style="margin-bottom:8px">
                                <div class="col-12 col-md-10">
                                    <textarea class="form-control" name="txtantecedentes" id="txtantecedentes" >@if ($tesis->antecedentes != null){{$tesis->antecedentes}}@endif</textarea>
                                </div>

                                @if (sizeof($correciones) != 0 && $tesis->condicion == null)
                                    @if ($correciones[0]->antecedentes != null)
                                        <div class="col-2">
                                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                                data-bs-target="#mCorreccionAntecedente">Correccion</button>
                                        </div>
                                    @endif
                                    {{-- Aqui va el modal --}}
                                    <div class="modal" id="mCorreccionAntecedente">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Correccion de antecedentes</h4>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <!-- Modal body -->
                                                <div class="modal-body">
                                                    <div class="row" style="padding: 20px">
                                                        <div class="row my-2">
                                                            <textarea class="form-control" name="taNone" id="taNone" style="height: 200px; resize:none" readonly>{{ $correciones[0]->antecedentes }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Modal footer -->
                                                <div class="modal-footer">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <button type="button" class="btn btn-danger"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="row" style=" margin-bottom:20px">
                            <h5>Justificación de la investigación</h5>
                            <div class="row" style="margin-bottom:8px">
                                <div class="col-12 col-md-10">
                                    <textarea class="form-control" name="txtjustificacion" id="txtjustificacion" >@if ($tesis->justificacion != null){{$tesis->justificacion}}@endif</textarea>
                                </div>

                                @if (sizeof($correciones) != 0 && $tesis->condicion == null)
                                    @if ($correciones[0]->justificacion != null)
                                        <div class="col-2">
                                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                                data-bs-target="#mCorreccionJInv">Correccion</button>
                                        </div>
                                    @endif
                                    {{-- Aqui va el modal --}}
                                  <div class="modal" id="mCorreccionJInv">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Correccion de justificacion de la investigacion
                                                    </h4>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <!-- Modal body -->
                                                <div class="modal-body">
                                                    <div class="row" style="padding: 20px">
                                                        <div class="row my-2">
                                                            <textarea class="form-control" name="taNone" id="taNone" style="height: 200px; resize:none" readonly>{{ $correciones[0]->justificacion }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Modal footer -->
                                                <div class="modal-footer">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <button type="button" class="btn btn-danger"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="row" style=" margin-bottom:20px">
                            <h5>Formulación del problema</h5>
                            <div class="row" style="margin-bottom:8px">
                                <div class="col-12 col-md-10">
                                    <textarea class="form-control" name="txtformulacion_prob" id="txtformulacion_prob" >@if ($tesis->formulacion_prob != null){{$tesis->formulacion_prob}}@endif</textarea>
                                </div>

                                @if (sizeof($correciones) != 0 && $tesis->condicion == null)
                                    @if ($correciones[0]->formulacion_prob != null)
                                        <div class="col-2">
                                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                                data-bs-target="#mCorreccionFProbl">Correccion</button>
                                        </div>
                                    @endif
                                    {{-- Aqui va el modal --}}
                                   <div class="modal" id="mCorreccionFProbl">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Correccion de Formulacion del problema</h4>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <!-- Modal body -->
                                                <div class="modal-body">
                                                    <div class="row" style="padding: 20px">
                                                        <div class="row my-2">
                                                            <textarea class="form-control" name="taNone" id="taNone" style="height: 200px; resize:none" readonly>{{ $correciones[0]->formulacion_prob }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Modal footer -->
                                                <div class="modal-footer">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <button type="button" class="btn btn-danger"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="row" style=" margin-bottom:20px">
                            <h5>Objetivos</h5>
                            <div class="col-8 col-md-5 col-xl-3">
                                <div class="row border-box" style="margin-bottom:20px">
                                    <div class="col-7 col-md-6" style="text-align:center">
                                        <p>Agregar un objetivo</p>
                                    </div>
                                    <div class="col-5 col-md-6">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#mObjetivo">
                                            Agregar
                                        </button>

                                    </div>
                                </div>
                            </div>
                            @if (sizeof($correciones) != 0 && $tesis->condicion == null)
                                @if ($correciones[0]->objetivos != null)
                                    <div class="col-2">
                                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                            data-bs-target="#mCorreccionObjetivo">Correccion</button>
                                    </div>
                                @endif
                                {{-- Aqui va el modal --}}
                               <div class="modal" id="mCorreccionObjetivo">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Correccion de Objetivos</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <div class="row" style="padding: 20px">
                                                    <div class="row my-2">
                                                        <textarea class="form-control" name="taNone" id="taNone" style="height: 200px; resize:none" readonly>{{ $correciones[0]->objetivos }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <button type="button" class="btn btn-danger"
                                                            data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="row" style="margin-bottom:8px">
                                <div class="col-12">
                                    {{-- Tabla para insertar los recursos usados --}}
                                    <table id="objetivoTable"
                                        class="table table-striped table-bordered table-condensed table-hover">
                                        <thead>
                                            <tr>
                                                <th>Tipo</th>
                                                <th>Subtipo</th>
                                                <th>Accion</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (sizeof($objetivos) > 0)
                                                @php
                                                    $indObj = 0;
                                                @endphp

                                                @foreach ($objetivos as $obj)
                                                    <tr id="filaO{{ $indObj }}">
                                                        <td>{{ $obj->tipo }}</td>
                                                        <td>{{ $obj->descripcion }}</td>
                                                        <td>
                                                            @if ((sizeof($correciones) > 0 && $correciones[0]->objetivos != null) || $tesis->estado != 1)
                                                                <a href="#" id="lobj-{{ $indObj }}"
                                                                    class="btn btn-warning"
                                                                    onclick="deleteOldData(this);">X</a>
                                                            @endif
                                                            <input type="hidden" id="xlobj-{{ $indObj }}"
                                                                value="{{ $obj->cod_objetivo }}">
                                                        </td>
                                                    </tr>
                                                    @php
                                                        $indObj++;
                                                    @endphp
                                                @endforeach
                                            @endif
                                            <input type="hidden" id="valNObjetivo" value="{{ sizeof($objetivos) }}">
                                            <input type="hidden" name="listOldlobj" id="listOldlobj">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        {{-- Aqui van los marcos teorico, conceptual y legal(opcional) --}}
                        <div class="row" style=" margin-bottom:20px">
                            <div class="row" style="margin-bottom:15px">
                                <div class="col-12">
                                    <hr style="border: 1px solid gray">
                                </div>
                                <h5>Marco Teórico</h5>
                                <div class="col-12 col-md-10">
                                    <textarea class="form-control" name="txtmarco_teorico" id="txtmarco_teorico" >@if ($tesis->marco_teorico != null){{$tesis->marco_teorico}}@endif</textarea>
                                </div>
                                @if (sizeof($correciones) != 0 && $tesis->condicion == null)
                                    @if ($correciones[0]->marco_teorico != null)
                                        <div class="col-2">
                                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                                data-bs-target="#mCorreccionMTeorico">Correccion</button>
                                        </div>
                                    @endif
                                    {{-- Aqui va el modal --}}
                                   <div class="modal" id="mCorreccionMTeorico">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Correccion de Marco teorico</h4>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <!-- Modal body -->
                                                <div class="modal-body">
                                                    <div class="row" style="padding: 20px">
                                                        <div class="row my-2">
                                                            <textarea class="form-control" name="taNone" id="taNone" style="height: 200px; resize:none" readonly>{{ $correciones[0]->marco_teorico }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Modal footer -->
                                                <div class="modal-footer">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <button type="button" class="btn btn-danger"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="row" style="margin-bottom:15px">
                                <h5>Marco Conceptual</h5>
                                <div class="col-12 col-md-10">
                                    <textarea class="form-control" name="txtmarco_conceptual" id="txtmarco_conceptual" >@if ($tesis->marco_conceptual != null){{$tesis->marco_conceptual}}@endif</textarea>
                                </div>

                                @if (sizeof($correciones) != 0 && $tesis->condicion == null)
                                    @if ($correciones[0]->marco_conceptual != null)
                                        <div class="col-2">
                                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                                data-bs-target="#mCorreccionMConceptual">Correccion</button>
                                        </div>
                                    @endif
                                    {{-- Aqui va el modal --}}
                                   <div class="modal" id="mCorreccionMConceptual">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Correccion de Marco conceptual</h4>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row" style="padding: 20px">
                                                        <div class="row my-2">
                                                            <textarea class="form-control" name="taNone" id="taNone" style="height: 200px; resize:none" readonly>{{ $correciones[0]->marco_conceptual }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <button type="button" class="btn btn-danger"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="row" style="margin-bottom:15px">
                                <h5>Marco Legal</h5>
                                <div class="col-12 col-md-10">
                                    <textarea class="form-control" name="txtmarco_legal" id="txtmarco_legal" >@if ($tesis->marco_legal != null){{$tesis->marco_legal}}@endif</textarea>
                                </div>

                                @if (sizeof($correciones) != 0 && $tesis->condicion == null)
                                    @if ($correciones[0]->marco_legal != null)
                                        <div class="col-2">
                                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                                data-bs-target="#mCorreccionMLegal">Correccion</button>
                                        </div>
                                    @endif
                                    {{-- Aqui va el modal --}}
                                   <div class="modal" id="mCorreccionMLegal">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Correccion de Marco Legal</h4>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <!-- Modal body -->
                                                <div class="modal-body">
                                                    <div class="row" style="padding: 20px">
                                                        <div class="row my-2">
                                                            <textarea class="form-control" name="taNone" id="taNone" style="height: 200px; resize:none" readonly>{{ $correciones[0]->marco_legal }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Modal footer -->
                                                <div class="modal-footer">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <button type="button" class="btn btn-danger"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="row" style=" margin-bottom:20px">
                            <h5>Formulación de la hipótesis </h5>
                            <div class="row" style="margin-bottom:8px">
                                <div class="col-12 col-md-10">
                                    <textarea class="form-control" name="txtform_hipotesis" id="txtform_hipotesis" >@if ($tesis->form_hipotesis != null){{$tesis->form_hipotesis}}@endif</textarea>
                                </div>

                                @if (sizeof($correciones) != 0 && $tesis->condicion == null)
                                    @if ($correciones[0]->form_hipotesis != null)
                                        <div class="col-2">
                                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                                data-bs-target="#mCorreccionFHipotesis">Correccion</button>
                                        </div>
                                    @endif
                                    {{-- Aqui va el modal --}}
                                   <div class="modal" id="mCorreccionFHipotesis">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Correccion de Formulacion de la hipotesis</h4>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <!-- Modal body -->
                                                <div class="modal-body">
                                                    <div class="row" style="padding: 20px">
                                                        <div class="row my-2">
                                                            <textarea class="form-control" name="taNone" id="taNone" style="height: 200px; resize:none" readonly>{{ $correciones[0]->form_hipotesis }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Modal footer -->
                                                <div class="modal-footer">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <button type="button" class="btn btn-danger"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="row" style=" margin-bottom:20px">
                            <div class="row">
                                {{-- Punto Diseno de Investigacion y demas subtemas --}}
                                <h5>Diseño de Investigación</h5>
                                <h6>Material, Métodos y Técnicas</h6>
                                <hr style="width: 60%; margin-left:15px;" />
                            </div>
                            <div class="row" style="margin-bottom:8px">
                                <label for="txtobjeto_estudio" class="form-label">Objeto de Estudio</label>
                                <div class="col-12 col-md-10">
                                    <textarea class="form-control" name="txtobjeto_estudio" id="txtobjeto_estudio" >@if ($tesis->objeto_estudio != null){{$tesis->objeto_estudio}}@endif</textarea>
                                </div>

                                @if (sizeof($correciones) != 0 && $tesis->condicion == null)
                                    @if ($correciones[0]->objeto_estudio != null)
                                        <div class="col-2">
                                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                                data-bs-target="#mCorreccionOEstudio">Correccion</button>
                                        </div>
                                    @endif
                                    {{-- Aqui va el modal --}}
                                   <div class="modal" id="mCorreccionOEstudio">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Correccion del Objeto de Estudio</h4>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <!-- Modal body -->
                                                <div class="modal-body">
                                                    <div class="row" style="padding: 20px">
                                                        <div class="row my-2">
                                                            <textarea class="form-control" name="taNone" id="taNone" style="height: 200px; resize:none" readonly>{{ $correciones[0]->objeto_estudio }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Modal footer -->
                                                <div class="modal-footer">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <button type="button" class="btn btn-danger"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="row" style="margin-bottom:8px">
                                <label for="txtpoblacion" class="form-label">Población</label>
                                <div class="col-12 col-md-10">
                                    <textarea class="form-control" name="txtpoblacion" id="txtpoblacion" >@if ($tesis->poblacion != null){{$tesis->poblacion}}@endif</textarea>
                                </div>

                                @if (sizeof($correciones) != 0 && $tesis->condicion == null)
                                    @if ($correciones[0]->poblacion != null)
                                        <div class="col-2">
                                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                                data-bs-target="#mCorreccionPoblacion">Correccion</button>
                                        </div>
                                    @endif
                                    {{-- Aqui va el modal --}}
                                   <div class="modal" id="mCorreccionPoblacion">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Correccion de Poblacion</h4>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <!-- Modal body -->
                                                <div class="modal-body">
                                                    <div class="row" style="padding: 20px">
                                                        <div class="row my-2">
                                                            <textarea class="form-control" name="taNone" id="taNone" style="height: 200px; resize:none" readonly>{{ $correciones[0]->poblacion }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Modal footer -->
                                                <div class="modal-footer">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <button type="button" class="btn btn-danger"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="row" style="margin-bottom:8px">
                                <label for="txtmuestra" class="form-label">Muestra</label>
                                <div class="col-12 col-md-10">
                                    <textarea class="form-control" name="txtmuestra" id="txtmuestra" >@if ($tesis->muestra != null){{$tesis->muestra}}@endif</textarea>
                                </div>

                                @if (sizeof($correciones) != 0 && $tesis->condicion == null)
                                    @if ($correciones[0]->muestra != null)
                                        <div class="col-2">
                                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                                data-bs-target="#mCorreccionMuestra">Correccion</button>
                                        </div>
                                    @endif
                                    {{-- Aqui va el modal --}}
                                    <div class="modal" id="mCorreccionMuestra">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Correccion de Muestra</h4>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <!-- Modal body -->
                                                <div class="modal-body">
                                                    <div class="row" style="padding: 20px">
                                                        <div class="row my-2">
                                                            <textarea class="form-control" name="taNone" id="taNone" style="height: 200px; resize:none" readonly>{{ $correciones[0]->muestra }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Modal footer -->
                                                <div class="modal-footer">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <button type="button" class="btn btn-danger"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="row" style="margin-bottom:8px">
                                <label for="txtmetodos" class="form-label">Métodos</label>
                                <div class="col-12 col-md-10">
                                    <textarea class="form-control" name="txtmetodos" id="txtmetodos" >@if ($tesis->metodos != null){{$tesis->metodos}}@endif</textarea>
                                </div>

                                @if (sizeof($correciones) != 0 && $tesis->condicion == null)
                                    @if ($correciones[0]->metodos != null)
                                        <div class="col-2">
                                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                                data-bs-target="#mCorreccionMetodos">Correccion</button>
                                        </div>
                                    @endif
                                    {{-- Aqui va el modal --}}
                                    <div class="modal" id="mCorreccionMetodos">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Correccion de Metodos</h4>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <!-- Modal body -->
                                                <div class="modal-body">
                                                    <div class="row" style="padding: 20px">
                                                        <div class="row my-2">
                                                            <textarea class="form-control" name="taNone" id="taNone" style="height: 200px; resize:none" readonly>{{ $correciones[0]->metodos }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Modal footer -->
                                                <div class="modal-footer">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <button type="button" class="btn btn-danger"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="row" style="margin-bottom:8px">
                                <label for="txttecnicas_instrum" class="form-label">Técnicas e instrumentos de recolección
                                    de datos</label>
                                <div class="col-12 col-md-10">
                                    <textarea class="form-control" name="txttecnicas_instrum" id="txttecnicas_instrum" type="text" >@if ($tesis->tecnicas_instrum != null){{$tesis->tecnicas_instrum}}@endif</textarea>
                                </div>
                                @if (sizeof($correciones) != 0 && $tesis->condicion == null)
                                    @if ($correciones[0]->tecnicas_instrum != null)
                                        <div class="col-2">
                                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                                data-bs-target="#mCorreccionTecInst">Correccion</button>
                                        </div>
                                    @endif
                                    {{-- Aqui va el modal --}}
                                   <div class="modal" id="mCorreccionTecInst">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Correccion de Técnicas e instrumentos</h4>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <!-- Modal body -->
                                                <div class="modal-body">
                                                    <div class="row" style="padding: 20px">
                                                        <div class="row my-2">
                                                            <textarea class="form-control" name="taNone" id="taNone" style="height: 200px; resize:none" readonly>{{ $correciones[0]->tecnicas_instrum }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Modal footer -->
                                                <div class="modal-footer">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <button type="button" class="btn btn-danger"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="row" style="margin-bottom:20px">
                                <h6>Instrumentación y/o fuentes de datos</h6>
                                <div class="col-12 col-md-10">
                                    <textarea class="form-control" name="txtinstrumentacion" id="txtinstrumentacion" type="text" value="" >@if ($tesis->instrumentacion != null){{$tesis->instrumentacion}}@endif</textarea>
                                </div>
                                @if (sizeof($correciones) != 0 && $tesis->condicion == null)
                                    @if ($correciones[0]->instrumentacion != null)
                                        <div class="col-2">
                                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                                data-bs-target="#mCorreccionInsFD">Correccion</button>
                                        </div>
                                    @endif
                                    {{-- Aqui va el modal --}}
                                   <div class="modal" id="mCorreccionInsFD">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Correccion de Instrumentación y/o fuentes de datos
                                                    </h4>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <!-- Modal body -->
                                                <div class="modal-body">
                                                    <div class="row" style="padding: 20px">
                                                        <div class="row my-2">
                                                            <textarea class="form-control" name="taNone" id="taNone" style="height: 200px; resize:none" readonly>{{ $correciones[0]->instrumentacion }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Modal footer -->
                                                <div class="modal-footer">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <button type="button" class="btn btn-danger"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="row" style="margin-bottom:20px">
                                <h6>Estrategias Metodológicas</h6>
                                <div class="col-12 col-md-10">
                                    <textarea class="form-control" name="txtestg_metodologicas" id="txtestg_metodologicas"
                                        >@if ($tesis->estg_metodologicas != null){{$tesis->estg_metodologicas}}@endif</textarea>
                                </div>
                                @if (sizeof($correciones) != 0 && $tesis->condicion == null)
                                    @if ($correciones[0]->estg_metodologicas != null)
                                        <div class="col-2">
                                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                                data-bs-target="#mCorreccionEstrategia">Correccion</button>
                                        </div>
                                    @endif
                                    {{-- Aqui va el modal --}}
                                    <div class="modal" id="mCorreccionEstrategia">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Correccion de Estrategias Metodológicas</h4>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <!-- Modal body -->
                                                <div class="modal-body">
                                                    <div class="row" style="padding: 20px">
                                                        <div class="row my-2">
                                                            <textarea class="form-control" name="taNone" id="taNone" style="height: 200px; resize:none" readonly>{{ $correciones[0]->estg_metodologicas }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Modal footer -->
                                                <div class="modal-footer">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <button type="button" class="btn btn-danger"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                        </div>
                        <div class="row" style=" margin-bottom:20px;">
                            <h5>Resultados</h5>
                            <div class="row" style="margin-bottom:8px">
                                <div class="col-12 col-md-10">
                                    <textarea class="form-control" name="txtresultados[]" id="txtresultados" >@if ($tesis->resultados != null){{$tesis->resultados}}@endif</textarea>
                                </div>
                                @if (sizeof($correciones) != 0 && $tesis->condicion == null)
                                    @if ($correciones[0]->resultados != null)
                                        <div class="col-2">
                                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                                data-bs-target="#mCorreccionResultados">Correccion</button>
                                        </div>
                                    @endif
                                    {{-- Aqui va el modal --}}
                                   <div class="modal" id="mCorreccionResultados">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Correccion de Resultados
                                                    </h4>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <!-- Modal body -->
                                                <div class="modal-body">
                                                    <div class="row" style="padding: 20px">
                                                        <div class="row my-2">
                                                            <textarea class="form-control" name="taNone" id="taNone" style="height: 200px; resize:none" readonly>{{ $correciones[0]->resultados }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Modal footer -->
                                                <div class="modal-footer">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <button type="button" class="btn btn-danger"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div id="resultados_contenedor" class="row m-3" hidden>
                                <input name="resultados_getImg" id="resultados_getImg" type="hidden" value="{{$resultadosImg}}">
                                <input name="resultados_getTxt" id="resultados_getTxt" type="hidden" value="{{$tesis->resultados}}">
                                <input name="resultados_sendRow" id="resultados_sendRow" type="hidden">
                            </div>
                            <div class="col-12 m-1">
                                <button id="resultados_btn_addImage" class="btn btn-primary" type="button" onclick="addRowImage(this);">Agregar imagenes</button>
                                <button id="resultados_btn_addField" class="btn btn-outline-primary" type="button" onclick="addTextField(this);" hidden>Agregar campo</button>
                            </div>
                        </div>
                        <div class="row" style=" margin-bottom:20px;">
                            <h5>Discusión</h5>
                            <div class="row" style="margin-bottom:8px">
                                <div class="col-12 col-md-10">
                                    <textarea class="form-control" name="txtdiscucion" id="txtdiscucion" >@if ($tesis->discusion != null){{$tesis->discusion}}@endif</textarea>
                                </div>
                                @if (sizeof($correciones) != 0 && $tesis->condicion == null)
                                    @if ($correciones[0]->discusion != null)
                                        <div class="col-2">
                                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                                data-bs-target="#mCorreccionDiscusion">Correccion</button>
                                        </div>
                                    @endif
                                    {{-- Aqui va el modal --}}
                                   <div class="modal" id="mCorreccionDiscusion">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Correccion de Discusion
                                                    </h4>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <!-- Modal body -->
                                                <div class="modal-body">
                                                    <div class="row" style="padding: 20px">
                                                        <div class="row my-2">
                                                            <textarea class="form-control" name="taNone" id="taNone" style="height: 200px; resize:none" readonly>{{ $correciones[0]->discusion }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Modal footer -->
                                                <div class="modal-footer">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <button type="button" class="btn btn-danger"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="row" style=" margin-bottom:20px;">
                            <h5>Conclusiones</h5>
                            <div class="row" style="margin-bottom:8px">
                                <div class="col-12 col-md-10">
                                    <textarea class="form-control" name="txtconclusiones" id="txtconcluciones" >@if ($tesis->conclusiones != null){{$tesis->conclusiones}}@endif</textarea>
                                </div>
                                @if (sizeof($correciones) != 0 && $tesis->condicion == null)
                                    @if ($correciones[0]->conclusiones != null)
                                        <div class="col-2">
                                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                                data-bs-target="#mCorreccionConclusiones">Correccion</button>
                                        </div>
                                    @endif
                                    {{-- Aqui va el modal --}}
                                   <div class="modal" id="mCorreccionConclusiones">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Correccion de Conclusiones
                                                    </h4>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <!-- Modal body -->
                                                <div class="modal-body">
                                                    <div class="row" style="padding: 20px">
                                                        <div class="row my-2">
                                                            <textarea class="form-control" name="taNone" id="taNone" style="height: 200px; resize:none" readonly>{{ $correciones[0]->conclusiones }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Modal footer -->
                                                <div class="modal-footer">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <button type="button" class="btn btn-danger"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="row" style=" margin-bottom:20px;">
                            <h5>Recomendaciones</h5>
                            <div class="row" style="margin-bottom:8px">
                                <div class="col-12 col-md-10">
                                    <textarea class="form-control" name="txtrecomendaciones" id="txtrecomendaciones" >@if ($tesis->recomendaciones != null){{$tesis->recomendaciones}}@endif</textarea>
                                </div>
                                @if (sizeof($correciones) != 0 && $tesis->condicion == null)
                                    @if ($correciones[0]->recomendaciones != null)
                                        <div class="col-2">
                                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                                data-bs-target="#mCorreccionRecomendaciones">Correccion</button>
                                        </div>
                                    @endif
                                    {{-- Aqui va el modal --}}
                                   <div class="modal" id="mCorreccionRecomendaciones">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Correccion de Recomendaciones
                                                    </h4>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <!-- Modal body -->
                                                <div class="modal-body">
                                                    <div class="row" style="padding: 20px">
                                                        <div class="row my-2">
                                                            <textarea class="form-control" name="taNone" id="taNone" style="height: 200px; resize:none" readonly>{{ $correciones[0]->recomendaciones }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Modal footer -->
                                                <div class="modal-footer">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <button type="button" class="btn btn-danger"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="row" style=" margin-bottom:20px; padding-right:12px;">
                            <div class="col-12">
                                <hr style="border: 1px solid gray">
                            </div>
                            <h5>Referencias bibliográficas</h5>
                            <div class="row">
                                <div class="row mb-3">
                                    <div class="col-8 col-md-4">
                                        <label for="cboTipoAPA" class="form-label">Tipo</label>
                                        <select name="cboTipoAPA" id="cboTipoAPA" class="form-select"
                                            onchange="setTypeAPA();" required>
                                            <option selected>-</option>
                                            @foreach ($tiporeferencia as $tipo)
                                                <option value="{{ $tipo->cod_tiporeferencia }}">{{ $tipo->tipo }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @if (sizeof($correciones) != 0 && $tesis->condicion == null)
                                        @if ($correciones[0]->referencias != null)
                                            <div class="col-2">
                                                <button type="button" class="btn btn-outline-danger"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#mCorreccionReferencia">Correccion</button>
                                            </div>
                                        @endif
                                        {{-- Aqui va el modal --}}
                                      <div class="modal" id="mCorreccionReferencia">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                <div class="modal-content">
                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Correccion de las Referencias</h4>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <!-- Modal body -->
                                                    <div class="modal-body">
                                                        <div class="row" style="padding: 20px">
                                                            <div class="row my-2">
                                                                <textarea class="form-control" name="taNone" id="taNone" style="height: 200px; resize:none" readonly>{{ $correciones[0]->referencias }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Modal footer -->
                                                    <div class="modal-footer">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <button type="button" class="btn btn-danger"
                                                                    data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-12">
                                    <div class="row border-box mb-3">
                                        <div class="item-card2">
                                            <div class="col-12">
                                                <label for="txtAutorAPA" class="form-label">Autor</label>
                                                <div class="row">
                                                    <div class="col-6 col-xl-7">
                                                        <input class="form-control" name="txtAutorAPA" id="txtAutorAPA"
                                                            type="text" value="" placeholder="Nombre del autor">
                                                    </div>
                                                    <div class="col-6 col-xl-5 d-flex">
                                                        <div class="me-3" id="btnVariosAutores" hidden>
                                                            <input type="button" class="btn btn-success" id="btnAgregaAutores"
                                                                onclick="addAutor();" value="Agregar">
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value=""
                                                                id="chkMasAutor" onclick="setVariosAutores();">
                                                            <label class="form-check-label" for="chkMasAutor">
                                                                Varios
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <input type="hidden" id="array_autores">
                                                </div>
                                            </div>
                                            <div class="col-12" style="padding-top:5px;" id="rowVariosAutores" hidden>
                                                <div class="row" id="rowAddAutor"
                                                    style="display: grid; grid-template-columns: repeat(auto-fill,minmax(9em,1fr)); grid-gap: 2px; ">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="item-card2">
                                            <label for="txtFechaPublicacion" class="form-label">Fecha de Publicacion</label>
                                            <input class="form-control" name="txtFechaPublicacion" id="txtFechaPublicacion"
                                                type="text" value="" placeholder="Fecha de publicacion">
                                        </div>
                                        <div class="item-card2">
                                            <label for="txtTituloTrabajo" class="form-label">Titulo del Trabajo</label>
                                            <input class="form-control" name="txtTituloTrabajo" id="txtTituloTrabajo"
                                                type="text" value="" placeholder="Titulo del trabajo">
                                        </div>
                                        <div class="item-card2">
                                            <label for="txtFuente" class="form-label">Fuente</label>
                                            <input class="form-control" name="txtFuente" id="txtFuente" type="text"
                                                value="" placeholder="Fuente para recuperacion">
                                        </div>
                                        <div class="item-card2" id="div-editorial" hidden>
                                            <label for="txtEditorial" class="form-label">Editorial</label>
                                            <input class="form-control" name="txtEditorial" id="txtEditorial" type="text"
                                                value="" placeholder="Editorial">
                                        </div>
                                        <div class="item-card2" id="div-titlecap" hidden>
                                            <label for="txtTitleCap" class="form-label">Titulo del Capitulo</label>
                                            <input class="form-control" name="txtTitleCap" id="txtTitleCap" type="text"
                                                value="" placeholder="Titulo del capitulo">
                                        </div>
                                        <div class="item-card2" id="div-numcap" hidden>
                                            <label for="txtNumCapitulo" class="form-label"># Capitulos</label>
                                            <input class="form-control" name="txtNumCapitulo" id="txtNumCapitulo"
                                                type="text" value="" placeholder="Numero del capitulo">
                                        </div>
                                        <div class="item-card2" id="div-titlerev" hidden>
                                            <label for="txtTitleRev" class="form-label">Titulo de Revista</label>
                                            <input class="form-control" name="txtTitleRev" id="txtTitleRev" type="text"
                                                value="" placeholder="Titulo de revista">
                                        </div>
                                        <div class="item-card2" id="div-volumen" hidden>
                                            <label for="txtVolumen" class="form-label">Volumen</label>
                                            <input class="form-control" name="txtVolumen" id="txtVolumen" type="text"
                                                value="" placeholder="Volumen">
                                        </div>
                                        <div class="item-card2" id="div-nameweb" hidden>
                                            <label for="txtNameWeb" class="form-label">Nombre de la Web</label>
                                            <input class="form-control" name="txtNameWeb" id="txtNameWeb" type="text"
                                                value="" placeholder="Nombre de la web">
                                        </div>
                                        <div class="item-card2" id="div-nameperiodista" hidden>
                                            <label for="txtNamePeriodista" class="form-label">Nombre del Periodista</label>
                                            <input class="form-control" name="txtNamePeriodista" id="txtNamePeriodista"
                                                type="text" value="" placeholder="Nombre del periodista">
                                        </div>
                                        <div class="item-card2" id="div-nameinsti" hidden>
                                            <label for="txtNameInsti" class="form-label">Nombre de la Institucion</label>
                                            <input class="form-control" name="txtNameInsti" id="txtNameInsti" type="text"
                                                value="" placeholder="Nombre de la institucion">
                                        </div>
                                        <div class="item-card2" id="div-subtitle" hidden>
                                            <label for="txtSubtitle" class="form-label">Sub titulo</label>
                                            <input class="form-control" name="txtSubtitle" id="txtSubtitle" type="text"
                                                value="" placeholder="Subtitulo">
                                        </div>
                                        <div class="item-card2" id="div-nameeditor" hidden>
                                            <label for="txtNameEditor" class="form-label">Nombre del editor</label>
                                            <input class="form-control" name="txtNameEditor" id="txtNameEditor"
                                                type="text" value="" placeholder="Nombre del Editor">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-2">
                                        <span id="fullReference" name="fullReference" style="color: red"></span>
                                        <input type="button" class="btn btn-outline-primary" value="Agregar referencia"
                                            onclick="agregarReferenciaB();">
                                    </div>
                                </div>
                            </div>


                            <div class="row" style="padding-top:15px;">
                                <div class="col-12 table-responsive-sm">
                                    <table id="detalleReferencias" class="table table-bordered ">
                                        @if ($referencias->count() > 0)
                                            @php
                                                $indRef = 0;
                                            @endphp
                                            <tbody>
                                                @foreach ($referencias as $ref)
                                                    <tr id="filaRe{{ $indRef }}">
                                                        <td>
                                                            @if ($tesis->estado != 1)
                                                                <a href="#" id="lref-{{ $indRef }}"
                                                                    class="btn btn-warning"
                                                                    onclick="deleteOldData(this);">X</a>
                                                            @endif
                                                            <input type="hidden" id="xlref-{{ $indRef }}"
                                                                value="{{ $obj->cod_referencias }}">
                                                        </td>
                                                        <td>{{ $ref->autor }}</td>
                                                        <td>{{ $ref->fPublicacion }}</td>
                                                        <td>{{ $ref->titulo }}</td>
                                                        <td>{{ $ref->fuente }}</td>
                                                        <td>{{ $ref->editorial }}</td>
                                                        <td>{{ $ref->title_cap }}</td>
                                                        <td>{{ $ref->num_capitulo }}</td>
                                                        <td>{{ $ref->title_revista }}</td>
                                                        <td>{{ $ref->volumen }}</td>
                                                        <td>{{ $ref->name_web }}</td>
                                                        <td>{{ $ref->name_periodista }}</td>
                                                        <td>{{ $ref->name_institucion }}</td>
                                                        <td>{{ $ref->subtitle }}</td>
                                                        <td>{{ $ref->name_editor }}</td>
                                                    </tr>
                                                    @php
                                                        $indRef++;
                                                    @endphp
                                                @endforeach
                                            </tbody>
                                        @endif
                                        <input type="hidden" name="listOldlref" id="listOldlref">
                                    </table>
                                </div>

                            </div>
                        </div>
                        <div class="row" style=" margin-bottom:20px;">
                            <h5>Anexos</h5>
                            <div class="row" style="margin-bottom:8px">
                                <div class="col-12 col-md-10">
                                    <textarea class="form-control" name="txtanexos[]" id="txtanexos">@if ($tesis->anexos != null){{$tesis->anexos}}@endif</textarea>
                                </div>
                                @if (sizeof($correciones) != 0 && $tesis->condicion == null)
                                    @if ($correciones[0]->anexos != null)
                                        <div class="col-2">
                                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                                data-bs-target="#mCorreccionAnexos">Correccion</button>
                                        </div>
                                    @endif
                                    {{-- Aqui va el modal --}}
                                   <div class="modal" id="mCorreccionAnexos">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Correccion de Anexos
                                                    </h4>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <!-- Modal body -->
                                                <div class="modal-body">
                                                    <div class="row" style="padding: 20px">
                                                        <div class="row my-2">
                                                            <textarea class="form-control" name="taNone" id="taNone" style="height: 200px; resize:none" readonly>{{ $correciones[0]->anexos }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Modal footer -->
                                                <div class="modal-footer">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <button type="button" class="btn btn-danger"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div id="anexos_contenedor" class="row m-3" hidden>
                                <input name="anexos_getImg" id="anexos_getImg" type="hidden" value="{{$anexosImg}}">
                                <input name="anexos_getTxt" id="anexos_getTxt" type="hidden" value="{{$tesis->anexos}}">
                                <input name="anexos_sendRow" id="anexos_sendRow" type="hidden">
                            </div>
                            <div class="col-12 m-1">
                                <button id="anexos_btn_addImage" class="btn btn-primary" type="button" onclick="addRowImage(this);">Agregar imagenes</button>
                                <button id="anexos_btn_addField" class="btn btn-outline-primary" type="button" onclick="addTextField(this);" hidden>Agregar campo</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <input type="hidden" name="isSaved" id="isSaved" value="">
                            </div>
                        </div>
                        <div class="row" style=" margin-bottom:20px;">

                            <div class="col-8 col-md-9" style="align-items:flex-start;">

                            </div>
                        </div>

                        <div class="row" style=" margin-bottom:20px;">
                            @if ($tesis->estado == 0 || $tesis->estado == 2 || $tesis->estado == 9)
                                <div class="col-4 col-md-2 ">
                                    <input type="button" class="btn btn-outline-success" value="Guardar"
                                        onclick="guardarCopia();">
                                </div>
                            @endif
                            <div class="col-8 col-md-9" style="align-items:flex-start;">

                                @if ($tesis->estado == 0 || $tesis->estado == 2 || $tesis->estado == 9)
                                    <input class="btn btn-success" type="button" value="Enviar"
                                        onclick="registerProject();">
                                @endif
                                <a href="{{ route('user_information') }}" type="button" class="btn btn-danger"
                                    style="margin-left:20px;">
                                    @if ($tesis->estado == 0 || $tesis->estado == 2)
                                        Cancelar
                                    @else
                                        Volver
                                    @endif
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
        {{-- modales --}}
        {{-- Modal para Objetivo --}}
        <div class="modal" id="mObjetivo">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Objetivo</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="row" style="padding: 20px">
                            <div class="row my-2">
                                <div class="col-6">
                                    <select class="form-select" id="cboObjetivo">
                                        <option selected>-</option>
                                        <option value="1">General</option>
                                        <option value="2">Especifico</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <textarea class="form-control" name="taObjetivo" id="taObjetivo" style="height: 200px; resize:none"></textarea>
                            </div>
                        </div>

                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-6">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            </div>
                            <div class="col-6">
                                <button type="button" class="btn btn-warning" onclick="agregarObjetivo();"
                                    data-bs-dismiss="modal">Guardar</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endif
@endsection
@section('js')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="./js/script-tesis-2022.js"></script>
    @if (session('datos') == 'oknot')
            <script>
                Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Error al guardar la Tesis',
                showConfirmButton: false,
                timer: 1500
                })
            </script>
    @endif
@endsection
