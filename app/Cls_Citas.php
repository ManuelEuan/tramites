<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Cls_Citas extends Model
{
    protected $connection   = 'pgsql';
    protected $table        = 'tram_aux_citas_reservadas';
    protected $fillable     = ['idtram_aux_citas_reservadas', 'CITA_FOLIO', 'CITA_STATUS', 'CITA_IDUSUARIO', 'CITA_IDTRAMITECONF'];
    protected $primaryKey   = 'idtram_aux_citas_reservadas';
    protected $timestamps   = false;

}
