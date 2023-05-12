<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diseno_Investigacion extends Model
{
    use HasFactory;
    public $table = 'diseno_investigacion';

    protected $primaryKey = 'cod_diseno_investigacion';
    protected $fillable = [
        'cod_diseno_investigacion',
        'descripcion',
        'cod_escuela',
        'semestre_academico'
    ];

    public $timestamps = false;
}
