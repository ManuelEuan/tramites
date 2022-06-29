<?php

namespace App\Http\Controllers;
use DateTime;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;


class GeneralController extends Controller
{
    public function roles(Request $request){
        $query = DB::table('tram_cat_rol')->get();
        return response()->json($query, 200);
    }

    public function dependencias(){
        $registros = [];

        try{
            $url = 'https://vucapacita.chihuahua.gob.mx/api/vw_accede_centro_trabajo';
            $options = array( 'http' => array( 'method'  => 'GET' ));

            $context  = stream_context_create($options);
            $result = file_get_contents($url, false, $context);
            $registros = json_decode($result, true);
        }
        catch(Exception $exception){
            throw $exception;
        }

        return response()->json($registros, 200);
    }

    public function unidades_administrativas(Request $request){
        $registros = [];

        try{
            $url = 'https://vucapacita.chihuahua.gob.mx/api/vw_accede_unidad_administrativa_centro_id/'.$request->dependencia_id;
            $options = array( 'http' => array( 'method'  => 'GET' ));

            if(isset($request->tipo) && $request->tipo == 'multiple')
                $url = 'https://vucapacita.chihuahua.gob.mx/api/vw_accede_unidad_administrativa';

            $context  = stream_context_create($options);
            $result = file_get_contents($url, false, $context);
            $registros = json_decode($result, true);
        }
        catch(Exception $exception){
            throw $exception;
        }

        if(isset($request->tipo) && $request->tipo == 'multiple'){
            $final          = [];
            $dependencias   = explode(",", $request->dependencia_id);

            foreach  ($dependencias as $dependencia) {
                foreach ($registros as $registro) {
                    if($dependencia == $registro["ID_CENTRO"])
                        array_push($final, $registro);
                }
            }
            return response()->json($final, 200);
        }

        return response()->json($registros, 200);
    }

    public function edificios(Request $request){
        $registros  = [];
        $tramites   = json_decode($request->tramite_id);

        try{
            $url = 'https://vucapacita.chihuahua.gob.mx/api/vw_accede_edificios';
            $options = array( 'http' => array( 'method'  => 'GET' ));

            $context  = stream_context_create($options);
            $result = file_get_contents($url, false, $context);

            if(!is_null($tramites) && !isset($request->tipo)){
                $registros      = json_decode($result, true);
                $url_tramite    = 'https://vucapacita.chihuahua.gob.mx/api/vw_accede_tramite';
                $result_tramite = file_get_contents($url_tramite, false, $context);
                $registros_tram = json_decode($result_tramite, true);
                $edificio_tram  = [];
                $final          = [];

                foreach ($tramites as $tramite) {
                    foreach ($registros_tram as $reg_tram) {
                        if($reg_tram['ID_TRAM'] == $tramite){
                            $temp = explode("||", $reg_tram['EDIFICIOS']);
                            $edificio_tram  = array_merge($edificio_tram, $temp);
                        }
                    }
                }

                $edificio_tram = array_unique($edificio_tram);
                foreach ($edificio_tram as $key) {
                    foreach ($registros as $reg) {
                       if($key == $reg["ID_EDIFICIO"])
                        array_push($final,$reg);
                    }
                }
                return response()->json($final, 200);
            }

            if(isset($request->tipo) && $request->tipo == 'all')
                $registros = json_decode($result, true);
        }
        catch(Exception $exception){
            throw $exception;
        }

        return response()->json($registros, 200);
    }

    public function tramites(Request $request){
        $registros = [];

        try{
            $url = 'https://vucapacita.chihuahua.gob.mx/api/vw_accede_tramite';
            $options = array( 'http' => array( 'method'  => 'GET' ));

            $context  = stream_context_create($options);
            $result = file_get_contents($url, false, $context);
            $registros = json_decode($result, true);
        }
        catch(Exception $exception){
            throw $exception;
        }

        $final      = [];
        $unidades   = explode(",", $request->unidad_id);

        foreach  ($unidades as $unidad) {
            foreach ($registros as $registro) {
                if ($unidad == $registro["ID_UNIDAD"])
                    array_push($final, $registro);
            }
        }

        if(isset($request->tipo) && $request->tipo == 'all')
            return response()->json($registros, 200);

        return response()->json($final, 200);
    }



    public function obtener($ids){

        $url = 'https://vucapacita.chihuahua.gob.mx/api/vw_accede_tramite_id_unidad/'.$ids;
        $options = array(
            'http' => array(
                'method'  => 'GET',
            )
        );

        $context  = stream_context_create($options);
        $result   = file_get_contents($url, false, $context);

        $listTramites = json_decode($result, true);


        return Response()->json($listTramites);
    }



    public function usuarios(Request $request){
        $items = [];
        $order = 'desc';
        $order_by = 'u.USUA_NIDUSUARIO';
        $resultados = 10;

        //Comienza el Query
        $query = DB::table('tram_mst_usuario as u')
                    ->leftJoin('tram_cat_rol as rol', 'u.USUA_NIDROL', '=', 'rol.ROL_NIDROL')
                    ->leftJoin('tram_aux_dependencia_usuario_pertenece as dp', 'u.USUA_NIDUSUARIO', '=', 'dp.DEPUP_NIDUSUARIO')
                    ->leftJoin('tram_aux_dependencia_usuario_acceso as da', 'u.USUA_NIDUSUARIO', '=', 'da.DEPUA_NIDUSUARIO')
                    ->leftJoin('tram_aux_unidad_usuario_pertenece as up', 'u.USUA_NIDUSUARIO', '=', 'up.UNIDUP_NIDUSUARIO')
                    ->leftJoin('tram_aux_unidad_usuario_acceso as ua', 'u.USUA_NIDUSUARIO', '=', 'ua.UNIDUA_NIDUSUARIO')
                    ->select('u.USUA_CUSUARIO', 'u.USUA_CNOMBRES','u.USUA_CPRIMER_APELLIDO','u.USUA_CSEGUNDO_APELLIDO',
                                'u.USUA_NIDUSUARIO', 'rol.ROL_CNOMBRE as USUA_CROLNOMBRE', 'u.USUA_NACTIVO')
                    ->groupBy( 'u.USUA_CUSUARIO', 'u.USUA_CNOMBRES','u.USUA_CPRIMER_APELLIDO','u.USUA_CSEGUNDO_APELLIDO',
                                'u.USUA_NIDUSUARIO', 'rol.ROL_CNOMBRE', 'u.USUA_NACTIVO');

        $query->where('rol.ROL_NIDROL', '<>', 2);

        //$query->where('USUA_NELIMINADO', null);

        if(!is_null($request->nombre) && $request->nombre != "")
            $query->where('u.USUA_CNOMBRES','like','%'. $request->nombre .'%');

        if(!is_null($request->primer_Ap) && $request->primer_Ap != "")
            $query->where('u.USUA_CPRIMER_APELLIDO','like','%'. $request->primer_Ap .'%');

        if(!is_null($request->segundo_AP) && $request->segundo_AP != "")
            $query->where('u.USUA_CSEGUNDO_APELLIDO','like','%'. $request->segundo_AP .'%');

        if(!is_null($request->correo) && $request->correo != "")
            $query->where('u.USUA_CCORREO_ELECTRONICO','like','%'. $request->correo .'%');

        if(!is_null($request->estatus) && $request->estatus != "0"){
            $estatus = $request->estatus == 'true' ? true : false;
            $query->where('u.USUA_NACTIVO', $estatus);
        }

        if(!is_null($request->rol) && $request->rol != "0")
            $query->where('rol.ROL_NIDROL', $request->rol);

        if(!is_null($request->dep_pertenece) && $request->dep_pertenece != "0")
            $query->where('dp.DEPUP_NIDDEPENCIA', $request->dep_pertenece);

        if(!is_null($request->uni_pertenece) && $request->uni_pertenece != "0")
            $query->where('up.UNIDUP_NIDUNIDAD', $request->uni_pertenece);

        if(!is_null($request->dep_acceso) && $request->dep_acceso != "0")
            $query->where('da.DEPUA_NIDDEPENCIA', $request->dep_acceso);

        if(!is_null($request->uni_acceso) && $request->uni_acceso != "0")
            $query->where('ua.UNIDUA_NIDUNIDAD', $request->uni_acceso);



        //Parametros de paginacion y orden
        if(!is_null($request->order))
            $order = $request->order;

        if(!is_null($request->order_by))
            $order_by = $request->order_by;

        $query->orderBy($order_by, $order);



        if(is_null($request->paginate) || $request->paginate == "true" ){
            if(!is_null($request->items_to_show))
                $resultados = $request->items_to_show;

            $items = $query->paginate($resultados);
        }
        else{
            $items = $query->get();
            return response()->json(["data" => $items], 200);
        }

        return response()->json($items, 200);
    }

    public function deleteUsuario(Request $request){
        //DB::table('tram_his_bitacora')->where('BITA_NIDUSUARIO', $request->id)->delete();
        DB::table('tram_mst_usuario')->where('USUA_NIDUSUARIO', $request->id)->update(['USUA_NELIMINADO' => true]);
        return response()->json(['message'=> 'Operación exitosa'], 200);
    }

    public function reportes(Request $request){
        $dtActual = Carbon::now()->format('d-m-Y');
        $data = [];

        if($request->modulo == 'pfm'){
            $controller = new PersonaController();
            $data = $controller->find($request);
            $titulo =  'PERSONAS FISICAS Y MORALES';
        }

        $parametros = ["data" => $data->getData()->data, "titulo" => $titulo, "fecha" => $dtActual];
        $pdf = PDF::loadView('REPORTES.listados', compact('parametros'))->setPaper('a4', 'portrait');

        if($request->tipo == "pdf"){
            $pdf = PDF::loadView('REPORTES.listados', compact('parametros'))->setPaper('a4', 'portrait');
            return $pdf->download('asistencias.pdf');
        }
    }
}
