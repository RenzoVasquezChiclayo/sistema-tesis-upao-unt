<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class variableOP extends Model
{
    use HasFactory;
    public $table = 'variableop';
    protected $primaryKey = 'cod_variable';
    protected $fillable = ['descripcion','cod_proyectotesis'];

    public function proyectoTesis(){
        return $this->hasOne(TesisCT2022::class);
    }
    public $timestamps = false;
}
