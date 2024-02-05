<?php $__env->startSection('titulo'); ?>
    Configuraciones Iniciales
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contenido'); ?>
    <div class="card-header">
        Semestre Academico
    </div>
    <div class="card-body">
        <div class="row justify-content-around align-items-center">
            <form id="formconfig" method="post" action="<?php echo e(route('admin.saveconfigurar')); ?>">
                <?php echo csrf_field(); ?>
                <div class="row">
                    <div class="col-xl-4">
                        <h5>Año</h5>
                        <input class="form-control" type="text" minlength="4" maxlength="4" placeholder="0000"
                            name="year" required>
                    </div>
                    <div class="col-xl-5">
                        <h5>Curso</h5>
                        <input class="form-control" type="text" placeholder="Nombre del curso" name="curso" required>
                    </div>
                    <div class="col-xl-3">
                        <h5>Ciclo</h5>
                        <input class="form-control" type="number" name="ciclo" required>
                    </div>
                </div>
                <div class="row justify-content-around align-items-center" style="margin-top: 30px;">
                    <div class="col-4">
                        <input class="btn btn-success" type="button" value="Guardar" onclick="saveConfig(this);">
                    </div>

                </div>
            </form>

        </div>
        <div class="row">
            <div class="table-responsive">
                <table id="table-proyecto" class="table table-striped table-responsive-md" style="font-size: 14px;">
                    <thead>
                        <tr>
                            <td>Id</td>
                            <td>Año</td>
                            <td>Curso</td>
                            <td>Ciclo</td>
                            <td>Estado</td>
                            <td>Editar</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $cont = 0;
                        ?>
                        <?php $__currentLoopData = $lista_configuraciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l_c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($l_c->cod_configuraciones); ?></td>
                                <td><?php echo e($l_c->año); ?></td>
                                <td><?php echo e($l_c->curso); ?></td>
                                <td><?php echo e($l_c->ciclo); ?></td>
                                <td>
                                    <div class="container-center">
                                        <form class="form-fit" id="formChangeStatus" name="formChangeStatus" method="post"
                                        action="<?php echo e(route('admin.changeStatusConfiguraciones')); ?>" >
                                            <?php echo csrf_field(); ?>
                                            <input type="text" name="aux_configuraciones"
                                                value="<?php echo e($l_c->cod_configuraciones); ?>" hidden>
                                            <div class="form-check form-switch" style="width: fit-content">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    id="flexSwitchCheckDefault" onclick="updateState(this);"
                                                    <?php if($l_c->estado == 1): ?> checked <?php endif; ?>>
                                                <label class="form-check-label" for="flexSwitchCheckDefault">Activado</label>
                                            </div>
                                        </form>
                                    </div>
                                </td>
                                <td>
                                    <form id="form-configuracion" method="post"
                                        action="<?php echo e(route('admin.verConfiguracionEditar')); ?>">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="auxid" value="<?php echo e($l_c->cod_configuraciones); ?>">
                                        <a href="#" class="btn btn-warning"
                                            onclick="this.closest('#form-configuracion').submit();"><i
                                                class='bx bx-sm bx-edit-alt'></i></a>
                                    </form>
                                </td>
                            </tr>
                            <?php
                                $cont++;
                            ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
                <?php echo e($lista_configuraciones->links()); ?>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        function saveConfig(form) {
            Swal.fire({
                title: 'Estas seguro?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, guardar!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.closest('#formconfig').submit();
                }
            })
        }


        function alertaConfirmacion(form) {
            Swal.fire({
                title: 'Estas seguro?',
                text: "No podras revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminar!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.closest('#formConfiguracionDelete').submit();
                }
            })
        }
        function updateState(form) {
            form.closest('#formChangeStatus').submit();
        }
    </script>
    <?php if(session('datos') == 'okNotNull'): ?>
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Complete todos los campos',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    <?php elseif(session('datos') == 'ok'): ?>
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Guardado correctamente',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    <?php elseif(session('datos') == 'okNot'): ?>
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error al guardar',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    <?php elseif(session('datos') == 'okDelete'): ?>
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Configuracion eliminado correctamente',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    <?php elseif(session('datos') == 'okNotDelete'): ?>
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error al eliminar la Configuracion',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usuario\Desktop\UNT\Escuela_Contabilidad\ProyectoActualizado\sistema-tesis-upao-unt\resources\views/cursoTesis20221/administrador/configuraciones_iniciales/agregar_configuraciones_iniciales.blade.php ENDPATH**/ ?>