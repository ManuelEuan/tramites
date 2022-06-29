<?php

namespace App\Http\Controllers;

use DateTime;
use DateInterval;
use Illuminate\Http\Request;
use App\Models\Cls_Dia_Inhabil;
use Illuminate\Support\Facades\DB;

class DiaInhabilController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    
    public function calendario(){
        return view('FORMULARIOS_CEMR.calendario');
    }

    public function find(Request $request){
        $response   = [];
        $query      = DB::table('cemr_dias_inhabiles');
        $items      = $query->get();
        
        foreach ($items as $value) {
            $final  = new DateTime($value->FORM_DFINAL);
            $final->add(new DateInterval('P1D'));

            $tem = [];
            $item['id']     = $value->FORM_NID;
            $item['title']  = $value->FORM_CNOMBRE;
            $item['start']  = $value->FORM_DINICIO;
            $item['starStr']= $value->FORM_DINICIO;
            $item['end']    = $final->format('Y-m-d');
            $item['endStr'] = $value->FORM_DFINAL;
            $item['color']  = $value->FORM_CCOLOR;
            $item['textColor'] = "#000";
            array_push($response, $item);
        }
        
        return response()->json($response, 200);
    }

    public function store(Request $request){
        $item = new Cls_Dia_Inhabil();
        $item->FORM_CNOMBRE = $request->nombre;
        $item->FORM_CCOLOR  = $request->color;
        $item->FORM_DINICIO = $request->fechaInicial;
        $item->FORM_DFINAL  = $request->fechaFinal;
        $item->save();

        return response()->json(['item' => $item], 200);
    }

    public function update(Request $request){
        $response = array('message' => 'Error');
        $codigo = 403;
        
        try{
            $item = Cls_Dia_Inhabil::find($request->id);
            if(!is_null($item)){
                $item->FORM_CNOMBRE = $request->nombre;
                $item->FORM_CCOLOR  = $request->color;
                $item->FORM_DINICIO = $request->fechaInicial;
                $item->FORM_DFINAL  = $request->fechaFinal;
                $item->save();
            }
            
            $response["message"] = "Operacion Exitosa";
            $codigo = 200;
        }
        catch(Exception $ex){
            $response["message"] = $ex->errorInfo[2];
        }
        return response()->json($response, $codigo);
    }

    public function delete(Request $request){
        Cls_Dia_Inhabil::where('FORM_NID',$request->id)->delete();
        return response()->json(['message'=> 'Operación exitosa'], 200);
    }
}
