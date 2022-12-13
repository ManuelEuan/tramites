<?php

namespace App\Http\Controllers;
use Exception;
use App\Cls_Rol;
use App\Cls_PermisoRol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $response = ['codigo' => 200, 'status' => "success", 'message' => 'Los datos se han guardado correctamente.'];
        
        try {
            DB::beginTransaction();
            $rol = new Cls_Rol();
            $rol->ROL_CNOMBRE       = $request->StrNommbre;
            $rol->ROL_CDESCRIPCION  = $request->StrDescripcion;
            $rol->ROL_CCLAVE       =  strtoupper(substr($request->StrNommbre, 0, 3));
            $rol->save();

            foreach ($request->dLstPermisos as $value) {
                $item = new Cls_PermisoRol();
                $item->PROL_NIDPERMISO  = $value;
                $item->PROL_NIDROL      = $rol->ROL_NIDROL;
                $item->save();
            }
            DB::commit();
        }
        catch(Exception $e) {
            DB::rollBack();
            $response = [
                'codigo'    => 400, 
                'status'    => "error", 
                'message'   => "Ocurrió una excepción, favor de contactar al administrador del sistema , " .$e->getMessage()
            ];
        }

        return Response()->json($response);
    }

    public function modificar(Request $request){
        $response = ['codigo' => 200, 'status' => "success", 'message' => 'Los datos se han guardado correctamente.'];

        try {
            DB::beginTransaction();
            $rol = Cls_Rol::find($request->IntId);
            $rol->ROL_CNOMBRE      = $request->StrNommbre;
            $rol->ROL_CDESCRIPCION =  $request->StrDescripcion;
            $rol->save();
            
            Cls_PermisoRol::where('PROL_NIDROL',$request->IntId)->delete();
            foreach ($request->dLstPermisos as $value) {
                $item = new Cls_PermisoRol();
                $item->PROL_NIDPERMISO  = $value;
                $item->PROL_NIDROL      = $rol->ROL_NIDROL;
                $item->save();

            }
            DB::commit();
        }
        catch(Exception $e) {
            DB::rollBack();
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
            Cls_PermisoRol::where('PROL_NIDROL',$request->IntId)->delete();
            Cls_Rol::find($request->IntId)->delete();
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
