<?php

namespace App\Http\Controllers;

use Exception;
use App\Cls_Usuario;
use App\Cls_Bitacora;
use Illuminate\Http\Request;
use App\Services\TramiteService;
use Illuminate\Support\Facades\DB;
use App\Services\ServidoresService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\GeneralController;

class ServidorPublicoController extends Controller
{

    protected $servidoresService;
    protected $tramiteService;
    public function __construct() {
        $this->servidoresService    = new ServidoresService();
        $this->tramiteService       = new TramiteService();
    }

    public function index(Request $request)
    {
        return view('CAT_SERVIDOR_PUBLICO.index');
    }

    public function crear(Request $request){
        return view('CAT_SERVIDOR_PUBLICO.crear');
    }

    public function consultar(){
        $result = Cls_Usuario::TRAM_SP_CONSULTAR_USUARIOS();
        $response = [
            'data' => $result,
        ];
        
        return Response()->json($response);
    }

    public function agregar(Request $request){
        $response = [];
        $IntUsuarioId = 0;
        
        try {
            $request->txtRol            = $request->cmbRol;
            $request->rdbTipo_Persona   = "FISICA";
            $request->txtRfc            = "XAXX010101000";
            $request->txtCurp           = "11111111111111";
            $request->txtCalle_Fiscal   = "1";
            $request->txtCP_Fiscal      = 11111;
            $request->cmbColonia_Fiscal = "1";
            $request->cmbEstado_Fiscal  = "1";
            $request->cmbPais_Fiscal    = "1";
            $request->txtNumero_Interior_Fiscal = 1;
            $request->txtNumero_Exterior_Fiscal = 1;
            $request->cmbMunicipio_Fiscal       = "1";
            $request->txtNumeroTelefono         = $request->txtTelefono;
            
            DB::beginTransaction();
            $IntUsuarioId = Cls_Usuario::TRAM_SP_AGREGARUSUARIO($request);

            Cls_Usuario::TRAM_SP_ELIMINAR_AREAS_PERTENECE_ACCESO($IntUsuarioId);
            //Agregar areas pertenece
            
            if($request->lstDependenciaPertenece != null && count($request->lstDependenciaPertenece) > 0){
                foreach ($request->lstDependenciaPertenece as $value) {
                    $retys = $this->tramiteService->getRetys('dependencies',$value);
                    Cls_Usuario::TRAM_SP_AGREGAR_DEPENDENCIA_USUARIO_PERTENECE($retys->iId, $IntUsuarioId);
                }
            }

            if( $request->lstUnidadPertence != null && count($request->lstUnidadPertence) > 0){
                foreach ($request->lstUnidadPertence as $value) {
                    $retys = $this->tramiteService->getRetys('administrativeunits',$value);
                    Cls_Usuario::TRAM_SP_AGREGAR_UNIDAD_USUARIO_PERTENECE($retys->iId, $IntUsuarioId);
                }
            }

            if( $request->lstTramitePertence != null && count($request->lstTramitePertence) > 0){
                foreach ($request->lstTramitePertence as $value) {
                    Cls_Usuario::TRAM_SP_AGREGAR_TRAMITE_USUARIO_PERTENECE($value, $IntUsuarioId);
                }
            }


            if(  $request->lstEdificioPertence != null && count($request->lstEdificioPertence) > 0){
                foreach ($request->lstEdificioPertence as $value) {
                    $retys = $this->tramiteService->getRetys('administrativeunitbuildings',$value);
                    Cls_Usuario::TRAM_SP_AGREGAR_EDIFICIO_USUARIO_PERTENECE($retys->iId, $IntUsuarioId);
                }
            }
       

            //Agregar areas acceso
            if($request->lstDependenciaAcceso != null && count($request->lstDependenciaAcceso) > 0){
                foreach ($request->lstDependenciaAcceso as $value) {
                    $retys = $this->tramiteService->getRetys('dependencies',$value);
                    Cls_Usuario::TRAM_SP_AGREGAR_DEPENDENCIA_USUARIO_ACCESO($retys->iId, $IntUsuarioId);
                }
            }

            if($request->lstUnidadAcceso != null && count($request->lstUnidadAcceso)> 0){
                foreach ($request->lstUnidadAcceso as $value) {
                    $retys = $this->tramiteService->getRetys('administrativeunits',$value);
                    Cls_Usuario::TRAM_SP_AGREGAR_UNIDAD_USUARIO_ACCESO($retys->iId, $IntUsuarioId);
                }
            }

        
            if($request->lstTramiteAcceso  != null && count($request->lstTramiteAcceso) > 0){
                foreach ($request->lstTramiteAcceso as $value) {
                    Cls_Usuario::TRAM_SP_AGREGAR_TRAMITE_USUARIO_ACCESO($value, $IntUsuarioId);
                }
            }
            
            if($request->lstEdificioAcceso != null  && count($request->lstEdificioAcceso) > 0){
                foreach ($request->lstEdificioAcceso as $value) {
                    $retys = $this->tramiteService->getRetys('administrativeunitbuildings',$value);
                    Cls_Usuario::TRAM_SP_AGREGAR_EDIFICIO_USUARIO_ACCESO($retys->iId, $IntUsuarioId);
                }
            }

            //Envia correo
            $ObjData['StrNombres'] = $request->txtNombres;
            $ObjData['StrHost'] = $request->getHttpHost();
            $ObjData['StrApellidos'] = $request->txtPrimer_Apellido . " " . $request->txtSegundo_Apellido;;
            $ObjData['StrCorreoElectronico'] = $request->txtCorreo_Electronico;
            Mail::send('MSTP_MAIL.registro_funcionario', $ObjData, function ($message) use($ObjData) {
                $message->from('ldavalos@esz.com.mx', 'ldavalos');
                $message->to($ObjData['StrCorreoElectronico'], '')->subject('Registro.');
            });

            if($IntUsuarioId > 0){
                //Insertar bitacora
                $ObjBitacora = new Cls_Bitacora();
                $ObjBitacora->BITA_NIDUSUARIO = $IntUsuarioId;
                $ObjBitacora->BITA_CMOVIMIENTO = "Registro usuario servidor público";
                $ObjBitacora->BITA_CTABLA = "tram_mst_usuario";
                $ObjBitacora->BITA_CIP = $request->ip();
                Cls_Bitacora::TRAM_SP_AGREGARBITACORA($ObjBitacora);
            }

            $response = [
                'codigo' => $IntUsuarioId > 0 ? 200 : 400, 
                'status' => $IntUsuarioId > 0 ? "success" : "error",
                'message' => $IntUsuarioId > 0 ? '¡Éxito! Acción realizada con éxito.' : "Ocurrió un excepción, favor de contactar al administrador del sistema <<>>",
                'data' => $IntUsuarioId
            ];
            
            DB::commit();
        }
        catch(Exception $e) {
            DB::rollBack();
            $response = [
                'codigo' => 400, 
                'status' => "error", 
                'message' => "Ocurrió una excepción, favor de contactar al administrador del sistema , " .$e->getMessage(),
                'data' => $IntUsuarioId
            ];
        }
        return Response()->json($response);
    }

    public function editar($id){
        $objUsuario =  Cls_Usuario::TRAM_SP_OBTENER_USUARIO($id);
      
        //Areas pertenece
        $objUsuario->lstDependenciaPertenece    = Cls_Usuario::TRAM_SP_CONSULTAR_DEPENDENCIA_USUARIO_PERTENECE($id);
        $objUsuario->lstUnidadPertence          = Cls_Usuario::TRAM_SP_CONSULTAR_UNIDAD_USUARIO_PERTENECE($id);
        $objUsuario->lstTramitePertence         = Cls_Usuario::CONSULTAR_TRAMITE_USUARIO_PERTENECE($id);
        $objUsuario->lstEdificioPertence        = Cls_Usuario::TRAM_SP_CONSULTAR_EDIFICIO_USUARIO_PERTENECE($id);

        //Areas acceso
        $objUsuario->lstDependenciaAcceso   = Cls_Usuario::TRAM_SP_CONSULTAR_DEPENDENCIA_USUARIO_ACCESO($id);
        $objUsuario->lstUnidadAcceso        = Cls_Usuario::TRAM_SP_CONSULTAR_UNIDAD_USUARIO_ACCESO($id);
        $objUsuario->lstTramiteAcceso       = Cls_Usuario::CONSULTAR_TRAMITE_USUARIO_ACCESO($id);
        $objUsuario->lstEdificioAcceso      = Cls_Usuario::TRAM_SP_CONSULTAR_EDIFICIO_USUARIO_ACCESO($id);
  
        return view('CAT_SERVIDOR_PUBLICO.editar', compact('objUsuario'));
    }

    public function modificar(Request $request){ dd($request->all());
        $response = [];
        try {
            $request->txtRol            = $request->cmbRol;
            $request->rdbTipo_Persona   = "FISICA";
            $request->txtCalle_Fiscal   = "1";
            $request->txtRfc            = "XAXX010101000";
            $request->txtCurp           = "11111111111111";
            $request->txtCP_Fiscal      = 11111;
            $request->cmbColonia_Fiscal = "1";
            $request->cmbEstado_Fiscal  = "1";
            $request->cmbPais_Fiscal    = "1";
            $request->txtNumeroTelefono = $request->txtTelefono;
            $request->cmbMunicipio_Fiscal       = "1";
            $request->txtNumero_Interior_Fiscal = 1;
            $request->txtNumero_Exterior_Fiscal = 1;

            Cls_Usuario::TRAM_SP_MODIFICARUSUARIO($request);
            
            DB::beginTransaction();
            //Insertar bitacora
            $ObjBitacora = new Cls_Bitacora();
            $ObjBitacora->BITA_NIDUSUARIO = $request->txtIdUsuario;
            $ObjBitacora->BITA_CMOVIMIENTO = "Edición de usuario";
            $ObjBitacora->BITA_CTABLA = "tram_mst_usuario";
            $ObjBitacora->BITA_CIP = $request->ip();
            Cls_Bitacora::TRAM_SP_AGREGARBITACORA($ObjBitacora);

            $IntUsuarioId = $request->txtIdUsuario;
            
            Cls_Usuario::TRAM_SP_ELIMINAR_AREAS_PERTENECE_ACCESO($IntUsuarioId);


            //Agregar areas pertenece
            if($request->lstDependenciaPertenece  != null && count($request->lstDependenciaPertenece) > 0){
                foreach ($request->lstDependenciaPertenece as $value) {
                    Cls_Usuario::TRAM_SP_AGREGAR_DEPENDENCIA_USUARIO_PERTENECE($value, $IntUsuarioId);
                }
            }
            if($request->lstUnidadPertence  != null && count($request->lstUnidadPertence) > 0){
                foreach ($request->lstUnidadPertence as $value) {
                    Cls_Usuario::TRAM_SP_AGREGAR_UNIDAD_USUARIO_PERTENECE($value, $IntUsuarioId);
                }
            }
            if($request->lstTramitePertence  != null && count($request->lstTramitePertence) > 0){
                foreach ($request->lstTramitePertence as $value) {
                    Cls_Usuario::TRAM_SP_AGREGAR_TRAMITE_USUARIO_PERTENECE($value, $IntUsuarioId);
                }
            }
            if($request->lstEdificioPertence  != null && count($request->lstEdificioPertence) > 0){
                foreach ($request->lstEdificioPertence as $value) {
                    Cls_Usuario::TRAM_SP_AGREGAR_EDIFICIO_USUARIO_PERTENECE($value, $IntUsuarioId);
                }
            }

            //Agregar areas acceso
            if($request->lstDependenciaAcceso  != null && count($request->lstDependenciaAcceso) > 0){
                foreach ($request->lstDependenciaAcceso as $value) {
                    Cls_Usuario::TRAM_SP_AGREGAR_DEPENDENCIA_USUARIO_ACCESO($value, $IntUsuarioId);
                }
            }
            if($request->lstUnidadAcceso != null && count($request->lstUnidadAcceso) > 0){
                foreach ($request->lstUnidadAcceso as $value) {
                    Cls_Usuario::TRAM_SP_AGREGAR_UNIDAD_USUARIO_ACCESO($value, $IntUsuarioId);
                }
            }
            if($request->lstTramiteAcceso != null && count($request->lstTramiteAcceso) > 0){
                foreach ($request->lstTramiteAcceso as $value) {
                    Cls_Usuario::TRAM_SP_AGREGAR_TRAMITE_USUARIO_ACCESO($value, $IntUsuarioId);
                }
            }
            if($request->lstEdificioAcceso != null && count($request->lstEdificioAcceso) > 0){
                foreach ($request->lstEdificioAcceso as $value) {
                    Cls_Usuario::TRAM_SP_AGREGAR_EDIFICIO_USUARIO_ACCESO($value, $IntUsuarioId);
                }
            }
        }
        catch(Exception $e) {
            $response = [
                'codigo' => 400, 
                'status' => "error", 
                'message' => "Ocurrió una excepción, favor de contactar al administrador del sistema , " .$e->getMessage()
            ];
        }
        $response = [
            'codigo' => 200, 
            'status' => "success",
            'message' => '¡Éxito! Acción realizada con éxito.'
        ];

        return Response()->json($response);
    }

    public function getDepencencias(){
        return $this->servidoresService->getDependencias();
    }

    public function getUnity(Request $request){
        return $this->servidoresService->getUnidadesAdministrativas($request);
    }

    public function getTramites(Request $request){
        return $this->servidoresService->getTramites($request);
    }

    public function getEdificios(Request $request){
        return $this->servidoresService->getEdificios($request);
    }

    public function detalle($id){
        $data_unidad    = [];
        $data_edificios = [];
        $num_dependen   = 0;
        $num_unidades   = 0;
        $num_tramites   = 0;
        $num_edificios  = 0;
        
        $general = new GeneralController();
        $data_dependencias = $general->dependencias()->getData();
        $Obj =  Cls_Usuario::TRAM_SP_OBTENER_USUARIO($id);

        //Areas pertenece
        $Obj->lstDependenciaPertenece = Cls_Usuario::TRAM_SP_CONSULTAR_DEPENDENCIA_USUARIO_PERTENECE($id);
        $num_dependen =  $num_dependen  + count($Obj->lstDependenciaPertenece);
        foreach($Obj->lstDependenciaPertenece as $value){
            $value->DEPUP_CNOMBRE = "";
            foreach($data_dependencias as $item){
                if($value->DEPUP_NIDDEPENCIA == $item->ID_CENTRO){
                    $value->DEPUP_CNOMBRE = $item->DESCRIPCION;
                }
            }
        }
        
        if(sizeof($Obj->lstDependenciaPertenece) > 0){
            $data["dependencia_id"] = (string) $Obj->lstDependenciaPertenece['0']->DEPUP_NIDDEPENCIA;
            $request        = new Request($data);
            $data_unidad    = $general->unidades_administrativas($request)->getData();
        }

        $Obj->lstUnidadPertence = Cls_Usuario::TRAM_SP_CONSULTAR_UNIDAD_USUARIO_PERTENECE($id);
        $num_unidades =  $num_unidades  + count($Obj->lstUnidadPertence);
        foreach($Obj->lstUnidadPertence as $value){
            $value->UNIDUP_CNOMBRE = "";
            foreach($data_unidad as $item){
                if($value->UNIDUP_NIDUNIDAD == $item->ID_UNIDAD){
                    $value->UNIDUP_CNOMBRE = $item->DESCRIPCION;
                    $value->ID_DEPENDENCIA = $item->ID_CENTRO;
                }
            }
        }

        
        $data["dependencia_id"]     = (string) $Obj->lstDependenciaPertenece['0']->DEPUP_NIDDEPENCIA;
        $data["tipo"]               = "all";
        $request                    = new Request($data);
        $data_edificios             = $general->edificios($request)->getData();
        $Obj->lstTramitePertence    = Cls_Usuario::TRAM_SP_CONSULTAR_TRAMITE_USUARIO_PERTENECE($id);
        $Obj->lstEdificioPertence   = Cls_Usuario::TRAM_SP_CONSULTAR_EDIFICIO_USUARIO_PERTENECE($id);
        $num_tramites               = $num_tramites + count($Obj->lstTramitePertence);
        $num_edificios              = $num_edificios + count($Obj->lstEdificioPertence);

        foreach($Obj->lstEdificioPertence as $value){
            $value->EDIFUP_CNOMBRE = "";
            foreach($data_edificios as $item){
                if($value->EDIFUP_NIDEDIFICIO == $item->ID_EDIFICIO){
                    $value->EDIFUP_CNOMBRE = $item->EDIFICIO;
                }
            }
        }
      
        //Areas acceso
        $Obj->lstDependenciaAcceso = Cls_Usuario::TRAM_SP_CONSULTAR_DEPENDENCIA_USUARIO_ACCESO($id);
        $num_dependen =  $num_dependen  + count($Obj->lstDependenciaAcceso);
        foreach($Obj->lstDependenciaAcceso as $value){
            $value->DEPUA_CNOMBRE = "";
            foreach($data_dependencias as $item){
                if($value->DEPUA_NIDDEPENCIA == $item->ID_CENTRO){
                    $value->DEPUA_CNOMBRE = $item->DESCRIPCION;
                }
            }
        }

        if(sizeof($Obj->lstDependenciaAcceso) > 0){
            $data["dependencia_id"] = "0";
            $data["tipo"]           = "multiple";

            foreach ($Obj->lstDependenciaAcceso as $dependencia) {
                $data["dependencia_id"] = $data["dependencia_id"].",".(string)$dependencia->DEPUA_NIDDEPENCIA;
            }
           
            $request        = new Request($data);
            $data_unidad    = $general->unidades_administrativas($request)->getData();
        }

        $Obj->lstUnidadAcceso   = Cls_Usuario::TRAM_SP_CONSULTAR_UNIDAD_USUARIO_ACCESO($id);
        $num_unidades           =  $num_unidades  + count($Obj->lstUnidadAcceso);

        foreach($Obj->lstUnidadAcceso as $value){
            $value->UNIDUA_CNOMBRE = "";
            foreach($data_unidad as $item){
                if($value->UNIDUA_NIDUNIDAD == $item->ID_UNIDAD){
                    $value->UNIDUA_CNOMBRE = $item->DESCRIPCION;
                    $value->ID_DEPENDENCIA = $item->ID_CENTRO;
                }
            }
        }

        $Obj->lstTramiteAcceso  = Cls_Usuario::TRAM_SP_CONSULTAR_TRAMITE_USUARIO_ACCESO($id);
        $Obj->lstEdificioAcceso = Cls_Usuario::TRAM_SP_CONSULTAR_EDIFICIO_USUARIO_ACCESO($id);
        $num_tramites           = $num_tramites + count($Obj->lstTramiteAcceso);
        $num_edificios          = $num_edificios + count($Obj->lstEdificioAcceso);

        $data_tramite = [];
        $data["unidad_id"] = "0";
        $data["tipo"]      = "all";

        foreach ($Obj->lstTramiteAcceso as $tramite) {
            $data["unidad_id"] = $data["unidad_id"].",".(string)$tramite->ID_UNIDAD;
        }
        
        $request        = new Request($data);
        $data_tramite   = $general->tramites($request)->getData();
        $temp_tramite   = [];
        $qw = [];

        foreach($Obj->lstEdificioAcceso as $value){
            $value->EDIFUA_CNOMBRE  = "";
            $value->unida_id        = "";
            foreach($data_edificios as $item){
                if($value->EDIFUA_NIDEDIFICIO == $item->ID_EDIFICIO){
                    $value->EDIFUP_CNOMBRE = $item->EDIFICIO;
                }
            }

            foreach ($Obj->lstTramiteAcceso as $tramite) {
                foreach ($data_tramite as $item) {
                    if( $item->ID_TRAM == $tramite->TRAMUA_NIDTRAMITE){ 
                        $temp = ["ID_TRAM" => $item->ID_TRAM, "ID_CENTRO" => $item->ID_CENTRO, "ID_UNIDAD" => $item->ID_UNIDAD, "EDIFICIOS" => $item->EDIFICIOS ];
                        array_push($temp_tramite, $temp);
                    }
                } 
            }
        }
       
        foreach ($Obj->lstEdificioAcceso as $aa) {
            foreach ($temp_tramite as $key) {
                $edificios = explode("||", $key["EDIFICIOS"]);
                foreach ($edificios as $e ) {
                    if($e == $aa->EDIFUA_NIDEDIFICIO){
                        $aa->unidad_id = $key["ID_UNIDAD"];
                        array_push($qw, $key["ID_UNIDAD"]);
                    }
                }
            }
        }

        $Obj->num_dependen  = $num_dependen;
        $Obj->num_unidades  = $num_unidades;
        $Obj->num_tramites  = $num_tramites;
        $Obj->num_edificios = $num_edificios;

        return view('CAT_SERVIDOR_PUBLICO.detalle', compact('Obj'));
    }

    public function validar_correo($StrCorreo){

        try {
            $IntResult = Cls_Usuario::TRAM_SP_VALIDAR_CORREO($StrCorreo);

            $response = [
                'codigo' => $IntResult > 0 ? 200 : 400, 
                'status' => $IntResult > 0 ? "success" : "error", 
                'message' => $IntResult > 0 ? 'El correo electrónico ya existe en el sistema.' : "Ocurrió un excepción, favor de contactar al administrador del sistema <<>>"
            ];
        }
        catch(Exception $e) {
            $response = [
                'codigo' => 400, 
                'status' => "error", 
                'message' => "Ocurrió una excepción, favor de contactar al administrador del sistema , " .$e->getMessage()
            ];
        }
        return Response()->json($response);
    }
}
