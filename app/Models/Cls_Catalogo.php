<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cls_Catalogo extends Model
{
    protected $table    = 'catalogos';
    public $timestamps  = false;
    protected $fillable = [
        'nombre',
        'tabla',
        'descripcion',
        'activo'
    ];
}
