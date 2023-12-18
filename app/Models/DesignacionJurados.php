<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DesignacionJurados extends Model
{
    use HasFactory;
    public $table = 'designacion_jurados';
    protected $primaryKey = 'cod_designacion_jurados';
    protected $fillable =[
        'cod_designacion_jurados',
        'cod_tesis',
        'cod_jurado1',
        'cod_jurado2',
        'cod_vocal',
    ];

}
