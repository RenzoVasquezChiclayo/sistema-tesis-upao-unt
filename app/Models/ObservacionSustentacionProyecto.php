<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObservacionSustentacionProyecto extends Model
{
    use HasFactory;
    public $table = 'observacion_sustentacionproy';

    protected $primaryKey = 'cod_observacion_sustentacion';
    protected $fillable = [
        'cod_historialObs',
        'cod_jurado',
        'fecha',
        'titulo',
        'linea_investigacion',
        'localidad_institucion',
        'meses_ejecucion',

        'recursos',
        'presupuesto_proy',
        'real_problematica',
        'antecedentes',
        'justificacion',
        'formulacion_prob',
        'objetivos',

        'marco_teorico',
        'marco_conceptual',
        'marco_legal',
        'form_hipotesis',
        'objeto_estudio',
        'poblacion',
        'muestra',
        'metodos',
        'tecnicas_instrum',
        'instrumentacion',
        'estg_metodologicas',

        'variables',
        'referencias',

        'estado'
    ];
}
