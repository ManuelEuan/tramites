<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use PDO;
use PhpParser\Node\Stmt\Switch_;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class Cls_Vista_Accede extends Model
{

    static function VW_ACCEDE_TRAMITE(){
       	$user = "SIGETYSC";
    	$pass = "td788T6VB92mKNKr";
    	$name = "devinfo";
    	$host = "10.18.29.107";
    	$tns = "(DESCRIPTION =(ADDRESS_LIST =(ADDRESS = (PROTOCOL = TCP) (HOST = ".$host.")(PORT = 1521)))(CONNECT_DATA = (SID = ".$name.")))";
	    $response = [];
        try
        {
            $conn = new \PDO("oci:dbname=".$tns.";charset=UTF8",$user,$pass);
            $consulta = $conn->query('SELECT * from SIGETYSC.VW_ACCEDE_TRAMITE');

            foreach($consulta as $row)
            {
                array_push($response, $row);
            }
        }
        catch(PDOException $e)
        {
            echo ($e->getMessage());
        }
	    return $response;
    }

    static function VW_ACCEDE_TRAMITE_ID($id){
        $user = "SIGETYSC";
        $pass = "td788T6VB92mKNKr";
        $name = "devinfo";
        $host = "10.18.29.107";
        $tns = "(DESCRIPTION =(ADDRESS_LIST =(ADDRESS = (PROTOCOL = TCP) (HOST = ".$host.")(PORT = 1521)))(CONNECT_DATA = (SID = ".$name.")))";
        $response = [];
        try
        {
            $conn = new \PDO("oci:dbname=".$tns.";charset=UTF8",$user,$pass);
            $consulta = $conn->query('SELECT * from SIGETYSC.VW_ACCEDE_TRAMITE WHERE SIGETYSC.VW_ACCEDE_TRAMITE.ID_TRAM =' .$id);
            //dd($consulta);

            foreach($consulta as $row)
            {
                array_push($response, $row);
            }
        }
        catch(PDOException $e)
        {
            echo ($e->getMessage());
        }
        return $response[0];
    }

    static function VW_ACCEDE_TRAMITE_ID_UNIDAD($id){
        $user = "SIGETYSC";
        $pass = "td788T6VB92mKNKr";
        $name = "devinfo";
        $host = "10.18.29.107";
        $tns = "(DESCRIPTION =(ADDRESS_LIST =(ADDRESS = (PROTOCOL = TCP) (HOST = ".$host.")(PORT = 1521)))(CONNECT_DATA = (SID = ".$name.")))";
        $response = [];
        try
        {
            $conn = new \PDO("oci:dbname=".$tns.";charset=UTF8",$user,$pass);
            $consulta = $conn->query('SELECT * from SIGETYSC.VW_ACCEDE_TRAMITE WHERE SIGETYSC.VW_ACCEDE_TRAMITE.ID_UNIDAD in (' .$id . ')');
            //dd($consulta);

            foreach($consulta as $row)
            {
                array_push($response, $row);
            }
        }
        catch(PDOException $e)
        {
            echo ($e->getMessage());
        }
        return $response;
    }

    static function VW_ACCEDE_TRAMITEDIFICIO(){
        $user = "SIGETYSC";
        $pass = "td788T6VB92mKNKr";
        $name = "devinfo";
        $host = "10.18.29.107";
        $tns = "(DESCRIPTION =(ADDRESS_LIST =(ADDRESS = (PROTOCOL = TCP) (HOST = ".$host.")(PORT = 1521)))(CONNECT_DATA = (SID = ".$name.")))";
        $response = [];
        try
        {
            $conn = new \PDO("oci:dbname=".$tns.";charset=UTF8",$user,$pass);
            $consulta = $conn->query('SELECT * from SIGETYSC.VW_ACCEDE_TRAMITEDIFICIO');

            foreach($consulta as $row)
            {
                array_push($response, $row);
            }
        }
        catch(PDOException $e)
        {
            echo ($e->getMessage());
        }
        return $response;
    }

    static function VW_ACCEDE_EDIFICIOS(){
        $user = "SIGETYSC";
        $pass = "td788T6VB92mKNKr";
        $name = "devinfo";
        $host = "10.18.29.107";
        $tns = "(DESCRIPTION =(ADDRESS_LIST =(ADDRESS = (PROTOCOL = TCP) (HOST = ".$host.")(PORT = 1521)))(CONNECT_DATA = (SID = ".$name.")))";
        $response = [];
        try
        {
            $conn = new \PDO("oci:dbname=".$tns.";charset=UTF8",$user,$pass);
            $consulta = $conn->query('SELECT * from SIGETYSC.VW_ACCEDE_EDIFICIOS');

            foreach($consulta as $row)
            {
                array_push($response, $row);
            }
        }
        catch(PDOException $e)
        {
            echo ($e->getMessage());
        }
        return $response;
    }

    static function VW_ACCEDE_EDIFICIOS_ID($id){
        $user = "SIGETYSC";
        $pass = "td788T6VB92mKNKr";
        $name = "devinfo";
        $host = "10.18.29.107";
        $tns = "(DESCRIPTION =(ADDRESS_LIST =(ADDRESS = (PROTOCOL = TCP) (HOST = ".$host.")(PORT = 1521)))(CONNECT_DATA = (SID = ".$name.")))";
        $response = [];
        try
        {
            $conn = new \PDO("oci:dbname=".$tns.";charset=UTF8",$user,$pass);
            $consulta = $conn->query('SELECT * from SIGETYSC.VW_ACCEDE_EDIFICIOS WHERE SIGETYSC.VW_ACCEDE_EDIFICIOS.ID_EDIFICIO =' .$id);

            foreach($consulta as $row)
            {
                array_push($response, $row);
            }
        }
        catch(PDOException $e)
        {
            echo ($e->getMessage());
        }
        return $response[0];
    }

    static function VW_ACCEDE_TRAMITEDOCUMENTO(){
        $user = "SIGETYSC";
        $pass = "td788T6VB92mKNKr";
        $name = "devinfo";
        $host = "10.18.29.107";
        $tns = "(DESCRIPTION =(ADDRESS_LIST =(ADDRESS = (PROTOCOL = TCP) (HOST = ".$host.")(PORT = 1521)))(CONNECT_DATA = (SID = ".$name.")))";
        $response = [];
        try
        {
            $conn = new \PDO("oci:dbname=".$tns.";charset=UTF8",$user,$pass);
            $consulta = $conn->query('SELECT * from SIGETYSC.VW_ACCEDE_TRAMITEDOCUMENTO');

            foreach($consulta as $row)
            {
                array_push($response, $row);
            }
        }
        catch(PDOException $e)
        {
            echo ($e->getMessage());
        }
        return $response;
    }

    static function VW_ACCEDE_TRAMITEDOCUMENTO_TRAM_ID($id){
        $user = "SIGETYSC";
        $pass = "td788T6VB92mKNKr";
        $name = "devinfo";
        $host = "10.18.29.107";
        $tns = "(DESCRIPTION =(ADDRESS_LIST =(ADDRESS = (PROTOCOL = TCP) (HOST = ".$host.")(PORT = 1521)))(CONNECT_DATA = (SID = ".$name.")))";
        $response = [];
        try
        {
            $conn = new \PDO("oci:dbname=".$tns.";charset=UTF8",$user,$pass);
            //SELECT * FROM CIGV2.vw_accede_documentos WHERE ID_DOCTRAMITE=357
            $consulta = $conn->query('SELECT * from SIGETYSC.VW_ACCEDE_DOCUMENTOS WHERE SIGETYSC.VW_ACCEDE_DOCUMENTOS.ID_DOCTRAMITE ='.$id);

            foreach($consulta as $row)
            {
                array_push($response, $row);
            }
        }
        catch(PDOException $e)
        {
            echo ($e->getMessage());
        }
        return $response;
    }

    static function VW_ACCEDE_DOCUMENTOS(){
        $user = "SIGETYSC";
        $pass = "td788T6VB92mKNKr";
        $name = "devinfo";
        $host = "10.18.29.107";
        $tns = "(DESCRIPTION =(ADDRESS_LIST =(ADDRESS = (PROTOCOL = TCP) (HOST = ".$host.")(PORT = 1521)))(CONNECT_DATA = (SID = ".$name.")))";
        $response = [];
        try
        {
            $conn = new \PDO("oci:dbname=".$tns.";charset=UTF8",$user,$pass);
            $consulta = $conn->query('SELECT * from SIGETYSC.VW_ACCEDE_DOCUMENTOS');

            foreach($consulta as $row)
            {
                array_push($response, $row);
            }
        }
        catch(PDOException $e)
        {
            echo ($e->getMessage());
        }
        return $response;
    }

    static function VW_ACCEDE_TRAMLEGA($id){
        $user = "SIGETYSC";
        $pass = "td788T6VB92mKNKr";
        $name = "devinfo";
        $host = "10.18.29.107";
        $tns = "(DESCRIPTION =(ADDRESS_LIST =(ADDRESS = (PROTOCOL = TCP) (HOST = ".$host.")(PORT = 1521)))(CONNECT_DATA = (SID = ".$name.")))";
        $response = [];
        try
        {
            $conn = new \PDO("oci:dbname=".$tns.";charset=UTF8",$user,$pass);
            $consulta = $conn->query('SELECT * from SIGETYSC.VW_ACCEDE_TRAMLEGA WHERE SIGETYSC.VW_ACCEDE_TRAMLEGA.TRAM_LEGA =' .$id);

            foreach($consulta as $row)
            {
                array_push($response, $row);
            }
        }
        catch(PDOException $e)
        {
            echo ($e->getMessage());
        }
        return $response;
    }

    static function VW_ACCEDE_CENTROTRABAJO(){
        $user = "SIGETYSC";
        $pass = "td788T6VB92mKNKr";
        $name = "devinfo";
        $host = "10.18.29.107";
        $tns = "(DESCRIPTION =(ADDRESS_LIST =(ADDRESS = (PROTOCOL = TCP) (HOST = ".$host.")(PORT = 1521)))(CONNECT_DATA = (SID = ".$name.")))";
        $response = [];
        try
        {
            $conn = new \PDO("oci:dbname=".$tns.";charset=UTF8",$user,$pass);
            $consulta = $conn->query('SELECT * from SIGETYSC.VW_ACCEDE_CENTROTRABAJO');

            foreach($consulta as $row)
            {
                array_push($response, $row);
            }
        }
        catch(PDOException $e)
        {
            echo ($e->getMessage());
        }
        return $response;
    }

    static function VW_ACCEDE_UNIDADADMINISTRATIVA(){
        $user = "SIGETYSC";
        $pass = "td788T6VB92mKNKr";
        $name = "devinfo";
        $host = "10.18.29.107";
        $tns = "(DESCRIPTION =(ADDRESS_LIST =(ADDRESS = (PROTOCOL = TCP) (HOST = ".$host.")(PORT = 1521)))(CONNECT_DATA = (SID = ".$name.")))";
        $response = [];
        try
        {
            $conn = new \PDO("oci:dbname=".$tns.";charset=UTF8",$user,$pass);
            $consulta = $conn->query('SELECT * from SIGETYSC.VW_ACCEDE_UNIDADADMINISTRATIVA');

            foreach($consulta as $row)
            {
                array_push($response, $row);
            }
        }
        catch(PDOException $e)
        {
            echo ($e->getMessage());
        }
        return $response;
    }

    static function VW_ACCEDE_UNIDADADMINISTRATIVA_CENTRO_ID($id){
        $user = "SIGETYSC";
        $pass = "td788T6VB92mKNKr";
        $name = "devinfo";
        $host = "10.18.29.107";
        $tns = "(DESCRIPTION =(ADDRESS_LIST =(ADDRESS = (PROTOCOL = TCP) (HOST = ".$host.")(PORT = 1521)))(CONNECT_DATA = (SID = ".$name.")))";
        $response = [];
        try
        {
            $conn = new \PDO("oci:dbname=".$tns.";charset=UTF8",$user,$pass);
            $consulta = $conn->query('SELECT * from SIGETYSC.VW_ACCEDE_UNIDADADMINISTRATIVA WHERE SIGETYSC.VW_ACCEDE_UNIDADADMINISTRATIVA.ID_CENTRO =' .$id);

            foreach($consulta as $row)
            {
                array_push($response, $row);
            }
        }
        catch(PDOException $e)
        {
            echo ($e->getMessage());
        }
        return $response;
    }

    static function VW_ACCEDE_PAISES(){
        $user = "SIGETYSC";
        $pass = "td788T6VB92mKNKr";
        $name = "devinfo";
        $host = "10.18.29.107";
        $tns = "(DESCRIPTION =(ADDRESS_LIST =(ADDRESS = (PROTOCOL = TCP) (HOST = ".$host.")(PORT = 1521)))(CONNECT_DATA = (SID = ".$name.")))";
        $response = [];
        try
        {
            $conn = new \PDO("oci:dbname=".$tns.";charset=UTF8",$user,$pass);
            $consulta = $conn->query('SELECT * from SIGETYSC.VW_ACCEDE_PAISES');

            foreach($consulta as $row)
            {
                array_push($response, $row);
            }
        }
        catch(PDOException $e)
        {
            echo ($e->getMessage());
        }
        return $response;
    }

    static function VW_ACCEDE_ESTADOS(){
        $user = "SIGETYSC";
        $pass = "td788T6VB92mKNKr";
        $name = "devinfo";
        $host = "10.18.29.107";
        $tns = "(DESCRIPTION =(ADDRESS_LIST =(ADDRESS = (PROTOCOL = TCP) (HOST = ".$host.")(PORT = 1521)))(CONNECT_DATA = (SID = ".$name.")))";
        $response = [];
        try
        {
            $conn = new \PDO("oci:dbname=".$tns.";charset=UTF8",$user,$pass);
            $consulta = $conn->query('SELECT * from SIGETYSC.VW_ACCEDE_ESTADOS');

            foreach($consulta as $row)
            {
                array_push($response, $row);
            }
        }
        catch(PDOException $e)
        {
            echo ($e->getMessage());
        }
        return $response;
    }

    static function VW_ACCEDE_MUNICIPIOS(){
        $user = "SIGETYSC";
        $pass = "td788T6VB92mKNKr";
        $name = "devinfo";
        $host = "10.18.29.107";
        $tns = "(DESCRIPTION =(ADDRESS_LIST =(ADDRESS = (PROTOCOL = TCP) (HOST = ".$host.")(PORT = 1521)))(CONNECT_DATA = (SID = ".$name.")))";
        $response = [];
        try
        {
            $conn = new \PDO("oci:dbname=".$tns.";charset=UTF8",$user,$pass);
            $consulta = $conn->query('SELECT * from SIGETYSC.VW_ACCEDE_MUNICIPIOS');

            foreach($consulta as $row)
            {
                array_push($response, $row);
            }
        }
        catch(PDOException $e)
        {
            echo ($e->getMessage());
        }
        return $response;
    }

    static function VW_ACCEDE_LOCALIDADES(){
        $user = "SIGETYSC";
        $pass = "td788T6VB92mKNKr";
        $name = "devinfo";
        $host = "10.18.29.107";
        $tns = "(DESCRIPTION =(ADDRESS_LIST =(ADDRESS = (PROTOCOL = TCP) (HOST = ".$host.")(PORT = 1521)))(CONNECT_DATA = (SID = ".$name.")))";
        $response = [];
        try
        {
            $conn = new \PDO("oci:dbname=".$tns.";charset=UTF8",$user,$pass);
            $consulta = $conn->query('SELECT * from SIGETYSC.VW_ACCEDE_LOCALIDADES');

            foreach($consulta as $row)
            {
                array_push($response, $row);
            }
        }
        catch(PDOException $e)
        {
            echo ($e->getMessage());
        }
        return $response;
    }

    static function VW_ACCEDE_LOCALIDADES_MUNICIPIO($municipio){
        $user = "SIGETYSC";
        $pass = "td788T6VB92mKNKr";
        $name = "devinfo";
        $host = "10.18.29.107";
        $tns = "(DESCRIPTION =(ADDRESS_LIST =(ADDRESS = (PROTOCOL = TCP) (HOST = ".$host.")(PORT = 1521)))(CONNECT_DATA = (SID = ".$name.")))";
        $response = [];
        try
        {
            $conn = new \PDO("oci:dbname=".$tns.";charset=UTF8",$user,$pass);
            $consulta = $conn->query("SELECT * from SIGETYSC.VW_ACCEDE_LOCALIDADES WHERE SIGETYSC.VW_ACCEDE_LOCALIDADES.MUNICIPIO =". "'" .$municipio . "' ORDER BY SIGETYSC.VW_ACCEDE_LOCALIDADES.NOMBRE");


            //$consulta = $conn->query('SELECT * from SIGETYSC.VW_ACCEDE_TRAMLEGA WHERE SIGETYSC.VW_ACCEDE_TRAMLEGA.TRAM_LEGA =' .$id);

            foreach($consulta as $row)
            {
                array_push($response, $row);
            }
        }
        catch(PDOException $e)
        {
            echo ($e->getMessage());
        }
        return $response;
    }

    //Citas
    //Citas
    static function SICI_VW_CITAS_DISPONIBLES(){
        $user = "SIGETYSC";
        $pass = "td788T6VB92mKNKr";
        $name = "devinfo";
        $host = "10.18.29.107";
        $tns = "(DESCRIPTION =(ADDRESS_LIST =(ADDRESS = (PROTOCOL = TCP) (HOST = ".$host.")(PORT = 1521)))(CONNECT_DATA = (SID = ".$name.")))";
        $response = [];
        try
        {
            $conn = new \PDO("oci:dbname=".$tns.";charset=UTF8",$user,$pass);
            $consulta = $conn->query('SELECT DISTINCT * from SIGETYSC.SICI_VW_CITAS_DISPONIBLES');

            foreach($consulta as $row)
            {
                array_push($response, $row);
            }
        }
        catch(PDOException $e)
        {
            echo ($e->getMessage());
        }
        return $response;
    }

    static function SICI_VW_CITAS_DISPONIBLES_Filtrado($idtramite, $idedificio){
        $user = "SIGETYSC";
        $pass = "td788T6VB92mKNKr";
        $name = "devinfo";
        $host = "10.18.29.107";
        $tns = "(DESCRIPTION =(ADDRESS_LIST =(ADDRESS = (PROTOCOL = TCP) (HOST = ".$host.")(PORT = 1521)))(CONNECT_DATA = (SID = ".$name.")))";
        $response = [];
        try
        {
            //array_push($response, [$idtramite,$idedificio]);
            $conn = new \PDO("oci:dbname=".$tns.";charset=UTF8",$user,$pass);
            $consulta = $conn->query('SELECT DISTINCT * from SIGETYSC.SICI_VW_CITAS_DISPONIBLES WHERE SIGETYSC.SICI_VW_CITAS_DISPONIBLES.IDTRAMITE = '.$idtramite.' AND SIGETYSC.SICI_VW_CITAS_DISPONIBLES.IDEDIFICIO = '.$idedificio);

            foreach($consulta as $row)
            {
                array_push($response, $row);
            }
        }
        catch(PDOException $e)
        {
            echo ($e->getMessage());
        }
        return $response;
    }

    static function SICI_VW_ESTATUSCITAS(){
        $user = "SIGETYSC";
        $pass = "td788T6VB92mKNKr";
        $name = "devinfo";
        $host = "10.18.29.107";
        $tns = "(DESCRIPTION =(ADDRESS_LIST =(ADDRESS = (PROTOCOL = TCP) (HOST = ".$host.")(PORT = 1521)))(CONNECT_DATA = (SID = ".$name.")))";
        $response = [];
        try
        {
            $conn = new \PDO("oci:dbname=".$tns.";charset=UTF8",$user,$pass);
            $consulta = $conn->query("SELECT * from SIGETYSC.SICI_VW_ESTATUS_CITAS");

            //dd($consulta);
            foreach($consulta as $row)
            {

                array_push($response, $row);
            }
        }
        catch(PDOException $e)
        {
            echo ($e->getMessage());
        }
        return $response;
    }

    static function SICI_VW_ESTATUSCITAS_Filtrado($folio, $test, $param){
        $user = "SIGETYSC";
        $pass = "td788T6VB92mKNKr";
        $name = "devinfo";
        $host = "10.18.29.107";
        $tns = "(DESCRIPTION =(ADDRESS_LIST =(ADDRESS = (PROTOCOL = TCP) (HOST = ".$host.")(PORT = 1521)))(CONNECT_DATA = (SID = ".$name.")))";
        $response = [];
        try
        {
            $conn = new \PDO("oci:dbname=".$tns.";charset=UTF8",$user,$pass);
            $consulta = $conn->query("SELECT * from SIGETYSC.SICI_VW_ESTATUS_CITAS WHERE SIGETYSC.SICI_VW_ESTATUS_CITAS.FOLIO='".$folio."' OR SIGETYSC.SICI_VW_ESTATUS_CITAS.FOLIO_CANCELADO='".$folio."'");

            //dd($consulta);
            foreach($consulta as $row)
            {
                array_push($response, $row);
            }
        }
        catch(PDOException $e)
        {
            echo ($e->getMessage());
        }
        return $response;
    }

    static function SICI_VW_TRAM_EDIF_CON_CITAS(){
        $user = "SIGETYSC";
        $pass = "td788T6VB92mKNKr";
        $name = "devinfo";
        $host = "10.18.29.107";
        $tns = "(DESCRIPTION =(ADDRESS_LIST =(ADDRESS = (PROTOCOL = TCP) (HOST = ".$host.")(PORT = 1521)))(CONNECT_DATA = (SID = ".$name.")))";
        $response = [];
        try
        {
            $conn = new \PDO("oci:dbname=".$tns.";charset=UTF8",$user,$pass);
            $consulta = $conn->query('SELECT * from SIGETYSC.SICI_VW_TRAM_EDIF_CON_CITAS');

            foreach($consulta as $row)
            {
                array_push($response, $row);
            }
        }
        catch(PDOException $e)
        {
            echo ($e->getMessage());
        }
        return $response;
    }

    static function SICI_SP_GUARDARCITA($nombre, $primerapellido, $segundoapellido, $correo, $celular, $tramite, $edificio, $hora, $fecha){
        $user = "SIGETYSC";
        $pass = "td788T6VB92mKNKr";
        $name = "devinfo";
        $host = "10.18.29.107";
        $valor_devuelto="";
	$valor_devuelto1="";
	$valor_devuelto2="";
        $tns = "(DESCRIPTION =(ADDRESS_LIST =(ADDRESS = (PROTOCOL = TCP) (HOST = ".$host.")(PORT = 1521)))(CONNECT_DATA = (SID = ".$name.")))";
        $response = [];
        try
        {
            $conn = new \PDO("oci:dbname=".$tns.";charset=UTF8",$user,$pass);
            //$consulta = $conn->query('CALL SIGETYSC.SICI_SP_GUARDARCITA');

            /* The call */
            $stmt= $conn->prepare("BEGIN SIGETYSC.SICIP_SP_GUARDARCITA(:PNOMBRE,:PPRIMERAPELLIDO,:PSEGUNDOAPELLIDO,:PCORREO,:PCELULAR,:PEDIFICIO,:PTRAMFTE,:PHORA,:PFECHA,:REGRESA,:MENSAJE,:AVISO); END;");

            /* Binding Parameters */
            $stmt->bindParam(':PNOMBRE', $nombre);
            $stmt->bindParam(':PPRIMERAPELLIDO', $primerapellido);
            $stmt->bindParam(':PSEGUNDOAPELLIDO', $segundoapellido);
            $stmt->bindParam(':PCORREO', $correo);
            $stmt->bindParam(':PCELULAR', $celular);
            $stmt->bindParam(':PEDIFICIO', $edificio);
            $stmt->bindParam(':PTRAMFTE', $tramite);
            $stmt->bindParam(':PHORA', $hora);
            $stmt->bindParam(':PFECHA', $fecha);
	    $stmt->bindParam(':REGRESA', $valor_devuelto, PDO::PARAM_STR, 4000);
	    $stmt->bindParam(':MENSAJE', $valor_devuelto1, PDO::PARAM_STR, 4000);
	    $stmt->bindParam(':AVISO', $valor_devuelto2, PDO::PARAM_STR, 4000);
/* Execture Query */
            $stmt->execute();

            $result = $stmt-> fetch();

            array_push($response, [$valor_devuelto,$valor_devuelto1,$valor_devuelto2]);
	    //array_push($response, $result);
        }
        catch(PDOException $e)
        {
            echo ($e->getMessage());
        }
        return $response;
    }

    static function SICI_VW_CITAS_RESERVADAS(){
        $user = "SIGETYSC";
        $pass = "td788T6VB92mKNKr";
        $name = "devinfo";
        $host = "10.18.29.107";
        $tns = "(DESCRIPTION =(ADDRESS_LIST =(ADDRESS = (PROTOCOL = TCP) (HOST = ".$host.")(PORT = 1521)))(CONNECT_DATA = (SID = ".$name.")))";
        $response = [];
        try
        {
            $conn = new \PDO("oci:dbname=".$tns.";charset=UTF8",$user,$pass);
            $consulta = $conn->query('SELECT * from SIGETYSC.SICI_VW_CITAS_RESERVADAS');

            foreach($consulta as $row)
            {
                array_push($response, $row);
            }
        }
        catch(PDOException $e)
        {
            echo ($e->getMessage());
        }
        return $response;
    }

    static function SICI_VW_CITAS_RESERVADAS_Filtrado($idcita){
        $user = "SIGETYSC";
        $pass = "td788T6VB92mKNKr";
        $name = "devinfo";
        $host = "10.18.29.107";
        $tns = "(DESCRIPTION =(ADDRESS_LIST =(ADDRESS = (PROTOCOL = TCP) (HOST = ".$host.")(PORT = 1521)))(CONNECT_DATA = (SID = ".$name.")))";
        $response = [];
        try
        {
 	    //array_push($response, [$idcita]);

            $conn = new \PDO("oci:dbname=".$tns.";charset=UTF8",$user,$pass);
            $consulta = $conn->query("SELECT * from SIGETYSC.SICI_VW_CITAS_RESERVADAS WHERE SIGETYSC.SICI_VW_CITAS_RESERVADAS.FOLIO_CITA ='".$idcita."'");

	    //dd($consulta);
            foreach($consulta as $row)
            {
                array_push($response, $row);
            }
        }
        catch(PDOException $e)
        {
            echo ($e->getMessage());
        }
        return $response;
    }

    static function SICI_SPU_AGENDA($idasisten, $idcancelan, $idmotivocancela, $motivocancela, $usuario, $hd){
        $user = "SIGETYSC";
        $pass = "td788T6VB92mKNKr";
        $name = "devinfo";
	$valor_devuelto="";
        $valor_devuelto1="";
        $valor_devuelto2="";
        $host = "10.18.29.107";
        $tns = "(DESCRIPTION =(ADDRESS_LIST =(ADDRESS = (PROTOCOL = TCP) (HOST = ".$host.")(PORT = 1521)))(CONNECT_DATA = (SID = ".$name.")))";
        $response = [];
        try
        {
            $conn = new \PDO("oci:dbname=".$tns.";charset=UTF8",$user,$pass);
            //$consulta = $conn->query('CALL SIGETYSC.SICI_SP_GUARDARCITA');

            /* The call */
            $stmt= $conn->prepare("BEGIN SIGETYSC.SICI_SPU_AGENDA(:IDSASISTEN,:IDSCANCELAN,:IDMOTIVOCANCEL,:MOTIVOCANCEL,:SESSUSUARIO,:IP,:RESULTADO,:ASISTEN,:CANCELAN); END;");

            /* Binding Parameters */
            $stmt->bindParam(':IDSASISTEN', $idasisten);
            $stmt->bindParam(':IDSCANCELAN', $idcancelan);
            $stmt->bindParam(':IDMOTIVOCANCEL', $idmotivocancela);
            $stmt->bindParam(':MOTIVOCANCEL', $motivocancela);
            $stmt->bindParam(':SESSUSUARIO', $usuario);
            $stmt->bindParam(':IP', $hd);
	    $stmt->bindParam(':RESULTADO', $valor_devuelto, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':ASISTEN', $valor_devuelto1, PDO::PARAM_STR, 4000);
            $stmt->bindParam(':CANCELAN', $valor_devuelto2, PDO::PARAM_STR, 4000);

            /* Execture Query */
            $stmt->execute();

            $result = $stmt-> fetch();

	    array_push($response, [$valor_devuelto,$valor_devuelto1,$valor_devuelto2]);
           // array_push($response, $result);
        }
        catch(PDOException $e)
        {
            echo ($e->getMessage());
        }
        return $response;
    }

    static function SICI_VW_CITAS_DISPONIBLES_Filtrado_tram($idtramite){
        $user = "SIGETYSC";
        $pass = "td788T6VB92mKNKr";
        $name = "devinfo";
        $host = "10.18.29.107";
        $tns = "(DESCRIPTION =(ADDRESS_LIST =(ADDRESS = (PROTOCOL = TCP) (HOST = ".$host.")(PORT = 1521)))(CONNECT_DATA = (SID = ".$name.")))";
        $response = [];
        try
        {
            //array_push($response, [$idtramite,$idedificio]);
            $conn = new \PDO("oci:dbname=".$tns.";charset=UTF8",$user,$pass);
            $consulta = $conn->query('SELECT DISTINCT * from SIGETYSC.SICI_VW_CITAS_DISPONIBLES WHERE SIGETYSC.SICI_VW_CITAS_DISPONIBLES.IDTRAMITE = '.$idtramite);

            foreach($consulta as $row)
            {
                array_push($response, $row);
            }
        }
        catch(PDOException $e)
        {
            echo ($e->getMessage());
        }
        return $response;
    }


    static function TYS_SP_CITALINEA($idtramite, $tramitelinea, $tramiteliga, $tramitecita, $tramiteedificio){
        $user = "SIGETYSC";
        $pass = "td788T6VB92mKNKr";
        $name = "devinfo";
	$valor_devuelto="...";
        $host = "10.18.29.107";
        $tns = "(DESCRIPTION =(ADDRESS_LIST =(ADDRESS = (PROTOCOL = TCP) (HOST = ".$host.")(PORT = 1521)))(CONNECT_DATA = (SID = ".$name.")))";
        $response = [];
        try
        {
            $conn = new \PDO("oci:dbname=".$tns.";charset=UTF8",$user,$pass);

            /* The call */
            $stmt= $conn->prepare("BEGIN SIGETYSC.TYS_SP_CITALINEA(:TRAMITEID,:TRAMITECITALINEA,:TRAMITELIGA,:TRAMITECITA,:TRAMITEEDIFICIO,:RESULTADO); END;");

            /* Binding Parameters */
            $stmt->bindParam(':TRAMITEID', $idtramite);
            $stmt->bindParam(':TRAMITECITALINEA', $tramitelinea);
            $stmt->bindParam(':TRAMITELIGA', $tramiteliga);
            $stmt->bindParam(':TRAMITECITA', $tramitecita);
	    $stmt->bindParam(':TRAMITEEDIFICIO', $tramiteedificio);
	    $stmt->bindParam(':RESULTADO', $valor_devuelto, PDO::PARAM_STR, 2000);


            /* Execture Query m*/
            $stmt->execute();

            $result = $stmt->fetch();

	    array_push($response, $idtramite);
	array_push($response, $tramitelinea);
	array_push($response, $tramiteliga);
	array_push($response, $tramitecita);
	array_push($response, $tramiteedificio);
		array_push($response, $valor_devuelto);
            //array_push($response, $result);
        }
        catch(PDOException $e)
        {
            echo ($e->getMessage());
        }
        return $response;
    }


    static function VW_ACCEDE_TRAMITE_FILTRO($palabraClave, $dependencia, $modalidad, $clasificacion, $audiencia, $desde, $hasta, $usuarioID, $unidad, $estatus)
    {
        $user = "SIGETYSC";
        $pass = "td788T6VB92mKNKr";
        $name = "devinfo";
        $host = "10.18.29.107";
        $tns = "(DESCRIPTION =(ADDRESS_LIST =(ADDRESS = (PROTOCOL = TCP) (HOST = " . $host . ")(PORT = 1521)))(CONNECT_DATA = (SID = " . $name . ")))";
        $response = [];

        try {

            //TRAMITE, ID_CENTRO,(LINEA,PRESENCIAL, TELEFONO), TRAM_NCLASIFICACION, AUDIENCIA
            $palabraClave = $palabraClave ?? '';
            $dependencia = $dependencia ?? 0;
            $unidad = $unidad ?? 0;
            $modalidad = $modalidad ?? '';
            $clasificacion = $clasificacion ?? 0;
            $audiencia = $audiencia ?? '';

            //Nombre de la tabla temporal
            // $nombreTabla = Str::random(32);
            $nombreTabla = "tem_tramite_prueba";

            $consulta = "SELECT SIGETYSC.VW_ACCEDE_TRAMITE.ID_TRAM";
            $consulta = $consulta . ", SIGETYSC.VW_ACCEDE_TRAMITE.TRAMITE";
            $consulta = $consulta . ", SIGETYSC.VW_ACCEDE_TRAMITE.ID_CENTRO";
            $consulta = $consulta . ", SIGETYSC.VW_ACCEDE_TRAMITE.LINEA";
            $consulta = $consulta . ", SIGETYSC.VW_ACCEDE_TRAMITE.PRESENCIAL";
            $consulta = $consulta . ", SIGETYSC.VW_ACCEDE_TRAMITE.TELEFONO";
            $consulta = $consulta . ", SIGETYSC.VW_ACCEDE_TRAMITE.TRAM_NCLASIFICACION";
            $consulta = $consulta . ", SIGETYSC.VW_ACCEDE_TRAMITE.AUDIENCIA";
            $consulta = $consulta . ", SIGETYSC.VW_ACCEDE_TRAMITE.DESCRIPCION";
            $consulta = $consulta . ", SIGETYSC.VW_ACCEDE_TRAMITE.DESC_CENTRO";
            $consulta = $consulta . " FROM SIGETYSC.VW_ACCEDE_TRAMITE WHERE LOWER(TRAMITE) LIKE LOWER('%" . $palabraClave . "%')";

            //Validar tipo de usuario y tramites que tiene permito
            $listaTramitesAccesoPertenece = [];
            if ($usuarioID > 0) {

                $listaTramitesAccesoPertenece = Cls_Gestor::TRAM_SP_OBTENER_TRAMITE_ACCESO_PERTENECE_USUARIO($usuarioID);

                if (count($listaTramitesAccesoPertenece) > 0) {

                    $consulta = $consulta . " AND ID_TRAM IN (";

                    foreach ($listaTramitesAccesoPertenece as $key => $value) {

                        $ultimoTramite = end($listaTramitesAccesoPertenece);

                        if ($ultimoTramite->TramiteID === $value->TramiteID) {
                            $consulta = $consulta . "" . $value->TramiteID;
                        } else {
                            $consulta = $consulta . "" . $value->TramiteID . ", ";
                        }
                    }

                    $consulta = $consulta . ") ";
                }
            }

            //Dependencia
            if ($dependencia > 0) {
                $consulta = $consulta . " AND (ID_CENTRO = " . $dependencia . ")";
            }

            //Unidad
            if ($unidad > 0) {
                $consulta = $consulta . " AND (ID_UNIDAD = " . $unidad . ")";
            }

            //Modalidad
            if (!(empty($modalidad))) {

                switch ($modalidad) {
                    case 'LINEA':
                        $consulta = $consulta . " AND LINEA = 1";
                        break;
                    case 'PRESENCIAL':
                        $consulta = $consulta . " AND PRESENCIAL = 1";
                        break;
                    case 'TELEFONO':
                        $consulta = $consulta . " AND TELEFONO = 1";
                        break;
                    default:
                        break;
                }
            }

            //Clasificacion
            if ($clasificacion > 0) {
                $consulta = $consulta . " AND TRAM_NCLASIFICACION = " . $clasificacion . "";
            }

            //AUDIENCIA
            if (!(empty($audiencia))) {
                $consulta = $consulta . " AND AUDIENCIA LIKE '%" . $audiencia . "%'";
            }

            //Estatus
            $idAccedeConfig = [];
            $whereIDAccede = '';
            if (intval($estatus) === 1) {

                $idAccedeConfig = DB::select('SELECT distinct TRAM_NIDTRAMITE_ACCEDE  FROM tram_mst_tramite');

                if ($idAccedeConfig != null && count($idAccedeConfig) > 0) {
                    foreach ($idAccedeConfig as $valor) {

                        $whereIDAccede .= $valor->TRAM_NIDTRAMITE_ACCEDE . ',';
                    }
                    $whereIDAccede = trim($whereIDAccede, ',');
                    $consulta = $consulta . " AND ID_TRAM IN (" . $whereIDAccede . ")";
                }
            } else if (intval($estatus) === 0) {

                $idAccedeConfig = DB::select('SELECT distinct TRAM_NIDTRAMITE_ACCEDE  FROM tram_mst_tramite');

                if ($idAccedeConfig != null && count($idAccedeConfig) > 0) {
                    foreach ($idAccedeConfig as $valor) {

                        $whereIDAccede .= $valor->TRAM_NIDTRAMITE_ACCEDE . ',';
                    }
                    $whereIDAccede = trim($whereIDAccede, ',');
                    $consulta = $consulta . " AND ID_TRAM NOT IN (" . $whereIDAccede . ")";
                }
            }

            $conn = new \PDO("oci:dbname=" . $tns.";charset=UTF8", $user, $pass);
            $consulta_paginado = "SELECT * FROM (SELECT ROWNUM AS FILA, CONSULTA.* FROM ( " . $consulta . ") CONSULTA) WHERE FILA > " . $desde . " AND FILA <= " . $hasta . " ";
            $consulta_ = $conn->query($consulta_paginado);

            $consulta_total = "SELECT COUNT(*) FROM (" . $consulta . ")";

            //Total
            $total = 0;
            foreach ($conn->query($consulta_total) as $row) {
                $total = intval($row['0']);
            }

            //Crear tabla temporal de trámites accede
            Schema::create('' . $nombreTabla . '', function (Blueprint $table) {
                $table->integer('ID_TRAM');
                $table->longText('TRAMITE');
                $table->integer('ID_CENTRO');
                $table->integer('LINEA');
                $table->integer('PRESENCIAL');
                $table->integer('TELEFONO');
                $table->integer('TRAM_NCLASIFICACION');
                $table->longText('AUDIENCIA');
                $table->longText('DESCRIPCION');
                $table->longText('DESC_CENTRO');
                $table->temporary();
            });

            $listInsertar = [];
            foreach ($consulta_ as $row) {
                $item = [
                    'ID_TRAM' => $row['ID_TRAM'],
                    'TRAMITE' => $row['TRAMITE'],
                    'ID_CENTRO' => $row['ID_CENTRO'],
                    'LINEA' => $row['LINEA'],
                    'PRESENCIAL' => $row['PRESENCIAL'],
                    'TELEFONO' => $row['TELEFONO'],
                    'TRAM_NCLASIFICACION' => $row['TRAM_NCLASIFICACION'],
                    'AUDIENCIA' => $row['AUDIENCIA'],
                    'DESCRIPCION' => $row['DESCRIPCION'] ?? "",
                    'DESC_CENTRO' => $row['DESC_CENTRO'] ?? "",
                ];
                array_push($listInsertar, $item);
            }

            //Insertamos trámites accede a la tabla temporal
            DB::table('' . $nombreTabla . '')->insert($listInsertar);

            //Marcamos como enviado a enlace todos los trámites implementados
            Cls_Tramite_Servicio::where('TRAM_NIMPLEMENTADO', 1)->update(['TRAM_NENLACEOFICIAL' => 1]);

            //Verificamos rol del usuario
            $user = DB::select('SELECT rol.ROL_CCLAVE FROM tram_mst_usuario as us
            JOIN tram_cat_rol as rol on rol.ROL_NIDROL = us.USUA_NIDROL
            where us.USUA_NIDUSUARIO = ?', array($usuarioID));
            $rol = $user[0]->ROL_CCLAVE ?? 'other';

            $enlaceO = 0;
            if ($rol === 'ENLOF') {
                $enlaceO = 1;
            }

            $resultado = DB::table('' . $nombreTabla . '')
            ->leftJoin(
                'tram_mst_tramite',
                '' . $nombreTabla . '.ID_TRAM',
                '=',
                'tram_mst_tramite.TRAM_NIDTRAMITE_ACCEDE'
            )->select(
                '' . $nombreTabla . '.ID_TRAM as TRAM_NIDTRAMITE',
                'tram_mst_tramite.TRAM_NIDTRAMITE as TRAM_NIDTRAMITE_CONFIG',
                '' . $nombreTabla . '.TRAMITE as TRAM_CNOMBRE',
                '' . $nombreTabla . '.DESCRIPCION as TRAM_CDESCRIPCION',
                '' . $nombreTabla . '.DESC_CENTRO as UNAD_CNOMBRE',
                '' . $nombreTabla . '.DESC_CENTRO as TRAM_CCENTRO',
                '' . $nombreTabla . '.ID_CENTRO as TRAM_NIDCENTRO',
                'tram_mst_tramite.TRAM_NIMPLEMENTADO as TRAM_NIMPLEMENTADO',
                'tram_mst_tramite.TRAM_NENLACEOFICIAL as TRAM_NENLACEOFICIAL',
                '' . $nombreTabla . '.ID_CENTRO as UNAD_CNID',
                'tram_mst_tramite.created_at as TRAM_DFECHACREACION',
                'tram_mst_tramite.updated_at as TRAM_DFECHAACTUALIZACION'
            );

            // if ($enlaceO === 1) {
            //     $resultado = $resultado->where('TRAM_NENLACEOFICIAL', 1);
            //     $resultado = $resultado->where('TRAM_NENLACEOFICIAL', null);
            // }

            // $resultado = $resultado->skip($desde)->take($hasta)->get();
            $resultado = $resultado->where(['TRAM_NIMPLEMENTADO' => 1])
            ->orWhere(['TRAM_NIMPLEMENTADO' => 0])
            ->orWhere(['TRAM_NIMPLEMENTADO' => null]);
            $resultado = $resultado->get();

            /*
            $total = DB::table('' . $nombreTabla . '')
            ->leftJoin(
                'tram_mst_tramite',
                '' . $nombreTabla . '.ID_TRAM',
                '=',
                'tram_mst_tramite.TRAM_NIDTRAMITE_ACCEDE'
            )->select(
                '' . $nombreTabla . '.ID_TRAM as TRAM_NIDTRAMITE',
                'tram_mst_tramite.TRAM_NIDTRAMITE as TRAM_NIDTRAMITE_CONFIG',
                '' . $nombreTabla . '.TRAMITE as TRAM_CNOMBRE',
                '' . $nombreTabla . '.DESCRIPCION as TRAM_CDESCRIPCION',
                '' . $nombreTabla . '.DESC_CENTRO as UNAD_CNOMBRE',
                '' . $nombreTabla . '.DESC_CENTRO as TRAM_CCENTRO',
                '' . $nombreTabla . '.ID_CENTRO as TRAM_NIDCENTRO',
                'tram_mst_tramite.TRAM_NIMPLEMENTADO as TRAM_NIMPLEMENTADO',
                'tram_mst_tramite.TRAM_NENLACEOFICIAL as TRAM_NENLACEOFICIAL',
                '' . $nombreTabla . '.ID_CENTRO as UNAD_CNID',
                'tram_mst_tramite.created_at as TRAM_DFECHACREACION',
                'tram_mst_tramite.updated_at as TRAM_DFECHAACTUALIZACION'
            );*/

            // if ($enlaceO === 1) {
            //     $total = $total->where('TRAM_NENLACEOFICIAL', 1);
            //     $total = $total->where('TRAM_NENLACEOFICIAL', null);
            // }
            /*$total = $total->count();*/

            Schema::drop('' . $nombreTabla . '');

            $response = [
                'data'=> $resultado,
                'total'=> $total
            ];

        } catch (PDOException $e) {
            $error = [
                "error" => $e->getMessage(),
            ];
            echo ($error);
        }
        return $response;
    }


}
