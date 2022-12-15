<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Cls_Citas extends Model
{
    protected $connection   = 'pgsql';
    protected $table        = 'tram_aux_citas_reservadas';
    protected $fillable     = ['idtram_aux_citas_reservadas', 'CITA_FOLIO', 'CITA_STATUS', 'CITA_IDUSUARIO', 'CITA_IDTRAMITECONF'];
    protected $primaryKey   = 'idtram_aux_citas_reservadas';
    public $timestamps      = false;


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

    static function GET_ALL(){}
}
