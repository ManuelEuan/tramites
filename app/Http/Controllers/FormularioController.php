<?php

namespace App\Http\Controllers;

use DateTime;
use Exception;
use Illuminate\Http\Request;

use App\Models\Cls_Formulario;
use App\Models\Cls_Cat_Seccion;
use Illuminate\Support\Facades\DB;
use App\Models\Cls_Formulario_Pregunta;
use App\Models\Cls_Formulario_Pregunta_Respuesta;
use App\Models\Cls_Formulario_Respuesta_Especial;


class FormularioController extends Controller
{
    public $open_modal = 0;
    public function __construct(){
       $this->middleware('auth');
    }

    public function list(){
        $open = $this->open_modal;
        return view('FORMULARIOS_CEMR.listado', compact('open'));
    }

    public function find(Request $request){
        $items      = [];
        $order      = 'desc';
        $order_by   = 'FORM_NID';
        $resultados = 10;
        $page       = 1;
        $draw = $request->get('draw');
        $start = $request->get("start");

        if($request->start != 0)
            $page =  $request->length/ $request->start;

        $request->merge(['page' => $page]);


        $totalRecords = DB::table('tram_form_formulario')->where('FORM_BACTIVO', true)->count();



        //Comienza el Query
        $query = DB::table('tram_form_formulario');
        $totalFiltered = DB::table('tram_form_formulario');

        if(!is_null($request->nombre) && $request->nombre != ""){
            $query->where('FORM_CNOMBRE','ilike','%'. $request->nombre .'%');
            $totalFiltered->where('FORM_CNOMBRE','ilike','%'. $request->nombre .'%');
        }

        if(!is_null($request->estatus) && $request->estatus != "" &&  $request->estatus != "Seleccionar"){
            $estatus = $request->estatus == 'Activos' ? true : false;
            $query->where('FORM_BACTIVO', $estatus);
            $totalFiltered->where('FORM_BACTIVO', $estatus);
        }

        if(!is_null($request->fecha_inicio)  && $request->fecha_inicio != ""){
            $query->where('FORM_DFECHA',">=", $request->fecha_inicio);
            $totalFiltered->where('FORM_DFECHA',">=", $request->fecha_inicio);
        }

        if(!is_null($request->fecha_final)  && $request->fecha_final != ""){
            $query->where('FORM_DFECHA',"<=", $request->fecha_final);
            $totalFiltered->where('FORM_DFECHA',"<=", $request->fecha_final);
        }

        $totalFilteredCount = $totalFiltered->count();

        //Parametros de paginacion y orden
        if(!is_null($request->order)){
            $order = $request->order[0]['dir'];

            if($request->order[0]['column'] == 0)
                $order_by = "FORM_DFECHA";
            elseif($request->order[0]['column'] == 1)
                $order_by = "FORM_CNOMBRE";
            elseif($request->order[0]['column'] == 2)
                $order_by = "FORM_CDESCRIPCION";
            elseif($request->order[0]['column'] == 3)
                $order_by = "FORM_BACTIVO";
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

        $final      = (object)[
            "data"              => $items,
            "recordsFiltered"   => $totalFilteredCount,
            "recordsTotal"      => $totalRecords,
            "draw" => intval($draw)
        ];

        return response()->json($final, 200);
    }

    public function secciones(){
        $items = Cls_Cat_Seccion::where('FORM_BACTIVO', true)->get();
        return response()->json($items);
    }

    public function store(Request $request){
        $item = new Cls_Formulario();
        $item->FORM_CNOMBRE         = $request->nombre;
        $item->FORM_DFECHA          = new DateTime('now');
        $item->FORM_CDESCRIPCION    = $request->descripcion;
        $item->save();

        if($request->copia_id != 0){
            $preguntas = Cls_Formulario_Pregunta::where('FORM_NFORMULARIOID', $request->copia_id)->get();

            foreach ($preguntas as $pregunta) {
                $np = new Cls_Formulario_Pregunta();
                $np->FORM_NFORMULARIOID   = $item->FORM_NID;
                $np->FORM_NSECCIONID      = $pregunta->FORM_NSECCIONID;
                $np->FORM_CPREGUNTA       = $pregunta->FORM_CPREGUNTA;
                $np->save();

                $respuestas = Cls_Formulario_Pregunta_Respuesta::where('FORM_NPREGUNTAID', $pregunta->FORM_NID)->get();
                foreach ($respuestas as $respuesta) {
                    $nr = new Cls_Formulario_Pregunta_Respuesta();
                    $nr->FORM_NPREGUNTAID    = $np->FORM_NID;
                    $nr->FORM_CTIPORESPUESTA = $respuesta->FORM_CTIPORESPUESTA;
                    $nr->FORM_CVALOR         = $respuesta->FORM_CVALOR;
                    $nr->FORM_BBloquear      = $respuesta->FORM_BBloquear;
                    $nr->save();

                    $especiales = Cls_Formulario_Respuesta_Especial::where('FORM_NPREGUNTARESPUESTAID', $respuesta->FORM_NID)->get();
                    foreach ($especiales as $especial) {
                        $ne = new Cls_Formulario_Respuesta_Especial();
                        $ne->FORM_NPREGUNTARESPUESTAID  = $nr->FORM_NID;
                        $ne->FORM_CTIPORESPUESTA        = $especial->FORM_CTIPORESPUESTA;
                        $ne->FORM_CVALOR                = $especial->FORM_CVALOR;
                        $ne->save();
                    }
                }
            }

        }

        return response()->json(['id'=> $item->FORM_NID], 200);
    }

    public function status(Request $request){
        $item = Cls_Formulario::where('FORM_NID',$request->id)
                                ->select('*')
                                ->first('FORM_NID');
        $activo = true;
        if($item->FORM_BACTIVO)
            $activo = false;

        $response= Cls_Formulario::where('FORM_NID',$request->id)->update(['FORM_BACTIVO' => $activo ]);

        return response()->json(['message'=> 'Operación exitosa'], 200);
    }

    public function update( Request $request){
        $item = Cls_Formulario::where('FORM_NID',$request->id)
                    ->update([
                        'FORM_CNOMBRE'      => $request->nombre,
                        'FORM_CDESCRIPCION' =>$request->descripcion,
                    ]);

        return response()->json(['message'=> 'Operación exitosa'], 200);
    }

    public function delete(Request $request){
        Cls_Formulario::where('FORM_NID',$request->id)->delete();
        return response()->json(['message'=> 'Operación exitosa'], 200);
    }

    // public function preguntas(Request $request)
    // {
    //     try {
    //         $pregunta   = null;
    //         $respuesta  = null;
    //         $tiRes      = "";
    //         $tipEsp     = "";
    //         $isAsigned = 0;
    //         //DB::beginTransaction();

    //         $eliminados = json_decode($request->eliminados);
    //         foreach ($eliminados as $eliminar) {
    //             if ($eliminar->tipo == 'pregunta')
    //                 Cls_Formulario_Pregunta::where('FORM_NID', $eliminar->id)->delete();
    //             elseif ($eliminar->tipo == 'respuesta')
    //                 Cls_Formulario_Pregunta_Respuesta::where('FORM_NID', $eliminar->id)->delete();
    //             elseif ($eliminar->tipo == 'especial')
    //                 Cls_Formulario_Respuesta_Especial::where('FORM_NID', $eliminar->id)->delete();
    //         }

    //         $array = json_decode($request->preguntas);
    //         foreach ($array as $datos) {
    //             $valP       = strpos($datos->name,  'pregunta_');
    //             $valTR      = strpos($datos->name,  'tipoRespuesta_');
    //             $valR       = strpos($datos->name,  'respuesta_');
    //             $valTE      = strpos($datos->name,  'select_');
    //             $valCh      = strpos($datos->name,  'bloqueo_');
    //             $valEO      = strpos($datos->name,  'opcionEspecial_');
    //             $valEO      = strpos($datos->name,  'opcionEspecial_');
    //             $valCat     = strpos($datos->name,  'tipoCatalogo_');
    //             $valRes     = strpos($datos->name,  'update_resolutivo_');
    //             $valResol   = strpos($datos->name,  'resolutivo_');
    //             $valAsignasion = strpos($datos->name, 'asignacion_');
    //             $valVinculacion = strpos($datos->name, 'tipoVinculacion_');
    //             $resolutivo = $datos->id;

    //             if ($valResol !== FALSE) {
    //                 if ($resolutivo == 0)
    //                     $res = $datos->value;
    //                 else {
    //                     $pregunta = Cls_Formulario_Pregunta::where('FORM_NID', $resolutivo)->select('*')->first('FORM_NID');
    //                     Cls_Formulario_Pregunta::where('FORM_NID', $resolutivo)->update(['FORM_BRESOLUTIVO' => $datos->value]);
    //                     Cls_Formulario_Pregunta::where('FORM_NID', $resolutivo)->update(['FORM_BTIENEASIGNACION' => false]);
    //                 }
    //             }

    //             if ($valP !== FALSE) {
    //                 // $resolutivo =$datos->id;
    //                 if ($datos->id == 0) {
    //                     $pregunta = new Cls_Formulario_Pregunta();
    //                     $pregunta->FORM_NFORMULARIOID   = $request->formulario_id;
    //                     $pregunta->FORM_NSECCIONID      = $request->seccion_id;
    //                     $pregunta->FORM_CPREGUNTA       = $datos->value;
    //                     $pregunta->FORM_BRESOLUTIVO       = $request->resolutivo;
    //                     $pregunta->save();
    //                 } else {
    //                     $pregunta = Cls_Formulario_Pregunta::where('FORM_NID', $datos->id)->select('*')->first('FORM_NID');
    //                     Cls_Formulario_Pregunta::where('FORM_NID', $datos->id)->update(['FORM_CPREGUNTA' => $datos->value]);
    //                 }
    //             }
    //             if ($valCh !== false)
    //                 Cls_Formulario_Pregunta_Respuesta::where('FORM_NID', $respuesta->FORM_NID)->update(['FORM_BBLOQUEAR' => true]);
                    
    //             // if ($datos->id !== 0) {
    //             //     Cls_Formulario_Pregunta::where('FORM_NID', $datos->id)->update(['FORM_BTIENEASIGNACION' => false]);
    //             // }
    //             if ($valAsignasion !== false) {
    //                 if ($datos->id == 0) {
    //                     $lastId =  Cls_Formulario_Pregunta::latest('FORM_NID')->first();
    //                     Cls_Formulario_Pregunta::where('FORM_NID', $lastId)->update(['FORM_BTIENEASIGNACION' => true]);
    //                     $isAsigned = 1;
    //                 } else {
    //                     Cls_Formulario_Pregunta::where('FORM_NID', $datos->id)->update(['FORM_BTIENEASIGNACION' => true]);
    //                     $isAsigned = 1;
    //                 }
    //             } 
    //             if ($valVinculacion !== false && $isAsigned === 1) {
    //                 if ($datos->id == 0) {
    //                     Cls_Formulario_Pregunta::where('FORM_NID', $lastId)->update(['FORM_CVALORASIGNACION' => $datos->value]);
    //                     $isAsigned = 0;
    //                 } else {
    //                     Cls_Formulario_Pregunta::where('FORM_NID', $datos->id)->update(['FORM_CVALORASIGNACION' => $datos->value]);
    //                     $isAsigned = 0;
    //                 }
    //             }
    //             if ($valTR !== FALSE)
    //                 $tiRes = $datos->value;

    //             if ($valR !== FALSE) {
    //                 if ($datos->id == 0) {
    //                     if (str_contains($datos->name, 'respuesta_')) {
    //                         $res_id     = explode("_", $datos->name);
    //                         $anterior   = Cls_Formulario_Pregunta_Respuesta::where('FORM_NPREGUNTAID', $res_id[1])->select('*')->first();

    //                         if ($anterior->FORM_CTIPORESPUESTA != $tiRes)
    //                             Cls_Formulario_Pregunta_Respuesta::where('FORM_NPREGUNTAID', $res_id[1])->delete();
    //                     }
    //                     $respuesta = new Cls_Formulario_Pregunta_Respuesta();
    //                     $respuesta->FORM_NPREGUNTAID    = $pregunta->FORM_NID;
    //                     $respuesta->FORM_CTIPORESPUESTA = $tiRes;
    //                     $respuesta->FORM_CVALOR         = $datos->value;
    //                     $respuesta->save();

                        
    //                 } else {
    //                     $respuesta = Cls_Formulario_Pregunta_Respuesta::where('FORM_NID', $datos->id)->select('*')->first('FORM_NID');
    //                     Cls_Formulario_Pregunta_Respuesta::where('FORM_NID', $datos->id)->update(['FORM_NPREGUNTAID' => $pregunta->FORM_NID, 'FORM_CTIPORESPUESTA' => $tiRes, 'FORM_CVALOR' =>  $datos->value, "FORM_BBLOQUEAR" => null]);
    //                 }
    //             }

    //             if ($valCh !== false)
    //                 Cls_Formulario_Pregunta_Respuesta::where('FORM_NID', $respuesta->FORM_NID)->update(['FORM_BBLOQUEAR' => true]);

    //             if ($valTE !== FALSE)
    //                 $tipEsp = $datos->value;

    //             if ($valEO !== FALSE)
    //                 $tipEsp = $datos->value;

    //             if (($tiRes == "especial" && $valTE !== false) || ($tiRes == "especial" && $valEO !== false)) {
    //                 $anterior = Cls_Formulario_Respuesta_Especial::where('FORM_NPREGUNTARESPUESTAID', $datos->id)->first();
    //                 if ($anterior != null) {
    //                     if ($anterior->FORM_CTIPORESPUESTA != $datos->value) {
    //                         if ($datos->value != "opciones") {
    //                             Cls_Formulario_Respuesta_Especial::where('FORM_NPREGUNTARESPUESTAID', $datos->id)->update(['FORM_CTIPORESPUESTA' => $datos->value, 'FORM_CVALOR' => $datos->value]);

    //                             if ($anterior->FORM_CTIPORESPUESTA == "opciones") {
    //                                 $primero = Cls_Formulario_Respuesta_Especial::where('FORM_NPREGUNTARESPUESTAID', $datos->id)->first();
    //                                 Cls_Formulario_Respuesta_Especial::where('FORM_NPREGUNTARESPUESTAID', $datos->id)->where('FORM_NID', '!=', $primero->FORM_NID)->delete();
    //                             }
    //                         } else
    //                             Cls_Formulario_Respuesta_Especial::where('FORM_NPREGUNTARESPUESTAID', $datos->id)->delete();
    //                     }
    //                 }

    //                 if ($tipEsp !== "opciones" && $datos->value !== "opciones") {
    //                     if ($datos->id == 0) {
    //                         $especiales = new Cls_Formulario_Respuesta_Especial();
    //                         $especiales->FORM_NPREGUNTARESPUESTAID  = $respuesta->FORM_NID;

    //                         if ($datos->value != "simple" && $datos->value != "numerico") {
    //                             $tipEsp = 'opciones';
    //                         }

    //                         $especiales->FORM_CTIPORESPUESTA        = $tipEsp;
    //                         $especiales->FORM_CVALOR                = trim($datos->value);
    //                         $especiales->save();
    //                     } else {
    //                         if ($datos->value != "simple" && $datos->value != "numerico") {
    //                             $tipEsp = 'opciones';
    //                         }

    //                         Cls_Formulario_Respuesta_Especial::where('FORM_NID', $datos->id)->update(['FORM_CTIPORESPUESTA' => $tipEsp, 'FORM_CVALOR' => trim($datos->value)]);
    //                     }
    //                 }
    //             } elseif ($tiRes == 'abierta') {
    //                 //eliminar las respustas anteriores
    //                 if (strpos($datos->name, 'update')) {
    //                     $inf = explode("_", $datos->name);
    //                     //bscar las IDs de la respuesta
    //                     $data = Cls_Formulario_Pregunta_Respuesta::select('FORM_NID')->where('FORM_NPREGUNTAID', '=', $inf[2])->get();
    //                     foreach ($data as $d) {
    //                         Cls_Formulario_Pregunta_Respuesta::where('FORM_NID', '=', $d->FORM_NID)->delete();
    //                     }
    //                 }
    //                 if ($datos->id == 0) {
    //                     $answer = new Cls_Formulario_Pregunta_Respuesta();
    //                     $answer->FORM_NPREGUNTAID    = $pregunta->FORM_NID;
    //                     $answer->FORM_CTIPORESPUESTA = $tiRes;
    //                     $answer->save();
    //                 }
    //             }
    //         }
    //     } catch (\Throwable $th) {
    //         return response()->json(['error' => $th], 403);
    //     }

    //     return response()->json(['message' => 'Operación exitosa'], 200);
    // }
    public function preguntas(Request $request){
        try {
            $pregunta   = null;
            $respuesta  = null;
            $tiRes      = "";
            $tipEsp     = "";
            //DB::beginTransaction();
            $isAsigned = 0;
            $eliminados = json_decode($request->eliminados);
            foreach ($eliminados as $eliminar) {
                if($eliminar->tipo == 'pregunta')
                    Cls_Formulario_Pregunta::where('FORM_NID', $eliminar->id)->delete();
                elseif($eliminar->tipo == 'respuesta')
                    Cls_Formulario_Pregunta_Respuesta::where('FORM_NID', $eliminar->id)->delete();
                elseif($eliminar->tipo == 'especial')
                    Cls_Formulario_Respuesta_Especial::where('FORM_NID', $eliminar->id)->delete();
            }
            $tipoRespuesta = [];
            $array = json_decode($request->preguntas);
            foreach ($array as $datos) {
                $valP       = strpos($datos->name,  'pregunta_');
                $valTR      = strpos($datos->name,  'tipoRespuesta_');
                $valR       = strpos($datos->name,  'respuesta_');
                $valTE      = strpos($datos->name,  'select_');
                $valCh      = strpos($datos->name,  'bloqueo_');
                $valEO      = strpos($datos->name,  'opcionEspecial_');
                $valCat     = strpos($datos->name,  'tipoCatalogo_');
                $valRes     = strpos($datos->name,  'update_resolutivo_');
                $valResol   = strpos($datos->name,  'resolutivo_');
                $valAsignasion = strpos($datos->name, 'asignacion_');
                $valVinculacion = strpos($datos->name, 'tipoVinculacion_');
                $resolutivo = $datos->id;

                if($valResol !== FALSE) {
                    if($resolutivo == 0)
                        $res =$datos->value;
                    else{
                        $pregunta = Cls_Formulario_Pregunta::where('FORM_NID',$resolutivo)->select('*')->first('FORM_NID');
                        Cls_Formulario_Pregunta::where('FORM_NID',$resolutivo)->update(['FORM_BRESOLUTIVO' => $datos->value]);
                        Cls_Formulario_Pregunta::where('FORM_NID', $resolutivo)->update(['FORM_BTIENEASIGNACION' => false]);
                    }

                }
                // if($datos->id != 0){
                //     Cls_Formulario_Pregunta::where('FORM_NID', $resolutivo)->update(['FORM_BTIENEASIGNACION' => false]);
                // }
                if($valP !== FALSE) {
                    // $resolutivo =$datos->id;
                    if ($datos->id != 0) {
                        $existe   = Cls_Formulario_Pregunta_Respuesta::where('FORM_NPREGUNTAID',$datos->id)->select('*')->first();
                        array_push($tipoRespuesta,$existe);
                        if(isset($existe)){
                        Cls_Formulario_Pregunta_Respuesta::where('FORM_NPREGUNTAID',$datos->id)->delete();
                        
                        }
                    }
                    if($datos->id == 0){
                        $pregunta = new Cls_Formulario_Pregunta();
                        $pregunta->FORM_NFORMULARIOID   = $request->formulario_id;
                        $pregunta->FORM_NSECCIONID      = $request->seccion_id;
                        $pregunta->FORM_CPREGUNTA       = $datos->value;
                        $pregunta->FORM_BRESOLUTIVO       = $request->resolutivo;
                        $pregunta->save();
                    }
                    else{
                        $pregunta = Cls_Formulario_Pregunta::where('FORM_NID',$datos->id)->select('*')->first('FORM_NID');
                        Cls_Formulario_Pregunta::where('FORM_NID',$datos->id)->update(['FORM_CPREGUNTA' => $datos->value]);
                    }
                }

                if($valTR !== FALSE){
                    $tiRes = $datos->value;
                }

                    

                if($valR !== FALSE){
                    if($datos->id == 0){
                        if (str_contains($datos->name,'respuesta_update_')) {
                            $res_id     = explode("_", $datos->name);
                            $anterior   = Cls_Formulario_Pregunta_Respuesta::where('FORM_NPREGUNTAID',$res_id[2])->select('*')->first();
                            if(isset($anterior)){

                                if($anterior->FORM_CTIPORESPUESTA != $tiRes)
                                    Cls_Formulario_Pregunta_Respuesta::where('FORM_NPREGUNTAID',$res_id[2])->delete();
                            }
                        }
                        
                        $respuesta = new Cls_Formulario_Pregunta_Respuesta();
                        $respuesta->FORM_NPREGUNTAID    = $pregunta->FORM_NID;
                        $respuesta->FORM_CTIPORESPUESTA = $tiRes;
                        $respuesta->FORM_CVALOR         = $datos->value;
                        $respuesta->save();
                        
                    }
                    else{
                        $respuesta = Cls_Formulario_Pregunta_Respuesta::where('FORM_NID',$datos->id)->select('*')->first('FORM_NID');
                        Cls_Formulario_Pregunta_Respuesta::where('FORM_NID',$datos->id)->update(['FORM_NPREGUNTAID' => $pregunta->FORM_NID, 'FORM_CTIPORESPUESTA' => $tiRes, 'FORM_CVALOR' =>  $datos->value, "FORM_BBLOQUEAR" => null]);
                    }
                    $ultimo =  Cls_Formulario_Pregunta_Respuesta::latest('FORM_NID')->first();
                    
                }

                if($valCh !== false)
                    Cls_Formulario_Pregunta_Respuesta::where('FORM_NID',$respuesta->FORM_NID)->update(['FORM_BBLOQUEAR' => true ]);

                if($valTE !== FALSE)
                    $tipEsp = $datos->value;

                if($valEO !== FALSE)
                    $tipEsp = $datos->value;


                    if ($valAsignasion !== false) {
                        if ($datos->id == 0) {
                            $lastId =  Cls_Formulario_Pregunta::latest('FORM_NID')->first();
                            Cls_Formulario_Pregunta::where('FORM_NID', $lastId->FORM_NID)->update(['FORM_BTIENEASIGNACION' => true]);
                            $isAsigned = 1;
                        } else {
                            Cls_Formulario_Pregunta::where('FORM_NID', $datos->id)->update(['FORM_BTIENEASIGNACION' => true]);
                            $isAsigned = 1;
                        }
                    } 
                    if ($valVinculacion !== false && $isAsigned === 1) {
                        if ($datos->id == 0) {
                            $lastId =  Cls_Formulario_Pregunta::latest('FORM_NID')->first();
                            Cls_Formulario_Pregunta::where('FORM_NID', $lastId->FORM_NID)->update(['FORM_CVALORASIGNACION' => $datos->value]);
                            $isAsigned = 0;
                        } else {
                            Cls_Formulario_Pregunta::where('FORM_NID', $datos->id)->update(['FORM_CVALORASIGNACION' => $datos->value]);
                            $isAsigned = 0;
                        }
                    }
                if(($tiRes == "especial" && $valTE !== false) || ($tiRes == "especial" && $valEO !== false)){
                    $anterior = Cls_Formulario_Respuesta_Especial::where('FORM_NPREGUNTARESPUESTAID',$datos->id)->first();
                    if($anterior != null){
                        if($anterior->FORM_CTIPORESPUESTA != $datos->value){
                            if($datos->value != "opciones"){
                                Cls_Formulario_Respuesta_Especial::where('FORM_NPREGUNTARESPUESTAID',$datos->id)->update(['FORM_CTIPORESPUESTA' => $datos->value, 'FORM_CVALOR' => $datos->value]);

                                if($anterior->FORM_CTIPORESPUESTA == "opciones"){
                                    $primero = Cls_Formulario_Respuesta_Especial::where('FORM_NPREGUNTARESPUESTAID',$datos->id)->first();
                                    Cls_Formulario_Respuesta_Especial::where('FORM_NPREGUNTARESPUESTAID',$datos->id)->where('FORM_NID', '!=', $primero->FORM_NID)->delete();
                                }
                            }
                            else
                                Cls_Formulario_Respuesta_Especial::where('FORM_NPREGUNTARESPUESTAID',$datos->id)->delete();
                        }
                    }

                    if($tipEsp !== "opciones" && $datos->value !== "opciones"  ){
                        if($datos->id == 0){
                            $especiales = new Cls_Formulario_Respuesta_Especial();
                            $especiales->FORM_NPREGUNTARESPUESTAID  = $respuesta->FORM_NID;

                            if($datos->value != "simple" && $datos->value != "numerico"){
                                $tipEsp= 'opciones';
                            }

                            $especiales->FORM_CTIPORESPUESTA        = $tipEsp;
                            $especiales->FORM_CVALOR                = trim($datos->value);
                            $especiales->save();
                        }
                        else{
                            if($datos->value != "simple" && $datos->value != "numerico"){
                                $tipEsp= 'opciones';
                            }

                            Cls_Formulario_Respuesta_Especial::where('FORM_NID',$datos->id)->update(['FORM_CTIPORESPUESTA' => $tipEsp, 'FORM_CVALOR' => trim($datos->value) ]);
                        }
                    }
                }elseif($tiRes == 'abierta'){
                    //eliminar las respustas anteriores
                    if(strpos($datos->name, 'update')){
                        $inf = explode("_", $datos->name);
                        //bscar las IDs de la respuesta
                        $data = Cls_Formulario_Pregunta_Respuesta::select('FORM_NID')->where('FORM_NPREGUNTAID','=',$inf[2])->get();
                        foreach($data as $d){
                            Cls_Formulario_Pregunta_Respuesta::where('FORM_NID','=',$d->FORM_NID)->delete();
                        }
                    }
                    if($datos->id == 0){
                        $answer = new Cls_Formulario_Pregunta_Respuesta();
                        $answer->FORM_NPREGUNTAID    = $pregunta->FORM_NID;
                        $answer->FORM_CTIPORESPUESTA = $tiRes;
                        $answer->save();
                    }
                }
            }
            return response()->json(['message'=> $tipoRespuesta], 200);
        } catch (\Throwable $th) {
            return response()->json(['error'=> $th], 403);
        }

        
    }
    public function detalle(Request $request){
        $response= [];
        $preguntas = Cls_Formulario_Pregunta::where('FORM_NFORMULARIOID', $request->formulario_id)->where('FORM_NSECCIONID', $request->seccion_id)->get()->toArray();

        try {
            foreach ($preguntas as $pregunta) {
                $pregunta['respuestas'] = Cls_Formulario_Pregunta_Respuesta::where('FORM_NPREGUNTAID', $pregunta['FORM_NID'])->get()->toArray();
                $especiales = [];

                foreach ($pregunta['respuestas']  as $index => $respuesta) {
                    if($respuesta['FORM_CTIPORESPUESTA'] == "especial"){
                        $pregunta['respuestas'][$index]['especial'] = Cls_Formulario_Respuesta_Especial::where('FORM_NPREGUNTARESPUESTAID', $respuesta['FORM_NID'])->get();
                    }
                }
                array_push($response, $pregunta);
            }

            return response()->json($response, 200);
        } catch (Exception $ex) {
            return response()->json($ex, 403);
        }
    }
}
