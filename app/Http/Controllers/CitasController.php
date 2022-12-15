<?php

namespace App\Http\Controllers;

use Exception;
use App\Cls_Citas;
use Illuminate\Http\Request;
use App\Services\CitasService;
use App\Services\TramiteService;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\GeneralValidator;
use App\Models\Cls_Citas_Calendario;
use Barryvdh\DomPDF\Facade as PDF;

class CitasController extends Controller
{
    protected $host = "https://vucapacita.chihuahua.gob.mx/api/";
    
    /**
     * Construct Gestor
     */
    public function __construct()
    {
       /*  $this->middleware('auth'); */
        $this->tramiteService   = new TramiteService();
        $this->citasService     = new CitasService();
        $this->validaciones     = new GeneralValidator();
    }

     //Obtener formularios activos
    public function consultar_citas($idusuario, $idtramiteconf) {
        $query = DB::table('tram_aux_citas_reservadas')
                    ->where(function($q) { 
                        $q->orWhere('CITA_STATUS',1)->orWhere('CITA_STATUS',2);
                    })
                    ->where(['CITA_IDTRAMITECONF' => $idtramiteconf, 'CITA_IDUSUARIO' => $idusuario])->get();

        return response()->json(['data' => $query]);
    }

    public function guardar_cita(Request $request){

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

    public function guardar_cita_local(Request $request) {
        $item = new Cls_Citas();
        $item->CITA_FOLIO       = $request->CITA_FOLIO;
        $item->CITA_STATUS      = $request->CITA_STATUS;
        $item->CITA_IDUSUARIO   = $request->CITA_IDUSUARIO;
        $item->CITA_IDTRAMITECONF =  $request->CITA_IDTRAMITECONF;
        $item->save();

        return response()->json(["estatus" => "success", "codigo" => 200, "mensaje" => "Cita guardada con éxito"]);
    }

    public function actualizar_cita(Request $request) {
        Cls_Citas::where('CITA_FOLIO', $request->CITA_FOLIO)->update(['CITA_STATUS' => $request->CITA_STATUS]);
        return response()->json([ "estatus" => "success", "codigo" => 200, "mensaje" => "Cita actualizada con éxito"]);
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

    /**
     * Retorna el listado de citas en base a un rangoo de fechas
     * @param Request $request
     * @return Response
     */
    public function getCitasFiltro(Request $request) {
        $validacion = $this->validaciones->listadoCitas($request);
        if($validacion !== true)
            return response()->json(['error' => $validacion->original], 403);

        $tramite    = $this->tramiteService->getTramitesSiegy($request->tramite_id);
        $result     = Cls_Citas_Calendario::getByFiltro($tramite,$request->edificio_id,$request->anio,$request->mes, $request->tipo);
        return response()->json($result);
    }

    /**
     * Retorna la vista de la agenda
     */
    public function agenda(Request $request) {
        $data['API_URL']    = env('APP_URL')."/api";
        $data['tramites']   = $this->tramiteService->getTramitesSiegy();
        return view('CITAS.agenda', compact('data'));
    }

    /**
     * Retorna las citas agendadas
     * @param Request $request
     * @return Response
     */
    public function getListado(Request $request){
        $order      = "desc";
        $order_by   = "c.CITA_IDTRAMITE";

        $query = DB::table('citas_tramites_calendario as c')
                    ->join('tram_mst_usuario as u', 'c.CITA_IDUSUARIO', '=', 'u.USUA_NIDUSUARIO')
                    ->select('c.*', 'u.USUA_CRFC AS rfc', 'u.USUA_CRFC as rfc', 'u.USUA_CNOMBRES as nombre', 'u.USUA_CPRIMER_APELLIDO as apellido_paterno', 'u.USUA_CSEGUNDO_APELLIDO as apellido_materno')
                    ->whereNull('deleted_at');

        if(!is_null($request->usuario_id))
            $query->where("c.CITA_IDUSUARIO", $request->usuario_id);
        if(!is_null($request->accede_id)) {
            $objTramite = $this->tramiteService->getTramitesSiegy($request->accede_id);
            if(is_null(!$objTramite))
                $query->where("c.CITA_IDTRAMITE", $objTramite->TRAM_NIDTRAMITE);
        }
        if(!is_null($request->modulo_id))
            $query->where("c.CITA_IDMODULO", $request->modulo_id);
        if(!is_null($request->fecha_inicio))
            $query->where("c.CITA_FECHA",">=", $request->fecha_inicio);
        if(!is_null($request->fecha_final))
            $query->where("c.CITA_FECHA","<=", $request->fecha_final);
        if(!is_null($request->confirmado))
            $query->where("c.confirmado", $request->confirmado);


        if(!is_null($request->order))
            $order = $request->order == 'asc'? "asc" : "desc";
        if(!is_null($request->order_by))
            $order_by = $request->order_by;

        $query->orderBy($order_by, $order);

        return response()->json(["data" => $query->get()], 200);
    }

    /**
     * Actualiza la cita agendada
     * @param Request $request
     * @return Response
     */
    public function update(Request $request){
        $statusCode = 200;

        try {
            $validacion = $this->validaciones->citas($request, 'update');
            if($validacion !== true)
                return response()->json(['error' => $validacion->original], 403);

            $result = $this->citasService->update((object)$request);
        } catch (Exception $ex) {
            $statusCode = 403;
            $result     = ['error' => $ex->getMessage()];
        }

        return response()->json($result, $statusCode);
    }

    /**
     * Retorna la disponibilidad para la cita de un tramte
     * @param Request $request
     * @return Response
     */
    public function disponibilidad(Request $request) {
        $statusCode = 200;

        try {
            $validacion = $this->validaciones->disponibilidad($request);
            if($validacion !== true)
                return response()->json(['error' => $validacion->original], 403);

            $objTramite = $this->tramiteService->getTramitesSiegy($request->accede_id);
            $resultado  = $this->citasService->disponibilidad($objTramite->TRAM_NIDTRAMITE, $request->modulo_id, $request->fecha);
        } catch (Exception $ex) {
            $statusCode = 403;
            $resultado  = ['error' => $ex->getMessage()];
        }

        return response()->json($resultado, $statusCode);
        
    }
    public function saveCita(Request $request) {
        $cita = new Cls_Citas_Calendario();
        // $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        // $folio = substr(str_shuffle($permitted_chars), 0, 10);

        $cita->CITA_IDUSUARIO = $request->CITA_IDUSUARIO;
        $cita->CITA_FECHA = $request->CITA_FECHA;
        $cita->CITA_HORA = $request->CITA_HORA;
        $cita->CITA_IDTRAMITE = $request->CITA_IDTRAMITE;
        $cita->CITA_IDMODULO = $request->CITA_IDMODULO;
        // $cita->CITA_FOLIO = $request->CITA_FOLIO;
        $anio = substr($request->CITA_FECHA, 0, 4);
        // $conteo = Cls_Citas_Calendario::where("CITA_IDTRAMITE", $request->CITA_IDTRAMITE)->count();
        $conteo = Cls_Citas_Calendario::count()+1;

        $cita->CITA_FOLIO = $anio."-".str_pad($conteo, 10, "0", STR_PAD_LEFT);

        if ($cita->save()) {
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
                <p><span>Folio:</span> '. $request->CITA_FOLIO .'.</p>
                <p><span>Fecha:</span> '. $request->CITA_FECHA .'.</p>
                <p><span>Hora:</span> '. $request->CITA_HORA .'.</p>
                <p><span>Municipio:</span> '.$request->MUNICIPIO.'.</p>
                <p><span>Módulo:</span> '.$request->MODULO.'.</p>
            ';

        $pdf = PDF::loadHTML($html)->setPaper('a4', 'portrait');
        // return $pdf->download($request->CITA_FOLIO.'.pdf');


        $path = storage_path();
        $archivoPDF = $path.'/app/public/'."CITA".$request->CITA_FOLIO.'.pdf';
        $pdf->save($archivoPDF);
        // return response()->json(["data" => "CITA".'.pdf']);
        return response()->json([
            "URL" => env("APP_URL")."/storage/CITA".$request->CITA_FOLIO.".pdf"
        ]);
    }

    public function deleteCita($id) {
        if(Cls_Citas_Calendario::deleteCita((int)$id)){
            return response()->json([
                "estatus" => "success",
                "codigo" => 200,
                "mensaje" => "Cita eliminada"
            ]);
        }
        return response()->json([
            "estatus" => "error",
            "codigo" => 500,
            "mensaje" => "No se elimino la cita"
        ], 500);
    }
    
}
