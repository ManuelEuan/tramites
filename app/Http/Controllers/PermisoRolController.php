<?php

namespace App\Http\Controllers;

use App\Cls_PermisoRol;
use Illuminate\Http\Request;

class PermisoRolController extends Controller
{
    public function consultar($id)
    {
        $result = Cls_PermisoRol::where('PROL_NIDROL',$id)->get();
        return Response()->json($result);
    }
}
