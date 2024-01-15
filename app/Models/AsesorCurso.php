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
        //'grado_academico', Deleted
        // 'titulo_profesional', Deleted
        'cod_grado_academico',
        'cod_categoria',
        'direccion',
        'correo',
        //Fines del curso
        'username',
        'estado'
    ];


    public $timestamps = false;
}
