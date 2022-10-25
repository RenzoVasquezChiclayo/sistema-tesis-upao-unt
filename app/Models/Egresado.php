<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Egresado extends Model
{
    use HasFactory;
    public $table = 'egresado';

    protected $primaryKey = 'cod_matricula';
    protected $fillable = [
        'dni',
        'apellidos',
        'nombres'
    ];

    public function formatoTitulo(){
        return $this->hasOne(FormatoTitulo::class);
    }

    public $timestamps = false;
}
