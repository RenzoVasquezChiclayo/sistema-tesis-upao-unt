<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class recursos extends Model
{
    use HasFactory;
    public $table = 'recursos';
    protected $primaryKey = 'cod_recurso';
    protected $fillable = [
        'tipo',
        'subtipo',
        'descripcion',
        'cod_proyectotesis'
    ];

    public function proyectoTesis(){
        return $this->hasOne(TesisCT2022::class);
    }

    public $timestamps = false;

}
