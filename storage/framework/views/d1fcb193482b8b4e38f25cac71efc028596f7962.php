
<?php $__env->startSection('titulo'); ?>
    Agregar Categoria
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <style type="text/css">
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contenido'); ?>
    <div class="card-header">
        Registrar Categoria
    </div>
    <div class="card-body">
        <div class="row" style="display: flex; align-items:center;">

            <form action="<?php echo e(route('admin.saveCategorias')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="row justify-content-around align-items-center">
                    <div class="col-md-4">
                        <label for="cod_matricula">Descripcion</label>
                        <input class="form-control" type="text" id="descripcion" name="descripcion"
                            placeholder="Ingrese nombre de la categoria" autofocus required>
                    </div>
                </div>

                <div class="col-12" style="margin-top: 10px;">
                    <button class="btn btn-success" type="submit">Registrar</button>
                    <a href="<?php echo e(route('user_information')); ?>" type="button" class="btn btn-danger">Cancelar</a>
                </div>
            </form>
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
                title: 'Categoria agregada correctamente',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    <?php elseif(session('datos') == 'oknot'): ?>
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error al agregar la categoria',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    <?php endif; ?>
    <script type="text/javascript"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usuario\Desktop\UNT\Escuela_Contabilidad\ProyectoActualizado\sistema-tesis-upao-unt\resources\views/cursoTesis20221/administrador/categoria/agregar_categoria_docente.blade.php ENDPATH**/ ?>