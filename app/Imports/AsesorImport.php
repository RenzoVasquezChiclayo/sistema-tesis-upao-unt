<?php

namespace App\Imports;

use App\Models\AsesorCurso;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;

class AsesorImport implements ToModel
{
    public $semestre_academico;

    public function __construct($semestre_academico)
    {
        $this->semestre_academico = $semestre_academico;
    }
    public function model(array $row)
    {

        return new AsesorCurso([
            'cod_docente'=> $row[0],
            'nombres'=> $row[1],
            'grado_academico'=> $row[2],
            'titulo_profesional'=> $row[3],
            'direccion'=> $row[4],
            'correo' => $row[5],
            'semestre_academico'=> $this->semestre_academico,
        ]);
    }

}
