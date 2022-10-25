<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoInvestigacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('mysql')->table('tipoinvestigacion')->insert(
            [
                'cod_tinvestigacion'=>'0001',
                'descripcion'=>'CONTABILIDAD',
                'cod_escuela'=>'0001'
            ]
        );
        DB::connection('mysql')->table('tipoinvestigacion')->insert(
            [
                'cod_tinvestigacion'=>'0002',
                'descripcion'=>'FINANZAS',
                'cod_escuela'=>'0001'
            ]
        );


    }
}
