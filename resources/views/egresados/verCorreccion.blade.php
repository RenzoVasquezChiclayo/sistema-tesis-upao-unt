@extends('plantilla.dashboard')
@section('titulo')
Correccion
@endsection
@section('css')
    <style type="text/css">
        .box-center{
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top:10px;
            margin-bottom:10px;
        }
        .card-correccion{
            background: white;
            border-radius: 10px;
            border: 1px solid gray;
            padding: 10px;
        }
    </style>
@endsection
@section('contenido')
    <div class="row">
        <div class="col-12">
            <div class="row box-center">
                <div class="col-10 ">
                    <div class="row card-correccion">
                        <div class="col-12" style="text-align: center;">
                            <h4>{{$observacion[0]->observacionNum}}</h4>
                        </div>
                        <div class="col-12" style="text-align: right;">
                            <h5>Asesor</h5>
                            <p>{{$proyinvestigacion[0]->nombre_asesor}}</p>
                            <h5>Fecha</h5>
                            <p>{{$observacion[0]->fecha}}</p>

                        </div>
                        <div class="col-12" style="text-align: left;">
                            @foreach ($correcciones as $correccion)
                                @if ($correccion->tema_referido=='titulo')
                                    <h5>Titulo</h5>
                                    <ul>
                                        <li>Observacion : {{$observacion[0]->titulo}}</li>
                                        <li>Correccion: {{$correccion->correccion}}</li>
                                    </ul>
                                @endif
                                @if ($correccion->tema_referido=='localidad_institucion')
                                    <h5>Localidad e Insitucion</h5>
                                    <ul>
                                        <li>Observacion : {{$observacion[0]->localidad_institucion}}</li>
                                        <li>Correccion: {{$correccion->correccion}}</li>
                                    </ul>
                                @endif
                                @if ($correccion->tema_referido=='meses_ejecucion')
                                <h5>Mese de ejecucion</h5>
                                <ul>
                                    <li>Observacion : {{$observacion[0]->meses_ejecucion}}</li>
                                    <li>Correccion: {{$correccion->correccion}}</li>
                                </ul>
                                @endif
                                @if ($correccion->tema_referido=='recursos')
                                <h5>Recursos</h5>
                                <ul>
                                    <li>Observacion : {{$observacion[0]->recursos}}</li>
                                    <li>Correccion: {{$correccion->correccion}}</li>
                                </ul>
                                @endif
                                @if ($correccion->tema_referido=='real_problematica')
                                <h5>Realidad Problematica</h5>
                                <ul>
                                    <li>Observacion : {{$observacion[0]->real_problematica}}</li>
                                    <li>Correccion: {{$correccion->correccion}}</li>
                                </ul>
                                @endif
                                @if ($correccion->tema_referido=='antecedentes')
                                <h5>Antecedentes</h5>
                                <ul>
                                    <li>Observacion : {{$observacion[0]->antecedentes}}</li>
                                    <li>Correccion: {{$correccion->correccion}}</li>
                                </ul>
                                @endif
                                @if ($correccion->tema_referido=='justificacion')
                                    <h5>Justificacion</h5>
                                    <ul>
                                        <li>Observacion : {{$observacion[0]->justificacion}}</li>
                                        <li>Correccion: {{$correccion->correccion}}</li>
                                    </ul>
                                @endif
                                @if ($correccion->tema_referido=='formulacion_prob')
                                    <h5>Formulacion del Problema</h5>
                                    <ul>
                                        <li>Observacion : {{$observacion[0]->formulacion_prob}}</li>
                                        <li>Correccion: {{$correccion->correccion}}</li>
                                    </ul>
                                @endif
                                @if ($correccion->tema_referido=='objetivos')
                                    <h5>Objetivos</h5>
                                    <ul>
                                        <li>Observacion : {{$observacion[0]->objetivos}}</li>
                                        <li>Correccion: {{$correccion->correccion}}</li>
                                    </ul>
                                @endif
                                @if ($correccion->tema_referido=='marco_teorico')
                                    <h5>Marco Teorico</h5>
                                    <ul>
                                        <li>Observacion : {{$observacion[0]->marco_teorico}}</li>
                                        <li>Correccion: {{$correccion->correccion}}</li>
                                    </ul>
                                @endif
                                @if ($correccion->tema_referido=='marco_conceptual')
                                    <h5>Marco Conceptual</h5>
                                    <ul>
                                        <li>Observacion : {{$observacion[0]->marco_conceptual}}</li>
                                        <li>Correccion: {{$correccion->correccion}}</li>
                                    </ul>
                                @endif
                                @if ($correccion->tema_referido=='marco_legal')
                                    <h5>Marco Legal</h5>
                                    <ul>
                                        <li>Observacion : {{$observacion[0]->marco_legal}}</li>
                                        <li>Correccion: {{$correccion->correccion}}</li>
                                    </ul>
                                @endif
                                @if ($correccion->tema_referido=='form_hipotesis')
                                    <h5>Formulacion de la Hipotesis</h5>
                                    <ul>
                                        <li>Observacion : {{$observacion[0]->form_hipotesis}}</li>
                                        <li>Correccion: {{$correccion->correccion}}</li>
                                    </ul>
                                @endif
                                @if ($correccion->tema_referido=='objeto_estudio')
                                    <h5>Objeto de Estudio</h5>
                                    <ul>
                                        <li>Observacion : {{$observacion[0]->objeto_estudio}}</li>
                                        <li>Correccion: {{$correccion->correccion}}</li>
                                    </ul>
                                @endif
                                @if ($correccion->tema_referido=='poblacion')
                                    <h5>Poblacion</h5>
                                    <ul>
                                        <li>Observacion : {{$observacion[0]->poblacion}}</li>
                                        <li>Correccion: {{$correccion->correccion}}</li>
                                    </ul>
                                @endif
                                @if ($correccion->tema_referido=='muestra')
                                    <h5>Muestra</h5>
                                    <ul>
                                        <li>Observacion : {{$observacion[0]->muestra}}</li>
                                        <li>Correccion: {{$correccion->correccion}}</li>
                                    </ul>
                                @endif
                                @if ($correccion->tema_referido=='metodos')
                                    <h5>Metodos</h5>
                                    <ul>
                                        <li>Observacion : {{$observacion[0]->metodos}}</li>
                                        <li>Correccion: {{$correccion->correccion}}</li>
                                    </ul>
                                @endif
                                @if ($correccion->tema_referido=='tecnicas_instrum')
                                    <h5>Tecnicas de Intrumentacion</h5>
                                    <ul>
                                        <li>Observacion : {{$observacion[0]->tecnicas_instrum}}</li>
                                        <li>Correccion: {{$correccion->correccion}}</li>
                                    </ul>
                                @endif
                                @if ($correccion->tema_referido=='instrumentacion')
                                    <h5>Instrumentacion</h5>
                                    <ul>
                                        <li>Observacion : {{$observacion[0]->instrumentacion}}</li>
                                        <li>Correccion: {{$correccion->correccion}}</li>
                                    </ul>
                                @endif
                                @if ($correccion->tema_referido=='estg_metodologicas')
                                    <h5>Estrategias Metodologicas</h5>
                                    <ul>
                                        <li>Observacion : {{$observacion[0]->estg_metodologicas}}</li>
                                        <li>Correccion: {{$correccion->correccion}}</li>
                                    </ul>
                                @endif
                                @if ($correccion->tema_referido=='variables')
                                    <h5>Variables</h5>
                                    <ul>
                                        <li>Observacion : {{$observacion[0]->variables}}</li>
                                        <li>Correccion: {{$correccion->correccion}}</li>
                                    </ul>
                                @endif
                                @if ($correccion->tema_referido=='referencias')
                                    <h5>Referencias</h5>
                                    <ul>
                                        <li>Observacion : {{$observacion[0]->referencias}}</li>
                                        <li>Correccion: {{$correccion->correccion}}</li>
                                    </ul>
                                @endif


                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
