@extends('plantilla.dashboard')
@section('titulo')
    Asignar Temas
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
<div class="card-header">
    Asignacion de Temas
</div>
<div class="card-body">
    <div class="row">
        <div class="col-12">
            <div class="row box-center">
                <div class="col-10 ">
                    <div class="row card-correccion">
                        <div class="col-12" style="text-align: right;">
                            <h5>{{$estudiante[0]->num_grupo}}</h5>
                            @foreach ($estudiantes_grupo as $estu)
                                    <p>{{$estu->nombres.' '.$estu->apellidos}}</p>
                            @endforeach

                        </div>
                        <form id="formCampos" action="{{route('asesor.guardarTemas')}}" method="post">
                            @csrf
                            <input type="hidden" value="{{$estudiante[0]->id_grupo}}" name="id_grupoAux" >
                            <div class="col-12" style="text-align: left;">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="flexCheckDefault" value="chkTInvestigacion" checked name="chkTInvestigacion" @if ($estudiante[0]->tipo_investigacion==1)disabled checked @endif>
                                    <label class="form-check-label" for="flexCheckDefault">
                                    Tipo Investigacion
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="flexCheckDefault" value="chkLocalidad" checked  name="chkLocalidad" @if ($estudiante[0]->localidad_institucion==1)disabled checked @endif>
                                    <label class="form-check-label" for="flexCheckDefault">
                                    Localidad e Institucion
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="flexCheckDefault" value="chkDuracion" checked name="chkDuracion" @if ($estudiante[0]->duracion_proyecto==1)disabled checked @endif>
                                    <label class="form-check-label" for="flexCheckDefault">
                                    Duracion del Proyecto
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="flexCheckDefault" value="chkRecursos" checked name="chkRecursos" @if ($estudiante[0]->recursos==1)disabled checked @endif>
                                    <label class="form-check-label" for="flexCheckDefault">
                                    Recursos
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="flexCheckDefault" value="chkPresupuesto" checked name="chkPresupuesto" @if ($estudiante[0]->presupuesto==1)disabled checked @endif>
                                    <label class="form-check-label" for="flexCheckDefault">
                                    Presupuesto
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="flexCheckDefault" value="chkFinanciamiento" checked name="chkFinanciamiento" @if ($estudiante[0]->financiamiento==1)disabled checked @endif>
                                    <label class="form-check-label" for="flexCheckDefault">
                                    Financiamiento
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="flexCheckDefault" value="chkRealProb" checked name="chkRealProb" @if ($estudiante[0]->rp_antecedente_justificacion==1)disabled checked @endif>
                                    <label class="form-check-label" for="flexCheckDefault">
                                    Realidad Problematica, Antecedentes, Justificacion
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="flexCheckDefault" value="chkProblema" checked name="chkProblema" @if ($estudiante[0]->formulacion_problema==1)disabled checked @endif>
                                    <label class="form-check-label" for="flexCheckDefault">
                                    Formulacion del Problema
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="flexCheckDefault" value="chkObjetivos" checked name="chkObjetivos" @if ($estudiante[0]->objetivos==1)disabled checked @endif>
                                    <label class="form-check-label" for="flexCheckDefault">
                                    Objetivos
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="flexCheckDefault" value="chkMarcos" checked name="chkMarcos" @if ($estudiante[0]->marcos==1)disabled checked @endif>
                                    <label class="form-check-label" for="flexCheckDefault">
                                    Marcos
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="flexCheckDefault" value="chkHipotesis" checked name="chkHipotesis" @if ($estudiante[0]->formulacion_hipotesis==1)disabled checked @endif>
                                    <label class="form-check-label" for="flexCheckDefault">
                                    Formulacion de la Hipostesis
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="flexCheckDefault" value="chkDiseno" checked name="chkDiseno" @if ($estudiante[0]->diseño_investigacion==1)disabled checked @endif>
                                    <label class="form-check-label" for="flexCheckDefault">
                                    Diseno de Investigacion
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="flexCheckDefault" value="chkReferencias" checked name="chkReferencias" @if ($estudiante[0]->referencias_b==1)disabled checked @endif>
                                    <label class="form-check-label" for="flexCheckDefault">
                                    Referencias
                                    </label>
                                </div>
                                <div class="row">
                                    <div class="d-grid gap-2 d-md-block mt-3">
                                        <a class="btn btn-danger" href="{{route('asesor.showEstudiantes')}}">Cancelar</a>
                                        @if($estudiante[0]->referencias_b!=1)
                                            <input class="btn btn-success" type="submit" value="Guardar" onclick="saveCampos();">
                                        @endif
                                    </div>
                                </div>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
@section('js')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script type="text/javascript">
        function saveCampos(){
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
                    document.formCampos.submit();
                }
                })

        }

    </script>
@endsection
