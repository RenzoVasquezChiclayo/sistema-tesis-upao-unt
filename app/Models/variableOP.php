<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class variableOP extends Model
{
    use HasFactory;
    public $table = 'variableop';
    protected $primaryKey = 'cod_variable';
    protected $fillable = ['descripcion','cod_proyinvestigacion'];

    public function proyInvestigacion(){
        return $this->hasOne(Tesis::class);
    }
    public $timestamps = false;
}
