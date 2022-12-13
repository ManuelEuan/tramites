<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Cls_PermisoRol;
use App\Cls_Rol;
use Exception;

class RolController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(Request $request){
        return view('CAT_ROL.index');
    }
    
    public function consultar(Request $request) {
        $response = [
            'data' => Cls_Rol::all()
        ];

        return Response()->json($response);
    }
    
    public function obtener($id) {
        $result = Cls_Rol::find($id);
        return Response()->json($result);
    }

    public function agregar(Request $request){
        $response = [];
        try {
            $IntRolId = Cls_Rol::TRAM_SP_AGREGARROL($request);
            
            //Eliminar permisos
            Cls_PermisoRol::TRAM_SP_ELIMINARPERMISOROL($IntRolId);

            //Agregar permisos
            foreach ($request->dLstPermisos as $value) {
                Cls_PermisoRol::TRAM_SP_AGREGARPERMISOROL($value, $IntRolId);
            }
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
            Cls_Rol::TRAM_SP_MODIFICARROL($request);

            //Eliminar permisos
            Cls_PermisoRol::TRAM_SP_ELIMINARPERMISOROL($request->IntId);

            //Agregar permisos
            foreach ($request->dLstPermisos as $value) {
                Cls_PermisoRol::TRAM_SP_AGREGARPERMISOROL($value, $request->IntId);
            }
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
            //Eliminar permisos
            Cls_PermisoRol::TRAM_SP_ELIMINARPERMISOROL($request->IntId);
            
            Cls_Rol::TRAM_SP_ELIMINARROL($request);
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
