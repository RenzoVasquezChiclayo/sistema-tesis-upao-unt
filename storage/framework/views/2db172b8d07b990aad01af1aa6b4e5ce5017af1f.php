<?php $__env->startSection('titulo'); ?>
    Estudiantes con Tesis
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contenido'); ?>
<div class="card-header">Estudiantes asignados para Tesis</div>
<div class="card-body">
    <div class="table-responsive">
        <table id="table-proyecto" class="table table-striped table-responsive-md">
            <thead>
                <tr>
                    <td>Grupo</td>
                    <td>Estudiantes</td>
                    <td>Revision</td>
                    <td class="text-center">Descargar</td>
                </tr>
            </thead>
            <tbody>
                
                <?php $__currentLoopData = $studentforGroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr
                    <?php if($estu[0]->estado == 3): ?>
                                        style="background-color: rgba(76, 175, 80, 0.2);"
                                    <?php elseif($estu[0]->estado == 4): ?>
                                    style="background-color: rgba(255, 87, 51, 0.2);"
                                    <?php endif; ?>>
                        <td>
                            <?php echo e($estu[0]->num_grupo); ?>

                        </td>
                        <td>
                            <?php $__currentLoopData = $estu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <p><?php echo e($e->cod_matricula.' - '.$e->apellidos.', '.$e->nombres); ?></p>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <td>
                            <?php if($estu[0]->estado != 0): ?>
                                <form id="form-revisaTema" action="<?php echo e(route('asesor.revisar-tesis')); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="id_grupo" value="<?php echo e($estu[0]->id_grupo); ?>">
                                    <?php if($estu[0]->estado == 1): ?>
                                        <a href="#" onclick="this.closest('#form-revisaTema').submit()" class="btn btn-success">Revisar</a>
                                    <?php else: ?>
                                        <a href="#" onclick="this.closest('#form-revisaTema').submit()" class="btn btn-secondary">Observar</a>
                                    <?php endif; ?>
                                </form>
                            <?php endif; ?>
                            
                        </td>
                        <td class="text-center" style="text-align: center; justify-content:center;">
                            <form id="proyecto-download" action="<?php echo e(route('curso.descargar-tesis')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="cod_Tesis" value="<?php echo e($estu[0]->cod_tesis); ?>">
                                <a href="#" onclick="this.closest('#proyecto-download').submit()"><i class='bx bx-sm bx-download'></i></a>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php if(session('datos')=='ok'): ?>
        <script>
            Swal.fire(
                'Guardado!',
                'Asignacion de campos guardados correctamente',
                'success'
            )
        </script>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usuario\Desktop\UNT\Escuela_Contabilidad\ProyectoActualizado\sistema-tesis-upao-unt\resources\views/cursoTesis20221/asesor/tesis/lista-estudiantes-tesis.blade.php ENDPATH**/ ?>