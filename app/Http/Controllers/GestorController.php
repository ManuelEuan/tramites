<?php

namespace App\Http\Controllers;

use stdClass;
use Exception;
use App\Cls_Gestor;
use App\Cls_Resolutivo;
use Illuminate\Http\Request;
use App\Models\Cls_Formulario;
use App\Services\CitasService;
use App\Cls_Seccion_Seguimiento;
use App\Cls_Tramite_Concepto;
use App\Services\TramiteService;
use Illuminate\Support\Collection;
use App\Models\Cls_TramiteEdificio;
use Illuminate\Support\Facades\DB;
use App\Models\Cls_TramiteDocumento;
use Illuminate\Support\Facades\Auth;
use  Illuminate\Pagination\Paginator;
use App\Models\Cls_TramiteFormulario;
use App\Http\Controllers\FormularioController;
use  Illuminate\Pagination\LengthAwarePaginator;

class GestorController extends Controller
{
    /**
     * @var TramiteService
     */
    private $tramiteService;

    /**
     * @var CitasService
     */
    private $citasService;

    /**
     * Construct Gestor
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->tramiteService   = new TramiteService();
        $this->citasService     = new CitasService();
    }

    /**
     * Retorna la vista inicial del modulo de gestores
     * @return View
     */
    public function index()
    {
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
    public function consultar(Request $request){
        $tramite        =  $this->tramiteService->busqueda($request);
        $data_tramite   = $tramite['data'];

        return response()->json(view('MST_GESTOR.index_partial', compact('data_tramite'))->render());
    }

    /**
     * Retorna el array de los diferentes filtros a utilizar
     * @param Request $request
     * @return Response
     */
    public function obtener_filtro(Request $request)
    {
        $filtros = $this->tramiteService->filtros($request);
        $response = [
            "clasificacion" =>  [],
            "audiencia"     =>  [],
            "dependencias"  =>  $filtros['dependencias'],
            "tramites"      =>  []
        ];

        return Response()->json($response);
    }

    /**
     * Retorna el detalle del tramite
     * @param int $tramiteID
     * @return Response
     */
    public function detalleTramite($tramiteID)
    {
        $objTramite     = $this->tramiteService->getTramite($tramiteID);
        $arrayDetalle   = $this->tramiteService->getDetalle($objTramite->Id);

        return response()->json(["data" => $arrayDetalle]);
    }

    /**
     * Retorna la vista de la descripcion del tramite
     * @param int $tramiteID
     * @param int $tramiteIDConfig
     * @return View
     */
    public function consultar_tramite($tramiteID, $tramiteIDConfig)
    {
        $objTramite             = $this->tramiteService->getTramite($tramiteID);
        $arrayDetalle           = $this->tramiteService->getDetalle($objTramite->Id);

        ################ Comienzo a llenar los datos para el tramite ################
        $tramite                = [];
        $tramite['id']          = $tramiteID;
        $tramite['nombre']      = $objTramite->Name;
        $tramite['responsable'] = $objTramite->nameDependencia;
        $tramite['descripcion'] = $objTramite->CitizenDescription;
        $datosGenerales         = $this->tramiteService->valoresDefaulTramite($arrayDetalle, $objTramite);
        $tramite['oficinas']    = $datosGenerales['oficinas'];
        $tramite['en_linea']    = $datosGenerales['en_linea'];
        $tramite['costo']       = $datosGenerales['costo'];
        $tramite['requerimientos']      = $datosGenerales['requerimientos'];
        $tramite['informacion_general'] = $datosGenerales['informacion_general'];
        $tramite['fundamento_legal']    = $datosGenerales['fundamento_legal'];

        return view('MST_GESTOR.DET_TRAMITE', compact('tramite'));
    }

    public function actualizar_pago($id)
    {
        Cls_Seccion_Seguimiento::where(['SSEGTRA_NIDSECCION_SEGUIMIENTO' => $id])->update(['SSEGTRA_PAGADO' => 1]);
        return response()->json(['data' => "ok"]);
    }


    //Vista donde se realiza configuración del trámite
    /**
     * Valida si el tramite de retys se encuentra bien configurado
     * @param Request $request
     * @return Response
     */
    public function validaTramite (Request $request){
        $objTramite     = $this->tramiteService->getTramite($request->tramiteId);
        $objTramite     = $this->tramiteService->getTramite(1);
        if(is_null($objTramite)){
            return response()->json(["error" => "La configución de RETYS no esta completya, favor de validar el tramite."], 403);
        }
        else
            return response()->json(["message" => "Correcto"], 200);
    }

    public function configurar_tramite($tramiteID, $tramiteIDConfig) {
        $tramite        = [];
        $objTramite     = $this->tramiteService->getTramite($tramiteID);
        $arrayDetalle   = $this->tramiteService->getDetalle($objTramite->Id);
        $datosGenerales = $this->tramiteService->valoresDefaulTramite($arrayDetalle, $objTramite);
        $edificios      = $datosGenerales['oficinas'];

        #################### Configuraciones anteriores ####################
        $tramites   = new Cls_Gestor();;
        $registro   = $tramites->TRAM_SP_OBTENER_DETALLE_TRAMITE_CONFIGURACION($tramiteID, $tramiteIDConfig);

        if (!is_null($registro)) {
            $tramite['VALIDO'] = true;
            $tramite['TRAM_ID_TRAMITE']     = $registro->tram_nidtramite;
            $tramite['ACCE_ID_TRAMITE']     = $registro[0]->TRAM_NIDTRAMITE_ACCEDE;
            $tramite['ACCE_CLAVE_INTERNA']  = 'Clave Accede: ' . $registro[0]->TRAM_NIDTRAMITE_ACCEDE;
            $tramite['ACCE_NOMBRE_TRAMITE'] = $registro->tram_cnombre;
            $tramite['EDIFICIOS']           = $registro->tram_cnombre;
            $tramite['TRAM_NIMPLEMENTADO']  = $registro->tram_nimplementado != null ? intval($registro->tram_nimplementado) : intval($registro->tram_nimplementado);
            $tramite['TRAM_NENLACEOFICIAL'] = $registro->tram_nenlaceoficial != null ? intval($registro->tram_nenlaceoficial) : intval($registro->tram_nenlaceoficial);
        } else {
            if (is_numeric($tramiteIDConfig) && intval($tramiteIDConfig) > 0) {
                $tramite['VALIDO'] = false;
                $tramite['TRAM_ID_TRAMITE'] = NULL;
                $tramite['ACCE_ID_TRAMITE'] = NULL;
                $tramite['ACCE_CLAVE_INTERNA'] = "";
                $tramite['ACCE_NOMBRE_TRAMITE'] = "NO SE ENCONTRÓ EL TRÁMITE EN ACCEDE.";
                $tramite['TRAM_NIMPLEMENTADO'] = null;
                $tramite['TRAM_NENLACEOFICIAL'] = null;
            } else {
                $tramite['VALIDO'] = true;
                $tramite['TRAM_ID_TRAMITE']     = 0;
                $tramite['ACCE_ID_TRAMITE']     =  $objTramite->remtisId;
                $tramite['ACCE_CLAVE_INTERNA']  = 'Clave interna: ' . $objTramite->Id;
                $tramite['ACCE_NOMBRE_TRAMITE'] = $objTramite->Name;
                $tramite['TRAM_NIMPLEMENTADO']  = null;
                $tramite['TRAM_NENLACEOFICIAL'] = null;
            }
        }

        return view('DET_GESTOR_CONFIGURACION_TRAMITE.index',  compact('tramite', 'edificios'));
    }

    //Vista detalle de configuración de trámite
    public function detalle_configuracion_tramite($tramiteID, $tramiteIDConfig) {
        $tramites = new Cls_Gestor();
        $tramites->TRAM_NIDTRAMITE = $tramiteID;
        $tramites->TRAM_NIDTRAMITE_CONFIG = $tramiteIDConfig;
        $registro = $tramites->TRAM_SP_OBTENER_DETALLE_TRAMITE_CONFIGURACION($tramiteID, $tramiteIDConfig);
        $tramite = [];
        $objTramite     = $this->tramiteService->getTramite($tramiteID);
        $arrayDetalle   = $this->tramiteService->getDetalle($objTramite->Id);
        $datosGenerales = $this->tramiteService->valoresDefaulTramite($arrayDetalle, $objTramite);
        $edificios      = $datosGenerales['oficinas'];

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
    public function consultar_formulario() {
        $formularios = Cls_Formulario::where('FORM_BACTIVO', true)->get();
        return response()->json([ 'data' => $formularios]);
    }

    //Obtener documentos necesarios del trámite
    public function consultar_documento_tramite($IntTramite)
    {
        $objTramite = $this->tramiteService->getTramite($IntTramite);
        $rsp = $this->tramiteService->getDetalle($objTramite->Id);
        $lstDocumentos = [];

        foreach ($rsp['documentos'] as $key => $doc) {
            $_objD = [
                "ACCE_NIDTRAMITEDOCUMENTO"  => 1,
                "ACCE_NIDTRAMITE"           => $objTramite->Id ?? "",
                "ACCE_NIDDOCUMENTO"         => $doc->Id ?? "",
                "ACCE_CNOMBRE"              => $doc->Name ?? "",
                "ACCE_CDESCRIPCION"         => $doc->Description ?? "",
                "ACCE_CEXTENSION"           =>  'PDF',
                "ACCE_NOBLIGATORIO"         => 0,
                "ACCE_NMULTIPLE"            => 0,
            ];
            array_push($lstDocumentos, (object)$_objD);
        }

        $response['data'] = $lstDocumentos;
        return response()->json($response);
    }

    //Obtener la configuración de un trámite existente
    public function consultar_configuracion_tramite($TRAM_NIDTRAMITE_CONFIG)
    {
        $gestor = new Cls_Gestor();
        $result = $gestor->TRAM_CONSULTAR_CONFIGURACION_TRAMITE($TRAM_NIDTRAMITE_CONFIG);
        $result['citas'] = $this->citasService->getCitas($TRAM_NIDTRAMITE_CONFIG);
        return response()->json($result);
    }

    //Guardar configuración de trámite
    public function save(Request $request)
    {
        try {
            DB::beginTransaction();
            $tramite    = $this->tramiteService->storeTramite((object)$request->all());

            if ($tramite->TRAM_CTIPO == "Creación" || $tramite->TRAM_CTIPO == "Actualización") {
                $resultSecciones = $this->TRAM_SP_AGREGAR_SECCIONES($request->TRAM_LIST_SECCION, $tramite->TRAM_NIDTRAMITE);

                if ($resultSecciones['codigo'] == 200) {
                    $rutaNew    = route('gestor_configurar_tramite', ['tramiteID' =>  $tramite->TRAM_NIDTRAMITE_ACCEDE, 'tramiteIDConfig' => $tramite->TRAM_NIDTRAMITE]);
                    $result     = null;

                    //Implementar en caso de implementar
                    if ($request->TRAM_NIMPLEMENTADO == 1) {
                        $gestor_im  = new Cls_Gestor();
                        $result     = $gestor_im->TRAM_SP_CAMBIAR_ESTATUS_TRAMITE($tramite->TRAM_NIDTRAMITE, 1);
                    }

                    DB::commit();
                    return response()->json([
                        "estatus"   => "success",
                        "codigo"    => 200,
                        "mensaje"   => "Trámite y secciones agregadas correctamente",
                        "ruta"      => $rutaNew,
                        "result"    => $result,
                    ]);
                }
            } else {

                return response()->json([
                    "estatus"   => "error",
                    "codigo"    => 400,
                    "DataError" => $tramite[0]->TRAM_CTIPO
                ]);
            }
        } catch (Exception $ex) {
            DB::rollBack();
            $response = [
                "estatus"   => "error",
                "codigo"    => 400,
                "mensaje"   => "Ocurrió una excepción, favor de contactar al administrador del sistema " . $e->getMessage(),
            ];
            return response()->json($response);
        }
    }

    private function TRAM_SP_AGREGAR_SECCIONES(array $listSecciones, $TramiteID) {
        $response = [ "estatus" => "success", "codigo" => 200, "mensaje" => "Secciones agregadas correctamente"];

        try {
            if (count($listSecciones) > 0) {
                $seccionesEliminadas = new Cls_Gestor();
                $seccionesEliminadas->TRAM_SP_ELIMINAR_SECCION($TramiteID);

                foreach ($listSecciones as $seccion) {
                    try{
                        $object = new stdClass();
                        $object->CONF_NIDTRAMITE        = $TramiteID;
                        $object->CONF_NSECCION          = $seccion['CONF_NSECCION'];
                        $object->CONF_CNOMBRESECCION    = $seccion['CONF_CNOMBRESECCION'];
                        $object->CONF_ESTATUSSECCION    = 0;
                        $object->CONF_NDIASHABILES      = is_null($seccion['CONF_NDIASHABILES']) ? 0 :  $seccion['CONF_NDIASHABILES'];
                        $object->CONF_CDESCRIPCIONCITA  = is_null($seccion['CONF_CDESCRIPCIONCITA']) ? "" : $seccion['CONF_CDESCRIPCIONCITA'];
                        $object->CONF_NORDEN            = $seccion['CONF_NORDEN'];
                        $object->CONF_CDESCRIPCIONVENTANILLA = is_null($seccion['CONF_CDESCRIPCIONVENTANILLA']) ? "" : $seccion['CONF_CDESCRIPCIONVENTANILLA'];
                        $objSeccion = $this->tramiteService->agregarSeccion($object);

                        //Agregar formulario y documentos: Se elimina documentos, edificios y conceptos antiguos en TRAM_AGREGAR_DOCUMENTO()
                        if ($seccion['CONF_NSECCION'] === "Formulario") {
                            $this->TRAM_AGREGAR_FORMULARIO($seccion['CONF_LIST_FORMULARIO'], $TramiteID);
                            if (isset($seccion['CONF_LIST_DOCUMENTO']))
                                $this->TRAM_AGREGAR_DOCUMENTO($seccion['CONF_LIST_DOCUMENTO'], $TramiteID);
                        }
                        if ($seccion['CONF_NSECCION'] === "Ventanilla sin cita") {
                            $TRAM_LIST_EDIFICIO = $seccion['CONF_LIST_EDIFICIO'];
                            $this->TRAM_AGREGAR_EDIFICIOS($TRAM_LIST_EDIFICIO, $TramiteID, $objSeccion->CONF_NIDTRAMITE);
                        }

                        if ($seccion['CONF_NSECCION'] === "Citas en línea") {
                            $citas = isset($seccion['CONF_ARRAY_DETALLE_CITA']) ? $seccion['CONF_ARRAY_DETALLE_CITA'] : [];
                            $this->citasService->create($TramiteID, $citas);
                        }

                        if ($seccion['CONF_NSECCION'] === "Pago en línea") {
                            $TRAM_LIST_CONCEPTO = $seccion['CONF_LIST_PAGO'];
                            $this->TRAM_AGREGAR_CONCEPTO_PAGO_TRAMITE($TRAM_LIST_CONCEPTO, $TramiteID, $objSeccion->CONF_NIDTRAMITE);
                        }

                        if ($seccion['CONF_NSECCION'] === "Resolutivo electrónico") {
                            $TRAM_LIST_RESOLUTIVO = $seccion['CONF_DATA_RESOLUTIVO'];
                            $this->TRAM_AGREGAR_RESOLUTIVO($TRAM_LIST_RESOLUTIVO, $TramiteID, $objSeccion->CONF_NIDTRAMITE);
                        }
                    }catch(Exception $ex){
                        dd($ex,$seccion);
                    }
                }
            } else {
                $response = [
                    "estatus"   => "error",
                    "codigo"    => 400,
                    "mensaje"   => "No se agregaron secciones a configurar",
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

    private function TRAM_AGREGAR_FORMULARIO($TRAM_LIST_FORMULARIO, $TRAM_NIDTRAMITE) {
        try {
            DB::table('tram_mst_formulario_tramite')->where('FORM_NIDTRAMITE',$TRAM_NIDTRAMITE)->delete();
            for ($i = 0; $i < count($TRAM_LIST_FORMULARIO); $i++) {
                $valor =  DB::table('tram_form_formulario')->where('FORM_NID', $TRAM_LIST_FORMULARIO[$i]['TRAM_NIDFORMULARIO'])->first();
                $item = new Cls_TramiteFormulario();
                $item->FORM_NIDFORMULARIO   = $valor->FORM_NID;
                $item->FORM_NIDTRAMITE      = $TRAM_LIST_FORMULARIO[$i]['TRAM_NIDTRAMITE'];
                $item->FORM_CNOMBRE         = $valor->FORM_CNOMBRE;
                $item->FORM_CDESCRIPCION    = is_null($valor->FORM_CDESCRIPCION) ? $valor->FORM_CNOMBRE : $valor->FORM_CDESCRIPCION;
                $item->FORM_NESACTIVO       = $valor->FORM_BACTIVO;
                $item->save();
            }
        } catch (Exception $ex) {
            dd($ex);
        }
    }

    private function TRAM_AGREGAR_DOCUMENTO($TRAM_LIST_DOCUMENTO, $TRAM_NIDTRAMITE)
    {
        $arrayId = array();

        try {
            //Eliminar edificos, resolutivos y conceptos del trámite
            $gestor = new Cls_Gestor();
            Cls_TramiteEdificio::where('EDIF_NIDTRAMITE', $TRAM_NIDTRAMITE)->delete();
            DB::table('tram_mst_resolutivo')->where('RESO_NIDTRAMITE', $TRAM_NIDTRAMITE)->delete();
            DB::table('tram_mst_concepto_tramite')->where('CONC_NIDTRAMITE', $TRAM_NIDTRAMITE)->delete();

            foreach ($TRAM_LIST_DOCUMENTO as $documentos) {
                array_push($arrayId, $documentos['TRAD_NIDDOCUMENTO']);
                $item = Cls_TramiteDocumento::where(['TRAD_NIDTRAMITE' => $TRAM_NIDTRAMITE, 'TRAD_NIDDOCUMENTO' => $documentos['TRAD_NIDDOCUMENTO']])->first();
                
                if(is_null($item)){
                    $item = new Cls_TramiteDocumento();
                    $item->TRAD_NIDTRAMITE      = $TRAM_NIDTRAMITE;
                    $item->TRAD_NIDDOCUMENTO    = $documentos['TRAD_NIDDOCUMENTO'];
                    $item->TRAD_CNOMBRE         = $documentos['TRAD_CNOMBRE'];
                    $item->TRAD_CDESCRIPCION    = $documentos['TRAD_CDESCRIPCION'];
                    $item->TRAD_CEXTENSION      = $documentos['TRAD_CEXTENSION'];
                    $item->TRAD_NOBLIGATORIO    = $documentos['TRAD_NOBLIGATORIO'];
                    $item->TRAD_NMULTIPLE       = $documentos['TRAD_NMULTIPLE'];
                    $item->save();
                }
                else{
                    Cls_TramiteDocumento::where(['TRAD_NIDTRAMITE' => $TRAM_NIDTRAMITE, 'TRAD_NIDDOCUMENTO' => $documentos['TRAD_NIDDOCUMENTO']])
                        ->update([
                            'TRAD_NOBLIGATORIO' => $documentos['TRAD_NOBLIGATORIO'],
                            'TRAD_NMULTIPLE'    => $documentos['TRAD_NMULTIPLE']
                        ]);
                }
            }

            //Elimino los que ya no van a estar
            Cls_TramiteDocumento::where('TRAD_NIDTRAMITE', $TRAM_NIDTRAMITE)->whereNotIn('TRAD_NIDDOCUMENTO', $arrayId)->delete();
        } catch (EXception $ex) {
            throw $ex;
        }
    }

    private function TRAM_AGREGAR_EDIFICIOS($TRAM_LIST_EDIFICIO, $TRAM_NIDTRAMITE, $TRAM_NIDSECCION) {
        try {
            for ($i = 0; $i < count($TRAM_LIST_EDIFICIO); $i++) {
                $item = new Cls_TramiteEdificio();
                $item->EDIF_NIDTRAMITE  = $TRAM_NIDTRAMITE;
                $item->EDIF_CNOMBRE     = $TRAM_LIST_EDIFICIO[$i]['EDIF_CNOMBRE'];
                $item->EDIF_CCALLE      = $TRAM_LIST_EDIFICIO[$i]['EDIF_CCALLE'];
                $item->EDIF_CLATITUD    = $TRAM_LIST_EDIFICIO[$i]['EDIF_CLATITUD'];
                $item->EDIF_CLONGITUD   = $TRAM_LIST_EDIFICIO[$i]['EDIF_CLONGITUD'];
                $item->EDIF_NIDSECCION  = $TRAM_NIDSECCION;
                $item->EDIF_NIDEDIFICIO = intval($TRAM_LIST_EDIFICIO[$i]['EDIF_NIDEDIFICIO']);
                $item->save();
            }
        } catch (Exception $ex) {
            dd($ex);
        }
    }

    private function TRAM_AGREGAR_RESOLUTIVO($TRAM_LIST_RESOLUTIVO, $TRAM_NIDTRAMITE, $TRAM_NIDSECCION)
    {
        $gestor     = new Cls_Gestor();
        $fileName   = '';

        if (!empty($TRAM_LIST_RESOLUTIVO['RESO_FILEBASE64'])) {

            $fileName = md5(time() . $TRAM_LIST_RESOLUTIVO['RESO_NOMBREFILE']) . '.' . 'docx';

            //Storage::disk('public')->put($fileName, base64_decode($TRAM_LIST_RESOLUTIVO['RESO_FILEBASE64']));

            //$ifp = fopen(siegy_path('docts/resolutivos/') . $fileName, 'wb');
            $ifp = fopen(public_path() . '/docts/resolutivos/' . $fileName, 'wb');


            fwrite($ifp, base64_decode($TRAM_LIST_RESOLUTIVO['RESO_FILEBASE64']));

            // clean up the file resource
            fclose($ifp);
        } else {
            if (!empty($TRAM_LIST_RESOLUTIVO['RESO_NOMBREFILE'])) {

                $fileName = $TRAM_LIST_RESOLUTIVO['RESO_NOMBREFILE'];
            }
        }


        $TRAM_LIST_RESOLUTIVO['RESO_NIDTRAMITE'] = $TRAM_NIDTRAMITE;
        $TRAM_LIST_RESOLUTIVO['RESO_NIDRESOLUTIVO'] = 1;
        $nombreResolutivo       = isset($TRAM_LIST_RESOLUTIVO['RESO_CNOMBRE']) ? $TRAM_LIST_RESOLUTIVO['RESO_CNOMBRE'] : "";
        $documentoResolutivo    = $gestor->TRAM_SP_AGREGAR_RESOLUTIVO($TRAM_LIST_RESOLUTIVO['RESO_NIDTRAMITE'], $TRAM_LIST_RESOLUTIVO['RESO_NIDRESOLUTIVO'], $nombreResolutivo , $TRAM_NIDSECCION, $fileName);

        if (!empty($TRAM_LIST_RESOLUTIVO["MAPEO"])) {
            foreach ($TRAM_LIST_RESOLUTIVO["MAPEO"] as $MAPEO) {
                $gestor->TRAM_SP_AGREGAR_RESOLUTIVO_MAPEO($documentoResolutivo->RESO_NID, $MAPEO['idFormulario'], $MAPEO['idPregunta'], $MAPEO['campo']);
            }
        }
    }

    private function TRAM_AGREGAR_CONCEPTO_PAGO_TRAMITE($TRAM_LIST_CONCEPTO, $TRAM_NIDTRAMITE, $TRAM_NIDSECCION)
    {
        try{
            for ($i = 0; $i < count($TRAM_LIST_CONCEPTO); $i++) {
                $item = new Cls_Tramite_Concepto();
                $item->CONC_NIDCONCEPTO     = $TRAM_LIST_CONCEPTO[$i]['CONC_NIDCONCEPTO'];
                $item->CONC_NIDTRAMITE      = $TRAM_NIDTRAMITE;
                $item->CONC_NIDTRAMITE_ACCEDE = $TRAM_LIST_CONCEPTO[$i]['CONC_NIDTRAMITE_ACCEDE'];
                $item->CONC_NREFERENCIA     = $TRAM_LIST_CONCEPTO[$i]['CONC_NREFERENCIA'];
                $item->CONC_CTRAMITE        = $TRAM_LIST_CONCEPTO[$i]['CONC_CTRAMITE'];
                $item->CONC_CENTE_PUBLICO   = $TRAM_LIST_CONCEPTO[$i]['CONC_CENTE_PUBLICO'];
                $item->CONC_CENTE           = $TRAM_LIST_CONCEPTO[$i]['CONC_CENTE'];
                $item->CONC_NIDSECCION      = $TRAM_NIDSECCION;
                $item->save();
            }
        }
        catch (Exception $ex) {
            dd($ex);
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
    public function consultar_resolutivo()
    {
        return response()->json(Cls_Resolutivo::get());
    }

    //Obtener resolutivos
    public function consultar_preguntas_formulario() {
        $formulariosPreguntas = DB::table('tram_form_formulario as f')
                                    ->join('tram_form_pregunta as fp','f.FORM_NID', '=', 'fp.FORM_NFORMULARIOID')
                                    ->where([ 'f.FORM_BACTIVO' => true, 'fp.FORM_BRESOLUTIVO'  => true])
                                    ->select('f.FORM_NID AS FORMID', 'f.FORM_CNOMBRE','f.FORM_CDESCRIPCION', 'fp.FORM_NSECCIONID',
                                                'fp.FORM_NID AS PREID', 'fp.FORM_CPREGUNTA','fp.FORM_BRESOLUTIVO')
                                    ->get();

        $formularios = array();
        foreach ($formulariosPreguntas as $formularioPreguntas) {
            $inArray    = false;
            $data       = array();
            foreach ($formularios as $formulario) {
                if ($formularioPreguntas->FORMID == $formulario["FORMID"]) {
                    $inArray = true;
                }
            }

            if ($inArray == false) {
                $data = array("FORMID" => $formularioPreguntas->FORMID, "FORM_CNOMBRE" => $formularioPreguntas->FORM_CNOMBRE, "FORM_CDESCRIPCION" => $formularioPreguntas->FORM_CDESCRIPCION);

                $formularios[] = $data;
            }
        }

        foreach ($formularios as $key => $formulario) {
            $preguntas = array();
            foreach ($formulariosPreguntas as $fkey => $formularioPreguntas) {
                if ($formulario["FORMID"] == $formularioPreguntas->FORMID) {
                    $preguntas[] = array(
                        "PREID" => $formularioPreguntas->PREID,
                        "FORM_NSECCIONID" => $formularioPreguntas->FORM_NSECCIONID,
                        "FORM_CPREGUNTA" => $formularioPreguntas->FORM_CPREGUNTA
                    );
                }
            }

            $formularios[$key]["preguntas"] = $preguntas;
        }

        return response()->json($formularios);
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

    public function formulario()
    {
        $formulario = new FormularioController();
        $formulario->open_modal = 1;
        return $formulario->list();
    }
}
