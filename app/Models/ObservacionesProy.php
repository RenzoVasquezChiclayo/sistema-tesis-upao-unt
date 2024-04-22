<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObservacionesProy extends Model
{
    use HasFactory;
    public $table = 'observaciones_proy';

    protected $primaryKey = 'cod_observaciones';
    protected $fillable = [
        'cod_historialObs',
        'observacionNum',
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
        'diseno_contrastacion',
        'tecnicas_instrum',
        'instrumentacion',
        'estg_metodologicas',

        'variables',
        'referencias',

        'estado'
    ];

    public function historialObservacion(){
        return $this->hasOne(Historial_Observaciones::class);
    }

}
