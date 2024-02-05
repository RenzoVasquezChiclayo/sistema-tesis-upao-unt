
<?php $__env->startSection('titulo'); ?>
    Lista Alumnos
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contenido'); ?>
    <div class="card-header">
        Lista de alumnos
    </div>
    <div class="card-body">
        <div class="row justify-content-around align-items-center">
            <div class="col-12">
                <div class="row justify-content-around align-items-center">
                    <div class="col-12">
                        <div class="card text-center shadow bg-white rounded">
                            <div class="card-body">
                                <div class="row justify-content-around align-items-center" style="margin: 10px;">
                                    <div class="col-md-5">
                                        <a href="<?php echo e(route('director.veragregar')); ?>" class="btn btn-success"><i
                                                class='bx bx-sm bx-message-square-add'></i>Nuevo Alumno</a>
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-end align-items-center">
                                    <div class="col-md-3">
                                        <h5>Filtrar</h5>
                                        <form id="filtrarAlumno" name="filtrarAlumno" method="get">
                                            <div class="row">
                                                <div class="input-group">
                                                    <select class="form-select" name="filtrar_semestre"
                                                        id="filtrar_semestre" required>
                                                        <?php $__currentLoopData = $semestre; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($sem->cod_config_ini); ?>" <?php if($sem->cod_config_ini == $filtrarSemestre): ?> selected <?php endif; ?>>
                                                                <?php echo e($sem->year); ?>_<?php echo e($sem->curso); ?>

                                                            </option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                    <button class="btn btn-outline-primary" type="submit"
                                                        id="btn-search">Filtrar</button>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                    <div class="col col-sm-8 col-md-6">
                                        <h5>Buscar alumno</h5>
                                        <form id="listAlumno" name="listAlumno" method="get">
                                            <div class="row">
                                                <input name="semestre" id="semestre" type="text" hidden>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="buscarAlumno"
                                                        placeholder="Codigo de matricula o Apellidos"
                                                        value="<?php echo e($buscarAlumno); ?>" aria-describedby="btn-search">
                                                    <button class="btn btn-outline-primary" type="button" onclick="saveStateSemestre(this);"
                                                        id="btn-search">Buscar</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table id="table-proyecto" class="table table-striped table-responsive-md">
                                <thead>
                                    <tr>
                                        <td>Numero Matricula</td>
                                        <td>DNI</td>
                                        <td>Nombre</td>
                                        <td>Escuela</td>
                                        <td>Editar</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $cont = 0;
                                    ?>
                                    <?php $__currentLoopData = $estudiantes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $est): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($est->cod_matricula); ?></td>
                                            <td><?php echo e($est->dni); ?></td>
                                            <td><?php echo e($est->apellidos . ' ' . $est->nombres); ?></td>
                                            <td><?php echo e($est->nombreEscuela); ?></td>
                                            <td>
                                                <form id="form-alumno" method="post"
                                                    action="<?php echo e(route('director.verAlumnoEditar')); ?>">
                                                    <?php echo csrf_field(); ?>
                                                    <input type="hidden" name="auxid" value="<?php echo e($est->cod_matricula); ?>">
                                                    <a href="#" class="btn btn-warning"
                                                        onclick="this.closest('#form-alumno').submit();"><i
                                                            class='bx bx-sm bx-edit-alt'></i></a>
                                                </form>
                                            </td>
                                            <?php if(auth()->user()->rol == 'administrador' || auth()->user()->rol == 'd-CTesis2022-1'): ?>
                                                <td>
                                                    <form id="formAlumnoDelete" name="formAlumnoDelete" method="POST"
                                                        action="<?php echo e(route('director.deleteAlumno')); ?>">
                                                        <?php echo method_field('DELETE'); ?>
                                                        <?php echo csrf_field(); ?>

                                                        <input type="hidden" name="auxidDelete"
                                                            value="<?php echo e($est->cod_matricula); ?>">
                                                        <a href="#" class="btn btn-danger btn-eliminar"
                                                            onclick="alertaConfirmacion(this);"><i
                                                                class='bx bx-message-square-x'></i></a>
                                                    </form>
                                                </td>
                                            <?php endif; ?>

                                        </tr>
                                        <?php
                                            $cont++;
                                        ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <input type="hidden" name="saveAsesor" id="saveAsesor">
                                    <input type="hidden" id="cantidadEstudiantes" value="<?php echo e(count($estudiantes)); ?>">
                                </tbody>
                            </table>
                            <?php if(!empty($estudiantes)): ?>
                                <?php echo e($estudiantes->appends(request()->input())->links()); ?>

                            <?php endif; ?>

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
                title: 'Alumno editado correctamente',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    <?php elseif(session('datos') == 'oknot'): ?>
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error al editar alumno',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    <?php elseif(session('datos') == 'okDelete'): ?>
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Alumno eliminado correctamente',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    <?php elseif(session('datos') == 'okNotDelete'): ?>
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error al eliminar el alumno',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    <?php endif; ?>
    <script type="text/javascript">

        function editarAlumno(formulario, contador) {
            formulario.closest('#form-alumno' + contador).submit();
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
                    form.closest('#formAlumnoDelete').submit();
                }
            })
        }

        function saveStateSemestre(form){
            const semestreSelect = document.getElementById("filtrar_semestre");
            const selectedSemestre = semestreSelect.options[semestreSelect.selectedIndex];
            document.getElementById("semestre").value = selectedSemestre.value;
            form.closest("#listAlumno").submit();
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usuario\Desktop\UNT\Escuela_Contabilidad\ProyectoActualizado\sistema-tesis-upao-unt\resources\views/cursoTesis20221/director/listaAlumnos.blade.php ENDPATH**/ ?>