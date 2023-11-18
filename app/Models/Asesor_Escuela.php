<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asesor_Escuela extends Model
{
    use HasFactory;
    public $table = 'asesor_escuela';

    protected $primaryKey = 'cod_asesor_escuela';

    protected $fillable = [
        'cod_asesor_escuela',
        'cod_docente',
        'cod_escuela',

    ];

    public $timestamps = false;
}
