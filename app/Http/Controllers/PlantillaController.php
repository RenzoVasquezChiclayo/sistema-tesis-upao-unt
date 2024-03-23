<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AsesorCurso;
use App\Models\Diseno_Investigacion;
use App\Models\Fin_Persigue;
use App\Models\Objetivo;
use App\Models\recursos;
use App\Models\referencias;
use App\Models\TDetalleKeyword;
use App\Models\TesisCT2022;
use App\Models\TipoInvestigacion;
use App\Models\TObjetivo;
use App\Models\TReferencias;
use App\Models\variableOP;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Settings;

class PlantillaController extends Controller
{
    public function descargaUNTTesis(Request $request)
    {

        $cod_Tesis = $request->cod_cursoTesis;
        $lineKeywords = "";
        //HOSTING
        $tesis = DB::table('tesis_2022 as t')
            ->join('detalle_grupo_investigacion as d_g', 'd_g.id_grupo_inves', '=', 't.id_grupo_inves')
            ->join('estudiante_ct2022', 'estudiante_ct2022.cod_matricula', '=', 'd_g.cod_matricula')
            ->join('asesor_curso', 't.cod_docente', '=', 'asesor_curso.cod_docente')
            ->select('t.*', 'estudiante_ct2022.nombres as nombresAutor', 'estudiante_ct2022.apellidos as apellidosAutor', 'estudiante_ct2022.correo as correoEstudi', 'asesor_curso.*')
            ->where('t.cod_tesis', $cod_Tesis)->get();

        // Dedicatoria
        $dedicatoria = $tesis[0]->dedicatoria;
        // Agradecimiento
        $agradecimiento = $tesis[0]->agradecimiento;
        // Presentacion
        $presentacion = $tesis[0]->presentacion;
        // Resumen
        $resumen = $tesis[0]->resumen;
        // Abstract
        $abstract = $tesis[0]->abstract;
        // Keywords
        $keywords = TDetalleKeyword::join('t_keyword', 't_detalle_keyword.id_keyword', '=', 't_keyword.id_keyword')
            ->join('tesis_2022', 't_keyword.cod_tesis', '=', 'tesis_2022.cod_tesis')
            ->select('t_detalle_keyword.*')->get();

        foreach ($keywords as $key) {
            $lineKeywords .= $key->keyword . ',';
        }

        // Introduccion
        $introduccion = $tesis[0]->introduccion;

        //HOSTING
        /*Datos del Autor*/
        if (count($tesis) > 1) {
            $Autor1 = $tesis[0]->nombresAutor . ' ' . $tesis[0]->apellidosAutor;
            $Autor2 = $tesis[1]->nombresAutor . ' ' . $tesis[1]->apellidosAutor;
        } else {
            $nombres = $tesis[0]->nombresAutor . ' ' . $tesis[0]->apellidosAutor;
        }


        /*Datos del Asesor*/
        $orcid_asesor = $tesis[0]->orcid;
        $nombre_asesor = $tesis[0]->nombres;
        $grado_asesor = $tesis[0]->cod_grado_academico;
        $titulo_asesor = $tesis[0]->cod_categoria;
        $direccion_asesor = $tesis[0]->direccion;

        /*Proyecto de Investigacion y/o Tesis*/
        $titulo = $tesis[0]->titulo;

        /*Realidad problematica y others*/
        $real_problematica = $tesis[0]->real_problematica;

        $antecedentes = $tesis[0]->antecedentes;
        $justificacion = $tesis[0]->justificacion;
        $formulacion_prob = $tesis[0]->formulacion_prob;

        /*Hipotesis y disenio*/
        $form_hipotesis = $tesis[0]->form_hipotesis;

        /*Material, metodos y tecnicas*/
        $objeto_estudio = $tesis[0]->objeto_estudio;
        $poblacion = $tesis[0]->poblacion;
        $muestra = $tesis[0]->muestra;
        $metodos = $tesis[0]->metodos;
        $tecnicas_instrum = $tesis[0]->tecnicas_instrum;

        /*Instrumentacion*/
        $instrumentacion = $tesis[0]->instrumentacion;

        /*Estrateg. metodologicas*/
        $estg_metodologicas = $tesis[0]->estg_metodologicas;

        /*Marco teorico*/
        $marco_teorico = $tesis[0]->marco_teorico;
        $marco_conceptual = $tesis[0]->marco_conceptual;
        $marco_legal = $tesis[0]->marco_legal;

        $resultados = $tesis[0]->resultados;
        $anexos = $tesis[0]->anexos;

        $discusion = $tesis[0]->discusion;
        $conclusiones = $tesis[0]->conclusiones;
        $recomendaciones = $tesis[0]->recomendaciones;

        Settings::setOutputEscapingEnabled(true);

        $word = new PhpWord();

        /* Creacion de las fuentes */
        $word->setDefaultFontName('Times New Roman');
        $word->setDefaultFontSize(11);


        $titulos = 'titulos';
        $word->addFontStyle($titulos, array('bold' => true));

        /* Estilos de la caratula */
        $styleCaratula1 = 'styleCaratula1';
        $word->addParagraphStyle($styleCaratula1, array('align' => 'center', 'spacing' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.08)));

        $styleCaratula2 = 'styleCaratula2';
        $word->addParagraphStyle($styleCaratula2, array('align' => 'left', 'spacing' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.08)));

        $styleTitulo = 'styleTitulo';
        $word->addParagraphStyle($styleTitulo, array('align' => 'center', 'spacing' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.08)));

        $styleContenido = 'styleContenido';
        $word->addParagraphStyle($styleContenido, array('align' => 'left', 'spacing' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.08)));

        $tituloCaratula = 'tituloCaratula';
        $word->addFontStyle($tituloCaratula, array('name' => 'Arial', 'bold' => true, 'size' => 16, 'position' => 'raised'));

        $subtitCaratula1 = 'subtitCaratual1';
        $word->addFontStyle($subtitCaratula1, array('name' => 'Arial', 'bold' => true, 'size' => 12, 'align' => 'center'));
        $subtitCaratula2 = 'subtitCaratual2';
        $word->addFontStyle($subtitCaratula2, array('name' => 'Arial', 'bold' => true, 'size' => 12, 'align' => 'center'));

        $titProyCaratula = 'titProyCaratula';
        $word->addFontStyle($titProyCaratula, array('name' => 'Arial', 'bold' => true, 'size' => 12, 'align' => 'justify'));

        $styleImage = array('align' => 'center', 'width' => 280, 'height' => 200);

        // /* ------------------------------- */

        // /* CARATULA */

        $caratulaSesion = $word->addSection();



        $caratulaSesion->addText("UNIVERSIDAD NACIONAL DE TRUJILLO", $tituloCaratula, $styleCaratula1);
        $caratulaSesion->addText("FACULTAD DE CIENCIAS ECONOMICAS", $subtitCaratula1, $styleCaratula1);
        $caratulaSesion->addText("ESCUELA PROFESIONAL DE CONTABILIDAD Y FINANZAS", $subtitCaratula2, $styleCaratula1);

        $caratulaSesion->addImage("img/logoUNTcaratula.png", $styleImage);

        $caratulaSesion->addText($titulo, $titProyCaratula, $styleCaratula1);
        $caratulaSesion->addTextBreak(1.5);

        $caratulaSesion->addText("TESIS", array('name' => 'Arial', 'bold' => true, 'size' => 12), $styleCaratula1);
        $caratulaSesion->addText("Para obtener el Titulo Profesional de:", array('name' => 'Arial', 'bold' => true, 'size' => 12), $styleCaratula1);

        $caratulaSesion->addText("Contabilidad y Finanzas", array('name' => 'Arial', 'bold' => true, 'size' => 12), $styleCaratula1);

        $caratulaSesion->addTextBreak(2);

        $caratulaSesion->addText("Autor (es)", array('name' => 'Arial', 'bold' => true, 'size' => 12, 'align' => 'justify'), $styleCaratula1);
        if (count($tesis) > 1) {
            $caratulaSesion->addText($Autor1, array('name' => 'Arial', 'bold' => false, 'size' => 12, 'align' => 'justify'), $styleCaratula1);
            $caratulaSesion->addText($Autor2, array('name' => 'Arial', 'bold' => false, 'size' => 12, 'align' => 'justify'), $styleCaratula1);
        } else {
            $caratulaSesion->addText($nombres, array('name' => 'Arial', 'bold' => false, 'size' => 12, 'align' => 'justify'), $styleCaratula1);
        }


        //$caratulaSesion->addText($nombres,array('name'=>'Arial','bold'=>true,'size'=>16),$styleCaratula1);
        $caratulaSesion->addText("Bachiller en Ciencias Economicas", array('name' => 'Arial', 'bold' => true, 'size' => 12), $styleCaratula1);

        $caratulaSesion->addText("Asesor: " . $nombre_asesor, array('name' => 'Arial', 'bold' => true, 'size' => 12), $styleCaratula2);

        $caratulaSesion->addTextBreak(2);
        $caratulaSesion->addText("Trujillo - Peru", array('name' => 'Arial', 'bold' => true, 'size' => 12), $styleCaratula1);
        $caratulaSesion->addText("2024", array('name' => 'Arial', 'bold' => true, 'size' => 12), $styleCaratula1);

        // CARATULA UPAO

        /* Estilos de la caratula UPAO */
        // $styleCaratula1UPAO = 'styleCaratula1UPAO';
        // $word->addParagraphStyle($styleCaratula1UPAO,array('align'=>'center','spacing' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.08)));

        // $styleCaratula2 = 'styleCaratula2';
        // $word->addParagraphStyle($styleCaratula2,array('align'=>'left','spacing' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.08)));

        // $styleTitulo = 'styleTitulo';
        // $word->addParagraphStyle($styleTitulo,array('align'=>'center','spacing' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.08)));

        // $styleContenido = 'styleContenido';
        // $word->addParagraphStyle($styleContenido,array('align'=>'left','spacing' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.08)));

        // $tituloCaratulaUPAO = 'tituloCaratulaUPAO';
        // $word->addFontStyle($tituloCaratulaUPAO,array('name'=>'Arial','bold'=>true,'size'=>14,'position'=>'raised'));

        // $subtitCaratula1UPAO = 'subtitCaratual1UPAO';
        // $word->addFontStyle($subtitCaratula1UPAO,array('name'=>'Arial','bold'=>false,'size'=>14,'align'=>'center'));
        // $subtitCaratula2UPAO = 'subtitCaratual2UPAO';
        // $word->addFontStyle($subtitCaratula2UPAO,array('name'=>'Arial','bold'=>false,'size'=>16,'align'=>'center'));

        // $titProyCaratulaUPAO = 'titProyCaratulaUPAO';
        // $word->addFontStyle($titProyCaratulaUPAO,array('name'=>'Arial','bold'=>false,'italic'=>true,'size'=>12,'align'=>'justify'));

        // $styleImage = array('align'=>'center','width'=>280,'height'=>200);

        // $styleImageUPAO = array('align'=>'center','width'=>200,'height'=>150);
        // $lineStyle = array('weight' => 2, 'width' => 450, 'height' => 1.5, 'color' => 000000);

        // $caratulaSesion->addText("UNIVERSIDAD PRIVADA ANTENOR ORREGO",$tituloCaratulaUPAO,$styleCaratula1UPAO);
        // $caratulaSesion->addText("FACULTAD DE CIENCIAS ECONOMICAS",$subtitCaratula1UPAO,$styleCaratula1UPAO);
        // $caratulaSesion->addText("PROGRAMA DE ESTUDIO DE CONTABILIDAD",$subtitCaratula2UPAO,$styleCaratula1UPAO);

        // $caratulaSesion->addImage("img/logo-upao.png",$styleImageUPAO);

        // $caratulaSesion->addText("TESIS PARA OBTENER EL TITULO PROFESIONAL DE CONTADOR PUBLICO",$titProyCaratulaUPAO,$styleCaratula1UPAO);

        // $caratulaSesion->addLine($lineStyle);

        // $caratulaSesion->addText($titulo,array('name'=>'Arial','bold'=>true,'size'=>12,'align'=>'justify'),$styleCaratula1UPAO);

        // $caratulaSesion->addLine($lineStyle);

        // //HOSTING
        // $caratulaSesion->addText("Autor (es)",array('name'=>'Arial','bold'=>true,'size'=>12,'align'=>'justify'),$styleCaratula1UPAO);
        // if (count($tesis)>1) {
        //     $caratulaSesion->addText($Autor1,array('name'=>'Arial','bold'=>false,'size'=>12,'align'=>'justify'),$styleCaratula1UPAO);
        //     $caratulaSesion->addText($Autor2,array('name'=>'Arial','bold'=>false,'size'=>12,'align'=>'justify'),$styleCaratula1UPAO);
        // }else{
        //     $caratulaSesion->addText($nombres,array('name'=>'Arial','bold'=>false,'size'=>12,'align'=>'justify'),$styleCaratula1UPAO);
        // }

        // $caratulaSesion->addText("Asesor:",array('name'=>'Arial','bold'=>true,'size'=>12,'align'=>'justify'),$styleCaratula1UPAO);
        // $caratulaSesion->addText($nombre_asesor,array('name'=>'Arial','bold'=>false,'size'=>12,'align'=>'justify'),$styleCaratula1UPAO);

        // $caratulaSesion->addText("Codigo ORCID: https://orcid.org/".$orcid_asesor,array('name'=>'Arial','bold'=>true,'size'=>12,'align'=>'justify'),$styleCaratula1UPAO);

        // $caratulaSesion->addTextBreak(2);
        // $caratulaSesion->addText("TRUJILLO - PERU",array('name'=>'Arial','bold'=>true,'size'=>12),$styleCaratula1UPAO);
        // $caratulaSesion->addText("2023",array('name'=>'Arial','bold'=>true,'size'=>12),$styleCaratula1UPAO);

        /* ------------------------------------------ */

        /* ------------------------------------------ */
        if ($dedicatoria != null) {
            $SesionDedica = $word->addSection();

            $SesionDedica->addListItem("DEDICATORIA", 0.5, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
            $SesionDedica->addText($dedicatoria, null, $styleContenido);
        }

        if ($agradecimiento != null) {
            $SesionAgradece = $word->addSection();
            $SesionAgradece->addListItem("AGRADECIMIENTO", 0.5, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
            $SesionAgradece->addText($agradecimiento, null, $styleContenido);
        }

        $SesionPresenta = $word->addSection();
        $SesionPresenta->addListItem("PRESENTACION", 0.5, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $SesionPresenta->addText($presentacion, null, $styleContenido);

        $SesionResumen = $word->addSection();
        $SesionResumen->addListItem("RESUMEN", 0.5, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $SesionResumen->addText($resumen, null, $styleContenido);
        $SesionResumen->addText("Palabras clave: " . $lineKeywords, null, $styleContenido);
        $caratulaSesion->addTextBreak(1);
        $SesionResumen->addListItem("ABSTRACT", 0.5, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $SesionResumen->addText($abstract, null, $styleContenido);

        // for ($i=0; $i < count($keywords); $i++) {
        //     if (!empty($keywords[$i+1])) {
        //         $SesionResumen->addText("Palabras clave: ".$keywords[$i]->keyword.', '.$keywords[$i+1]->keyword,null,$styleContenido);
        //     }
        // }

        $SesionIntroduccion = $word->addSection();
        $SesionIntroduccion->addListItem("INTRODUCCION", 0.5, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $SesionIntroduccion->addText($introduccion, null, $styleContenido);

        $nuevaSesion = $word->addSection();
        $nuevaSesion->addText("I. GENERALIDADES", $titulos);

        $nuevaSesion->addListItem("1. TITULO", 0.5, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $nuevaSesion->addText("'" . $titulo . "'", null, $styleTitulo);

        //HOSTING
        $nuevaSesion->addListItem("2. AUTOR(ES)", 0.5, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        if (count($tesis) > 1) {
            $nuevaSesion->addText($Autor1, null, $styleContenido);
            $nuevaSesion->addText($Autor2, null, $styleContenido);
        } else {
            $nuevaSesion->addText($nombres, null, $styleContenido);
        }

        $nuevaSesion->addListItem("3. ASESOR", 0.5, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $nuevaSesion->addText($nombre_asesor, null, $styleContenido);
        $nuevaSesion->addText($grado_asesor, null, $styleContenido);
        $nuevaSesion->addText($titulo_asesor, null, $styleContenido);
        $nuevaSesion->addText($direccion_asesor, null, $styleContenido);



        /* ------------------------------------------ */



        $nuevaSesion->addText("II. PLAN DE INVESTIGACION", $titulos, $styleContenido);

        $nuevaSesion->addListItem("1. REALIDAD PROBLEMATICA", 0.5, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $nuevaSesion->addText($real_problematica, null, $styleContenido);

        $nuevaSesion->addListItem("2. ANTECEDENTES", 0.5, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $nuevaSesion->addText($antecedentes, null, $styleContenido);

        $nuevaSesion->addListItem("3. JUSTIFICACION", 0.5, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $nuevaSesion->addText($justificacion, null, $styleContenido);

        $nuevaSesion->addListItem("4. FORMULACION DEL PROBLEMA", 0.5, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $nuevaSesion->addText($formulacion_prob, null, $styleContenido);

        /* Objetivos */
        $objetivos = TObjetivo::where('cod_tesis', '=', $tesis[0]->cod_tesis)->latest('cod_objetivo')->get();

        $nuevaSesion->addListItem("5. OBJETIVOS", 0.5, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        if ($objetivos->count() != 0) {
            $arregloObjetivo = [];

            $arregloObjTipo = [];
            foreach ($objetivos as $obj) {
                $arregloObjTipo[] = $obj->tipo;
                $arregloObjetivo[] = $obj->descripcion;
            }

            $cont4 = 0;
            $cont5 = 0;
            for ($i = count($objetivos) - 1; $i >= 0; $i--) {
                if ($arregloObjTipo[$i] == 'General') {
                    if ($cont4 == 0) {
                        $nuevaSesion->addListItem("5.1. General: ", 1, null, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
                    }
                    $nuevaSesion->addListItem("5.1." . ($cont4 + 1) . ". " . $arregloObjetivo[$i], 2, null, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
                    $cont4++;
                }
                if ($arregloObjTipo[$i] == 'Especifico') {
                    if ($cont5 == 0) {
                        $nuevaSesion->addListItem("5.2. Especifico: ", 1, null, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
                    }
                    $nuevaSesion->addListItem("5.2." . ($cont5 + 1) . ". " . $arregloObjetivo[$i], 2, null, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
                    $cont5++;
                }
            }
        }

        /* ------------------------ */
        $nuevaSesion->addListItem("6. MARCO TEORICO", 0.5, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $nuevaSesion->addText($marco_teorico, null, $styleContenido);

        $nuevaSesion->addListItem("7. MARCO CONCEPTUAL", 0.5, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $nuevaSesion->addText($marco_conceptual, null, $styleContenido);

        $nuevaSesion->addListItem("8. MARCO LEGAL", 0.5, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $nuevaSesion->addText($marco_legal, null, $styleContenido);

        $nuevaSesion->addListItem("9. FORMULACION DE LA HIPOTESIS", 0.5, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $nuevaSesion->addText($form_hipotesis, null, $styleContenido);

        $nuevaSesion->addListItem("10. DISENO DE INVESTIGACION", 0.5, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $nuevaSesion->addListItem("10.1. OBJETO DE ESTUDIO", 1, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $nuevaSesion->addText($objeto_estudio, null, $styleContenido);
        $nuevaSesion->addListItem("10.2. POBLACION", 1, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $nuevaSesion->addText($poblacion, null, $styleContenido);
        $nuevaSesion->addListItem("10.3. MUESTRA", 1, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $nuevaSesion->addText($muestra, null, $styleContenido);
        $nuevaSesion->addListItem("10.4. METODOS", 1, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $nuevaSesion->addText($metodos, null, $styleContenido);
        $nuevaSesion->addListItem("10.5. TECNICAS E INTRUMENTOS DE RECOLECCION DE DATOS", 1, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $nuevaSesion->addText($tecnicas_instrum, null, $styleContenido);


        $nuevaSesion->addListItem("10.6. INSTRUMENTACION", 1, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $nuevaSesion->addText($instrumentacion, null, $styleContenido);

        $nuevaSesion->addListItem("10.7. ESTRATEGIAS METODOLOGICAS", 1, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $nuevaSesion->addText($estg_metodologicas, null, $styleContenido);


        /* ---------------------------- */

        // Resultados

        $img_resultado = DB::table('detalle_archivos as DA')->join('archivos_proy_tesis as AP', 'DA.cod_archivos', '=', 'AP.cod_archivos')
            ->where('AP.cod_tesis', '=', $tesis[0]->cod_tesis)->where('DA.tipo', '=', 'resultados')->get();
        // dd($img_resultado);
        $nuevaSesion->addListItem("11. RESULTADOS", 0.5, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);

        $texto = explode('%&%', $resultados);

        if (count($texto) != 0) {
            for ($i = 0; $i < count($texto); $i++) {
                $nuevaSesion->addText($texto[$i], null, $styleContenido);
                if (count($img_resultado) != 0) {
                    for ($j = 0; $j < count($img_resultado); $j++) {
                        if ($img_resultado[$j]->grupo == $i) {
                            $nuevaSesion->addImage("cursoTesis-2022/img/" . $tesis[0]->cod_matricula . "-Tesis/resultados/" . $img_resultado[$j]->ruta, $styleImage);
                        }
                    }
                }
            }
        }

        // Discusion

        $nuevaSesion->addListItem("12. DISCUSION", 0.5, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $nuevaSesion->addText($discusion, null, $styleContenido);

        // Conclusiones

        $nuevaSesion->addListItem("13. CONCLUSIONES", 0.5, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $nuevaSesion->addText($conclusiones, null, $styleContenido);

        // Recomendaciones

        $nuevaSesion->addListItem("14. RECOMENDACIONES", 0.5, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $nuevaSesion->addText($recomendaciones, null, $styleContenido);

        /* Regerencias Bibliograficas */

        $referencia = TReferencias::where('cod_tesis', '=', $tesis[0]->cod_tesis)->latest('cod_referencias')->get();

        $arregloRefTipo = [];
        $arregloRefA = [];
        $arregloRefP = [];
        $arregloRefT = [];
        $arregloRefF = [];

        $arregloEd = [];
        $arregloTCap = [];
        $arregloNC = [];
        $arregloTRev = [];
        $arregloV = [];
        $arregloNWeb = [];
        $arregloNPe = [];
        $arregloNIn = [];
        $arregloS = [];
        $arregloNEd = [];
        if ($referencia->count() != 0) {

            foreach ($referencia as $ref) {
                $arregloRefTipo[] = $ref->cod_tiporeferencia;
                $arregloRefA[] = $ref->autor;
                $arregloRefP[] = $ref->fPublicacion;
                $arregloRefT[] = $ref->titulo;
                $arregloRefF[] = $ref->fuente;
                $arregloEd[] =  $ref->editorial;
                $arregloTCap[] = $ref->title_cap;
                $arregloNC[] = $ref->num_capitulo;
                $arregloTRev[] = $ref->title_revista;
                $arregloV[] = $ref->volumen;
                $arregloNWeb[] = $ref->name_web;
                $arregloNPe[] = $ref->name_periodista;
                $arregloNIn[] = $ref->name_institucion;
                $arregloS[] = $ref->subtitle;
                $arregloNEd[] = $ref->name_editor;
            }


            $nuevaSesion->addListItem("15. REFERENCIAS BIBLOIGRAFICAS", 0.5, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);

            for ($i = 0; $i <= count($referencia) - 1; $i++) {
                if ($arregloRefTipo[$i] == 1) {
                    $nuevaSesion->addText($arregloRefA[$i] . "." . "(" . $arregloRefP[$i] . ")." . $arregloTCap[$i] . "." . $arregloRefF[$i] . "," . $arregloRefT[$i] . " (capitulo " . $arregloNC[$i] . ")" . $arregloEd[$i] . ".", null, $styleContenido);
                }
                if ($arregloRefTipo[$i] == 2) {
                    $nuevaSesion->addText($arregloRefA[$i] . "." . "(" . $arregloRefP[$i] . ")." . $arregloRefT[$i] . "." . $arregloRefF[$i] . "." . $arregloTRev[$i] . ",pp " . $arregloV[$i] . ".", null, $styleContenido);
                }
                if ($arregloRefTipo[$i] == 3) {
                    $nuevaSesion->addText($arregloRefA[$i] . "." . "(" . $arregloRefP[$i] . ")." . $arregloRefT[$i] . "." . $arregloRefF[$i] . "." . $arregloNWeb[$i] . ".", null, $styleContenido);
                }
                if ($arregloRefTipo[$i] == 4) {
                    $nuevaSesion->addText($arregloRefA[$i] . "." . "(" . $arregloRefP[$i] . ")." . $arregloRefT[$i] . "." . $arregloRefF[$i] . "." . $arregloNPe[$i] . ".", null, $styleContenido);
                }
                if ($arregloRefTipo[$i] == 5) {
                    $nuevaSesion->addText($arregloRefA[$i] . "." . "(" . $arregloRefP[$i] . ")." . $arregloRefT[$i] . "." . $arregloRefF[$i] . "." . $arregloNIn[$i] . ".", null, $styleContenido);
                }
                if ($arregloRefTipo[$i] == 6) {
                    $nuevaSesion->addText($arregloRefA[$i] . "." . "(" . $arregloRefP[$i] . ")." . $arregloRefT[$i] . ": " . $arregloRefF[$i] . "," . $arregloS[$i] . ", " . $arregloNEd[$i] . ".", null, $styleContenido);
                }
            }
        }

        // Anexos

        $img_anexos = DB::table('detalle_archivos as DA')->join('archivos_proy_tesis as AP', 'DA.cod_archivos', '=', 'AP.cod_archivos')
            ->where('AP.cod_tesis', '=', $tesis[0]->cod_tesis)->where('DA.tipo', '=', 'anexos')->get();
        // dd($img_resultado);
        $nuevaSesion->addListItem("16. ANEXOS", 0.5, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);

        $textoAnexo = explode('%&%', $anexos);

        if (count($textoAnexo) != 0) {
            for ($i = 0; $i < count($textoAnexo); $i++) {
                $nuevaSesion->addText($textoAnexo[$i], null, $styleContenido);
                if (count($img_anexos) != 0) {
                    for ($j = 0; $j < count($img_anexos); $j++) {
                        if ($img_anexos[$j]->grupo == $i) {
                            $nuevaSesion->addImage("cursoTesis-2022/img/" . $tesis[0]->cod_matricula . "-Tesis/anexos/" . $img_anexos[$j]->ruta, $styleImage);
                        }
                    }
                }
            }
        }

        /* ------------------------------------------------------- */

        $objetoEscrito = \PhpOffice\PhpWord\IOFactory::createWriter($word, 'Word2007');
        try {
            $objetoEscrito->save(storage_path('Tesis.docx'));
        } catch (\Throwable $th) {
            $th;
        }

        return response()->download(storage_path('Tesis.docx'));
    }


    public function descargaProyectoTesis(Request $request)
    {

        $cod_cursoTesis = $request->cod_cursoTesis;

        $tesis = TesisCT2022::where('cod_proyectotesis', $cod_cursoTesis)->get();
        $estudiantes_grupo = DB::table('estudiante_ct2022 as e')
            ->join('detalle_grupo_investigacion as d_g', 'd_g.cod_matricula', '=', 'e.cod_matricula')
            ->select('e.cod_matricula', 'e.nombres', 'e.apellidos')
            ->where('d_g.id_grupo_inves', $tesis[0]->id_grupo_inves)->get();
        $asesor = AsesorCurso::find($tesis[0]->cod_docente);
        /*Datos del Autor*/
        if (count($estudiantes_grupo) > 1) {
            $estudiante1 = $estudiantes_grupo[0]->nombres . ' ' . $estudiantes_grupo[0]->apellidos;
            $estudiante2 = $estudiantes_grupo[1]->nombres . ' ' . $estudiantes_grupo[1]->apellidos;
        } else {
            $estudiante1 = $estudiantes_grupo[0]->nombres . ' ' . $estudiantes_grupo[0]->apellidos;
        }

        /*Datos del Asesor*/
        $nombre_asesor = $asesor->nombres . " " . $asesor->apellidos;

        $orcid_asesor = $asesor->orcid;
        $grado_asesor = $asesor->grado_academico;
        $titulo_asesor = $asesor->titulo_profesional;
        $direccion_asesor = $asesor->direccion;

        /*Proyecto de Investigacion y/o Tesis*/
        $titulo = $tesis[0]->titulo;

        //Investigacion
        $cod_tinvestigacion = TipoInvestigacion::find($tesis[0]->cod_tinvestigacion);
        if ($cod_tinvestigacion != null) {
            $cod_tinvestigacion = $cod_tinvestigacion->descripcion;
        }

        $fin_persigue = Fin_Persigue::find($tesis[0]->ti_finpersigue);
        if ($fin_persigue != null) {
            $ti_finpersigue = $fin_persigue->descripcion;
        } else {
            $ti_finpersigue = "";
        }

        $diseno_investigacion = Diseno_Investigacion::find($tesis[0]->ti_disinvestigacion);
        if ($diseno_investigacion != null) {
            $ti_disinvestigacion = $diseno_investigacion->descripcion;
        } else {
            $ti_disinvestigacion = "";
        }


        //Desarrollo del proyecto
        $localidad = $tesis[0]->localidad;
        $institucion = $tesis[0]->institucion;
        $meses_ejecucion = $tesis[0]->meses_ejecucion;


        //Economico
        $financiamiento = $tesis[0]->financiamiento;


        /*Realidad problematica y others*/
        $real_problematica = $tesis[0]->real_problematica;

        $antecedentes = $tesis[0]->antecedentes;
        $justificacion = $tesis[0]->justificacion;
        $formulacion_prob = $tesis[0]->formulacion_prob;

        /*Hipotesis y disenio*/
        $form_hipotesis = $tesis[0]->form_hipotesis;

        /*Material, metodos y tecnicas*/
        $objeto_estudio = $tesis[0]->objeto_estudio;
        $poblacion = $tesis[0]->poblacion;
        $muestra = $tesis[0]->muestra;
        $metodos = $tesis[0]->metodos;
        $tecnicas_instrum = $tesis[0]->tecnicas_instrum;

        /*Instrumentacion*/
        $instrumentacion = $tesis[0]->instrumentacion;

        /*Estrateg. metodologicas*/
        $estg_metodologicas = $tesis[0]->estg_metodologicas;

        /*Marco teorico*/
        $marco_teorico = $tesis[0]->marco_teorico;
        $marco_conceptual = $tesis[0]->marco_conceptual;
        $marco_legal = $tesis[0]->marco_legal;

        Settings::setOutputEscapingEnabled(true);

        $word = new PhpWord();

        /* Creacion de las fuentes */
        $word->setDefaultFontName('Times New Roman');
        $word->setDefaultFontSize(11);


        $titulos = 'titulos';
        $word->addFontStyle($titulos, array('bold' => true));

        /* Estilos de la caratula */
        $styleCaratula1 = 'styleCaratula1';
        $word->addParagraphStyle($styleCaratula1, array('align' => 'center', 'spacing' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.08)));

        $styleCaratula2 = 'styleCaratula2';
        $word->addParagraphStyle($styleCaratula2, array('align' => 'left', 'spacing' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.08)));

        $styleTitulo = 'styleTitulo';
        $word->addParagraphStyle($styleTitulo, array('align' => 'center', 'spacing' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.08)));

        $styleContenido = 'styleContenido';
        $word->addParagraphStyle($styleContenido, array('align' => 'left', 'spacing' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.08)));

        $tituloCaratula = 'tituloCaratula';
        $word->addFontStyle($tituloCaratula, array('name' => 'Arial', 'bold' => true, 'size' => 20, 'position' => 'raised'));

        $subtitCaratula1 = 'subtitCaratual1';
        $word->addFontStyle($subtitCaratula1, array('name' => 'Arial', 'bold' => true, 'size' => 16, 'align' => 'center'));
        $subtitCaratula2 = 'subtitCaratual2';
        $word->addFontStyle($subtitCaratula2, array('name' => 'Arial', 'bold' => true, 'size' => 14, 'align' => 'center'));

        $titProyCaratula = 'titProyCaratula';
        $word->addFontStyle($titProyCaratula, array('name' => 'Arial', 'bold' => true, 'size' => 18, 'align' => 'justify'));

        $styleImage = array('align' => 'center', 'width' => 280, 'height' => 200);

        /* ------------------------------- */

        /* CARATULA */

        $caratulaSesion = $word->addSection();
        $nuevaSesion = $word->addSection();

        // CARATULA UNT
        $caratulaSesion->addText("UNIVERSIDAD NACIONAL DE TRUJILLO", $tituloCaratula, $styleCaratula1);
        $caratulaSesion->addText("FACULTAD DE CIENCIAS ECONOMICAS", $subtitCaratula1, $styleCaratula1);
        $caratulaSesion->addText("ESCUELA PROFESIONAL DE CONTABILIDAD Y FINANZAS", $subtitCaratula2, $styleCaratula1);

        $caratulaSesion->addImage("img/logoUNTcaratula.png", $styleImage);

        $caratulaSesion->addText($titulo, $titProyCaratula, $styleCaratula1);
        $caratulaSesion->addTextBreak(1.5);

        $caratulaSesion->addText("PROYECTO DE TESIS", array('name' => 'Arial', 'bold' => true, 'size' => 16), $styleCaratula1);
        $caratulaSesion->addText("Para obtener el Titulo Porfesional de:", array('name' => 'Arial', 'bold' => true, 'size' => 16), $styleCaratula1);

        $caratulaSesion->addText("Contabilidad y Finanzas", array('name' => 'Arial', 'bold' => true, 'size' => 18), $styleCaratula1);


        $caratulaSesion->addText($nombre_asesor, array('name' => 'Arial', 'bold' => true, 'size' => 16), $styleCaratula1);
        $caratulaSesion->addText("Bachiller en Ciencias Economicas", array('name' => 'Arial', 'bold' => true, 'size' => 16), $styleCaratula1);

        $caratulaSesion->addText("Asesor: " . $nombre_asesor, array('name' => 'Arial', 'bold' => true, 'size' => 16), $styleCaratula2);

        $caratulaSesion->addText("ORCID: " . $orcid_asesor, array('name' => 'Arial', 'bold' => true, 'size' => 14), $styleCaratula2);

        $caratulaSesion->addTextBreak(1.5);
        $caratulaSesion->addText("Trujillo - Peru", array('name' => 'Arial', 'bold' => true, 'size' => 16), $styleCaratula1);
        $caratulaSesion->addText("2022", array('name' => 'Arial', 'bold' => true, 'size' => 16), $styleCaratula1);

        /* ------------------------------------------ */

        $nuevaSesion->addText("I. GENERALIDADES", $titulos);

        $nuevaSesion->addListItem("1. TITULO", 0.5, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $nuevaSesion->addText("'" . $titulo . "'", null, $styleTitulo);

        $nuevaSesion->addListItem("2. AUTORES", 0.5, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        if (count($estudiantes_grupo) > 1) {
            $nuevaSesion->addText($estudiante1, null, $styleContenido);
            $nuevaSesion->addText($estudiante2, null, $styleContenido);
        } else {
            $nuevaSesion->addText($estudiante1, null, $styleContenido);
        }

        $nuevaSesion->addListItem("3. ASESOR", 0.5, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $nuevaSesion->addText($nombre_asesor, null, $styleContenido);
        $nuevaSesion->addText($grado_asesor, null, $styleContenido);
        $nuevaSesion->addText($titulo_asesor, null, $styleContenido);
        $nuevaSesion->addText($direccion_asesor, null, $styleContenido);

        $nuevaSesion->addListItem("4. TIPO DE INVESTIGACION", 0.5, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $nuevaSesion->addText($cod_tinvestigacion, null, $styleContenido);
        $nuevaSesion->addText("De acuerdo al fin que se persigue: " . $ti_finpersigue, null, $styleContenido);
        $nuevaSesion->addText("De acuerdo al diseño de investigacion: " . $ti_disinvestigacion, null, $styleContenido);

        $nuevaSesion->addListItem("5. LOCALIDAD E INSTITUCION DONDE SE DESARROLLO EL PROYECTO", 0.5, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $nuevaSesion->addText("Localidad: " . $localidad, null, $styleContenido);
        $nuevaSesion->addText("Institucion: " . $institucion, null, $styleContenido);

        $nuevaSesion->addListItem("6. DURECION DE LA EJECUCION DEL PROYECTO", 0.5, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $nuevaSesion->addText($meses_ejecucion . " MESES", null, $styleContenido);

        /* Tabla del Cronograma de Trabajo */
        /* Estilo de la table */
        $tableStyle = array(
            'borderSize' => 6,
            'cellMargin' => 50,
            'alignMent' => 'center'
        );

        $nuevaSesion->addListItem("7. CRONOGRAMA DE TRABAJO", 0.5, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);

        $cronogramaTable = $nuevaSesion->addTable($tableStyle);

        $cronogramaTable->addRow(400);
        $cronogramaTable->addCell(3500)->addText('ACTIVIDAD', $titulos);
        $cronogramaTable->addCell(1500)->addText('MES INICIO', $titulos);
        $cronogramaTable->addCell(1500)->addText('MES TERMINO', $titulos);


        // $cronogramaTable->addRow(400);
        // $cronogramaTable->addCell(3500)->addText('Preparacion de instrumentos de recoleccion de datos',$titulos);
        // for ($i=0; $i <= count($reparacionInstrum)-1 ; $i++) {
        //     $cronogramaTable->addCell(2000)->addText($reparacionInstrum[$i]);
        // }


        // $cronogramaTable->addRow(400);
        // $cronogramaTable->addCell(3500)->addText('Recoleccion de datos',$titulos);
        // for ($i=0; $i <= count($recoleccionDatos)-1 ; $i++) {
        //     $cronogramaTable->addCell(2000)->addText($recoleccionDatos[$i]);
        // }

        // $cronogramaTable->addRow(400);
        // $cronogramaTable->addCell(3500)->addText('Analisis de Datos',$titulos);
        // for ($i=0; $i <= count($analisisDatos)-1 ; $i++) {
        //     $cronogramaTable->addCell(2000)->addText($analisisDatos[$i]);
        // }

        // $cronogramaTable->addRow(400);
        // $cronogramaTable->addCell(3500)->addText('Elaboracion del Informe',$titulos);
        // for ($i=0; $i <= count($elaboracionInfo)-1 ; $i++) {
        //     $cronogramaTable->addCell(2000)->addText($elaboracionInfo[$i]);
        // }


        /* ------------------------------------------ */

        /* Recursos */

        $recursos = recursos::where('cod_proyectotesis', '=', $tesis[0]->cod_proyectotesis)->latest('cod_recurso')->get();

        $arregloRecursos = [];

        $nuevaSesion->addListItem("8. RECURSOS", 0.5, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);

        $arregloRecTipo = [];
        if ($recursos->count() != 0) {
            foreach ($recursos as $rec) {
                $arregloRecTipo[] = $rec->tipo;
                $arregloRecursos[] = $rec->descripcion;
            }

            $cont1 = 0;
            $cont2 = 0;
            $cont3 = 0;
            for ($i = count($recursos) - 1; $i >= 0; $i--) {
                if ($arregloRecTipo[$i] == 'Personal') {
                    if ($cont1 == 0) {
                        $nuevaSesion->addListItem("8.1. Personal: ", 1, null, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
                    }
                    $nuevaSesion->addListItem("8.1." . ($cont1 + 1) . ". " . $arregloRecursos[$i], 2, null, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
                    $cont1++;
                }
                if ($arregloRecTipo[$i] == 'Bienes') {
                    if ($cont2 == 0) {
                        $nuevaSesion->addListItem("8.2. Bienes: ", 1, null, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
                    }
                    $nuevaSesion->addListItem("8.2." . ($cont2 + 1) . ". " . $arregloRecursos[$i], 2, null, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
                    $cont2++;
                }
                if ($arregloRecTipo[$i] == 'Servicios') {
                    if ($cont3 == 0) {
                        $nuevaSesion->addListItem("8.3. Servicios: ", 1, null, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
                    }
                    $nuevaSesion->addListItem("8.3." . ($cont3 + 1) . ". " . $arregloRecursos[$i], 2, null, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
                    $cont3++;
                }
            }
        }

        /* ---------------- */

        $nuevaSesion->addListItem("9. PRESUPUESTO", 0.5, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);

        /* Presupuesto */
        $presupues = DB::table('presupuesto_proyecto')->join('presupuesto', 'presupuesto_proyecto.cod_presupuesto', '=', 'presupuesto.cod_presupuesto')
            ->select('precio', 'presupuesto.codeUniversal', 'presupuesto.denominacion')
            ->where('cod_proyectotesis', '=', $tesis[0]->cod_proyectotesis)->latest('cod_presProyecto')->get();

        $presupuestoTable = $nuevaSesion->addTable($tableStyle);

        $presupuestoTable->addRow(400);
        $presupuestoTable->addCell(2000)->addText("CODIGO", $titulos);
        $presupuestoTable->addCell(4000)->addText("DENOMINACION", $titulos);
        $presupuestoTable->addCell(1500)->addText("PRECIO TOTAL (S/.)", $titulos);
        $totalP = 0;
        if ($presupues->count() != 0) {
            for ($i = count($presupues) - 1; $i >= 0; $i--) {
                $presupuestoTable->addRow(400);
                $presupuestoTable->addCell(2000)->addText($presupues[$i]->codeUniversal, $titulos);
                $presupuestoTable->addCell(4000)->addText($presupues[$i]->denominacion, $titulos);
                $presupuestoTable->addCell(1500)->addText($presupues[$i]->precio . ".00", $titulos);
                $totalP += floatval($presupues[$i]->precio);
            }
        }

        $presupuestoTable->addRow(400);
        $presupuestoTable->addCell(2000)->addText("", $titulos);
        $presupuestoTable->addCell(4000)->addText("TOTAL", $titulos);
        $presupuestoTable->addCell(1500)->addText($totalP . ".00", $titulos); //x


        /* ----------------------------------- */


        $nuevaSesion->addListItem("10. FINANCIAMIENTO", 0.5, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $nuevaSesion->addText($financiamiento);

        $nuevaSesion->addPageBreak();

        $nuevaSesion->addText("II. PLAN DE INVESTIGACION", $titulos, $styleContenido);

        $nuevaSesion->addListItem("1. REALIDAD PROBLEMATICA", 0.5, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $nuevaSesion->addText($real_problematica, null, $styleContenido);

        $nuevaSesion->addListItem("2. ANTECEDENTES", 0.5, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $nuevaSesion->addText($antecedentes, null, $styleContenido);

        $nuevaSesion->addListItem("3. JUSTIFICACION", 0.5, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $nuevaSesion->addText($justificacion, null, $styleContenido);

        $nuevaSesion->addListItem("4. FORMULACION DEL PROBLEMA", 0.5, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $nuevaSesion->addText($formulacion_prob, null, $styleContenido);

        /* Objetivos */
        $objetivos = Objetivo::where('cod_proyectotesis', '=', $tesis[0]->cod_proyectotesis)->latest('cod_objetivo')->get();

        $nuevaSesion->addListItem("5. OBJETIVOS", 0.5, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        if ($objetivos->count() != 0) {
            $arregloObjetivo = [];

            $arregloObjTipo = [];
            foreach ($objetivos as $obj) {
                $arregloObjTipo[] = $obj->tipo;
                $arregloObjetivo[] = $obj->descripcion;
            }



            $cont4 = 0;
            $cont5 = 0;
            for ($i = count($objetivos) - 1; $i >= 0; $i--) {
                if ($arregloObjTipo[$i] == 'General') {
                    if ($cont4 == 0) {
                        $nuevaSesion->addListItem("5.1. General: ", 1, null, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
                    }
                    $nuevaSesion->addListItem("5.1." . ($cont4 + 1) . ". " . $arregloObjetivo[$i], 2, null, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
                    $cont4++;
                }
                if ($arregloObjTipo[$i] == 'Especifico') {
                    if ($cont5 == 0) {
                        $nuevaSesion->addListItem("5.2. Especifico: ", 1, null, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
                    }
                    $nuevaSesion->addListItem("5.2." . ($cont5 + 1) . ". " . $arregloObjetivo[$i], 2, null, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
                    $cont5++;
                }
            }
        }

        /* ------------------------ */
        $nuevaSesion->addListItem("6. MARCO TEORICO", 0.5, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $nuevaSesion->addText($marco_teorico, null, $styleContenido);

        $nuevaSesion->addListItem("7. MARCO CONCEPTUAL", 0.5, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $nuevaSesion->addText($marco_conceptual, null, $styleContenido);

        $nuevaSesion->addListItem("8. MARCO LEGAL", 0.5, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $nuevaSesion->addText($marco_legal, null, $styleContenido);

        $nuevaSesion->addListItem("9. FORMULACION DE LA HIPOTESIS", 0.5, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $nuevaSesion->addText($form_hipotesis, null, $styleContenido);

        $nuevaSesion->addListItem("10. DISENO DE INVESTIGACION", 0.5, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $nuevaSesion->addListItem("10.1. OBJETO DE ESTUDIO", 1, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $nuevaSesion->addText($objeto_estudio, null, $styleContenido);
        $nuevaSesion->addListItem("10.2. POBLACION", 1, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $nuevaSesion->addText($poblacion, null, $styleContenido);
        $nuevaSesion->addListItem("10.3. MUESTRA", 1, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $nuevaSesion->addText($muestra, null, $styleContenido);
        $nuevaSesion->addListItem("10.4. METODOS", 1, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $nuevaSesion->addText($metodos, null, $styleContenido);
        $nuevaSesion->addListItem("10.5. TECNICAS E INTRUMENTOS DE RECOLECCION DE DATOS", 1, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $nuevaSesion->addText($tecnicas_instrum, null, $styleContenido);


        $nuevaSesion->addListItem("10.6. INSTRUMENTACION", 1, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $nuevaSesion->addText($instrumentacion, null, $styleContenido);

        $nuevaSesion->addListItem("10.7. ESTRATEGIAS METODOLOGICAS", 1, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $nuevaSesion->addText($estg_metodologicas, null, $styleContenido);

        /* Variables */
        $variables = variableOP::where('cod_proyectotesis', '=', $tesis[0]->cod_proyectotesis)->latest('cod_variable')->get();
        $nuevaSesion->addListItem("10.8. OPERACIONALIZACION DE VARIABLES Y MATRIZ DE CONSISTENCIA", 1, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);

        if ($variables->count() != 0) {

            $arregloVariable = [];


            foreach ($variables as $var) {
                $arregloVariable[] = $var->descripcion;
            }

            for ($i = 0; $i <= count($variables) - 1; $i++) {
                $nuevaSesion->addListItem("10.8." . ($i + 1) . ". " . $arregloVariable[$i], 2, null, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
            }
        }

        $footer = $nuevaSesion->addFooter();

        $footer->addPreserveText(1);

        /* ---------------------------- */

        /* Regerencias Bibliograficas */

        $referencia = referencias::where('cod_proyectotesis', '=', $tesis[0]->cod_proyectotesis)->latest('cod_referencias')->get();

        $arregloRefTipo = [];
        $arregloRefA = [];
        $arregloRefP = [];
        $arregloRefT = [];
        $arregloRefF = [];

        $arregloEd = [];
        $arregloTCap = [];
        $arregloNC = [];
        $arregloTRev = [];
        $arregloV = [];
        $arregloNWeb = [];
        $arregloNPe = [];
        $arregloNIn = [];
        $arregloS = [];
        $arregloNEd = [];

        $nuevaSesion->addListItem("11. REFERENCIAS BIBLIOGRAFICAS", 0.5, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);

        if ($referencia->count() != 0) {

            foreach ($referencia as $ref) {
                $arregloRefTipo[] = $ref->cod_tiporeferencia;
                $arregloRefA[] = $ref->autor;
                $arregloRefP[] = $ref->fPublicacion;
                $arregloRefT[] = $ref->titulo;
                $arregloRefF[] = $ref->fuente;
                $arregloEd[] =  $ref->editorial;
                $arregloTCap[] = $ref->title_cap;
                $arregloNC[] = $ref->num_capitulo;
                $arregloTRev[] = $ref->title_revista;
                $arregloV[] = $ref->volumen;
                $arregloNWeb[] = $ref->name_web;
                $arregloNPe[] = $ref->name_periodista;
                $arregloNIn[] = $ref->name_institucion;
                $arregloS[] = $ref->subtitle;
                $arregloNEd[] = $ref->name_editor;
            }




            for ($i = 0; $i <= count($referencia) - 1; $i++) {
                if ($arregloRefTipo[$i] == 1) {
                    $nuevaSesion->addText($arregloRefA[$i] . "." . "(" . $arregloRefP[$i] . ")." . $arregloTCap[$i] . "." . $arregloRefF[$i] . "," . $arregloRefT[$i] . " (capitulo " . $arregloNC[$i] . ")" . $arregloEd[$i] . ".", null, $styleContenido);
                }
                if ($arregloRefTipo[$i] == 2) {
                    $nuevaSesion->addText($arregloRefA[$i] . "." . "(" . $arregloRefP[$i] . ")." . $arregloRefT[$i] . "." . $arregloRefF[$i] . "." . $arregloTRev[$i] . ",pp " . $arregloV[$i] . ".", null, $styleContenido);
                }
                if ($arregloRefTipo[$i] == 3) {
                    $nuevaSesion->addText($arregloRefA[$i] . "." . "(" . $arregloRefP[$i] . ")." . $arregloRefT[$i] . "." . $arregloRefF[$i] . "." . $arregloNWeb[$i] . ".", null, $styleContenido);
                }
                if ($arregloRefTipo[$i] == 4) {
                    $nuevaSesion->addText($arregloRefA[$i] . "." . "(" . $arregloRefP[$i] . ")." . $arregloRefT[$i] . "." . $arregloRefF[$i] . "." . $arregloNPe[$i] . ".", null, $styleContenido);
                }
                if ($arregloRefTipo[$i] == 5) {
                    $nuevaSesion->addText($arregloRefA[$i] . "." . "(" . $arregloRefP[$i] . ")." . $arregloRefT[$i] . "." . $arregloRefF[$i] . "." . $arregloNIn[$i] . ".", null, $styleContenido);
                }
                if ($arregloRefTipo[$i] == 6) {
                    $nuevaSesion->addText($arregloRefA[$i] . "." . "(" . $arregloRefP[$i] . ")." . $arregloRefT[$i] . ": " . $arregloRefF[$i] . "," . $arregloS[$i] . ", " . $arregloNEd[$i] . ".", null, $styleContenido);
                }
            }
        }

        // Matriz Operacional

        $nuevaSesion->addText("MATRIZ DE OPERACIONALIZACION", null, $titulos);

        $matriz = DB::table('matriz_operacional')->select('matriz_operacional.*')->where('cod_proyectotesis', '=', $tesis[0]->cod_proyectotesis)->get();

        $matrizTable = $nuevaSesion->addTable($tableStyle);
        $matrizTable->addRow();
        $matrizTable->addCell()->addText("VARIABLES", $titulos);
        $matrizTable->addCell()->addText("DEFINICION CONCEPTUAL", $titulos);
        $matrizTable->addCell()->addText("DEFINICION OPERACIONAL", $titulos);
        $matrizTable->addCell()->addText("DIMENSIONES", $titulos);
        $matrizTable->addCell()->addText("INDICADORES", $titulos);
        $matrizTable->addCell()->addText("Escala", $titulos);

        if ($matriz->count() != 0) {
            $matrizTable->addRow();
            $matrizTable->addCell()->addText($matriz[0]->variable_I);
            $matrizTable->addCell()->addText($matriz[0]->def_conceptual_I);
            $matrizTable->addCell()->addText($matriz[0]->def_operacional_I);
            $matrizTable->addCell()->addText($matriz[0]->dimensiones_I);
            $matrizTable->addCell()->addText($matriz[0]->indicadores_I);
            $matrizTable->addCell()->addText($matriz[0]->escala_I);

            $matrizTable->addRow();
            $matrizTable->addCell()->addText($matriz[0]->variable_D);
            $matrizTable->addCell()->addText($matriz[0]->def_conceptual_D);
            $matrizTable->addCell()->addText($matriz[0]->def_operacional_D);
            $matrizTable->addCell()->addText($matriz[0]->dimensiones_D);
            $matrizTable->addCell()->addText($matriz[0]->indicadores_D);
            $matrizTable->addCell()->addText($matriz[0]->escala_D);
        }


        /* ------------------------------------------------------- */

        $objetoEscrito = \PhpOffice\PhpWord\IOFactory::createWriter($word, 'Word2007');
        try {
            $objetoEscrito->save(storage_path('ProyectoTesis.docx'));
        } catch (\Throwable $th) {
            $th;
        }

        return response()->download(storage_path('ProyectoTesis.docx'));
    }

    public function descargaUNTCienciasEconomicasProyectoTesis(Request $request)
    {
        $TITULO_BACHILLER = "";
        $ESCUELA_PROFESIONAL="";
        $cod_cursoTesis = $request->cod_cursoTesis;

        $tesis = TesisCT2022::where('cod_proyectotesis', $cod_cursoTesis)->get();
        $estudiantes_grupo = DB::table('estudiante_ct2022 as e')
            ->join('detalle_grupo_investigacion as d_g', 'd_g.cod_matricula', '=', 'e.cod_matricula')
            ->select('e.cod_matricula', 'e.nombres', 'e.apellidos')
            ->where('d_g.id_grupo_inves', $tesis[0]->id_grupo_inves)->get();
        $asesor = AsesorCurso::find($tesis[0]->cod_docente);
        /*Datos del Autor*/
        if (count($estudiantes_grupo) > 1) {
            $estudiante1 = $estudiantes_grupo[0]->nombres . ' ' . $estudiantes_grupo[0]->apellidos;
            $estudiante2 = $estudiantes_grupo[1]->nombres . ' ' . $estudiantes_grupo[1]->apellidos;
        } else {
            $estudiante1 = $estudiantes_grupo[0]->nombres . ' ' . $estudiantes_grupo[0]->apellidos;
        }

        /*Datos del Asesor*/
        $nombre_asesor = $asesor->nombres . " " . $asesor->apellidos;

        $orcid_asesor = $asesor->orcid;
        $grado_asesor = $asesor->grado_academico;
        $titulo_asesor = $asesor->titulo_profesional;
        $direccion_asesor = $asesor->direccion;

        /*Proyecto de Investigacion y/o Tesis*/
        $titulo = $tesis[0]->titulo;

        //Investigacion
        $cod_tinvestigacion = TipoInvestigacion::find($tesis[0]->cod_tinvestigacion);
        if ($cod_tinvestigacion != null) {
            $cod_tinvestigacion = $cod_tinvestigacion->descripcion;
        }

        $fin_persigue = Fin_Persigue::find($tesis[0]->ti_finpersigue);
        if ($fin_persigue != null) {
            $ti_finpersigue = $fin_persigue->descripcion;
        } else {
            $ti_finpersigue = "";
        }

        $diseno_investigacion = Diseno_Investigacion::find($tesis[0]->ti_disinvestigacion);
        if ($diseno_investigacion != null) {
            $ti_disinvestigacion = $diseno_investigacion->descripcion;
        } else {
            $ti_disinvestigacion = "";
        }


        //Desarrollo del proyecto
        $localidad = $tesis[0]->localidad;
        $institucion = $tesis[0]->institucion;
        $meses_ejecucion = $tesis[0]->meses_ejecucion;


        //Economico
        $financiamiento = $tesis[0]->financiamiento;


        /*Realidad problematica y others*/
        $real_problematica = $tesis[0]->real_problematica;

        $antecedentes = $tesis[0]->antecedentes;
        $justificacion = $tesis[0]->justificacion;
        $formulacion_prob = $tesis[0]->formulacion_prob;

        /*Hipotesis y disenio*/
        $form_hipotesis = $tesis[0]->form_hipotesis;

        /*Material, metodos y tecnicas*/
        $objeto_estudio = $tesis[0]->objeto_estudio;
        $poblacion = $tesis[0]->poblacion;
        $muestra = $tesis[0]->muestra;
        $metodos = $tesis[0]->metodos;
        $tecnicas_instrum = $tesis[0]->tecnicas_instrum;

        /*Instrumentacion*/
        $instrumentacion = $tesis[0]->instrumentacion;

        /*Estrateg. metodologicas*/
        $estg_metodologicas = $tesis[0]->estg_metodologicas;

        /*Marco teorico*/
        $marco_teorico = $tesis[0]->marco_teorico;
        $marco_conceptual = $tesis[0]->marco_conceptual;
        $marco_legal = $tesis[0]->marco_legal;

        Settings::setOutputEscapingEnabled(true);

        $word = new PhpWord();

        /* Creacion de las fuentes */
        $word->setDefaultFontName('Times New Roman');
        $word->setDefaultFontSize(11);


        $titulos = 'titulos';
        $word->addFontStyle($titulos, array('bold' => true));

        /* Estilos de la caratula */
        $styleCaratula1 = 'styleCaratula1';
        $word->addParagraphStyle($styleCaratula1, array('align' => 'center', 'spacing' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.08)));

        $styleCaratula2 = 'styleCaratula2';
        $word->addParagraphStyle($styleCaratula2, array('align' => 'left', 'spacing' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.08)));

        $styleTitulo = 'styleTitulo';
        $word->addParagraphStyle($styleTitulo, array('align' => 'center', 'spacing' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.08)));

        $styleContenido = 'styleContenido';
        $word->addParagraphStyle($styleContenido, array('align' => 'left', 'spacing' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.08)));

        $tituloCaratula = 'tituloCaratula';
        $word->addFontStyle($tituloCaratula, array('name' => 'Arial', 'bold' => true, 'size' => 20, 'position' => 'raised'));

        $subtitCaratula1 = 'subtitCaratual1';
        $word->addFontStyle($subtitCaratula1, array('name' => 'Arial', 'bold' => true, 'size' => 16, 'align' => 'center'));
        $subtitCaratula2 = 'subtitCaratual2';
        $word->addFontStyle($subtitCaratula2, array('name' => 'Arial', 'bold' => true, 'size' => 14, 'align' => 'center'));

        $titProyCaratula = 'titProyCaratula';
        $word->addFontStyle($titProyCaratula, array('name' => 'Arial', 'bold' => true, 'size' => 18, 'align' => 'justify'));

        $styleImage = array('align' => 'center', 'width' => 280, 'height' => 200);

        /* ------------------------------- */

        /* CARATULA */

        $caratulaSesion = $word->addSection();
        $nuevaSesion = $word->addSection();

        // CARATULA UNT
        $caratulaSesion->addText("UNIVERSIDAD NACIONAL DE TRUJILLO", $tituloCaratula, $styleCaratula1);
        $caratulaSesion->addText("FACULTAD DE CIENCIAS ECONÓMICAS", $subtitCaratula1, $styleCaratula1);
        $caratulaSesion->addText("ESCUELA PROFESIONAL DE ".$ESCUELA_PROFESIONAL, $subtitCaratula2, $styleCaratula1);

        $caratulaSesion->addImage("img/logoUNTcaratula.png", $styleImage);

        $caratulaSesion->addText($titulo, $titProyCaratula, $styleCaratula1);
        $caratulaSesion->addTextBreak(1.5);

        $caratulaSesion->addText("PROYECTO DE TESIS", array('name' => 'Arial', 'bold' => true, 'size' => 16), $styleCaratula1);
        $caratulaSesion->addText("Para obtener el Título Profesional de:", array('name' => 'Arial', 'bold' => true, 'size' => 16), $styleCaratula1);

        $caratulaSesion->addText($TITULO_BACHILLER, array('name' => 'Arial', 'bold' => true, 'size' => 18), $styleCaratula1);


        if (count($estudiantes_grupo) > 1) {
            $nuevaSesion->addText($estudiante1, null, $styleContenido);
            $nuevaSesion->addText($estudiante2, null, $styleContenido);
        } else {
            $nuevaSesion->addText($estudiante1, null, $styleContenido);
        }
        $caratulaSesion->addText("Bachiller en ".$TITULO_BACHILLER, array('name' => 'Arial', 'bold' => true, 'size' => 16), $styleCaratula1);

        $caratulaSesion->addText("Asesor: " . $nombre_asesor, array('name' => 'Arial', 'bold' => true, 'size' => 16), $styleCaratula2);

        $caratulaSesion->addText("ORCID: " . $orcid_asesor, array('name' => 'Arial', 'bold' => true, 'size' => 14), $styleCaratula2);

        $caratulaSesion->addTextBreak(1.5);
        $caratulaSesion->addText("Trujillo - Perú", array('name' => 'Arial', 'bold' => true, 'size' => 16), $styleCaratula1);
        $caratulaSesion->addText("2024", array('name' => 'Arial', 'bold' => true, 'size' => 16), $styleCaratula1);

        /* ------------------------------------------ */

        $nuevaSesion->addText("I. GENERALIDADES", $titulos);

        $nuevaSesion->addListItem("1. TÍTULO", 0.5, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $nuevaSesion->addText("'" . $titulo . "'", null, $styleTitulo);

        $nuevaSesion->addListItem("2. AUTORES", 0.5, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        if (count($estudiantes_grupo) > 1) {
            $nuevaSesion->addText($estudiante1, null, $styleContenido);
            $nuevaSesion->addText($estudiante2, null, $styleContenido);
        } else {
            $nuevaSesion->addText($estudiante1, null, $styleContenido);
        }

        $nuevaSesion->addListItem("3. ASESOR", 0.5, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $nuevaSesion->addText($nombre_asesor, null, $styleContenido);
        $nuevaSesion->addText($grado_asesor, null, $styleContenido);
        $nuevaSesion->addText($titulo_asesor, null, $styleContenido);
        $nuevaSesion->addText($direccion_asesor, null, $styleContenido);

        $nuevaSesion->addListItem("4. TIPO DE INVESTIGACIÓN", 0.5, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $nuevaSesion->addText($cod_tinvestigacion, null, $styleContenido);
        $nuevaSesion->addText("De acuerdo al fin que se persigue: ".$ti_finpersigue, null, $styleContenido);
        $nuevaSesion->addText("De acuerdo al diseño de investigacion: ".$ti_disinvestigacion, null, $styleContenido);

        $nuevaSesion->addListItem("5. LOCALIDAD E INSTITUCIÓN DONDE SE DESARROLLARÁ EL PROYECTO", 0.5, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $nuevaSesion->addText("Localidad: ".$localidad, null, $styleContenido);
        $nuevaSesion->addText("Institución: ".$institucion, null, $styleContenido);

        $nuevaSesion->addListItem("6. DURACIÓN DE LA EJECUCIÓN DEL PROYECTO", 0.5, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $nuevaSesion->addText($meses_ejecucion." MESES", null, $styleContenido);

        /* Tabla del Cronograma de Trabajo */
        /* Estilo de la table */
        $tableStyle = array(
            'borderSize' => 6,
            'cellMargin' => 50,
            'alignMent' => 'center'
        );

        $nuevaSesion->addListItem("7. CRONOGRAMA DE TRABAJO", 0.5, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);

        $cronogramaTable = $nuevaSesion->addTable($tableStyle);

        $cronogramaTable->addRow(400);
        $cronogramaTable->addCell(3500)->addText('ACTIVIDAD', $titulos);
        $cronogramaTable->addCell(1500)->addText('MES INICIO', $titulos);
        $cronogramaTable->addCell(1500)->addText('MES TERMINO', $titulos);


        // $cronogramaTable->addRow(400);
        // $cronogramaTable->addCell(3500)->addText('Preparacion de instrumentos de recoleccion de datos',$titulos);
        // for ($i=0; $i <= count($reparacionInstrum)-1 ; $i++) {
        //     $cronogramaTable->addCell(2000)->addText($reparacionInstrum[$i]);
        // }


        // $cronogramaTable->addRow(400);
        // $cronogramaTable->addCell(3500)->addText('Recoleccion de datos',$titulos);
        // for ($i=0; $i <= count($recoleccionDatos)-1 ; $i++) {
        //     $cronogramaTable->addCell(2000)->addText($recoleccionDatos[$i]);
        // }

        // $cronogramaTable->addRow(400);
        // $cronogramaTable->addCell(3500)->addText('Analisis de Datos',$titulos);
        // for ($i=0; $i <= count($analisisDatos)-1 ; $i++) {
        //     $cronogramaTable->addCell(2000)->addText($analisisDatos[$i]);
        // }

        // $cronogramaTable->addRow(400);
        // $cronogramaTable->addCell(3500)->addText('Elaboracion del Informe',$titulos);
        // for ($i=0; $i <= count($elaboracionInfo)-1 ; $i++) {
        //     $cronogramaTable->addCell(2000)->addText($elaboracionInfo[$i]);
        // }


        /* ------------------------------------------ */

        /* Recursos */

        $recursos = recursos::where('cod_proyectotesis', '=', $tesis[0]->cod_proyectotesis)->latest('cod_recurso')->get();

        $arregloRecursos = [];

        $nuevaSesion->addListItem("8. RECURSOS", 0.5, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);

        $arregloRecTipo = [];
        if ($recursos->count() != 0) {
            foreach ($recursos as $rec) {
                $arregloRecTipo[] = $rec->tipo;
                $arregloRecursos[] = $rec->descripcion;
            }

            $cont1 = 0;
            $cont2 = 0;
            $cont3 = 0;
            for ($i = count($recursos) - 1; $i >= 0; $i--) {
                if ($arregloRecTipo[$i] == 'Personal') {
                    if ($cont1 == 0) {
                        $nuevaSesion->addListItem("8.1. Personal: ", 1, null, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
                    }
                    $nuevaSesion->addListItem("8.1.".($cont1 + 1) . ". " . $arregloRecursos[$i], 2, null, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
                    $cont1++;
                }
                if ($arregloRecTipo[$i] == 'Bienes') {
                    if ($cont2 == 0) {
                        $nuevaSesion->addListItem("8.2. Bienes: ", 1, null, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
                    }
                    $nuevaSesion->addListItem("8.2.".($cont2 + 1) . ". " . $arregloRecursos[$i], 2, null, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
                    $cont2++;
                }
                if ($arregloRecTipo[$i] == 'Servicios') {
                    if ($cont3 == 0) {
                        $nuevaSesion->addListItem("8.3. Servicios: ", 1, null, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
                    }
                    $nuevaSesion->addListItem("8.3.".($cont3 + 1) . ". " . $arregloRecursos[$i], 2, null, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
                    $cont3++;
                }
            }
        }

        /* ---------------- */

        $nuevaSesion->addListItem("9. PRESUPUESTO", 0.5, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);

        /* Presupuesto */
        $presupues = DB::table('presupuesto_proyecto')->join('presupuesto', 'presupuesto_proyecto.cod_presupuesto', '=', 'presupuesto.cod_presupuesto')
            ->select('precio', 'presupuesto.codeUniversal', 'presupuesto.denominacion')
            ->where('cod_proyectotesis', '=', $tesis[0]->cod_proyectotesis)->latest('cod_presProyecto')->get();

        $presupuestoTable = $nuevaSesion->addTable($tableStyle);

        $presupuestoTable->addRow(400);
        $presupuestoTable->addCell(2000)->addText("CÓDIGO", $titulos);
        $presupuestoTable->addCell(4000)->addText("DENOMINACIÓN", $titulos);
        $presupuestoTable->addCell(1500)->addText("PRECIO TOTAL (S/.)", $titulos);
        $totalP = 0;
        if ($presupues->count() != 0) {
            for ($i = count($presupues) - 1; $i >= 0; $i--) {
                $presupuestoTable->addRow(400);
                $presupuestoTable->addCell(2000)->addText($presupues[$i]->codeUniversal, $titulos);
                $presupuestoTable->addCell(4000)->addText($presupues[$i]->denominacion, $titulos);
                $presupuestoTable->addCell(1500)->addText($presupues[$i]->precio . ".00", $titulos);
                $totalP += floatval($presupues[$i]->precio);
            }
        }

        $presupuestoTable->addRow(400);
        $presupuestoTable->addCell(2000)->addText("", $titulos);
        $presupuestoTable->addCell(4000)->addText("TOTAL", $titulos);
        $presupuestoTable->addCell(1500)->addText($totalP . ".00", $titulos); //x


        /* ----------------------------------- */


        $nuevaSesion->addListItem("10. FINANCIAMIENTO", 0.5, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $nuevaSesion->addText($financiamiento);

        $nuevaSesion->addPageBreak();

        $nuevaSesion->addText("II. PLAN DE INVESTIGACIÓN", $titulos, $styleContenido);
        $nuevaSesion->addListItem("2.1. REALIDAD PROBLEMÁTICA, ANTECEDENTES Y JUSTIFICACIÓN DE LA INVESTIGACIÓN", 0.5, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $nuevaSesion->addListItem("2.1.1. REALIDAD PROBLEMÁTICA", 0.5, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $nuevaSesion->addText($real_problematica, null, $styleContenido);

        $nuevaSesion->addListItem("2.1.2. ANTECEDENTES", 0.5, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $nuevaSesion->addText($antecedentes, null, $styleContenido);

        $nuevaSesion->addListItem("2.1.3. JUSTIFICACIÓN DE LA INVESTIGACIÓN", 0.5, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $nuevaSesion->addText($justificacion, null, $styleContenido);

        $nuevaSesion->addListItem("2.2. FORMULACIÓN DEL PROBLEMA", 0.5, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $nuevaSesion->addText($formulacion_prob, null, $styleContenido);

        /* Objetivos */
        $objetivos = Objetivo::where('cod_proyectotesis', '=', $tesis[0]->cod_proyectotesis)->latest('cod_objetivo')->get();
        $nuevaSesion->addListItem("2.3. OBJETIVOS GENERALES Y ESPECÍFICOS", 0.5, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        if ($objetivos->count() != 0) {
            $arregloObjetivo = [];

            $arregloObjTipo = [];
            foreach ($objetivos as $obj) {
                $arregloObjTipo[] = $obj->tipo;
                $arregloObjetivo[] = $obj->descripcion;
            }



            $cont4 = 0;
            $cont5 = 0;
            for ($i = count($objetivos) - 1; $i >= 0; $i--) {
                if ($arregloObjTipo[$i] == 'General') {
                    if ($cont4 == 0) {
                        $nuevaSesion->addListItem("2.3.1 Generales: ", 1, null, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
                    }
                    $nuevaSesion->addListItem("2.3.1." . ($cont4 + 1) . ". " . $arregloObjetivo[$i], 2, null, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
                    $cont4++;
                }
                if ($arregloObjTipo[$i] == 'Especifico') {
                    if ($cont5 == 0) {
                        $nuevaSesion->addListItem("2.3.2. Específicos: ", 1, null, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
                    }
                    $nuevaSesion->addListItem("2.3.2." . ($cont5 + 1) . ". " . $arregloObjetivo[$i], 2, null, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
                    $cont5++;
                }
            }
        }

        /* ------------------------ */
        $nuevaSesion->addListItem("2.4. MARCO TEÓRICO, CONCEPTUAL Y LEGAL", 0.5, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);

        $nuevaSesion->addListItem("2.4.1. MARCO TEÓRICO", 0.5, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $nuevaSesion->addText($marco_teorico, null, $styleContenido);

        $nuevaSesion->addListItem("2.4.2. MARCO CONCEPTUAL", 0.5, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $nuevaSesion->addText($marco_conceptual, null, $styleContenido);

        if($marco_legal != null && $marco_legal != ""){
            $nuevaSesion->addListItem("2.4.3. MARCO LEGAL", 0.5, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
            $nuevaSesion->addText($marco_legal, null, $styleContenido);
        }

        $nuevaSesion->addListItem("2.5. FORMULACION DE LA HIPÓTESIS", 0.5, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $nuevaSesion->addText($form_hipotesis, null, $styleContenido);

        $nuevaSesion->addListItem("2.6. DISEÑO DE INVESTIGACIÓN", 0.5, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $nuevaSesion->addListItem("2.6.1. MATERIAL. MÉTODOS Y TÉCNICAS", 0.5, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $nuevaSesion->addListItem("2.6.1.1. MATERIAL: OBJETO DE ESTUDIO, POBLACIÓN Y MUESTRA", 1, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $nuevaSesion->addListItem("2.6.1.1.1. OBJETO DE ESTUDIO", 1, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $nuevaSesion->addText($objeto_estudio, null, $styleContenido);
        $nuevaSesion->addListItem("2.6.1.1.2. POBLACIÓN", 1, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $nuevaSesion->addText($poblacion, null, $styleContenido);
        $nuevaSesion->addListItem("2.6.1.1.3. MUESTRA", 1, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $nuevaSesion->addText($muestra, null, $styleContenido);
        $nuevaSesion->addListItem("2.6.1.2. MÉTODOS", 1, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $nuevaSesion->addText($metodos, null, $styleContenido);
        $nuevaSesion->addListItem("2.6.1.3. TÉCNICAS E INTRUMENTOS DE RECOLECCIÓN DE DATOS", 1, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $nuevaSesion->addText($tecnicas_instrum, null, $styleContenido);


        $nuevaSesion->addListItem("2.6.2. INSTRUMENTACIÓN Y/O FUENTES DE DATOS", 1, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $nuevaSesion->addText($instrumentacion, null, $styleContenido);

        $nuevaSesion->addListItem("2.6.3. ESTRATEGIAS METODOLÓGICAS", 1, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
        $nuevaSesion->addText($estg_metodologicas, null, $styleContenido);

        /* Variables */
        $variables = variableOP::where('cod_proyectotesis', '=', $tesis[0]->cod_proyectotesis)->latest('cod_variable')->get();
        $nuevaSesion->addListItem("2.6.4. OPERACIONALIZACIÓN DE VARIABLES Y MATRIZ DE CONSISTENCIA", 1, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);

        if ($variables->count() != 0) {

            $arregloVariable = [];


            foreach ($variables as $var) {
                $arregloVariable[] = $var->descripcion;
            }

            for ($i = 0; $i <= count($variables) - 1; $i++) {
                $nuevaSesion->addListItem("10.8." . ($i + 1) . ". " . $arregloVariable[$i], 2, null, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);
            }
        }

        $footer = $nuevaSesion->addFooter();

        $footer->addPreserveText(1);

        /* ---------------------------- */

        /* Regerencias Bibliograficas */

        $referencia = referencias::where('cod_proyectotesis', '=', $tesis[0]->cod_proyectotesis)->latest('cod_referencias')->get();

        $arregloRefTipo = [];
        $arregloRefA = [];
        $arregloRefP = [];
        $arregloRefT = [];
        $arregloRefF = [];

        $arregloEd = [];
        $arregloTCap = [];
        $arregloNC = [];
        $arregloTRev = [];
        $arregloV = [];
        $arregloNWeb = [];
        $arregloNPe = [];
        $arregloNIn = [];
        $arregloS = [];
        $arregloNEd = [];

        $nuevaSesion->addListItem("2.7. REFERENCIAS BIBLIOGRÁFICAS", 0.5, $titulos, [\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER], $styleContenido);

        if ($referencia->count() != 0) {

            foreach ($referencia as $ref) {
                $arregloRefTipo[] = $ref->cod_tiporeferencia;
                $arregloRefA[] = $ref->autor;
                $arregloRefP[] = $ref->fPublicacion;
                $arregloRefT[] = $ref->titulo;
                $arregloRefF[] = $ref->fuente;
                $arregloEd[] =  $ref->editorial;
                $arregloTCap[] = $ref->title_cap;
                $arregloNC[] = $ref->num_capitulo;
                $arregloTRev[] = $ref->title_revista;
                $arregloV[] = $ref->volumen;
                $arregloNWeb[] = $ref->name_web;
                $arregloNPe[] = $ref->name_periodista;
                $arregloNIn[] = $ref->name_institucion;
                $arregloS[] = $ref->subtitle;
                $arregloNEd[] = $ref->name_editor;
            }




            for ($i = 0; $i <= count($referencia) - 1; $i++) {
                if ($arregloRefTipo[$i] == 1) {
                    $nuevaSesion->addText($arregloRefA[$i] . "." . "(" . $arregloRefP[$i] . ")." . $arregloTCap[$i] . "." . $arregloRefF[$i] . "," . $arregloRefT[$i] . " (capitulo " . $arregloNC[$i] . ")" . $arregloEd[$i] . ".", null, $styleContenido);
                }
                if ($arregloRefTipo[$i] == 2) {
                    $nuevaSesion->addText($arregloRefA[$i] . "." . "(" . $arregloRefP[$i] . ")." . $arregloRefT[$i] . "." . $arregloRefF[$i] . "." . $arregloTRev[$i] . ",pp " . $arregloV[$i] . ".", null, $styleContenido);
                }
                if ($arregloRefTipo[$i] == 3) {
                    $nuevaSesion->addText($arregloRefA[$i] . "." . "(" . $arregloRefP[$i] . ")." . $arregloRefT[$i] . "." . $arregloRefF[$i] . "." . $arregloNWeb[$i] . ".", null, $styleContenido);
                }
                if ($arregloRefTipo[$i] == 4) {
                    $nuevaSesion->addText($arregloRefA[$i] . "." . "(" . $arregloRefP[$i] . ")." . $arregloRefT[$i] . "." . $arregloRefF[$i] . "." . $arregloNPe[$i] . ".", null, $styleContenido);
                }
                if ($arregloRefTipo[$i] == 5) {
                    $nuevaSesion->addText($arregloRefA[$i] . "." . "(" . $arregloRefP[$i] . ")." . $arregloRefT[$i] . "." . $arregloRefF[$i] . "." . $arregloNIn[$i] . ".", null, $styleContenido);
                }
                if ($arregloRefTipo[$i] == 6) {
                    $nuevaSesion->addText($arregloRefA[$i] . "." . "(" . $arregloRefP[$i] . ")." . $arregloRefT[$i] . ": " . $arregloRefF[$i] . "," . $arregloS[$i] . ", " . $arregloNEd[$i] . ".", null, $styleContenido);
                }
            }
        }

        // Matriz Operacional

        $nuevaSesion->addText("MATRIZ DE OPERACIONALIZACIÓN", null, $titulos);

        $matriz = DB::table('matriz_operacional')->select('matriz_operacional.*')->where('cod_proyectotesis', '=', $tesis[0]->cod_proyectotesis)->get();

        $matrizTable = $nuevaSesion->addTable($tableStyle);
        $matrizTable->addRow();
        $matrizTable->addCell()->addText("VARIABLES", $titulos);
        $matrizTable->addCell()->addText("DEFINICIÓN CONCEPTUAL", $titulos);
        $matrizTable->addCell()->addText("DEFINICIÓN OPERACIONAL", $titulos);
        $matrizTable->addCell()->addText("DIMENSIONES", $titulos);
        $matrizTable->addCell()->addText("INDICADORES", $titulos);
        $matrizTable->addCell()->addText("ESCALA", $titulos);

        if ($matriz->count() != 0) {
            $matrizTable->addRow();
            $matrizTable->addCell()->addText($matriz[0]->variable_I);
            $matrizTable->addCell()->addText($matriz[0]->def_conceptual_I);
            $matrizTable->addCell()->addText($matriz[0]->def_operacional_I);
            $matrizTable->addCell()->addText($matriz[0]->dimensiones_I);
            $matrizTable->addCell()->addText($matriz[0]->indicadores_I);
            $matrizTable->addCell()->addText($matriz[0]->escala_I);

            $matrizTable->addRow();
            $matrizTable->addCell()->addText($matriz[0]->variable_D);
            $matrizTable->addCell()->addText($matriz[0]->def_conceptual_D);
            $matrizTable->addCell()->addText($matriz[0]->def_operacional_D);
            $matrizTable->addCell()->addText($matriz[0]->dimensiones_D);
            $matrizTable->addCell()->addText($matriz[0]->indicadores_D);
            $matrizTable->addCell()->addText($matriz[0]->escala_D);
        }


        /* ------------------------------------------------------- */

        $objetoEscrito = \PhpOffice\PhpWord\IOFactory::createWriter($word, 'Word2007');
        try {
            $objetoEscrito->save(storage_path('ProyectoTesis.docx'));
        } catch (\Throwable $th) {
            $th;
        }

        return response()->download(storage_path('ProyectoTesis.docx'));
    }

    public function descargaWordPlantillaUNT(Request $request){
        try{
            $template = new \PhpOffice\PhpWord\TemplateProcessor(documentTemplate:'plantilla/docs/PLANTILLA_UNT.docx');
            $template->setValue('facultad','');
        }catch(\PhpOffice\PhpWord\Exception\Exception $e){
            return back($e->getCode());
        }
    }
}
