<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cls_Dia_Inhabil extends Model
{
    protected $table    = 'tram_dia_inhabil';
    public $timestamps  = false;
    protected $fillable = [
        'nombre',
        'color',
        'fecha_inicio',
        'fecha_final',
        'dependencias',
        'activo'
    ];
}
