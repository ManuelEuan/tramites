<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'USUA_NIDUSUARIO', 'USUA_CCORREO_ELECTRONICO', 'USUA_CCONTRASENIA',
    ];
    
    protected $table = 'tram_mst_usuario';
    protected $primaryKey = 'USUA_NIDUSUARIO';

    public function getEmailAttribute() {
        return $this->USUA_CCORREO_ELECTRONICO;
    }
  
    public function setEmailAttribute($value)
    {
      $this->attributes['USUA_CCORREO_ELECTRONICO'] = strtolower($value);
    }

    public function getPasswordAttribute() {
        return $this->USUA_CCONTRASENIA;
    }
  
    public function setPasswordAttribute($value)
    {
      $this->attributes['USUA_CCONTRASENIA'] = strtolower($value);
    }

    public function getidAttribute() {
        return $this->USUA_NIDUSUARIO;
    }
    
    public function setIidttribute($value)
    {
      $this->attributes['USUA_NIDUSUARIO'] = strtolower($value);
    }

    protected $with = ['TRAM_CAT_ROL', 'TRAM_MDV_SUCURSAL'];
    public function TRAM_CAT_ROL()
    {
        //forean key, primay key
        return $this->belongsTo('App\Cls_Rol', 'USUA_NIDROL', 'ROL_NIDROL');
    }
    
    public function TRAM_MDV_SUCURSAL()
    {
        return $this->hasMany('App\Cls_Sucursal', 'SUCU_NIDUSUARIO', 'USUA_NIDUSUARIO');
    }
}
