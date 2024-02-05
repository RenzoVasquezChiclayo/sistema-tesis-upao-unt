
<?php $__env->startSection('titulo'); ?>
    Mantenedor Generalidades
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <style type="text/css">

    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contenido'); ?>
    <div class="card-header">
        Mantenedor de generalidades
    </div>
    <div class="card-body">
        <div class="row justify-content-around align-items-center">
            <div class="col-11">
                <h5>Filtrar por semestre:</h5>
                <div class="row justify-content-around align-items-center">
                    <div class="col-lg-5">
                        <form id="listGeneralidades" name="listGeneralidades" method="get">
                            <div class="row">
                                <div class="input-group">
                                    <select class="form-select" name="buscarpor_semestre" id="buscarpor_semestre">
                                        <option value="20231">2023-I</option>
                                    </select>
                                    <button class="btn btn-primary" type="submit" id="btn-search">Buscar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card shadow bg-white rounded" style="margin-top: 5px;">
                    <div class="card-body">
                        <div class="row">
                            <h5 class="card-title">Linea de Investigacion</h5>
                            <div class="table-responsive">
                                <table class="table table-striped table-responsive-md" style="font-size: 13px;">
                                    <thead>
                                        <tr>
                                            <th scope="col">Codigo</th>
                                            <th scope="col">Descripcion</th>
                                            <th scope="col">Accion</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(!empty($lineasInves)): ?>
                                            <?php $__currentLoopData = $lineasInves; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l_i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($l_i->cod_tinvestigacion); ?></td>
                                                    <td><?php echo e($l_i->descripcion); ?></td>
                                                    <td>
                                                        <form id="form-linea-inves" method="post"
                                                            action="<?php echo e(route('director.lineaInvesEditar')); ?>">
                                                            <?php echo csrf_field(); ?>
                                                            <input type="hidden" name="auxid"
                                                                value="<?php echo e($l_i->cod_tinvestigacion); ?>">
                                                            <a href="#" class="btn btn-warning"
                                                                onclick="this.closest('#form-linea-inves').submit();"><i
                                                                    class='bx bx-sm bx-edit-alt'></i></a>
                                                        </form>
                                                    </td>
                                                    <td>
                                                        <form id="formLineaInvesDelete" name="formLineaInvesDelete"
                                                            method="post"
                                                            action="<?php echo e(route('director.deleteLineaInves')); ?>">
                                                            <?php echo method_field('DELETE'); ?>
                                                            <?php echo csrf_field(); ?>
                                                            <input type="hidden" name="auxidDelete"
                                                                value="<?php echo e($l_i->cod_tinvestigacion); ?>">
                                                            <a href="#" class="btn btn-danger btn-eliminar"
                                                                onclick="alertaConfirmacion(this);"><i
                                                                    class='bx bx-message-square-x'></i></a>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card shadow bg-white rounded" style="margin-top: 5px;">
                    <div class="card-body">
                        <div class="row">
                            <h5 class="card-title">Fin que persigue</h5>
                            <div class="table-responsive">
                                <table class="table table-striped table-responsive-md" style="font-size: 13px;">
                                    <thead>
                                        <tr>
                                            <th scope="col">Codigo</th>
                                            <th scope="col">Descripcion</th>
                                            <th scope="col">Accion</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(!empty($fin_persigue)): ?>
                                            <?php $__currentLoopData = $fin_persigue; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f_p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($f_p->cod_fin_persigue); ?></td>
                                                    <td><?php echo e($f_p->descripcion); ?></td>
                                                    <td>
                                                        <form id="formFinPersigueDelete" name="formFinPersigueDelete"
                                                            method="post" action="<?php echo e(route('director.deleteFinPersigue')); ?>">
                                                            <?php echo method_field('DELETE'); ?>
                                                            <?php echo csrf_field(); ?>
                                                            <input type="hidden" name="auxidDeleteF_P"
                                                                value="<?php echo e($f_p->cod_fin_persigue); ?>">
                                                            <a href="#" class="btn btn-danger btn-eliminar"
                                                                onclick="alertaConfirmacionF_P(this);"><i
                                                                    class='bx bx-message-square-x'></i></a>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card shadow bg-white rounded" style="margin-top: 5px;">
                    <div class="card-body">
                        <div class="row">
                            <h5 class="card-title">Diseno de Investigacion</h5>
                            <div class="table-responsive">
                                <table class="table table-striped table-responsive-md" style="font-size: 13px;">
                                    <thead>
                                        <tr>
                                            <th scope="col">Codigo</th>
                                            <th scope="col">Descripcion</th>
                                            <th scope="col">Accion</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(!empty($diseno_investigacion)): ?>
                                            <?php $__currentLoopData = $diseno_investigacion; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d_i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($d_i->cod_diseno_investigacion); ?></td>
                                                    <td><?php echo e($d_i->descripcion); ?></td>
                                                    <td>
                                                        <form id="formDisInvestigaDelete" name="formDisInvestigaDelete"
                                                            method="post" action="<?php echo e(route('director.deleteDisInvestiga')); ?>">
                                                            <?php echo method_field('DELETE'); ?>
                                                            <?php echo csrf_field(); ?>
                                                            <input type="hidden" name="auxidDeleteD_I"
                                                                value="<?php echo e($d_i->cod_diseno_investigacion); ?>">
                                                            <a href="#" class="btn btn-danger btn-eliminar"
                                                                onclick="alertaConfirmacionD_I(this);"><i
                                                                    class='bx bx-message-square-x'></i></a>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>



<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php if(session('datos') == 'okEdit'): ?>
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Editado correctamente',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    <?php elseif(session('datos') == 'oknotEdit'): ?>
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error al editar',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    <?php elseif(session('datos') == 'okDelete'): ?>
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Eliminado correcxtamente',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    <?php elseif(session('datos') == 'oknotDelete'): ?>
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error al eliminar',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    <?php endif; ?>
    <script type="text/javascript">
        function editarLinea(formulario, contador) {
            formulario.closest('#form-linea-inves' + contador).submit();
        }

        function alertaConfirmacion(e) {
            Swal.fire({
                title: 'Estas Seguro que deseas eliminar?',
                text: "No podras revertirlo",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Confirmar!'
            }).then((result) => {
                if (result.isConfirmed) {
                    e.closest('#formLineaInvesDelete').submit();
                }
            });
        }

        function alertaConfirmacionF_P(e) {
            Swal.fire({
                title: 'Estas Seguro que deseas eliminar?',
                text: "No podras revertirlo",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Confirmar!'
            }).then((result) => {
                if (result.isConfirmed) {
                    e.closest('#formFinPersigueDelete').submit();
                }
            });
        }

        function alertaConfirmacionD_I(e) {
            Swal.fire({
                title: 'Estas Seguro que deseas eliminar?',
                text: "No podras revertirlo",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Confirmar!'
            }).then((result) => {
                if (result.isConfirmed) {
                    e.closest('#formDisInvestigaDelete').submit();
                }
            });
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usuario\Desktop\UNT\Escuela_Contabilidad\ProyectoActualizado\sistema-tesis-upao-unt\resources\views/cursoTesis20221/director/mantenedorGeneralidades.blade.php ENDPATH**/ ?>