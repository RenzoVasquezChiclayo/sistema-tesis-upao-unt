<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cronograma_Proyecto extends Model
{
    use HasFactory;
    public $table = 'cronograma_proyecto';
    protected $primaryKey = 'cod_cronoProyecto';
    protected $fillable =[
        'cod_cronoProyecto',
        'descripcion',
        'cod_cronograma',
        'cod_proyectotesis',
    ];

    public $timestamps = false;
}
