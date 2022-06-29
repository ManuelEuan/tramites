<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Cls_Rol;
use App\Cls_Usuario;
use App\Cls_Sucursal;
use App\Cls_Bitacora;
use Exception;

class PerfilController extends Controller
{
    public function index(Request $request)
    {
        $ObjAuth = Auth::user();
		if($ObjAuth == null) {
			return view('MSTP_LOGIN.index');
		}
        return view('MST_PERFIL.index', compact('ObjAuth'));
    }

    public function modificar(Request $request){
        $response = [];
        try {
            //$request->txtRol = Cls_Rol::TRAM_SP_OBTENERROLPORCLAVE("CDNS");
            $request->txtRol = Auth::user()->TRAM_CAT_ROL->ROL_NIDROL; //ROL_NIDROL

            if(Auth::user()->TRAM_CAT_ROL->ROL_CCLAVE == "CDNS")
                $request->txtTelefono = "";
                $request->txtExtension = "";
                $request->txtUsuario = "";

            Cls_Usuario::TRAM_SP_MODIFICARUSUARIO($request);
            
            //Eliminar sucursal actuales
            Cls_Sucursal::TRAM_SP_ELIMINARSUCURSAL_USUARIO($request->txtIdUsuario);
            
            //Agregar sucursales
            foreach ($request->lstSucursal as $value) {
                $ObjSucursal = array(
                    'txtUsuario' => $request->txtIdUsuario,
                    'txtCalle' => $value['txtCalle_Sucursal'],
                    'txtNumero_Interior' => $value['txtNumero_Interior_Sucursal'],
                    'txtNumero_Exterior' => $value['txtNumero_Exterior_Sucursal'],
                    'txtCP' => $value['txtCP_Sucursal'],
                    'cmbColonia' => $value['cmbColonia_Sucursal'],
                    'cmbMunicipio' => $value['cmbMunicipio_Sucursal'],
                    'cmbEstado' => $value['cmbEstado_Sucursal'],
                    'cmbPais' => $value['cmbPais_Sucursal']
                );
                Cls_Sucursal::TRAM_SP_AGREGARSUCURSAL($ObjSucursal);
            }
            
            //Insertar bitacora
            $ObjBitacora = new Cls_Bitacora();
            $ObjBitacora->BITA_NIDUSUARIO = Auth::user()->USUA_NIDUSUARIO;
            $ObjBitacora->BITA_CMOVIMIENTO = "Edición de perfil";
            $ObjBitacora->BITA_CTABLA = Auth::user()->TRAM_CAT_ROL->ROL_CCLAVE != "CDNS" ? "tram_mst_usuario" : "tram_mst_usuario y tram_mdv_sucursal";
            $ObjBitacora->BITA_CIP = $request->ip();
            Cls_Bitacora::TRAM_SP_AGREGARBITACORA($ObjBitacora);
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

    function confirmar(Request $request){
        $response = [];
        $ObjAuth = Auth::user();

        try {
            if($request->txtCorreo_RFC_Electronico !=  $ObjAuth->USUA_CCORREO_ELECTRONICO 
            && $request->txtCorreo_RFC_Electronico != $ObjAuth->USUA_CRFC){
                $response = [
                    'codigo' => 400, 
                    'status' => "error",
                    'message' => "Los datos ingresados no corresponden a los datos del usuario logueado."
                ];
                return Response()->json($response);
            }
            
            if(crypt($request->txtContrasena_Actual, '$1$*$') != $ObjAuth->USUA_CCONTRASENIA){
                $response = [
                    'codigo' => 400, 
                    'status' => "error",
                    'message' => "La contraseña no es válida, favor de verificar."
                ];
                return Response()->json($response);
            }

            if($request->txtCorreo_RFC_Electronico == $ObjAuth->USUA_CCORREO_ELECTRONICO && crypt($request->txtContrasena_Actual, '$1$*$') == $ObjAuth->USUA_CCONTRASENIA
            || $request->txtCorreo_RFC_Electronico == $ObjAuth->USUA_CRFC && crypt($request->txtContrasena_Actual, '$1$*$') == $ObjAuth->USUA_CCONTRASENIA){
                $response = [
                    'codigo' => 200,
                    'status' => "success",
                    'message' => '¡Éxito! Acción realizada con éxito.'
                ];
            }else {
                $response = [
                    'codigo' => 400, 
                    'status' => "error", 
                    'message' => "Los datos ingresados no corresponden a los datos del usuario logueado."
                ];
            }
            
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

    function confirmarServidor(Request $request){
        $response = [];
        $ObjAuth = Auth::user();

        try {
            if($request->txtCorreo_RFC_Electronico !=  $ObjAuth->USUA_CCORREO_ELECTRONICO 
            && $request->txtCorreo_RFC_Electronico != $ObjAuth->USUA_CUSUARIO){
                $response = [
                    'codigo' => 400, 
                    'status' => "error",
                    'message' => "Los datos ingresados no corresponden a los datos del usuario logueado."
                ];
                return Response()->json($response);
            }
            
            if(crypt($request->txtContrasena_Actual, '$1$*$') != $ObjAuth->USUA_CCONTRASENIA){
                $response = [
                    'codigo' => 400, 
                    'status' => "error",
                    'message' => "La contraseña no es válida, favor de verificar."
                ];
                return Response()->json($response);
            }

            if($request->txtCorreo_RFC_Electronico == $ObjAuth->USUA_CCORREO_ELECTRONICO && crypt($request->txtContrasena_Actual, '$1$*$') == $ObjAuth->USUA_CCONTRASENIA
            || $request->txtCorreo_RFC_Electronico == $ObjAuth->USUA_CUSUARIO && crypt($request->txtContrasena_Actual, '$1$*$') == $ObjAuth->USUA_CCONTRASENIA){
                $response = [
                    'codigo' => 200,
                    'status' => "success",
                    'message' => '¡Éxito! Acción realizada con éxito.'
                ];
            }else {
                $response = [
                    'codigo' => 400, 
                    'status' => "error", 
                    'message' => "Los datos ingresados no corresponden a los datos del usuario logueado."
                ];
            }
            
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
