<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImgEgresado extends Model
{
    use HasFactory;
    public $table = 'img_egresado';
    protected $primaryKey = 'cod_img';
    protected $fillable = [
        'referencia',
        'cod_matricula'
    ];

    public function egresado(){
        return $this->hasOne(Egresado::class);
    }

    public $timestamps = false;
}
