<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
Use App\Cls_Usuario;
use App\Cls_Bloqueo;
use App\Cls_Bitacora;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
	use AuthenticatesUsers;
	public $maxAttempts = 2;

    public function index() {
		if(is_null(Auth::user()))
			return view('MSTP_LOGIN.index');
		else {
			switch(Auth::user()->TRAM_CAT_ROL->ROL_CCLAVE){
				case "CDNS"	: return redirect('/tramite_servicio'); break;
				case "ADM"	: return redirect('/gestores'); break;
				default		: return redirect('/gestores'); break;
			}
		}
	}

	//Login
	public function login(Request $request) {
		$validator = Validator::make($request->all(), [
			'Usuario' => 'required',
			'Contraseña' => 'required',
		]);

		if($request->txtUsuario == "" || $request->txtUsuario == null ){
			$validator->after(function($validator) {
				$validator->errors()->add('credenciales', ' El campo Usuario es requerido.');
			});
			return Redirect::back()->withErrors($validator);
		}
		else{
			//Valida reRECAPTCHA
			/* $ArrRecaptcha = Cls_Usuario::TRAM_FN_VALIDAR_RECAPTCHA($request['g-recaptcha-response']);
			if($ArrRecaptcha["success"] != '1') {
			 	$validator->after(function($validator){
			 		$validator->errors()->add('recaptcha', ' El campo No soy un robot es requerido.');
			 	}); 
			 	return Redirect::back()->withErrors($validator);
			} */

			$user = User::where('USUA_CCORREO_ELECTRONICO', $request->txtUsuario)->orWhere('USUA_CCORREO_ALTERNATIVO', $request->txtUsuario)->first();
			if(!is_null($user)){
				if(is_null($user->email_verified_at)){
					$validator->errors()->add('verificacion', ' Estimado usuario, su cuenta no se ha verificado, favor de verificar.');
					return Redirect::back()->withErrors($validator);
				}

				$bloqueo = Cls_Bloqueo::where('BLUS_NIDUSUARIO', $user->USUA_NIDUSUARIO)->first();
				if(!is_null($bloqueo)){
					if($bloqueo->BLUS_NBLOQUEADO == 1){
						$validator->after(function($validator) {
							$validator->errors()->add('bloqueado', ' Estimado usuario, su cuenta se encuentra bloqueado temporalmente, favor de restablecer su contraseña.');
						});
						return Redirect::back()->withErrors($validator);
					}
				}
			}

			if(!is_null($user)){
				$pass = $user->USUA_CCONTRASENIA == crypt($request->txtContrasenia, '$1$*$') ? $user : null;

				if(is_null($pass)) {
					if(!is_null($user)){
						Cls_Usuario::TRAM_SP_AGREGAR_ACCESO($user->USUA_NIDUSUARIO, false);
						$ObjBitacora = new Cls_Bitacora();
						$ObjBitacora->BITA_NIDUSUARIO	= $user->USUA_NIDUSUARIO;
						$ObjBitacora->BITA_CMOVIMIENTO 	= "Acceso fallido";
						$ObjBitacora->BITA_CTABLA 		= "tram_mst_usuario";
						$ObjBitacora->BITA_CIP 			= $request->ip();
						$ObjBitacora->BITA_FECHAMOVIMIENTO = now();
						$ObjBitacora->save();
						
						//Validar si el usuario ya supero el limite de intentos
						/* SE comenta el bloqueo de las cuentas de correo 
						if(Cls_Usuario::TRAM_SP_CONTAR_ACCESO_NO_VALIDO($IntIdUsuario->USUA_NIDUSUARIO) == 5){
							//Insertar en la tabla de bloqueo
							Cls_Bloqueo::TRAM_SP_AGREGAR_BLOQUEO($IntIdUsuario->USUA_NIDUSUARIO, true, encrypt($IntIdUsuario->USUA_NIDUSUARIO));

							//Insertar bitacora
							$ObjBitacora = new Cls_Bitacora();
							$ObjBitacora->BITA_NIDUSUARIO = $IntIdUsuario->USUA_NIDUSUARIO;
							$ObjBitacora->BITA_CMOVIMIENTO = "Cuenta bloqueada";
							$ObjBitacora->BITA_CTABLA = "tram_dat_bloqueusuario";
							$ObjBitacora->BITA_CIP = $request->ip();
							$ObjBitacora->BITA_FECHAMOVIMIENTO = now();
							$ObjBitacora->save();

							//Retornar respuesta al usuario, que su cuenta fue bloqueado
							$validator->after(function($validator)
							{
								$validator->errors()->add('bloqueado', ' Estimado usuario, su cuenta ha sido bloqueada temporalmente debido al fallo en el intento de ingreso, favor de restablecer su contraseña.');
							});
							return Redirect::back()->withErrors($validator);
						} */
					}
					$validator->after(function($validator) {
						$validator->errors()->add('credenciales', ' La contraseña no es valida, favor de verificarla.');
					});
					return Redirect::back()->withErrors($validator);
				}
			}else{
				$validator->after(function($validator) {
					$validator->errors()->add('credenciales', ' Usuario no registrado, favor de verificar.');
				});
				return Redirect::back()->withErrors($validator);
			}

			if($user->USUA_NACTIVO != null && $user->USUA_NACTIVO == 1){
				$validator->after(function($validator) {
					$validator->errors()->add('bloqueado', 'Usuario bloqueado, favor de contactar al Administrador.');
				});
				return Redirect::back()->withErrors($validator);
			}

			//Insertar acceso validos
			Cls_Usuario::TRAM_SP_AGREGAR_ACCESO($user->USUA_NIDUSUARIO, true);
			Cls_Usuario::TRAM_SP_ELIMINAR_ACCESO_NO_VALIDO($user->USUA_NIDUSUARIO);
			
			//Crea auth
			Auth::loginUsingId($user->USUA_NIDUSUARIO);

			//Insertar bitacora
			$ObjBitacora = new Cls_Bitacora();
			$ObjBitacora->BITA_NIDUSUARIO	= Auth::user()->USUA_NIDUSUARIO;
			$ObjBitacora->BITA_CMOVIMIENTO 	= "Acceso exitoso";
			$ObjBitacora->BITA_CTABLA	 	= "tram_mst_usuario";
			$ObjBitacora->BITA_CIP 			= $request->ip();
			$ObjBitacora->BITA_FECHAMOVIMIENTO = now();
			$ObjBitacora->save();

			Cookie::forever("rol_clave", Auth::user()->TRAM_CAT_ROL->ROL_CCLAVE);
			$ruta 	= session('retys');
			session()->forget('retys');

			switch( Auth::user()->TRAM_CAT_ROL->ROL_CCLAVE){
				case "CDNS":
					if(is_null($ruta))
						return Redirect::to('/tramite_servicio');
					else
						return Redirect::to("/".$ruta);
					break;
				case "ADM":
					return Redirect::to('/gestores');
				default:
					return Redirect::to('/gestores');
					break;
			}
		}
	}

	public function recuperar_contrasena(Request $request){
		$response	= [];
		$StrUrl 	= "";

		try {
			$user = User::where('USUA_CCORREO_ELECTRONICO', $request->txtCorreo_Electronico)
						->orWhere('USUA_CCORREO_ALTERNATIVO', $request->txtCorreo_Electronico)->first();

			if(is_null($user)){
				$response = [
					'codigo'	=> 400,
					'status' 	=> "error",
					'message' 	=> "El usuario no tiene un registro en el sistema, verifique la información"
				];
			}
			else {
				$bloqueo = Cls_Bloqueo::where('BLUS_NIDUSUARIO',$user->USUA_NIDUSUARIO)->first();
				if(!is_null($bloqueo)){
					//Envio de correo con token para recuperar contraseña y desbloquear cuenta
					if($bloqueo->BLUS_NBLOQUEADO == 1){
						$StrUrl = $request->getHttpHost() . "/" . "recuperar_cuenta/" . $bloqueo->BLUS_CTOKEN;

						$ObjData['StrUrl'] 		= $StrUrl;
						$ObjData['StrCorreo'] 	= $request->txtCorreo_Electronico;
						$ObjData['StrUsuario']	= $user->USUA_NTIPO_PERSONA == "FISICA" ? $user->USUA_CNOMBRES : $user->USUA_CRAZON_SOCIAL;

						Mail::send('MSTP_MAIL.recuperar_contrasena', $ObjData, function ($message) use($ObjData) {
							$message->from(env('MAIL_USERNAME'), 'Sistema de Tramites Digitales Queretaro');
							$message->to($ObjData['StrCorreo'], '')->subject('Recuperación de contraseña.');
						});
					}else {
						//Envio de correo id ecriptado, para recuperar contraseña
						$StrToken	= encrypt($user->USUA_NIDUSUARIO);
						$StrUrl 	= $request->getHttpHost() . "/" . "recuperar/" . $StrToken;

						$ObjData['StrUrl'] 		= $StrUrl;
						$ObjData['StrCorreo'] 	= $request->txtCorreo_Electronico;
						$ObjData['StrUsuario'] 	= $user->USUA_NTIPO_PERSONA == "FISICA" ? $user->USUA_CNOMBRES : $user->USUA_CRAZON_SOCIAL;

						Mail::send('MSTP_MAIL.recuperar_contrasena', $ObjData, function ($message) use($ObjData) {
							$message->from(env('MAIL_USERNAME'), 'Sistema de Tramites Digitales Queretaro');
							$message->to($ObjData['StrCorreo'], '')->subject('Recuperación de contraseña.');
						});
					}
				}else {
					//Envio de correo id ecriptado, para recuperar contraseña
					$StrToken	= encrypt($user->USUA_NIDUSUARIO);
					$StrUrl 	= $request->getHttpHost() . "/" . "recuperar/" . $StrToken;

					$ObjData['StrUrl'] 		= $StrUrl;
					$ObjData['StrCorreo'] 	= $request->txtCorreo_Electronico;
					$ObjData['StrUsuario'] 	= $user->USUA_NTIPO_PERSONA == "FISICA" ? $user->USUA_CNOMBRES : $user->USUA_CRAZON_SOCIAL;

					Mail::send('MSTP_MAIL.recuperar_contrasena', $ObjData, function ($message) use($ObjData) {
						$message->from(env('MAIL_USERNAME'), 'Sistema de Tramites Digitales Queretaro');
						$message->to($ObjData['StrCorreo'], '')->subject('Recuperación de contraseña.');
					});
				}

				$response = [
					'codigo' => 200,
					'status' => "success",
					'message' => "Es necesario revisar su correo para recuperar su contraseña."
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

	public function recuperar_cuenta($token){
		$ObjBloqueo = Cls_Bloqueo::where(['BLUS_NBLOQUEADO' => true, 'BLUS_CTOKEN' => $token])->first();
		
		if(is_null($ObjBloqueo))
			return redirect('/logout');
		
		$IntIdUsuario = $ObjBloqueo->BLUS_NIDUSUARIO;
		$IntTipo = 0;//recuperar cuenta y cambiando contraseña
		return view('MST_RECUPERAR_CONTRASENA.index', compact('IntIdUsuario', 'StrToken', 'IntTipo'));
	}

	public function recuperar($StrToken){
		$StrDecrypted = decrypt($StrToken);
		$IntIdUsuario = $StrDecrypted;
		$IntTipo = 1; //recuperar unicamente contraseña
		return view('MST_RECUPERAR_CONTRASENA.index', compact('IntIdUsuario', 'StrToken', 'IntTipo'));
	}

	public function cambiar_contrasena(Request $request){
		$response = ['codigo' => 200, 'status' => "success", 'message' => "Acción realizada con éxito."];
		try {
			$user = User::find($request->txtIntIdUsuario);
			$user->USUA_CCONTRASENIA = crypt($request->txtContrasena_Nueva, '$1$*$');
			$user->save();

			//Insertar bitacora
			$ObjBitacora = new Cls_Bitacora();
			$ObjBitacora->BITA_NIDUSUARIO = $request->txtIntIdUsuario;
			$ObjBitacora->BITA_CMOVIMIENTO = "Cambiar contraseña";
			$ObjBitacora->BITA_CTABLA = "tram_mst_usuario";
			$ObjBitacora->BITA_CIP = $request->ip();
			$ObjBitacora->BITA_FECHAMOVIMIENTO = now();
			$ObjBitacora->save();

			if($request->txtIntTipo == 0){
				Cls_Bloqueo::where('BLUS_CTOKEN',$request->txtStrToken)->update([
					'BLUS_NBLOQUEADO' 		=> 0,
					'BLUS_DFECHADESBLOQUEO' => NOW()
				]);

				//Insertar bitacora
				$ObjBitacora = new Cls_Bitacora();
				$ObjBitacora->BITA_NIDUSUARIO = $request->txtIntIdUsuario;
				$ObjBitacora->BITA_CMOVIMIENTO = "Recuperar contraseña";
				$ObjBitacora->BITA_CTABLA = "tram_mst_usuario y tram_dat_bloqueusuario";
				$ObjBitacora->BITA_CIP = $request->ip();
				$ObjBitacora->BITA_FECHAMOVIMIENTO = now();
				$ObjBitacora->save();
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

	public function logout() {
		session()->forget('consultarPen');
		Auth::logout();
		if(Cookie::has("rol_clave")){
			$rol = Cookie::forget("rol_clave");
			Cookie::queue($rol);
		}
		return view('MSTP_LOGIN.index');
	}


	/**
	 * Verificacion de la cuenta del usuario
	 */
	public function verificacion($id, $token, Request $request){
		$user = User::find($id);
		if(!is_null($user)){
			$user->email_verified_at = now();
			$user->save();
		}
		
		return Redirect::to('/');
    }
}
