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
        'cod_proyectotesis',
        'fecha',
        'estado'
    ];
    public function proyectoTesis(){
        return $this->hasOne(TesisCT2022::class);
    }
}
