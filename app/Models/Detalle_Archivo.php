<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detalle_Archivo extends Model
{
    use HasFactory;
    public $table = 'detalle_archivos';

    protected $primaryKey = 'id';

    protected $fillable = [
        'cod_archivos',
        'tipo',
        'grupo',
        'orden',
        'ruta'
    ];

    public function archivoProyecto(){
        return $this->hasOne(Archivo_Tesis_ct2022::class);
    }

}
