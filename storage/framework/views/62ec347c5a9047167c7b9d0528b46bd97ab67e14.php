
<?php $__env->startSection('titulo'); ?>
    Estado de la Tesis
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contenido'); ?>
    <div class="row" style="display:flex; align-items:center; justify-content: center;">
        <div class="col-12">
            <div class="row">
                <div class="col-10" style="margin:0px auto;margin-top:10px;">
                </div>
            </div>
        </div>

        <?php if(sizeof($hTesis)>0 && $hTesis[0]!=null): ?>
            <div class="col-10">
                <div class="row">
                    <div class="col-12">
                        <div class="row box-center">
                            <div class="col-10">
                                <h5><b>Estado de la Tesis</b></h5>
                                <div class="row">
                                    <table id="table-formato" class="table table-bordered table-responsive-md" style="table-border-color: red;">
                                        <thead>
                                            <tr>
                                                <td>Fecha</td>
                                                <td>Titulo</td>
                                                <td>Asesor</td>
                                                <td>Estado</td>
                                                <td style="text-align: center">Descargar</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $estado = 'sin iniciar';
                                                switch($hTesis[0]->estado){
                                                    case 1:
                                                        $estado = 'Sin revisar';
                                                        break;
                                                    case 2:
                                                        $estado = 'Revisado';
                                                        break;
                                                    case 3:
                                                        $estado = 'Aprobado';
                                                        break;
                                                    case 4:
                                                        $estado = 'Desaprobado';
                                                        break;
                                                    case 9:
                                                        $estado = 'Guardado';
                                                        break;
                                                }
                                            ?>
                                            <tr>
                                                <td><?php echo e($hTesis[0]->fecha_update); ?></td>
                                                <td><?php echo e($hTesis[0]->titulo); ?></td>
                                                <td><?php if($asesor!=null): ?><?php echo e($asesor->nombres." ".$asesor->apellidos); ?><?php endif; ?></td>
                                                <td><?php echo e($estado); ?></td>
                                                <td style="text-align: center;">
                                                    <?php if($hTesis[0]->estado!=0): ?>
                                                        <form id="tesis-download" action="<?php echo e(route('curso.descargar-tesis')); ?>" method="POST">
                                                            <?php echo csrf_field(); ?>
                                                            <input type="hidden" name="cod_Tesis" value="<?php echo e($hTesis[0]->cod_tesis); ?>">
                                                            <a href="#" onclick="this.closest('#tesis-download').submit()" <?php if($hTesis[0]->estado == 0): ?> hidden <?php endif; ?>><i class='bx bx-sm bx-download'></i></a>
                                                        </form>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="row d-flex" style="align-items:center; justify-content: center;">
                <div class="col-8 border-box mt-3">
                    <div class="row">
                        <div class="col">
                            <h4 style="color:red;">Aviso!</h4>
                            <hr style="border: 1px solid black;" />
                        </div>

                        <div class="col">
                            <p>Esta vista estará habilitada cuando se te designe algun asesor para el curso.
                                Si existe algun inconveniente y/o queja envia un correo a <a href="#">
                                    <>example@unitru.edu.pe</u>
                                </a> para mas información.</p>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php if(session('datos')=='ok'): ?>
        <script>
            Swal.fire(
                'Guardado/Enviado!',
                'Tesis guardado/enviado correctamente',
                'success'
            )
        </script>
    <?php endif; ?>
    <script type="text/javascript">
        setTimeout(function(){
            document.querySelector('#mensaje').remove();
        },2000);
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usuario\Desktop\UNT\Escuela_Contabilidad\ProyectoActualizado\sistema-tesis-upao-unt\resources\views/cursoTesis20221/estudiante/tesis/estadoTesis.blade.php ENDPATH**/ ?>