<?php

namespace App\Imports;

use App\Models\AsesorCurso;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;

class AsesorImport implements ToModel
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        return new AsesorCurso([
            'cod_docente' => $row[0],
            'nombres' => $row[1],
            'grado_academico' => $row[2],
            'titulo_profesional'=> $row[3],
            'direccion'=> $row[4],
        ]);
    }
}
