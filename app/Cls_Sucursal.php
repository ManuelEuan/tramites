<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Cls_Sucursal extends Model
{
    protected $connection   = 'pgsql';
    protected $table        = 'tram_mdv_sucursal';
    protected $primaryKey   = 'SUCU_NIDSUCURSAL';
    protected $fillable     = [
        'SUCU_NIDUSUARIO',
        'SUCU_CCALLE',
        'SUCU_NNUMERO_INTERIOR',
        'SUCU_NNUMERO_EXTERIOR',
        'SUCU_NCP',
        'SUCU_CCOLONIA',
        'SUCU_NCVECOLONIA',
        'SUCU_CMUNICIPIO',
        'SUCU_NCVEMUNICIPIO',
        'SUCU_CESTADO',
        'SUCU_CESTADO',
        'SUCU_NCVEESTADO',
        'SUCU_CPAIS',
        'SUCU_NCVEPAIS',
        'SUCU_FOLIO'
    ];
}
