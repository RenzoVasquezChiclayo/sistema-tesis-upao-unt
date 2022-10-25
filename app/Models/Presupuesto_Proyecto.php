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
        'cod_proyinvestigacion'
    ];

    public function presupuesto(){
        return $this->hasOne(Presupuesto::class);
    }


    public $timestamps = false;
}
