<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class Cls_SeccionFormRol extends Model
{
    protected $connection = 'mysql';
    protected $table = 'Seccionform_rol';

    
    static function AsignarSecRol($FORM_NID ,$ROL_NIDROL, $USUA_NIDUSUARIOREGISTRO){//Request $request
        try {
            $verifica = DB::select('select * from Seccionform_rol where FORM_NID = ? and ROL_NIDROL = ?', [$FORM_NID, $ROL_NIDROL]);
        
            if(count($verifica) > 0){
                //ya registrado
            }else{
                DB::insert('insert into Seccionform_rol (FORM_NID, ROL_NIDROL, USUA_NIDUSUARIOREGISTRO) values (?, ?, ?)',
                    [
                        $FORM_NID,
                        $ROL_NIDROL,
                        $USUA_NIDUSUARIOREGISTRO
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
    static function dependencia_asigna_area($FORM_NID ,$ID_AREA, $ID_DEPENDENCIA){//Request $request
        try {
            $verifica = DB::select('select * from areapordependencia where NID_FORM = ? and NID_AREA_ADMINISTRATIVA = ?', [$FORM_NID, $ID_AREA]);
        
            if(count($verifica) > 0){
                //ya registrado
            }else{
                DB::insert('insert into areapordependencia (NID_FORM, NID_AREA_ADMINISTRATIVA, NID_DEPENDENCIA) values (?, ?, ?)',
                    [
                        $FORM_NID,
                        $ID_AREA,
                        $ID_DEPENDENCIA
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
    static function AsignarDependencia($FORM_NID ,$FORM_NIDDEPENDENCIA, $USUA_NIDUSUARIOREGISTRO){//Request $request
        try {
            $verifica = DB::select('select * from dependenciaform where FORM_NID = ? and FORM_NIDDEPENDENCIA = ?', [$FORM_NID, $FORM_NIDDEPENDENCIA]);
        
            if(count($verifica) > 0){
                //ya registrado
            }else{
                DB::insert('insert into dependenciaform (FORM_NID, FORM_NIDDEPENDENCIA, USUA_NIDUSUARIOREGISTRO) values (?, ?, ?)',
                    [
                        $FORM_NID,
                        $FORM_NIDDEPENDENCIA,
                        $USUA_NIDUSUARIOREGISTRO
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

    static function SeccionRoles($FORM_NID){//Request $request
        $response = DB::select('select * from Seccionform_rol where FORM_NID = ?', [$FORM_NID]);

        return $response;
    }
    static function areasXDependencia($FORM_NID){//Request $request
        $response = DB::select('select * from areaPorDependencia where NID_FORM = ?', [$FORM_NID]);

        return $response;
    }
    static function dependenciaForm($FORM_NID){//Request $request
        $response = DB::select('select * from dependenciaform where FORM_NID = ?', [$FORM_NID]);

        return $response;
    }

    

    

    

    
}
