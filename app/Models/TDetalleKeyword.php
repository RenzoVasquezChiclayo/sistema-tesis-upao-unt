<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TDetalleKeyword extends Model
{
    use HasFactory;
    public $table = 't_detalle_keyword';

    protected $primaryKey = 'id_detalle_keyword';
    protected $fillable = [
        'id_keyword',
        'keyword'
    ];
    public $timestamps = false;
    public function keyword(){
        return $this->hasOne(TKeyword::class);
    }

}
