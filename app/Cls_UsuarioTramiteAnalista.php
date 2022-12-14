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
            $existe = DB::table('tram_mdv_usuariotramite_analista')->where('USTR_NIDUSUARIOTRAMITE', $request->USTR_NIDUSUARIOTRAMITE)->first();
            if(!is_null($existe)){
                DB::table('tram_mdv_usuariotramite_analista')->where('USTR_NIDUSUARIOTRAMITE', $request->USTR_NIDUSUARIOTRAMITE)->update([
                    'USUA_NIDUSUARIO'           => $request->USUA_NIDUSUARIO, 
                    'USUA_NIDUSUARIOREGISTRO'   => $request->USUA_NIDUSUARIOREGISTRO,
                    'USUA_FECHA'                => $request->USUA_NIDUSUARIO != 0 ? now() : null,
                ]);
            }else{
                DB::table('tram_mdv_usuariotramite_analista')->insert([
                    'USTR_NIDUSUARIOTRAMITE'    => $request->USTR_NIDUSUARIOTRAMITE,
                    'USUA_NIDUSUARIO'           => $request->USUA_NIDUSUARIO, 
                    'USUA_NIDUSUARIOREGISTRO'   => $request->USUA_NIDUSUARIOREGISTRO,
                    'USUA_FECHA'                => now(),
                    'USTR_ACTIVO'               => true
                ]);
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

    static function AnalistaTramiteAsignado($USTR_NIDUSUARIOTRAMITE, $USUA_NIDUSUARIO){//Request $request
        $response = DB::select('select * from tram_mdv_usuariotramite_analista where USTR_NIDUSUARIOTRAMITE = ? and USUA_NIDUSUARIO = ? and USTR_ACTIVO = 1', [$USTR_NIDUSUARIOTRAMITE, $USUA_NIDUSUARIO]);

        return $response;
    }

    static function VerificaAsignacion($id){
        $query = DB::table('tram_mdv_usuariotramite_analista')->where('USTR_NIDUSUARIOTRAMITE', $id)->where('USUA_NIDUSUARIO', '>', 0)->first();
        return is_null($query) ? 0: 1;
    }
}
