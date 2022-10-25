<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;
    public $table = 'usuario';

    protected $primaryKey = 'username';

    protected $fillable = [
        'contra',
        'rol'
    ];

    public $timestamps = false;
}
