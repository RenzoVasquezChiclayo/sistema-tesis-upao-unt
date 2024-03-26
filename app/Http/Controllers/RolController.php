<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RolController extends Controller
{
    const PAGINATION = 10;
    public function listarRoles(Request $request)
    {
        $buscarRol = $request->buscarRol;
        if ($buscarRol) {
            $roles = DB::table('rol')->where('descripcion', 'like', '%' . $buscarRol . '%')->paginate($this::PAGINATION);
        }else{
            $roles = DB::table('rol')->paginate($this::PAGINATION);
        }
        return view('cursoTesis20221.administrador.rol.listar_roles', ['roles' => $roles,'buscarRol'=>$buscarRol]);
    }

    public function guardarRol(Request $request)
    {
        try {
            $aux_cod_rol = $request->aux_cod_rol;
            if ($aux_cod_rol != '') {
                try {
                    $edit_rol = Rol::find($aux_cod_rol);
                    $edit_rol->descripcion = $request->descripcion;
                    $edit_rol->save();
                    return redirect()
                        ->route('rol.listar')
                        ->with('datos', 'ok');
                } catch (\Throwable $th) {
                    return redirect()
                        ->route('rol.listar')
                        ->with('datos', 'oknot');
                }

            }else{
                $new_rol = new Rol();
                $new_rol->descripcion = $request->descripcion;
                $new_rol->save();
                return redirect()
                ->route('rol.listar')
                ->with('datos', 'oksave');
            }
        } catch (\Throwable $th) {
            return redirect()
                ->route('rol.listar')
                ->with('datos', 'oknotsave');
        }
    }

    public function deleteRol(Request $request)
    {
        $idrol = $request->auxidrol;

        try {
            $rol = Rol::where('id', $idrol);
            $rol->delete();

            return redirect()
                ->route('rol.listar')
                ->with('datos', 'okdelete');
        } catch (\Throwable $th) {
            return redirect()
                ->route('rol.listar')
                ->with('datos', 'oknotdelete');
        }
    }
}
