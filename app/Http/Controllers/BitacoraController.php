<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cls_Bitacora;
use Illuminate\Support\Carbon;
use  Illuminate\Pagination\LengthAwarePaginator;
use  Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

class BitacoraController extends Controller
{
    public function index(Request $request)
    {  
        $ObjAuth = Auth::user();
        return view('HIS_BITACORA.index',compact('ObjAuth'));
    }

    public function consultar(Request $request){
        ## Read value
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page


        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        
       
        $bitacora = new Cls_Bitacora();
        $bitacora->StrTexto = $searchValue;
        $bitacora->IntNumPagina = $start;
        $bitacora->IntCantidadRegistros = $rowperpage;
        $bitacora->StrOrdenColumna = $columnName;
        $bitacora->StrOrdenDir =$columnSortOrder;
        $bitacora->IntUsuarioId = Auth::user()->USUA_NIDUSUARIO;
        $registros = $bitacora->TRAM_SP_CONSULTARBITACORA();

        $IntTotalRegistros = (int)$registros['pagination'][0]->TotalRegistros;
        $IntTotalRegistrosFiltrados = (int)$registros['registrosFiltrados'][0]->RegistrosFiltrados;
        
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $IntTotalRegistros,
            "iTotalDisplayRecords" => $IntTotalRegistrosFiltrados,
            "aaData" => $registros['data']
         );
        return response()->json($response);
    }
}
