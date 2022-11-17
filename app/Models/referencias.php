<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class referencias extends Model
{
    use HasFactory;
    public $table = 'referencias';
    protected $primaryKey = 'cod_referencias';
    protected $fillable = [
        'cod_tiporeferencia',
        'autor',
        'fPublicacion',
        'titulo',
        'fuente',
        /*Libro*/
        'editorial',
        'title_cap'       ,
        'num_capitulo'    ,
        /*Revista*/
        'title_revista'  ,
        'volumen'         ,
        /*Pagina Web*/
        'name_web'        ,
        /*Articulo*/
        'name_periodista' ,
        /*Tesis*/
        'name_institucion',
        /*Informe-Reporte*/
        'subtitle'        ,
        'name_editor '    ,
        'cod_proyectotesis' ,
        ];
        public function proyectoTesis(){
            return $this->hasOne(TesisCT2022::class);
        }
        public function tipoReferencia(){
            return $this->hasOne(TipoReferencia::class);
        }

    public $timestamps = false;
}
