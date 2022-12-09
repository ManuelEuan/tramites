<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use App\Cls_Rol;
use App\Cls_Usuario;
use App\Cls_Bitacora;
use App\Cls_Sucursal;
use Illuminate\Http\Request;
use App\Services\UsuarioService;
use App\Services\CatalogoService;
use Illuminate\Auth\Events\Registered;

class RegistroController extends Controller
{
    protected $catalogoService;
    protected $userService;
    public function __construct(){
        $this->catalogoService  = new CatalogoService();
        $this->userService      = new UsuarioService();
    }
    
    public function agregar(Request $request){
        $response   = [];
        $usuario    = null;
        $rol  = Cls_Rol::TRAM_SP_OBTENERROLPORCLAVE("CDNS");

        $request->rolId     = $rol->ROL_NIDROL;
        $request->txtCurp   = isset($request->rdbTipo_Persona) && $request->rdbTipo_Persona == "MORAL" ? $request->txtCurpMoral : $request->txtCurp;
        $request->txtCorreo = isset($request->rdbTipo_Persona) && $request->rdbTipo_Persona == "MORAL" ? $request->txtCorreo_ElectronicoMoral : $request->txtCorreo_Electronico;
        $result             = $this->userService->store($request);
        $sucursales         = is_null($request->lstSucursal) ? [] : $request->lstSucursal;
            
            if(is_null($result['error'])){
                $usuario    = $result['item'];
                event(new Registered($usuario));

                //Agregar sucursales
                foreach ($sucursales as $value) {
                    $ObjSucursal = array(
                        'txtUsuario'    => $usuario->USUA_NIDUSUARIO,
                        'txtCalle'      => '0',
                        'txtNumero_Interior' => '0',
                        'txtNumero_Exterior' => '0',
                        'txtCP'         => '0',
                        'cmbColonia'    => '0',
                        'cmbMunicipio'  => '0',
                        'cmbEstado'     => '0',
                        'cmbPais'       => '0'
                    );
                    Cls_Sucursal::TRAM_SP_AGREGARSUCURSAL($ObjSucursal);
                }

                //Envia correo
                /*$ObjData['StrNombres'] = $request->txtNombres;
                $ObjData['StrHost'] = $request->getHttpHost();
                $ObjData['StrApellidos'] = $request->txtPrimer_Apellido . " " . $request->txtSegundo_Apellido;;
                $ObjData['StrCorreoElectronico'] = isset($request->rdbTipo_Persona) && $request->rdbTipo_Persona == "MORAL" ? $request->txtCorreo_ElectronicoMoral : $request->txtCorreo_Electronico;
                $ObjData['StrRFC'] = $request->txtRfc;
                Mail::send('MSTP_MAIL.registro', $ObjData, function ($message) use($ObjData) {
                    $message->from(env('MAIL_FROM_ADDRESS'), 'Sistema de Tramites Digitales Queretaro');
                    $message->to($ObjData['StrCorreoElectronico'], $request->txtNombres)->subject('Registro.');
                });*/

                $bitacora = new Cls_Bitacora();
                $bitacora->BITA_NIDUSUARIO   = $usuario->USUA_NIDUSUARIO;
                $bitacora->BITA_CMOVIMIENTO  = "Registro";
                $bitacora->BITA_CTABLA       = "tram_mst_usuario y tram_mdv_sucursal";
                $bitacora->BITA_CIP          = $request->ip();
                $bitacora->BITA_FECHAMOVIMIENTO = now();
                $bitacora->save();
            }

            $response = [
                'codigo'    => !is_null($usuario) ? 200 : 400, 
                'status'    => !is_null($usuario) ? "success" : "error",
                'message'   => !is_null($usuario) ? '¡Éxito! Acción realizada con éxito.' : "Ocurrió un excepción, favor de contactar al administrador del sistema <<asdas>>",
                'data'      => !is_null($usuario) ? $result['error'] : $usuario
            ];

        return Response()->json($response);
    }

    public function validar_rfc($StrRfc){

        try {
            $IntResult = Cls_Usuario::TRAM_SP_VALIDAR_RFC($StrRfc);

            $response = [
                'codigo' => $IntResult > 0 ? 200 : 400, 
                'status' => $IntResult > 0 ? "success" : "error", 
                'message' => $IntResult > 0 ? 'El RFC ya existe en el sistema, por favor ingresa con tu usuario y contraseña.' : "Ocurrió un excepción, favor de contactar al administrador del sistema <<>>"
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

    public function validar_curp($StrCurp){

        $IntResult = Cls_Usuario::TRAM_SP_VALIDAR_CURP($StrCurp);
        $response = [
            'codigo' => $IntResult > 0 ? 200 : 400, 
            'status' => $IntResult > 0 ? "success" : "error", 
            'message' => $IntResult > 0 ? 'El correo electrónico ya existe en el sistema, por favor ingresa con tu usuario y contraseña.' : "Ocurrió un excepción, favor de contactar al administrador del sistema <<>>"
        ];
        //dd($response);
        return Response()->json($response);
    }

    public function validar_correo($StrCorreo){
        
        try {
            $IntResult = Cls_Usuario::TRAM_SP_VALIDAR_CORREO($StrCorreo);
            
            $response = [
                'codigo' => $IntResult > 0 ? 200 : 400, 
                'status' => $IntResult > 0 ? "success" : "error", 
                'message' => $IntResult > 0 ? 'El correo electrónico ya existe en el sistema, por favor ingresa con tu usuario y contraseña.' : "Ocurrió un excepción, favor de contactar al administrador del sistema <<>>"
            ];
        }
        catch(Exception $e) {
            $response = [
                'codigo' => 400, 
                'status' => "error", 
                'message' => "Ocurrió una excepción, favor de contactar al administrador del sistema , " .$e->getMessage()
            ];
        }
        //dd($response);
        return Response()->json($response);
    }
	
	
    public function estados(){
        $list = $this->catalogoService->get("states");
        return Response()->json($list);
    }

    public function municipios($id){
        $list = $this->catalogoService->getCondition("municipalities", "IdState", $id);
        return Response()->json($list);
    }

    public function localidades($id){
        $list = $this->catalogoService->getCondition("colonies", "IdMunicipality", $id);
        return Response()->json($list);
    }

}
