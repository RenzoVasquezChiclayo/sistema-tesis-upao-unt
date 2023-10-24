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
        'apellidos',
        'orcid',
        'cod_grado_academico',
        'cod_categoira',
        'direccion',
        'correo',
        //Fines del curso
        'username',
        'semestre_academico',
        'estado'
    ];

    public function categoria_docente(){
        return $this->hasOne(Categoria_Docente::class);
    }

    public function grado_academico(){
        return $this->hasOne(Grado_Academico::class);
    }


    public $timestamps = false;
}
