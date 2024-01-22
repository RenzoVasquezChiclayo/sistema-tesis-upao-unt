<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DesignacionJuradoProyecto extends Model
{
    use HasFactory;
    public $table = 'designacion_jurado_proyecto';
    protected $primaryKey = 'cod_designacion_proyecto';
    protected $fillable =[
        'cod_proyectotesis',
        'cod_jurado1',
        'cod_jurado2',
        'cod_jurado3',
        'cod_jurado4',
        'estado'
    ];
}
