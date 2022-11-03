<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Cls_Usuario_Tramite extends Model
{
    protected $connection = 'mysql';
    protected $table = 'tram_mdv_usuariotramite';

    //Atributos para filtro
    public $StrTexto;
    public $IntNumPagina;
    public $IntCantidadRegistros;
    public $StrOrdenColumna;
    public $StrOrdenDir;
    public $IntUsuarioId;

    static function TRAM_SP_CONSULTAR_SEGUIMIENTO_TRAMITE_USUARIO($IntUsiario, $StrTexto, $IntEstatus, $IntDependencia, $DteFechaInicio){
        return DB::select('call TRAM_SP_CONSULTAR_SEGUIMIENTO_TRAMITE_USUARIO(?,?,?,?,?)'
        , array($IntUsiario, $StrTexto, $IntEstatus, $IntDependencia, $DteFechaInicio));
    }
    static function ACTUALIZAR_STATUS($folio){
        $rsp = DB::table('tram_mdv_usuariotramite')
                    ->where('USTR_CFOLIO', $folio)
                    ->update(['USTR_NESTATUS' => 10]);
        return $rsp;
    }
    static function ACTUALIZAR_STATUS_VENCIDO($folio){
        $rsp = DB::table('tram_mdv_usuariotramite')
                    ->where('USTR_CFOLIO', $folio)
                    ->update(['USTR_NESTATUS' => 11]);
        return $rsp;
    }
}
