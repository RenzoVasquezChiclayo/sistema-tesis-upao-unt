<?php $__env->startSection('titulo'); ?>
    Crear Grupos de Investigacion
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contenido'); ?>
    <div class="card-header">
        Crear grupos de investigacion
    </div>
    <div class="card-body">
        <div class="row justify-content-around align-items-center">
            <div>
                <div class="row justify-content-around align-items-center" style="margin-top: 10px;">
                    <div class="col-lg-7" id="fieldsBody">
                        <div class="row justify-content-around align-items-center" id="rowStudent_0">
                            <div class="col-lg-6">
                                <label for="">Estudiante</label>
                                <select class="form-control" name="selectStudent_0" id="selectStudent_0"
                                    onchange="onSelectStudent(0);">
                                    <option value="-">-</option>
                                    <?php $__currentLoopData = $estudiantes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $est): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($est->cod_matricula); ?>">
                                            <?php echo e($est->apellidos); ?> <?php echo e($est->nombres); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <button class="btn btn-danger" id="deleteStudent_0" type="button"
                                    onclick="deleteFieldStudent(0);" hidden><i class='bx bx-minus bx-xs'></i></button>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-2">
                        <button class="btn btn-success" id="addStudent" type="button" onclick="addFieldStudent();"><i
                                class='bx bx-plus bx-xs'></i></button>
                    </div>
                    <div class="col-lg-3">
                        <form name="form1" action="<?php echo e(route('director.saveGruposInvestigacion')); ?>" method="post">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="arreglo_grupos" id="arreglo_grupos">
                            <div class="row" style="margin: 10px;">
                                <div class="col-12" style="text-align: center;">
                                    <input class="btn btn-success" type="button" value="Crear grupo" id="saveGrupos"
                                        onclick="guardarGrupo();">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table id="table-proyecto" class="table table-striped table-responsive-md">
                    <thead>
                        <tr>
                            <td>Numero de grupo</td>
                            <td colspan="2" style="text-align: center;">Estudiante(s)</td>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $cont = 0;
                            $lastGroup = 0;
                        ?>
                        <?php $__currentLoopData = $studentforGroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grupo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td style="justify-content: center; align-content:center;"><?php echo e($grupo[0]->num_grupo); ?></td>
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
                                
                            </tr>
                            <?php
                                $cont++;
                            ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
                <?php echo e($studentforGroups->links()); ?>

            </div>


        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        let num_grupo = 1
        let datos = [];
        //Recently added
        let studentNumber = [0];
        let lastStudentSelected = 0;

        function addFieldStudent() {
            studentNumber.push(studentNumber[studentNumber.length - 1] + 1);
            const fieldsBody = document.getElementById('fieldsBody');
            const lastItem = studentNumber[studentNumber.length - 1];
            const newRow = document.createElement("div");
            newRow.class = "row";
            newRow.id = `rowStudent_${lastItem}`
            newRow.innerHTML = `<div class="row justify-content-around align-items-center">
                        <div class="col-lg-6">
                            <label for="">Estudiante</label>
                            <select class="form-control" id="selectStudent_` + lastItem +
                `" onchange="onSelectStudent(` + lastItem + `);">
                                <option value="-">-</option>
                                <?php $__currentLoopData = $estudiantes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $est): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($est->cod_matricula); ?>">
                                        <?php echo e($est->apellidos); ?> <?php echo e($est->nombres); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <button class="btn btn-danger" id="deleteStudent_` + lastItem +
                `" type="button" onclick="deleteFieldStudent(` + lastItem + `);"><i class="bx bx-minus bx-xs"></i></button>
                        </div>
                    </div>`;
            fieldsBody.appendChild(newRow);
            console.log(studentNumber.length);
            if (studentNumber.length > 1) {
                document.getElementById(`addStudent`).hidden = true;
                document.getElementById(`deleteStudent_${studentNumber[0]}`).hidden = false;
                console.log(studentNumber);
            }
        }

        function onSelectStudent(id) {
            let select = document.getElementById(`selectStudent_${id}`);
            if (select.selectedIndex == 0) {
                alert("Seleccione una opcion!");
                return;
            }
            let student = select.value;
            let objStudent = {
                "select": id,
                "code": student
            };
            if (datos.size == 0 || !datos.some(e => e.select == id)) {
                datos.push(objStudent);
                return;
            }
            datos.forEach(e => {
                if (e.select == id) {
                    e.code = student;
                }
            });
        }

        function deleteFieldStudent(id) {
            datos = datos.filter(e => e.select != id);
            studentNumber = studentNumber.filter(e => e != id);
            document.getElementById(`rowStudent_${id}`).remove();
            document.getElementById(`deleteStudent_${studentNumber[0]}`).hidden = true;
            document.getElementById(`addStudent`).hidden = false;
        }

        function guardarGrupo(count) {
            if (datos.length == 0) {
                alert("Debe seleccionar almenos un estudiante.");
                return;
            }
            let select = document.getElementById(`selectStudent_${datos[0].select}`);
            if (select.selectedIndex == 0) {
                alert("Seleccione una opcion!");
                return;
            }
            if (datos.length > 1) {
                if (datos[0].code == datos[1].code) {
                    alert("Debe seleccionar dos estudiantes distintos.")
                    return;
                }
            }
            var chainGroup = (datos.length > 1) ? datos[0].code + "_" + datos[1].code : datos[0].code;
            console.log(datos);
            document.getElementById("arreglo_grupos").value = chainGroup;
            document.form1.submit();
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
                title: 'Error al guardar los grupos',
                showConfirmButton: false,
                timer: 1200
            })
        </script>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usuario\Desktop\UNT\Escuela_Contabilidad\ProyectoActualizado\sistema-tesis-upao-unt\resources\views/cursoTesis20221/director/crearGruposDeInvestigacion.blade.php ENDPATH**/ ?>