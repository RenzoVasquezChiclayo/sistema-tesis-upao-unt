<?php $__env->startSection('titulo'); ?>
    Evaluacion Tesis
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="./css/tesis_body.css">
<style type="text/css">
    .border-box {
        border: 0.5px solid rgba(0, 0, 0, 0.2);
        border-radius: 20px;
        padding: 10px 0px;
        margin: 0;
    }

    .item-card2 {
        flex: 1 1 500px;
        margin-bottom: 10px;
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

    .title-p{
        text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.35);
    }

    .agrega_text {
        width: 100%;
    }
    .agrega_text tr td{
        max-width: 0;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .td_descripcion{
        width: 60%;
    }
    .input-counter{
        border:none;
        width:90px;
    }
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contenido'); ?>
<title>Evaluación de Tesis</title>
    <?php if(sizeof($enabledView) <= 0): ?>
        <div class="row d-flex" style="align-items:center; justify-content: center;">
            <div class="col-8 border-box mt-3">
                <div class="row">
                    <div class="col">
                        <h4 style="color:red;">Aviso!</h4>
                        <hr style="border: 1px solid black;" />
                    </div>

                    <div class="col">
                        <p>Esta vista estará habilitada cuando se apruebe tu tesis.
                            Si existe algun inconveniente y/o queja envia un correo a <a href="#">
                                <>example@unitru.edu.pe</u>
                            </a> para mas información.</p>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="col-12">
            <?php if($tesis->estadoDesignacion == 3): ?>
                <div class="row p-2" style="background-color: rgb(77, 153, 77);">
                    <div class="col alert-correction" style="text-align: center;">
                        <p>TESIS APROBADO!</p>
                    </div>
                </div>
            <?php elseif($tesis->estadoDesignacion == 4): ?>
                <div class="row p-2" style="background-color: rgb(148, 91, 91);">
                    <div class="col col-md-6 alert-correction" style="text-align: center;">
                        <p>TESIS DESAPROBADO!</p>
                    </div>
                </div>
            <?php elseif(sizeof($observaciones) != 0): ?>
                <div class="row p-2" style="text-align:center;">
                    <div class="col col-md-6 alert-correction">
                        <p>Se realizaron las correciones correspondientes.</p>
                    </div>
                </div>
            <?php endif; ?>
            <div class="card-header">
                Evaluación de Tesis
            </div>
            <div class="card-body">
                <div class="row">
                    <form id="formTesis2022" name="formTesis2022" action="<?php echo e(route('estudiante.evaluacion.actualizarTesis')); ?>" method="POST"
                        enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="col">
                            <h4>ESTRUCTURA</h4>
                            <hr style="border:1 px black; width: 70%;">

                            <input id="verificaCorrect" type="hidden"
                                value="">
                            <input type="hidden" name="cod_tesis" value="<?php echo e($tesis->cod_tesis); ?>">
                            <input type="hidden" id="txtValuesObs" value="">
                        </div>
                        <div class="col-12 mb-3">
                            <input type="hidden" name="textcod" value="<?php echo e($tesis->cod_tesis); ?>">
                            <div class="row" id="auxObstitulo">
                                <h5>Título</h5>
                                <div class="col-10">
                                    <div class="row gy-1 gy-sm-0">
                                        <div class="col-12 col-sm-10">
                                            <input class="form-control" name="txttitulo" id="txttitulo" type="text"
                                                value="<?php if($tesis->titulo != null): ?><?php echo e($tesis->titulo); ?><?php endif; ?>"
                                                placeholder="Ingrese el titulo de la tesis">
                                            <span class="ps-2" id="validateTitle" name="validateTitle"
                                                style="color: red"></span>
                                        </div>
                                        <div class="col-2">
                                            <input type="button" value="Verificar" onclick="validaText();"
                                                class="btn btn-success">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col mb-3">
                            <h5>Autor(es)</h5>
                            <div class="row my-2">
                                <div class="row">
                                    <div style="width:auto;">
                                        <input class="form-control" name="txtCodMatricula" id="txtCodMatricula" type="search"
                                            value="<?php echo e($estudiante->cod_matricula); ?>" placeholder="Codigo de Matricula" readonly>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row border-box">
                                <div class="col-12 col-sm-6">
                                    <label for="txtNombreAutor" class="form-label">Nombres</label>
                                    <input class="form-control" name="txtNombreAutor" id="txtNombreAutor" type="text"
                                        value="<?php echo e($estudiante->nombres); ?>" placeholder="Nombres" readonly>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <label for="txtApellidoAutor" class="form-label">Apellidos</label>
                                    <input class="form-control" name="txtApellidoAutor" id="txtApellidoAutor" type="text"
                                        value="<?php echo e($estudiante->apellidos); ?>" placeholder="Apellidos" readonly>
                                </div>
                            </div>
                            
                            <?php if($coautor != null): ?>
                                <div class="row my-2">
                                    <div class="row">
                                        <div style="width:auto;">
                                            <input class="form-control" name="txtCodMatricula" id="txtCodMatricula" type="search"
                                                value="<?php echo e($coautor->cod_matricula); ?>" placeholder="Codigo de Matricula" readonly>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row border-box">
                                    <div class="col-12 col-sm-6">
                                        <label for="txtNombreAutor" class="form-label">Nombres</label>
                                        <input class="form-control" name="txtNombreAutor" id="txtNombreAutor" type="text"
                                            value="<?php echo e($coautor->nombres); ?>" placeholder="Nombres" readonly>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <label for="txtApellidoAutor" class="form-label">Apellidos</label>
                                        <input class="form-control" name="txtApellidoAutor" id="txtApellidoAutor" type="text"
                                            value="<?php echo e($coautor->apellidos); ?>" placeholder="Apellidos" readonly>
                                    </div>
                                </div>
                            <?php endif; ?>

                        </div>
                        <div class="col mb-3">
                            <h5>Asesor</h5>
                            <div class="row my-2">
                                <div class="row">
                                    <div style="width:auto;">
                                        <input class="form-control" name="txtCodDocente" id="txtCodDocente" type="text"
                                            value="<?php echo e($tesis->cod_docente); ?>" placeholder="Codigo del Docente" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row border-box">
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                    <label for="txtNombreAsesor" class="form-label">Apellidos y Nombres</label>
                                    <input class="form-control" name="txtNombreAsesor" id="txtNombreAsesor" type="text"
                                        value="<?php echo e($asesor->nombres); ?>" placeholder="Apellidos y nombres" readonly>
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
                        
                        <div class="row" id="auxObsdedicatoria" style=" margin-bottom:20px;">
                            <div class="col col-sm-9">
                                <h5>Dedicatoria</h5>
                            </div>
                            <div class="col-3">
                                <button <?php if($tesis->dedicatoria == null): ?> hidden <?php endif; ?> id="icon-dedicatoria" type="button" class="btn btn-danger" onclick="displayOptional(this);"><i class='bx bx-xs bx-minus'></i></button>
                            </div>
                            <div class="row mt-2" style="margin-bottom:8px">
                                <div class="col-12 col-md-10">
                                    <button id="btn-dedicatoria" class="btn btn-primary" type="button" onclick="displayOptional(this);" <?php if($tesis->dedicatoria != null): ?> hidden <?php endif; ?>>Agregar</button>
                                    <div id="d-dedicatoria" class="form-floating" <?php if($tesis->dedicatoria == null): ?> hidden <?php endif; ?>>
                                        <textarea class="form-control" name="txtdedicatoria" id="txtdedicatoria" style="height: 150px;"><?php if($tesis->dedicatoria != null): ?><?php echo e($tesis->dedicatoria); ?><?php endif; ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row" id="auxObsagradecimiento" style=" margin-bottom:20px;">
                            <div class="col col-sm-9">
                                <h5>Agradecimiento</h5>
                            </div>
                            <div class="col-3">
                                <button <?php if($tesis->agradecimiento == null): ?> hidden <?php endif; ?> id="icon-agradecimiento" type="button" class="btn btn-danger" onclick="displayOptional(this);"><i class='bx bx-xs bx-minus'></i></button>
                            </div>
                            <div class="row mt-2" style="margin-bottom:8px">
                                <div class="col-12 col-md-10">
                                    <button id="btn-agradecimiento" class="btn btn-primary" type="button" onclick="displayOptional(this);" <?php if($tesis->agradecimiento != null): ?> hidden <?php endif; ?>>Agregar</button>
                                    <div id="d-agradecimiento" class="form-floating" <?php if($tesis->agradecimiento == null): ?> hidden <?php endif; ?>>
                                        <textarea class="form-control" name="txtagradecimiento" id="txtagradecimiento" style="height: 150px;"><?php if($tesis->agradecimiento != null): ?><?php echo e($tesis->agradecimiento); ?><?php endif; ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style=" margin-bottom:20px;">
                            <h5>Presentacion</h5>
                            <div class="row" id="auxObspresentacion" style="margin-bottom:8px">
                                <div class="col-12 col-md-10">
                                    <textarea class="form-control" name="txtpresentacion" id="txtpresentacion" ><?php if($tesis->presentacion != null): ?><?php echo e($tesis->presentacion); ?><?php endif; ?></textarea>
                                </div>
                            </div>

                        </div>
                        <div class="row" id="auxObsresumen" style=" margin-bottom:20px;">
                            <div class="col-12">
                                <h5>Resumen</h5>
                                <div class="row" style="margin-bottom:8px">
                                    <div class="col-12 col-md-10">
                                        <textarea class="form-control" name="txtresumen" id="txtresumen" ><?php if($tesis->resumen != null): ?><?php echo e($tesis->resumen); ?><?php endif; ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <h5>Abstract</h5>
                                <div class="row" style="margin-bottom:8px">
                                    <div class="col-12 col-md-10">
                                        <textarea class="form-control" name="txtabstract" id="txtabstract" ><?php if($tesis->abstract != null): ?><?php echo e($tesis->abstract); ?><?php endif; ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="auxObskeyword" style=" margin-bottom:20px;">
                            <h5>Palabras claves</h5>
                            <div class="col col-sm-4">
                                <div class="input-group">
                                    <input class="form-control" type="text" id="i_keyword" placeholder="Palabra clave">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-success" id="btn_agregark" onclick="addKeyword();">Agregar</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3 ms-1" id="chips">
                                <input id="get_keyword" type="hidden" <?php if(sizeof($keywords)>0): ?>value="<?php echo e($keywords); ?>"<?php endif; ?>>
                                <input id="list_keyword" name="list_keyword" type="hidden">
                                <input type="hidden" name="deleted_keyword" id="deleted_keyword">
                                <!-- Se crea mediante js -->
                            </div>
                        </div>
                        <div class="row" style=" margin-bottom:20px;">
                            <h5>Introduccion</h5>
                            <div class="row" id="auxObsintroduccion" style="margin-bottom:8px">
                                <div class="col-12 col-md-10">
                                    <textarea class="form-control" name="txtintroduccion" id="txtintroduccion" ><?php if($tesis->introduccion != null): ?><?php echo e($tesis->introduccion); ?><?php endif; ?></textarea>
                                </div>
                            </div>

                        </div>


                        
                        <?php
                            $iGRUPO = 0;
                        ?>
                        <div class="row" style=" margin-bottom:20px">
                            <div class="col-8">
                                <h4>PLAN DE INVESTIGACION</h4>
                                <hr style="border:1 px black;">
                            </div>


                            <h5>Realidad problematica </h5>


                            <div class="row" id="auxObsreal_problematica" style="margin-bottom:8px">
                                <div class="col-12 col-md-10">
                                    <textarea class="form-control" name="txtreal_problematica" id="txtreal_problematica" ><?php if($tesis->real_problematica != null): ?><?php echo e($tesis->real_problematica); ?><?php endif; ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row" style=" margin-bottom:20px">
                            <h5>Antecedentes</h5>
                            <div class="row" id="auxObsactecedentes" style="margin-bottom:8px">
                                <div class="col-12 col-md-10">
                                    <textarea class="form-control" name="txtantecedentes" id="txtantecedentes" ><?php if($tesis->antecedentes != null): ?><?php echo e($tesis->antecedentes); ?><?php endif; ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row" style=" margin-bottom:20px">
                            <h5>Justificación de la investigación</h5>
                            <div class="row" id="auxObsjustificacion" style="margin-bottom:8px">
                                <div class="col-12 col-md-10">
                                    <textarea class="form-control" name="txtjustificacion" id="txtjustificacion" ><?php if($tesis->justificacion != null): ?><?php echo e($tesis->justificacion); ?><?php endif; ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row" style=" margin-bottom:20px">
                            <h5>Formulación del problema</h5>
                            <div class="row" id="auxObsformulacion_prob" style="margin-bottom:8px">
                                <div class="col-12 col-md-10">
                                    <textarea class="form-control" name="txtformulacion_prob" id="txtformulacion_prob" ><?php if($tesis->formulacion_prob != null): ?><?php echo e($tesis->formulacion_prob); ?><?php endif; ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row" id="auxObsobjetivos" style=" margin-bottom:20px">
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
                                                            <?php if((sizeof($observaciones) > 0 && $observaciones[0]->objetivos != null) || $tesis->estado != 1): ?>
                                                                <a href="#" id="lobj-<?php echo e($indObj); ?>"
                                                                    class="btn btn-warning"
                                                                    onclick="deleteOldData(this);">X</a>
                                                            <?php endif; ?>
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

                        
                        <div class="row" style=" margin-bottom:20px">
                            <div class="row" id="auxObsmarco_teorico" style="margin-bottom:15px">
                                <div class="col-12">
                                    <hr style="border: 1px solid gray">
                                </div>
                                <h5>Marco Teórico</h5>
                                <div class="col-12 col-md-10">
                                    <textarea class="form-control" name="txtmarco_teorico" id="txtmarco_teorico" ><?php if($tesis->marco_teorico != null): ?><?php echo e($tesis->marco_teorico); ?><?php endif; ?></textarea>
                                </div>
                            </div>

                            <div class="row" id="auxObsmarco_conceptual" style="margin-bottom:15px">
                                <h5>Marco Conceptual</h5>
                                <div class="col-12 col-md-10">
                                    <textarea class="form-control" name="txtmarco_conceptual" id="txtmarco_conceptual" ><?php if($tesis->marco_conceptual != null): ?><?php echo e($tesis->marco_conceptual); ?><?php endif; ?></textarea>
                                </div>
                            </div>

                            <div class="row" id="auxObsmarco_legal" style="margin-bottom:15px">
                                <h5>Marco Legal</h5>
                                <div class="col-12 col-md-10">
                                    <textarea class="form-control" name="txtmarco_legal" id="txtmarco_legal" ><?php if($tesis->marco_legal != null): ?><?php echo e($tesis->marco_legal); ?><?php endif; ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row" style=" margin-bottom:20px">
                            <h5>Formulación de la hipótesis </h5>
                            <div class="row" id="auxObsform_hipotesis" style="margin-bottom:8px">
                                <div class="col-12 col-md-10">
                                    <textarea class="form-control" name="txtform_hipotesis" id="txtform_hipotesis" ><?php if($tesis->form_hipotesis != null): ?><?php echo e($tesis->form_hipotesis); ?><?php endif; ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row" style=" margin-bottom:20px">
                            <div class="row">
                                
                                <h5>Diseño de Investigación</h5>
                                <h6>Material, Métodos y Técnicas</h6>
                                <hr style="width: 60%; margin-left:15px;" />
                            </div>
                            <div class="row" id="auxObsobjeto_estudio" style="margin-bottom:8px">
                                <label for="txtobjeto_estudio" class="form-label">Objeto de Estudio</label>
                                <div class="col-12 col-md-10">
                                    <textarea class="form-control" name="txtobjeto_estudio" id="txtobjeto_estudio" ><?php if($tesis->objeto_estudio != null): ?><?php echo e($tesis->objeto_estudio); ?><?php endif; ?></textarea>
                                </div>
                            </div>
                            <div class="row" id="auxObspoblacion" style="margin-bottom:8px">
                                <label for="txtpoblacion" class="form-label">Población</label>
                                <div class="col-12 col-md-10">
                                    <textarea class="form-control" name="txtpoblacion" id="txtpoblacion" ><?php if($tesis->poblacion != null): ?><?php echo e($tesis->poblacion); ?><?php endif; ?></textarea>
                                </div>
                            </div>
                            <div class="row" id="auxObsmuestra" style="margin-bottom:8px">
                                <label for="txtmuestra" class="form-label">Muestra</label>
                                <div class="col-12 col-md-10">
                                    <textarea class="form-control" name="txtmuestra" id="txtmuestra" ><?php if($tesis->muestra != null): ?><?php echo e($tesis->muestra); ?><?php endif; ?></textarea>
                                </div>
                            </div>
                            <div class="row" id="auxObsmetodos" style="margin-bottom:8px">
                                <label for="txtmetodos" class="form-label">Métodos</label>
                                <div class="col-12 col-md-10">
                                    <textarea class="form-control" name="txtmetodos" id="txtmetodos" ><?php if($tesis->metodos != null): ?><?php echo e($tesis->metodos); ?><?php endif; ?></textarea>
                                </div>
                            </div>
                            <div class="row" id="auxObstecnicas_instrum" style="margin-bottom:8px">
                                <label for="txttecnicas_instrum" class="form-label">Técnicas e instrumentos de recolección
                                    de datos</label>
                                <div class="col-12 col-md-10">
                                    <textarea class="form-control" name="txttecnicas_instrum" id="txttecnicas_instrum" type="text" ><?php if($tesis->tecnicas_instrum != null): ?><?php echo e($tesis->tecnicas_instrum); ?><?php endif; ?></textarea>
                                </div>
                            </div>
                            <div class="row" id="auxObsinstrumentacion" style="margin-bottom:20px">
                                <h6>Instrumentación y/o fuentes de datos</h6>
                                <div class="col-12 col-md-10">
                                    <textarea class="form-control" name="txtinstrumentacion" id="txtinstrumentacion" type="text" value="" ><?php if($tesis->instrumentacion != null): ?><?php echo e($tesis->instrumentacion); ?><?php endif; ?></textarea>
                                </div>
                            </div>
                            <div class="row" id="auxObsestg_metodologicas" style="margin-bottom:20px">
                                <h6>Estrategias Metodológicas</h6>
                                <div class="col-12 col-md-10">
                                    <textarea class="form-control" name="txtestg_metodologicas" id="txtestg_metodologicas"
                                        ><?php if($tesis->estg_metodologicas != null): ?><?php echo e($tesis->estg_metodologicas); ?><?php endif; ?></textarea>
                                </div>
                            </div>

                        </div>
                        <div class="row" id="auxObsresultados" style=" margin-bottom:20px;">
                            <h5>Resultados</h5>
                            <div class="row" style="margin-bottom:8px">
                                <div class="col-12 col-md-10">
                                    <textarea class="form-control" name="txtresultados[]" id="txtresultados" ><?php if($tesis->resultados != null): ?><?php echo e($tesis->resultados); ?><?php endif; ?></textarea>
                                </div>
                            </div>
                            <div id="resultados_contenedor" class="row m-3" hidden>
                                <input name="resultados_getImg" id="resultados_getImg" type="hidden" value="<?php echo e($resultadosImg); ?>">
                                <input name="resultados_getTxt" id="resultados_getTxt" type="hidden" value="<?php echo e($tesis->resultados); ?>">
                                <input name="resultados_sendRow" id="resultados_sendRow" type="hidden">
                            </div>
                            <div class="col-12 m-1">
                                <button id="resultados_btn_addImage" class="btn btn-primary" type="button" onclick="addRowImage(this);">Agregar imagenes</button>
                                <button id="resultados_btn_addField" class="btn btn-outline-primary" type="button" onclick="addTextField(this);" hidden>Agregar campo</button>
                            </div>
                        </div>
                        <div class="row" id="auxObsdiscusion" style=" margin-bottom:20px;">
                            <h5>Discusión</h5>
                            <div class="row" style="margin-bottom:8px">
                                <div class="col-12 col-md-10">
                                    <textarea class="form-control" name="txtdiscucion" id="txtdiscucion" ><?php if($tesis->discusion != null): ?><?php echo e($tesis->discusion); ?><?php endif; ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row" style=" margin-bottom:20px;">
                            <h5>Conclusiones</h5>
                            <div class="row" id="auxObsconclusiones"  style="margin-bottom:8px">
                                <div class="col-12 col-md-10">
                                    <textarea class="form-control" name="txtconclusiones" id="txtconcluciones" ><?php if($tesis->conclusiones != null): ?><?php echo e($tesis->conclusiones); ?><?php endif; ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row" style=" margin-bottom:20px;">
                            <h5>Recomendaciones</h5>
                            <div class="row" id="auxObsrecomendaciones" style="margin-bottom:8px">
                                <div class="col-12 col-md-10">
                                    <textarea class="form-control" name="txtrecomendaciones" id="txtrecomendaciones" ><?php if($tesis->recomendaciones != null): ?><?php echo e($tesis->recomendaciones); ?><?php endif; ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row" style=" margin-bottom:20px; padding-right:12px;">
                            <div class="col-12">
                                <hr style="border: 1px solid gray">
                            </div>
                            <h5>Referencias bibliográficas</h5>
                            <div class="row">
                                <div class="row mb-3" id="auxObsreferencias" >
                                    <div class="col-8 col-md-4">
                                        <label for="cboTipoAPA" class="form-label">Tipo</label>
                                        <select name="cboTipoAPA" id="cboTipoAPA" class="form-select"
                                            onchange="setTypeAPA();" required>
                                            <option selected>-</option>
                                            <?php $__currentLoopData = $tiporeferencia; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($tipo->cod_tiporeferencia); ?>"><?php echo e($tipo->tipo); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="row border-box mb-3">
                                        <div class="item-card2">
                                            <div class="col-12">
                                                <label for="txtAutorAPA" class="form-label">Autor</label>
                                                <div class="row">
                                                    <div class="col-6 col-xl-7">
                                                        <input class="form-control" name="txtAutorAPA" id="txtAutorAPA"
                                                            type="text" value="" placeholder="Nombre del autor">
                                                    </div>
                                                    <div class="col-6 col-xl-5 d-flex">
                                                        <div class="me-3" id="btnVariosAutores" hidden>
                                                            <input type="button" class="btn btn-success" id="btnAgregaAutores"
                                                                onclick="addAutor();" value="Agregar">
                                                        </div>
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
                                            <label for="txtFechaPublicacion" class="form-label">Fecha de Publicacion</label>
                                            <input class="form-control" name="txtFechaPublicacion" id="txtFechaPublicacion"
                                                type="text" value="" placeholder="Fecha de publicacion">
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
                                            <input class="form-control" name="txtEditorial" id="txtEditorial" type="text"
                                                value="" placeholder="Editorial">
                                        </div>
                                        <div class="item-card2" id="div-titlecap" hidden>
                                            <label for="txtTitleCap" class="form-label">Titulo del Capitulo</label>
                                            <input class="form-control" name="txtTitleCap" id="txtTitleCap" type="text"
                                                value="" placeholder="Titulo del capitulo">
                                        </div>
                                        <div class="item-card2" id="div-numcap" hidden>
                                            <label for="txtNumCapitulo" class="form-label"># Capitulos</label>
                                            <input class="form-control" name="txtNumCapitulo" id="txtNumCapitulo"
                                                type="text" value="" placeholder="Numero del capitulo">
                                        </div>
                                        <div class="item-card2" id="div-titlerev" hidden>
                                            <label for="txtTitleRev" class="form-label">Titulo de Revista</label>
                                            <input class="form-control" name="txtTitleRev" id="txtTitleRev" type="text"
                                                value="" placeholder="Titulo de revista">
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
                                            <label for="txtNamePeriodista" class="form-label">Nombre del Periodista</label>
                                            <input class="form-control" name="txtNamePeriodista" id="txtNamePeriodista"
                                                type="text" value="" placeholder="Nombre del periodista">
                                        </div>
                                        <div class="item-card2" id="div-nameinsti" hidden>
                                            <label for="txtNameInsti" class="form-label">Nombre de la Institucion</label>
                                            <input class="form-control" name="txtNameInsti" id="txtNameInsti" type="text"
                                                value="" placeholder="Nombre de la institucion">
                                        </div>
                                        <div class="item-card2" id="div-subtitle" hidden>
                                            <label for="txtSubtitle" class="form-label">Sub titulo</label>
                                            <input class="form-control" name="txtSubtitle" id="txtSubtitle" type="text"
                                                value="" placeholder="Subtitulo">
                                        </div>
                                        <div class="item-card2" id="div-nameeditor" hidden>
                                            <label for="txtNameEditor" class="form-label">Nombre del editor</label>
                                            <input class="form-control" name="txtNameEditor" id="txtNameEditor"
                                                type="text" value="" placeholder="Nombre del Editor">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-2">
                                        <span id="fullReference" name="fullReference" style="color: red"></span>
                                        <input type="button" class="btn btn-outline-primary" value="Agregar referencia"
                                            onclick="agregarReferenciaB();">
                                    </div>
                                </div>
                            </div>


                            <div class="row" style="padding-top:15px;">
                                <div class="col-12 table-responsive-sm">
                                    <table id="detalleReferencias" class="table table-bordered ">
                                        <?php if($referencias->count() > 0): ?>
                                            <?php
                                                $indRef = 0;
                                            ?>
                                            <tbody>
                                                <?php $__currentLoopData = $referencias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ref): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr id="filaRe<?php echo e($indRef); ?>">
                                                        <td>
                                                            <?php if($tesis->estado != 1): ?>
                                                                <a href="#" id="lref-<?php echo e($indRef); ?>"
                                                                    class="btn btn-warning"
                                                                    onclick="deleteOldData(this);">X</a>
                                                            <?php endif; ?>
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
                        <div class="row" style=" margin-bottom:20px;">
                            <h5>Anexos</h5>
                            <div class="row" id="auxObsanexos"  style="margin-bottom:8px">
                                <div class="col-12 col-md-10">
                                    <textarea class="form-control" name="txtanexos[]" id="txtanexos"><?php if($tesis->anexos != null): ?><?php echo e($tesis->anexos); ?><?php endif; ?></textarea>
                                </div>
                            </div>
                            <div id="anexos_contenedor" class="row m-3" hidden>
                                <input name="anexos_getImg" id="anexos_getImg" type="hidden" value="<?php echo e($anexosImg); ?>">
                                <input name="anexos_getTxt" id="anexos_getTxt" type="hidden" value="<?php echo e($tesis->anexos); ?>">
                                <input name="anexos_sendRow" id="anexos_sendRow" type="hidden">
                            </div>
                            <div class="col-12 m-1">
                                <button id="anexos_btn_addImage" class="btn btn-primary" type="button" onclick="addRowImage(this);">Agregar imagenes</button>
                                <button id="anexos_btn_addField" class="btn btn-outline-primary" type="button" onclick="addTextField(this);" hidden>Agregar campo</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <input type="hidden" name="isSaved" id="isSaved" value="">
                            </div>
                        </div>

                        <div class="row" style=" margin-bottom:20px;">
                            <div class="d-grid gap-2 d-md-block">

                                <?php if($tesis->estadoDesignacion == 2 || $tesis->estadoDesignacion == 9): ?>
                                    <input type="button" class="btn btn-outline-success" value="Guardar" onclick="guardarCopia();">
                                    <input class="btn btn-success" type="button" value="Enviar"
                                        onclick="registerProject();">
                                <?php endif; ?>
                                <a href="<?php echo e(route('user_information')); ?>" type="button" class="btn btn-danger"
                                    style="margin-left:20px;">
                                    Volver
                                </a>
                            </div>
                        </div>
                    </form>
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
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="./js/script-tesis-2022.js"></script>
    <?php if(session('datos') == 'oknot'): ?>
            <script>
                Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Error al guardar la Tesis',
                showConfirmButton: false,
                timer: 1500
                })
            </script>
    <?php endif; ?>
    <script type="text/javascript">
        let observations = <?php echo json_encode($observaciones, 15, 512) ?>;
        console.log(observations);
        let filterObservations = [];
        let finalObs = {};
        const arrayAttributeName = [
            'cod_historial_observacion',
            'id_observacion',
            'created_at',
            'updated_at',
            'estado'
        ];
        const secondFilter = [
            'apellidosAsesor',
            'nombresAsesor',
            'cod_jurado'
        ];
        initObservations();
        function initObservations(){
            observations.forEach(observation => {
                const filteredObservation = {};

                // Eliminar atributos con valor null
                Object.keys(observation).forEach(key => {
                    if (observation[key] !== null && !arrayAttributeName.includes(key)) {
                        filteredObservation[key] = observation[key];
                    }
                });
                filterObservations.push(filteredObservation);
            });
            configureObservations();
        }

        function configureObservations(){
            filterObservations.forEach(obs =>{
                // Eliminar atributos con valor null
                Object.keys(obs).forEach(key => {
                    if(!secondFilter.includes(key)){
                        if(finalObs[key]!=null){
                            let arrayExtra = [{'jurado':`${obs['apellidosAsesor']}, ${obs['nombresAsesor']}`,'obs':`${obs[key]}`},finalObs[key]];
                            finalObs[key] = arrayExtra.flat(5);
                        }else{
                            finalObs[key] = [{'jurado':`${obs['apellidosAsesor']}, ${obs['nombresAsesor']}`,'obs':`${obs[key]}`}];
                        }
                    }
                });
            });
            setModelToObservations();
        }
        function setModelToObservations(){
            Object.keys(finalObs).forEach(key => {
                const newModal = `<div class="col-2">
                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#mCorreccion${key}">Correccion</button>
                    </div>
                    <div class="modal" id="mCorreccion${key}">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Correccion del ${key}</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row" style="padding: 20px">
                                        ${finalObs[key].map(obs => `<p><strong>${obs['jurado']}</strong>:<br> ${obs['obs']}</p><br>`).join('')}
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <div class="row">
                                        <div class="col-6">
                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;
                document.getElementById(`auxObs${key}`).innerHTML+=newModal;
            });

        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usuario\Desktop\UNT\Escuela_Contabilidad\ProyectoActualizado\sistema-tesis-upao-unt\resources\views/cursoTesis20221/estudiante/evaluacion/documentoTesis.blade.php ENDPATH**/ ?>