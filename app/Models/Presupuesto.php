<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presupuesto extends Model
{
    use HasFactory;
    public $table = 'presupuesto';
    protected $primaryKey = 'cod_presupuesto';
    protected $fillable =[
        'denominacion',
        'codeUniversal'
    ];

    public function presupuestoProyecto(){
        return $this->hasMany(Presupuesto_Proyecto::class);
    }

    public $timestamps = false;
}
