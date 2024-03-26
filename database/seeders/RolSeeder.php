<?php

namespace Database\Seeders;

use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('mysql')->table('rol')->insert(
            [
                'descripcion'=>'Administrador',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ]
        );
        DB::connection('mysql')->table('rol')->insert(
            [
                'descripcion'=>'Director',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        DB::connection('mysql')->table('rol')->insert(
            [
                'descripcion'=>'Asesor',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        DB::connection('mysql')->table('rol')->insert(
            [
                'descripcion'=>'Estudiante',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
    }
}
