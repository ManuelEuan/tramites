<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class Cls_PermisoRol extends Model
{
    protected $connection   = 'pgsql';
    protected $table        = 'tram_det_permisorol';
    protected $with         = ['TRAM_CAT_PERMISO'];

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
    
    public function TRAM_CAT_PERMISO()
    {
        //forean key, primary key
        return $this->belongsTo(Cls_Permiso::class, 'PROL_NIDPERMISO', 'PERMI_NIDPERMISO');
    }
}
