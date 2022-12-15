<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cls_TramiteEdificio extends Model
{
    protected $table        = 'tram_mst_edificio';
    protected $primaryKey   = 'EDIF_NID';
    public $timestamps      = false;
    protected $fillable     = [
        'EDIF_NIDTRAMITE',
        'EDIF_CNOMBRE',
        'EDIF_CCALLE',
        'EDIF_NNUMERO_INTERIOR',
        'EDIF_NNUMERO_EXTERIOR',
        'EDIF_NCP',
        'EDIF_CCOLONIA',
        'EDIF_NCVECOLONIA',
        'EDIF_CMUNICIPIO',
        'EDIF_CESTADO',
        'EDIF_CDIASATENCION',
        'EDIF_CHORARIOS',
        'EDIF_CLATITUD',
        'EDIF_CLONGITUD',
        'EDIF_NIDSECCION',
        'EDIF_NIDEDIFICIO',    
    ];
}
