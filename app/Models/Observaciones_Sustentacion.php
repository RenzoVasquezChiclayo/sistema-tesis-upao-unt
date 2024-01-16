<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Observaciones_Sustentacion extends Model
{
    use HasFactory;
    public $table = 'observacion_sustentacion';
    protected $primaryKey = 'id_observacion';

    protected $fillable = [
        'cod_historial_observacion',
        'cod_jurado',
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
