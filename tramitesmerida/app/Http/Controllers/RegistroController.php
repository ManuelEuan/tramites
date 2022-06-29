<?php

namespace App\Http\Controllers;

use App\Cls_Usuario;
use App\Cls_Rol;
use App\Cls_Sucursal;
use App\Cls_Bitacora;
use Exception;
use Illuminate\Http\Request;
use App\Mail\MailService;
use Illuminate\Support\Facades\Mail;
use Mockery\Undefined;

class RegistroController extends Controller
{
    public function agregar(Request $request){
        $response = [];
        $IntUsuarioId = 0;
        try {
            $request->txtRol = Cls_Rol::TRAM_SP_OBTENERROLPORCLAVE("CDNS");
            $request->txtTelefono = "";
            $request->txtExtension = "";
            $request->txtUsuario = "";
            $IntUsuarioId = Cls_Usuario::TRAM_SP_AGREGARUSUARIO($request);
            
            //Agregar sucursales
            foreach ($request->lstSucursal as $value) {
                $ObjSucursal = array(
                    'txtUsuario' => $IntUsuarioId,
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
            
        }
        catch(Exception $e) {
            $response = [
                'codigo' => 400, 
                'status' => "error", 
                'message' => "Ocurrió una excepción, favor de contactar al administrador del sistema , " .$e->getMessage(),
                'data' => $IntUsuarioId
            ];
        }
        
        //Envia correo
		$ObjData['StrNombres'] = $request->txtNombres;
		$ObjData['StrHost'] = $request->getHttpHost();
		$ObjData['StrApellidos'] = $request->txtPrimer_Apellido . " " . $request->txtSegundo_Apellido;;
		$ObjData['StrCorreoElectronico'] = $request->txtCorreo_Electronico;
		$ObjData['StrRFC'] = $request->txtRfc;
		Mail::send('MSTP_MAIL.registro', $ObjData, function ($message) use($ObjData) {
			$message->from('ldavalos@esz.com.mx', 'ldavalos');
			$message->to($ObjData['StrCorreoElectronico'], '')->subject('Registro.');
        });
        
        if($IntUsuarioId > 0){
            //Insertar bitacora
            $ObjBitacora = new Cls_Bitacora();
            $ObjBitacora->BITA_NIDUSUARIO = $IntUsuarioId;
            $ObjBitacora->BITA_CMOVIMIENTO = "Registro";
            $ObjBitacora->BITA_CTABLA = "tram_mst_usuario y tram_mdv_sucursal";
            $ObjBitacora->BITA_CIP = $request->ip();
            Cls_Bitacora::TRAM_SP_AGREGARBITACORA($ObjBitacora);
        }

        $response = [
            'codigo' => $IntUsuarioId > 0 ? 200 : 400, 
            'status' => $IntUsuarioId > 0 ? "success" : "error",
            'message' => $IntUsuarioId > 0 ? '¡Éxito! Acción realizada con éxito.' : "Ocurrió un excepción, favor de contactar al administrador del sistema <<>>",
            'data' => $IntUsuarioId
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
        return Response()->json($response);
    }

    public function localidades($Strlocalidad){
        $url = 'https://vucapacita.chihuahua.gob.mx/api/vw_accede_localidades_municipio/'.$Strlocalidad;
        $options = array(
            'http' => array(
                'method'  => 'GET',
            )
        );

        $context  = stream_context_create($options);
        $result   = file_get_contents($url, false, $context);

        $listTramites = json_decode($result, true);

  
        return Response()->json($listTramites);
    }

}
