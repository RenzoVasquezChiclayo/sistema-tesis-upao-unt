
<?php $__env->startSection('titulo'); ?>
    Lista Categorias Docente
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contenido'); ?>
    <div class="card-header">
        Lista Categorias
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <div class="row" style="display: flex; align-items:center;">
                    <div class="col-12">
                        <div class="row justify-content-around align-items-center" style="margin: 10px;">
                            <div class="col-8 col-md-5 col-lg-3">
                                <a href="<?php echo e(route('admin.categoriasDocente')); ?>" class="btn btn-success"><i
                                        class='bx bx-sm bx-message-square-add'></i>Agregar Categoria</a>
                            </div>
                        </div>
                        <div class="row mb-3" style="display:flex; align-items:right; justify-content:right;">
                            <div class="col col-sm-8 col-md-6 col-lg-4">
                                <form id="" name="" method="get">
                                    <div class="row">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="buscarCategoria"
                                                placeholder="Categoria" value="" aria-describedby="btn-search">
                                            <button class="btn btn-outline-primary" type="submit"
                                                id="btn-search">Buscar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="table-proyecto" class="table table-striped table-responsive-md" style="font-size: 14px;">
                                <thead>
                                    <tr>
                                        <td>Id</td>
                                        <td>Descripcion</td>
                                        <td>Estado</td>
                                        <td>Opcion</td>
                                    </tr>
                                </thead>
                                <?php $__currentLoopData = $lista_categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l_u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($l_u->cod_categoria); ?></td>
                                        <td><?php echo e($l_u->descripcion); ?></td>
                                        <td>
                                            <div class="container-center">
                                                <form class="form-fit" id="formChangeStatus" name="formChangeStatus" method="post"
                                                action="<?php echo e(route('admin.changeStatusCategoria')); ?>">
                                                    <?php echo csrf_field(); ?>
                                                    <input type="text" name="aux_categoria"
                                                        value="<?php echo e($l_u->cod_categoria); ?>" hidden>
                                                    <div class="form-check form-switch" style="width: fit-content">
                                                        <input class="form-check-input" type="checkbox" role="switch"
                                                            id="flexSwitchCheckDefault" onclick="updateState(this);"
                                                            <?php if($l_u->estado == 1): ?> checked <?php endif; ?>>
                                                        <label class="form-check-label"
                                                            for="flexSwitchCheckDefault">Activado</label>
                                                    </div>
                                                </form>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="row justify-content-center">
                                                <div class="col-3">
                                                    <form id="form-categoria" method="post"
                                                        action="<?php echo e(route('admin.EditarcategoriasDocente')); ?>">
                                                        <?php echo csrf_field(); ?>
                                                        <input type="hidden" name="auxidcategoria"
                                                            value="<?php echo e($l_u->cod_categoria); ?>">
                                                        <a href="#" class="btn btn-warning"
                                                            onclick="this.closest('#form-categoria').submit();"><i
                                                                class='bx bx-sm bx-edit-alt'></i></a>
                                                    </form>
                                                </div>
                                                <div class="col-3">
                                                    <form id="form-delete-categoria" method="post"
                                                        action="<?php echo e(route('admin.delete_categoria')); ?>">
                                                        <?php echo method_field('DELETE'); ?>
                                                        <?php echo csrf_field(); ?>
                                                        <input type="hidden" name="auxidcategoria"
                                                            value="<?php echo e($l_u->cod_categoria); ?>">
                                                        <a href="#" class="btn btn-danger"
                                                            onclick="alertaConfirmacion(this);"><i class='bx bx-message-square-x' ></i></a>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                            <?php echo e($lista_categorias->links()); ?>

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
                title: 'Categoria editado correctamente',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    <?php elseif(session('datos') == 'okregistro'): ?>
    <script>
        Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Categoria agregada correctamente',
            showConfirmButton: false,
            timer: 1200
        })
    </script>
    <?php elseif(session('datos') == 'oknot'): ?>
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error al editar Categoria',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    <?php elseif(session('datos') == 'okdelete'): ?>
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Categoria eliminado correctamente',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    <?php elseif(session('datos') == 'oknotdelete'): ?>
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error al eliminar la Categoria',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    <?php endif; ?>
    <script type="text/javascript">
        // function editarAlumno(formulario, contador){
        //     formulario.closest('#form-alumno'+contador).submit();
        // }
        function alertaConfirmacion(form) {
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
                    form.closest('#form-delete-categoria').submit();
                }
            });
        }

        function updateState(form) {
            form.closest('#formChangeStatus').submit();
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usuario\Desktop\UNT\Escuela_Contabilidad\ProyectoActualizado\sistema-tesis-upao-unt\resources\views/cursoTesis20221/administrador/categoria/listar_categoria_docente.blade.php ENDPATH**/ ?>