<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fin_Persigue extends Model
{
    use HasFactory;
    public $table = 'fin_persigue';

    protected $primaryKey = 'cod_fin_persigue';
    protected $fillable = [
        'cod_fin_persigue',
        'descripcion',
        'cod_escuela',
        'semestre_academico'
    ];


    public $timestamps = false;
}
