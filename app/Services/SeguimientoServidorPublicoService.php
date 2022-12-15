<?php

namespace App\Services;

use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Cls_TramiteEdificio;
use Illuminate\Support\Facades\Auth;

class SeguimientoServidorPublicoService
{    
    /**
     * ACTUALIZAR_STATUS
     *
     * @param  mixed $folio
     * @return void
     */
    static function ACTUALIZAR_STATUS($folio){
        $rsp = DB::table('tram_mdv_usuariotramite')
        ->where('USTR_CFOLIO', $folio)
        ->update(['USTR_NESTATUS' => 10]);
        return $rsp;
    }
    
    /**
     * ACTUALIZAR_STATUS_VENCIDO
     *
     * @param  mixed $folio
     * @return void
     */
    static function ACTUALIZAR_STATUS_VENCIDO($folio){
        $rsp = DB::table('tram_mdv_usuariotramite')
        ->where('USTR_CFOLIO', $folio)
        ->update(['USTR_NESTATUS' => 11]);
        return $rsp;
    }
    
    /**
     * OBTENER_ID_POR_FECHA
     *
     * @param  mixed $inicio
     * @param  mixed $fin
     * @return array
     */
    static function OBTENER_ID_POR_FECHA($inicio, $fin){
        $sql = "SELECT USTR_NIDUSUARIOTRAMITE FROM tram_mdv_usuariotramite WHERE CAST(created_at AS DATE) >= '".$inicio."' AND CAST(created_at AS DATE) <= '".$fin."'";
        $query = DB::table($sql);
        return $query;
    }
    
    /**
     * TramiteSeguimiento
     *
     * @param  mixed $id
     * @return array
     */
    static function TramiteSeguimiento($id){
        $query  = DB::table('tram_vw_tramite_seguimiento')
                        ->where('USTR_NIDUSUARIOTRAMITE', $id)->get();
        return $query;
    }
    
    /**
     * TramiteSecciones
     *
     * @param  mixed $id
     * @return array
     */
    static function TramiteSecciones($id){
        $query  = DB::table('tram_mdv_seccion_tramite')
                        ->where('CONF_NIDTRAMITE', $id)
                        ->orderBy('CONF_NORDEN')->get();
        return $query;
    }
    
    /**
     * TramiteFormulario
     *
     * @param  mixed $id
     * @return array
     */
    static function TramiteFormulario($id){
        $query  = DB::table('tram_mst_formulario_tramite')
                        ->where('FORM_NIDTRAMITE', $id)->get();
        return $query;
    }
    
    /**
     * TramiteSeccionesFormulario
     *
     * @param  mixed $id
     * @return array
     */
    static function TramiteSeccionesFormulario($id){
        $query  = DB::table('tram_cat_secciones')
                        ->where('FORM_BACTIVO', 1)->get();
        return $query;
    }
    
    /**
     * TramiteDocumentos
     *
     * @param  mixed $id
     * @return array
     */
    static function TramiteDocumentos($id){
        $query  = DB::table('tram_mdv_documento_tramite')
                        ->where('TRAD_NIDTRAMITE', $id)->get();
        return $query;
    }

    /**
     * TramiteResolutivos
     *
     * @param  mixed $id
     * @return array
     */
    static function TramiteResolutivos($id){
        $query  = DB::table('tram_mst_resolutivo')
                        ->where('RESO_NIDTRAMITE', $id)->get();
        return $query;
    }

    static function TramiteSeccionSeguimiento($id){
        $query  = DB::table('tram_aux_seccion_seguimiento_tramite')
                        ->where('SSEGTRA_NIDUSUARIOTRAMITE', $id)
                        ->orderBy('SSEGTRA_NIDSECCION_SEGUIMIENTO')->get();
        return $query;
    }
        
    /**
     * TRAM_CONSULTAR_CONFIGURACION_TRAMITE_PUBLICO
     *
     * @param  mixed $TRAM_NIDTRAMITE_CONFIG
     * @return array
     */
    static function TRAM_CONSULTAR_CONFIGURACION_TRAMITE_PUBLICO($TRAM_NIDTRAMITE_CONFIG)
    {
        $USTR_NIDTRAMITE = DB::table('tram_vw_tramite_seguimiento')->where('USTR_NIDUSUARIOTRAMITE', $TRAM_NIDTRAMITE_CONFIG)->first()->USTR_NIDTRAMITE;

        $response = [
            'tramite' => null,
            'secciones' => [],
            'formularios' => [],
            'documentos' => [],
            'edificios' => [],
            'resolutivos' => [],
        ];

        try {
            //Primer resultado: Datos trámite en seguimiento
            $response['tramite'] = SeguimientoServidorPublicoService::TramiteSeguimiento($TRAM_NIDTRAMITE_CONFIG);

            //Segundo resultado: Secciones del trámite
            $response['secciones'] = SeguimientoServidorPublicoService::TramiteSecciones($USTR_NIDTRAMITE);

            //Tercer resultado: Formulario del trámite
            $formularios = SeguimientoServidorPublicoService::TramiteFormulario($USTR_NIDTRAMITE);

            //Cuarto resultado: Secciones del formulario activo
            $secciones = SeguimientoServidorPublicoService::TramiteSeccionesFormulario($USTR_NIDTRAMITE);

            //Quinto resultado: Secciones de documentos
            $response['documentos'] = SeguimientoServidorPublicoService::TramiteDocumentos($USTR_NIDTRAMITE);

            //Sexto resultado: Secciones de edificios
            $response['edificios'] = Cls_TramiteEdificio::where('EDIF_NIDTRAMITE', $USTR_NIDTRAMITE)->get();

            //Septimo resultado: Secciones de resolutivos
            $response['resolutivos'] = SeguimientoServidorPublicoService::TramiteResolutivos($USTR_NIDTRAMITE);

            foreach ($formularios as $form) {
                $form->secciones = [];
                foreach ($secciones as $sec) {
                    $sec->preguntas = DB::table('tram_form_pregunta as a')
                    ->join('tram_form_pregunta_respuestas as b', 'a.FORM_NID', '=', 'b.FORM_NPREGUNTAID')
                    ->select('a.FORM_NID','a.FORM_NFORMULARIOID','a.FORM_NSECCIONID', 'a.FORM_CPREGUNTA', 'b.FORM_CTIPORESPUESTA')
                    ->where(['a.FORM_NFORMULARIOID'=> $form->FORM_NIDFORMULARIO, 'a.FORM_NSECCIONID' => $sec->FORM_NID])
                    ->groupBy('a.FORM_NID', 'a.FORM_NFORMULARIOID', 'a.FORM_NSECCIONID', 'a.FORM_CPREGUNTA', 'b.FORM_CTIPORESPUESTA')->get();
                    
                    /*DB::select(
                        'SELECT a.FORM_NID, a.FORM_NFORMULARIOID, a.FORM_NSECCIONID, a.FORM_CPREGUNTA, b.FORM_CTIPORESPUESTA FROM tram_form_pregunta as a
                        JOIN tram_form_pregunta_respuestas as b on a.FORM_NID = b.FORM_NPREGUNTAID
                        WHERE a.FORM_NFORMULARIOID = ? and a.FORM_NSECCIONID = ?
                        GROUP BY a.FORM_NID, a.FORM_NFORMULARIOID, a.FORM_NSECCIONID, a.FORM_CPREGUNTA, b.FORM_CTIPORESPUESTA',
                        array($form->FORM_NIDFORMULARIO, $sec->FORM_NID)
                    );*/

                    foreach ($sec->preguntas as $preg) {
                        $preg->respuestas = DB::table('tram_form_pregunta_respuestas as a')
                        ->leftJoin('tram_form_pregunta_respuestas_especial as b', 'b.FORM_NPREGUNTARESPUESTAID', '=', 'a.FORM_NID')
                        ->select('a.FORM_NID','a.FORM_NPREGUNTAID','a.FORM_CTIPORESPUESTA', 'a.FORM_CVALOR', 'b.FORM_CTIPORESPUESTA', 'a.FORM_BBLOQUEAR', 'b.FORM_CTIPORESPUESTA as FORM_CTIPORESPUESTAESPECIAL')
                        ->where(['a.FORM_NPREGUNTAID'=> $preg->FORM_NID])
                        ->groupBy('a.FORM_NID', 'a.FORM_NPREGUNTAID', 'a.FORM_CTIPORESPUESTA', 'a.FORM_CVALOR', 'b.FORM_CTIPORESPUESTA', 'a.FORM_BBLOQUEAR', 'b.FORM_CTIPORESPUESTA')->get();
                        
                        /*DB::select(
                            'SELECT a.FORM_NID, a.FORM_NPREGUNTAID, a.FORM_CTIPORESPUESTA, a.FORM_CVALOR, a.FORM_BBLOQUEAR, b.FORM_CTIPORESPUESTA as FORM_CTIPORESPUESTAESPECIAL
                        FROM tram_form_pregunta_respuestas as a
                        LEFT JOIN tram_form_pregunta_respuestas_especial as b on b.FORM_NPREGUNTARESPUESTAID = a.FORM_NID
                        WHERE a.FORM_NPREGUNTAID = ?
                        GROUP BY a.FORM_NID, a.FORM_NPREGUNTAID, a.FORM_CTIPORESPUESTA, a.FORM_CVALOR, a.FORM_BBLOQUEAR, b.FORM_CTIPORESPUESTA',
                            array($preg->FORM_NID)
                        );*/
                        

                        foreach ($preg->respuestas as $resp) {
                            $resp->respuestas_especial =  DB::table('tram_form_pregunta_respuestas_especial')
                            ->where('FORM_NPREGUNTARESPUESTAID', $resp->FORM_NID)->get();
                            //DB::select('SELECT * FROM tram_form_pregunta_respuestas_especial where FORM_NPREGUNTARESPUESTAID = ?', [$resp->FORM_NID]);
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
            return DB::table('tram_vw_tramite_seguimiento')
            ->where('USTR_NIDUSUARIOTRAMITE', $TRAM_NIDTRAMITE_CONFIG)->get();
        } catch (\Throwable $th) {
            return [
                "error" => $th
            ];
        }
    }

    static function TRAM_OBTENER_SECCIONES_ESTATUS($NIDUSUARIOTRAMITE)
    {
        try {
            /*return DB::select(
                'SELECT * FROM tram_aux_seccion_seguimiento_tramite WHERE SSEGTRA_NIDUSUARIOTRAMITE = ?',
                array($NIDUSUARIOTRAMITE)
            );*/
            return DB::table('tram_aux_seccion_seguimiento_tramite')
            ->where('SSEGTRA_NIDUSUARIOTRAMITE', $NIDUSUARIOTRAMITE)->get();
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    static function TRAM_OBTENER_RESOLUTIVOS_FINALES($NIDUSUARIOTRAMITE)
    {
        try {
            /*return DB::select(
                'SELECT * FROM tram_mdv_usuario_resolutivo WHERE USRE_NIDUSUARIOTRAMITE = ?',
                array($NIDUSUARIOTRAMITE)
            );*/
            return DB::table('tram_mdv_usuario_resolutivo')
            ->where('USRE_NIDUSUARIOTRAMITE', $NIDUSUARIOTRAMITE)->get();
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    static function TRAM_OBTENER_RESOLUTIVOS_CONFIGURADOS($NIDTRAMITE)
    {
        try {
            /*return DB::select(
                'SELECT * FROM tram_mst_resolutivo WHERE RESO_NIDTRAMITE = ?',
                array($NIDTRAMITE)
            );*/
            return DB::table('tram_mst_resolutivo')
            ->where('RESO_NIDTRAMITE', $NIDTRAMITE)->get();
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    static function TRAM_OBTENER_RESOLUTIVO($NIDRESOLUTIVO)
    {
        try {
            /*return DB::select(
                'SELECT * FROM tram_mst_resolutivo WHERE RESO_NID = ?',
                array($NIDRESOLUTIVO)
            );*/
            return DB::table('tram_mst_resolutivo')
            ->where('RESO_NID', $NIDRESOLUTIVO)->get();
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    //Marcar de Recibido el estatus del trámite del ciudadano
    static function TRAM_MARCAR_ESTATUS_REVISION_TRAMITE($CONF_NIDUSUARIOTRAMITE)
    {
        try {
            $tramite = DB::table('tram_mdv_usuariotramite')->where('USTR_NIDUSUARIOTRAMITE', $CONF_NIDUSUARIOTRAMITE)->first();

            /*$tramite = DB::select(
                'SELECT * FROM tram_mdv_usuariotramite WHERE USTR_NIDUSUARIOTRAMITE = ?',
                array($CONF_NIDUSUARIOTRAMITE)
            );*/

            //Marcamos como Recibido->3 en caso de que no este aún
            if ($tramite->USTR_NESTATUS <= 2) {
                DB::table('tram_mdv_usuariotramite')->where('USTR_NIDUSUARIOTRAMITE', $CONF_NIDUSUARIOTRAMITE)->update([
                'USTR_NESTATUS' => 3
                ]);

                /*DB::select(
                    'UPDATE tram_mdv_usuariotramite SET USTR_NESTATUS = 3 WHERE USTR_NIDUSUARIOTRAMITE = ?',
                    array($CONF_NIDUSUARIOTRAMITE)
                );*/
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    static function UsuarioRespuestas($id){
        $query  = DB::table('tram_mdv_usuariorespuestas')
                        ->where('USRE_NIDUSUARIOTRAMITE', $id)->get();
        return $query;
    }

     
    static function UsuarioDocumentos($id){
        $query  = DB::table('tram_mdv_usuariordocumento')
                        ->where('USDO_NIDUSUARIOTRAMITE', $id)->get();
        return $query;
    }
   
}
