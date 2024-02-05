<?php $__env->startSection('titulo'); ?>
    Observaciones del Estudiante
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <style type="text/css">
        .box-search {
            display: flex;
            justify-content: right;
            align-items: right;
            margin-top: 15px;
            margin-bottom: 10px;
        }

        .box-center {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        #table-formato>thead>tr>td {
            color: rgb(40, 52, 122);
            font-style: italic;
        }
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contenido'); ?>
    <div class="card-header">
        Observaciones del estudiante
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <div class="row box-center">
                    <div class="col-10">
                        <h4><b><?php echo e($estudiante[0]->nombres); ?></b></h4>
                        <h6><?php echo e($estudiante[0]->escuela); ?></h6>
                    </div>
                    <?php if($estudiante[0]->estado == 3): ?>
                        <div class="col-10" style="background-color: #7BF96E; padding-top:10px;">
                            <p style="color: white">Este proyecto fue APROBADO!</p>
                        </div>
                    <?php elseif($estudiante[0]->estado == 4): ?>
                        <div class="col-10" style="background-color: #FA6A56; padding-top:10px;">
                            <p style="color: white">Este proyecto fue DESAPROBADO!</p>
                        </div>
                    <?php endif; ?>
                    <div class="col-10 ">
                        <br>
                        <div class="row">
                            <table id="table-formato" class="table table-bordered table-striped table-responsive-md">
                                <thead>
                                    <tr>
                                        <td>Numero</td>
                                        <td>Estado</td>
                                        <td>Fecha</td>
                                        <td style="text-align:center;">Descargar</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $estado = 'Sin iniciar';
                                    ?>
                                    <?php $__currentLoopData = $observaciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $observacion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($observacion->observacionNum); ?></td>
                                            <td>
                                                <?php
                                                    switch ($observacion->estado) {
                                                        case 1:
                                                            $estado = 'Sin corregir';
                                                            break;
                                                        case 2:
                                                            $estado = 'Corregido';
                                                            break;
                                                    }
                                                ?>
                                                <?php echo e($estado); ?></td>
                                            <td><?php echo e($observacion->fecha); ?></td>
                                            <td style="text-align: center;">
                                                <form id="observacion-download"
                                                    action="<?php echo e(route('asesor.descargaObservacion')); ?>" method="POST">
                                                    <?php echo csrf_field(); ?>
                                                    <input type="hidden" name="cod_observaciones"
                                                        value="<?php echo e($observacion->cod_observaciones); ?>">
                                                    <a href="#"
                                                        onclick="this.closest('#observacion-download').submit()"><i
                                                            class='bx bx-sm bx-download'></i></a>

                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-10">
                        <br>
                        <!-- <input type="button" class="btn btn-warning" onclick="history.back()" name="volver atrás" value="Volver"> -->
                        <a href="<?php echo e(route('user_information')); ?>" type="button" class="btn btn-danger"
                            style="margin-left:20px;">Volver</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php if(session('datos') == 'ok'): ?>
        <script>
            Swal.fire(
                'Guardado!',
                'La observaciones se guardaron correctamente',
                'success'
            )
        </script>
    <?php elseif(session('datos') == 'oknot'): ?>
        <script>
            Swal.fire(
                'Error!',
                'Ha ocurrido un error. Vuelve a intentarlo.',
                'error'
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usuario\Desktop\UNT\Escuela_Contabilidad\ProyectoActualizado\sistema-tesis-upao-unt\resources\views/cursoTesis20221/asesor/verObservacionEstudiante.blade.php ENDPATH**/ ?>