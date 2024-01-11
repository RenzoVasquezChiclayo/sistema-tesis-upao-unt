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
            'apellidos'=> $row[3],
            'grado_academico'=> $row[4],
            'titulo_profesional'=> $row[5],
            'direccion'=> $row[6],
            'correo' => $row[7],
            'semestre_academico'=> $this->semestre_academico,
        ]);
    }

}
