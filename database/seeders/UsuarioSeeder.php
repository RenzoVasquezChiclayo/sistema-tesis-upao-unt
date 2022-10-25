<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('users')->insert(
        //     [
        //         'name'=>'1013300719',
        //         'password'=> md5('admin'),
        //         'rol'=>'estudiante'
        //     ],

        // );

        // DB::table('estudiante_ct2022')->insert(
        //     [
        //         'cod_matricula' => '1513300419',
        //         'dni' => '70255560',
        //         'apellidos' => 'Rios Reyes',
        //         'nombres' => 'Jairo Aldair',
        //     ],
        // );
        // DB::table('tesis_ct2022')->insert(
        //     [
        //         'cod_matricula' => '1513300419',
        //         'nombres' => 'Jairo Aldair Rios Reyes',
        //         'estado' => '0',
        //     ],
        // );
        // DB::table('asesor')->insert(
        //     [
        //         'cod_docente'=>'3245',
        //         'nombres'=>'Luis Boy Chavil',
        //         'grado_academico'=>'Doctor',
        //         'titulo_profesional'=>'Ingenieriero en Sistemas',
        //         'direccion'=>'Los Olivos 430',
        //         'username'=>'lboy2-CTesis'
        //     ]
        // );

        // DB::table('campos_estudiante')->insert(
        //     [
        //         'cod_matricula' => '1513300419',
        //         'cod_docente' => '3245',
        //     ],
        // );

    }
}
