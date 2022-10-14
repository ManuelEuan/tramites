<?php

namespace App\Http\Controllers;

use File;
use DateTime;
use Exception;
use ZipArchive;
use App\Cls_Usuario;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Cls_Usuario_Tramite;
use Illuminate\Http\Request;
use App\Cls_Usuario_Concepto;
use App\Cls_Usuario_Documento;
use App\Cls_Usuario_Respuesta;
use App\Services\VariosService;
use PhpOffice\PhpWord\Settings;
use App\Services\TramiteService;
use Illuminate\Support\Facades\DB;
use App\Cls_UsuarioTramiteAnalista;
use App\Models\Cls_Citas_Calendario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

//asignar tramites
use App\Cls_Seguimiento_Servidor_Publico;
use App\Models\Cls_Formulario_Pregunta_Respuesta;

class TramitesController extends Controller
{
    protected $variosService;
    protected $tramiteService;
    public function __construct() {
        $this->variosService    = new VariosService();
        $this->tramiteService   = new TramiteService();
    }

    public function listado() {
        $tramites = [];
        return view('TRAMITES_CEMR.listado', compact('tramites'));
    }

    public function configurar_tramite() {
        return view('TRAMITES_CEMR.index');
    }

    public function find(Request $request)
    {
        $response = [];
        try {

            ## Read value
            /* $draw = $request->get('draw');
            $start = $request->get("start");
            $rowperpage = $request->get("length"); // Rows display per page

            $columnIndex_arr = $request->get('order');
            $columnName_arr = $request->get('columns');
            $order_arr = $request->get('order');
            $search_arr = $request->get('search');

            $columnIndex = $columnIndex_arr[0]['column']; // Column index
            $columnName = $columnName_arr[$columnIndex]['data']; // Column name
            $columnSortOrder = $order_arr[0]['dir']; // asc or desc
            $searchValue = $search_arr['value']; // Search value

            //Filter
            $filter = [];
            $filter['StrTexto'] = $searchValue;
            $filter['IntNumPagina'] = $searchValue === null ? intval($start) : 0;
            $filter['IntDesde'] = $searchValue === null ? intval($start) : 0;
            $filter['IntCantidadRegistros'] = intval($rowperpage);
            $filter['StrOrdenColumna'] = $columnName;
            $filter['StrOrdenDir'] = $columnSortOrder;

            $filter['fecha'] = $request->get('fecha') ?? "";
            $filter['folio'] = $request->get('folio') ?? "";
            $filter['tramite'] = is_null($request->get('tramite')) ? 0 : intval($request->get('tramite'));
            $filter['razonSocial'] = $request->get('razonSocial') ?? "";
            $filter['nombre'] = $request->get('nombre') ?? "";
            $filter['rfc'] = $request->get('rfc') ?? "";
            $filter['curp'] = $request->get('curp') ?? "";
            $filter['estatus'] = is_null($request->get('estatus')) ? 0 : intval($request->get('estatus'));
 
            $tramite_seguimiento = new Cls_Seguimiento_Servidor_Publico();
            $tramite_seguimiento->USTR_NIDUSUARIOTRAMITE = 0;
            $tramite_seguimiento->StrTexto =  $filter['StrTexto'] ?? "";
            $tramite_seguimiento->IntDesde = $filter['IntDesde'];
            $tramite_seguimiento->IntCantidadRegistros =  $filter['IntCantidadRegistros'];

            $tramite_seguimiento->fecha =  $filter['fecha'];
            $tramite_seguimiento->folio =  $filter['folio'];
            $tramite_seguimiento->tramite =  $filter['tramite'];
            $tramite_seguimiento->razonSocial =  $filter['razonSocial'];
            $tramite_seguimiento->nombre =  $filter['nombre'];
            $tramite_seguimiento->rfc =  $filter['rfc'];
            $tramite_seguimiento->curp =  $filter['curp'];
            $tramite_seguimiento->estatus =  $filter['estatus'];

            $tramite_seguimiento->ordenColumna =  $filter['StrOrdenColumna'] === null ? 'USTR_DFECHACREACION' : $filter['StrOrdenColumna'];
            $tramite_seguimiento->direccionOrden = $filter['StrOrdenColumna'] === null ? 'desc' :  $filter['StrOrdenDir'];

            //Validar tipo de usuario
            */
            $tramite_seguimiento = new Cls_Seguimiento_Servidor_Publico();
            if (Auth::user()->TRAM_CAT_ROL->ROL_CCLAVE === 'ADM') {
                $tramite_seguimiento->UsuarioID = 0;
            } else {
                $tramite_seguimiento->UsuarioID = Auth::user()->USUA_NIDUSUARIO;
            }

           // $result = $tramite_seguimiento->TRAM_SP_CONSULTAR_TRAMITES_SEGUIMIENTO();
            $result         =  $this->tramiteService->listadoSeguimiento($request);

            $tramites       = $result['result'];
            $totalRegistros = $result['total'];
            $mostrar=[];

            if(Auth::user()->TRAM_CAT_ROL->ROL_CCLAVE === 'ANTA'){
                $asignados = Cls_UsuarioTramiteAnalista::TramitesAnalista($tramite_seguimiento->UsuarioID);
                //$asignados[] = $tramite_seguimiento->UsuarioID;
                //$asignados[] = Auth::user()->TRAM_CAT_ROL->ROL_CCLAVE;

                foreach ($tramites as $key => $t) {
                    foreach ($asignados as $llave => $index) {
                        if($t->USTR_NIDUSUARIOTRAMITE == $index->USTR_NIDUSUARIOTRAMITE){
                            $t->rol = Auth::user()->TRAM_CAT_ROL->ROL_CCLAVE;

                            $mostrar[] = $t;

                            $diasH = $t->USTR_NDIASHABILESRESOLUCION;
                            $hoy = date('Y-m-d');
                            $fechaFinal = date('Y-m-d', strtotime($t->USTR_DFECHACREACION. ' + '.$diasH.' days'));
                            

                            if($t->USTR_NESTATUS == 4){
                                if(!empty($t->USTR_DFECHAESTATUS)){
                                    $diasN = $t->USTR_NDIASHABILESNOTIFICACION;
                                    $fechaFinalNotificacion = date('Y-m-d', strtotime($t->USTR_DFECHAESTATUS. ' + '.$diasN.' days'));
                                    if($hoy > $fechaFinalNotificacion){
                                        $tramite_seguimiento->ACTUALIZAR_STATUS($t->USTR_CFOLIO);
                                    }
                                }else{
                                    if($hoy > $fechaFinal){
                                        $tramite_seguimiento->ACTUALIZAR_STATUS($t->USTR_CFOLIO);
                                    }
                                }
                                
                            }elseif($t->USTR_NESTATUS != 10){
                                /*if($hoy > $fechaFinal){
                                    $tramite_seguimiento->ACTUALIZAR_STATUS_VENCIDO($t->USTR_CFOLIO);
                                }*/
                            }

                        }
                    }
                }
                $tramites = $mostrar;
                $totalRegistros=strval(count($tramites));
                $asignados =['rol' =>Auth::user()->TRAM_CAT_ROL->ROL_CCLAVE];
            }else{
                //$asignados =[$tramite_seguimiento->UsuarioID, 'rol' =>Auth::user()->TRAM_CAT_ROL->ROL_CCLAVE];
                $asignados =['rol' =>Auth::user()->TRAM_CAT_ROL->ROL_CCLAVE];
                foreach ($tramites as $key => $t) {
                    $t->rol = Auth::user()->TRAM_CAT_ROL->ROL_CCLAVE;
                    $t->asignado = Cls_UsuarioTramiteAnalista::VerificaAsignacion($t->USTR_NIDUSUARIOTRAMITE);

                    $diasH = $t->USTR_NDIASHABILESRESOLUCION;
                    $hoy = date('Y-m-d');
                    $fechaFinal = date('Y-m-d', strtotime($t->USTR_DFECHACREACION. ' + '.$diasH.' days'));
                    
                    if($t->USTR_NESTATUS == 4){
                        if(!empty($t->USTR_DFECHAESTATUS)){
                            $diasN = $t->USTR_NDIASHABILESNOTIFICACION;
                            $fechaFinalNotificacion = date('Y-m-d', strtotime($t->USTR_DFECHAESTATUS. ' + '.$diasN.' days'));
                            if($hoy > $fechaFinalNotificacion){
                                $tramite_seguimiento->ACTUALIZAR_STATUS($t->USTR_CFOLIO);
                            }
                        }else{
                            if($hoy > $fechaFinal){
                                $tramite_seguimiento->ACTUALIZAR_STATUS($t->USTR_CFOLIO);
                            }
                        }
                    }elseif($t->USTR_NESTATUS != 10){
                        /*if($hoy > $fechaFinal){
                            $tramite_seguimiento->ACTUALIZAR_STATUS_VENCIDO($t->USTR_CFOLIO);
                        }*/
                    }
                }
            }
            
            $response = [
                'recordsTotal'      => $totalRegistros,
                'recordsFiltered'   => $totalRegistros,
                'data'              =>  $tramites,
                'asignados'         => $asignados
            ];
        } catch (\Throwable $th) {
            $response = [
                'data'      => [],
                'error'     => $th->getMessage(),
                'code'      => 400,
                'mensaje'   => 'Ocurrió un error al obtener trámites',
            ];
        }

        return response()->json($response);
    }

    //Vista detalle
    public function detalle($id) {
        $result = Cls_Seguimiento_Servidor_Publico::TRAM_OBTENER_TRAMITE_SEGUIMIENTO($id);
        $tramite = $result[0];
        return view('TRAMITES_CEMR.detalles', compact('tramite'));
    }

    //Vista seguimiento
    public function seguimiento($id)
    {
        $var = $this->verifica_rol_analista_asignado($id);
        if($var){
            //Marcar trámite del ciudadano como Recibido
            Cls_Seguimiento_Servidor_Publico::TRAM_MARCAR_ESTATUS_REVISION_TRAMITE($id);
            $result = Cls_Seguimiento_Servidor_Publico::TRAM_OBTENER_TRAMITE_SEGUIMIENTO($id);
            $tramite = $result[0];

            //Secciones
            $secciones = DB::select(
                'SELECT * FROM tram_aux_seccion_seguimiento_tramite WHERE SSEGTRA_NIDUSUARIOTRAMITE = ? ORDER BY SSEGTRA_NIDSECCION_SEGUIMIENTO',
                array($id)
            );

            //Conceptos
            $conceptos = DB::select(
                'SELECT * FROM tram_mdv_usuario_concepto WHERE USCON_NIDUSUARIOTRAMITE = ?',
                array($id)
            );

            $resolutivos= Cls_Seguimiento_Servidor_Publico::TRAM_OBTENER_RESOLUTIVOS_CONFIGURADOS($tramite->USTR_NIDTRAMITE);
            $objTramite = $this->tramiteService->getTramite($tramite->USTR_NIDTRAMITE_ACCEDE);
            $result     = $this->tramiteService->getDetalle($objTramite->Id);
            $tramite->infoModulo                    = (array) $result['oficinas'][0];

            $tramite->EDF_VENTANILLA_SIN_CITA       = $result['oficinas'][0]->Name;
            $tramite->EDF_VENTANILLA_SIN_CITA_LAT   = $result['oficinas'][0]->Latitude;
            $tramite->EDF_VENTANILLA_SIN_CITA_LON   = $result['oficinas'][0]->Longitude;

            $cita = Cls_Citas_Calendario::where([
                    ["CITA_IDUSUARIO", $tramite->USTR_NIDUSUARIO],
                    ["CITA_IDTRAMITE", $tramite->USTR_NIDTRAMITE],
                    ["CITA_IDMODULO", $tramite->infoModulo['iId']],
                ])->orderBy('idcitas_tramites_calendario', 'DESC');

            $tramite->cita = ($cita->count() > 0
                ? array(
                        "ID" => $cita->first()->idcitas_tramites_calendario,
                        "USUARIO" => $cita->first()->CITA_IDUSUARIO,
                        "FECHA" => $cita->first()->CITA_FECHA,
                        "HORA" => $cita->first()->CITA_HORA,
                        "TRAMITE" => $cita->first()->CITA_IDTRAMITE,
                        "MODULO" => $cita->first()->CITA_IDMODULO,
                        "CONFIRMADO" => $cita->first()->CITA_CONFIRMADO,
                        "FOLIO" => $cita->first()->CITA_FOLIO,
                    )
                : array());

            return view('TRAMITES_CEMR.seguimiento', compact('tramite', 'secciones', 'conceptos', 'resolutivos'));
        }else{
            return redirect('/tramite_servicio_cemr');
        }
        
    }

    /**
     * Retorna el resolutivo en formato PDF y/o Doc
     * @param int $resolutivo_Id
     * @param int $tramite_Id
     * @param int $tipo
     * @return File
     */
    public function generatePrevioResolutivo($resolutivo_Id,$tramite_Id, $tipo = 0 ) {
        $resolutivo = Cls_Seguimiento_Servidor_Publico::TRAM_OBTENER_RESOLUTIVO($resolutivo_Id)[0];
        $mapeoCampos = Cls_Seguimiento_Servidor_Publico::TRAM_OBTENER_RESOLUTIVO_MAPEO($resolutivo_Id, $tramite_Id);

        /* Set the PDF Engine Renderer Path */  
        $domPdfPath = base_path('vendor/dompdf/dompdf');
        Settings::setPdfRendererPath($domPdfPath);
        Settings::setPdfRendererName('DomPDF');

        $rutaBase = public_path() . '/docts/resolutivos/';
        $rutaResolutivo =   $rutaBase . $resolutivo->RESO_CNAMEFILE;
        $nameFile = explode(".", $resolutivo->RESO_CNAMEFILE);
        /*@ Reading doc file */
        $template = new \PhpOffice\PhpWord\TemplateProcessor($rutaResolutivo);

        foreach ($mapeoCampos as $campo) {
            $pregunta = Cls_Formulario_Pregunta_Respuesta::where('FORM_NPREGUNTAID', $campo->USRE_NIDPREGUNTA)->first();
            
            if(!is_null($pregunta) && $pregunta->FORM_CTIPORESPUESTA == 'catalogo' ) {
                $json   = json_decode($campo->USRE_CRESPUESTA);
                $texto  = "";

                foreach($json as $key => $value){
                    $query = DB::table($pregunta->FORM_CVALOR)->where('id', $value->id)->first();
                    
                    if(!is_null($query))
                        $texto = $key == 0 ? $query->nombre : $texto.", ". $query->nombre;
                }
                $campo->USRE_CRESPUESTA = $texto;
            }

            /*@ Replacing variables in doc file */
            $template->setValue($campo->TRAM_CNOMBRECAMPO, $campo->USRE_CRESPUESTA);
        }

        $pathQR = $this->variosService->generaQR(url('/') . '/docts/resolutivos/resolutivo_' . $nameFile[0] . '.pdf');
        $template->setImageValue('qrcode', array('path' =>  $pathQR, 'width' => 100, 'height' => 100, 'ratio' => true));

        /*@ Save Temporary Word File With New Name */
        $saveDocPath = $rutaBase . 'resolutivo_'. $nameFile[0] .'.docx';
        $template->saveAs($saveDocPath);

        if($tipo == 0)
            return redirect('/docts/resolutivos/resolutivo_' . $nameFile[0] . '.docx');


        // Load temporarily create word file
        $Content = \PhpOffice\PhpWord\IOFactory::load($saveDocPath);

        //Save it into PDF
        $savePdfPath = $rutaBase . 'resolutivo_'. $nameFile[0] .'.pdf';

        /*@ If already PDF exists then delete it */
        if (file_exists($savePdfPath)) {
            unlink($savePdfPath);
        }

        //Save it into PDF
        $PDFWriter = \PhpOffice\PhpWord\IOFactory::createWriter($Content, 'PDF');
        $PDFWriter->save($savePdfPath);

        /*@ Remove temporarily created word file */
        if (file_exists($saveDocPath)) {
            unlink($saveDocPath);
        }

        return redirect('/docts/resolutivos/resolutivo_' . $nameFile[0] . '.pdf');
    }

    //Obtener trámite en seguimiento
    public function obtener_tramite_seguimiento($id) {
        $tramite = Cls_Seguimiento_Servidor_Publico::TRAM_CONSULTAR_CONFIGURACION_TRAMITE_PUBLICO($id);
        $configaracion =  $tramite;

        $USTR_NIDUSUARIOTRAMITE = $tramite['tramite'][0]->USTR_NIDUSUARIOTRAMITE;

        try {
            //Respuestas
            $respuestas = Cls_Usuario_Respuesta::where('USRE_NIDUSUARIOTRAMITE', $USTR_NIDUSUARIOTRAMITE)
                ->select('*')
                ->get()->toArray();
    
            foreach ($configaracion['formularios'] as $form) {
                foreach ($form->secciones as $sec) {
                    foreach ($sec->preguntas as $preg) {
                        foreach ($preg->respuestas as $resp) {
                            $resp->FORM_CVALOR_RESPUESTA = "";
    
                            foreach ($respuestas as $_resp) {
                                if ($preg->FORM_NID == $_resp['USRE_NIDPREGUNTA']) {
                                    $preg->estatus = $_resp['USRE_NESTATUS'];
                                    $preg->observaciones = $_resp['USRE_COBSERVACION'];
                                }
    
                                switch ($preg->FORM_CTIPORESPUESTA) {
                                    case "multiple":
                                        if ($resp->FORM_NID == $_resp['USRE_CRESPUESTA']) {
                                            $resp->FORM_CVALOR_RESPUESTA = "checked";
                                            break;
                                        }
                                        break;
                                    case "unica":
                                        if ($resp->FORM_NID == $_resp['USRE_CRESPUESTA']) {
                                            $resp->FORM_CVALOR_RESPUESTA = "checked";
                                            break;
                                        }
                                        break;
                                    case "especial":
                                        foreach ($resp->respuestas_especial as $esp) {
                                            switch ($resp->FORM_CTIPORESPUESTAESPECIAL) {
                                                case "opciones":
    
                                                    if ($esp->FORM_NPREGUNTARESPUESTAID == $_resp['USRE_NIDPREGUNTARESPUESTA']) {
                                                        if ($esp->FORM_NID == $_resp['USRE_CRESPUESTA']) {
                                                            $esp->FORM_CVALOR_RESPUESTA = "selected";
                                                            break;
                                                        }
                                                    }
                                                    break;
                                                default:
                                                    if ($esp->FORM_NPREGUNTARESPUESTAID == $_resp['USRE_NIDPREGUNTARESPUESTA']) {
                                                        $esp->FORM_CVALOR_RESPUESTA = $_resp['USRE_CRESPUESTA'];
                                                        break;
                                                    }
                                                    break;
                                            }
                                        }
                                        break;
                                    case "catalogo":
                                        if ($preg->FORM_NID == $_resp['USRE_NIDPREGUNTA']) {
                                            $json       = json_decode($_resp['USRE_CRESPUESTA']);
                                            $array      = array();

                                            if(is_array($json)){
                                                foreach($json as $key => $value){
                                                    $query = DB::table($resp->FORM_CVALOR)->where('id', $value->id)->first();
    
                                                    if(!is_null($query)){
                                                        $format         =  new DateTime($value->fecha);
                                                        $query->fecha   = $format->format('d-m-Y');
                                                        array_push($array, $query);
                                                    }
                                                }
                                            }
                                            else {
                                                $query = DB::table($resp->FORM_CVALOR)->where('id', $json)->first();
                                                array_push($array, $query);
                                            }

                                            $resp->FORM_CVALOR_RESPUESTA = $array;
                                            break;
                                        }
                                        break;
                                    default:
    
                                        if ($resp->FORM_NPREGUNTAID === $_resp['USRE_NIDPREGUNTA']) {
                                            $resp->FORM_CVALOR_RESPUESTA = $_resp['USRE_CRESPUESTA'];
                                            break;
                                        }
                                        break;
                                }
                            }
                        }
                    }
                }
            }
    
            //Documentos
            $documentos = Cls_Usuario_Documento::where('USDO_NIDUSUARIOTRAMITE', $USTR_NIDUSUARIOTRAMITE)
                ->select('*')
                ->get()->toArray();
    
            foreach ($configaracion['documentos'] as $doc) {
                $doc->TRAD_CRUTADOC = "";
                $doc->TRAD_NPESO = 0;
                $doc->existe = 0;
                foreach ($documentos as $_doc) {
                    if ($doc->TRAD_NIDTRAMITEDOCUMENTO === $_doc['USDO_NIDTRAMITEDOCUMENTO']) {
                        $doc->existe = 1;
                        $doc->USDO_NIDUSUARIORESP = $_doc['USDO_NIDUSUARIORESP'];
                        $doc->TRAD_NESTATUS = $_doc['USDO_NESTATUS'];
                        $doc->TRAD_COBSERVACION = $_doc['USDO_COBSERVACION'];
                        $doc->TRAD_CEXTENSION = $_doc['USDO_CEXTENSION'];
                        $doc->TRAD_CRUTADOC = $_doc['USDO_CRUTADOC'];
                        $doc->TRAD_NPESO = $_doc['USDO_NPESO'];
                        $doc->idDocExpediente = $_doc['idDocExpediente'];
                        $consulartVigencia = $_doc['VIGENCIA_FIN'];//Cls_Seguimiento_Servidor_Publico::getVigencia($doc->idDocExpediente);
                        if($consulartVigencia==NULL){$consulartVigencia='';};
                        $doc->vigencia = $consulartVigencia;// $consulartVigencia->vigencia ?? "";
                        break;
                    }
                }
            }
    
            $configaracion['secciones_estatus'] = Cls_Seguimiento_Servidor_Publico::TRAM_OBTENER_SECCIONES_ESTATUS($id);
            $configaracion['resolutivos_finales'] = Cls_Seguimiento_Servidor_Publico::TRAM_OBTENER_RESOLUTIVOS_FINALES($id);
            $configaracion['resolutivos_configurados'] = Cls_Seguimiento_Servidor_Publico::TRAM_OBTENER_RESOLUTIVOS_CONFIGURADOS($id);
    
            $tramite['configuracion'] = $configaracion;
        } catch (Exception $ex) {
            dd($ex);
        }
        return response()->json($tramite);
    }

    /*----------------------- Formulario ---------------------------- */
    //Aceptar seccion de formulario
    public function aprobar_seccion_formulario(Request $request)
    {
        $response = [];
        try {

            Cls_Seguimiento_Servidor_Publico::TRAM_ACEPTAR_SECCION_FORMULARIO($request->CONF_NIDUSUARIOTRAMITE, $request->SSEGTRA_NIDSECCION_SEGUIMIENTO);
            $this->enviar_correo_aprobacion($request->CONF_NIDUSUARIOTRAMITE);
            if($request->APROBAR_PAGO){
                Cls_UsuarioTramiteAnalista::ApruebaTramite($request->CONF_NIDUSUARIOTRAMITE);
            }
            
            foreach($request->CONF_DOCUMENTOS as $key => $value){
                if($value["vigencia"] != "" && $value["documento_id"] != ""){
                    Cls_Usuario::updateVigencia($value["documento_id"], $value["vigencia"]);
                }
            }
            $response = [
                "estatus" => "success",
                "mensaje" => "¡Éxito! acción realizada con éxito.",
                "codigo" => 200
            ];
        } catch (\Throwable $th) {
            $response = [
                "estatus" => "error",
                "mensaje" => "Ocurrió un error al aprobar: " . $th->getMessage(),
                "codigo" => 400
            ];
        }

        return response()->json($response);
    }

    //Indicar seccion formulario con datos incompletos
    public function seccion_formulario_incompleta(Request $request)
    {
        $response = [];
        try {

            //Marcamos estatus del trámite en revision y estatus de seccion formulario como incompleto
            Cls_Seguimiento_Servidor_Publico::TRAM_INCOMPLETA_SECCION_FORMULARIO($request->CONF_NIDUSUARIOTRAMITE);

            //Cambiar estatus y observación de preguntas
            if (count($request->CONF_PREGUNTAS)) {

                foreach ($request->CONF_PREGUNTAS as $pregunta) {
                    $observaciones = '';
                    if(isset($pregunta['observaciones'])){

                        $observaciones = $pregunta['observaciones'];
                    }
                    Cls_Seguimiento_Servidor_Publico::TRAM_ESTATUS_PREGUNTA($request->CONF_NIDUSUARIOTRAMITE, $pregunta['pregunta_id'], $pregunta['estatus'], $observaciones);
                }
            }

            //Cambiar estatus y observación de documentos
            $TEST_MS='';
            if (isset($request->CONF_DOCUMENTOS)) {
                if (count($request->CONF_DOCUMENTOS)) {

                    foreach ($request->CONF_DOCUMENTOS as $documento) {

                        Cls_Seguimiento_Servidor_Publico::TRAM_ESTATUS_DOCUMENTO_VIG($request->CONF_NIDUSUARIOTRAMITE,
                        $documento['documento_id'], $documento['estatus'], $documento['observaciones'], $documento['vigencia']);
                        //Aqui se agrega la vigencia//
                        //getIdDocExp afecta tram_mdv_usuariordocumento, el parametro es para USDO_NIDTRAMITEDOCUMENTO
                        $idDocExp = Cls_Seguimiento_Servidor_Publico::getIdDocExp($documento['documento_id']);
                        ////////////////
                        //
                        $TEST_MS = $TEST_MS.'( DOCid: '.$documento['documento_id'];
                        if(isset($idDocExp->id)){
                            //$TEST_MS = $TEST_MS.'( idDocExp1: '.$idDocExp->id;
                            //modificamos la vigencia en la tabla tram_mst_documentosbase
                            Cls_Seguimiento_Servidor_Publico::ActualizarDocsUsuario($idDocExp->id, $documento['vigencia']);
                        }else{//si el idDocsExpediente no existe

                            $idDocExp2 = Cls_Seguimiento_Servidor_Publico::getnombDocExp($documento['documento_id']);
                            if(isset($idDocExp2->USDO_CDOCNOMBRE)){
                                //$TEST_MS = $TEST_MS.$idDocExp2->USDO_CDOCNOMBRE;
                                //$idDocExp3 = Cls_Seguimiento_Servidor_Publico::getuserDocExp($documento['documento_id']);
                                $idDocExp3 = Cls_Seguimiento_Servidor_Publico::getIdusrTram($request->CONF_NIDUSUARIOTRAMITE);
                                if(isset($idDocExp3->id)){
                                    //$TEST_MS = $TEST_MS.' . u: '.$idDocExp3->id;

                                    $USDO_CDOCNOMBRE =$idDocExp2->USDO_CDOCNOMBRE;
                                    $USDO_NIDUSUARIOBASE =$idDocExp3->id;

                                    $id_doc_config = Cls_Seguimiento_Servidor_Publico::getConfigDocumentos($USDO_CDOCNOMBRE);
                                    if(isset($id_doc_config->id)){
                                        $id_doc_base='';
                                        $doc_base = Cls_Seguimiento_Servidor_Publico::getDocBase($id_doc_config->id, $USDO_NIDUSUARIOBASE);
                                        foreach ($doc_base as $key => $H) {
                                            $id_doc_base = $H->id;
                                        }
                                        if($id_doc_base!=''){
                                            $TEST_MS = $TEST_MS.'--> SAVE  '.$id_doc_base;
                                            Cls_Seguimiento_Servidor_Publico::ActualizarDocVigencia($id_doc_base, $documento['vigencia']);
                                        };
                                        //*/
                                    };

                                };

                            };
                        };
                        $TEST_MS = '';
                    }
                }
            }
            //Enviar notificacion al ciudadano
            $mensaje_corto = "Usted tiene una notificación sobre datos incompletos en la sección de formularios del trámite " . $request->nombre_tramite . ", el cual tiene el número de folio " . $request->folio_tramite . ".";
            Cls_Seguimiento_Servidor_Publico::crear_notificacion($request->CONF_NIDUSUARIOTRAMITE, "Información incompleta", $request->CONF_NOTIFICACION, $mensaje_corto, $request->nombre_tramite, $request->SSEGTRA_NIDSECCION_SEGUIMIENTO, 1);

            $rutaNew =  route('seguimiento_tramite_servidor', ['id' =>  $request->CONF_NIDUSUARIOTRAMITE]);

            $response = [
                "estatus" => "success",
                "codigo" => 200,
                "mensaje" => "Se ha notificado al ciudadano los campos y documentos a corregir".$TEST_MS ,
                "ruta" => $rutaNew
            ];
        } catch (\Throwable $e) {
            $response = [
                "estatus" => "error",
                "codigo" => 400,
                "mensaje" => "Ocurrió una excepción, favor de contactar al administrador del sistema , " . $e->getMessage()
            ];
        }

        return response()->json($response);
    }

    /*-------------- Revision de documentos ------------------ */
    //Aceptar sección revisión de documentación
    public function aprobar_seccion_revision_documentos(Request $request)
    {
        $response = [];
        try {

            Cls_Seguimiento_Servidor_Publico::TRAM_ACEPTAR_SECCION_REVISION_DOCUMENTOS($request->CONF_NIDUSUARIOTRAMITE, $request->SSEGTRA_NIDSECCION_SEGUIMIENTO);
            $this->enviar_correo_aprobacion($request->CONF_NIDUSUARIOTRAMITE);
            if (count($request->CONF_DOCUMENTOS)) {

                foreach ($request->CONF_DOCUMENTOS as $documento) {
                    //Aqui se hace la busqueda.
                    $idDocExp = Cls_Seguimiento_Servidor_Publico::getIdDocExp($documento['documento_id']);
                    if(isset($idDocExp->id)){
                        Cls_Seguimiento_Servidor_Publico::ActualizarDocsUsuario($idDocExp->id, $documento['vigencia']);
                    }

                }
            }

            $response = [
                "estatus" => "success",
                "mensaje" => "¡Éxito! acción realizada con éxito.",
                "codigo" => 200
            ];
        } catch (\Throwable $th) {
            $response = [
                "estatus" => "error",
                "mensaje" => "Ocurrió un error al aprobar: " . $th->getMessage(),
                "codigo" => 400
            ];
        }
        return response()->json($response);
    }

    //Indicar seccion revisión de documentación con datos incompletos
    public function seccion_revision_incompleta(Request $request)
    {
        $response = [];
        try {

            //Marcamos estatus del trámite en revision y estatus de seccion formulario como incompleto
            Cls_Seguimiento_Servidor_Publico::TRAM_INCOMPLETA_SECCION_REVISION_DOCUMENTOS($request->CONF_NIDUSUARIOTRAMITE, $request->SSEGTRA_NIDSECCION_SEGUIMIENTO);

            //Cambiar estatus y observación de preguntas
            if (count($request->CONF_PREGUNTAS)) {

                foreach ($request->CONF_PREGUNTAS as $pregunta) {

                    Cls_Seguimiento_Servidor_Publico::TRAM_ESTATUS_PREGUNTA($request->CONF_NIDUSUARIOTRAMITE, $pregunta['pregunta_id'], $pregunta['estatus'], $pregunta['observaciones']);
                }
            }

            //Cambiar estatus y observación de documentos
            if (count($request->CONF_DOCUMENTOS)) {

                foreach ($request->CONF_DOCUMENTOS as $documento) {

                    Cls_Seguimiento_Servidor_Publico::TRAM_ESTATUS_DOCUMENTO_VIG($request->CONF_NIDUSUARIOTRAMITE, $documento['documento_id'], $documento['estatus'], $documento['observaciones'], $documento['vigencia']);
                    //Aqui se hace la busqueda.
                    $idDocExp = Cls_Seguimiento_Servidor_Publico::getIdDocExp($documento['documento_id']);
                    if(isset($idDocExp->id)){
                        Cls_Seguimiento_Servidor_Publico::ActualizarDocsUsuario($idDocExp->id, $documento['vigencia']);
                    }

                }
            }

            //Enviar notificacion al ciudadano
            $mensaje_corto = "Usted tiene una notificación sobre datos incompletos en la sección de revisión de documentación del trámite " . $request->nombre_tramite . ", el cual tiene el número de folio " . $request->folio_tramite . ".";
            Cls_Seguimiento_Servidor_Publico::crear_notificacion($request->CONF_NIDUSUARIOTRAMITE, "Información incompleta", $request->CONF_NOTIFICACION, $mensaje_corto, $request->nombre_tramite, $request->SSEGTRA_NIDSECCION_SEGUIMIENTO, 3);

            $rutaNew =  route('seguimiento_tramite_servidor', ['id' =>  $request->CONF_NIDUSUARIOTRAMITE]);

            $response = [
                "estatus" => "success",
                "codigo" => 200,
                "mensaje" => "Se ha notificado al ciudadano los campos y documentos a corregir",
                "ruta" => $rutaNew
            ];
        } catch (\Throwable $e) {
            $response = [
                "estatus" => "error",
                "codigo" => 400,
                "mensaje" => "Ocurrió una excepción, favor de contactar al administrador del sistema , " . $e->getMessage()
            ];
        }

        return response()->json($response);
    }

    /*--------------------- Cita --------------------------*/
    public function aprobar_seccion_cita(Request $request)
    {
        $response = [];
        try {

            Cls_Seguimiento_Servidor_Publico::TRAM_ACEPTAR_SECCION_CITA($request->CONF_NIDUSUARIOTRAMITE, $request->SSEGTRA_NIDSECCION_SEGUIMIENTO);
            $this->enviar_correo_aprobacion($request->CONF_NIDUSUARIOTRAMITE);

            Cls_Citas_Calendario::aprobarCita($request->IDCITA);

            $response = [
                "estatus" => "success",
                "mensaje" => "¡Éxito! acción realizada con éxito.",
                "codigo" => 200
            ];
        } catch (\Throwable $th) {
            $response = [
                "estatus" => "error",
                "mensaje" => "Ocurrió un error al aprobar: " . $th->getMessage(),
                "codigo" => 400
            ];
        }
        return response()->json($response);
    }

    public function reprogramar_seccion_cita(Request $request)
    {
        $response = [];
        try {

            Cls_Seguimiento_Servidor_Publico::TRAM_REPROGRAMACION_SECCION_CITA($request->CONF_NIDUSUARIOTRAMITE, $request->SSEGTRA_NIDSECCION_SEGUIMIENTO);

            //Enviar notificacion al ciudadano
            $mensaje_corto = "Usted tiene una notificación sobre el estatus de su cita en línea para el trámite " . $request->nombre_tramite . ", el cual tiene el número de folio " . $request->folio_tramite . ".";
            Cls_Seguimiento_Servidor_Publico::crear_notificacion($request->CONF_NIDUSUARIOTRAMITE, "Reprogramación de cita en línea", $request->CONF_NOTIFICACION, $mensaje_corto, $request->nombre_tramite, $request->SSEGTRA_NIDSECCION_SEGUIMIENTO, 2);

            $response = [
                "estatus" => "success",
                "codigo" => 200,
                "mensaje" => "Se ha notificado al ciudadano de la reprogramación de la cita",
            ];
        } catch (\Throwable $th) {
            $response = [
                "estatus" => "error",
                "mensaje" => "Ocurrió un error al aprobar: " . $th->getMessage(),
                "codigo" => 400
            ];
        }

        return response()->json($response);
    }

    //--------------- Ventanilla sin cita ----------------
    public function aprobar_seccion_ventanilla(Request $request)
    {
        $response = [];
        try {

            Cls_Seguimiento_Servidor_Publico::TRAM_ACEPTAR_SECCION_VENTANILLA($request->CONF_NIDUSUARIOTRAMITE, $request->SSEGTRA_NIDSECCION_SEGUIMIENTO);
            $this->enviar_correo_aprobacion($request->CONF_NIDUSUARIOTRAMITE);

            $response = [
                "estatus" => "success",
                "mensaje" => "¡Éxito! acción realizada con éxito.",
                "codigo" => 200
            ];
        } catch (\Throwable $th) {
            $response = [
                "estatus" => "error",
                "mensaje" => "Ocurrió un error al aprobar: " . $th->getMessage(),
                "codigo" => 400
            ];
        }
        return response()->json($response);
    }

    //--------------- Pago en linea ----------------
    public function aprobar_seccion_pago(Request $request)
    {
        $response = [];
        try {

            Cls_Seguimiento_Servidor_Publico::TRAM_ACEPTAR_SECCION_PAGO($request->CONF_NIDUSUARIOTRAMITE, $request->SSEGTRA_NIDSECCION_SEGUIMIENTO);
            $this->enviar_correo_aprobacion($request->CONF_NIDUSUARIOTRAMITE);

            $response = [
                "estatus" => "success",
                "mensaje" => "¡Éxito! acción realizada con éxito.",
                "codigo" => 200
            ];
        } catch (\Throwable $th) {
            $response = [
                "estatus" => "error",
                "mensaje" => "Ocurrió un error al aprobar: " . $th->getMessage(),
                "codigo" => 400
            ];
        }
        return response()->json($response);
    }

    //--------------- Modulo de analisis interno del area ----------------
    public function aprobar_seccion_analisis_interno(Request $request)
    {
        $response = [];
        try {

            Cls_Seguimiento_Servidor_Publico::TRAM_ACEPTAR_SECCION_ANALISIS_INTERNO($request->CONF_NIDUSUARIOTRAMITE, $request->SSEGTRA_NIDSECCION_SEGUIMIENTO);
            $this->enviar_correo_aprobacion($request->CONF_NIDUSUARIOTRAMITE);

            $response = [
                "estatus" => "success",
                "mensaje" => "¡Éxito! acción realizada con éxito.",
                "codigo" => 200
            ];
        } catch (\Throwable $th) {
            $response = [
                "estatus" => "error",
                "mensaje" => "Ocurrió un error al aprobar: " . $th->getMessage(),
                "codigo" => 400
            ];
        }
        return response()->json($response);
    }

    //--------------- Resolutivo electronico ----------------
    public function emitir_resolutivo(Request $request)
    {
        $response = [];
        try {

            $Estatus = 0;

            if ($request->estatus_resolutivo == "aprobado") {
                //Terminado
                $Estatus = 8;
            } else if ($request->estatus_resolutivo == "rechazado") {
                //Rechazado
                $Estatus = 9;
            } else {
                $response = [
                    "estatus" => "warning",
                    "mensaje" => "Es necesario seleccionar el estatus del resolutivo",
                    "codigo" => 400
                ];
                return response()->json($response);
            }

            if (!($request->file('documento_resolutivo'))) {
                $response = [
                    "estatus" => "warning",
                    "mensaje" => "Es necesario seleccionar un documento",
                    "codigo" => 400
                ];
                return response()->json($response);
            }

            $File = $request->file('documento_resolutivo');
            $IntSize = $File->getSize();
            $StrExtension = $File->getClientOriginalExtension();
            $StrName = rand() . '.' . $StrExtension;
            $File->move(public_path('files/documentos/'), $StrName);

            $CONF_NIDUSUARIOTRAMITE = $request->CONF_NIDUSUARIOTRAMITE;

            //Actualizamos estatus de seccion de resolutivo y cambiamos estatus general del trámite
            Cls_Seguimiento_Servidor_Publico::TRAM_ACEPTAR_SECCION_RESOLUTIVO($CONF_NIDUSUARIOTRAMITE, $Estatus, $request->SSEGTRA_NIDSECCION_SEGUIMIENTO);

            //Guardamos path de resolutivo
            $ruta_doc = "files/documentos/" . $StrName;
            Cls_Seguimiento_Servidor_Publico::TRAM_GUARDAR_PATH_RESOLUTIVO($CONF_NIDUSUARIOTRAMITE, $ruta_doc, $IntSize, $StrExtension, $request->SSEGTRA_NIDSECCION_SEGUIMIENTO);
            $this->enviar_correo_aprobacion($CONF_NIDUSUARIOTRAMITE);

            $response = [
                "estatus" => "success",
                "mensaje" => "¡Éxito! acción realizada con éxito.",
                "codigo" => 200,
            ];
        } catch (\Throwable $th) {
            $response = [
                "estatus" => "error",
                "mensaje" => "Ocurrió un error al aprobar: " . $th->getMessage(),
                "codigo" => 400
            ];
        }
        return response()->json($response);
    }

    //---------------Rechazar trámite ----------------
    public function rechazar_tramite(Request $request)
    {
        $response = [];
        try {

            Cls_Seguimiento_Servidor_Publico::TRAM_RECHAZAR_TRAMITE($request->CONF_NIDUSUARIOTRAMITE);

            if($request->IDCITA != null || $request->IDCITA != undefined || $request->IDCITA != "") {
                Cls_Citas_Calendario::deleteCita($request->IDCITA);
            }

            //Enviar notificacion de rechazo al ciudadano
            $mensaje_corto = "Usted tiene una notificación sobre el rechazo del trámite " . $request->nombre_tramite . ", el cual tiene el número de folio " . $request->folio_tramite . ".";
            Cls_Seguimiento_Servidor_Publico::crear_notificacion($request->CONF_NIDUSUARIOTRAMITE, "Rechazo de trámite", $request->CONF_NOTIFICACION, $mensaje_corto, $request->nombre_tramite, $request->CONF_NIDSECCION, 3);

            $response = [
                "estatus" => "success",
                "mensaje" => "¡Éxito! acción realizada con éxito.",
                "codigo" => 200
            ];
        } catch (\Throwable $th) {
            $response = [
                "estatus" => "error",
                "mensaje" => "Ocurrió un error al rechazar: " . $th->getMessage(),
                "codigo" => 400
            ];
        }
        return response()->json($response);
    }

    //Enviar correo de aprobacion de trámite
    private function enviar_correo_aprobacion($NIDUSUARIOTRAMITE)
    {
        try {

            $tramite = Cls_Seguimiento_Servidor_Publico::obtener_tramite_usuario($NIDUSUARIOTRAMITE);

            $ObjData['_correo'] = $tramite[0]->USTR_CCORREO_USUARIO;
            $ObjData['_nombre_usuario'] = $tramite[0]->USTR_CNOMBRE_USUARIO;
            $ObjData['_nombre_tramite'] = $tramite[0]->TRAM_CNOMBRE;
            $ObjData['_folio_tramite'] = $tramite[0]->USTR_CFOLIO;
            $ObjData['_homoclave_tramite'] = "H_CLAVE";
            $ObjData['_unidad_administrativa'] = $tramite[0]->TRAM_CCENTRO;
            $ObjData['_secretaria'] = $tramite[0]->TRAM_CCENTRO;
            $ObjData['_fecha_hora'] = now();
            $ObjData['_fecha_maxima'] = now();

            Mail::send('MSTP_MAIL.notificacion_aprobacion', $ObjData, function ($message) use ($ObjData) {
                $message->from(env('MAIL_USERNAME'), 'Sistema de Tramites Digitales Queretaro');
                $message->to($ObjData['_correo'], '')->subject('Aviso de trámite');
            });

            return response()->json([
                "Mensaje" => "Correo enviando con exito"
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "error" => "error: " . $th->getMessage(),
                "id" => $NIDUSUARIOTRAMITE
            ]);
        }
    }

    //Guardamos conceptos por tramite y seccion
    public function guardar_conceptos(Request $request)
    {
        $resp_selected = array();
        $resp_cantidad = array();

        foreach ($request->all() as $key => $value) {
            $a = substr($key, 0, 7);
            $b = substr($key, 0, 7);

            if ($a == 'respc1_') {
                $resp_selected[$key] = $value;
            }
            if ($b == 'respc2_') {
                $resp_cantidad[$key] = $value;
            }
        }

        //Limpiar
        Cls_Usuario_Concepto::where(['USCON_NIDUSUARIOTRAMITE' => $request->txtIdUsuarioTramite, 'USCON_NIDSECCION' => $request->txtIdSeccion])
            ->update([
                'USCON_NACTIVO' => 0,
                'USCON_NCANTIDAD' => null,
            ]);

        foreach ($resp_selected as $key => $value) {
            foreach ($resp_cantidad as $key2 => $cantidad) {
                $id = explode("_", $key2);
                //Validar USCON_NIDUSUARIOCONCEPTO
                if ($value == $id[1]) {
                    Cls_Usuario_Concepto::where('USCON_NIDUSUARIOCONCEPTO', $value)
                        ->update([
                            'USCON_NACTIVO' => 1,
                            'USCON_NCANTIDAD' => $cantidad,
                        ]);
                }
            }
        }


        $response = [
            'codigo' => 200,
            'status' => "success",
            'message' => 'Los datos se han guardado correctamente.'
        ];

        return Response()->json($response);
    }

    //------------------------- Descarga de reportes ------------------------
    public function download_tramite($id)
    {
        //Se trámite y formulario
        try {
            $tramite_ = Cls_Seguimiento_Servidor_Publico::TRAM_CONSULTAR_CONFIGURACION_TRAMITE_PUBLICO($id);
            $configuracion =  $tramite_;
            $USTR_NIDUSUARIOTRAMITE = $tramite_['tramite'][0]->USTR_NIDUSUARIOTRAMITE;

            //Respuestas
            $respuestas = Cls_Usuario_Respuesta::where('USRE_NIDUSUARIOTRAMITE', $USTR_NIDUSUARIOTRAMITE)->orderBy('USRE_NIDUSUARIORESP','DESC')->get();
            foreach ($configuracion['formularios'] as $form) {
                foreach ($form->secciones as $sec) {
                    foreach ($sec->preguntas as $preg) {
                        foreach ($preg->respuestas as $resp) {
                            $resp->FORM_CVALOR_RESPUESTA = "";

                            foreach ($respuestas as $_resp) {
                                if ($preg->FORM_NID == $_resp['USRE_NIDPREGUNTA']) {
                                    $preg->estatus = $_resp['USRE_NESTATUS'];
                                    $preg->observaciones = $_resp['USRE_COBSERVACION'];
                                }

                                switch ($preg->FORM_CTIPORESPUESTA) {
                                    case "multiple":
                                        if ($resp->FORM_NID == $_resp['USRE_CRESPUESTA']) {
                                            $resp->FORM_CVALOR_RESPUESTA = "checked";
                                            break;
                                        }
                                        break;
                                    case "unica":
                                        if ($resp->FORM_NID == $_resp['USRE_CRESPUESTA']) {
                                            $resp->FORM_CVALOR_RESPUESTA = "checked";
                                            break;
                                        }
                                        break;
                                    case "especial":
                                        foreach ($resp->respuestas_especial as $esp) {
                                            switch ($resp->FORM_CTIPORESPUESTAESPECIAL) {
                                                case "opciones":

                                                    if ($esp->FORM_NPREGUNTARESPUESTAID == $_resp['USRE_NIDPREGUNTARESPUESTA']) {
                                                        if ($esp->FORM_NID == $_resp['USRE_CRESPUESTA']) {
                                                            $esp->FORM_CVALOR_RESPUESTA = "selected";
                                                            break;
                                                        }
                                                    }
                                                    break;
                                                default:
                                                    if ($esp->FORM_NPREGUNTARESPUESTAID == $_resp['USRE_NIDPREGUNTARESPUESTA']) {
                                                        $esp->FORM_CVALOR_RESPUESTA = $_resp['USRE_CRESPUESTA'];
                                                        break;
                                                    }
                                                    break;
                                            }
                                        }
                                        break;
                                    case "catalogo":
                                        if ($preg->FORM_NID == $_resp['USRE_NIDPREGUNTA']){
                                            $json   = json_decode($_resp->USRE_CRESPUESTA);
                                            $array  = array();

                                            if(is_array($json)){
                                                foreach($json as $key => $value){
                                                    $query = DB::table($resp->FORM_CVALOR)->where('id', $value->id)->first();
    
                                                    if(!is_null($query)){
                                                        $format         =  new DateTime($value->fecha);
                                                        $query->fecha   = $format->format('d-m-Y');
                                                        array_push($array, $query);
                                                    }
                                                }
                                            }
                                            else {
                                                $query = DB::table($resp->FORM_CVALOR)->where('id', $json)->first();
                                                array_push($array, $query);
                                            }
                                            $resp->FORM_CVALOR_RESPUESTA = $array;
                                        }
                                        break;
                                    default:
                                        if ($resp->FORM_NPREGUNTAID === $_resp['USRE_NIDPREGUNTA']) {
                                            $resp->FORM_CVALOR_RESPUESTA = $_resp['USRE_CRESPUESTA'];
                                            break;
                                        }
                                        break;
                                }
                            }
                        }
                    }
                }
            }

            $tramite        = $configuracion['tramite'][0];
            $formularios    =  $configuracion['formularios'][0];

            //Creacion de pdf
            $pdf = app('dompdf.wrapper');
            $pdf->getDomPDF()->set_option("enable_php", true);
            $pdf->setPaper("letter", "portrait");
            $pdf->loadView('TEMPLATE.FORMULARIO_TRAMITE', compact('tramite', 'formularios'));
            //return $pdf->download('Formulario.pdf');

            //Se guardar el pdf
            $pathPdf        = public_path('tramites');
            $fileNamePdf    = Str::random(8) . '.pdf';
            if(!File::isDirectory($pathPdf)) {
                if(!File::makeDirectory($pathPdf, $mode = 0777, true, true))
                    $response = false;
            }

            $pdf->save($pathPdf . '/' . $fileNamePdf);
            //Creación y descarga de archivo zip
            $zip = new ZipArchive();
            $fecha = Carbon::now();
            $fecha = $fecha->toArray();
            $fecha = $fecha['timestamp'];
            $folio = explode('/', $tramite->USTR_CFOLIO);
            $folio = $folio[0] . '_' . $folio[1];
            //$fileName = 'TRAM_' . $folio  . '.zip';
            $fileName = 'TRAM_' . $tramite->USTR_CRFC  . '.zip';


            //Obtenemos documentos del trámite
            $listDocumentos = DB::select('SELECT * FROM tram_mdv_usuariordocumento WHERE USDO_NIDUSUARIOTRAMITE = ?', array($id));
            $listResolutivos = DB::select('SELECT * FROM tram_mdv_usuario_resolutivo WHERE USRE_NIDUSUARIOTRAMITE = ?', array($id));

            if ($zip->open($pathPdf."/".$fileName, ZipArchive::CREATE) == TRUE) {

                //Agregamos formulario
                $zip->addFile($pathPdf."/".$fileNamePdf, 'FORMULARIO_' . $folio . '.pdf');

                //Agregar documentos al zip
                foreach ($listDocumentos as $key => $value) {

                    if ($value->USDO_CRUTADOC != null && $value->USDO_CRUTADOC != "") {
                        if (file_exists(public_path($value->USDO_CRUTADOC))) {
                            $fileNameDocumento = $value->USDO_CDOCNOMBRE . '.' . $value->USDO_CEXTENSION;
                            $zip->addFile(public_path($value->USDO_CRUTADOC), $fileNameDocumento);
                        }
                    }
                }

                //Agregar resolutivos
                foreach ($listResolutivos as $key => $value) {
                    if ($value->USRE_CRUTADOC != null && $value->USRE_CRUTADOC != "") {
                        if (file_exists(public_path($value->USRE_CRUTADOC))) {
                            $fileNameDocumento = "R-" . $value->USRE_NIDUSUARIO_RESOLUTIVO . '.' . $value->USRE_CEXTENSION;
                            $zip->addFile(public_path($value->USRE_CRUTADOC), $fileNameDocumento);
                        }
                    }
                }
                $zip->close();
            }

            //Eliminamos los archivos
            File::delete($pathPdf . '/' . $fileNamePdf);
            //File::delete($pathPdf . '/' . $fileName);

            $response = [ 'name' => 'tramites/'.$fileName ];
        } catch (Exception $ex) {
            //dd($ex->getMessage());
            return response()->json($ex->getMessage());
        }

        //return response()->download(public_path($fileName))->deleteFileAfterSend(true);
        return response()->json($response);
    }


    //--------------------------asignar--------------------
    public function asignar_tramite(Request $request){//Request $request
        $respuesta = Cls_UsuarioTramiteAnalista::AsignarTramite($request);
        
        return $respuesta;
    }

    private function verifica_rol_analista_asignado($idtramite){
        $rol = Auth::user()->TRAM_CAT_ROL->ROL_CCLAVE;
        $iduser = Auth::user()->USUA_NIDUSUARIO;

        if($rol == 'ANTA'){
            $asignados = Cls_UsuarioTramiteAnalista::AnalistaTramiteAsignado($idtramite, $iduser);
            if(count($asignados) > 0){
                $retorno = true;
            }else{
                $retorno = false;
            }
        }else{
            $retorno = true;
        }
        return $retorno;
    }
}
