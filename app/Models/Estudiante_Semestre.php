<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiante_Semestre extends Model
{
    use HasFactory;
    public $table = 'estudiante_semestre';

    protected $primaryKey = 'cod_estudiante_semestre';

    protected $fillable = [
        'cod_estudiante_semestre',
        'cod_matricula',
        'cod_configuraciones',

    ];

    public $timestamps = false;
}
