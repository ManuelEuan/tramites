<?php

namespace App\Services;
use DateTime;
use Exception;
use App\Cls_Bitacora;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


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
   
    /**
     * Retorna la lista de los registros en DB
     * @param object $data
     */
    public function find(object $data) {
        $usuario    = Auth::user();   
        $rol        = $usuario->TRAM_CAT_ROL;
        $query      = DB::table('tram_his_bitacora as a')
                            ->join('tram_mst_usuario as b', 'b.USUA_NIDUSUARIO', '=', 'a.BITA_NIDUSUARIO')
                            ->select('a.*', 'b.USUA_CNOMBRES', 'b.USUA_CPRIMER_APELLIDO','b.USUA_CSEGUNDO_APELLIDO');

        if($rol->ROL_CCLAVE != 'ADM'){
            $query->where('a.BITA_NIDUSUARIO', $usuario->USUA_NIDUSUARIO);
        }

        if(isset($data->search['value']) && !is_null($data->search['value']) && $data->search['value'] != ''){
            $palabra = $data->search['value'];
            $query->where(function ($query) use ($palabra) {
                $query->orWhere("b.USUA_CNOMBRES", "like","%".$palabra."%")
                        ->orWhere("b.USUA_CPRIMER_APELLIDO", "ilike","%".$palabra."%")
                        ->orWhere("b.USUA_CSEGUNDO_APELLIDO", "ilike","%".$palabra."%")
                        ->orWhere("a.BITA_CMOVIMIENTO", "ilike","%".$palabra."%")
                        ->orWhere("a.BITA_CTABLA", "ilike","%".$palabra."%")
                        ->orWhere("a.BITA_FECHAMOVIMIENTO", "ilike","%".$palabra."%");
            });
        }
            
        $order      = isset($data->order[0]['dir']) ? $data->order[0]['dir'] : 'desc';
        $orderBy    = $data->columns[$data->order[0]['column']]['data'];
        $orderBy    = $orderBy == 'BITA_HORAMOVIMIENTO' ? 'BITA_FECHAMOVIMIENTO' : $orderBy;
        $show       = isset($data->length) ? $data->length : 10;
        $show       = $show == -1 ? 1000000 : $show;
        $start      = !is_null($data->start) ? $data->start : 0;
        $conteo     = $query;
        $total      = $conteo->count();
        $resultado  = $query->orderBy($orderBy, $order)->offset($start)->limit($show)->get();

        foreach($resultado as $item){
            $creacion   = new DateTime($item->BITA_FECHAMOVIMIENTO);
            $item->BITA_FECHAMOVIMIENTO = $creacion->format('d-m-Y');
            $item->BITA_HORAMOVIMIENTO  = $creacion->format('g:i a');
            $item->BITA_USUARIO         = $item->USUA_CNOMBRES. " ".$item->USUA_CPRIMER_APELLIDO. " ".$item->USUA_CSEGUNDO_APELLIDO;
        }

        return [ "data" => $resultado, "total" =>  $total];
    }
}