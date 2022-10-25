<?php

namespace App\Http\Controllers;

use App\Models\Historial_Observaciones;
use App\Models\Objetivo;
use App\Models\ObservacionesProy;
use App\Models\recursos;
use App\Models\Tesis;
use App\Models\variableOP;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpWord\PhpWord;

class AsesorController extends Controller
{
    const PAGINATION=10;
    public function historial_observacion(Request $request){
        $buscarObservaciones = $request->get('buscarObservacion');

        if (is_numeric($buscarObservaciones)) {
            $egresados = DB::table('egresado')->join('proyinvestigacion','egresado.cod_matricula','=','proyinvestigacion.cod_matricula')->join('historial_observaciones','proyinvestigacion.cod_proyinvestigacion','=','historial_observaciones.cod_proyinvestigacion')
                            ->select('egresado.*','proyinvestigacion.escuela','historial_observaciones.fecha','historial_observaciones.cod_historialObs')->where('proyinvestigacion.cod_matricula','like','%'.$buscarObservaciones.'%')->paginate($this::PAGINATION);
        } else {
            $egresados = DB::table('egresado')->join('proyinvestigacion','egresado.cod_matricula','=','proyinvestigacion.cod_matricula')->join('historial_observaciones','proyinvestigacion.cod_proyinvestigacion','=','historial_observaciones.cod_proyinvestigacion')
                            ->select('egresado.*','proyinvestigacion.escuela','historial_observaciones.fecha','historial_observaciones.cod_historialObs')->where('egresado.apellidos','like','%'.$buscarObservaciones.'%')->paginate($this::PAGINATION);
        }

        if(empty($egresados)){
            return view('asesor.historialObservaciones',['buscarObservaciones'=>$buscarObservaciones,'egresados'=>$egresados])->with('datos','No se encontro algun registro');
        }else{
            return view('asesor.historialObservaciones',['buscarObservaciones'=>$buscarObservaciones,'egresados'=>$egresados]);
        }

    }


    public function showObservaciones($cod_historialObs){
        $observaciones = ObservacionesProy::where('cod_historialObs',$cod_historialObs)->get();
        $egresado = Tesis::join('historial_observaciones','proyinvestigacion.cod_proyinvestigacion','=','historial_observaciones.cod_proyinvestigacion')->select('proyinvestigacion.*')->where('historial_observaciones.cod_historialObs',$cod_historialObs)->get();
        return view('asesor.showListaObservacion',['observaciones'=>$observaciones,'egresado'=>$egresado]);
    }

    public function downloadObservacion(Request $request){

        $correccion = ObservacionesProy::where('cod_observaciones','=',$request->cod_observaciones)->get();
        $tesis = Tesis::join('historial_observaciones','proyinvestigacion.cod_proyinvestigacion','=','historial_observaciones.cod_proyinvestigacion')->where('historial_observaciones.cod_historialObs',$correccion[0]->cod_historialObs)->first();

        $proyecto = DB::table('proyinvestigacion')->join('asesor','asesor.nombres','=','proyinvestigacion.nombre_asesor')->join('egresado','proyinvestigacion.cod_matricula','=','egresado.cod_matricula')->join('tipoinvestigacion','proyinvestigacion.cod_tinvestigacion','=','tipoinvestigacion.cod_tinvestigacion')
                       ->join('formato_titulo','proyinvestigacion.cod_matricula','=','formato_titulo.cod_matricula')
                       ->select('proyinvestigacion.*','asesor.cod_docente as cod_asesor','egresado.nombres as nombresAutor','egresado.apellidos as apellidosAutor','tipoinvestigacion.descripcion')
                       ->where('proyinvestigacion.cod_proyinvestigacion','=',$tesis->cod_proyinvestigacion)->get();


        $recursosProy = recursos::where('cod_proyinvestigacion','=',$proyecto[0]->cod_proyinvestigacion)->get();

        //$presupuestoProy = Presupuesto_Proyecto::join('presupuesto','presupuesto.cod_presupuesto','=','presupuesto_proyecto.cod_presupuesto')->select('presupuesto_proyecto.*','presupuesto.codeUniversal','presupuesto.denominacion')->where('presupuesto_proyecto.cod_proyinvestigacion','=',$proyecto[0]->cod_proyinvestigacion)->get();

        $objetivosProy = Objetivo::where('cod_proyinvestigacion','=',$proyecto[0]->cod_proyinvestigacion)->get();
        $variableopProy = variableOP::where('cod_proyinvestigacion','=',$proyecto[0]->cod_proyinvestigacion)->get();

        /* CODIGO PARA GENERAR EL WORD DE LAS CORRECCIONES */
        $cod_matricula = $tesis->cod_matricula;
        $nombreEgresado = $tesis->nombres;
        $escuelaEgresado = $tesis->escuela;
        $nombreAsesor = $tesis->nombre_asesor;
        $numObservacion = $correccion[0]->observacionNum;
        $fecha = $correccion[0]->fecha;
        $titulo = $correccion[0]->titulo;

        $localidad_institucion = $correccion[0]->localidad_institucion;
        $meses_ejecucion = $correccion[0]->meses_ejecucion;

        $recursos = $correccion[0]->recursos;

        $real_problematica = $correccion[0]->real_problematica;
        $antecedentes = $correccion[0]->antecedentes;
        $justificacion = $correccion[0]->justificacion;
        $formulacion_prob = $correccion[0]->formulacion_prob;

        $marco_teorico = $correccion[0]->marco_teorico;
        $marco_conceptual = $correccion[0]->marco_conceptual;
        $marco_legal = $correccion[0]->marco_legal;

        $objetivos = $correccion[0]->objetivos;

        $form_hipotesis = $correccion[0]->form_hipotesis;
        $objeto_estudio = $correccion[0]->objeto_estudio;
        $poblacion = $correccion[0]->poblacion;
        $muestra = $correccion[0]->muestra;
        $metodos = $correccion[0]->metodos;
        $tecnicas_instrum = $correccion[0]->tecnicas_instrum;
        $instrumentacion = $correccion[0]->instrumentacion;

        $estg_metodologicas = $correccion[0]->estg_metodologicas;


        $variables = $correccion[0]->variables;
        $referencias = $correccion[0]->referencias;

        $word = new PhpWord();

        /* Creacion de las fuentes */

        $word->setDefaultFontName('Times New Roman');
        $word->setDefaultFontSize(11);

        $titulos = 'titulos';
        $word->addFontStyle($titulos,array('bold'=>true,'size'=>12));

        $styleFecha = 'styleFecha';
        $word->addParagraphStyle($styleFecha,array('align'=>'right'));

        $styleTitulos = 'styleTitulos';
        $word->addParagraphStyle($styleTitulos,array('align'=>'center'));


        $nuevaSesion = $word->addSection();

        $nuevaSesion->addText($fecha,$titulo,$styleFecha);
        $nuevaSesion->addText('OBSERVACIONES PROYECTO DE TESIS',$titulos,$styleTitulos);
        $nuevaSesion->addText($numObservacion,$titulo,$styleTitulos);

        $nuevaSesion->addText('Codigo Egresado: '.$cod_matricula,$titulos,$styleFecha);
        $nuevaSesion->addText('Egresado: '.$nombreEgresado,$titulos,$styleFecha);
        $nuevaSesion->addText('Escuela: '.$escuelaEgresado,$titulos,$styleFecha);
        $nuevaSesion->addText('Asesor: '.$nombreAsesor,$titulos,$styleFecha);

        $nuevaSesion->addTextBreak(2);

        if ($titulo != "") {

            $nuevaSesion->addText("TITULO",$titulos);
            $nuevaSesion->addText($proyecto[0]->titulo);
            $nuevaSesion->addText("Observacion: ".$titulo);
        }
        if ($localidad_institucion!= "") {
            $nuevaSesion->addText("LOCALIDAD E INSTITUCION",$titulos);
            $nuevaSesion->addText($proyecto[0]->localidad.", ".$proyecto[0]->institucion);
            $nuevaSesion->addText("Observacion: ".$localidad_institucion);
        }
        if ($meses_ejecucion!= "") {
            $nuevaSesion->addText("DURECION DE LA EJECUCION DEL PROYECTO",$titulos);
            $nuevaSesion->addText($proyecto[0]->meses_ejecucion);
            $nuevaSesion->addText("Observacion: ".$meses_ejecucion);
        }

        if ($recursos != "") {
            $nuevaSesion->addText("RECURSOS",$titulos);
            for ($i=0; $i < count($recursosProy); $i++) {
                $nuevaSesion->addText("Tipo: ".$recursosProy[$i]->tipo.", Subtipo: ".$recursosProy[$i]->subtipo.", Descripcion: ".$recursosProy[$i]->descripcion);
            }
            $nuevaSesion->addText($recursos);

        }
        if ($real_problematica!= "") {
            $nuevaSesion->addText("REALIDAD PROBLEMATICA",$titulos);
            $nuevaSesion->addText($proyecto[0]->real_problematica);
            $nuevaSesion->addText("Observacion: ".$real_problematica);
        }
        if ($antecedentes!= "") {
            $nuevaSesion->addText("ANTECEDENTES",$titulos);
            $nuevaSesion->addText($proyecto[0]->antecedentes);
            $nuevaSesion->addText("Observacion: ".$antecedentes);
        }
        if ($justificacion!= "") {
            $nuevaSesion->addText("JUSTIFICACION",$titulos);
            $nuevaSesion->addText($proyecto[0]->justificacion);
            $nuevaSesion->addText("Observacion: ".$justificacion);
        }
        if ($formulacion_prob!= "") {
            $nuevaSesion->addText("FORMULACION DEL PROBLEMA",$titulos);
            $nuevaSesion->addText($proyecto[0]->formulacion_prob);
            $nuevaSesion->addText("Observacion: ".$formulacion_prob);
        }
        if ($objetivos != "") {
            $nuevaSesion->addText("OBJETIVOS",$titulos);
            for ($i=0; $i < count($objetivosProy); $i++) {
                $nuevaSesion->addText("Tipo: ".$objetivosProy[$i]->tipo.", Descripcion: ".$objetivosProy[$i]->descripcion);
            }

            $nuevaSesion->addText("Observacion: ".$objetivos);
        }
        if ($marco_teorico!= "") {
            $nuevaSesion->addText("MARCO TEORICO",$titulos);
            $nuevaSesion->addText($proyecto[0]->marco_teorico);
            $nuevaSesion->addText("Observacion: ".$marco_teorico);
        }
        if ($marco_conceptual!= "") {
            $nuevaSesion->addText("MARCO CONCEPTUAL",$titulos);
            $nuevaSesion->addText($proyecto[0]->marco_conceptual);
            $nuevaSesion->addText("Observacion: ".$marco_conceptual);
        }
        if ($marco_legal!= "") {
            $nuevaSesion->addText("MARCO LEGAL",$titulos);
            $nuevaSesion->addText($proyecto[0]->marco_legal);
            $nuevaSesion->addText("Observacion: ".$marco_legal);
        }
        if ($form_hipotesis!= "") {
            $nuevaSesion->addText("FORMULACION DE LA HIPOTESIS",$titulos);
            $nuevaSesion->addText($proyecto[0]->form_hipotesis);
            $nuevaSesion->addText("Observacion: ".$form_hipotesis);
        }
        if ($objeto_estudio!= "") {
            $nuevaSesion->addText("OBJETO DE ESTUDIO",$titulos);
            $nuevaSesion->addText($proyecto[0]->objeto_estudio);
            $nuevaSesion->addText("Observacion: ".$objeto_estudio);
        }
        if ($poblacion!= "") {
            $nuevaSesion->addText("POBLACION",$titulos);
            $nuevaSesion->addText($proyecto[0]->poblacion);
            $nuevaSesion->addText("Observacion: ".$poblacion);
        }
        if ($muestra!= "") {
            $nuevaSesion->addText("MUESTRA",$titulos);
            $nuevaSesion->addText($proyecto[0]->muestra);
            $nuevaSesion->addText("Observacion: ".$muestra);
        }
        if ($metodos!= "") {
            $nuevaSesion->addText("METODOS",$titulos);
            $nuevaSesion->addText($proyecto[0]->metodos);
            $nuevaSesion->addText("Observacion: ".$metodos);
        }
        if ($tecnicas_instrum!= "") {
            $nuevaSesion->addText("TECNICAS E INTRUMENTOS DE RECOLECCION DE DATOS",$titulos);
            $nuevaSesion->addText($proyecto[0]->tecnicas_instrum);
            $nuevaSesion->addText("Observacion: ".$tecnicas_instrum);
        }
        if ($instrumentacion!= "") {
            $nuevaSesion->addText("INSTRUMENTACION",$titulos);
            $nuevaSesion->addText($proyecto[0]->instrumentacion);
            $nuevaSesion->addText("Observacion: ".$instrumentacion);
        }
        if ($estg_metodologicas != "") {
            $nuevaSesion->addText("ESTRATEGIAS METODOLOGICAS",$titulos);
            $nuevaSesion->addText($proyecto[0]->estg_metodologicas);
            $nuevaSesion->addText("Observacion: ".$estg_metodologicas);
        }
        if ($variables != "") {
            $nuevaSesion->addText("VARIABLES",$titulos);
            for ($i=0; $i < count($variableopProy); $i++) {
                $nuevaSesion->addText("Descripcion: ".$variableopProy[$i]->descripcion);
            }
            $nuevaSesion->addText("Observacion: ".$variables);
        }
        if ($referencias != "") {
            $nuevaSesion->addText("REFERENCIAS",$titulos);

            $nuevaSesion->addText("Observacion: ".$referencias);
        }


        $objetoEscrito = \PhpOffice\PhpWord\IOFactory::createWriter($word,'Word2007');
        try {
            $objetoEscrito->save(storage_path('Observaciones.docx'));
        } catch (\Throwable $th) {
            $th;
        }

        return response()->download(storage_path('Observaciones.docx'));
    }
}
