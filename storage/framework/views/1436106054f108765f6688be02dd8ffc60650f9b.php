
<?php $__env->startSection('titulo'); ?>
    Editar Configuraciones Iniciales
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contenido'); ?>
    <div class="card-header">
        Editar Configuraciones Iniciales
    </div>
    <div class="card-body">
        <div class="row">
            <form id="form_edit_config" method="post" action="<?php echo e(route('admin.saveEditarconfiguraciones')); ?>">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="auxid" value="<?php echo e($find_configuracion->cod_config_ini); ?>">
                <div class="row">
                    <div class="col-xl-4">
                        <h5>Año</h5>
                        <input class="form-control" type="text" minlength="4" maxlength="4" placeholder="0000" name="year" value="<?php echo e($find_configuracion->year); ?>" required>
                    </div>
                    <div class="col-xl-5">
                        <h5>Curso</h5>
                        <input class="form-control" type="text" placeholder="Nombre del curso" name="curso" value="<?php echo e($find_configuracion->curso); ?>" required>
                    </div>
                    <div class="col-xl-3">
                        <h5>Ciclo</h5>
                        <input class="form-control" type="number" name="ciclo" value="<?php echo e($find_configuracion->ciclo); ?>" required>
                    </div>
                </div>
                <div class="row justify-content-around align-items-center" style="margin-top: 30px;">
                    <div class="col-4">
                        <input class="btn btn-success" type="submit" value="Guardar">
                    </div>

                </div>
            </form>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usuario\Desktop\UNT\Escuela_Contabilidad\ProyectoActualizado\sistema-tesis-upao-unt\resources\views/cursoTesis20221/administrador/configuraciones_iniciales/editar_configuraciones_iniciales.blade.php ENDPATH**/ ?>