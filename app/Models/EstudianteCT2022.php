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
        'cod_docente'
    ];

    public function asesor(){
        return $this->hasOne(AsesorCurso::class);
    }

    public $timestamps = false;
}
