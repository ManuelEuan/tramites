<?php 

namespace App\Services;

use stdClass;
use Exception;
use App\Models\Cls_DiasCitaTramite;
use App\Models\Cls_Citas_Calendario;

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

    /**
     * Actualiza la cita realizada
     * @param Object $data
     * @return array
     */
    public function update(object $data){
        $response = ["status" => true, "user" => null, "error" => null];

        $cita = Cls_Citas_Calendario::where('idcitas_tramites_calendario', $data->cita_Id)->first();

        try {
            $cita->CITA_IDUSUARIO   = $cita->CITA_IDUSUARIO;
            $cita->CITA_FECHA       = $data->fecha;
            $cita->CITA_HORA        = $data->hora;
            $cita->CITA_IDTRAMITE   = $cita->CITA_IDTRAMITE;
            $cita->CITA_IDMODULO    = $cita->CITA_IDMODULO;
            $cita->CITA_CONFIRMADO  = $cita->CITA_CONFIRMADO;
            $cita->save();
            $response['item'] = $cita;
        } catch (Exception $ex) {
            throw $ex;
        }
        return $response;
    }

    /**
     * Retorna los horarios disponibles de una fecha especifica
     * @param int $tramite_id
     * @param int $tramite_id
     * @param int $tramite_id
     * @return array
     */
    public function disponibilidad(int $tramite_id, int $modulo_id, $fecha){
        $fechaFF    = strtotime(date($fecha));
        $dia        = date("N", $fechaFF);
        $disponible = array();

        switch ($dia) {
            case '1': $dia = "Lunes";   break;
            case '2': $dia = "Martes";  break;
            case '3': $dia = "Miercoles"; break;
            case '4': $dia = "Jueves";  break;
            case '5': $dia = "Viernes"; break;
            case '6': $dia = "Sabado";  break;
            case '7': $dia = "Domingo"; break;
        }

        $citas  = Cls_DiasCitaTramite::where([
                    'tramiteId' => $tramite_id,
                    'moduloId'  => $modulo_id,
                    'dia'       =>  $dia
                ])->get();

        foreach ($citas as  $cita) {
            $ocupados = Cls_Citas_Calendario::where([
                        'CITA_IDTRAMITE'    => $tramite_id,
                        'CITA_IDMODULO'     => $modulo_id,
                        'CITA_FECHA'        => $fecha
                    ])->get();

            for($j=strtotime($cita->horarioInicial); $j<=strtotime($cita->horarioFinal); $j+=($cita->tiempoAtencion * 60)){
                $hora       = date("H:i:s", $j);
                $ocupado    = false;

                foreach ($ocupados as $item) {
                    if ($item->CITA_HORA == $hora){
                        //Valido cuantos estan ocupados por ventanilla
                        $numero = Cls_Citas_Calendario::where([
                                    'CITA_IDTRAMITE'    => $tramite_id,
                                    'CITA_IDMODULO'     => $modulo_id,
                                    'CITA_FECHA'        => $fecha,
                                    'CITA_HORA'         => $hora
                                ])->count();
                        
                        $ocupado = $numero >= $cita->ventanillas ? true : false;
                    }
                }

                array_push($disponible,array(
                    'horario' => $hora,
                    'ocupado' => $ocupado
                ));
            }
        }

        return $disponible;
    }
}
