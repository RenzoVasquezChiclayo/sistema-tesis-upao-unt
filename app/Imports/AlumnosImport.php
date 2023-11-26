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
                'cod_matricula' => 'required',
                'dni' => 'required',
                'apellidos' => 'required',
                'nombres' => 'required',
                'correo' => 'nullable',
                'escuela' => 'required',
            ];
        }
    public function model(array $row)
    {

        $find_student = DB::table('estudiante_ct2022 as e')->where('cod_matricula',$row['cod_matricula'])->first();


        if ($find_student == null) {
            $new_estudiante = new EstudianteCT2022([
                'cod_matricula' => $row['cod_matricula'],
                'dni' => $row['dni'],
                'apellidos' => $row['apellidos'],
                'nombres' => $row['nombres'],
                'correo' => $row['correo'],
                'cod_escuela' => $this->escuela,
            ]);
            $new_estudiante->save();
            $new_estudiante_semestre = new Estudiante_Semestre([
                'cod_matricula' => $row['cod_matricula'],
                'cod_configuraciones'=> $this->semestre_academico,
            ]);
            $new_estudiante_semestre->save();
            return $new_estudiante;
        }else{
            $find_estu_semes = DB::table('estudiante_semestre as es')->where('es.cod_matricula',$find_student->cod_matricula)->get();
            foreach ($find_estu_semes as $key => $f_e_s) {
                if ($f_e_s->cod_configuraciones == $this->semestre_academico) {
                    $this->cont += 1;
                }
            }
            if ($this->cont == 0) {
                $new_estudiante_semestre = new Estudiante_Semestre([
                    'cod_matricula' => $row['cod_matricula'],
                    'cod_configuraciones'=> $this->semestre_academico,
                ]);
                $new_estudiante_semestre->save();
                return $new_estudiante_semestre;
            }
        }


    }

}
