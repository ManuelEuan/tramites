<?php

namespace App\Http\Controllers;

use DateTime;
use Exception;
use DateInterval;
use Illuminate\Http\Request;
use App\Models\Cls_Dia_Inhabil;
use App\Services\TramiteService;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\GeneralValidator;

class DiaInhabilController extends Controller
{
    protected $tramiteServicio;
    protected $validaciones;
    public function __construct(){
       /*  $this->middleware('auth'); */
        $this->validaciones     = new GeneralValidator();
        $this->tramiteServicio  = new TramiteService();
    }
    
    public function calendario(Request $request){
        $filtros = $this->tramiteServicio->filtros($request);
        return view('FORMULARIOS_CEMR.calendario', compact('filtros'));
    }

    /**
     * Retorna los días delcalendario con dos meses de anticipacion y dos de retraso
     * @param Request $request
     * @return Response
     */
    public function find(Request $request){
        $response   = [];
        $fecha_inicio = new DateTime($request->start);
        $fecha_inicio->modify("-2 month");
        $fecha_final = new DateTime($request->end);
        $fecha_final->modify("2 month");

        $items      = DB::table('tram_dia_inhabil')->where('fecha_inicio', '>=', $fecha_inicio->format('Y-m-d'))
                            ->where('fecha_inicio', '<=', $fecha_final->format('Y-m-d'))->where('activo', true )->get();

        foreach ($items as $value) {
            $final  = new DateTime($value->fecha_final);
            $final->add(new DateInterval('P1D'));

            $item           = array();
            $item['id']     = $value->id;
            $item['title']  = $value->nombre;
            $item['start']  = $value->fecha_inicio;
            $item['starStr']= $value->fecha_inicio;
            $item['end']    = $final->format('Y-m-d');
            $item['endStr'] = $value->fecha_final;
            $item['color']  = $value->color;
            $item['colores']    = $value->color;
            $item['textColor']  = "#000";
            $item['dependencias']   = $value->dependencias;
            array_push($response, $item);
        }
        
        return response()->json($response, 200);
    }

    /**
     * Guarda un registro en la DB
     * @param Request $request
     * @return Response
     */
    public function store(Request $request){
        $validacion     = $this->validaciones->diaInhabil($request, 'add');
        if($validacion !== true)
            return response()->json(['error' => $validacion->original], 403);

        $datos = $request->all();
        if($request->all == 'true'){
            $dependencias   = $this->tramiteServicio->filtros($request);
            $valor          = "";
            
            foreach($dependencias['dependencias'] as $index => $value){
                $valor = $index == 0 ? $value->iId : $valor.",".$value->iId;
            }

            $datos['dependencias'] =  $valor;
        }

        $item = Cls_Dia_Inhabil::create($datos);
        return response()->json(['item' => $item], 200);
    }

    /**
     * Guarda un registro en la DB
     * @param Request $request
     * @return Response
     */
    public function update(Request $request){
        $response = array('message' => 'Error');
        $codigo = 403;
        
        try{
            $validacion     = $this->validaciones->diaInhabil($request, 'update');
            if($validacion !== true)
                return response()->json(['error' => $validacion->original], 403);

            $item           = Cls_Dia_Inhabil::find($request->id);
            $dependencias   = $request->dependencias;

            if(!is_null($item)){
                if($request->all == 'true'){
                    $dependencias   = $this->tramiteServicio->filtros($request);
                    $valor          = "";

                    foreach($dependencias['dependencias'] as $index => $value){
                        $valor = $index == 0 ? $value->iId : $valor.",".$value->iId;
                    }

                    $dependencias   = $valor;
                }
                  
                $item->nombre       = $request->nombre;
                $item->color        = $request->color;
                $item->fecha_inicio = $request->fecha_inicio;
                $item->fecha_final  = $request->fecha_final;
                $item->dependencias = $dependencias;
                $item->save();
            }
            
            $response["message"] = "Operacion Exitosa";
            $codigo = 200;
        }
        catch(Exception $ex){
            $response["message"] = $ex->getMessage();
        }
        return response()->json($response, $codigo);
    }

    /**
     * Eliminacion logica del registro
     * @param Request $request
     * @return Response
     */
    public function delete(Request $request){
        $item =  Cls_Dia_Inhabil::find($request->id);
        $item->activo = false;
        $item->save();

        return response()->json(['message'=> 'Operación exitosa'], 200);
    }
}
