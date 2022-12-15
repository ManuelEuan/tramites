<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cls_Tramite_Concepto extends Model
{
    protected $connection   = 'psql';
    protected $table        = 'tram_mst_concepto_tramite';
    protected $timestamps   = false;
    protected $primaryKey   = 'CONC_NID';
    protected $fillable     = [
        'CONC_NID',
        'CONC_NIDCONCEPTO',
        'CONC_NIDTRAMITE',
        'CONC_NIDTRAMITE_ACCEDE',
        'CONC_NREFERENCIA',
        'CONC_CONCEPTO',
        'CONC_CTRAMITE',
        'CONC_CENTE_PUBLICO',
        'CONC_CENTE',
        'CONC_NIDSECCION',
    ];


}
