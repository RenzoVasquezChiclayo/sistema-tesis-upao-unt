<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Objetivo extends Model
{
    use HasFactory;
    public $table = 'objetivo';
    protected $primaryKey = 'cod_objetivo';
    protected $fillable = ['tipo','descripcion','cod_proyectotesis'];

    public function proyectoTesis(){
        return $this->hasOne(TesisCT2022::class);
    }

    public $timestamps = false;

}
