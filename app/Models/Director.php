<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Director extends Model
{
    protected $connection = 'mysql';
    use HasFactory;
    public $table = 'director';

    protected $primaryKey = 'cod_director';

    protected $fillable = [
        'cod_director',
        'nombres',
        'apellidos',
        'cod_grado_academico',
        'cod_escuela',
        'direccion',
        'correo',
        //Fines del curso
        'username',
        'estado'
    ];

}
