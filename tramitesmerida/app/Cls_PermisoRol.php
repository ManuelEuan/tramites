<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class Cls_PermisoRol extends Model
{
    protected $table = 'tram_det_permisorol';

    static function TRAM_SP_CONSULTARPERMISOROL($IntRolId){
        return DB::select('call TRAM_SP_CONSULTARPERMISOROL(?)'
                , array($IntRolId));
    }

    static function TRAM_SP_AGREGARPERMISOROL($IntPermisoId, $IntRolId){
        return DB::select('call TRAM_SP_AGREGARPERMISOROL(?,?)'
                , array($IntPermisoId
                , $IntRolId));
    }
    
    static function TRAM_SP_ELIMINARPERMISOROL($IntRolId){
        return DB::select('call TRAM_SP_ELIMINARPERMISOROL(?)'
                , array($IntRolId));
    }
    
    protected $with = ['TRAM_CAT_PERMISO'];
    
    public function TRAM_CAT_PERMISO()
    {
        //forean key, primary key
        return $this->belongsTo('App\Cls_Permiso', 'PROL_NIDPERMISO', 'PERMI_NIDPERMISO');
    }
}
