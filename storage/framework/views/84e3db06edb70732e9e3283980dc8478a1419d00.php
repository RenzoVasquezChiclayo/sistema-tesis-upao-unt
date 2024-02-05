
<?php $__env->startSection('titulo'); ?>
    Registrar Jurado
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contenido'); ?>
    <div class="card-header">
        Registrar Jurado
    </div>
    <div class="card-body" style="text-align: start;">
        <div class="row">
            <form id="formJurado" name="formJurado" action="<?php echo e(route('director.registrarJurado')); ?>" method="post">
                <?php echo csrf_field(); ?>
                <div class="row mb-3">
                    <div class="col-12 col-lg-6">
                        <label class="ms-1">Buscar asesor</label>
                        <div class="input-group">
                            <input id="codeAsesor" type="text" class="form-control" placeholder="Código del asesor"
                                aria-label="Código del asesor" aria-describedby="btnSearch">
                            <button class="btn btn-outline-secondary" type="button" id="btnSearch"
                                onclick="buscarAsesor();">Buscar</button>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <label class="ms-1">Asesor</label>
                        <select name="selectAsesor" id="selectAsesor" class="form-control">
                            <option value="0">-</option>
                            <?php $__currentLoopData = $asesores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $asesor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($asesor->cod_docente); ?>"><?php echo e($asesor->apellidos. ' ' .$asesor->nombres); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-lg-6">
                        <label class="ms-1">Linea de investigacion</label>
                        <select name="selectTInvestigacion" id="selectTInvestigacion" class="form-control">
                            <option value="0">-</option>
                            <?php $__currentLoopData = $tipoInvestigacion; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tInvest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($tInvest->cod_tinvestigacion); ?>"><?php echo e($tInvest->descripcion); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-6 col-lg-3">
                        <label for="">Fecha de la solicitud</label>
                        <input class="form-control" type="date" name="fechaActual" id="fechaActual" disabled>
                    </div>

                </div>
                <div class="row d-flex mb-3">
                    <div class="col-auto">
                        <button type="button" class="btn btn-secondary">Cancelar</button>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn btn-success" onclick="tryToSend();">Registrar como jurado</button>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <table class="table">
                            <thead>
                                <tr>
                                    <td>Codigo docente</td>
                                    <td>Nombres y apellidos</td>
                                    <td>Linea de Investigacion</td>
                                    <td>Fecha de inicio</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $jurados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jurado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($jurado->cod_docente); ?></td>
                                        <td><?php echo e($jurado->apellidos . ' ' .$jurado->nombres); ?></td>
                                        <td><?php echo e($jurado->descripcion); ?></td>
                                        <td><?php echo e($jurado->created_at); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
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
                title: 'Jurado registrado correctamente',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    <?php elseif(session('datos') == 'oknot'): ?>
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Ha ocurrido un error. Intentelo denuevo.',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    <?php endif; ?>
    <script type="text/javascript">
        const asesores = <?php echo json_encode($asesores, 15, 512) ?>;
        console.log(`asesores: ${asesores}`)
        //fecha
        let fechaActual = new Date();
        let formatoFecha = [
            fechaActual.getFullYear(),
            ('0' + (fechaActual.getMonth() + 1)).slice(-2),
            ('0' + fechaActual.getDate()).slice(-2)
        ].join('-');
        document.getElementById('fechaActual').value = formatoFecha;

        function buscarAsesor() {
            const codeAsesor = document.getElementById('codeAsesor').value;
            console.log(`codAsesor: ${codeAsesor}`);
            let asesorFound = null;
            asesores.forEach(e => {
                if (e.cod_docente == codeAsesor) {
                    asesorFound = e;
                }
            })
            console.log(`asesorFound: ${asesorFound}`);
            const selectAsesor = document.getElementById('selectAsesor');
            selectAsesor.value = asesorFound.cod_docente;
        }

        function tryToSend() {
            const asesor = document.getElementById('selectAsesor').value;
            const dinvestigacion = document.getElementById('selectTInvestigacion').value;
            if (asesor == 0 || dinvestigacion == 0) {
                return false;
            }
            document.formJurado.submit();
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usuario\Desktop\UNT\Escuela_Contabilidad\ProyectoActualizado\sistema-tesis-upao-unt\resources\views/cursoTesis20221/director/evaluacion/registrarJurado.blade.php ENDPATH**/ ?>