
<?php $__env->startSection('titulo'); ?>
    Asignar Temas
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
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
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contenido'); ?>
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
                            <h5><?php echo e($estudiante[0]->num_grupo); ?></h5>
                            <?php $__currentLoopData = $estudiantes_grupo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <p><?php echo e($estu->nombres.' '.$estu->apellidos); ?></p>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </div>
                        <form id="formCampos" action="<?php echo e(route('asesor.guardarTemas')); ?>" method="post">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" value="<?php echo e($estudiante[0]->id_grupo); ?>" name="id_grupoAux" >
                            <div class="col-12" style="text-align: left;">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="flexCheckDefault" value="chkTInvestigacion" name="chkTInvestigacion" <?php if($estudiante[0]->tipo_investigacion==1): ?>disabled checked <?php endif; ?>>
                                    <label class="form-check-label" for="flexCheckDefault">
                                    Tipo Investigacion
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="flexCheckDefault" value="chkLocalidad"  name="chkLocalidad" <?php if($estudiante[0]->localidad_institucion==1): ?>disabled checked <?php endif; ?>>
                                    <label class="form-check-label" for="flexCheckDefault">
                                    Localidad e Institucion
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="flexCheckDefault" value="chkDuracion" name="chkDuracion" <?php if($estudiante[0]->duracion_proyecto==1): ?>disabled checked <?php endif; ?>>
                                    <label class="form-check-label" for="flexCheckDefault">
                                    Duracion del Proyecto
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="flexCheckDefault" value="chkRecursos" name="chkRecursos" <?php if($estudiante[0]->recursos==1): ?>disabled checked <?php endif; ?>>
                                    <label class="form-check-label" for="flexCheckDefault">
                                    Recursos
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="flexCheckDefault" value="chkPresupuesto" name="chkPresupuesto" <?php if($estudiante[0]->presupuesto==1): ?>disabled checked <?php endif; ?>>
                                    <label class="form-check-label" for="flexCheckDefault">
                                    Presupuesto
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="flexCheckDefault" value="chkFinanciamiento" name="chkFinanciamiento" <?php if($estudiante[0]->financiamiento==1): ?>disabled checked <?php endif; ?>>
                                    <label class="form-check-label" for="flexCheckDefault">
                                    Financiamiento
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="flexCheckDefault" value="chkRealProb" name="chkRealProb" <?php if($estudiante[0]->rp_antecedente_justificacion==1): ?>disabled checked <?php endif; ?>>
                                    <label class="form-check-label" for="flexCheckDefault">
                                    Realidad Problematica, Antecedentes, Justificacion
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="flexCheckDefault" value="chkProblema" name="chkProblema" <?php if($estudiante[0]->formulacion_problema==1): ?>disabled checked <?php endif; ?>>
                                    <label class="form-check-label" for="flexCheckDefault">
                                    Formulacion del Problema
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="flexCheckDefault" value="chkObjetivos" name="chkObjetivos" <?php if($estudiante[0]->objetivos==1): ?>disabled checked <?php endif; ?>>
                                    <label class="form-check-label" for="flexCheckDefault">
                                    Objetivos
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="flexCheckDefault" value="chkMarcos" name="chkMarcos" <?php if($estudiante[0]->marcos==1): ?>disabled checked <?php endif; ?>>
                                    <label class="form-check-label" for="flexCheckDefault">
                                    Marcos
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="flexCheckDefault" value="chkHipotesis" name="chkHipotesis" <?php if($estudiante[0]->formulacion_hipotesis==1): ?>disabled checked <?php endif; ?>>
                                    <label class="form-check-label" for="flexCheckDefault">
                                    Formulacion de la Hipostesis
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="flexCheckDefault" value="chkDiseno" name="chkDiseno" <?php if($estudiante[0]->diseño_investigacion==1): ?>disabled checked <?php endif; ?>>
                                    <label class="form-check-label" for="flexCheckDefault">
                                    Diseno de Investigacion
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="flexCheckDefault" value="chkReferencias" name="chkReferencias" <?php if($estudiante[0]->referencias_b==1): ?>disabled checked <?php endif; ?>>
                                    <label class="form-check-label" for="flexCheckDefault">
                                    Referencias
                                    </label>
                                </div>
                                <div class="row">
                                    <div class="d-grid gap-2 d-md-block mt-3">
                                        <a class="btn btn-danger" href="<?php echo e(route('asesor.showEstudiantes')); ?>">Cancelar</a>
                                        <?php if($estudiante[0]->referencias_b!=1): ?>
                                            <input class="btn btn-success" type="submit" value="Guardar" onclick="saveCampos();">
                                        <?php endif; ?>
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

<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usuario\Desktop\UNT\Escuela_Contabilidad\ProyectoActualizado\sistema-tesis-upao-unt\resources\views/cursoTesis20221/asesor/camposEstudiante.blade.php ENDPATH**/ ?>