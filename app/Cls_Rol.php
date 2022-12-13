<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class Cls_Rol extends Model
{
    protected $connection   = 'pgsql';
    protected $table        = 'tram_cat_rol';
    protected $fillable     = ['ROL_NIDROL', 'ROL_CNOMBRE', 'ROL_CDESCRIPCION', 'ROL_CCLAVE'];
    protected $primaryKey   = 'ROL_NIDROL';
    
    static function TRAM_SP_OBTENERROLPORCLAVE($clave){
        return DB::table('tram_cat_rol')->where('ROL_CCLAVE', $clave)->first();
    }
    
    static function TRAM_SP_AGREGARROL(Request $request){
        return DB::select('call TRAM_SP_AGREGARROL(?,?)'
                , array($request->StrNommbre
                , $request->StrDescripcion))[0]->{'LAST_INSERT_ID()'};
    }
    
    static function TRAM_SP_MODIFICARROL(Request $request){
        return DB::select('call TRAM_SP_MODIFICARROL(?,?,?)'
                , array($request->StrNommbre
                , $request->StrDescripcion
                , $request->IntId));
    }

    static function TRAM_SP_ELIMINARROL(Request $request){
        return DB::select('call TRAM_SP_ELIMINARROL(?)'
                , array((int)$request->IntId));
    }

    public function TRAM_DET_PERMISOROL(){
        return $this->hasMany(Cls_PermisoRol::class, 'PROL_NIDROL', 'ROL_NIDROL');
    }
}
