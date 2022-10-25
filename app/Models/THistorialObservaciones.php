<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class THistorialObservaciones extends Model
{
    use HasFactory;
    protected $table = 't_historial_observaciones';
    protected $primaryKey = 'cod_historial_observacion';
    protected $fillable = [
        'cod_Tesis',
        'fecha',
        'estado',
        // 'observacionNum'
    ];

    public $timestamps = false;
}
