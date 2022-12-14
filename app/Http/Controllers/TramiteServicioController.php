<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use App\Cls_Bitacora;
use GuzzleHttp\Client;
use App\Cls_Pago_Tramite;
use App\Cls_Usuario_Tramite;
use Illuminate\Http\Request;
use App\Cls_Tramite_Concepto;
use App\Cls_Tramite_Servicio;
use App\Cls_Usuario_Concepto;
use App\Cls_Usuario_Documento;
use App\Cls_Usuario_Respuesta;
use App\Models\Cls_Dependencia;
use App\Models\Cls_Cat_Seccion;
use App\Services\GestorService;
use App\Services\VariosService;
use App\Cls_Seccion_Seguimiento;
use App\Services\TramiteService;
use App\Cls_Encuesta_Satisfaccion;
use Illuminate\Support\Facades\DB;
use App\Models\Cls_Citas_Calendario;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use App\Models\Cls_PersonaFisicaMoral;
use App\Models\Cls_Formulario_Pregunta;
use App\Cls_Seguimiento_Servidor_Publico;
use Illuminate\Pagination\LengthAwarePaginator;

class TramiteServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $atencion = 0;
    protected $seccion_active = 0;
    protected $host ="https://remtys-qro-qa.azurewebsites.net";
    protected $host_pagos = "https://ipagostest.chihuahua.gob.mx/WSPagosDiversos/consultas/consultas1/obtieneEstatus";
    protected $host_pagos_queretaro = "http://servicios.queretaro.gob.mx:8080/verificaPago/ws/VerificaPagoSedCas";

    protected $tramiteService;
    protected $gestorService;
    protected $variosService;
    /**
     * Construct Gestor
     */
    public function __construct() {
        session(['retys' => request()->path()]);
        $this->middleware('auth');
        $this->tramiteService   = new TramiteService();
        $this->gestorService    = new GestorService();
        $this->variosService    = new VariosService();
    }

    public function index() {
        $tramiteSrv = new TramiteService();

        $obj = (object)[
            "StrTexto" => "",
            "IntDependencia" => 0,
            "IntModalidad" => 0,
            "IntClasificacion" => 0,
            "IntNumPagina" => 1,
            "IntCantidadRegistros" => 10,
            "StrOrdenColumna" => "",
            "StrOrdenDir" => "",
            "IntUsuarioId" => Auth::user()->USUA_NIDUSUARIO
        ];

        $registros = $tramiteSrv->getTramitePublico($obj);
        $IntPaginaActual    = (int)$registros['pagination'][0]->PaginaActual;
        $IntTotalPaginas    = (int)$registros['pagination'][0]->TotalPaginas;
        $IntTotalRegistros  = (int)$registros['pagination'][0]->TotalRegistros;
        $data_tramite       = new LengthAwarePaginator($registros['data'], $IntTotalRegistros, $obj->IntCantidadRegistros, $IntPaginaActual, [
            'path' => Paginator::resolveCurrentPath()
        ]);

        return view('MST_TRAMITE_SERVICIO.index', compact('data_tramite'));
    }

    public function consultar(Request $request) {
        $objDependencia             = $this->tramiteService->getRetys('dependencies',$request->IntDependencia);
        $dependenciaID              = is_null($objDependencia) ? 0 : $objDependencia->iId;

        $obj = (object)[
            "StrTexto" => $request->ajax() ? $request->StrTexto : "",
            "IntDependencia" => $request->ajax() ? $dependenciaID : 0,
            "IntModalidad" => $request->ajax() ? $request->IntModalidad : "",
            "IntClasificacion" => $request->ajax() ? $request->IntClasificacion  :0,
            "IntNumPagina" => $request->ajax() ? $request->IntNumPagina : 1,
            "IntCantidadRegistros" => $request->ajax() ? $request->IntCantidadRegistros : 10,
            "StrOrdenColumna" => $request->ajax() ? $request->StrOrdenColumna : "",
            "StrOrdenDir" => $request->ajax() ? $request->StrOrdenDir : "",
            "IntUsuarioId" => Auth::user()->USUA_NIDUSUARIO
        ];

        $registros = $this->tramiteService->getTramitePublico($obj);
        
        $IntPaginaActual = (int)$registros['pagination'][0]->PaginaActual;
        $IntTotalPaginas = (int)$registros['pagination'][0]->TotalPaginas;
        $IntTotalRegistros = (int)$registros['pagination'][0]->TotalRegistros;
        $data_tramite = new LengthAwarePaginator($registros['data'], $IntTotalRegistros, $obj->IntCantidadRegistros, $IntPaginaActual, [
            'path' => Paginator::resolveCurrentPath()
        ]);

        return $request->ajax() ? response()->json(view('MST_TRAMITE_SERVICIO.index_partial', compact('data_tramite'))->render()) : response()->json($data_tramite);
    }

    public function getTramites(Request $request)
    {
        $resultTram = Cls_Tramite_Servicio::TRAM_OBTENER_TRAMITES();
        $html = '';

        if(count($resultTram)>0){
            foreach ($resultTram as $i) {
                $html .= '<div class="card text-left" style="margin-bottom: 2rem;">
                    <div class="card-header text-primary titleCard">
                        ' . $i->TRAM_CNOMBRE . ' <span class="badge badge-warning">' . $i->TRAM_CCENTRO . '</span>
                    </div>
                    <div class="card-body">
                        <h6 class="card-text" style="color: #212529;">
                            ' . $i->TRAM_CDESCRIPCION . '
                        </h6>
                    </div>
                    <div class="card-footer text-muted" style="background-color: transparent; border-top: none; border-bottom: none;">
                        <span class="text-left" style="margin-right: 30px;">Creado: ' . date("d/m/Y", strtotime($i->created_at)) . '</span>
                        <span class="text-left">Ultima Modificaci??n: ' . date("d/m/Y", strtotime($i->updated_at)) . '</span>
                        <a href="' . route('detalle_tramite', ['id' => $i->TRAM_NIDTRAMITE]) . '" class="btn btn-primary" style="float: right;">Ver tr??mite</a>
                    </div>
                </div>';
            }
        } else {
            $html = '<div class="card text-left" style="margin-bottom: 2rem;">
                <div class="card-body">
                    <h6 class="card-text" style="color: #212529; text-aling: center">
                        Sin tr??mites que mostrar 
                    </h6>
                </div>
            </div>';
        }
        
        return $html;
    }
    //Aqui
    public function tramite_edificios($id)
    {

        //Consultar tramite
        $urlTramite = $this->host . '/api/Tramite/Detalle/' . $id;
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

        //Oficinas
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
                $_objE = [
                    "id" => $contEdi,
                    "nombre" => $objEdificio['nombre'],
                    "direccion" => $objEdificio['direccion'],
                    "horario" => $horarios,
                    "latitud" => $objEdificio['latitud'] ?? 0,
                    "longitud" => $objEdificio['longitud'] ?? 0,
                    "responsable" => $funcionarios,
                    "contacto_telefono" => $telefono,
                    "contacto_email" => "",
                    "informacion_adicional" => ""
                ];
                array_push($lstOficinas, $_objE);
                $contEdi++;
            }
        }
        $tramite['oficinas'] = $lstOficinas;

        return response()->json($tramite);
    }


    public function obtener_detalle_tramite($id)
    {
        $tramites       = new Cls_Tramite_Servicio();
        $detalle        = $tramites->TRAM_CONSULTAR_DETALLE_TRAMITE($id);
        $objTramite     = $this->tramiteService->getTramite($detalle->TRAM_NIDTRAMITE_ACCEDE);
        $arrayDetalle   = $this->tramiteService->getDetalle($objTramite->Id);

        ################ Comienzo a llenar los datos para el tramite ################
        $tramite                = [];
        $tramite['id']          = $detalle->TRAM_NIDTRAMITE;
        $tramite['nombre']      = $objTramite->Name;
        $tramite['responsable'] = $objTramite->nameDependencia;
        $tramite['descripcion'] = $objTramite->CitizenDescription;
        $datosGenerales         = $this->tramiteService->valoresDefaulTramite($arrayDetalle, $objTramite);
        $tramite['oficinas']    = $datosGenerales['oficinas'];
        $tramite['en_linea']    = $datosGenerales['en_linea'];
        $tramite['costo']       = $datosGenerales['costo'];
        $tramite['requerimientos']      = $datosGenerales['requerimientos'];
        $tramite['informacion_general'] = $datosGenerales['informacion_general'];
        $tramite['fundamento_legal']    = $datosGenerales['fundamento_legal'];//array(["titulo" => "", "opciones" => [], "adicional" => [], "descripcion" => $objTramite->nameInstrumento]);

        $tramite['estatus'] = 1;
        /* $tramite['estatus'] = $detalle->TRAM_NESTATUS_PROCESO == null ? 1 : $detalle->TRAM_NESTATUS_PROCESO;
        if ($detalle->TRAM_NESTATUS_PROCESO == null) {
            $tramite['disabled'] = "";
        } else {
            $tramite['disabled'] = $detalle->TRAM_NESTATUS_PROCESO == 1 ? "" : "disabled";
        }  */

        return view('MST_TRAMITE_SERVICIO.DET_TRAMITE', compact('tramite'));
    }
    /**
     * !construccion del
     */
    public function iniciar_tramite_servicio($id)
    {

        $tramites   = new Cls_Tramite_Servicio();
        $detalle    = $tramites->TRAM_CONSULTAR_DETALLE_TRAMITE($id);
        $folio      = strtoupper(substr($detalle->TRAM_CCENTRO, 0, 3)) . substr(date("Y"), -2);
        $gestoresFisicos    = $this->gestorService->getGestores('FISICA');
        $gestoresMorales    = $this->gestorService->getGestores('MORAL');
        $totalGestores      = sizeof($gestoresFisicos) + sizeof($gestoresMorales);
        //Consultar decripcion documentos
        $objTramite     = $this->tramiteService->getTramite($detalle->TRAM_NIDTRAMITE_ACCEDE);
        $arrayDetalle   = $this->tramiteService->getDetalle($objTramite->Id);
        $arrayDocumentos = [];

        foreach($arrayDetalle['documentos'] as $key => $documento) {
            $desc = $documento->Description;
            foreach($arrayDetalle['requisitos'] as $req){
                if($req->RequisitId == $documento->uuid)
                    $desc = $req->Description;
            }
            $array = array($desc, $documento->Name);
            array_push($arrayDocumentos, $array);
        }
        $descripcion = $arrayDocumentos;
        ################ Llenado de datos del tramite ################
        $tramite        = [];
        $tramite['id']  = $id;
        $tramite['folio']       = $folio;
        $tramite['idsuario']    = Auth::user()->USUA_NIDUSUARIO;
        $tramite['nombre']      = $detalle->TRAM_CNOMBRE;
        $tramite['es_gestor']   = $totalGestores;
        $tramite['responsable'] = $detalle->TRAM_CCENTRO;
        $tramite['descripcion'] = $detalle->TRAM_CDESCRIPCION;
        $tramite['estatus']     = $detalle->TRAM_NESTATUS_PROCESO == null ? 1 : $detalle->TRAM_NESTATUS_PROCESO;
        $tramite['idtramiteaccede']     = $detalle->TRAM_NIDTRAMITE_ACCEDE;
        $tramite['fechaactualizacion']  = $detalle->updated_at;
        $tramite['gestores_fisica']     = $gestoresFisicos;
        $tramite['gestores_moral']      = $gestoresMorales;
        $tramite['encuesta_contestada'] = $detalle->USTR_NENCUESTA_CONTESTADA;
        $tramite['disabled']            = is_null($detalle->TRAM_NESTATUS_PROCESO) && $detalle->TRAM_NESTATUS_PROCESO != 1 ?  "disabled" : "";
        $tramite['configuracion']       = $tramites->TRAM_CONSULTAR_CONFIGURACION_TRAMITE_PUBLICO($id);
        
        //datos de ciudadano
        $ObjAuth = Auth::user();
        $tramite['USUA_CRFC'] = $ObjAuth->USUA_CRFC;
        $tramite['USUA_CCURP'] = $ObjAuth->USUA_CCURP;
        $tramite['USUA_CRAZON_SOCIAL'] = $ObjAuth->USUA_CRAZON_SOCIAL;
        $tramite['USUA_CNOMBRES'] = $ObjAuth->USUA_CNOMBRES;
        $tramite['USUA_CPRIMER_APELLIDO'] = $ObjAuth->USUA_CPRIMER_APELLIDO;
        $tramite['USUA_CSEGUNDO_APELLIDO'] = $ObjAuth->USUA_CSEGUNDO_APELLIDO;
        $tramite['USUA_DFECHA_NACIMIENTO'] = $ObjAuth->USUA_DFECHA_NACIMIENTO;
        $tramite['USUA_CCORREO_ELECTRONICO'] = $ObjAuth->USUA_CCORREO_ELECTRONICO;
        $tramite['USUA_CCORREO_ALTERNATIVO'] = $ObjAuth->USUA_CCORREO_ALTERNATIVO;
        $tramite['USUA_NTELEFONO'] = $ObjAuth->USUA_NTELEFONO;
        $tramite['USUA_CCALLE_PARTICULAR'] = $ObjAuth->USUA_CCALLE_PARTICULAR;
        $tramite['USUA_NNUMERO_INTERIOR_PARTICULAR'] = $ObjAuth->USUA_NNUMERO_INTERIOR_PARTICULAR;
        $tramite['USUA_NNUMERO_EXTERIOR_PARTICULAR'] = $ObjAuth->USUA_NNUMERO_EXTERIOR_PARTICULAR;
        $tramite['USUA_NCP_PARTICULAR'] = $ObjAuth->USUA_NCP_PARTICULAR;
        $tramite['USUA_CCOLONIA_PARTICULAR'] = $ObjAuth->USUA_CCOLONIA_PARTICULAR;
        $tramite['USUA_CMUNICIPIO_PARTICULAR'] = $ObjAuth->USUA_CMUNICIPIO_PARTICULAR;
        $tramite['USUA_CESTADO_PARTICULAR'] = $ObjAuth->USUA_CESTADO_PARTICULAR;
        $tramite['USUA_CPAIS_PARTICULAR'] = $ObjAuth->USUA_CPAIS_PARTICULAR;

        $tramite["DOCS_BASE"][] = [];
        //CREO ARRAY CON LOS TIPOS DE DOCUMENTOS
        $arrTst='';$ARR_DOC_CON = [];;
        $tramite['USDO_NIDUSUARIORESP'] = [];
        $tramite['USDO_NESTATUS'] = [];
        $Cls_documento_config = new Cls_Tramite_Servicio();
        $result = $Cls_documento_config->getConfigDocArr();
        foreach ($result as $_dtsc) {
            $id_arr = $_dtsc->id;
            $NOMBRE_arr = $_dtsc->NOMBRE;
            $ARR_DOC_CON[$id_arr] = $NOMBRE_arr;
        };

        //Cls_Tramite_Servicio
        $DOCtram        = new Cls_Tramite_Servicio();
        $repositorio    = $DOCtram->getTRAMexp(Auth::user()->USUA_NIDUSUARIO);

        $tramite['repositorio'] = [];
        $docs_base='';
        ///////////////////////////////////////////////////////////////////
        //AGREGANDO LOS DOCUMENTOS DE SOLICITUDES
        foreach ($repositorio as $_doc) {
            if($_doc->USDO_NPESO>0){
                $repodoc = new Cls_Usuario_Documento;
                $repodoc->USDO_CDOCNOMBRE = $_doc->USDO_CDOCNOMBRE;
                $repodoc->USDO_CEXTENSION = $_doc->USDO_CEXTENSION;
                $repodoc->USDO_CRUTADOC = $_doc->USDO_CRUTADOC;
                $repodoc->USDO_NPESO = $_doc->USDO_NPESO;
                $repodoc->VIGENCIA_FIN = $repodoc->VIGENCIA_FIN;
                $f_USDO_CDOCNOMBRE = $repodoc->USDO_CDOCNOMBRE;
                $tramite['USDO_NESTATUS'][$f_USDO_CDOCNOMBRE] = $_doc->USDO_NESTATUS;
                $tramite['TEST'][$f_USDO_CDOCNOMBRE] ='';

                if (array_key_exists($f_USDO_CDOCNOMBRE, $tramite['DOCS_BASE'])) {
                }else{
                    $tramite['DOCS_BASE'][$f_USDO_CDOCNOMBRE][0] = $_doc->USDO_CEXTENSION;
                    $tramite['DOCS_BASE'][$f_USDO_CDOCNOMBRE][1] = $_doc->USDO_NPESO;
                    $tramite['DOCS_BASE'][$f_USDO_CDOCNOMBRE][2] = $_doc->USDO_CRUTADOC;
                    $tramite['DOCS_BASE'][$f_USDO_CDOCNOMBRE][3] = $_doc->USDO_NESTATUS;
                    $tramite['DOCS_BASE'][$f_USDO_CDOCNOMBRE][5] = $_doc->VIGENCIA_FIN;
                    $tramite['DOCS_BASE'][$f_USDO_CDOCNOMBRE][6] = $_doc->USDO_NIDUSUARIORESP;
                };

                $TIPO_doc = $_doc->TIPO;
                $estatus  = $_doc->USDO_NESTATUS;
                if($TIPO_doc=='EXP' && $estatus==1){
                    $tramite['DOCS_BASE'][$f_USDO_CDOCNOMBRE][3]=0;
                };

                $key_ARR_DOC_CON = array_search($f_USDO_CDOCNOMBRE, $ARR_DOC_CON);
                if($key_ARR_DOC_CON>0){
                    $tramite['DOCS_BASE'][$f_USDO_CDOCNOMBRE][4] = $key_ARR_DOC_CON;
                };
                $tramite['repositorio'][] = $repodoc;
            };
        }
        /* dd($tramite['configuracion']['documentos']); */
        //$tramite['descripcionesDoc'] = $arrayDocumentos;
        ///////////////////////////////////////////////////////////////////

        $nmbres='';$P_NESTATUS='';$TXT_STAT=$arrTst;$docs_base;
        return view('MST_TRAMITE_SERVICIO.iniciar_tramite_servicio', compact('tramite', 'descripcion', 'ARR_DOC_CON', 'nmbres', 'P_NESTATUS', 'TXT_STAT', 'docs_base'));
    }
    public function obtenerInformacionCiudadano(Request $request)
    {
        # code...
        if(isset($request->NIDEUSUARIO)){
            $datos = Cls_PersonaFisicaMoral::where('USUA_NIDUSUARIO',$request->NIDEUSUARIO)->get();
            return response()->json($datos, 200);
        }else{
            return response()->json(['informacion'=> false], 404);
        }
    }

    public function seguimiento_tramite_servicio($id) {
        try {
            $objUsuario     = Auth::user();
            $tramites       = new Cls_Tramite_Servicio();
            $detalle        = $tramites->TRAM_CONSULTAR_DETALLE_TRAMITE_SEGUIMIENTO($id);
            $configaracion  = $tramites->TRAM_CONSULTAR_CONFIGURACION_TRAMITE_PUBLICO($detalle->TRAM_NIDTRAMITE, $detalle->USTR_NIDUSUARIOTRAMITE);
            $pagoTramite    = Cls_Pago_Tramite::where([['USTR_NIDUSUARIOTRAMITE','=',$id],['Activo','=',1]])->first();
            $resolutivosConfig = Cls_Seguimiento_Servidor_Publico::TRAM_OBTENER_RESOLUTIVOS_CONFIGURADOS($detalle->TRAM_NIDTRAMITE);

            //Verificar seccion seguiente, para activar
            foreach ($configaracion['secciones'] as $item) {
                if (isset($item->SSEGTRA_NIDSECCION_SEGUIMIENTO)) {
                    if ($item->CONF_NESTATUS_SEGUIMIENTO == 0) {
                        $this->seccion_active = $item->SSEGTRA_NIDSECCION_SEGUIMIENTO;
                        break;
                    } else if ($item->CONF_NESTATUS_SEGUIMIENTO == 1) {
                        $this->seccion_active = $item->SSEGTRA_NIDSECCION_SEGUIMIENTO;
                        break;
                    }
                }
            }
            //VAlido si esta dando seguimiento
            if(session()->has('consultarPen'))
                $this->atencion = 1;


            $tramite = [];
            $tramite['id']                  = $detalle->TRAM_NIDTRAMITE;
            $tramite['idusuariotramite']    = $id;
            $tramite['idtramiteaccede']     = $detalle->TRAM_NIDTRAMITE_ACCEDE;
            $tramite['idsuario']            = $detalle->USTR_NIDUSUARIO;
            $tramite['modulo']              = intval($detalle->USTR_CMODULO);
            $tramite['nombreUsuario']       = $objUsuario->USUA_CNOMBRES;
            $tramite['rfcUser']             = $objUsuario->USUA_CRFC;
            $tramite['apellidoPUsuario']    = $objUsuario->USUA_CPRIMER_APELLIDO;
            $tramite['apellidoMUsuario']    = $objUsuario->USUA_CSEGUNDO_APELLIDO;
            $tramite['correoUsuario']       = $objUsuario->USUA_CCORREO_ELECTRONICO;
            $tramite['tipoPersona']         = $objUsuario->USUA_NTIPO_PERSONA;
            $tramite['razonSocioal']        = $objUsuario->USUA_CRAZON_SOCIAL;
            $tramite['idTramitePago']       = time()+$detalle->TRAM_NIDTRAMITE;;
            $tramite['nombre']              = $detalle->TRAM_CNOMBRE;
            $tramite['folio']               = $detalle->TRAM_CFOLIO_SEGUIMIENTO;
            $tramite['fechaactualizacion']  = $detalle->updated_at;
            $tramite['responsable']         = $detalle->TRAM_CCENTRO;
            $tramite['descripcion']         = $detalle->TRAM_CDESCRIPCION;
            $tramite['estatus']             = $detalle->TRAM_NESTATUS_PROCESO == null ? 1 : $detalle->TRAM_NESTATUS_PROCESO;
            $tramite['atencion_formulario'] = $this->atencion;
            $tramite['encuesta_contestada'] = $detalle->USTR_NENCUESTA_CONTESTADA;
            $tramite['seccion_active']      = $this->seccion_active;
            $tramite['giros']               = [];
            $tramite['dias_resolucion']     = $detalle->TRAM_NDIASHABILESNOTIFICACION;

            if(!$pagoTramite){
                $tramite['tienePago'] = 0;
            }else{
                $tramite['tienePago'] = 1;
               
                $folioSlit = explode("/",$pagoTramite->FolioControlEstado);
                $tramite['datosPago'] = [
                    'FolioControlEstado' => $pagoTramite->FolioControlEstado,
                    'Periodo' => $folioSlit[0],
                    'Folio' => $folioSlit[1],
                    'LineaCaptura' =>  $pagoTramite->LineaCaptura,
                    'FechaVencimiento' =>  $pagoTramite->StrFechaVencimiento,
                    'UrlFormatoPago' =>  $pagoTramite->UrlFormatoPago,
                ];
            }

            if ($detalle->TRAM_NESTATUS_PROCESO == null || $detalle->TRAM_NESTATUS_PROCESO == 0)
                $tramite['disabled'] = "";
            else
                $tramite['disabled'] = $detalle->TRAM_NESTATUS_PROCESO == 1 ? "" : "disabled";

            $claveTramitePago =  $tramites->TRAM_CONSULTAR_CONFIGURACION_TRAMITE_CONCEPTO($tramite['idtramiteaccede']);
            $tramite['clavePago'] = is_null($claveTramitePago ) ? "0" : intval($claveTramitePago->Referencia);

            //consulta para obtener el nombre y direccion del modulo seleccionado para la ventanilla sin cita
            $tramite['ventanilla_sin_cita_lat'] = $detalle->USTR_NLATITUD == null ? 0 : $detalle->USTR_NLATITUD;
            $tramite['ventanilla_sin_cita_lon'] = $detalle->USTR_NLONGITUD == NULL ? 0 : $detalle->USTR_NLONGITUD;
            $tramite['ubicacion_ventanilla_sin_cita'] = $detalle->USTR_CMODULO;
            //     }
            // }

            $exist = Cls_Usuario_Tramite::where('USTR_NIDUSUARIOTRAMITE', $detalle->USTR_NIDUSUARIOTRAMITE)
                ->select('*')
                ->first();

            $respuestas = Cls_Usuario_Respuesta::where('USRE_NIDUSUARIOTRAMITE', $exist->USTR_NIDUSUARIOTRAMITE)
                ->select('*')
                ->get()->toArray();


            foreach ($configaracion['formularios'] as $form) {
                foreach ($form->secciones as $sec) {
                    foreach ($sec->preguntas as $preg) {
                        $preg->estatus = 0;
                        $preg->observaciones = "";
                        foreach ($preg->respuestas as $resp) {
                            $resp->FORM_CVALOR_RESPUESTA = "";
                            $resp->respArray    = array();
                            $resp->respString   = "";
                            $resp->id           = 0;

                            foreach ($resp->respuestas_especial as $esp) {
                                $esp->id = 0;
                                $esp->FORM_CVALOR_RESPUESTA = "";
                            }

                            foreach ($respuestas as $_resp) {
                                if ($preg->FORM_NID == $_resp['USRE_NIDPREGUNTA']) {
                                    $preg->estatus = $_resp['USRE_NESTATUS'];
                                    $preg->observaciones = $_resp['USRE_COBSERVACION'];
                                }
                                switch ($preg->FORM_CTIPORESPUESTA) {
                                    case "multiple":
                                        if ($resp->FORM_NPREGUNTAID == $_resp['USRE_NIDPREGUNTA']) {
                                            if ($resp->FORM_NID == $_resp['USRE_CRESPUESTA']) {
                                                $resp->FORM_CVALOR_RESPUESTA = "checked";
                                                $resp->id = $_resp['USRE_NIDUSUARIORESP'];
                                                break;
                                            }
                                        }
                                        break;
                                    case "unica":
                                        if ($resp->FORM_NPREGUNTAID == $_resp['USRE_NIDPREGUNTA']) {
                                            if ($resp->FORM_NID == $_resp['USRE_CRESPUESTA']) {
                                                $resp->FORM_CVALOR_RESPUESTA = "checked";
                                                $resp->id = $_resp['USRE_NIDUSUARIORESP'];
                                                break;
                                            } else {
                                                $resp->id = $_resp['USRE_NIDUSUARIORESP'];
                                            }
                                        }
                                        break;
                                    case "especial":
                                        foreach ($resp->respuestas_especial as $esp) {
                                            switch ($resp->FORM_CTIPORESPUESTAESPECIAL) {
                                                case "opciones":
                                                    if ($esp->FORM_NPREGUNTARESPUESTAID == $_resp['USRE_NIDPREGUNTARESPUESTA']) {
                                                        if ($esp->FORM_NID == $_resp['USRE_CRESPUESTA']) {
                                                            $esp->FORM_CVALOR_RESPUESTA = "selected";
                                                            $esp->id = $_resp['USRE_NIDUSUARIORESP'];
                                                            break;
                                                        }
                                                    }
                                                    break;
                                                default:

                                                    if ($esp->FORM_NPREGUNTARESPUESTAID == $_resp['USRE_NIDPREGUNTARESPUESTA']) {
                                                        $esp->FORM_CVALOR_RESPUESTA = $_resp['USRE_CRESPUESTA'];
                                                        $esp->id = $_resp['USRE_NIDUSUARIORESP'];
                                                        break;
                                                    }
                                                    break;
                                            }
                                        }
                                        break;
                                    case "catalogo":
                                        if ($resp->FORM_NPREGUNTAID == $_resp['USRE_NIDPREGUNTA']) {
                                            $resp->respString   = $_resp['USRE_CRESPUESTA'];
                                            $resp->id           = $_resp['USRE_NIDUSUARIORESP'];

                                            if($resp->FORM_CVALOR == 'tram_cat_giros'){
                                                $resp->respArray    = json_decode($_resp['USRE_CRESPUESTA']);
                                                $resp->respArray    = is_array($resp->respArray) ? $resp->respArray : [];
                                                $resp->respClave    = '';
                                                $respArray          = [];

                                                foreach($resp->respArray as $item ){
                                                    array_push($respArray, $item->id);
                                                }
                                                $objArray = (object)["pregunta" => "resp_".$_resp['USRE_NIDPREGUNTA']."_0", "respuesta" => $respArray];
                                                array_push($tramite['giros'], $objArray);
                                            }
                                        }
                                        break;
                                    default:
                                        if ($resp->FORM_NPREGUNTAID == $_resp['USRE_NIDPREGUNTA']) {
                                            $resp->FORM_CVALOR_RESPUESTA = $_resp['USRE_CRESPUESTA'];
                                            $resp->id = $_resp['USRE_NIDUSUARIORESP'];
                                            break;
                                        }
                                        break;
                                }
                            }
                        }
                    }
                }
            }
        } catch (\Throwable $th) {
            dd($th);
        }

        $tramite['configuracion'] = $configaracion;
        $tramite['resolutivosConfig'] = $resolutivosConfig;

        //validar si el paso de ventanilla sin cita ha finalizado
        $secciones = $configaracion['secciones'];
        $tramite['ventanillaSinCitaFinalizado'] = 1; //0-Finalizado, 1-No Finalizado
        foreach ($secciones as $sec) {
            if ($sec->CONF_NSECCION == "Ventanilla sin cita") {
                if ($sec->CONF_NESTATUS_SEGUIMIENTO == 2) {
                    $tramite['ventanillaSinCitaFinalizado'] = 0;
                }
                break;
            }
        }

        //Obtener detalles del tramite
        $objTramite     = $this->tramiteService->getTramite($tramite['idtramiteaccede']);
        $result         = $this->tramiteService->getDetalle($objTramite->Id);

        $tramite['infoModulo'] = (array) $result['oficinas'][0];
        $cita = Cls_Citas_Calendario::where([
                ["CITA_IDUSUARIO", $detalle->USTR_NIDUSUARIO],
                ["CITA_IDTRAMITE", $tramite['id']],
                ["CITA_IDMODULO", $tramite['infoModulo']['iId']],
            ])->orderBy('idcitas_tramites_calendario', 'DESC');
        $tramite['cita'] = ($cita->count() > 0
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

        //Cambiar status de la cita en linea
        if (count($tramite['cita']) > 0) {
            for ($i=0; $i < count($tramite['configuracion']['secciones']); $i++) {
                if ($tramite['configuracion']['secciones'][$i]->CONF_NSECCION == "Citas en l??nea")
                    $tramite['configuracion']['secciones'][$i]->CONF_NESTATUS_SEGUIMIENTO = 2;
            }
        }
        /* dd($tramite['configuracion']['formularios'][0]->secciones); */
        return view('MST_TRAMITE_SERVICIO.seguimiento_tramite_servicio2', compact('tramite'));
    }

    public function ubicacion_ventanilla_sin_cita(Request $request)
    {
        $response = [
            'codigo' => 200,
            'status' => "success",
            'message' => 'Los datos se han guardado correctamente.'
        ];

        if ($request->ajax()) {
            try {
                DB::beginTransaction();

                $IntIdUsuarioTramite = $request->id;
                $IntIdUbicacionVentanillaSinCita = $request->id_ubicacion;
                $longitud = $request->longitud;
                $latitud = $request->latitud;

                $tram = Cls_Usuario_Tramite::where('USTR_NIDUSUARIOTRAMITE', $IntIdUsuarioTramite)
                    ->update([
                        'USTR_CMODULO' => $IntIdUbicacionVentanillaSinCita,
                        'USTR_NLATITUD' => $latitud,
                        'USTR_NLONGITUD' => $longitud
                    ]);

                DB::commit();
            } catch (Exception $e) {
                $response = [
                    'codigo' => 500,
                    'status' => "error",
                    'message' => 'Hubo un problema al guardar la informaci??n.',
                ];
            }
        } else {
            $response = [
                'codigo' => 403,
                'status' => "error",
                'message' => 'Petici??n denegada.',
            ];
        }

        return Response()->json($response);
    }

    public function consultar_detalle_notificacion($id) {
        $tramites = new Cls_Tramite_Servicio();
        $noti = $tramites->TRAM_CONSULTAR_DETALLE_NOTIFICACION($id);
        $detalle = $tramites->TRAM_CONSULTAR_DETALLE_TRAMITE_SEGUIMIENTO($noti->HNOTI_NIDUSUARIOTRAMITE);
        $tramite = [];
        $tramite['id'] = $detalle->TRAM_NIDTRAMITE;
        $tramite['idusuariotramite'] = $noti->HNOTI_NIDUSUARIOTRAMITE;
        $tramite['nombre'] = $detalle->TRAM_CNOMBRE;
        $tramite['folio'] = $detalle->TRAM_CFOLIO_SEGUIMIENTO;
        $tramite['responsable'] = $detalle->TRAM_CCENTRO;
        $tramite['descripcion'] = $detalle->TRAM_CDESCRIPCION;
        $tramite['estatus'] = $detalle->TRAM_NESTATUS_PROCESO == null ? 1 : $detalle->TRAM_NESTATUS_PROCESO;
        $tramite['atencion_formulario'] = $this->atencion;
        $tramite['notificacion'] = $noti;
        $tramites->TRAM_VISTO_NOTIFICACION($id);

        return view('MST_TRAMITE_SERVICIO.detalle_notificacion', compact('tramite'));
    }

    public function atencion_notificacion_seguimiento($id, $noti)
    {
        session(['consultarPen' => $noti]);
        $tramites = new Cls_Tramite_Servicio();
        /* $tramites->TRAM_VISTO_NOTIFICACION($noti); */
        $notificacion_det = $tramites->TRAM_CONSULTAR_DETALLE_NOTIFICACION($noti);
        $this->atencion = 1;
        $this->seccion_active = $notificacion_det->HNOTI_NIDCONFIGSECCION; //Activar seccion
        return $this->seguimiento_tramite_servicio($id);
    }

    public function obtener_dependencias_unidad() {
        $result =  Cls_Dependencia::all();
        return response()->json($result);
    }

    public function obtener_modalidad()
    {
        $collection = collect();

        for ($i = 0; $i < 5; $i++) {
            $data = [
                'id' => $i + 1,
                'nombre' => "Opci??n MO " . $i
            ];
            $collection->push($data);
        }

        return Response()->json($collection);
    }

    public function obtener_clasificacion()
    {
        $collection = collect();

        for ($i = 0; $i < 5; $i++) {
            $data = [
                'id' => $i + 1,
                'nombre' => "Opci??n CS " . $i
            ];
            $collection->push($data);
        }

        return Response()->json($collection);
    }

    public function obtener_audiencia()
    {
        $collection = collect();

        for ($i = 0; $i < 5; $i++) {
            $data = [
                'id' => $i + 1,
                'nombre' => "Opci??n AU " . $i
            ];
            $collection->push($data);
        }

        return Response()->json($collection);
    }

    public function obtener_municipio($id)
    {
        $objTramite = $this->tramiteService->getTramite($id);
        $direccion  = $this->tramiteService->getEstadoandMunicipio($objTramite->dependenciaId);
        $municipios = array();

        if (!is_null($direccion))
            $municipios = ["id" => $direccion->municipioId, "nombre" => $direccion->municipio];

        return Response()->json($municipios);
    }

    public function obtener_modulo($id, $idaccede)
    {
        $objTramite     = $this->tramiteService->getTramite($idaccede);
        $arrayDetalle   = $this->tramiteService->getDetalle($objTramite->Id);
        $datosGenerales = $this->tramiteService->valoresDefaulTramite($arrayDetalle, $objTramite);

        return Response()->json($datosGenerales['oficinas']);
    }

    public function obtener_modulo_detalle($id)
    {
        $lstModulos = [];
        $options = array(
            'http' => array(
                'method'  => 'GET',
            )
        );
        $_objD = null;
        $url = $this->host . '/api/Tramite/EdificioPorId/' . $id;
        $context = stream_context_create($options);
        $result = @file_get_contents($url, false, $context);
        if (strpos($http_response_header[0], "200")) {
            $arr = json_decode($result, true);
            $_objD = [
                "id" => $arr['id'] ?? "",
                "nombre" => $arr['nombre'] ?? "",
                "referencia" => $arr['CALLES'],
                "latitud" => 20.9800512,
                "longitud" => -89.7029587
            ];
        }

        return Response()->json($_objD);
    }

    public function crear()
    {
        $resulList = [];
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 100; $i++) {
            $tramite = new Cls_Tramite_Servicio();
            $tramite->TRAM_NTIPO = 25;
            $tramite->TRAM_NIDUNIDADADMINISTRATIVA = 1;
            $tramite->TRAM_CNOMBRE = $faker->catchPhrase;
            $tramite->TRAM_CENCARGADO = $faker->name;
            $tramite->TRAM_CUNIDADADMIN = "1";
            $tramite->TRAM_CCONTACTO = $faker->phoneNumber;
            $tramite->TRAM_CDESCRIPCION = $faker->text($maxNbChars = 200);
            $result = $tramite->TRAM_SP_CREARTRAMITE();

            $resulList[$i] = $result;
        }
        return response()->json($resulList);
    }

    //General
    public function procesarTramite($tipo, $request){
        $respuestas = array();
        $especiales = array();
        $documentos = array();
        $secciones  = array();

        foreach ($request->all() as $key => $value) {
            $k = substr($key, 0, 5);
            $f = substr($key, 0, 10);
            $e = substr($key, 0, 9);
            $s = substr($key, 0, 5);

            //resp_ "respuestas", resp_especial_ "respuestas de pregunta especial" y docs_ "documentos"
            if ($k == 'resp_')
                $respuestas[$key] = $value;
            if ($f == 'docs_file_')
                $documentos[$key] = $value;
            if ($e == 'especial_')
                $especiales[$key] = $value;
            if ($s == 'secc_')
                $secciones[$key] = $value;
        }

        $exist = Cls_Usuario_Tramite::where('USTR_NIDTRAMITE', $request->txtIdTramite)
                        ->where('USTR_CFOLIO', $request->txtFolio)->first();
    
        $IntIdUsuarioTramite = null;
        $TxtFolio = null;
        $tram = new Cls_Usuario_Tramite();

        $nEstatus = 1;
        $nProceso = 0;
        $cMovimiento = "";
        switch($tipo){
            case 1:
                $nEstatus = 1; //iniciar
                $nProceso = 0; //pendiente
                $cMovimiento = "Edici??n inicial tr??mite";
                break;
            case 2:
                $nEstatus = 2; //enviar
                $nProceso = 1; //proceso
                $cMovimiento = "En proceso tr??mite";
                break;
        }

        if ($exist == null) {
            $num = 1;
            $getUltimoFolio = Cls_Usuario_Tramite::get()->last();

            if ($getUltimoFolio != null) {
                $num = $getUltimoFolio->USTR_NNUMERO + 1;
            }
            //Guardar inicio de tramite
            $tram->USTR_NESTATUS = $nEstatus;
            $tram->USTR_NIDUSUARIO = $request->txtIdUsuario;
            $tram->USTR_NIDTRAMITE = $request->txtIdTramite;
            $tram->USTR_NBANDERA_PROCESO = $nProceso;
            $tram->USTR_NPAGADO = 0;
            $tram->USTR_CFOLIO = $request->txtFolio . "/00000" . $num;
            $tram->USTR_NNUMERO = $num;
            $tram->USTR_CMUNICIPIO = $request->txtMunicipio;
            $tram->USTR_CMODULO = $request->txtModulo;
            $tram->USTR_NLATITUD = $request->txtLatitud;
            $tram->USTR_NLONGITUD = $request->txtLongitud;
            $tram->save();

            $IntIdUsuarioTramite = $tram->id;
            $TxtFolio = $tram->USTR_CFOLIO;

            //Insertar bitacora
            $ObjBitacora = new Cls_Bitacora();
            $ObjBitacora->BITA_NIDUSUARIO = $request->txtIdUsuario;
            $ObjBitacora->BITA_CMOVIMIENTO = "Captura inicial tr??mite";
            $ObjBitacora->BITA_CTABLA = "tram_mdv_usuariotramite";
            $ObjBitacora->BITA_CIP = $request->ip();
            $ObjBitacora->BITA_FECHAMOVIMIENTO = now();
            $ObjBitacora->save();
        } else {
            $IntIdUsuarioTramite = $exist->USTR_NIDUSUARIOTRAMITE;
            $TxtFolio = $exist->USTR_CFOLIO;

            //Seguimiento
            if($tipo == 2){
                //Editar estatus del tramite
                $tram = Cls_Usuario_Tramite::where('USTR_NIDUSUARIOTRAMITE', $IntIdUsuarioTramite)
                ->update([
                    'USTR_NESTATUS' => 2,
                    'USTR_NBANDERA_PROCESO' => 1
                ]);
            }

            //Insertar bitacora
            $ObjBitacora = new Cls_Bitacora();
            $ObjBitacora->BITA_NIDUSUARIO = $request->txtIdUsuario;
            $ObjBitacora->BITA_CMOVIMIENTO = $cMovimiento;
            $ObjBitacora->BITA_CTABLA = "tram_mdv_usuariotramite";
            $ObjBitacora->BITA_CIP = $request->ip();
            $ObjBitacora->BITA_FECHAMOVIMIENTO = now();
            $ObjBitacora->save();

            //Eliminar respuesta del usuario
            Cls_Usuario_Respuesta::where('USRE_NIDUSUARIOTRAMITE', $IntIdUsuarioTramite)->delete();
            //Eliminar documentos del usuario
            if (count($documentos) > 0) {
                Cls_Usuario_Documento::where('USDO_NIDUSUARIOTRAMITE', $IntIdUsuarioTramite)->delete();
            }
        }

        //Guardar respuestas
        foreach ($respuestas as $key => $value) {
            $arr = explode("_", $key);
            $obj_p = Cls_Formulario_Pregunta::where('FORM_NID', $arr[1])
            ->select('*')
            ->first();

            $resp = new Cls_Usuario_Respuesta();
            $resp->USRE_NIDPREGUNTA = $obj_p->FORM_NID;
            $resp->USRE_NIDUSUARIOTRAMITE = $IntIdUsuarioTramite;
            $resp->USRE_CRESPUESTA = $value;
            $resp->USRE_CNOMBRE_PREGUNTA = $obj_p->FORM_CPREGUNTA;
            $resp->USRE_NIDSECCION = $obj_p->FORM_NSECCIONID;
            $resp->USRE_CNOMBRE_SECCION = Cls_Cat_Seccion::where('FORM_NID', $obj_p->FORM_NSECCIONID)
            ->select('*')
            ->first()->FORM_CNOMBRE;
            $resp->USRE_NIDFORMULARIO = $obj_p->FORM_NFORMULARIOID;

            if($tipo == 1){
                if($value == null){
                    $resp->USRE_NESTATUS = 9;
                }else{
                    $resp->USRE_NESTATUS = 0;
                }
            }else if($tipo == 2){
                $resp->USRE_NESTATUS = 0;
            }

            $resp->USRE_CFOLIO_TRAMITE = $TxtFolio;
            $resp->save();
        }

        //Guardar respuestas especial
        foreach ($especiales as $key => $value) {
            $arr = explode("_", $key);
            $obj_p = Cls_Formulario_Pregunta::where('FORM_NID', $arr[1])
                ->select('*')
                ->first();

            $resp = new Cls_Usuario_Respuesta();
            $resp->USRE_NIDPREGUNTA = $obj_p->FORM_NID;
            $resp->USRE_NIDUSUARIOTRAMITE = $IntIdUsuarioTramite;
            $resp->USRE_CRESPUESTA = $value;
            $resp->USRE_CNOMBRE_PREGUNTA = $obj_p->FORM_CPREGUNTA;
            $resp->USRE_NIDSECCION = $obj_p->FORM_NSECCIONID;
            $resp->USRE_CNOMBRE_SECCION = Cls_Cat_Seccion::where('FORM_NID', $obj_p->FORM_NSECCIONID)
                ->select('*')
                ->first()->FORM_CNOMBRE;
            $resp->USRE_NIDFORMULARIO = $obj_p->FORM_NFORMULARIOID;
            $resp->USRE_NIDPREGUNTARESPUESTA = $arr[2];

            if($tipo == 1){
                if($value == null){
                    $resp->USRE_NESTATUS = 9;
                }else{
                    $resp->USRE_NESTATUS = 0;
                }
            }else if($tipo == 2){
                $resp->USRE_NESTATUS = 0;
            }

            $resp->USRE_CFOLIO_TRAMITE = $TxtFolio;
            $resp->save();
        }

        //CREO ARRAY CON LOS TIPOS DE DOCUMENTOS
        $arrTst='';$ARR_DOC_CON = [];;
        $tramite['USDO_NIDUSUARIORESP'] = [];
        $tramite['USDO_NESTATUS'] = [];
        $Cls_documento_config = new Cls_Tramite_Servicio();
        $result = $Cls_documento_config->getConfigDocArr();
        foreach ($result as $_dtsc) {
            $id_arr = $_dtsc->id;
            $NOMBRE_arr = $_dtsc->NOMBRE;
            $ARR_DOC_CON[$id_arr] = $NOMBRE_arr;
        };

        //Guardar documentos
        $test = '';
        foreach ($documentos as $key => $value) {
            if ($value != null) {
                $arr_key = explode("_", $key);
                $arr_value = explode("_", $value);

                $doc = new Cls_Usuario_Documento();
                $doc->USDO_NIDUSUARIOTRAMITE = $IntIdUsuarioTramite;
                $doc->USDO_CRUTADOC = $arr_value[0];
                $doc->USDO_CEXTENSION = $arr_value[1];
                $doc->USDO_NPESO = $arr_value[2];
                $doc->USDO_NESTATUS = 0;
                $doc->USDO_NIDTRAMITEDOCUMENTO = $arr_key[2];
                $doc->USDO_CDOCNOMBRE = $arr_value[3];
                $doc->USDO_NIDUSUARIOBASE = $request->txtIdUsuario;

                if($tipo == 1) {
                    $doc->idDocExpediente = 0;
                    $doc->VIGENCIA_INICIO = date("Y-m-d");
                }

                $key_ARR_DOC_CON = array_search($arr_value[3], $ARR_DOC_CON);
                if($key_ARR_DOC_CON>0){
                    $doc->idDocExpediente = $key_ARR_DOC_CON;
                };

                $test=$test.$doc->USDO_CRUTADOC.'_'.$doc->USDO_CEXTENSION.'_'.$doc->USDO_NPESO.'_'.$doc->idDocExpediente.'*';

                $doc->save(); 
            }
        }

        //Guardar seccion
        //Se valida si existe
        $exist_seccion = Cls_Seccion_Seguimiento::where('SSEGTRA_NIDUSUARIOTRAMITE', $IntIdUsuarioTramite)
            ->select('*')
            ->get()->toArray();
        if (count($exist_seccion) == 0) {
            foreach ($secciones as $key => $value) {
                $arr_key = explode("_", $key);
                $csecc = new Cls_Seccion_Seguimiento();
                $csecc->SSEGTRA_NIDUSUARIOTRAMITE = $IntIdUsuarioTramite;
                $csecc->SSEGTRA_NIDCONFIGURACION = $arr_key[1];
                $csecc->SSEGTRA_CNOMBRE_SECCION = $value;
                $csecc->SSEGTRA_NIDESTATUS = $value == "Formulario" ? 0 : 1;
                $csecc->save();

                //Isertar conceptos de pago
                $tram_conceptos = Cls_Tramite_Concepto::where('CONC_NIDTRAMITE', $request->txtIdTramite)
                    ->where('CONC_NIDSECCION', $arr_key[1])
                    ->select('*')
                    ->get()->toArray();
                foreach ($tram_conceptos as $value) {
                    $usc = new Cls_Usuario_Concepto();
                    $usc->USCON_NIDUSUARIOTRAMITE = $IntIdUsuarioTramite;
                    $usc->USCON_NREFERENCIA = $value['CONC_NREFERENCIA'];
                    $usc->USCON_NIDCONCEPTO = $value['CONC_NIDCONCEPTO'];
                    $usc->USCON_CONCEPTO = $value['CONC_CONCEPTO'];
                    $usc->USCON_CTRAMITE = $value['CONC_CTRAMITE'];
                    $usc->USCON_CENTE_PUBLICO = $value['CONC_CENTE_PUBLICO'];
                    $usc->USCON_CENTE = $value['CONC_CENTE'];
                    $usc->USCON_NIDSECCION = $csecc->id;
                    $usc->USCON_NCANTIDAD = null;
                    $usc->USCON_NACTIVO = 0;
                    $usc->save();
                }
            }
        }
        return $IntIdUsuarioTramite;
    }

    public function guardar(Request $request) {
        try {
            DB::beginTransaction();

            $IntIdUsuarioTramite = $this->procesarTramite(1, $request);
            DB::commit();
            $response = [
                'codigo' => 200,
                'status' => "success",
                'message' => 'Los datos se han guardado correctamente.',
                'data' => $IntIdUsuarioTramite
            ];
        } catch (Exception $ex) {
            DB::rollBack();
            $response = [
                'codigo' => 403,
                'status' => "error",
                'message' => 'Se presento un problema contactar al administrador.',
                'data' => $ex->getMessage()
            ];
        }

        return Response()->json($response);
    }

    public function enviar(Request $request)
    {
        try{
            $IntIdUsuarioTramite = $this->procesarTramite(2, $request);
        }
        catch (\Throwable $e) {
             $response = [
                 'codigo' => 400,
                 'status' => "error",
                 'message' => "Ocurri?? una excepci??n, favor de contactar al administrador del sistema , " .$e->message
             ];
        }

        $response = [
            'codigo' => 200,
            'status' => "success",
            'message' => 'Tu solicitud se ha enviado, te recordamos que los horarios de atenci??n son de Lunes a Viernes de 08:30 a 15:00 hrs. en d??as h??biles. Si tu solicitud fue enviada en d??a inh??bil o fuera de horario laboral, esta ser?? atendida hasta en el pr??ximo d??a laboral, en el horario se??alado.',
            'data' => $IntIdUsuarioTramite
        ];

        return Response()->json($response);
    }

    public function reenviar(Request $request) {
        try{
            $session = session('consultarPen');
            DB::table('tram_his_notificacion_tramite')->where('HNOTI_NIDNOTIFICACION', $session )->update(['HNOTI_NLEIDO' => true]);
            session()->forget('consultarPen');
            
            $respuestas = array();
            $respuestas_especial = array();
            $documentos = array();
            $secciones = array();
            foreach ($request->all() as $key => $value) {
                $k = substr($key, 0, 5);
                $f = substr($key, 0, 10);
                $e = substr($key, 0, 9);
                $s = substr($key, 0, 5);

                //resp_ "respuestas", resp_especial_ "respuestas de pregunta especial" y docs_ "documentos"
                if ($k == 'resp_') {
                    $respuestas[$key] = $value;
                }
                if ($f == 'docs_file_') {
                    $documentos[$key] = $value;
                }
                if ($e == 'especial_') {
                    $respuestas_especial[$key] = $value;
                }
                if ($s == 'secc_') {
                    $secciones[$key] = $value;
                }
            }

            $exist = Cls_Usuario_Tramite::where('USTR_NIDUSUARIO', $request->txtIdUsuario)
                ->where('USTR_NIDTRAMITE', $request->txtIdTramite)
                ->where('USTR_CFOLIO', $request->txtFolio)
                ->select('*')
                ->first();

            $IntIdUsuarioTramite = null;
            $TxtFolio = null;
            $IntIdUsuarioTramite = $exist->USTR_NIDUSUARIOTRAMITE;
            $TxtFolio = $exist->USTR_CFOLIO;
            //Editar bandera del tramite
            $tram = Cls_Usuario_Tramite::where('USTR_NIDUSUARIOTRAMITE', $IntIdUsuarioTramite)
                ->update([
                    'USTR_NBANDERA_PROCESO' => 2,
                    'USTR_NESTATUS' => 2
                ]);

            //Insertar bitacora
            $ObjBitacora = new Cls_Bitacora();
            $ObjBitacora->BITA_NIDUSUARIO = $request->txtIdUsuario;
            $ObjBitacora->BITA_CMOVIMIENTO = "Tr??mite reenviado";
            $ObjBitacora->BITA_CTABLA = "tram_mdv_usuariotramite";
            $ObjBitacora->BITA_CIP = $request->ip();
            $ObjBitacora->BITA_FECHAMOVIMIENTO = now();
            $ObjBitacora->save();

            //Guardar respuestas
            foreach ($respuestas as $key => $value) {
                $arr = explode("_", $key);
                $obj_p = Cls_Formulario_Pregunta::where('FORM_NID', $arr[1])
                    ->select('*')
                    ->first();

                //Exist
                $valorexistt = isset( $arr[3]);
                if($valorexistt){
                    $exist_respuestas = Cls_Usuario_Respuesta::where('USRE_NIDUSUARIORESP', $arr[3])
                    ->select('*')
                    ->first();
                }else{
                    $archivoexist_respuestas = null;
                }
                
                

                if ($exist_respuestas == null) {
                    $resp = new Cls_Usuario_Respuesta();
                    $resp->USRE_NIDPREGUNTA = $obj_p->FORM_NID;
                    $resp->USRE_NIDUSUARIOTRAMITE = $IntIdUsuarioTramite;
                    $resp->USRE_CRESPUESTA = $value;
                    $resp->USRE_CNOMBRE_PREGUNTA = $obj_p->FORM_CPREGUNTA;
                    $resp->USRE_NIDSECCION = $obj_p->FORM_NSECCIONID;
                    $resp->USRE_CNOMBRE_SECCION = Cls_Cat_Seccion::where('FORM_NID', $obj_p->FORM_NSECCIONID)
                        ->select('*')
                        ->first()->FORM_CNOMBRE;
                    $resp->USRE_NIDFORMULARIO = $obj_p->FORM_NFORMULARIOID;
                    $resp->USRE_NESTATUS = 0;
                    $resp->USRE_CFOLIO_TRAMITE = $TxtFolio;
                    $resp->save();
                } else {
                    Cls_Usuario_Respuesta::where(['USRE_NIDUSUARIORESP' => $exist_respuestas->USRE_NIDUSUARIORESP])
                        ->update(['USRE_CRESPUESTA' => $value]);
                }
            }

            //Guardar respuestas especial
            foreach ($respuestas_especial as $key => $value) {
                $arr = explode("_", $key);
                $obj_p = Cls_Formulario_Pregunta::where('FORM_NID', $arr[1])
                    ->select('*')
                    ->first();

                //Exist
                $valorExistEspecial = isset( $arr[3]);
                if($valorExistEspecial){
                    $exist_respuestas_especial = Cls_Usuario_Respuesta::where('USRE_NIDUSUARIORESP', $arr[3])
                    ->select('*')
                    ->first();
                }else{
                $exist_respuestas_especial = null;
                }
                

                if ($exist_respuestas_especial == null) {
                    $resp = new Cls_Usuario_Respuesta();
                    $resp->USRE_NIDPREGUNTA = $obj_p->FORM_NID;
                    $resp->USRE_NIDUSUARIOTRAMITE = $IntIdUsuarioTramite;
                    $resp->USRE_CRESPUESTA = $value;
                    $resp->USRE_CNOMBRE_PREGUNTA = $obj_p->FORM_CPREGUNTA;
                    $resp->USRE_NIDSECCION = $obj_p->FORM_NSECCIONID;
                    $resp->USRE_CNOMBRE_SECCION = Cls_Cat_Seccion::where('FORM_NID', $obj_p->FORM_NSECCIONID)
                        ->select('*')
                        ->first()->FORM_CNOMBRE;
                    $resp->USRE_NIDFORMULARIO = $obj_p->FORM_NFORMULARIOID;
                    $resp->USRE_NIDPREGUNTARESPUESTA = $arr[2];
                    $resp->USRE_NESTATUS = 0;
                    $resp->USRE_CFOLIO_TRAMITE = $TxtFolio;
                    $resp->save();
                } else {
                    Cls_Usuario_Respuesta::where(['USRE_NIDUSUARIORESP' => $exist_respuestas_especial->USRE_NIDUSUARIORESP])
                        ->update(['USRE_CRESPUESTA' => $value]);
                }
            }

            //Guardar documentos
            foreach ($documentos as $key => $value) {
                if ($value != null) {
                    $arr_key = explode("_", $key);
                    $arr_value = explode("_", $value);

                    //Exist
                
                        $exist_docs = Cls_Usuario_Documento::where('USDO_NIDUSUARIORESP', $arr_key[3])
                        ->select('*')
                        ->first();

                
                
                    if ($exist_docs == null) {
                        $doc = new Cls_Usuario_Documento();
                        $doc->USDO_NIDUSUARIOTRAMITE = $IntIdUsuarioTramite;
                        $doc->USDO_CRUTADOC = $arr_value[0];
                        $doc->USDO_CEXTENSION = $arr_value[1];
                        $doc->USDO_NPESO = $arr_value[2];
                        $doc->USDO_NESTATUS = 0;
                        $doc->USDO_NIDTRAMITEDOCUMENTO = $arr_key[2];
                        $doc->USDO_CDOCNOMBRE = $arr_value[3];
                        $doc->USDO_NIDUSUARIOBASE = $request->txtIdUsuario;
                        $doc->save();



                    } else {
                        Cls_Usuario_Documento::where(['USDO_NIDUSUARIORESP' => $exist_docs->USDO_NIDUSUARIORESP])
                            ->update(['USDO_CRUTADOC' => $arr_value[0], 'USDO_CEXTENSION' => $arr_value[1], 'USDO_NPESO' => $arr_value[2]]);
                    }
                }
            }



            $tramite = Cls_Seguimiento_Servidor_Publico::obtener_tramite_usuario($IntIdUsuarioTramite);

            $ObjData['_correo'] = $tramite[0]->USTR_CCORREO_USUARIO;
            $ObjData['_nombre_usuario'] = $tramite[0]->USTR_CNOMBRE_USUARIO;
            $ObjData['_nombre_tramite'] = $tramite[0]->TRAM_CNOMBRE;
            $ObjData['_folio_tramite'] = $tramite[0]->USTR_CFOLIO;
            $ObjData['_homoclave_tramite'] = "H_CLAVE";
            $ObjData['_unidad_administrativa'] = $tramite[0]->TRAM_CCENTRO;
            $ObjData['_secretaria'] = $tramite[0]->TRAM_CCENTRO;
            $ObjData['_fecha_hora'] = now();
            $ObjData['_fecha_maxima'] = now();

            // Mail::send('MSTP_MAIL.notificacion_subsanar', $ObjData, function ($message) use ($ObjData) {
            //     $message->from(env('MAIL_USERNAME'), 'Sistema de Tramites Digitales Queretaro');
            //     $message->to($ObjData['_correo'], '')->subject('Correcci??n de informaci??n sobre tr??mite con folio ' . $ObjData['_folio_tramite']);
            // });

            $response = [
                'codigo' => 200,
                'status' => "success",
                'message' => 'Los datos se han enviado correctamente.'
            ];
        }
        catch (\Throwable $e) {
            $response = [
                'codigo' => 400,
                'status' => "error",
                'message' => "Ocurri?? una excepci??n, favor de contactar al administrador del sistema , " .$e->message
            ];
        // return Response()->json($response);

        }
        return Response()->json($response);


        

    }

    public function enviar_encuesta(Request $request)
    {
        $item = new Cls_Encuesta_Satisfaccion();
        $item->HENCS_NIDUSUARIOTRAMITE = $request->txtIdUsuarioTramite;
        $item->HENCS_CPREGUNTA = "??C??mo fue el servicio que recibi?? por parte de la persona que le atendi???";
        $item->HENCS_CPRESPUESTA = $request->txtPregunta1;
        $item->save();

        $item = new Cls_Encuesta_Satisfaccion();
        $item->HENCS_NIDUSUARIOTRAMITE = $request->txtIdUsuarioTramite;
        $item->HENCS_CPREGUNTA = "De acuerdo a su visita, ??se enfrent?? con obst??culos, barreras o alg??n tipo de inconveniente?";
        $item->HENCS_CPRESPUESTA = $request->txtPregunta2;
        $item->save();

        $item = new Cls_Encuesta_Satisfaccion();
        $item->HENCS_NIDUSUARIOTRAMITE = $request->txtIdUsuarioTramite;
        $item->HENCS_CPREGUNTA = "??Qu?? tan satisfecho se encuentra con el tiempo de atenci??n del tr??mite o servicio?";
        $item->HENCS_CPRESPUESTA = $request->txtPregunta3;
        $item->save();

        $item = new Cls_Encuesta_Satisfaccion();
        $item->HENCS_NIDUSUARIOTRAMITE = $request->txtIdUsuarioTramite;
        $item->HENCS_CPREGUNTA = "??Desea agregar alg??n comentario adicional?";
        $item->HENCS_CPRESPUESTA = $request->txtPregunta4;
        $item->save();

        Cls_Usuario_Tramite::where('USTR_NIDUSUARIOTRAMITE', $request->txtIdUsuarioTramite)
            ->update([
                'USTR_NENCUESTA_CONTESTADA' => 1
            ]);

        $response = [
            'codigo' => 200,
            'status' => "success",
            'message' => 'Acci??n realizada con ??xito.'
        ];

        return Response()->json($response);
    }

    public function enviar_documentos(Request $request)
    {
        $documentos = array();
        foreach ($request->all() as $key => $value) {
            $f = substr($key, 0, 10);

            if ($f == 'docs_file_') {
                $documentos[$key] = $value;
            }
        }

        $exist = Cls_Usuario_Tramite::where('USTR_NIDUSUARIO', $request->txtIdUsuario)
            ->where('USTR_NIDTRAMITE', $request->txtIdTramite)
            ->select('*')
            ->first();

        //Eliminar documentos del usuario
        if (count($documentos) > 0) {
            Cls_Usuario_Documento::where('USDO_NIDUSUARIOTRAMITE', $exist->USTR_NIDUSUARIOTRAMITE)->delete();
        }

        //Guardar documentos
        foreach ($documentos as $key => $value) {
            if ($value != null) {
                $arr_key = explode("_", $key);
                $arr_value = explode("_", $value);

                $doc = new Cls_Usuario_Documento();
                $doc->USDO_NIDUSUARIOTRAMITE = $exist->USTR_NIDUSUARIOTRAMITE;
                $doc->USDO_CRUTADOC = $arr_value[0];
                $doc->USDO_CEXTENSION = $arr_value[1];
                $doc->USDO_NPESO = $arr_value[2];
                $doc->USDO_NESTATUS = 0;
                $doc->USDO_NIDTRAMITEDOCUMENTO = $arr_key[2];
                $doc->USDO_CDOCNOMBRE = $arr_value[3];
                $doc->USDO_NIDUSUARIOBASE = $request->txtIdUsuario;

                $doc->save();
            }
        }

        $response = [
            'codigo' => 200,
            'status' => "success",
            'message' => 'Los documentos se han enviado correctamente.'
        ];

        return Response()->json($response);
    }

    public function subir_documento(Request $request)
    {
        $path       = 'files/documentos/';
        $archivo    = $request->file('file');
        $response   = $this->variosService->subeArchivo($archivo, $path);
        $response   = array_merge($response, ["typename" => $request->doctype]);

        return response()->json($response);
    }

    public function download_tramite_detalle($id)
    {
        $tramites = new Cls_Tramite_Servicio();
        $detalle = $tramites->TRAM_CONSULTAR_DETALLE_TRAMITE($id);

        //tramite
        $urlTramite = $this->host . '/api/vw_accede_tramite_id/' . $detalle->TRAM_NIDTRAMITE_ACCEDE;
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

        //dd($objTramite);

        $tramite = [];
        $tramite['id'] = $id;
        $tramite['nombre'] = $objTramite == null ? $detalle->TRAM_CNOMBRE : $objTramite['TRAMITE'];
        $tramite['responsable'] = $objTramite == null ? $detalle->TRAM_CCENTRO : $objTramite['DESC_CENTRO'];
        $tramite['descripcion'] = $objTramite == null ? $detalle->TRAM_CDESCRIPCION : $objTramite['DESCRIPCION'];
        $tramite['estatus'] = $detalle->TRAM_NESTATUS_PROCESO == null ? 1 : $detalle->TRAM_NESTATUS_PROCESO;
        if ($detalle->TRAM_NESTATUS_PROCESO == null) {
            $tramite['disabled'] = "";
        } else {
            $tramite['disabled'] = $detalle->TRAM_NESTATUS_PROCESO == 1 ? "" : "disabled";
        }

        //Oficinas
        $lstOficinas = [];
        if ($objTramite != null) {
            $arrOficinas = (explode("||", $objTramite['EDIFICIOS']));
            foreach ($arrOficinas as $value) {
                $urlEdificio = $this->host . '/api/vw_accede_edificios_id/' . $value;
                $context = stream_context_create($options);
                $result = @file_get_contents($urlEdificio, false, $context);
                if (strpos($http_response_header[0], "200")) {
                    $objEdificio = json_decode($result, true);
                    $_objE = [
                        "id" => $objEdificio['ID_EDIFICIO'],
                        "nombre" => $objEdificio['EDIFICIO'],
                        "direccion" => $objEdificio['DIRECCION'] . ", " .  $objEdificio['COLONIA'] . ", " . $objEdificio['MUNICIPIO'] . ", " . $objEdificio['ESTADO'],
                        "horario" => "",
                        "latitud" => $objEdificio['LATITUD'] ?? 0,
                        "longitud" => $objEdificio['LONGITUD'] ?? 0,
                        "responsable" => $objTramite['ENCARGADO_TRAMITE'] ?? "",
                        "contacto_telefono" => $objTramite['CONTACTO_ENCARGADO'] ?? "",
                        "contacto_email" => "",
                        "informacion_adicional" => $objTramite['INFOADIC'] ?? ""
                    ];
                    array_push($lstOficinas, $_objE);
                }
            }
        }

        //dd($lstOficinas);

        $tramite['oficinas'] = $lstOficinas;

        $tramite['informacion_general'] = [
            [
                "titulo" => "Periodo en que puedo realizar el tr??mite",
                "descripcion" => $objTramite['INICIO_VIGENCIA'] . " al " . $objTramite['FIN_VIGENCIA'] ?? "",
                "opciones" => [],
            ],
            [
                "titulo" => "Usuario a quien est?? dirigido el tr??mite:",
                "descripcion" => $objTramite['DIRIGIDO'] ?? "",
                "opciones" => [],
            ],
            [
                "titulo" => "Tipo de persona:",
                "descripcion" => $objTramite['TIPO_PERSONA'] ?? "",
                "opciones" => [],
            ],
            [
                "titulo" => "Tipo de documento entregado:",
                "descripcion" => $objTramite['ENTREGABLE'] ?? "",
                "opciones" => [],
            ],
            [
                "titulo" => "Tiempo h??bil promedio de resoluci??n:",
                "descripcion" => $objTramite['TIEMPO_RESPUESTA'] ?? "",
                "opciones" => [],
            ],
            [
                "titulo" => "Vigencias de los documentos:",
                "descripcion" => $objTramite['VIGENCIA'] ?? "",
                "opciones" => [],
            ],
            [
                "titulo" => "Audiencia",
                "descripcion" => $objTramite['AUDIENCIA'] ?? "",
                "opciones" => [],
            ],
            [
                "titulo" => "Clasificaci??n",
                "descripcion" => $objTramite['CLASIFICACION'] ?? "",
                "opciones" => [],
            ],
            [
                "titulo" => "Beneficio del usuario:",
                "descripcion" => $objTramite['BENEFICIOS'] ?? "",
                "opciones" => [],
            ],
            [
                "titulo" => "Derechos del usuario:",
                "descripcion" => $objTramite['DERECHOS_USUARIO'] ?? "",
                "opciones" => [],
            ]
        ];

        //Documentos
        $lstDocumentos = [];
        if ($objTramite != null) {
            $urlDocumento = $this->host . '/api/vw_accede_tramite_documento_tram_id/' . $objTramite['ID_TRAM'];
            $context = stream_context_create($options);
            $result = @file_get_contents($urlDocumento, false, $context);
            if (strpos($http_response_header[0], "200")) {
                $objDocumento = json_decode($result, true);
                foreach ($objDocumento as $doc) {
                    $nombre_doc = $doc['DOCU_CDESCRIPCION'] ?? "" . $doc['OTRODOC'] ?? "";
                    $_objD = [
                        "nombre" => $nombre_doc,
                        "presentacion" => $doc['PRES'] ?? "",
                        "observaciones" => $doc['OBS'] ?? "",
                    ];
                    array_push($lstDocumentos, $_objD);
                }
            }
        }

        $tramite['requerimientos'] = [
            [
                "titulo" => "Casos en que se debe realizar el tr??mite:",
                "descripcion" => $objTramite['CASO_REALIZACION'] ?? "",
                "opciones" => [],
                "documentos" => []
            ],
            [
                "titulo" => "Requisitos:",
                "descripcion" => "",
                "opciones" => [
                    $objTramite['REQUISITOS'] ?? ""
                ],
                "documentos" => []
            ],
            [
                "titulo" => "Documentos requeridos:",
                "descripcion" => "",
                "opciones" => [],
                "documentos" => $lstDocumentos
            ],
            [
                "titulo" => "??Puede hacer el tr??mite alguien m??s?:",
                "descripcion" => $objTramite['SNALGUIENMAS'] . ", " . $objTramite['ALGUIENMAS'] ?? "",
                "opciones" => [],
                "documentos" => []
            ],
            [
                "titulo" => "Casos de rechazo:",
                "descripcion" => $objTramite['CASO_RECHAZO'] ?? "",
                "opciones" => [],
                "documentos" => []
            ]
        ];

        $tramite['en_linea'] = [
            [
                "titulo" => "Tiempo promedio de espera en fila",
                "descripcion" => $objTramite['TIEMPO_ESPERA'] ?? "",
                "opciones" => [],
                "documentos" => []
            ],
            [
                "titulo" => "??Hay informaci??n en l??nea?:",
                "descripcion" => $objTramite['SNSOLILINEA'] ?? "",
                "opciones" => [],
                "documentos" => []
            ],
            [
                "titulo" => "??Se pueden recibir solicitudes en l??nea?:",
                "descripcion" => $objTramite['SNTRAMLINEA'] ?? "",
                "opciones" => [],
                "documentos" => []
            ],
            [
                "titulo" => "Solicitud en l??nea ??Requiere formato?:",
                "descripcion" => $objTramite['SNFORMATO'] ?? "",
                "opciones" => [],
                "documentos" => []
            ]
        ];

        //Oficinas pago
        $lstOficinas_pago = [];
        $arrOficinas_pago = (explode("||", $objTramite['EDIFICIOSPAGO']));
        foreach ($arrOficinas_pago as $value) {
            $urlEdificio = $this->host . '/api/vw_accede_edificios_id/' . $value;
            $context = stream_context_create($options);
            $result = @file_get_contents($urlEdificio, false, $context);
            if (strpos($http_response_header[0], "200")) {
                $objEdificio = json_decode($result, true);
                $_objE = [
                    "id" => $objEdificio['ID_EDIFICIO'],
                    "nombre" => $objEdificio['EDIFICIO'],
                    "direccion" => $objEdificio['DIRECCION'] . ", " .  $objEdificio['COLONIA'] . ", " . $objEdificio['MUNICIPIO'] . ", " . $objEdificio['ESTADO'],
                    "horario" => "",
                    "latitud" => $objEdificio['LATITUD'] ?? 0,
                    "longitud" => $objEdificio['LONGITUD'] ?? 0,
                    "responsable" => $objTramite['ENCARGADO_TRAMITE'] ?? "",
                    "contacto_telefono" => $objTramite['CONTACTO_ENCARGADO'] ?? "",
                    "contacto_email" => "",
                    "informacion_adicional" => $objTramite['INFOADIC'] ?? ""
                ];
                array_push($lstOficinas_pago, $_objE);
            }
        }

        $tramite['costo'] = [
            [
                "titulo" => "??Tiene costo?:",
                "descripcion" => $objTramite['TIENE_COSTO'] ?? "",
                "opciones" => [],
                "documentos" => []
            ],
            [
                "titulo" => "Costos",
                "descripcion" => "",
                "opciones" => [$objTramite['COSTOS'] ?? ""],
                "documentos" => []
            ],
            [
                "titulo" => "Oficinas donde se puede realizar el pago:",
                "descripcion" => "",
                "opciones" => [],
                "documentos" => $lstOficinas_pago
            ]
        ];

        //Fundamentos legales
        $lstFundamentos = [];
        if ($objTramite != null) {
            $urlFudamentos = $this->host . '/api/vw_accede_tramite_legal/' . $objTramite['ID_TRAM'];
            $context = stream_context_create($options);
            $result = @file_get_contents($urlFudamentos, false, $context);
            if (strpos($http_response_header[0], "200")) {
                $objFundamento = json_decode($result, true);
                foreach ($objFundamento as $fun) {
                    $_objF = [
                        "titulo" => $fun['ORDELEY'] ?? "",
                        "descripcion" => "",
                        "opciones" => []
                    ];
                    array_push($lstFundamentos, $_objF);
                }
            }
        }

        $tramite['fundamento_legal'] = [
            [
                "titulo" => "",
                "descripcion" => "",
                "opciones" => [],
                "adicional" => $lstFundamentos
            ],
        ];

        $name =  str_replace(" ", "_", $tramite['nombre']);
        //Creacion de pdf
        $pdf = app('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->setPaper("letter", "portrait");
        $pdf->loadView('TEMPLATE.DETALLE_TRAMITE', compact('tramite'));
        return $pdf->download($name . '.pdf');
    }

    public function consultar_pago($IntReferencia)
    {

        $options = array(
            'http' => array(
                'method'  => 'GET',
            )
        );
        $url = $this->host_pagos . '/' . $IntReferencia;
        $context = stream_context_create($options);
        $result = @file_get_contents($url, false, $context);
        $response = [];

        if (strpos($http_response_header[0], "200")) {
            $response = json_decode($result, true);
        }
        $options = array(
            'http' => array(
                // 'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'GET',
                // 'content' => http_build_query($dataForPost),
            )
        );

        $context  = stream_context_create($options);
        $listTramites = file_get_contents($url, false, $context);
        $response = json_decode($listTramites, true);

        //$response = Http::get($url);

        // $client = new \GuzzleHttp\Client();
        // $response = $client->request('GET', $url, [
        //     'headers' => [
        //         'Origin' => 'https://vucapacita.chihuahua.gob.mx',
        //     ]
        // ]);

        // echo $response->getStatusCode(); // 200
        // echo $response->getHeaderLine('content-type'); // 'application/json; charset=utf8'
        // echo $response->getBody(); // '{"id": 1420053, "name": "guzzle", ...}'

        // // Send an asynchronous request.
        // $request = new \GuzzleHttp\Psr7\Request('GET', 'http://httpbin.org');
        // $promise = $client->sendAsync($request)->then(function ($response) {
        //     echo 'I completed! ' . $response->getBody();
        // });

        // $promise->wait();

        return response()->json($response);
    }

    public function validarPagoQueretaro(Request $request){


        /* echo $request->input('PERIODO');
        echo $request->input('NUMERO_TRANSACCION');
        echo $request->input('TRAMITE_ID');
        exit; */

        $client = new Client();
        $headers = [
        'usuario' => env('USUARIO_VALIDAR_PAGOS_QUERETARO'),
        'password' => env('PASSWORD_VALIDAR_PAGOS_QUERETARO')
        ];
        $requestQueretaro = new \GuzzleHttp\Psr7\Request('GET', env('HOST_VALIDAR_PAGOS_QUERETARO').'?noPeriodo='.$request->input('PERIODO').'&noTransaccion='.$request->input('NUMERO_TRANSACCION'), $headers);
        $res = $client->sendAsync($requestQueretaro)->wait();

        $response = json_decode($res->getBody(), true);
        //dd($response); 
       /*  $response["estatusPago"] = 1;
        $response["mensajePago"] = "Pagado"; */
       /*  $response["estatusPago"] = 0;
        $response["mensajePago"] = "Falta Pago"; */

        


        if(isset($response["estatusPago"])){
            if($response["estatusPago"] == 1){
                Cls_Seccion_Seguimiento::where(['SSEGTRA_NIDSECCION_SEGUIMIENTO' => $request->input('TRAMITE_ID')])->update(['SSEGTRA_PAGADO' => 1]);
            }
            $responseJson["estatusPago"] = $response["estatusPago"];
            $responseJson["mensajePago"] = $response["mensajePago"];
        }else{
            $responseJson["estatusPago"] = 0;
            if(isset($response["respuestaSimple"]["mensaje"])){
                $responseJson["mensajePago"] = $response["respuestaSimple"]["mensaje"];
            }else{
                $responseJson["mensajePago"] = "Ocurrio un error al consultar este pago en RecaudaNet";
            }
        }
        

        return response()->json($responseJson);

    }

    
    public function generarOrdenPagoQueretaro(Request $request){


        /* echo $request->input('PERIODO');
        echo $request->input('NUMERO_TRANSACCION');
        echo $request->input('TRAMITE_ID');
        exit; */

        $objUsuario     = Auth::user();
        $tramites       = new Cls_Tramite_Servicio();
        $detalle        = $tramites->TRAM_CONSULTAR_DETALLE_TRAMITE_SEGUIMIENTO($request->input('USUARIO_TRAMITE_ID'));

        $claveTramitePago =  $tramites->TRAM_CONSULTAR_CONFIGURACION_TRAMITE_CONCEPTO($detalle->TRAM_NIDTRAMITE_ACCEDE);
        $clavePago = is_null($claveTramitePago ) ? "0" : intval($claveTramitePago->Referencia);

        //dd($objUsuario);

        $client = new Client();
        $headers = [
        'Content-Type' => 'application/json'
        ];

        //"idTramite":'.$clavePago.',
        $body = '{
        "folioSeguimiento": "PlaTra",
        "idTramite":'.$clavePago.',
        "importe": 5540.0,
        "nombre": "'.$objUsuario->USUA_CNOMBRES.'",
        "apaterno": "'.$objUsuario->USUA_CPRIMER_APELLIDO.'",
        "amaterno": "'.$objUsuario->USUA_CSEGUNDO_APELLIDO.'",
        "rfc": "'.$objUsuario->USUA_CRFC.'", 
        "curp": "'.$objUsuario->USUA_CCURP.'", 
        "estado": "'.$objUsuario->USUA_CESTADO_PARTICULAR.'",
        "municipio": "'.$objUsuario->USUA_CMUNICIPIO_PARTICULAR.'",
        "poblacion": "'.$objUsuario->USUA_CMUNICIPIO_PARTICULAR.'",
        "colonia": "'.$objUsuario->USUA_CCOLONIA_PARTICULAR.'",
        "calle": "'.$objUsuario->USUA_CCALLE_PARTICULAR.'",
        "numero": "'.$objUsuario->USUA_NNUMERO_EXTERIOR_PARTICULAR.'",
        "cp": "'.$objUsuario->USUA_NCP_PARTICULAR.'",
        "telefono": "'.$objUsuario->USUA_NTELEFONO.'", 
        "correo": "'.$objUsuario->USUA_CCORREO_ELECTRONICO.'",
        "usuario": "'.env('USUARIO_GENERAR_ORDEN_PAGO_QUERETARO').'",
        "contrasena": "'.env('PASSWORD_GENERAR_ORDEN_PAGO_QUERETARO').'"
        }';
        //dd($body);
        $requestQueretaro = new \GuzzleHttp\Psr7\Request('POST', env('HOST_GENERAR_ORDEN_PAGO_QUERETARO'), $headers, $body);
        $res = $client->sendAsync($requestQueretaro)->wait();

      
        $response = json_decode($res->getBody(), true);
        //echo $res->getBody();
        /* $response["estatusPago"] = 1;
        $response["mensajePago"] = "Pagado"; */
        //$response["urlFormatoPago"] = "";

        $responseJson = array();

         if(!empty($response["urlFormatoPago"])){

            Cls_Pago_Tramite::where('USTR_NIDUSUARIOTRAMITE',$request->input('USUARIO_TRAMITE_ID'))->update(['Activo'=>0]);

            $referenciaPago = new Cls_Pago_Tramite();
            $referenciaPago->USTR_NIDUSUARIOTRAMITE = $request->input('USUARIO_TRAMITE_ID');
            $referenciaPago->FolioSeguimiento = $response["folioSeguimiento"];
            $referenciaPago->FolioControlEstado = $response["folioControlEstado"];
            $referenciaPago->LineaCaptura = $response["lineaCaptura"];
           // $referenciaPago->FechaVencimiento = date(strtotime($response["fechaVencimiento"]),'Y-m-d'); 
            $referenciaPago->StrFechaVencimiento =$response["fechaVencimiento"];
            $referenciaPago->Importe = $response["importe"];
            $referenciaPago->UrlFormatoPago = $response["urlFormatoPago"];
            $referenciaPago->Codigo = $response["codigo"];
            $referenciaPago->Mensaje = $response["mensaje"];
            $referenciaPago->NoTransaccion = $response["noTransaccion"];
            $referenciaPago->Activo = 1;
            $referenciaPago->save();

            $folioSlit = explode("/",$response["folioControlEstado"]);

            $responseJson["estatusPago"] = 1;
            $responseJson["mensajePago"] = $response["mensaje"];
            $responseJson["urlFormatoPago"] = $response["urlFormatoPago"];
            $responseJson["folioControlEstado"] = $response["folioControlEstado"];
            $responseJson["lineaCaptura"] = $response["lineaCaptura"];
            $responseJson["fechaVencimiento"] = $response["fechaVencimiento"];
            $responseJson["periodo"] = $folioSlit[0];
            $responseJson["folio"] = $folioSlit[1];

        }else{
            $responseJson["estatusPago"] = 0;
            $responseJson["mensajePago"] = "No se pudo generar la orden intente de nuevo mas tarde";
        }


        

        return response()->json($responseJson);

    }


}
