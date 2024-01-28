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
        'id_observacion',
        'tema_referido',
        'correccion',
    ];
    public function observacion(){
        return $this->hasOne(TObservacion::class);
    }

}
