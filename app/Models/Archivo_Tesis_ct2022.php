<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archivo_Tesis_ct2022 extends Model
{
    use HasFactory;
    public $table = 'archivos_proy_tesis';

    protected $primaryKey = 'cod_archivos';

    protected $fillable = [
        'cod_proyinvestigacion'
    ];


    public $timestamps = false;
}
