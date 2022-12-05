<?php 

namespace App\Services;

use Exception;
use App\Models\Cls_Catalogo;
use Illuminate\Support\Facades\DB;

class CatalogoService {

    /**
     * Crea el registro en DB
     * @param object $data
     * @return array
     */
    public function store(object $data){
        $response   = ["status" => 200, "item" => []];
        
       /*  $data->clave= strtoupper($data->clave);
        $anterior   = Cls_Giro::where(['clave' => $data->clave, 'activo' => true])->first();
        if(!is_null($anterior))
            throw new Exception("La clave ya existe, intentar con otra");

        $response['item'] = Cls_Giro::create((array)$data);  */
        return $response;
    }

    /**
     * Crea el registro en DB
     * @param object $data
     * @return array
     */
    public function update(object $data){
        $response   = ["status" => 200, "item" => []];
        
        /* $data->clave= strtoupper($data->clave);
        $anterior = Cls_Giro::where(['clave' => $data->clave, 'activo' => true])->where('id', '!=', $data->id)->first();
        if(!is_null($anterior))
            throw new Exception("La clave ya existe, intentar con otra");

        Cls_Giro::find($data->id)->update((array) $data);
        $response['item'] = Cls_Giro::find($data->id); */

        return $response;
    }

    /**
     * Invierte el estatus del registro
     * @param int $giroID
     * @return array
     */
    public function cambiaEstatus(int $giroId){
        $response   = ["status" => 200, "item" => "Operación exitosa"];
       /*  $item       = Cls_Giro::find($giroId);

        if(is_null($item))
            throw new Exception("La clave ya existe, intentar con otra");

        $item->activo = !$item->activo;
        $item->save(); */
        return $response;
    }

    /**
     * Retorna el catalogo en base a su id.
     *
     * @param int $id
     * @return Cls_Catalogo
     */
    public function getCatalogoById($id) {
        return Cls_Catalogo::find($id);
    }

    /**
     * retorna el registro de retys en base a la tabla que se indique
     * @param String $tabla
     * @param Sting $match
     * @param String $uuid
     * @return Object
     */
    public function getCondition($tabla, $match, $uuid){
        return DB::connection('remtys')->table($tabla)->where($match, $uuid)->get();
    }

    /**
     * retorna los registros de retys en base a la tabla que se indique
     * @param String $tabla
     * @return Object
     */
    public function get($tabla){
        return DB::connection('remtys')->table($tabla)->get();
    }
}
