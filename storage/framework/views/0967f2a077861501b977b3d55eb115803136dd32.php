
<?php $__env->startSection('titulo'); ?>
    Editar Jurado
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contenido'); ?>
    <div class="card-header">
        Editar Jurados de Sustentación
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <div class="row" style="display: flex; align-items:center;">
                    <div class="col-12">
                        <form action="<?php echo e(route('director.editAsignacionJurados')); ?>" method="post">
                            <?php echo csrf_field(); ?>
                            <table id="table-proyecto" class="table table-striped table-responsive-md">
                                <thead>
                                    <tr>
                                        <td>Nº</td>
                                        <td>Nombres</td>
                                        <td>Titulo</td>
                                        <td>Asesor</td>
                                        <td>Designar</td>
                                        <td>Acciones</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $cont = 0;
                                    ?>
                                    <?php $__currentLoopData = $tesisAgrupadas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($ta[0]['cod_tesis']); ?></td>
                                            <td>
                                                <?php $__currentLoopData = $ta[0]['autores']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $autor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php echo e($autor['nombresAutor'] . ' ' . $autor['apellidosAutor']); ?>

                                                    <?php if($index < count($ta[0]['autores']) - 1): ?>
                                                        &amp;
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </td>
                                            <td><?php echo e($ta[0]['titulo']); ?></td>
                                            <td><?php echo e($ta[0]['apellidosAsesor'] . ' ' . $ta[0]['nombresAsesor']); ?></td>
                                            <td style="text-align: center;">
                                                <div class="row">
                                                    <p>1er Jurado</p>
                                                    <select name="cbo1Jurado_<?php echo e($cont); ?>"
                                                        id="cbo1Jurado_<?php echo e($cont); ?>" class="form-control"
                                                        onchange="validarSeleccion(<?php echo e($cont); ?>);"
                                                        <?php if($ta[0]['cod_jurado1'] != null): ?> disabled <?php endif; ?>>
                                                        <option value="0">-</option>
                                                        <?php $__currentLoopData = $ta[1]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $asesores): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php if($asesores->cod_docente != $ta[0]['cod_docente']): ?>
                                                                <option value="<?php echo e($asesores->cod_docente); ?>"
                                                                    <?php if($ta[0]['cod_jurado1'] == $asesores->cod_docente): ?> selected <?php endif; ?>>
                                                                    <?php echo e($asesores->apellidos . ' ' . $asesores->nombres); ?>

                                                                </option>
                                                            <?php endif; ?>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                                <div class="row">
                                                    <p>2do Jurado</p>
                                                    <select name="cbo2Jurado_<?php echo e($cont); ?>"
                                                        id="cbo2Jurado_<?php echo e($cont); ?>" class="form-control"
                                                        onchange="validarSeleccion(<?php echo e($cont); ?>);"
                                                        <?php if($ta[0]['cod_jurado2'] != null): ?> disabled <?php endif; ?>>
                                                        <option value="0">-</option>
                                                        <?php $__currentLoopData = $ta[1]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $asesores): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php if($asesores->cod_docente != $ta[0]['cod_docente']): ?>
                                                                <option value="<?php echo e($asesores->cod_docente); ?>"
                                                                    <?php if($ta[0]['cod_jurado2'] == $asesores->cod_docente): ?> selected <?php endif; ?>>
                                                                    <?php echo e($asesores->apellidos . ' ' . $asesores->nombres); ?>

                                                                </option>
                                                            <?php endif; ?>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                                <div class="row">
                                                    <p>VOCAL</p>
                                                    <select name="cboVocal_<?php echo e($cont); ?>"
                                                        id="cboVocal_<?php echo e($cont); ?>" class="form-control"
                                                        onchange="validarSeleccion(<?php echo e($cont); ?>);"
                                                        <?php if($ta[0]['cod_jurado3'] != null): ?> disabled <?php endif; ?>>
                                                        <option value="0">-</option>
                                                        <?php $__currentLoopData = $ta[1]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $asesores): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php if($asesores->cod_docente != $ta[0]['cod_docente']): ?>
                                                                <option value="<?php echo e($asesores->cod_docente); ?>"
                                                                    <?php if($ta[0]['cod_jurado3'] == $asesores->cod_docente): ?> selected <?php endif; ?>>
                                                                    <?php echo e($asesores->apellidos . ' ' . $asesores->nombres); ?>

                                                                </option>
                                                            <?php endif; ?>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                                <div class="row">
                                                    <p>VOCAL</p>
                                                    <select name="cbo4Jurado_<?php echo e($cont); ?>"
                                                        id="cbo4Jurado_<?php echo e($cont); ?>" class="form-control"
                                                        onchange="validarSeleccion(<?php echo e($cont); ?>);"
                                                        <?php if($ta[0]['cod_jurado4'] != null): ?> disabled <?php endif; ?>>
                                                        <option value="0">-</option>
                                                        <?php $__currentLoopData = $ta[1]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $asesores): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php if($asesores->cod_docente != $ta[0]['cod_docente']): ?>
                                                                <option value="<?php echo e($asesores->cod_docente); ?>"
                                                                    <?php if($ta[0]['cod_jurado4'] == $asesores->cod_docente): ?> selected <?php endif; ?>>
                                                                    <?php echo e($asesores->apellidos . ' ' . $asesores->nombres); ?>

                                                                </option>
                                                            <?php endif; ?>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <input class="btn btn-success" id="btnValidar_<?php echo e($cont); ?>"
                                                    type="button" value="+"
                                                    onclick="guardarJurados(<?php echo e($cont); ?>);" hidden>
                                                <input type="button" class="btn"
                                                    style="color:white; background-color: rgb(219, 98, 98)" value="-"
                                                    id="btnDeleteAsignar_<?php echo e($cont); ?>"
                                                    onclick="deleteAsignacion(<?php echo e($cont); ?>);" hidden>
                                                <a class="btn btn-warning" id="btnOpenEdit_<?php echo e($cont); ?>"
                                                    onclick="openEdit(<?php echo e($cont); ?>)"><i
                                                        class='bx bx-sm bx-edit-alt'></i></a>
                                            </td>
                                        </tr>
                                        <input type="hidden" id="codTesis_<?php echo e($cont); ?>"
                                            value="<?php echo e($ta[0]['cod_tesis']); ?>">
                                        <?php
                                            $cont++;
                                        ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <input type="hidden" name="saveJurados" id="saveJurados">
                                </tbody>
                            </table>

                            <div class="row">
                                <div class="col-5">
                                    <input class="btn btn-success" type="submit" value="Guardar Edicion"
                                    id="saveAsignacion" hidden>
                                </div>

                            </div>
                            <a href="<?php echo e(route('user_information')); ?>" class="btn btn-danger">Volver</a>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script type="text/javascript">
        function validarSeleccion(cont) {
            const selector1 = document.getElementById('cbo1Jurado_' + cont);
            const selector2 = document.getElementById('cbo2Jurado_' + cont);
            const selector3 = document.getElementById('cboVocal_' + cont);
            const selector4 = document.getElementById('cbo4Jurado_' + cont);
            index1 = document.getElementById('cbo1Jurado_' + cont).selectedIndex;
            index2 = document.getElementById('cbo2Jurado_' + cont).selectedIndex;
            index3 = document.getElementById('cboVocal_' + cont).selectedIndex;
            index4 = document.getElementById('cbo4Jurado_' + cont).selectedIndex;
            if (index1 != 0) {
                selector1.style.backgroundColor = 'lightyellow';
            }
            if (index2 != 0) {
                selector2.style.backgroundColor = 'lightyellow';
            }
            if (index3 != 0) {
                selector3.style.backgroundColor = 'lightyellow';
            }
            if (index4 != 0) {
                selector4.style.backgroundColor = 'lightyellow';
            }
            if (index1 != 0 && index2 != 0 && index3 != 0 && index4 != 0) {
                document.getElementById('btnValidar_'+cont).hidden = false;
            }
        }


        var arregloJurados = []

        function guardarJurados(cont) {
            if(document.getElementById('cbo1Jurado_' + cont).selectedIndex ==0 || document.getElementById('cbo2Jurado_' + cont).selectedIndex == 0 || document.getElementById('cboVocal_' + cont).selectedIndex == 0 || document.getElementById('cbo4Jurado_' + cont).selectedIndex == 0){
                alert("Debe seleccionar un jurado!");
                return;
            }
            const selector1 = document.getElementById('cbo1Jurado_' + cont);
            const selector2 = document.getElementById('cbo2Jurado_' + cont);
            const selector3 = document.getElementById('cboVocal_' + cont);
            const selector4 = document.getElementById('cbo4Jurado_' + cont);
            jurado1 = document.getElementById('cbo1Jurado_' + cont).value;
            jurado2 = document.getElementById('cbo2Jurado_' + cont).value;
            jurado3 = document.getElementById('cboVocal_' + cont).value;
            jurado4 = document.getElementById('cbo4Jurado_' + cont).value;

            if(jurado1 == jurado2 || jurado1 == jurado3 || jurado1 == jurado4 || jurado2 == jurado3 || jurado2 == jurado4 || jurado3 == jurado4){
                alert("No se deben repetir los jurados.");
                return;
            }

            codTesis = document.getElementById('codTesis_' + cont).value;

            arregloJurados[cont] = codTesis + '_' + jurado1 + '_' + jurado2 + '_' + jurado3 + '_' + jurado4;
            document.getElementById('saveJurados').value = arregloJurados;
            document.getElementById("saveAsignacion").hidden = false;
            selector1.style.backgroundColor = 'lightgreen';
            selector2.style.backgroundColor = 'lightgreen';
            selector3.style.backgroundColor = 'lightgreen';
            selector4.style.backgroundColor = 'lightgreen';
            document.getElementById('btnDeleteAsignar_' + cont).hidden = false;

        }

        function openEdit(cont) {
            document.getElementById('cbo1Jurado_' + cont).disabled = false;
            document.getElementById('cbo2Jurado_' + cont).disabled = false;
            document.getElementById('cboVocal_' + cont).disabled = false;
            document.getElementById('cbo4Jurado_' + cont).disabled = false;
            document.getElementById('btnOpenEdit_' + cont).hidden = true;
        }
    </script>

    <?php if(session('datos') == 'okedit'): ?>
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Editado correctamente',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    <?php elseif(session('datos') == 'oknotedit'): ?>
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error al editar',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usuario\Desktop\UNT\Escuela_Contabilidad\ProyectoActualizado\sistema-tesis-upao-unt\resources\views/cursoTesis20221/director/evaluacion/editarAsignacionJurados.blade.php ENDPATH**/ ?>