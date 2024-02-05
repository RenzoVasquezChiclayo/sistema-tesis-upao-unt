<?php $__env->startSection('titulo'); ?>
    Asignar Asesor
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contenido'); ?>
<div class="card-header">
    Asignar asesor por grupos para tesis
</div>
<div class="card-body">
    <div class="row" style="display:flex; align-items:right; justify-content:right; margin-bottom:10px; margin-top:10px;">
        <div class="col col-sm-8 col-md-6 col-lg-4 col-xl-3">
            <form id="listAlumno" name="listAlumno" method="get">
                <div class="input-group">
                    <input type="text" class="form-control" name="buscarAlumno" placeholder="Código de matricula o Apellidos" value="<?php echo e($buscarAlumno); ?>" aria-describedby="btn-search">
                    <button class="btn btn-outline-primary" type="submit" id="btn-search">Buscar</button>
                </div>
            </form>
        </div>
    </div>
    <form action="<?php echo e(route('director.saveAsesorAsignadoGruposTesis')); ?>" method="post">
        <?php echo csrf_field(); ?>
        <div class="row mb-3" style="text-align:left; justify-content:flex-start">
            <div class="flex-container" style="display:flex;">
                <div style="margin:5px;">
                    <a href="<?php echo e(route('director.editAsignacionAsesorTesis')); ?>" class="btn btn-modificaciones">Editar Asignacion</a>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table id="table-proyecto" class="table table-striped table-responsive-md">
                <thead>
                    <tr>
                        <td>Numero de grupo</td>
                        <td colspan="2" style="text-align: center;">Estudiante</td>
                        <td>Asignar</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $cont = 0;
                        $lastGroup = 0;
                    ?>
                    <?php $__currentLoopData = $studentforGroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grupo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($grupo[0]->num_grupo); ?></td>
                            <td colspan="2">
                                <table class="table table-borderless mb-0">
                                    <tbody>
                                    <?php $__currentLoopData = $grupo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($g->cod_matricula); ?></td>
                                            <td><?php echo e($g->apellidos.' '.$g->nombres); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </td>

                            <td>
                                <select name="cboAsesor_<?php echo e($cont); ?>" id="cboAsesor_<?php echo e($cont); ?>" class="form-control" onchange="validarSeleccion(<?php echo e($cont); ?>);"
                                <?php if($grupo[0]->cod_docente_tesis != null): ?>
                                    disabled
                                <?php endif; ?>
                                >
                                    <option value="0">-</option>
                                    <?php $__currentLoopData = $asesores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($ase->cod_docente); ?>"
                                        <?php if($grupo[0]->cod_docente_tesis == $ase->cod_docente): ?>
                                            selected
                                        <?php endif; ?>
                                        ><?php echo e($ase->nombres." ".$ase->apellidos); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </td>
                            <td>
                                <input  class="btn btn-success" id="btnAsesor_<?php echo e($cont); ?>" type="button" value="+" onclick="guardarAsesor(<?php echo e($cont); ?>);" hidden>
                                <input type="button" class="btn" style="color:white; background-color: rgb(219, 98, 98)" value="-" id="btnDeleteAsignar_<?php echo e($cont); ?>" onclick="deleteAsignacion(<?php echo e($cont); ?>);" hidden>
                            </td>
                        </tr>
                        <input type="hidden" id="codEst_<?php echo e($cont); ?>_grupo" value="<?php echo e($grupo[0]->id_grupo); ?>">
                        <?php
                            $cont++;
                        ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <input type="hidden" name="saveAsesor" id="saveAsesor">

                </tbody>
            </table>
            <?php echo e($studentforGroups->links()); ?>

        </div>
        <div class="row" style="margin: 10px;">
            <div class="col-12" style="text-align: right;">
                <input class="btn btn-success" type="submit" value="Guardar registro" id="saveAsignacion" hidden>
            </div>
        </div>
    </form>
</div>




<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        var arregloAsesor = [];
            function validarSeleccion(cont){
                const selector = document.getElementById('cboAsesor_'+cont);
                index = document.getElementById('cboAsesor_'+cont).selectedIndex;
                if (index!=0) {
                    document.getElementById("btnAsesor_"+cont).hidden=false;
                    selector.style.backgroundColor='lightyellow';
                }else {
                    document.getElementById("btnAsesor_"+cont).hidden=true;

                }
            }
            //CAMBIAR

            function guardarAsesor(cont){
                const selector = document.getElementById('cboAsesor_'+cont);
                asesor = document.getElementById('cboAsesor_'+cont).value;

                groupStudent = document.getElementById('codEst_'+cont+'_grupo').value;

                arregloAsesor[cont] = groupStudent+'_'+asesor;

                document.getElementById('saveAsesor').value = arregloAsesor;

                document.getElementById("saveAsignacion").hidden=false;
                selector.style.backgroundColor='lightgreen';
                document.getElementById('btnDeleteAsignar_'+cont).hidden=false;

            }

            //Cambio
            function deleteAsignacion(cont){
                const selector = document.getElementById('cboAsesor_'+cont);
                document.getElementById('cboAsesor_'+cont).selectedIndex = 0;
                arregloAsesor[cont] = "";
                document.getElementById("btnAsesor_"+cont).hidden=true;
                document.getElementById('btnDeleteAsignar_'+cont).hidden=true;
                selector.style.backgroundColor='white';
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

<?php echo $__env->make('plantilla.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usuario\Desktop\UNT\Escuela_Contabilidad\ProyectoActualizado\sistema-tesis-upao-unt\resources\views/cursoTesis20221/director/tesis/asignarAsesorGruposTesis.blade.php ENDPATH**/ ?>