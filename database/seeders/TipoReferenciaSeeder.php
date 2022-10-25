<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoReferenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('mysql')->table('tiporeferencia')->insert(
            [
                'tipo'=>'Libro'

            ]
        );
        DB::connection('mysql')->table('tiporeferencia')->insert(
            [
                'tipo'=>'Revista'

            ]
        );
        DB::connection('mysql')->table('tiporeferencia')->insert(
            [
                'tipo'=>'Pagina web'

            ]
        );
        DB::connection('mysql')->table('tiporeferencia')->insert(
            [
                'tipo'=>'Articulo en un periodico'

            ]
        );
        DB::connection('mysql')->table('tiporeferencia')->insert(
            [
                'tipo'=>'Tesis o disertaciones'

            ]
        );
        DB::connection('mysql')->table('tiporeferencia')->insert(
            [
                'tipo'=>'Informes/Reportes'

            ]
        );


    }
}
