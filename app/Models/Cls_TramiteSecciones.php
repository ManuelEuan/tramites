<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cls_TramiteSecciones extends Model
{
    protected $table        = 'tram_mdv_seccion_tramite';
    protected $primaryKey   = 'CONF_NIDCONFIGURACION';
    protected $fillable     = [
        'CONF_NIDCONFIGURACION',
        'CONF_NIDTRAMITE',
        'CONF_NSECCION',
        'CONF_CNOMBRESECCION',
        'CONF_ESTATUSSECCION',
        'CONF_NDIASHABILES',
        'CONF_CDESCRIPCIONCITA',
        'CONF_CDESCRIPCIONVENTANILLA',
        'CONF_NORDEN'
    ];
}
