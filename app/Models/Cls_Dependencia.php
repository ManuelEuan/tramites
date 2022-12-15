<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cls_Dependencia extends Model
{
    protected $connection   = 'pgsql';
    protected $table        = 'catalogos';
    protected $timestamps   = false;
    protected $primaryKey   = 'DEPE_NIDDEPENDENCIA';
    protected $fillable     = [ 'DEPE_CNOMBRE' ];
}
