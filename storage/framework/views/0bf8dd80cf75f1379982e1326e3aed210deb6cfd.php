<?php $__env->startSection('titulo'); ?>
    Lista de Tesis asignadas
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <style type="text/css">

    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contenido'); ?>
    <div class="card-header">
        Lista de Tesis asignadas (EVALUACIÓN)
    </div>
    <div class="card-body">
        <div class="row justify-content-around align-items-center">
            <div class="col-12">
                
                <div class="row" style="display: flex; align-items:center;">
                    <div class="table-responsive">
                        <table id="table-tesis" class="table table-striped table-responsive-md">
                            <thead>
                                <tr>
                                    <td>Grupo</td>
                                    <td>Estudiante(s)</td>
                                    <td>Título</td>
                                    <td>Asesor</td>
                                    <td>Tipo Jurado</td>
                                    <td>Revisión</td>
                                    <td>Aprobación</td>
                                    <td>Observacion(es)</td>
                                    <td class="text-center">Descargar</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(sizeof($studentforGroups)<=0): ?>
                                <tr>
                                    <td colspan="9"><i>No cuenta con tesis asignadas.</i></td>
                                </tr>
                                <?php endif; ?>
                                <?php $__currentLoopData = $studentforGroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr
                                    <?php if($estu[0]->estadoDesignacion == 3): ?>
                                        style="background-color: rgba(76, 175, 80, 0.2);"
                                    <?php elseif($estu[0]->estadoDesignacion == 4): ?>
                                    style="background-color: rgba(255, 87, 51, 0.2);"
                                    <?php endif; ?>>
                                        <td><?php echo e($estu[0]->num_grupo); ?></td>
                                        <td>
                                        <?php $__currentLoopData = $estu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <p><?php echo e($e->cod_matricula.' - '.$e->apellidosAutor.', '.$e->nombresAutor); ?></p>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </td>
                                        <td><?php echo e($estu[0]->titulo); ?></td>
                                        <td><?php echo e($estu[0]->nombresAsesor . ' ' . $estu[0]->apellidosAsesor); ?></td>
                                        <td>
                                            <?php if($estu[0]->cod_jurado1 == $asesor->cod_docente): ?>
                                                PRESIDENTE
                                            <?php elseif($estu[0]->cod_jurado2 == $asesor->cod_docente): ?>
                                                2do JURADO
                                            <?php elseif($estu[0]->cod_jurado3 == $asesor->cod_docente): ?>
                                                VOCAL
                                            <?php elseif($estu[0]->cod_jurado4 == $asesor->cod_docente): ?>
                                                RESERVA
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php
                                                $textButton = "";
                                                if($estu[0]->numObs > 0 || $estu[0]->estadoDesignacion > 1){
                                                    $textButton = "Observar";
                                                }elseif($estu[0]->estadoDesignacion <= 1){
                                                    $textButton = "Revisar";
                                                }else
                                            ?>
                                            <?php if($estu[0]->estado != 0): ?>
                                                <form id="form-revisaTema"
                                                    action="<?php echo e(route('jurado.detalleTesisAsignada')); ?>"
                                                    method="POST">
                                                    <?php echo csrf_field(); ?>
                                                    <input type="hidden" name="id_grupo" value="<?php echo e($estu[0]->id_grupo); ?>">
                                                    <input type="hidden" name="cod_tesis" value="<?php echo e($estu[0]->cod_tesis); ?>">
                                                    <a href="#" onclick="this.closest('#form-revisaTema').submit()" class=" btn <?php if($textButton == "Observar"): ?> btn-secondary <?php else: ?> btn-success <?php endif; ?>"><?php echo e($textButton); ?></a>
                                                </form>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <form id="formAprobarTesis" name="formAprobarTesis">
                                                <?php echo csrf_field(); ?>
                                                <input type="hidden" name="cod_tesis" value="<?php echo e($estu[0]->cod_tesis); ?>">
                                                <input type="hidden" name="stateAprobation" id="stateAprobation-<?php echo e($estu[0]->id_grupo); ?>" value="">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="" id="chkAprobado-<?php echo e($estu[0]->id_grupo); ?>" onclick="aprobarTesis(this);" <?php if($estu[0]->estadoResultado != null || $estu[0]->numObs>0): ?> disabled <?php endif; ?> <?php if($estu[0]->estadoResultado != null && $estu[0]->estadoResultado ==1): ?> checked <?php endif; ?>>
                                                    <label class="form-check-label" for="chkAprobado">
                                                      Aprobar/Desaprobar
                                                    </label>
                                                </div>

                                            </form>
                                        </td>
                                        <td>
                                            <a href="<?php echo e(route('jurado.listaTesisAsignadas',['showObservacion'=>$estu[0]->cod_tesis])); ?>">Ver detalle</a>
                                        </td>
                                        <td class="text-center" >
                                            <form id="tesis-download" action="<?php echo e(route('curso.descargaTesis')); ?>"
                                                method="POST">
                                                <?php echo csrf_field(); ?>
                                                <input type="hidden" name="cod_cursoTesis"
                                                    value="<?php echo e($estu[0]->cod_tesis); ?>">
                                                <a href="#" onclick="this.closest('#tesis-download').submit()"><i
                                                        class='bx bx-sm bx-download'></i></a>
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
    <?php if($observaciones != null): ?>
    <div class="card shadow bg-white rounded">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td># Observación</td>
                            <td>Jurado</td>
                            <td>Fecha</td>
                            <td class="text-center">Acción</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(sizeof($observaciones)<=0): ?>
                            <tr>
                                <td colspan="4"><p><i>No existen observaciones.</i></p></td>
                            </tr>
                        <?php endif; ?>
                        <?php $__currentLoopData = $observaciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $obs): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e('#'.($loop->index +1)); ?></td>
                                <td><?php echo e($obs->apellidosJurado.', '.$obs->nombresJurado); ?></td>
                                <td><?php echo e($obs->fechaHistorial); ?></td>
                                <td class="text-center"><a href="#"><i class='bx bx-sm bx-show'></i></a></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php if(session('datos') == 'oknotevaluacion'): ?>
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Ocurrio un error. Intentelo nuevamente.',
                showConfirmButton: true,
                timer: 2500
            })
        </script>
    <?php elseif(session('datos') == 'okevaluacion'): ?>
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Los cambios/observaciones se guardaron correctamente!',
                showConfirmButton: true,
                timer: 2500
            })
        </script>
    <?php elseif(session('datos') == 'okAprobadoTesis'): ?>
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'La tesis se aprobó correctamente!',
                showConfirmButton: true,
                timer: 2500
            })
        </script>
    <?php elseif(session('datos') == 'oknotAprobadoTesis'): ?>
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Ocurrió un problema durante la aprobación de la tesis.',
                showConfirmButton: true,
                timer: 2500
            })
        </script>
    <?php elseif(session('datos') == 'okobservacion'): ?>
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'La observacion se guardo correctamente!',
                showConfirmButton: true,
                timer: 2500
            })
        </script>
    <?php elseif(session('datos') == 'oknotobservacion'): ?>
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Ocurrió un problema. Intentelo nuevamente.',
                showConfirmButton: true,
                timer: 2500
            })
        </script>
    <?php endif; ?>
    <script type="text/javascript">
        function aprobarTesis(chk) {
            const idchk = chk.id.split('-');
            Swal.fire({
                title: 'Estas seguro(a)?',
                text: "La tesis será aprobado/desaprobado.",
                icon: 'warning',
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: 'APROBAR',
                denyButtonText: 'DESAPROBAR',
                cancelButtonText: 'Cancelar',
            }).then((result) => {

                if (result.isConfirmed) {
                    document.getElementById(`stateAprobation-${idchk[1]}`).value = 1;
                } else if (result.isDenied) {
                    document.getElementById(`stateAprobation-${idchk[1]}`).value = 0;
                } else {
                    document.getElementById(`chkAprobado-${idchk[1]}`).checked = false;
                    return;
                }
                chk.closest('#formAprobarTesis').action = "<?php echo e(route('jurado.aprobarTesis')); ?>";
                chk.closest('#formAprobarTesis').method = "POST";
                chk.closest('#formAprobarTesis').submit();
            });
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usuario\Desktop\UNT\Escuela_Contabilidad\ProyectoActualizado\sistema-tesis-upao-unt\resources\views/cursoTesis20221/asesor/evaluacion/listaTesisAsignadas.blade.php ENDPATH**/ ?>