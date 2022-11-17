<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TObjetivo extends Model
{
    use HasFactory;
    public $table = 't_objetivo';
    protected $primaryKey = 'cod_objetivo';
    protected $fillable = ['tipo','descripcion','cod_tesis'];
    public function tesis(){
        return $this->hasOne(Tesis_2022::class);
    }

    public $timestamps = false;
}
