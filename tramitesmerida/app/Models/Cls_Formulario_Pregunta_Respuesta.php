<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cls_Formulario_Pregunta_Respuesta extends Model
{
    protected $table = 'tram_form_pregunta_respuestas';
    protected $primaryKey = 'FORM_NID';
    protected $fillable = [
        'FORM_NID',
        'FORM_NPREGUNTAID',
        'FORM_CTIPORESPUESTA',
        'FORM_CVALOR',
        'FORM_BBLOQUEAR',
    ];

    public $timestamps = false;
}
