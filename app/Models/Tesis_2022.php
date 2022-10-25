<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tesis_2022 extends Model
{
    use HasFactory;
    public $table = 'tesis_2022';
    protected $primaryKey = 'cod_tesis';

    protected $fillable = [
        'titulo',
        'cod_matricula',

        'cod_docente',

        'presentacion',
        'resumen',
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
        'anexos',
        'fecha_create',
        'fecha_update',
        'estado',
        'condicion'
    ];

    public $timestamps = false;

}
