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
<div class="row">
    <div class="col-12">
        <div class="row box-center">
            <div class="col-10 ">
                <div class="row card-correccion">
                    <div class="col-12" style="text-align: center;">
                        <h4>Asignacion de Temas</h4>
                    </div>
                    <div class="col-12" style="text-align: right;">
                        <h5>Codigo</h5>
                        <p>{{$estudiante[0]->cod_matricula}}</p>
                    </div>
                    <div class="col-12" style="text-align: right;">
                        <h5>Alumno</h5>
                        <p>{{$estudiante[0]->nombres.' '.$estudiante[0]->apellidos}}</p>
                    </div>
                    <form id="formCampos" action="{{route('asesor.guardarTemas')}}" method="post">
                        @csrf
                        <input type="hidden" value="{{$estudiante[0]->cod_matricula}}" name="cod_matriculaAux" >
                        <div class="col-12" style="text-align: left;">
                            @if ($estudiante[0]->tipo_investigacion==1)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="flexCheckDefault" value="chkTInvestigacion" name="chkTInvestigacion" disabled>
                                    <label class="form-check-label" for="flexCheckDefault">
                                    Tipo Investigacion
                                    </label>
                                </div>
                            @else
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="flexCheckDefault" value="chkTInvestigacion" name="chkTInvestigacion">
                                <label class="form-check-label" for="flexCheckDefault">
                                Tipo Investigacion
                                </label>
                            </div>
                            @endif
                            @if ($estudiante[0]->localidad_institucion==1)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="flexCheckDefault" value="chkLocalidad"  name="chkLocalidad" disabled>
                                    <label class="form-check-label" for="flexCheckDefault">
                                    Localidad e Institucion
                                    </label>
                                </div>
                            @else
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="flexCheckDefault" value="chkLocalidad"  name="chkLocalidad">
                                <label class="form-check-label" for="flexCheckDefault">
                                Localidad e Institucion
                                </label>
                            </div>
                            @endif
                            @if ($estudiante[0]->duracion_proyecto==1)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="flexCheckDefault" value="chkDuracion" name="chkDuracion" disabled>
                                    <label class="form-check-label" for="flexCheckDefault">
                                    Duracion del Proyecto
                                    </label>
                                </div>
                            @else
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="flexCheckDefault" value="chkDuracion" name="chkDuracion">
                                <label class="form-check-label" for="flexCheckDefault">
                                Duracion del Proyecto
                                </label>
                            </div>
                            @endif
                            @if ($estudiante[0]->recursos==1)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="flexCheckDefault" value="chkRecursos" name="chkRecursos" disabled>
                                    <label class="form-check-label" for="flexCheckDefault">
                                    Recursos
                                    </label>
                                </div>
                            @else
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="flexCheckDefault" value="chkRecursos" name="chkRecursos">
                                <label class="form-check-label" for="flexCheckDefault">
                                Recursos
                                </label>
                            </div>
                            @endif
                            @if ($estudiante[0]->presupuesto==1)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="flexCheckDefault" value="chkPresupuesto" name="chkPresupuesto" disabled>
                                    <label class="form-check-label" for="flexCheckDefault">
                                    Presupuesto
                                    </label>
                                </div>
                            @else
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="flexCheckDefault" value="chkPresupuesto" name="chkPresupuesto">
                                <label class="form-check-label" for="flexCheckDefault">
                                Presupuesto
                                </label>
                            </div>
                            @endif
                            @if ($estudiante[0]->financiamiento==1)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="flexCheckDefault" value="chkFinanciamiento" name="chkFinanciamiento" disabled>
                                    <label class="form-check-label" for="flexCheckDefault">
                                    Financiamiento
                                    </label>
                                </div>
                            @else
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="flexCheckDefault" value="chkFinanciamiento" name="chkFinanciamiento">
                                <label class="form-check-label" for="flexCheckDefault">
                                Financiamiento
                                </label>
                            </div>
                            @endif
                            @if ($estudiante[0]->rp_antecedente_justificacion==1)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="flexCheckDefault" value="chkRealProb" name="chkRealProb" disabled>
                                    <label class="form-check-label" for="flexCheckDefault">
                                    Realidad Problematica, Antecedentes, Justificacion
                                    </label>
                                </div>
                            @else
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="flexCheckDefault" value="chkRealProb" name="chkRealProb">
                                <label class="form-check-label" for="flexCheckDefault">
                                Realidad Problematica, Antecedentes, Justificacion
                                </label>
                            </div>
                            @endif
                            @if ($estudiante[0]->formulacion_problema==1)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="flexCheckDefault" value="chkProblema" name="chkProblema" disabled>
                                    <label class="form-check-label" for="flexCheckDefault">
                                    Formulacion del Problema
                                    </label>
                                </div>
                            @else
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="flexCheckDefault" value="chkProblema" name="chkProblema">
                                <label class="form-check-label" for="flexCheckDefault">
                                Formulacion del Problema
                                </label>
                            </div>
                            @endif
                            @if ($estudiante[0]->objetivos==1)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="flexCheckDefault" value="chkObjetivos" name="chkObjetivos" disabled>
                                    <label class="form-check-label" for="flexCheckDefault">
                                    Objetivos
                                    </label>
                                </div>
                            @else
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="flexCheckDefault" value="chkObjetivos" name="chkObjetivos">
                                <label class="form-check-label" for="flexCheckDefault">
                                Objetivos
                                </label>
                            </div>
                            @endif
                            @if ($estudiante[0]->marcos==1)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="flexCheckDefault" value="chkMarcos" name="chkMarcos" disabled>
                                    <label class="form-check-label" for="flexCheckDefault">
                                    Marcos
                                    </label>
                                </div>
                            @else
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="flexCheckDefault" value="chkMarcos" name="chkMarcos">
                                <label class="form-check-label" for="flexCheckDefault">
                                Marcos
                                </label>
                            </div>
                            @endif
                            @if ($estudiante[0]->formulacion_hipotesis==1)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="flexCheckDefault" value="chkHipotesis" name="chkHipotesis" disabled>
                                    <label class="form-check-label" for="flexCheckDefault">
                                    Formulacion de la Hipostesis
                                    </label>
                                </div>
                            @else
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="flexCheckDefault" value="chkHipotesis" name="chkHipotesis">
                                <label class="form-check-label" for="flexCheckDefault">
                                Formulacion de la Hipostesis
                                </label>
                            </div>
                            @endif
                            @if ($estudiante[0]->diseño_investigacion==1)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="flexCheckDefault" value="chkDiseno" name="chkDiseno" disabled>
                                    <label class="form-check-label" for="flexCheckDefault">
                                    Diseno de Investigacion
                                    </label>
                                </div>
                            @else
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="flexCheckDefault" value="chkDiseno" name="chkDiseno">
                                <label class="form-check-label" for="flexCheckDefault">
                                Diseno de Investigacion
                                </label>
                            </div>
                            @endif
                            @if ($estudiante[0]->referencias_b==1)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="flexCheckDefault" value="chkReferencias" name="chkReferencias" disabled>
                                    <label class="form-check-label" for="flexCheckDefault">
                                    Referencias
                                    </label>
                                </div>
                            @else
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="flexCheckDefault" value="chkReferencias" name="chkReferencias">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Referencias
                                </label>
                            </div>
                            @endif

                              <div class="row">
                                  <div class="col-6">
                                    <!-- <input class="btn btn-success" type="submit" value="Guardar"> -->
                                    <input class="btn btn-success" type="submit" value="Guardar" onclick="saveCampos();" style="margin-right:20px;">
                                  </div>
                                  <div class="col-6">
                                    <a class="btn btn-danger" href="{{route('asesor.showEstudiantes')}}">Cancelar</a>
                                  </div>
                              </div>
                    </div>
                </form>
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
