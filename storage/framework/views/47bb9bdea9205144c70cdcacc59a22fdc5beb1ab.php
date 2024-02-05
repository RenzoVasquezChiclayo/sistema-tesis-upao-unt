<?php $__env->startSection('titulo'); ?>
    Curso Tesis 2022-1
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <style type="text/css">
        .border-box {
            border: 0.5px solid rgba(0, 0, 0, 0.2);
            border-radius: 20px;
            padding: 10px 0px;
            margin: 0;
        }

        .item-card2 {
            flex: 1 1 500px;
        }

        .alert-correction {
            border: 1px solid green;
            border-radius: 10px;
        }

        /* Cambios */
        .contenedor-img {
            border-radius: 6px;
            background-color: azure;
            border: 1px solid gray;
        }

        .img-tarjeta {
            justify-content: center;
            text-align: center;
        }

        .img-buttons {
            justify-content: center;
            margin: 10px;
        }

        .galerias {
            display: grid;
            padding-top: 10px;
            padding-bottom: 10px;
            grid-template-rows: repeat(1, 250px);
            grid-auto-flow: column;
            overflow-x: auto;
            grid-auto-columns: auto;
        }

        .card-img-top {
            height: 140px;
        }


        .btn-delete-group {
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .btn-delete-group a {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 5px;
            color: red;
            text-decoration: none;
        }

        .btn-delete-group a:hover {

            border-radius: 5px;
            background: rgba(0, 0, 0, 0.1);
        }

        .title-p {
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.35);
        }

        .agrega_text {
            width: 100%;
        }

        .agrega_text tr td {
            max-width: 0;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .td_descripcion {
            width: 60%;
        }

        h4,
        h5,
        h6 {
            text-align: left;
        }
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contenido'); ?>
    <title>Tesis</title>

    <?php if($autor->id_grupo == null): ?>
        <div class="row d-flex" style="align-items:center; justify-content: center;">
            <div class="col-8 border-box mt-3">
                <div class="row">
                    <div class="col">
                        <h4 style="color:red;">Aviso!</h4>
                        <hr style="border: 1px solid black;" />
                    </div>

                    <div class="col">
                        <p>Esta vista estara habilitada cuando se te asigne algun grupo de investigacion para el curso.
                            Si existe algun inconveniente y/o queja envia un correo a <a href="#">
                                <>example@unitru.edu.pe</u>
                            </a> para mas informacion.</p>
                    </div>
                </div>
            </div>
        </div>
    <?php elseif($autor->cod_docente == null): ?>
        <div class="row d-flex" style="align-items:center; justify-content: center;">
            <div class="col-8 border-box mt-3">
                <div class="row">
                    <div class="col">
                        <h4 style="color:red;">Aviso!</h4>
                        <hr style="border: 1px solid black;" />
                    </div>

                    <div class="col">
                        <p>Esta vista estara habilitada cuando se te designe algun asesor para el curso.
                            Si existe algun inconveniente y/o queja envia un correo a <a href="#">
                                <>example@unitru.edu.pe</u>
                            </a> para mas informacion.</p>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="col-12">
            <?php if($tesis[0]->condicion == 'APROBADO'): ?>
                <div class="row p-2" style="background-color: rgb(77, 153, 77);">
                    <div class="col alert-correction" style="text-align: center;">
                        <p>PROYECTO APROBADO!</p>
                    </div>
                </div>
            <?php elseif($tesis[0]->condicion == 'DESAPROBADO'): ?>
                <div class="row p-2" style="background-color: rgb(148, 91, 91);">
                    <div class="col col-md-6 alert-correction" style="text-align: center;">
                        <p>PROYECTO DESAPROBADO!</p>
                    </div>
                </div>
            <?php elseif(sizeof($correciones) != 0): ?>
                <div class="row p-2" style="text-align:center;">
                    <div class="col col-md-6 alert-correction">
                        <p>Se realizaron las correciones correspondientes.</p>
                    </div>
                </div>
            <?php endif; ?>
            <div class="card-body">
                <form id="formTesis" name="formTesis" action="<?php echo e(route('curso.saveTesis')); ?>" method="POST"
                    enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>

                    <div class="col">
                        <h4>GENERALIDADES</h4>
                        <hr style="border:1 px black; width: 70%;">
                        <?php
                            $varextra1 = 'true';
                        ?>
                        <input id="verificaCorrect" type="hidden"
                            value="<?php if(sizeof($correciones) > 0): ?> <?php echo e($varextra1); ?> <?php endif; ?>">
                        <?php
                            $valuesObs = '';
                            for ($i = 0; $i < sizeof($detalles); $i++) {
                                if ($i == 0) {
                                    $valuesObs = $detalles[$i]->tema_referido;
                                } else {
                                    $valuesObs = $valuesObs . ',' . $detalles[$i]->tema_referido;
                                }
                            }
                        ?>
                        <input type="hidden" id="txtValuesObs" value="<?php echo e($valuesObs); ?>">
                    </div>
                    <div class="col-12 mb-3">
                        <input type="hidden" name="textcod" value="<?php echo e($tesis[0]->cod_cursoTesis); ?>">
                        <div class="row" <?php if($campos->count() > 0 && $campos[0]->titulo == 0): ?> hidden <?php endif; ?>>
                            <h5>Titulo</h5>
                            <div class="col">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row gy-1 gy-sm-0">
                                            <div class="col-12 col-sm-11">
                                                <input class="form-control" name="txttitulo" id="txttitulo" type="text"
                                                    value="<?php if($tesis[0]->titulo != ''): ?> <?php echo e($tesis[0]->titulo); ?> <?php endif; ?>"
                                                    placeholder="Ingrese el titulo del proyecto" required>
                                                <span class="ps-2" id="validateTitle" name="validateTitle"
                                                    style="color: red"></span>
                                            </div>
                                            <div class="col-12 col-sm-1">
                                                <input type="button" value="Verificar" onclick="validaText();"
                                                    class="btn btn-success">
                                            </div>
                                        </div>
                                    </div>
                                    <?php if(sizeof($correciones) != 0 && $tesis[0]->condicion == null): ?>
                                        <?php if($correciones[0]->titulo != null): ?>
                                            <div class="col-2">
                                                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                                    data-bs-target="#mCorreccionTitulo">Correccion</button>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <div class="modal" id="mCorreccionTitulo">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                <div class="modal-content">
                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Correccion del titulo</h4>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <!-- Modal body -->
                                                    <div class="modal-body">
                                                        <div class="row" style="padding: 20px">
                                                            <p><?php echo e($correciones[0]->titulo); ?></p>
                                                        </div>
                                                    </div>
                                                    <!-- Modal footer -->
                                                    <div class="modal-footer">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <button type="button" class="btn btn-danger"
                                                                    data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col mb-3">
                        <h5>Autor(es)</h5>
                        
                        <?php if($coautor != null): ?>
                            <div class="row my-2">
                                <div class="row">
                                    <div style="width:auto;">
                                        <input class="form-control" name="txtCodMatricula" id="txtCodMatricula"
                                            type="search" value="<?php echo e($coautor->cod_matricula); ?>"
                                            placeholder="Codigo de Matricula" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row border-box" style="margin-bottom: 10px">
                                <div class="col-12 col-sm-6">
                                    <label for="txtNombreAutor" class="form-label">Nombres</label>
                                    <input class="form-control" name="txtNombreAutor" id="txtNombreAutor" type="text"
                                        value="<?php echo e($coautor->nombres); ?>" placeholder="Nombres" readonly>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <label for="txtApellidoAutor" class="form-label">Apellidos</label>
                                    <input class="form-control" name="txtApellidoAutor" id="txtApellidoAutor"
                                        type="text" value="<?php echo e($coautor->apellidos); ?>" placeholder="Apellidos"
                                        readonly>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="row my-2">
                            <div class="row">
                                <div style="width:auto;">
                                    <input class="form-control" name="txtCodMatricula" id="txtCodMatricula"
                                        type="search" value="<?php echo e($autor->cod_matricula); ?>"
                                        placeholder="Codigo de Matricula" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row border-box">
                            <div class="col-12 col-sm-6">
                                <label for="txtNombreAutor" class="form-label">Nombres</label>
                                <input class="form-control" name="txtNombreAutor" id="txtNombreAutor" type="text"
                                    value="<?php echo e($autor->nombres); ?>" placeholder="Nombres" readonly>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label for="txtApellidoAutor" class="form-label">Apellidos</label>
                                <input class="form-control" name="txtApellidoAutor" id="txtApellidoAutor" type="text"
                                    value="<?php echo e($autor->apellidos); ?>" placeholder="Apellidos" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col mb-3">
                        <h5>Asesor</h5>
                        <div class="row my-2">
                            <div class="row">
                                <div style="width:auto;">
                                    <input class="form-control" name="txtCodDocente" id="txtCodDocente" type="text"
                                        value="<?php echo e($asesor->cod_docente); ?>" placeholder="Codigo del Docente" readonly>
                                </div>
                                <div style="width:auto;">
                                    <input class="form-control" name="txtCodORCID" id="txtCodORCID" type="text"
                                        value="<?php echo e($asesor->orcid); ?>" placeholder="Codigo ORCID" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row border-box">
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                <label for="txtNombreAsesor" class="form-label">Apellidos y Nombres</label>
                                <input class="form-control" name="txtNombreAsesor" id="txtNombreAsesor" type="text"
                                    value="<?php echo e($asesor->nombres . ' ' . $asesor->apellidos); ?>"
                                    placeholder="Apellidos y nombres" readonly>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                <label for="cboGrAcademicoAsesor" class="form-label">Grado Academico</label>
                                <input class="form-control" name="txtGrAcademicoAsesor" id="txtGrAcademicoAsesor"
                                    type="text" value="<?php echo e($asesor->DescGrado); ?>" placeholder="Grado academico"
                                    readonly>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                <label for="txtTProfesional" class="form-label">Titulo Profesional</label>
                                <input class="form-control" name="txtTProfesional" id="txtTProfesional" type="text"
                                    value="<?php echo e($asesor->DescCat); ?>" placeholder="Titulo profesional" readonly>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                <label for="txtDireccionAsesor" class="form-label">Dirección laboral y/o
                                    domiciliaria</label>
                                <input class="form-control" name="txtDireccionAsesor" id="txtDireccionAsesor"
                                    type="text" value="<?php echo e($asesor->direccion); ?>"
                                    placeholder="Direccion laboral y/o domiciliaria" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="col mb-3" <?php if($campos[0]->tipo_investigacion == 0): ?> hidden <?php endif; ?>>
                        <h5>Tipo de Investigacion</h5>
                        <div class="row border-box">
                            <div class="col-12 col-sm-6 col-md-4">
                                <label for="cboTipoInvestigacion" class="form-label">Linea de Investigacion</label>
                                <select name="cboTipoInvestigacion" id="cboTipoInvestigacion" class="form-select"
                                    required>
                                    <option value="">-</option>
                                    <?php $__currentLoopData = $tinvestigacion; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($tipo->cod_tinvestigacion); ?>"
                                            <?php if($tesis[0]->cod_tinvestigacion == $tipo->cod_tinvestigacion): ?> selected <?php endif; ?>><?php echo e($tipo->descripcion); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4">
                                <label for="cboFinInvestigacion" class="form-label">De acuerdo al fin que se
                                    persigue</label>
                                <select name="txtti_finpersigue" id="cboFinInvestigacion" class="form-select" required>
                                    <option value="" selected>-</option>
                                    <?php $__currentLoopData = $fin_persigue; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f_p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($f_p->cod_fin_persigue); ?>"
                                            <?php if($tesis[0]->ti_finpersigue == $f_p->cod_fin_persigue): ?> selected <?php endif; ?>><?php echo e($f_p->descripcion); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4">
                                <label for="cboDesignInvestigacion" class="form-label">De acuerdo al diseño de
                                    investigación</label>
                                <select name="txtti_disinvestigacion" id="cboDesignInvestigacion" class="form-select"
                                    required>
                                    <option value="" selected>-</option>
                                    <?php $__currentLoopData = $diseno_investigacion; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d_i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($d_i->cod_diseno_investigacion); ?>"
                                            <?php if($tesis[0]->ti_disinvestigacion == $d_i->cod_diseno_investigacion): ?> selected <?php endif; ?>><?php echo e($d_i->descripcion); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <?php if(sizeof($correciones) != 0 && $tesis[0]->condicion == null): ?>
                                <?php if($correciones[0]->linea_investigacion != null): ?>
                                    <div class="col-2">
                                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                            data-bs-target="#mCorreccionLinea">Correccion</button>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="modal" id="mCorreccionLinea">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Correccion de la Linea de Investigacion</h4>
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal"></button>
                                            </div>
                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <div class="row" style="padding: 20px">
                                                    <p><?php echo e($correciones[0]->linea_investigacion); ?></p>
                                                </div>
                                            </div>
                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <button type="button" class="btn btn-danger"
                                                            data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="row mb-4 gy-3 gy-lg-0" style="justify-content: right;">
                        <div class="col-12 col-lg-8" <?php if($campos[0]->localidad_institucion == 0): ?> hidden <?php endif; ?>>
                            <div class="row border-box">
                                <h5>Localidad e Institucion</h5>
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <label for="txtLocalidad" class="form-label">Localidad</label>
                                        <input class="form-control" name="txtlocalidad" id="txtLocalidad" type="text"
                                            value="<?php if($tesis[0]->localidad != ''): ?> <?php echo e($tesis[0]->localidad); ?> <?php endif; ?>"
                                            placeholder="Localidad" required>

                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label for="txtInstitucion" class="form-label">Institucion</label>
                                        <input class="form-control" name="txtinstitucion" id="txtInstitucion"
                                            type="text"
                                            value="<?php if($tesis[0]->institucion != ''): ?> <?php echo e($tesis[0]->institucion); ?> <?php endif; ?>"
                                            placeholder="Institucion" required>
                                    </div>

                                    <?php if(sizeof($correciones) != 0 && $tesis[0]->condicion == null): ?>
                                        <?php if($correciones[0]->localidad_institucion != null): ?>
                                            <div class="item-card" style="padding-top:10px;">
                                                <button type="button" class="btn btn-outline-danger"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#mCorreccionLocalInsti">Correccion</button>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <div class="modal" id="mCorreccionLocalInsti">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                <div class="modal-content">

                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Correccion de Localidad e Institucion
                                                        </h4>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <div class="row" style="padding: 20px">
                                                            <p><?php echo e($correciones[0]->localidad_institucion); ?></p>
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <button type="button" class="btn btn-danger"
                                                                    data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-10 col-lg-4 mb-2" <?php if($campos[0]->duracion_proyecto == 0): ?> hidden <?php endif; ?>>
                            <div class="row border-box" style="text-align: right;">
                                <h5>Ejecución del proyecto</h5>
                                <div class="row" style="justify-content:flex-end;">
                                    <div class="col-12 col-md-8">
                                        <div class="row">
                                            <div class="col-4 col-xl-3" style="padding-top: 32px;">
                                                <input type="button" class="btn btn-success" value="Set"
                                                    id="setMes" name="setMes" onclick="setMeses();" required>
                                            </div>
                                            <div class="col-8 col-xl-9" style="text-align: right;">
                                                <label for="txtmeses_ejecucion" class="form-label">Numero de
                                                    meses</label>
                                                <input class="form-control" name="txtmeses_ejecucion"
                                                    id="txtmeses_ejecucion" type="number"
                                                    onkeypress="return isNumberKey(this);"
                                                    value="<?php if($tesis[0]->meses_ejecucion != ''): ?><?php echo e($tesis[0]->meses_ejecucion); ?><?php endif; ?>"
                                                    placeholder="00" min="0" required>
                                                <input type="hidden" id="valuesMesesPart"
                                                    value="<?php if($tesis[0]->meses_ejecucion != ''): ?> <?php echo e($tesis[0]->t_ReparacionInstrum); ?>,<?php echo e($tesis[0]->t_RecoleccionDatos); ?>,<?php echo e($tesis[0]->t_AnalisisDatos); ?>,<?php echo e($tesis[0]->t_ElaboracionInfo); ?> <?php endif; ?>">
                                            </div>

                                        </div>
                                        <input type="hidden" id="CorreccionMes" value="corregir">
                                    </div>
                                    <?php if(sizeof($correciones) != 0 && $tesis[0]->condicion == null): ?>
                                        <?php if($correciones[0]->meses_ejecucion != null): ?>
                                            <div class="col-2" style="padding-top:10px;">
                                                <button type="button" class="btn btn-outline-danger"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#mCorreccionMeses">Correccion</button>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <div class="modal" id="mCorreccionMeses">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                <div class="modal-content">
                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Correccion de Meses de ejecucion</h4>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <!-- Modal body -->
                                                    <div class="modal-body">
                                                        <div class="row" style="padding: 20px">
                                                            <p><?php echo e($correciones[0]->meses_ejecucion); ?></p>
                                                        </div>
                                                    </div>
                                                    <!-- Modal footer -->
                                                    <div class="modal-footer">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <button type="button" class="btn btn-danger"
                                                                    data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <div class="row mb-2" <?php if($campos[0]->duracion_proyecto == 0): ?> hidden <?php endif; ?>>
                        <div class="col-8">
                            <h5>Cronograma de trabajo</h5>
                            <input type="hidden" name="nActivities" id="nActivities"
                                    value="<?php echo e(sizeof($cronograma)); ?>">
                        </div>
                        <div class="row m-0">
                            <table class="table table-bordered">
                                <thead>
                                    <tr id="headers">
                                        <th scope="col">ACTIVIDAD</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $cont_tr = 1;
                                    ?>
                                    <?php $__currentLoopData = $cronograma; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <input type="hidden" name="cod_cronograma[]" id="cod_cronograma[]"
                                            value="<?php echo e($cro->cod_cronograma); ?>">
                                        <tr id="<?php echo e($cont_tr); ?>Tr">
                                            <td><?php echo e($cro->actividad); ?></td>
                                        </tr>
                                        <?php
                                            $cont_tr++;
                                        ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                            <input type="hidden" value="" id="listMonths" name="listMonths">
                        </div>
                    </div>

                    <div class="row mb-3" <?php if($campos[0]->recursos == 0): ?> hidden <?php endif; ?>>
                        <h5>Recursos</h5>
                        <div class="col col-sm-8 col-lg-6 col-xl-3 mb-3">
                            <div class="row border-box">
                                <div class="col-6" style="text-align:center; justify-content:center;">
                                    <p>Agregar un recurso</p>
                                </div>
                                <div class="col-6">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#mRecurso">
                                        Agregar
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="table-responsive">
                                
                                <table id="recursosTable" class="table table-bordered agrega_text">
                                    <thead>
                                        <tr>
                                            <th>Tipo</th>
                                            <th>Subtipo</th>
                                            <th>Descripcion</th>
                                            <th>Accion</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(sizeof($recursos) > 0): ?>
                                            <?php
                                                $indRec = 0;
                                            ?>
                                            <?php $__currentLoopData = $recursos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr id="filaR<?php echo e($indRec); ?>">
                                                    <td><?php echo e($rec->tipo); ?></td>
                                                    <td><?php echo e($rec->subtipo); ?></td>
                                                    <td class="td_descripcion"><?php echo e($rec->descripcion); ?></td>
                                                    <td style=" text-align:center;">
                                                        <a href="#" id="lrec-<?php echo e($indRec); ?>"
                                                            class="btn btn-warning"
                                                            onclick="deleteOldRecurso(this);">X</a>
                                                        <input type="hidden" id="xlrec-<?php echo e($indRec); ?>"
                                                            value="<?php echo e($rec->cod_recurso); ?>">
                                                    </td>
                                                </tr>
                                                <?php
                                                    $indRec++;
                                                ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                        <input type="hidden" id="valNRecurso" value="<?php echo e(sizeof($recursos)); ?>">
                                        <input type="hidden" name="listOldlrec" id="listOldlrec">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php if(sizeof($correciones) != 0 && $tesis[0]->condicion == null): ?>
                            <?php if($correciones[0]->recursos != null): ?>
                                <div class="col-2 col-lg-4" style="padding-top:10px;">
                                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                        data-bs-target="#mRecursos">Correccion</button>
                                </div>
                            <?php endif; ?>
                            
                            <div class="modal" id="mRecursos">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Correccion de Recursos</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            <div class="row" style="padding: 20px">
                                                <div class="row my-2">
                                                    <textarea class="form-control" name="taNone" id="taNone" style="height: 200px; resize:none" readonly><?php echo e($correciones[0]->recursos); ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                            <div class="row">
                                                <div class="col-6">
                                                    <button type="button" class="btn btn-danger"
                                                        data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                    </div>

                    <div class="row mb-2" <?php if($campos[0]->presupuesto == 0): ?> hidden <?php endif; ?>>
                        <div class="col">
                            <hr style="border: 1px solid gray">
                        </div>
                        <h5>Presupuesto</h5>
                        
                        <div class="col-11">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Codigo</th>
                                            <th>Denominacion</th>
                                            <th>Precio Total</th>
                                        </tr>
                                    </thead>
                                    <?php
                                        $i = 0;
                                        $total = 0;
                                    ?>
                                    <tbody>
                                        <?php $__currentLoopData = $presupuestos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $presupuesto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <th><?php echo e($presupuesto->codeUniversal); ?></th>
                                                <td><?php echo e($presupuesto->denominacion); ?></td>
                                                <td>
                                                    <div class="input-group mb-1">
                                                        <span class="input-group-text">S/.</span>
                                                        <input type="number" id="cod_<?php echo e($i); ?>"
                                                            name="cod_<?php echo e($i); ?>" class="form-control"
                                                            aria-label="Amount (to the nearest dollar)" min="0"
                                                            value=<?php if($presupuestoProy->count() > 0): ?> "<?php echo e($presupuestoProy[$i]->precio); ?>"
                                                                <?php elseif(sizeof($correciones) == 0): ?>
                                                                "0" required <?php endif; ?>>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php
                                                $i++;
                                            ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="2" style="text-align: right;"><input type="button"
                                                    class="btn btn-success" onclick="verTotal();" value="Total">
                                            </th>
                                            <th>
                                                <div class="input-group mb-1">
                                                    <span class="input-group-text">S/.</span>
                                                    <input class="form-control" type="number" id="total"
                                                        name="total"
                                                        value=<?php if($presupuestoProy->count() > 0): ?> "<?php echo e($presupuestoProy[0]->precio + $presupuestoProy[1]->precio + $presupuestoProy[2]->precio + $presupuestoProy[3]->precio + $presupuestoProy[4]->precio); ?>" disabled
                                                        <?php elseif(sizeof($correciones) == 0): ?>
                                                        "0" <?php endif; ?>>
                                                </div>

                                            </th>
                                            <input type="hidden" id="precios" name="precios" value="">
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <?php if(sizeof($correciones) != 0 && $tesis[0]->condicion == null): ?>
                            <?php if($correciones[0]->presupuesto_proy != null): ?>
                                <div class="col-1">
                                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                        data-bs-target="#mCorreccionPresupuestoProy">Correccion</button>
                                </div>
                            <?php endif; ?>
                            
                            <div class="modal" id="mCorreccionPresupuestoProy">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Correccion de Presupuesto</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            <div class="row" style="padding: 20px">
                                                <div class="row my-2">
                                                    <textarea class="form-control" name="taNone" id="taNone" style="height: 200px; resize:none" readonly><?php echo e($correciones[0]->presupuesto_proy); ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                            <div class="row">
                                                <div class="col-6">
                                                    <button type="button" class="btn btn-danger"
                                                        data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="row" style="margin-bottom:20px" <?php if($campos[0]->financiamiento == 0): ?> hidden <?php endif; ?>>
                        <h5>Financiamiento </h5>
                        <div class="row" style="margin-bottom:8px">
                            <div class="col-8 col-md-5">
                                <select name="txtfinanciamiento" id="cboFinanciamiento" class="form-select">
                                    <option value="">-</option>
                                    <option value="Con recursos propios"
                                        <?php if($tesis[0]->financiamiento == 'Con recursos propios'): ?> selected <?php endif; ?>>Con recursos propios
                                    </option>
                                    <option value="Con recursos de la UNT"
                                        <?php if($tesis[0]->financiamiento == 'Con recursos de la UNT'): ?> selected <?php endif; ?>>Con recursos de la UNT
                                    </option>
                                    <option value="Con recursos externos"
                                        <?php if($tesis[0]->financiamiento == 'Con recursos externos'): ?> selected <?php endif; ?>>Con recursos externos
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <?php
                        $iGRUPO = 0;
                    ?>
                    <div class="row" style=" margin-bottom:20px" <?php if($campos[0]->rp_antecedente_justificacion == 0): ?> hidden <?php endif; ?>>
                        <div class="col-8">
                            <h4>PLAN DE INVESTIGACION</h4>
                            <hr style="border:1 px black;">
                        </div>
                        <h5>Realidad problematica </h5>
                        <div class="row" style="margin-bottom:8px">
                            <div class="col-12 col-md-10">
                                <div class="form-floating">
                                    <textarea class="form-control" name="txtreal_problematica" id="txtreal_problematica"
                                        style="height: 100px; resize:none" required>
<?php if($tesis[0]->real_problematica != ''): ?>
<?php echo e($tesis[0]->real_problematica); ?>

<?php endif; ?>
</textarea>
                                </div>
                            </div>

                            <?php if(sizeof($correciones) != 0 && $tesis[0]->condicion == null): ?>
                                <?php if($correciones[0]->real_problematica != null): ?>
                                    <div class="col-2">
                                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                            data-bs-target="#mCorreccionRProbl">Correccion</button>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="modal" id="mCorreccionRProbl">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Correccion de Realidad problematica</h4>
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal"></button>
                                            </div>
                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <div class="row" style="padding: 20px">
                                                    <div class="row my-2">
                                                        <textarea class="form-control" name="taNone" id="taNone" style="height: 200px; resize:none" readonly><?php echo e($correciones[0]->real_problematica); ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <button type="button" class="btn btn-danger"
                                                            data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                        </div>
                    </div>

                    <div class="row" style=" margin-bottom:20px" <?php if($campos[0]->rp_antecedente_justificacion == 0): ?> hidden <?php endif; ?>>
                        <h5>Antecedentes</h5>
                        <div class="row" style="margin-bottom:8px">
                            <div class="col-12 col-md-10">
                                <div class="form-floating">
                                    <textarea class="form-control" name="txtantecedentes" id="txtantecedentes" style="height: 100px; resize:none"
                                        required>
<?php if($tesis[0]->antecedentes != ''): ?>
<?php echo e($tesis[0]->antecedentes); ?>

<?php endif; ?>
</textarea>
                                </div>
                            </div>

                            <?php if(sizeof($correciones) != 0 && $tesis[0]->condicion == null): ?>
                                <?php if($correciones[0]->antecedentes != null): ?>
                                    <div class="col-2">
                                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                            data-bs-target="#mCorreccionAntecedente">Correccion</button>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="modal" id="mCorreccionAntecedente">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Correccion de antecedentes</h4>
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal"></button>
                                            </div>
                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <div class="row" style="padding: 20px">
                                                    <div class="row my-2">
                                                        <textarea class="form-control" name="taNone" id="taNone" style="height: 200px; resize:none" readonly><?php echo e($correciones[0]->antecedentes); ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <button type="button" class="btn btn-danger"
                                                            data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="row" style=" margin-bottom:20px" <?php if($campos[0]->rp_antecedente_justificacion == 0): ?> hidden <?php endif; ?>>
                        <h5>Justificación de la investigación</h5>
                        <div class="row" style="margin-bottom:8px">
                            <div class="col-12 col-md-10">
                                <div class="form-floating">
                                    <textarea class="form-control" name="txtjustificacion" id="txtjustificacion" style="height: 100px; resize:none"
                                        required>
<?php if($tesis[0]->justificacion != ''): ?>
<?php echo e($tesis[0]->justificacion); ?>

<?php endif; ?>
</textarea>
                                </div>
                            </div>

                            <?php if(sizeof($correciones) != 0 && $tesis[0]->condicion == null): ?>
                                <?php if($correciones[0]->justificacion != null): ?>
                                    <div class="col-2">
                                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                            data-bs-target="#mCorreccionJInv">Correccion</button>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="modal" id="mCorreccionJInv">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Correccion de justificacion de la investigacion
                                                </h4>
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal"></button>
                                            </div>
                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <div class="row" style="padding: 20px">
                                                    <div class="row my-2">
                                                        <textarea class="form-control" name="taNone" id="taNone" style="height: 200px; resize:none" readonly><?php echo e($correciones[0]->justificacion); ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <button type="button" class="btn btn-danger"
                                                            data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="row" style=" margin-bottom:20px" <?php if($campos[0]->formulacion_problema == 0): ?> hidden <?php endif; ?>>
                        <h5>Formulación del problema</h5>
                        <div class="row" style="margin-bottom:8px">
                            <div class="col-12 col-md-10">
                                <div class="form-floating">
                                    <textarea class="form-control" name="txtformulacion_prob" id="txtformulacion_prob"
                                        style="height: 100px; resize:none" required>
<?php if($tesis[0]->formulacion_prob != ''): ?>
<?php echo e($tesis[0]->formulacion_prob); ?>

<?php endif; ?>
</textarea>
                                </div>
                            </div>

                            <?php if(sizeof($correciones) != 0 && $tesis[0]->condicion == null): ?>
                                <?php if($correciones[0]->formulacion_prob != null): ?>
                                    <div class="col-2">
                                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                            data-bs-target="#mCorreccionFProbl">Correccion</button>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="modal" id="mCorreccionFProbl">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Correccion de Formulacion del problema</h4>
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal"></button>
                                            </div>
                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <div class="row" style="padding: 20px">
                                                    <div class="row my-2">
                                                        <textarea class="form-control" name="taNone" id="taNone" style="height: 200px; resize:none" readonly><?php echo e($correciones[0]->formulacion_prob); ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <button type="button" class="btn btn-danger"
                                                            data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="row" style=" margin-bottom:20px" <?php if($campos[0]->objetivos == 0): ?> hidden <?php endif; ?>>
                        <h5>Objetivos</h5>
                        <div class="col-8 col-md-5 col-xl-3">
                            <div class="row border-box" style="margin-bottom:20px">
                                <div class="col-7 col-md-6" style="text-align:center">
                                    <p>Agregar un objetivo</p>
                                </div>
                                <div class="col-5 col-md-6">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#mObjetivo">
                                        Agregar
                                    </button>

                                </div>
                            </div>
                        </div>
                        <?php if(sizeof($correciones) != 0 && $tesis[0]->condicion == null): ?>
                            <?php if($correciones[0]->objetivos != null): ?>
                                <div class="col-2">
                                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                        data-bs-target="#mCorreccionObjetivo">Correccion</button>
                                </div>
                            <?php endif; ?>
                            
                            <div class="modal" id="mCorreccionObjetivo">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Correccion de Objetivos</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            <div class="row" style="padding: 20px">
                                                <div class="row my-2">
                                                    <textarea class="form-control" name="taNone" id="taNone" style="height: 200px; resize:none" readonly><?php echo e($correciones[0]->objetivos); ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                            <div class="row">
                                                <div class="col-6">
                                                    <button type="button" class="btn btn-danger"
                                                        data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="row" style="margin-bottom:8px">
                            <div class="col-12">
                                
                                <table id="objetivoTable"
                                    class="table table-striped table-bordered table-condensed table-hover">
                                    <thead>
                                        <tr>
                                            <th>Tipo</th>
                                            <th>Subtipo</th>
                                            <th>Accion</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(sizeof($objetivos) > 0): ?>
                                            <?php
                                                $indObj = 0;
                                            ?>

                                            <?php $__currentLoopData = $objetivos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $obj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr id="filaO<?php echo e($indObj); ?>">
                                                    <td><?php echo e($obj->tipo); ?></td>
                                                    <td><?php echo e($obj->descripcion); ?></td>
                                                    <td>
                                                        <a href="#" id="lobj-<?php echo e($indObj); ?>"
                                                            class="btn btn-warning"
                                                            onclick="deleteOldRecurso(this);">X</a>
                                                        <input type="hidden" id="xlobj-<?php echo e($indObj); ?>"
                                                            value="<?php echo e($obj->cod_objetivo); ?>">
                                                    </td>
                                                </tr>
                                                <?php
                                                    $indObj++;
                                                ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                        <input type="hidden" id="valNObjetivo" value="<?php echo e(sizeof($objetivos)); ?>">
                                        <input type="hidden" name="listOldlobj" id="listOldlobj">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    
                    <div class="row" style=" margin-bottom:20px" <?php if($campos[0]->marcos == 0): ?> hidden <?php endif; ?>>
                        <div class="row" style="margin-bottom:15px">
                            <div class="col-12">
                                <hr style="border: 1px solid gray">
                            </div>
                            <h5>Marco Teórico</h5>
                            <div class="col-12 col-md-10">
                                <div class="form-floating">
                                    <textarea class="form-control" name="txtmarco_teorico" id="txtmarco_teorico" style="height: 100px; resize:none"
                                        required>
<?php if($tesis[0]->marco_teorico != ''): ?>
<?php echo e($tesis[0]->marco_teorico); ?>

<?php endif; ?>
</textarea>
                                </div>
                            </div>

                            <?php if(sizeof($correciones) != 0 && $tesis[0]->condicion == null): ?>
                                <?php if($correciones[0]->marco_teorico != null): ?>
                                    <div class="col-2">
                                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                            data-bs-target="#mCorreccionMTeorico">Correccion</button>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="modal" id="mCorreccionMTeorico">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Correccion de Marco teorico</h4>
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal"></button>
                                            </div>
                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <div class="row" style="padding: 20px">
                                                    <div class="row my-2">
                                                        <textarea class="form-control" name="taNone" id="taNone" style="height: 200px; resize:none" readonly><?php echo e($correciones[0]->marco_teorico); ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <button type="button" class="btn btn-danger"
                                                            data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="row" style="margin-bottom:15px">
                            <h5>Marco Conceptual</h5>
                            <div class="col-12 col-md-10">
                                <div class="form-floating">
                                    <textarea class="form-control" name="txtmarco_conceptual" id="txtmarco_conceptual"
                                        style="height: 100px; resize:none" required>
<?php if($tesis[0]->marco_conceptual != ''): ?>
<?php echo e($tesis[0]->marco_conceptual); ?>

<?php endif; ?>
</textarea>
                                </div>
                            </div>

                            <?php if(sizeof($correciones) != 0 && $tesis[0]->condicion == null): ?>
                                <?php if($correciones[0]->marco_conceptual != null): ?>
                                    <div class="col-2">
                                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                            data-bs-target="#mCorreccionMConceptual">Correccion</button>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="modal" id="mCorreccionMConceptual">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Correccion de Marco conceptual</h4>
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row" style="padding: 20px">
                                                    <div class="row my-2">
                                                        <textarea class="form-control" name="taNone" id="taNone" style="height: 200px; resize:none" readonly><?php echo e($correciones[0]->marco_conceptual); ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <button type="button" class="btn btn-danger"
                                                            data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="row" style="margin-bottom:15px">
                            <h5>Marco Legal</h5>
                            <div class="col-12 col-md-10">
                                <div class="form-floating">
                                    <textarea class="form-control" name="txtmarco_legal" id="txtmarco_legal" style="height: 100px; resize:none"
                                        required>
<?php if($tesis[0]->marco_legal != ''): ?>
<?php echo e($tesis[0]->marco_legal); ?>

<?php endif; ?>
</textarea>
                                </div>
                            </div>

                            <?php if(sizeof($correciones) != 0 && $tesis[0]->condicion == null): ?>
                                <?php if($correciones[0]->marco_legal != null): ?>
                                    <div class="col-2">
                                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                            data-bs-target="#mCorreccionMLegal">Correccion</button>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="modal" id="mCorreccionMLegal">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Correccion de Marco Legal</h4>
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal"></button>
                                            </div>
                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <div class="row" style="padding: 20px">
                                                    <div class="row my-2">
                                                        <textarea class="form-control" name="taNone" id="taNone" style="height: 200px; resize:none" readonly><?php echo e($correciones[0]->marco_legal); ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <button type="button" class="btn btn-danger"
                                                            data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="row" style=" margin-bottom:20px" <?php if($campos[0]->formulacion_hipotesis == 0): ?> hidden <?php endif; ?>>
                        <h5>Formulación de la hipótesis </h5>
                        <div class="row" style="margin-bottom:8px">
                            <div class="col-12 col-md-10">
                                <div class="form-floating">
                                    <textarea class="form-control" name="txtform_hipotesis" id="txtform_hipotesis" style="height: 100px; resize:none"
                                        required>
<?php if($tesis[0]->form_hipotesis != ''): ?>
<?php echo e($tesis[0]->form_hipotesis); ?>

<?php endif; ?>
</textarea>
                                </div>
                            </div>

                            <?php if(sizeof($correciones) != 0 && $tesis[0]->condicion == null): ?>
                                <?php if($correciones[0]->form_hipotesis != null): ?>
                                    <div class="col-2">
                                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                            data-bs-target="#mCorreccionFHipotesis">Correccion</button>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="modal" id="mCorreccionFHipotesis">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Correccion de Formulacion de la hipotesis</h4>
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal"></button>
                                            </div>
                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <div class="row" style="padding: 20px">
                                                    <div class="row my-2">
                                                        <textarea class="form-control" name="taNone" id="taNone" style="height: 200px; resize:none" readonly><?php echo e($correciones[0]->form_hipotesis); ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <button type="button" class="btn btn-danger"
                                                            data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="row" style=" margin-bottom:20px" <?php if($campos[0]->diseño_investigacion == 0): ?> hidden <?php endif; ?>>
                        <div class="row">
                            
                            <h5>Diseño de Investigación</h5>
                            <h6>Material, Métodos y Técnicas</h6>
                            <hr style="width: 60%; margin-left:15px;" />
                        </div>
                        <div class="row" style="margin-bottom:8px">
                            <label for="txtobjeto_estudio" class="form-label">Objeto de Estudio</label>
                            <div class="col-12 col-md-10">
                                <div class="form-floating">
                                    <textarea class="form-control" name="txtobjeto_estudio" id="txtobjeto_estudio" style="height: 100px; resize:none"
                                        required>
<?php if($tesis[0]->objeto_estudio != ''): ?>
<?php echo e($tesis[0]->objeto_estudio); ?>

<?php endif; ?>
</textarea>

                                </div>
                            </div>

                            <?php if(sizeof($correciones) != 0 && $tesis[0]->condicion == null): ?>
                                <?php if($correciones[0]->objeto_estudio != null): ?>
                                    <div class="col-2">
                                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                            data-bs-target="#mCorreccionOEstudio">Correccion</button>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="modal" id="mCorreccionOEstudio">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Correccion del Objeto de Estudio</h4>
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal"></button>
                                            </div>
                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <div class="row" style="padding: 20px">
                                                    <div class="row my-2">
                                                        <textarea class="form-control" name="taNone" id="taNone" style="height: 200px; resize:none" readonly><?php echo e($correciones[0]->objeto_estudio); ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <button type="button" class="btn btn-danger"
                                                            data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="row" style="margin-bottom:8px">
                            <label for="txtpoblacion" class="form-label">Población</label>
                            <div class="col-12 col-md-10">
                                <div class="form-floating">
                                    <textarea class="form-control" name="txtpoblacion" id="txtpoblacion" style="height: 100px; resize:none" required>
<?php if($tesis[0]->poblacion != ''): ?>
<?php echo e($tesis[0]->poblacion); ?>

<?php endif; ?>
</textarea>

                                </div>
                            </div>

                            <?php if(sizeof($correciones) != 0 && $tesis[0]->condicion == null): ?>
                                <?php if($correciones[0]->poblacion != null): ?>
                                    <div class="col-2">
                                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                            data-bs-target="#mCorreccionPoblacion">Correccion</button>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="modal" id="mCorreccionPoblacion">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Correccion de Poblacion</h4>
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal"></button>
                                            </div>
                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <div class="row" style="padding: 20px">
                                                    <div class="row my-2">
                                                        <textarea class="form-control" name="taNone" id="taNone" style="height: 200px; resize:none" readonly><?php echo e($correciones[0]->poblacion); ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <button type="button" class="btn btn-danger"
                                                            data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="row" style="margin-bottom:8px">
                            <label for="txtmuestra" class="form-label">Muestra</label>
                            <div class="col-12 col-md-10">
                                <div class="form-floating">
                                    <textarea class="form-control" name="txtmuestra" id="txtmuestra" style="height: 100px; resize:none" required>
<?php if($tesis[0]->muestra != ''): ?>
<?php echo e($tesis[0]->muestra); ?>

<?php endif; ?>
</textarea>
                                </div>
                            </div>

                            <?php if(sizeof($correciones) != 0 && $tesis[0]->condicion == null): ?>
                                <?php if($correciones[0]->muestra != null): ?>
                                    <div class="col-2">
                                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                            data-bs-target="#mCorreccionMuestra">Correccion</button>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="modal" id="mCorreccionMuestra">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Correccion de Muestra</h4>
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal"></button>
                                            </div>
                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <div class="row" style="padding: 20px">
                                                    <div class="row my-2">
                                                        <textarea class="form-control" name="taNone" id="taNone" style="height: 200px; resize:none" readonly><?php echo e($correciones[0]->muestra); ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <button type="button" class="btn btn-danger"
                                                            data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="row" style="margin-bottom:8px">
                            <label for="txtmetodos" class="form-label">Métodos</label>
                            <div class="col-12 col-md-10">
                                <div class="form-floating">
                                    <textarea class="form-control" name="txtmetodos" id="txtmetodos" style="height: 100px; resize:none" required>
<?php if($tesis[0]->metodos != ''): ?>
<?php echo e($tesis[0]->metodos); ?>

<?php endif; ?>
</textarea>

                                </div>
                            </div>

                            <?php if(sizeof($correciones) != 0 && $tesis[0]->condicion == null): ?>
                                <?php if($correciones[0]->metodos != null): ?>
                                    <div class="col-2">
                                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                            data-bs-target="#mCorreccionMetodos">Correccion</button>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="modal" id="mCorreccionMetodos">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Correccion de Metodos</h4>
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal"></button>
                                            </div>
                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <div class="row" style="padding: 20px">
                                                    <div class="row my-2">
                                                        <textarea class="form-control" name="taNone" id="taNone" style="height: 200px; resize:none" readonly><?php echo e($correciones[0]->metodos); ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <button type="button" class="btn btn-danger"
                                                            data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="row" style="margin-bottom:8px">
                            <label for="txttecnicas_instrum" class="form-label">Técnicas e instrumentos de
                                recolección
                                de datos</label>
                            <div class="col-12 col-md-10">
                                <div class="form-floating">
                                    <textarea class="form-control" name="txttecnicas_instrum" id="txttecnicas_instrum" type="text"
                                        value="" style="height: 100px; resize:none" required>
<?php if($tesis[0]->tecnicas_instrum != ''): ?>
<?php echo e($tesis[0]->tecnicas_instrum); ?>

<?php endif; ?>
</textarea>
                                </div>
                            </div>
                            <?php if(sizeof($correciones) != 0 && $tesis[0]->condicion == null): ?>
                                <?php if($correciones[0]->tecnicas_instrum != null): ?>
                                    <div class="col-2">
                                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                            data-bs-target="#mCorreccionTecInst">Correccion</button>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="modal" id="mCorreccionTecInst">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Correccion de Técnicas e instrumentos</h4>
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal"></button>
                                            </div>
                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <div class="row" style="padding: 20px">
                                                    <div class="row my-2">
                                                        <textarea class="form-control" name="taNone" id="taNone" style="height: 200px; resize:none" readonly><?php echo e($correciones[0]->tecnicas_instrum); ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <button type="button" class="btn btn-danger"
                                                            data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="row" style="margin-bottom:20px">
                            <h6>Instrumentación y/o fuentes de datos</h6>
                            <div class="col-12 col-md-10">
                                <div class="form-floating">
                                    <textarea class="form-control" name="txtinstrumentacion" id="txtinstrumentacion" type="text" value=""
                                        style="height: 100px; resize:none" required>
<?php if($tesis[0]->instrumentacion != ''): ?>
<?php echo e($tesis[0]->instrumentacion); ?>

<?php endif; ?>
</textarea>
                                </div>
                            </div>
                            <?php if(sizeof($correciones) != 0 && $tesis[0]->condicion == null): ?>
                                <?php if($correciones[0]->instrumentacion != null): ?>
                                    <div class="col-2">
                                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                            data-bs-target="#mCorreccionInsFD">Correccion</button>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="modal" id="mCorreccionInsFD">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Correccion de Instrumentación y/o fuentes de
                                                    datos
                                                </h4>
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal"></button>
                                            </div>
                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <div class="row" style="padding: 20px">
                                                    <div class="row my-2">
                                                        <textarea class="form-control" name="taNone" id="taNone" style="height: 200px; resize:none" readonly><?php echo e($correciones[0]->instrumentacion); ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <button type="button" class="btn btn-danger"
                                                            data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="row" style="margin-bottom:20px">
                            <h6>Estrategias Metodológicas</h6>
                            <div class="col-12 col-md-10">
                                <div class="form-floating">
                                    <textarea class="form-control" name="txtestg_metodologicas" id="txtestg_metodologicas"
                                        style="height: 100px; resize:none" required>
<?php if($tesis[0]->estg_metodologicas != ''): ?>
<?php echo e($tesis[0]->estg_metodologicas); ?>

<?php endif; ?>
</textarea>
                                </div>
                            </div>
                            <?php if(sizeof($correciones) != 0 && $tesis[0]->condicion == null): ?>
                                <?php if($correciones[0]->estg_metodologicas != null): ?>
                                    <div class="col-2">
                                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                            data-bs-target="#mCorreccionEstrategia">Correccion</button>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="modal" id="mCorreccionEstrategia">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Correccion de Estrategias Metodológicas</h4>
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal"></button>
                                            </div>
                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <div class="row" style="padding: 20px">
                                                    <div class="row my-2">
                                                        <textarea class="form-control" name="taNone" id="taNone" style="height: 200px; resize:none" readonly><?php echo e($correciones[0]->estg_metodologicas); ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <button type="button" class="btn btn-danger"
                                                            data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="row" style="margin-bottom:20px">
                            
                            <h6>Variables</h6>
                            <div class="col-8 col-md-7 col-xl-3">
                                <div class="row border-box" style="margin-bottom:20px">
                                    <div class="col-7 col-md-6" style="text-align:center">
                                        <p>Agregar una variable</p>
                                    </div>
                                    <div class="col-5 col-md-6">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#mVariable">
                                            Agregar
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <?php if(sizeof($correciones) != 0 && $tesis[0]->condicion == null): ?>
                                <?php if($correciones[0]->variables != null): ?>
                                    <div class="col-2">
                                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                            data-bs-target="#mCorreccionVariables">Correccion</button>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="modal" id="mCorreccionVariables">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Correccion de Variables</h4>
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal"></button>
                                            </div>
                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <div class="row" style="padding: 20px">
                                                    <div class="row my-2">
                                                        <textarea class="form-control" name="taNone" id="taNone" style="height: 200px; resize:none" readonly><?php echo e($correciones[0]->variables); ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <button type="button" class="btn btn-danger"
                                                            data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="row" style="margin-bottom:8px">
                                <div class="col-12">
                                    
                                    <table id="variableTable"
                                        class="table table-striped table-bordered table-condensed table-hover">
                                        <thead>
                                            <tr>
                                                <th>Descripcion</th>
                                                <th>Accion</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(sizeof($variableop) > 0): ?>
                                                <?php
                                                    $indVar = 0;
                                                ?>

                                                <?php $__currentLoopData = $variableop; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $var): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr id="filaV<?php echo e($indVar); ?>">
                                                        <td><?php echo e($var->descripcion); ?></td>
                                                        <td>
                                                            <a href="#" id="lvar-<?php echo e($indVar); ?>"
                                                                class="btn btn-warning"
                                                                onclick="deleteOldRecurso(this);">X</a>
                                                            <input type="hidden" id="xlvar-<?php echo e($indVar); ?>"
                                                                value="<?php echo e($var->cod_variable); ?>">
                                                        </td>
                                                    </tr>
                                                    <?php
                                                        $indVar++;
                                                    ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                            <input type="hidden" id="valNVariable"
                                                value="<?php echo e(sizeof($variableop)); ?>">
                                            <input type="hidden" name="listOldlvar" id="listOldlvar">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <h5>Matriz Operacional</h5>
                            <div class="col-10" id="noVariableMssg" <?php if($variableop->count() > 0): ?> hidden <?php endif; ?>>
                                <p>Necesita agregar una o más variables.</p>
                            </div>
                            <div class="table-responsive" id="matrizVariableTable" <?php if($variableop->count() <= 0): ?> hidden <?php endif; ?>>
                                <table class="table" id="table-matriz" style="border: 5px;">
                                    <thead>
                                        <tr>
                                            <th scope="col"></th>
                                            <th scope="col">VARIABLES</th>
                                            <th scope="col">DEFINICION CONCEPTUAL</th>
                                            <th scope="col">DEFINICION OPERACIONAL</th>
                                            <th scope="col">DIMENSIONES</th>
                                            <th scope="col">INDICADORES</th>
                                            <th scope="col">ESCALA</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if($matriz->count() > 0): ?>
                                            <tr id="table-matriz-tr">
                                                <td>VI</td>
                                                <td>
                                                    <select class="form-control" name="i_varI" id="rowMatrizVI">
                                                        <?php if($variableop->count()>0): ?>
                                                            <?php $__currentLoopData = $variableop; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($v->descripcion); ?>" <?php if($matriz[0]->variable_I == $v->descripcion): ?> selected <?php endif; ?>><?php echo e($v->descripcion); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <textarea class="form-control" name="i_dc" rows="3" cols="8">
<?php if($matriz[0]->def_conceptual_I != null): ?>
<?php echo e($matriz[0]->def_conceptual_I); ?>

<?php endif; ?>
</textarea>
                                                </td>
                                                <td>
                                                    <textarea class="form-control" name="i_do" rows="3" cols="8">
<?php if($matriz[0]->def_operacional_I != null): ?>
<?php echo e($matriz[0]->def_operacional_I); ?>

<?php endif; ?>
</textarea>
                                                </td>
                                                <td>
                                                    <textarea class="form-control" name="i_dim" rows="3" cols="8">
<?php if($matriz[0]->dimensiones_I != null): ?>
<?php echo e($matriz[0]->dimensiones_I); ?>

<?php endif; ?>
</textarea>
                                                </td>
                                                <td>
                                                    <textarea class="form-control" name="i_ind" rows="3" cols="8">
<?php if($matriz[0]->indicadores_I != null): ?>
<?php echo e($matriz[0]->indicadores_I); ?>

<?php endif; ?>
</textarea>
                                                </td>
                                                <td>
                                                    <textarea class="form-control" name="i_esc" rows="3" cols="8">
<?php if($matriz[0]->escala_I != null): ?>
<?php echo e($matriz[0]->escala_I); ?>

<?php endif; ?>
</textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>VD</td>
                                                <td>
                                                    <select class="form-control" name="d_varD" id="rowMatrizVD">
                                                        <?php if($variableop->count()>0): ?>
                                                            <?php $__currentLoopData = $variableop; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($v->descripcion); ?>" <?php if($matriz[0]->variable_D == $v->descripcion): ?> selected <?php endif; ?>><?php echo e($v->descripcion); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <textarea class="form-control" name="d_dc" rows="3" cols="8">
<?php if($matriz[0]->def_conceptual_D != null): ?>
<?php echo e($matriz[0]->def_conceptual_D); ?>

<?php endif; ?>
</textarea>
                                                </td>
                                                <td>
                                                    <textarea class="form-control" name="d_do" rows="3" cols="8">
<?php if($matriz[0]->def_operacional_D != null): ?>
<?php echo e($matriz[0]->def_operacional_D); ?>

<?php endif; ?>
</textarea>
                                                </td>
                                                <td>
                                                    <textarea class="form-control" name="d_dim" rows="3" cols="8">
<?php if($matriz[0]->dimensiones_D != null): ?>
<?php echo e($matriz[0]->dimensiones_D); ?>

<?php endif; ?>
</textarea>
                                                </td>
                                                <td>
                                                    <textarea class="form-control" name="d_ind" rows="3" cols="8">
<?php if($matriz[0]->indicadores_D != null): ?>
<?php echo e($matriz[0]->indicadores_D); ?>

<?php endif; ?>
</textarea>
                                                </td>
                                                <td>
                                                    <textarea class="form-control" name="d_esc" rows="3" cols="8">
<?php if($matriz[0]->escala_D != null): ?>
<?php echo e($matriz[0]->escala_D); ?>

<?php endif; ?>
</textarea>
                                                </td>
                                            </tr>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="6"><em>No existen datos</em></td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php if(sizeof($correciones) != 0 && $tesis[0]->condicion == null): ?>
                                <?php if($correciones[0]->matriz_op != null): ?>
                                    <div class="col-2">
                                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                            data-bs-target="#mCorreccionMatriz_op">Correccion</button>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="modal" id="mCorreccionMatriz_op">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Correccion de la Matriz Operacional</h4>
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal"></button>
                                            </div>
                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <div class="row" style="padding: 20px">
                                                    <div class="row my-2">
                                                        <textarea class="form-control" name="taNone" id="taNone" style="height: 200px; resize:none" readonly><?php echo e($correciones[0]->matriz_op); ?></textarea>

                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <button type="button" class="btn btn-danger"
                                                            data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="row" style=" margin-bottom:20px; padding-right:12px;"
                        <?php if($campos[0]->referencias_b == 0): ?> hidden <?php endif; ?>>
                        <div class="col-12">
                            <hr style="border: 1px solid gray">
                        </div>
                        <h5>Referencias bibliográficas</h5>
                        <div class="row">
                            <div class="row" style="margin-bottom:20px;">
                                <div class="col-8 col-md-4">
                                    <label for="cboTipoAPA" class="form-label">Tipo</label>
                                    <select name="cboTipoAPA" id="cboTipoAPA" class="form-select"
                                        onchange="setTypeAPA();" required>
                                        <option selected>-</option>
                                        <?php $__currentLoopData = $tiporeferencia; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($tipo->cod_tiporeferencia); ?>"><?php echo e($tipo->tipo); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <?php if(sizeof($correciones) != 0 && $tesis[0]->condicion == null): ?>
                                    <?php if($correciones[0]->referencias != null): ?>
                                        <div class="col-2">
                                            <button type="button" class="btn btn-outline-danger"
                                                data-bs-toggle="modal"
                                                data-bs-target="#mCorreccionReferencia">Correccion</button>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="modal" id="mCorreccionReferencia">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Correccion de las Referencias</h4>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <!-- Modal body -->
                                                <div class="modal-body">
                                                    <div class="row" style="padding: 20px">
                                                        <div class="row my-2">
                                                            <textarea class="form-control" name="taNone" id="taNone" style="height: 200px; resize:none" readonly><?php echo e($correciones[0]->referencias); ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Modal footer -->
                                                <div class="modal-footer">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <button type="button" class="btn btn-danger"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-12">
                                <div class="row border-box">
                                    <div class="item-card2">
                                        <div class="col-12">
                                            <label for="txtAutorAPA" class="form-label">Autor</label>
                                            <div class="row">
                                                <div class="col-6 col-xl-7">
                                                    <input class="form-control" name="txtAutorAPA" id="txtAutorAPA"
                                                        type="text" value="" placeholder="Nombre del autor">
                                                </div>
                                                <div class="col-4 col-xl-3" id="btnVariosAutores" hidden>
                                                    <input type="button" class="btn btn-success"
                                                        id="btnAgregaAutores" onclick="addAutor();" value="Agregar"
                                                        style="width:70px; font-size:1.2vh;">
                                                </div>
                                                <div class="col-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value=""
                                                            id="chkMasAutor" onclick="setVariosAutores();">
                                                        <label class="form-check-label" for="chkMasAutor">
                                                            Varios
                                                        </label>
                                                    </div>
                                                </div>
                                                <input type="hidden" id="array_autores">
                                            </div>
                                        </div>
                                        <div class="col-12" style="padding-top:5px;" id="rowVariosAutores" hidden>
                                            <div class="row" id="rowAddAutor"
                                                style="display: grid; grid-template-columns: repeat(auto-fill,minmax(9em,1fr)); grid-gap: 2px; ">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="item-card2">
                                        <label for="txtFechaPublicacion" class="form-label">Fecha de
                                            Publicacion</label>
                                        <input class="form-control" name="txtFechaPublicacion"
                                            id="txtFechaPublicacion" type="text" value=""
                                            placeholder="Fecha de publicacion">
                                    </div>
                                    <div class="item-card2">
                                        <label for="txtTituloTrabajo" class="form-label">Titulo del Trabajo</label>
                                        <input class="form-control" name="txtTituloTrabajo" id="txtTituloTrabajo"
                                            type="text" value="" placeholder="Titulo del trabajo">
                                    </div>
                                    <div class="item-card2">
                                        <label for="txtFuente" class="form-label">Fuente</label>
                                        <input class="form-control" name="txtFuente" id="txtFuente" type="text"
                                            value="" placeholder="Fuente para recuperacion">
                                    </div>
                                    <div class="item-card2" id="div-editorial" hidden>
                                        <label for="txtEditorial" class="form-label">Editorial</label>
                                        <input class="form-control" name="txtEditorial" id="txtEditorial"
                                            type="text" value="" placeholder="Editorial">
                                    </div>
                                    <div class="item-card2" id="div-titlecap" hidden>
                                        <label for="txtTitleCap" class="form-label">Titulo del Capitulo</label>
                                        <input class="form-control" name="txtTitleCap" id="txtTitleCap"
                                            type="text" value="" placeholder="Titulo del capitulo">
                                    </div>
                                    <div class="item-card2" id="div-numcap" hidden>
                                        <label for="txtNumCapitulo" class="form-label"># Capitulos</label>
                                        <input class="form-control" name="txtNumCapitulo" id="txtNumCapitulo"
                                            type="text" value="" placeholder="Numero del capitulo">
                                    </div>
                                    <div class="item-card2" id="div-titlerev" hidden>
                                        <label for="txtTitleRev" class="form-label">Titulo de Revista</label>
                                        <input class="form-control" name="txtTitleRev" id="txtTitleRev"
                                            type="text" value="" placeholder="Titulo de revista">
                                    </div>
                                    <div class="item-card2" id="div-volumen" hidden>
                                        <label for="txtVolumen" class="form-label">Volumen</label>
                                        <input class="form-control" name="txtVolumen" id="txtVolumen" type="text"
                                            value="" placeholder="Volumen">
                                    </div>
                                    <div class="item-card2" id="div-nameweb" hidden>
                                        <label for="txtNameWeb" class="form-label">Nombre de la Web</label>
                                        <input class="form-control" name="txtNameWeb" id="txtNameWeb" type="text"
                                            value="" placeholder="Nombre de la web">
                                    </div>
                                    <div class="item-card2" id="div-nameperiodista" hidden>
                                        <label for="txtNamePeriodista" class="form-label">Nombre del
                                            Periodista</label>
                                        <input class="form-control" name="txtNamePeriodista" id="txtNamePeriodista"
                                            type="text" value="" placeholder="Nombre del periodista">
                                    </div>
                                    <div class="item-card2" id="div-nameinsti" hidden>
                                        <label for="txtNameInsti" class="form-label">Nombre de la
                                            Institucion</label>
                                        <input class="form-control" name="txtNameInsti" id="txtNameInsti"
                                            type="text" value="" placeholder="Nombre de la institucion">
                                    </div>
                                    <div class="item-card2" id="div-subtitle" hidden>
                                        <label for="txtSubtitle" class="form-label">Sub titulo</label>
                                        <input class="form-control" name="txtSubtitle" id="txtSubtitle"
                                            type="text" value="" placeholder="Subtitulo">
                                    </div>
                                    <div class="item-card2" id="div-nameeditor" hidden>
                                        <label for="txtNameEditor" class="form-label">Nombre del editor</label>
                                        <input class="form-control" name="txtNameEditor" id="txtNameEditor"
                                            type="text" value="" placeholder="Nombre del Editor">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col">
                                    <span id="fullReference" name="fullReference" style="color: red"></span>
                                    <input type="button" class="btn btn-outline-primary" value="Agregar referencia"
                                        onclick="agregarReferenciaB();">
                                </div>
                            </div>
                        </div>


                        <div class="row" style="padding-top:15px;">
                            <div class="table-responsive">
                                <table id="detalleReferencias" class="table table-bordered ">
                                    <?php if($referencias->count() > 0): ?>
                                        <?php
                                            $indRef = 0;
                                        ?>
                                        <tbody>
                                            <?php $__currentLoopData = $referencias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ref): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr id="filaRe<?php echo e($indRef); ?>">
                                                    <td>
                                                        <a href="#" id="lref-<?php echo e($indRef); ?>"
                                                            class="btn btn-warning"
                                                            onclick="deleteOldRecurso(this);">X</a>
                                                        <input type="hidden" id="xlref-<?php echo e($indRef); ?>"
                                                            value="<?php echo e($obj->cod_referencias); ?>">
                                                    </td>
                                                    <td><?php echo e($ref->autor); ?></td>
                                                    <td><?php echo e($ref->fPublicacion); ?></td>
                                                    <td><?php echo e($ref->titulo); ?></td>
                                                    <td><?php echo e($ref->fuente); ?></td>
                                                    <td><?php echo e($ref->editorial); ?></td>
                                                    <td><?php echo e($ref->title_cap); ?></td>
                                                    <td><?php echo e($ref->num_capitulo); ?></td>
                                                    <td><?php echo e($ref->title_revista); ?></td>
                                                    <td><?php echo e($ref->volumen); ?></td>
                                                    <td><?php echo e($ref->name_web); ?></td>
                                                    <td><?php echo e($ref->name_periodista); ?></td>
                                                    <td><?php echo e($ref->name_institucion); ?></td>
                                                    <td><?php echo e($ref->subtitle); ?></td>
                                                    <td><?php echo e($ref->name_editor); ?></td>
                                                </tr>
                                                <?php
                                                    $indRef++;
                                                ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    <?php endif; ?>
                                    <input type="hidden" name="listOldlref" id="listOldlref">
                                </table>
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <input type="hidden" name="isSaved" id="isSaved" value="">
                        </div>
                    </div>
                    <div class="row" style=" margin-bottom:20px;">
                        <div class="d-grid gap-2 d-md-block">
                            <?php if($tesis[0]->estado == 0 || $tesis[0]->estado == 2 || $tesis[0]->estado == 9): ?>
                                <input type="button" class="btn btn-secondary" value="Guardar"
                                    onclick="guardarCopia();">
                            <?php endif; ?>
                            <?php if($tesis[0]->estado == 0 || $tesis[0]->estado == 2 || $tesis[0]->estado == 9): ?>
                                <input class="btn btn-primary" type="button" value="Enviar"
                                    onclick="registerProject();">
                            <?php endif; ?>
                            <a href="<?php echo e(route('user_information')); ?>" type="button"
                                class="btn btn-outline-danger ms-3">
                                <?php if($tesis[0]->estado == 0 || $tesis[0]->estado == 2): ?>
                                    Cancelar
                                <?php else: ?>
                                    Volver
                                <?php endif; ?>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        
        <div class="modal" id="mRecurso">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Recursos</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row" style="padding: 20px">
                            <div class="row my-2">
                                <div class="col-6">
                                    <select class="form-select" id="cboTipoRecurso" onchange="onChangeRecurso();">
                                        <option selected>-</option>
                                        <option value="1">Personal</option>
                                        <option value="2">Bienes</option>
                                        <option value="3">Servicios</option>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <select class="form-select" id="cboSubtipoRecurso" hidden>
                                        <option value="1">De consumo</option>
                                        <option value="2">De inversion</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <textarea class="form-control" name="taRecurso" id="taRecurso" style="height: 200px; resize:none"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-6">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            </div>
                            <div class="col-6">
                                <button type="button" class="btn btn-primary" onclick="agregarRecurso();"
                                    data-bs-dismiss="modal">Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="modal" id="mObjetivo">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Objetivo</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="row" style="padding: 20px">
                            <div class="row my-2">
                                <div class="col-6">
                                    <select class="form-select" id="cboObjetivo">
                                        <option selected>-</option>
                                        <option value="1">General</option>
                                        <option value="2">Especifico</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <textarea class="form-control" name="taObjetivo" id="taObjetivo" style="height: 200px; resize:none"></textarea>
                            </div>
                        </div>

                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-6">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            </div>
                            <div class="col-6">
                                <button type="button" class="btn btn-warning" onclick="agregarObjetivo();"
                                    data-bs-dismiss="modal">Guardar</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>


        
        <div class="modal fade" id="mVariable">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Variables</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row" style="padding: 20px">
                            <div class="row my-2">
                                <textarea class="form-control" name="taVariable" id="taVariable" style="height: 200px; resize:none"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-6">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            </div>
                            <div class="col-6">
                                <button type="button" class="btn btn-warning" onclick="agregarVariable();"
                                    data-bs-dismiss="modal">Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="./js/myjs.js"></script>
    <?php if(session('datos') == 'oknot'): ?>
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'No se ha podido Guardar/Enviar, revise si su informacion es correcta',
                showConfirmButton: true,
                timer: 2500
            })
        </script>
    <?php endif; ?>
    <script type="text/javascript">
        let variablesFromBd = <?php echo json_encode($variableop, 15, 512) ?>;
        let array_variable = [];
        let cronogramas_py_bd = <?php echo json_encode($cronogramas_py, 15, 512) ?>;
        let cronograma = <?php echo json_encode($cronograma, 15, 512) ?>;
        let lastMonth = 0;
        var existMes = false;
        if (document.getElementById('txtmeses_ejecucion').value != "") {
            setMeses();

        }

        /*Verificamos que los meses contiene valor*/
        if (cronogramas_py_bd.length > 0) {
            cronogramas_py_bd.forEach(function(item) {
                const separate = item.descripcion.split(",");
                separate.forEach(function(sp) {
                    const rango = sp.split("-");
                    if (rango.length > 1) {
                        for (let i = rango[0]; i <= rango[1]; i++) {
                            setColorInit(item.cod_cronograma + 'Tr' + i);
                        }
                        return;
                    }
                    setColorInit(item.cod_cronograma + 'Tr' + rango[0]);
                })
            });
        }
        if(variablesFromBd.length > 0){

            variablesFromBd.forEach(item =>{
                array_variable.push(item.descripcion);
            })
        }

        /*From myjs.js*/
        function agregarVariable(){
            let iVariable = array_variable.length;
            descripcion = document.getElementById("taVariable").value;
            fila = '<tbody><tr id="filaV'+iVariable+'"><td><input type="hidden" name="iddescripcionVar[]" value="'+descripcion+'">'+descripcion+'</td><td align="center"><a href="#" class="btn btn-warning" onclick="quitarVariable('+iVariable+');">X</a></td></tr></tbody>';
            document.getElementById('variableTable').innerHTML +=fila;
            document.getElementById('taVariable').value="";
            addTempVariable(descripcion);
            console.log(`after add: ${array_variable}`);
        }
        function quitarVariable(item){
            console.log(`to delete: ${array_variable[item]}`);
            document.getElementById('filaV'+item).remove();
            array_variable[item]="";
            console.log(`after delete: ${array_variable}`);
            updateMatriz();
            //iVariable--;
        }

        function addTempVariable(descripcion){
            array_variable.push(descripcion);
            updateMatriz();
        }
        function updateMatriz(){
            let stateViewMatriz = array_variable.length > 0;
            /* Cambiar estado de vista de los componentes */
            document.getElementById("noVariableMssg").hidden = stateViewMatriz;
            document.getElementById("matrizVariableTable").hidden = !stateViewMatriz;

            /* Generar select en la matriz */
            if(stateViewMatriz){
                let select1 = document.getElementById('rowMatrizVI');
                let select2 = document.getElementById('rowMatrizVD');
                select1.innerHTML = '';
                select2.innerHTML = '';

                array_variable.forEach(item => {
                    if(item!=""){
                        let option1 = document.createElement('option');
                        option1.value = item;
                        option1.text = item;
                        select1.appendChild(option1);

                        let option2 = document.createElement('option');
                        option2.value = item;
                        option2.text = item;
                        select2.appendChild(option2);
                    }
                });
            }
        }

        /*Funcion para agregar las celdas referentes de los meses de ejecucion*/
        function setMeses() {
            const activities = cronograma.length;
            if (existMes == false) {
                existMes = true;
                let meses = document.getElementById("txtmeses_ejecucion").value;
                lastMonth = meses;
                for (i = 1; i <= meses; i++) {
                    document.getElementById("headers").innerHTML += '<th id="Mes' + i + '" scope="col">Mes ' + i + '</th>';
                    for (let j = 1; j <= activities; j++) {
                        document.getElementById(j + "Tr").innerHTML += '<input type="hidden" id="n' + j + 'Tr' + i +
                            '" name="n' + j + 'Tr' + i +
                            '" value="0"><td id="' + j + 'Tr' + i +
                            '" onclick="<?php if(sizeof($tesis) > 0 && $tesis[0]->estado != 1): ?> setColorTable(this); <?php endif; ?>"></td>';
                    }
                }
            } else {
                for (i = 1; i <= lastMonth; i++) {

                    document.getElementById('Mes' + i).remove();
                    for (let j = 1; j <= activities; j++) {
                        document.getElementById('n' + j + 'Tr' + i).remove();
                        document.getElementById(j + 'Tr' + i).remove();
                    }
                }

                existMes = false;
                setMeses();
            }
        }

        function verifyVariableField(){
            const campos = <?php echo json_encode($campos, 15, 512) ?>;
            if(campos['formulacion_problema'] == 1){
                let selectVariableI = document.getElementById('rowMatrizVI').selectedIndex;
                let selectVariableD = document.getElementById('rowMatrizVD').selectedIndex;
                if(selectVariableI == selectVariableD){
                    alert('Se requiere que la variable INDEPENDIENTE sea distinta de la DEPENDIENTE.');
                    return false;
                }
                return true;
            }
            return true;
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usuario\Desktop\UNT\Escuela_Contabilidad\ProyectoActualizado\sistema-tesis-upao-unt\resources\views/cursoTesis20221/cursoTesis.blade.php ENDPATH**/ ?>