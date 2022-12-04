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
    
    static function TRAM_SP_AGREGARSUCURSAL($Obj){
        return DB::statement('call TRAM_SP_AGREGARSUCURSAL(?,?,?,?,?,?,?,?,?,?,?,?,?)'
                , array($Obj['txtUsuario']
                    , $Obj['txtCalle']
                    , $Obj['txtNumero_Interior']
                    , $Obj['txtNumero_Exterior']
                    , $Obj['txtCP']
                    , $Obj['cmbColonia']
                    , 0
                    , $Obj['cmbMunicipio']
                    , 0
                    , $Obj['cmbEstado']
                    , 0
                    , $Obj['cmbPais']
                    , 0
                )
            );
    }

    static function TRAM_SP_ELIMINARSUCURSAL_USUARIO($IntIdUsuario){
        return DB::statement('call TRAM_SP_ELIMINARSUCURSAL_USUARIO(?)'
                , array($IntIdUsuario));
    }
}
