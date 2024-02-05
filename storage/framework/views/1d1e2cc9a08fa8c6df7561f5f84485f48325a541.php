
<?php $__env->startSection('titulo'); ?>
    Historial de Observaciones
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <style type="text/css">
        .box-search{
            display: flex;
            justify-content: right;
            align-items: right;
            margin-top:15px;
            margin-bottom:10px;
        }
        .box-center{
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top:10px;
            margin-bottom:10px;
        }

        #table-formato > thead > tr > td{
            color: rgb(40, 52, 122);
            font-style: italic;
        }

    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contenido'); ?>
    <div class="row">
        <div class="col-12">
            <div class="row box-center">
                <div class="col-10">
                    <div class="row" style="display:flex; align-items:right; justify-content:right;">
                        <div class="col-9 col-md-4">
                            <form id="listObservacion" name="listObservacion" method="get">
                                <div class="row">
                                    <div class="col-9">
                                        <input type="text" class="form-control me-2" name="buscarObservacion" placeholder="Buscar observacion" value="<?php echo e($buscarObservaciones); ?>" aria-describedby="btn-search">
                                    </div>
                                    <div class="col-3">
                                        <input class="btn btn-outline-success" type="submit" id="btn-search" value="Search">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row" style="display:flex; align-items:right; justify-content:right;">
                        <div class="col-7 col-xl-4" style="text-align: right;">
                            <span id="notfound"><?php if(sizeof($estudiantes)==0): ?>
                                No se encontro algun registro
                            <?php endif; ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="row box-center">
                <div class="col-10 ">
                    <div class="row">
                        <table id="table-formato" class="table table-bordered table-striped table-responsive-md">
                            <thead>
                                <tr>
                                    <td>Grupo</td>

                                    <td>Escuela</td>
                                    <td>Ultima Observacion</td>
                                    <td style="text-align:center;">Ver Observacion</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $estudiantes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estudiante): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr
                                    <?php if($estudiante->estado == 3): ?>
                                        style= "background-color: #7BF96E;"
                                    <?php elseif($estudiante->estado == 4): ?>
                                        style= "background-color: #FA6A56;"
                                    <?php endif; ?>
                                    >
                                        
                                        <td><?php echo e($estudiante->id_grupo); ?></td>
                                        <td>Contabilidad y Finanzas</td>
                                        <td><?php echo e($estudiante->fecha); ?></td>
                                        <td style="text-align:center;">
                                            <a href="<?php echo e(route('asesor.ver-obs-estudiante-tesis',$estudiante->cod_historial_observacion)); ?>"><i class="bx bx-sm bx-show"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </tbody>
                        </table>
                        <?php echo e($estudiantes->links()); ?>

                    </div>


                </div>
            </div>
        </div>

    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usuario\Desktop\UNT\Escuela_Contabilidad\ProyectoActualizado\sistema-tesis-upao-unt\resources\views/cursoTesis20221/asesor/tesis/estudiantes-obs.blade.php ENDPATH**/ ?>