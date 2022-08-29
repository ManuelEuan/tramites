<?php 

namespace App\Services;

use stdClass;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Models\Cls_DiasCitaTramite;

class CitasService {

     /**
     * Elimina las anteriores y genera los dias permitidos para las citas del tramite
     * @param int $tramiteId
     * @param array $data
     * @return array
     */
    public function create(int $tramiteId, array $data){
        $response   = ["status" => 200, "items" => []];
        
        Cls_DiasCitaTramite::where('tramiteId', $tramiteId)->delete();
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

    /**
     * Retorna la colecion de dias para citas del tramite
     * @param int tramiteId
     * @return collection
     */
    public function getCitas(int $tramiteId){
        $response   = array();
        $citas      = Cls_DiasCitaTramite::where('tramiteId', $tramiteId)->get();
        
        foreach($citas as $cita){
            $inicioFF   = date( 'h:i a', strtotime($cita->horarioInicial));
            $finalFF    = date( 'h:i a', strtotime($cita->horarioFinal));

            $item = new stdClass();
            $item->dia          = $cita->dia;
            $item->inicio       = $inicioFF;
            $item->final        = $finalFF;
            $item->capacidad    = $cita->capacidad;
            $item->moduloId     = $cita->moduloId;
            $item->inicioSF     = $cita->horarioInicial;
            $item->finalSF      = $cita->horarioFinal;
            $item->tiempo       = $cita->tiempoAtencion;
            $item->ventanillas  = $cita->ventanillas;
            array_push($response,$item);
        }
      
        return $response;
    }
}
