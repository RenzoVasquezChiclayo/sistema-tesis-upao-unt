<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configuraciones_Iniciales extends Model
{
    use HasFactory;
    public $table ='configuraciones_iniciales';
    protected $primaryKey = 'cod_config_ini';
    protected $fillable =[
        'year',
        'curso',
        'ciclo',

    ];

    public $timestamps = false;
}
