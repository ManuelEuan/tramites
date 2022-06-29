<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class Cls_Categoria_Permiso extends Model
{
    protected $table = 'tram_cat_categoria_permiso';

    static function TRAM_SP_CONSULTAR_CATEGORIA_PERMISO(){
        return DB::select(
            'call TRAM_SP_CONSULTAR_CATEGORIA_PERMISO()'
        );
    }
}
