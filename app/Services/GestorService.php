<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class GestorService
{
    /**
     * Retorna la busqueda de los gestores en base al tipo de persona y el usuario logueado
     * @param string $data
     * @return array
     */
    public function getGestores(string $tipo= 'FISICA'){
        $gestores = DB::table('tram_mdv_gestores as g')
                        ->join('tram_mst_usuario as u', 'g.GES_NUSUARIOID', '=', 'u.USUA_NIDUSUARIO')
                        ->select('u.USUA_CRFC', 'u.USUA_CCURP', 'u.USUA_NIDUSUARIO', 'u.USUA_CNOMBRES', 'u.USUA_CPRIMER_APELLIDO', 'u.USUA_CSEGUNDO_APELLIDO', 'u.USUA_CRAZON_SOCIAL', 'g.*')
                        ->where('g.GES_NGESTORID', Auth::user()->USUA_NIDUSUARIO)
                        ->where('u.USUA_NTIPO_PERSONA', 'FISICA')
                        ->where('g.GES_CESTATUS', 'Autorizado')
                        ->get();

       return $gestores;
    }

    
}