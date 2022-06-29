<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cls_Cat_Seccion extends Model
{
    protected $table = 'tram_cat_secciones';
    protected $fillable = [
        'FORM_CNOMBRE',
        'FORM_CDESCRIPCION',
        'FORM_BACTIVO',
    ];

    public $timestamps = false;
}
