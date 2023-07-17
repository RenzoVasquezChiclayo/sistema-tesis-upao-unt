@extends('plantilla.dashboard')
@section('titulo')
    Proyecto de Tesis del Estudiante
@endsection
@section('contenido')
    <style type="text/css">
        .border-box {
            margin-bottom: 8px;
            margin-left: 5px;
            border: 0.5px solid rgba(0, 0, 0, 0.2);
            border-radius: 20px;
            padding-top: 5px;
            padding-bottom: 10px;
        }

        .box-autor {
            height: 25px;
            font-size: 1.2vh;
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

        textarea {
            resize: none;
        }
    </style>
    <div class="" style="background-color:rgb(212, 212, 212)">
        <div class="row" style="text-align: center; padding:10px;">
            @if (session('datos'))
                <div id="mensaje">
                    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                        {{ session('datos') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            @endif
            <div class="col-12" style="align-items: center">
                <h2>Proyecto de Tesis</h2>
            </div>
        </div>
        <div class="row">
            <form id="formProyecto" name="formProyecto" action="" method="">
                @csrf
                <input type="hidden" name="textcod" value="{{ $cursoTesis[0]->cod_proyectotesis }}">
                <input type="hidden" name="id_grupo_hidden" value="{{ $cursoTesis[0]->id_grupo_inves }}">
                <div class="col-12">
                    <h4>GENERALIDADES</h4>
                    <hr style="border:1 px black;">
                </div>
                <div class="col-12">
                    <div class="row" style=" margin-bottom:20px">
                        <h5>Titulo</h5>
                        <div class="col-12">
                            <div class="row" style="margin-bottom:8px">
                                <div class="col-9 col-md-8">
                                    <input class="form-control" name="txtTitulo" id="txtTitulo" type="text"
                                        value="{{ $cursoTesis[0]->titulo }}" readonly>
                                    <span id="validateTitle" name="validateTitle" style="color: red"></span>
                                </div>
                                @if ($cursoTesis[0]->estado == 1)
                                    <div class="col-3" align="center">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-check">
                                                    <input class="form-check-input prueba" type="checkbox" id="chkCorregir1"
                                                        onchange="chkCorregir(this);">
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        Corregir
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif


                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:15px;">
                        <div class="col-12">
                            <textarea class="form-control" name="tachkCorregir1" id="tachkCorregir1" cols="30" rows="4" hidden></textarea>
                        </div>

                    </div>
                </div>
                <div class="row" style=" margin-bottom:20px; padding-right:12px;">
                    <h5>Autor(es)</h5>
                    @foreach ($estudiantes_grupo as $est)
                        <div class="row" style="margin-bottom:8px;">
                            <div class="row">
                                <div class="col-5 col-md-3">
                                    <input class="form-control" name="txtCodMatricula" id="txtCodMatricula" type="search"
                                        value="{{ $est->cod_matricula }}" readonly>
                                </div>
                            </div>
                        </div>
                        {{-- Informacion del egresado --}}
                        {{-- style="display: grid; grid-template-columns: repeat(3, 1fr); grid-gap: 5px; " --}}
                        <div class="row border-box card-box">
                            <div class="item-card col">
                                <label for="txtNombreAutor" class="form-label">Nombres</label>
                                <input class="form-control" name="txtNombreAutor" id="txtNombreAutor" type="text"
                                    value="{{ $est->nombres }}" readonly>
                            </div>
                            <div class="item-card">
                                <label for="txtApellidoAutor" class="form-label">Apellidos</label>
                                <input class="form-control" name="txtApellidoAutor" id="txtApellidoAutor" type="text"
                                    value="{{ $est->apellidos }}" readonly>
                            </div>
                        </div>
                    @endforeach



                </div>
                <div class="row" style="margin-bottom:20px; padding-right:12px;">
                    <h5>Asesor</h5>

                    <div class="row border-box card-box">
                        <div class="item-card">
                            <label for="txtNombreAsesor" class="form-label">Apellidos y Nombres</label>
                            <input class="form-control" name="txtNombreAsesor" id="txtNombreAsesor" type="text"
                                value="{{ $cursoTesis[0]->nombre_asesor }}" readonly>
                        </div>
                        <div class="item-card">
                            <label for="cboGrAcademicoAsesor" class="form-label">Grado Academico</label>
                            <input class="form-control" name="txtGrAcademicoAsesor" id="txtGrAcademicoAsesor"
                                type="text" value="{{ $cursoTesis[0]->grado_academico }}" readonly>
                        </div>
                        <div class="item-card">
                            <label for="txtTProfesional" class="form-label">Titulo Profesional</label>
                            <input class="form-control" name="txtTProfesional" id="txtTProfesional" type="text"
                                value="{{ $cursoTesis[0]->titulo_profesional }}" readonly>
                        </div>
                        <div class="item-card">
                            <label for="txtDireccionAsesor" class="form-label">Dirección laboral y/o domiciliaria</label>
                            <input class="form-control" name="txtDireccionAsesor" id="txtDireccionAsesor" type="text"
                                value="{{ $cursoTesis[0]->direccion }}" readonly>
                        </div>
                    </div>
                </div>

                <div class="row" style=" margin-bottom:20px; padding-right:12px;"
                    @if ($campos[0]->tipo_investigacion == 0) hidden @endif>
                    <div class="row">
                        <div class="col-3">
                            <h5>Tipo de Investigacion</h5>
                        </div>
                        <div class="col-3">
                            @if ($cursoTesis[0]->estado == 1)
                                <div class="col-4" align="center">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-check">
                                                <input class="form-check-input prueba" type="checkbox" id="chkCorregir23"
                                                    onchange="chkCorregir(this);">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    Corregir
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="row border-box card-box" style="margin-bottom:8px">
                        <div class="item-card col-4">
                            <label for="cboTipoInvestigacion" class="form-label">Linea de Investigacion</label>
                            <input class="form-control" type="text" name="cboTipoInvestigacion"
                                id="cboTipoInvestigacion"
                                value="@if ($tipoinvestigacion->count() > 0) {{ $tipoinvestigacion[0]->descripcion }} @endif"readonly>
                            <input type="hidden" name="txtTipoInvestigacion">
                        </div>
                        <div class="item-card col-4">
                            <label for="cboFinInvestigacion" class="form-label">De acuerdo al fin que se persigue</label>
                            <input class="form-control" type="text" name="txtFinInvestigacion"
                                id="txtFinInvestigacion" value="@if ($fin_persigue->count() > 0) {{ $fin_persigue[0]->descripcion }} @endif" readonly>
                        </div>
                        <div class="item-card col-4">
                            <label for="cboDesignInvestigacion" class="form-label">De acuerdo al diseño de
                                investigación</label>
                            <input class="form-control" type="text" name="txtDesignInvestigacion"
                                id="txtDesignInvestigacion" value="@if ($diseno_investigacion->count() > 0) {{ $diseno_investigacion[0]->descripcion }} @endif" readonly>
                        </div>
                        <div class="col-12">
                            <textarea class="form-control" name="tachkCorregir23" id="tachkCorregir23" cols="30" rows="4" hidden
                                style="margin:10px 0px 10px;"></textarea>
                        </div>

                    </div>

                </div>
                <div class="row" style="margin-bottom:20px; padding-right:12px;"
                    @if ($campos[0]->localidad_institucion == 0) hidden @endif>
                    <div class="col-12 col-md-8">
                        <div class="row border-box" style="margin-left:0px;">
                            <div class="row">
                                <div class="col-8">
                                    <h5>Localidad e Institucion</h5>
                                </div>
                                @if ($cursoTesis[0]->estado == 1)
                                    <div class="col-4" align="center">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-check">
                                                    <input class="form-check-input prueba" type="checkbox"
                                                        id="chkCorregir2" onchange="chkCorregir(this);">
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        Corregir
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                            </div>
                            <div class="row card-box" style="margin-bottom:8px">
                                <div class="item-card col-6">
                                    <label for="txtLocalidad" class="form-label">Localidad</label>
                                    <input class="form-control" name="txtLocalidad" id="txtLocalidad" type="text"
                                        value="{{ $cursoTesis[0]->localidad }}" readonly>
                                </div>

                                <div class="item-card col-6">
                                    <label for="txtInstitucion" class="form-label">Institucion</label>
                                    <input class="form-control" name="txtInstitucion" id="txtInstitucion" type="text"
                                        value="{{ $cursoTesis[0]->institucion }}" readonly>
                                </div>
                                <textarea class="form-control" name="tachkCorregir2" id="tachkCorregir2" cols="30" rows="4" hidden></textarea>

                            </div>

                        </div>

                    </div>
                    <div class="col-12 col-md-4" @if ($campos[0]->duracion_proyecto == 0) hidden @endif>
                        <div class="row border-box">
                            <h5>Duración de la ejecución del proyecto</h5>
                            <div class="row" style="margin-bottom:8px">
                                <div class="col-10 col-lg-8">
                                    <label for="txtMesesEjecucion" class="form-label">Numero de meses</label>
                                    <div class="row">
                                        <div class="col-12">
                                            <input class="form-control" name="txtMesesEjecucion" id="txtMesesEjecucion"
                                                type="text" value="{{ $cursoTesis[0]->meses_ejecucion }}" readonly>
                                            <input type="hidden" id="valuesMesesPart"
                                                value="{{ $cursoTesis[0]->t_ReparacionInstrum }},{{ $cursoTesis[0]->t_RecoleccionDatos }},{{ $cursoTesis[0]->t_AnalisisDatos }},{{ $cursoTesis[0]->t_ElaboracionInfo }}">
                                        </div>
                                        <input type="text" name="datosCronograma" id=" "
                                            value="{{ $cursoTesis[0]->t_ReparacionInstrum }}/{{ $cursoTesis[0]->t_RecoleccionDatos }}/{{ $cursoTesis[0]->t_AnalisisDatos }}/{{ $cursoTesis[0]->t_ElaboracionInfo }}"
                                            hidden>
                                    </div>

                                </div>
                                @if ($cursoTesis[0]->estado == 1)
                                    <div class="col-4" align="center">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="chkCorregir3"
                                                        onchange="chkCorregir(this);">
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        Corregir
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif


                            </div>
                            <textarea class="form-control" name="tachkCorregir3" id="tachkCorregir3" cols="30" rows="4" hidden></textarea>
                        </div>
                    </div>



                </div>
                {{-- Tabla para clickear los meses correspondientes al cronograma de trabajo --}}
                <div class="row" style=" margin-bottom:20px" @if ($campos[0]->duracion_proyecto == 0) hidden @endif>
                    <h5>Cronograma de trabajo</h5>
                    <div class="row" style="padding-left:20px; padding-right:20px; margin-bottom:8px">
                        <table class="table table-bordered border-dark">
                            <thead>
                                <tr id="headers">
                                    <th scope="col">ACTIVIDAD</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr id="1Tr">

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
                        <input type="hidden" id="listMonths" name="listMonths">
                    </div>
                </div>

                <div class="row" style="margin-bottom:20px" @if ($campos[0]->recursos == 0) hidden @endif>
                    <h5>Recursos</h5>
                    <div class="col-8 col-md-5 col-xl-11">
                        <table class="table table-striped table-bordered ">
                            <thead>
                                <tr>
                                    <th>Tipo</th>
                                    <th>Subtipo</th>
                                    <th>Descripcion</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recursos as $rec)
                                    <tr>
                                        <td>{{ $rec->tipo }}</td>
                                        <td>{{ $rec->subtipo }}</td>
                                        <td>{{ $rec->descripcion }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if ($cursoTesis[0]->estado == 1)
                        <div class="col-1" align="center">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="chkCorregir4"
                                            onchange="chkCorregir(this);">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Corregir
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <textarea class="form-control" name="tachkCorregir4" id="tachkCorregir4" cols="30" rows="4" hidden></textarea>

                </div>

                <div class="row" style="margin-bottom:20px" @if ($campos[0]->presupuesto == 0) hidden @endif>
                    <div class="col-12">
                        <hr style="border: 1px solid gray">
                    </div>
                    <h5>Presupuesto</h5>
                    {{-- Tabla resumen del presupuesto --}}

                        <div class="col-8 col-md-5 col-xl-11">
                            <table class="table">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Codigo</th>
                                        <th>Denominacion</th>
                                        <th>Precio Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($presupuesto as $presu)
                                        <tr>
                                            <td>{{ $presu->codeUniversal }}</td>
                                            <td>{{ $presu->denominacion }}</td>
                                            <td>S/. {{ $presu->precio }}.00</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="2" style="text-align: right;">
                                            <p><strong>Total:</strong></p>
                                        </th>
                                        <th>
                                            <p><strong>S/. @if ($presupuesto->count() > 0)
                                                        {{ $presupuesto[0]->precio + $presupuesto[1]->precio + $presupuesto[2]->precio + $presupuesto[3]->precio + $presupuesto[4]->precio }}
                                                    @endif
                                                </strong></p>
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        @if ($cursoTesis[0]->estado == 1)
                            <div class="col-1" align="center">
                                <div class="row">
                                    <div class="col-10">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="chkCorregir25"
                                                onchange="chkCorregir(this);">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                Corregir
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                    <div class="row" style="margin-bottom:15px;">
                        <div class="col-12">
                            <textarea class="form-control" name="tachkCorregir25" id="tachkCorregir25" cols="30" rows="4" hidden></textarea>
                        </div>

                    </div>
                </div>

                <div class="row" style="margin-bottom:20px" @if ($campos[0]->financiamiento == 0) hidden @endif>
                    <h5>Financiamiento </h5>
                    <div class="row" style="margin-bottom:8px">
                        <div class="col-8 col-md-5">
                            <input class="form-control" type="text" name="txtFinanciamiento" id="txtFinanciamiento"
                                value="{{ $cursoTesis[0]->financiamiento }}" readonly>
                        </div>
                    </div>
                </div>

                <div class="col-8" @if ($campos[0]->rp_antecedente_justificacion == 0) hidden @endif>
                    <h4>PLAN DE INVESTIGACION</h4>
                    <hr style="border:1 px black;">
                </div>

                <div class="row" style=" margin-bottom:20px" @if ($campos[0]->rp_antecedente_justificacion == 0) hidden @endif>
                    <h5>Realidad problematica </h5>
                    <div class="row" style="margin-bottom:8px">
                        <div class="col-12 col-md-10">
                            <div class="form-floating">
                                <textarea class="form-control" name="taRProblematica" id="taRProblematica" style="height: 100px; resize:none"
                                    readonly>{{ $cursoTesis[0]->real_problematica }}</textarea>
                            </div>
                        </div>
                        @if ($cursoTesis[0]->estado == 1)
                            <div class="col-2" align="center">
                                <div class="row">
                                    <div class="col-10">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="chkCorregir5"
                                                onchange="chkCorregir(this);">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                Corregir
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif


                    </div>
                    <textarea class="form-control" name="tachkCorregir5" id="tachkCorregir5" cols="30" rows="4" hidden></textarea>
                </div>
                <div class="row" style=" margin-bottom:20px" @if ($campos[0]->rp_antecedente_justificacion == 0) hidden @endif>
                    <h5>Antecedentes</h5>
                    <div class="row" style="margin-bottom:8px">
                        <div class="col-12 col-md-10">
                            <div class="form-floating">
                                <textarea class="form-control" name="taAntecedentes" id="taAntecedentes" style="height: 100px; resize:none"
                                    readonly>{{ $cursoTesis[0]->antecedentes }}</textarea>
                            </div>
                        </div>
                        @if ($cursoTesis[0]->estado == 1)
                            <div class="col-2" align="center">
                                <div class="row">
                                    <div class="col-10">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="chkCorregir6"
                                                onchange="chkCorregir(this);">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                Corregir
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif


                    </div>
                    <textarea class="form-control" name="tachkCorregir6" id="tachkCorregir6" cols="30" rows="4" hidden></textarea>
                </div>
                <div class="row" style=" margin-bottom:20px" @if ($campos[0]->rp_antecedente_justificacion == 0) hidden @endif>
                    <h5>Justificación de la investigación</h5>
                    <div class="row" style="margin-bottom:8px">
                        <div class="col-12 col-md-10">
                            <div class="form-floating">
                                <textarea class="form-control" name="taJInvestigacion" id="taJInvestigacion" style="height: 100px; resize:none"
                                    readonly>{{ $cursoTesis[0]->justificacion }}</textarea>
                            </div>
                        </div>
                        @if ($cursoTesis[0]->estado == 1)
                            <div class="col-2" align="center">
                                <div class="row">
                                    <div class="col-10">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="chkCorregir7"
                                                onchange="chkCorregir(this);">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                Corregir
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif


                    </div>
                    <textarea class="form-control" name="tachkCorregir7" id="tachkCorregir7" cols="30" rows="4" hidden></textarea>
                </div>
                <div class="row" style=" margin-bottom:20px" @if ($campos[0]->formulacion_problema == 0) hidden @endif>
                    <h5>Formulación del problema</h5>
                    <div class="row" style="margin-bottom:8px">
                        <div class="col-12 col-md-10">
                            <div class="form-floating">
                                <textarea class="form-control" name="taFProblema" id="taFProblema" style="height: 100px; resize:none" readonly>{{ $cursoTesis[0]->formulacion_prob }}</textarea>
                            </div>
                        </div>
                        @if ($cursoTesis[0]->estado == 1)
                            <div class="col-2" align="center">
                                <div class="row">
                                    <div class="col-10">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="chkCorregir8"
                                                onchange="chkCorregir(this);">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                Corregir
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif


                    </div>
                    <textarea class="form-control" name="tachkCorregir8" id="tachkCorregir8" cols="30" rows="4" hidden></textarea>
                </div>
                <div class="row" style=" margin-bottom:20px" @if ($campos[0]->objetivos == 0) hidden @endif>
                    <h5>Objetivos</h5>
                    <div class="col-8 col-md-5 col-xl-11">
                        <table class="table table-striped table-bordered ">
                            <thead>
                                <tr>
                                    <th>Tipo</th>
                                    <th>Descripcion</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($objetivos as $obj)
                                    <tr>
                                        <td>{{ $obj->tipo }}</td>
                                        <td>{{ $obj->descripcion }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if ($cursoTesis[0]->estado == 1)
                        <div class="col-1" align="center">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="chkCorregir9"
                                            onchange="chkCorregir(this);">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Corregir
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <textarea class="form-control" name="tachkCorregir9" id="tachkCorregir9" cols="30" rows="4" hidden></textarea>
                </div>
                {{-- Aqui van los marcos teorico, conceptual y legal(opcional) --}}
                <div class="row" style=" margin-bottom:20px" @if ($campos[0]->marcos == 0) hidden @endif>
                    <div class="row" style="margin-bottom:15px">
                        <div class="col-12">
                            <hr style="border: 1px solid gray">
                        </div>
                        <h5>Marco Teórico</h5>
                        <div class="row">
                            <div class="col-12 col-md-10">
                                <div class="form-floating">
                                    <textarea class="form-control" name="taMTeorico" id="taMTeorico" style="height: 100px; resize:none" readonly>{{ $cursoTesis[0]->marco_teorico }}</textarea>
                                </div>
                            </div>
                            @if ($cursoTesis[0]->estado == 1)
                                <div class="col-2" align="center">
                                    <div class="row">
                                        <div class="col-10">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="chkCorregir10"
                                                    onchange="chkCorregir(this);">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    Corregir
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        </div>
                        <textarea class="form-control" name="tachkCorregir10" id="tachkCorregir10" cols="30" rows="4" hidden></textarea>
                    </div>

                    <div class="row" style="margin-bottom:15px">
                        <h5>Marco Conceptual</h5>
                        <div class="row">
                            <div class="col-12 col-md-10">
                                <div class="form-floating">
                                    <textarea class="form-control" name="taMConceptual" id="taMConceptual" style="height: 100px; resize:none" readonly>{{ $cursoTesis[0]->marco_conceptual }}</textarea>
                                </div>
                            </div>
                            @if ($cursoTesis[0]->estado == 1)
                                <div class="col-2" align="center">
                                    <div class="row">
                                        <div class="col-0">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="chkCorregir11"
                                                    onchange="chkCorregir(this);">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    Corregir
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        </div>
                        <textarea class="form-control" name="tachkCorregir11" id="tachkCorregir11" cols="30" rows="4" hidden></textarea>
                    </div>

                    <div class="row" style="margin-bottom:15px">
                        <h5>Marco Legal</h5>
                        <div class="row">
                            <div class="col-12 col-md-10">
                                <div class="form-floating">
                                    <textarea class="form-control" name="taMLegal" id="taMLegal" style="height: 100px; resize:none" readonly>{{ $cursoTesis[0]->marco_legal }}</textarea>
                                </div>
                            </div>
                            @if ($cursoTesis[0]->estado == 1)
                                <div class="col-2" align="center">
                                    <div class="row">
                                        <div class="col-10">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="chkCorregir12"
                                                    onchange="chkCorregir(this);">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    Corregir
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        </div>
                        <textarea class="form-control" name="tachkCorregir12" id="tachkCorregir12" cols="30" rows="4" hidden></textarea>
                    </div>
                </div>

                <div class="row" style=" margin-bottom:20px" @if ($campos[0]->formulacion_hipotesis == 0) hidden @endif>
                    <h5>Formulación de la hipótesis </h5>
                    <div class="row" style="margin-bottom:8px">
                        <div class="row">
                            <div class="col-12 col-md-10">
                                <div class="form-floating">
                                    <textarea class="form-control" name="taFHipotesis" id="taFHipotesis" style="height: 100px; resize:none" readonly>{{ $cursoTesis[0]->form_hipotesis }}</textarea>
                                </div>
                            </div>
                            @if ($cursoTesis[0]->estado == 1)
                                <div class="col-2" align="center">
                                    <div class="row">
                                        <div class="col-10">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="chkCorregir13"
                                                    onchange="chkCorregir(this);">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    Corregir
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        </div>
                        <textarea class="form-control" name="tachkCorregir13" id="tachkCorregir13" cols="30" rows="4" hidden></textarea>
                    </div>
                </div>

                <div class="row" style=" margin-bottom:20px" @if ($campos[0]->diseño_investigacion == 0) hidden @endif>
                    <div class="row">
                        {{-- Punto Diseno de Investigacion y demas subtemas --}}
                        <h5>Diseño de Investigación</h5>
                        <h6>Material, Métodos y Técnicas</h6>
                        <hr style="width: 60%; margin-left:15px;" />
                    </div>
                    <div class="row" style="margin-bottom:8px">
                        <label for="taOEstudio" class="form-label">Objeto de Estudio</label>
                        <div class="col-12 col-md-10">
                            <div class="form-floating">
                                <textarea class="form-control" name="taOEstudio" id="taOEstudio" style="height: 100px; resize:none" readonly>{{ $cursoTesis[0]->objeto_estudio }}</textarea>
                            </div>
                        </div>
                        @if ($cursoTesis[0]->estado == 1)
                            <div class="col-2" align="center">
                                <div class="row">
                                    <div class="col-10">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="chkCorregir14"
                                                onchange="chkCorregir(this);">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                Corregir
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <textarea class="form-control" name="tachkCorregir14" id="tachkCorregir14" cols="30" rows="4" hidden></textarea>
                    </div>
                    <div class="row" style="margin-bottom:8px">
                        <label for="taPoblacion" class="form-label">Población</label>
                        <div class="col-12 col-md-10">
                            <div class="form-floating">
                                <textarea class="form-control" name="taPoblacion" id="taPoblacion" style="height: 100px; resize:none" readonly>{{ $cursoTesis[0]->poblacion }}</textarea>
                            </div>
                        </div>
                        @if ($cursoTesis[0]->estado == 1)
                            <div class="col-2" align="center">
                                <div class="row">
                                    <div class="col-10">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="chkCorregir15"
                                                onchange="chkCorregir(this);">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                Corregir
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <textarea class="form-control" name="tachkCorregir15" id="tachkCorregir15" cols="30" rows="4" hidden></textarea>
                    </div>
                    <div class="row" style="margin-bottom:8px">
                        <label for="taMuestra" class="form-label">Muestra</label>
                        <div class="col-12 col-md-10">
                            <div class="form-floating">
                                <textarea class="form-control" name="taMuestra" id="taMuestra" style="height: 100px; resize:none" readonly>{{ $cursoTesis[0]->muestra }}</textarea>
                            </div>
                        </div>
                        @if ($cursoTesis[0]->estado == 1)
                            <div class="col-2" align="center">
                                <div class="row">
                                    <div class="col-10">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="chkCorregir16"
                                                onchange="chkCorregir(this);">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                Corregir
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <textarea class="form-control" name="tachkCorregir16" id="tachkCorregir16" cols="30" rows="4" hidden></textarea>
                    </div>
                    <div class="row" style="margin-bottom:8px">
                        <label for="taMetodos" class="form-label">Métodos</label>
                        <div class="col-12 col-md-10">
                            <div class="form-floating">
                                <textarea class="form-control" name="taMetodos" id="taMetodos" style="height: 100px; resize:none" readonly>{{ $cursoTesis[0]->metodos }}</textarea>
                            </div>
                        </div>
                        @if ($cursoTesis[0]->estado == 1)
                            <div class="col-2" align="center">
                                <div class="row">
                                    <div class="col-10">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="chkCorregir17"
                                                onchange="chkCorregir(this);">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                Corregir
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <textarea class="form-control" name="tachkCorregir17" id="tachkCorregir17" cols="30" rows="4" hidden></textarea>
                    </div>
                    <div class="row" style="margin-bottom:8px">
                        <label for="taRecoleccionDatos" class="form-label">Técnicas e instrumentos de recolección de
                            datos</label>
                        <div class="col-12 col-md-10">
                            <div class="form-floating">
                                <textarea class="form-control" name="taRecoleccionDatos" id="taRecoleccionDatos" type="text"
                                    style="height: 100px; resize:none" readonly>{{ $cursoTesis[0]->tecnicas_instrum }}</textarea>
                            </div>
                        </div>
                        @if ($cursoTesis[0]->estado == 1)
                            <div class="col-2" align="center">
                                <div class="row">
                                    <div class="col-10">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="chkCorregir18"
                                                onchange="chkCorregir(this);">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                Corregir
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <textarea class="form-control" name="tachkCorregir18" id="tachkCorregir18" cols="30" rows="4" hidden></textarea>
                    </div>
                    <div class="row" style="margin-bottom:20px">
                        <h6>Instrumentación y/o fuentes de datos</h6>
                        <div class="col-12 col-md-10">
                            <div class="form-floating">
                                <textarea class="form-control" name="taFuentesDatos" id="taFuentesDatos" type="text"
                                    style="height: 100px; resize:none" readonly>{{ $cursoTesis[0]->instrumentacion }}</textarea>
                            </div>
                        </div>
                        @if ($cursoTesis[0]->estado == 1)
                            <div class="col-2" align="center">
                                <div class="row">
                                    <div class="col-10">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="chkCorregir19"
                                                onchange="chkCorregir(this);">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                Corregir
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <textarea class="form-control" name="tachkCorregir19" id="tachkCorregir19" cols="30" rows="4" hidden></textarea>
                    </div>
                    <div class="row" style="margin-bottom:20px">
                        <h6>Estrategias Metodológicas</h6>
                        <div class="col-12 col-md-10">
                            <div class="form-floating">
                                <textarea class="form-control" name="taEstrategiasM" id="taEstrategiasM" style="height: 100px; resize:none"
                                    readonly>{{ $cursoTesis[0]->estg_metodologicas }}</textarea>
                            </div>
                        </div>
                        @if ($cursoTesis[0]->estado == 1)
                            <div class="col-2" align="center">
                                <div class="row">
                                    <div class="col-10">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="chkCorregir20"
                                                onchange="chkCorregir(this);">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                Corregir
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <textarea class="form-control" name="tachkCorregir20" id="tachkCorregir20" cols="30" rows="4" hidden></textarea>
                    </div>
                    <div class="row" style="margin-bottom:20px">
                        {{-- Variables de operalizacion modal extra --}}
                        <h6>Variables</h6>
                        <div class="col-8 col-md-7 col-xl-11">
                            <table class="table table-striped table-bordered ">
                                <thead>
                                    <tr>
                                        <th>Descripcion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($variableop as $var)
                                        <tr>
                                            <td>{{ $var->descripcion }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if ($cursoTesis[0]->estado == 1)
                            <div class="col-1" align="center">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="chkCorregir21"
                                                onchange="chkCorregir(this);">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                Corregir
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <textarea class="form-control" name="tachkCorregir21" id="tachkCorregir21" cols="30" rows="4" hidden></textarea>
                        <div class="row">
                            <h5>Matriz Operacional</h5>
                            <div class="col-10">
                                <table class="table" id="table-matriz" style="border: 5px;">
                                    <thead>
                                        <tr>
                                            <th scope="col">VARIABLES</th>
                                            <th scope="col">DEFINICION CONCEPTUAL</th>
                                            <th scope="col">DEFINICION OPERACIONAL</th>
                                            <th scope="col">DIMENSIONES</th>
                                            <th scope="col">INDICADORES</th>
                                            <th scope="col">ESCALA</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($matriz->count() > 0)
                                            <tr id="table-matriz-tr">
                                                <td>VI</td>
                                                <td>
                                                    <textarea class="form-control" name="i_varI" rows="3" cols="8" readonly>
@if ($matriz[0]->variable_I != null)
{{ $matriz[0]->variable_I }}
@endif
</textarea>
                                                </td>
                                                <td>
                                                    <textarea class="form-control" name="i_dc" rows="3" cols="8" readonly>
@if ($matriz[0]->def_conceptual_I != null)
{{ $matriz[0]->def_conceptual_I }}
@endif
</textarea>
                                                </td>
                                                <td>
                                                    <textarea class="form-control" name="i_do" rows="3" cols="8" readonly>
@if ($matriz[0]->def_operacional_I != null)
{{ $matriz[0]->def_operacional_I }}
@endif
</textarea>
                                                </td>
                                                <td>
                                                    <textarea class="form-control" name="i_dim" rows="3" cols="8" readonly>
@if ($matriz[0]->dimensiones_I != null)
{{ $matriz[0]->dimensiones_I }}
@endif
</textarea>
                                                </td>
                                                <td>
                                                    <textarea class="form-control" name="i_ind" rows="3" cols="8" readonly>
@if ($matriz[0]->indicadores_I != null)
{{ $matriz[0]->indicadores_I }}
@endif
</textarea>
                                                </td>
                                                <td>
                                                    <textarea class="form-control" name="i_esc" rows="3" cols="8" readonly>
@if ($matriz[0]->escala_I != null)
{{ $matriz[0]->escala_I }}
@endif
</textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>VD</td>
                                                <td>
                                                    <textarea class="form-control" name="d_varD" rows="3" cols="8" readonly>
@if ($matriz[0]->variable_D != null)
{{ $matriz[0]->variable_D }}
@endif
</textarea>
                                                </td>
                                                <td>
                                                    <textarea class="form-control" name="d_dc" rows="3" cols="8" readonly>
@if ($matriz[0]->def_conceptual_D != null)
{{ $matriz[0]->def_conceptual_D }}
@endif
</textarea>
                                                </td>
                                                <td>
                                                    <textarea class="form-control" name="d_do" rows="3" cols="8" readonly>
@if ($matriz[0]->def_operacional_D != null)
{{ $matriz[0]->def_operacional_D }}
@endif
</textarea>
                                                </td>
                                                <td>
                                                    <textarea class="form-control" name="d_dim" rows="3" cols="8" readonly>
@if ($matriz[0]->dimensiones_D != null)
{{ $matriz[0]->dimensiones_D }}
@endif
</textarea>
                                                </td>
                                                <td>
                                                    <textarea class="form-control" name="d_ind" rows="3" cols="8" readonly>
@if ($matriz[0]->indicadores_D != null)
{{ $matriz[0]->indicadores_D }}
@endif
</textarea>
                                                </td>
                                                <td>
                                                    <textarea class="form-control" name="d_esc" rows="3" cols="8" readonly>
@if ($matriz[0]->escala_D != null)
{{ $matriz[0]->escala_D }}
@endif
</textarea>
                                                </td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td colspan="6"><em class="class="fst-italic"">No existen datos</em>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            @if ($cursoTesis[0]->estado == 1)
                            <div class="col-2" align="center">
                                <div class="row">
                                    <div class="col-10">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="chkCorregir24"
                                                onchange="chkCorregir(this);">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                Corregir
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <textarea class="form-control" name="tachkCorregir24" id="tachkCorregir24" cols="30" rows="4" hidden></textarea>
                        </div>

                    </div>
                </div>
                <div class="row" style=" margin-bottom:20px; padding-right:12px;"
                    @if ($campos[0]->referencias_b == 0) hidden @endif>
                    <div class="col-12">
                        <hr style="border: 1px solid gray">
                    </div>
                    <h5>Referencias bibliográficas</h5>
                    <div class="col-8 col-md-7 col-xl-11">
                        <table class="table table-striped table-bordered ">
                            <tbody>
                                @foreach ($referencias as $ref)
                                    <tr>
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
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if ($cursoTesis[0]->estado == 1)
                        <div class="col-1" align="center">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="chkCorregir22"
                                            onchange="chkCorregir(this);">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Corregir
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <textarea class="form-control" name="tachkCorregir22" id="tachkCorregir22" cols="30" rows="4" hidden></textarea>
                </div>
                <input type="hidden" name="validacionCampos" id="validacionCampos" value="{{ $camposFull }}">
                <input type="hidden" name="validacionTesis" id="validacionTesis" value="{{ $isFinal }}">
                <div class="row" style="padding-top: 20px; padding-bottom:20px;">
                    <div class="col-12">
                        <div class="row" style="text-align:left; ">
                            <div class="row" id="grupoAproDesa" hidden>
                                <div class="d-grid gap-2 d-md-block">
                                    <input class="btn btn-success" type="button" value="APROBAR PROYECTO"
                                        onclick="aprobarProy();" style="margin-right:20px;">
                                    <input class="btn btn-danger" type="button" value="DESAPROBAR PROYECTO"
                                        onclick="desaprobarProy();" style="margin-right:20px;">
                                </div>

                            </div>
                            <div class="row" id="grupoObservaciones">

                                <div class="d-grid gap-2 d-md-block">
                                    @if ($cursoTesis[0]->estado == 1)
                                        <input class="btn btn-secondary" type="button" id="btnSinObservar" value="Sin observaciones"
                                            onclick="saveWithoutErrors();">
                                        <input class="btn btn-primary" type="button" id="btnConObservacion" value="Guardar Observaciones"
                                            onclick="uploadProyecto();">
                                    @endif
                                    {{-- @if ($cursoTesis[0]->estado == 2)
                                        <input class="btn btn-warning" type="button" value="Editar campos"
                                            onclick="editCamposEstudiante();">
                                    @endif
                                    @if ($camposFull == 'true')
                                        <input class="btn btn-warning" type="button" id="btnCalificacionFinal" value="Calificación Final"
                                        onclick="checkAprobation();">
                                    @endif --}}
                                    <a href="{{ route('asesor.showEstudiantes') }}" type="button"
                                        class="btn btn-outline-danger">Cancelar</a>

                                </div>

                            </div>

                        </div>
                    </div>
                </div>



            </form>
        </div>
    </div>
@endsection
@section('js')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        let array_chk = new Array(24);
        array_chk.fill(0, 0);
        array_chk[0] = 99;
        /*Esta funcion es implementada cuando se inicia la ventana y el proyecto de tesis
          ya se haya registrado antes.*/
        window.onload = function() {

            /*Valores de los meses de ejecucion y a la vez recibimos los valores para la tabla*/
            const valueMes = document.getElementById('txtMesesEjecucion').value;
            const valueMesPart = document.getElementById('valuesMesesPart').value;

            /*Verificamos que los meses contiene valor*/
            if (valueMes != "" || valueMes != 0) {
                setMeses();
            }

            if (valueMesPart != "") {
                /*Cada valor de mes en la actividad del cronograma la hemos separado por comas*/
                let eachActivity = valueMesPart.split(",");
                for (let i = 0; i < eachActivity.length; i++) {
                    /*Luego separamos los valores obtenidos antes mediante un guion*/
                    let mesActivity = eachActivity[i].split("-");

                    let extrasumador = 0;
                    for (let j = 0; j < mesActivity.length; j++) {
                        let activity = i + 1;
                        /*Esta condicion aplica cuando en el cronograma una actividad solo ocupó un mes*/
                        if (mesActivity[0] == mesActivity[1]) {
                            extrasumador += 1;
                        }
                        /*El extrasumador nos ayuda a que solo se repita una vez*/
                        if (extrasumador != 1) {
                            setColorInit(activity + 'Tr' + mesActivity[j]);
                            extrasumador = 0;
                        }

                    }
                }
            }

        };

        /*Esta funcion la hemos duplicado para aplicar solo cuando haya datos registrados en el cronograma*/
        function setColorInit(id) {
            const celda = document.getElementById(id);
            const ncelda = document.getElementById('n' + id);
            let cont = ncelda.value;
            let touch = parseInt(cont) + 1
            ncelda.value = touch;

            if (touch % 2 != 0) {
                celda.style.backgroundColor = "red";
            } else {
                celda.style.backgroundColor = "rgb(212, 212, 212)";
            }
        }

        function aprobarProy() {
            Swal.fire({
                title: 'Estas seguro(a)?',
                text: "El proyecto sera APROBADO!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, APROBAR!',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.formProyecto.action = "{{ route('asesor.aprobarCTProy') }}";
                    document.formProyecto.method = "POST";
                    document.formProyecto.submit();
                }
            })

        }

        function desaprobarProy() {
            Swal.fire({
                title: 'Estas seguro(a)?',
                text: "El proyecto sera DESAPROBADO!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, DESAPROBAR!',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.formProyecto.action = "{{ route('asesor.desaprobarCTProy') }}";
                    document.formProyecto.method = "POST";
                    document.formProyecto.submit();
                }
            })

        }

        function uploadProyecto() {

            let hayCorreccion = false;
            for (let i = 1; i < 26; i++) {
                if (array_chk[i] == 1) {
                    if (document.getElementById('tachkCorregir' + i).value != "") {
                        hayCorreccion = true;
                    } else {
                        hayCorreccion = false;
                    }
                }
            }
            if (!hayCorreccion) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Necesita realizar una observacion'
                })
            } else {
                Swal.fire({
                    title: 'Estas seguro(a)?',
                    text: "Se guardaran las observaciones!",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, guardar!',
                    cancelButtonText: 'Cancelar',
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.formProyecto.action = "{{ route('asesor.guardarObservaciones') }}";
                        document.formProyecto.method = "POST";
                        document.formProyecto.submit();
                    }
                })



            }
        }

        // Guardar sin observacion el proyecto
        function saveWithoutErrors() {
            //Validar si hay checks activos
            const condition = (check) => check == 1
            const isFill = array_chk.some(condition)
            var validaCampos = document.getElementById('validacionCampos').value;
            if(isFill){
                Swal.fire({
                    icon: 'info',
                    title: 'Aviso!',
                    text: 'Usted realizó algun(as) observacion(es)\n y esta intentando guardar sin ella(s)'
                })
                return
            }
            if (validaCampos == 'true') {

                checkAprobation();
                return;
            }
            Swal.fire({
                title: 'Estas seguro(a)?',
                text: "No se guardaran observaciones!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, continuar!',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.formProyecto.action = "{{ route('asesor.asignarTemas') }}";
                    document.formProyecto.method = "POST";
                    document.formProyecto.submit();
                }
            })

        }

        /*Validar si se aprueba o no*/
        function checkAprobation() {
            var validacionCampos = document.getElementById('validacionCampos').value;
            var validacionTesis = document.getElementById('validacionTesis').value;
            if (validacionTesis == 'true' && validacionCampos == 'true') {
                document.getElementById('btnSinObservar').hidden = true;
                document.getElementById('btnConObservacion').hidden = true;

                document.getElementById('grupoAproDesa').hidden = false;
                document.getElementById('grupoObservaciones').hidden = true;
            }
        }

        function editCamposEstudiante() {
            document.formProyecto.action = "{{ route('asesor.asignarTemas') }}";
            document.formProyecto.method = "POST";
            document.formProyecto.submit();
        }

        function chkCorregir(check) {
            const idcheck = check.id
            const numero_check = idcheck.split('chkCorregir');
            if (document.getElementById(check.id).checked) {
                document.getElementById('ta' + check.id).hidden = false;
                array_chk[numero_check[1]] = 1;
            } else {
                array_chk[numero_check[1]] = 0;
                document.getElementById('ta' + check.id).hidden = true;
                document.getElementById('ta' + check.id).value = "";
            }
        }

        var existMes = false;
        var lastMonth = 0;

        function setMeses() {
            if (existMes == false) {
                existMes = true;
                meses = document.getElementById("txtMesesEjecucion").value;
                lastMonth = meses;
                for (i = 1; i <= meses; i++) {
                    document.getElementById("headers").innerHTML += '<th id="Mes' + i + '" scope="col">Mes ' + i + '</th>'
                    document.getElementById("1Tr").innerHTML += '<input type="hidden" id="n1Tr' + i + '" name="n1Tr' + i +
                        '" value="0"><td id="1Tr' + i + '" onclick="setColorTable(this);"></td>'
                    document.getElementById("2Tr").innerHTML += '<input type="hidden" id="n2Tr' + i + '" name="n2Tr' + i +
                        '" value="0"><td id="2Tr' + i + '" onclick="setColorTable(this);"></td>'
                    document.getElementById("3Tr").innerHTML += '<input type="hidden" id="n3Tr' + i + '" name="n3Tr' + i +
                        '" value="0"><td id="3Tr' + i + '" onclick="setColorTable(this);"></td>'
                    document.getElementById("4Tr").innerHTML += '<input type="hidden" id="n4Tr' + i + '" name="n4Tr' + i +
                        '" value="0"><td id="4Tr' + i + '" onclick="setColorTable(this);"></td>'
                }
            } else {
                for (i = 1; i <= lastMonth; i++) {
                    $('#Mes' + i).remove();
                    $('#n1Tr' + i).remove();
                    $('#n2Tr' + i).remove();
                    $('#n3Tr' + i).remove();
                    $('#n4Tr' + i).remove();

                    $('#1Tr' + i).remove();
                    $('#2Tr' + i).remove();
                    $('#3Tr' + i).remove();
                    $('#4Tr' + i).remove();
                }
                existMes = false;
                setMeses();
            }
        }
        /*Funcion para pintar las celdas que se seleccionen para cada actividad*/
        function setColorTable(celda) {
            cont = document.getElementById("n" + celda.id).value;
            datos = document.getElementById()
            touch = parseInt(cont) + 1
            document.getElementById("n" + celda.id).value = touch;

            if (touch % 2 != 0) {
                celda.style.backgroundColor = "red";
            } else {
                celda.style.backgroundColor = "rgb(212, 212, 212)";
            }
        }
    </script>
@endsection
