<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudSustentacion extends Model
{
    use HasFactory;
    public $table ='solicitud_sustentacion';
    protected $primaryKey = 'cod_solicitud_sustentacion';
    protected $fillable =[
        'cod_solicitud_sustentacion',
        'razon_solicitud',
        'fecha_solicitud',
        'cod_tesis',
        'voucher',
        'estado',
    ];


    public $timestamps = false;
}
