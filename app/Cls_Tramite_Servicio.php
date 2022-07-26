<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Cls_Notificacion_Tramite;

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
        $response = DB::selectOne(
            'SELECT a.*, b.USTR_NESTATUS as TRAM_NESTATUS_PROCESO, b.USTR_CFOLIO as TRAM_CFOLIO_SEGUIMIENTO, b.USTR_NENCUESTA_CONTESTADA FROM tram_mst_tramite as a
            LEFT JOIN tram_mdv_usuariotramite as b on a.TRAM_NIDTRAMITE = b.USTR_NIDTRAMITE
            WHERE a.TRAM_NIDTRAMITE = ?',
            array($TRAM_NIDTRAMITE_CONFIG)
        );
        return $response;
    }

    public function TRAM_CONSULTAR_DETALLE_TRAMITE_SEGUIMIENTO($USTR_NIDUSUARIOTRAMITE){
        $response = DB::selectOne(
            'SELECT b.*, a.USTR_NESTATUS as TRAM_NESTATUS_PROCESO, a.USTR_CFOLIO as TRAM_CFOLIO_SEGUIMIENTO, a.USTR_NIDUSUARIOTRAMITE, a.USTR_NIDUSUARIO, a.USTR_NENCUESTA_CONTESTADA, a.USTR_CMODULO, a.USTR_NLATITUD, a.USTR_NLONGITUD FROM tram_mdv_usuariotramite as a
            INNER JOIN tram_mst_tramite as b on b.TRAM_NIDTRAMITE = a.USTR_NIDTRAMITE
            WHERE a.USTR_NIDUSUARIOTRAMITE = ?',
            array($USTR_NIDUSUARIOTRAMITE)
        );
        return $response;
    }

    public function TRAM_CONSULTAR_CONFIGURACION_TRAMITE_PUBLICO($TRAM_NIDTRAMITE_CONFIG, $USTR_NIDUSUARIOTRAMITE = 0)
    {

        $response = [
            'tramite' => null,
            'secciones' => [],
            'formularios' => [],
            'documentos' => [],
            'edificios' => [],
            'resolutivos' => [],
            'conceptos' => [],
        ];

        try {
            if($USTR_NIDUSUARIOTRAMITE == 0){
                $response['secciones'] = DB::select(
                    'SELECT * FROM tram_mdv_seccion_tramite where CONF_NIDTRAMITE = ? ORDER BY CONF_NORDEN',
                    array($TRAM_NIDTRAMITE_CONFIG)
                );
            }else {
                $response['secciones'] = DB::select(
                    'SELECT a.SSEGTRA_NIDSECCION_SEGUIMIENTO, a.SSEGTRA_NIDSECCION_SEGUIMIENTO as CONF_NIDCONFIGURACION, a.SSEGTRA_NIDESTATUS as CONF_NESTATUS_SEGUIMIENTO,
 		    a.SSEGTRA_CNOMBRE_SECCION as CONF_NSECCION, a.SSEGTRA_PAGADO 
                    FROM tram_aux_seccion_seguimiento_tramite as a
                    WHERE a.SSEGTRA_NIDUSUARIOTRAMITE = ?',
                    array($USTR_NIDUSUARIOTRAMITE)
                );
                
                //Detalle secciones
                if(count($response['secciones']) > 0){
                    foreach($response['secciones'] as $det){
                        switch($det->CONF_NSECCION){
                            case 'Ventanilla sin cita':
                                $det->edificios = DB::select(
                                    'SELECT * FROM tram_mst_edificio WHERE EDIF_NIDSECCION = ?',
                                    array($det->CONF_NIDCONFIGURACION)
                                );
                                $det->sincita = DB::select(
                                    'SELECT CONF_CDESCRIPCIONVENTANILLA FROM tram_mdv_seccion_tramite where CONF_NIDTRAMITE = ? AND CONF_NSECCION = "Ventanilla sin cita" ORDER BY CONF_NORDEN',
                                    array($TRAM_NIDTRAMITE_CONFIG)
                                );
                                break;
                            case 'Pago en línea':
                                $det->conceptos = DB::select(
                                    'SELECT * FROM tram_mdv_usuario_concepto WHERE USCON_NIDUSUARIOTRAMITE = ? AND USCON_NIDSECCION = ? AND USCON_NACTIVO = ?',
                                    array($USTR_NIDUSUARIOTRAMITE, $det->SSEGTRA_NIDSECCION_SEGUIMIENTO, 1)
                                );
                                break;
                            case 'Resolutivo electrónico':
                                $det->resolutivos = DB::select(
                                    'SELECT * FROM tram_mdv_usuario_resolutivo WHERE USRE_NIDUSUARIOTRAMITE = ? AND USRE_NIDSECCION = ?',
                                    array($USTR_NIDUSUARIOTRAMITE, $det->SSEGTRA_NIDSECCION_SEGUIMIENTO)
                                );
                                break;
                            case 'Citas en línea':
                                $det->cita = DB::select(
                                    'SELECT CONF_CDESCRIPCIONCITA FROM tram_mdv_seccion_tramite where CONF_NIDTRAMITE = ? AND CONF_NSECCION = "Citas en línea" ORDER BY CONF_NORDEN',
                                    array($TRAM_NIDTRAMITE_CONFIG)
                                );
                                break;
                        }
                    }
                }else {
                    $response['secciones'] = DB::select(
                        'SELECT a.*, a.CONF_NIDCONFIGURACION as SSEGTRA_NIDSECCION_SEGUIMIENTO,  a.CONF_ESTATUSSECCION as CONF_NESTATUS_SEGUIMIENTO FROM tram_mdv_seccion_tramite as a where a.CONF_NIDTRAMITE = ? ORDER BY CONF_NORDEN',
                        array($TRAM_NIDTRAMITE_CONFIG)
                    );

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

            $formularios = DB::select(
                'SELECT * FROM tram_mst_formulario_tramite where FORM_NIDTRAMITE = ?',
                array($TRAM_NIDTRAMITE_CONFIG)
            );
            
            
        
            $secciones = DB::select(
                'SELECT * FROM tram_cat_secciones where FORM_BACTIVO = ?',
                array(1)
            );

            foreach($formularios as $form){
                $form->secciones = [];
                foreach($secciones as $sec){
                    $sec->preguntas = DB::select(
                        'SELECT a.FORM_NID, a.FORM_NFORMULARIOID, a.FORM_NSECCIONID, a.FORM_CPREGUNTA, b.FORM_CTIPORESPUESTA FROM tram_form_pregunta as a
                        LEFT JOIN tram_form_pregunta_respuestas as b on a.FORM_NID = b.FORM_NPREGUNTAID
                        WHERE a.FORM_NFORMULARIOID = ? and a.FORM_NSECCIONID = ?
                        GROUP BY a.FORM_NID, a.FORM_NFORMULARIOID, a.FORM_NSECCIONID, a.FORM_CPREGUNTA, b.FORM_CTIPORESPUESTA',
                        array($form->FORM_NIDFORMULARIO, $sec->FORM_NID)
                    );
                    foreach($sec->preguntas as $preg){
                        $preg->respuestas = DB::select('SELECT a.FORM_NID, a.FORM_NPREGUNTAID, a.FORM_CTIPORESPUESTA, a.FORM_CVALOR, a.FORM_BBLOQUEAR, b.FORM_CTIPORESPUESTA as FORM_CTIPORESPUESTAESPECIAL
                        FROM tram_form_pregunta_respuestas as a
                        LEFT JOIN tram_form_pregunta_respuestas_especial as b on b.FORM_NPREGUNTARESPUESTAID = a.FORM_NID
                        WHERE a.FORM_NPREGUNTAID = ?
                        GROUP BY a.FORM_NID, a.FORM_NPREGUNTAID, a.FORM_CTIPORESPUESTA, a.FORM_CVALOR, a.FORM_BBLOQUEAR, b.FORM_CTIPORESPUESTA', array($preg->FORM_NID)
                        );
                        foreach($preg->respuestas as $resp){
                            $resp->respuestas_especial =  DB::select('SELECT * FROM tram_form_pregunta_respuestas_especial where FORM_NPREGUNTARESPUESTAID = ?', [$resp->FORM_NID]);
                        }
                    }

                    array_push($form->secciones, $sec);
                }
            }
            $response['formularios'] = $formularios;

            if($USTR_NIDUSUARIOTRAMITE == 0){
                $response['documentos'] = DB::select(
                    'SELECT * FROM tram_mdv_documento_tramite where TRAD_NIDTRAMITE = ?',
                    array($TRAM_NIDTRAMITE_CONFIG)
                );
            }else {
                $response['documentos'] = DB::select(
                    'SELECT a.USDO_NIDTRAMITEDOCUMENTO as TRAD_NIDTRAMITEDOCUMENTO, 
                            a.USDO_CEXTENSION as TRAD_CEXTENSION, 
                            a.USDO_CRUTADOC as TRAD_CRUTADOC, 
                            a.USDO_NPESO as TRAD_NPESO,
                            a.USDO_NESTATUS as TRAD_NESTATUS,
                            a.USDO_COBSERVACION as TRAD_COBSERVACION,
                            a.USDO_CDOCNOMBRE as TRAD_CNOMBRE,
                            b.TRAD_NMULTIPLE,
                            b.TRAD_NOBLIGATORIO,
                            a.USDO_NIDUSUARIORESP as id
                            FROM tram_mdv_usuariordocumento as a
                            LEFT JOIN tram_mdv_documento_tramite as b ON a.USDO_NIDTRAMITEDOCUMENTO = b.TRAD_NIDTRAMITEDOCUMENTO 
                            where a.USDO_NIDUSUARIOTRAMITE = ?',
                    array($USTR_NIDUSUARIOTRAMITE)
                );

                if(count($response['documentos']) == 0){
                    $response['documentos'] = DB::select(
                        'SELECT a.*, 1 as TRAD_NESTATUS, "" as TRAD_COBSERVACION, 0 as id, "" as TRAD_CRUTADOC, 0 as TRAD_NPESO  FROM tram_mdv_documento_tramite as a where a.TRAD_NIDTRAMITE = ?',
                        array($TRAM_NIDTRAMITE_CONFIG)
                    );
                }
            }
            
            $response['edificios'] = DB::select(
                'SELECT * FROM tram_mst_edificio where EDIF_NIDTRAMITE = ?',
                array($TRAM_NIDTRAMITE_CONFIG)
            );

            if($USTR_NIDUSUARIOTRAMITE > 0){
                $response['conceptos'] = DB::select(
                    'SELECT * FROM tram_mdv_usuario_concepto where USCON_NIDUSUARIOTRAMITE = ? AND USCON_NACTIVO = ?',
                    array($USTR_NIDUSUARIOTRAMITE, 1)
                );
            }

            $response['resolutivos'] = DB::select(
                'SELECT * FROM tram_mdv_usuario_resolutivo where USRE_NIDUSUARIOTRAMITE = ?',
                array($USTR_NIDUSUARIOTRAMITE)
            );

            $response['notificaciones'] = DB::select(
                'SELECT * FROM tram_his_notificacion_tramite where HNOTI_NIDUSUARIOTRAMITE = ?',
                array($USTR_NIDUSUARIOTRAMITE)
            );

            return $response;

        } catch (\Throwable $th) {
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

    public function TRAM_CONSULTAR_DETALLE_NOTIFICACION($IntIdNotificacion){
        return Cls_Notificacion_Tramite::where('HNOTI_NIDNOTIFICACION', $IntIdNotificacion)
        ->select('*')
        ->first();
    }

}
