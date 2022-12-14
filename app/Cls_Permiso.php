<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class Cls_Permiso extends Model
{
    protected $connection   = 'pgsql';
    protected $table        = 'tram_cat_permiso';
    protected $fillable     = ['PERMI_CNOMBRE', 'PERMI_CDESCRIPCION', 'PERMI_CICONO', 'PERMI_CRUTA','PERMI_NIDCATEGORIA_PERMISO'];
    protected $primaryKey   = 'PERMI_NIDPERMISO';

    public function TRAM_CAT_CATEGORIA_PERMISO()
    {
        return $this->belongsTo(Cls_Categoria_Permiso::class, 'PERMI_NIDCATEGORIA_PERMISO', 'CPERMI_NIDCATEGORIA_PERMISO');
    }
    
}
