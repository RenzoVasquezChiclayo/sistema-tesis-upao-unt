<?php $__env->startSection('titulo'); ?>
    Tesis del Estudiante
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="./css/tesis_body.css">
<style type="text/css">
    .border-box{
        margin-bottom:8px;
        margin-left:5px;
        border: 0.5px solid rgba(0, 0, 0, 0.2);
        border-radius:20px;
        padding-top:5px;
        padding-bottom:10px;
    }

    .box-autor{
        height: 25px;
        font-size:1.2vh;
        white-space: nowrap;
        text-overflow: ellipsis;
    }

    .card-box {
        display: flex;
        flex-wrap: wrap;
    }
    .item-card {
        flex: 1 1 300px;
    }
    .item-card2 {
        flex: 1 1 500px;
    }
    textarea{
        resize:none;
    }
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contenido'); ?>
<div class="card-header text-center">
    <?php if(session('datos')): ?>
                <div id="mensaje">
                    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                        <?php echo e(session('datos')); ?>

                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
        <?php endif; ?>
    <div class="col-12" style="align-items: center">
        <h4>Tesis</h2>
    </div>
</div>
<div class="card-body">
    <?php
        $esEstadoValido = $Tesis[0]->estadoDesignacion <=1;
        $esResultadoVacio = sizeof($resultado) <= 0;
        $sinObservaciones = $verifyObs?->numObs <= 0 ?: true;
    ?>
    <form id="formProyecto" name="formProyecto" action="" method="">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="cod_tesis" value="<?php echo e($Tesis[0]->cod_tesis); ?>">
        <input type="hidden" name="id_grupo_hidden" value="<?php echo e($Tesis[0]->id_grupo_inves); ?>">
        <div class="col-12">
            <h4 >GENERALIDADES</h4>
            <hr style="border:1 px black;">
        </div>
        <div class="col-12">
            <div class="row" style=" margin-bottom:20px">
                <h5>Titulo</h5>
                <div class="col-12">
                    <div class="row" style="margin-bottom:8px">
                        <div class="col-9 col-md-8">
                            <input class="form-control" name="txtTitulo" id="txtTitulo" type="text" value="<?php echo e($Tesis[0]->titulo); ?>" readonly>
                            <span id="validateTitle" name="validateTitle" style="color: red"></span>
                        </div>
                        <?php if($Tesis[0]->estado==1): ?>
                        <div class="col-3">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input prueba" type="checkbox" id="chkCorregir1" onchange="chkCorregir(this);">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Corregir
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>


                    </div>
                </div>
            </div>
            <div class="row" style="margin-bottom:15px;">
                <div class="col-12">
                    <textarea class="form-control" name="tachkCorregir1" id="tachkCorregir1" cols="30" rows="4" hidden></textarea>
                </div>

            </div>
        </div>
        
        <div class="row" style=" margin-bottom:20px; padding-right:12px;">
            <h5>Autor(es)</h5>
            <?php $__currentLoopData = $estudiantes_grupo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $est): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="row" style="margin-bottom:8px;">
                    <div class="row">
                        <div class="col-5 col-md-3">
                            <input class="form-control" name="txtCodMatricula" id="txtCodMatricula" type="search" value="<?php echo e($est->cod_matricula); ?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="row border-box card-box" >
                    <div class="item-card col">
                        <label for="txtNombreAutor" class="form-label">Nombres</label>
                        <input class="form-control" name="txtNombreAutor" id="txtNombreAutor" type="text" value="<?php echo e($est->nombres); ?>" readonly>
                    </div>
                    <div class="item-card">
                        <label for="txtApellidoAutor" class="form-label">Apellidos</label>
                        <input class="form-control" name="txtApellidoAutor" id="txtApellidoAutor" type="text" value="<?php echo e($est->apellidos); ?>" readonly>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </div>
        <div class="row" style="margin-bottom:20px; padding-right:12px;">
            <h5>Asesor</h5>

            <div class="row border-box card-box">
                <div class="item-card">
                    <label for="txtNombreAsesor" class="form-label">Apellidos y Nombres</label>
                    <input class="form-control" name="txtNombreAsesor" id="txtNombreAsesor" type="text" value="<?php echo e($Tesis[0]->nombre_asesor); ?>" readonly>
                </div>
                <div class="item-card">
                    <label for="cboGrAcademicoAsesor" class="form-label">Grado Academico</label>
                    <input class="form-control" name="txtGrAcademicoAsesor" id="txtGrAcademicoAsesor" type="text" value="<?php echo e($Tesis[0]->grado_academico); ?>" readonly>
                </div>
                <div class="item-card">
                    <label for="txtTProfesional" class="form-label">Titulo Profesional</label>
                    <input class="form-control" name="txtTProfesional" id="txtTProfesional" type="text" value="" readonly>
                </div>
                <div class="item-card">
                    <label for="txtDireccionAsesor" class="form-label">Dirección laboral y/o domiciliaria</label>
                    <input class="form-control" name="txtDireccionAsesor" id="txtDireccionAsesor" type="text" value="<?php echo e($Tesis[0]->direccion_asesor); ?>" readonly>
                </div>
            </div>
        </div>
        <div class="row" style=" margin-bottom:20px">
            <h5>Dedicatoria </h5>
            <div class="row" style="margin-bottom:8px">
                <div class="col-12 col-md-10">
                    <div class="form-floating">
                        <textarea class="form-control" name="taDedicatoria" id="taDedicatoria" style="height: 100px; resize:none" readonly><?php echo e($Tesis[0]->dedicatoria); ?></textarea>
                    </div>
                </div>
                <?php if($Tesis[0]->estado==1): ?>
                <div class="col-2" >
                    <div class="row">
                        <div class="col-10">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="chkCorregir2" onchange="chkCorregir(this);">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Corregir
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <textarea class="form-control" name="tachkCorregir2" id="tachkCorregir2" cols="30" rows="4"  hidden></textarea>
        </div>
        <div class="row" style=" margin-bottom:20px">
            <h5>Agradecimiento</h5>
            <div class="row" style="margin-bottom:8px">
                <div class="col-12 col-md-10">
                    <div class="form-floating">
                        <textarea class="form-control" name="taAgradecimiento" id="taAgradecimiento" style="height: 100px; resize:none" readonly><?php echo e($Tesis[0]->agradecimiento); ?></textarea>
                    </div>
                </div>
                <?php if($Tesis[0]->estado==1): ?>
                <div class="col-2">
                    <div class="row">
                        <div class="col-10">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="chkCorregir3" onchange="chkCorregir(this);">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Corregir
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <textarea class="form-control" name="tachkCorregir3" id="tachkCorregir3" cols="30" rows="4"  hidden></textarea>
        </div>
        <div class="row" style=" margin-bottom:20px">
            <h5>Presentacion</h5>
            <div class="row" style="margin-bottom:8px">
                <div class="col-12 col-md-10">
                    <div class="form-floating">
                        <textarea class="form-control" name="taPresentacion" id="taPresentacion" style="height: 100px; resize:none" readonly><?php echo e($Tesis[0]->presentacion); ?></textarea>
                    </div>
                </div>
                <?php if($esEstadoValido && $esResultadoVacio && $sinObservaciones): ?>
                    <div class="col-2" align="center">
                        <div class="row">
                            <div class="col-10">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="chkCorregir4" onchange="chkCorregir(this);">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Corregir
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <textarea class="form-control" name="tachkCorregir4" id="tachkCorregir4" cols="30" rows="4"  hidden></textarea>
        </div>
        <div class="row" style=" margin-bottom:20px">
            <h5>Resumen</h5>
            <div class="row" style="margin-bottom:8px">
                <div class="col-12 col-md-10">
                    <div class="form-floating">
                        <textarea class="form-control" name="taResumen" id="taResumen" style="height: 100px; resize:none" readonly><?php echo e($Tesis[0]->resumen); ?></textarea>
                    </div>
                </div>
                <?php if($esEstadoValido && $esResultadoVacio && $sinObservaciones): ?>
                <div class="col-2" align="center">
                    <div class="row">
                        <div class="col-10">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="chkCorregir5" onchange="chkCorregir(this);">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Corregir
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <div class="row" style=" margin-bottom:20px;">
                <h5>Abstract</h5>
                <div class="col-12 col-md-10">
                    <textarea class="form-control" name="taabstract" id="taabstract" style="height: 100px; resize:none" readonly><?php echo e($Tesis[0]->abstract); ?></textarea>
                </div>
            </div>
            <textarea class="form-control" name="tachkCorregir5" id="tachkCorregir5" cols="30" rows="4"  hidden></textarea>
        </div>
        <div class="row" style=" margin-bottom:20px;">
            <h5>Palabras claves</h5>
            <div class="row mt-3 ms-1" id="chips">
                <input id="get_keyword" type="hidden" <?php if(sizeof($keywords)>0): ?>value="<?php echo e($keywords); ?>"<?php endif; ?>>
            </div>
        </div>
        <div class="row" style=" margin-bottom:20px">
            <h5>Introduccion</h5>
            <div class="row" style="margin-bottom:8px">
                <div class="col-12 col-md-10">
                    <div class="form-floating">
                        <textarea class="form-control" name="taIntroduccion" id="taIntroduccion" style="height: 100px; resize:none" readonly><?php echo e($Tesis[0]->introduccion); ?></textarea>
                    </div>
                </div>
                <?php if($esEstadoValido && $esResultadoVacio && $sinObservaciones): ?>
                <div class="col-2" align="center">
                    <div class="row">
                        <div class="col-10">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="chkCorregir6" onchange="chkCorregir(this);">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Corregir
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <textarea class="form-control" name="tachkCorregir6" id="tachkCorregir6" cols="30" rows="4"  hidden></textarea>
        </div>
        <div class="col-8">
            <h4>PLAN DE INVESTIGACION</h4>
            <hr style="border:1 px black;">
        </div>

        <div class="row" style=" margin-bottom:20px">
            <h5>Realidad problematica </h5>
            <div class="row" style="margin-bottom:8px">
                <div class="col-12 col-md-10">
                    <div class="form-floating">
                        <textarea class="form-control" name="taRProblematica" id="taRProblematica" style="height: 100px; resize:none" readonly><?php echo e($Tesis[0]->real_problematica); ?></textarea>
                    </div>
                </div>
                <?php if($esEstadoValido && $esResultadoVacio && $sinObservaciones): ?>
                <div class="col-2" align="center">
                    <div class="row">
                        <div class="col-10">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="chkCorregir7" onchange="chkCorregir(this);">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Corregir
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <textarea class="form-control" name="tachkCorregir7" id="tachkCorregir7" cols="30" rows="4"  hidden></textarea>
        </div>
        <div class="row" style=" margin-bottom:20px">
            <h5>Antecedentes</h5>
            <div class="row" style="margin-bottom:8px">
                <div class="col-12 col-md-10">
                    <div class="form-floating">
                        <textarea class="form-control" name="taAntecedentes" id="taAntecedentes" style="height: 100px; resize:none" readonly><?php echo e($Tesis[0]->antecedentes); ?></textarea>
                    </div>
                </div>
                <?php if($esEstadoValido && $esResultadoVacio && $sinObservaciones): ?>
                <div class="col-2" align="center">
                    <div class="row">
                        <div class="col-10">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="chkCorregir8" onchange="chkCorregir(this);">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Corregir
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <textarea class="form-control" name="tachkCorregir8" id="tachkCorregir8" cols="30" rows="4"  hidden></textarea>
        </div>
        <div class="row" style=" margin-bottom:20px">
            <h5>Justificación de la investigación</h5>
            <div class="row" style="margin-bottom:8px">
                <div class="col-12 col-md-10">
                    <div class="form-floating">
                        <textarea class="form-control" name="taJInvestigacion" id="taJInvestigacion" style="height: 100px; resize:none" readonly><?php echo e($Tesis[0]->justificacion); ?></textarea>
                    </div>
                </div>
                <?php if($esEstadoValido && $esResultadoVacio && $sinObservaciones): ?>
                <div class="col-2" align="center">
                    <div class="row">
                        <div class="col-10">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="chkCorregir9" onchange="chkCorregir(this);">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Corregir
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <textarea class="form-control" name="tachkCorregir9" id="tachkCorregir9" cols="30" rows="4"  hidden></textarea>
        </div>
        <div class="row" style=" margin-bottom:20px">
            <h5>Formulación del problema</h5>
            <div class="row" style="margin-bottom:8px">
                <div class="col-12 col-md-10">
                    <div class="form-floating">
                        <textarea class="form-control" name="taFProblema" id="taFProblema" style="height: 100px; resize:none" readonly><?php echo e($Tesis[0]->formulacion_prob); ?></textarea>
                    </div>
                </div>
                <?php if($esEstadoValido && $esResultadoVacio && $sinObservaciones): ?>
                <div class="col-2" align="center">
                    <div class="row">
                        <div class="col-10">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="chkCorregir10" onchange="chkCorregir(this);">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Corregir
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <textarea class="form-control" name="tachkCorregir10" id="tachkCorregir10" cols="30" rows="4"  hidden></textarea>
        </div>
        <div class="row" style=" margin-bottom:20px">
            <h5>Objetivos</h5>
            <div class="col-8 col-md-5 col-xl-11">
                <table class="table table-striped table-bordered ">
                    <thead>
                        <tr>
                            <th>Tipo</th>
                            <th>Descripcion</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $objetivos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $obj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($obj->tipo); ?></td>
                                <td><?php echo e($obj->descripcion); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            <?php if($esEstadoValido && $esResultadoVacio && $sinObservaciones): ?>
            <div class="col-1" align="center">
                <div class="row">
                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="chkCorregir11" onchange="chkCorregir(this);">
                            <label class="form-check-label" for="flexCheckDefault">
                                Corregir
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <textarea class="form-control" name="tachkCorregir11" id="tachkCorregir11" cols="30" rows="4" hidden></textarea>
        </div>
        
        <div class="row" style=" margin-bottom:20px">
            <div class="row" style="margin-bottom:15px">
                <div class="col-12">
                    <hr style="border: 1px solid gray">
                </div>
                <h5>Marco Teórico</h5>
                <div class="row">
                    <div class="col-12 col-md-10">
                        <div class="form-floating">
                            <textarea class="form-control" name="taMTeorico" id="taMTeorico" style="height: 100px; resize:none" readonly><?php echo e($Tesis[0]->marco_teorico); ?></textarea>
                        </div>
                    </div>
                    <?php if($esEstadoValido && $esResultadoVacio && $sinObservaciones): ?>
                    <div class="col-2" align="center">
                        <div class="row">
                            <div class="col-10">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="chkCorregir12" onchange="chkCorregir(this);">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Corregir
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                <textarea class="form-control" name="tachkCorregir12" id="tachkCorregir12" cols="30" rows="4"  hidden></textarea>
            </div>

            <div class="row" style="margin-bottom:15px">
                <h5>Marco Conceptual</h5>
                <div class="row">
                    <div class="col-12 col-md-10">
                        <div class="form-floating">
                            <textarea class="form-control" name="taMConceptual" id="taMConceptual" style="height: 100px; resize:none" readonly><?php echo e($Tesis[0]->marco_conceptual); ?></textarea>
                        </div>
                    </div>
                    <?php if($esEstadoValido && $esResultadoVacio && $sinObservaciones): ?>
                    <div class="col-2" align="center">
                        <div class="row">
                            <div class="col-0">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="chkCorregir13" onchange="chkCorregir(this);">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Corregir
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                <textarea class="form-control" name="tachkCorregir13" id="tachkCorregir13" cols="30" rows="4"  hidden></textarea>
            </div>

            <div class="row" style="margin-bottom:15px">
                <h5>Marco Legal</h5>
                <div class="row">
                    <div class="col-12 col-md-10">
                        <div class="form-floating">
                            <textarea class="form-control" name="taMLegal" id="taMLegal" style="height: 100px; resize:none" readonly><?php echo e($Tesis[0]->marco_legal); ?></textarea>
                        </div>
                    </div>
                    <?php if($esEstadoValido && $esResultadoVacio && $sinObservaciones): ?>
                    <div class="col-2" align="center">
                        <div class="row">
                            <div class="col-10">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="chkCorregir14" onchange="chkCorregir(this);">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Corregir
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                <textarea class="form-control" name="tachkCorregir14" id="tachkCorregir14" cols="30" rows="4"  hidden></textarea>
            </div>
        </div>

        <div class="row" style=" margin-bottom:20px">
            <h5>Formulación de la hipótesis </h5>
            <div class="row" style="margin-bottom:8px">
                <div class="row">
                    <div class="col-12 col-md-10">
                        <div class="form-floating">
                            <textarea class="form-control" name="taFHipotesis" id="taFHipotesis" style="height: 100px; resize:none" readonly><?php echo e($Tesis[0]->form_hipotesis); ?></textarea>
                        </div>
                    </div>
                    <?php if($esEstadoValido && $esResultadoVacio && $sinObservaciones): ?>
                    <div class="col-2" align="center">
                        <div class="row">
                            <div class="col-10">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="chkCorregir15" onchange="chkCorregir(this);">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Corregir
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                <textarea class="form-control" name="tachkCorregir15" id="tachkCorregir15" cols="30" rows="4"  hidden></textarea>
            </div>
        </div>

        <div class="row" style=" margin-bottom:20px">
            <div class="row">
                
                <h5>Diseño de Investigación</h5>
                <h6>Material, Métodos y Técnicas</h6>
                <hr style="width: 60%; margin-left:15px;"/>
            </div>
            <div class="row" style="margin-bottom:8px">
                <label for="taOEstudio" class="form-label">Objeto de Estudio</label>
                <div class="col-12 col-md-10">
                    <div class="form-floating">
                        <textarea class="form-control" name="taOEstudio" id="taOEstudio" style="height: 100px; resize:none" readonly><?php echo e($Tesis[0]->objeto_estudio); ?></textarea>
                    </div>
                </div>
                <?php if($esEstadoValido && $esResultadoVacio && $sinObservaciones): ?>
                <div class="col-2" align="center">
                    <div class="row">
                        <div class="col-10">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="chkCorregir16" onchange="chkCorregir(this);">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Corregir
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <textarea class="form-control" name="tachkCorregir16" id="tachkCorregir16" cols="30" rows="4"  hidden></textarea>
            </div>
            <div class="row" style="margin-bottom:8px">
                <label for="taPoblacion" class="form-label">Población</label>
                <div class="col-12 col-md-10">
                    <div class="form-floating">
                        <textarea class="form-control" name="taPoblacion" id="taPoblacion" style="height: 100px; resize:none" readonly><?php echo e($Tesis[0]->poblacion); ?></textarea>
                    </div>
                </div>
                <?php if($esEstadoValido && $esResultadoVacio && $sinObservaciones): ?>
                <div class="col-2" align="center">
                    <div class="row">
                        <div class="col-10">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="chkCorregir17" onchange="chkCorregir(this);">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Corregir
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <textarea class="form-control" name="tachkCorregir17" id="tachkCorregir17" cols="30" rows="4"  hidden></textarea>
            </div>
            <div class="row" style="margin-bottom:8px">
                <label for="taMuestra" class="form-label">Muestra</label>
                <div class="col-12 col-md-10">
                    <div class="form-floating">
                        <textarea class="form-control" name="taMuestra" id="taMuestra" style="height: 100px; resize:none" readonly><?php echo e($Tesis[0]->muestra); ?></textarea>
                    </div>
                </div>
                <?php if($esEstadoValido && $esResultadoVacio && $sinObservaciones): ?>
                <div class="col-2" align="center">
                    <div class="row">
                        <div class="col-10">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="chkCorregir18" onchange="chkCorregir(this);">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Corregir
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <textarea class="form-control" name="tachkCorregir18" id="tachkCorregir18" cols="30" rows="4"  hidden></textarea>
            </div>
            <div class="row" style="margin-bottom:8px">
                <label for="taMetodos" class="form-label">Métodos</label>
                <div class="col-12 col-md-10">
                    <div class="form-floating">
                        <textarea class="form-control" name="taMetodos" id="taMetodos" style="height: 100px; resize:none" readonly><?php echo e($Tesis[0]->metodos); ?></textarea>
                    </div>
                </div>
                <?php if($esEstadoValido && $esResultadoVacio && $sinObservaciones): ?>
                <div class="col-2" align="center">
                    <div class="row">
                        <div class="col-10">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="chkCorregir19" onchange="chkCorregir(this);">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Corregir
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <textarea class="form-control" name="tachkCorregir19" id="tachkCorregir19" cols="30" rows="4"  hidden></textarea>
            </div>
            <div class="row" style="margin-bottom:8px">
                <label for="taRecoleccionDatos" class="form-label">Técnicas e instrumentos de recolección de datos</label>
                <div class="col-12 col-md-10">
                    <div class="form-floating">
                        <textarea class="form-control" name="taRecoleccionDatos" id="taRecoleccionDatos" type="text" style="height: 100px; resize:none" readonly><?php echo e($Tesis[0]->tecnicas_instrum); ?></textarea>
                    </div>
                </div>
                <?php if($esEstadoValido && $esResultadoVacio && $sinObservaciones): ?>
                 <div class="col-2" align="center">
                    <div class="row">
                        <div class="col-10">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="chkCorregir20" onchange="chkCorregir(this);">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Corregir
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <textarea class="form-control" name="tachkCorregir20" id="tachkCorregir20" cols="30" rows="4"  hidden></textarea>
            </div>
            <div class="row" style="margin-bottom:20px">
                <h6>Instrumentación y/o fuentes de datos</h6>
                <div class="col-12 col-md-10">
                    <div class="form-floating">
                        <textarea class="form-control" name="taFuentesDatos" id="taFuentesDatos" type="text" style="height: 100px; resize:none" readonly><?php echo e($Tesis[0]->instrumentacion); ?></textarea>
                    </div>
                </div>
                <?php if($esEstadoValido && $esResultadoVacio && $sinObservaciones): ?>
                    <div class="col-2" align="center">
                    <div class="row">
                        <div class="col-10">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="chkCorregir21" onchange="chkCorregir(this);">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Corregir
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <textarea class="form-control" name="tachkCorregir21" id="tachkCorregir21" cols="30" rows="4"  hidden></textarea>
            </div>
            <div class="row" style="margin-bottom:20px">
                <h6>Estrategias Metodológicas</h6>
                <div class="col-12 col-md-10">
                    <div class="form-floating">
                        <textarea class="form-control" name="taEstrategiasM" id="taEstrategiasM" style="height: 100px; resize:none" readonly><?php echo e($Tesis[0]->estg_metodologicas); ?></textarea>
                    </div>
                </div>
                <?php if($esEstadoValido && $esResultadoVacio && $sinObservaciones): ?>
                    <div class="col-2" align="center">
                    <div class="row">
                        <div class="col-10">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="chkCorregir22" onchange="chkCorregir(this);">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Corregir
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <textarea class="form-control" name="tachkCorregir22" id="tachkCorregir22" cols="30" rows="4"  hidden></textarea>
            </div>
            <div class="row" style=" margin-bottom:20px">
                <h5>Resultados</h5>
                <div class="row" style="margin-bottom:8px">
                    <div class="row">
                        <div class="col-12 col-md-10">
                            <div class="form-floating">
                                <textarea class="form-control" name="taresultados" id="taresultados" style="height: 100px; resize:none" readonly><?php echo e($Tesis[0]->resultados); ?></textarea>
                            </div>
                        </div>
                        <?php if($esEstadoValido && $esResultadoVacio && $sinObservaciones): ?>
                        <div class="col-2" align="center">
                            <div class="row">
                                <div class="col-10">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="chkCorregir23" onchange="chkCorregir(this);">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Corregir
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div id="resultados_contenedor" class="row m-3" hidden>
                        <input name="resultados_getImg" id="resultados_getImg" type="hidden" value="<?php echo e($resultadosImg); ?>">
                        <input name="resultados_getTxt" id="resultados_getTxt" type="hidden" value="<?php echo e($Tesis[0]->resultados); ?>">
                    </div>
                    <textarea class="form-control" name="tachkCorregir23" id="tachkCorregir23" cols="30" rows="4"  hidden></textarea>
                </div>
            </div>
            <div class="row" style=" margin-bottom:20px">
                <h5>Discusion</h5>
                <div class="row" style="margin-bottom:8px">
                    <div class="row">
                        <div class="col-12 col-md-10">
                            <div class="form-floating">
                                <textarea class="form-control" name="taDiscusion" id="taDiscusion" style="height: 100px; resize:none" readonly><?php echo e($Tesis[0]->discusion); ?></textarea>
                            </div>
                        </div>
                        <?php if($esEstadoValido && $esResultadoVacio && $sinObservaciones): ?>
                        <div class="col-2" align="center">
                            <div class="row">
                                <div class="col-10">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="chkCorregir24" onchange="chkCorregir(this);">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Corregir
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                    <textarea class="form-control" name="tachkCorregir24" id="tachkCorregir24" cols="30" rows="4"  hidden></textarea>
                </div>
            </div>
            <div class="row" style=" margin-bottom:20px">
                <h5>Conclusiones</h5>
                <div class="row" style="margin-bottom:8px">
                    <div class="row">
                        <div class="col-12 col-md-10">
                            <div class="form-floating">
                                <textarea class="form-control" name="taConclusiones" id="taConclusiones" style="height: 100px; resize:none" readonly><?php echo e($Tesis[0]->conclusiones); ?></textarea>
                            </div>
                        </div>
                        <?php if($esEstadoValido && $esResultadoVacio && $sinObservaciones): ?>
                        <div class="col-2" align="center">
                            <div class="row">
                                <div class="col-10">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="chkCorregir25" onchange="chkCorregir(this);">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Corregir
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                    <textarea class="form-control" name="tachkCorregir25" id="tachkCorregir25" cols="30" rows="4"  hidden></textarea>
                </div>
            </div>
            <div class="row" style=" margin-bottom:20px">
                <h5>Recomendaciones</h5>
                <div class="row" style="margin-bottom:8px">
                    <div class="row">
                        <div class="col-12 col-md-10">
                            <div class="form-floating">
                                <textarea class="form-control" name="taRecomendaciones" id="taRecomendaciones" style="height: 100px; resize:none" readonly><?php echo e($Tesis[0]->recomendaciones); ?></textarea>
                            </div>
                        </div>
                        <?php if($esEstadoValido && $esResultadoVacio && $sinObservaciones): ?>
                        <div class="col-2" align="center">
                            <div class="row">
                                <div class="col-10">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="chkCorregir26" onchange="chkCorregir(this);">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Corregir
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                    <textarea class="form-control" name="tachkCorregir26" id="tachkCorregir26" cols="30" rows="4"  hidden></textarea>
                </div>
            </div>
        </div>
        <div class="row" style=" margin-bottom:20px; padding-right:12px;">
            <div class="col-12">
                <hr style="border: 1px solid gray">
            </div>
            <h5>Referencias bibliográficas</h5>
            <div class="col-8 col-md-7 col-xl-11">
                <table class="table table-striped table-bordered ">
                    <tbody>
                        <?php $__currentLoopData = $referencias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ref): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
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
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            <?php if($esEstadoValido && $esResultadoVacio && $sinObservaciones): ?>
                  <div class="col-1" align="center">
                <div class="row">
                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="chkCorregir27" onchange="chkCorregir(this);">
                            <label class="form-check-label" for="flexCheckDefault">
                                Corregir
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <textarea class="form-control" name="tachkCorregir27" id="tachkCorregir27" cols="30" rows="4" hidden></textarea>
        </div>
        <div class="row" style=" margin-bottom:20px;">
            <h5>Anexos</h5>
            <div class="row" style="margin-bottom:8px">
                <div class="col-12 col-md-10">
                    <textarea class="form-control" name="txtanexos[]" id="taanexos" readonly><?php if($Tesis[0]->anexos != null): ?><?php echo e($Tesis[0]->anexos); ?><?php endif; ?></textarea>
                </div>
                <?php if($esEstadoValido && $esResultadoVacio && $sinObservaciones): ?>
                <div class="col-1" align="center">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="chkCorregir28" onchange="chkCorregir(this);">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Corregir
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <textarea class="form-control" name="tachkCorregir28" id="tachkCorregir28" cols="30" rows="4" hidden></textarea>
            </div>
            <div id="anexos_contenedor" class="row m-3" hidden>
                <input name="anexos_getImg" id="anexos_getImg" type="hidden" value="<?php echo e($anexosImg); ?>">
                <input name="anexos_getTxt" id="anexos_getTxt" type="hidden" value="<?php echo e($Tesis[0]->anexos); ?>">
            </div>
        </div>
        <input type="hidden" name="validacionTesis" id="validacionTesis" value="<?php echo e($camposFull); ?>">
        <div class="d-flex" style="padding-top: 20px; padding-bottom:20px;">
            <?php if($esEstadoValido && $esResultadoVacio && $sinObservaciones): ?>
                <div class="">
                    <input class="btn btn-primary" type="button" value="Guardar Observaciones" onclick="uploadTesis();" style="margin-right:20px;">
                </div>
            <?php endif; ?>
            <div class="">
                <a href="<?php echo e(route('jurado.listaTesisAsignadas')); ?>" type="button" class="btn btn-outline-danger">Cancelar</a>
            </div>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="./js/asesor-tesis-2022.js"></script>
    <?php if(session('datos')=='oknot'): ?>
        <script>
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'No se ha podido guardar las observaciones, revise si su informacion es correcta',
                showConfirmButton: true,
                timer: 2500
            })
        </script>
    <?php endif; ?>
    <script type="text/javascript">
        let array_chk = new Array(30);
        array_chk.fill(0,0);
        array_chk[0] = 99;

        function aprobarProy(){
            Swal.fire({
                title: 'Estas seguro(a)?',
                text: "La Tesis sera APROBADA!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, APROBAR!',
                cancelButtonText: 'Cancelar',
                }).then((result) => {
                if (result.isConfirmed) {
                    document.formProyecto.action = "<?php echo e(route('asesor.aprobar-tesis')); ?>";
                    document.formProyecto.method = "POST";
                    document.formProyecto.submit();
                }
            })
        }

        function desaprobarProy(){
            Swal.fire({
                title: 'Estas seguro(a)?',
                text: "La Tesis sera DESAPROBADA!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, DESAPROBAR!',
                cancelButtonText: 'Cancelar',
                }).then((result) => {
                if (result.isConfirmed) {
                    document.formProyecto.action = "<?php echo e(route('asesor.desaprobar-tesis')); ?>";
                    document.formProyecto.method = "POST";
                    document.formProyecto.submit();
                }
            })
        }

        function uploadTesis(){

            let hayCorreccion = false;
            for(let i=1; i<=28;i++){
                if(array_chk[i] == 1){
                    if(document.getElementById('tachkCorregir'+i).value != ""){
                        hayCorreccion = true;
                        break;
                    }
                }
            }
            if(!hayCorreccion){
                Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Necesita realizar una observacion'
                })
            }else{
                Swal.fire({
                title: 'Estas seguro(a)?',
                text: "Se guardaran las observaciones!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, guardar!',
                cancelButtonText: 'Cancelar',
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.formProyecto.action = "<?php echo e(route('jurado.guardarObservacionTesis')); ?>";
                        document.formProyecto.method = "POST";
                        document.formProyecto.submit();
                    }
                })
            }
        }

        function chkCorregir(check){
            const idcheck = check.id
            const numero_check = idcheck.split('chkCorregir');
            if(document.getElementById(check.id).checked){
                document.getElementById('ta'+check.id).hidden = false;
                array_chk[numero_check[1]] = 1;
            }else{
                array_chk[numero_check[1]] = 0;
                document.getElementById('ta'+check.id).hidden = true;
                document.getElementById('ta'+check.id).value = "";
            }
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usuario\Desktop\UNT\Escuela_Contabilidad\ProyectoActualizado\sistema-tesis-upao-unt\resources\views/cursoTesis20221/asesor/evaluacion/detalleTesisAsignada.blade.php ENDPATH**/ ?>