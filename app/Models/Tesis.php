<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tesis extends Model
{
    use HasFactory;
    public $table = 'proyinvestigacion';

    protected $primaryKey = 'cod_proyinvestigacion';
    protected $fillable = [
        'titulo',
        'cod_matricula',
        'nombres',
        'direccion',
        'escuela',
        'nombre_asesor',
        'grado_asesor',
        'titulo_asesor',
        'direccion_asesor',

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

        'rec_personal',
        'rec_b_consumo',
        'rec_b_inversion',
        'rec_servicios',
        'titulo_presup',
        'nombre_recurso',
        'cantidad_rec',
        'costo_rec',
        'financiamiento',
        'real_problematica',
        'antecedentes',
        'justificacion',
        'formulacion_prob',
        'obj_generales',
        'obj_especificos',
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
        'referencias',
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
    public $timestamps = false;
}
