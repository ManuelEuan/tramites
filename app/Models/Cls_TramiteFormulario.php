<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cls_TramiteFormulario extends Model
{
    protected $table        = 'tram_mst_formulario_tramite';
    protected $primaryKey   = 'FORM_NID';
    protected $fillable     = [
        'FORM_NID',
        'FORM_NIDFORMULARIO',
        'FORM_NIDTRAMITE',
        'FORM_CNOMBRE',
        'FORM_CDESCRIPCION',
        'FORM_NESACTIVO',
        'FORM_NMAXDIASRESOL',
        'FORM_NMAXDIASATENCION'
    ];
}
