<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asesor extends Model
{
    use HasFactory;
    public $table = 'asesor';

    protected $primaryKey = 'cod_docente';

    protected $fillable = [
        'nombres',
        'grado_academico',
        'titulo_profesional',
        'direccion',

        //Fines del curso
        'username'
    ];
    public function formatoTitulo(){
        return $this->hasMany(FormatoTitulo::class);
    }

    public $timestamps = false;
}
