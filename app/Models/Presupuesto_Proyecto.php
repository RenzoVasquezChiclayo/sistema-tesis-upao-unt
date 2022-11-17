<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presupuesto_Proyecto extends Model
{
    use HasFactory;
    public $table = 'presupuesto_proyecto';
    protected $primaryKey = 'cod_presProyecto';
    protected $fillable =[
        'precio',
        'cod_presupuesto',
        'cod_proyectotesis'
    ];

    public function presupuesto(){
        return $this->hasOne(Presupuesto::class);
    }
    public function proyectoTesis(){
        return $this->hasOne(TesisCT2022::class);
    }

    public $timestamps = false;
}
