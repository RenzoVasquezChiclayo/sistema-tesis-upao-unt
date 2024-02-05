
<?php $__env->startSection('titulo'); ?>
    Generalidades
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <style type="text/css">

    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contenido'); ?>

    <div class="card-header">
        Generalidades
    </div>
    <div class="card-body">
        <div class="row justify-content-around align-items-center">
            <div class="col-11">
                <form action="<?php echo e(route('director.saveDatosGenerales')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Escuela</h5>
                            <select class="form-select" name="escuela" id="escuela">
                                <?php $__currentLoopData = $escuela; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $esc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($esc->cod_escuela); ?>"><?php echo e($esc->nombre); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <h5>Semestre academico</h5>
                            <select class="form-select" name="semestre_academico" id="semestre_academico" required>
                                <option value="2023-I">2023-I</option>
                                <option value="2023-II">2023-II</option>
                            </select>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 20px;">
                        <div class="col-md-4">
                            <div class="card text-center shadow bg-white rounded">
                                <div class="card-body">
                                    <h5 class="card-title">Linea de Investigacion</h5>
                                    <div class="row">
                                        <div>
                                            <div class="table-responsive">
                                                <table class="table table-warning" id="table_linea_investigacion"
                                                    style="font-size: 13px;">
                                                    <?php if(sizeof($linea_investigacion) > 0): ?>
                                                        <?php
                                                            $indice_l_i = 0;
                                                        ?>
                                                        <?php $__currentLoopData = $linea_investigacion; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l_i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tbody>
                                                                <tr id="filal_i<?php echo e($indice_l_i); ?>">
                                                                    <td><?php echo e($l_i->cod_tinvestigacion); ?></td>
                                                                    <td><?php echo e($l_i->descripcion); ?></td>
                                                                    <td style=" text-align:center;">
                                                                        <a href="#" id="l_i-<?php echo e($indice_l_i); ?>"
                                                                            class="btn btn-warning"
                                                                            onclick="remover_vieja_gen(this);">-</a>
                                                                        <input type="hidden" id="xl_i-<?php echo e($indice_l_i); ?>"
                                                                            value="<?php echo e($l_i->cod_tinvestigacion); ?>">

                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                            <?php
                                                                $indice_l_i++;
                                                            ?>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>
                                                    <input type="hidden" id="valNl_i"
                                                        value="<?php echo e(sizeof($linea_investigacion)); ?>">
                                                    <input type="hidden" name="listOldl_i" id="listOldl_i">
                                                </table>
                                            </div>
                                            <div class="row justify-content-center">
                                                <div class="col-lg-4">
                                                    <h6>Codigo:</h6>
                                                    <input class="form-control" minlength="4" maxlength="4" type="text"
                                                        name="cod_linea_investigacion" id="cod_linea_investigacion"
                                                        autofocus>
                                                </div>
                                                <div class="col-lg-8">
                                                    <h6>Descripcion:</h6>
                                                    <input class="form-control" type="text" name="linea_investigacion"
                                                        id="linea_investigacion">
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <input class="btn btn-success" id="btnAsesor_" type="button" value="+"
                                                onclick="agregar_linea_inv();">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-4">
                            <div class="card text-center shadow bg-white rounded">
                                <div class="card-body">
                                    <h5 class="card-title">De acuerdo al fin que persigue</h5>
                                    <div class="row">
                                        <div>
                                            <div class="table-responsive">
                                                <table class="table table-warning" id="table_fin_persigue"
                                                style="font-size: 13px;">
                                                <?php if(sizeof($fin_persigue) > 0): ?>
                                                    <?php
                                                        $indice_f_p = 0;
                                                    ?>
                                                    <?php $__currentLoopData = $fin_persigue; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f_p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tbody>
                                                            <tr id="filaf_p<?php echo e($indice_f_p); ?>">
                                                                <td><?php echo e($f_p->descripcion); ?></td>
                                                                <td style=" text-align:center;">
                                                                    <a href="#" id="f_p-<?php echo e($indice_f_p); ?>"
                                                                        class="btn btn-warning"
                                                                        onclick="remover_vieja_gen(this);">-</a>
                                                                    <input type="hidden" id="xf_p-<?php echo e($indice_f_p); ?>"
                                                                        value="<?php echo e($f_p->cod_fin_persigue); ?>">
                                                            </tr>
                                                        </tbody>
                                                        <?php
                                                            $indice_f_p++;
                                                        ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endif; ?>
                                                <input type="hidden" id="valNf_p" value="<?php echo e(sizeof($fin_persigue)); ?>">
                                                <input type="hidden" name="listOldf_p" id="listOldf_p">
                                            </table>
                                            </div>
                                            <h6>Descripcion:</h6>
                                            <input class="form-control" type="text" name="fin_persigue"
                                                id="fin_persigue">

                                        </div>
                                        <div>
                                            <input class="btn btn-success" id="btnAsesor_" type="button" value="+"
                                                onclick="agregar_fin_persigue();">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-4">
                            <div class="card text-center shadow bg-white rounded">
                                <div class="card-body">
                                    <h5 class="card-title">De acuerdo al diseño de investigacion</h5>
                                    <div class="row">
                                        <div>
                                            <div class="table-responsive">
                                                <table class="table table-warning" id="table_diseno_investigacion"
                                                style="font-size: 13px;">
                                                <?php if(sizeof($diseno_investigacion) > 0): ?>
                                                    <?php
                                                        $indice_d_i = 0;
                                                    ?>
                                                    <?php $__currentLoopData = $diseno_investigacion; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d_i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tbody>
                                                            <tr id="filad_i<?php echo e($indice_d_i); ?>">
                                                                <td><?php echo e($d_i->descripcion); ?></td>
                                                                <td style=" text-align:center;">
                                                                    <a href="#" id="d_i-<?php echo e($indice_d_i); ?>"
                                                                        class="btn btn-warning"
                                                                        onclick="remover_vieja_gen(this);">-</a>
                                                                    <input type="hidden" id="xd_i-<?php echo e($indice_d_i); ?>"
                                                                        value="<?php echo e($d_i->cod_diseno_investigacion); ?>">
                                                            </tr>
                                                        </tbody>
                                                        <?php
                                                            $indice_d_i++;
                                                        ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endif; ?>
                                                <input type="hidden" id="valNd_i"
                                                    value="<?php echo e(sizeof($diseno_investigacion)); ?>">
                                                <input type="hidden" name="listOldd_i" id="listOldd_i">
                                            </table>
                                            </div>
                                            <h6>Descripcion:</h6>
                                            <input class="form-control" type="text" name="diseno_investigacion"
                                                id="diseno_investigacion">
                                        </div>
                                        <div>
                                            <input class="btn btn-success" id="btnAsesor_" type="button" value="+"
                                                onclick="agregar_diseno_investigacion();">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="row justify-content-center" style="margin: 30px;">
                        <div class="col-md-4">
                            <input class="btn btn-success" type="submit" value="Guardar todo">
                        </div>
                    </div>
                </form>

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
                title: 'Datos guardados correctamente',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    <?php elseif(session('datos') == 'oknot'): ?>
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error al guardar los datos',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    <?php endif; ?>
    <script type="text/javascript">
        var indicel_i = 0;
        var indicef_p = 0;
        var indiced_i = 0;
        const valOldl_i = document.getElementById('valNl_i').value;
        if (valOldl_i != 0) {
            indicel_i = parseInt(valOldl_i);
        }

        function agregar_linea_inv() {
            linea_investigacion = document.getElementById('linea_investigacion').value;
            cod_linea_investigacion = document.getElementById('cod_linea_investigacion').value;
            fila = '<tbody><tr id="filal_i' + indicel_i + '"><td>' + cod_linea_investigacion +
                '</td><td><input type="hidden" name="id_linea_investigacion[]" value="' + cod_linea_investigacion + '_' +
                linea_investigacion + '">' + linea_investigacion +
                '</td><td><input  class="btn btn-danger" id="btnAsesor_" type="button" value="-" onclick="remover_linea_inv(' +
                indicel_i + ');"></td></tr></tbody>'
            document.getElementById('table_linea_investigacion').innerHTML += fila;
            document.getElementById('linea_investigacion').value = "";
            document.getElementById('cod_linea_investigacion').value = "";
            indicel_i++;
        }

        function remover_linea_inv(indice) {
            document.getElementById('filal_i' + indice).remove();

        }

        function remover_vieja_gen(item) {
            const iditem = item.id;

            const idindice = iditem.split("-");
            let code = document.getElementById('x' + iditem).value;
            if (document.getElementById('listOld' + idindice[0]).value == "") {
                document.getElementById('listOld' + idindice[0]).value = code;
            } else {
                document.getElementById('listOld' + idindice[0]).value += "," + code;
            }
            if (idindice[0] == 'l_i') {
                document.getElementById('filal_i' + idindice[1]).remove();
            } else if (idindice[0] == 'f_p') {
                document.getElementById('filaf_p' + idindice[1]).remove();
            } else if (idindice[0] == 'd_i') {
                document.getElementById('filad_i' + idindice[1]).remove();
            }
        }

        function agregar_fin_persigue() {
            fin_persigue = document.getElementById('fin_persigue').value;
            fila = '<tbody><tr id="filaf_p' + indicef_p + '"><td><input type="hidden" name="id_fin_persigue[]" value="' +
                fin_persigue + '">' + fin_persigue +
                '</td><td><input  class="btn btn-danger" id="btnAsesor_" type="button" value="-" onclick="remover_fin_persigue(' +
                indicef_p + ');"></td></tr></tbody>'
            document.getElementById('table_fin_persigue').innerHTML += fila;
            document.getElementById('fin_persigue').value = "";
            indicef_p++;
        }

        function remover_fin_persigue(indice) {
            document.getElementById('filaf_p' + indice).remove();

        }

        function agregar_diseno_investigacion() {
            diseno_investigacion = document.getElementById('diseno_investigacion').value;
            fila = '<tbody><tr id="filad_i' + indiced_i +
                '"><td><input type="hidden" name="id_diseno_investigacion[]" value="' + diseno_investigacion + '">' +
                diseno_investigacion +
                '</td><td><input  class="btn btn-danger" id="btnAsesor_" type="button" value="-" onclick="remover_dis_inves(' +
                indiced_i + ');"></td></tr></tbody>'
            document.getElementById('table_diseno_investigacion').innerHTML += fila;
            document.getElementById('diseno_investigacion').value = "";
            indiced_i++;
        }

        function remover_dis_inves(indice) {
            document.getElementById('filad_i' + indice).remove();

        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usuario\Desktop\UNT\Escuela_Contabilidad\ProyectoActualizado\sistema-tesis-upao-unt\resources\views/cursoTesis20221/director/actualizarGeneralidades.blade.php ENDPATH**/ ?>