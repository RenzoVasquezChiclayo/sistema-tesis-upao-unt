<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configuraciones_Iniciales extends Model
{
    use HasFactory;
    public $table = 'configuraciones_iniciales';
    protected $primaryKey = 'cod_config_ini';
    protected $fillable = [
        'year',
        'curso',
        'ciclo',
        'estado',
        'codigo',
    ];

    public $timestamps = false;

    /* Define el codigo del curso */
    protected static function booted()
    {
        static::saved(function ($model) {
            $idModified =
                ($model->cod_config_ini < 100) ? (
                    ($model->cod_config_ini < 10) ? "00" . $model->cod_config_ini : "0" . $model->cod_config_ini
                ) : $model->cod_config_ini;

            $model->codigo = $model->year . $idModified;
            $model->saveQuietly();
        });
    }
}
