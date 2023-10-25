<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asesor_Semestre extends Model
{
    use HasFactory;
    public $table = 'asesor_semestre';

    protected $primaryKey = 'cod_asesor_semestre';

    protected $fillable = [
        'cod_asesor_semestre',
        'cod_docente',
        'cod_configuraciones',

    ];

    public $timestamps = false;
}
