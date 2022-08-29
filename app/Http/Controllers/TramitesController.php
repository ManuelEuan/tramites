<?php

namespace App\Http\Controllers;


use File;
use ZipArchive;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Cls_Usuario_Tramite;
use Illuminate\Http\Request;
use App\Cls_Usuario_Concepto;
use App\Cls_Usuario_Documento;
use App\Cls_Usuario_Respuesta;
use App\Services\CitasService;
use App\Services\VariosService;
use PhpOffice\PhpWord\Settings;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Mail;
use App\Cls_Seguimiento_Servidor_Publico;

class TramitesController extends Controller
{
    protected $variosService;
    protected $citasService;
    protected $host = 'http://tramitesqueretaro.eastus.cloudapp.azure.com';

    public function __construct() {
        $this->variosService    = new VariosService();
        $this->citasService     = new CitasService();
    }

    /**
     * Retorna las citas agendadas
     * @param Request $request
     * @return Response
     */
    public function getCitasAgendadas(Request $request){
        $order      = "desc";
        $order_by   = "c.id";

        $query = DB::table('citas_tramites_calendario as c')
                    ->join('tram_mst_usuario as u', 'c.CITA_IDUSUARIO', '=', 'u.USUA_NIDUSUARIO')
                    ->select('c.*', 'u.USUA_CRFC AS rfc', 'u.USUA_CRFC as rfc', 'u.USUA_CNOMBRES as nombre', 'u.USUA_CPRIMER_APELLIDO as apellido_paterno', 'u.USUA_CSEGUNDO_APELLIDO as apellido_materno');

        if(!is_null($request->usuario_id))
            $query->where("c.CITA_IDUSUARIO", $request->usuario_id);
        if(!is_null($request->tramite_id))
            $query->where("c.CITA_IDTRAMITE", $request->tramite_id);
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

    public function listado()
    {

        /*$url =   $this->host . '/api/vw_accede_tramite';
        //$dataForPost = array('UN_PARAMETRO' => UN_VALUE);
        $options = array(
            'http' => array(
                // 'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'GET',
                // 'content' => http_build_query($dataForPost),
            )
        );

        $context  = stream_context_create($options);
        set_time_limit(150);
        $listTramites = file_get_contents($url, false, $context);
        $tramites = json_decode($listTramites, true);*/
        $tramites = [];
        return view('TRAMITES_CEMR.listado', compact('tramites'));
    }

    public function configurar_tramite()
    {
        return view('TRAMITES_CEMR.index');
    }

    public function find(Request $request)
    {
        $response = [];
        try {

            ## Read value
            $draw = $request->get('draw');
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
            if (Auth::user()->TRAM_CAT_ROL->ROL_CCLAVE === 'ADM') {
                $tramite_seguimiento->UsuarioID = 0;
            } else {
                $tramite_seguimiento->UsuarioID = Auth::user()->USUA_NIDUSUARIO;
            }

            $result = $tramite_seguimiento->TRAM_SP_CONSULTAR_TRAMITES_SEGUIMIENTO();
            $tramites = $result['result'];
            $totalRegistros = $result['total'][0]->TotalRegistros;

            $response = [
                'recordsTotal' => $totalRegistros,
                'recordsFiltered' => $searchValue === null ? $totalRegistros : count($tramites),
                'data' =>  $tramites
            ];
        } catch (\Throwable $th) {
            $response = [
                'data' => [],
                'error' => $th->getMessage(),
                'code' => 400,
                'mensaje' => 'Ocurrió un error al obtener trámites',
            ];
        }

        return response()->json($response);
    }

    //Vista detalle
    public function detalle($id)
    {
        $result = Cls_Seguimiento_Servidor_Publico::TRAM_OBTENER_TRAMITE_SEGUIMIENTO($id);
        $tramite = $result[0];
        return view('TRAMITES_CEMR.detalles', compact('tramite'));
    }

    //Vista seguimiento
    public function seguimiento($id)
    {
        //Marcar trámite del ciudadano como Recibido
        Cls_Seguimiento_Servidor_Publico::TRAM_MARCAR_ESTATUS_REVISION_TRAMITE($id);

        //Tramite
        $result = Cls_Seguimiento_Servidor_Publico::TRAM_OBTENER_TRAMITE_SEGUIMIENTO($id);
        $tramite = $result[0];
        $ventanilla_sin_cita = $this->obtener_edificio_ventanilla($tramite->USTR_NIDUSUARIOTRAMITE, $tramite->USTR_NIDTRAMITE_ACCEDE);
        $tramite->EDF_VENTANILLA_SIN_CITA = $ventanilla_sin_cita['NAME'];
        $tramite->EDF_VENTANILLA_SIN_CITA_LAT = $ventanilla_sin_cita['LAT'];
        $tramite->EDF_VENTANILLA_SIN_CITA_LON = $ventanilla_sin_cita['LON'];

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

        $resolutivos = Cls_Seguimiento_Servidor_Publico::TRAM_OBTENER_RESOLUTIVOS_CONFIGURADOS($tramite->USTR_NIDTRAMITE);

        //dd($resolutivos);
        return view('TRAMITES_CEMR.seguimiento', compact('tramite', 'secciones', 'conceptos', 'resolutivos'));
    }

    public function generatePrevioResolutivo($resolutivoId, $tramiteId)
    {

        $resolutivo = Cls_Seguimiento_Servidor_Publico::TRAM_OBTENER_RESOLUTIVO($resolutivoId)[0];

        $mapeoCampos = Cls_Seguimiento_Servidor_Publico::TRAM_OBTENER_RESOLUTIVO_MAPEO($resolutivoId, $tramiteId);

        //dd($mapeoCampos);
        /* Set the PDF Engine Renderer Path */
        $domPdfPath = base_path('vendor/dompdf/dompdf');

        Settings::setPdfRendererPath($domPdfPath);
        Settings::setPdfRendererName('DomPDF');

        $rutaBase = public_path() . '/docts/resolutivos/';
        //dd($rutaBase);
        $rutaResolutivo =   $rutaBase . $resolutivo->RESO_CNAMEFILE;
        $nameFile = explode(".", $resolutivo->RESO_CNAMEFILE);
        /*@ Reading doc file */
        $template = new \PhpOffice\PhpWord\TemplateProcessor($rutaResolutivo);

        foreach ($mapeoCampos as $campo) {

            $template->setValue($campo->TRAM_CNOMBRECAMPO, $campo->USRE_CRESPUESTA);
        }

        $pathQR = $this->variosService->generaQR(url('/') . '/docts/resolutivos/new-result' . $nameFile[0] . '.pdf');
        $template->setImageValue('qrcode', array('path' =>  $pathQR, 'width' => 100, 'height' => 100, 'ratio' => true));
        /*@ Replacing variables in doc file */
        /*  $template->setValue('date', date('d-m-Y'));
        $template->setValue('title', 'Mr.');
        $template->setValue('firstname', 'Josue');
        $template->setValue('lastname', 'Lopez');
        */
        /*@ Save Temporary Word File With New Name */
        $saveDocPath = $rutaBase . 'new-result' . $nameFile[0] . '.docx';
        $template->saveAs($saveDocPath);

        // Load temporarily create word file
        $Content = \PhpOffice\PhpWord\IOFactory::load($saveDocPath);

        //Save it into PDF
        $savePdfPath = $rutaBase . 'new-result' . $nameFile[0] . '.pdf';

        /*@ If already PDF exists then delete it */
        if (file_exists($savePdfPath)) {
            unlink($savePdfPath);
        }



        //dd($pathQR);
        //Save it into PDF
        $PDFWriter = \PhpOffice\PhpWord\IOFactory::createWriter($Content, 'PDF');
        $PDFWriter->save($savePdfPath);
        //echo 'File has been successfully converted ' . $savePdfPath;

        /*@ Remove temporarily created word file */
        if (file_exists($saveDocPath)) {
            unlink($saveDocPath);
        }
        //return response()->file($savePdfPath);

        //dd($savePdfPath);

        return redirect('/docts/resolutivos/new-result' . $nameFile[0] . '.pdf');

        //return response()->file($savePdfPath, ['Content-Type' => 'application/pdf']);
    }


    //Obtener el nombre del modulo para asistir a ventanilla
    private function obtener_edificio_ventanilla($USTR_NIDUSUARIOTRAMITE, $USTR_NIDTRAMITE_ACCEDE)
    {
        //Obtenemos el valor de ID del edificio
        $consulta = Cls_Usuario_Tramite::select('USTR_CMODULO')->where('USTR_NIDUSUARIOTRAMITE', $USTR_NIDUSUARIOTRAMITE)->take(1)->get()->first();
        $USTR_CMODULO = $consulta->USTR_CMODULO;
        $USTR_CMODULO_DATA = [
            'NAME' => "Pendiente",
            'LAT' => 0,
            'LON' => 0
        ];

        //Consultar tramite
        $urlTramite = $this->host . '/api/Tramite/Detalle/' . $USTR_NIDTRAMITE_ACCEDE;
        $options = array(
            'http' => array(
                'method'  => 'GET',
            )
        );

        $objTramite = null;
        $context = stream_context_create($options);
        $result = @file_get_contents($urlTramite, false, $context);
        if (strpos($http_response_header[0], "200")) {
            $objTramite = json_decode($result, true);
        }


        if ($USTR_CMODULO != 0) {
            $lstOficinas = [];
            if ($objTramite != null) {
                $horarios = "";
                foreach ($objTramite['horarios'] as $objHorario) {
                    $horarios .= $objHorario . " <br/>";
                }
                $telefono = "";
                foreach ($objTramite['telefonos'] as $objTelefono) {
                    $telefono .= $objTelefono . " <br/>";
                }
                $funcionarios = "";
                foreach ($objTramite['funcionarios'] as $objFuncionarios) {
                    $funcionarios .= $objFuncionarios['nombre'] . "<br/> correo: " . $objFuncionarios['correo'] . "<br/><hr>";
                }
                $contEdi = 1;
                foreach ($objTramite['listaDetallesEdificio'] as $objEdificio) {
                    if ($contEdi == $USTR_CMODULO) {
                        $USTR_CMODULO_DATA['NAME'] = $objEdificio['nombre'] . ". \n(" . $objEdificio['direccion'] . " - " . $objEdificio['latitud'];
                        $USTR_CMODULO_DATA['LAT'] = $objEdificio['latitud'];
                        $USTR_CMODULO_DATA['LON'] = $objEdificio['longitud'];
                    }
                    $contEdi++;
                }
            }
        }

        return $USTR_CMODULO_DATA;
    }

    //Obtener trámite en seguimiento
    public function obtener_tramite_seguimiento($id)
    {
        $tramite = Cls_Seguimiento_Servidor_Publico::TRAM_CONSULTAR_CONFIGURACION_TRAMITE_PUBLICO($id);
        $configaracion =  $tramite;

        $USTR_NIDUSUARIOTRAMITE = $tramite['tramite'][0]->USTR_NIDUSUARIOTRAMITE;

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
                    $consulartVigencia = Cls_Seguimiento_Servidor_Publico::getVigencia($doc->idDocExpediente);
                    $doc->vigencia = $consulartVigencia->vigencia ?? "";
                    break;
                }
            }
        }

        $configaracion['secciones_estatus'] = Cls_Seguimiento_Servidor_Publico::TRAM_OBTENER_SECCIONES_ESTATUS($id);
        $configaracion['resolutivos_finales'] = Cls_Seguimiento_Servidor_Publico::TRAM_OBTENER_RESOLUTIVOS_FINALES($id);
        $configaracion['resolutivos_configurados'] = Cls_Seguimiento_Servidor_Publico::TRAM_OBTENER_RESOLUTIVOS_CONFIGURADOS($id);

        $tramite['configuracion'] = $configaracion;
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
            if (isset($request->CONF_DOCUMENTOS)) {
                if (count($request->CONF_DOCUMENTOS)) {

                    foreach ($request->CONF_DOCUMENTOS as $documento) {

                        Cls_Seguimiento_Servidor_Publico::TRAM_ESTATUS_DOCUMENTO($request->CONF_NIDUSUARIOTRAMITE, $documento['documento_id'], $documento['estatus'], $documento['observaciones']);
                        //Aqui se agrega la vigencia
                        $idDocExp = Cls_Seguimiento_Servidor_Publico::getIdDocExp($documento['documento_id']);
                        if(isset($idDocExp->id)){
                            Cls_Seguimiento_Servidor_Publico::ActualizarDocsUsuario($idDocExp->id, $documento['vigencia']);
                        }
                        
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

                    Cls_Seguimiento_Servidor_Publico::TRAM_ESTATUS_DOCUMENTO($request->CONF_NIDUSUARIOTRAMITE, $documento['documento_id'], $documento['estatus'], $documento['observaciones']);
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
                $message->from('ldavalos@esz.com.mx', 'ldavalos');
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
        $tramite_ = Cls_Seguimiento_Servidor_Publico::TRAM_CONSULTAR_CONFIGURACION_TRAMITE_PUBLICO($id);
        $configuracion =  $tramite_;
        $USTR_NIDUSUARIOTRAMITE = $tramite_['tramite'][0]->USTR_NIDUSUARIOTRAMITE;

        //Respuestas
        $respuestas = Cls_Usuario_Respuesta::where('USRE_NIDUSUARIOTRAMITE', $USTR_NIDUSUARIOTRAMITE)
            ->select('*')
            ->get()->toArray();

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

        $tramite = $configuracion['tramite'][0];
        $formularios =  $configuracion['formularios'][0];

        // return view('TEMPLATE.FORMULARIO_TRAMITE', compact('tramite', 'formularios'));
        // $pdf = \PDF::loadView('TEMPLATE.FORMULARIO_TRAMITE', compact('tramite'));
        // return $pdf->download('pruebapdf.pdf');

        //Creacion de pdf
        $pdf = app('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->setPaper("letter", "portrait");
        $pdf->loadView('TEMPLATE.FORMULARIO_TRAMITE', compact('tramite', 'formularios'));
        //return $pdf->download('Formulario.pdf');

        //Se guardar el pdf
        $pathPdf = public_path();
        $fileNamePdf =   Str::random(8) . '.pdf';
        $pdf->save($pathPdf . '/' . $fileNamePdf);
        // File::delete($pathPdf . '/' . $fileNamePdf);
        // return $pdf->download($fileNamePdf);

        //Creación y descarga de archivo zip
        $zip = new ZipArchive();
        $fecha = Carbon::now();
        $fecha = $fecha->toArray();
        $fecha = $fecha['timestamp'];
        $folio = explode('/', $tramite->USTR_CFOLIO);
        $folio = $folio[0] . '_' . $folio[1];
        $fileName = 'TRAM_' . $folio  . '.zip';

        //Eliminamos el archivo zip en caso de que exista
        File::delete($pathPdf . '/' . $fileName);

        //Obtenemos documentos del trámite
        $listDocumentos = DB::select('SELECT * FROM tram_mdv_usuariordocumento WHERE USDO_NIDUSUARIOTRAMITE = ?', array($id));
        $listResolutivos = DB::select('SELECT * FROM tram_mdv_usuario_resolutivo WHERE USRE_NIDUSUARIOTRAMITE = ?', array($id));

        if ($zip->open(public_path($fileName), ZipArchive::CREATE) == TRUE) {

            //Agregamos formulario
            $zip->addFile(public_path($fileNamePdf), 'FORMULARIO_' . $folio . '.pdf');

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

        //Eliminamos el pdf
        File::delete($pathPdf . '/' . $fileNamePdf);

        $response = [
            'name' => $fileName,
        ];

        //return response()->download(public_path($fileName))->deleteFileAfterSend(true);
        return response()->json($response);
    }
}
