<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cls_Dia_Inhabil extends Model
{
    protected $table = 'cemr_dias_inhabiles';
    protected $primaryKey = 'FORM_NID';
    protected $fillable = [
        'FORM_CNOMBRE',
        'FORM_CCOLOR',
        'FORM_DINICIO',
        'FORM_DFINAL'
    ];

    public $timestamps = false;
}
