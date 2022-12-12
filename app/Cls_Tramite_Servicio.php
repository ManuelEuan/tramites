<?php

namespace App;

use stdClass;
use Exception;
use Illuminate\Http\Request;
use App\Cls_Notificacion_Tramite;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Cls_Tramite_Servicio extends Model
{
    protected $connection = 'mysql';
    protected $table = 'tram_mst_tramite';

    //Atributos para filtro
    public $StrTexto;
    public $IntDependencia;
    public $IntModalidad;
    public $IntClasificacion;
    public $StrAudiencia;
    public $IntNumPagina;
    public $IntCantidadRegistros;
    public $StrOrdenColumna;
    public $StrOrdenDir;
    public $IntUsuarioId;

    //Atributos para tramite
    public $TRAM_NIDTRAMITE;
    public $TRAM_NTIPO;
    public $TRAM_NIDUNIDADADMINISTRATIVA;
    public $TRAM_CNOMBRE;
    public $TRAM_CENCARGADO;
    public $TRAM_CUNIDADADMIN;
    public $TRAM_CCONTACTO;
    public $TRAM_CDESCRIPCION;

    public function TRAM_SP_CONSULTAR_TRAMITE_PUBLICO()
    {
        $sql = "call TRAM_SP_CONSULTAR_TRAMITE_PUBLICO('$this->StrTexto', '$this->IntDependencia', '$this->IntModalidad',
        '$this->IntClasificacion', '$this->IntNumPagina','$this->IntCantidadRegistros', '$this->StrOrdenColumna',
        '$this->StrOrdenDir','$this->IntUsuarioId', '$this->StrAudiencia')";

        $pdo = DB::connection()->getPdo();
        $pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, true);
        $stmt = $pdo->prepare($sql, [\PDO::ATTR_CURSOR => \PDO::CURSOR_SCROLL]);
        $exec = $stmt->execute();

        //Primer resultado
        $first = $stmt->fetchAll(\PDO::FETCH_OBJ);

        //Segundo resultado
        $stmt->nextRowset();
        $second = $stmt->fetchAll(\PDO::FETCH_OBJ);

        $data = [
            'data' => $first,
            'pagination' => $second,
        ];

        return $data;
    }

    public function TRAM_CONSULTAR_DETALLE_TRAMITE($TRAM_NIDTRAMITE_CONFIG){
        return  DB::table(' tram_mst_tramite as a')
                    ->join('tram_mdv_usuariotramite as b', 'a.TRAM_NIDTRAMITE', '=', 'b.USTR_NIDTRAMITE')
                    ->select('a.*','  b.USTR_NESTATUS as TRAM_NESTATUS_PROCESO', 'b.USTR_CFOLIO as TRAM_CFOLIO_SEGUIMIENTO', 'b.USTR_NENCUESTA_CONTESTADA')
                    ->where('a.TRAM_NIDTRAMITE', $TRAM_NIDTRAMITE_CONFIG)->first();
    }

    public function TRAM_CONSULTAR_DETALLE_TRAMITE_SEGUIMIENTO($USTR_NIDUSUARIOTRAMITE){
        return DB::table(' FROM tram_mdv_usuariotramite as a')
                    ->join('tram_mst_tramite as b', 'b.TRAM_NIDTRAMITE', '=', 'a.USTR_NIDTRAMITE')
                    ->where('a.USTR_NIDUSUARIOTRAMITE', $USTR_NIDUSUARIOTRAMITE)
                    ->select('b.*', 'a.*' ,'a.USTR_NESTATUS as TRAM_NESTATUS_PROCESO', 'a.USTR_CFOLIO as TRAM_CFOLIO_SEGUIMIENTO')->first();
    }

    public function TRAM_CONSULTAR_CONFIGURACION_TRAMITE_CONCEPTO($ID_TRAMITE_ACCEDE){
        return DB::table('config_trámites_conceptos')
                 ->select('a.Referencia', 'ID del trámite en ACCEDE')
                 ->where('ID del trámite en ACCEDE', $ID_TRAMITE_ACCEDE)->first();
    }


    public function TRAM_CONSULTAR_CONFIGURACION_TRAMITE_PUBLICO($TRAM_NIDTRAMITE_CONFIG, $USTR_NIDUSUARIOTRAMITE = 0)
    {
        $response = [
            'tramite'       => null,
            'secciones'     => [],
            'formularios'   => [],
            'documentos'    => [],
            'edificios'     => [],
            'resolutivos'   => [],
            'conceptos'     => [],
        ];

        try {
            if($USTR_NIDUSUARIOTRAMITE == 0){
                $response['secciones'] = DB::table('tram_mdv_seccion_tramite')->where('CONF_NIDTRAMITE',$TRAM_NIDTRAMITE_CONFIG)->orderBy('CONF_NORDEN','asc')->get();
            }else {
                $response['secciones'] = DB::table('tram_aux_seccion_seguimiento_tramite')
                                        ->select('SSEGTRA_NIDSECCION_SEGUIMIENTO','SSEGTRA_NIDSECCION_SEGUIMIENTO as CONF_NIDCONFIGURACION','SSEGTRA_NIDESTATUS as CONF_NESTATUS_SEGUIMIENTO','SSEGTRA_CNOMBRE_SECCION as CONF_NSECCION', 'SSEGTRA_PAGADO')
                                        ->where('SSEGTRA_NIDUSUARIOTRAMITE', $USTR_NIDUSUARIOTRAMITE)->get();

                //Detalle secciones
                if(count($response['secciones']) > 0){
                    foreach($response['secciones'] as $det){
                        switch($det->CONF_NSECCION){
                            case 'Ventanilla sin cita':
                                $det->edificios = DB::table('tram_mst_edificio')->where('EDIF_NIDSECCION',$det->CONF_NIDCONFIGURACION )->get();
                                $det->sincita   = DB::table('tram_mdv_seccion_tramite')->select('CONF_CDESCRIPCIONVENTANILLA')->where('CONF_NIDTRAMITE',$TRAM_NIDTRAMITE_CONFIG)->where('CONF_NSECCION', 'Ventanilla sin cita')->orderBy('CONF_NORDEN', 'asc')->get();
                                break;
                            case 'Pago en línea':
                                $det->conceptos = DB::table('tram_mdv_usuario_concepto')->where(['USCON_NIDUSUARIOTRAMITE' => $USTR_NIDUSUARIOTRAMITE, 'USCON_NACTIVO' => '$det->SSEGTRA_NIDSECCION_SEGUIMIENTO', 'USCON_NACTIVO' => true])->get();
                                break;
                            case 'Resolutivo electrónico':
                                $det->resolutivos = DB::table('tram_mdv_usuario_resolutivo')->where(['USRE_NIDUSUARIOTRAMITE' =>$USTR_NIDUSUARIOTRAMITE, 'USRE_NIDSECCION' =>$det->SSEGTRA_NIDSECCION_SEGUIMIENTO])->get();
                                break;
                            case 'Citas en línea':
                                $det->cita  = DB::table('tram_mdv_seccion_tramite')->where(['CONF_NIDTRAMITE' => $TRAM_NIDTRAMITE_CONFIG,'CONF_NSECCION' => 'Citas en línea'])->orderBy('CONF_NORDEN','asc')->get();
                                break;
                        }
                    }
                }else {
                    $response['secciones'] = DB::table('tram_mdv_seccion_tramite as a')
                                                ->select('a.*', 'a.CONF_NIDCONFIGURACION as SSEGTRA_NIDSECCION_SEGUIMIENTO', 'a.CONF_ESTATUSSECCION as CONF_NESTATUS_SEGUIMIENTO')
                                                ->where('a.CONF_NIDTRAMITE',$TRAM_NIDTRAMITE_CONFIG)->orderBy('CONF_NORDEN', 'asc')->get();
                    
                    //Detalle secciones
                    if(count($response['secciones']) > 0){
                        foreach($response['secciones'] as $det){
                            switch($det->CONF_NSECCION){
                                case 'Ventanilla sin cita':
                                    $det->edificios = [];
                                    $det->sincita = [];
                                    break;
                                case 'Pago en línea':
                                    $det->conceptos = [];
                                    break;
                                case 'Resolutivo electrónico':
                                    $det->resolutivos = [];
                                    break;
                                case 'Citas en línea':
                                    $det->cita = [];
                                    break;
                            }
                        }
                    }
                }
            }

            $formularios    = DB::table('tram_mst_formulario_tramite')->where('FORM_NIDTRAMITE', $TRAM_NIDTRAMITE_CONFIG)->get();
            $secciones      = DB::table('tram_cat_secciones')->where('FORM_BACTIVO', true)->get();
            foreach($formularios as $form){
                $form->secciones = [];
                foreach($secciones as $sec){
                    $sec->preguntas = DB::select(
                        'SELECT a."FORM_NID", a."FORM_NFORMULARIOID", a."FORM_NSECCIONID", a."FORM_CPREGUNTA", a."FORM_BTIENEASIGNACION", a."FORM_CVALORASIGNACION", b."FORM_CTIPORESPUESTA" 
                        FROM tram_form_pregunta as a
                        LEFT JOIN tram_form_pregunta_respuestas as b on a."FORM_NID" = b."FORM_NPREGUNTAID"
                        WHERE a."FORM_NFORMULARIOID" = ? and a."FORM_NSECCIONID" = ?
                        GROUP BY a."FORM_NID", a."FORM_NFORMULARIOID", a."FORM_NSECCIONID", a."FORM_CPREGUNTA", b."FORM_CTIPORESPUESTA"',
                        array($form->FORM_NIDFORMULARIO, $sec->FORM_NID)
                    );
                    foreach($sec->preguntas as $preg){
                        $preg->respuestas = DB::select('SELECT a."FORM_NID", a."FORM_NPREGUNTAID", a."FORM_CTIPORESPUESTA", a."FORM_CVALOR", a."FORM_BBLOQUEAR", b."FORM_CTIPORESPUESTA" as "FORM_CTIPORESPUESTAESPECIAL"
                        FROM tram_form_pregunta_respuestas as a
                        LEFT JOIN tram_form_pregunta_respuestas_especial as b on b."FORM_NPREGUNTARESPUESTAID" = a."FORM_NID"
                        WHERE a."FORM_NPREGUNTAID" = ?
                        GROUP BY a."FORM_NID", a."FORM_NPREGUNTAID", a."FORM_CTIPORESPUESTA", a."FORM_CVALOR", a."FORM_BBLOQUEAR", b."FORM_CTIPORESPUESTA"', array($preg->FORM_NID)
                        );
                        foreach($preg->respuestas as $resp){
                            $resp->respuestas_especial =  DB::select('SELECT * FROM tram_form_pregunta_respuestas_especial where "FORM_NPREGUNTARESPUESTAID" = ?', [$resp->FORM_NID]);

                            if($preg->FORM_CTIPORESPUESTA == 'catalogo'){
                                $resp->catalogos = [];
                                try{
                                    $resp->catalogos = DB::table($resp->FORM_CVALOR)->where('activo', true)->get();
                                }
                                catch(Exception $ex){
                                    //Preguntar como marcar el error
                                }
                            }
                        }
                    }

                    array_push($form->secciones, $sec);
                }
            }
            $response['formularios'] = $formularios;

            if($USTR_NIDUSUARIOTRAMITE == 0){
                $response['documentos'] = DB::table('tram_mdv_documento_tramite')->where('TRAD_NIDTRAMITE', $TRAM_NIDTRAMITE_CONFIG)->get();
            }else {
                $requeridos = DB::table('tram_mdv_documento_tramite')->where('TRAD_NIDTRAMITE', $TRAM_NIDTRAMITE_CONFIG)->get();
                $subidos    = DB::table('tram_mdv_usuariordocumento as a')
                                    ->join('tram_mdv_documento_tramite as b', 'a."USDO_NIDTRAMITEDOCUMENTO"', '=', 'b."TRAD_NIDTRAMITEDOCUMENTO"')
                                    ->select('a."USDO_NIDTRAMITEDOCUMENTO" as "TRAD_NIDTRAMITEDOCUMENTO"', 'a."USDO_CEXTENSION" as "TRAD_CEXTENSION"', 'a."USDO_CRUTADOC" as "TRAD_CRUTADOC"', 'a."USDO_NPESO" as "TRAD_NPESO"',
                                                'a."USDO_NESTATUS" as "TRAD_NESTATUS"', 'a."USDO_COBSERVACION" as "TRAD_COBSERVACION"', 'a."USDO_CDOCNOMBRE" as "TRAD_CNOMBRE"', 'b."TRAD_NMULTIPLE"', 'b."TRAD_NOBLIGATORIO"', 'a."USDO_NIDUSUARIORESP" as id'
                                    )
                                    ->where('a."USDO_NIDUSUARIOTRAMITE"', $USTR_NIDUSUARIOTRAMITE)->get();

                foreach($requeridos as $requerido){
                    $item = new stdClass();
                    $item->TRAD_NIDTRAMITEDOCUMENTO = $requerido->TRAD_NIDTRAMITEDOCUMENTO;
                    $item->TRAD_CEXTENSION      = null;
                    $item->TRAD_CRUTADOC        = null;
                    $item->TRAD_NPESO           = null;
                    $item->TRAD_NESTATUS        = 999999;
                    $item->TRAD_COBSERVACION    = null;
                    $item->TRAD_CNOMBRE         = $requerido->TRAD_CNOMBRE;
                    $item->TRAD_NMULTIPLE       = $requerido->TRAD_NMULTIPLE;
                    $item->TRAD_NOBLIGATORIO    = $requerido->TRAD_NOBLIGATORIO;
                    $item->id                   = null;


                    foreach($subidos as $sub){
                        if($requerido->TRAD_NIDTRAMITEDOCUMENTO == $sub->TRAD_NIDTRAMITEDOCUMENTO){
                            $item = $sub;
                        }
                    }
                    array_push($response['documentos'] , $item);
                }
            }

           
            if($USTR_NIDUSUARIOTRAMITE > 0){
                $response['conceptos'] = DB::table('tram_mdv_usuario_concepto')
                                            ->where('USCON_NIDUSUARIOTRAMITE', $USTR_NIDUSUARIOTRAMITE)
                                            ->where('USCON_NACTIVO', true)->get();
            }

            $response['edificios']      = DB::table('tram_mst_edificio')->where('EDIF_NIDTRAMITE', $TRAM_NIDTRAMITE_CONFIG)->get();
            $response['resolutivos']    = DB::table('tram_mdv_usuario_resolutivo')->where('USRE_NIDUSUARIOTRAMITE', $USTR_NIDUSUARIOTRAMITE)->get();
            $response['notificaciones'] = DB::table('tram_his_notificacion_tramite')->where('HNOTI_NIDUSUARIOTRAMITE', $USTR_NIDUSUARIOTRAMITE)->get();
            
            return $response;
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function TRAM_SP_OBTENERDEPENDECIAS()
    {
        return DB::select('CALL TRAM_SP_OBTENERDEPENDENCIA()');
    }

    public function TRAM_SP_CREARTRAMITE()
    {
        return DB::select(
            'call TRAM_SP_AGREGARTRAMITE(?,?,?,?,?,?,?)',
            array(
                $this->TRAM_NTIPO, $this->TRAM_NIDUNIDADADMINISTRATIVA, $this->TRAM_CNOMBRE, $this->TRAM_CENCARGADO, $this->TRAM_CUNIDADADMIN,
                $this->TRAM_CCONTACTO, $this->TRAM_CDESCRIPCION
            )
        );
    }

    public function TRAM_SP_OBTENER_DETALLE_TRAMITE()
    {
        return DB::select(
            'call TRAM_SP_OBTENER_DETALLE_TRAMITE(?)',
            array(
                $this->TRAM_NIDTRAMITE
            )
        );
    }

    public function TRAM_SP_CONSULTAR_TRAMITE_ACCEDE($IntIdUnidad)
    {
        return DB::select('CALL TRAM_SP_CONSULTAR_TRAMITE_ACCEDE(?)', array($IntIdUnidad));
    }

    static function TRAM_ESTATUS_NOTIFICACION($IntIdNotificacion)
    {
        try {

            Cls_Notificacion_Tramite::where(['HNOTI_NIDNOTIFICACION' => $IntIdNotificacion])
                ->update(['HNOTI_NLEIDO' => 1, 'HNOTI_DFECHALEIDO' => date('Y-m-d H:i:s')]);
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    static function TRAM_VISTO_NOTIFICACION($IntIdNotificacion)
    {
        try {

            Cls_Notificacion_Tramite::where(['HNOTI_NIDNOTIFICACION' => $IntIdNotificacion])
                ->update(['HNOTI_DFECHALEIDO' => date('Y-m-d H:i:s')]);
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function TRAM_CONSULTAR_DETALLE_NOTIFICACION($IntIdNotificacion){
        return Cls_Notificacion_Tramite::where('HNOTI_NIDNOTIFICACION', $IntIdNotificacion)
        ->select('*')
        ->first();
    }

    static function TRAM_OBTENER_TRAMITES(){
        $user = Auth::user();
        $rol =$user->USUA_NIDROL;
        $persona_tipo = $user->USUA_NTIPO_PERSONA;
        if($rol == 2){
            switch ($persona_tipo) {
                case 'FISICA':
                    $resp = DB::table('tram_mst_tramite')->where('TRAM_NIMPLEMENTADO', 1)
                    ->where(function($query) { 
                        $query->orWhere('TRAM_CTIPO_PERSONA','=',1)
                        ->orWhere('TRAM_CTIPO_PERSONA','=',0)
                        ->orWhereNull('TRAM_CTIPO_PERSONA');
                    })->orderBy('TRAM_CTIPO_PERSONA','ASC')->get();
                    break;
                case 'MORAL':
                    $resp = DB::table('tram_mst_tramite')->where('TRAM_NIMPLEMENTADO', 1)
                    ->where(function($query) { 
                        $query->orWhere('TRAM_CTIPO_PERSONA','=',2)
                        ->orWhere('TRAM_CTIPO_PERSONA','=',0)
                        ->orWhereNull('TRAM_CTIPO_PERSONA');
                    })->orderBy('TRAM_CTIPO_PERSONA','ASC')->get();
                    break;
                default:
                $resp = DB::table('tram_mst_tramite')->where('TRAM_NIMPLEMENTADO', 1)->orderBy('TRAM_CTIPO_PERSONA','ASC')->get();
                    break;
            }
        }
        else{
            $resp = DB::table('tram_mst_tramite')->where('TRAM_NIMPLEMENTADO', 1)->orderBy('TRAM_CTIPO_PERSONA','ASC')->get();
        }
        
        return $resp;
    }

    static function TRAM_TIPO_PERSONA(Request $request){
        try {
            DB::table('tram_mst_tramite')->where('TRAM_NIDTRAMITE', $request->TRAM_NIDTRAMITE)->update(['TRAM_CTIPO_PERSONA' => $request->TRAM_CTIPO_PERSONA]);

            $response = [
                "estatus" => "success",
                "mensaje" => "¡Éxito! acción realizada con éxito.",
                "codigo" => 200
            ];
        } catch (Throwable $th) {
            $response = [
                "estatus" => "error",
                "mensaje" => "Ocurrió un error: " . $th->getMessage(),
                "codigo" => 400
            ];
        }

        return response()->json($response);
    }
    
    static function getConfigDocArr(){
        return DB::table('tram_mst_configdocumentos')->get();
    } 
 

    static function getConfigDocumentos($nombre) 
    {
        //$docs = DB::select("SELECT * FROM `tram_mst_configdocumentos` WHERE NOMBRE = '".$nombre."' LIMIT 0,1");
        
        //return $docs;
        $response = DB::selectOne('SELECT * FROM tram_mst_configdocumentos WHERE NOMBRE =  ?',
        array($nombre));
        return $response;
    } 
    static function getTipoDocsBASE($idUSER)
    {
        $docsUser = DB::select("SELECT * FROM `tram_mst_documentosbase` 
        WHERE ID_USUARIO = '".$idUSER."' AND isDelete = 0 AND isActual = 1 ");
        
        return $docsUser;
    }
    
    
    static function getTRAMexp($idUSER) 
    {


        //FORMATO DE TRAMITE tram_mdv_documento_tramite
        $sec = DB::select('SELECT \'TRAM\' AS "TIPO", "USDO_NIDUSUARIORESP", "USDO_CRUTADOC", "USDO_NPESO", "USDO_NESTATUS", 
        "USDO_COBSERVACION", "USDO_NIDTRAMITEDOCUMENTO", created_at, updated_at,  "USDO_CEXTENSION", "USDO_NIDUSUARIOBASE", 
        "USDO_CDOCNOMBRE", "idDocExpediente", "VIGENCIA_FIN"
        FROM tram_mdv_usuariordocumento
        WHERE "USDO_NIDUSUARIOBASE" =  ? 
        UNION        
        SELECT \'EXP\' AS "TIPO", base.id AS "USDO_NIDUSUARIORESP", base.ruta AS "USDO_CRUTADOC", base."PESO" AS "USDO_NPESO", 
        base.estatus AS "USDO_NESTATUS", \' \' AS "USDO_COBSERVACION", 0 AS "USDO_NIDTRAMITEDOCUMENTO", 
        base.create_at AS created_at, base.update_at AS updated_at, base."FORMATO" AS "USDO_CEXTENSION", 
        base."ID_USUARIO" AS "USDO_NIDUSUARIOBASE", "CONFIG"."NOMBRE" AS "USDO_CDOCNOMBRE", 
		  base."ID_CDOCUMENTOS" AS idDocExpediente, base."VIGENCIA_FIN" AS "VIGENCIA_FIN"
        FROM tram_mst_documentosbase AS base  LEFT JOIN tram_mst_configdocumentos AS "CONFIG"
        ON base."ID_CDOCUMENTOS" = "CONFIG".id
        WHERE base."ID_USUARIO" = ?
        ORDER BY created_at DESC', [$idUSER, $idUSER]); 
         
              
        
        return $sec;
    }//*/
    
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







}
