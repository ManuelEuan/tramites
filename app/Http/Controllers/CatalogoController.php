<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CatalogoService;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\GeneralValidator;

class CatalogoController extends Controller
{
    public function __construct() {
        /* $this->middleware('auth'); */
        $this->validator        = new GeneralValidator();
        $this->catalogoService  = new CatalogoService();
    }

    /**
     * Retorna el giro en base a su id.
     * @param int $id
     * @return Response
     */
    public function get($id) {
        $item = $this->catalogoService->getCatalogoById($id);
        return response()->json($item, 200);
    }

    /**
     * Retorna un json de los registros en base a lo solicitado
     * @param Request $request
     * @return Response
     */
    public function find(Request $request){
        $query = DB::table('catalogos');

        if(!is_null($request->nombre))
            $query->where('nombre', 'ilike','%'.$request->nombre.'%');
        if(!is_null($request->descripcion))
            $query->where('descripcion', 'ilike','%'.$request->descripcion.'%');
        if(!is_null($request->activo)){
            $activo = $request->activo === 'true'? true: false;
            $query->where("activo","=", $activo);
        }

        ############ Orden y paginacion ############
        $order      = !is_null($request->order)     ? $request->order : "desc";
        $order_by    = !is_null($request->order_by)  ? $request->order_by : "id";
        $itemsShow  = !is_null($request->items_to_show) ? $request->items_to_show : 10;

        $query->orderBy($order_by, $order);
        if(!is_null($request->paginate) && $request->paginate == 'true') {
            $items = $query->paginate($itemsShow);
            return response()->json($items, 200);
        }

        return response()->json(["data" => $query->get()], 200);
    }
}
