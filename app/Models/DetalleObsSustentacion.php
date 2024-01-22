<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleObsSustentacion extends Model
{
    use HasFactory;
    protected $table = 'detalle_obs_sustentacion';
    protected $primaryKey = 'cod_detalleObs_sustentacion';
    protected $fillable = [
        'id_observacion',
        'tema_referido',
        'correccion',
        'estado'
    ];
}
