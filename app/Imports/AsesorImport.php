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
                'cod_docente' => 'required',
                'nombres' => 'required',
                'apellidos' => 'required',
                'orcid' => 'required',
                'cod_grado_academico' => 'nullable',
                'cod_categoria' => 'nullable',
                'correo' => 'nullable',
            ];
        }
    public function model(array $row)
    {

        $find_asesor = DB::table('asesor_curso')->where('cod_docente',$row['cod_docente'])->first();

        if ($find_asesor == null) {
            $new_asesor = new AsesorCurso([
                'cod_docente'=> $row['cod_docente'],
                'nombres'=> $row['nombres'],
                'apellidos'=> $row['apellidos'],
                'orcid'=> $row['orcid'],
                'cod_grado_academico'=> $row['grado_academico'],
                'cod_categoria'=> $row['categoria'],
                'direccion'=> $row['direccion']==null? "":$row['direccion'],
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
