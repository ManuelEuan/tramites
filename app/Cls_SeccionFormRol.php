<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class Cls_SeccionFormRol extends Model
{
    protected $connection = 'mysql';
    protected $table = 'Seccionform_rol';

    
    static function AsignarSecRol(Request $request){//Request $request
        try {
            $verifica = DB::select('select * from Seccionform_rol where FORM_NID = ? and ROL_NIDROL = ?', [$request->FORM_NID, $request->ROL_NIDROL]);
        
            if(count($verifica) > 0){
                //ya registrado
            }else{
                DB::insert('insert into Seccionform_rol (FORM_NID, ROL_NIDROL, USUA_NIDUSUARIOREGISTRO) values (?, ?, ?)',
                    [
                        $request->FORM_NID,
                        $request->ROL_NIDROL,
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

    static function SeccionRoles($FORM_NID){//Request $request
        $response = DB::select('select * from Seccionform_rol where FORM_NID = ?', [$FORM_NID]);

        return $response;
    }

    

    

    

    
}
