<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historial_Observaciones extends Model
{
    use HasFactory;
    protected $table = 'historial_observaciones';
    protected $primaryKey = 'cod_historialObs';
    protected $fillable = [
        'cod_observaciones',
        'fecha',
        'estado',
        // 'observacionNum'
    ];
    public function ObservacionesP(){
        return $this->hasOne(ObservacionesProy::class);
    }
    public $timestamps = false;
}
