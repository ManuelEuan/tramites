<?php

namespace App\Http\Controllers;

use Exception;
use App\Services\BancosService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\GeneralValidator;

class BancosController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->validator    = new GeneralValidator();
        $this->bancoService  = new BancosService();     
    }

    /**
     * Retorna la vista principal de giros
     * @return View
     */
    public function index() {
        return view('CAT_BANCOS.index');
    }

    /**
     * Crea un registros en la db
     * @param Request  $request
     * @return Response
     */
    public function store(Request $request){
        $statusCode = 200;
        
        try {
            $validacion = $this->validator->bancos($request, 'add');
            if($validacion !== true)
                return response()->json(['error' => $validacion->original], 403);

            $result = $this->bancoService->store((object)$request->all());
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
            $validacion = $this->validator->bancos($request, 'update');
            if($validacion !== true)
                return response()->json(['error' => $validacion->original], 403);

            $result = $this->bancoService->update((object)$request->all());
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
            $validacion = $this->validator->bancoEstatus($request);
            if($validacion !== true)
                return response()->json(['error' => $validacion->original], 403);

            $result = $this->bancoService->cambiaEstatus($request->id);
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
        $item = $this->bancoService->getBancoById($id);
        return response()->json($item, 200);
    }

    /**
     * Retorna un json de los registros en base a lo solicitado
     * @param Request $request
     * @return Response
     */
    public function find(Request $request){
        $query = DB::table('tram_cat_bancos');

        if(!is_null($request->clave))
            $query->where('clave', $request->clave);
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
        if(!is_null($request->paginate) && $request->paginate == "true") {
            $items = $query->paginate($itemsShow);
            return response()->json($items, 200);
        }

        return response()->json(["data" => $query->get()], 200);
    }
}
