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
            if (auth()->user()->rol == 'a-CTesis2022-1') {
                $exists_jurado = false;
                $asesor_user = DB::table('asesor_curso')->select('cod_docente')->where('username',auth()->user()->name)->first();
                $jurados = DB::table('jurado')->select('cod_docente')->get();
                if (!empty($jurados)) {
                    foreach ($jurados as $key => $jurado) {
                        if ($jurado->cod_docente == $asesor_user->cod_docente) {
                            $exists_jurado = true;
                        }
                    }
                }
                $view->with(['exists_jurado'=>$exists_jurado]);
            }

        });
    }
}
