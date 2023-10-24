<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grado_Academico extends Model
{
    use HasFactory;
    public $table ='grado_academico';
    protected $primaryKey = 'cod_grado_academico';
    protected $fillable =[
        'cod_grado_academico',
        'descripcion',
        'estado',


    ];

    public function asesor_curso(){
        return $this->hasMany(AsesorCurso::class);
    }

    public $timestamps = false;
}
