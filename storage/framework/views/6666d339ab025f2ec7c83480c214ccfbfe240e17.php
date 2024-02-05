
<?php $__env->startSection('titulo'); ?>
    Lista Asesores
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contenido'); ?>
    <div class="card-header">
        Lista de asesores y docentes
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
                                        <a href="<?php echo e(route('director.veragregarAsesor')); ?>" class="btn btn-success"><i
                                                class='bx bx-sm bx-message-square-add'></i>Nuevo Asesor</a>
                                    </div>
                                </div>
                                <div class="row mb-3" style="display:flex; align-items:right; justify-content:right;">
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
                                        <h5>Buscar asesor</h5>
                                        <form id="listAsesor" name="listAsesor" method="get">
                                            <div class="row">
                                                <input name="semestre" id="semestre" type="text" hidden>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="buscarAsesor"
                                                        placeholder="Codigo o Apellidos" value="<?php echo e($buscarAsesor); ?>"
                                                        aria-describedby="btn-search">
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
                                        <td>Codigo</td>
                                        <td>Nombres</td>
                                        <td>ORCID</td>
                                        <td>Categoria</td>
                                        <td>Editar</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $cont = 0;
                                    ?>
                                    <?php $__currentLoopData = $asesores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($ase->cod_docente); ?></td>
                                            <td><?php echo e($ase->DescGrado); ?>. <?php echo e($ase->apellidos); ?> <?php echo e($ase->nombres); ?></td>
                                            <td><?php echo e($ase->orcid); ?></td>
                                            <td><?php echo e($ase->DescCat); ?></td>
                                            <td>
                                                <form id="form-asesor" method="post"
                                                    action="<?php echo e(route('director.verAsesorEditar')); ?>">
                                                    <?php echo csrf_field(); ?>
                                                    <input type="hidden" name="auxid" value="<?php echo e($ase->cod_docente); ?>">
                                                    <a href="#" class="btn btn-warning"
                                                        onclick="this.closest('#form-asesor').submit();"><i
                                                            class='bx bx-sm bx-edit-alt'></i></a>
                                                </form>
                                            </td>
                                            

                                        </tr>
                                        <?php
                                            $cont++;
                                        ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <input type="hidden" name="saveAsesor" id="saveAsesor">
                                    <input type="hidden" id="cantidadAsesores" value="<?php echo e(count($asesores)); ?>">
                                </tbody>
                            </table>
                            <?php if(!empty($asesores)): ?>
                                <?php echo e($asesores->appends(request()->input())->links()); ?>

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
    <?php endif; ?>
    <script type="text/javascript">
        function editarAsesor(formulario, contador) {
            formulario.closest('#form-asesor' + contador).submit();
        }
        function saveStateSemestre(form){
            const semestreSelect = document.getElementById("filtrar_semestre");
            const selectedSemestre = semestreSelect.options[semestreSelect.selectedIndex];
            document.getElementById("semestre").value = selectedSemestre.value;
            form.closest("#listAsesor").submit();
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usuario\Desktop\UNT\Escuela_Contabilidad\ProyectoActualizado\sistema-tesis-upao-unt\resources\views/cursoTesis20221/director/listaAsesores.blade.php ENDPATH**/ ?>