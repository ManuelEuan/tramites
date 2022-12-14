<?php

namespace App;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Cls_DocumentosBase;
use Illuminate\Database\Eloquent\Model;

class Cls_Usuario extends Model
{
    protected $connection   = 'pgsql';
    protected $table        = 'tram_mst_usuario';

    static function getTipoDocs($tipoUser){
        return DB::table('tram_mst_configdocumentos')->where('TIPO_PERSONA','AMBAS')->orWhere('TIPO_PERSONA',$tipoUser)->get();
    }


    static function getDocsUser($id){
        return DB::table('tram_mst_documentosbase')->where('ID_USUARIO', $id)->where('isDelete', '!=', true)->get();
    }

    static function getResolutivosUser($id){
        return DB::table('tram_mdv_usuariotramite as ut')
                ->join('tram_mdv_usuario_resolutivo as ur', 'ut.USTR_NIDUSUARIOTRAMITE', '=', 'ur.USRE_NIDUSUARIOTRAMITE')
                ->join('tram_mst_tramite as t', 't.TRAM_NIDTRAMITE', '=', 'ut.USTR_NIDTRAMITE')
                ->select('ur.USRE_NIDUSUARIOTRAMITE', 'ur.USRE_CRUTADOC', 'ur.USRE_CEXTENSION', 'ur.USRE_NPESO', 'ur.created_at', 't.TRAM_CNOMBRE')
                ->where('ut.USTR_NIDUSUARIO', $id)->get();
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

    static function TRAM_SP_AGREGAR_DEPENDENCIA_USUARIO_ACCESO($IntIdDependencia, $IntIdUsuario)
    {
        return DB::table('tram_aux_dependencia_usuario_acceso')->insert([
            'DEPUA_NIDDEPENCIA' => $IntIdDependencia,
            'DEPUA_NIDUSUARIO'  => $IntIdUsuario
        ]);
    }

    static function TRAM_SP_AGREGAR_DEPENDENCIA_USUARIO_PERTENECE($dependeciaId, $usuarioId)
    {
        return DB::table('tram_aux_dependencia_usuario_pertenece')->insert([
            'DEPUP_NIDDEPENCIA' => $dependeciaId,
            'DEPUP_NIDUSUARIO'  => $usuarioId
        ]);
    }

    static function TRAM_SP_AGREGAR_EDIFICIO_USUARIO_ACCESO($IntIdEdificio, $IntIdUsuario)
    {
        return  DB::table('tram_aux_edificio_usuario_acceso')->insert([
                    'EDIFUA_NIDEDIFICIO'    => $IntIdEdificio,
                    'EDIFUA_NIDUSUARIO'     => $IntIdUsuario
                ]);
    }

    static function TRAM_SP_AGREGAR_EDIFICIO_USUARIO_PERTENECE($IntIdEdificio, $IntIdUsuario)
    {
        return  DB::table('tram_aux_edificio_usuario_pertenece')->insert([
            'EDIFUP_NIDEDIFICIO' => $IntIdEdificio,
            'EDIFUP_NIDUSUARIO'  => $IntIdUsuario
        ]);
    }

    static function TRAM_SP_AGREGAR_TRAMITE_USUARIO_ACCESO($IntIdTramite, $IntIdUsuario)
    {
        return DB::table('tram_aux_tramite_usuario_acceso')->insert([
                    'TRAMUA_NIDTRAMITE' => $IntIdTramite,
                    'TRAMUA_NIDUSUARIO' => $IntIdUsuario
                ]);
    }

    static function TRAM_SP_AGREGAR_TRAMITE_USUARIO_PERTENECE($IntIdTramite, $IntIdUsuario)
    {
        return DB::table('tram_aux_tramite_usuario_pertenece')->insert([
                    'TRAMUP_NIDTRAMITE' => $IntIdTramite,
                    'TRAMUP_NIDUSUARIO' => $IntIdUsuario
                ]);
    }

    static function TRAM_SP_AGREGAR_UNIDAD_USUARIO_ACCESO($IntIdUnidad, $IntIdUsuario)
    {
        return DB::table('tram_aux_unidad_usuario_acceso')->insert([
                            'UNIDUA_NIDUNIDAD'  => $IntIdUnidad,
                            'UNIDUA_NIDUSUARIO' => $IntIdUsuario
                ]);
    }

    static function TRAM_SP_AGREGAR_UNIDAD_USUARIO_PERTENECE($IntIdUnidad, $IntIdUsuario)
    {
        return DB::table('tram_aux_unidad_usuario_pertenece')->insert([
                            'UNIDUP_NIDUNIDAD'  => $IntIdUnidad,
                            'UNIDUP_NIDUSUARIO' => $IntIdUsuario
        ]);
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

    static function guardarDocs($request, $idU, $archivo){
        Cls_DocumentosBase::where(['ID_CDOCUMENTOS' => $request->tipo, 'ID_USUARIO' => $idU])->update(['isActual' => false , 'update_at' => now()]);
        $item = new Cls_DocumentosBase();
        $item->FORMATO          = $archivo['extension'];
        $item->PESO             = $archivo['size'];
        $item->VIGENCIA_INICIO  = date('Y-m-d');
        $item->VIGENCIA_FIN     = '';
        $item->ID_CDOCUMENTOS   = $request->tipo;
        $item->ID_USUARIO       = $idU;
        $item->isDelete         = false;
        $item->estatus          = 1;
        $item->ruta             = $archivo['path'];
        $item->isActual         = true;
        $item->create_at        = now();
        $item->update_at        = now();
        $item->save();
        return $item;
    }

    static function getHistoryDocs($user){
        return DB::table('tram_mdv_usuariordocumento')->where('USDO_NIDUSUARIOBASE', $user)->get();
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
