<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cls_DocumentosBase extends Model
{
    protected $table = 'tram_mst_documentosbase';
    protected $fillable = [
        'FORMATO',
        'PESO',
        'VIGENCIA_INICIO',
        'VIGENCIA_FIN',
        'ID_CDOCUMENTOS',
        'ID_USUARIO',
        'isDelete',
        'estatus',
        'ruta',
        'isActual',
        'create_at',
        'update_at',
    ];
    public $timestamps  = false;
}
