<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Cls_Usuario extends Model
{
    protected $connection   = 'pgsql';
    protected $table        = 'tram_mst_usuario';
    static function TRAM_SP_VALIDAR_RFC($StrRfc)
    {
        return count(DB::select(
            'call TRAM_SP_VALIDAR_RFC(?)',
            array(
                $StrRfc
            )
        ));
    }

    static function TRAM_SP_VALIDAR_CORREO($StrCorreo)
    {
        return count(DB::select(
            'call TRAM_SP_VALIDAR_CORREO(?)',
            array(
                $StrCorreo
            )
        ));
    }

    static function getTipoDocs($tipoUser)
    {
        $docsUser = DB::select("SELECT * FROM `tram_mst_configdocumentos` WHERE TIPO_PERSONA = 'AMBAS' OR TIPO_PERSONA = '".$tipoUser."'");
        return $docsUser;
    }

    static function getTipoDocsACT($idUSER, $nombre)
    {
        $docsUser = DB::select("SELECT * FROM `tram_mdv_usuariordocumento` 
        WHERE USDO_NIDUSUARIOBASE = '".$idUSER."' AND USDO_CDOCNOMBRE ='".$nombre."' ");
        
        return $docsUser;
    }
    static function getVigDocsBASE($id)
    {
        $docsUser = DB::select("SELECT VIGENCIA_FIN AS VIG FROM `tram_mst_documentosbase` 
        WHERE id ='".$id."' ORDER BY id DESC LIMIT 0,1");
        
        return $docsUser;
    }

    static function getDocsUser($id){
        $docsUser = DB::select("SELECT * FROM `tram_mst_documentosbase` WHERE ID_USUARIO = $id AND isDelete != 1");
        return $docsUser;
    }
    static function getResolutivosUser($id){
        $resolutivosUser = DB::select("SELECT tmur.USRE_NIDUSUARIOTRAMITE, tmur.USRE_CRUTADOC, tmur.USRE_CEXTENSION, tmur.USRE_NPESO, tmur.created_at, tmt.TRAM_CNOMBRE FROM tram_mdv_usuariotramite AS tmut
        INNER JOIN tram_mdv_usuario_resolutivo AS tmur
        ON tmut.USTR_NIDUSUARIOTRAMITE = tmur.USRE_NIDUSUARIOTRAMITE
        INNER JOIN tram_mst_tramite AS tmt
        ON tmt.TRAM_NIDTRAMITE = tmut.USTR_NIDTRAMITE
        WHERE tmut.USTR_NIDUSUARIO = $id");
        return $resolutivosUser;
    }
    static function TRAM_OBTENER_DOCS($idUser)
    {
        $docsUser = DB::select("SELECT * FROM `tram_mdv_usuariordocumento` WHERE created_at = (SELECT MAX(created_at) FROM tram_mdv_usuariordocumento) and USDO_NIDUSUARIOBASE = $idUser");
        return $docsUser;
    }

    static function TRAM_OBTENER_DOCS_EXPEDIENTE_USER($userID)
    {
        $docsExpedienteUSer = DB::select("SELECT a.*, b.* FROM tram_mst_configdocumentos as a LEFT JOIN tram_mst_documentosbase as b ON a.id = b.ID_CDOCUMENTOS AND B.ID_USUARIO = $userID");
        return $docsExpedienteUSer;
    }

    static function TRAM_SP_VALIDAR_CURP($StrCurp)
    {
        $ObjUser = DB::select("SELECT * FROM tram_mst_usuario WHERE USUA_CCURP = '$StrCurp'");

        return $ObjUser;
    }

    static function TRAM_SP_VALIDAR_CORREO_OBTIENE_ID($StrCorreo)
    {
        $item = null;
        $query = DB::select('call tram_sp_validar_correo(?)', array(
            $StrCorreo
        ));
        $user = json_decode($query[0]->tram_sp_validar_correo);
       
        
        if (!is_null($user)) {
            $item = new Cls_Usuario();
            $item->USUA_NIDUSUARIO       = $user->usua_nidusuario;
            $item->USUA_CNOMBRES         = $user->usua_cnombres;
            $item->USUA_NTIPO_PERSONA    = $user->usua_ntipo_persona;
            $item->USUA_CRAZON_SOCIAL    = $user->usua_crazon_social;
        }
        
        return $item;
    }

    static function TRAM_SP_CONTAR_ACCESO_NO_VALIDO($IntIdUsuario)
    {
        return count(DB::select(
            'call TRAM_SP_CONTAR_ACCESO_NO_VALIDO(?)',
            array(
                $IntIdUsuario
            )
        ));
    }

    static function TRAM_FN_VALIDAR_RECAPTCHA($StrRecaptcha)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('secret' => '6LcDyushAAAAAI6QkUxapLflCgubOe3hfJEDD7pt', 'response' => $StrRecaptcha)));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $arrResponse = json_decode($response, true);

        return $arrResponse;
    }

    static function TRAM_SP_LOGIN($StrCorreo, $StrContrasenia)
    {
        $ObjUser = DB::selectOne(
            'call TRAM_SP_LOGIN(?,?)',
            array(
                $StrCorreo, crypt($StrContrasenia, '$1$*$')
            )
        );
        if ($ObjUser == null) {
            $Obj = null;
        } else {
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

    static function TRAM_SP_AGREGARUSUARIO(Request $request)
    {
        return DB::select(
            'call TRAM_SP_AGREGARUSUARIO(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',
            array(
                $request->txtRol, $request->rdbTipo_Persona, $request->txtRfc, $request->txtCurp, $request->rdbSexo, $request->txtRazon_Social ?? '', $request->txtNombres, $request->txtPrimer_Apellido, $request->txtSegundo_Apellido, $request->txtCalle_Fiscal ?? 0, $request->txtNumero_Interior_Fiscal ?? 0, $request->txtNumero_Exterior_Fiscal ?? 0, $request->txtCP_Fiscal ?? 0, $request->cmbColonia_Fiscal ?? 0, 0, $request->cmbMunicipio_Fiscal ?? 0, 0, $request->cmbEstado_Fiscal ?? 0, 0, $request->cmbPais_Fiscal ?? 0, 0, $request->txtCorreo_Electronico, $request->txtCorreo_Alternativo,  crypt($request->txtContrasenia, '$1$*$'), $request->txtCalle_Particular ?? 0, $request->txtNumero_Interior_Particular ?? 0, $request->txtNumero_Exterior_Particular ?? 0, $request->txtCP_Particular ?? 0, $request->cmbColonia_Particular ?? 0, 0, $request->cmbMunicipio_Particular ?? 0, 0, $request->cmbEstado_Particular ?? 0, 0, $request->cmbPais_Particular ?? 0, 0, $request->txtNumeroTelefono ?? 0, $request->txtExtension ?? 0, $request->txtUsuario ?? 0, 0, 0, $request->fechaNacimientoFisica ?? null, $request->txtNumeroTelefono ?? 0, $request->txtNumeroTelefono ?? 0, $request->fechaConstitucionMoral ?? null, $request->nombrePersonaAutorizada, $request->apellidoPrimerAutorizada, $request->apellidoSegundoAutorizada, $request->telefonoPersonaAutorizada ?? 0, $request->telefonoPersonaAutorizada ?? 0, $request->correoPersonaAutorizada
            )
        )[0]->{'LAST_INSERT_ID()'};
    }

    static function TRAM_SP_MODIFICARUSUARIO(Request $request)
    {
        return DB::statement(
            'call TRAM_SP_MODIFICARUSUARIO(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',
            array(
                $request->txtRol, $request->rdbTipo_Persona, $request->txtRfc, $request->txtCurp, $request->rdbSexo, $request->txtRazon_Social, $request->txtNombres, $request->txtPrimer_Apellido, $request->txtSegundo_Apellido, $request->txtCalleFiscal, $request->txtNumeroInteriorFiscal, $request->txtNumeroExteriorFiscal, $request->txtCPFiscal, $request->txtColoniaFiscal, 0,$request->txtMunicipioFiscal, 0,$request->txtEstadoFiscal, 0, $request->txtPaisFiscal, 0, $request->txtCorreo, $request->txtCorreoAlternativo, $request->txtCalleParticular, $request->txtNumeroInteriorParticular, $request->txtNumeroExteriorParticular, $request->txtNumeroCPParticular, $request->txtColoniaParticular,  0, $request->txtMunicipioParticular, 0, $request->txtEstadoParticular, 0,  $request->txtPaisParticular, 0, $request->txtIdUsuario,  $request->txtTelefono, $request->txtExtension, $request->txtUsuario, $request->fechaNacimientoFisica ?? null, $request->fechaConstitucionMoral ?? null, $request->nombrePersonaAutorizada, $request->telefonoPersonaAutorizada ?? 0, $request->correoPersonaAutorizada
            )
        );
    }

    static function TRAM_SP_AGREGAR_ACCESO($IntIdUsuario, $BolAccesoValido)
    {
        return DB::table('tram_dat_acceso')->insert([
            "ACCE_NIDUSUARIO"       => $IntIdUsuario,
            "ACCE_NACCESOVALIDO"    => $BolAccesoValido,
            "ACCE_DFECHAACCESO"     => now(),
        ]);
    }

    static function TRAM_SP_ELIMINAR_ACCESO_NO_VALIDO($IntIdUsuario)
    {
        DB::table('tram_dat_acceso')->where('ACCE_NIDUSUARIO', $IntIdUsuario)->delete();
    }

    static function TRAM_SP_CAMBIAR_CONTRASENA($IntIdUsuario, $StrContrasenia)
    {
        return DB::statement(
            'call TRAM_SP_CAMBIAR_CONTRASENA(?,?)',
            array(
                $IntIdUsuario, crypt($StrContrasenia, '$1$*$')
            )
        );
    }

    static function TRAM_SP_CONSULTAR_USUARIOS()
    {
        return DB::select('CALL TRAM_SP_CONSULTAR_USUARIOS()');
    }

    static function TRAM_SP_AGREGAR_DEPENDENCIA_USUARIO_ACCESO($IntIdDependencia, $IntIdUsuario)
    {
        return DB::statement(
            'call TRAM_SP_AGREGAR_DEPENDENCIA_USUARIO_ACCESO(?,?)',
            array(
                $IntIdDependencia, $IntIdUsuario
            )
        );
    }

    static function TRAM_SP_AGREGAR_DEPENDENCIA_USUARIO_PERTENECE($IntIdDependencia, $IntIdUsuario)
    {
        return DB::statement(
            'call TRAM_SP_AGREGAR_DEPENDENCIA_USUARIO_PERTENECE(?,?)',
            array(
                $IntIdDependencia, $IntIdUsuario
            )
        );
    }

    static function TRAM_SP_AGREGAR_EDIFICIO_USUARIO_ACCESO($IntIdEdificio, $IntIdUsuario)
    {
        return DB::statement(
            'call TRAM_SP_AGREGAR_EDIFICIO_USUARIO_ACCESO(?,?)',
            array(
                $IntIdEdificio, $IntIdUsuario
            )
        );
    }

    static function TRAM_SP_AGREGAR_EDIFICIO_USUARIO_PERTENECE($IntIdEdificio, $IntIdUsuario)
    {
        return DB::statement(
            'call TRAM_SP_AGREGAR_EDIFICIO_USUARIO_PERTENECE(?,?)',
            array(
                $IntIdEdificio, $IntIdUsuario
            )
        );
    }

    static function TRAM_SP_AGREGAR_TRAMITE_USUARIO_ACCESO($IntIdTramite, $IntIdUsuario)
    {
        return DB::statement(
            'call TRAM_SP_AGREGAR_TRAMITE_USUARIO_ACCESO(?,?)',
            array(
                $IntIdTramite, $IntIdUsuario
            )
        );
    }

    static function TRAM_SP_AGREGAR_TRAMITE_USUARIO_PERTENECE($IntIdTramite, $IntIdUsuario)
    {
        return DB::statement(
            'call TRAM_SP_AGREGAR_TRAMITE_USUARIO_PERTENECE(?,?)',
            array(
                $IntIdTramite, $IntIdUsuario
            )
        );
    }

    static function TRAM_SP_AGREGAR_UNIDAD_USUARIO_ACCESO($IntIdUnidad, $IntIdUsuario)
    {
        return DB::statement(
            'call TRAM_SP_AGREGAR_UNIDAD_USUARIO_ACCESO(?,?)',
            array(
                $IntIdUnidad, $IntIdUsuario
            )
        );
    }

    static function TRAM_SP_AGREGAR_UNIDAD_USUARIO_PERTENECE($IntIdUnidad, $IntIdUsuario)
    {
        return DB::statement(
            'call TRAM_SP_AGREGAR_UNIDAD_USUARIO_PERTENECE(?,?)',
            array(
                $IntIdUnidad, $IntIdUsuario
            )
        );
    }

    static function TRAM_SP_ELIMINAR_AREAS_PERTENECE_ACCESO($IntIdUsuario)
    {
        return DB::statement(
            'call TRAM_SP_ELIMINAR_AREAS_PERTENECE_ACCESO(?)',
            array($IntIdUsuario)
        );
    }

    static function TRAM_SP_CONSULTAR_DEPENDENCIA_USUARIO_ACCESO($id){
        return DB::table('tram_aux_dependencia_usuario_acceso')->where('DEPUA_NIDUSUARIO', $id)->get();
    }

    static function TRAM_SP_CONSULTAR_DEPENDENCIA_USUARIO_PERTENECE($id) {
        return DB::table('tram_aux_dependencia_usuario_pertenece')->where('DEPUP_NIDUSUARIO', $id)->get();
    }

    static function TRAM_SP_CONSULTAR_EDIFICIO_USUARIO_ACCESO($id){
        return DB::table('tram_aux_edificio_usuario_acceso')->where('EDIFUA_NIDUSUARIO', $id)->get();
    }

    static function TRAM_SP_CONSULTAR_EDIFICIO_USUARIO_PERTENECE($id){
        return DB::table('tram_aux_edificio_usuario_pertenece')->where('EDIFUP_NIDUSUARIO', $id)->get();
    }

    static function TRAM_SP_CONSULTAR_TRAMITE_USUARIO_ACCESO($id)
    {
        return DB::table('tram_aux_tramite_usuario_acceso as a')
                    ->join('accede_lista_tramites as b', 'a.TRAMUA_NIDTRAMITE', '=', 'b.ID_TRAM')
                    ->where('TRAMUA_NIDUSUARIO', $id)
                    ->select('a.*', 'b.TRAMITE as TRAMUA_CNOMBRE', 'b.ID_UNIDAD')->get();
    }

    static function CONSULTAR_TRAMITE_USUARIO_ACCESO($id) {
        return DB::table('tram_aux_tramite_usuario_acceso')->where('TRAMUA_NIDUSUARIO', $id)->get();
    }

    static function TRAM_SP_CONSULTAR_TRAMITE_USUARIO_PERTENECE($id)
    { 
        return DB::table('tram_aux_tramite_usuario_pertenece as a')
                    ->join('accede_lista_tramites as b', 'a.TRAMUP_NIDTRAMITE', '=', 'b.ID_TRAM')
                    ->where('TRAMUP_NIDUSUARIO', $id)
                    ->select('a.*','b.TRAMITE as TRAMUP_CNOMBRE', 'b.ID_UNIDAD')->get();
    }

    static function CONSULTAR_TRAMITE_USUARIO_PERTENECE($id) {
        return DB::table('tram_aux_tramite_usuario_pertenece')->where('TRAMUP_NIDUSUARIO', $id)->get();
    }

    static function TRAM_SP_CONSULTAR_UNIDAD_USUARIO_ACCESO($id){
        return DB::table('tram_aux_unidad_usuario_acceso')->where('UNIDUA_NIDUSUARIO', $id)->get();
    }

    static function TRAM_SP_CONSULTAR_UNIDAD_USUARIO_PERTENECE($id){
        return DB::table('tram_aux_unidad_usuario_pertenece')->where('UNIDUP_NIDUSUARIO', $id)->get();
    }


    static function getUnidadPertenece($usuarioId) {
       $registros = DB::table('tram_aux_unidad_usuario_pertenece')
                        ->select('UNIDUP_NIDUNIDAD', 'UNIDUP_NIDUSUARIO')
                        ->where('UNIDUP_NIDUSUARIO', $usuarioId)
                        ->groupBy('UNIDUP_NIDUNIDAD', 'UNIDUP_NIDUSUARIO')
                        ->get();
        return $registros;
    }

    static function getUnidadAcceso($usuarioId) {
        $registros = DB::table('tram_aux_unidad_usuario_acceso')
                         ->select('UNIDUA_NIDUNIDAD', 'UNIDUA_NIDUSUARIO')
                         ->where('UNIDUA_NIDUSUARIO', $usuarioId)
                         ->groupBy('UNIDUA_NIDUNIDAD', 'UNIDUA_NIDUSUARIO')
                         ->get();
         return $registros;
     }

    static function TRAM_SP_OBTENER_USUARIO($id)
    {
        return DB::table('tram_mst_usuario as u')
            ->leftJoin('tram_cat_rol as r','u.USUA_NIDROL', '=', 'r.ROL_NIDROL')
            ->where('u.USUA_NIDUSUARIO', $id)
            ->select('u.*', 'r.ROL_CNOMBRE')->first();
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
    static function updateVigencia($id_documento, $vigencia)
    {
        $actualizar = DB::update('update tram_mst_documentosbase as tmd
            inner join tram_mdv_usuariordocumento as tmu
            on tmu.idDocExpediente = tmd.ID_CDOCUMENTOS
            set tmd.VIGENCIA_FIN = ?
            where tmu.USDO_NIDTRAMITEDOCUMENTO = ? and tmd.isActual = 1
        ', [ $vigencia, $id_documento]);
    }
    static function guardarDocs($request, $idU, $nombre){
        $hoy = date('Y-m-d');
        $hoytime = date('Y-m-d H:i:s');

        $actualizar = DB::update('update tram_mst_documentosbase set isActual = 0 where ID_CDOCUMENTOS = ?', [$request->tipo]);

        $insert = DB::insert('insert into tram_mst_documentosbase (FORMATO, PESO, VIGENCIA_INICIO, VIGENCIA_FIN, ID_CDOCUMENTOS, 
        ID_USUARIO, estatus, ruta, isDelete, isActual, create_at) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
        [
            $request->formato,
            $request->peso,
            $hoy,
            '',
            $request->tipo,
            $idU,
            1,
            'files/documentosUser/'.$idU.'/'.$nombre,
            0,
            1,
            $hoytime
        ]);

        return $insert;
    }
    static function eliminarDoc($id){
        $delete = DB::update('UPDATE tram_mst_documentosbase SET isDelete = 1 WHERE id = ?',[$id->id]);
        return $delete;
    }
    static function getHistoryDocs($user){
        $getH = DB::select('SELECT * FROM tram_mdv_usuariordocumento WHERE USDO_NIDUSUARIOBASE = ?',[$user]);
        return $getH;
    }
    static function getHistoryExpe($id, $user)
    {
        $getH = DB::select('SELECT * FROM tram_mst_documentosbase WHERE ID_CDOCUMENTOS = ? AND ID_USUARIO = ?', [$id, $user]);
        return $getH;
    }

    static function getEXPtram($TIPO, $idUSER)
    {//
        //FORMATO DE EXPEDIENTE tram_mdv_documento_tramite
        //ARRAY PARA IGUALAR ESTATUS 
        //$ESTATUS_TRAM = array('0' => 1, '1' => '2', '2' => '3');
//AND BASE.ID_CDOCUMENTOS=CONFIG.id 
//LEFT JOIN tram_mst_configdocumentos AS CONFIG 
        $docsUser = DB::select("SELECT BASE.*, 'expediente' AS  TIPO
        FROM tram_mst_documentosbase AS BASE 
        WHERE  ID_CDOCUMENTOS = ? AND ID_USUARIO = ? 
        UNION
        SELECT  TRAM.USDO_NIDUSUARIORESP AS id, TRAM.USDO_CEXTENSION AS FORMATO, TRAM.USDO_NPESO AS PESO, 
        '' AS VIGENCIA_INICIO, '' AS VIGENCIA_FIN, TRAM.idDocExpediente AS ID_CDOCUMENTOS, 
		  TRAM.USDO_NIDUSUARIOBASE AS ID_USUARIO, 
        TRAM.created_at AS create_at, TRAM.updated_at AS update_at, '0' AS isDelete, 
        TRAM.USDO_NESTATUS AS estatus, TRAM.USDO_CRUTADOC AS ruta, '0' AS isActual, 'tramite' AS  TIPO 
        FROM tram_mdv_usuariordocumento AS TRAM  
        WHERE TRAM.idDocExpediente = ? AND TRAM.USDO_NIDUSUARIOBASE = ?
         ", [$TIPO, $idUSER, $TIPO, $idUSER]);
        
        return $docsUser;
    }





    static function ActualizarDoc($id){
        $act = DB::update('UPDATE tram_mst_documentosbase SET isActual = 1 WHERE id = ?',[$id->id]);
        return $act;
    }
    static function setActual($id){
        $rspta = DB::update('UPDATE tram_mst_documentosbase SET isActual = 1, isDelete = 0 WHERE id = ?', [$id]);
        $rspta2 = DB::update('UPDATE tram_mst_documentosbase SET isActual = 0, isDelete = 1 WHERE id != ?', [$id]);

        if ($rspta && $rspta2){
            return true;
        } else {
            return false;
        }
    }







}
