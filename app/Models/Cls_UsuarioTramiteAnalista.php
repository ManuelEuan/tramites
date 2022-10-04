<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cls_UsuarioTramiteAnalista extends Model
{
    protected $table = 'tram_mdv_usuariotramite_analista';
    protected $primaryKey = 'USTR_NIDUSUARIOTRAMITE';
    protected $fillable = [
        'USUA_NIDUSUARIO',
        'USTR_ACTIVO',
    ];
}
