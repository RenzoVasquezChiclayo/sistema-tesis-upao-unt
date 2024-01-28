<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TesisCT2022 extends Model
{
    protected $connection = 'mysql';
    use HasFactory;
    public $table = 'proyecto_tesis';

    protected $primaryKey = 'cod_proyectotesis';
    protected $fillable = [
        'cod_proyectotesis',
        'titulo',
        //'cod_matricula',
        'id_grupo_inves',

        'cod_docente',
        /*Delete info de asesor y nombre de alumno*/

        'tipo_investigacion',
        'ti_finpersigue',
        'ti_disinvestigacion',
        'localidad',
        'institucion',
        'meses_ejecucion',

        't_ReparacionInstrum',
        't_RecoleccionDatos',
        't_AnalisisDatos',
        't_ElaboracionInfo',

        'financiamiento',
        'real_problematica',
        'antecedentes',
        'justificacion',
        'formulacion_prob',
        'marco_teorico',
        'marco_conceptual',
        'marco_legal',
        'form_hipotesis',
        'objeto_estudio',
        'poblacion',
        'muestra',
        'metodos',
        'tecnicas_instrum',
        'instrumentacion',
        'estg_metodologicas',
        'fecha',
        'estado',
        'condicion'

    ];

    public function presupuestoProyecto(){
        return $this->hasMany(Presupuesto_Proyecto::class);
    }
    public function objetivos(){
        return $this->hasMany(Objetivo::class);
    }
    public function recursos(){
        return $this->hasMany(recursos::class);
    }
    public function variableOP(){
        return $this->hasMany(variableOP::class);
    }
    public function referencias(){
        return $this->hasMany(referencias::class);
    }
    public function observaciones(){
        return $this->hasMany(ObservacionesProy::class);
    }
    public function estudiante(){
        return $this->hasOne(EstudianteCT2022::class);
    }
    public function asesor(){
        return $this->hasOne(AsesorCurso::class);
    }
    public function tipoInvestigacion(){
        return $this->hasOne(TipoInvestigacion::class);
    }
}
