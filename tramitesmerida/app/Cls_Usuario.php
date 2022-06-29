<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use App\Cls_Rol;
use App\Cls_Bloqueo;
use App\Cls_Sucursal;

class Cls_Usuario extends Model
{
    protected $table = 'tram_mst_usuario';
    static function TRAM_SP_VALIDAR_RFC($StrRfc){
        return count(DB::select('call TRAM_SP_VALIDAR_RFC(?)'
                , array($StrRfc
                )
            ));
    }

    static function TRAM_SP_VALIDAR_CORREO($StrCorreo){
        return count(DB::select('call TRAM_SP_VALIDAR_CORREO(?)'
                , array($StrCorreo
                )
            ));
    }

    static function TRAM_SP_VALIDAR_CORREO_OBTIENE_ID($StrCorreo){
        $ObjUser = DB::selectOne('call TRAM_SP_VALIDAR_CORREO(?)'
                , array($StrCorreo
                )
            );
        if($ObjUser == null){
            $Obj = null;
        }else {
            $Obj = new Cls_Usuario();
            $Obj->USUA_NIDUSUARIO = $ObjUser->USUA_NIDUSUARIO;
            $Obj->USUA_CNOMBRES = $ObjUser->USUA_CNOMBRES;
            $Obj->USUA_NTIPO_PERSONA = $ObjUser->USUA_NTIPO_PERSONA;
            $Obj->USUA_CRAZON_SOCIAL = $ObjUser->USUA_CRAZON_SOCIAL;
        }
        return $Obj;
    }

    static function TRAM_SP_CONTAR_ACCESO_NO_VALIDO($IntIdUsuario){
        return count(DB::select('call TRAM_SP_CONTAR_ACCESO_NO_VALIDO(?)'
                , array($IntIdUsuario
                )
            ));
    }
    
    static function TRAM_FN_VALIDAR_RECAPTCHA($StrRecaptcha){
        $ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,"https://www.google.com/recaptcha/api/siteverify");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('secret' => '6LfWCPUZAAAAAODebYm56T2sttXscE5c8LdOudL4', 'response' => $StrRecaptcha)));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		curl_close($ch);
        $arrResponse = json_decode($response, true);
        
        return $arrResponse;
    }
    
    static function TRAM_SP_LOGIN($StrCorreo, $StrContrasenia){
        $ObjUser = DB::selectOne('call TRAM_SP_LOGIN(?,?)'
                , array($StrCorreo
                , crypt($StrContrasenia, '$1$*$')
                )
            );
        if($ObjUser == null){
            $Obj = null;
        }else {
            $Obj = new Cls_Usuario();
            $Obj->USUA_NIDUSUARIO = $ObjUser->USUA_NIDUSUARIO;
            $Obj->USUA_CNOMBRES = $ObjUser->USUA_CNOMBRES;
            $Obj->USUA_CPRIMER_APELLIDO = $ObjUser->USUA_CPRIMER_APELLIDO;
            $Obj->USUA_CSEGUNDO_APELLIDO = $ObjUser->USUA_CSEGUNDO_APELLIDO;
            $Obj->USUA_CRFC = $ObjUser->USUA_CRFC;
            $Obj->USUA_CCORREO_ELECTRONICO = $ObjUser->USUA_CCORREO_ELECTRONICO;
            $Obj->USUA_NACTIVO = $ObjUser->USUA_NACTIVO;
        }
        return $Obj;
    }

    static function TRAM_SP_AGREGARUSUARIO(Request $request){
        return DB::select('call TRAM_SP_AGREGARUSUARIO(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'
                , array($request->txtRol
                , $request->rdbTipo_Persona
                , $request->txtRfc
                , $request->txtCurp
                , $request->rdbSexo
                , $request->txtRazon_Social
                , $request->txtNombres
                , $request->txtPrimer_Apellido
                , $request->txtSegundo_Apellido
                , $request->txtCalle_Fiscal ?? 0
                , $request->txtNumero_Interior_Fiscal
                , $request->txtNumero_Exterior_Fiscal ?? 0
                , $request->txtCP_Fiscal ?? 0
                , $request->cmbColonia_Fiscal ?? 0
                , 0
                , $request->cmbMunicipio_Fiscal ?? 0
                , 0
                , $request->cmbEstado_Fiscal ?? 0
                , 0
                , $request->cmbPais_Fiscal ?? 0
                , 0
                , $request->txtCorreo_Electronico
                , $request->txtCorreo_Alternativo
                ,  crypt($request->txtContrasenia, '$1$*$')
                , $request->txtCalle_Particular
                , $request->txtNumero_Interior_Particular
                , $request->txtNumero_Exterior_Particular
                , $request->txtCP_Particular
                , $request->cmbColonia_Particular
                , 0
                , $request->cmbMunicipio_Particular
                , 0
                , $request->cmbEstado_Particular
                , 0
                , $request->cmbPais_Particular
                , 0
                , $request->txtTelefono
                , $request->txtExtension
                , $request->txtUsuario
                , 0
                ))[0]->{'LAST_INSERT_ID()'};
    }

    static function TRAM_SP_MODIFICARUSUARIO(Request $request){

        return DB::statement('call TRAM_SP_MODIFICARUSUARIO(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'
                , array($request->txtRol
                , $request->rdbTipo_Persona
                , $request->txtRfc
                , $request->txtCurp
                , $request->rdbSexo
                , $request->txtRazon_Social
                , $request->txtNombres
                , $request->txtPrimer_Apellido
                , $request->txtSegundo_Apellido
                , $request->txtCalle_Fiscal
                , $request->txtNumero_Interior_Fiscal
                , $request->txtNumero_Exterior_Fiscal
                , $request->txtCP_Fiscal
                , $request->cmbColonia_Fiscal
                , 0
                , $request->cmbMunicipio_Fiscal
                , 0
                , $request->cmbEstado_Fiscal
                , 0
                , $request->cmbPais_Fiscal
                , 0
                , $request->txtCorreo_Electronico
                , $request->txtCorreo_Alternativo
                , $request->txtCalle_Particular
                , $request->txtNumero_Interior_Particular
                , $request->txtNumero_Exterior_Particular
                , $request->txtCP_Particular
                , $request->cmbColonia_Particular
                , 0
                , $request->cmbMunicipio_Particular
                , 0
                , $request->cmbEstado_Particular
                , 0
                , $request->cmbPais_Particular
                , 0
                , $request->txtIdUsuario
                , $request->txtTelefono
                , $request->txtExtension
                , $request->txtUsuario
                ));
    }
    
    static function TRAM_SP_AGREGAR_ACCESO($IntIdUsuario, $BolAccesoValido){
        return DB::statement('call TRAM_SP_AGREGAR_ACCESO(?,?)'
                , array($IntIdUsuario
                , $BolAccesoValido));
    }

    static function TRAM_SP_ELIMINAR_ACCESO_NO_VALIDO($IntIdUsuario){
        return DB::statement('call TRAM_SP_ELIMINAR_ACCESO_NO_VALIDO(?)'
                , array($IntIdUsuario));
    }

    static function TRAM_SP_CAMBIAR_CONTRASENA($IntIdUsuario, $StrContrasenia){
        return DB::statement('call TRAM_SP_CAMBIAR_CONTRASENA(?,?)'
                , array($IntIdUsuario
                , crypt($StrContrasenia, '$1$*$')));
    }
    
    static function TRAM_SP_CONSULTAR_USUARIOS()
    {
        return DB::select('CALL TRAM_SP_CONSULTAR_USUARIOS()');
    }

    static function TRAM_SP_AGREGAR_DEPENDENCIA_USUARIO_ACCESO($IntIdDependencia, $IntIdUsuario){
        return DB::statement('call TRAM_SP_AGREGAR_DEPENDENCIA_USUARIO_ACCESO(?,?)'
                , array($IntIdDependencia
                , $IntIdUsuario));
    }

    static function TRAM_SP_AGREGAR_DEPENDENCIA_USUARIO_PERTENECE($IntIdDependencia, $IntIdUsuario){
        return DB::statement('call TRAM_SP_AGREGAR_DEPENDENCIA_USUARIO_PERTENECE(?,?)'
                , array($IntIdDependencia
                , $IntIdUsuario));
    }

    static function TRAM_SP_AGREGAR_EDIFICIO_USUARIO_ACCESO($IntIdEdificio, $IntIdUsuario){
        return DB::statement('call TRAM_SP_AGREGAR_EDIFICIO_USUARIO_ACCESO(?,?)'
                , array($IntIdEdificio
                , $IntIdUsuario));
    }

    static function TRAM_SP_AGREGAR_EDIFICIO_USUARIO_PERTENECE($IntIdEdificio, $IntIdUsuario){
        return DB::statement('call TRAM_SP_AGREGAR_EDIFICIO_USUARIO_PERTENECE(?,?)'
                , array($IntIdEdificio
                , $IntIdUsuario));
    }

    static function TRAM_SP_AGREGAR_TRAMITE_USUARIO_ACCESO($IntIdTramite, $IntIdUsuario){
        return DB::statement('call TRAM_SP_AGREGAR_TRAMITE_USUARIO_ACCESO(?,?)'
                , array($IntIdTramite
                , $IntIdUsuario));
    }
    
    static function TRAM_SP_AGREGAR_TRAMITE_USUARIO_PERTENECE($IntIdTramite, $IntIdUsuario){
        return DB::statement('call TRAM_SP_AGREGAR_TRAMITE_USUARIO_PERTENECE(?,?)'
                , array($IntIdTramite
                , $IntIdUsuario));
    }

    static function TRAM_SP_AGREGAR_UNIDAD_USUARIO_ACCESO($IntIdUnidad, $IntIdUsuario){
        return DB::statement('call TRAM_SP_AGREGAR_UNIDAD_USUARIO_ACCESO(?,?)'
                , array($IntIdUnidad
                , $IntIdUsuario));
    }

    static function TRAM_SP_AGREGAR_UNIDAD_USUARIO_PERTENECE($IntIdUnidad, $IntIdUsuario){
        return DB::statement('call TRAM_SP_AGREGAR_UNIDAD_USUARIO_PERTENECE(?,?)'
                , array($IntIdUnidad
                , $IntIdUsuario));
    }

    static function TRAM_SP_ELIMINAR_AREAS_PERTENECE_ACCESO($IntIdUsuario){
        return DB::statement('call TRAM_SP_ELIMINAR_AREAS_PERTENECE_ACCESO(?)'
                , array($IntIdUsuario));
    }

    static function TRAM_SP_CONSULTAR_DEPENDENCIA_USUARIO_ACCESO($IntIdUsuario){
        return DB::select('call TRAM_SP_CONSULTAR_DEPENDENCIA_USUARIO_ACCESO(?)'
        , array($IntIdUsuario));
    }

    static function TRAM_SP_CONSULTAR_DEPENDENCIA_USUARIO_PERTENECE($IntIdUsuario){
        return DB::select('call TRAM_SP_CONSULTAR_DEPENDENCIA_USUARIO_PERTENECE(?)'
        , array($IntIdUsuario));
    }

    static function TRAM_SP_CONSULTAR_EDIFICIO_USUARIO_ACCESO($IntIdUsuario){
        return DB::select('call TRAM_SP_CONSULTAR_EDIFICIO_USUARIO_ACCESO(?)'
        , array($IntIdUsuario));
    }

    static function TRAM_SP_CONSULTAR_EDIFICIO_USUARIO_PERTENECE($IntIdUsuario){
        return DB::select('call TRAM_SP_CONSULTAR_EDIFICIO_USUARIO_PERTENECE(?)'
        , array($IntIdUsuario));
    }

    static function TRAM_SP_CONSULTAR_TRAMITE_USUARIO_ACCESO($IntIdUsuario){
        return DB::select('call TRAM_SP_CONSULTAR_TRAMITE_USUARIO_ACCESO(?)'
        , array($IntIdUsuario));
    }

    static function TRAM_SP_CONSULTAR_TRAMITE_USUARIO_PERTENECE($IntIdUsuario){
        return DB::select('call TRAM_SP_CONSULTAR_TRAMITE_USUARIO_PERTENECE(?)'
        , array($IntIdUsuario));
    }

    static function TRAM_SP_CONSULTAR_UNIDAD_USUARIO_ACCESO($IntIdUsuario){
        return DB::select('call TRAM_SP_CONSULTAR_UNIDAD_USUARIO_ACCESO(?)'
        , array($IntIdUsuario));
    }

    static function TRAM_SP_CONSULTAR_UNIDAD_USUARIO_PERTENECE($IntIdUsuario){
        return DB::select('call TRAM_SP_CONSULTAR_UNIDAD_USUARIO_PERTENECE(?)'
        , array($IntIdUsuario));
    }

    static function TRAM_SP_OBTENER_USUARIO($IntIdUsuario){
        $Obj = DB::selectOne('call TRAM_SP_OBTENER_USUARIO(?)'
                , array($IntIdUsuario
                )
            );
        return $Obj;
    }
    
    /* */
    
    public function TRAM_CAT_ROL()
    {
        //forean key, primay key
        return $this->belongsTo('App\Cls_Rol', 'USUA_NIDROL', 'ROL_NIDROL');
    }
    
    public function TRAM_MDV_SUCURSAL()
    {
        return $this->hasMany('App\Cls_Sucursal', 'SUCU_NIDUSUARIO', 'USUA_NIDUSUARIO');
    }
}
