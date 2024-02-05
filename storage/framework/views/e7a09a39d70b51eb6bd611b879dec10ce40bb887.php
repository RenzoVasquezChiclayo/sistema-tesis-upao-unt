<?php $__env->startSection('titulo'); ?>
    Estudiantes con Proyectos
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contenido'); ?>
<div class="card-header">
    En proceso (PROYECTO DE TESIS)
</div>
<div class="card-body">
    <div class="row">
        <div class="col-12">
            
            <div class="row" style="display: flex; align-items:center;">
                <div class="col-12">
                        <table id="table-proyecto" class="table table-striped table-responsive-md">
                            <thead>
                                <tr>
                                    <td>Grupo</td>
                                    <td colspan="2" style="text-align: center;">Estudiantes</td>
                                    <td>Revision</td>
                                    <td>Descargar</td>
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
                                        <td><?php echo e($estu[0]->num_grupo); ?></td>
                                        <td colspan="2">
                                            <table class="table table-borderless mb-0">
                                                <tbody>
                                                    <?php $__currentLoopData = $estu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td><?php echo e($e->cod_matricula); ?></td>
                                                        <td><?php echo e($e->apellidos.' '.$e->nombres); ?></td>
                                                    </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                </tbody>
                                            </table>
                                        </td>
                                        <td>
                                            <?php if($estu[0]->estado != 0): ?>
                                                <form id="form-revisaTema" action="<?php echo e(route('asesor.revisarTemas')); ?>" method="POST">
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
                                        <td style="text-align: center;">
                                            <form id="proyecto-download" action="<?php echo e(route('curso.descargaTesis')); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <input type="hidden" name="cod_cursoTesis" value="<?php echo e($estu[0]->cod_proyectotesis); ?>">
                                                <a href="#" onclick="this.closest('#proyecto-download').submit()"><i class='bx bx-sm bx-download'></i></a>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                </div>
            </div>

        </div>
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
    <?php elseif(session('datos') == 'okAprobado'): ?>
        <script>
            Swal.fire(
                'Guardado!',
                'El proyecto fue APROBADO',
                'success'
            )
        </script>
    <?php elseif(session('datos') == 'okDesaprobado'): ?>
        <script>
            Swal.fire(
                'Guardado!',
                'El proyecto fue DESAPROBADO',
                'success'
            )
        </script>
    <?php endif; ?>
    <script type="text/javascript">
        function saveStateSemestre(form){
                    const semestreSelect = document.getElementById("filtrar_semestre");
                    const selectedSemestre = semestreSelect.options[semestreSelect.selectedIndex];
                    document.getElementById("semestre").value = selectedSemestre.value;
                    form.closest("#listAlumno").submit();
                }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usuario\Desktop\UNT\Escuela_Contabilidad\ProyectoActualizado\sistema-tesis-upao-unt\resources\views/cursoTesis20221/asesor/showEstudiantes.blade.php ENDPATH**/ ?>