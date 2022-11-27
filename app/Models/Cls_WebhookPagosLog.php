<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cls_WebhookPagosLog extends Model
{
    protected $table = 'webhook_pagos_log';
    protected $primaryKey = 'id';
    /* protected $fillable = [
        'FORM_CNOMBRE',
        'FORM_CDESCRIPCION',
        'FORM_BACTIVO',
        'FORM_DFECHA',
    ]; */

    public $timestamps = false;
}
