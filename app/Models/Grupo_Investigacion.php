<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupo_Investigacion extends Model
{
    use HasFactory;
    public $table = 'grupo_investigacion';

    protected $primaryKey = 'id_grupo';

    protected $fillable = [
        'id_grupo',
        'num_grupo',
        'cod_docente'
    ];

    public $timestamps = false;
}
