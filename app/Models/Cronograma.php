<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cronograma extends Model
{
    use HasFactory;
    public $table = 'cronograma';
    protected $primaryKey = 'cod_cronograma';
    protected $fillable =[
        'cod_cronograma',
        'actividad',
        'cod_escuela',
        'cod_configuraciones'
    ];

    public $timestamps = false;
}
