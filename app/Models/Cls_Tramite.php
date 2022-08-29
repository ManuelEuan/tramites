<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cls_Tramite extends Model
{
    protected $table = 'tram_mst_tramite';
    protected $fillable = [
        'TRAM_NIDTRAMITE',
        'TRAM_NIDTRAMITE_ACCEDE',
        'TRAM_NTIPO',
        'TRAM_NIDUNIDADADMINISTRATIVA',
        'TRAM_CUNIDADADMINISTRATIVA',
        'TRAM_NIDCENTRO',
        'TRAM_CCENTRO',
        'TRAM_CNOMBRE',
        'TRAM_CENCARGADO',
        'TRAM_CCONTACTO',
        'TRAM_CDESCRIPCION',
        'TRAM_NDIASHABILESRESOLUCION',
        'TRAM_NDIASHABILESNOTIFICACION',
        'TRAM_NENLACEOFICIAL',
        'TRAM_NIMPLEMENTADO',
        'TRAM_NIDFORMULARIO',
        'TRAM_NESTATUS',
        'TRAM_NLINEA',
        'TRAM_NPRESENCIAL',
        'TRAM_NTELEFONO',
        'TRAM_CAUDIENCIA',
        'TRAM_CID_AUDIENCIA',
        'TRAM_CTRAMITE_JSON'
    ];
}
