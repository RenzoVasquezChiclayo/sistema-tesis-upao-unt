<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria_Docente extends Model
{
    use HasFactory;
    public $table ='categoria_docente';
    protected $primaryKey = 'cod_categoria';
    protected $fillable =[
        'cod_categoria',
        'descripcion',
        'estado',


    ];

    public function asesor_curso(){
        return $this->hasMany(AsesorCurso::class);
    }

    public $timestamps = false;
}
