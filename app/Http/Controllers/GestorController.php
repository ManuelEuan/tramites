<?php

namespace App\Http\Controllers;

use stdClass;
use App\Cls_Gestor;
use App\Cls_Resolutivo;
use Hamcrest\Type\IsNumeric;
use Illuminate\Http\Request;
use App\Cls_Tramite_Servicio;
use App\Cls_Seccion_Seguimiento;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use  Illuminate\Pagination\Paginator;
use App\Http\Controllers\FormularioController;
use App\Services\TramiteService;
use  Illuminate\Pagination\LengthAwarePaginator;


class GestorController extends Controller
{
    /**
     * @var String
     */
    private $host = 'https://remtysmerida.azurewebsites.net';
    
    /**
     * @var TramiteService
     */
    private $tramiteService;

    /**
     * Construct Gestor
     */
    public function __construct(){
        //$this->middleware('auth');
        $this->tramiteService = new TramiteService();
    }

    /**
     * Retorna la vista inicial del modulo de gestores
     * @return View
     */
    public function index() {
        $data       = ['usuarioID' => Auth::user()->USUA_NIDUSUARIO, 'unidad' => 0, 'estatus' => 2];
        $request    = new Request($data);
        $tramite    = $this->tramiteService->busqueda($request);

        $data_tramite = $tramite['data'];
        return view('MST_GESTOR.index', compact('data_tramite'));
    }

    /**
     * Retorna la seccion de la tabla con los datos de la busqueda solicitada
     * @param Request $request
     * @return Response
     */
    public function consultar(Request $request) {
        $tramite        =  $this->tramiteService->busqueda($request);
        $data_tramite   = $tramite['data'];

        return response()->json(view('MST_GESTOR.index_partial', compact('data_tramite'))->render());
    }

    /**
     * Retorna el array de los diferentes filtros a utilizar
     * @param Request $request
     * @return Response
     */
    public function obtener_filtro(Request $request) {
        $filtros = $this->tramiteService->filtros($request);
        $response = [
            "clasificacion" =>  [],
            "audiencia"     =>  [],
            "dependencias"  =>  $filtros['dependencias'],
            "tramites"      =>  []
        ];

        return Response()->json($response);
    }

    //Vista información sobre el trámite (merida)
    public function consultar_tramite($tramiteID, $tramiteIDConfig) {
        $objTramite             = $this->tramiteService->getTramite($tramiteID);
        $arrayDetalle           = $this->tramiteService->getDetalle($objTramite->Id);

        ################ Comienzo a llenar los datos para el tramite ################
        $tramite                = [];
        $tramite['id']          = $tramiteID;
        $tramite['nombre']      = $objTramite->Name;
        $tramite['responsable'] = $objTramite->nameDependencia;
        $tramite['descripcion'] = $objTramite->CitizenDescription;
        $tramite['fundamento_legal'] = array([ "titulo" => "", "opciones" => [], "adicional" => [], "descripcion" => $objTramite->nameInstrumento ]);

        $arrayDocumentos = [];
        foreach($arrayDetalle['documentos'] as $documento) {
            $array = array(
                "nombre"        => $documento->Name,
                "presentacion"  => $documento->presentacion,
                "observaciones" => $documento->Description,
                "tipo"          => $documento->tipoDocumento,
                "informacionComplementaria" => "." //"informacionComplementaria",
            );
            array_push($arrayDocumentos, $array);
        }

        ################ Horarios ################
        $tramite['oficinas']    = [];
        $horarios               = "";
        foreach($arrayDetalle['horario'] as $horario){
            $horarios.= $horario->diaNombre.": ".date("h:i a", strtotime($horario->OpeningHour))." - ".date("h:i a", strtotime($horario->ClosingHour))." <br/>";
        }

        ################ Funcionarios ################
        $funcionarios = "";
        foreach($arrayDetalle['funcionarios']as $funcionario){
            $funcionarios .= $funcionario->Name."<br/> correo: " . $funcionario->Email. "<br/><hr>";
        }

        foreach($arrayDetalle['oficinas'] as $oficina){
            $array = array(
                "id"            => $oficina->Id,
                "nombre"        => $oficina->Name,
                "direccion"     => "Calle ".$oficina->Street." No Exterior ".$oficina->ExternalNumber." No Interior ". strtoupper($oficina->InternalNumber)." colonia ".$oficina->Colony.", ".$oficina->Municipality.", ".$oficina->State,
                "horario"       => "</br> Horario: </br>".$horarios,
                "latitud"       => $oficina->Latitude,
                "longitud"      => $oficina->Longitude,
                "responsable"   => $funcionarios,
                "contacto_email"        => $oficina->Email,
                "informacion_adicional" => "",
                "contacto_telefono"     => "Télfono: ".$oficina->NumberPhone." Ext ".$oficina->Ext,
            );
            array_push($tramite['oficinas'], $array);
        }

        ################ Lugares donde pagar ################
        $lugares = "";
        foreach($arrayDetalle['lugaresPago']as $lugar){
            $lugares .= $lugar->Property. ", ";
        }
        $lugares    = substr($lugares, 0, -2).".";
        $monto      = !is_null($objTramite->StaticAmount) ? $objTramite->StaticAmount : 0;

        $tramite['costo'] = [
            [
                "titulo"        => "¿Tiene costo?",
                "descripcion"   => $monto > 0 ? "SI" : "NO",
                "opciones"      => [],
                "documentos"    => []
            ],
            [
                "titulo"        => "Costos",
                "descripcion"   => "$".number_format(round($monto, 2, PHP_ROUND_HALF_UP), 2, ".", ""),
                "opciones"      => [],
                "documentos"    => []
            ],
            [
                "titulo"        => "Oficinas donde se puede realizar el pago:",
                "descripcion"   =>  $lugares,
                "opciones"      => [],
                "documentos"    => []
            ]
        ];
       
        $tramite['requerimientos'] = [
            [
                "titulo"        => "Casos en que se debe realizar el trámite:",
                "descripcion"   =>  "Manuel Euan",//$objTramite['casoRealizacion'] ?? "",
                "opciones"      => [],
                "documentos"    => []
            ],
            [
                "titulo" => "Requisitos:",
                "descripcion" => "",
                "opciones" => [],
                "documentos" => $arrayDocumentos
            ],
            [
                "titulo" => "¿Puede hacer el trámite alguien más?:",
                "descripcion" => "",
                "opciones" => [],
                "documentos" => []
            ],
            [
                "titulo" => "Casos de rechazo:",
                "descripcion" => "",
                "opciones" => [],
                "documentos" => []
            ]
        ];

        $vigencia   = $objTramite->VigencyNumber == 0 || is_null($objTramite->VigencyNumber) ? "" : $objTramite->VigencyNumber;
        $rango      = $objTramite->VigencyNumber == 1 ? substr($objTramite->tipoVigencia, 0, -1)  : $objTramite->tipoVigencia;
        $tramite['informacion_general'] = [
            /* [
                "titulo"        => "Periodo en que puedo realizar el trámite",
                "descripcion"   => "$vigencia." ".$rango",
                "opciones"      => [],
            ], */
            [
                "titulo"        => "Usuario a quien está dirigido el trámite:",
                "descripcion"   => "dirigidoA", //$objTramite['dirigidoA'] ?? "",
                "opciones"      => [],
            ],
            [
                "titulo"        => "Tipo de persona:",
                "descripcion"   => "tipoPersonas", //$tipoPersonas,
                "opciones"      => [],
            ],
            /* [
                "titulo"        => "Tipo de documento entregado:",
                "descripcion"   => "presentaFormato", // $objTramite['presentaFormato'] ?? "",
                "opciones"      => [],
            ], */
            [
                "titulo"        => "Tiempo hábil promedio de resolución:",
                "descripcion"   =>  $vigencia." ".$rango,
                "opciones"      => [],
            ],
            /* [
                "titulo"        => "Vigencias de los documentos:",
                "descripcion"   => "vigencia", //$objTramite['vigencia'] ?? "",
                "opciones"      => [],
            ], */
            [
                "titulo"        => "Audiencia",
                "descripcion"   => "",
                "opciones"      => [],
            ],
            /* [
                "titulo"        => "Clasificación",
                "descripcion"   => "modalidad", // $objTramite['modalidad '] ?? "",
                "opciones"      => [],
            ], */
            [
                "titulo"        => "Beneficio del usuario:",
                "descripcion"   => $objTramite->Benefit,
                "opciones"      => [],
            ],
            [
                "titulo"        => "Derechos del usuario:",
                "descripcion"   => "",
                "opciones"      => [],
            ]
        ];

        $tramite['en_linea'] = [
            [
                "titulo"        => "Tiempo promedio de espera en fila",
                "descripcion"   =>  "",
                "opciones"      => [],
                "documentos"    => []
            ],
            [
                "titulo"        => "¿Hay información en línea?:",
                "descripcion"   => "",
                "opciones"      => [],
                "documentos"    => []
            ],
            [
                "titulo"        => "¿Se pueden recibir solicitudes en línea?:",
                "descripcion"   => "",
                "opciones"      => [],
                "documentos"    => []
            ],
            [
                "titulo"        => "Solicitud en línea ¿Requiere formato?:",
                "descripcion"   => "",
                "opciones"      => [],
                "documentos"    => []
            ]
        ];
        return view('MST_GESTOR.DET_TRAMITE', compact('tramite'));
    }



    public function actualizar_pago($id){
        Cls_Seccion_Seguimiento::where(['SSEGTRA_NIDSECCION_SEGUIMIENTO' => $id])->update(['SSEGTRA_PAGADO' => 1]);
        return response()->json(['data' => "ok"]);
    }

    
    //Vista donde se realiza configuración del trámite
    public function configurar_tramite($tramiteID, $tramiteIDConfig){
        $tramite        = [];
        $edificios      = [];
        $objTramite     = $this->tramiteService->getTramite($tramiteID);
        $arrayDetalle   = $this->tramiteService->getDetalle($objTramite->Id);
        $horarios       = "";
        $funcionarios   = "";
        $telefono       = "";

        foreach($arrayDetalle['horario'] as $horario){
            $horarios.= $horario->diaNombre.": ".date("h:i a", strtotime($horario->OpeningHour))." - ".date("h:i a", strtotime($horario->ClosingHour))." <br/>";
        }

        foreach($arrayDetalle['funcionarios']as $funcionario){
            $funcionarios .= $funcionario->Name."<br/> correo: " . $funcionario->Email. "<br/><hr>";
        }
        
        /* foreach($objTramite['telefonos'] as $objTelefono){
            $telefono .= $objTelefono ." <br/>";
        } */


        foreach($arrayDetalle['oficinas'] as $key => $oficina){
            $_objE = [
                /* "id"            => $oficina->Id, */
                "id"            => $key + 1,
                "nombre"        => $oficina->Name,
                "direccion"     => "Calle ".$oficina->Street." No Exterior ".$oficina->ExternalNumber." No Interior ". strtoupper($oficina->InternalNumber)." colonia ".$oficina->Colony.", ".$oficina->Municipality.", ".$oficina->State,
                "horario"       => "</br> Horario: </br>".$horarios,
                "latitud"       => $oficina->Latitude,
                "longitud"      => $oficina->Longitude,
                "responsable"   => $funcionarios,
                "contacto_email"        => $oficina->Email,
                "informacion_adicional" => "",
                "contacto_telefono"     => "Télfono: ".$oficina->NumberPhone." Ext ".$oficina->Ext,
            ];
            array_push($edificios, $_objE);
        }

        #################### Configuraciones anteriores ####################
        $tramites   = new Cls_Gestor();
        $registro   = $tramites->TRAM_SP_OBTENER_DETALLE_TRAMITE_CONFIGURACION();
        if (count($registro) > 0) {
            $tramite['VALIDO'] = true;
            $tramite['TRAM_ID_TRAMITE'] = $registro[0]->TRAM_NIDTRAMITE;
            $tramite['ACCE_ID_TRAMITE'] = $registro[0]->TRAM_NIDTRAMITE_ACCEDE;
            $tramite['ACCE_CLAVE_INTERNA'] = 'Clave Accede: ' . $registro[0]->TRAM_NIDTRAMITE_ACCEDE;
            $tramite['ACCE_NOMBRE_TRAMITE'] = $registro[0]->TRAM_CNOMBRE;
            $tramite['EDIFICIOS'] = $registro[0]->TRAM_CNOMBRE;
            $tramite['TRAM_NIMPLEMENTADO'] = $registro[0]->TRAM_NIMPLEMENTADO != null ? intval($registro[0]->TRAM_NIMPLEMENTADO) : intval($registro[0]->TRAM_NIMPLEMENTADO);
            $tramite['TRAM_NENLACEOFICIAL'] = $registro[0]->TRAM_NENLACEOFICIAL != null ? intval($registro[0]->TRAM_NENLACEOFICIAL) : intval($registro[0]->TRAM_NENLACEOFICIAL);
        } else {

            if (is_numeric($tramiteIDConfig) && intval($tramiteIDConfig) > 0) {
                $tramite['VALIDO'] = false;
                $tramite['TRAM_ID_TRAMITE'] = NULL;
                $tramite['ACCE_ID_TRAMITE'] = NULL;
                $tramite['ACCE_CLAVE_INTERNA'] = "";
                $tramite['ACCE_NOMBRE_TRAMITE'] = "NO SE ENCONTRÓ EL TRÁMITE. USTED ESPECIFICO UN TRÁMITE, PERO NO SE ENCONTRÓ.";
                $tramite['TRAM_NIMPLEMENTADO'] = null;
                $tramite['TRAM_NENLACEOFICIAL'] = null;
            } else {
                $tramite['VALIDO'] = true;
                $tramite['TRAM_ID_TRAMITE'] = 0;
                $tramite['ACCE_ID_TRAMITE'] =  $objTramite->Id;
                $tramite['ACCE_CLAVE_INTERNA'] = 'Clave interna: ' . $objTramite->Id;
                $tramite['ACCE_NOMBRE_TRAMITE'] = $objTramite->Name;
                $tramite['TRAM_NIMPLEMENTADO'] = null;
                $tramite['TRAM_NENLACEOFICIAL'] = null;
            }
        }


        return view('DET_GESTOR_CONFIGURACION_TRAMITE.index',  compact('tramite', 'edificios'));
    }

    //Vista detalle de configuración de trámite
    public function detalle_configuracion_tramite($tramiteID, $tramiteIDConfig)
    {
        $tramites = new Cls_Gestor();
        $tramites->TRAM_NIDTRAMITE = $tramiteID;
        $tramites->TRAM_NIDTRAMITE_CONFIG = $tramiteIDConfig;
        $registro = $tramites->TRAM_SP_OBTENER_DETALLE_TRAMITE_CONFIGURACION();
        $tramite = [];

        //Obtener tramite
        $urlTramite = $this->host . '/api/Tramite/Detalle/' . $tramiteID;
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

        //Obtener edificios
        $edificios = [];
        if ($objTramite != null) {
            $horarios = "";
            foreach($objTramite['horarios'] as $objHorario){
                $horarios .= $objHorario ." <br/>";
            }
            $telefono = "";
            foreach($objTramite['telefonos'] as $objTelefono){
                $telefono .= $objTelefono ." <br/>";
            }
            $funcionarios = "";
            foreach($objTramite['funcionarios'] as $objFuncionarios){
                $funcionarios .= $objFuncionarios['nombre'] ."<br/> correo: " . $objFuncionarios['correo'] . "<br/><hr>";
            }
            $contEdi = 1;
            foreach($objTramite['listaDetallesEdificio'] as $objEdificio){
                $_objE = [
                    "id" => $contEdi,
                    "nombre"=> $objEdificio['nombre'],
                    "direccion"=> $objEdificio['direccion'],
                    "horario"=> $horarios,
                    "latitud"=> $objEdificio['latitud'] ?? 0,
                    "longitud"=> $objEdificio['longitud'] ?? 0,
                    "responsable"=> $funcionarios,
                    "contacto_telefono"=> $telefono,
                    "contacto_email"=> "",
                    "informacion_adicional"=> ""
                ];
                array_push($edificios, $_objE);
                $contEdi++;
            }
        }

        if (count($registro) > 0) {
            $tramite['VALIDO'] = true;
            $tramite['TRAM_ID_TRAMITE'] = $registro[0]->TRAM_NIDTRAMITE;
            $tramite['ACCE_ID_TRAMITE'] = $registro[0]->TRAM_NIDTRAMITE_ACCEDE;
            $tramite['ACCE_CLAVE_INTERNA'] = 'Clave Accede: ' . $registro[0]->TRAM_NIDTRAMITE_ACCEDE;
            $tramite['ACCE_NOMBRE_TRAMITE'] = $registro[0]->TRAM_CNOMBRE;
            $tramite['EDIFICIOS'] = $registro[0]->TRAM_CNOMBRE;
            $tramite['TRAM_NIMPLEMENTADO'] = $registro[0]->TRAM_NIMPLEMENTADO != null ? intval($registro[0]->TRAM_NIMPLEMENTADO) : intval($registro[0]->TRAM_NIMPLEMENTADO);
            $tramite['TRAM_NENLACEOFICIAL'] = $registro[0]->TRAM_NENLACEOFICIAL != null ? intval($registro[0]->TRAM_NENLACEOFICIAL) : intval($registro[0]->TRAM_NENLACEOFICIAL);
        } else {
            $tramite['VALIDO'] = false;
            $tramite['TRAM_ID_TRAMITE'] = NULL;
            $tramite['ACCE_ID_TRAMITE'] = NULL;
            $tramite['ACCE_CLAVE_INTERNA'] = "";
            $tramite['ACCE_NOMBRE_TRAMITE'] = "NO SE ENCONTRÓ EL TRÁMITE. USTED ESPECIFICO UN TRÁMITE, PERO NO SE ENCONTRÓ.";
            $tramite['TRAM_NIMPLEMENTADO'] = null;
            $tramite['TRAM_NENLACEOFICIAL'] = null;
        }

        return view('DET_GESTOR_CONFIGURACION_TRAMITE.DET_CONFIGURACION_TRAMITE',  compact('tramite', 'edificios'));
    }

    /************* Vistas parciales de la configuración de trámite *******************/
    public function view_formulario()
    {
        return response()->json(view('DET_GESTOR_CONFIGURACION_TRAMITE.DET_FORMULARIO')->render());
    }

    public function view_revision()
    {
        return response()->json(view('DET_GESTOR_CONFIGURACION_TRAMITE.DET_REVISION')->render());
    }

    public function view_cita()
    {
        return response()->json(view('DET_GESTOR_CONFIGURACION_TRAMITE.DET_CITA')->render());
    }

    public function view_ventanilla()
    {
        return response()->json(view('DET_GESTOR_CONFIGURACION_TRAMITE.DET_VENTANILLA')->render());
    }

    public function view_pago()
    {
        return response()->json(view('DET_GESTOR_CONFIGURACION_TRAMITE.DET_PAGO')->render());
    }

    public function view_analisis_modulo_interno()
    {
        return response()->json(view('DET_GESTOR_CONFIGURACION_TRAMITE.DET_ANALISIS_INTERNO')->render());
    }

    public function view_resolutivo()
    {
        return response()->json(view('DET_GESTOR_CONFIGURACION_TRAMITE.DET_RESOLUTIVO')->render());
    }

    //Obtener formularios activos
    public function consultar_formulario()
    {
        $StrNombreFormulario = null;
        if ($StrNombreFormulario === null) {
            $StrNombreFormulario = "";
        }

        $formularios = new Cls_Gestor();
        $formularios->StrNombreFormulario = $StrNombreFormulario;
        $registros = $formularios->TRAM_SP_CONSULTAR_FORMULARIO();

        $response = [
            'data' => $registros,
        ];

        return response()->json($response);
    }

    //Obtener documentos necesarios del trámite
    public function consultar_documento_tramite($IntTramite)
    {
        // $documentos = new Cls_Gestor();
        // $documentos->IntTramite = $IntTramite;
        // $registros = $documentos->TRAM_SP_CONSULTAR_DOCUMENTO_TRAMITE();

        $options = array(
            'http' => array(
                'method'  => 'GET',
            )
        );
        //$urlDocumento = $this->host . '/api/vw_accede_tramite_documento_tram_id/' . $IntTramite;
        $urlDocumento = $this->host . '/api/Tramite/DocumentosPorTramiteId/' . $IntTramite;
        // $urlDocumento = $this->host . '/api/vw_accede_tramite_documento';
        $context = stream_context_create($options);
        $result = @file_get_contents($urlDocumento, false, $context);
        $lstDocumentos = [];

        if (strpos($http_response_header[0], "200")) {
            $objDocumento = json_decode($result, true);
            //dd($objDocumento);
            foreach ($objDocumento as $key => $doc) {
                $nombre_doc = "";

                /*if(strlen($doc['DOCU_CDESCRIPCION']) <2){
                    $nombre_doc = $doc['OTRODOC'];
                }else {
                    $nombre_doc = $doc['DOCU_CDESCRIPCION'] . " ". $doc['OTRODOC'];
                }*/
                $_objD = [
                    "ACCE_NIDTRAMITEDOCUMENTO" => 1,
                    "ACCE_NIDTRAMITE" => intval($doc['tramiteGeneralId']) ?? "",
                    "ACCE_NIDDOCUMENTO" => intval($doc['id']) ?? "",
                    "ACCE_CNOMBRE" => $doc['requisito']['nombre'],
                    "ACCE_CDESCRIPCION" => $doc['descripcion'],
                    "ACCE_CEXTENSION" =>  "pdf",
                    "ACCE_NOBLIGATORIO" => 0,
                    "ACCE_NMULTIPLE" => 0,
                ];
                array_push($lstDocumentos, (object)$_objD);
            }
        }
        ////////////////
        $response = [
            'data' => $lstDocumentos,
        ];
        return response()->json($response);
    }

    //Obtener la configuración de un trámite existente
    public function consultar_configuracion_tramite($TRAM_NIDTRAMITE_CONFIG)
    {
        $gestor = new Cls_Gestor();
        $result = $gestor->TRAM_CONSULTAR_CONFIGURACION_TRAMITE($TRAM_NIDTRAMITE_CONFIG);
        return response()->json($result);
    }

    //Guardar configuración de trámite
    public function save(Request $request)
    {
        $response = [];
        $tram = null;
        try {

            $tramite = $this->TRAM_SP_AGREGAR_TRAMITE($request);
            $tram = $tramite;

            //dd($tramite);

            if ($tramite->TRAM_CTIPO == "Creación" || $tramite->TRAM_CTIPO == "Actualización") {

                $resultSecciones = $this->TRAM_SP_AGREGAR_SECCIONES($request->TRAM_LIST_SECCION, $tramite->TRAM_NIDTRAMITE_CONFIG);

                if ($resultSecciones['codigo'] == 200) {

                    $rutaNew =  route('gestor_configurar_tramite', ['tramiteID' =>  $tramite->TRAM_NIDTRAMITE_ACCEDE, 'tramiteIDConfig' => $tramite->TRAM_NIDTRAMITE_CONFIG]);
                    $result = null;

                    //Implementar en caso de implementar
                    if ($request->TRAM_NIMPLEMENTADO == 1) {
                        $gestor_im = new Cls_Gestor();
                        $result = $gestor_im->TRAM_SP_CAMBIAR_ESTATUS_TRAMITE($tramite->TRAM_NIDTRAMITE_CONFIG, 1);
                    }

                    return response()->json([
                        "estatus" => "success",
                        "codigo" => 200,
                        "mensaje" => "Trámite y secciones agregadas correctamente",
                        "ruta" => $rutaNew,
                        "result"=> $result,
                    ]);
                }else{
                    return response()->json($resultSecciones);
                }

            } else {

                return response()->json([
                    "estatus" => "error",
                    "codigo" => 400,
                    "DataError" => $tramite->TRAM_CTIPO
                ]);
            }
        } catch (\Throwable $e) {
            $response = [
                "estatus" => "error",
                "codigo" => 400,
                "mensaje" => "Ocurrió una excepción, favor de contactar al administrador del sistema " . $e->getMessage(),
            ];
            return response()->json($response);
        }
    }

    /********* Auxiliares del guardado de configuración de trámite *********/
    private function TRAM_SP_AGREGAR_TRAMITE($tramite)
    {
        $response = [];
        try {

            //Consultar tramite
            $urlTramite = $this->host . '/api/Tramite/Detalle/' . $tramite->TRAM_NIDTRAMITE_ACCEDE;
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

            //----- Creamos Json ------
            $objJson = [];
            if ($objTramite != null) {

                //Verificamos solo los atributos con nombre
                foreach ($objTramite as $key => $value) {
                    if (is_int($key)) {
                        continue;
                    }
                    $objJson[$key] = $value;
                }
            }

            $tramites = new Cls_Gestor();
            $tramites->TRAM_NIDTRAMITE_ACCEDE = $tramite->TRAM_NIDTRAMITE_ACCEDE;
            $tramites->TRAM_NIDTRAMITE_CONFIG = $tramite->TRAM_NIDTRAMITE_CONFIG;
            $tramites->TRAM_NDIASHABILESRESOLUCION = $tramite->TRAM_NDIASHABILESRESOLUCION;
            $tramites->TRAM_NDIASHABILESNOTIFICACION = $tramite->TRAM_NDIASHABILESNOTIFICACION;
            $tramites->TRAM_NIDFORMULARIO = $tramite->TRAM_NIDFORMULARIO;

            $tramites->TRAM_NIDUNIDADADMINISTRATIVA =  1;
            $tramites->TRAM_CUNIDADADMINISTRATIVA =  "";
            $tramites->TRAM_NIDCENTRO =  $objTramite['idDependencia'];
            $tramites->TRAM_CCENTRO =  $objTramite['nombreDependencia'];
            $tramites->TRAM_CNOMBRE =  $objTramite['nombre'];
            $tramites->TRAM_CENCARGADO =  "";
            $tramites->TRAM_CCONTACTO =  "";
            $tramites->TRAM_CDESCRIPCION =  $objTramite['descripcionCiudadana'];
            $tramites->TRAM_NTIPO =  0;

            $tramites->TRAM_NLINEA =  0;
            $tramites->TRAM_NPRESENCIAL =  0;
            $tramites->TRAM_NTELEFONO =  0;
            $tramites->TRAM_CAUDIENCIA =  "";
            $tramites->TRAM_CID_AUDIENCIA =  0;

            $tramites->TRAM_CTRAMITE_JSON = '{"item": 1}';
            if ($tramite->TRAM_NENLACEOFICIAL < 1) {
                if (Gate::allows('isAdministradorOrEnlace')) {
                    $tramites->TRAM_NENLACEOFICIAL = 1;
                } else {
                    $tramites->TRAM_NENLACEOFICIAL = 0;
                }
            } else {
                $tramites->TRAM_NENLACEOFICIAL = 1;
            }

            $result = $tramites->TRAM_SP_AGREGAR_TRAMITE();

            return $result[0];

        } catch (\Throwable $e) {
            $response = [
                "TRAM_CTIPO" => "error",
                "estatus" => "error",
                "codigo" => 400,
                "mensaje" => "Ocurrió una excepción, favor de contactar al administrador del sistema " . $e->getMessage(),
            ];
        }

        return $response;
    }

    private function TRAM_SP_AGREGAR_SECCIONES(array $listSecciones, $TramiteID)
    {
        //dd($listSecciones);

        $response = [];
        try {

            if (count($listSecciones) > 0) {

                $seccionesEliminadas = new Cls_Gestor();
                $seccionesEliminadas->TRAM_SP_ELIMINAR_SECCION($TramiteID);

                foreach ($listSecciones as $seccion) {

                    $newSeccion = new Cls_Gestor();
                    $newSeccion->CONF_NIDTRAMITE = $TramiteID;
                    $newSeccion->CONF_NSECCION = $seccion['CONF_NSECCION'];
                    $newSeccion->CONF_CNOMBRESECCION = $seccion['CONF_CNOMBRESECCION'];
                    $newSeccion->CONF_ESTATUSSECCION = 0;
                    $newSeccion->CONF_NDIASHABILES = is_null($seccion['CONF_NDIASHABILES']) ? 0 :  $seccion['CONF_NDIASHABILES'];
                    $newSeccion->CONF_CDESCRIPCIONCITA = is_null($seccion['CONF_CDESCRIPCIONCITA']) ? "" : $seccion['CONF_CDESCRIPCIONCITA'];
                    $newSeccion->CONF_CDESCRIPCIONVENTANILLA = is_null($seccion['CONF_CDESCRIPCIONVENTANILLA']) ? "" : $seccion['CONF_CDESCRIPCIONVENTANILLA'];
                    $newSeccion->CONF_NORDEN = $seccion['CONF_NORDEN'];
                    $SectionID = $newSeccion->TRAM_SP_AGREGAR_SECCION();
                    $Seccion_id = $SectionID[0]->SeccionID;

                    //Agregar formulario y documentos: Se elimina documentos, edificios y conceptos antiguos en TRAM_AGREGAR_DOCUMENTO()
                    if ($seccion['CONF_NSECCION'] === "Formulario") {
                        $TRAM_LIST_FORMULARIO =  $seccion['CONF_LIST_FORMULARIO'];

                        $this->TRAM_AGREGAR_FORMULARIO($TRAM_LIST_FORMULARIO, $TramiteID);
                        //dd($seccion['CONF_LIST_DOCUMENTO']);
                        $doc_exist = array_key_exists('CONF_LIST_DOCUMENTO', $seccion);
                        if($doc_exist){
                            $TRAM_LIST_DOCUMENTO =  $seccion['CONF_LIST_DOCUMENTO'];
                            $this->TRAM_AGREGAR_DOCUMENTO($TRAM_LIST_DOCUMENTO, $TramiteID);
                        }
                    }

                    //Agregas edificios
                    if ($seccion['CONF_NSECCION'] === "Ventanilla sin cita") {
                        $TRAM_LIST_EDIFICIO = $seccion['CONF_LIST_EDIFICIO'];
                        $this->TRAM_AGREGAR_EDIFICIOS($TRAM_LIST_EDIFICIO, $TramiteID, $Seccion_id);
                    }

                    //Agregar resolutivos
                    if ($seccion['CONF_NSECCION'] === "Resolutivo electrónico") {
                        $TRAM_LIST_RESOLUTIVO = $seccion['CONF_LIST_RESOLUTIVO'];
                        $this->TRAM_AGREGAR_RESOLUTIVO($TRAM_LIST_RESOLUTIVO, $TramiteID, $Seccion_id);
                    }

                    //Agregar conceptos de pago
                    if ($seccion['CONF_NSECCION'] === "Pago en línea") {
                        $TRAM_LIST_CONCEPTO = $seccion['CONF_LIST_PAGO'];
                        $this->TRAM_AGREGAR_CONCEPTO_PAGO_TRAMITE($TRAM_LIST_CONCEPTO, $TramiteID, $Seccion_id);
                    }
                }

                $response = [
                    "estatus" => "success",
                    "codigo" => 200,
                    "mensaje" => "Secciones agregadas correctamente",
                ];
            } else {
                $response = [
                    "estatus" => "error",
                    "codigo" => 400,
                    "mensaje" => "No se agregaron secciones a configurar",
                ];
            }
        } catch (\Throwable $e) {
            $response = [
                "estatus" => "error",
                "codigo" => 400,
                "mensaje" => "Ocurrió una excepción al agregar secciones, favor de contactar al administrador del sistema " . $e->getMessage()
            ];
        }

        return $response;
    }

    private function TRAM_AGREGAR_FORMULARIO($TRAM_LIST_FORMULARIO, $TRAM_NIDTRAMITE){

        try {

            $gestor = new Cls_Gestor();
            $gestor->TRAM_SP_ELIMINAR_FORMULARIO($TRAM_NIDTRAMITE);

            for ($i=0; $i < count($TRAM_LIST_FORMULARIO); $i++) {

                $TRAM_LIST_FORMULARIO[$i]['TRAM_NIDTRAMITE'] = $TRAM_NIDTRAMITE;
                $gestor->TRAM_SP_AGREGAR_FORMULARIO($TRAM_LIST_FORMULARIO[$i]['TRAM_NIDFORMULARIO'], $TRAM_LIST_FORMULARIO[$i]['TRAM_NIDTRAMITE']);
            }

        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    private function TRAM_AGREGAR_DOCUMENTO($TRAM_LIST_DOCUMENTO, $TRAM_NIDTRAMITE)
    {
        try {

            //Eliminas secciones del trámite
            $gestor = new Cls_Gestor();
            $gestor->TRAM_SP_ELIMINAR_DOCUMENTO($TRAM_NIDTRAMITE);

            //Eliminar edificos, resolutivos y conceptos del trámite
            $gestor->TRAM_SP_ELIMINAR_EDIFICIO($TRAM_NIDTRAMITE);
            $gestor->TRAM_SP_ELIMINAR_RESOLUTIVO($TRAM_NIDTRAMITE);
            $gestor->TRAM_SP_ELIMINAR_CONCEPTO($TRAM_NIDTRAMITE);

            if(count($TRAM_LIST_DOCUMENTO) > 0){
                for ($i = 0; $i < count($TRAM_LIST_DOCUMENTO); $i++) {

                    $TRAM_LIST_DOCUMENTO[$i]['TRAD_NIDTRAMITE'] = $TRAM_NIDTRAMITE;

                    $gestor->TRAM_SP_AGREGAR_DOCUMENTO(
                        $TRAM_LIST_DOCUMENTO[$i]['TRAD_NIDTRAMITE'],
                        $TRAM_LIST_DOCUMENTO[$i]['TRAD_NIDDOCUMENTO'],
                        $TRAM_LIST_DOCUMENTO[$i]['TRAD_CNOMBRE'],
                        $TRAM_LIST_DOCUMENTO[$i]['TRAD_CDESCRIPCION'],
                        $TRAM_LIST_DOCUMENTO[$i]['TRAD_CEXTENSION'],
                        $TRAM_LIST_DOCUMENTO[$i]['TRAD_NOBLIGATORIO'],
                        $TRAM_LIST_DOCUMENTO[$i]['TRAD_NMULTIPLE']
                    );
                }
            }

        } catch (\Throwable $th) {

        }
    }

    private function TRAM_AGREGAR_EDIFICIOS($TRAM_LIST_EDIFICIO, $TRAM_NIDTRAMITE, $TRAM_NIDSECCION)
    {
        $gestor = new Cls_Gestor();

        for ($i=0; $i < count($TRAM_LIST_EDIFICIO); $i++) {

            $TRAM_LIST_EDIFICIO[$i]['EDIF_NIDTRAMITE'] = $TRAM_NIDTRAMITE;
            $gestor->TRAM_SP_AGREGAR_EDIFICIO_TRAMITE($TRAM_LIST_EDIFICIO[$i]['EDIF_NIDTRAMITE'], $TRAM_LIST_EDIFICIO[$i]['EDIF_CNOMBRE'], $TRAM_NIDSECCION, $TRAM_LIST_EDIFICIO[$i]['EDIF_CCALLE'], $TRAM_LIST_EDIFICIO[$i]['EDIF_CLATITUD'], $TRAM_LIST_EDIFICIO[$i]['EDIF_CLONGITUD'], intval($TRAM_LIST_EDIFICIO[$i]['EDIF_NIDEDIFICIO']));
        }
    }

    private function TRAM_AGREGAR_RESOLUTIVO($TRAM_LIST_RESOLUTIVO, $TRAM_NIDTRAMITE, $TRAM_NIDSECCION)
    {
        $gestor = new Cls_Gestor();

        for ($i = 0; $i < count($TRAM_LIST_RESOLUTIVO); $i++) {

            $TRAM_LIST_RESOLUTIVO[$i]['RESO_NIDTRAMITE'] = $TRAM_NIDTRAMITE;
            $TRAM_LIST_RESOLUTIVO[$i]['RESO_NIDRESOLUTIVO'] = $i + 1;
            $gestor->TRAM_SP_AGREGAR_RESOLUTIVO($TRAM_LIST_RESOLUTIVO[$i]['RESO_NIDTRAMITE'], $TRAM_LIST_RESOLUTIVO[$i]['RESO_NIDRESOLUTIVO'], $TRAM_LIST_RESOLUTIVO[$i]['RESO_CNOMBRE'], $TRAM_NIDSECCION);
        }
    }

    private function TRAM_AGREGAR_CONCEPTO_PAGO_TRAMITE($TRAM_LIST_CONCEPTO, $TRAM_NIDTRAMITE, $TRAM_NIDSECCION)
    {
        $gestor = new Cls_Gestor();

        for ($i = 0; $i < count($TRAM_LIST_CONCEPTO); $i++) {
            $concepto_add = [
                $TRAM_LIST_CONCEPTO[$i]['CONC_NIDCONCEPTO'],
                $TRAM_NIDTRAMITE,
                $TRAM_LIST_CONCEPTO[$i]['CONC_NIDTRAMITE_ACCEDE'],
                $TRAM_LIST_CONCEPTO[$i]['CONC_NREFERENCIA'],
                $TRAM_LIST_CONCEPTO[$i]['CONC_CONCEPTO'],
                $TRAM_LIST_CONCEPTO[$i]['CONC_CTRAMITE'],
                $TRAM_LIST_CONCEPTO[$i]['CONC_CENTE_PUBLICO'],
                $TRAM_LIST_CONCEPTO[$i]['CONC_CENTE'],
                $TRAM_NIDSECCION
            ];
            $gestor->TRAM_SP_AGREGAR_CONCEPTO($concepto_add);
        }
    }

    //Implementar y desimplmentar trámite
    public function implementar_tramite($TRAM_NIDTRAMITE_CONFIG, $TRAM_NIMPLEMENTADO)
    {
        $gestor = new Cls_Gestor();
        $result = $gestor->TRAM_SP_CAMBIAR_ESTATUS_TRAMITE($TRAM_NIDTRAMITE_CONFIG, $TRAM_NIMPLEMENTADO);

        return response()->json($result);
    }

    //Obtener conceptos de pago de tramite
    public function consultar_concepto_pago($TRAM_NIDTRAMITE_ACCEDE)
    {
        try {
            return Cls_Gestor::TRAM_CONSULTAR_CONCEPTO_TRAMITE($TRAM_NIDTRAMITE_ACCEDE);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    //Obtener resolutivos
    public function consultar_resolutivo(){
        return response()->json(Cls_Resolutivo::get());
    }


    public function unidad_administrativa($id){
        $url = $this->host . '/api/vw_accede_unidad_administrativa_centro_id/'.$id;
        $options = array(
            'http' => array(
                'method'  => 'GET',
            )
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        $registros = json_decode($result, true);
        return Response()->json($registros);
    }

    //Funcion paginacion
    public function paginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, [
            'path' => Paginator::resolveCurrentPath()
        ]);
    }

    public function set_json_value_tramite(){

        try {

            $listTramites = Cls_Tramite_Servicio::get();

            foreach ($listTramites as $key => $value) {

                //Consultar tramite
                $urlTramite = $this->host . '/api/vw_accede_tramite_id/' . $value['TRAM_NIDTRAMITE_ACCEDE'];
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

                //----- Creamos Json ------
                $objJson = [];
                if ($objTramite != null) {

                    //Verificamos solo los atributos con nombre
                    foreach ($objTramite as $keyt => $valuer) {
                        if (is_int($keyt)) {
                            continue;
                        }
                        $objJson[$keyt] = $valuer;
                    }
                }

                //Actualiamos campo Json
                Cls_Tramite_Servicio::where(['TRAM_NIDTRAMITE' => $value['TRAM_NIDTRAMITE']])->update(['TRAM_CTRAMITE_JSON' => json_encode($objJson,JSON_UNESCAPED_UNICODE)]);
            }

            return Response()->json(['ok'=> 'si ok ok']);

        } catch (\Throwable $th) {
            return Response()->json(['ok'=> $th->getMessage()]);
        }

    }

    public function formulario(){
        $formulario = new FormularioController();
        $formulario->open_modal = 1;
        return $formulario->list();
    }


}
