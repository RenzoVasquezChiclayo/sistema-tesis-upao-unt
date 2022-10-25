<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TObservacion extends Model
{
    use HasFactory;
    public $table = 't_observacion';
    protected $primaryKey = 'id_observacion';

    protected $fillable = [
        'cod_tesis',
        'cod_hisotrial_obs',
        'presentacion',
        'resumen',
        'keyword',
        'introduccion',

        'real_problematica',
        'antecedentes',
        'justificacion',
        'formulacion_prob',

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

        'discusion',
        'conclusiones',
        'recomendaciones',

        'resultados',

        'estado',
        'fecha_create',
        'fecha_update',
    ];

    public $timestamps = false;

}
