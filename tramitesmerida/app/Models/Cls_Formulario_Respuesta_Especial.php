<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cls_Formulario_Respuesta_Especial  extends Model
{
    protected $table = 'tram_form_pregunta_respuestas_especial';
    protected $primaryKey = 'FORM_NID';
    protected $fillable = [
        'FORM_NID',
        'FORM_NPREGUNTARESPUESTAID',
        'FORM_CTIPORESPUESTA',
        'FORM_CVALOR'
    ];

    public $timestamps = false;
}
