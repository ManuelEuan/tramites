<?php

namespace App;

use Exception;
use App\Models\Cls_Tramite;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Cls_Gestor extends Model
{
    protected $connection   = 'pgsql';
   /*  protected $table        = 'tram_his_bitacora';
    protected $fillable     = ['BITA_NIDBITACORA', 'BITA_NIDUSUARIO', 'BITA_CMOVIMIENTO', 'BITA_CTABLA', 'BITA_FECHAMOVIMIENTO', 'BITA_CIP'];
    protected $primaryKey   = 'BITA_NIDBITACORA';
    public $timestamps      = false; */

    public $StrNombreFormulario;
    public $IntTramite;

    //Atributos para filtro
    public $StrTexto;
    public $IntDependencia;
    public $IntModalidad;
    public $IntClasificacion;
    public $IntNumPagina;
    public $IntCantidadRegistros;
    public $StrOrdenColumna;
    public $StrOrdenDir;
    public $IntUsuarioId;
    public $IntUnidadId;

    //Crear tramite
    public $TRAM_NIDTRAMITE_ACCEDE;
    public $TRAM_NIDTRAMITE_CONFIG;
    public $TRAM_NTIPO;
    public $TRAM_NIDUNIDADADMINISTRATIVA;
    public $TRAM_CUNIDADADMINISTRATIVA;
    public $TRAM_NIDCENTRO;
    public $TRAM_CCENTRO;
    public $TRAM_CNOMBRE;
    public $TRAM_CENCARGADO;
    public $TRAM_CCONTACTO;
    public $TRAM_CDESCRIPCION;
    public $TRAM_NDIASHABILESRESOLUCION;
    public $TRAM_NDIASHABILESNOTIFICACION;
    public $TRAM_NENLACEOFICIAL;
    public $TRAM_NIMPLEMENTADO;
    public $TRAM_NIDFORMULARIO;
    public $TRAM_NESTATUS;

    public $TRAM_NLINEA;
    public $TRAM_NPRESENCIAL;
    public $TRAM_NTELEFONO;
    public $TRAM_CAUDIENCIA;
    public $TRAM_CID_AUDIENCIA;

    public $TRAM_CTRAMITE_JSON;

    //Crear seccion configurado
    public $CONF_NIDTRAMITE;
    public $CONF_NSECCION;
    public $CONF_CNOMBRESECCION;
    public $CONF_ESTATUSSECCION;
    public $CONF_NDIASHABILES;
    public $CONF_CDESCRIPCIONCITA;
    public $CONF_CDESCRIPCIONVENTANILLA;
    public $CONF_NORDEN;
    public $TRAM_SERV_ID;

    //Obtiene los trámites segun filtrado y unidad administrativa
    public function TRAM_SP_CONSULTARTRAMITESERVICIO()
    {

        $sql = "";
        if ($this->IntUsuarioId > 0) {
            $sql = "call TRAM_SP_CONSULTAR_TRAMITE_SERVIDOR_PUBLICO('$this->StrTexto', '$this->IntDependencia', '$this->IntModalidad',
            '$this->IntClasificacion', '$this->IntNumPagina','$this->IntCantidadRegistros', '$this->StrOrdenColumna',
            '$this->StrOrdenDir','$this->IntUsuarioId', '$this->IntUnidadId')";
        } else {
            $sql = "call TRAM_SP_CONSULTAR_TRAMITE_ADMINISTRADOR('$this->StrTexto', '$this->IntDependencia', '$this->IntModalidad',
            '$this->IntClasificacion', '$this->IntNumPagina','$this->IntCantidadRegistros', '$this->StrOrdenColumna',
            '$this->StrOrdenDir','$this->IntUsuarioId', '$this->IntUnidadId')";
        }

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

    //Obtiene el detalle del trámite
    public function TRAM_SP_OBTENER_DETALLE_TRAMITE()
    {
        return DB::select(
            'call TRAM_SP_OBTENER_DETALLE_TRAMITE(?)',
            array(
                $this->TRAM_NIDTRAMITE
            )
        );
    }

   
    //Obtiene detalle de trámite con configuración
    public function TRAM_SP_OBTENER_DETALLE_TRAMITE_CONFIGURACION($tramiteID, $tramiteIDConfig)
    {
        return DB::table('tram_view_tramite_accede')->where([
                            'tram_nidtramite'           => $tramiteID,
                            'tram_nidtramite_config'    => $tramiteIDConfig])
                        ->first();
    }

    //Obtiene los documentos del trámite
    public function TRAM_SP_CONSULTAR_DOCUMENTO_TRAMITE()
    {
        return DB::select(
            'call TRA_SP_CONSULTAR_DOCUMENTOS_TRAMITE(?)',
            array($this->IntTramite)
        );
    }

    //Obtiene la configuración de un trámite
    public function TRAM_CONSULTAR_CONFIGURACION_TRAMITE($TRAM_NIDTRAMITE_CONFIG) {
        $response = array();

        try {
            $tramite = DB::table('tram_mst_tramite')->where('TRAM_NIDTRAMITE', $TRAM_NIDTRAMITE_CONFIG)->get();
            $response['tramite']        = $tramite;
            $response['secciones']      = DB::table('tram_mdv_seccion_tramite')->where('CONF_NIDTRAMITE', $TRAM_NIDTRAMITE_CONFIG)->orderBy('CONF_NORDEN', 'asc')->get();
            $response['formularios']    = DB::table('tram_mst_formulario_tramite')->where('FORM_NIDTRAMITE', $TRAM_NIDTRAMITE_CONFIG)->get();
            $response['documentos']     = DB::table('tram_mdv_documento_tramite')->where('TRAD_NIDTRAMITE', $TRAM_NIDTRAMITE_CONFIG)->get();
            $response['edificios']      = DB::table('tram_mst_edificio')->where('EDIF_NIDTRAMITE', $TRAM_NIDTRAMITE_CONFIG)->get();
            $response['conceptos_pago'] = DB::table('tram_mst_concepto_tramite')->where('CONC_NIDTRAMITE', $TRAM_NIDTRAMITE_CONFIG)->get();
            $response['resolutivos']    = DB::table('tram_mst_resolutivo')->where('RESO_NIDTRAMITE', $TRAM_NIDTRAMITE_CONFIG)->get();
            $response['servicios']      = [];

            if($tramite && count($tramite)>0){
                $response['servicios'] = DB::table('tram_cat_services')->where('SERV_ACTIVE', 1)->where('SERV_ID', $tramite[0]->TRAM_SERV_ID)->get();   
            }

            foreach ($response['resolutivos'] as $key => $resolutivo) {
                $response['resolutivos'][$key]->MAPEO = DB::select(
                    'SELECT trm.*, tfp.FORM_CPREGUNTA FROM tram_mst_resolutivo_mapeo trm
                    INNER JOIN tram_form_pregunta tfp ON trm.TRAM_NIDPRGUNTA = tfp.FORM_NID
                    where trm.TRAM_RESODOCU_NID = ?',
                    array($resolutivo->RESO_NID)
                );
            }

            return $response;
        } catch (Exception $ex) {
            dd($ex);
        }
    }

    //-------------- Metodos de guardado ----------------

    public function TRAM_SP_AGREGAR_SECCION()
    {

        return DB::select(
            'call TRAM_SP_AGREGAR_SECCION_CONFIGURACION(?,?,?,?,?,?,?,?)',
            array(
                $this->CONF_NIDTRAMITE,
                $this->CONF_NSECCION,
                $this->CONF_CNOMBRESECCION,
                $this->CONF_ESTATUSSECCION,
                $this->CONF_NDIASHABILES,
                $this->CONF_CDESCRIPCIONCITA,
                $this->CONF_CDESCRIPCIONVENTANILLA,
                $this->CONF_NORDEN
            )
        );
    }

    public function TRAM_SP_AGREGAR_RESOLUTIVO($RESO_NIDTRAMITE, $RESO_NIDRESOLUTIVO, $RESO_CNOMBRE, $TRAM_NIDSECCION, $RESO_CNAMEFILE)
    {
        $item = new Cls_Resolutivo();
        $item->RESO_NIDTRAMITE = $RESO_NIDTRAMITE;
        $item->TRAD_CNOMBRE = $RESO_NIDTRAMITE;
        $item->RESO_NIDRESOLUTIVO = $RESO_NIDTRAMITE;
        $item->RESO_CNOMBRE = $RESO_NIDTRAMITE;
        $item->TRAD_NOBLIGATORIO = $RESO_NIDTRAMITE;
        $item->RESO_NIDSECCION = $RESO_NIDTRAMITE;
        $item->RESO_CNAMEFILE = $RESO_NIDTRAMITE;
        $item->save();
        
        return $item;
    }

    public function TRAM_SP_AGREGAR_RESOLUTIVO_MAPEO($TRAM_RESODOCU_NID, $TRAM_NIDFORMULARIO, $TRAM_NIDPRGUNTA, $TRAM_CNOMBRECAMPO)
    {
        DB::table('tram_mst_resolutivo_mapeo')->insert([
            'TRAM_RESODOCU_NID'     => $TRAM_RESODOCU_NID,
            'TRAM_NIDFORMULARIO'    => $TRAM_NIDFORMULARIO,
            'TRAM_NIDPRGUNTA'       => $TRAM_NIDPRGUNTA,
            'TRAM_CNOMBRECAMPO'     => $TRAM_CNOMBRECAMPO

        ]);
    }

    //----------- Metodo de eliminacion ---------------------

    public function TRAM_SP_ELIMINAR_SECCION($TRAM_NIDTRAMITE) {
        return  DB::table('tram_mdv_seccion_tramite')->where('CONF_NIDTRAMITE', $TRAM_NIDTRAMITE)->delete();
    }

    public function TRAM_SP_ELIMINAR_DOCUMENTO($TRAM_NIDTRAMITE)
    {

        return DB::select(
            'DELETE FROM tram_mdv_documento_tramite WHERE TRAD_NIDTRAMITE = ?',
            array($TRAM_NIDTRAMITE)
        );
    }

    //Implementar/Desimplementar trámite
    public function TRAM_SP_CAMBIAR_ESTATUS_TRAMITE($TRAM_NIDTRAMITE_CONFIG, $TRAM_NIMPLEMENTADO)
    {
        $response = ["estatus" => "success", "mensaje" => "Se cambio el estatus del trámite", "codigo" => 200 ];
        try {

            $tramite = Cls_Tramite::find($TRAM_NIDTRAMITE_CONFIG);

            //Desimplementamos los trámites anteriores
            if($TRAM_NIMPLEMENTADO > 0){
                Cls_Tramite::where(['TRAM_NIDTRAMITE_ACCEDE' => $tramite->TRAM_NIDACCEDE, 'TRAM_NIDTRAMITE' => $TRAM_NIDTRAMITE_CONFIG])->update(['TRAM_NIMPLEMENTADO' => false]);
            }

            $item = Cls_Tramite::find($TRAM_NIDTRAMITE_CONFIG);
            $item->TRAM_NIMPLEMENTADO = $TRAM_NIMPLEMENTADO;
            $item->save();
        } catch (Exception $ex) {
            $response = [
                "estatus" => "error",
                "mensaje" => "Error al intentar cambiar estatus del trámite, ". $ex->getMessage(),
                "codigo" => 400
            ];
        }

        return $response;
    }

    //Obtiene los conceptos de pago del trámite
    static function TRAM_CONSULTAR_CONCEPTO_TRAMITE($TRAM_NIDTRAMITE_ACCEDE)
    {
        $response = [];
        try {

            $result =  DB::select(
                'SELECT * FROM tram_view_tramite_concepto WHERE Id_Accede = ?',
                array($TRAM_NIDTRAMITE_ACCEDE)
            );

            $response = [
                "estatus" => "success",
                "mensaje" => "Success",
                "codigo" => 200,
                "data" => $result
            ];
        } catch (\Throwable $th) {
            $response = [
                "estatus" => "error",
                "mensaje" => "Error al intentar cambiar estatus del trámite",
                "codigo" => 400
            ];
        }
        return $response;
    }

    //Validar si un usuario puede tener acceso a la configuracion de un tramite segun su TRAM_NIDUNIDAD
    static function TRAM_SP_VALIDAR_UNIDAD_USUARIO_TRAMITE($TRAM_NIDTRAMITE, $TRAM_NIDUSUARIO)
    {
        $response = [
            "acceso" => 0,
            "pertenece" => 0,
        ];

        try {

            $sql = "call TRAM_SP_VALIDAR_UNIDAD_USUARIO_TRAMITE('$TRAM_NIDTRAMITE', '$TRAM_NIDUSUARIO')";

            $pdo = DB::connection()->getPdo();
            $pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, true);
            $stmt = $pdo->prepare($sql, [\PDO::ATTR_CURSOR => \PDO::CURSOR_SCROLL]);
            $exec = $stmt->execute();

            //Primer resultado: Tiene acceso a la unidad
            /* Obtener todos los valores de la primera columna */
            $response['acceso'] = $stmt->fetchAll(\PDO::FETCH_COLUMN, 0)[0];

            //Segundo resultado: Pertenece a la unidad
            /* Obtener todos los valores de la primera columna */
            $stmt->nextRowset();
            $response['pertenece'] = $stmt->fetchAll(\PDO::FETCH_COLUMN, 0)[0];

            $stmt->closeCursor();

            return $response;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    //Obtener los tramites que pertenece y tiene acceso el usuario
    static function TRAM_SP_OBTENER_TRAMITE_ACCESO_PERTENECE_USUARIO($TRAM_NIDUSUARIO)
    {
        try {

            return DB::select(
                'call TRAM_SP_OBTENER_TRAMITE_ACCESO_PERTENECE_USUARIO(?)',
                array(
                    $TRAM_NIDUSUARIO
                )
            );
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    //Obtener los tramites que pertenece y tiene acceso el usuario
    static function TRAM_SP_OBTENER_TRAMITE_ID_ACCEDE($TRAM_NIDTRAMITEACCEDE)
    {
        try {

            return DB::select(
                'call TRAM_SP_OBTENER_TRAMITE_ID(?)',
                array(
                    $TRAM_NIDTRAMITEACCEDE
                )
            );
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    //Obtiene los conceptos de pago del trámite
    static function TRAM_CONSULTAR_SERVICIOS_TRAMITE($TRAM_NIDTRAMITE_ACCEDE)
    {
        $response = ["estatus" => "success",  "mensaje" => "Success","codigo" => 200, "data" => null];
        try {
            $result = DB::table('tram_cat_services')->where('SERV_ACTIVE', true)->get();
            $response["data"] = $result;

        } catch (Exception $ex) {
            $response = [
                "estatus" => "error",
                "mensaje" => "Error al intentar cambiar estatus del trámite, ".$ex->getMessage(),
                "codigo" => 400
            ];
        }
        return $response;
    }
}
