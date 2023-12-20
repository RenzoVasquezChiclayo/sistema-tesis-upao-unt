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
                            <h5>Codigo</h5>
                            <p>{{$estudiante[0]->cod_matricula}}</p>
                        </div>
                        <div class="col-12" style="text-align: right;">
                            <h5>Alumno</h5>
                            <p>{{$estudiante[0]->estudiante_nombres.' '.$estudiante[0]->estudiante_apellidos}}</p>
                        </div>
                        <form id="formCampos" action="" method="">
                            @csrf
                            <input type="hidden" value="{{$estudiante[0]->cod_matricula}}" name="cod_matriculaAux" >
                            <div class="col-12" style="text-align: left;">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="flexCheckDefault" value="chkTInvestigacion" name="chkTInvestigacion" @if ($estudiante[0]->tipo_investigacion==1)disabled checked @endif>
                                    <label class="form-check-label" for="flexCheckDefault">
                                    Tipo Investigacion
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="flexCheckDefault" value="chkLocalidad"  name="chkLocalidad" @if ($estudiante[0]->localidad_institucion==1)disabled checked @endif>
                                    <label class="form-check-label" for="flexCheckDefault">
                                    Localidad e Institucion
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="flexCheckDefault" value="chkDuracion" name="chkDuracion" @if ($estudiante[0]->duracion_proyecto==1)disabled checked @endif>
                                    <label class="form-check-label" for="flexCheckDefault">
                                    Duracion del Proyecto
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="flexCheckDefault" value="chkRecursos" name="chkRecursos" @if ($estudiante[0]->recursos==1)disabled checked @endif>
                                    <label class="form-check-label" for="flexCheckDefault">
                                    Recursos
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="flexCheckDefault" value="chkPresupuesto" name="chkPresupuesto" @if ($estudiante[0]->presupuesto==1)disabled checked @endif>
                                    <label class="form-check-label" for="flexCheckDefault">
                                    Presupuesto
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="flexCheckDefault" value="chkFinanciamiento" name="chkFinanciamiento" @if ($estudiante[0]->financiamiento==1)disabled checked @endif>
                                    <label class="form-check-label" for="flexCheckDefault">
                                    Financiamiento
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="flexCheckDefault" value="chkRealProb" name="chkRealProb" @if ($estudiante[0]->rp_antecedente_justificacion==1)disabled checked @endif>
                                    <label class="form-check-label" for="flexCheckDefault">
                                    Realidad Problematica, Antecedentes, Justificacion
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="flexCheckDefault" value="chkProblema" name="chkProblema" @if ($estudiante[0]->formulacion_problema==1)disabled checked @endif>
                                    <label class="form-check-label" for="flexCheckDefault">
                                    Formulacion del Problema
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="flexCheckDefault" value="chkObjetivos" name="chkObjetivos" @if ($estudiante[0]->objetivos==1)disabled checked @endif>
                                    <label class="form-check-label" for="flexCheckDefault">
                                    Objetivos
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="flexCheckDefault" value="chkMarcos" name="chkMarcos" @if ($estudiante[0]->marcos==1)disabled checked @endif>
                                    <label class="form-check-label" for="flexCheckDefault">
                                    Marcos
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="flexCheckDefault" value="chkHipotesis" name="chkHipotesis" @if ($estudiante[0]->formulacion_hipotesis==1)disabled checked @endif>
                                    <label class="form-check-label" for="flexCheckDefault">
                                    Formulacion de la Hipostesis
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="flexCheckDefault" value="chkDiseno" name="chkDiseno" @if ($estudiante[0]->diseño_investigacion==1)disabled checked @endif>
                                    <label class="form-check-label" for="flexCheckDefault">
                                    Diseno de Investigacion
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="flexCheckDefault" value="chkReferencias" name="chkReferencias" @if ($estudiante[0]->referencias_b==1)disabled checked @endif>
                                    <label class="form-check-label" for="flexCheckDefault">
                                    Referencias
                                    </label>
                                </div>
                                <div class="row">
                                    <div class="d-grid gap-2 d-md-block mt-3">
                                        <a class="btn btn-danger" href="{{route('asesor.showEstudiantes')}}">Cancelar</a>
                                        @if($estudiante[0]->referencias_b!=1)
                                            <input class="btn btn-success" type="button" value="Guardar" onclick="saveCampos();">
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
                text: "Se habilitaran los campos!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, guardar!',
                cancelButtonText: 'Cancelar',
                }).then((result) => {
                if (result.isConfirmed) {
                    document.formCampos.action = "{{route('asesor.guardarTemas')}}";
                    document.formCampos.method = "post";
                    document.formCampos.submit();
                }
                })

        }

    </script>
@endsection
