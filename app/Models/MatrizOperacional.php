<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatrizOperacional extends Model
{
    use HasFactory;
    public $table = 'matriz_operacional';
    protected $primaryKey = 'cod_matriz_ope';
    protected $fillable = ['cod_tesis','tipo','variable_I','def_conceptual_I','def_operacional_I','dimensiones_I','indicadores_I','escala_I','variable_D','def_conceptual_D','def_operacional_D','dimensiones_D','indicadores_D','escala_D'];
    public function tesis(){
        return $this->hasOne(Tesis_2022::class);
    }

    public $timestamps = false;
}
