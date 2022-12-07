<?php

namespace App\Services;
use App\Cls_Bitacora;
use Exception;


class BitacoraService {

    /**
     * Crea el registro en DB
     * @param object $data
     * @return array
     */
    public function store(object $data){
        $response   = ["status" => 200, "item" => []];
        
        $ObjBitacora = new Cls_Bitacora();
        $ObjBitacora->BITA_NIDUSUARIO	= $data->USUA_NIDUSUARIO;
        $ObjBitacora->BITA_CMOVIMIENTO 	= "Acceso fallido";
        $ObjBitacora->BITA_CTABLA 		= "tram_mst_usuario";
        $ObjBitacora->BITA_CIP 			= $data->ip();
        $ObjBitacora->BITA_FECHAMOVIMIENTO = now();
        $ObjBitacora->save();
        return $response;
    }
   
}