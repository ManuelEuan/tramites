<?php

namespace App\Http\Controllers;

use App\User;
use App\Cls_Bitacora;
use Illuminate\Http\Request;
use App\Services\BitacoraService;
use Illuminate\Support\Facades\Auth;

class BitacoraController extends Controller
{
    protected $bitacoraServicio;
    public function __construct() {
        $this->bitacoraServicio = new BitacoraService();    
    }

    public function index(Request $request){  
        $ObjAuth = Auth::user();
        return view('HIS_BITACORA.index',compact('ObjAuth'));
    }

    public function consultar(Request $request){
        $registros = $this->bitacoraServicio->find((object)$request->all());
        $response = array(
            "draw"          => intval($request->draw),
            "iTotalRecords" => $registros['total'],
            "iTotalDisplayRecords" => $registros['total'],
            "aaData"        => $registros['data']
         );
        return response()->json($response);
    }
}
