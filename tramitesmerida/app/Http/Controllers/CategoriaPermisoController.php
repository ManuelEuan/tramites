<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cls_Categoria_Permiso;

class CategoriaPermisoController extends Controller
{
    public function consultar()
    {
        $result = Cls_Categoria_Permiso::TRAM_SP_CONSULTAR_CATEGORIA_PERMISO();
        return Response()->json($result);
    }
}
