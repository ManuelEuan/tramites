<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Services\GiroService;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\GeneralValidator;

class GiroController extends Controller
{

    public function __construct() {
        $this->validator    = new GeneralValidator();
        $this->giroService  = new GiroService();     
    }

    /**
     * Crea un registros en la db
     * @param Request  $request
     * @return Response
     */
    public function store(Request $request){
        $statusCode = 200;
        
        try {
            $validacion = $this->validator->giros($request, 'add');
            if($validacion !== true)
                return response()->json(['error' => $validacion->original], 403);

            $result = $this->giroService->store((object)$request->all());
        } catch (Exception $ex) {
            $statusCode = 403;
            $result     = ['error' => $ex->getMessage()];
        }

        return response()->json($result, $statusCode);
    }

    /**
     * Actualiza un registros en la db
     * @param Request  $request
     * @return Response
     */
    public function update(Request $request){
        $statusCode = 200;
        
        try {
            $validacion = $this->validator->giros($request, 'update');
            if($validacion !== true)
                return response()->json(['error' => $validacion->original], 403);

            $result = $this->giroService->update((object)$request->all());
        } catch (Exception $ex) {
            $statusCode = 403;
            $result     = ['error' => $ex->getMessage()];
        }

        return response()->json($result, $statusCode);
    }

    /**
     * Cambia el estatus de activo a inactivo e inversamente
     * @param Request  $request
     * @return Response
     */
    public function cambiaEstatus(Request $request){
        $statusCode = 200;
        
        try {
            $validacion = $this->validator->giroEstatus($request);
            if($validacion !== true)
                return response()->json(['error' => $validacion->original], 403);

            $result = $this->giroService->cambiaEstatus($request->id);
        } catch (Exception $ex) {
            $statusCode = 403;
            $result     = ['error' => $ex->getMessage()];
        }

        return response()->json($result, $statusCode);
    }

    /**
     * Retorna el giro en base a su id.
     * @param int $id
     * @return Response
     */
    public function get($id) {
        $item = $this->giroService->getGiroById($id);
        return response()->json($item, 200);
    }

    /**
     * Retorna un json de los registros en base a lo solicitado
     * @param Request $request
     * @return Response
     */
    public function find(Request $request){
        $query = DB::table('tram_cat_giros')->where("activo", true);

        if(!is_null($request->clave))
            $query->where('clave', $request->clave);
        if(!is_null($request->nombre))
            $query->where('nombre', 'like','%'.$request->nombre.'%');
        if(!is_null($request->descripcion))
                $query->where('descripcion', 'like','%'.$request->descripcion.'%');


        ############ Orden y paginacion ############
        $order      = !is_null($request->order) ? $request->order : "desc";
        $orderBy    = !is_null($request->orderBy) ? $request->orderBy : "id";
        $itemsShow  = !is_null($request->itemsShow) ? $request->itemsShow : 10;

        $query->orderBy("id", $order);
        if(!is_null($request->paginate) || $request->paginate == true) {
            $items = $query->paginate($itemsShow);
            return response()->json($items, 200);
        }

        return response()->json(["data" => $query->get()], 200);
    }
}
