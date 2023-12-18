<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurado extends Model
{
    use HasFactory;

    public $table = 'jurado';
    protected $primaryKey = 'cod_jurado';
    protected $fillable = ['cod_diseno_investigacion','cod_docente','username','estado'];
}
