<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    use HasFactory;
    public $table = 'docente';

    protected $primaryKey = 'cod_docente';
    protected $fillable = [
        'dni',
        'nombres',
        'celular',
        'correo',
        'direccion',
        'grado_academico',
        'titulo_profesional',
        'cod_escuela'

    ];

    public function escuela(){
        return $this->hasMany(Escuela::class);
    }

    public $timestamps = false;
}

