<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformeFinal extends Model
{
    use HasFactory;
    public $table ='informe_final_asesor';
    protected $primaryKey = 'cod_informe_final_asesor';
    protected $fillable =[
        'cod_informe_final',
        'introduccion',
        'aporte_investigacion',
        'metodologia_empleada',
        'cod_tesis',
        'fecha_informe',
        'cod_asesor',
        'estado',


    ];


    public $timestamps = false;
}
