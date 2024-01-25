<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResultadoJuradoProyecto extends Model
{
    use HasFactory;
    public $table = 'resultado_jurado_proyecto';
    protected $primaryKey = 'cod_resultado';
    protected $fillable = [
        'cod_designacion_proyecto',
        'cod_jurado',
        'estado'
    ];
}
