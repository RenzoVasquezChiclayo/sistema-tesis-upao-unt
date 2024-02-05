
<?php $__env->startSection('titulo'); ?>
    Lista Usuario
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contenido'); ?>
    <div class="card-header">
        Lista Usuario
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <div class="row justify-content-around align-items-center">
                    <div class="col-12">
                        <div class="row justify-content-around align-items-center" style="margin: 10px;">
                            <div class="col-8 col-md-5 col-lg-3">
                                <a href="<?php echo e(route('admin.verAgregarUsuario')); ?>" class="btn btn-success"><i
                                        class='bx bx-sm bx-message-square-add'></i>Agregar Usuario</a>
                            </div>
                        </div>
                        <div class="row mb-3" style="display:flex; align-items:right; justify-content:right;">
                            <div class="col col-sm-8 col-md-6 col-lg-4 col-xl-3">
                                <form id="" name="" method="get">
                                    <div class="row">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="buscarAlumno"
                                                placeholder="Usuario" value="" aria-describedby="btn-search">
                                            <button class="btn btn-outline-primary" type="submit"
                                                id="btn-search">Buscar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="table-proyecto" class="table table-striped table-responsive-md">
                                <thead>
                                    <tr>
                                        <td>Id</td>
                                        <td>Usuario</td>
                                        <td>Rol</td>
                                        <td>Opciones</td>
                                    </tr>
                                </thead>
                                <?php $__currentLoopData = $usuarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($user->id); ?></td>
                                        <td><?php echo e($user->name); ?></td>
                                        <td><?php echo e($user->rol); ?>.</td>
                                        <td>
                                            <div class="row">
                                                <div class="col-3">
                                                    <form id="form-usuario" method="post"
                                                        action="<?php echo e(route('admin.editar')); ?>">
                                                        <?php echo csrf_field(); ?>
                                                        <input type="hidden" name="auxiduser" value="<?php echo e($user->id); ?>">
                                                        <a href="#" class="btn btn-warning"
                                                            onclick="this.closest('#form-usuario').submit();"><i
                                                                class='bx bx-sm bx-edit-alt'></i></a>
                                                    </form>
                                                </div>
                                                <div class="col-3">
                                                    <form id="formUsuarioDelete" name="formUsuarioDelete" method="POST"
                                                        action="<?php echo e(route('admin.deleteUser')); ?>">
                                                        <?php echo method_field('DELETE'); ?>
                                                        <?php echo csrf_field(); ?>
                                                        <input type="hidden" name="auxiduser" value="<?php echo e($user->id); ?>">
                                                        <a href="#" class="btn btn-danger btn-eliminar"
                                                            onclick="alertaConfirmacion(this);"><i
                                                                class='bx bx-message-square-x'></i></a>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                            <?php echo e($usuarios->links()); ?>

                        </div>

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
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Usuario editado correctamente',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    <?php elseif(session('datos') == 'oksave'): ?>
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Usuario guardado correctamente',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    <?php elseif(session('datos') == 'oknotsave'): ?>
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error al agregar usuario',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    <?php elseif(session('datos') == 'oknot'): ?>
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error al editar usuario',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    <?php elseif(session('datos') == 'okdelete'): ?>
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Usuario eliminado correctamente',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    <?php elseif(session('datos') == 'oknotdelete'): ?>
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error al eliminar el Usuario',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    <?php endif; ?>
    <script type="text/javascript">
        // function editarAlumno(formulario, contador){
        //     formulario.closest('#form-alumno'+contador).submit();
        // }
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
                    document.formUsuarioDelete.action = "<?php echo e(route('admin.deleteUser')); ?>";
                    document.formUsuarioDelete.method = "POST";
                    e.closest('#formUsuarioDelete').submit();
                }
            });
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usuario\Desktop\UNT\Escuela_Contabilidad\ProyectoActualizado\sistema-tesis-upao-unt\resources\views/cursoTesis20221/administrador/listarUsuarios.blade.php ENDPATH**/ ?>