<?php

namespace App\Http\Controllers;

use Exception;
use App\Cls_Bloqueo;
Use App\Cls_Usuario;
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
		//dd($request);
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
			$ArrRecaptcha = Cls_Usuario::TRAM_FN_VALIDAR_RECAPTCHA($request['g-recaptcha-response']);
			if($ArrRecaptcha["success"] != '1') {
			 	$validator->after(function($validator){
			 		$validator->errors()->add('recaptcha', ' El campo No soy un robot es requerido.');
			 	}); 
			 	return Redirect::back()->withErrors($validator);
			}

			//Validamos que al menos el correo sea correcto, de ser así se obtiene el id del usuario e insertamos en la tabla de acesso, con estatus no valido
			$IntIdUsuario = Cls_Usuario::TRAM_SP_VALIDAR_CORREO_OBTIENE_ID($request->txtUsuario);

			//Validar si la cuenta esta bloquedo
			//Validar si encontro un usuario con el correo indicado
			if($IntIdUsuario != null){
				$ObjBloqueo = Cls_Bloqueo::TRAM_SP_VALIDAR_BLOQUEO($IntIdUsuario->USUA_NIDUSUARIO);

				if($ObjBloqueo != null){
					//Retornar respuesta al usuario, que su cuenta esta bloqueado
					if($ObjBloqueo->BLUS_NBLOQUEADO == 1){
						$validator->after(function($validator)
						{
							$validator->errors()->add('bloqueado', ' Estimado usuario, su cuenta se encuentra bloqueado temporalmente, favor de restablecer su contraseña.');
						});
						return Redirect::back()->withErrors($validator);
					}
				}
			}

			if($IntIdUsuario != null){
					//Validar credenciales de acceso
					$ObjUser = Cls_Usuario::TRAM_SP_LOGIN($request->txtUsuario, $request->txtContrasenia);
					//Credenciales invalidas
					if($ObjUser == null) {

						//Validar si encontro un usuario con el correo indicado
						if($IntIdUsuario != null){
							//Insertar acceso invalido
							Cls_Usuario::TRAM_SP_AGREGAR_ACCESO($IntIdUsuario->USUA_NIDUSUARIO, false);

							//Insertar bitacora
							$ObjBitacora = new Cls_Bitacora();
							$ObjBitacora->BITA_NIDUSUARIO = $IntIdUsuario->USUA_NIDUSUARIO;
							$ObjBitacora->BITA_CMOVIMIENTO = "Acceso fallido";
							$ObjBitacora->BITA_CTABLA = "tram_mst_usuario";
							$ObjBitacora->BITA_CIP = $request->ip();
							Cls_Bitacora::TRAM_SP_AGREGARBITACORA($ObjBitacora);

							//Validar si el usuario ya supero el limite de intentos
							if(Cls_Usuario::TRAM_SP_CONTAR_ACCESO_NO_VALIDO($IntIdUsuario->USUA_NIDUSUARIO) == 5){
								//Insertar en la tabla de bloqueo
								Cls_Bloqueo::TRAM_SP_AGREGAR_BLOQUEO($IntIdUsuario->USUA_NIDUSUARIO, true, encrypt($IntIdUsuario->USUA_NIDUSUARIO));

								//Insertar bitacora
								$ObjBitacora = new Cls_Bitacora();
								$ObjBitacora->BITA_NIDUSUARIO = $IntIdUsuario->USUA_NIDUSUARIO;
								$ObjBitacora->BITA_CMOVIMIENTO = "Cuenta bloqueada";
								$ObjBitacora->BITA_CTABLA = "tram_dat_bloqueusuario";
								$ObjBitacora->BITA_CIP = $request->ip();
								Cls_Bitacora::TRAM_SP_AGREGARBITACORA($ObjBitacora);

								//Retornar respuesta al usuario, que su cuenta fue bloqueado
								$validator->after(function($validator)
								{
									$validator->errors()->add('bloqueado', ' Estimado usuario, su cuenta ha sido bloqueada temporalmente debido al fallo en el intento de ingreso, favor de restablecer su contraseña.');
								});
								return Redirect::back()->withErrors($validator);
							}
						}
						$validator->after(function($validator)
							{
								$validator->errors()->add('credenciales', ' La contraseña no es valida, favor de verificarla.');
							});
							return Redirect::back()->withErrors($validator);
					}
			}else{
				$validator->after(function($validator)
				{
					$validator->errors()->add('credenciales', ' Usuario no registrado, favor de verificar.');
				});
				return Redirect::back()->withErrors($validator);
			}

			if($ObjUser->USUA_NACTIVO != null && $ObjUser->USUA_NACTIVO == 1){
				$validator->after(function($validator)
				{
					$validator->errors()->add('bloqueado', 'Usuario bloqueado, favor de contactar al Administrador.');
				});
				return Redirect::back()->withErrors($validator);
			}

			//Insertar acceso validos
			Cls_Usuario::TRAM_SP_AGREGAR_ACCESO($ObjUser->USUA_NIDUSUARIO, true);
			//Eliminar intetos fallidos
			Cls_Usuario::TRAM_SP_ELIMINAR_ACCESO_NO_VALIDO($ObjUser->USUA_NIDUSUARIO);
			//Insertar en la tabla de bloqueo, bloqueo false
			//Cls_Usuario::TRAM_SP_AGREGAR_BLOQUEO($IntIdUsuario->USUA_NIDUSUARIO, false, Uuid::uuid1()->toString());

			//Crea auth
			Auth::loginUsingId($ObjUser->USUA_NIDUSUARIO);

			//Insertar bitacora
			$ObjBitacora = new Cls_Bitacora();
			$ObjBitacora->BITA_NIDUSUARIO = Auth::user()->USUA_NIDUSUARIO;
			$ObjBitacora->BITA_CMOVIMIENTO = "Acceso exitoso";
			$ObjBitacora->BITA_CTABLA = "tram_mst_usuario";
			$ObjBitacora->BITA_CIP = $request->ip();
			Cls_Bitacora::TRAM_SP_AGREGARBITACORA($ObjBitacora);
			Cookie::forever("rol_clave", Auth::user()->TRAM_CAT_ROL->ROL_CCLAVE);
			$ruta 	= session('retys');
			session()->forget('retys');

			/* $getCookie = Cookie::get("rol_clave");
			Cookie::queue($getCookie); */

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

			/* if($cookie){
				Cookie::queue($getCookie);
				switch($cookie->name){
					case "CDNS":
						if(str_ends_with($request->previous_url,"logout")){
							return Redirect::to('/tramite_servicio')->withCookie($cookie);
						}else{
							return Redirect::to($request->previous_url->withCookie($cookie));
						}
						break;
					case "ADM":
						return Redirect::to('/gestores')->withCookie($cookie);
						// dd("admin");
						break;
					default:
						return Redirect::to('/gestores')->withCookie($cookie);
						break;
				}
			} */
		}


	}

	public function recuperar_contrasena(Request $request){
		$response = [];
		$StrUrl = "";

		try {
			$IntIdUsuario = Cls_Usuario::TRAM_SP_VALIDAR_CORREO_OBTIENE_ID($request->txtCorreo_Electronico);
			if($IntIdUsuario == null){
				$response = [
					'codigo' => 400,
					'status' => "error",
					'message' => "El usuario no tiene un registro en el sistema, verifique la información"
				];
			}else {
				$ObjBloqueo = Cls_Bloqueo::TRAM_SP_VALIDAR_BLOQUEO($IntIdUsuario->USUA_NIDUSUARIO);

				if($ObjBloqueo != null){
					//Envio de correo con token para recuperar contraseña y desbloquear cuenta
					if($ObjBloqueo->BLUS_NBLOQUEADO == 1){
						$StrUrl = $request->getHttpHost() . "/" . "recuperar_cuenta/" . $ObjBloqueo->BLUS_CTOKEN;

						$ObjData['StrUrl'] = $StrUrl;
						$ObjData['StrCorreo'] = $request->txtCorreo_Electronico;
						$ObjData['StrUsuario'] = $IntIdUsuario->USUA_NTIPO_PERSONA == "FISICA" ? $IntIdUsuario->USUA_CNOMBRES : $IntIdUsuario->USUA_CRAZON_SOCIAL;

						Mail::send('MSTP_MAIL.recuperar_contrasena', $ObjData, function ($message) use($ObjData) {
							$message->from(env('MAIL_USERNAME'), 'Sistema de Tramites Digitales Queretaro');
							$message->to($ObjData['StrCorreo'], '')->subject('Recuperación de contraseña.');
						});
					}else {
						//Envio de correo id ecriptado, para recuperar contraseña
						$StrToken = encrypt($IntIdUsuario->USUA_NIDUSUARIO);
						$StrUrl = $request->getHttpHost() . "/" . "recuperar/" . $StrToken;

						$ObjData['StrUrl'] = $StrUrl;
						$ObjData['StrCorreo'] = $request->txtCorreo_Electronico;
						$ObjData['StrUsuario'] = $IntIdUsuario->USUA_NTIPO_PERSONA == "FISICA" ? $IntIdUsuario->USUA_CNOMBRES : $IntIdUsuario->USUA_CRAZON_SOCIAL;

						Mail::send('MSTP_MAIL.recuperar_contrasena', $ObjData, function ($message) use($ObjData) {
							$message->from(env('MAIL_USERNAME'), 'Sistema de Tramites Digitales Queretaro');
							$message->to($ObjData['StrCorreo'], '')->subject('Recuperación de contraseña.');
						});
					}
				}else {
					//Envio de correo id ecriptado, para recuperar contraseña
					$StrToken = encrypt($IntIdUsuario->USUA_NIDUSUARIO);
					$StrUrl = $request->getHttpHost() . "/" . "recuperar/" . $StrToken;

					$ObjData['StrUrl'] = $StrUrl;
					$ObjData['StrCorreo'] = $request->txtCorreo_Electronico;
					$ObjData['StrUsuario'] = $IntIdUsuario->USUA_NTIPO_PERSONA == "FISICA" ? $IntIdUsuario->USUA_CNOMBRES : $IntIdUsuario->USUA_CRAZON_SOCIAL;

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

	public function recuperar_cuenta($StrToken){
		$ObjBloqueo = Cls_Bloqueo::TRAM_SP_CONSULTARBLOQUEO($StrToken);
		if($ObjBloqueo == null){
			return redirect('/logout');
		}
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
		$response = [];
		try {
			Cls_Usuario::TRAM_SP_CAMBIAR_CONTRASENA($request->txtIntIdUsuario, $request->txtContrasena_Nueva);

			//Insertar bitacora
			$ObjBitacora = new Cls_Bitacora();
			$ObjBitacora->BITA_NIDUSUARIO = $request->txtIntIdUsuario;
			$ObjBitacora->BITA_CMOVIMIENTO = "Cambiar contraseña";
			$ObjBitacora->BITA_CTABLA = "tram_mst_usuario";
			$ObjBitacora->BITA_CIP = $request->ip();
			Cls_Bitacora::TRAM_SP_AGREGARBITACORA($ObjBitacora);

			if($request->txtIntTipo == 0){
				Cls_Bloqueo::TRAM_SP_DESBLOQUEAR($request->txtStrToken);

				//Insertar bitacora
				$ObjBitacora = new Cls_Bitacora();
				$ObjBitacora->BITA_NIDUSUARIO = $request->txtIntIdUsuario;
				$ObjBitacora->BITA_CMOVIMIENTO = "Recuperar contraseña";
				$ObjBitacora->BITA_CTABLA = "tram_mst_usuario y tram_dat_bloqueusuario";
				$ObjBitacora->BITA_CIP = $request->ip();
				Cls_Bitacora::TRAM_SP_AGREGARBITACORA($ObjBitacora);
			}
			$response = [
				'codigo' => 400,
				'status' => "success",
				'message' => "Acción realizada con éxito."
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

	public function logout() {
		Auth::logout();
		if(Cookie::has("rol_clave")){
			$rol = Cookie::forget("rol_clave");
			Cookie::queue($rol);
		}
		return view('MSTP_LOGIN.index');
	}
}
