<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Cls_Seguimiento_Servidor_Publico extends Model
{
    protected $connection = 'mysql';
    public $USTR_NIDUSUARIOTRAMITE;
    public $UsuarioID;

    //Filtro table
    public $StrTexto;
    public $IntDesde;
    public $IntCantidadRegistros;

    //Header filter
    public $fecha;
    public $folio;
    public $tramite;
    public $razonSocial;
    public $nombre;
    public $rfc;
    public $curp;
    public $estatus;
    public $ordenColumna;
    public $direccionOrden;

    public function TRAM_SP_CONSULTAR_TRAMITES_SEGUIMIENTO()
    {
        $response = [
            'result' => null,
            'total' => 0,
        ];

        try {

            $sql = "call TRAM_SP_OBTENER_SEGUIMIENTO_TRAMITE_SERVIDOR_PUBLICO('$this->USTR_NIDUSUARIOTRAMITE', ' $this->StrTexto', '$this->IntDesde', '$this->IntCantidadRegistros', '$this->fecha', '$this->folio', '$this->tramite', '$this->razonSocial', '$this->nombre', '$this->rfc', '$this->curp', '$this->estatus', '$this->ordenColumna', '$this->direccionOrden', '$this->UsuarioID')";

            $pdo = DB::connection()->getPdo();
            $pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, true);
            $stmt = $pdo->prepare($sql, [\PDO::ATTR_CURSOR => \PDO::CURSOR_SCROLL]);
            $exec = $stmt->execute();

            //Primer resultado: Lista de resultados
            $response['result'] = $stmt->fetchAll(\PDO::FETCH_OBJ);

            //Segundo resultado: Lista de resultados
            $stmt->nextRowset();
            $response['total'] = $stmt->fetchAll(\PDO::FETCH_OBJ);

            return $response;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    static function ACTUALIZAR_STATUS($folio){
        $rsp = DB::table('tram_mdv_usuariotramite')
        ->where('USTR_CFOLIO', $folio)
        ->update(['USTR_NESTATUS' => 10]);
        return $rsp;
    }

    static function ACTUALIZAR_STATUS_VENCIDO($folio){
        $rsp = DB::table('tram_mdv_usuariotramite')
        ->where('USTR_CFOLIO', $folio)
        ->update(['USTR_NESTATUS' => 11]);
        return $rsp;
    }

    static function OBTENER_ID_POR_FECHA($inicio, $fin){
        $sql = "SELECT USTR_NIDUSUARIOTRAMITE FROM tram_mdv_usuariotramite WHERE CAST(created_at AS DATE) >= '".$inicio."' AND CAST(created_at AS DATE) <= '".$fin."'";
        $query = DB::select($sql);
        return $query;
    }

    static function TRAM_CONSULTAR_CONFIGURACION_TRAMITE_PUBLICO($TRAM_NIDTRAMITE_CONFIG)
    {
        $response = [
            'tramite' => null,
            'secciones' => [],
            'formularios' => [],
            'documentos' => [],
            'edificios' => [],
            'resolutivos' => [],
        ];

        try {

            $sql = "call TRAM_SP_CONSULTAR_TRAMITE_SEGUIMIENTO('$TRAM_NIDTRAMITE_CONFIG')";

            $pdo = DB::connection()->getPdo();
            $pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, true);
            $stmt = $pdo->prepare($sql, [\PDO::ATTR_CURSOR => \PDO::CURSOR_SCROLL]);
            $exec = $stmt->execute();

            //Primer resultado: Datos trámite en seguimiento
            $response['tramite'] = $stmt->fetchAll(\PDO::FETCH_OBJ);

            //Segundo resultado: Secciones del trámite
            $stmt->nextRowset();
            $response['secciones'] = $stmt->fetchAll(\PDO::FETCH_OBJ);

            //Tercer resultado: Formulario del trámite
            $stmt->nextRowset();
            $formularios = $stmt->fetchAll(\PDO::FETCH_OBJ);

            //Cuarto resultado: Secciones del formulario activo
            $stmt->nextRowset();
            $secciones = $stmt->fetchAll(\PDO::FETCH_OBJ);

            //Quinto resultado: Secciones de documentos
            $stmt->nextRowset();
            $response['documentos'] = $stmt->fetchAll(\PDO::FETCH_OBJ);

            //Sexto resultado: Secciones de edificios
            $stmt->nextRowset();
            $response['edificios'] = $stmt->fetchAll(\PDO::FETCH_OBJ);

            //Septimo resultado: Secciones de resolutivos
            $stmt->nextRowset();
            $response['resolutivos'] = $stmt->fetchAll(\PDO::FETCH_OBJ);

            $stmt->closeCursor();

            foreach ($formularios as $form) {
                $form->secciones = [];
                foreach ($secciones as $sec) {
                    $sec->preguntas = DB::select(
                        'SELECT a.FORM_NID, a.FORM_NFORMULARIOID, a.FORM_NSECCIONID, a.FORM_CPREGUNTA, b.FORM_CTIPORESPUESTA FROM tram_form_pregunta as a
                        JOIN tram_form_pregunta_respuestas as b on a.FORM_NID = b.FORM_NPREGUNTAID
                        WHERE a.FORM_NFORMULARIOID = ? and a.FORM_NSECCIONID = ?
                        GROUP BY a.FORM_NID, a.FORM_NFORMULARIOID, a.FORM_NSECCIONID, a.FORM_CPREGUNTA, b.FORM_CTIPORESPUESTA',
                        array($form->FORM_NIDFORMULARIO, $sec->FORM_NID)
                    );
                    foreach ($sec->preguntas as $preg) {
                        $preg->respuestas = DB::select(
                            'SELECT a.FORM_NID, a.FORM_NPREGUNTAID, a.FORM_CTIPORESPUESTA, a.FORM_CVALOR, a.FORM_BBLOQUEAR, b.FORM_CTIPORESPUESTA as FORM_CTIPORESPUESTAESPECIAL
                        FROM tram_form_pregunta_respuestas as a
                        LEFT JOIN tram_form_pregunta_respuestas_especial as b on b.FORM_NPREGUNTARESPUESTAID = a.FORM_NID
                        WHERE a.FORM_NPREGUNTAID = ?
                        GROUP BY a.FORM_NID, a.FORM_NPREGUNTAID, a.FORM_CTIPORESPUESTA, a.FORM_CVALOR, a.FORM_BBLOQUEAR, b.FORM_CTIPORESPUESTA',
                            array($preg->FORM_NID)
                        );
                        foreach ($preg->respuestas as $resp) {
                            $resp->respuestas_especial =  DB::select('SELECT * FROM tram_form_pregunta_respuestas_especial where FORM_NPREGUNTARESPUESTAID = ?', [$resp->FORM_NID]);
                        }
                    }

                    array_push($form->secciones, $sec);
                }
            }

            $response['formularios'] = $formularios;

            return $response;
        } catch (\Throwable $th) {

            dd([
                "error" => $th
            ]);
        }
    }

    static function TRAM_OBTENER_TRAMITE_SEGUIMIENTO($TRAM_NIDTRAMITE_CONFIG)
    {
        try {
            return  DB::select(
                'SELECT * FROM tram_vw_tramite_seguimiento where USTR_NIDUSUARIOTRAMITE = ?',
                array($TRAM_NIDTRAMITE_CONFIG)
            );
        } catch (\Throwable $th) {
            return [
                "error" => $th
            ];
        }
    }

    static function TRAM_OBTENER_TRAMITE_SECCIONES($TRAM_NIDTRAMITE_CONFIG)
    {
        $response = [
            'tramite' => null,
            'secciones' => [],
            'formularios' => [],
            'documentos' => [],
            'edificios' => [],
            'resolutivos' => [],
        ];

        try {
            $sql = "call TRAM_SP_CONSULTAR_TRAMITE_SEGUIMIENTO('$TRAM_NIDTRAMITE_CONFIG')";

            $pdo = DB::connection()->getPdo();
            $pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, true);
            $stmt = $pdo->prepare($sql, [\PDO::ATTR_CURSOR => \PDO::CURSOR_SCROLL]);
            $exec = $stmt->execute();

            //Primer resultado: Datos trámite en seguimiento
            $response['tramite'] = $stmt->fetchAll(\PDO::FETCH_OBJ);

            //Segundo resultado: Secciones del trámite
            $stmt->nextRowset();
            $response['secciones'] = $stmt->fetchAll(\PDO::FETCH_OBJ);

            //Tercer resultado: Formulario del trámite
            $stmt->nextRowset();
            $formularios = $stmt->fetchAll(\PDO::FETCH_OBJ);

            //Cuarto resultado: Secciones del formulario activo
            $stmt->nextRowset();
            $secciones = $stmt->fetchAll(\PDO::FETCH_OBJ);

            //Quinto resultado: Secciones de documentos
            $stmt->nextRowset();
            $response['documentos'] = $stmt->fetchAll(\PDO::FETCH_OBJ);

            //Sexto resultado: Secciones de edificios
            $stmt->nextRowset();
            $response['edificios'] = $stmt->fetchAll(\PDO::FETCH_OBJ);

            //Septimo resultado: Secciones de resolutivos
            $stmt->nextRowset();
            $response['resolutivos'] = $stmt->fetchAll(\PDO::FETCH_OBJ);

            $stmt->closeCursor();
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    static function TRAM_OBTENER_SECCIONES_ESTATUS($NIDUSUARIOTRAMITE)
    {
        try {
            return DB::select(
                'SELECT * FROM tram_aux_seccion_seguimiento_tramite WHERE SSEGTRA_NIDUSUARIOTRAMITE = ?',
                array($NIDUSUARIOTRAMITE)
            );
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    static function TRAM_OBTENER_RESOLUTIVOS_FINALES($NIDUSUARIOTRAMITE)
    {
        try {
            return DB::select(
                'SELECT * FROM tram_mdv_usuario_resolutivo WHERE USRE_NIDUSUARIOTRAMITE = ?',
                array($NIDUSUARIOTRAMITE)
            );
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    static function TRAM_OBTENER_RESOLUTIVOS_CONFIGURADOS($NIDTRAMITE)
    {
        try {
            return DB::select(
                'SELECT * FROM tram_mst_resolutivo WHERE RESO_NIDTRAMITE = ?',
                array($NIDTRAMITE)
            );
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    static function TRAM_OBTENER_RESOLUTIVO($NIDRESOLUTIVO)
    {
        try {
            return DB::select(
                'SELECT * FROM tram_mst_resolutivo WHERE RESO_NID = ?',
                array($NIDRESOLUTIVO)
            );
        } catch (\Throwable $th) {
            //throw $th;
        }
    }


    static function TRAM_OBTENER_RESOLUTIVO_MAPEO($NIDRESOLUTIVO, $NIDUSUARIOTRAMITE)
    {
        try {
            return DB::select(
                '
                SELECT 
                tr.RESO_NID,
                tut.USTR_NIDUSUARIOTRAMITE,
                tt.TRAM_NIDTRAMITE,
                tur.USRE_NIDPREGUNTA,
                tr.RESO_NIDRESOLUTIVO,
                tr.RESO_CNOMBRE,
                tfp.FORM_NSECCIONID,
                tfp.FORM_CPREGUNTA,
                tur.USRE_NIDUSUARIORESP,
                tur.USRE_CRESPUESTA,
                trm.TRAM_CNOMBRECAMPO
                FROM tram_mdv_usuariorespuestas tur
                INNER JOIN tram_form_pregunta tfp ON tfp.FORM_NID = tur.USRE_NIDPREGUNTA
                INNER JOIN tram_mdv_usuariotramite tut ON tut.USTR_NIDUSUARIOTRAMITE = tur.USRE_NIDUSUARIOTRAMITE
                INNER JOIN tram_mst_tramite tt ON tut.USTR_NIDTRAMITE = tt.TRAM_NIDTRAMITE
                INNER JOIN tram_mst_resolutivo tr ON tr.RESO_NIDTRAMITE = tt.TRAM_NIDTRAMITE
                INNER JOIN tram_mst_resolutivo_mapeo trm ON tr.RESO_NID = trm.TRAM_RESODOCU_NID  AND tur.USRE_NIDPREGUNTA = trm.TRAM_NIDPRGUNTA
                WHERE tr.RESO_NID = ? AND  tur.USRE_NIDUSUARIOTRAMITE  = ?',
                array($NIDRESOLUTIVO, $NIDUSUARIOTRAMITE)
            );
        } catch (\Throwable $th) {
            //throw $th;
        }
    }



    public function TRAM_GUARDAR_SECCION_FORMULARIO($USTR_NIDUSUARIOTRAMITE, $USTR_NESTATUS, array $Preguntas)
    {
        try {

            //----- Estatus Seccion -----------
            //$USTR_NESTATUS = 1 -> Seccion Inhabilitado
            //$USTR_NESTATUS = 2 -> Seccion Aprobado
            //$USTR_NESTATUS = 3 -> Seccion Incompleta
            //$USTR_NESTATUS = 4 -> Trámite rechazado

            //----- Estatus de trámite --------
            // 1 -> Trámite iniciado
            // 2 -> Recibido
            // 3 -> En revisión
            // 4 -> Finalizado
            // 5 -> Rechazado

            if ($USTR_NESTATUS == 3) {

                //Estatus general del trámite: 3 - En revisión
                DB::select(
                    'UPDATE tram_mdv_usuariotramite SET USTR_NESTATUS = 3 WHERE USTR_NIDUSUARIOTRAMITE = ?',
                    array($USTR_NIDUSUARIOTRAMITE)
                );

                //Actualizar estatus del sección

            } else {
            }

            //Actualizar estatus general del trámite
            DB::select(
                'UPDATE tram_mdv_usuariotramite SET USTR_NESTATUS= 1 WHERE USTR_NIDUSUARIOTRAMITE = ?',
                array($USTR_NIDUSUARIOTRAMITE)
            );

            //Actualizar estatus de seccion formulario

            //Actualizar estatus y observacion de preguntas

        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    //Marcar de Recibido el estatus del trámite del ciudadano
    static function TRAM_MARCAR_ESTATUS_REVISION_TRAMITE($CONF_NIDUSUARIOTRAMITE)
    {
        try {

            $tramite = DB::select(
                'SELECT * FROM tram_mdv_usuariotramite WHERE USTR_NIDUSUARIOTRAMITE = ?',
                array($CONF_NIDUSUARIOTRAMITE)
            );

            //Marcamos como Recibido->3 en caso de que no este aún
            if ($tramite['USTR_NESTATUS'] <= 2) {
                DB::select(
                    'UPDATE tram_mdv_usuariotramite SET USTR_NESTATUS = 3 WHERE USTR_NIDUSUARIOTRAMITE = ?',
                    array($CONF_NIDUSUARIOTRAMITE)
                );
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    //Cambiar estatus y observacion de respuesta usuario
    static function TRAM_ESTATUS_PREGUNTA($USRE_NIDUSUARIOTRAMITE, $USRE_NIDPREGUNTA, $USRE_NESTATUS, $USRE_COBSERVACION)
    {
        try {

            Cls_Usuario_Respuesta::where(['USRE_NIDUSUARIOTRAMITE' => $USRE_NIDUSUARIOTRAMITE, 'USRE_NIDPREGUNTA' => $USRE_NIDPREGUNTA])
                ->update(['USRE_NESTATUS' => $USRE_NESTATUS, 'USRE_COBSERVACION' => $USRE_COBSERVACION]);
        } catch (\Throwable $th) {
        }
    }

    //Cambiar estatus y observacion de documentos de usuario
    static function TRAM_ESTATUS_DOCUMENTO($USDO_NIDUSUARIOTRAMITE, $USDO_NIDTRAMITEDOCUMENTO, $USDO_NESTATUS, $USDO_COBSERVACION)
    {
        try {

            Cls_Usuario_Documento::where(['USDO_NIDUSUARIOTRAMITE' => $USDO_NIDUSUARIOTRAMITE, 'USDO_NIDTRAMITEDOCUMENTO' => $USDO_NIDTRAMITEDOCUMENTO])
                ->update(['USDO_NESTATUS' => $USDO_NESTATUS, 'USDO_COBSERVACION' => $USDO_COBSERVACION]);
        } catch (\Throwable $th) {
        }
    }
    //Cambiar estatus, vigencia y observacion de documentos de usuario
    static function TRAM_ESTATUS_DOCUMENTO_VIG($USDO_NIDUSUARIOTRAMITE, $USDO_NIDTRAMITEDOCUMENTO, $USDO_NESTATUS, $USDO_COBSERVACION, $VIGENCIA)
    {//$VIGENCIA
        try {

            Cls_Usuario_Documento::where(['USDO_NIDUSUARIOTRAMITE' => $USDO_NIDUSUARIOTRAMITE, 'USDO_NIDTRAMITEDOCUMENTO' => $USDO_NIDTRAMITEDOCUMENTO])
                ->update(['USDO_NESTATUS' => $USDO_NESTATUS, 'VIGENCIA_FIN' => $VIGENCIA, 'USDO_COBSERVACION' => $USDO_COBSERVACION]);
        } catch (\Throwable $th) {
        }
    }

    static function ActualizarDocsUsuario($docId, $vigencia)
    {
        $affected = DB::table('tram_mst_documentosbase')
            ->where('id', $docId)
            ->update(['VIGENCIA_FIN' => $vigencia]);
        return $affected;
    }

    
    
    static function ActualizarDocVigencia($idbase, $vigencia){
        $affected = DB::table('tram_mst_documentosbase')
            ->where('id', $idbase)
            ->update(['VIGENCIA_FIN' => $vigencia]);
        return $affected;
    }


    static function getDocBase($docs, $usr)  
    {
        $docsUser = DB::select("SELECT * FROM `tram_mst_documentosbase` 
        WHERE ID_USUARIO = '".$usr."' AND ID_CDOCUMENTOS ='".$docs."'  LIMIT 0,1");
          
        return $docsUser;
        
    }
    static function getConfigDocumentos($nombre)
    {
        $sql = DB::table('tram_mst_configdocumentos')
            ->select('id')
            ->where('NOMBRE', $nombre)
            ->first();
        return $sql;
    }

    static function getVigencia($idDoc)
    {
        $sql = DB::table('tram_mst_documentosbase')
            ->select('VIGENCIA_FIN as vigencia')
            ->where('id', $idDoc)
            ->first();
        return $sql;
    }

    static function getIdDocExp($idDoc)
    {
        $sql = DB::table('tram_mdv_usuariordocumento')
            ->select('idDocExpediente as id') 
            ->where('USDO_NIDTRAMITEDOCUMENTO', $idDoc) 
            ->first();
        return $sql;
    }
    
    static function getIdusrTram($idDoc)
    {
        $sql = DB::table('tram_mdv_usuariotramite')
            ->select('USTR_NIDUSUARIO as id') 
            ->where('USTR_NIDUSUARIOTRAMITE', $idDoc) 
            ->first();
        return $sql;
    }

    static function getIdidExp($idDoc)
    {
        $sql = DB::table('tram_mdv_usuariordocumento')
            ->select('USDO_NIDUSUARIORESP') 
            ->where('USDO_NIDTRAMITEDOCUMENTO', $idDoc) 
            ->first();
        return $sql;
    }

    static function getnombDocExp($idDoc)
    {
        $sql = DB::table('tram_mdv_usuariordocumento')
            ->select('USDO_CDOCNOMBRE') 
            ->where('USDO_NIDTRAMITEDOCUMENTO', $idDoc) 
            ->first();
        return $sql;
    }
    static function getuserDocExp($idDoc)
    {
        $sql = DB::table('tram_mdv_usuariordocumento')
            ->select('USDO_NIDUSUARIOBASE') 
            ->where('USDO_NIDTRAMITEDOCUMENTO', $idDoc) 
            ->first();
        return $sql;
    }

    /********* Formulario ******** */

    //Aprobar sección de formulario
    static function TRAM_ACEPTAR_SECCION_FORMULARIO($CONF_NIDUSUARIOTRAMITE, $SSEGTRA_NIDSECCION_SEGUIMIENTO)
    {
        try {

            //Mantenemos el estatus general del trámite en 5 -> Iniciado
            DB::select(
                'UPDATE tram_mdv_usuariotramite SET USTR_NESTATUS = 5 WHERE USTR_NIDUSUARIOTRAMITE = ?',
                array($CONF_NIDUSUARIOTRAMITE)
            );

            //Marcar como aprobador seccion de formulario (SSEGTRA_NIDESTATUS = 2)
            DB::select(
                'UPDATE tram_aux_seccion_seguimiento_tramite SET SSEGTRA_NIDESTATUS = 2 WHERE SSEGTRA_CNOMBRE_SECCION = ? AND SSEGTRA_NIDUSUARIOTRAMITE = ?',
                array('Formulario', $CONF_NIDUSUARIOTRAMITE)
            );

            //Marcamos como aprobadas todas las preguntas y quitamos observaciones
            Cls_Usuario_Respuesta::where(['USRE_NIDUSUARIOTRAMITE' => $CONF_NIDUSUARIOTRAMITE])
                ->update(['USRE_NESTATUS' => 2, 'USRE_COBSERVACION' => ""]);

            //Marcamos como aprobadas todos los documentos y quitas las observaciones
            Cls_Usuario_Documento::where(['USDO_NIDUSUARIOTRAMITE' => $CONF_NIDUSUARIOTRAMITE])
                ->update(['USDO_NESTATUS' => 2, 'USDO_COBSERVACION' => ""]);


            //Validamos estatus final de trámite segun las secciones
            Cls_Seguimiento_Servidor_Publico::validar_seccion_tramite($CONF_NIDUSUARIOTRAMITE);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    //Marcar como incompleta la sección de formulario
    static function TRAM_INCOMPLETA_SECCION_FORMULARIO($CONF_NIDUSUARIOTRAMITE)
    {
        try {
            $hoy = "'".date('y-m-d h:i:s')."'";
            //Mantenemos el estatus general del trámite en 4 -> Información incompleta
            //Ponemos USTR_NBANDERA_PROCESO = 1 para poner texto adicional de si el usuario contesto.
            DB::select(
                'UPDATE tram_mdv_usuariotramite SET USTR_NESTATUS = 4, USTR_NBANDERA_PROCESO = 1, USTR_DFECHAESTATUS = '.$hoy.' WHERE USTR_NIDUSUARIOTRAMITE = ?',
                array($CONF_NIDUSUARIOTRAMITE)
            );

            //Marcar como incompleta seccion de formulario (SSEGTRA_NIDESTATUS = 3)
            DB::select(
                'UPDATE tram_aux_seccion_seguimiento_tramite SET SSEGTRA_NIDESTATUS = 3 WHERE SSEGTRA_CNOMBRE_SECCION = ? AND SSEGTRA_NIDUSUARIOTRAMITE = ?',
                array('Formulario', $CONF_NIDUSUARIOTRAMITE)
            );
        } catch (\Throwable $th) {
            echo $th;
        }
    }

    /********* Revision de documentos ******** */

    //Aprobar revision de documentación
    static function TRAM_ACEPTAR_SECCION_REVISION_DOCUMENTOS($CONF_NIDUSUARIOTRAMITE, $SSEGTRA_NIDSECCION_SEGUIMIENTO)
    {
        try {

            //Mantenemos el estatus general del trámite en 3 -> En revisión
            DB::select(
                'UPDATE tram_mdv_usuariotramite SET USTR_NESTATUS = 3 WHERE USTR_NIDUSUARIOTRAMITE = ?',
                array($CONF_NIDUSUARIOTRAMITE)
            );

            //Marcar como aprobador seccion de revision de documentacion (SSEGTRA_NIDESTATUS = 2)
            DB::select(
                'UPDATE tram_aux_seccion_seguimiento_tramite SET SSEGTRA_NIDESTATUS = 2 WHERE SSEGTRA_NIDSECCION_SEGUIMIENTO = ? AND SSEGTRA_NIDUSUARIOTRAMITE = ?',
                array($SSEGTRA_NIDSECCION_SEGUIMIENTO, $CONF_NIDUSUARIOTRAMITE)
            );

            //Marcamos como aprobadas todas las preguntas y quitamos observaciones
            Cls_Usuario_Respuesta::where(['USRE_NIDUSUARIOTRAMITE' => $CONF_NIDUSUARIOTRAMITE])
                ->update(['USRE_NESTATUS' => 2, 'USRE_COBSERVACION' => ""]);

            //Marcamos como aprobadas todos los documentos y quitamos las observaciones
            Cls_Usuario_Documento::where(['USDO_NIDUSUARIOTRAMITE' => $CONF_NIDUSUARIOTRAMITE])
                ->update(['USDO_NESTATUS' => 2, 'USDO_COBSERVACION' => ""]);


            //Validamos estatus final de trámite segun las secciones
            Cls_Seguimiento_Servidor_Publico::validar_seccion_tramite($CONF_NIDUSUARIOTRAMITE);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    //Marcar como incompleta la sección de formulario
    static function TRAM_INCOMPLETA_SECCION_REVISION_DOCUMENTOS($CONF_NIDUSUARIOTRAMITE, $SSEGTRA_NIDSECCION_SEGUIMIENTO)
    {
        try {

            //Mantenemos el estatus general del trámite en 4 -> Información incompleta
            DB::select(
                'UPDATE tram_mdv_usuariotramite SET USTR_NESTATUS = 4 WHERE USTR_NIDUSUARIOTRAMITE = ?',
                array($CONF_NIDUSUARIOTRAMITE)
            );

            //Marcar como incompleta seccion de formulario (SSEGTRA_NIDESTATUS = 3)
            DB::select(
                'UPDATE tram_aux_seccion_seguimiento_tramite SET SSEGTRA_NIDESTATUS = 3 WHERE SSEGTRA_NIDSECCION_SEGUIMIENTO = ? AND SSEGTRA_NIDUSUARIOTRAMITE = ?',
                array($SSEGTRA_NIDSECCION_SEGUIMIENTO, $CONF_NIDUSUARIOTRAMITE)
            );
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    /********* Cita ******** */

    //Aprobar cita
    static function TRAM_ACEPTAR_SECCION_CITA($CONF_NIDUSUARIOTRAMITE, $SSEGTRA_NIDSECCION_SEGUIMIENTO)
    {
        try {

            //Mantenemos el estatus general del trámite en 3 -> En revisión
            DB::select(
                'UPDATE tram_mdv_usuariotramite SET USTR_NESTATUS = 3 WHERE USTR_NIDUSUARIOTRAMITE = ?',
                array($CONF_NIDUSUARIOTRAMITE)
            );

            //Marcar como aprobado seccion de cita (SSEGTRA_NIDESTATUS = 2)
            DB::select(
                'UPDATE tram_aux_seccion_seguimiento_tramite SET SSEGTRA_NIDESTATUS = 2 WHERE SSEGTRA_NIDSECCION_SEGUIMIENTO = ? AND SSEGTRA_NIDUSUARIOTRAMITE = ?',
                array($SSEGTRA_NIDSECCION_SEGUIMIENTO, $CONF_NIDUSUARIOTRAMITE)
            );

            //Validamos estatus final de trámite segun las secciones
            Cls_Seguimiento_Servidor_Publico::validar_seccion_tramite($CONF_NIDUSUARIOTRAMITE);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    //Marcar como reporgramación de cita
    static function TRAM_REPROGRAMACION_SECCION_CITA($CONF_NIDUSUARIOTRAMITE, $SSEGTRA_NIDSECCION_SEGUIMIENTO)
    {
        try {

            //Mantenemos el estatus general del trámite en 3 -> En revisión
            DB::select(
                'UPDATE tram_mdv_usuariotramite SET USTR_NESTATUS = 3 WHERE USTR_NIDUSUARIOTRAMITE = ?',
                array($CONF_NIDUSUARIOTRAMITE)
            );

            //Marcar como reprogramacion seccion de cita (SSEGTRA_NIDESTATUS = 3)
            DB::select(
                'UPDATE tram_aux_seccion_seguimiento_tramite SET SSEGTRA_NIDESTATUS = 3 WHERE SSEGTRA_NIDSECCION_SEGUIMIENTO = ? AND SSEGTRA_NIDUSUARIOTRAMITE = ?',
                array($SSEGTRA_NIDSECCION_SEGUIMIENTO, $CONF_NIDUSUARIOTRAMITE)
            );
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    /*********** Ventanilla *************/
    //Aprobar ventanilla
    static function TRAM_ACEPTAR_SECCION_VENTANILLA($CONF_NIDUSUARIOTRAMITE, $SSEGTRA_NIDSECCION_SEGUIMIENTO)
    {
        try {

            //Mantenemos el estatus general del trámite en 3 -> En revisión
            DB::select(
                'UPDATE tram_mdv_usuariotramite SET USTR_NESTATUS = 3 WHERE USTR_NIDUSUARIOTRAMITE = ?',
                array($CONF_NIDUSUARIOTRAMITE)
            );

            //Marcar como aprobado la seccion de ventanilla (SSEGTRA_NIDESTATUS = 2)
            DB::select(
                'UPDATE tram_aux_seccion_seguimiento_tramite SET SSEGTRA_NIDESTATUS = 2 WHERE SSEGTRA_NIDSECCION_SEGUIMIENTO = ? AND SSEGTRA_NIDUSUARIOTRAMITE = ?',
                array($SSEGTRA_NIDSECCION_SEGUIMIENTO, $CONF_NIDUSUARIOTRAMITE)
            );

            //Validamos estatus final de trámite segun las secciones
            Cls_Seguimiento_Servidor_Publico::validar_seccion_tramite($CONF_NIDUSUARIOTRAMITE);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    /*********** Pago *************/
    //Aprobar pago
    static function TRAM_ACEPTAR_SECCION_PAGO($CONF_NIDUSUARIOTRAMITE, $SSEGTRA_NIDSECCION_SEGUIMIENTO)
    {
        try {

            //Mantenemos el estatus general del trámite en 3 -> En revisión
            DB::select(
                'UPDATE tram_mdv_usuariotramite SET USTR_NESTATUS = 3 WHERE USTR_NIDUSUARIOTRAMITE = ?',
                array($CONF_NIDUSUARIOTRAMITE)
            );

            //Marcar como aprobado la seccion de pago (SSEGTRA_NIDESTATUS = 2)
            DB::select(
                'UPDATE tram_aux_seccion_seguimiento_tramite SET SSEGTRA_NIDESTATUS = 2 WHERE SSEGTRA_NIDSECCION_SEGUIMIENTO = ? AND SSEGTRA_NIDUSUARIOTRAMITE = ?',
                array($SSEGTRA_NIDSECCION_SEGUIMIENTO, $CONF_NIDUSUARIOTRAMITE)
            );

            //Validamos estatus final de trámite segun las secciones
            Cls_Seguimiento_Servidor_Publico::validar_seccion_tramite($CONF_NIDUSUARIOTRAMITE);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    /*********** Módulo de análisis interno del área *************/
    //Aprobar Módulo de análisis interno del área
    static function TRAM_ACEPTAR_SECCION_ANALISIS_INTERNO($CONF_NIDUSUARIOTRAMITE, $SSEGTRA_NIDSECCION_SEGUIMIENTO)
    {
        try {

            //Mantenemos el estatus general del trámite en 3 -> En revisión
            DB::select(
                'UPDATE tram_mdv_usuariotramite SET USTR_NESTATUS = 3 WHERE USTR_NIDUSUARIOTRAMITE = ?',
                array($CONF_NIDUSUARIOTRAMITE)
            );

            //Marcar como aprobado la seccion de Módulo de análisis interno del área (SSEGTRA_NIDESTATUS = 2)
            DB::select(
                'UPDATE tram_aux_seccion_seguimiento_tramite SET SSEGTRA_NIDESTATUS = 2 WHERE SSEGTRA_NIDSECCION_SEGUIMIENTO = ? AND SSEGTRA_NIDUSUARIOTRAMITE = ?',
                array($SSEGTRA_NIDSECCION_SEGUIMIENTO, $CONF_NIDUSUARIOTRAMITE)
            );

            //Validamos estatus final de trámite segun las secciones
            Cls_Seguimiento_Servidor_Publico::validar_seccion_tramite($CONF_NIDUSUARIOTRAMITE);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    /*********** Resolutivo *************/
    //Emitir resolutivo
    static function TRAM_ACEPTAR_SECCION_RESOLUTIVO($CONF_NIDUSUARIOTRAMITE, $Estatus, $SSEGTRA_NIDSECCION_SEGUIMIENTO)
    {
        try {

            if ($Estatus == 8) {

                //Marcar como aprobado la seccion de Resolutivo Electrónico (SSEGTRA_NIDESTATUS = 2)
                DB::select(
                    'UPDATE tram_aux_seccion_seguimiento_tramite SET SSEGTRA_NIDESTATUS = ? WHERE SSEGTRA_NIDSECCION_SEGUIMIENTO = ? AND SSEGTRA_NIDUSUARIOTRAMITE = ?',
                    array(2, $SSEGTRA_NIDSECCION_SEGUIMIENTO, $CONF_NIDUSUARIOTRAMITE)
                );

                //Validamos estatus final de trámite segun las secciones
                Cls_Seguimiento_Servidor_Publico::validar_seccion_tramite($CONF_NIDUSUARIOTRAMITE);
            } else if ($Estatus == 9) {

                //Cambiamos el estatus general de trámite (8 -> Finalizado, 9 -> Rechazado)
                DB::select(
                    'UPDATE tram_mdv_usuariotramite SET USTR_NESTATUS = ? WHERE USTR_NIDUSUARIOTRAMITE = ?',
                    array(9, $CONF_NIDUSUARIOTRAMITE)
                );

                //Marcar como aprobado la seccion de Resolutivo Electrónico (SSEGTRA_NIDESTATUS = 2)
                DB::select(
                    'UPDATE tram_aux_seccion_seguimiento_tramite SET SSEGTRA_NIDESTATUS = ? WHERE SSEGTRA_NIDSECCION_SEGUIMIENTO = ? AND SSEGTRA_NIDUSUARIOTRAMITE = ?',
                    array(2, $SSEGTRA_NIDSECCION_SEGUIMIENTO, $CONF_NIDUSUARIOTRAMITE)
                );
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    //Guardar el path del resolutivo
    static function TRAM_GUARDAR_PATH_RESOLUTIVO($USRE_NIDUSUARIOTRAMITE, $USRE_CRUTADOC, $USRE_NPESO, $USRE_CEXTENSION, $SSEGTRA_NIDSECCION_SEGUIMIENTO)
    {
        try {

            //Eliminamos resolutivos anteriores
            DB::SELECT(
                'DELETE FROM tram_mdv_usuario_resolutivo where USRE_NIDUSUARIOTRAMITE = ? AND USRE_NIDSECCION = ?',
                array($USRE_NIDUSUARIOTRAMITE, $SSEGTRA_NIDSECCION_SEGUIMIENTO)
            );

            DB::SELECT(
                'INSERT INTO tram_mdv_usuario_resolutivo (USRE_NIDUSUARIOTRAMITE, USRE_CRUTADOC, USRE_NPESO, USRE_CEXTENSION, created_at, updated_at, USRE_NIDSECCION) VALUES (?, ?, ?, ?, ?, ?, ?)',
                array($USRE_NIDUSUARIOTRAMITE, $USRE_CRUTADOC, $USRE_NPESO, $USRE_CEXTENSION, now(), now(), $SSEGTRA_NIDSECCION_SEGUIMIENTO)
            );
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    /*********** RECHARZAR *************/
    //RECHAZAR
    static function TRAM_RECHAZAR_TRAMITE($CONF_NIDUSUARIOTRAMITE, $USTR_CMOTIVORECHAZO)
    {
        try {

            //Mantenemos el estatus general del trámite en 9 -> Rechazar
            DB::select(
                'UPDATE tram_mdv_usuariotramite SET USTR_NESTATUS = 9, USTR_CMOTIVORECHAZO = ?  WHERE USTR_NIDUSUARIOTRAMITE = ?',
                array($USTR_CMOTIVORECHAZO, $CONF_NIDUSUARIOTRAMITE)
            );
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    //-------------- Notificacion ---------------´
    static function crear_notificacion($USTR_NIDUSUARIOTRAMITE, $titulo, $mensaje, $mensaje_corto, $nombre_tramite, $SSEGTRA_NIDSECCION_SEGUIMIENTO, $NTIPO)
    {
        try {

            //TIPO 1 es formulario, 2 es citas y 3 resolutivo

            $user = Auth::user();
            $tramite = Cls_Usuario_Tramite::where(['USTR_NIDUSUARIOTRAMITE' => $USTR_NIDUSUARIOTRAMITE])->first();

            $emisor = $user->USUA_CNOMBRES . " " . $user->USUA_CPRIMER_APELLIDO . " " . $user->USUA_CSEGUNDO_APELLIDO;

            DB::SELECT(
                'INSERT INTO tram_his_notificacion_tramite (HNOTI_CITUTLO, HNOTI_CMENSAJE, HNOTI_NIDUSUARIOTRAMITE, HNOTI_CFOLIO, HNOTI_CNOMBRETRAMITE, HNOTI_NLEIDO,HNOTI_DFECHACREACION,HNOTI_DFECHALEIDO,HNOTI_CEMISOR,HNOTI_ROLEMISOR,HNOTI_CMENSAJECORTO, HNOTI_NIDCONFIGSECCION, HNOTI_NTIPO ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)',
                array($titulo, $mensaje, $tramite->USTR_NIDUSUARIOTRAMITE, $tramite->USTR_CFOLIO, $nombre_tramite, 0, now(), null, $emisor, $user->TRAM_CAT_ROL->ROL_CNOMBRE, $mensaje_corto, $SSEGTRA_NIDSECCION_SEGUIMIENTO, $NTIPO)
            );
        } catch (\Throwable $th) {
        }
    }

    static function obtener_tramite_usuario($NIDUSUARIOTRAMITE)
    {
        $tramite = [];
        try {

            $sql = "call TRAM_SP_OBTENER_TRAMITE_USUARIO_INFO('$NIDUSUARIOTRAMITE')";

            $pdo = DB::connection()->getPdo();
            $pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, true);
            $stmt = $pdo->prepare($sql, [\PDO::ATTR_CURSOR => \PDO::CURSOR_SCROLL]);
            $exec = $stmt->execute();

            //Primer resultado
            $tramite = $stmt->fetchAll(\PDO::FETCH_OBJ);

            $stmt->closeCursor();

            return $tramite;
        } catch (\Throwable $th) {
            return [];
        }
    }

    static function validar_seccion_tramite($NIDUSUARIOTRAMITE)
    {
        try {

            $totalSecciones = Cls_Seccion_Seguimiento::where(['SSEGTRA_NIDUSUARIOTRAMITE' => $NIDUSUARIOTRAMITE])->count();
            $totalSecciones_aprobadas = Cls_Seccion_Seguimiento::where(['SSEGTRA_NIDUSUARIOTRAMITE' => $NIDUSUARIOTRAMITE, 'SSEGTRA_NIDESTATUS' => 2])->count();

            if ($totalSecciones === $totalSecciones_aprobadas) {

                //Cambiamos el estatus general de trámite (8 -> Finalizado, 9 -> Rechazado)
                DB::select(
                    'UPDATE tram_mdv_usuariotramite SET USTR_NESTATUS = 8 WHERE USTR_NIDUSUARIOTRAMITE = ?',
                    array($NIDUSUARIOTRAMITE)
                );
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
