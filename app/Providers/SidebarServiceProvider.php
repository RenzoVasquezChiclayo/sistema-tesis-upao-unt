<?php

namespace App\Providers;

use App\Models\Jurado;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class SidebarServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Utiliza un View Composer para compartir datos con la vista de la barra lateral
        View::composer('plantilla.nav', function ($view) {
            $exists_jurado = false;
            $exist_obs = false;
            if (auth()->user()->rol == 3) {
                $asesor_user = DB::table('asesor_curso')->select('cod_docente')->where('username', auth()->user()->name)->first();
                $jurados = DB::table('jurado')->select('cod_docente')->get();
                if (!empty($jurados)) {
                    foreach ($jurados as $key => $jurado) {
                        if ($jurado->cod_docente == $asesor_user->cod_docente) {
                            $exists_jurado = true;
                        }
                    }
                }
                $view->with(['exists_jurado' => $exists_jurado]);
            } else if (auth()->user()->rol == 4) {
                $datos = explode('-', auth()->user()->name);
                $Tesis = DB::table('tesis_2022 as t')
                    ->join('detalle_grupo_investigacion as d_g', 'd_g.id_grupo_inves', '=', 't.id_grupo_inves')
                    ->join('estudiante_ct2022', 'estudiante_ct2022.cod_matricula', '=', 'd_g.cod_matricula')
                    ->select('t.cod_tesis')
                    ->where('estudiante_ct2022.cod_matricula', '=', $datos[0])
                    ->first();
                if ($Tesis != null) {
                    $historial_obs_sus = DB::table('t_historial_observaciones as t_h_o')
                        ->where('t_h_o.cod_tesis', $Tesis->cod_tesis)
                        ->where('t_h_o.sustentacion', true)
                        ->get();
                    if (count($historial_obs_sus) > 0) {
                        $exist_obs = true;
                    }
                }

                $view->with(['exist_obs' => $exist_obs]);
            }
        });
    }
}
