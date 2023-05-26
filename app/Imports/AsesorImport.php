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
            'orcid'=> $row[2],
            'grado_academico'=> $row[3],
            'titulo_profesional'=> $row[4],
            'direccion'=> $row[5],
            'correo' => $row[6],
            'semestre_academico'=> $this->semestre_academico,
        ]);
    }

}
