<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleObsSustentacionProy extends Model
{
    use HasFactory;
    protected $table = 'detalle_obs_sustentacionproy';
    protected $primaryKey = 'cod_detalleObs_sustentacionProy';
    protected $fillable = [
        'cod_observacion_sustentacion',
        'tema_referido',
        'correccion',
        'estado'
    ];
}
