<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class Cls_Permiso extends Model
{
    protected $connection   = 'pgsql';
    protected $table        = 'tram_cat_permiso';
    protected $with         = ['TRAM_CAT_CATEGORIA_PERMISO'];

    static function TRAM_SP_CONSULTARPERMISO(){
        return DB::select(
            'call TRAM_SP_CONSULTARPERMISO()'
        );
    }

    static function TRAM_SP_OBTENERPERMISO($id){
        return DB::select('call TRAM_SP_OBTENERPERMISO(?)'
        , array($id));
    }
    
    static function TRAM_SP_AGREGARPERMISO(Request $request){
        return DB::select('call TRAM_SP_AGREGARPERMISO(?,?,?,?,?)'
                , array($request->StrNommbre
                , $request->StrDescripcion
                , $request->StrIcono
                , $request->StrRuta
                , $request->IntIdCategoriaPermiso));
    }
    
    static function TRAM_SP_MODIFICARPERMISO(Request $request){
        return DB::select('call TRAM_SP_MODIFICARPERMISO(?,?,?,?,?,?)'
                , array($request->StrNommbre
                , $request->StrDescripcion
                , $request->StrIcono
                , $request->StrRuta
                , $request->IntCategoria
                , $request->IntId));
    }

    static function TRAM_SP_ELIMINARPERMISO(Request $request){
        return DB::select('call TRAM_SP_ELIMINARPERMISO(?)'
                , array($request->IntId));
    }
    
    public function TRAM_CAT_CATEGORIA_PERMISO()
    {
        return $this->belongsTo(Cls_Categoria_Permiso::class, 'PERMI_NIDCATEGORIA_PERMISO', 'CPERMI_NIDCATEGORIA_PERMISO');
    }
    
}
