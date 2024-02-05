<?php $__env->startSection('titulo'); ?>
    Editar Configuraciones Iniciales
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contenido'); ?>
    <div class="card-header">
        Editar Configuraciones Iniciales
    </div>
    <div class="card-body">
        <div class="row">
            <form id="form_edit_config" method="post" action="<?php echo e(route('admin.saveEditarconfiguraciones')); ?>">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="auxid" value="<?php echo e($find_configuracion->cod_config_ini); ?>">
                <div class="row">
                    <div class="col-xl-4">
                        <h5>Año</h5>
                        <select class="form-control" name="year" id="year">
                            <option value="0">-- Selecciona el año académico --</option>
                        </select>
                    </div>
                    <div class="col-xl-5">
                        <h5>Curso</h5>
                        <input class="form-control" type="text" placeholder="Nombre del curso" name="curso" id="curso"
                            value="<?php echo e($find_configuracion->curso); ?>" required>
                    </div>
                    <div class="col-xl-3">
                        <h5>Ciclo</h5>
                        <select class="form-control" name="ciclo" id="ciclo">
                            <option value="0">-- Selecciona el ciclo académico --</option>
                        </select>
                    </div>
                </div>
                <div class="row justify-content-around align-items-center" style="margin-top: 30px;">
                    <div class="col-4">
                        <input class="btn btn-success" type="button" value="Guardar" onclick="saveConfig(this);">
                    </div>

                </div>
            </form>

        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        function saveConfig(form) {
            if (!verifiyFields()) {
                alert("Existen campos pendientes.");
                return;
            }
            Swal.fire({
                title: 'Estas seguro?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, guardar!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.closest('#form_edit_config').submit();
                }
            })

        }

        function verifiyFields() {
            const year = document.getElementById('year').selectedIndex;
            const ciclo = document.getElementById('ciclo').selectedIndex;
            const curso = document.getElementById('curso').value.trim();
            if (year === 0) {
                return false;
            }
            if (ciclo === 0) {
                return false;
            }
            if (curso == "") {
                return false;
            }
            return true;
        }

        const configuracion = <?php echo json_encode($find_configuracion, 15, 512) ?>;
        console.log(configuracion);

        putListYears();
        putListCiclos();

        function putListYears() {
            const currentYear = new Date().getFullYear();

            const yearSelector = document.getElementById('year');
            for (let i = 0; i < 5; i++) {
                const optionYear = currentYear - i;
                const option = document.createElement('option');
                option.value = optionYear;
                option.text = optionYear;
                option.selected = (currentYear - i === parseInt(configuracion.year));
                yearSelector.add(option);
            }
        }

        function putListCiclos() {
            const cicloSelector = document.getElementById('ciclo');
            for (let i = 1; i <= 10; i++) {
                const option = document.createElement('option');
                option.value = i;
                option.text = i;
                option.selected = (i === configuracion.ciclo);
                cicloSelector.add(option);
            }
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usuario\Desktop\UNT\Escuela_Contabilidad\ProyectoActualizado\sistema-tesis-upao-unt\resources\views/cursoTesis20221/administrador/editar_configuraciones_iniciales.blade.php ENDPATH**/ ?>