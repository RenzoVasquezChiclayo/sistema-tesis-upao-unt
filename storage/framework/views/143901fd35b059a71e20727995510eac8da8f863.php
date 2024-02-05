
<?php $__env->startSection('titulo'); ?>
    Estado del Proyecto
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
<style type="text/css">
    .border-box {
        border: 0.5px solid rgba(0, 0, 0, 0.2);
        border-radius: 20px;
        padding: 10px 0px;
        margin: 0;
    }
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contenido'); ?>
<div class="card-header">
    Estado del proyecto de tesis
</div>
<div class="card-body">
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
                        <div class="row box-center justify-content-center">
                            <div class="col-10">
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
                                                <td><?php echo e($hTesis[0]->fecha); ?></td>
                                                <td><?php echo e($hTesis[0]->titulo); ?></td>
                                                <td><?php echo e($hTesis[0]->nombre_asesor." ".$hTesis[0]->apellidos_asesor); ?></td>
                                                <td><?php echo e($estado); ?></td>
                                                <td style="text-align: center;">
                                                    <?php if($hTesis[0]->estado!=0): ?>
                                                        <form id="proyecto-download" action="<?php echo e(route('curso.descargaTesis')); ?>" method="POST">
                                                            <?php echo csrf_field(); ?>
                                                            <input type="hidden" name="cod_cursoTesis" value="<?php echo e($hTesis[0]->cod_proyectotesis); ?>">
                                                            <a href="#" onclick="this.closest('#proyecto-download').submit()" <?php if($hTesis[0]->estado == 0): ?> hidden <?php endif; ?>><i class='bx bx-sm bx-download'></i></a>
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
            <?php echo $__env->make('cards.avisoCard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php if(session('datos')=='ok'): ?>
        <script>
            Swal.fire(
                'Guardado/Enviado!',
                'Proyecto de Tesis guardado/enviado correctamente',
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

<?php echo $__env->make('plantilla.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usuario\Desktop\UNT\Escuela_Contabilidad\ProyectoActualizado\sistema-tesis-upao-unt\resources\views/cursoTesis20221/estadoProyecto.blade.php ENDPATH**/ ?>