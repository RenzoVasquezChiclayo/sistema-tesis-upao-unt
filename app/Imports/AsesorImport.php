<?php

namespace App\Imports;

use App\Models\Asesor_Semestre;
use App\Models\AsesorCurso;
use App\Models\Estudiante_Semestre;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class AsesorImport implements ToModel, WithHeadingRow, WithValidation
{
    public $semestre_academico;

    public function __construct($semestre_academico)
    {
        $this->semestre_academico = $semestre_academico;
    }
    public function rules(): array
        {
            return [
                'cod_grado_academico' => 'required', // Assuming 'cod_matricula' is a required field
                'cod_categoria' => 'nullable', // 'dni' can be nullable in the Excel file
                'direccion' => 'required', // Assuming 'apellidos' is a required field
                'correo' => 'required', // Assuming 'nombres' is a required field
            ];
        }
    public function model(array $row)
    {

        $find_asesor = DB::table('asesor_curso')->where('cod_docente',$row['cod_docente'])->first();

        if ($find_asesor == null) {
            $new_asesor = new AsesorCurso([
                'cod_docente'=> $row['cod_docente'],
                'nombres'=> $row['nombres'],
                'orcid'=> $row['orcid'],
                'cod_grado_academico'=> $row['grado_academico'],
                'cod_categoria'=> $row['categoria'],
                'direccion'=> $row['direccion'],
                'correo' => $row['correo'],
            ]);
            $new_asesor->save();

            $new_asesor_semestre = new Asesor_Semestre([
                'cod_docente' => $row['cod_docente'],
                'cod_configuraciones'=> $this->semestre_academico,
            ]);
            $new_asesor_semestre->save();
            return $new_asesor;
        }

    }

}
