<?php

namespace App\Imports;

use App\Models\AsesorCurso;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AsesorImport implements ToModel, WithHeadingRow
{
    public $semestre_academico;

    public function __construct($semestre_academico)
    {
        $this->semestre_academico = $semestre_academico;
    }
    public function model(array $row)
    {
        $find_asesor = DB::table('asesor_curso')->where('cod_docente',$row['cod_docente'])->first();

        if ($find_asesor == null) {
            return new AsesorCurso([
                'cod_docente'=> $row['cod_docente'],
                'nombres'=> $row['nombres'],
                'orcid'=> $row['orcid'],
                'grado_academico'=> $row['categoria'],
                'titulo_profesional'=> $row['carrera'],
                'direccion'=> $row['direccion']==null? "":$row['direccion'],
                'correo' => $row['correo']==null? "":$row['correo'],
                'semestre_academico'=> $this->semestre_academico,
            ]);
        }

    }

}
