<?php

namespace App\Imports;

use App\Models\EstudianteCT2022;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AlumnosImport implements ToModel, WithHeadingRow
{
    public $semestre_academico;

    public function __construct($semestre_academico)
    {
        $this->semestre_academico = $semestre_academico;
    }
    public function model(array $row)
    {

        $find_student = DB::table('estudiante_ct2022')->where('cod_matricula',$row['cod_matricula'])->first();

        if ($find_student == null) {
            return new EstudianteCT2022([
                'cod_matricula' => $row['cod_matricula'],
                'dni' => $row['dni'],
                'apellidos' => $row['apellidos'],
                'nombres' => $row['nombres'],
                'correo' => $row['correo']==null? "":$row['correo'],
                'semestre_academico'=> $this->semestre_academico,
            ]);
        }


    }

}
