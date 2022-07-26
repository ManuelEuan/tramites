<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class Cls_Gestor extends Model
{
    protected $connection = 'mysql';
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

    //Obtiene los formularios activos
    public function TRAM_SP_CONSULTAR_FORMULARIO()
    {
        return DB::select(
            'call TRAM_SP_CONSULTAR_FORMULARIO(?)',
            array($this->StrNombreFormulario)
        );
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
    public function TRAM_SP_OBTENER_DETALLE_TRAMITE_CONFIGURACION()
    {
        return DB::select(
            'call TRAM_SP_OBTENER_DETALLE_TRAMITE_CONFIGURACION(?,?)',
            array(
                $this->TRAM_NIDTRAMITE,
                $this->TRAM_NIDTRAMITE_CONFIG
            )
        );
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
    public function TRAM_CONSULTAR_CONFIGURACION_TRAMITE($TRAM_NIDTRAMITE_CONFIG)
    {
        $response = [
            'tramite' => null,
            'secciones' => [],
            'formularios' => [],
            'documentos' => [],
            'edificios' => [],
            'resolutivos' => [],
            'conceptos_pago' => [],
        ];

        try {

            $response['tramite'] = DB::select(
                'SELECT * FROM tram_mst_tramite where TRAM_NIDTRAMITE = ?',
                array($TRAM_NIDTRAMITE_CONFIG)
            );

            $response['secciones'] = DB::select(
                'SELECT * FROM tram_mdv_seccion_tramite where CONF_NIDTRAMITE = ? ORDER BY CONF_NORDEN ASC ',
                array($TRAM_NIDTRAMITE_CONFIG)
            );

            $response['formularios'] = DB::select(
                'SELECT * FROM tram_mst_formulario_tramite where FORM_NIDTRAMITE = ?',
                array($TRAM_NIDTRAMITE_CONFIG)
            );

            $response['documentos'] = DB::select(
                'SELECT * FROM tram_mdv_documento_tramite where TRAD_NIDTRAMITE = ?',
                array($TRAM_NIDTRAMITE_CONFIG)
            );

            $response['edificios'] = DB::select(
                'SELECT * FROM tram_mst_edificio where EDIF_NIDTRAMITE = ?',
                array($TRAM_NIDTRAMITE_CONFIG)
            );

            $response['resolutivos'] = DB::select(
                'SELECT * FROM tram_mst_resolutivo where RESO_NIDTRAMITE = ?',
                array($TRAM_NIDTRAMITE_CONFIG)
            );

            $response['conceptos_pago'] = DB::select(
                'SELECT * FROM tram_mst_concepto_tramite where CONC_NIDTRAMITE = ?',
                array($TRAM_NIDTRAMITE_CONFIG)
            );

            return $response;

        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    //-------------- Metodos de guardado ----------------

    public function TRAM_SP_AGREGAR_TRAMITE()
    {
        return DB::select(
            'call TRAM_SP_AGREGAR_TRAMITE(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',
            array(
                $this->TRAM_NIDTRAMITE_ACCEDE,
                $this->TRAM_NIDTRAMITE_CONFIG,
                $this->TRAM_NDIASHABILESRESOLUCION,
                $this->TRAM_NDIASHABILESNOTIFICACION,
                $this->TRAM_NIDFORMULARIO,
                $this->TRAM_NENLACEOFICIAL,

                $this->TRAM_NIDUNIDADADMINISTRATIVA,
                $this->TRAM_CUNIDADADMINISTRATIVA,
                $this->TRAM_NIDCENTRO,
                $this->TRAM_CCENTRO,
                $this->TRAM_CNOMBRE,
                $this->TRAM_CENCARGADO,
                $this->TRAM_CCONTACTO,
                $this->TRAM_CDESCRIPCION,
                $this->TRAM_NTIPO,

                $this->TRAM_NLINEA,
                $this->TRAM_NPRESENCIAL,
                $this->TRAM_NTELEFONO,
                $this->TRAM_CAUDIENCIA,
                $this->TRAM_CID_AUDIENCIA,

                $this->TRAM_CTRAMITE_JSON
            )
        );
    }

    public function TRAM_SP_AGREGAR_SECCION(){

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

    public function TRAM_SP_AGREGAR_FORMULARIO($TRAM_NIDFORMULARIO, $TRAM_NIDTRAMITE)
    {
        return DB::select(
            'call TRAM_SP_AGREGAR_FORMULARIO_TRAMITE(?, ?)',
            array(
                $TRAM_NIDFORMULARIO,
                $TRAM_NIDTRAMITE
            )
        );
    }

    public function TRAM_SP_AGREGAR_DOCUMENTO($TRAD_NIDTRAMITE, $TRAD_NIDDOCUMENTO, $TRAD_CNOMBRE, $TRAD_CDESCRIPCION, $TRAD_CEXTENSION, $TRAD_NOBLIGATORIO, $TRAD_NMULTIPLE)
    {
        return DB::select(
            'call TRAM_SP_AGREGAR_DOCUMENTO_TRAMITE(?,?,?,?,?,?,?)',
            array(
                $TRAD_NIDTRAMITE,
                $TRAD_NIDDOCUMENTO,
                $TRAD_CNOMBRE,
                $TRAD_CDESCRIPCION,
                $TRAD_CEXTENSION,
                $TRAD_NOBLIGATORIO,
                $TRAD_NMULTIPLE
            )
        );
    }

    public function TRAM_SP_AGREGAR_EDIFICIO_TRAMITE($EDIF_NIDTRAMITE, $EDIF_CNOMBRE, $TRAM_NIDSECCION, $TRAM_NCALLE, $TRAM_CLATITUD, $TRAM_CLONGITUD, $TRAM_NIDEDIFICIO)
    {
        return DB::select(
            'call TRAM_SP_AGREGAR_EDIFICIO_TRAMITE(?, ?, ?, ?, ?, ?, ?)',
            array(
                $EDIF_NIDTRAMITE,
                $EDIF_CNOMBRE,
                $TRAM_NIDSECCION,
                $TRAM_NCALLE,
                $TRAM_CLATITUD,
                $TRAM_CLONGITUD,
                $TRAM_NIDEDIFICIO
            )
        );
    }

    public function TRAM_SP_AGREGAR_RESOLUTIVO($RESO_NIDTRAMITE, $RESO_NIDRESOLUTIVO, $RESO_CNOMBRE, $TRAM_NIDSECCION)
    {
        return DB::select(
            'call TRAM_SP_AGREGAR_RESOLUTIVO(?,?,?,?)',
            array(
                $RESO_NIDTRAMITE,
                $RESO_NIDRESOLUTIVO,
                $RESO_CNOMBRE,
                $TRAM_NIDSECCION
            )
        );
    }

    public function TRAM_SP_AGREGAR_CONCEPTO(array $conceptos)
    {
        DB::select(
            'INSERT INTO tram_mst_concepto_tramite (CONC_NIDCONCEPTO, CONC_NIDTRAMITE, CONC_NIDTRAMITE_ACCEDE, CONC_NREFERENCIA, CONC_CONCEPTO, CONC_CTRAMITE, CONC_CENTE_PUBLICO, CONC_CENTE, CONC_NIDSECCION) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)',
            $conceptos
        );
    }

    //----------- Metodo de eliminacion ---------------------

    public function TRAM_SP_ELIMINAR_FORMULARIO($FORM_NIDTRAMITE)
    {
        DB::select(
            'DELETE FROM tram_mst_formulario_tramite WHERE FORM_NIDTRAMITE = ? ',
            array($FORM_NIDTRAMITE)
        );
    }

    public function TRAM_SP_ELIMINAR_SECCION($TRAM_NIDTRAMITE){

        return DB::select(
            'DELETE FROM tram_mdv_seccion_tramite WHERE CONF_NIDTRAMITE = ?',
            array($TRAM_NIDTRAMITE)
        );
    }

    public function TRAM_SP_ELIMINAR_DOCUMENTO($TRAM_NIDTRAMITE){

        return DB::select(
            'DELETE FROM tram_mdv_documento_tramite WHERE TRAD_NIDTRAMITE = ?',
            array($TRAM_NIDTRAMITE)
        );
    }

    public function TRAM_SP_ELIMINAR_EDIFICIO($EDIF_NIDTRAMITE){

        return DB::select(
            'DELETE FROM tram_mst_edificio WHERE EDIF_NIDTRAMITE = ?',
            array($EDIF_NIDTRAMITE)
        );
    }

    public function TRAM_SP_ELIMINAR_RESOLUTIVO($TRAM_NIDTRAMITE){

        return DB::select(
            'DELETE FROM tram_mst_resolutivo WHERE RESO_NIDTRAMITE = ?',
            array($TRAM_NIDTRAMITE)
        );
    }

    public function TRAM_SP_ELIMINAR_CONCEPTO($TRAM_NIDTRAMITE){

        return DB::select(
            'DELETE FROM tram_mst_concepto_tramite WHERE CONC_NIDTRAMITE = ?',
            array($TRAM_NIDTRAMITE)
        );
    }

    //Implementar/Desimplementar trámite
    public function TRAM_SP_CAMBIAR_ESTATUS_TRAMITE($TRAM_NIDTRAMITE_CONFIG, $TRAM_NIMPLEMENTADO)
    {
        $response = [];
        try {

            $tramite = DB::select(
                'SELECT TRAM_NIDTRAMITE_ACCEDE FROM tram_mst_tramite WHERE TRAM_NIDTRAMITE = ?',
                array($TRAM_NIDTRAMITE_CONFIG)
            );

            $TRAM_NIDACCEDE = $tramite[0]->TRAM_NIDTRAMITE_ACCEDE;

            //Desimplementamos los trámites anteriores
            if ($TRAM_NIMPLEMENTADO > 0) {
                DB::select(
                    'UPDATE tram_mst_tramite SET TRAM_NIMPLEMENTADO = 0 WHERE TRAM_NIDTRAMITE_ACCEDE = ? AND TRAM_NIDTRAMITE != ?',
                    array($TRAM_NIDACCEDE, $TRAM_NIDTRAMITE_CONFIG)
                );
            }

            //Implementamos/Desimplementamos el Trámite en cuestión
            DB::select(
                'UPDATE tram_mst_tramite SET TRAM_NIMPLEMENTADO = ? WHERE TRAM_NIDTRAMITE = ?',
                array($TRAM_NIMPLEMENTADO, $TRAM_NIDTRAMITE_CONFIG)
            );

            $response = [
                "estatus" => "success",
                "mensaje" => "Se cambio el estatus del trámite",
                "codigo" => 200
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
        $response=[
            "acceso"=> 0,
            "pertenece"=> 0,
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
}
