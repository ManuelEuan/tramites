<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Cls_Citas extends Model
{
    protected $table = 'tram_aux_citas_reservadas';


    public function TRAM_SP_CITACONSULTAR($idusuario, $idtramite)
    {
        return DB::select('call TRAM_SP_CITACONSULTAR(?,?)'
                , array($idusuario
                , $idtramite));
    }

    static function TRAM_SP_CITAAGENDADA($CITA_FOLIO,$CITA_STATUS,$CITA_IDUSUARIO,$CITA_IDTRAMITECONF){
        return DB::statement('call TRAM_SP_CITAAGENDADA(?,?,?,?)'
                , array($CITA_FOLIO
                , $CITA_STATUS
                , $CITA_IDUSUARIO
                , $CITA_IDTRAMITECONF));
    }

    static function TRAM_SP_CITAACTUALIZADA($CITA_FOLIO,$CITA_STATUS){
        return DB::statement('call TRAM_SP_CITAACTUALIZADA(?,?)'
                , array($CITA_FOLIO
                , $CITA_STATUS));
    }
}
