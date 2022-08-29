<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cls_Citas;
use Illuminate\Support\Carbon;
use  Illuminate\Pagination\LengthAwarePaginator;
use  Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Http;
use App\Models\Cls_Citas_Calendario;
use Barryvdh\DomPDF\Facade as PDF;

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

    /**
     * Retorna el calendario de las citas
     */
    public function calendario() {

        $data = ['API_URL' => env('APP_URL')."/api"];
        return view('CITAS.calendario', compact('data'));
    }

    //Citas agendadas All()
    public function getCitas() {
        return response()->json(Cls_Citas_Calendario::all());
    }
    // Obtener las citas disponibles por mes
    public function getCitasFiltro($idtramite,$idedificio,$anio,$mes) {
        $values = array((int)$idtramite,(int)$idedificio,$anio,$mes);
        $result = Cls_Citas_Calendario::getByFiltro($idtramite,$idedificio,$anio,$mes);
        return response()->json($result);        
    }

    public function saveCita(Request $request) {
        $cita = new Cls_Citas_Calendario();
        $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $folio = substr(str_shuffle($permitted_chars), 0, 10);

        $cita->CITA_IDUSUARIO = $request->CITA_IDUSUARIO;
        $cita->CITA_FECHA = $request->CITA_FECHA;
        $cita->CITA_HORA = $request->CITA_HORA;
        $cita->CITA_IDTRAMITE = $request->CITA_IDTRAMITE;
        $cita->CITA_IDMODULO = $request->CITA_IDMODULO;
        $cita->CITA_FOLIO = $folio;
        if (Cls_Citas_Calendario::validaNueva($cita)) {
            $cita->save();
            return response()->json([
                "estatus" => "success",
                "codigo" => 200,
                "cita" => $cita,
                "mensaje" => "Cita guardada con éxito"
            ]);            
        }
        return response()->json([
            "estatus" => "warning",
            "codigo" => 500,
            "mensaje" => "No se puede agendar otra cita para el mismo tramite"
        ]);
    }

    public function descargaPDFCita(Request $request) {

        $html = '
                <p><span>Folio:</span> '. "asdaasdfasdf" .'.</p>
                <p><span>Fecha:</span> '. "sdsfasdfs" .'.</p>
                <p><span>Hora:</span> '. "dsvasfvavasd" .'.</p>
                <p><span>Municipio:</span> Prueba.</p>
                <p><span>Módulo:</span> Prueba.</p>
            ';
        // $html = '
        //         <p><span>Folio:</span> '. $cita->CITA_FOLIO .'.</p>
        //         <p><span>Fecha:</span> '. $cita->CITA_FECHA .'.</p>
        //         <p><span>Hora:</span> '. $cita->CITA_HORA .'.</p>
        //         <p><span>Municipio:</span> Prueba.</p>
        //         <p><span>Módulo:</span> Prueba.</p>
        //     ';
        $pdf = PDF::loadHTML($html)->setPaper('a4', 'portrait');
        $path = storage_path();
        $archivoPDF = $path.'/'."CITA".'.pdf';
        $pdf->save($archivoPDF);
        return response()->download($archivoPDF, 'CITA.pdf')->deleteFileAfterSend();

        return $pdf->download('CITA.pdf');
    }

}
