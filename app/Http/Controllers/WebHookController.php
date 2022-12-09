<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CatalogoService;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\GeneralValidator;
use App\Models\Cls_WebhookPagosLog;
use Exception;

class WebHookController extends Controller
{
    public function __construct()
    {
        /* $this->middleware('auth'); */
    }

    /**
     * Retorna un json con la respuesta de web hook
     * @param Request $request
     * @return Response
     */
    public function PagoEstatus(Request $request)
    {

        try {

            $registro = new Cls_WebhookPagosLog();
            $registro->contrato = $request["contrato"];
            $registro->tramite = $request["tramite"];
            $registro->monto = $request["monto"];
            $registro->estatus = $request["estatus"];

            $registro->save();


            return response()->json(["success" => "1", "msg" => ""], 200);
        } catch (Exception $ex) {
            return response()->json(["success" => "0", "msg" => $ex->getMessage()], 200);
        }
    }
}
