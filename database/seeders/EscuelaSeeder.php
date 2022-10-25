<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EscuelaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('mysql')->table('escuela')->insert(
            [
                'cod_escuela'=>'0001',
                'nombre'=>'CONTABILIDAD Y FINANZAS',
                'cod_facultad'=>'0001'
            ]
        );
        DB::connection('mysql')->table('escuela')->insert(
            [
                'cod_escuela'=>'0002',
                'nombre'=>'ADMINISTRACION',
                'cod_facultad'=>'0001'
            ]
        );
        DB::connection('mysql')->table('escuela')->insert(
            [
                'cod_escuela'=>'0003',
                'nombre'=>'ECONOMICA',
                'cod_facultad'=>'0001'
            ]
        );

    }
}
