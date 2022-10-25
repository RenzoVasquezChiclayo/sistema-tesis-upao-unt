<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facultad extends Model
{


    use HasFactory;
    public $table = 'facultad';
    protected $primaryKey = 'cod_facultad';
    protected $fillable = [
        'nombre'
    ];

    public function escuela(){
        return $this->hasMany(Escuela::class);
    }

    public $timestamps = false;
}
