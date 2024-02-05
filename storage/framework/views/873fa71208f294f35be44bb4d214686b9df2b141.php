<?php $__env->startSection('titulo'); ?>
    Registrar Sustentacion
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <style type="text/css">

    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contenido'); ?>
    <div class="card-header">
        Registrar Sustentación
    </div>
    <div class="card-body">
        <div class="row justify-content-around align-items-center">
            
            <div class="row">
                <div style="margin:5px;">
                    <a href="" class="btn btn-modificaciones">Editar Sustentacion</a>
                </div>
            </div>
            <form action="" method="post">
                <?php echo csrf_field(); ?>
                <div class="row" style="display: flex; align-items:center;">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table id="table-proyecto" class="table table-striped table-responsive-md">
                                <thead>
                                    <tr>
                                        <td>Nº</td>
                                        <td>Nombres</td>
                                        <td>Titulo</td>
                                        <td>Asesor</td>
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
                                                    <p><?php echo e($autor['cod_matricula'].' - '.$autor['apellidosAutor'].', '.$autor['nombresAutor']); ?></p><br>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </td>
                                            <td><?php echo e($ta[0]['titulo']); ?></td>
                                            <td><?php echo e($ta[0]['apellidosAsesor']. ' ' .$ta[0]['nombresAsesor']); ?></td>
                                            <td>
                                                <?php if($ta->estadoSustentacion == null): ?>
                                                <a href=""><i class='bx bx-calendar-plus' ></i></a>
                                                <?php else: ?>
                                                    <?php if($ta->estadoSustentacion == 0): ?>
                                                        <a href=""><i class='bx bx-sm bxs-edit'></i></a>
                                                    <?php else: ?>
                                                        <a href=""><i class='bx bx-sm bx-show'></i></a>
                                                    <?php endif; ?>
                                                <?php endif; ?>
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
                        </div>

                    </div>
                </div>
                <div class="row" style="margin: 10px;">
                    <div class="col-12" style="text-align: right;">
                        <input class="btn btn-success" type="submit" value="Guardar registro" id="saveAsignacion" hidden>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php if(session('datos') == 'okdesignacion'): ?>
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Designacion correcta',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    <?php elseif(session('datos') == 'oknotdesignacion'): ?>
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error en la designacion',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    <?php elseif(session('datos') == 'exists'): ?>
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Ya existe un alumno con el mismo codigo de matricula',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    <?php endif; ?>

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

        function deleteAsignacion(cont) {
            const selector1 = document.getElementById('cbo1Jurado_' + cont);
            const selector2 = document.getElementById('cbo2Jurado_' + cont);
            const selector3 = document.getElementById('cboVocal_' + cont);
            const selector4 = document.getElementById('cbo4Jurado_' + cont);

            document.getElementById('cbo1Jurado_' + cont).selectedIndex = 0;
            document.getElementById('cbo2Jurado_' + cont).selectedIndex = 0;
            document.getElementById('cboVocal_' + cont).selectedIndex = 0;
            document.getElementById('cbo4Jurado_' + cont).selectedIndex = 0;
            arregloJurados[cont] = "";
            document.getElementById("btnValidar_" + cont).hidden = true;
            document.getElementById('btnDeleteAsignar_' + cont).hidden = true;
            selector1.style.backgroundColor = 'white';
            selector2.style.backgroundColor = 'white';
            selector3.style.backgroundColor = 'white';
            selector4.style.backgroundColor = 'white';
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usuario\Desktop\UNT\Escuela_Contabilidad\ProyectoActualizado\sistema-tesis-upao-unt\resources\views/cursoTesis20221/director/sustentacion/registrarSustentacion.blade.php ENDPATH**/ ?>