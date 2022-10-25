<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sede extends Model
{
    use HasFactory;

    public $table = 'sede';
    protected $primaryKey = 'cod_sede';
    protected $fillable = [
        'nombre'
    ];

    public function formatoTitulo(){
        return $this->hasMany(FormatoTitulo::class);
    }

    public $timestamps = false;
}
