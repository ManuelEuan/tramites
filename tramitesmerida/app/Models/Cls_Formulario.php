<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cls_Formulario extends Model
{
    protected $table = 'tram_form_formulario';
    protected $primaryKey = 'FORM_NID';
    protected $fillable = [
        'FORM_CNOMBRE',
        'FORM_CDESCRIPCION',
        'FORM_BACTIVO',
        'FORM_DFECHA',
    ];

    public $timestamps = false;
}
