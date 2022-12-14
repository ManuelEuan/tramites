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
                    Cls_Sucursal::create($ObjSucursal);
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
                'message'   => !is_null($usuario) ? '????xito! Acci??n realizada con ??xito.' : "Ocurri?? un excepci??n, favor de contactar al administrador del sistema <<asdas>>",
                'data'      => !is_null($usuario) ? $result['error'] : $usuario
            ];

        return Response()->json($response);
    }

    public function validar_rfc($rfc){
        $result = User::where('USUA_CRFC', $rfc)->first();
        $response = [
            'codigo'    => !is_null($result) ? 200 : 400, 
            'status'    => !is_null($result) ? "success" : "error", 
            'message'   => !is_null($result) ? 'El RFC ya existe en el sistema, por favor ingresa con tu usuario y contrase??a.' : "El RFC esta disponible."
        ];
        return Response()->json($response);
    }

    public function validar_curp($StrCurp, $id){
        $response = ['codigo' =>  200, 'status' =>  "success", 'message' => "Correcto"];
        $user = User::where('USUA_CCURP',$StrCurp)->first();

        if(!is_null($user)){
            if($user->USUA_NIDUSUARIO != $id){
                $response = [
                    'codigo' => 400, 
                    'status' => "error", 
                    'message' => 'El correo electr??nico ya existe en el sistema, por favor ingresa con tu usuario y contrase??a.'
                ];
            }
        }

        return Response()->json($response);
    }

    public function validar_correo($correo){
        $result = User::where('USUA_CCORREO_ELECTRONICO', $correo)->orWhere('USUA_CCORREO_ALTERNATIVO', $correo)->first();
        $response = [
            'codigo'    => !is_null($result) ? 200 : 400, 
            'status'    => !is_null($result) ? "success" : "error", 
            'message'   => !is_null($result) ? 'El correo electr??nico ya existe en el sistema, por favor ingresa con tu usuario y contrase??a.' : "Correo dispoonible."
        ];
        
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
