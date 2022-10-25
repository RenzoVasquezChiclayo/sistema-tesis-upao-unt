<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TDetalleObservacion extends Model
{
    use HasFactory;
    public $table = 't_detalle_observacion';

    protected $primaryKey = 'id_detalle_observacion';
    protected $fillable = [
        'cod_historial_obs',
        'tema_referido',
        'correccion',
    ];
    public $timestamps = false;

}
