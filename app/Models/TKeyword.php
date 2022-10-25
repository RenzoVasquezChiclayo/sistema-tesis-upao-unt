<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TKeyword extends Model
{
    use HasFactory;
    public $table = 't_keyword';

    protected $primaryKey = 'id_keyword';
    protected $fillable = [
        'cod_tesis',
        'fecha_update'
    ];
    public $timestamps = false;

}
