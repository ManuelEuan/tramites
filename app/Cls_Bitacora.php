<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Cls_Bitacora extends Model
{
    protected $connection = 'mysql';
    protected $table = 'tram_his_bitacora';

    //Atributos para filtro
    public $StrTexto;
    public $IntNumPagina;
    public $IntCantidadRegistros;
    public $StrOrdenColumna;
    public $StrOrdenDir;
    public $IntUsuarioId;

    public function TRAM_SP_CONSULTARBITACORA()
    {
     

        $sql = "call TRAM_SP_CONSULTARBITACORA('$this->StrTexto', '$this->IntNumPagina','$this->IntCantidadRegistros', '$this->StrOrdenColumna',
        '$this->StrOrdenDir','$this->IntUsuarioId')";

        $pdo = DB::connection()->getPdo();
        $pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, true);
        $stmt = $pdo->prepare($sql, [\PDO::ATTR_CURSOR => \PDO::CURSOR_SCROLL]);
        $exec = $stmt->execute();

        
        //Primer resultado
        $first = $stmt->fetchAll(\PDO::FETCH_OBJ);

        //Segundo resultado
        $stmt->nextRowset();
        $second = $stmt->fetchAll(\PDO::FETCH_OBJ);

        //Tercer resultado
        $stmt->nextRowset();
        $second2 = $stmt->fetchAll(\PDO::FETCH_OBJ);

        $data = [
            'data' => $first,
            'pagination' => $second,
            'registrosFiltrados' => $second2
        ];

        return $data;
    }

    static function TRAM_SP_AGREGARBITACORA($ObjBitacora){
        return DB::statement('call TRAM_SP_AGREGARBITACORA(?,?,?,?)'
                , array($ObjBitacora->BITA_NIDUSUARIO
                , $ObjBitacora->BITA_CMOVIMIENTO
                , $ObjBitacora->BITA_CTABLA
                , $ObjBitacora->BITA_CIP));
    }
}
