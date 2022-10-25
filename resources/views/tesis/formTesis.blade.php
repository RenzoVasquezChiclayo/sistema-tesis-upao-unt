@extends('plantilla.dashboard')
@section('titulo')
    Tesis
@endsection

@section('contenido')
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"> --}}
    <title>Tesis</title>
    <style type="text/css">
        .border-box{
            margin-bottom:8px;
            margin-left:5px;
            border: 0.5px solid rgba(0, 0, 0, 0.2);
            border-radius:20px;
            padding-top:5px;
            padding-bottom:10px;
        }

        .box-autor{
            height: 25px;
            font-size:1.2vh;
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        .card-box {
            display: flex;
            flex-wrap: wrap;
        }
        .item-card {
            flex: 1 1 300px;
        }
        .item-card2 {
            flex: 1 1 500px;
        }
        .alert-correction{
            border: 1px solid green;
            border-radius: 10px;
        }
    </style>
<body>

    @if ($validar == true)

        <div class="row" style="display:flex; align-items:center; justify-content: center; margin-top:15px;">
            <div class="col-8 border-box">
                <div class="row">
                    <div class="col-12">
                        <h4 style="color:red;">Aviso!</h4>
                        <hr style="border: 1px solid black;" />
                    </div>
                    <div class="col-12">
                        <p>Esta vista estara habilitada cuando llene su Formato de Titulo. Vuelve luego para observar si ya se proceso tu solicitud.
                            Si existe algun inconveniente y/o queja envia un correo a <a href="#"><u>example@unitru.edu.pe</u></a> para mas informacion.</p>
                    </div>

                </div>
            </div>
        </div>
    @elseif ($formato[0]->cod_docente == null)
        <div class="row" style="display:flex; align-items:center; justify-content: center; margin-top:15px;">
            <div class="col-8 border-box">
                <div class="row">
                    <div class="col-12">
                        <h4 style="color:red;">Aviso!</h4>
                        <hr style="border: 1px solid black;" />
                    </div>
                    <div class="col-12">
                        <p>Esta vista estara habilitada cuando el director de escuela te designe algun asesor. Vuelve luego para observar si ya se proceso tu solicitud.
                            Si existe algun inconveniente y/o queja envia un correo a <a href="#"><u>example@unitru.edu.pe</u></a> para mas informacion.</p>
                    </div>

                </div>
            </div>
        </div>
    @else

    <div class="" style="background-color:rgb(212, 212, 212)">
        @if ($tesis[0]->condicion == 'APROBADO')
        <div class="row" style="padding:10px; background-color: green;">
            <div class="col-12 col-md-12 alert-correction" style="text-align: center;">
                <p>PROYECTO APROBADO</p>
            </div>
        </div>
        @elseif($tesis[0]->condicion == 'DESAPROBADO')
        <div class="row" style="padding:10px; background-color: red;">
            <div class="col-12 col-md-6 alert-correction" style="text-align: center;">
                <p>PROYECTO DESAPROBADO</p>
            </div>
        </div>
        @elseif (sizeof($correciones)!=0)
            <div class="row" style="padding:10px; text-align:center;">
                <div class="col-12 col-md-6 alert-correction">
                    <p>Se realizaron las correciones correspondientes.</p>
                </div>
            </div>
        @endif
        <div class="row" style="text-align: center; padding:10px;">
            <div class="col-12" style="align-items: center">
                <h2>Registro de Proyectos</h2>
            </div>
        </div>
        <div class="row">
            <form id="formTesis" name="formTesis" action="" method="">
                @csrf
                <div class="col-8">
                    <h4 >GENERALIDADES</h4>
                    <hr style="border:1 px black;">
                    @php
                        $varextra1="true";
                    @endphp
                    <input id="verificaCorrect" type="hidden" value="@if(sizeof($correciones)>0){{$varextra1}}@endif">
                    @php
                        $valuesObs = "";
                        for($i = 0; $i<sizeof($detalles);$i++) {
                            if($i == 0){
                                $valuesObs = $detalles[$i]->tema_referido;
                            }else{
                                $valuesObs = $valuesObs.",".$detalles[$i]->tema_referido;
                            }
                        }
                    @endphp
                    <input type="hidden" id="txtValuesObs" value="{{$valuesObs}}">

                </div>
                <div class="col-12">
                    <div class="row" style=" margin-bottom:10px">
                        <h5>Titulo</h5>
                        <div class="12">
                            <div class="row" style="margin-bottom:8px">
                                <div class="col-12 col-md-10" style="margin-bottom:10px;">
                                    <div class="row">
                                        <div class="col-9">
                                                <input class="form-control" name="txttitulo" id="txttitulo" type="text" value="@if($tesis[0]->titulo!=""){{$tesis[0]->titulo}}@endif" placeholder="Ingrese el titulo del proyecto"
                                                    @if (($correciones->count()>0 && $correciones[0]->titulo==null) || $tesis[0]->estado == 1)
                                                        readonly
                                                    @endif required>
                                                <span id="validateTitle" name="validateTitle" style="color: red"></span>
                                        </div>
                                        <div class="col-3">
                                            <input type="button" value="Verificar" onclick="validaText();" class="btn btn-success"
                                            @if (($correciones->count()>0 && $correciones[0]->titulo==null) || $tesis[0]->estado == 1)
                                                disabled
                                            @endif>
                                        </div>
                                    </div>
                                </div>
                                @if (sizeof($correciones)!=0 && $tesis[0]->condicion == null)
                                    @if($correciones[0]->titulo!=null)
                                        <div class="col-2">
                                            <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#mCorreccionTitulo">Correccion</button>
                                        </div>
                                    @endif
                                    {{-- Aqui va el modal --}}
                                    <div class="modal" id="mCorreccionTitulo">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Correccion del titulo</h4>
                                                    <button type="button" class="btn-close" data-dismiss="modal"></button>
                                                </div>
                                                <!-- Modal body -->
                                                <div class="modal-body">
                                                    <div class="row" style="padding: 20px">
                                                        <div class="row my-2">
                                                            <textarea class="form-control" name="taVariable" id="taNone" style="height: 200px; resize:none" readonly>{{$correciones[0]->titulo}}</textarea>
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
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style=" margin-bottom:20px; padding-right:12px;">
                    <h5>Autor</h5>
                    <div class="row" style="margin-bottom:8px;">
                        <div class="row">
                            <div class="col-5 col-md-3">
                                <input class="form-control" name="txtCodMatricula" id="txtCodMatricula" type="search" value="{{$autor->cod_matricula}}" placeholder="Codigo de Matricula" readonly>
                            </div>
                        </div>
                    </div>

                    {{--Informacion del egresado--}}
                    {{-- style="display: grid; grid-template-columns: repeat(3, 1fr); grid-gap: 5px; " --}}
                    <div class="row border-box card-box" >
                        <div class="item-card">
                            <label for="txtNombreAutor" class="form-label">Nombres</label>
                            <input class="form-control" name="txtNombreAutor" id="txtNombreAutor" type="text" value="{{$autor->nombres}}" placeholder="Nombres" readonly>
                        </div>
                        <div class="item-card">
                            <label for="txtApellidoAutor" class="form-label">Apellidos</label>
                            <input class="form-control" name="txtApellidoAutor" id="txtApellidoAutor" type="text" value="{{$autor->apellidos}}" placeholder="Apellidos" readonly>
                        </div>
                        <div class="item-card">
                            <label for="cboEscuela" class="form-label">Escuela</label>
                            <input class="form-control" name="txtEscuelaAutor" id="txtEscuelaAutor" type="text" value="{{$formato[0]->name_escuela}}" placeholder="Escuela" readonly>
                        </div>
                        <div class="item-card">
                            <label for="txtDireccionAutor" class="form-label">Direccion</label>
                            <input class="form-control" name="txtDireccionAutor" id="txtDireccionAutor" type="text" value="{{$formato[0]->direccion}}" placeholder="Direccion del domicilio" readonly>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-bottom:20px; padding-right:12px;">
                    <h5>Asesor</h5>
                    <div class="row" style="margin-bottom:8px;">
                        <div class="row">
                            <div class="col-5 col-md-3">
                                <input class="form-control" name="txtCodDocente" id="txtCodDocente" type="text" value="{{$asesor->cod_docente}}" placeholder="Codigo del Docente" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row border-box card-box">
                        <div class="item-card">
                            <label for="txtNombreAsesor" class="form-label">Apellidos y Nombres</label>
                            <input class="form-control" name="txtNombreAsesor" id="txtNombreAsesor" type="text" value="{{$asesor->nombres}}" placeholder="Apellidos y nombres" readonly>
                        </div>
                        <div class="item-card">
                            <label for="cboGrAcademicoAsesor" class="form-label">Grado Academico</label>
                            <input class="form-control" name="txtGrAcademicoAsesor" id="txtGrAcademicoAsesor" type="text" value="{{$asesor->grado_academico}}" placeholder="Grado academico" readonly>
                        </div>
                        <div class="item-card">
                            <label for="txtTProfesional" class="form-label">Titulo Profesional</label>
                            <input class="form-control" name="txtTProfesional" id="txtTProfesional" type="text" value="{{$asesor->titulo_profesional}}" placeholder="Titulo profesional" readonly>
                        </div>
                        <div class="item-card">
                            <label for="txtDireccionAsesor" class="form-label">Dirección laboral y/o domiciliaria</label>
                            <input class="form-control" name="txtDireccionAsesor" id="txtDireccionAsesor" type="text" value="{{$asesor->direccion}}" placeholder="Direccion laboral y/o domiciliaria" readonly>
                        </div>
                    </div>
                </div>

                <div class="row" style=" margin-bottom:20px; padding-right:12px;">
                    <h5>Tipo de Investigacion</h5>
                    <div class="row border-box card-box" style="margin-bottom:8px">
                        <div class="item-card">
                            <label for="cboTipoInvestigacion" class="form-label">Linea de Investigacion</label>
                            <input class="form-control" type="text" name="cboTipoInvestigacion" id="cboTipoInvestigacion" value="{{$formato[0]->descripcion}}" readonly>
                            <input type="hidden" name="txtTipoInvestigacion" value="{{$formato[0]->cod_tinvestigacion}}">
                        </div>
                        <div class="item-card">
                            <label for="cboFinInvestigacion" class="form-label">De acuerdo al fin que se persigue</label>
                            <select name="txtti_finpersigue" id="cboFinInvestigacion" class="form-select"
                            @if($tesis[0]->ti_finpersigue !=null)disabled @endif
                            >
                                <option value="-" selected>-</option>
                                <option value="Basica" @if($tesis[0]->ti_finpersigue =='Basica')selected @endif>Basica</option>
                                <option value="Aplicada" @if($tesis[0]->ti_finpersigue =='Aplicada')selected @endif>Aplicada</option>
                            </select>
                        </div>
                        <div class="item-card">
                            <label for="cboDesignInvestigacion" class="form-label">De acuerdo al diseño de investigación</label>
                            <select name="txtti_disinvestigacion" id="cboDesignInvestigacion" class="form-select"
                            @if($tesis[0]->ti_disinvestigacion!=null)disabled @endif
                            >
                                <option value="-" selected>-</option>
                                <option value="Descriptiva" @if($tesis[0]->ti_disinvestigacion=='Descriptiva')selected @endif>Descriptiva</option>
                                <option value="Explicativa" @if($tesis[0]->ti_disinvestigacion=='Explicativa')selected @endif>Explicativa</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-bottom:20px; padding-right:12px;">
                    <div class="col-12 col-md-8">
                        <div class="row border-box" style="margin-left:0px;">
                            <h5>Localidad e Institucion</h5>
                            <div class="row car-box" style="margin-bottom:8px">

                                    <div class="item-card">
                                        <label for="txtLocalidad" class="form-label">Localidad</label>
                                        <input class="form-control" name="txtlocalidad" id="txtLocalidad" type="text" value="@if($tesis[0]->localidad!=""){{$tesis[0]->localidad}}@endif" placeholder="Localidad"
                                        @if (($correciones->count()>0 && $correciones[0]->localidad_institucion==null) || $tesis[0]->estado == 1)
                                            readonly
                                        @endif required>

                                    </div>
                                    <div class="item-card">
                                        <label for="txtInstitucion" class="form-label">Institucion</label>
                                        <input class="form-control" name="txtinstitucion" id="txtInstitucion" type="text" value="@if($tesis[0]->institucion!=""){{$tesis[0]->institucion}}@endif" placeholder="Institucion"
                                        @if (($correciones->count()>0 && $correciones[0]->localidad_institucion==null) || $tesis[0]->estado == 1)
                                            readonly
                                        @endif required>
                                    </div>


                                @if (sizeof($correciones)!=0  && $tesis[0]->condicion == null)
                                    @if($correciones[0]->localidad_institucion!=null)
                                        <div class="item-card" style="padding-top:10px;">
                                            <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#mCorreccionLocalInsti">Correccion</button>
                                        </div>
                                    @endif
                                    {{-- Aqui va el modal --}}
                                    <div class="modal" id="mCorreccionLocalInsti">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Correccion de Localidad e Institucion</h4>
                                                    <button type="button" class="btn-close" data-dismiss="modal"></button>
                                                </div>
                                                <!-- Modal body -->
                                                <div class="modal-body">
                                                    <div class="row" style="padding: 20px">
                                                        <div class="row my-2">
                                                            <textarea class="form-control" name="taNone" id="taNone" style="height: 200px; resize:none" readonly>{{$correciones[0]->localidad_institucion}}</textarea>
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
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="row border-box">
                            <h5>Duración de la ejecución del proyecto</h5>
                            <div class="row" style="margin-bottom:8px">
                                <div class="col-9 col-lg-8">
                                    <label for="txtmeses_ejecucion" class="form-label">Numero de meses</label>
                                    <div class="row">
                                        <div class="col-10">
                                            <input class="form-control" name="txtmeses_ejecucion" id="txtmeses_ejecucion" type="number" onkeypress="return isNumberKey(this);" value="@if($tesis[0]->meses_ejecucion!=""){{$tesis[0]->meses_ejecucion}}@endif" placeholder="00" min="0"
                                            @if (($correciones->count()>0 && $correciones[0]->meses_ejecucion==null) || $tesis[0]->estado == 1)
                                                readonly
                                            @endif required>
                                            <input type="hidden" id="valuesMesesPart" value="{{$tesis[0]->t_ReparacionInstrum}},{{$tesis[0]->t_RecoleccionDatos}},{{$tesis[0]->t_AnalisisDatos}},{{$tesis[0]->t_ElaboracionInfo}}">
                                        </div>
                                        <div class="col-2">
                                            <input type="button" class="btn btn-success" value="Set" id="setMes" name="setMes" onclick="setMeses();"
                                            @if (($correciones->count()>0 && $correciones[0]->meses_ejecucion==null) || $tesis[0]->estado == 1)
                                                disabled
                                            @endif>
                                        </div>
                                    </div>

                                </div>
                                @if (sizeof($correciones)!=0 && $tesis[0]->condicion == null)
                                    @if($correciones[0]->meses_ejecucion!=null)
                                        <div class="col-2" style="padding-top:10px;">
                                            <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#mCorreccionMeses">Correccion</button>
                                        </div>
                                    @endif
                                    {{-- Aqui va el modal --}}
                                    <div class="modal" id="mCorreccionMeses">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Correccion de Meses de ejecucion</h4>
                                                    <button type="button" class="btn-close" data-dismiss="modal"></button>
                                                </div>
                                                <!-- Modal body -->
                                                <div class="modal-body">
                                                    <div class="row" style="padding: 20px">
                                                        <div class="row my-2">
                                                            <textarea class="form-control" name="taNone" id="taNone" style="height: 200px; resize:none" readonly>{{$correciones[0]->meses_ejecucion}}</textarea>
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
                                @endif

                            </div>
                        </div>
                    </div>

                </div>
                {{-- Tabla para clickear los meses correspondientes al cronograma de trabajo --}}
                <div class="row" style=" margin-bottom:20px">
                    <div class="row">
                        <div class="col-8">
                            <h5>Cronograma de trabajo</h5>
                        </div>
                    </div>

                    <div class="row" style="padding-left:20px; padding-right:20px; margin-bottom:8px">
                        <table class="table table-bordered border-dark">
                            <thead>
                              <tr id="headers">
                                <th scope="col">ACTIVIDAD</th>
                              </tr>
                            </thead>
                            <tbody>

                              <tr id="1Tr" >

                                <td>Preparación de instrumentos de recolección de datos</td>
                              </tr>
                              <tr id="2Tr">

                                <td>Recolección de datos</td>
                              </tr>
                              <tr id="3Tr">

                                <td>Análisis de datos</td>
                              </tr>
                              <tr id="4Tr">

                                <td>Elaboración del informe</td>
                              </tr>
                            </tbody>
                        </table>
                        <input type="hidden" value="" id="listMonths" name="listMonths">
                    </div>
                </div>

                <div class="row" style="margin-bottom:20px">
                    <h5>Recursos</h5>

                    <div class="col-8 col-md-5 col-xl-3">
                        <div class="row border-box" style="margin-bottom:20px"
                        @if (($correciones->count()>0 && $correciones[0]->recursos==null) || $tesis[0]->estado==1)
                            hidden
                        @endif>
                            <div class="col-6" style="text-align:center">
                                <p>Agregar un recurso</p>
                            </div>
                            <div class="col-6">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#mRecurso">
                                    Agregar
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:8px">
                        <div class="col-12">
                            {{-- Tabla para insertar los recursos usados --}}
                            <table id="recursosTable" class="table table-striped table-bordered table-condensed table-hover" >
                                <thead>
                                    <tr>
                                        <th>Tipo</th>
                                        <th>Subtipo</th>
                                        <th>Descripcion</th>
                                        <th>Accion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if (sizeof($recursos)>0)
                                    @php
                                        $indRec = 0;
                                    @endphp
                                    @foreach ($recursos as $rec)
                                        <tr id="filaR{{$indRec}}">
                                            <td>{{$rec->tipo}}</td>
                                            <td>{{$rec->subtipo}}</td>
                                            <td>{{$rec->descripcion}}</td>
                                            <td>
                                            @if(sizeof($correciones)>0)
                                                @if($correciones[0]->recursos != null && $tesis[0]->condicion == null)
                                                <a href="#" id="lrec-{{$indRec}}" class="btn btn-warning" onclick="deleteOldRecurso(this);">X</a>
                                                @endif

                                            @endif
                                                <input type="hidden" id="xlrec-{{$indRec}}" value="{{$rec->cod_recurso}}">
                                            </td>
                                        </tr>
                                        @php
                                            $indRec++;
                                        @endphp
                                    @endforeach
                                    <input type="hidden" id="valNRecurso" value="{{sizeof($recursos)}}">
                                    <input type="hidden" name="listOldlrec" id="listOldlrec">
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if (sizeof($correciones)!=0 && $tesis[0]->condicion == null)
                        @if($correciones[0]->recursos!=null)
                            <div class="col-2 col-lg-4" style="padding-top:10px;">
                                <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#mRecursos">Correccion</button>
                            </div>
                        @endif
                        {{-- Aqui va el modal --}}
                        <div class="modal" id="mRecursos">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Correccion de Recursos</h4>
                                        <button type="button" class="btn-close" data-dismiss="modal"></button>
                                    </div>
                                    <!-- Modal body -->
                                    <div class="modal-body">
                                        <div class="row" style="padding: 20px">
                                            <div class="row my-2">
                                                <textarea class="form-control" name="taNone" id="taNone" style="height: 200px; resize:none" readonly>{{$correciones[0]->recursos}}</textarea>
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
                    @endif

                </div>

                <div class="row" style="margin-bottom:20px">
                    <div class="col-12">
                        <hr style="border: 1px solid gray">
                    </div>
                    <h5>Presupuesto</h5>
                    {{--Tabla resumen del presupuesto--}}
                    <div class="row" style="margin-bottom:8px; padding-left:25px;">
                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Codigo</th>
                                    <th>Denominacion</th>
                                    <th>Precio Total</th>
                                </tr>
                            </thead>
                            @php
                                $i = 0;
                                $total = 0;
                            @endphp
                            <tbody>

                                @foreach ($presupuestos as $presupuesto)
                                    <tr>
                                        <th>{{$presupuesto->codeUniversal}}</th>
                                        <td>{{$presupuesto->denominacion}}</td>
                                        <td>S/. <input type="number" id="cod_{{$i}}" name="cod_{{$i}}" min="0" value=@if($presupuestoProy->count()>0)"{{$presupuestoProy[$i]->precio}}"@else "0" @endif
                                            @if ($correciones->count()>0 || $tesis[0]->estado==1)
                                                readonly
                                            @endif>.00</td>
                                    </tr>
                                    @php
                                        $i++;
                                    @endphp
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="2" style="text-align: right;"><input type="button" class="btn btn-success" onclick="verTotal();" value="Total"
                                        @if ($tesis[0]->titulo!=null)
                                            disabled
                                        @endif
                                        ></th>
                                    <th>
                                        S/.<input type="text" id="total" name="total" value=
                                        @if ($tesis[0]->titulo!=null)
                                            "{{$presupuestoProy[0]->precio+$presupuestoProy[1]->precio+$presupuestoProy[2]->precio+$presupuestoProy[3]->precio+$presupuestoProy[4]->precio}}"
                                            readonly
                                        @endif
                                        >.00
                                    </th>
                                    <input type="hidden" id="precios" name="precios" value="{{$i}}">
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div class="row" style="margin-bottom:20px">
                    <h5>Financiamiento </h5>
                    <div class="row" style="margin-bottom:8px">
                        <div class="col-8 col-md-5">
                            <select name="txtfinanciamiento" id="cboFinanciamiento" class="form-select" @if($tesis[0]->financiamiento !=null)disabled @endif>
                                <option selected>-</option>
                                <option value="Con recursos propios" @if($tesis[0]->financiamiento=='Con recursos propios')selected @endif>Con recursos propios</option>
                                <option value="Con recursos de la UNT" @if($tesis[0]->financiamiento=='Con recursos de la UNT')selected @endif>Con recursos de la UNT</option>
                                <option value="Con recursos externos" @if($tesis[0]->financiamiento=='Con recursos externos')selected @endif>Con recursos externos</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-8">
                    <h4>PLAN DE INVESTIGACION</h4>
                    <hr style="border:1 px black;">
                </div>

                <div class="row" style=" margin-bottom:20px">
                    <h5>Realidad problematica </h5>
                    <div class="row" style="margin-bottom:8px">
                        <div class="col-12 col-md-10">
                            <div class="form-floating">
                                <textarea class="form-control" name="txtreal_problematica" id="txtreal_problematica" style="height: 100px; resize:none"
                                @if (($correciones->count()>0 && $correciones[0]->real_problematica==null) || $tesis[0]->estado == 1)
                                    readonly
                                @endif required>@if($tesis[0]->real_problematica!=""){{$tesis[0]->real_problematica}}@endif</textarea>
                            </div>
                        </div>
                        @if (sizeof($correciones)!=0 && $tesis[0]->condicion == null)
                            @if($correciones[0]->real_problematica!=null)
                                <div class="col-2">
                                    <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#mCorreccionRProbl">Correccion</button>
                                </div>
                            @endif
                            {{-- Aqui va el modal --}}
                            <div class="modal" id="mCorreccionRProbl">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Correccion de Realidad problematica</h4>
                                            <button type="button" class="btn-close" data-dismiss="modal"></button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            <div class="row" style="padding: 20px">
                                                <div class="row my-2">
                                                    <textarea class="form-control" name="taNone" id="taNone" style="height: 200px; resize:none" readonly>{{$correciones[0]->real_problematica}}</textarea>
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
                        @endif
                    </div>
                </div>
                <div class="row" style=" margin-bottom:20px">
                    <h5>Antecedentes</h5>
                    <div class="row" style="margin-bottom:8px">
                        <div class="col-12 col-md-10">
                            <div class="form-floating">
                                <textarea class="form-control" name="txtantecedentes" id="txtantecedentes" style="height: 100px; resize:none"
                                @if (($correciones->count()>0 && $correciones[0]->antecedentes==null) || $tesis[0]->estado == 1)
                                    readonly
                                @endif required>@if($tesis[0]->antecedentes!=""){{$tesis[0]->antecedentes}}@endif</textarea>
                            </div>
                        </div>
                        @if (sizeof($correciones)!=0 && $tesis[0]->condicion == null)
                            @if($correciones[0]->antecedentes!=null)
                            <div class="col-2">
                                <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#mCorreccionAntecedente">Correccion</button>
                            </div>
                            @endif
                            {{-- Aqui va el modal --}}
                            <div class="modal" id="mCorreccionAntecedente">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Correccion de antecedentes</h4>
                                            <button type="button" class="btn-close" data-dismiss="modal"></button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            <div class="row" style="padding: 20px">
                                                <div class="row my-2">
                                                    <textarea class="form-control" name="taNone" id="taNone" style="height: 200px; resize:none" readonly>{{$correciones[0]->antecedentes}}</textarea>
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
                        @endif
                    </div>
                </div>
                <div class="row" style=" margin-bottom:20px">
                    <h5>Justificación de la investigación</h5>
                    <div class="row" style="margin-bottom:8px">
                        <div class="col-12 col-md-10">
                            <div class="form-floating">
                                <textarea class="form-control" name="txtjustificacion" id="txtjustificacion" style="height: 100px; resize:none"
                                @if (($correciones->count()>0 && $correciones[0]->justificacion==null) || $tesis[0]->estado == 1)
                                    readonly
                                @endif required>@if($tesis[0]->justificacion!=""){{$tesis[0]->justificacion}}@endif</textarea>
                            </div>
                        </div>
                        @if (sizeof($correciones)!=0 && $tesis[0]->condicion == null)
                            @if($correciones[0]->justificacion!=null)
                            <div class="col-2">
                                <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#mCorreccionJInv">Correccion</button>
                            </div>
                            @endif
                            {{-- Aqui va el modal --}}
                            <div class="modal" id="mCorreccionJInv">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Correccion de justificacion de la investigacion</h4>
                                            <button type="button" class="btn-close" data-dismiss="modal"></button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            <div class="row" style="padding: 20px">
                                                <div class="row my-2">
                                                    <textarea class="form-control" name="taNone" id="taNone" style="height: 200px; resize:none" readonly>{{$correciones[0]->justificacion}}</textarea>
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
                        @endif
                    </div>
                </div>
                <div class="row" style=" margin-bottom:20px">
                    <h5>Formulación del problema</h5>
                    <div class="row" style="margin-bottom:8px">
                        <div class="col-12 col-md-10">
                            <div class="form-floating">
                                <textarea class="form-control" name="txtformulacion_prob" id="txtformulacion_prob" style="height: 100px; resize:none"
                                @if (($correciones->count()>0 && $correciones[0]->formulacion_prob==null) || $tesis[0]->estado == 1)
                                    readonly
                                @endif required>@if($tesis[0]->formulacion_prob!=""){{$tesis[0]->formulacion_prob}}@endif</textarea>
                            </div>
                        </div>
                        @if (sizeof($correciones)!=0 && $tesis[0]->condicion == null)
                            @if($correciones[0]->formulacion_prob!=null)
                            <div class="col-2">
                                <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#mCorreccionFProbl">Correccion</button>
                            </div>
                            @endif
                            {{-- Aqui va el modal --}}
                            <div class="modal" id="mCorreccionFProbl">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Correccion de Formulacion del problema</h4>
                                            <button type="button" class="btn-close" data-dismiss="modal"></button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            <div class="row" style="padding: 20px">
                                                <div class="row my-2">
                                                    <textarea class="form-control" name="taNone" id="taNone" style="height: 200px; resize:none" readonly>{{$correciones[0]->formulacion_prob}}</textarea>
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
                        @endif
                    </div>
                </div>
                <div class="row" style=" margin-bottom:20px">
                    <h5>Objetivos</h5>
                        <div class="col-8 col-md-5 col-xl-3">
                            <div class="row border-box" style="margin-bottom:20px"
                            @if (($correciones->count()>0 && $correciones[0]->recursos==null) || $tesis[0]->estado==1)
                                hidden
                            @endif>
                                <div class="col-7 col-md-6" style="text-align:center">
                                    <p>Agregar un objetivo</p>
                                </div>
                                <div class="col-5 col-md-6">
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#mObjetivo">
                                        Agregar
                                    </button>

                                </div>
                            </div>
                        </div>
                    @if (sizeof($correciones)!=0 && $tesis[0]->condicion == null)
                        @if($correciones[0]->objetivos!=null)
                        <div class="col-2">
                            <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#mCorreccionObjetivo">Correccion</button>
                        </div>
                        @endif
                        {{-- Aqui va el modal --}}
                        <div class="modal" id="mCorreccionObjetivo">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Correccion de Objetivos</h4>
                                        <button type="button" class="btn-close" data-dismiss="modal"></button>
                                    </div>
                                    <!-- Modal body -->
                                    <div class="modal-body">
                                        <div class="row" style="padding: 20px">
                                            <div class="row my-2">
                                                <textarea class="form-control" name="taNone" id="taNone" style="height: 200px; resize:none" readonly>{{$correciones[0]->objetivos}}</textarea>
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
                    @endif
                    <div class="row" style="margin-bottom:8px">
                        <div class="col-12">
                            {{-- Tabla para insertar los recursos usados --}}
                            <table id="objetivoTable" class="table table-striped table-bordered table-condensed table-hover" >
                                <thead>
                                    <tr>
                                        <th>Tipo</th>
                                        <th>Subtipo</th>
                                        <th>Accion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if (sizeof($objetivos)>0)
                                    @php
                                        $indObj = 0;
                                    @endphp

                                    @foreach ($objetivos as $obj)
                                        <tr id="filaO{{$indObj}}">
                                            <td>{{$obj->tipo}}</td>
                                            <td>{{$obj->descripcion}}</td>
                                            <td>
                                            @if(sizeof($correciones)>0)
                                                @if($correciones[0]->objetivos != null && $tesis[0]->condicion == null)
                                                <a href="#" id="lobj-{{$indObj}}" class="btn btn-warning" onclick="deleteOldRecurso(this);">X</a>
                                                @endif

                                            @endif
                                                <input type="hidden" id="xlobj-{{$indObj}}" value="{{$obj->cod_objetivo}}">
                                            </td>
                                        </tr>
                                        @php
                                            $indObj++;
                                        @endphp
                                    @endforeach
                                    <input type="hidden" id="valNObjetivo" value="{{sizeof($objetivos)}}">
                                    <input type="hidden" name="listOldlobj" id="listOldlobj">
                                @endif
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
                            <div class="form-floating">
                                <textarea class="form-control" name="txtmarco_teorico" id="txtmarco_teorico" style="height: 100px; resize:none"
                                @if (($correciones->count()>0 && $correciones[0]->marco_teorico==null) || $tesis[0]->estado == 1)
                                    readonly
                                @endif required>@if($tesis[0]->marco_teorico!=""){{$tesis[0]->marco_teorico}}@endif</textarea>
                            </div>
                        </div>
                        @if (sizeof($correciones)!=0 && $tesis[0]->condicion == null)
                            @if($correciones[0]->marco_teorico!=null)
                            <div class="col-2">
                                <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#mCorreccionMTeorico">Correccion</button>
                            </div>
                            @endif
                            {{-- Aqui va el modal --}}
                            <div class="modal" id="mCorreccionMTeorico">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Correccion de Marco teorico</h4>
                                            <button type="button" class="btn-close" data-dismiss="modal"></button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            <div class="row" style="padding: 20px">
                                                <div class="row my-2">
                                                    <textarea class="form-control" name="taNone" id="taNone" style="height: 200px; resize:none" readonly>{{$correciones[0]->marco_teorico}}</textarea>
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
                        @endif
                    </div>

                    <div class="row" style="margin-bottom:15px">
                        <h5>Marco Conceptual</h5>
                        <div class="col-12 col-md-10">
                            <div class="form-floating">
                                <textarea class="form-control" name="txtmarco_conceptual" id="txtmarco_conceptual" style="height: 100px; resize:none"
                                @if (($correciones->count()>0 && $correciones[0]->marco_conceptual==null) || $tesis[0]->estado == 1)
                                    readonly
                                @endif required>@if($tesis[0]->marco_conceptual!=""){{$tesis[0]->marco_conceptual}}@endif</textarea>
                            </div>
                        </div>
                        @if (sizeof($correciones)!=0 && $tesis[0]->condicion == null)
                            @if($correciones[0]->marco_conceptual!=null)
                            <div class="col-2">
                                <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#mCorreccionMConceptual">Correccion</button>
                            </div>
                            @endif
                            {{-- Aqui va el modal --}}
                            <div class="modal" id="mCorreccionMConceptual">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Correccion de Marco conceptual</h4>
                                            <button type="button" class="btn-close" data-dismiss="modal"></button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            <div class="row" style="padding: 20px">
                                                <div class="row my-2">
                                                    <textarea class="form-control" name="taNone" id="taNone" style="height: 200px; resize:none" readonly>{{$correciones[0]->marco_conceptual}}</textarea>
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
                        @endif
                    </div>

                    <div class="row" style="margin-bottom:15px">
                        <h5>Marco Legal (Opcional)</h5>
                        <div class="col-12 col-md-10">
                            <div class="form-floating">
                                <textarea class="form-control" name="txtmarco_legal" id="txtmarco_legal" style="height: 100px; resize:none"
                                @if (($correciones->count()>0 && $correciones[0]->marco_legal==null) || $tesis[0]->estado == 1)
                                    readonly
                                @endif required>@if($tesis[0]->marco_legal!=""){{$tesis[0]->marco_legal}}@endif</textarea>
                            </div>
                        </div>
                        @if (sizeof($correciones)!=0 && $tesis[0]->condicion == null)
                            @if($correciones[0]->marco_legal!=null)
                            <div class="col-2">
                                <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#mCorreccionMLegal">Correccion</button>
                            </div>
                            @endif
                            {{-- Aqui va el modal --}}
                            <div class="modal" id="mCorreccionMLegal">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Correccion de Marco Legal</h4>
                                            <button type="button" class="btn-close" data-dismiss="modal"></button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            <div class="row" style="padding: 20px">
                                                <div class="row my-2">
                                                    <textarea class="form-control" name="taNone" id="taNone" style="height: 200px; resize:none" readonly>{{$correciones[0]->marco_legal}}</textarea>
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
                        @endif
                    </div>
                </div>

                <div class="row" style=" margin-bottom:20px">
                    <h5>Formulación de la hipótesis </h5>
                    <div class="row" style="margin-bottom:8px">
                        <div class="col-12 col-md-10">
                            <div class="form-floating">
                                <textarea class="form-control" name="txtform_hipotesis" id="txtform_hipotesis" style="height: 100px; resize:none"
                                @if (($correciones->count()>0 && $correciones[0]->form_hipotesis==null) || $tesis[0]->estado == 1)
                                    readonly
                                @endif required>@if($tesis[0]->form_hipotesis!=""){{$tesis[0]->form_hipotesis}}@endif</textarea>
                            </div>
                        </div>
                        @if (sizeof($correciones)!=0 && $tesis[0]->condicion == null)
                            @if($correciones[0]->form_hipotesis!=null)
                            <div class="col-2">
                                <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#mCorreccionFHipotesis">Correccion</button>
                            </div>
                            @endif
                            {{-- Aqui va el modal --}}
                            <div class="modal" id="mCorreccionFHipotesis">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Correccion de Formulacion de la hipotesis</h4>
                                            <button type="button" class="btn-close" data-dismiss="modal"></button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            <div class="row" style="padding: 20px">
                                                <div class="row my-2">
                                                    <textarea class="form-control" name="taNone" id="taNone" style="height: 200px; resize:none" readonly>{{$correciones[0]->form_hipotesis}}</textarea>
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
                        @endif
                    </div>
                </div>

                <div class="row" style=" margin-bottom:20px">
                    <div class="row">
                        {{-- Punto Diseno de Investigacion y demas subtemas --}}
                        <h5>Diseño de Investigación</h5>
                        <h6>Material, Métodos y Técnicas</h6>
                        <hr style="width: 60%; margin-left:15px;"/>
                    </div>
                    <div class="row" style="margin-bottom:8px">
                        <label for="txtobjeto_estudio" class="form-label">Objeto de Estudio</label>
                        <div class="col-12 col-md-10">
                            <div class="form-floating">
                                <textarea class="form-control" name="txtobjeto_estudio" id="txtobjeto_estudio" style="height: 100px; resize:none"
                                @if (($correciones->count()>0 && $correciones[0]->objeto_estudio==null) || $tesis[0]->estado == 1)
                                    readonly
                                @endif required>@if($tesis[0]->objeto_estudio!=""){{$tesis[0]->objeto_estudio}}@endif</textarea>
                            </div>
                        </div>
                        @if (sizeof($correciones)!=0 && $tesis[0]->condicion == null)
                            @if($correciones[0]->objeto_estudio!=null)
                            <div class="col-2">
                                <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#mCorreccionOEstudio">Correccion</button>
                            </div>
                            @endif
                            {{-- Aqui va el modal --}}
                            <div class="modal" id="mCorreccionOEstudio">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Correccion del Objeto de Estudio</h4>
                                            <button type="button" class="btn-close" data-dismiss="modal"></button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            <div class="row" style="padding: 20px">
                                                <div class="row my-2">
                                                    <textarea class="form-control" name="taNone" id="taNone" style="height: 200px; resize:none" readonly>{{$correciones[0]->objeto_estudio}}</textarea>
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
                        @endif
                    </div>
                    <div class="row" style="margin-bottom:8px">
                        <label for="txtpoblacion" class="form-label">Población</label>
                        <div class="col-12 col-md-10">
                            <div class="form-floating">
                                <textarea class="form-control" name="txtpoblacion" id="txtpoblacion" style="height: 100px; resize:none"
                                @if (($correciones->count()>0 && $correciones[0]->poblacion==null) || $tesis[0]->estado == 1)
                                    readonly
                                @endif required>@if($tesis[0]->poblacion!=""){{$tesis[0]->poblacion}}@endif</textarea>
                            </div>
                        </div>
                        @if (sizeof($correciones)!=0 && $tesis[0]->condicion == null)
                            @if($correciones[0]->poblacion!=null)
                            <div class="col-2">
                                <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#mCorreccionPoblacion">Correccion</button>
                            </div>
                            @endif
                            {{-- Aqui va el modal --}}
                            <div class="modal" id="mCorreccionPoblacion">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Correccion de Poblacion</h4>
                                            <button type="button" class="btn-close" data-dismiss="modal"></button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            <div class="row" style="padding: 20px">
                                                <div class="row my-2">
                                                    <textarea class="form-control" name="taNone" id="taNone" style="height: 200px; resize:none" readonly>{{$correciones[0]->poblacion}}</textarea>
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
                        @endif
                    </div>
                    <div class="row" style="margin-bottom:8px">
                        <label for="txtmuestra" class="form-label">Muestra</label>
                        <div class="col-12 col-md-10">
                            <div class="form-floating">
                                <textarea class="form-control" name="txtmuestra" id="txtmuestra" style="height: 100px; resize:none"
                                @if (($correciones->count()>0 && $correciones[0]->muestra==null) || $tesis[0]->estado == 1)
                                    readonly
                                @endif required>@if($tesis[0]->muestra!=""){{$tesis[0]->muestra}}@endif</textarea>
                            </div>
                        </div>
                        @if (sizeof($correciones)!=0 && $tesis[0]->condicion == null)
                            @if($correciones[0]->muestra!=null)
                            <div class="col-2">
                                <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#mCorreccionMuestra">Correccion</button>
                            </div>
                            @endif
                            {{-- Aqui va el modal --}}
                            <div class="modal" id="mCorreccionMuestra">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Correccion de Muestra</h4>
                                            <button type="button" class="btn-close" data-dismiss="modal"></button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            <div class="row" style="padding: 20px">
                                                <div class="row my-2">
                                                    <textarea class="form-control" name="taNone" id="taNone" style="height: 200px; resize:none" readonly>{{$correciones[0]->muestra}}</textarea>
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
                        @endif
                    </div>
                    <div class="row" style="margin-bottom:8px">
                        <label for="txtmetodos" class="form-label">Métodos</label>
                        <div class="col-12 col-md-10">
                            <div class="form-floating">
                                <textarea class="form-control" name="txtmetodos" id="txtmetodos" style="height: 100px; resize:none"
                                @if (($correciones->count()>0 && $correciones[0]->metodos==null) || $tesis[0]->estado == 1)
                                    readonly
                                @endif required>@if($tesis[0]->metodos!=""){{$tesis[0]->metodos}}@endif</textarea>
                            </div>
                        </div>
                        @if (sizeof($correciones)!=0 && $tesis[0]->condicion == null)
                            @if($correciones[0]->metodos!=null)
                            <div class="col-2">
                                <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#mCorreccionMetodos">Correccion</button>
                            </div>
                            @endif
                            {{-- Aqui va el modal --}}
                            <div class="modal" id="mCorreccionMetodos">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Correccion de Metodos</h4>
                                            <button type="button" class="btn-close" data-dismiss="modal"></button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            <div class="row" style="padding: 20px">
                                                <div class="row my-2">
                                                    <textarea class="form-control" name="taNone" id="taNone" style="height: 200px; resize:none" readonly>{{$correciones[0]->metodos}}</textarea>
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
                        @endif
                    </div>
                    <div class="row" style="margin-bottom:8px">
                        <label for="txttecnicas_instrum" class="form-label">Técnicas e instrumentos de recolección de datos</label>
                        <div class="col-12 col-md-10">
                            <div class="form-floating">
                                <textarea class="form-control" name="txttecnicas_instrum" id="txttecnicas_instrum" type="text" value="" style="height: 100px; resize:none"
                                @if (($correciones->count()>0 && $correciones[0]->tecnicas_instrum==null) || $tesis[0]->estado == 1)
                                    readonly
                                @endif required>@if($tesis[0]->tecnicas_instrum!=""){{$tesis[0]->tecnicas_instrum}}@endif</textarea>
                            </div>
                        </div>
                        @if (sizeof($correciones)!=0 && $tesis[0]->condicion == null)
                            @if($correciones[0]->tecnicas_instrum!=null)
                            <div class="col-2">
                                <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#mCorreccionTecInst">Correccion</button>
                            </div>
                            @endif
                            {{-- Aqui va el modal --}}
                            <div class="modal" id="mCorreccionTecInst">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Correccion de Técnicas e instrumentos</h4>
                                            <button type="button" class="btn-close" data-dismiss="modal"></button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            <div class="row" style="padding: 20px">
                                                <div class="row my-2">
                                                    <textarea class="form-control" name="taNone" id="taNone" style="height: 200px; resize:none" readonly>{{$correciones[0]->tecnicas_instrum}}</textarea>
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
                        @endif
                    </div>
                    <div class="row" style="margin-bottom:20px">
                        <h6>Instrumentación y/o fuentes de datos</h6>
                        <div class="col-12 col-md-10">
                            <div class="form-floating">
                                <textarea class="form-control" name="txtinstrumentacion" id="txtinstrumentacion" type="text" value="" style="height: 100px; resize:none"
                                @if (($correciones->count()>0 && $correciones[0]->instrumentacion==null) || $tesis[0]->estado == 1)
                                    readonly
                                @endif required>@if($tesis[0]->instrumentacion!=""){{$tesis[0]->instrumentacion}}@endif</textarea>
                            </div>
                        </div>
                        @if (sizeof($correciones)!=0 && $tesis[0]->condicion == null)
                            @if($correciones[0]->instrumentacion!=null)
                            <div class="col-2">
                                <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#mCorreccionInsFD">Correccion</button>
                            </div>
                            @endif
                            {{-- Aqui va el modal --}}
                            <div class="modal" id="mCorreccionInsFD">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Correccion de Instrumentación y/o fuentes de datos</h4>
                                            <button type="button" class="btn-close" data-dismiss="modal"></button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            <div class="row" style="padding: 20px">
                                                <div class="row my-2">
                                                    <textarea class="form-control" name="taNone" id="taNone" style="height: 200px; resize:none" readonly>{{$correciones[0]->instrumentacion}}</textarea>
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
                        @endif
                    </div>
                    <div class="row" style="margin-bottom:20px">
                        <h6>Estrategias Metodológicas</h6>
                        <div class="col-12 col-md-10">
                            <div class="form-floating">
                                <textarea class="form-control" name="txtestg_metodologicas" id="txtestg_metodologicas" style="height: 100px; resize:none"
                                @if (($correciones->count()>0 && $correciones[0]->estg_metodologicas==null) || $tesis[0]->estado == 1)
                                    readonly
                                @endif required>@if($tesis[0]->estg_metodologicas!=""){{$tesis[0]->estg_metodologicas}}@endif</textarea>
                            </div>
                        </div>
                        @if (sizeof($correciones)!=0 && $tesis[0]->condicion == null)
                            @if($correciones[0]->estg_metodologicas!=null)
                            <div class="col-2">
                                <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#mCorreccionEstrategia">Correccion</button>
                            </div>
                            @endif
                            {{-- Aqui va el modal --}}
                            <div class="modal" id="mCorreccionEstrategia">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Correccion de Estrategias Metodológicas</h4>
                                            <button type="button" class="btn-close" data-dismiss="modal"></button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            <div class="row" style="padding: 20px">
                                                <div class="row my-2">
                                                    <textarea class="form-control" name="taNone" id="taNone" style="height: 200px; resize:none" readonly>{{$correciones[0]->estg_metodologicas}}</textarea>
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
                        @endif
                    </div>
                    <div class="row" style="margin-bottom:20px">
                        {{--Variables de operalizacion modal extra--}}
                        <h6>Variables</h6>
                            <div class="col-8 col-md-7 col-xl-3">
                                <div class="row border-box" style="margin-bottom:20px"
                                @if (($correciones->count()>0 && $correciones[0]->recursos==null) || $tesis[0]->estado==1)
                                    hidden
                                @endif>
                                    <div class="col-7 col-md-6" style="text-align:center">
                                        <p>Agregar una variable</p>
                                    </div>
                                    <div class="col-5 col-md-6">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#mVariable">
                                            Agregar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @if (sizeof($correciones)!=0 && $tesis[0]->condicion == null)
                            @if($correciones[0]->variables!=null)
                            <div class="col-2">
                                <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#mCorreccionVariables">Correccion</button>
                            </div>
                            @endif
                            {{-- Aqui va el modal --}}
                            <div class="modal" id="mCorreccionVariables">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Correccion de Variables</h4>
                                            <button type="button" class="btn-close" data-dismiss="modal"></button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            <div class="row" style="padding: 20px">
                                                <div class="row my-2">
                                                    <textarea class="form-control" name="taNone" id="taNone" style="height: 200px; resize:none" readonly>{{$correciones[0]->variables}}</textarea>
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
                        @endif
                        <div class="row" style="margin-bottom:8px">
                            <div class="col-12">
                                {{-- Tabla para insertar los recursos usados --}}
                                <table id="variableTable" class="table table-striped table-bordered table-condensed table-hover" >
                                    <thead>
                                        <tr>
                                            <th>Descripcion</th>
                                            <th>Accion</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @if (sizeof($variableop)>0)
                                        @php
                                            $indVar = 0;
                                        @endphp

                                        @foreach ($variableop as $var)
                                            <tr id="filaV{{$indVar}}">
                                                <td>{{$var->descripcion}}</td>
                                                <td>
                                                @if(sizeof($correciones)>0)
                                                    @if($correciones[0]->variables != null && $tesis[0]->condicion == null)
                                                    <a href="#" id="lvar-{{$indVar}}" class="btn btn-warning" onclick="deleteOldRecurso(this);">X</a>
                                                    @endif

                                                @endif
                                                    <input type="hidden" id="xlvar-{{$indVar}}" value="{{$var->cod_variable}}">
                                                </td>
                                            </tr>
                                            @php
                                                $indVar++;
                                            @endphp
                                        @endforeach
                                        <input type="hidden" id="valNVariable" value="{{sizeof($variableop)}}">
                                        <input type="hidden" name="listOldlvar" id="listOldlvar">
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style=" margin-bottom:20px; padding-right:12px;">
                    <div class="col-12">
                        <hr style="border: 1px solid gray">
                    </div>
                    <h5>Referencias bibliográficas</h5>
                    <div class="row">
                        <div class="row" style="margin-bottom:20px;">
                            <div class="col-8 col-md-4">
                                <label for="cboTipoAPA" class="form-label">Tipo</label>
                                <select name="cboTipoAPA" id="cboTipoAPA" class="form-select" onchange="setTypeAPA();" required
                                @if (($correciones->count()>0 && $correciones[0]->referencias==null) || $tesis[0]->estado == 1)
                                    disabled
                                @endif>>
                                    <option selected>-</option>
                                    @foreach ($tiporeferencia as $tipo)
                                        <option value="{{$tipo->cod_tiporeferencia}}">{{$tipo->tipo}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if (sizeof($correciones)!=0 && $tesis[0]->condicion == null)
                                @if($correciones[0]->referencias!=null)
                                <div class="col-2">
                                    <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#mCorreccionReferencia">Correccion</button>
                                </div>
                                @endif
                                {{-- Aqui va el modal --}}
                                <div class="modal" id="mCorreccionReferencia">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Correccion de las Referencias</h4>
                                                <button type="button" class="btn-close" data-dismiss="modal"></button>
                                            </div>
                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <div class="row" style="padding: 20px">
                                                    <div class="row my-2">
                                                        <textarea class="form-control" name="taNone" id="taNone" style="height: 200px; resize:none" readonly>{{$correciones[0]->referencias}}</textarea>
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
                            @endif
                        </div>
                        <div class="row border-box card-box">
                            <div class="item-card2">
                                <div class="col-12">
                                    <label for="txtAutorAPA" class="form-label">Autor</label>
                                    <div class="row">
                                        <div class="col-6 col-xl-7">
                                            <input class="form-control" name="txtAutorAPA" id="txtAutorAPA" type="text" value="" placeholder="Nombre del autor"
                                            @if (($correciones->count()>0 && $correciones[0]->referencias==null) || $tesis[0]->estado == 1)
                                                readonly
                                            @endif>
                                        </div>
                                        <div class="col-4 col-xl-3" id="btnVariosAutores" hidden>
                                            <input type="button" class="btn btn-success" id="btnAgregaAutores" onclick="addAutor();" value="Agregar" style="width:70px; font-size:1.2vh;">
                                        </div>
                                        <div class="col-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="chkMasAutor" onclick="setVariosAutores();"
                                                @if (($correciones->count()>0 && $correciones[0]->referencias==null) || $tesis[0]->estado == 1)
                                                    disabled
                                                @endif>
                                                <label class="form-check-label" for="chkMasAutor">
                                                  Varios
                                                </label>
                                              </div>
                                        </div>

                                    </div>

                                </div>
                                <div class="col-12" style="padding-top:5px;" id="rowVariosAutores" hidden>
                                    <div class="row" id="rowAddAutor" style="display: grid; grid-template-columns: repeat(4, 1fr); grid-gap: 5px; ">

                                    </div>
                                </div>
                            </div>
                            <div class="item-card2">
                                <label for="txtFechaPublicacion" class="form-label">Fecha de Publicacion</label>
                                <input class="form-control" name="txtFechaPublicacion" id="txtFechaPublicacion" type="text" value="" placeholder="Fecha de publicacion"
                                @if (($correciones->count()>0 && $correciones[0]->referencias==null) || $tesis[0]->estado == 1)
                                    readonly
                                @endif>
                            </div>
                            <div class="item-card2">
                                <label for="txtTituloTrabajo" class="form-label">Titulo del Trabajo</label>
                                <input class="form-control" name="txtTituloTrabajo" id="txtTituloTrabajo" type="text" value="" placeholder="Titulo del trabajo"
                                @if (($correciones->count()>0 && $correciones[0]->referencias==null) || $tesis[0]->estado == 1)
                                    readonly
                                @endif>
                            </div>
                            <div class="item-card2">
                                <label for="txtFuente" class="form-label">Fuente</label>
                                <input class="form-control" name="txtFuente" id="txtFuente" type="text" value="" placeholder="Fuente para recuperacion"
                                @if (($correciones->count()>0 && $correciones[0]->referencias==null) || $tesis[0]->estado == 1)
                                    readonly
                                @endif>
                            </div>
                            <div class="item-card2" id="div-editorial" hidden>
                                <label for="txtEditorial" class="form-label">Editorial</label>
                                <input class="form-control" name="txtEditorial" id="txtEditorial" type="text" value="" placeholder="Editorial">
                            </div>
                            <div class="item-card2" id="div-titlecap" hidden>
                                <label for="txtTitleCap" class="form-label">Titulo del Capitulo</label>
                                <input class="form-control" name="txtTitleCap" id="txtTitleCap" type="text" value="" placeholder="Titulo del capitulo">
                            </div>
                            <div class="item-card2" id="div-numcap" hidden>
                                <label for="txtNumCapitulo" class="form-label"># Capitulos</label>
                                <input class="form-control" name="txtNumCapitulo" id="txtNumCapitulo" type="text" value="" placeholder="Numero del capitulo">
                            </div>
                            <div class="item-card2" id="div-titlerev" hidden>
                                <label for="txtTitleRev" class="form-label">Titulo de Revista</label>
                                <input class="form-control" name="txtTitleRev" id="txtTitleRev" type="text" value="" placeholder="Titulo de revista">
                            </div>
                            <div class="item-card2" id="div-volumen" hidden>
                                <label for="txtVolumen" class="form-label">Volumen</label>
                                <input class="form-control" name="txtVolumen" id="txtVolumen" type="text" value="" placeholder="Volumen">
                            </div>
                            <div class="item-card2" id="div-nameweb" hidden>
                                <label for="txtNameWeb" class="form-label">Nombre de la Web</label>
                                <input class="form-control" name="txtNameWeb" id="txtNameWeb" type="text" value="" placeholder="Nombre de la web">
                            </div>
                            <div class="item-card2" id="div-nameperiodista" hidden>
                                <label for="txtNamePeriodista" class="form-label">Nombre del Periodista</label>
                                <input class="form-control" name="txtNamePeriodista" id="txtNamePeriodista" type="text" value="" placeholder="Nombre del periodista">
                            </div>
                            <div class="item-card2" id="div-nameinsti" hidden>
                                <label for="txtNameInsti" class="form-label">Nombre de la Institucion</label>
                                <input class="form-control" name="txtNameInsti" id="txtNameInsti" type="text" value="" placeholder="Nombre de la institucion">
                            </div>
                            <div class="item-card2" id="div-subtitle" hidden>
                                <label for="txtSubtitle" class="form-label">Sub titulo</label>
                                <input class="form-control" name="txtSubtitle" id="txtSubtitle" type="text" value="" placeholder="Subtitulo">
                            </div>
                            <div class="item-card2" id="div-nameeditor" hidden>
                                <label for="txtNameEditor" class="form-label">Nombre del editor</label>
                                <input class="form-control" name="txtNameEditor" id="txtNameEditor" type="text" value="" placeholder="Nombre del Editor">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2">
                                <span id="fullReference" name="fullReference" style="color: red"></span>
                                <input type="button" class="btn btn-outline-primary" value="Agregar referencia" onclick="agregarReferenciaB();"
                                @if (($correciones->count()>0 && $correciones[0]->referencias==null) || $tesis[0]->estado == 1)
                                    hidden
                                @endif>
                            </div>
                        </div>
                    </div>


                    <div class="row" style="padding-top:15px;">
                        <div class="col-12">
                            <table id="detalleReferencias" class="table table-striped table-bordered table-condensed table-hover">
                                @if ($referencias->count()>0)
                                    <tbody>
                                    @foreach ($referencias as $ref)
                                        <tr>
                                            <td>{{$ref->autor}}</td>
                                            <td>{{$ref->fPublicacion}}</td>
                                            <td>{{$ref->titulo}}</td>
                                            <td>{{$ref->fuente}}</td>
                                            <td>{{$ref->editorial}}</td>
                                            <td>{{$ref->title_cap}}</td>
                                            <td>{{$ref->num_capitulo}}</td>
                                            <td>{{$ref->title_revista}}</td>
                                            <td>{{$ref->volumen}}</td>
                                            <td>{{$ref->name_web}}</td>
                                            <td>{{$ref->name_periodista}}</td>
                                            <td>{{$ref->name_institucion}}</td>
                                            <td>{{$ref->subtitle}}</td>
                                            <td>{{$ref->name_editor}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                @endif
                            </table>
                        </div>

                    </div>
                </div>
                <div class="row" style=" margin-bottom:20px;">
                    <div class="col-6">
                        <div class="row">
                            <div class="col-12">
                                @if ($tesis[0]->estado == 0 || $tesis[0]->estado == 2)
                                <input class="btn btn-success" type="button" value="Guardar registro" onclick="registerProject();">
                                @endif
                                <a href="{{route('user_information')}}" type="button" class="btn btn-danger">@if ($tesis[0]->estado == 0 || $tesis[0]->estado == 2) Cancelar @else Volver @endif</a>
                            </div>
                        </div>
                    </div>
                </div>


            </form>
        </div>
    </div>
    {{--modales--}}
    {{--Modal para Recurso--}}
    <div class="modal" id="mRecurso">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Recursos</h4>
                    <button type="button" class="btn-close" data-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row" style="padding: 20px">
                        <div class="row my-2">
                            <div class="col-6">
                                <select class="form-select" id="cboTipoRecurso" onchange="onChangeRecurso();">
                                    <option selected>-</option>
                                    <option value="1">Personal</option>
                                    <option value="2">Bienes</option>
                                    <option value="3">Servicios</option>
                                  </select>
                            </div>
                            <div class="col-6">
                                <select class="form-select" id="cboSubtipoRecurso" hidden>
                                    <option value="1">De consumo</option>
                                    <option value="2">De inversion</option>
                                  </select>
                            </div>
                        </div>
                        <div class="row">
                            <textarea class="form-control" name="taRecurso" id="taRecurso" style="height: 200px; resize:none"></textarea>
                        </div>
                    </div>

                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-6">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                        <div class="col-6">
                            <button type="button" class="btn btn-warning" onclick="agregarRecurso();" data-dismiss="modal">Guardar</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{--Modal para Objetivo--}}
    <div class="modal" id="mObjetivo">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Objetivo</h4>
                    <button type="button" class="btn-close" data-dismiss="modal"></button>
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
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                        <div class="col-6">
                            <button type="button" class="btn btn-warning" onclick="agregarObjetivo();" data-dismiss="modal">Guardar</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    {{--Modal para Variables--}}
    <div class="modal" id="mVariable">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Variables</h4>
                    <button type="button" class="btn-close" data-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row" style="padding: 20px">
                        <div class="row my-2">
                            <textarea class="form-control" name="taVariable" id="taVariable" style="height: 200px; resize:none"></textarea>
                        </div>
                    </div>

                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-6">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                        <div class="col-6">
                            <button type="button" class="btn btn-warning" onclick="agregarVariable();" data-dismiss="modal">Guardar</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @endif
    <script type="text/javascript">
        var indiceRecurso=0;
        var iObjetivo=0;
        var iVariable=0;

        var listObs = [];
        var listTextObs = [];
        var counter = 0;
        /*Esta funcion es implementada cuando se inicia la ventana y el proyecto de tesis
          ya se haya registrado antes.*/
        window.onload = function() {

            /*Asignar el valor para el indice del recurso en caso ya existan*/
            const valOldRecursos = document.getElementById('valNRecurso').value;
            if(valOldRecursos!=0 ){
                indiceRecurso = parseInt(valOldRecursos);
            }

            const valOldObj = document.getElementById('valNObjetivo').value;

            if(valOldObj!=0 ){
                iObjetivo = parseInt(valOldObj);

            }

            const valOldVar = document.getElementById('valNVariable').value;
            if(valOldVar!=0 ){
                iVariable = parseInt(valOldVar);
            }

            /*Valores de los meses de ejecucion y a la vez recibimos los valores para la tabla*/
            const valueMes = document.getElementById('txtmeses_ejecucion').value;
            const valueMesPart = document.getElementById('valuesMesesPart').value;

            /*Verificamos que los meses contiene valor*/
            if(valueMes !="" || valueMes !=0){
                setMeses();
            }

            if(valueMesPart!=""){
                /*Cada valor de mes en la actividad del cronograma la hemos separado por comas*/
                let eachActivity = valueMesPart.split(",");
                for(let i = 0; i<eachActivity.length; i++){
                    /*Luego separamos los valores obtenidos antes mediante un guion*/
                    let mesActivity = eachActivity[i].split("-");

                    let extrasumador = 0;
                    for(let j = 0; j<mesActivity.length; j++){
                        let activity = i+1;
                        /*Esta condicion aplica cuando en el cronograma una actividad solo ocupó un mes*/
                        if(mesActivity[0]==mesActivity[1]){
                            extrasumador += 1;
                        }
                        /*El extrasumador nos ayuda a que solo se repita una vez*/
                        if(extrasumador!=1){
                            setColorInit(activity+'Tr'+mesActivity[j]);
                            extrasumador=0;
                        }

                    }
                }
            }

            //Verificamos que se este corrigiendo alguna observacion
            const isObservacion = document.getElementById('verificaCorrect').value;

            if(isObservacion=='true'){
                const valuesObs = document.getElementById('txtValuesObs').value;
                listObs = valuesObs.split(',');
                for(let x=0; x<listObs.length; x++){
                    if(listObs[x]!='recursos' && listObs[x]!='objetivos' && listObs[x]!='variables' && listObs[x]!='referencias' && listObs[x]!='localidad_institucion'){
                        //Debo cambiar los id por los nombres del input o txtarea segun sea el caso.
                        let valueTA = document.getElementById('txt'+listObs[x]).value;
                        listObs[counter] = listObs[x];
                        counter += 1;
                        listTextObs.push(valueTA);
                    }
                }

            }

        };

        /*Esta funcion la hemos duplicado para aplicar solo cuando haya datos registrados en el cronograma*/
        function setColorInit(id){
            const celda = document.getElementById(id);
            const ncelda = document.getElementById('n'+id);
            let cont = ncelda.value;
            let touch = parseInt(cont) + 1
            ncelda.value = touch;

            if(touch%2 != 0 ){
                celda.style.backgroundColor= "red";
            }else{
                celda.style.backgroundColor= "rgb(212, 212, 212)";
            }
        }

        /*Funcion para eliminar los recursos antiguos que ya estan registrados*/
        function deleteOldRecurso(item){
            const iditem = item.id;
            const idindice = iditem.split("-");

            let code = document.getElementById('x'+iditem).value;
            if(document.getElementById('listOld'+idindice[0]).value == ""){
                document.getElementById('listOld'+idindice[0]).value = code;
            }else{
                document.getElementById('listOld'+idindice[0]).value += ","+code;
            }
            if(idindice[0]=='lrec'){
                $('#filaR'+idindice[1]).remove();
                //indiceRecurso--;
            }else if(idindice[0]=='lobj'){
                $('#filaO'+idindice[1]).remove();
                //iObjetivo--;
            }else if(idindice[0]=='lvar'){
                $('#filaV'+idindice[1]).remove();
                //iVariable--;
            }


        }

        /*Funcion para validar que el titulo no sea mayor de 20 palabras*/
        function validaText()
        {

            primerBlanco = /^ /;
            ultimoBlanco = / $/;
            variosBlancos = /[ ]+/g;

            txtTitulo = document.getElementById("txttitulo").value;
            txtTitulo = txtTitulo.replace(variosBlancos," ");
            txtTitulo = txtTitulo.replace(primerBlanco,"");
            txtTitulo = txtTitulo.replace(ultimoBlanco,"");

            txtTituloValidado = txtTitulo.split(" ");

            if(txtTituloValidado.length > 20){
                document.getElementById("validateTitle").innerHTML = "Maximo 20 palabras";
                return false;
            } else {
                document.getElementById("validateTitle").innerHTML = "Aceptado";
                return true;
            }

        }

        /*Funcion para prohibir escribir numeros decimales u otro caracter*/
        function isNumberKey(evt)
        {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
        }



        /*Funcion para agregar las celdas referentes de los meses de ejecucion*/
        var existMes = false;
        var lastMonth = 0;
        function setMeses(){
            if(existMes == false){
                existMes=true;
                meses = document.getElementById("txtmeses_ejecucion").value;
                lastMonth = meses;
                for(i = 1;i<=meses; i++){
                    document.getElementById("headers").innerHTML += '<th id="Mes'+i+'" scope="col">Mes '+i+'</th>'
                    document.getElementById("1Tr").innerHTML += '<input type="hidden" id="n1Tr'+i+'" name="n1Tr'+i+'" value="0"><td id="1Tr'+i+'" onclick="@if(sizeof($tesis)>0 && $tesis[0]->estado!=1) @if((sizeof($correciones)>0 && $correciones[0]->meses_ejecucion!=null) || sizeof($correciones)==0) setColorTable(this); @endif @endif"></td>'
                    document.getElementById("2Tr").innerHTML += '<input type="hidden" id="n2Tr'+i+'" name="n2Tr'+i+'" value="0"><td id="2Tr'+i+'" onclick="@if(sizeof($tesis)>0 && $tesis[0]->estado!=1) @if((sizeof($correciones)>0 && $correciones[0]->meses_ejecucion!=null) || sizeof($correciones)==0) setColorTable(this); @endif @endif"></td>'
                    document.getElementById("3Tr").innerHTML += '<input type="hidden" id="n3Tr'+i+'" name="n3Tr'+i+'" value="0"><td id="3Tr'+i+'" onclick="@if(sizeof($tesis)>0 && $tesis[0]->estado!=1) @if((sizeof($correciones)>0 && $correciones[0]->meses_ejecucion!=null) || sizeof($correciones)==0) setColorTable(this); @endif @endif"></td>'
                    document.getElementById("4Tr").innerHTML += '<input type="hidden" id="n4Tr'+i+'" name="n4Tr'+i+'" value="0"><td id="4Tr'+i+'" onclick="@if(sizeof($tesis)>0 && $tesis[0]->estado!=1) @if((sizeof($correciones)>0 && $correciones[0]->meses_ejecucion!=null) || sizeof($correciones)==0) setColorTable(this); @endif @endif"></td>'
                }
            }else{
                for(i = 1; i<=lastMonth; i++){
                    $('#Mes'+i).remove();
                    $('#n1Tr'+i).remove();
                    $('#n2Tr'+i).remove();
                    $('#n3Tr'+i).remove();
                    $('#n4Tr'+i).remove();

                    $('#1Tr'+i).remove();
                    $('#2Tr'+i).remove();
                    $('#3Tr'+i).remove();
                    $('#4Tr'+i).remove();
                }
                existMes = false;
                setMeses();
            }


        }

        /*Funcion para pintar las celdas que se seleccionen para cada actividad*/
        function setColorTable(celda){
            cont = document.getElementById("n"+celda.id).value;
            touch = parseInt(cont) + 1
            document.getElementById("n"+celda.id).value = touch;

            if(touch%2 != 0 ){
                celda.style.backgroundColor= "red";
            }else{
                celda.style.backgroundColor= "rgb(212, 212, 212)";
            }
        }

        /*Funcion para guardar los meses que duraron cada actividad del cronograma de trabajo
          tambien, estos meses estan separados por un '_' para conocer tambien el rango de estos*/
        function saveMonths(){
            months = document.getElementById("txtmeses_ejecucion").value;
            list=[]
            cadena = ""
            hayMeses = false;
            for(i=1;i<=parseInt(months);i++){
                notnull = document.getElementById("n1Tr"+i).value;
                if((notnull%2) != 0 && notnull !=0){
                    hayMeses = true;
                    if(cadena!=""){
                        cadena += "_" + i
                    }else{
                        cadena += i
                    }
                }
            }
            if(hayMeses==true){
                hayMeses=false;
                cadena += "_1a"
            }else{
                return false;
            }

            for(i=1;i<=parseInt(months);i++){
                notnull = document.getElementById("n2Tr"+i).value;
                if((notnull%2) != 0 && notnull !=0){
                    hayMeses = true;
                    if(cadena!=""){
                        cadena += "_" + i
                    }else{
                        cadena += i
                    }
                }
            }
            if(hayMeses==true){
                hayMeses=false;
                cadena += "_2a"
            }else{
                return false;
            }

            for(i=1;i<=parseInt(months);i++){
                notnull = document.getElementById("n3Tr"+i).value;
                if((notnull%2) != 0 && notnull !=0){
                    hayMeses = true;
                    if(cadena!=""){
                        cadena += "_" + i
                    }else{
                        cadena += i
                    }
                }
            }
            if(hayMeses==true){
                hayMeses=false;
                cadena += "_3a"
            }else{
                return false;
            }

            for(i=1;i<=parseInt(months);i++){
                notnull = document.getElementById("n4Tr"+i).value;
                if((notnull%2) != 0 && notnull !=0){
                    hayMeses=true;
                    if(cadena!=""){
                        cadena += "_" + i
                    }else{
                        cadena += i
                    }
                }
            }
            if(hayMeses==true){
                hayMeses=false;
                cadena += "_4a"
            }else{
                return false;
            }

            document.getElementById("listMonths").value=cadena;
            return true;

        }

        /*Funcion para agregar cada referencia bibliografica en la tabla*/
        var indice=0;
        function agregarReferenciaB()
        {
            listAutor="";
            autores4table = "";
            arrayAutor = [];

            for(i=0; i<iAutor; i++){
                longit = $("#addAutor"+i).length;
                if(longit>0){
                    autor = document.getElementById('addAutor'+i).value;
                    if(autor!= ""){
                        arrayAutor.push(autor);
                        if(listAutor!=""){
                            listAutor += '_' + autor;
                        }else{
                            listAutor += autor;
                        }
                    }

                }
            }
            for(i=0; i<arrayAutor.length;i++){
                if(i==0){
                    autores4table += arrayAutor[i];

                }else{
                    if(i==arrayAutor.length-1){
                        autores4table += ' y ' + arrayAutor[i];
                    }else{
                        autores4table += ', ' + arrayAutor[i];
                    }
                }
            }
            iAutor = 0;
            tipoAPA = document.getElementById("cboTipoAPA").selectedIndex;
            //autorApa = document.getElementById('txtAutorAPA').value;
            fPublicacion = document.getElementById('txtFechaPublicacion').value;
            tituloTrabajo = document.getElementById('txtTituloTrabajo').value;
            fuente = document.getElementById('txtFuente').value;
            editorial = document.getElementById('txtEditorial').value;
            titCapitulo = document.getElementById('txtTitleCap').value;
            numCapitulos = document.getElementById('txtNumCapitulo').value;

            titRevista = document.getElementById('txtTitleRev').value;
            volumenRevista = document.getElementById('txtVolumen').value;

            nombreWeb = document.getElementById('txtNameWeb').value;

            nombrePeriodista = document.getElementById('txtNamePeriodista').value;

            nombreInstitucion = document.getElementById('txtNameInsti').value;

            subtitInfo = document.getElementById('txtSubtitle').value;
            nombreEditorInfo = document.getElementById('txtNameEditor').value;

            if (tipoAPA == 1) {
                if(listAutor!="" && fPublicacion !="" && tituloTrabajo!="" && fuente!="" && editorial!="" && titCapitulo!="" && numCapitulos!=""){
                fila ='<tbody><tr id="fila'+indice+'"><td align="center"><a href="#" class="btn btn-warning" onclick="quitarReferenciaB('
                    +indice+')">X</a></td><td><input type="hidden" name="idtipoAPA[]" value="'
                    +tipoAPA+'"><input type="hidden" name="idautorApa[]" value="'
                    +autores4table+'">'+autores4table+'</td><td><input type="hidden" name="idfPublicacion[]" value="'
                    +fPublicacion+'">'+fPublicacion+'</td><td><input type="hidden" name="idtituloTrabajo[]" value="'
                    +tituloTrabajo+'">'+tituloTrabajo+'</td><td><input type="hidden" name="idfuente[]" value="'
                    +fuente+'">'+fuente+'</td><td><input type="hidden" name="ideditorial[]" value="'
                    +editorial+'">'+editorial+'</td><td><input type="hidden" name="idtitCapitulo[]" value="'
                    +titCapitulo+'">'+titCapitulo+'</td><td><input type="hidden" name="idnumCapitulos[]" value="'
                    +numCapitulos+'">'+numCapitulos+'</td></tr></tbody>';
                $('#detalleReferencias').append(fila);
                indice++;
                clearReferences();

                }else{
                    document.getElementById("fullReference").innerHTML = 'Falta llenar datos';
                }
            } else if(tipoAPA == 2) {
                if(listAutor!="" && fPublicacion !="" && tituloTrabajo!="" && fuente!="" && titRevista!="" && volumenRevista!=""){
                fila ='<tbody><tr id="fila'+indice+'"><td align="center"><a href="#" class="btn btn-warning" onclick="quitarReferenciaB('
                    +indice+')">X</a></td><td><input type="hidden" name="idtipoAPA[]" value="'
                    +tipoAPA+'"><input type="hidden" name="idautorApa[]" value="'
                    +autores4table+'">'+autores4table+'</td><td><input type="hidden" name="idfPublicacion[]" value="'
                    +fPublicacion+'">'+fPublicacion+'</td><td><input type="hidden" name="idtituloTrabajo[]" value="'
                    +tituloTrabajo+'">'+tituloTrabajo+'</td><td><input type="hidden" name="idfuente[]" value="'
                    +fuente+'">'+fuente+'</td><td><input type="hidden" name="idtitRevista[]" value="'
                    +titRevista+'">'+titRevista+'</td><td><input type="hidden" name="idvolumenRevista[]" value="'
                    +volumenRevista+'">'+volumenRevista+'</td></tr></tbody>';
                $('#detalleReferencias').append(fila);
                indice++;
                clearReferences();

                }else{
                    document.getElementById("fullReference").innerHTML = 'Falta llenar datos';
                }
            } else if(tipoAPA == 3) {
                if(listAutor!="" && fPublicacion !="" && tituloTrabajo!="" && fuente!="" && nombreWeb!=""){
                fila ='<tbody><tr id="fila'+indice+'"><td align="center"><a href="#" class="btn btn-warning" onclick="quitarReferenciaB('
                    +indice+')">X</a></td><td><input type="hidden" name="idtipoAPA[]" value="'
                    +tipoAPA+'"><input type="hidden" name="idautorApa[]" value="'
                    +autores4table+'">'+autores4table+'</td><td><input type="hidden" name="idfPublicacion[]" value="'
                    +fPublicacion+'">'+fPublicacion+'</td><td><input type="hidden" name="idtituloTrabajo[]" value="'
                    +tituloTrabajo+'">'+tituloTrabajo+'</td><td><input type="hidden" name="idfuente[]" value="'
                    +fuente+'">'+fuente+'</td><td><input type="hidden" name="idnombreWeb[]" value="'
                    +nombreWeb+'">'+nombreWeb+'</td></tr></tbody>';
                $('#detalleReferencias').append(fila);
                indice++;
                clearReferences();

                }else{
                    document.getElementById("fullReference").innerHTML = 'Falta llenar datos';
                }

            } else if(tipoAPA == 4) {
                if(listAutor!="" && fPublicacion !="" && tituloTrabajo!="" && fuente!="" && nombrePeriodista!=""){
                fila ='<tbody><tr id="fila'+indice+'"><td align="center"><a href="#" class="btn btn-warning" onclick="quitarReferenciaB('
                    +indice+')">X</a></td><td><input type="hidden" name="idtipoAPA[]" value="'
                    +tipoAPA+'"><input type="hidden" name="idautorApa[]" value="'
                    +autores4table+'">'+autores4table+'</td><td><input type="hidden" name="idfPublicacion[]" value="'
                    +fPublicacion+'">'+fPublicacion+'</td><td><input type="hidden" name="idtituloTrabajo[]" value="'
                    +tituloTrabajo+'">'+tituloTrabajo+'</td><td><input type="hidden" name="idfuente[]" value="'
                    +fuente+'">'+fuente+'</td><td><input type="hidden" name="idnombrePeriodista[]" value="'
                    +nombrePeriodista+'">'+nombrePeriodista+'</td></tr></tbody>';
                $('#detalleReferencias').append(fila);
                indice++;
                clearReferences();

                }else{
                    document.getElementById("fullReference").innerHTML = 'Falta llenar datos';
                }
            } else if(tipoAPA == 5) {
                if(listAutor!="" && fPublicacion !="" && tituloTrabajo!="" && fuente!="" && nombreInstitucion!=""){
                fila ='<tbody><tr id="fila'+indice+'"><td align="center"><a href="#" class="btn btn-warning" onclick="quitarReferenciaB('
                    +indice+')">X</a></td><td><input type="hidden" name="idtipoAPA[]" value="'
                    +tipoAPA+'"><input type="hidden" name="idautorApa[]" value="'
                    +autores4table+'">'+autores4table+'</td><td><input type="hidden" name="idfPublicacion[]" value="'
                    +fPublicacion+'">'+fPublicacion+'</td><td><input type="hidden" name="idtituloTrabajo[]" value="'
                    +tituloTrabajo+'">'+tituloTrabajo+'</td><td><input type="hidden" name="idfuente[]" value="'
                    +fuente+'">'+fuente+'</td><td><input type="hidden" name="idnombreInstitucion[]" value="'
                    +nombreInstitucion+'">'+nombreInstitucion+'</td></tr></tbody>';
                $('#detalleReferencias').append(fila);
                indice++;
                clearReferences();

                }else{
                    document.getElementById("fullReference").innerHTML = 'Falta llenar datos';
                }
            } else if(tipoAPA == 6) {
                if(listAutor!="" && fPublicacion !="" && tituloTrabajo!="" && fuente!="" && subtitInfo!="" && nombreEditorInfo!=""){
                fila ='<tbody><tr id="fila'+indice+'"><td align="center"><a href="#" class="btn btn-warning" onclick="quitarReferenciaB('
                    +indice+')">X</a></td><td><input type="hidden" name="idtipoAPA[]" value="'
                    +tipoAPA+'"><input type="hidden" name="idautorApa[]" value="'
                    +autores4table+'">'+autores4table+'</td><td><input type="hidden" name="idfPublicacion[]" value="'
                    +fPublicacion+'">'+fPublicacion+'</td><td><input type="hidden" name="idtituloTrabajo[]" value="'
                    +tituloTrabajo+'">'+tituloTrabajo+'</td><td><input type="hidden" name="idfuente[]" value="'
                    +fuente+'">'+fuente+'</td><td><input type="hidden" name="idsubtitInfo[]" value="'
                    +subtitInfo+'">'+subtitInfo+'</td><td><input type="hidden" name="idnombreEditorInfo[]" value="'
                    +nombreEditorInfo+'">'+nombreEditorInfo+'</td></tr></tbody>';
                $('#detalleReferencias').append(fila);
                indice++;
                clearReferences();

                }else{
                    document.getElementById("fullReference").innerHTML = 'Falta llenar datos';
                }
            }
            return indice;

        }

        function quitarReferenciaB(item)
        {
            $('#fila'+item).remove();
            //indice--;
            document.getElementById('txtAutorAPA').focus();
        }

        function clearReferences(){
            $('#txtFechaPublicacion').val('');
            $('#txtTituloTrabajo').val('');
            $('#txtFuente').val('');

            $('#txtEditorial').val('');
            $('#txtTitleCap').val('');
            $('#txtNumCapitulo').val('');

            $('#txtTitleRev').val('');
            $('#txtVolumen').val('');

            $('#txtNameWeb').val('');

            $('#txtNamePeriodista').val('');

            $('#txtNameInsti').val('');

            $('#txtSubtitle').val('');
            $('#txtNameEditor').val('');

            document.getElementById("fullReference").innerHTML = '';
            document.getElementById('rowAddAutor').innerHTML = '';
            document.getElementById('chkMasAutor').click();
        }

        function onChangeRecurso(){
            if(document.getElementById('cboTipoRecurso').value == 2){
                document.getElementById('cboSubtipoRecurso').hidden = false;
            } else {
                document.getElementById('cboSubtipoRecurso').hidden = true;
            }
        }

        //Funcion para agregar cada Recurso

        function agregarRecurso()
        {
            tipo = document.getElementById("cboTipoRecurso");
            txtTipo = tipo.options[tipo.selectedIndex].text;

            subtipo = ""
            if(document.getElementById('cboTipoRecurso').value == 2){
                st = document.getElementById("cboSubtipoRecurso");
                subtipo = st.options[st.selectedIndex].text;
            }
            descripcion = document.getElementById("taRecurso").value;

            fila = '<tbody><tr id="filaR'+indiceRecurso+'"><td><input type="hidden" name="idtipo[]" value="'+txtTipo+'">'+txtTipo+'</td><td><input type="hidden" name="idsubtipo[]" value="'+subtipo+'">'+subtipo+'</td><td><input type="hidden" name="iddescripcion[]" value="'+descripcion+'">'+descripcion+'</td><td align="center"><a href="#" class="btn btn-warning" onclick="quitarRecurso('+indiceRecurso+')">X</a></td></tr></tbody>';
            $('#recursosTable').append(fila);
            indiceRecurso++;
            document.getElementById('taRecurso').value="";
        }

        function quitarRecurso(item)
        {
            $('#filaR'+item).remove();
            //indiceRecurso--;
        }


        //Funcion para agregar cada Recurso

        function agregarObjetivo()
        {

            tipo = document.getElementById("cboObjetivo");
            txtTipo = tipo.options[tipo.selectedIndex].text;

            descripcion = document.getElementById("taObjetivo").value;
            fila = '<tbody><tr id="filaO'+iObjetivo+'"><td><input type="hidden" name="idtipoObj[]" value="'+txtTipo+'">'+txtTipo+'</td><td><input type="hidden" name="iddescripcionObj[]" value="'+descripcion+'">'+descripcion+'</td><td align="center"><a href="#" class="btn btn-warning" onclick="quitarObjetivo('+iObjetivo+')">X</a></td></tr></tbody>';
            $('#objetivoTable').append(fila);
            iObjetivo++;
            document.getElementById('taObjetivo').value="";

        }

        function quitarObjetivo(item)
        {
            $('#filaO'+item).remove();
            //iObjetivo--;
        }


        function agregarVariable()
        {

            descripcion = document.getElementById("taVariable").value;
            fila = '<tbody><tr id="filaV'+iVariable+'"><td><input type="hidden" name="iddescripcionVar[]" value="'+descripcion+'">'+descripcion+'</td><td align="center"><a href="#" class="btn btn-warning" onclick="quitarVariable('+iVariable+');">X</a></td></tr></tbody>';
            $('#variableTable').append(fila);
            iVariable++;
            document.getElementById('taVariable').value="";

        }

        function quitarVariable(item)
        {
            $('#filaV'+item).remove();
            //iVariable--;
        }


        //Funcion para generar el total del presupuesto
        function verTotal(){
            cadena = ""
            total = 0.0;
            vextra = true;
            for(i=0;i<5;i++){
                precioCod = document.getElementById("cod_"+i).value;
                if(parseFloat(precioCod)>1 || precioCod != ""){
                    total += parseFloat(precioCod);
                    if(cadena!=""){
                        cadena += "_" + precioCod
                    }else{
                        cadena += precioCod
                    }
                }else{
                    return false;
                }
            }

            precios = cadena.split('_');
            document.getElementById('precios').value = cadena;
            document.getElementById('total').value = parseFloat(total);
            $('#total').css({"background":"yellow"});
            return true;


        }

        /*Funcion para dirigir a la ruta guardar y registrar los datos del proy. investigacion*/
        function registerProject(){

            titulo = document.getElementById("txttitulo").value;
            validarTitulo = document.getElementById("validateTitle").value;

            tipoInvestigacion = document.getElementById("cboTipoInvestigacion").selectedIndex;
            finInvestigacion = document.getElementById("cboFinInvestigacion").selectedIndex;
            disenInvestigacion = document.getElementById("cboDesignInvestigacion").selectedIndex;

            financiamiento = document.getElementById("cboFinanciamiento").selectedIndex;

            localidad = document.getElementById("txtLocalidad").value;
            institucion = document.getElementById("txtInstitucion").value;

            rProblematica = document.getElementById("txtreal_problematica").value;
            antecedentes = document.getElementById("txtantecedentes").value;
            justifiInvestigacion = document.getElementById("txtjustificacion").value;
            formulProblema = document.getElementById("txtformulacion_prob").value;

            totalPres = document.getElementById('total').value;
            marcoTeorico = document.getElementById("txtmarco_teorico").value;
            marcoConceptual = document.getElementById("txtmarco_conceptual").value;
            formHipotesis = document.getElementById("txtform_hipotesis").value;

            objEstudio = document.getElementById("txtobjeto_estudio").value;
            poblacion = document.getElementById("txtpoblacion").value;
            muestra = document.getElementById("txtmuestra").value;
            metodos = document.getElementById("txtmetodos").value;
            tecnicas = document.getElementById("txttecnicas_instrum").value;
            fuentes = document.getElementById("txtinstrumentacion").value;
            estrategias = document.getElementById("txtestg_metodologicas").value;

            //Esto nos ayuda a saber si se esta haciendo una correccion
            const isCorrect = document.getElementById('verificaCorrect').value;



            if(isCorrect!='true'){
                extra = saveMonths();
                if (titulo == "") {
                    alert('Ingrese el Titulo del Proyecto');
                }else if(validaText()==false){
                    alert('El titulo del proyecto es incorrecto, por favor verificar.');
                }else if (finInvestigacion == 0) {
                    alert('Debe selecion un Fin de Investigacion');
                }else if (financiamiento == 0) {
                    alert('Debe selecionar su Financiamiento');
                }else if (disenInvestigacion == 0) {
                    alert('Debe selecion un Diseno de Investigacion');
                }else if (localidad == "") {
                    alert('Debe agregar su Localidad');
                }else if (institucion == "") {
                    alert('Debe agregar su Institucion');
                }else if(extra==false){
                    alert('Debe seleccionar almenos un mes para cada actividad');
                }else if(indiceRecurso==0 || iVariable==0 || iObjetivo==0){
                    alert('Falta rellenar Recursos, Objetivos o Variables, por favor completar.');
                }else if(totalPres== "" || totalPres==0){
                    alert('Debe ingresar el presupuesto correctamente.');
                }else if (rProblematica == "" || antecedentes == "" || justifiInvestigacion == "" || formulProblema == "" || marcoTeorico == "" || marcoConceptual == "" || formHipotesis == "") {
                    alert('Debe completar todo los campos del Pan de Investigacion');
                }else if (objEstudio == "" || poblacion == "" || muestra == "" || metodos == "" || tecnicas == "" || fuentes == "" || estrategias == "") {
                    alert('Debe completar todo los campos del Diseño de Investigacion');
                }else if (indice == 0) {
                    alert('Debe agregar almenos 1 referencia');

                }else{
                    document.formTesis.action = "{{route('guardarDoc')}}";
                    document.formTesis.method = "POST";
                    document.formTesis.submit();

                }
            }else{
                let corrigio = true;
                for(let x=0; x<counter; x++){
                    let valueTA = document.getElementById('txt'+listObs[x]).value;
                    if(valueTA == listTextObs[x]){
                        corrigio = false;
                    }
                }
                if(corrigio==true){
                    document.formTesis.action = "{{route('guardarDoc')}}";
                    document.formTesis.method = "POST";
                    document.formTesis.submit();
                }else{
                    alert('Debe realizar las correcciones correspondientes.');
                }

            }
        }

        function setVariosAutores(){
            if (document.getElementById('chkMasAutor').checked)
            {
                document.getElementById('btnVariosAutores').hidden = false;
                document.getElementById('rowVariosAutores').hidden = false;
            }else{
                document.getElementById('btnVariosAutores').hidden = true;
                document.getElementById('rowVariosAutores').hidden = true;
            }

        }

        function setTypeAPA(){
            document.getElementById('div-editorial').hidden = true;
            document.getElementById('div-titlecap').hidden = true;
            document.getElementById('div-numcap').hidden = true;

            document.getElementById('div-titlerev').hidden = true;
            document.getElementById('div-volumen').hidden = true;

            document.getElementById('div-nameweb').hidden = true;

            document.getElementById('div-nameperiodista').hidden = true;

            document.getElementById('div-nameinsti').hidden = true;

            document.getElementById('div-subtitle').hidden = true;
            document.getElementById('div-nameeditor').hidden = true;

            if(document.getElementById('cboTipoAPA').value == 1){
                document.getElementById('div-editorial').hidden = false;
                document.getElementById('div-titlecap').hidden = false;
                document.getElementById('div-numcap').hidden = false;
            }else if(document.getElementById('cboTipoAPA').value == 2){
                document.getElementById('div-titlerev').hidden = false;
                document.getElementById('div-volumen').hidden = false;
            }else if(document.getElementById('cboTipoAPA').value == 3){
                document.getElementById('div-nameweb').hidden = false;
            }else if(document.getElementById('cboTipoAPA').value == 4){
                document.getElementById('div-nameperiodista').hidden = false;
            }else if(document.getElementById('cboTipoAPA').value == 5){
                document.getElementById('div-nameinsti').hidden = false;
            }else{
                document.getElementById('div-subtitle').hidden = false;
                document.getElementById('div-nameeditor').hidden = false;
            }
        }

        var iAutor = 0;
        function addAutor(){
            txtautor = document.getElementById('txtAutorAPA').value;
            if(txtautor!= ""){
                document.getElementById('rowAddAutor').innerHTML += '<div id="rAutor'+iAutor+'"><div class="input-group" ><input type="text" class="form-control box-autor" id="addAutor'+iAutor+'" value="'+txtautor+'" aria-describedby="btn'+iAutor+'" readonly >'+
                                                    '<button class="btn btn-outline-danger" type="button" id="btn'+iAutor+'" onclick="deleteAutor('+iAutor+');" style="height: 25px; font-size:1.2vh;">x</button></div></div>';
                document.getElementById('txtAutorAPA').value="";
                iAutor +=1;
            }else{
                alert("Falta rellenar el autor");
            }

        }

        function deleteAutor(indice){
            if(indice >= 0){
                $('#rAutor'+indice).remove();
            }
        }

    </script>

</body>
@endsection
@section('js')
    <script src="/js/valida-tesis.js"></script>
@endsection


