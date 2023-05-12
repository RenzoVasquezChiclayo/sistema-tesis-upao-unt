<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoInvestigacion extends Model
{
    use HasFactory;
    public $table = 'tipoinvestigacion';

    protected $primaryKey = 'cod_tinvestigacion';
    protected $fillable = [
        'descripcion',
        'cod_escuela',
        'semestre_academico'
    ];

    public function escuela(){
        return $this->hasOne(Escuela::class);
    }

    public function formatoTitulo(){
        return $this->hasMany(FormatoTitulo::class);
    }
    public $timestamps = false;
}
