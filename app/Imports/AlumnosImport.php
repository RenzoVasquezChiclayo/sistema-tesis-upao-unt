<?php

namespace App\Imports;

use App\Models\EstudianteCT2022;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AlumnosImport implements ToModel
{
    public $semestre_academico;

    public function __construct($semestre_academico)
    {
        $this->semestre_academico = $semestre_academico;
    }
    public function model(array $row)
    {
        return new EstudianteCT2022([
            'cod_matricula' => $row[0],
            'dni' => $row[1],
            'apellidos' => $row[2],
            'nombres' => $row[3],
            'correo' => $row[4],
            'semestre_academico'=> $this->semestre_academico,
        ]);
    }

}
