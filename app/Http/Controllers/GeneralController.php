<?php

namespace App\Http\Controllers;

use DateTime;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\GeneralValidator;
use App\User;

class GeneralController extends Controller
{
    protected $validation;
    public function __construct(){
        $this->validation = new GeneralValidator();
    }

    public function roles(Request $request){
        $query = DB::table('tram_cat_rol')->get();
        return response()->json($query, 200);
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

    /**
     * Valida si existe la curp y/o RFC dado de alta
     */
    public function validaDuplicidad(Request $request){
        $validation = $this->validation->validaDuplicidad($request);
      
        if( $validation  !== true)
            return response()->json(['error'=> $validation->original], 403);
        
        $tipo = $request->tipo == 'rfc' ? 'USUA_CRFC' : 'USUA_CCURP';
        $usuario = User::where($tipo, strtoupper($request->valor))->first();

        return response()->json(["data" => $usuario], 200);
    } 
}
