@extends('plantilla.dashboard')
@section('titulo')
    Tesis del Estudiante
@endsection
@section('css')
<link rel="stylesheet" href="./css/tesis_body.css">
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
<div class="card-header">
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
        <h2>Tesis</h2>
    </div>
</div>
<div class="card-body">
    <form id="formProyecto" name="formProyecto" action="" method="">
        @csrf
        <input type="hidden" name="textcod" value="{{$Tesis[0]->cod_tesis}}">
        <input type="hidden" name="id_grupo_hidden" value="{{$Tesis[0]->id_grupo_inves}}">
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
                            <input class="form-control" name="txtTitulo" id="txtTitulo" type="text" value="{{$Tesis[0]->titulo}}" readonly>
                            <span id="validateTitle" name="validateTitle" style="color: red"></span>
                        </div>
                        {{-- @if ($Tesis[0]->estado==1)
                        <div class="col-3" align="center">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input prueba" type="checkbox" id="chkCorregir1" onchange="chkCorregir(this);">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Corregir
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif --}}


                    </div>
                </div>
            </div>
            <div class="row" style="margin-bottom:15px;">
                <div class="col-12">
                    <textarea class="form-control" name="tachkCorregir1" id="tachkCorregir1" cols="30" rows="4" hidden></textarea>
                </div>

            </div>
        </div>
        {{-- HOSTING --}}
        <div class="row" style=" margin-bottom:20px; padding-right:12px;">
            <h5>Autor(es)</h5>
            @foreach ($estudiantes_grupo as $est)
                <div class="row" style="margin-bottom:8px;">
                    <div class="row">
                        <div class="col-5 col-md-3">
                            <input class="form-control" name="txtCodMatricula" id="txtCodMatricula" type="search" value="{{$est->cod_matricula}}" readonly>
                        </div>
                    </div>
                </div>
                <div class="row border-box card-box" >
                    <div class="item-card col">
                        <label for="txtNombreAutor" class="form-label">Nombres</label>
                        <input class="form-control" name="txtNombreAutor" id="txtNombreAutor" type="text" value="{{$est->nombres}}" readonly>
                    </div>
                    <div class="item-card">
                        <label for="txtApellidoAutor" class="form-label">Apellidos</label>
                        <input class="form-control" name="txtApellidoAutor" id="txtApellidoAutor" type="text" value="{{$est->apellidos}}" readonly>
                    </div>
                </div>
            @endforeach

        </div>
        <div class="row" style="margin-bottom:20px; padding-right:12px;">
            <h5>Asesor</h5>

            <div class="row border-box card-box">
                <div class="item-card">
                    <label for="txtNombreAsesor" class="form-label">Apellidos y Nombres</label>
                    <input class="form-control" name="txtNombreAsesor" id="txtNombreAsesor" type="text" value="{{$Tesis[0]->nombre_asesor}}" readonly>
                </div>
                <div class="item-card">
                    <label for="cboGrAcademicoAsesor" class="form-label">Grado Academico</label>
                    <input class="form-control" name="txtGrAcademicoAsesor" id="txtGrAcademicoAsesor" type="text" value="{{$Tesis[0]->grado_academico}}" readonly>
                </div>
                <div class="item-card">
                    <label for="txtTProfesional" class="form-label">Titulo Profesional</label>
                    <input class="form-control" name="txtTProfesional" id="txtTProfesional" type="text" value="" readonly>
                </div>
                <div class="item-card">
                    <label for="txtDireccionAsesor" class="form-label">Dirección laboral y/o domiciliaria</label>
                    <input class="form-control" name="txtDireccionAsesor" id="txtDireccionAsesor" type="text" value="{{$Tesis[0]->direccion_asesor}}" readonly>
                </div>
            </div>
        </div>
        <div class="row" style=" margin-bottom:20px">
            <h5>Dedicatoria </h5>
            <div class="row" style="margin-bottom:8px">
                <div class="col-12 col-md-10">
                    <div class="form-floating">
                        <textarea class="form-control" name="taDedicatoria" id="taDedicatoria" style="height: 100px; resize:none" readonly>{{$Tesis[0]->dedicatoria}}</textarea>
                    </div>
                </div>
                {{-- @if ($Tesis[0]->estado==1)
                <div class="col-2" align="center">
                    <div class="row">
                        <div class="col-10">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="chkCorregir2" onchange="chkCorregir(this);">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Corregir
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                @endif --}}
            </div>
            <textarea class="form-control" name="tachkCorregir2" id="tachkCorregir2" cols="30" rows="4"  hidden></textarea>
        </div>
        <div class="row" style=" margin-bottom:20px">
            <h5>Agradecimiento</h5>
            <div class="row" style="margin-bottom:8px">
                <div class="col-12 col-md-10">
                    <div class="form-floating">
                        <textarea class="form-control" name="taAgradecimiento" id="taAgradecimiento" style="height: 100px; resize:none" readonly>{{$Tesis[0]->agradecimiento}}</textarea>
                    </div>
                </div>
                {{-- @if ($Tesis[0]->estado==1)
                <div class="col-2" align="center">
                    <div class="row">
                        <div class="col-10">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="chkCorregir3" onchange="chkCorregir(this);">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Corregir
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                @endif --}}
            </div>
            <textarea class="form-control" name="tachkCorregir3" id="tachkCorregir3" cols="30" rows="4"  hidden></textarea>
        </div>
        <div class="row" style=" margin-bottom:20px">
            <h5>Presentacion</h5>
            <div class="row" style="margin-bottom:8px">
                <div class="col-12 col-md-10">
                    <div class="form-floating">
                        <textarea class="form-control" name="taPresentacion" id="taPresentacion" style="height: 100px; resize:none" readonly>{{$Tesis[0]->presentacion}}</textarea>
                    </div>
                </div>
                @if ($Tesis[0]->estadoDesignacion!=2)
                    <div class="col-2" align="center">
                        <div class="row">
                            <div class="col-10">
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
            </div>
            <textarea class="form-control" name="tachkCorregir4" id="tachkCorregir4" cols="30" rows="4"  hidden></textarea>
        </div>
        <div class="row" style=" margin-bottom:20px">
            <h5>Resumen</h5>
            <div class="row" style="margin-bottom:8px">
                <div class="col-12 col-md-10">
                    <div class="form-floating">
                        <textarea class="form-control" name="taResumen" id="taResumen" style="height: 100px; resize:none" readonly>{{$Tesis[0]->resumen}}</textarea>
                    </div>
                </div>
                @if ($Tesis[0]->estadoDesignacion!=2)
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
            <div class="row" style=" margin-bottom:20px;">
                <h5>Abstract</h5>
                <div class="col-12 col-md-10">
                    <textarea class="form-control" name="taabstract" id="taabstract" style="height: 100px; resize:none" readonly>{{$Tesis[0]->abstract}}</textarea>
                </div>
            </div>
            <textarea class="form-control" name="tachkCorregir5" id="tachkCorregir5" cols="30" rows="4"  hidden></textarea>
        </div>
        <div class="row" style=" margin-bottom:20px;">
            <h5>Palabras claves</h5>
            <div class="row mt-3 ms-1" id="chips">
                <input id="get_keyword" type="hidden" @if(sizeof($keywords)>0)value="{{$keywords}}"@endif>
            </div>
        </div>
        <div class="row" style=" margin-bottom:20px">
            <h5>Introduccion</h5>
            <div class="row" style="margin-bottom:8px">
                <div class="col-12 col-md-10">
                    <div class="form-floating">
                        <textarea class="form-control" name="taIntroduccion" id="taIntroduccion" style="height: 100px; resize:none" readonly>{{$Tesis[0]->introduccion}}</textarea>
                    </div>
                </div>
                @if ($Tesis[0]->estadoDesignacion!=2)
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
        <div class="col-8">
            <h4>PLAN DE INVESTIGACION</h4>
            <hr style="border:1 px black;">
        </div>

        <div class="row" style=" margin-bottom:20px">
            <h5>Realidad problematica </h5>
            <div class="row" style="margin-bottom:8px">
                <div class="col-12 col-md-10">
                    <div class="form-floating">
                        <textarea class="form-control" name="taRProblematica" id="taRProblematica" style="height: 100px; resize:none" readonly>{{$Tesis[0]->real_problematica}}</textarea>
                    </div>
                </div>
                @if ($Tesis[0]->estadoDesignacion!=2)
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
            <h5>Antecedentes</h5>
            <div class="row" style="margin-bottom:8px">
                <div class="col-12 col-md-10">
                    <div class="form-floating">
                        <textarea class="form-control" name="taAntecedentes" id="taAntecedentes" style="height: 100px; resize:none" readonly>{{$Tesis[0]->antecedentes}}</textarea>
                    </div>
                </div>
                @if ($Tesis[0]->estadoDesignacion!=2)
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
            <h5>Justificación de la investigación</h5>
            <div class="row" style="margin-bottom:8px">
                <div class="col-12 col-md-10">
                    <div class="form-floating">
                        <textarea class="form-control" name="taJInvestigacion" id="taJInvestigacion" style="height: 100px; resize:none" readonly>{{$Tesis[0]->justificacion}}</textarea>
                    </div>
                </div>
                @if ($Tesis[0]->estadoDesignacion!=2)
                <div class="col-2" align="center">
                    <div class="row">
                        <div class="col-10">
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
            </div>
            <textarea class="form-control" name="tachkCorregir9" id="tachkCorregir9" cols="30" rows="4"  hidden></textarea>
        </div>
        <div class="row" style=" margin-bottom:20px">
            <h5>Formulación del problema</h5>
            <div class="row" style="margin-bottom:8px">
                <div class="col-12 col-md-10">
                    <div class="form-floating">
                        <textarea class="form-control" name="taFProblema" id="taFProblema" style="height: 100px; resize:none" readonly>{{$Tesis[0]->formulacion_prob}}</textarea>
                    </div>
                </div>
                @if ($Tesis[0]->estadoDesignacion!=2)
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
            @if ($Tesis[0]->estadoDesignacion!=2)
            <div class="col-1" align="center">
                <div class="row">
                    <div class="col-12">
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
            <textarea class="form-control" name="tachkCorregir11" id="tachkCorregir11" cols="30" rows="4" hidden></textarea>
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
                            <textarea class="form-control" name="taMTeorico" id="taMTeorico" style="height: 100px; resize:none" readonly>{{$Tesis[0]->marco_teorico}}</textarea>
                        </div>
                    </div>
                    @if ($Tesis[0]->estadoDesignacion!=2)
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

            <div class="row" style="margin-bottom:15px">
                <h5>Marco Conceptual</h5>
                <div class="row">
                    <div class="col-12 col-md-10">
                        <div class="form-floating">
                            <textarea class="form-control" name="taMConceptual" id="taMConceptual" style="height: 100px; resize:none" readonly>{{$Tesis[0]->marco_conceptual}}</textarea>
                        </div>
                    </div>
                    @if ($Tesis[0]->estadoDesignacion!=2)
                    <div class="col-2" align="center">
                        <div class="row">
                            <div class="col-0">
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

            <div class="row" style="margin-bottom:15px">
                <h5>Marco Legal</h5>
                <div class="row">
                    <div class="col-12 col-md-10">
                        <div class="form-floating">
                            <textarea class="form-control" name="taMLegal" id="taMLegal" style="height: 100px; resize:none" readonly>{{$Tesis[0]->marco_legal}}</textarea>
                        </div>
                    </div>
                    @if ($Tesis[0]->estadoDesignacion!=2)
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
                </div>
                <textarea class="form-control" name="tachkCorregir14" id="tachkCorregir14" cols="30" rows="4"  hidden></textarea>
            </div>
        </div>

        <div class="row" style=" margin-bottom:20px">
            <h5>Formulación de la hipótesis </h5>
            <div class="row" style="margin-bottom:8px">
                <div class="row">
                    <div class="col-12 col-md-10">
                        <div class="form-floating">
                            <textarea class="form-control" name="taFHipotesis" id="taFHipotesis" style="height: 100px; resize:none" readonly>{{$Tesis[0]->form_hipotesis}}</textarea>
                        </div>
                    </div>
                    @if ($Tesis[0]->estadoDesignacion!=2)
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
                </div>
                <textarea class="form-control" name="tachkCorregir15" id="tachkCorregir15" cols="30" rows="4"  hidden></textarea>
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
                        <textarea class="form-control" name="taOEstudio" id="taOEstudio" style="height: 100px; resize:none" readonly>{{$Tesis[0]->objeto_estudio}}</textarea>
                    </div>
                </div>
                @if ($Tesis[0]->estadoDesignacion!=2)
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
                <label for="taPoblacion" class="form-label">Población</label>
                <div class="col-12 col-md-10">
                    <div class="form-floating">
                        <textarea class="form-control" name="taPoblacion" id="taPoblacion" style="height: 100px; resize:none" readonly>{{$Tesis[0]->poblacion}}</textarea>
                    </div>
                </div>
                @if ($Tesis[0]->estadoDesignacion!=2)
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
                <label for="taMuestra" class="form-label">Muestra</label>
                <div class="col-12 col-md-10">
                    <div class="form-floating">
                        <textarea class="form-control" name="taMuestra" id="taMuestra" style="height: 100px; resize:none" readonly>{{$Tesis[0]->muestra}}</textarea>
                    </div>
                </div>
                @if ($Tesis[0]->estadoDesignacion!=2)
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
            <div class="row" style="margin-bottom:8px">
                <label for="taMetodos" class="form-label">Métodos</label>
                <div class="col-12 col-md-10">
                    <div class="form-floating">
                        <textarea class="form-control" name="taMetodos" id="taMetodos" style="height: 100px; resize:none" readonly>{{$Tesis[0]->metodos}}</textarea>
                    </div>
                </div>
                @if ($Tesis[0]->estadoDesignacion!=2)
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
            <div class="row" style="margin-bottom:8px">
                <label for="taRecoleccionDatos" class="form-label">Técnicas e instrumentos de recolección de datos</label>
                <div class="col-12 col-md-10">
                    <div class="form-floating">
                        <textarea class="form-control" name="taRecoleccionDatos" id="taRecoleccionDatos" type="text" style="height: 100px; resize:none" readonly>{{$Tesis[0]->tecnicas_instrum}}</textarea>
                    </div>
                </div>
                @if ($Tesis[0]->estadoDesignacion!=2)
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
                <h6>Instrumentación y/o fuentes de datos</h6>
                <div class="col-12 col-md-10">
                    <div class="form-floating">
                        <textarea class="form-control" name="taFuentesDatos" id="taFuentesDatos" type="text" style="height: 100px; resize:none" readonly>{{$Tesis[0]->instrumentacion}}</textarea>
                    </div>
                </div>
                @if ($Tesis[0]->estadoDesignacion!=2)
                    <div class="col-2" align="center">
                    <div class="row">
                        <div class="col-10">
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
                <textarea class="form-control" name="tachkCorregir21" id="tachkCorregir21" cols="30" rows="4"  hidden></textarea>
            </div>
            <div class="row" style="margin-bottom:20px">
                <h6>Estrategias Metodológicas</h6>
                <div class="col-12 col-md-10">
                    <div class="form-floating">
                        <textarea class="form-control" name="taEstrategiasM" id="taEstrategiasM" style="height: 100px; resize:none" readonly>{{$Tesis[0]->estg_metodologicas}}</textarea>
                    </div>
                </div>
                @if ($Tesis[0]->estadoDesignacion!=2)
                    <div class="col-2" align="center">
                    <div class="row">
                        <div class="col-10">
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
                <textarea class="form-control" name="tachkCorregir22" id="tachkCorregir22" cols="30" rows="4"  hidden></textarea>
            </div>
            <div class="row" style=" margin-bottom:20px">
                <h5>Resultados</h5>
                <div class="row" style="margin-bottom:8px">
                    <div class="row">
                        <div class="col-12 col-md-10">
                            <div class="form-floating">
                                <textarea class="form-control" name="taresultados" id="taresultados" style="height: 100px; resize:none" readonly>{{$Tesis[0]->resultados}}</textarea>
                            </div>
                        </div>
                        @if ($Tesis[0]->estadoDesignacion!=2)
                        <div class="col-2" align="center">
                            <div class="row">
                                <div class="col-10">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="chkCorregir23" onchange="chkCorregir(this);">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Corregir
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div id="resultados_contenedor" class="row m-3" hidden>
                        <input name="resultados_getImg" id="resultados_getImg" type="hidden" value="{{$resultadosImg}}">
                        <input name="resultados_getTxt" id="resultados_getTxt" type="hidden" value="{{$Tesis[0]->resultados}}">
                    </div>
                    <textarea class="form-control" name="tachkCorregir23" id="tachkCorregir23" cols="30" rows="4"  hidden></textarea>
                </div>
            </div>
            <div class="row" style=" margin-bottom:20px">
                <h5>Discusion</h5>
                <div class="row" style="margin-bottom:8px">
                    <div class="row">
                        <div class="col-12 col-md-10">
                            <div class="form-floating">
                                <textarea class="form-control" name="taDiscusion" id="taDiscusion" style="height: 100px; resize:none" readonly>{{$Tesis[0]->discusion}}</textarea>
                            </div>
                        </div>
                        @if ($Tesis[0]->estadoDesignacion!=2)
                        <div class="col-2" align="center">
                            <div class="row">
                                <div class="col-10">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="chkCorregir24" onchange="chkCorregir(this);">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Corregir
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    <textarea class="form-control" name="tachkCorregir24" id="tachkCorregir24" cols="30" rows="4"  hidden></textarea>
                </div>
            </div>
            <div class="row" style=" margin-bottom:20px">
                <h5>Conclusiones</h5>
                <div class="row" style="margin-bottom:8px">
                    <div class="row">
                        <div class="col-12 col-md-10">
                            <div class="form-floating">
                                <textarea class="form-control" name="taConclusiones" id="taConclusiones" style="height: 100px; resize:none" readonly>{{$Tesis[0]->conclusiones}}</textarea>
                            </div>
                        </div>
                        @if ($Tesis[0]->estadoDesignacion!=2)
                        <div class="col-2" align="center">
                            <div class="row">
                                <div class="col-10">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="chkCorregir25" onchange="chkCorregir(this);">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Corregir
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    <textarea class="form-control" name="tachkCorregir25" id="tachkCorregir25" cols="30" rows="4"  hidden></textarea>
                </div>
            </div>
            <div class="row" style=" margin-bottom:20px">
                <h5>Recomendaciones</h5>
                <div class="row" style="margin-bottom:8px">
                    <div class="row">
                        <div class="col-12 col-md-10">
                            <div class="form-floating">
                                <textarea class="form-control" name="taRecomendaciones" id="taRecomendaciones" style="height: 100px; resize:none" readonly>{{$Tesis[0]->recomendaciones}}</textarea>
                            </div>
                        </div>
                        @if ($Tesis[0]->estadoDesignacion!=2)
                        <div class="col-2" align="center">
                            <div class="row">
                                <div class="col-10">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="chkCorregir26" onchange="chkCorregir(this);">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Corregir
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    <textarea class="form-control" name="tachkCorregir26" id="tachkCorregir26" cols="30" rows="4"  hidden></textarea>
                </div>
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
            @if ($Tesis[0]->estadoDesignacion!=2)
                  <div class="col-1" align="center">
                <div class="row">
                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="chkCorregir27" onchange="chkCorregir(this);">
                            <label class="form-check-label" for="flexCheckDefault">
                                Corregir
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <textarea class="form-control" name="tachkCorregir27" id="tachkCorregir27" cols="30" rows="4" hidden></textarea>
        </div>
        <div class="row" style=" margin-bottom:20px;">
            <h5>Anexos</h5>
            <div class="row" style="margin-bottom:8px">
                <div class="col-12 col-md-10">
                    <textarea class="form-control" name="txtanexos[]" id="taanexos" readonly>@if ($Tesis[0]->anexos != null){{$Tesis[0]->anexos}}@endif</textarea>
                </div>
                @if ($Tesis[0]->estadoDesignacion!=2)
                <div class="col-1" align="center">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="chkCorregir28" onchange="chkCorregir(this);">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Corregir
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                <textarea class="form-control" name="tachkCorregir28" id="tachkCorregir28" cols="30" rows="4" hidden></textarea>
            </div>
            <div id="anexos_contenedor" class="row m-3" hidden>
                <input name="anexos_getImg" id="anexos_getImg" type="hidden" value="{{$anexosImg}}">
                <input name="anexos_getTxt" id="anexos_getTxt" type="hidden" value="{{$Tesis[0]->anexos}}">
            </div>
        </div>
        <input type="hidden" name="validacionTesis" id="validacionTesis" value="{{$camposFull}}">
        <div class="row" style="padding-top: 20px; padding-bottom:20px;">
            <div class="col-12">
                <div class="row" style="text-align:left; ">
                    <div class="row" id="grupoAproDesa" hidden>
                        <div class="col-3 col-md-3">
                            <input class="btn btn-success" type="button" value="APROBAR TESIS" onclick="aprobarProy();" style="margin-right:20px;">
                        </div>
                        <div class="col-3 col-md-3">
                            <input class="btn btn-danger" type="button" value="DESAPROBAR TESIS" onclick="desaprobarProy();" style="margin-right:20px;">
                        </div>
                    </div>
                    <div class="row" id="grupoObservaciones">
                        @if($Tesis[0]->estadoDesignacion!=2)
                            <div class="col-3 col-md-3">
                                <input class="btn btn-danger" type="button" value="Guardar Observaciones" onclick="uploadProyecto();" style="margin-right:20px;">
                            </div>
                        @endif
                    </div>
                    <div class="col-3 col-md-3 my-2">
                        <a href="{{route('asesor.estudiantes-tesis')}}" type="button" class="btn btn-outline-danger">Cancelar</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
@section('js')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="./js/asesor-tesis-2022.js"></script>
    @if (session('datos')=='oknot')
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'No se ha podido guardar las observaciones, revise si su informacion es correcta',
                showConfirmButton: true,
                timer: 2500
            })
        </script>
    @endif
    <script type="text/javascript">
        let array_chk = new Array(30);
        array_chk.fill(0,0);
        array_chk[0] = 99;

        function aprobarProy(){
            Swal.fire({
                title: 'Estas seguro(a)?',
                text: "La Tesis sera APROBADA!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, APROBAR!',
                cancelButtonText: 'Cancelar',
                }).then((result) => {
                if (result.isConfirmed) {
                    document.formProyecto.action = "{{route('asesor.aprobar-tesis')}}";
                    document.formProyecto.method = "POST";
                    document.formProyecto.submit();
                }
            })
        }

        function desaprobarProy(){
            Swal.fire({
                title: 'Estas seguro(a)?',
                text: "La Tesis sera DESAPROBADA!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, DESAPROBAR!',
                cancelButtonText: 'Cancelar',
                }).then((result) => {
                if (result.isConfirmed) {
                    document.formProyecto.action = "{{route('asesor.desaprobar-tesis')}}";
                    document.formProyecto.method = "POST";
                    document.formProyecto.submit();
                }
            })
        }

        function uploadProyecto(){

            let hayCorreccion = false;
            for(let i=1; i<24;i++){
                if(array_chk[i] == 1){
                    if(document.getElementById('tachkCorregir'+i).value != ""){
                        hayCorreccion = true;
                    }else{
                        hayCorreccion = false;
                    }
                }
            }
            if(!hayCorreccion){
                Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Necesita realizar una observacion'
                })
            }else{
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
                        document.formProyecto.action = "{{route('asesor.sustentacion.guardarObservacion')}}";
                        document.formProyecto.method = "POST";
                        document.formProyecto.submit();
                    }
                })
            }
        }

        function saveWithoutErrors(){
            var validacionTesis = document.getElementById('validacionTesis').value;
            if (validacionTesis == true){
                document.getElementById('grupoAproDesa').hidden=false;
                document.getElementById('grupoObservaciones').hidden=true;
            }
            else{
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
                        document.formProyecto.action = "{{route('asesor.guardar-sin-observaciones')}}";
                        document.formProyecto.method = "POST";
                        document.formProyecto.submit();
                    }
                })
            }
        }

        function chkCorregir(check){
            const idcheck = check.id
            const numero_check = idcheck.split('chkCorregir');
            if(document.getElementById(check.id).checked){
                document.getElementById('ta'+check.id).hidden = false;
                array_chk[numero_check[1]] = 1;
            }else{
                array_chk[numero_check[1]] = 0;
                document.getElementById('ta'+check.id).hidden = true;
                document.getElementById('ta'+check.id).value = "";
            }
        }
    </script>
@endsection
