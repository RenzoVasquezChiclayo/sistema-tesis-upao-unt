<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detalle_Observaciones extends Model
{
    use HasFactory;
    protected $table = 'detalle_observaciones';
    protected $primaryKey = 'cod_detalleObs';
    protected $fillable = [
        'cod_observaciones',
        'tema_referido',
        'correccion'
    ];

    public function observacion(){
        return $this->hasOne(ObservacionesProy::class);
    }

    public $timestamps = false;
}
