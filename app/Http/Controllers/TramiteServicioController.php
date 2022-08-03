<?php

namespace App\Http\Controllers;

use App\Cls_Bitacora;
use App\Cls_Usuario_Tramite;
use Illuminate\Http\Request;
use App\Cls_Tramite_Concepto;
use App\Cls_Tramite_Servicio;
use App\Cls_Usuario_Concepto;
use App\Cls_Usuario_Documento;
use App\Cls_Usuario_Respuesta;
use App\Models\Cls_Cat_Seccion;
use App\Cls_Seccion_Seguimiento;
use App\Services\TramiteService;
use App\Cls_Encuesta_Satisfaccion;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Pagination\Paginator;
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
    protected $host = "https://remtysmerida.azurewebsites.net";
    protected $host_pagos = "https://ipagostest.chihuahua.gob.mx/WSPagosDiversos/consultas/consultas1/obtieneEstatus";
    protected $tramiteService;

    /**
     * Construct Gestor
     */
    public function __construct() {
        $this->tramiteService = new TramiteService();
    }

    public function index()
    {
        $options = array(
            'http' => array(
                'method'  => 'GET',
            )
        );

        $context  = stream_context_create($options);

        $tramites = new Cls_Tramite_Servicio();
        $tramites->StrTexto = "";
        $tramites->IntDependencia = 0;
        $tramites->IntModalidad = 0;
        $tramites->IntClasificacion = 0;
        $tramites->IntNumPagina = 1;
        $tramites->IntCantidadRegistros = 10;
        $tramites->StrOrdenColumna = "";
        $tramites->StrOrdenDir = "";
        $tramites->IntUsuarioId = Auth::user()->USUA_NIDUSUARIO;

        $registros = $tramites->TRAM_SP_CONSULTAR_TRAMITE_PUBLICO();

        $IntPaginaActual = (int)$registros['pagination'][0]->PaginaActual;
        $IntTotalPaginas = (int)$registros['pagination'][0]->TotalPaginas;
        $IntTotalRegistros = (int)$registros['pagination'][0]->TotalRegistros;
        $data_tramite = new LengthAwarePaginator($registros['data'], $IntTotalRegistros, $tramites->IntCantidadRegistros, $IntPaginaActual, [
            'path' => Paginator::resolveCurrentPath()
        ]);

        //Dependencias
        $lstDependencias = [];
        $urlDependencias = $this->host . '/api/Tramite/Dependencias';
        $resultDependencias = file_get_contents($urlDependencias, false, $context);
        $listDependenciasTemporal = json_decode($resultDependencias, true);

        foreach ($listDependenciasTemporal as $dependencia) {
            $dependenciaTEM = [];
            $dependenciaTEM['ID_CENTRO'] = $dependencia['id'];
            $dependenciaTEM['DESCRIPCION '] =  $dependencia['name'];
            array_push($lstDependencias, $dependenciaTEM);
        }

        return view('MST_TRAMITE_SERVICIO.index', compact('data_tramite', 'lstDependencias'));
    }

    public function consultar(Request $request)
    {
        if ($request->ajax()) {

            $tramites = new Cls_Tramite_Servicio();
            $tramites->StrTexto = $request->StrTexto;
            $tramites->IntDependencia = $request->IntDependencia;
            $tramites->StrModalidad = $request->IntModalidad;
            $tramites->IntClasificacion = $request->IntClasificacion;
            $tramites->StrAudiencia = $request->StrAudiencia;
            $tramites->IntNumPagina = $request->IntNumPagina;
            $tramites->IntCantidadRegistros = $request->IntCantidadRegistros;
            $tramites->StrOrdenColumna = $request->StrOrdenColumna;
            $tramites->StrOrdenDir = $request->StrOrdenDir;
            $tramites->IntUsuarioId = Auth::user()->USUA_NIDUSUARIO;
            $registros = $tramites->TRAM_SP_CONSULTAR_TRAMITE_PUBLICO();

            $IntPaginaActual = (int)$registros['pagination'][0]->PaginaActual;
            $IntTotalPaginas = (int)$registros['pagination'][0]->TotalPaginas;
            $IntTotalRegistros = (int)$registros['pagination'][0]->TotalRegistros;

            $data_tramite = new LengthAwarePaginator($registros['data'], $IntTotalRegistros, $request->IntCantidadRegistros, $IntPaginaActual);
            return response()->json(view('MST_TRAMITE_SERVICIO.index_partial', compact('data_tramite'))->render());
        }

        $tramites = new Cls_Tramite_Servicio();
        $tramites->StrTexto = "";
        $tramites->IntDependencia = 0;
        $tramites->StrModalidad = "";
        $tramites->IntClasificacion = 0;
        $tramites->StrAudiencia = 0;
        $tramites->IntNumPagina = 1;
        $tramites->IntCantidadRegistros = 10;
        $tramites->StrOrdenColumna = "";
        $tramites->StrOrdenDir = "";
        $tramites->IntUsuarioId = Auth::user()->USUA_NIDUSUARIO;
        $registros = $tramites->TRAM_SP_CONSULTAR_TRAMITE_PUBLICO();

        $IntPaginaActual = (int)$registros['pagination'][0]->PaginaActual;
        $IntTotalPaginas = (int)$registros['pagination'][0]->TotalPaginas;
        $IntTotalRegistros = (int)$registros['pagination'][0]->TotalRegistros;

        $data_tramite = new LengthAwarePaginator($registros['data'], $IntTotalRegistros, $request->IntCantidadRegistros, $IntPaginaActual);
        // return view('MST_TRAMITE_SERVICIO.index', compact('data_tramite'));
        return response()->json($data_tramite);
    }

    public function getTramites(Request $request){
        /*$estatus = 2; //No seleccionado ningun estatus
        $url =   $this->host . '/api/Tramite/Filter';

        $dataForPost = array('search' => $request->search, 'dependencies' => $request->dependenci, 'unidadesadmin' => [], 'skipe' => 0, 'take' => 10, 'usuarioID' => Auth::user()->USUA_NIDUSUARIO, 'unidad' => 0, 'estatus' => $estatus);
        $options2 = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($dataForPost),
            )
        );

        $context2  = stream_context_create($options2);
        $result = file_get_contents($url, false, $context2);
        $arrayTramites = json_decode($result);*/

        $resultTram = Cls_Tramite_Servicio::TRAM_OBTENER_TRAMITES();
        $html = '';
        foreach ($resultTram as $i) {
            $html .= '<div class="card text-left" style="margin-bottom: 2rem;">
                <div class="card-header text-primary titleCard">
                    '.$i->TRAM_CNOMBRE. ' <span class="badge badge-warning">'.$i->TRAM_CNOMBRE.'</span>
                </div>
                <div class="card-body">
                    <h6 class="card-text" style="color: #212529;">
                        '.$i->TRAM_CDESCRIPCION.'
                    </h6>
                </div>
                <div class="card-footer text-muted" style="background-color: transparent; border-top: none; border-bottom: none;">
                    <span class="text-left" style="margin-right: 30px;">Creado: '.date("d/m/Y", strtotime($i->created_at)).'</span>
                    <span class="text-left">Ultima Modificación: '.date("d/m/Y", strtotime($i->created_at)).'</span>
                    <a href="'.route('detalle_tramite', ['id' => $i->TRAM_NIDTRAMITE]).'" class="btn btn-primary" style="float: right;">Ver trámite</a>
                </div>
            </div>';
        }
        return $html;
    }

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

    public function obtener_detalle_tramite($id) {
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
        $tramite['fundamento_legal']    = array([ "titulo" => "", "opciones" => [], "adicional" => [], "descripcion" => $objTramite->nameInstrumento ]);
   
        $tramite['estatus'] = 1;
        /* $tramite['estatus'] = $detalle->TRAM_NESTATUS_PROCESO == null ? 1 : $detalle->TRAM_NESTATUS_PROCESO;
        if ($detalle->TRAM_NESTATUS_PROCESO == null) {
            $tramite['disabled'] = "";
        } else {
            $tramite['disabled'] = $detalle->TRAM_NESTATUS_PROCESO == 1 ? "" : "disabled";
        }  */

        return view('MST_TRAMITE_SERVICIO.DET_TRAMITE', compact('tramite'));
    }

    public function iniciar_tramite_servicio($id)
    {
        $tramites = new Cls_Tramite_Servicio();
        $detalle = $tramites->TRAM_CONSULTAR_DETALLE_TRAMITE($id);
        $serie = strtoupper(substr($detalle->TRAM_CCENTRO, 0, 3));
        $anio = substr(date("Y"), -2);
        $folio = $serie . $anio;

        $cont_gestor = 0;
        $gestores_fisica = DB::table('tram_mdv_gestores as g')
            ->join('tram_mst_usuario as u', 'g.GES_NUSUARIOID', '=', 'u.USUA_NIDUSUARIO')
            ->select('u.USUA_CRFC', 'u.USUA_CCURP', 'u.USUA_NIDUSUARIO', 'u.USUA_CNOMBRES', 'u.USUA_CPRIMER_APELLIDO', 'u.USUA_CSEGUNDO_APELLIDO', 'u.USUA_CRAZON_SOCIAL', 'g.*')
            ->where('g.GES_NGESTORID', Auth::user()->USUA_NIDUSUARIO)
            ->where('u.USUA_NTIPO_PERSONA', 'FISICA')
            ->where('g.GES_CESTATUS', 'Autorizado')
            ->get();

        $gestores_moral = DB::table('tram_mdv_gestores as g')
            ->join('tram_mst_usuario as u', 'g.GES_NUSUARIOID', '=', 'u.USUA_NIDUSUARIO')
            ->select('u.USUA_CRFC', 'u.USUA_CCURP', 'u.USUA_NIDUSUARIO', 'u.USUA_CNOMBRES', 'u.USUA_CPRIMER_APELLIDO', 'u.USUA_CSEGUNDO_APELLIDO', 'u.USUA_CRAZON_SOCIAL', 'g.*')
            ->where('g.GES_NGESTORID', Auth::user()->USUA_NIDUSUARIO)
            ->where('u.USUA_NTIPO_PERSONA', 'MORAL')
            ->where('g.GES_CESTATUS', 'Autorizado')
            ->get();

        if (count($gestores_fisica) > 0)
            $cont_gestor += count($gestores_fisica);
        if (count($gestores_moral) > 0)
            $cont_gestor += count($gestores_moral);

        $tramite = [];
        $tramite['id'] = $id;
        $tramite['idtramiteaccede'] = $detalle->TRAM_NIDTRAMITE_ACCEDE;
        $tramite['fechaactualizacion'] = $detalle->updated_at;
        $tramite['folio'] = $folio;
        $tramite['idsuario'] = Auth::user()->USUA_NIDUSUARIO;
        $tramite['nombre'] = $detalle->TRAM_CNOMBRE;
        $tramite['gestores_fisica'] = $gestores_fisica;
        $tramite['gestores_moral'] = $gestores_moral;
        $tramite['es_gestor'] = $cont_gestor;
        $tramite['responsable'] = $detalle->TRAM_CCENTRO;
        $tramite['descripcion'] = $detalle->TRAM_CDESCRIPCION;
        $tramite['estatus'] = $detalle->TRAM_NESTATUS_PROCESO == null ? 1 : $detalle->TRAM_NESTATUS_PROCESO;
        $tramite['encuesta_contestada'] = $detalle->USTR_NENCUESTA_CONTESTADA;
        if ($detalle->TRAM_NESTATUS_PROCESO == null) {
            $tramite['disabled'] = "";
        } else {
            $tramite['disabled'] = $detalle->TRAM_NESTATUS_PROCESO == 1 ? "" : "disabled";
        }


        //DOcumentos en General Para el Repositorio
        $repositorio = Cls_Usuario_Documento::where('USDO_NIDUSUARIOBASE', Auth::user()->USUA_NIDUSUARIO)
            ->select('USDO_CDOCNOMBRE', 'USDO_CEXTENSION', 'USDO_CRUTADOC', 'USDO_NPESO', 'created_at')
            ->distinct()
            ->orderBy('created_at', 'desc')
            ->get()->toArray();

        $tramite['repositorio'] = [];

        foreach ($repositorio as $_doc) {
            $repodoc = new Cls_Usuario_Documento;
            $repodoc->USDO_CDOCNOMBRE = $_doc['USDO_CDOCNOMBRE'];
            $repodoc->USDO_CEXTENSION = $_doc['USDO_CEXTENSION'];
            $repodoc->USDO_CRUTADOC = $_doc['USDO_CRUTADOC'];
            $repodoc->USDO_NPESO = $_doc['USDO_NPESO'];

            $tramite['repositorio'][] = $repodoc;
            //break;
        }


        $configaracion = $tramites->TRAM_CONSULTAR_CONFIGURACION_TRAMITE_PUBLICO($id);
        $tramite['configuracion'] = $configaracion;
        return view('MST_TRAMITE_SERVICIO.iniciar_tramite_servicio', compact('tramite'));
    }

    public function seguimiento_tramite_servicio($id)
    {
        try {

            $objUsuario = Auth::user();

            $tramites = new Cls_Tramite_Servicio();
            $detalle = $tramites->TRAM_CONSULTAR_DETALLE_TRAMITE_SEGUIMIENTO($id);
            $configaracion = $tramites->TRAM_CONSULTAR_CONFIGURACION_TRAMITE_PUBLICO($detalle->TRAM_NIDTRAMITE, $detalle->USTR_NIDUSUARIOTRAMITE);

            $resolutivosConfig = Cls_Seguimiento_Servidor_Publico::TRAM_OBTENER_RESOLUTIVOS_CONFIGURADOS($detalle->TRAM_NIDTRAMITE);


            //Verificar seccion seguiente, para activar
            foreach ($configaracion['secciones'] as $item) {
                if (array_key_exists('SSEGTRA_NIDSECCION_SEGUIMIENTO', $item)) {
                    if ($item->CONF_NESTATUS_SEGUIMIENTO == 0) {
                        $this->seccion_active = $item->SSEGTRA_NIDSECCION_SEGUIMIENTO;
                        break;
                    } else if ($item->CONF_NESTATUS_SEGUIMIENTO == 1) {
                        $this->seccion_active = $item->SSEGTRA_NIDSECCION_SEGUIMIENTO;
                        break;
                    }
                }
            }

            $tramite = [];
            $tramite['id'] = $detalle->TRAM_NIDTRAMITE;
            $tramite['idusuariotramite'] = $id;
            $tramite['idtramiteaccede'] = $detalle->TRAM_NIDTRAMITE_ACCEDE;
            $tramite['idsuario'] = $detalle->USTR_NIDUSUARIO;
            $tramite['modulo'] = intval($detalle->USTR_CMODULO);
            $tramite['nombreUsuario'] = $objUsuario->USUA_CNOMBRES;
            $tramite['apellidoPUsuario'] = $objUsuario->USUA_CPRIMER_APELLIDO;
            $tramite['apellidoMUsuario'] = $objUsuario->USUA_CSEGUNDO_APELLIDO;
            $tramite['correoUsuario'] = $objUsuario->USUA_CCORREO_ELECTRONICO;
            $tramite['nombre'] = $detalle->TRAM_CNOMBRE;
            $tramite['folio'] = $detalle->TRAM_CFOLIO_SEGUIMIENTO;
            $tramite['fechaactualizacion'] = $detalle->updated_at;
            $tramite['responsable'] = $detalle->TRAM_CCENTRO;
            $tramite['descripcion'] = $detalle->TRAM_CDESCRIPCION;
            $tramite['estatus'] = $detalle->TRAM_NESTATUS_PROCESO == null ? 1 : $detalle->TRAM_NESTATUS_PROCESO;
            $tramite['atencion_formulario'] = $this->atencion;
            $tramite['encuesta_contestada'] = $detalle->USTR_NENCUESTA_CONTESTADA;
            $tramite['seccion_active'] = $this->seccion_active;
            if ($detalle->TRAM_NESTATUS_PROCESO == null || $detalle->TRAM_NESTATUS_PROCESO == 0) {
                $tramite['disabled'] = "";
            } else {
                $tramite['disabled'] = $detalle->TRAM_NESTATUS_PROCESO == 1 ? "" : "disabled";
            }

            //consulta para obtener el nombre y direccion del modulo seleccionado para la ventanilla sin cita
            $tramite['ventanilla_sin_cita_lat'] = $detalle->USTR_NLATITUD == null ? 0 : $detalle->USTR_NLATITUD;
            $tramite['ventanilla_sin_cita_lon'] = $detalle->USTR_NLONGITUD == NULL ? 0 : $detalle->USTR_NLONGITUD;
            // if($detalle->USTR_CMODULO != 0){
            //     $options = array(
            //         'http' => array(
            //             'method'  => 'GET',
            //         )
            //     );
            //     $urlEdificio = $this->host.'/api/vw_accede_edificios_id/'.$detalle->USTR_CMODULO;
            //     $context = stream_context_create($options);
            //     $result = @file_get_contents($urlEdificio, false, $context);
            //     if (strpos($http_response_header[0], "200")) {
            //         $objEdificio = json_decode($result, true);
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
                            $resp->id = 0;
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

            //dd($configaracion);
            //documentos ----
            // $documentos = Cls_Usuario_Documento::where('USDO_NIDUSUARIOTRAMITE', $exist->USTR_NIDUSUARIOTRAMITE)
            //         ->select('*')
            //         ->get()->toArray();
            // //Econtrar---------
            // foreach($configaracion['documentos'] as $doc){
            //     $doc->TRAD_CEXTENSION = "";
            //     $doc->TRAD_CRUTADOC = "";
            //     $doc->TRAD_NPESO = 0;
            //     $doc->TRAD_NESTATUS = 0;
            //     $doc->TRAD_COBSERVACION = "";
            //     $doc->id = 0;
            //     foreach($documentos as $_doc){
            //         if($doc->TRAD_NIDTRAMITEDOCUMENTO != $_doc['USDO_NIDTRAMITEDOCUMENTO']){
            //             $doc->TRAD_CEXTENSION = $_doc['USDO_CEXTENSION'];
            //             $doc->TRAD_CRUTADOC = $_doc['USDO_CRUTADOC'];
            //             $doc->TRAD_NPESO = $_doc['USDO_NPESO'];
            //             $doc->TRAD_NESTATUS = $_doc['USDO_NESTATUS'];
            //             $doc->TRAD_COBSERVACION = $_doc['USDO_COBSERVACION'];
            //             $doc->id = $_doc['USDO_NIDUSUARIORESP'];
            //             break;
            //         }
            //     }
            // }

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

        return view('MST_TRAMITE_SERVICIO.seguimiento_tramite_servicio', compact('tramite'));
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
                    'message' => 'Hubo un problema al guardar la información.',
                ];
            }
        } else {
            $response = [
                'codigo' => 403,
                'status' => "error",
                'message' => 'Petición denegada.',
            ];
        }

        return Response()->json($response);
    }

    public function consultar_detalle_notificacion($id)
    {
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
        //$tramites->TRAM_ESTATUS_NOTIFICACION($id);

        //dd($noti->HNOTI_CMENSAJE);

        return view('MST_TRAMITE_SERVICIO.detalle_notificacion', compact('tramite'));
    }

    public function atencion_notificacion_seguimiento($id, $noti)
    {
        $tramites = new Cls_Tramite_Servicio();
        $tramites->TRAM_ESTATUS_NOTIFICACION($noti);
        $notificacion_det = $tramites->TRAM_CONSULTAR_DETALLE_NOTIFICACION($noti);
        $this->atencion = 1;
        $this->seccion_active = $notificacion_det->HNOTI_NIDCONFIGSECCION; //Activar seccion
        return $this->seguimiento_tramite_servicio($id);
    }

    public function obtener_dependencias_unidad()
    {
        $collection = collect();

        for ($i = 0; $i < 5; $i++) {
            $data = [
                'id' => $i + 1,
                'nombre' => "Opción DU " . $i
            ];
            $collection->push($data);
        }

        $Cls_Tramite_Servicio = new Cls_Tramite_Servicio();
        $result = $Cls_Tramite_Servicio->TRAM_SP_OBTENERDEPENDECIAS();

        return Response()->json($result);
    }

    public function obtener_modalidad()
    {
        $collection = collect();

        for ($i = 0; $i < 5; $i++) {
            $data = [
                'id' => $i + 1,
                'nombre' => "Opción MO " . $i
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
                'nombre' => "Opción CS " . $i
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
                'nombre' => "Opción AU " . $i
            ];
            $collection->push($data);
        }

        return Response()->json($collection);
    }

    public function obtener_municipio($id)
    {
        $lstMunicipios = [];
        $options = array(
            'http' => array(
                'method'  => 'GET',
            )
        );

        $url = $this->host . '/api/Tramite/Municipios';
        $context = stream_context_create($options);
        $result_m = @file_get_contents($url, false, $context);
        if (strpos($http_response_header[0], "200")) {
            $arr = json_decode($result_m, true);
            foreach ($arr as $doc) {
                $_objD = [
                    "id" => $doc['id'] ?? "",
                    "nombre" => $doc['nombre'] ?? ""
                ];
                array_push($lstMunicipios, $_objD);
            }
        }

        return Response()->json($lstMunicipios);
    }

    public function obtener_modulo($id, $idaccede)
    {
        $lstModulos = [];
        $urlTramite = $this->host . '/api/Tramite/Detalle/' . $idaccede;
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

        return Response()->json($lstOficinas);
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

    public function guardar(Request $request)
    {
        // try{
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
        $tram = new Cls_Usuario_Tramite();
        if ($exist == null) {
            $num = 1;
            $getUltimoFolio = Cls_Usuario_Tramite::get()->last();

            if ($getUltimoFolio != null) {
                $num = $getUltimoFolio->USTR_NNUMERO + 1;
            }
            //Guardar inicio de tramite
            $tram->USTR_NESTATUS = 1;
            $tram->USTR_NIDUSUARIO = $request->txtIdUsuario;
            $tram->USTR_NIDTRAMITE = $request->txtIdTramite;
            $tram->USTR_NBANDERA_PROCESO = 0;
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
            $ObjBitacora->BITA_CMOVIMIENTO = "Captura inicial trámite";
            $ObjBitacora->BITA_CTABLA = "tram_mdv_usuariotramite";
            $ObjBitacora->BITA_CIP = $request->ip();
            Cls_Bitacora::TRAM_SP_AGREGARBITACORA($ObjBitacora);
        } else {
            $IntIdUsuarioTramite = $exist->USTR_NIDUSUARIOTRAMITE;
            $TxtFolio = $exist->USTR_CFOLIO;
            //Insertar bitacora
            $ObjBitacora = new Cls_Bitacora();
            $ObjBitacora->BITA_NIDUSUARIO = $request->txtIdUsuario;
            $ObjBitacora->BITA_CMOVIMIENTO = "Edición inicial trámite";
            $ObjBitacora->BITA_CTABLA = "tram_mdv_usuariotramite";
            $ObjBitacora->BITA_CIP = $request->ip();
            Cls_Bitacora::TRAM_SP_AGREGARBITACORA($ObjBitacora);

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
            $resp->USRE_NESTATUS = 0;
            $resp->USRE_CFOLIO_TRAMITE = $TxtFolio;
            $resp->save();
        }

        //Guardar respuestas especial
        foreach ($respuestas_especial as $key => $value) {
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
            $resp->USRE_NESTATUS = 0;
            $resp->USRE_CFOLIO_TRAMITE = $TxtFolio;
            $resp->save();
        }

        //Guardar documentos
        foreach ($documentos as $key => $value) {
            //if($value != null){
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
            $doc->save(); //
            //}
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
        // }
        // catch (\Throwable $e) {
        //     $response = [
        //         'codigo' => 400,
        //         'status' => "error",
        //         'message' => "Ocurrió una excepción, favor de contactar al administrador del sistema , " .$e->message
        //     ];
        // }

        $response = [
            'codigo' => 200,
            'status' => "success",
            'message' => 'Los datos se han guardado correctamente.',
            'data' => $IntIdUsuarioTramite
        ];

        return Response()->json($response);
    }

    public function enviar(Request $request)
    {
        // try{
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
        $tram = new Cls_Usuario_Tramite();
        if ($exist == null) {
            $num = 1;
            $getUltimoFolio = Cls_Usuario_Tramite::get()->last();
            if ($getUltimoFolio != null) {
                $num = $getUltimoFolio->USTR_NNUMERO + 1;
            }

            //Guardar inicio de tramite
            $tram->USTR_NESTATUS = 2;
            $tram->USTR_NIDUSUARIO = $request->txtIdUsuario;
            $tram->USTR_NIDTRAMITE = $request->txtIdTramite;
            $tram->USTR_NBANDERA_PROCESO = 1;
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
            $ObjBitacora->BITA_CMOVIMIENTO = "Captura inicial trámite";
            $ObjBitacora->BITA_CTABLA = "tram_mdv_usuariotramite";
            $ObjBitacora->BITA_CIP = $request->ip();
            Cls_Bitacora::TRAM_SP_AGREGARBITACORA($ObjBitacora);
        } else {
            $IntIdUsuarioTramite = $exist->USTR_NIDUSUARIOTRAMITE;
            $TxtFolio = $exist->USTR_CFOLIO;
            //Editar estatus del tramite
            $tram = Cls_Usuario_Tramite::where('USTR_NIDUSUARIOTRAMITE', $IntIdUsuarioTramite)
                ->update([
                    'USTR_NESTATUS' => 2,
                    'USTR_NBANDERA_PROCESO' => 1
                ]);

            //Insertar bitacora
            $ObjBitacora = new Cls_Bitacora();
            $ObjBitacora->BITA_NIDUSUARIO = $request->txtIdUsuario;
            $ObjBitacora->BITA_CMOVIMIENTO = "En proceso trámite";
            $ObjBitacora->BITA_CTABLA = "tram_mdv_usuariotramite";
            $ObjBitacora->BITA_CIP = $request->ip();
            Cls_Bitacora::TRAM_SP_AGREGARBITACORA($ObjBitacora);

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
            $resp->USRE_NESTATUS = 0;
            $resp->USRE_CFOLIO_TRAMITE = $TxtFolio;
            $resp->save();
        }

        //Guardar respuestas especial
        foreach ($respuestas_especial as $key => $value) {
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
            $resp->USRE_NESTATUS = 0;
            $resp->USRE_CFOLIO_TRAMITE = $TxtFolio;
            $resp->save();
        }

        //Guardar documentos
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
        // }
        // catch (\Throwable $e) {
        //     $response = [
        //         'codigo' => 400,
        //         'status' => "error",
        //         'message' => "Ocurrió una excepción, favor de contactar al administrador del sistema , " .$e->message
        //     ];
        // }

        $response = [
            'codigo' => 200,
            'status' => "success",
            'message' => 'Los datos se han enviado correctamente.',
            'data' => $IntIdUsuarioTramite
        ];

        return Response()->json($response);
    }

    public function reenviar(Request $request)
    {
        // try{
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
                'USTR_NBANDERA_PROCESO' => 2
            ]);

        //Insertar bitacora
        $ObjBitacora = new Cls_Bitacora();
        $ObjBitacora->BITA_NIDUSUARIO = $request->txtIdUsuario;
        $ObjBitacora->BITA_CMOVIMIENTO = "Trámite reenviado";
        $ObjBitacora->BITA_CTABLA = "tram_mdv_usuariotramite";
        $ObjBitacora->BITA_CIP = $request->ip();
        Cls_Bitacora::TRAM_SP_AGREGARBITACORA($ObjBitacora);

        //Guardar respuestas
        foreach ($respuestas as $key => $value) {
            $arr = explode("_", $key);
            $obj_p = Cls_Formulario_Pregunta::where('FORM_NID', $arr[1])
                ->select('*')
                ->first();

            //Exist
            $exist_respuestas = Cls_Usuario_Respuesta::where('USRE_NIDUSUARIORESP', $arr[3])
                ->select('*')
                ->first();

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
            $exist_respuestas_especial = Cls_Usuario_Respuesta::where('USRE_NIDUSUARIORESP', $arr[3])
                ->select('*')
                ->first();

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

        Mail::send('MSTP_MAIL.notificacion_subsanar', $ObjData, function ($message) use ($ObjData) {
            $message->from('ldavalos@esz.com.mx', 'ldavalos');
            $message->to($ObjData['_correo'], '')->subject('Corrección de información sobre trámite con folio ' . $ObjData['_folio_tramite']);
        });

        // }
        // catch (\Throwable $e) {
        //     $response = [
        //         'codigo' => 400,
        //         'status' => "error",
        //         'message' => "Ocurrió una excepción, favor de contactar al administrador del sistema , " .$e->message
        //     ];
        // }

        $response = [
            'codigo' => 200,
            'status' => "success",
            'message' => 'Los datos se han enviado correctamente.'
        ];

        return Response()->json($response);
    }

    public function enviar_encuesta(Request $request)
    {
        $item = new Cls_Encuesta_Satisfaccion();
        $item->HENCS_NIDUSUARIOTRAMITE = $request->txtIdUsuarioTramite;
        $item->HENCS_CPREGUNTA = "¿Cómo fue el servicio que recibió por parte de la persona que le atendió?";
        $item->HENCS_CPRESPUESTA = $request->txtPregunta1;
        $item->save();

        $item = new Cls_Encuesta_Satisfaccion();
        $item->HENCS_NIDUSUARIOTRAMITE = $request->txtIdUsuarioTramite;
        $item->HENCS_CPREGUNTA = "De acuerdo a su visita, ¿se enfrentó con obstáculos, barreras o algún tipo de inconveniente?";
        $item->HENCS_CPRESPUESTA = $request->txtPregunta2;
        $item->save();

        $item = new Cls_Encuesta_Satisfaccion();
        $item->HENCS_NIDUSUARIOTRAMITE = $request->txtIdUsuarioTramite;
        $item->HENCS_CPREGUNTA = "¿Qué tan satisfecho se encuentra con el tiempo de atención del trámite o servicio?";
        $item->HENCS_CPRESPUESTA = $request->txtPregunta3;
        $item->save();

        $item = new Cls_Encuesta_Satisfaccion();
        $item->HENCS_NIDUSUARIOTRAMITE = $request->txtIdUsuarioTramite;
        $item->HENCS_CPREGUNTA = "¿Desea agregar algún comentario adicional?";
        $item->HENCS_CPRESPUESTA = $request->txtPregunta4;
        $item->save();

        Cls_Usuario_Tramite::where('USTR_NIDUSUARIOTRAMITE', $request->txtIdUsuarioTramite)
            ->update([
                'USTR_NENCUESTA_CONTESTADA' => 1
            ]);

        $response = [
            'codigo' => 200,
            'status' => "success",
            'message' => 'Acción realizada con éxito.'
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
        $File = $request->file('file');
        $DocType = $request->doctype;
        $IntSize = $File->getSize();
        $StrExtension = $File->getClientOriginalExtension();
        $StrName = rand() . '.' . $StrExtension;
        $File->move(public_path('files/documentos/'), $StrName);

        return response()->json([
            'message'   => 'correctamente',
            'path' => 'files/documentos/' . $StrName,
            'extension' => $StrExtension,
            'size' => $IntSize,
            'typename' => $DocType,
            'status'  => 'success'
        ]);
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
                "titulo" => "Periodo en que puedo realizar el trámite",
                "descripcion" => $objTramite['INICIO_VIGENCIA'] . " al " . $objTramite['FIN_VIGENCIA'] ?? "",
                "opciones" => [],
            ],
            [
                "titulo" => "Usuario a quien está dirigido el trámite:",
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
                "titulo" => "Tiempo hábil promedio de resolución:",
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
                "titulo" => "Clasificación",
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
                "titulo" => "Casos en que se debe realizar el trámite:",
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
                "titulo" => "¿Puede hacer el trámite alguien más?:",
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
                "titulo" => "¿Hay información en línea?:",
                "descripcion" => $objTramite['SNSOLILINEA'] ?? "",
                "opciones" => [],
                "documentos" => []
            ],
            [
                "titulo" => "¿Se pueden recibir solicitudes en línea?:",
                "descripcion" => $objTramite['SNTRAMLINEA'] ?? "",
                "opciones" => [],
                "documentos" => []
            ],
            [
                "titulo" => "Solicitud en línea ¿Requiere formato?:",
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
                "titulo" => "¿Tiene costo?:",
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
}
