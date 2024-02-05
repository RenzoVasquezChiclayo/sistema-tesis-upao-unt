<?php $__env->startSection('titulo'); ?>
    Informacion del usuario
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contenido'); ?>
    <div class="card text-center shadow bg-white rounded">
        <div class="card-header">
            Información de Usuario
        </div>
        <div class="card-body">
            <div class="row justify-content-around align-items-center" style="display: flex; align-items:center;">
                <div class="col-12 col-md-4">
                    <img class="img-fluid" src="/img/<?php echo e($img); ?>" alt="imagen de perfil"
                        style="width:300px;">
                </div>
                <div class="col-12 col-md-8">
                    <div class="row">
                        <div class="col-10 col-md-6" style="text-align: left">
                            <div class="mb-3">
                                <label for="user" class="form-label">Usuario</label>
                                <p><?php echo e(auth()->user()->name); ?></p>
                            </div>
                        </div>
                        <?php if(auth()->user()->rol == 'CTesis2022-1'): ?>
                            <div class="col-10 col-md-6" style="text-align: left; margin-bottom:15px;">
                                <h5>DNI</h5>
                                <p><?php echo e($estudiante->dni); ?></p>
                            </div>
                            <div class="col-10 col-md-6" style="text-align: left; margin-bottom:15px;">
                                <h5>Nombres</h5>
                                <p><?php echo e($estudiante->nombres); ?></p>
                            </div>
                            <div class="col-10 col-md-6" style="text-align: left; margin-bottom:15px;">
                                <h5>Apellidos</h5>
                                <p><?php echo e($estudiante->apellidos); ?></p>
                            </div>
                            <div class="col-10" style="text-align: left; margin-bottom:15px;">
                                <h5>Correo institucional</h5>
                                <?php if($estudiante->correo == null): ?>
                                    <p style="color: red">Si desea recibir notificaciones cuando su asesor y/o jurado realice observaciones, actualice su correo electrónico.</p>
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#mActualizarCorreo">Actualizar Correo</button>
                                <?php else: ?>
                                    <p><?php echo e($estudiante->correo); ?></p>
                                <?php endif; ?>

                            </div>
                        <?php elseif(auth()->user()->rol == 'a-CTesis2022-1'): ?>
                            <div class="col-10 col-md-6" style="text-align: left; margin-bottom:15px;">
                                <h5>ORCID</h5>
                                <p><?php echo e($asesor->orcid); ?></p>
                            </div>
                            <div class="col-10 col-md-10" style="text-align: left; margin-bottom:15px;">
                                <h5>Nombres</h5>
                                <p><?php echo e($asesor->nombres); ?></p>
                            </div>
                            <div class="col-10 col-md-6" style="text-align: left; margin-bottom:15px;">
                                <h5>Grado Academico</h5>
                                <p><?php echo e($asesor->DescGrado); ?></p>
                            </div>

                            <div class="col-10 col-md-6" style="text-align: left; margin-bottom:15px;">
                                <h5>Categoria</h5>
                                <p><?php echo e($asesor->DescCat); ?></p>
                            </div>
                            <div class="col-10 col-md-6" style="text-align: left; margin-bottom:15px;">
                                <h5>Direccion</h5>
                                <p><?php echo e($asesor->direccion); ?></p>
                            </div>
                            <div class="col-10 col-md-6" style="text-align: left; margin-bottom:15px;">
                                <h5>Correo</h5>
                                <?php if($asesor->correo == null): ?>
                                    <p style="color: red">Si desea recibir notificaciones cuando el estudiante actualice sus documentos, actualice su correo electrónico.</p>
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#mActualizarCorreo">Actualizar Correo</button>
                                <?php else: ?>
                                    <p><?php echo e($asesor->correo); ?></p>
                                <?php endif; ?>

                            </div>
                        <?php endif; ?>
                        <form id="formContrasena" action="<?php echo e(route('save_user')); ?>" method="post">
                            <?php echo csrf_field(); ?>
                            <div class="col-12" style="text-align: left;">
                                <h4>Modificaciones</h4>
                                <hr style="width:100%; border: 0.3px solid black;" />
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                    data-bs-target="#mActualizarContra">Actualizar Contraseña</button>
                            </div>
                            <input type="hidden" id="txtCodUsuario" name="txtCodUsuario"
                                value="<?php echo e(auth()->user()->name); ?>">
                            
                            <div class="modal" id="mActualizarContra">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Actualizar Contraseña</h4>
                                            <button type="button" class="btn-close"
                                                data-bs-dismiss="modal"></button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            <div class="row" style="padding: 20px">
                                                <div class="row my-2">
                                                    <div class="col-12 col-md-10"
                                                        style="text-align: left; margin-bottom:15px;">
                                                        <h5>Nueva contraseña</h5>
                                                        <input type="password" class="form-control"
                                                            name="txtNuevaContra" id="txtNuevaContra"
                                                            required>
                                                        <input type="hidden" id="older-password"
                                                            value="">
                                                    </div>
                                                    <div class="col-12 col-md-10"
                                                        style="text-align: left; margin-bottom:15px;">
                                                        <h5>Repetir nueva contraseña</h5>
                                                        <input type="password" class="form-control"
                                                            onchange="verificaContra();"
                                                            id="txtRepNuevaContra" name="txtRepNuevaContra"
                                                            required>
                                                        <span id="guardadoContra"></span>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                            <div class="row">
                                                <div class="col-6">
                                                    <input class="btn btn-success" type="submit"
                                                        id="btnEnvioPassword" value="Guardar">
                                                </div>
                                                <div class="col-6">
                                                    <button type="button" class="btn btn-danger"
                                                        data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </form>
                        <form action="<?php echo e(route('save_user_estudiante_asesor')); ?>" method="post">
                            <?php echo csrf_field(); ?>
                            
                            <div class="modal" id="mActualizarCorreo">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Actualizar Correo</h4>
                                            <button type="button" class="btn-close"
                                                data-bs-dismiss="modal"></button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            <div class="row" style="padding: 20px">
                                                <div class="row my-2">
                                                    <div class="col-12 col-md-10"
                                                        style="text-align: left; margin-bottom:15px;">
                                                        <?php if(auth()->user()->rol == 'CTesis2022-1'): ?>
                                                            <input type="hidden" id="txtCodEstudiante"
                                                                name="txtCodEstudiante"
                                                                value="<?php echo e($estudiante->cod_matricula); ?>">
                                                        <?php elseif(auth()->user()->rol == 'a-CTesis2022-1'): ?>
                                                            <input type="hidden" id="txtCodAsesor"
                                                                name="txtCodAsesor"
                                                                value="<?php echo e($asesor->cod_docente); ?>">
                                                        <?php endif; ?>
                                                        <h5>Correo</h5>
                                                        <input type="input" class="form-control"
                                                            id="correo" name="correo"
                                                            onchange="verificarCorreo();" required>
                                                        <span style="color: red"
                                                            id="mensaje_correo"></span>
                                                        <span id="guardadoCorreo"></span>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                            <div class="row">
                                                <div class="col-6">
                                                    <input id="btnEnvioCorreo" type="submit"
                                                        class="btn btn-success" value="Guardar" disabled>
                                                </div>
                                                <div class="col-6">
                                                    <button type="button" class="btn btn-danger"
                                                        data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>


                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="mAvisoPassword">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Aviso</h4>
                    <button type="button" class="btn-close" data-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row" style="padding: 20px">
                        <p>Se recomienda a los estudiantes, realizar la actualización de su contraseña para mayor seguridad.</p>
                    </div>

                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-6">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php if(session('datos') == 'okActualizacionTesis'): ?>
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Tesis actualizado correctamente.',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    <?php elseif(session('datos') == 'oknotActualizacionTesis'): ?>
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error al actualizar la información de la tesis.',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    <?php elseif(session('datos') == 'okActualizacionProyecto'): ?>
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Proyecto de tesis actualizado correctamente.',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    <?php elseif(session('datos') == 'oknotActualizacionProyecto'): ?>
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error al actualizar la información del proyecto de tesis.',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    <?php elseif(session('datos') == 'ok'): ?>
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Contraseña actulizada correctamente',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    <?php elseif(session('datos') == 'oknot'): ?>
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error al actulizar contraseña',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    <?php elseif(session('datos') == 'okCorreo'): ?>
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Correo actulizada correctamente',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    <?php elseif(session('datos') == 'oknotCorreo'): ?>
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error al agregar correo',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    <?php endif; ?>
    <script type="text/javascript">
        window.onload = function() {
            validateChanged();
        };

        // const get_user = document.getElementById("").value;
        // if(get_user!=""){

        // }

        function aviso() {
            var myModal = document.getElementById('mAvisoPassword');
            $('#mAvisoPassword').modal('show');
        }

        function validateChanged() {
            let usuario = document.getElementById('txtCodUsuario').value;
            let password = document.getElementById('older-password').value;
            if (usuario == password) {
                setTimeout(() => {
                    aviso();
                }, 800);
            }
        }


        function verificaContra() {
            contraNueva = document.getElementById("txtNuevaContra").value;
            repContraNueva = document.getElementById("txtRepNuevaContra").value;

            if (contraNueva != repContraNueva) {
                document.getElementById('btnEnvioPassword').disabled = true;
                alert("Ambas contraseñas deben ser iguales");

            } else {
                document.getElementById('btnEnvioPassword').disabled = false;
            }
        }

        function verificarCorreo() {
            correo = document.getElementById("correo").value;
            var cont = 0;

            for (i = 0; i < correo.length; i++) {

                if (correo[i] == "@") {
                    cont++;
                    document.getElementById("mensaje_correo").innerHTML = "Valido";
                    document.getElementById("btnEnvioCorreo").disabled = false;
                }
            }
            if (cont == 0) {
                document.getElementById("mensaje_correo").innerHTML = "Ingrese un correo valido.";
                document.getElementById("btnEnvioCorreo").disabled = true;
                return false;
            } else {
                return true;
            }
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usuario\Desktop\UNT\Escuela_Contabilidad\ProyectoActualizado\sistema-tesis-upao-unt\resources\views/user/informacion.blade.php ENDPATH**/ ?>