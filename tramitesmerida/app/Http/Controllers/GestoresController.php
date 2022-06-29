<?php

namespace App\Http\Controllers;

use DateTime;
use Exception;
use App\Cls_Bitacora;
use Illuminate\Http\Request;
use App\Models\Cls_Notificacion;
use Illuminate\Support\Facades\DB;
use App\Events\NotificacionGestores;
use Illuminate\Support\Facades\Mail;

class GestoresController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        return view('GESTOR.index');
    }

    public function find(Request $request){
        $items = [];
        $order = 'desc';
        $order_by = 'GES_NID';
        $resultados = 10;
       
        //Comienza el Query
        $query = DB::table('tram_mdv_gestores as g')
                    ->join('tram_mst_usuario as u', 'g.GES_NGESTORID', '=', 'u.USUA_NIDUSUARIO')
                    ->select('u.USUA_CRFC', 'u.USUA_CCURP', 'g.*');
        
        if(!is_null($request->usuario_id) && $request->usuario_id != "")
            $query->where('GES_NUSUARIOID',$request->usuario_id);
        
        //Parametros de paginacion y orden
        if(!is_null($request->order))
            $order = $request->order;
        
        if(!is_null($request->order_by))
            $order_by = $request->order_by;
        
        $query->orderBy($order_by, $order);
        if(!is_null($request->items_to_show))
            $resultados = $request->items_to_show;
            
        return response()->json($query->paginate($resultados), 200);
    }

    public function usuarios(Request $request){
        $items = [];
        $order = 'desc';
        $order_by = 'USUA_NIDUSUARIO';
        $resultados = 10;

        if(!is_null(!$request->txtBuscar) && $request->txtBuscar == "")
            return response()->json(["data" => $items], 200);

        //Comienza el Query
        $query = DB::table('tram_mst_usuario')
                    ->select('USUA_NIDUSUARIO','USUA_CNOMBRES', 'USUA_CPRIMER_APELLIDO', 'USUA_CSEGUNDO_APELLIDO', 'USUA_CRFC', 'USUA_CCURP', 'USUA_CCORREO_ELECTRONICO', 'USUA_NTIPO_PERSONA')
                    ->where('USUA_NTIPO_PERSONA', 'FISICA')
                    ->where('USUA_CRFC','like','%'.$request->txtBuscar.'%')
                    ->orWhere('USUA_CCURP','like','%'.$request->txtBuscar.'%');
        
        //Parametros de paginacion y orden
        if(!is_null($request->order))
            $order = $request->order;
        
        if(!is_null($request->order_by))
            $order_by = $request->order_by;
        
        $query->orderBy($order_by, $order);
        if(!is_null($request->items_to_show))
            $resultados = $request->items_to_show;
            
        return response()->json($query->paginate($resultados), 200);
    }

    public function delete(Request $request){
        try {
            DB::table('tram_mdv_gestores')->where('GES_NID',$request->id)->delete();
            return response()->json(['message'=> 'Operación exitosa'], 200);
        } catch (Exception $ex) {
            return response()->json(['message'=> $ex->errorInfo[2]], 403);
        }   
    }

    public function vincular(Request $request){
        try {
            DB::table('tram_mdv_gestores')->insert([
                'GES_NUSUARIOID'    => $request->usuario_id,
                'GES_NGESTORID'     => $request->gestor_id,
            ]);
            $usuario = DB::table('tram_mst_usuario')->where('USUA_NIDUSUARIO', $request->usuario_id)->get();
            $nombre = '';
            if(sizeof($usuario) > 0)
                $nombre = $usuario[0]->USUA_CNOMBRES.' '.$usuario[0]->USUA_CPRIMER_APELLIDO;

            try {
                $ObjBitacora = new Cls_Bitacora();
				$ObjBitacora->BITA_NIDUSUARIO   = $request->usuario_id;
				$ObjBitacora->BITA_CMOVIMIENTO  = "Vinculacion gestor";
				$ObjBitacora->BITA_CTABLA       = "tram_mdv_gestores";
                $ObjBitacora->BITA_CIP          = $request->ip();
                Cls_Bitacora::TRAM_SP_AGREGARBITACORA($ObjBitacora);
                
                $objNotificacion    = new Cls_Notificacion();
                $objNotificacion->NOTI_NIDREMITENTE = $request->usuario_id;
                $objNotificacion->NOTI_NIDRECEPTOR  = $request->gestor_id;
                $objNotificacion->NOTI_CTITULO      = 'Vinculacion gestor';
                $objNotificacion->NOTI_CMENSAJE     = $nombre.' te agregó como gestor de su cuenta.';
                $objNotificacion->NOTI_NLEIDO       = false;
                $objNotificacion->NOTI_CTIPO        = 'GESTOR';
                $objNotificacion->NOTI_DFECHACREAACION = new DateTime('now');
                $objNotificacion->save(); 
                
                event(new NotificacionGestores($request->gestor_id));
            } catch (Exception $ex) {
                throw $ex;
            }
            return response()->json(['message'=> 'Operación exitosa'], 200);
        } catch (Exception $ex) {
            return response()->json(['message'=> $ex->errorInfo[2]], 403);
        }
    }

    public function respuesta(Request $request){
        $response = array('message' => 'Error');
        $codigo = 403;

        try {
            $objNotificacion = Cls_Notificacion::find($request->id);
            if(!is_null($objNotificacion)){
                $objNotificacion->NOTI_NLEIDO = true;
                $objNotificacion->save();

                if($request->respuesta == "Rechazado"){
                    DB::table('tram_mdv_gestores')->where([
                        'GES_NUSUARIOID' => $objNotificacion->NOTI_NIDREMITENTE,
                        'GES_NGESTORID'  =>  $objNotificacion->NOTI_NIDRECEPTOR
                    ])->delete();
                }
                else{
                    $gestor = DB::table('tram_mdv_gestores')
                        ->where('GES_NUSUARIOID', $objNotificacion->NOTI_NIDREMITENTE)
                        ->where('GES_NGESTORID', $objNotificacion->NOTI_NIDRECEPTOR)
                        ->update(['GES_CESTATUS' => $request->respuesta]);
                }    
            }

            $response["message"] = "Operacion Exitosa";
            $codigo = 200;
        } catch (Exception $ex) {
            $response["message"] = $ex->errorInfo[2];
        }
        
        return response()->json($response, $codigo);
    }
}
