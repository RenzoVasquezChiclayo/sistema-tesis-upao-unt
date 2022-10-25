<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SedeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('mysql')->table('sede')->insert(
            [
                'cod_sede'=>'01',
                'nombre'=> 'TRUJILLO'
            ]


        );
        DB::connection('mysql')->table('sede')->insert(
            [
                'cod_sede'=>'02',
                'nombre'=> 'VALLE'
            ]
        );
        DB::connection('mysql')->table('sede')->insert(
            [
                'cod_sede'=>'03',
                'nombre'=> 'HUAMACHUCO'
            ]
        );
    }
}
