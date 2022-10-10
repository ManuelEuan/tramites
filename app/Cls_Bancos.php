<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cls_Bancos extends Model
{
    //
    protected $table    = 'tram_cat_bancos';
    public $timestamps  = false;
    protected $fillable = [
        'clave',
        'nombre',
        'descripcion',
        'activo'
    ];
}
