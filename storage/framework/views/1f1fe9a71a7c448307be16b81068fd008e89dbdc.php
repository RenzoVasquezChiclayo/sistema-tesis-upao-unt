
<?php $__env->startSection('titulo'); ?>
    Asignar Asesor
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contenido'); ?>
    <div class="card-header">
        Asignar asesor para proyecto de tesis
    </div>
    <div class="card-body">
        <div class="row justify-content-around align-items-center" style="display:flex; align-items:center;">
            <div class="col-12">
                <div class="row"
                    style="display:flex; align-items:right; justify-content:right; margin-bottom:10px; margin-top:10px;">
                    <div class="col col-sm-8 col-md-6 col-lg-4 col-xl-3">
                        <form id="listAlumno" name="listAlumno" method="get">
                            <div class="row">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="buscarAlumno"
                                        placeholder="Código de matricula o Apellidos" value="<?php echo e($buscarAlumno); ?>"
                                        aria-describedby="btn-search">
                                    <button class="btn btn-outline-primary" type="submit" id="btn-search">Buscar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <form action="<?php echo e(route('director.saveAsesor')); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <div class="row mb-3" style="text-align:left; justify-content:flex-start">
                        <div class="flex-container" style="display:flex;">
                            <div style="margin:5px;">
                                <a href="<?php echo e(route('director.veragregar')); ?>" class="btn btn-success"><i
                                        class='bx bx-sm bx-message-square-add'></i>Nuevo Alumno</a>
                            </div>
                            <div style="margin:5px;">
                                <a href="<?php echo e(route('director.editarAsignacion')); ?>" class="btn btn-modificaciones">Editar
                                    Asignacion</a>
                            </div>

                        </div>
                        <div class="col-6 col-md-4 col-lg-2">
                        </div>
                        
                        <div class="col-6 col-md-4 col-lg-2">
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="table-proyecto" class="table table-striped table-responsive-md">
                            <thead>
                                <tr>
                                    <td>Numero Matricula</td>
                                    <td>DNI</td>
                                    <td>Nombre</td>
                                    <td>Asesor</td>
                                    <td>Docente</td>
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
                                        <td><?php echo e($est->nombres . ' ' . $est->apellidos); ?>.</td>
                                        <td>
                                            <select name="cboAsesor_<?php echo e($cont); ?>" id="cboAsesor_<?php echo e($cont); ?>"
                                                class="form-control" onchange="validarSeleccion(<?php echo e($cont); ?>);"
                                                <?php if($est->cod_docente != null): ?> disabled <?php endif; ?>>
                                                <option value="0">-</option>
                                                <?php $__currentLoopData = $asesores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($ase->cod_docente); ?>"
                                                        <?php if($est->cod_asesor == $ase->cod_docente): ?> selected <?php endif; ?>>
                                                        <?php echo e($ase->nombres . ' ' . $ase->apellidos); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </td>
                                        <td>
                                            <select name="cboDocente_<?php echo e($cont); ?>" id="cboDocente_<?php echo e($cont); ?>"
                                                class="form-control" onchange="validarSeleccionDocente(<?php echo e($cont); ?>);"
                                                <?php if($est->cod_docente != null): ?> disabled <?php endif; ?>>
                                                <option value="0">-</option>
                                                <?php $__currentLoopData = $asesores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($ase->cod_docente); ?>"
                                                        <?php if($est->cod_docente == $ase->cod_docente): ?> selected <?php endif; ?>><?php echo e($ase->nombres." ".$ase->apellidos); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </td>
                                        <td>
                                            <input class="btn btn-success" id="btnAsesor_<?php echo e($cont); ?>"
                                                type="button" value="+" onclick="guardarAsesor(<?php echo e($cont); ?>);"
                                                hidden>
                                            <input type="button" class="btn"
                                                style="color:white; background-color: rgb(219, 98, 98)" value="-"
                                                id="btnDeleteAsignar_<?php echo e($cont); ?>"
                                                onclick="deleteAsignacion(<?php echo e($cont); ?>);" hidden>
                                        </td>
                                    </tr>
                                    <input type="hidden" id="codEst_<?php echo e($cont); ?>"
                                        value="<?php echo e($est->cod_matricula); ?>">

                                    <?php
                                        $cont++;
                                    ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <input type="hidden" name="saveAsesor" id="saveAsesor">
                                <input type="hidden" id="cantidadEstudiantes" value="<?php echo e(count($estudiantes)); ?>">
                            </tbody>
                        </table>
                        <?php echo e($estudiantes->links()); ?>

                    </div>
                    <div class="row" style="margin: 10px;">
                        <div class="col-12" style="text-align: right;">
                            <input class="btn btn-success" type="submit" value="Guardar registro" id="saveAsignacion"
                                hidden>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        function validarSeleccion(cont) {
            const selector = document.getElementById('cboAsesor_' + cont);
            index = document.getElementById('cboAsesor_' + cont).selectedIndex;
            if (index != 0) {
                document.getElementById("btnAsesor_" + cont).hidden = false;
                selector.style.backgroundColor = 'lightyellow';
            } else {
                document.getElementById("btnAsesor_" + cont).hidden = true;

            }
        }

        function validarSeleccionDocente(cont){
            const selector = document.getElementById('cboDocente_' + cont);
            index = document.getElementById('cboDocente_' + cont).selectedIndex;
            if (index != 0) {
                document.getElementById("btnAsesor_" + cont).hidden = false;
                selector.style.backgroundColor = 'lightyellow';
            } else {
                document.getElementById("btnDocente_" + cont).hidden = true;
            }
        }

        var arregloAsesor = []

        function guardarAsesor(cont) {
            if(document.getElementById('cboAsesor_' + cont).selectedIndex ==0 || document.getElementById('cboDocente_' + cont).selectedIndex == 0){
                alert("Debe seleccionar un asesor y un docente!");
                return;
            }
            const selector = document.getElementById('cboAsesor_' + cont);
            asesor = document.getElementById('cboAsesor_' + cont).value;

            const selectorDocente = document.getElementById('cboDocente_' + cont);
            docente = document.getElementById('cboDocente_' + cont).value;

            codEstudiante = document.getElementById('codEst_' + cont).value;

            arregloAsesor[cont] = codEstudiante + '_' + asesor + '_' + docente;

            document.getElementById('saveAsesor').value = arregloAsesor;

            document.getElementById("saveAsignacion").hidden = false;
            selector.style.backgroundColor = 'lightgreen';
            selectorDocente.style.backgroundColor = 'lightgreen';
            document.getElementById('btnDeleteAsignar_' + cont).hidden = false;

        }

        //Cambio
        function deleteAsignacion(cont) {
            const selector = document.getElementById('cboAsesor_' + cont);
            const selectorDocente = document.getElementById('cboDocente_' + cont);

            document.getElementById('cboAsesor_' + cont).selectedIndex = 0;
            document.getElementById('cboDocente_' + cont).selectedIndex = 0;
            arregloAsesor[cont] = "";
            document.getElementById("btnAsesor_" + cont).hidden = true;
            document.getElementById('btnDeleteAsignar_' + cont).hidden = true;
            selector.style.backgroundColor = 'white';
            selectorDocente.style.backgroundColor = 'white';
        }
    </script>

    <?php if(session('datos') == 'ok'): ?>
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Guardado correctamente',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    <?php elseif(session('datos') == 'oknot'): ?>
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error al guardar',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usuario\Desktop\UNT\Escuela_Contabilidad\ProyectoActualizado\sistema-tesis-upao-unt\resources\views/cursoTesis20221/director/asignarAsesor.blade.php ENDPATH**/ ?>