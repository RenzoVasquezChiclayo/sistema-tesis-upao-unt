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
        'cod_proyinvestigacion',
        'observacionNum',
        'fecha',
        'titulo',
        'linea_investigacion',
        'localidad_institucion',
        'meses_ejecucion',

        'recursos',

        // 'titulo_presup',
        // 'nombre_recurso',
        // 'cantidad_rec',
        // 'costo_rec',
        // 'financiamiento',
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
        'estrategias',

        'variables',
        'referencias',

        'estado'

    ];

    public function proyInvestigacion(){
        return $this->hasOne(Tesis::class);
    }

    public $timestamps = false;
}
