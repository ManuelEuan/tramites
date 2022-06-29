<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class Cls_Sucursal extends Model
{
    protected $table = 'tram_mdv_sucursal';
    
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
