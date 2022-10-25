<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TReferencias extends Model
{
    use HasFactory;
    public $table = 't_referencias';
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
        'cod_tesis' ,
        ];

    public $timestamps = false;
}
