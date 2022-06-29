<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cls_Notificacion extends Model
{
    protected $table = 'tram_his_notificacion';
    protected $primaryKey = 'NOTI_NID';
    protected $fillable = [
        'NOTI_NIDREMITENTE',
        'NOTI_NIDRECEPTOR',
        'NOTI_CURL',
        'NOTI_CTITULO',
        'NOTI_CMENSAJE',
        'NOTI_NLEIDO',
        'NOTI_DFECHACREAACION',
        'NOTI_CTIPO'
    ];

    public $timestamps = false;
}
