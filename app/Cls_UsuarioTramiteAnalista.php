<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class Cls_UsuarioTramiteAnalista extends Model
{
    protected $connection = 'mysql';
    protected $table = 'tram_mdv_usuariotramite_analista';

    
    static function AsignarTramite(Request $request){//Request $request
        try {
            $verifica = DB::select('select * from tram_mdv_usuariotramite_analista where USTR_NIDUSUARIOTRAMITE = ?', [$request->USTR_NIDUSUARIOTRAMITE,]);
        
            if(count($verifica) > 0){
                DB::update('update tram_mdv_usuariotramite_analista set USUA_NIDUSUARIO = ?, USTR_ACTIVO  = 1 WHERE USTR_NIDUSUARIOTRAMITE = ?',
                    [
                        $request->USUA_NIDUSUARIO,
                        $request->USTR_NIDUSUARIOTRAMITE
                    ]
                );
            }else{
                DB::insert('insert into tram_mdv_usuariotramite_analista (USTR_NIDUSUARIOTRAMITE, USUA_NIDUSUARIO, USTR_ACTIVO, USUA_NIDUSUARIOREGISTRO) values (?, ?, ?, ?)',
                    [
                        $request->USTR_NIDUSUARIOTRAMITE,
                        $request->USUA_NIDUSUARIO,
                        1,
                        $request->USUA_NIDUSUARIOREGISTRO
                    ]
                );
            }

            $response = [
                "estatus" => "success",
                "mensaje" => "¡Éxito! acción realizada con éxito.",
                "codigo" => 200
            ];
        } catch (\Throwable $th) {
            $response = [
                "estatus" => "error",
                "mensaje" => "Ocurrió un error: " . $th->getMessage(),
                "codigo" => 400
            ];
        }

        return response()->json($response);
    }

    static function ApruebaTramite($USTR_NIDUSUARIOTRAMITE){//Request $request

        $verifica = DB::update('update tram_mdv_usuariotramite_analista set USTR_ACTIVO = 0 WHERE USTR_NIDUSUARIOTRAMITE = ?', [$USTR_NIDUSUARIOTRAMITE]);
        
        if($verifica > 0){
            $insert=true;
        }else{
            $insert=false;
        }

        return $insert;
    }

    static function TramitesAnalista($USUA_NIDUSUARIO){//Request $request
        $response = DB::select('select * from tram_mdv_usuariotramite_analista where USUA_NIDUSUARIO = ? and USTR_ACTIVO = 1', [$USUA_NIDUSUARIO]);

        return $response;
    }

    static function VerificaAsignacion($USTR_NIDUSUARIOTRAMITE){//Request $request
        $verifica = DB::select('select * from tram_mdv_usuariotramite_analista where USTR_NIDUSUARIOTRAMITE = ?', [$USTR_NIDUSUARIOTRAMITE,]);
        
        if(count($verifica) > 0){
            $verifica=1;
        }else{
            $verifica=0;
        }

        return $verifica;
    }
}
