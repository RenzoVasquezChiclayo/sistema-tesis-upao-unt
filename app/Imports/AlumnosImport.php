<?php

namespace App\Imports;

use App\Models\Estudiante_Semestre;
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
            $new_estudiante = new EstudianteCT2022([
                'cod_matricula' => $row['cod_matricula'],
                'dni' => $row['dni'],
                'apellidos' => $row['apellidos'],
                'nombres' => $row['nombres'],
                'correo' => $row['correo']==null? "":$row['correo'],
            ]);
            $new_estudiante->save();
            $new_estudiante_semestre = new Estudiante_Semestre([
                'cod_matricula' => $row['cod_matricula'],
                'cod_configuraciones'=> $this->semestre_academico,
            ]);
            $new_estudiante_semestre->save();
            return $new_estudiante;
        }


    }

}
