<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cls_Notificacion_Tramite extends Model
{
    protected $connection = 'mysql';
    protected $table = 'tram_his_notificacion_tramite';
    public $timestamps  = true;
    protected $fillable = [
        'HNOTI_NIDNOTIFICACION',
        'HNOTI_CITUTLO',
        'HNOTI_CMENSAJE',
        'HNOTI_NIDUSUARIOTRAMITE',
        'HNOTI_CFOLIO',
        'HNOTI_CNOMBRETRAMITE',
        'HNOTI_NLEIDO',
        'HNOTI_DFECHACREACION',
        'HNOTI_DFECHALEIDO',
        'HNOTI_CEMISOR',
        'HNOTI_ROLEMISOR',
        'HNOTI_CMENSAJECORTO',
        'HNOTI_NIDCONFIGSECCION',
        'HNOTI_NTIPO',
        'created_at',
        'updated_at'
    ];
}
