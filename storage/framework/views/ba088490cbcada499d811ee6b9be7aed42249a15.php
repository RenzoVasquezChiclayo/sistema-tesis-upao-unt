<?php $__env->startSection('titulo'); ?>
    Editar Asignacion
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contenido'); ?>
<div class="row">
    <div class="col-12">
        <div class="row" style="display: flex; align-items:center;">
            <div class="col-12">
                <h1>EDITAR ASIGNACION DE ASESOR DE TESIS</h1>
                <form action="<?php echo e(route('director.saveEditarAsignacion')); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <table id="table-proyecto" class="table table-striped table-responsive-md">
                        <thead>
                            <tr>
                                <td>Numero Matricula</td>
                                <td>DNI</td>
                                <td>Nombre</td>
                                <td>Asignar</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $cont = 0;
                            ?>
                            <?php $__currentLoopData = $studentforGroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grupo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($grupo[0]->num_grupo); ?></td>
                                <td><?php if(count($grupo)>1): ?><?php echo e($grupo[0]->apellidos.' '.$grupo[0]->nombres.' & '.$grupo[1]->apellidos.' '.$grupo[1]->nombres); ?><?php else: ?><?php echo e($grupo[0]->apellidos.' '.$grupo[0]->nombres); ?><?php endif; ?></td>

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
                                            ><?php echo e($ase->nombres); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </td>
                                <td>
                                    <input  class="btn btn-success" id="btnAsesor_<?php echo e($cont); ?>" type="button" value="+" onclick="guardarAsesor(<?php echo e($cont); ?>);" hidden>
                                </td>
                                <?php if($grupo[0]->cod_docente_tesis != null): ?>
                                        <td><a class="btn btn-warning" id="btnOpenEdit_<?php echo e($cont); ?>" onclick="openEdit(<?php echo e($cont); ?>)"><i class='bx bx-sm bx-edit-alt'></i></a></td>
                                <?php endif; ?>
                            </tr>
                            <input type="hidden" id="codEst_<?php echo e($cont); ?>_grupo" value="<?php echo e($grupo[0]->id_grupo); ?>">
                            <?php
                                $cont++;
                            ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <input type="hidden" name="saveAsesor" id="saveAsesor">
                            <input type="hidden" id="cantidadEstudiantes" value="<?php echo e(count($estudiantes)); ?>">
                        </tbody>
                    </table>

                    <div class="row" >
                        <input class="btn btn-success" type="submit" value="Guardar Edicion" id="saveAsignacion" hidden>

                    </div>
                </form>
                    <div>
                        <?php echo e($studentforGroups->links()); ?>

                    </div>
            </div>
        </div>

    </div>
</div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script type="text/javascript">
    function validarSeleccion(cont){

    index = document.getElementById('cboAsesor_'+cont).selectedIndex;

    if (index!=0) {

        document.getElementById("btnAsesor_"+cont).hidden=false;
    }else {
        document.getElementById("btnAsesor_"+cont).hidden=true;
    }
    }

    var arregloAsesor = []
    function guardarAsesor(cont){

    asesor = document.getElementById('cboAsesor_'+cont).value;

    idGrupo = document.getElementById(`codEst_${cont}_grupo`).value;

    arregloAsesor[cont] = idGrupo+'_'+asesor;

    document.getElementById('saveAsesor').value = arregloAsesor;

    document.getElementById("saveAsignacion").hidden=false;
    document.getElementById("btnAsesor_"+cont).hidden=true;

    }

    function openEdit(cont){
    document.getElementById('cboAsesor_'+cont).disabled=false;
    document.getElementById('btnOpenEdit_'+cont).hidden=true;
    }
</script>

    <?php if(session('datos') == 'ok'): ?>
            <script>
                Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Editado correctamente',
                showConfirmButton: false,
                timer: 1200
                })
            </script>
    <?php elseif(session('datos') == 'oknot'): ?>
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

<?php echo $__env->make('plantilla.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usuario\Desktop\UNT\Escuela_Contabilidad\ProyectoActualizado\sistema-tesis-upao-unt\resources\views/cursoTesis20221/director/tesis/editarAsignarAsesor.blade.php ENDPATH**/ ?>