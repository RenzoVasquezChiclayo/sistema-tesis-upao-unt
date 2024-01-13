<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsesorCurso extends Model
{
    protected $connection = 'mysql';
    use HasFactory;
    public $table = 'asesor_curso';

    protected $primaryKey = 'cod_docente';

    protected $fillable = [
        'cod_docente',
        'nombres',
        'orcid',
        'apellidos',
        'grado_academico',
        'titulo_profesional',
        'direccion',
        'correo',
        //Fines del curso
        'username',
        'estado'
    ];


    public $timestamps = false;
}
