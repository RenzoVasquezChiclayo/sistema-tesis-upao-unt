<?php

namespace App\Http\Controllers;

use App\Models\Asesor;
use App\Models\Detalle_Observaciones;
use App\Models\DocumentosEgresado;
use App\Models\Egresado;
use App\Models\Escuela;
use App\Models\EstudianteCT2022;
use App\Models\Facultad;
use App\Models\FormatoTitulo;
use App\Models\Historial_Observaciones;
use App\Models\ImgEgresado;
use App\Models\MatrizOperacional;
use App\Models\Objetivo;
use App\Models\ObservacionesProy;
use App\Models\recursos;
use App\Models\referencias;
use App\Models\Sede;
use App\Models\Tesis;
use App\Models\Tesis_2022;
use App\Models\TesisCT2022;
use App\Models\TipoInvestigacion;
use App\Models\User;
use App\Models\variableOP;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;
use PhpOffice\PhpWord\PhpWord;

class EgresadoController extends Controller
{

    public function index()
    {
        $id = auth()->user()->name;
        $egresado = Egresado::find($id);
        $facultad = Facultad::all();
        $escuela = Escuela::all();
        $sede = Sede::all();
        $tiposinvestigacion = TipoInvestigacion::all();


        $formatoTitulo = DB::connection('mysql')->table('formato_titulo')->join('img_egresado','formato_titulo.cod_matricula','=','img_egresado.cod_matricula')
                                ->join('escuela','formato_titulo.cod_escuela','escuela.cod_escuela')
                                ->join('facultad','escuela.cod_facultad','=','facultad.cod_facultad')
                                ->join('sede','formato_titulo.cod_sede','=','sede.cod_sede')
                                ->join('tipoinvestigacion','formato_titulo.cod_tinvestigacion','=','tipoinvestigacion.cod_tinvestigacion')
                                ->join('documentos_egresado','formato_titulo.cod_matricula','=','documentos_egresado.cod_matricula')
                                ->select('formato_titulo.*','img_egresado.referencia','facultad.nombre as facNombre','escuela.nombre as escNombre','sede.nombre as sedeNombre','tipoinvestigacion.descripcion as descripcionTI','documentos_egresado.*')
                                ->where('formato_titulo.cod_matricula','=',$id)->get();

        $formatoTituloAsesor = DB::connection('mysql')->table('formato_titulo')->join('asesor','formato_titulo.cod_docente','=','asesor.cod_docente')->where('formato_titulo.cod_matricula','=',$id)->where('formato_titulo.cod_docente','!=',null)->get();
        if (sizeof($formatoTituloAsesor)==0) {
            $validar = true;
        }else{
            $validar = false;
        }

        return view('egresados.agregarEgresado',['facultad'=>$facultad,'escuela'=>$escuela,'sede'=>$sede, 'egresado'=>$egresado, 'tiposinvestigacion'=>$tiposinvestigacion,'formatoTitulo'=>$formatoTitulo,'formatoTituloAsesor'=>$formatoTituloAsesor,'validar'=>$validar]);
    }


    public function create()
    {
        //
    }


    public function guardar(Request $request)
    {
        $egresado = Egresado::find($request->txtNumMatricula);
        $img = new ImgEgresado;
        $documentos = new DocumentosEgresado();

        $formatoTitulo = new FormatoTitulo;
        $codFormato = FormatoTitulo::select('codigo')->orderBy('codigo', 'desc')->first();
        try {
            if(!empty($codFormato)){
                if(strlen($codFormato->codigo)<4){
                    $formatoTitulo->cod_formato = str_repeat("0", 4 - strlen($codFormato->codigo)).($codFormato->codigo+1);
                }else{
                    $formatoTitulo->cod_formato = $codFormato->codigo+1;
                }
            }else{
                $formatoTitulo->cod_formato = '0001';
            }

            $formatoTitulo->cod_matricula = $egresado->cod_matricula;
            $formatoTitulo->tit_profesional = $request->txtTituloProfe;
            $formatoTitulo->fecha_nacimiento = $request->txtfNacimiento;

            $formatoTitulo->direccion = $request->txtDireccion;
            if ($request->txtTelefonoFijo == "") {
                $formatoTitulo->tele_fijo = "-";
            } else {
                $formatoTitulo->tele_fijo = $request->txtTelefonoFijo;
            }

            $formatoTitulo->tele_celular = $request->txtTelefonoCelular;
            $formatoTitulo->correo = $request->txtCorreo;
            $formatoTitulo->modalidad_titulo = $request->txtModalidadTit;
            if ($request->txt2daEsp == "") {
                $formatoTitulo->sgda_especialidad = "-";
            } else {
                $formatoTitulo->sgda_especialidad = $request->txt2daEsp;
            }
            $formatoTitulo->prog_extraordinario = $request->txtProgFormacion;
            $formatoTitulo->fecha_sustentacion = $request->txtFechaSustentacion;
            $formatoTitulo->fecha_colacion = $request->txtFechaColacion;

            if ($request->txtCentroTrabajo =="") {
                $formatoTitulo->centro_labores = "-";
            } else {
                $formatoTitulo->centro_labores = $request->txtCentroTrabajo;
            }
            $formatoTitulo->colegio = $request->txtColegio;

            if ($request->rubroColegio == null) {
                $formatoTitulo->tipo_colegio = 'PUBLICA';
            }else{
                $formatoTitulo->tipo_colegio = $request->rubroColegio;
            }

            if(strlen($request->cboEscuela)<4){
                $formatoTitulo->cod_escuela = str_repeat("0", 4 - strlen($request->cboEscuela)).$request->cboEscuela;
            }else{
                $formatoTitulo->cod_escuela = $request->cboEscuela;
            }
            if(strlen($request->cboSede)<2){
                $formatoTitulo->cod_sede = str_repeat("0", 2 - strlen($request->cboSede)).$request->cboSede;
            }else{
                $formatoTitulo->cod_sede = $request->cboSede;
            }

            if(strlen($request->cboTInvestigacion)<4){
                $formatoTitulo->cod_tinvestigacion = str_repeat("0", 4 - strlen($request->cboTInvestigacion)).$request->cboTInvestigacion;
            }else{
                $formatoTitulo->cod_tinvestigacion = $request->cboTInvestigacion;
            }


            if( $request->hasFile('fileImgEgresado') ){
                $file = $request->file('fileImgEgresado');
                $destinationPath = 'plantilla/img/';
                $filename = $request->txtNumMatricula.'-'.$request->cboSede.'-Img.jpg';
                $uploadSuccess = $request->file('fileImgEgresado')->move($destinationPath,$filename);
                $img->referencia = $filename;
                $img->cod_matricula = $request->txtNumMatricula;
            }
            if( $request->hasFile('fileFUT') ){
                $file = $request->file('fileFUT');
                $destinationPath = 'plantilla/pdf-egresado/';
                $filename = $request->txtNumMatricula.'-FUT.pdf';
                $uploadSuccess = $request->file('fileFUT')->move($destinationPath,$filename);
                $documentos->fut = $filename;
                $documentos->cod_matricula = $request->txtNumMatricula;
            }
            if( $request->hasFile('fileConstancia') ){
                $file = $request->file('fileConstancia');
                $destinationPath = 'plantilla/pdf-egresado/';
                $filename = $request->txtNumMatricula.'-ConstanciaNoDuplicidad.pdf';
                $uploadSuccess = $request->file('fileConstancia')->move($destinationPath,$filename);
                $documentos->constancia = $filename;
                $documentos->cod_matricula = $request->txtNumMatricula;
            }
            if( $request->hasFile('fileReciboPago') ){
                $file = $request->file('fileReciboPago');
                $destinationPath = 'plantilla/pdf-egresado/';
                $filename = $request->txtNumMatricula.'-ReciboPago.pdf';
                $uploadSuccess = $request->file('fileReciboPago')->move($destinationPath,$filename);
                $documentos->recibo = $filename;
                $documentos->cod_matricula = $request->txtNumMatricula;
            }

            if( $request->hasFile('fileFirmaEgresado') ){
                $file = $request->file('fileFirmaEgresado');
                $destinationPath = 'plantilla/img/firmas/';
                $filename = $request->txtNumMatricula.'-'.$request->cboSede.'-Firma.jpg';
                $uploadSuccess = $request->file('fileFirmaEgresado')->move($destinationPath,$filename);
                $formatoTitulo->firmaIMG = $filename;

            }
            //$formatoTitulo->cod_docente = null;
            $formatoTitulo->estado = 1;
            $formatoTitulo->fecha = now();

            /* return view('plantilla.dashboard'); */
        } catch (\Throwable $th) {
            $th;
        }

        $formatoTitulo->save();
        $documentos->save();
        $img->save();

        $tesis = new Tesis;
        $tesis->cod_matricula = $egresado->cod_matricula;
        $tesis->nombres = $egresado->nombres.' '.$egresado->apellidos;
        $tesis->direccion = $formatoTitulo->direccion;

        $escuela = Escuela::find($formatoTitulo->cod_escuela);

        $tesis->escuela = $escuela->nombre;
        $tesis->estado = 0;

        $tesis->save();
;
        /* ----------------------------------------------------------- */
        return redirect()->route('egresadoindex');
    }

    public function descargaProyecto(Request $request){
        $tesis = Tesis::where('cod_proyinvestigacion',$request->id_tesis)->get();
        /* CODIGO PARA GENERAR EL WORD DEL PROYECTO DE TESIS */

            /*Datos del Autor*/
            $nombres =$tesis[0]->nombres;
            /* $tesis->grado_academico = $request->cboGrAcademicoAutor; */
            $direccion = $tesis[0]->direccion;
            $escuela = $tesis[0]->escuela;

            /*Datos del Asesor*/
            $nombre_asesor = $tesis[0]->nombre_asesor;
            $grado_asesor = $tesis[0]->grado_asesor;
            $titulo_asesor = $tesis[0]->titulo_asesor;
            $direccion_asesor =$tesis[0]->direccion_asesor;

            /*Proyecto de Investigacion y/o Tesis*/
            $titulo = $tesis[0]->titulo;

            //Investigacion
            //Aqui se hizo un cambio
            $tipoInvestiga = TipoInvestigacion::find($tesis[0]->cod_tinvestigacion);
            $cod_tinvestigacion = $tipoInvestiga->descripcion;

            $ti_finpersigue =$tesis[0]->ti_finpersigue;
            $ti_disinvestigacion = $tesis[0]->ti_disinvestigacion;

            //Desarrollo del proyecto
            $localidad = $tesis[0]->localidad;
            $institucion = $tesis[0]->institucion;
            $meses_ejecucion = $tesis[0]->meses_ejecucion;

            //Cronograma
            $reparacionInstrum = $tesis[0]->t_ReparacionInstrum;
            $reparacionInstrum = explode("-",$reparacionInstrum);

            //dd($reparacionInstrum);

            $recoleccionDatos = $tesis[0]->t_RecoleccionDatos;
            $recoleccionDatos = explode("-",$recoleccionDatos);

            $analisisDatos = $tesis[0]->t_AnalisisDatos;
            $analisisDatos = explode("-",$analisisDatos);

            $elaboracionInfo = $tesis[0]->t_ElaboracionInfo;
            $elaboracionInfo = explode("-",$elaboracionInfo);

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


            $word = new PhpWord();

            /* Creacion de las fuentes */
            $word->setDefaultFontName('Times New Roman');
            $word->setDefaultFontSize(11);


            $titulos = 'titulos';
            $word->addFontStyle($titulos,array('bold'=>true));

            /* Estilos de la caratula */
            $styleCaratula1 = 'styleCaratula1';
            $word->addParagraphStyle($styleCaratula1,array('align'=>'center','spacing' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.08)));

            $styleCaratula2 = 'styleCaratula2';
            $word->addParagraphStyle($styleCaratula2,array('align'=>'left','spacing' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.08)));

            $styleTitulo = 'styleTitulo';
            $word->addParagraphStyle($styleTitulo,array('align'=>'center','spacing' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.08)));

            $styleContenido = 'styleContenido';
            $word->addParagraphStyle($styleContenido,array('align'=>'left','spacing' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(0.08)));

            $tituloCaratula = 'tituloCaratula';
            $word->addFontStyle($tituloCaratula,array('name'=>'Arial','bold'=>true,'size'=>20,'position'=>'raised'));

            $subtitCaratula1 = 'subtitCaratual1';
            $word->addFontStyle($subtitCaratula1,array('name'=>'Arial','bold'=>true,'size'=>16,'align'=>'center'));
            $subtitCaratula2 = 'subtitCaratual2';
            $word->addFontStyle($subtitCaratula2,array('name'=>'Arial','bold'=>true,'size'=>14,'align'=>'center'));

            $titProyCaratula = 'titProyCaratula';
            $word->addFontStyle($titProyCaratula,array('name'=>'Arial','bold'=>true,'size'=>18,'align'=>'justify'));

            $styleImage = array('align'=>'center','width'=>280,'height'=>200);


            /* -------------------------------------- */

            /* $word->addNumberingStyle(
                'multilevel',
                array(
                    'type' => 'multilevel',
                    'levels' => array(
                        array('format' => 'decimal','text'=>'%1','left'=>360,'hanging'=>360,'tabPos'=>360),
                        array('format' => 'upperLetter','text'=>'%2','left'=>720,'hanging'=>360,'tabPos'=>720)
                    )
                )
            ); */


            /* ------------------------------- */

            /* CARATULA */

            $caratulaSesion = $word->addSection();
            $nuevaSesion = $word->addSection();


            $caratulaSesion->addText("UNIVERSIDAD NACIONAL DE TRUJILLO",$tituloCaratula,$styleCaratula1);
            $caratulaSesion->addText("FACULTAD DE CIENCIAS ECONOMICAS",$subtitCaratula1,$styleCaratula1);
            $caratulaSesion->addText("ESCUELA PROFESIONAL DE CONTABILIDAD Y FINANZAS",$subtitCaratula2,$styleCaratula1);

            $caratulaSesion->addImage("img/logoUNTcaratula.png",$styleImage);

            $caratulaSesion->addText($titulo,$titProyCaratula,$styleCaratula1);
            $caratulaSesion->addTextBreak(1.5);

            $caratulaSesion->addText("PROYECTO DE TESIS",array('name'=>'Arial','bold'=>true,'size'=>16),$styleCaratula1);
            $caratulaSesion->addText("Para obtener el Titulo Porfesional de:",array('name'=>'Arial','bold'=>true,'size'=>16),$styleCaratula1);

            $caratulaSesion->addText($escuela,array('name'=>'Arial','bold'=>true,'size'=>18),$styleCaratula1);

            $caratulaSesion->addTextBreak(2);

            $caratulaSesion->addText($nombres,array('name'=>'Arial','bold'=>true,'size'=>16),$styleCaratula1);
            $caratulaSesion->addText("Bachiller en Ciencias Economicas",array('name'=>'Arial','bold'=>true,'size'=>16),$styleCaratula1);

            $caratulaSesion->addText("Asesor: ".$nombre_asesor,array('name'=>'Arial','bold'=>true,'size'=>16),$styleCaratula2);

            $caratulaSesion->addTextBreak(2);
            $caratulaSesion->addText("Trujillo - Peru",array('name'=>'Arial','bold'=>true,'size'=>16),$styleCaratula1);
            $caratulaSesion->addText("2022",array('name'=>'Arial','bold'=>true,'size'=>16),$styleCaratula1);

            /* ------------------------------------------ */





            $nuevaSesion->addText("I. GENERALIDADES",$titulos);

            $nuevaSesion->addListItem("1. TITULO",0.5,$titulos,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
            $nuevaSesion->addText("'".$titulo."'",null,$styleTitulo);

            $nuevaSesion->addListItem("2. AUTOR",0.5,$titulos,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
            $nuevaSesion->addText($nombres,null,$styleContenido);
            $nuevaSesion->addText($direccion,null,$styleContenido);
            $nuevaSesion->addText($escuela,null,$styleContenido);

            $nuevaSesion->addListItem("3. ASESOR",0.5,$titulos,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
            $nuevaSesion->addText($nombre_asesor,null,$styleContenido);
            $nuevaSesion->addText($grado_asesor,null,$styleContenido);
            $nuevaSesion->addText($titulo_asesor,null,$styleContenido);
            $nuevaSesion->addText($direccion_asesor,null,$styleContenido);

            $nuevaSesion->addListItem("4. TIPO DE INVESTIGACION",0.5,$titulos,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
            $nuevaSesion->addText($cod_tinvestigacion,null,$styleContenido);
            $nuevaSesion->addText("De acuerdo al fin que se persigue: ".$ti_finpersigue,null,$styleContenido);
            $nuevaSesion->addText("De acuerdo al diseño de investigacion".$ti_disinvestigacion,null,$styleContenido);

            $nuevaSesion->addListItem("5. LOCALIDAD E INSTITUCION DONDE SE DESARROLLO EL PROYECTO",0.5,$titulos,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
            $nuevaSesion->addText("Localidad: ".$localidad,null,$styleContenido);
            $nuevaSesion->addText("Institucion: ".$institucion,null,$styleContenido);

            $nuevaSesion->addListItem("6. DURECION DE LA EJECUCION DEL PROYECTO",0.5,$titulos,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
            $nuevaSesion->addText($meses_ejecucion." MESES",null,$styleContenido);

            /* Tabla del Cronograma de Trabajo */
            /* Estilo de la table */
            $tableStyle = array(
                'borderSize' => 6,
                'cellMargin' => 50,
                'alignMent' => 'center'
            );

            $nuevaSesion->addListItem("7. CRONOGRAMA DE TRABAJO",0.5,$titulos,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);

            $cronogramaTable = $nuevaSesion->addTable($tableStyle);

            $cronogramaTable->addRow(400);
            $cronogramaTable->addCell(3500)->addText('ACTIVIDAD',$titulos);
            $cronogramaTable->addCell(1500)->addText('MES INICIO',$titulos);
            $cronogramaTable->addCell(1500)->addText('MES TERMINO',$titulos);


            $cronogramaTable->addRow(400);
            $cronogramaTable->addCell(3500)->addText('Preparacion de instrumentos de recoleccion de datos',$titulos);
            for ($i=0; $i <= count($reparacionInstrum)-1 ; $i++) {
                $cronogramaTable->addCell(2000)->addText($reparacionInstrum[$i]);
            }


            $cronogramaTable->addRow(400);
            $cronogramaTable->addCell(3500)->addText('Recoleccion de datos',$titulos);
            for ($i=0; $i <= count($recoleccionDatos)-1 ; $i++) {
                $cronogramaTable->addCell(2000)->addText($recoleccionDatos[$i]);
            }

            $cronogramaTable->addRow(400);
            $cronogramaTable->addCell(3500)->addText('Analisis de Datos',$titulos);
            for ($i=0; $i <= count($analisisDatos)-1 ; $i++) {
                $cronogramaTable->addCell(2000)->addText($analisisDatos[$i]);
            }

            $cronogramaTable->addRow(400);
            $cronogramaTable->addCell(3500)->addText('Elaboracion del Informe',$titulos);
            for ($i=0; $i <= count($elaboracionInfo)-1 ; $i++) {
                $cronogramaTable->addCell(2000)->addText($elaboracionInfo[$i]);
            }


            /* ------------------------------------------ */

            /* Recursos */

            $recursos = recursos::where('cod_proyinvestigacion','=',$tesis[0]->cod_proyinvestigacion)->latest('cod_recurso')->get();

            $arregloRecursos = [];

            $nuevaSesion->addListItem("8. RECURSOS",0.5,$titulos,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);

            $arregloRecTipo = [];

            foreach ($recursos as $rec) {
                $arregloRecTipo[] = $rec->tipo;
                $arregloRecursos[] = $rec->descripcion;
            }

            $cont1 = 0;
            $cont2 = 0;
            $cont3 = 0;
            for ($i=count($recursos)-1; $i >=0 ; $i--) {
                if ($arregloRecTipo[$i] == 'Personal') {
                    if ($cont1 == 0) {
                        $nuevaSesion->addListItem("8.1. Personal: ",1,null,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
                    }
                    $nuevaSesion->addListItem("8.1.".($cont1+1).". ".$arregloRecursos[$i],2,null,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
                    $cont1++;
                }
                if ($arregloRecTipo[$i] == 'Bienes') {
                    if ($cont2 == 0) {
                        $nuevaSesion->addListItem("8.2. Bienes: ",1,null,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
                    }
                    $nuevaSesion->addListItem("8.2.".($cont2+1).". ".$arregloRecursos[$i],2,null,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
                    $cont2++;
                }
                if ($arregloRecTipo[$i] == 'Servicios') {
                    if ($cont3 == 0) {
                        $nuevaSesion->addListItem("8.3. Servicios: ",1,null,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
                    }
                    $nuevaSesion->addListItem("8.3.".($cont3+1).". ".$arregloRecursos[$i],2,null,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
                    $cont3++;
                }
            }

            /* ---------------- */

            $nuevaSesion->addListItem("9. PRESUPUESTO",0.5,$titulos,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);

            /* Presupuesto */
            $presupues = DB::connection('mysql')->table('presupuesto_proyecto')->join('presupuesto','presupuesto_proyecto.cod_presupuesto','=','presupuesto.cod_presupuesto')
                                                            ->select('precio','presupuesto.codeUniversal','presupuesto.denominacion')
                                                            ->where('cod_proyinvestigacion','=',$tesis[0]->cod_proyinvestigacion)->latest('cod_presProyecto')->get();

            $presupuestoTable = $nuevaSesion->addTable($tableStyle);

            $presupuestoTable->addRow(400);
            $presupuestoTable->addCell(2000)->addText("CODIGO",$titulos);
            $presupuestoTable->addCell(4000)->addText("DENOMINACION",$titulos);
            $presupuestoTable->addCell(1500)->addText("PRECIO TOTAL (S/.)",$titulos);

            for ($i=count($presupues)-1; $i >= 0; $i--) {
                $presupuestoTable->addRow(400);
                $presupuestoTable->addCell(2000)->addText($presupues[$i]->codeUniversal,$titulos);
                $presupuestoTable->addCell(4000)->addText($presupues[$i]->denominacion,$titulos);
                $presupuestoTable->addCell(1500)->addText($presupues[$i]->precio.".00",$titulos);
            }

            $presupuestoTable->addRow(400);
            $presupuestoTable->addCell(2000)->addText("",$titulos);
            $presupuestoTable->addCell(4000)->addText("TOTAL",$titulos);
            $presupuestoTable->addCell(1500)->addText($request->total.".00",$titulos);


            /* ----------------------------------- */


            $nuevaSesion->addListItem("10. FINANCIAMIENTO",0.5,$titulos,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
            $nuevaSesion->addText($financiamiento);

            $nuevaSesion->addPageBreak();

            $nuevaSesion->addText("II. PLAN DE INVESTIGACION",$titulos,$styleContenido);

            $nuevaSesion->addListItem("1. REALIDAD PROBLEMATICA",0.5,$titulos,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
            $nuevaSesion->addText($real_problematica,null,$styleContenido);

            $nuevaSesion->addListItem("2. ANTECEDENTES",0.5,$titulos,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
            $nuevaSesion->addText($antecedentes,null,$styleContenido);

            $nuevaSesion->addListItem("3. JUSTIFICACION",0.5,$titulos,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
            $nuevaSesion->addText($justificacion,null,$styleContenido);

            $nuevaSesion->addListItem("4. FORMULACION DEL PROBLEMA",0.5,$titulos,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
            $nuevaSesion->addText($formulacion_prob,null,$styleContenido);

            /* Objetivos */
            $objetivos = Objetivo::where('cod_proyinvestigacion','=',$tesis[0]->cod_proyinvestigacion)->latest('cod_objetivo')->get();

            $arregloObjetivo = [];

            $arregloObjTipo = [];

            $nuevaSesion->addListItem("5. OBJETIVOS",0.5,$titulos,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);

            foreach ($objetivos as $obj) {
                $arregloObjTipo[] = $obj->tipo;
                $arregloObjetivo[] = $obj->descripcion;
            }



            $cont4 = 0;
            $cont5 = 0;
            for ($i=count($objetivos)-1; $i >=0 ; $i--) {
                if ($arregloObjTipo[$i] == 'General') {
                    if ($cont4 == 0) {
                        $nuevaSesion->addListItem("5.1. General: ",1,null,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
                    }
                    $nuevaSesion->addListItem("5.1.".($cont4+1).". ".$arregloObjetivo[$i],2,null,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
                    $cont4++;
                }
                if ($arregloObjTipo[$i] == 'Especifico') {
                    if ($cont5 == 0) {
                        $nuevaSesion->addListItem("5.2. Especifico: ",1,null,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
                    }
                    $nuevaSesion->addListItem("5.2.".($cont5+1).". ".$arregloObjetivo[$i],2,null,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
                    $cont5++;
                }

            }

            /* ------------------------ */
            $nuevaSesion->addListItem("6. MARCO TEORICO",0.5,$titulos,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
            $nuevaSesion->addText($marco_teorico,null,$styleContenido);

            $nuevaSesion->addListItem("7. MARCO CONCEPTUAL",0.5,$titulos,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
            $nuevaSesion->addText($marco_conceptual,null,$styleContenido);

            $nuevaSesion->addListItem("8. MARCO LEGAL",0.5,$titulos,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
            $nuevaSesion->addText($marco_legal,null,$styleContenido);

            $nuevaSesion->addListItem("9. FORMULACION DE LA HIPOTESIS",0.5,$titulos,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
            $nuevaSesion->addText($form_hipotesis,null,$styleContenido);

            $nuevaSesion->addListItem("10. DISENO DE INVESTIGACION",0.5,$titulos,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
            $nuevaSesion->addListItem("10.1. OBJETO DE ESTUDIO",1,$titulos,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
            $nuevaSesion->addText($objeto_estudio,null,$styleContenido);
            $nuevaSesion->addListItem("10.2. POBLACION",1,$titulos,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
            $nuevaSesion->addText($poblacion,null,$styleContenido);
            $nuevaSesion->addListItem("10.3. MUESTRA",1,$titulos,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
            $nuevaSesion->addText($muestra,null,$styleContenido);
            $nuevaSesion->addListItem("10.4. METODOS",1,$titulos,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
            $nuevaSesion->addText($metodos,null,$styleContenido);
            $nuevaSesion->addListItem("10.5. TECNICAS E INTRUMENTOS DE RECOLECCION DE DATOS",1,$titulos,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
            $nuevaSesion->addText($tecnicas_instrum,null,$styleContenido);


            $nuevaSesion->addListItem("10.6. INSTRUMENTACION",1,$titulos,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
            $nuevaSesion->addText($instrumentacion,null,$styleContenido);

            $nuevaSesion->addListItem("10.7. ESTRATEGIAS METODOLOGICAS",1,$titulos,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
            $nuevaSesion->addText($estg_metodologicas,null,$styleContenido);

            /* Variables */
            $variables = variableOP::where('cod_proyinvestigacion','=',$tesis[0]->cod_proyinvestigacion)->latest('cod_variable')->get();

            $arregloVariable = [];

            $nuevaSesion->addListItem("10.8. OPERACIONALIZACION DE VARIABLES Y MATRIZ DE CONSISTENCIA",1,$titulos,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);

            foreach ($variables as $var) {
                $arregloVariable[] = $var->descripcion;
            }

            for ($i=0; $i <= count($variables)-1 ; $i++) {
                $nuevaSesion->addListItem("10.8.".($i+1).". ".$arregloVariable[$i],2,null,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);
            }

            $footer = $nuevaSesion->addFooter();

            $footer->addPreserveText(1);

            /* ---------------------------- */

            /* Regerencias Bibliograficas */

            $referencia = referencias::where('cod_proyinvestigacion','=',$tesis[0]->cod_proyinvestigacion)->latest('cod_referencias')->get();

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


            $nuevaSesion->addListItem("11. REFERENCIAS BIBLOIGRAFICAS",0.5,$titulos,[\PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER],$styleContenido);

            for ($i=0; $i <= count($referencia) - 1; $i++) {
                if ($arregloRefTipo[$i] == 1) {
                    $nuevaSesion->addText($arregloRefA[$i]."."."(".$arregloRefP[$i].").".$arregloTCap[$i].".".$arregloRefF[$i].",".$arregloRefT[$i]." (capitulo ".$arregloNC[$i].")".$arregloEd[$i].".",null,$styleContenido);
                }
                if ($arregloRefTipo[$i] == 2) {
                    $nuevaSesion->addText($arregloRefA[$i]."."."(".$arregloRefP[$i].").".$arregloRefT[$i].".".$arregloRefF[$i].".".$arregloTRev[$i].",pp ".$arregloV[$i].".",null,$styleContenido);
                }
                if ($arregloRefTipo[$i] == 3) {
                    $nuevaSesion->addText($arregloRefA[$i]."."."(".$arregloRefP[$i].").".$arregloRefT[$i].".".$arregloRefF[$i].".".$arregloNWeb[$i].".",null,$styleContenido);
                }
                if ($arregloRefTipo[$i] == 4) {
                    $nuevaSesion->addText($arregloRefA[$i]."."."(".$arregloRefP[$i].").".$arregloRefT[$i].".".$arregloRefF[$i].".".$arregloNPe[$i].".",null,$styleContenido);
                }
                if ($arregloRefTipo[$i] == 5) {
                    $nuevaSesion->addText($arregloRefA[$i]."."."(".$arregloRefP[$i].").".$arregloRefT[$i].".".$arregloRefF[$i].".".$arregloNIn[$i].".",null,$styleContenido);
                }
                if ($arregloRefTipo[$i] == 6) {
                    $nuevaSesion->addText($arregloRefA[$i]."."."(".$arregloRefP[$i].").".$arregloRefT[$i].": ".$arregloRefF[$i].",".$arregloS[$i].", ".$arregloNEd[$i].".",null,$styleContenido);
                }
            }



            /* ------------------------------------------------------- */

            $objetoEscrito = \PhpOffice\PhpWord\IOFactory::createWriter($word,'Word2007');
            try {
                $objetoEscrito->save(storage_path('ProyectoTesis.docx'));
            } catch (\Throwable $th) {
                $th;
            }
            return response()->download(storage_path('ProyectoTesis.docx'));
    }

    public function showFormato($id){
        $asesores = Asesor::all();
        $formato = FormatoTitulo::join('egresado','egresado.cod_matricula','=','formato_titulo.cod_matricula')
        ->join('escuela','escuela.cod_escuela','=','formato_titulo.cod_escuela')->join('facultad','facultad.cod_facultad','=','escuela.cod_facultad')->join('sede','sede.cod_sede','=','formato_titulo.cod_sede')
        ->join('tipoinvestigacion','tipoinvestigacion.cod_tinvestigacion','=','formato_titulo.cod_tinvestigacion')
        ->select('formato_titulo.*','egresado.nombres AS name_egresado','egresado.apellidos AS apellidos_egresado','egresado.dni AS dni','escuela.nombre AS name_escuela','facultad.nombre AS name_facultad','sede.nombre AS name_sede','tipoinvestigacion.descripcion AS lineaInv')
        ->where('formato_titulo.cod_matricula','=',$id)->get();

        $file = DocumentosEgresado::where('cod_matricula','=',$formato[0]->cod_matricula)->get();

        $rol = 'director';
        $img = ImgEgresado::where('cod_matricula','=',$formato[0]->cod_matricula)->get();
        return view('director.lookFormato',['formato'=>$formato,'rol'=>$rol,'id'=>$id,'asesores'=>$asesores,'img'=>$img,'file'=>$file]);
    }

    public function downloadFormato(Request $request){

        /* OBTENIENDO LOS DATOS PARA GENERAR EL PDF */
        $ultEgresado = DB::connection('mysql')->table('formato_titulo')->join('escuela','formato_titulo.cod_escuela','=','escuela.cod_escuela')
                                           ->join('sede','formato_titulo.cod_sede','=','sede.cod_sede')
                                           ->join('facultad','escuela.cod_facultad','=','facultad.cod_facultad')
                                           ->join('egresado','formato_titulo.cod_matricula','=','egresado.cod_matricula')
                                           ->select('tit_profesional','egresado.apellidos','egresado.nombres','egresado.cod_matricula','egresado.dni','formato_titulo.fecha_nacimiento',
                                           'formato_titulo.direccion','formato_titulo.tele_fijo','formato_titulo.tele_celular','formato_titulo.correo','modalidad_titulo','fecha_sustentacion','sgda_especialidad','prog_extraordinario','fecha_colacion','fecha',
                                           'formato_titulo.centro_labores','formato_titulo.colegio','formato_titulo.tipo_colegio','formato_titulo.firmaIMG','escuela.nombre as escuela','facultad.nombre as facultad','sede.nombre as sede')
                                           ->where('formato_titulo.codigo','=',$request->cod_formato)->latest('egresado.cod_matricula')->get();



        $pdf = PDF::loadView('egresados.PDFegresado',['ultEgresado' => $ultEgresado]);
        //return $pdf->stream();
        return $pdf->download($ultEgresado[0]->cod_matricula.'_FormatoEgresado.pdf');
        /* ----------------------------------------------------------- */
    }

    public function continuarFormato(Request $request){
        $formato = FormatoTitulo::find($request->codigoFormato);
        try{

            $formato->cod_docente = $request->hiddenCodDocente;
            $formato->estado = 2;

        } catch (\Throwable $th) {
            $th;
        }
        $formato->save();

        return redirect()->route('director.formatos')->with('datos','Registro modificado');
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }

    public function information(){
        $id = auth()->user()->name;
        $aux = explode('-',$id);
        $id = $aux[0];
        if(auth()->user()->rol == 'CTesis2022-1'){
            $estudiante = EstudianteCT2022::find($id);
            $existTesis = TesisCT2022::where('cod_matricula',$estudiante->cod_matricula)->get();
            $existTesisII = Tesis_2022::where('cod_matricula',$estudiante->cod_matricula)->get();

            if($existTesis->count()==0){
                $newTesis = new TesisCT2022();
                $newTesis->cod_matricula = $estudiante->cod_matricula;
                $newTesis->nombres = $estudiante->nombres.' '.$estudiante->apellidos;
                $newTesis->save();

                $tesis = TesisCT2022::where('cod_matricula','=',$estudiante->cod_matricula)->get();

                $matriz = new MatrizOperacional();
                $matriz->cod_tesis = $tesis[0]->cod_cursoTesis;
                $matriz->save();



            }
            if ($existTesisII->count()==0) {
                $newTesisII = new Tesis_2022();
                $newTesisII->cod_matricula = $estudiante->cod_matricula;
                // $newTesisII->nombres = $estudiante->nombres.' '.$estudiante->apellidos;
                $newTesisII->save();
            }

        }
        //$egresado = Egresado::find($id);
        $usuario = User::where('name',$id.'-C')->first();
        $estudiante = DB::table('estudiante_ct2022 as E')->where('E.cod_matricula',$id)->first();
        $asesor = DB::table('asesor_curso as A')->where('A.username',$id)->first();
        //dd($aux);
        $img = 'profile-notfound.jpg';
        // $imagen = ImgEgresado::find($id);
        // if($imagen != null){
        //     $img=$imagen->referencia;
        // }
        return view('user.informacion',['usuario'=>$usuario,'img'=>$img,'estudiante'=>$estudiante,'asesor'=>$asesor]);
    }

    public function saveUser(Request $request){

        $usuario = User::where('name','=',$request->txtCodUsuario)->first();
        //$usuario = Usuario::find($request->txtCodUsuario);
        try {
            $usuario->password = md5($request->txtNuevaContra);
            $usuario->save();
            return redirect()->route('user_information')->with('datos','ok');
            //Recuerda que luego de actualizar tu contrasena, no podras volver a cambiarla hasta luego de 7 dias.
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('user_information')->with('datos','oknot');
        }

    }


    public function verRegistroHistorial(){
        $id = auth()->user()->name;
        $tesis = Tesis::where('cod_matricula',$id)->first();
        $historial = Historial_Observaciones::join('observaciones_proy','historial_observaciones.cod_historialObs','=','observaciones_proy.cod_historialObs')
                            ->join('proyinvestigacion','historial_observaciones.cod_proyinvestigacion','=','proyinvestigacion.cod_proyinvestigacion')
                            ->select('historial_observaciones.fecha','proyinvestigacion.nombre_asesor','historial_observaciones.cod_historialObs','observaciones_proy.observacionNum','proyinvestigacion.condicion','observaciones_proy.cod_observaciones')
                            ->where('proyinvestigacion.cod_matricula','=',$id)->get();

        return view('egresados.verHistorial',['historial'=>$historial, 'tesis'=>$tesis]);
    }
    public function showCorrection($id){
        $observacion = ObservacionesProy::where('cod_observaciones','=',$id)->get();
        $proyinvestigacion = Tesis::join('historial_observaciones','proyinvestigacion.cod_proyinvestigacion','=','historial_observaciones.cod_proyinvestigacion')
                                ->where('historial_observaciones.cod_historialObs','=',$observacion[0]->cod_historialObs)->get();

        $correcciones = Detalle_Observaciones::where('cod_observaciones','=',$id)->get();
        return view('egresados.verCorreccion',['correcciones'=>$correcciones,'proyinvestigacion'=>$proyinvestigacion,'observacion'=>$observacion]);
    }
}
