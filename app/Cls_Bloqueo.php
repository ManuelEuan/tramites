<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class Cls_Bloqueo extends Model
{
    protected $connection   = 'pgsql';
    protected $table        = 'tram_dat_bloqueusuario';
    protected $fillable     = [ 'BLUS_NIDBLOQUEUSUARIO', 'BLUS_NIDUSUARIO', 'BLUS_NBLOQUEADO', 'BLUS_CTOKEN', 'BLUS_DFECHABLOQUEO', 'BLUS_DFECHADESBLOQUEO' ];
    
    static function TRAM_SP_VALIDAR_BLOQUEO($IntIdUsuario){
        $Obj = DB::selectOne('call TRAM_SP_VALIDAR_BLOQUEO(?)'
                , array($IntIdUsuario
                )
            );
        return $Obj;
    }
    
    static function TRAM_SP_AGREGAR_BLOQUEO($IntIdUsuario, $BolBloqueado, $StrToken){
        return DB::statement('call TRAM_SP_AGREGAR_BLOQUEO(?,?,?)'
                , array($IntIdUsuario
                , $BolBloqueado
                , $StrToken));
    }
    
    static function TRAM_SP_CONSULTARBLOQUEO($StrToken){
        $ObjBloqueo = DB::selectOne('call TRAM_SP_CONSULTARBLOQUEO(?)'
                , array($StrToken)
            );
        if($ObjBloqueo == null){
            $Obj = null;
        }else {
            $Obj = new Cls_Bloqueo();
            $Obj->BLUS_NIDBLOQUEUSUARIO = $ObjBloqueo->BLUS_NIDBLOQUEUSUARIO;
            $Obj->BLUS_NIDUSUARIO = $ObjBloqueo->BLUS_NIDUSUARIO;
            $Obj->BLUS_NBLOQUEADO = $ObjBloqueo->BLUS_NBLOQUEADO;
            $Obj->BLUS_CTOKEN = $ObjBloqueo->BLUS_CTOKEN;
            $Obj->BLUS_DFECHABLOQUEO = $ObjBloqueo->BLUS_DFECHABLOQUEO;
            $Obj->BLUS_DFECHADESBLOQUEO = $ObjBloqueo->BLUS_DFECHADESBLOQUEO;
        }
        return $Obj;
    }
    
    static function TRAM_SP_DESBLOQUEAR($StrToken){
        return DB::statement('call TRAM_SP_DESBLOQUEAR(?)'
                , array($StrToken));
    }
}
