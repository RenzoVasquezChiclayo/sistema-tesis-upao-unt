<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResultadoJuradoTesis extends Model
{
    use HasFactory;
    public $table = 'resultado_jurado_tesis';
    protected $primaryKey = 'cod_resultado';
    protected $fillable = [
        'cod_designacion_jurados',
        'cod_jurado',
        'estado'
    ];
}
