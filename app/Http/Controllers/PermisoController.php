<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cls_Permiso;
use Exception;

class PermisoController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        return view('CAT_PERMISO.index');
    }
    
    public function consultar(Request $request)
    {
        $result = Cls_Permiso::all();
        $response = [
            'data' => $result,
        ];

        return Response()->json($response);
    }

    public function obtener($id)
    {
        $result = Cls_Permiso::TRAM_SP_OBTENERPERMISO($id)[0];
        return Response()->json($result);
    }

    public function agregar(Request $request){
        $response = [];
        try {
            Cls_Permiso::TRAM_SP_AGREGARPERMISO($request);
        }
        catch(Exception $e) {
            $response = [
                'codigo' => 400, 
                'status' => "error", 
                'message' => "Ocurrió una excepción, favor de contactar al administrador del sistema , " .$e->getMessage()
            ];
        }

        $response = [
            'codigo' => 200, 
            'status' => "success", 
            'message' => 'Los datos se han guardado correctamente.'
        ];

        return Response()->json($response);
    }

    public function modificar(Request $request){
        $response = [];
        try {
            Cls_Permiso::TRAM_SP_MODIFICARPERMISO($request);
        }
        catch(Exception $e) {
            $response = [
                'codigo' => 400, 
                'status' => "error", 
                'message' => "Ocurrió una excepción, favor de contactar al administrador del sistema " .$e->getMessage()
            ];
        }

        $response = [
            'codigo' => 200, 
            'status' => "success", 
            'message' => 'Los datos se han guardado correctamente.'
        ];

        return Response()->json($response);
    }

    public function eliminar(Request $request){
        $response = [];
        try {
            Cls_Permiso::TRAM_SP_ELIMINARPERMISO($request);
        }
        catch(Exception $e) {
            $response = [
                'codigo' => 400, 
                'status' => "error", 
                'message' => "Ocurrió una excepción, favor de contactar al administrador del sistema " .$e->getMessage()
            ];
        }

        $response = [
            'codigo' => 200, 
            'status' => "success", 
            'message' => 'Los datos se han eliminado.'
        ];

        return Response()->json($response);
    }
}
