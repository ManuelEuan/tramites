<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    protected $connection   = 'pgsql';
    protected $table        = 'tram_mst_usuario';
    protected $primaryKey   = 'USUA_NIDUSUARIO';
    protected $with         = ['TRAM_CAT_ROL', 'TRAM_MDV_SUCURSAL'];
    protected $fillable     = [
        'USUA_NIDUSUARIO',
        'USUA_NIDROL',
        'USUA_NTIPO_PERSONA',
        'USUA_CRFC',
        'USUA_CCURP',
        'USUA_NTIPO_SEXO',
        'USUA_CRAZON_SOCIAL',
        'USUA_CNOMBRES',
        'USUA_CPRIMER_APELLIDO',
        'USUA_CSEGUNDO_APELLIDO',
        'USUA_CCALLE',
        'USUA_NNUMERO_INTERIOR',
        'USUA_NNUMERO_EXTERIOR',
        'USUA_NCP',
        'USUA_CCOLONIA',
        'USUA_NCVECOLONIA',
        'USUA_CMUNICIPIO',
        'USUA_NCVEMUNICIPIO',
        'USUA_CESTADO',
        'USUA_NCVEESTADO',
        'USUA_CPAIS',
        'USUA_NCVEPAIS',
        'USUA_CCORREO_ELECTRONICO',
        'USUA_CCORREO_ALTERNATIVO',
        'USUA_CCONTRASENIA',
        'USUA_CCALLE_PARTICULAR',
        'USUA_NNUMERO_INTERIOR_PARTICULAR',
        'USUA_NNUMERO_EXTERIOR_PARTICULAR',
        'USUA_NCP_PARTICULAR',
        'USUA_CCOLONIA_PARTICULAR',
        'USUA_NCVECOLONIA_PARTICULAR',
        'USUA_CMUNICIPIO_PARTICULAR',
        'USUA_NCVEMUNICIPIO_PARTICULAR',
        'USUA_CESTADO_PARTICULAR',
        'USUA_NCVEESTADO_PARTICULAR',
        'USUA_CPAIS_PARTICULAR',
        'USUA_NCVEPAIS_PARTICULAR',
        'USUA_NTELEFONO',
        'USUA_NEXTENSION',
        'USUA_CUSUARIO',
        'USUA_NACTIVO',
        'USUA_NELIMINADO',
        'USUA_DFECHA_NACIMIENTO',
        'USUA_CTEL_LOCAL',
        'USUA_CTEL_CELULAR',
        'USUA_DFECHA_CONSTITUCION',
        'USUA_CNOMBRE_NOTIFICACION',
        'USUA_CPRIMERAPELLIDO_NOTIFICACION',
        'USUA_CSEGUNDOAPELLIDO_NOTIFICACION',
        'USUA_CTEL_LOCAL_NOTIFICACION',
        'USUA_CTEL_CELULAR_NOTIFICACION',
        'USUA_CCORREO_NOTIFICACION',
        'email_verified_at'
    ];

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

    public function TRAM_CAT_ROL()
    {
        //forean key, primay key
        return $this->belongsTo(Cls_Rol::class, 'USUA_NIDROL', 'ROL_NIDROL');
    }
    
    public function TRAM_MDV_SUCURSAL()
    {
        return $this->hasMany(Cls_Sucursal::class, 'SUCU_NIDUSUARIO', 'USUA_NIDUSUARIO');
    }
}
