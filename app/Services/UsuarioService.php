<?php

namespace App\Services;

use App\User;
use Exception;
use Illuminate\Http\Request;

class UsuarioService {

    /**
     * Crea el registro en DB
     * @param Request $request
     * @return array
     */
    public function store(Request $request){
        $response = ["error" => null, "item" => null];
        try {
            $user = new User();
            $user->USUA_NIDROL          = $request->rolId;
            $user->USUA_NTIPO_PERSONA   = is_null($request->rdbTipo_Persona) ? 'FISICA' : $request->rdbTipo_Persona;
            $user->USUA_CRFC            = is_null($request->txtRfc) ? 'XAXX010101000' : $request->txtRfc;
            $user->USUA_CCURP           = is_null($request->txtCurp) ? '11111111111111' : $request->txtCurp;
            $user->USUA_NTIPO_SEXO      = $request->rdbSexo;
            $user->USUA_CRAZON_SOCIAL   = $request->txtRazon_Social ?? '';
            $user->USUA_CNOMBRES        = $request->txtNombres;
            $user->USUA_CPRIMER_APELLIDO    = $request->txtPrimer_Apellido;
            $user->USUA_CSEGUNDO_APELLIDO   = $request->txtSegundo_Apellido;
            $user->USUA_CCALLE              = $request->txtCalle_Fiscal ?? 0;
            $user->USUA_NNUMERO_INTERIOR    = $request->txtNumero_Interior_Fiscal ?? 0;
            $user->USUA_NNUMERO_EXTERIOR    = $request->txtNumero_Exterior_Fiscal ?? 0;
            $user->USUA_NCP                 = $request->txtCP_Fiscal ?? 0;
            $user->USUA_CCOLONIA            = $request->cmbColonia_Fiscal ?? 0;
            $user->USUA_NCVECOLONIA         = 0;
            $user->USUA_CMUNICIPIO          = $request->cmbMunicipio_Fiscal ?? 0;
            $user->USUA_NCVEMUNICIPIO       = 0;
            $user->USUA_CESTADO             = $request->cmbEstado_Fiscal ?? 0;
            $user->USUA_NCVEESTADO          = 0;
            $user->USUA_CPAIS               = $request->cmbPais_Fiscal ?? 0;
            $user->USUA_NCVEPAIS            = 0;
            $user->USUA_CCORREO_ELECTRONICO = $request->txtCorreo;
            $user->USUA_CCORREO_ALTERNATIVO = $request->txtCorreo_Alternativo;
            $user->USUA_CCONTRASENIA        = crypt($request->txtContrasenia, '$1$*$');
            $user->USUA_CCALLE_PARTICULAR   = $request->txtCalle_Particular ?? 0;
            $user->USUA_NCP_PARTICULAR      = $request->txtCP_Particular ?? 0;
            $user->USUA_CCOLONIA_PARTICULAR = $request->cmbColonia_Particular ?? 0;
            $user->USUA_CESTADO_PARTICULAR  = $request->cmbEstado_Particular ?? 0;
            $user->USUA_CPAIS_PARTICULAR    = $request->cmbPais_Particular ?? 0;
            $user->USUA_NCVEPAIS_PARTICULAR = 0;
            $user->USUA_NTELEFONO           = $request->txtNumeroTelefono ?? 0;
            $user->USUA_NEXTENSION          = $request->txtExtension ?? 0;
            $user->USUA_CUSUARIO            = $request->txtUsuario ?? 0;
            $user->USUA_NACTIVO             = 0;
            $user->USUA_NELIMINADO          = 0;
            $user->USUA_DFECHA_NACIMIENTO   = $request->fechaNacimientoFisica;
            $user->USUA_CTEL_LOCAL          = $request->txtNumeroTelefono ?? 0;
            $user->USUA_CTEL_CELULAR        = $request->txtNumeroTelefono ?? 0;
            $user->USUA_NCVECOLONIA_PARTICULAR      = 0;
            $user->USUA_CMUNICIPIO_PARTICULAR       = $request->cmbMunicipio_Particular ?? 0;
            $user->USUA_NCVEMUNICIPIO_PARTICULAR    = 0;
            $user->USUA_NCVEESTADO_PARTICULAR       = 0;
            $user->USUA_DFECHA_CONSTITUCION         = $request->fechaConstitucionMoral;
            $user->USUA_CNOMBRE_NOTIFICACION        = $request->nombrePersonaAutorizada;
            $user->USUA_CPRIMERAPELLIDO_NOTIFICACION = $request->apellidoPrimerAutorizada;
            $user->USUA_CSEGUNDOAPELLIDO_NOTIFICACION = $request->apellidoSegundoAutorizada;
            $user->USUA_CTEL_LOCAL_NOTIFICACION     = $request->telefonoPersonaAutorizada ?? 0;
            $user->USUA_CTEL_CELULAR_NOTIFICACION   = $request->telefonoPersonaAutorizada ?? 0;
            $user->USUA_CCORREO_NOTIFICACION        = $request->correoPersonaAutorizada;
            $user->USUA_NNUMERO_INTERIOR_PARTICULAR = $request->txtNumero_Interior_Particular ?? 0;
            $user->USUA_NNUMERO_EXTERIOR_PARTICULAR = $request->txtNumero_Exterior_Particular ?? 0;
            $user->save();
            $response['item'] = $user;
        } catch (Exception $ex) {
            $response['error'] = $ex->getMessage();
        }

        return $response;
    }
}