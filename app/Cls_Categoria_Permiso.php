<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class Cls_Categoria_Permiso extends Model
{
    protected $connection   = 'pgsql';
    protected $table        = 'tram_cat_categoria_permiso';
    protected $fillable     = ['CPERMI_NIDCATEGORIA_PERMISO', 'CPERMI_CNOMBRE'];
    protected $primaryKey   = 'CPERMI_NIDCATEGORIA_PERMISO';
    public $timestamps      = false;
}
