<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Escuela extends Model
{
    use HasFactory;
    public $table = 'escuela';
    protected $primaryKey = 'cod_escuela';
    protected $fillable = [
        'nombre',
        'cod_facultad'
    ];

    public function facultad(){
        return $this->hasOne(Facultad::class);
    }

    public function tinvestigacion(){
        return $this->hasMany(TipoInvestigacion::class);
    }

    public function fin_persigue(){
        return $this->hasMany(Fin_Persigue::class);
    }

    public function diseno_investigacion(){
        return $this->hasMany(Diseno_Investigacion::class);
    }

    public function formatoTitulo(){
        return $this->hasMany(FormatoTitulo::class);
    }

    public $timestamps = false;
}
