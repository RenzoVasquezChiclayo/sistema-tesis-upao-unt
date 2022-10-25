<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentosEgresado extends Model
{
    use HasFactory;
    public $table = 'documentos_egresado';
    protected $primaryKey = 'cod_documentos';
    protected $fillable = [
        'cod_matricula',
        'fut',
        'constancia',
        'recibo'
    ];

    public function egresado(){
        return $this->hasOne(Egresado::class);
    }

    public $timestamps = false;
}
