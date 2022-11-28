<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Cls_PersonaFisicaMoral;
use App\Models\Cls_UsuarioTramiteAnalista;

class PersonaController extends Controller
{
    protected $correo;
    public function __construct(){
       $this->middleware('auth');
    }

    public function index(){
        return view('TRAM_PERSONA_FISICA_MORAL.index');
    }

    public function find(Request $request){
        $items      = [];
        $order      = 'desc';
        $order_by   = 'USUA_NIDUSUARIO';
        $resultados = 10;
        $array      = [];
        $page = 1;
        $draw = $request->get('draw');
        $start = $request->get("start");

        if($request->start != 0)
            $page =  $request->length/ $request->start;

        $request->merge(['page' => $page]);

        $totalRecords = DB::table('tram_mst_usuario')->where("USUA_NACTIVO", true)->where("USUA_NIDROL", 2)->count();
        

        //Comienza el Query
        $query = DB::table('tram_mst_usuario');
        $totalFiltered = DB::table('tram_mst_usuario');

        if(!is_null($request->nombre) && $request->nombre != ""){
            $query->where('USUA_CNOMBRES','like','%'. $request->nombre .'%');
            $totalFiltered->where('USUA_CNOMBRES','like','%'. $request->nombre .'%');
        }
        if(!is_null($request->paterno) && $request->paterno != ""){
            $query->where('USUA_CPRIMER_APELLIDO','like','%'. $request->paterno .'%');
            $totalFiltered->where('USUA_CPRIMER_APELLIDO','like','%'. $request->paterno .'%');
        }
        if(!is_null($request->materno) && $request->materno != ""){
            $query->where('USUA_CSEGUNDO_APELLIDO','like','%'. $request->materno .'%');
            $totalFiltered->where('USUA_CSEGUNDO_APELLIDO','like','%'. $request->materno .'%');
        }
        if(!is_null($request->rfc) && $request->rfc != ""){
            $query->where('USUA_CRFC','like','%'. $request->rfc .'%');
            $totalFiltered->where('USUA_CRFC','like','%'. $request->rfc .'%');
        }
        if(!is_null($request->curp) && $request->curp != ""){
            $query->where('USUA_CCURP','like','%'. $request->curp .'%');
            $totalFiltered->where('USUA_CCURP','like','%'. $request->curp .'%');
        }
        if(!is_null($request->razon_social) && $request->razon_social != ""){
            $query->where('USUA_CRAZON_SOCIAL','like','%'. $request->razon_social .'%');
            $totalFiltered->where('USUA_CRAZON_SOCIAL','like','%'. $request->razon_social .'%');
        }
        if(!is_null($request->tipo_persona) && $request->tipo_persona != ""){
            $query->where('USUA_NTIPO_PERSONA','like','%'. $request->tipo_persona .'%');
            $totalFiltered->where('USUA_NTIPO_PERSONA','like','%'. $request->tipo_persona .'%');
        }
        if(!is_null($request->correo) && $request->correo != ""){
            $this->correo = $request->correo;
            $query->where(function ($query) {
                $query->where("USUA_CCORREO_ELECTRONICO","like",'%'. $this->correo .'%')
                    ->orWhere("USUA_CCORREO_ALTERNATIVO","like",'%'. $this->correo .'%');
            });

            $totalFiltered->where(function ($query) {
                $totalFiltered->where("USUA_CCORREO_ELECTRONICO","like",'%'. $this->correo .'%')
                    ->orWhere("USUA_CCORREO_ALTERNATIVO","like",'%'. $this->correo .'%');
            });
        }
        if(!is_null($request->activo)){
            $activo = $request->activo === 'true'? true: false;
            $query->where("USUA_NACTIVO", $activo);
            $totalFiltered->where("USUA_NACTIVO", $activo);
        }
        
        $query->where("USUA_NIDROL", 2);
        $totalFiltered->where("USUA_NIDROL", 2);

        $totalFilteredCount = $totalFiltered->count();

        //Parametros de paginacion y orden
        if(!is_null($request->order)){
            $order = $request->order[0]['dir'];
        
            if($request->order[0]['column'] == 0)
                $order_by = "USUA_CNOMBRES";
            elseif($request->order[0]['column'] == 1)
                $order_by = "USUA_CPRIMER_APELLIDO";
            elseif($request->order[0]['column'] == 2)
                $order_by = "USUA_CSEGUNDO_APELLIDO";
            elseif($request->order[0]['column'] == 3)
                $order_by = "USUA_CCURP";
            elseif($request->order[0]['column'] == 4)
                $order_by = "USUA_CRFC";
            elseif($request->order[0]['column'] == 5)
                $order_by = "USUA_CRAZON_SOCIAL";
            elseif($request->order[0]['column'] == 6)
                $order_by = "USUA_NTIPO_PERSONA";
        }
            
        
        $query->orderBy($order_by, $order);
        if(is_null($request->paginate) || $request->paginate == "true" ){
            if(!is_null($request->length)){
                $resultados = $request->length;
                if($request->length == "-1")
                    $resultados = 1000000000;
            }
             
            $items = $query->skip($start)->take($resultados)->get();
        }
        else{
            $items = $query->get();
            return response()->json(["data" => $items], 200);
        }

        $array  = $items;
        $result = [];

        foreach ($array as $value) {
            try {
                if($value->USUA_NTIPO_PERSONA == 'MORAL'){
                    $value->sucursales = DB::table('tram_mdv_sucursal')->where('SUCU_NIDUSUARIO', $value->USUA_NIDUSUARIO)->get();
                }
            } catch (Exception $th) {
                throw new Exception($th->getMessage());
            }
            
            array_push($result, $value);
        }

        
        /*$final      = (object)[          
            "data"              => $result,
            "recordsFiltered"   => $items->total(),
            "recordsTotal"      => $items->total()
        ];*/

        $final      = (object)[          
            "data"              => $result,
            "recordsFiltered"   => $totalFilteredCount,
            "recordsTotal"      => $totalRecords,
            "draw" => intval($draw)
        ];
        
        
        return response()->json($final, 200);
    }

    public function findAnalista(){
        $items      = [];
        $order_by   = 'USUA_CPRIMER_APELLIDO';
        $array      = [];
        
        //Comienza el Query
        $query = DB::table('tram_mst_usuario');
        //$query->where("USUA_NACTIVO", true);
        $query->where("USUA_NIDROL", 9);
        $query->orderBy($order_by, 'asc');

        $items = $query->get();

        return response()->json($items);
    }

    public function findAnalistaArea($area){
        $items      = [];
        $order_by   = 'USUA_CPRIMER_APELLIDO';
        $array      = [];

        //Comienza el Query
        $queryunidad = DB::table('TRAM_AUX_UNIDAD_USUARIO_PERTENECE');
        $queryunidad->where("UNIDUP_NIDUSUARIO", $area);
        $items = $queryunidad->get();
        for($i=0; $i<count($items); $i++){
            $array[] = $items[$i]->UNIDUP_NIDUNIDAD;
        }

        //Comienza el Query
        $query = DB::table('tram_mst_usuario')
        ->join('TRAM_AUX_UNIDAD_USUARIO_PERTENECE as t','t.UNIDUP_NIDUSUARIO','=','tram_mst_usuario.USUA_NIDUSUARIO')
        ->select('*');
        $query->where("USUA_NIDROL", 9);
        $query->whereIn("t.UNIDUP_NIDUNIDAD", $array);
        $query->orderBy($order_by, 'asc');
        $items = $query->distinct()->get();
        return response()->json($items);
    }

    public function status(Request $request){
        $item = Cls_PersonaFisicaMoral::find($request->id);
        
        if(is_null($item))
            return response()->json( ['error'=> "No se encontro el registro con id ".$request->id], 403);
        
        if($item->USUA_NACTIVO == 1)
            $item->USUA_NACTIVO = 0;
        else
            $item->USUA_NACTIVO = 1;

        $item->save();
        return response()->json(['success'=> true], 200);
    }

    public function update(Request $request){
        try {
            $anterior = Cls_PersonaFisicaMoral::find($request->id);
            
            if($anterior->USUA_CRFC != strtoupper($request->rfc)){    
                $repetido = Cls_PersonaFisicaMoral::where('USUA_CRFC', strtoupper($request->rfc) )->first();
                if(!is_null($repetido))
                return response()->json("El rfc ya esta en uso.", 202);
            }
            
            $item = Cls_PersonaFisicaMoral::where('USUA_NIDUSUARIO',$request->id)
                    ->update([
                        'USUA_CRFC'     => strtoupper($request->rfc),
                        'USUA_CCURP'    => strtoupper($request->curp),
                        'USUA_CCORREO_ELECTRONICO' =>$request->correo,
                        'USUA_CCORREO_ALTERNATIVO' =>$request->alternativo,
                    ]);

            return response()->json("operacion exitosa", 200);
        } catch (\Throwable $th) {
            return response()->json($th, 403);
        }
    }
}
