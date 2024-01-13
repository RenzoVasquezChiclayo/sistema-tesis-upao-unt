<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Jurado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SustentacionController extends Controller
{


    public function verRegistrarJurado(){
        $asesores = DB::table('asesor_curso as ac')->leftJoin('jurado as j','ac.cod_docente',"=",'j.cod_docente')->select('ac.*')->whereNull('j.cod_docente')->get();
        $tipoInvestigacion = DB::table('tipoinvestigacion')->get();
        $jurados = DB::table('jurado as j')->join('tipoinvestigacion as ti','j.cod_tinvestigacion','ti.cod_tinvestigacion')->leftJoin('asesor_curso as ac','j.cod_docente','=','ac.cod_docente')->select('ac.nombres','ac.apellidos','j.*','ti.descripcion')->get();
        return view('cursoTesis20221.director.evaluacion.registrarJurado',['asesores'=>$asesores, 'tipoInvestigacion'=>$tipoInvestigacion, 'jurados'=>$jurados]);
    }
    public function registrarJurado(Request $request){
        try{
            $asesor = DB::table('asesor_curso')->where('cod_docente',$request->selectAsesor)->get();
            $tipoInvestigacion = DB::table('tipoinvestigacion')->where('cod_tinvestigacion',$request->selectTInvestigacion)->get();

            $jurado = new Jurado();
            $jurado->cod_docente = $asesor[0]->cod_docente;
            $jurado->cod_tinvestigacion = $tipoInvestigacion[0]->cod_tinvestigacion;
            $jurado->save();
            return redirect()->route('director.verRegistrarJurado')->with('datos','ok');
        }catch(\Throwable $e){
            dd($e);
            return redirect()->route('director.verRegistrarJurado')->with('datos','oknot');
        }
    }
}
