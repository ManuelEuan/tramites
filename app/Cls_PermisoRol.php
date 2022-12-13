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
    protected $fillable     = ['PROL_NIDPERMISO', 'PROL_NIDROL'];
    protected $primaryKey   = 'PROL_NIDPERMISOROL';

    
    public function TRAM_CAT_PERMISO()
    {
        //forean key, primary key
        return $this->belongsTo(Cls_Permiso::class, 'PROL_NIDPERMISO', 'PERMI_NIDPERMISO');
    }
}
