<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AsesorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('asesor')->insert(
            [
                'cod_docente'=>'3345',
                'nombres'=>'Luis Boy Chavil',
                'grado_academico'=>'Doctor',
                'titulo_profesional'=>'Ingenieriero en Sistemas',
                'direccion'=>'Los Olivos 430',
                'username'=>'lboy-CTesis'
            ]
        );
    }
}
