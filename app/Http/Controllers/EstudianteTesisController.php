<?php

namespace App\Http\Controllers;


use App\Models\Detalle_Observaciones;

use App\Models\Historial_Observaciones;

use App\Models\ObservacionesProy;
use App\Models\TesisCT2022;
use Illuminate\Http\Request;

class EstudianteTesisController extends Controller
{
    public function verHistorial(){
        $id = auth()->user()->name;
        $tesis = TesisCT2022::where('cod_matricula',$id)->first();
        $historial = Historial_Observaciones::join('observaciones_proy','historial_observaciones.cod_historialObs','=','observaciones_proy.cod_historialObs')
                            ->join('tesis_ct2022','historial_observaciones.cod_proyinvestigacion','=','tesis_ct2022.cod_cursoTesis')
                            ->select('historial_observaciones.fecha','tesis_ct2022.nombre_asesor','historial_observaciones.cod_historialObs','observaciones_proy.observacionNum','tesis_ct2022.condicion','observaciones_proy.cod_observaciones')
                            ->where('tesis_ct2022.cod_matricula','=',$id)->get();

        return view('cursoTesis20221.historialCorrecciones',['historial'=>$historial, 'tesis'=>$tesis]);
    }

    public function showCorrection($id){
        $observacion = ObservacionesProy::where('cod_observaciones','=',$id)->get();
        $proyinvestigacion = TesisCT2022::join('historial_observaciones','tesis_ct2022.cod_cursoTesis','=','historial_observaciones.cod_proyinvestigacion')
                                ->where('historial_observaciones.cod_historialObs','=',$observacion[0]->cod_historialObs)->get();

        $correcciones = Detalle_Observaciones::where('cod_observaciones','=',$id)->get();
        return view('cursoTesis20221.showObservacion',['correcciones'=>$correcciones,'proyinvestigacion'=>$proyinvestigacion,'observacion'=>$observacion]);
    }

}
