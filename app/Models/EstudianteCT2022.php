<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstudianteCT2022 extends Model
{
    protected $connection = 'mysql';
    use HasFactory;

    public $table = 'estudiante_ct2022';

    protected $primaryKey = 'cod_matricula';
    protected $fillable = [
        'cod_matricula',
        'dni',
        'apellidos',
        'nombres',
        'correo',
        'semestre_academico',
        'estado'
    ];
    /*Delete cod docente*/

    public $timestamps = false;
}
