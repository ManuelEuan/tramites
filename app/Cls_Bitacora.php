<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Cls_Bitacora extends Model
{
    protected $connection   = 'pgsql';
    protected $table        = 'tram_his_bitacora';
    protected $fillable     = ['BITA_NIDBITACORA', 'BITA_NIDUSUARIO', 'BITA_CMOVIMIENTO', 'BITA_CTABLA', 'BITA_FECHAMOVIMIENTO', 'BITA_CIP'];
    protected $primaryKey   = 'BITA_NIDBITACORA';
    public $timestamps      = false;
}
