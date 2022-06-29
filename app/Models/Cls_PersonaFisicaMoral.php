<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cls_PersonaFisicaMoral extends Model
{
    protected $table = 'tram_mst_usuario';
    protected $primaryKey = 'USUA_NIDUSUARIO';
    protected $fillable = [
        'USUA_NIDROL',
        'USUA_NTIPO_PERSONA',
        'USUA_CRFC',
        'USUA_CCURP',
        'USUA_NTIPO_SEXO',
        'USUA_CRAZON_SOCIAL',
        'USUA_CNOMBRES',
        'USUA_CPRIMER_APELLIDO',
        'USUA_CSEGUNDO_APELLIDO',
        'USUA_CCALLE',
        'USUA_CNNUMERO_INTERIOR',
        'USUA_CNNUMERO_EXTERIOR',
        'USUA_NCP',
        'USUA_CCOLONIA',
        'USUA_NCVECOLONIA',
        'USUA_CMUNICIPIO',
        'USUA_NCVEMUNICIPIO',
        'USUA_CESTADO',
        'USUA_NCVESTADO',
        'USUA_CPAIS',
        'USUA_CCORREO_ELECTRONICO',
        'USUA_CCORREO_ALTERNATIVO',
        'USUA_CCALLE_PARTICULAR',
        'USUA_NNUMERO_INTERIOR_PARTICULAR',
        'USUA_NNUMERO_EXTERIOR_PARTICULAR',
        'USUA_NCP_PARTICULAR',
        'USUA_CCOLONIA_PARTICULAR',
        'USUA_NCVECOLONIA_PARTICULAR',
        'USUA_CMUNICIPIO_PARTICULAR',
        'USUA_NCVEMUNICIPIO_PARTICULAR',
        'USUA_CESTADO_PARTICULAR',
        'USUA_NCVEESTADO_PARTICULAR',
        'USUA_CPAIS_PARTICULAR',
        'USUA_NCVEPAIS_PARTICULAR',
        'USUA_NTELEFONO',
        'USUA_NEXTENSION',
        'USUA_CUSUARIO',
        'USUA_NACTIVO',
    ];
}
