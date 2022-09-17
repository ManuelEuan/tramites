<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cls_Giro extends Model
{
    protected $table    = 'tram_cat_giros';
    public $timestamps  = false;
    protected $fillable     = [
        'clave',
        'nombre',
        'descripcion',
        'activo'
    ];

}
