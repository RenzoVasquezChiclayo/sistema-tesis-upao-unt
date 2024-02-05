<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleSustentacion extends Model
{
    use HasFactory;
    public $table = 'detalle_sustentacion';
    protected $primaryKey = 'cod';
    protected $fillable = [
        'cod_sustentacion',
        'cod_jurado',
        'pos_jurado',
        'nota',
        'estado'
    ];
}
