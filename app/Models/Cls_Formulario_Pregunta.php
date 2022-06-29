<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Cls_Formulario_Pregunta_Respuesta;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cls_Formulario_Pregunta extends Model
{
    protected $table = 'tram_form_pregunta';
    protected $primaryKey = 'FORM_NID';
    protected $fillable = [
        'FORM_NID',
        'FORM_NFORMULARIOID',
        'FORM_NSECCIONID',
        'FORM_CPREGUNTA',
    ];

    public $timestamps = false;

    public function respuestas(): HasMany{
        return $this->hasMany(Cls_Formulario_Pregunta_Respuesta::class);
    }
}
