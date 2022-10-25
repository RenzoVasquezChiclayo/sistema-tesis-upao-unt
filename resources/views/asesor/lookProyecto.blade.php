@extends('plantilla.dashboard')
@section('titulo')
    Proyecto de Tesis
@endsection
@section('contenido')
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
    textarea{
        resize:none;
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
                @if (sizeof($observaciones)==0)
                    <h4>1era Observaciones</h4>
                @elseif(sizeof($observaciones)==1)
                    <h4>2da Observaciones</h4>
                @elseif(sizeof($observaciones)==3)
                    <h4>3ra Observaciones</h4>
                @endif
            </div>
        </div>
        <div class="row">
            <form id="formProyecto" name="formProyecto" action="" method="">
                @csrf
                <input type="hidden" name="textcod" value="{{$proyecto[0]->cod_proyinvestigacion}}">

                <div class="col-12">
                    <h4 >GENERALIDADES</h4>
                    <hr style="border:1 px black;">
                </div>
                <div class="col-12">
                    <div class="row" style=" margin-bottom:20px">
                        <h5>Titulo</h5>
                        <div class="col-12">
                            <div class="row" style="margin-bottom:8px">
                                <div class="col-9 col-md-8">
                                    <input class="form-control" name="txtTitulo" id="txtTitulo" type="text" value="{{$proyecto[0]->titulo}}" readonly>
                                    <span id="validateTitle" name="validateTitle" style="color: red"></span>
                                </div>
                                @if ($proyecto[0]->condicion==null)
                                <div class="col-3" align="center">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="chkCorregir1" onchange="chkCorregir(this);">
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
                    <h5>Autor</h5>
                    <div class="row" style="margin-bottom:8px;">
                        <div class="row">
                            <div class="col-5 col-md-3">
                                <input class="form-control" name="txtCodMatricula" id="txtCodMatricula" type="search" value="{{$proyecto[0]->cod_matricula}}" readonly>
                            </div>
                        </div>
                    </div>

                    {{--Informacion del egresado--}}
                    {{-- style="display: grid; grid-template-columns: repeat(3, 1fr); grid-gap: 5px; " --}}
                    <div class="row border-box card-box" >
                        <div class="item-card col">
                            <label for="txtNombreAutor" class="form-label">Nombres</label>
                            <input class="form-control" name="txtNombreAutor" id="txtNombreAutor" type="text" value="{{$proyecto[0]->nombresAutor}}" readonly>
                        </div>
                        <div class="item-card">
                            <label for="txtApellidoAutor" class="form-label">Apellidos</label>
                            <input class="form-control" name="txtApellidoAutor" id="txtApellidoAutor" type="text" value="{{$proyecto[0]->apellidosAutor}}" readonly>
                        </div>
                        <div class="item-card">
                            <label for="cboEscuela" class="form-label">Escuela</label>
                            <input class="form-control" name="txtEscuelaAutor" id="txtEscuelaAutor" type="text" value="{{$proyecto[0]->escuela}}" readonly>
                        </div>
                        <div class="item-card">
                            <label for="txtDireccionAutor" class="form-label">Direccion</label>
                            <input class="form-control" name="txtDireccionAutor" id="txtDireccionAutor" type="text" value="{{$proyecto[0]->direccion}}" readonly>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-bottom:20px; padding-right:12px;">
                    <h5>Asesor</h5>
                    <div class="row" style="margin-bottom:8px;">
                        <div class="row">
                            <div class="col-5 col-md-3">
                                <input class="form-control" name="txtCodDocente" id="txtCodDocente" type="text" value="{{$proyecto[0]->cod_asesor}}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row border-box card-box">
                        <div class="item-card">
                            <label for="txtNombreAsesor" class="form-label">Apellidos y Nombres</label>
                            <input class="form-control" name="txtNombreAsesor" id="txtNombreAsesor" type="text" value="{{$proyecto[0]->nombre_asesor}}" readonly>
                        </div>
                        <div class="item-card">
                            <label for="cboGrAcademicoAsesor" class="form-label">Grado Academico</label>
                            <input class="form-control" name="txtGrAcademicoAsesor" id="txtGrAcademicoAsesor" type="text" value="{{$proyecto[0]->grado_asesor}}" readonly>
                        </div>
                        <div class="item-card">
                            <label for="txtTProfesional" class="form-label">Titulo Profesional</label>
                            <input class="form-control" name="txtTProfesional" id="txtTProfesional" type="text" value="{{$proyecto[0]->titulo_asesor}}" readonly>
                        </div>
                        <div class="item-card">
                            <label for="txtDireccionAsesor" class="form-label">Dirección laboral y/o domiciliaria</label>
                            <input class="form-control" name="txtDireccionAsesor" id="txtDireccionAsesor" type="text" value="{{$proyecto[0]->direccion_asesor}}" readonly>
                        </div>
                    </div>
                </div>

                <div class="row" style=" margin-bottom:20px; padding-right:12px;">
                    <h5>Tipo de Investigacion</h5>
                    <div class="row border-box card-box" style="margin-bottom:8px">
                        <div class="item-card col-4">
                            <label for="cboTipoInvestigacion" class="form-label">Linea de Investigacion</label>
                            <input class="form-control" type="text" name="cboTipoInvestigacion" id="cboTipoInvestigacion" value="{{$proyecto[0]->descripcion}}" readonly>
                            <input type="hidden" name="txtTipoInvestigacion">
                        </div>
                        <div class="item-card col-4">
                            <label for="cboFinInvestigacion" class="form-label">De acuerdo al fin que se persigue</label>
                            <input class="form-control" type="text" name="txtFinInvestigacion" id="txtFinInvestigacion" value="{{$proyecto[0]->ti_finpersigue}}" readonly>
                        </div>
                        <div class="item-card col-4">
                            <label for="cboDesignInvestigacion" class="form-label">De acuerdo al diseño de investigación</label>
                            <input class="form-control" type="text" name="txtDesignInvestigacion" id="txtDesignInvestigacion" value="{{$proyecto[0]->ti_disinvestigacion}}" readonly>
                        </div>

                    </div>
                </div>
                <div class="row" style="margin-bottom:20px; padding-right:12px;">
                    <div class="col-12 col-md-8">
                        <div class="row border-box" style="margin-left:0px;">
                            <div class="row">
                                <div class="col-8">
                                    <h5>Localidad e Institucion</h5>
                                </div>
                                @if ($proyecto[0]->condicion==null)
                                <div class="col-4" align="center">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="chkCorregir2" onchange="chkCorregir(this);">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    Corregir
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif

                            </div>
                            <div class="row car-box" style="margin-bottom:8px">
                                <div class="item-card col-6">
                                    <label for="txtLocalidad" class="form-label">Localidad</label>
                                    <input class="form-control" name="txtLocalidad" id="txtLocalidad" type="text" value="{{$proyecto[0]->localidad}}" readonly>
                                </div>

                                <div class="item-card col-6">
                                    <label for="txtInstitucion" class="form-label">Institucion</label>
                                    <input class="form-control" name="txtInstitucion" id="txtInstitucion" type="text" value="{{$proyecto[0]->institucion}}" readonly>
                                </div>
                                <textarea class="form-control" name="tachkCorregir2" id="tachkCorregir2" cols="30" rows="4" hidden></textarea>

                            </div>

                        </div>

                    </div>
                    <div class="col-12 col-md-4">
                        <div class="row border-box">
                            <h5>Duración de la ejecución del proyecto</h5>
                            <div class="row" style="margin-bottom:8px">
                                <div class="col-10 col-lg-8">
                                    <label for="txtMesesEjecucion" class="form-label">Numero de meses</label>
                                    <div class="row">
                                        <div class="col-12">
                                            <input class="form-control" name="txtMesesEjecucion" id="txtMesesEjecucion" type="text" value="{{$proyecto[0]->meses_ejecucion}}" readonly>
                                            <input type="hidden" id="valuesMesesPart" value="{{$proyecto[0]->t_ReparacionInstrum}},{{$proyecto[0]->t_RecoleccionDatos}},{{$proyecto[0]->t_AnalisisDatos}},{{$proyecto[0]->t_ElaboracionInfo}}">
                                        </div>
                                        <input type="text" name="datosCronograma" id=" " value="{{$proyecto[0]->t_ReparacionInstrum}}/{{$proyecto[0]->t_RecoleccionDatos}}/{{$proyecto[0]->t_AnalisisDatos}}/{{$proyecto[0]->t_ElaboracionInfo}}" hidden>
                                    </div>

                                </div>
                                @if ($proyecto[0]->condicion==null)
                                <div class="col-4" align="center">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="chkCorregir3" onchange="chkCorregir(this);">
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
                <div class="row" style=" margin-bottom:20px">
                    <h5>Cronograma de trabajo</h5>
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
                        <input type="hidden" id="listMonths" name="listMonths">
                    </div>
                </div>

                <div class="row" style="margin-bottom:20px">
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
                                        <td>{{$rec->tipo}}</td>
                                        <td>{{$rec->subtipo}}</td>
                                        <td>{{$rec->descripcion}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if ($proyecto[0]->condicion==null)
                    <div class="col-1" align="center">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="chkCorregir4" onchange="chkCorregir(this);">
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
                            <tbody>
                                @foreach ($presupuesto as $presu)
                                    <tr>
                                        <td>{{$presu->codeUniversal}}</td>
                                        <td>{{$presu->denominacion}}</td>
                                        <td>S/. {{$presu->precio}}.00</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>
                                        {{-- <td>S/.{{$proy->codeUniversal + $proy->denominacionPresu + $proy->precioPresup}}.00</td> --}}
                                    </th>

                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div class="row" style="margin-bottom:20px">
                    <h5>Financiamiento </h5>
                    <div class="row" style="margin-bottom:8px">
                        <div class="col-8 col-md-5">
                            <input class="form-control" type="text" name="txtFinanciamiento" id="txtFinanciamiento" value="{{$proyecto[0]->financiamiento}}" readonly>
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
                                <textarea class="form-control" name="taRProblematica" id="taRProblematica" style="height: 100px; resize:none" readonly>{{$proyecto[0]->real_problematica}}</textarea>
                            </div>
                        </div>
                        @if ($proyecto[0]->condicion==null)
                        <div class="col-2" align="center">
                            <div class="row">
                                <div class="col-10">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="chkCorregir5" onchange="chkCorregir(this);">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Corregir
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif


                    </div>
                    <textarea class="form-control" name="tachkCorregir5" id="tachkCorregir5" cols="30" rows="4"  hidden></textarea>
                </div>
                <div class="row" style=" margin-bottom:20px">
                    <h5>Antecedentes</h5>
                    <div class="row" style="margin-bottom:8px">
                        <div class="col-12 col-md-10">
                            <div class="form-floating">
                                <textarea class="form-control" name="taAntecedentes" id="taAntecedentes" style="height: 100px; resize:none" readonly>{{$proyecto[0]->antecedentes}}</textarea>
                            </div>
                        </div>
                        @if ($proyecto[0]->condicion==null)
                        <div class="col-2" align="center">
                            <div class="row">
                                <div class="col-10">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="chkCorregir6" onchange="chkCorregir(this);">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Corregir
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif


                    </div>
                    <textarea class="form-control" name="tachkCorregir6" id="tachkCorregir6" cols="30" rows="4"  hidden></textarea>
                </div>
                <div class="row" style=" margin-bottom:20px">
                    <h5>Justificación de la investigación</h5>
                    <div class="row" style="margin-bottom:8px">
                        <div class="col-12 col-md-10">
                            <div class="form-floating">
                                <textarea class="form-control" name="taJInvestigacion" id="taJInvestigacion" style="height: 100px; resize:none" readonly>{{$proyecto[0]->justificacion}}</textarea>
                            </div>
                        </div>
                        @if ($proyecto[0]->condicion==null)
                        <div class="col-2" align="center">
                            <div class="row">
                                <div class="col-10">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="chkCorregir7" onchange="chkCorregir(this);">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Corregir
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif


                    </div>
                    <textarea class="form-control" name="tachkCorregir7" id="tachkCorregir7" cols="30" rows="4"  hidden></textarea>
                </div>
                <div class="row" style=" margin-bottom:20px">
                    <h5>Formulación del problema</h5>
                    <div class="row" style="margin-bottom:8px">
                        <div class="col-12 col-md-10">
                            <div class="form-floating">
                                <textarea class="form-control" name="taFProblema" id="taFProblema" style="height: 100px; resize:none" readonly>{{$proyecto[0]->formulacion_prob}}</textarea>
                            </div>
                        </div>
                        @if ($proyecto[0]->condicion==null)
                        <div class="col-2" align="center">
                            <div class="row">
                                <div class="col-10">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="chkCorregir8" onchange="chkCorregir(this);">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Corregir
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif


                    </div>
                    <textarea class="form-control" name="tachkCorregir8" id="tachkCorregir8" cols="30" rows="4"  hidden></textarea>
                </div>
                <div class="row" style=" margin-bottom:20px">
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
                                        <td>{{$obj->tipo}}</td>
                                        <td>{{$obj->descripcion}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if ($proyecto[0]->condicion==null)
                    <div class="col-1" align="center">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="chkCorregir9" onchange="chkCorregir(this);">
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
                <div class="row" style=" margin-bottom:20px">
                    <div class="row" style="margin-bottom:15px">
                        <div class="col-12">
                            <hr style="border: 1px solid gray">
                        </div>
                        <h5>Marco Teórico</h5>
                        <div class="row">
                            <div class="col-12 col-md-10">
                                <div class="form-floating">
                                    <textarea class="form-control" name="taMTeorico" id="taMTeorico" style="height: 100px; resize:none" readonly>{{$proyecto[0]->marco_teorico}}</textarea>
                                </div>
                            </div>
                            @if ($proyecto[0]->condicion==null)
                            <div class="col-2" align="center">
                                <div class="row">
                                    <div class="col-10">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="chkCorregir10" onchange="chkCorregir(this);">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                Corregir
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        </div>
                        <textarea class="form-control" name="tachkCorregir10" id="tachkCorregir10" cols="30" rows="4"  hidden></textarea>
                    </div>

                    <div class="row" style="margin-bottom:15px">
                        <h5>Marco Conceptual</h5>
                        <div class="row">
                            <div class="col-12 col-md-10">
                                <div class="form-floating">
                                    <textarea class="form-control" name="taMConceptual" id="taMConceptual" style="height: 100px; resize:none" readonly>{{$proyecto[0]->marco_conceptual}}</textarea>
                                </div>
                            </div>
                            @if ($proyecto[0]->condicion==null)
                            <div class="col-2" align="center">
                                <div class="row">
                                    <div class="col-0">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="chkCorregir11" onchange="chkCorregir(this);">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                Corregir
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        </div>
                        <textarea class="form-control" name="tachkCorregir11" id="tachkCorregir11" cols="30" rows="4"  hidden></textarea>
                    </div>

                    <div class="row" style="margin-bottom:15px">
                        <h5>Marco Legal</h5>
                        <div class="row">
                            <div class="col-12 col-md-10">
                                <div class="form-floating">
                                    <textarea class="form-control" name="taMLegal" id="taMLegal" style="height: 100px; resize:none" readonly>{{$proyecto[0]->marco_legal}}</textarea>
                                </div>
                            </div>
                            @if ($proyecto[0]->condicion==null)
                            <div class="col-2" align="center">
                                <div class="row">
                                    <div class="col-10">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="chkCorregir12" onchange="chkCorregir(this);">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                Corregir
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        </div>
                        <textarea class="form-control" name="tachkCorregir12" id="tachkCorregir12" cols="30" rows="4"  hidden></textarea>
                    </div>
                </div>

                <div class="row" style=" margin-bottom:20px">
                    <h5>Formulación de la hipótesis </h5>
                    <div class="row" style="margin-bottom:8px">
                        <div class="row">
                            <div class="col-12 col-md-10">
                                <div class="form-floating">
                                    <textarea class="form-control" name="taFHipotesis" id="taFHipotesis" style="height: 100px; resize:none" readonly>{{$proyecto[0]->form_hipotesis}}</textarea>
                                </div>
                            </div>
                            @if ($proyecto[0]->condicion==null)
                            <div class="col-2" align="center">
                                <div class="row">
                                    <div class="col-10">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="chkCorregir13" onchange="chkCorregir(this);">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                Corregir
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        </div>
                        <textarea class="form-control" name="tachkCorregir13" id="tachkCorregir13" cols="30" rows="4"  hidden></textarea>
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
                        <label for="taOEstudio" class="form-label">Objeto de Estudio</label>
                        <div class="col-12 col-md-10">
                            <div class="form-floating">
                                <textarea class="form-control" name="taOEstudio" id="taOEstudio" style="height: 100px; resize:none" readonly>{{$proyecto[0]->objeto_estudio}}</textarea>
                            </div>
                        </div>
                        @if ($proyecto[0]->condicion==null)
                        <div class="col-2" align="center">
                            <div class="row">
                                <div class="col-10">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="chkCorregir14" onchange="chkCorregir(this);">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Corregir
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <textarea class="form-control" name="tachkCorregir14" id="tachkCorregir14" cols="30" rows="4"  hidden></textarea>
                    </div>
                    <div class="row" style="margin-bottom:8px">
                        <label for="taPoblacion" class="form-label">Población</label>
                        <div class="col-12 col-md-10">
                            <div class="form-floating">
                                <textarea class="form-control" name="taPoblacion" id="taPoblacion" style="height: 100px; resize:none" readonly>{{$proyecto[0]->poblacion}}</textarea>
                            </div>
                        </div>
                        @if ($proyecto[0]->condicion==null)
                        <div class="col-2" align="center">
                            <div class="row">
                                <div class="col-10">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="chkCorregir15" onchange="chkCorregir(this);">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Corregir
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <textarea class="form-control" name="tachkCorregir15" id="tachkCorregir15" cols="30" rows="4"  hidden></textarea>
                    </div>
                    <div class="row" style="margin-bottom:8px">
                        <label for="taMuestra" class="form-label">Muestra</label>
                        <div class="col-12 col-md-10">
                            <div class="form-floating">
                                <textarea class="form-control" name="taMuestra" id="taMuestra" style="height: 100px; resize:none" readonly>{{$proyecto[0]->muestra}}</textarea>
                            </div>
                        </div>
                        @if ($proyecto[0]->condicion==null)
                        <div class="col-2" align="center">
                            <div class="row">
                                <div class="col-10">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="chkCorregir16" onchange="chkCorregir(this);">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Corregir
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <textarea class="form-control" name="tachkCorregir16" id="tachkCorregir16" cols="30" rows="4"  hidden></textarea>
                    </div>
                    <div class="row" style="margin-bottom:8px">
                        <label for="taMetodos" class="form-label">Métodos</label>
                        <div class="col-12 col-md-10">
                            <div class="form-floating">
                                <textarea class="form-control" name="taMetodos" id="taMetodos" style="height: 100px; resize:none" readonly>{{$proyecto[0]->metodos}}</textarea>
                            </div>
                        </div>
                        @if ($proyecto[0]->condicion==null)
                        <div class="col-2" align="center">
                            <div class="row">
                                <div class="col-10">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="chkCorregir17" onchange="chkCorregir(this);">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Corregir
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <textarea class="form-control" name="tachkCorregir17" id="tachkCorregir17" cols="30" rows="4"  hidden></textarea>
                    </div>
                    <div class="row" style="margin-bottom:8px">
                        <label for="taRecoleccionDatos" class="form-label">Técnicas e instrumentos de recolección de datos</label>
                        <div class="col-12 col-md-10">
                            <div class="form-floating">
                                <textarea class="form-control" name="taRecoleccionDatos" id="taRecoleccionDatos" type="text" style="height: 100px; resize:none" readonly>{{$proyecto[0]->tecnicas_instrum}}</textarea>
                            </div>
                        </div>
                        @if ($proyecto[0]->condicion==null)
                         <div class="col-2" align="center">
                            <div class="row">
                                <div class="col-10">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="chkCorregir18" onchange="chkCorregir(this);">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Corregir
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <textarea class="form-control" name="tachkCorregir18" id="tachkCorregir18" cols="30" rows="4"  hidden></textarea>
                    </div>
                    <div class="row" style="margin-bottom:20px">
                        <h6>Instrumentación y/o fuentes de datos</h6>
                        <div class="col-12 col-md-10">
                            <div class="form-floating">
                                <textarea class="form-control" name="taFuentesDatos" id="taFuentesDatos" type="text" style="height: 100px; resize:none" readonly>{{$proyecto[0]->instrumentacion}}</textarea>
                            </div>
                        </div>
                        @if ($proyecto[0]->condicion==null)
                            <div class="col-2" align="center">
                            <div class="row">
                                <div class="col-10">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="chkCorregir19" onchange="chkCorregir(this);">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Corregir
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <textarea class="form-control" name="tachkCorregir19" id="tachkCorregir19" cols="30" rows="4"  hidden></textarea>
                    </div>
                    <div class="row" style="margin-bottom:20px">
                        <h6>Estrategias Metodológicas</h6>
                        <div class="col-12 col-md-10">
                            <div class="form-floating">
                                <textarea class="form-control" name="taEstrategiasM" id="taEstrategiasM" style="height: 100px; resize:none" readonly>{{$proyecto[0]->estg_metodologicas}}</textarea>
                            </div>
                        </div>
                        @if ($proyecto[0]->condicion==null)
                            <div class="col-2" align="center">
                            <div class="row">
                                <div class="col-10">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="chkCorregir20" onchange="chkCorregir(this);">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Corregir
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <textarea class="form-control" name="tachkCorregir20" id="tachkCorregir20" cols="30" rows="4"  hidden></textarea>
                    </div>
                    <div class="row" style="margin-bottom:20px">
                        {{--Variables de operalizacion modal extra--}}
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
                                            <td>{{$var->descripcion}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if ($proyecto[0]->condicion==null)
                            <div class="col-1" align="center">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="chkCorregir21" onchange="chkCorregir(this);">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Corregir
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <textarea class="form-control" name="tachkCorregir21" id="tachkCorregir21" cols="30" rows="4" hidden></textarea>
                    </div>
                </div>
                <div class="row" style=" margin-bottom:20px; padding-right:12px;">
                    <div class="col-12">
                        <hr style="border: 1px solid gray">
                    </div>
                    <h5>Referencias bibliográficas</h5>
                    <div class="col-8 col-md-7 col-xl-11">
                        <table class="table table-striped table-bordered ">
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
                        </table>
                    </div>
                    @if ($proyecto[0]->condicion==null)
                          <div class="col-1" align="center">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="chkCorregir22" onchange="chkCorregir(this);">
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
                <div class="row" style="padding-top: 20px; padding-bottom:20px;">
                    <div class="col-7 col-xl-12 col-xxl-12">
                            @if (sizeof($observaciones)>=3)
                                <div class="row" style="text-align:right; ">
                                    <div class="col-6 col-md-4">
                                        <input class="btn btn-success" type="button" value="APROBAR PROYECTO" onclick="aprobarProy();" style="margin-right:20px;">
                                    </div>
                                    <div class="col-6 col-md-4">
                                        <input class="btn btn-danger" type="button" value="DESAPROBAR PROYECTO" onclick="desaprobarProy();" style="margin-right:20px;">
                                    </div>
                                </div>
                            @else
                                <div class="row" style="text-align:right; ">
                                    @if($lastObservacion->count()==0 || $proyecto[0]->estado==1)
                                        <div class="col-3 col-md-3">
                                            <input class="btn btn-success" type="button" value="Guardar Observaciones" onclick="uploadProyecto();" style="margin-right:20px;">
                                        </div>
                                    @endif
                                    <div class="col-3 col-md-3">
                                        <input class="btn btn-success" type="button" value="APROBAR PROYECTO" onclick="aprobarProy();" style="margin-right:20px;">
                                    </div>
                                    <div class="col-3 col-md-3">
                                        <input class="btn btn-danger" type="button" value="DESAPROBAR PROYECTO" onclick="desaprobarProy();" style="margin-right:20px;">
                                    </div>
                                    <div class="col-3 col-md-3">
                                        <a href="{{route('asesor.proyectos')}}" type="button" class="btn btn-danger">Cancelar</a>
                                    </div>
                                </div>

                            @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>

        /*Esta funcion es implementada cuando se inicia la ventana y el proyecto de tesis
          ya se haya registrado antes.*/
        window.onload = function() {

            /*Valores de los meses de ejecucion y a la vez recibimos los valores para la tabla*/
            const valueMes = document.getElementById('txtMesesEjecucion').value;
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
        function aprobarProy(){
            document.formProyecto.action = "{{route('asesor.aprobarProy')}}";
            document.formProyecto.method = "POST";
            document.formProyecto.submit();
        }

        function desaprobarProy(){
            document.formProyecto.action = "{{route('asesor.desaprobarProy')}}";
            document.formProyecto.method = "POST";
            document.formProyecto.submit();
        }



        function uploadProyecto(){
            document.formProyecto.action = "{{route('asesor.continueProyect')}}";
            document.formProyecto.method = "POST";
            document.formProyecto.submit();
        }

        function chkCorregir(check){
            if(document.getElementById(check.id).checked){
                document.getElementById('ta'+check.id).hidden = false;
            }else{
                document.getElementById('ta'+check.id).hidden = true;
                document.getElementById('ta'+check.id).value = "";
            }
        }

        var existMes = false;
        var lastMonth = 0;

        function setMeses(){
            if(existMes == false){
                existMes=true;
                meses = document.getElementById("txtMesesEjecucion").value;
                lastMonth = meses;
                for(i = 1;i<=meses; i++){
                    document.getElementById("headers").innerHTML += '<th id="Mes'+i+'" scope="col">Mes '+i+'</th>'
                    document.getElementById("1Tr").innerHTML += '<input type="hidden" id="n1Tr'+i+'" name="n1Tr'+i+'" value="0"><td id="1Tr'+i+'" onclick="setColorTable(this);"></td>'
                    document.getElementById("2Tr").innerHTML += '<input type="hidden" id="n2Tr'+i+'" name="n2Tr'+i+'" value="0"><td id="2Tr'+i+'" onclick="setColorTable(this);"></td>'
                    document.getElementById("3Tr").innerHTML += '<input type="hidden" id="n3Tr'+i+'" name="n3Tr'+i+'" value="0"><td id="3Tr'+i+'" onclick="setColorTable(this);"></td>'
                    document.getElementById("4Tr").innerHTML += '<input type="hidden" id="n4Tr'+i+'" name="n4Tr'+i+'" value="0"><td id="4Tr'+i+'" onclick="setColorTable(this);"></td>'
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
            datos = document.getElementById()
            touch = parseInt(cont) + 1
            document.getElementById("n"+celda.id).value = touch;

            if(touch%2 != 0 ){
                celda.style.backgroundColor= "red";
            }else{
                celda.style.backgroundColor= "rgb(212, 212, 212)";
            }
        }
    </script>
@endsection

