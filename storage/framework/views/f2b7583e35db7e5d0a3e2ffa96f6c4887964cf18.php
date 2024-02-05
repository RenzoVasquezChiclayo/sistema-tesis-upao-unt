
<?php $__env->startSection('titulo'); ?>
    Reportes
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contenido'); ?>
    <h1>REPORTES</h1>
    <?php if(auth()->user()->rol == 'CTesis2022-1'): ?>
        <div class="row">
            <div class="col-3">
                <h4>% Avance Proyecto de Tesis</h4>
            </div>
            <div class="col-5">
                <div class="progress" role="progressbar" aria-label="Example with label" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar" style="width: <?php echo e($porcentaje); ?>%"><?php echo e((int)$porcentaje); ?>%</div>
                </div>
            </div>

        </div>
    <?php elseif(auth()->user()->rol == 'a-CTesis2022-1'): ?>
        <input type="hidden" name="Codigo_Avance_Asesor" id="Codigo_Avance_Asesor" value="<?php echo e($dato2); ?>">
        <input type="hidden" id="rol" value="a-CTesis2022-1">
        <div class="row">
            <div class="col-6">
                <table class="table" id="table-reportes">
                    <thead>
                      <tr>
                        <th scope="col">Codigo</th>
                        <th scope="col">Porcentaje de Avance</th>
                      </tr>
                    </thead>
                    <tbody>
                        <tr>
                        </tr>
                    </tbody>
                  </table>
            </div>
        </div>
    <?php elseif(auth()->user()->rol == 'd-CTesis2022-1'): ?>
        <div class="row">
            <div class="card text-bg-light mb-3" style="max-width: 18rem; margin-left: 5px;">
                <div class="card-header">Total Estudiantes</div>
                <div class="card-body" style="text-align: center">
                    <h2 class="card-title"><?php echo e($totalEstudiantes); ?></h2>
                </div>
            </div>
            <div class="card text-bg-light mb-3" style="max-width: 18rem; margin-left: 5px;">
                <div class="card-header">Total Asesores</div>
                <div class="card-body" style="text-align: center">
                    <h2 class="card-title"><?php echo e($totalAsesores); ?></h2>
                </div>
            </div>
        </div>
        <input type="hidden" name="Codigo_Avance" id="Codigo_Avance" value="<?php echo e($dato); ?>">
        <input type="hidden" id="rol" value="d-CTesis2022-1">
        <div class="row">
            <div class="col-6">
                <h2 style="text-align: center">Avances Proyecto de Tesis</h2>
                <form action="<?php echo e(route('director.descargar-reporteProyT')); ?>" method="get" id="form-reporteProyT">
                    <table class="table" id="table-reportes">
                        <thead>
                          <tr>
                            <th scope="col">Codigo</th>
                            <th scope="col">Porcentaje de Avance</th>
                          </tr>
                        </thead>
                        <tbody>
                            <tr>
                            </tr>
                        </tbody>
                      </table>
                      <div class="row">
                        <div class="col-4">
                            <input type="submit" class="btn btn-success" value="Descargar">
                        </div>
                    </div>
                </form>
            </div>

        </div>
        <?php endif; ?>




<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <script src="./js/myjs.js"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usuario\Desktop\UNT\Escuela_Contabilidad\ProyectoActualizado\sistema-tesis-upao-unt\resources\views/cursoTesis20221/reportes/listaReportes.blade.php ENDPATH**/ ?>