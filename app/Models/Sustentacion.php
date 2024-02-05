<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sustentacion extends Model
{
    use HasFactory;
    public $table = 'sustentacion';
    protected $primaryKey = 'cod';
    protected $fillable = [
        'cod_tesis',
        'modalidad',
        'fecha_stt',
        'estado'
    ];
}
