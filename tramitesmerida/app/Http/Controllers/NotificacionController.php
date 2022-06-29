<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cls_Notificacion;
use Illuminate\Support\Facades\DB;

class NotificacionController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function getNotificaciones(Request $request)
    {

        $noti_tramite = DB::table('tram_his_notificacion_tramite')
        ->join('tram_mdv_usuariotramite', 'tram_his_notificacion_tramite.HNOTI_NIDUSUARIOTRAMITE', '=', 'tram_mdv_usuariotramite.USTR_NIDUSUARIOTRAMITE')
        ->where(['tram_mdv_usuariotramite.USTR_NIDUSUARIO' => $request->usuario_id, 'tram_his_notificacion_tramite.HNOTI_NLEIDO' => false])
            ->get();

        $noti_general = Cls_Notificacion::where(['NOTI_NIDRECEPTOR' => $request->usuario_id, 'NOTI_NLEIDO' => false])->get();

        $items = [
            "notificaciones" => $noti_general,
            "notificaciones_tramite" => $noti_tramite
        ];

        return response()->json($items, 200);
    }


}
