<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cls_TramiteDocumento extends Model
{
    protected $table        = 'tram_mdv_documento_tramite';
    protected $primaryKey   = 'TRAD_NIDTRAMITEDOCUMENTO';
    public $timestamps      = false;
    protected $fillable     = [
        'TRAD_NIDTRAMITE',
        'TRAD_NIDDOCUMENTO',
        'TRAD_CNOMBRE',
        'TRAD_CDESCRIPCION',
        'TRAD_CEXTENSION',
        'TRAD_NOBLIGATORIO',
        'TRAD_NMULTIPLE',
        'TRAD_NID_CONFIGDOCUMENTO',   
    ];
}
