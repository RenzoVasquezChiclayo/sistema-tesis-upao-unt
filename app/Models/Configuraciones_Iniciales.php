<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configuraciones_Iniciales extends Model
{
    use HasFactory;
    public $table ='configuraciones_iniciales';
    protected $primaryKey = 'cod_configuraciones';
    protected $fillable =[
        'cod_configuraciones',
        'año',
        'curso',
        'ciclo',
        'estado',

    ];

    public $timestamps = false;
}
