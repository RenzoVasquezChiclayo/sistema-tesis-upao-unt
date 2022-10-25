<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CamposEstudiante extends Model
{
    use HasFactory;
    public $table ='campos_estudiante';
    protected $primaryKey = 'cod_matricula';
    protected $fillable =[
        'cod_docente',
        'titulo',
        'tipo_investigacion',
        'localidad_institucion',
        'duracion_proyecto',
        'recursos',
        'presupuesto',
        'financiamiento',
        'rp_antecedente_justificacion',
        'formulacion_problema',
        'objetivos',
        'marcos',
        'formulacion_hipotesis',
        'diseño_investigacion',
        'referencias_b'

    ];
    public $timestamps = false;

}
