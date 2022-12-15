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
    protected $primaryKey   = 'BLUS_NIDBLOQUEUSUARIO';
    protected $timestamps   = false;


    static function TRAM_SP_AGREGAR_BLOQUEO($IntIdUsuario, $BolBloqueado, $token){
        $item = new Cls_Bloqueo();
        $item->BLUS_NIDUSUARIO      = $IntIdUsuario;
        $item->BLUS_NBLOQUEADO      = $BolBloqueado;
        $item->BLUS_CTOKEN          = $token;
        $item->BLUS_DFECHABLOQUEO   = now();
        $item->BLUS_DFECHADESBLOQUEO = now();
        $item->save();

        return $item;
    }
}
