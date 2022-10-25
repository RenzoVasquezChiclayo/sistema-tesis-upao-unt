<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoReferencia extends Model
{
    use HasFactory;
    public $table = 'tiporeferencia';

    protected $primaryKey = 'cod_tiporeferencia';
    protected $fillable = [
        'tipo'
    ];
    public $timestamps = false;
}
