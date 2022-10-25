<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PresupuestoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('mysql')->table('presupuesto')->insert(
            [
                'codeUniversal'=>'2.3.1.5.1',
                'denominacion'=>'De oficina'
            ]
        );
        DB::connection('mysql')->table('presupuesto')->insert(
            [
                'codeUniversal'=>'2.3.1.9.1',
                'denominacion'=>'Materiales y utiles de enseñanza'
            ]
        );
        DB::connection('mysql')->table('presupuesto')->insert(
            [
                'codeUniversal'=>'2.3.2.1.2',
                'denominacion'=>'Viaje Domestico'
            ]
        );
        DB::connection('mysql')->table('presupuesto')->insert(
            [
                'codeUniversal'=>'2.3.2.2.1',
                'denominacion'=>'Servicios De Energia Electrica, Agua y Gas'
            ]
        );
        DB::connection('mysql')->table('presupuesto')->insert(
            [
                'codeUniversal'=>'2.3.2.2.2',
                'denominacion'=>'Servicios De Telefonia e Internet'
            ]
        );
    }
}
