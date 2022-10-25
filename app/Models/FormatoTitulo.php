<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormatoTitulo extends Model
{
    use HasFactory;
    public $table = 'formato_titulo';
    protected $primaryKey = 'codigo';
    protected $fillable = [
        'cod_formato',
        'cod_matricula',
        'tit_profesional',
        'fecha_nacimiento',
        'direccion',
        'tele_fijo',
        'tele_celular',
        'correo',
        'modalidad_titulo',
        'sgda_especialidad',
        'prog_extraordinario',
        'fecha_sustentacion',
        'fecha_colacion',
        'centro_labores',
        'colegio',
        'tipo_colegio',
        'cod_escuela',
        'cod_sede',
        'estado',
        'fecha',
        'firmaIMG',
        'cod_tinvestigacion',
        'cod_docente'
    ];

    public function asesor(){
        return $this->hasOne(Asesor::class);
    }
    public function egresado(){
        return $this->hasOne(Egresado::class);
    }
    public function escuela(){
        return $this->hasOne(FormatoTitulo::class);
    }
    public function tipoinvestigacion(){
        return $this->hasOne(TipoInvestigacion::class);
    }
    public function sede(){
        return $this->hasOne(Sede::class);
    }

    public $timestamps = false;
}
