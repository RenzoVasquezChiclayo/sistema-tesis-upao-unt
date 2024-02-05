<?php $__env->startSection('titulo'); ?>
    Editar Asesor y Docente
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contenido'); ?>
    <div class="card-header">
        Editar Asesor y Docente
    </div>
    <div class="card-body">
        <div class="row justify-content-around align-items-center">
            <div class="row border-box">
                <form id="formEditAsesor" action="<?php echo e(route('director.editAsesor')); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <div class="row justify-content-around align-items-center">
                        <div class="col-4">
                            <label for="cod_docente">Codigo Institucional</label>
                            <input class="form-control" minlength="4" maxlength="4" type="text" id="cod_docente"
                                name="cod_docente" value="<?php echo e($asesor[0]->cod_docente); ?>" readonly>
                        </div>
                        <div class="col-4">
                            <label for="orcid">ORCID</label>
                            <input class="form-control" minlength="19" maxlength="20" type="text" id="orcid"
                                name="orcid" placeholder="Ingrese su codigo ORCID" value="<?php echo e($asesor[0]->orcid); ?>"
                                required>
                        </div>
                    </div>
                    <div class="row justify-content-around align-items-center">
                        <div class="col-md-4">
                            <label for="nombres">Nombres</label>
                            <input class="form-control" type="text" id="nombres" name="nombres"
                                value="<?php echo e($asesor[0]->nombres); ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label for="apellidos">Apellidos</label>
                            <input class="form-control" type="text" id="apellidos" name="apellidos"
                                value="<?php echo e($asesor[0]->apellidos); ?>" required>
                        </div>
                        <div class="col-md-3">
                            <label for="gradoAcademico">Grado Academico</label>
                            <select class="form-control" name="gradAcademico" id="gradAcademico" required>
                                <?php $__currentLoopData = $grados_academicos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g_a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($g_a->cod_grado_academico); ?>"
                                        <?php if($g_a->cod_grado_academico == $asesor[0]->cod_grado_academico): ?> selected <?php endif; ?>><?php echo e($g_a->descripcion); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="row justify-content-around align-items-center">
                        <div class="col-md-3">
                            <label for="categoria">Categoria</label>
                            <select class="form-control" name="categoria" id="categoria" required>
                                <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($c->cod_categoria); ?>"
                                        <?php if($c->cod_categoria == $asesor[0]->cod_categoria): ?> selected <?php endif; ?>><?php echo e($c->descripcion); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="nombres">Direccion</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="direccion" name="direccion" maxlength="30"
                                    value="<?php echo e($asesor[0]->direccion); ?>">
                                <span class="input-group-text" id="contador-caracteres">0/30</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="correo">Correo</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="correo" name="correo"
                                    value="<?php echo e($asesor[0]->correo); ?>" maxlength="80">
                            </div>
                        </div>
                    </div>

                    <div class="col-12" style="margin-top: 10px;">
                        <button class="btn btn-success" type="button" onclick="editAsesor(this);">Guardar</button>
                        <a href="<?php echo e(route('user_information')); ?>" type="button" class="btn btn-danger">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php if(session('datos') == 'oknot'): ?>
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
        const inputDireccion = document.querySelector('#direccion');
        const contadorCaracteres = document.querySelector('#contador-caracteres');

        inputDireccion.addEventListener('input', () => {
            contadorCaracteres.textContent = `${inputDireccion.value.length}/30`;
        });

        function editAsesor(form) {
            if(!verifyFields()){
                alert("Completa los campos requeridos.");
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
                    form.closest('#formEditAsesor').submit();
                }
            })

        }


        function verifyFields(){
            const orcid = document.getElementById("orcid");
            const nombres = document.getElementById("nombres");
            const apellidos = document.getElementById("apellidos");
            const gradoAcademico = document.getElementById("gradAcademico");
            const categoria = document.getElementById("categoria");
            const direccion = document.getElementById("direccion");
            const correo = document.getElementById("correo");
            if(orcid.value == ""){
                return false;
            }
            if(nombres.value == ""){
                return false;
            }
            if(apellidos.value == ""){
                return false;
            }
            if(gradoAcademico.value.selectedIndex == -1){
                return false;
            }
            if(categoria.value == ""){
                return false;
            }
            if(direccion.value == ""){
                return false;
            }
            if(correo.value == ""){
                return false;
            }
            return true;
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usuario\Desktop\UNT\Escuela_Contabilidad\ProyectoActualizado\sistema-tesis-upao-unt\resources\views/cursoTesis20221/director/editarAsesor.blade.php ENDPATH**/ ?>