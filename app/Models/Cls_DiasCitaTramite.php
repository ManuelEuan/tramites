<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cls_DiasCitaTramite extends Model
{
    protected $table = 'citas_tramites';
    protected $fillable = [
        'tramiteId',
        'moduloId',
        'dia',
        'horarioInicial',
        'horarioFinal',
        'ventanillas',
        'capacidad',
        'tiempoAtencion'
    ];

    public $timestamps = false;
}
