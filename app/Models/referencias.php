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
        'cod_proyinvestigacion' ,
        ];
        public function proyInvestigacion(){
            return $this->hasOne(Tesis::class);
        }

    public $timestamps = false;
}
