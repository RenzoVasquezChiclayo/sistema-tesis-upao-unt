<?php

namespace App\Imports;

use App\Models\Asesor_Escuela;
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
    public $escuela;
    public $cont;

    public function __construct($semestre_academico,$escuela)
    {
        $this->semestre_academico = $semestre_academico;
        $this->escuela = $escuela;
        $this->cont = 0;
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

            $new_asesor_escuela = new Asesor_Escuela([
                'cod_docente' => $row['cod_docente'],
                'cod_escuela'=> $this->escuela,
            ]);
            $new_asesor_escuela->save();

            $new_asesor_semestre = new Asesor_Semestre([
                'cod_docente' => $row['cod_docente'],
                'cod_configuraciones'=> $this->semestre_academico,
            ]);
            $new_asesor_semestre->save();
            return $new_asesor;
        }else {
            $find_ases_semes = DB::table('asesor_semestre as as')->where('as.cod_docente',$find_asesor->cod_docente)->get();
            foreach ($find_ases_semes as $key => $f_a_s) {
                if ($f_a_s->cod_configuraciones == $this->semestre_academico) {
                    $this->cont += 1;
                }
            }
            if ($this->cont == 0) {
                $new_asesor_semestre = new Asesor_Semestre([
                    'cod_docente' => $row['cod_docente'],
                    'cod_configuraciones'=> $this->semestre_academico,
                ]);
                $new_asesor_semestre->save();
                return $new_asesor_semestre;
            }

        }

    }

}
