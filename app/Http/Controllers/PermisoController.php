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
        $result = Cls_Permiso::find($id);
        return Response()->json($result);
    }

    public function agregar(Request $request){
        $response = ['codigo' => 200, 'status' => "success", 'message' => 'Los datos se han guardado correctamente.'];
        try {
            $permiso = new Cls_Permiso();
            $permiso->PERMI_CNOMBRE         = $request->StrNommbre;
            $permiso->PERMI_CDESCRIPCION    = $request->StrDescripcion;
            $permiso->PERMI_CICONO          = $request->StrIcono;
            $permiso->PERMI_CRUTA           = $request->StrRuta;
            $permiso->PERMI_NIDCATEGORIA_PERMISO = $request->IntCategoria;
            $permiso->save();
            $respoonse['item'] = $permiso;
        }
        catch(Exception $e) {
            $response = [
                'codigo' => 400, 
                'status' => "error", 
                'message' => "Ocurrió una excepción, favor de contactar al administrador del sistema , " .$e->getMessage()
            ];
        }
        return Response()->json($response);
    }

    public function modificar(Request $request){
        $response = ['codigo' => 200, 'status' => "success", 'message' => 'Los datos se han guardado correctamente.'];
        try {
            $permiso = Cls_Permiso::find($request->IntId);
            $permiso->PERMI_CNOMBRE         = $request->StrNommbre;
            $permiso->PERMI_CDESCRIPCION    = $request->StrDescripcion;
            $permiso->PERMI_CICONO          = $request->StrIcono;
            $permiso->PERMI_CRUTA           = $request->StrRuta;
            $permiso->PERMI_NIDCATEGORIA_PERMISO = $request->IntCategoria;
            $permiso->save();
        }
        catch(Exception $e) {
            $response = [
                'codigo' => 400, 
                'status' => "error", 
                'message' => "Ocurrió una excepción, favor de contactar al administrador del sistema " .$e->getMessage()
            ];
        }
        return Response()->json($response);
    }

    public function eliminar(Request $request){
        $response = ['codigo' => 200, 'status' => "success", 'message' => 'Los datos se han guardado correctamente.'];
        try {
            Cls_Permiso::find($request->IntId)->delete();
        }
        catch(Exception $e) {
            $response = [
                'codigo' => 400, 
                'status' => "error", 
                'message' => "Ocurrió una excepción, favor de contactar al administrador del sistema " .$e->getMessage()
            ];
        }
        return Response()->json($response);
    }
}
