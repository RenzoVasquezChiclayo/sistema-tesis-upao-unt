<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detalle_Grupo_Investigacion extends Model
{
    use HasFactory;

    public $table = 'detalle_grupo_investigacion';

    protected $primaryKey = 'id_detalle_grupo';

    protected $fillable = [
        'id_detalle_grupo',
        'id_grupo_inves',
        'cod_matricula'
    ];

    public $timestamps = false;
}
