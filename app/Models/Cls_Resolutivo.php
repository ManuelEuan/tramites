<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cls_Resolutivo extends Model
{
    protected $table        = 'tram_mst_resolutivo';
    protected $primaryKey   = 'RESO_NID';
    public $timestamps      = false;
    protected $fillable     = [
        'RESO_NID',
        'RESO_NIDTRAMITE',
        'TRAD_CNOMBRE',
        'RESO_NIDRESOLUTIVO',
        'RESO_CNOMBRE',
        'TRAD_NOBLIGATORIO',
        'RESO_NIDSECCION',
        'RESO_CNAMEFILE',   
    ];
}
