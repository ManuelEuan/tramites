<?php 

namespace App\Services;

use Exception;
use App\Models\Cls_Giro;

class GiroService {

     /**
     * Crea el registro en DB
     * @param object $data
     * @return Cls_Giro
     */
    public function store(object $data){
        $response   = ["status" => 200, "items" => []];
        
        $anterior = Cls_Giro::where(['clave', $data->clave])->first();
        if(!is_null($anterior))
            throw new Exception("La clave ya existe, intentar con otra");

        foreach ($data as $key => $value) {
            try {
                $item = new Cls_DiasCitaTramite();
                $item->tramiteId        = $tramiteId;
                $item->moduloId         = $value['moduloId'];
                $item->dia              = $value['dia'];
                $item->horarioInicial   = $value['inicioSF'];
                $item->horarioFinal     = $value['finalSF'];
                $item->ventanillas      = $value['ventanillas'];
                $item->capacidad        = $value['capacidad'];
                $item->tiempoAtencion   = $value['tiempo'];
                $item->save();
                array_push($response['items'],$item);
            } catch (Exception $ex) {dd($ex);
                throw $ex;
            }
        }

        return $response;
    }

}
