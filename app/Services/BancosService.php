<?php

namespace App\Services;

use Exception;
use App\Cls_Bancos;

class BancosService {

    /**
     * Crea el registro en DB
     * @param object $data
     * @return array
     */
    public function store(object $data){
        $response   = ["status" => 200, "item" => []];
        
        $data->clave= strtoupper($data->clave);
        $anterior   = Cls_Bancos::where(['clave' => $data->clave, 'activo' => true])->first();
        if(!is_null($anterior))
            throw new Exception("La clave ya existe, intentar con otra");

        $response['item'] = Cls_Bancos::create((array)$data); 
        return $response;
    }
    
    /**
     * Crea actualiza el registro en DB
     * @param object $data
     * @return array
     */
    public function update(object $data){
        $response   = ["status" => 200, "item" => []];
        
        $data->clave= strtoupper($data->clave);
        $anterior = Cls_Bancos::where(['clave' => $data->clave, 'activo' => true])->where('id', '!=', $data->id)->first();
        if(!is_null($anterior))
            throw new Exception("La clave ya existe, intentar con otra");

            Cls_Bancos::find($data->id)->update((array) $data);
        $response['item'] = Cls_Bancos::find($data->id);

        return $response;
    }

    /**
     * Invierte el estatus del registro
     * @param int $giroID
     * @return array
     */
    public function cambiaEstatus(int $giroId){
        $response   = ["status" => 200, "item" => "Operación exitosa"];
        $item       = Cls_Bancos::find($giroId);

        if(is_null($item))
            throw new Exception("La clave ya existe, intentar con otra");

        $item->activo = !$item->activo;
        $item->save();
        return $response;
    }

    /**
     * Retorna el banco en base a su id.
     *
     * @param int $id
     * @return Cls_Bancos
     */
    public function getBancoById($id) {
        return Cls_Bancos::find($id);
    }
}