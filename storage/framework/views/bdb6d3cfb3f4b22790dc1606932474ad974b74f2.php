
<?php $__env->startSection('titulo'); ?>
    Agregar Cronograma
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
        Registrar Cronograma
    </div>
    <div class="card-body">
        <div class="row" style="display: flex; align-items:center;">

            <div class="row border-box">
                <!-- TODO: Modify the route -->
                <form action="<?php echo e(route('admin.guardarCronograma')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" id="aux_cod_cronograma" name="aux_cod_cronograma">
                    <div class="row justify-content-center" style="margin-bottom: 20px;">
                        <div class="col-md-5">
                            <h5>Actividad</h5>
                            <input class="form-control" type="text" id="descripcion" name="descripcion"
                                placeholder="Ingrese la actividad" autofocus required>
                        </div>
                        <div class="col-3">
                            <h5>Escuela</h5>
                            <select class="form-select" onchange="select_escuela();" name="escuela" id="escuela" required>
                                <?php $__currentLoopData = $escuela; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($e->cod_escuela); ?>"><?php echo e($e->nombre); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-2">
                            <h5>Semestre academico</h5>
                            <select class="form-select" onchange="select_semestre();" name="semestre_academico"
                                id="semestre_academico" required>
                                <?php $__currentLoopData = $semestre; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s_a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($s_a->cod_config_ini); ?>"><?php echo e($s_a->year); ?>_<?php echo e($s_a->curso); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-12" style="margin-top: 10px;">
                        <button id="btn_save" class="btn btn-success" type="submit">Registrar</button>

                        <a href="<?php echo e(route('admin.verCronograma')); ?>" type="sub"
                            class="btn btn-no-border btn-outline-danger">Cancelar</a>
                    </div>
                </form>
            </div>
            <div class="row mb-3" style="display:flex; align-items:right; justify-content:right;">
                <div class="col col-sm-8 col-md-6 col-lg-4 col-xl-3">
                    <form id="" name="" method="get">
                        <div class="row">
                            <div class="input-group">
                                <input type="text" class="form-control" name="buscarActividad" placeholder="Actividad"
                                    value="" aria-describedby="btn-search">
                                <button class="btn btn-outline-primary" type="submit" id="btn-search">Buscar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card text-center shadow bg-white rounded">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table-proyecto" class="table table-striped table-responsive-md">
                            <thead>
                                <tr>
                                    <td>Id</td>
                                    <td>Actividad</td>
                                    <td>Escuela</td>
                                    <td>Semestre</td>
                                    <td>Opciones</td>
                                </tr>
                            </thead>
                            <?php $__currentLoopData = $cronograma; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($c->cod_cronograma); ?></td>
                                    <td><?php echo e($c->actividad); ?></td>
                                    <td><?php echo e($c->nombre); ?></td>
                                    <td><?php echo e($c->year); ?>_<?php echo e($c->curso); ?></td>
                                    <td>
                                        <div class="row justify-content-center" style="display: flex;">
                                            <div class="col-auto">
                                                <a href="#" class="btn btn-warning"
                                                    onclick="editCronograma('<?php echo e($c->cod_cronograma); ?>', '<?php echo e($c->actividad); ?>','<?php echo e($c->cod_escuela); ?>','<?php echo e($c->cod_config_ini); ?>');">
                                                    <i class='bx bx-sm bx-edit-alt'></i>
                                                </a>
                                            </div>
                                            <div class="col-auto">
                                                <form id="form-delete-cronograma" method="post"
                                                    action="<?php echo e(route('admin.delete_cronograma')); ?>">
                                                    <?php echo method_field('DELETE'); ?>
                                                    <?php echo csrf_field(); ?>
                                                    <input type="hidden" name="auxidcronograma"
                                                        value="<?php echo e($c->cod_cronograma); ?>">
                                                    <a href="#" class="btn btn-danger"
                                                        onclick="alertaConfirmacion(this);"><i
                                                            class='bx bx-message-square-x'></i></a>
                                                </form>
                                            </div>
                                        </div>

                                    </td>

                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </table>
                    </div>
                </div>

            </div>
            <?php echo e($cronograma->links()); ?>

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
                title: 'Actividad agregado correctamente',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    <?php elseif(session('datos') == 'oknot'): ?>
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error al agregar la actividad',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    <?php elseif(session('datos') == 'duplicate'): ?>
        <script>
            Swal.fire({
                position: 'center',
                icon: 'warning',
                title: 'La cctividad ya existe!',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    <?php endif; ?>
    <script type="text/javascript">
        function editCronograma(code, description,cod_escuela,cod_semestre) {
            const inputAuxCodeCronograma = document.getElementById("aux_cod_cronograma");
            inputAuxCodeCronograma.value = code;
            document.getElementById("descripcion").value = description;
            document.getElementById("semestre_academico").value = cod_semestre;
            document.getElementById("escuela").value = cod_escuela;
            document.getElementById("btn_save").textContent = "Editar";
        }

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
                    form.closest('#form-delete-cronograma').submit();
                }
            });
        }

        function select_semestre() {
            semestre = document.getElementById('semestre_academico').value;
            if (semestre != '0') {
                document.getElementById('semestre_hidden').value = semestre;
            } else {
                Swal.fire({
                            position: "top",
                            icon: "warning",
                            title: "Seleccione otra opcion de semestre academico",
                            showConfirmButton: false,
                            timer: 2000
                        });
            }
        }

        function select_escuela() {
            escuela = document.getElementById('escuela').value;
            if (escuela != '0') {
                document.getElementById('escuela_hidden').value = escuela;
            } else {
                Swal.fire({
                            position: "top",
                            icon: "warning",
                            title: "Seleccione otra opcion de escuela",
                            showConfirmButton: false,
                            timer: 2000
                        });
            }
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usuario\Desktop\UNT\Escuela_Contabilidad\ProyectoActualizado\sistema-tesis-upao-unt\resources\views/cursoTesis20221/administrador/cronograma/agregar_cronograma.blade.php ENDPATH**/ ?>