<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cls_Citas;
use Illuminate\Support\Carbon;
use  Illuminate\Pagination\LengthAwarePaginator;
use  Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Http;

class CitasController extends Controller
{
    protected $host = "https://vucapacita.chihuahua.gob.mx/api/";
     //Obtener formularios activos
    public function consultar_citas($idusuario, $idtramiteconf)
    {

         $citas = new Cls_Citas();
         $registros = $citas->TRAM_SP_CITACONSULTAR($idusuario, $idtramiteconf);
 
         $response = [
             'data' => $registros,
         ];
 
         return response()->json($response);
    }

    public function guardar_cita(Request $request)
    {

        $url = $this->host.'sp_sici_guardar_cita';
        $options = array(
            'http' => array(
                'header' => "Content-Type: application/json\r\n".
                    "User-Agent:MyAgent/1.0\r\n",
                'method'  => 'POST',
                'content' => json_encode($request, true)
            )
        );

        $context  = stream_context_create($options);
        $result   = file_get_contents($url, false, $context);

        $listCitas = json_decode($result, true);

        return Response()->json($listCitas);
    }

    public function guardar_cita_local(Request $request)
    {
        $response = Cls_Citas::TRAM_SP_CITAAGENDADA(
            $request->input('CITA_FOLIO'),
            $request->input('CITA_STATUS'),
            $request->input('CITA_IDUSUARIO'),
            $request->input('CITA_IDTRAMITECONF'));

        return response()->json([
            "estatus" => "success",
            "codigo" => 200,
            "mensaje" => "Cita guardada con éxito"
        ]);
    }

    public function actualizar_cita(Request $request)
    {
        $response = Cls_Citas::TRAM_SP_CITAACTUALIZADA(
            $request->input('CITA_FOLIO'),
            $request->input('CITA_STATUS'));

        return response()->json([
            "estatus" => "success",
            "codigo" => 200,
            "mensaje" => "Cita actualizada con éxito"
        ]);
    }

    public function citas_disponibles($idtramite, $idedificio){
        $url = $this->host.'vw_sici_citas_disponibles_filtro/'.$idtramite.'/'.$idedificio;
        $options = array(
            'http' => array(
                'method'  => 'GET',
            )
        );

        $context  = stream_context_create($options);
        $result   = file_get_contents($url, false, $context);

        $listCitas = json_decode($result, true);

        return Response()->json($listCitas);
    }
}
