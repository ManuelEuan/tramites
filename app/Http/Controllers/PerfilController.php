<?php

namespace App\Http\Controllers;

use App\User;
use DateTime;
use Exception;
use App\Cls_Usuario;
use App\Cls_Bitacora;
use App\Cls_Sucursal;
use Illuminate\Http\Request;
use App\Services\VariosService;
use App\Models\Cls_DocumentosBase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PerfilController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(Request $request) {
        $usuario        = Auth::user();
        $docsUser       = Cls_Usuario::getTipoDocs($usuario->USUA_NTIPO_PERSONA);
        $docsUpdates    = Cls_Usuario::getDocsUser($usuario->USUA_NIDUSUARIO);
        $hoy            = date('Y-m-d');
        $data           = array();

        foreach ($docsUser as $key => $i) {
            $tiene  = false;
            $peso   = '';
            $estatus= '';
            $idDoc  = '';

            foreach ($docsUpdates as $key => $j) {
                if ($j->ID_CDOCUMENTOS == $i->id) {
                    $tiene      = true;
                    $peso       = $j->PESO;
                    $estatus    = $j->estatus;
                    $idDoc      = $j->id;
                }
            }

            $data[] = array(
                'id'        => $i->id,
                'tipo'      => $i->NOMBRE,
                'extension' => 'pdf',
                'obligatorio' => '',
                'ruta'      => '',
                'tiene'     => $tiene,
                'peso'      => $peso,
                'estatus'   => $estatus,
                'idDoc'     => $idDoc
            );
        }

        if($usuario->USUA_NTIPO_PERSONA == "MORAL"){
            $personaFisica = Cls_Usuario::where("USUA_CCURP", $usuario->USUA_CCURP)->first();
            if($personaFisica){
                $usuario->USUA_DFECHA_NACIMIENTO = $personaFisica->USUA_DFECHA_NACIMIENTO;
            }
        }

        $usuario['documentos'] = $data;
        return view('MST_PERFIL.index', compact('usuario'));
    }

    public function listarDocs(){
        $ObjAuth    = Auth::user();
        $docsUser   = Cls_Usuario::getTipoDocs($ObjAuth->USUA_NTIPO_PERSONA);
        $updates    = Cls_Usuario::getDocsUser($ObjAuth->USUA_NIDUSUARIO);
        $data       = array();
        $hoy        = date('Y-m-d');

        foreach ($docsUser as $key => $i) {
            try {
                $tiene  = false;
                $peso   = '';
                $estatus= '';
                $icono  = '';
                $idDoc  = '';
                $btnRemplazar = '';
                $vencido = '';
    
    
                foreach ($updates as $key => $j) {
                    if ($j->ID_CDOCUMENTOS == $i->id) {
                        $tiene = true;
                        $peso = round((intval($j->PESO) / 1024),2).' KB';
                        $estatus = $j->estatus;
                        $idDoc = $j->id;
                        $url = $j->ruta;
    
                        ///ESTATUS ultimo dosc actualizado
                        $estatusDOCSa   ='';$id_docs_ACT='';$idusrBase='';
                        $docsUser       = Cls_DocumentosBase::where(['ID_USUARIO' => $j->ID_USUARIO, 'ID_CDOCUMENTOS' => $i->id])->get();
                        foreach ($docsUser as $key => $H) {
                            $estatusDOCSa = $H->USDO_NESTATUS;
                            $idusrBase = $H->USDO_NIDUSUARIOBASE;
                        }
                        if($estatusDOCSa!='')
                            $estatus= $estatusDOCSa;
    
                        $docs_con   = Cls_DocumentosBase::find($j->id);
                        $vigencia   = '';
                        
                        if($docs_con->VIGENCIA_FIN != ''){
                            $format     =  new DateTime($docs_con->VIGENCIA_FIN);
                            $vigencia   = $format->format('d-m-Y');
                        }
    

                        $vg_FIN = '<span style="color:#FF0000">'.$vigencia.'</span>';
                        if($j->isActual == 1){
                            if($j->VIGENCIA_FIN != ''){
                                if($j->VIGENCIA_FIN < $hoy){
                                    $btnRemplazar = '<input class="fileadd" type="file" name="doc'.$i->id.'" style="display:none;" />
                                    <button type="button" onclick="guardarDoc('.$i->id.',event)" title="Guardar archivo" id="btn'.$i->id.'"
                                     class="btn btn-success"><i class="fa fa-plus"></i></button>';
                                    $vencido = '<span>Vencido</span><br>'.$vg_FIN;
                                }else{
                                    $vencido = $j->VIGENCIA_FIN;
                                }
                            }else{
                                $vencido = 'N/A';
                            }
                        }
                        $det_btn_color = 'btn-danger';
                        $det_btn_click = 'onclick="deleteDocUser('.$idDoc.')"';
                        if (intval($estatus) == 1){
                            $icono = 'Pendiente revision';
                        };
                        if (intval($estatus) == 3){
                            $icono = 'Rechazado <span title="Rechazado" class="fa fa-warning" style="color:#eddb04"></span>';
                        };
                        if (intval($estatus) == 2){
                            $icono = 'Aceptado';
                            $det_btn_color = 'btn-secondary';
                            $det_btn_click = 'style="opacity:0"';
                        };
                        //$icono = $icono.'-->'.$iiii;
    
                    }
                }
    
                $data[] = array(
                    '0' => $i->NOMBRE,
                    '1' => $peso,
                    '2' => $icono,
                    '3' => $vencido,
                    '4' => ($tiene) ? $btnRemplazar.'
                    <button title="Ver archivo" class="btn btn-primary" onclick="verHDocs('.$i->id.')"><i class="fa fa-eye"></i></button>
                    <button '.$det_btn_click.' title="Eliminar documento" class="btn '.$det_btn_color.'"><i class="fa fa-times"></i></button>
                    </td>': '<input class="fileadd" type="file" name="doc'.$i->id.'" style="display:none;" />
                    <button type="button" onclick="guardarDoc('.$i->id.',event)" title="Guardar archivo" id="btn'.$i->id.'" class="btn btn-success"><i class="fa fa-plus"></i></button>'
                );
            } catch (Exception $ex) {
                dd($ex);
            }
        }

        $results = array(
            "sEcho"=>1, //Informaci??n para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);

        return json_encode($results);
    }
    /**
     *
     */
    public function listarResolutivos(){
        $ObjAuth    = Auth::user();
        $docsUser   = Cls_Usuario::getResolutivosUser($ObjAuth->USUA_NIDUSUARIO);
        $data       = array();
        $hoy        = date('Y-m-d');
        $host       = $_SERVER["HTTP_HOST"];
        foreach ($docsUser as $key => $i) {
            // $tiene = false;
            $peso = '';
            $estatus = '';
            // $icono = '';
            // $idDoc = '';
            // $btnRemplazar = '';
            // $vencido = '';
            $peso = $i->USRE_NPESO / 8000;
            $peso = number_format($peso, 2);

            $data[] = array(
                '0' => date("d-m-Y", strtotime($i->created_at)),
                '1' => '<p>'.$i->TRAM_CNOMBRE.'</p>',
                '2' => $peso . ' MB ' ,
                '3' => '<a title="Ver archivo" class="btn btn-primary" href="'.$i->USRE_CRUTADOC.'" target="_blank"><i class="fa fa-eye"></i></a>'
                // '4' => 'sin vencimiento',
                // '5' => '<p style="color: green;"> Vigente <i class="fa-solid fa-circle-check"></i></p>'

            );
            // $data[] = array(
            //     '0' => $i->NOMBRE,
            //     '1' => $peso,
            //     '2' => $icono,
            //     '3' => $vencido,
            //     '4' => ($tiene) ? $btnRemplazar.'
            //     <button title="Ver archivo" class="btn btn-primary" onclick="verHDocs('.$i->id.')"><i class="fa fa-eye"></i></button>
            //     <button '.$det_btn_click.' title="Eliminar documento" class="btn '.$det_btn_color.'"><i class="fa fa-times"></i></button>
            //     </td>': '<input class="fileadd" type="file" name="doc'.$i->id.'" style="display:none;" />
            //     <button type="button" onclick="guardarDoc('.$i->id.',event)" title="Guardar archivo" id="btn'.$i->id.'" class="btn btn-success"><i class="fa fa-plus"></i></button>'
            // );
        }
        $results = array(
            "sEcho"=>1, //Informaci??n para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);

        return json_encode($results);
    }
    
    public function modificar(Request $request)
    {
        $response = [];
        try {
            DB::beginTransaction();
            $existUser = Cls_Usuario::where("USUA_CCURP", $request->USUA_CCURP)->first();

            if(!is_null($existUser)){
                if($existUser->USUA_NIDUSUARIO != $request->txtIdUsuario){
                    $response = [
                        'codigo'    => 400,
                        'status'    => "error",
                        'message'   => 'CURP HA SIDO REGISTRADO POR ALGUIEN MAS'
                    ];
                    return $response;
                }
            }

            $usuario = User::find($request->txtIdUsuario);
            $usuario->update($request->all());
            Cls_Sucursal::where('SUCU_NIDUSUARIO',$request->txtIdUsuario)->delete();

            //Agregar sucursales
            if(isset($request->lstSucursal)){
                foreach ($request->lstSucursal as $value) {
                    $ObjSucursal = array(
                        'txtUsuario'    => $request->txtIdUsuario,
                        'txtCalle'      => $value['txtCalle_Sucursal'],
                        'txtCP'         => $value['txtCP_Sucursal'],
                        'cmbColonia'    => $value['cmbColonia_Sucursal'],
                        'cmbMunicipio'  => $value['cmbMunicipio_Sucursal'],
                        'cmbEstado'     => $value['cmbEstado_Sucursal'],
                        'cmbPais'       => $value['cmbPais_Sucursal'],
                        'txtNumero_Interior' => $value['txtNumero_Interior_Sucursal'],
                        'txtNumero_Exterior' => $value['txtNumero_Exterior_Sucursal'],
                    );
                    Cls_Sucursal::create($ObjSucursal);
                }
            }

            //Insertar bitacora
            $ObjBitacora = new Cls_Bitacora();
            $ObjBitacora->BITA_NIDUSUARIO   = $existUser->USUA_NIDUSUARIO;
            $ObjBitacora->BITA_CMOVIMIENTO  = "Edici??n de perfil";
            $ObjBitacora->BITA_CTABLA       = $existUser->TRAM_CAT_ROL->ROL_CCLAVE != "CDNS" ? "tram_mst_usuario" : "tram_mst_usuario y tram_mdv_sucursal";
            $ObjBitacora->BITA_CIP          = $request->ip();
            $ObjBitacora->BITA_FECHAMOVIMIENTO = now();
            $ObjBitacora->save();
            
            $response = [
                'codigo'    => 200,
                'status'    => "success",
                'message'   => '????xito! Los datos se han guardado correctamente.'
            ];
            DB::commit(); 
        } catch (Exception $e) { dd($e);
            DB::rollBack();
            $response = [
                'codigo'    => 400,
                'status'    => "error",
                'message'   => "Ocurri?? una excepci??n, favor de contactar al administrador del sistema , " . $e->getMessage()
            ];
        }


        return Response()->json($response);
    }

    function confirmar(Request $request)
    {
        $response = [];
        $ObjAuth = Auth::user();

        try {
            if (
                $request->txtCorreo_RFC_Electronico !=  $ObjAuth->USUA_CCORREO_ELECTRONICO
                && $request->txtCorreo_RFC_Electronico != $ObjAuth->USUA_CRFC
            ) {
                $response = [
                    'codigo' => 400,
                    'status' => "error",
                    'message' => "Los datos ingresados no corresponden a los datos del usuario logueado."
                ];
                return Response()->json($response);
            }

            if (crypt($request->txtContrasena_Actual, '$1$*$') != $ObjAuth->USUA_CCONTRASENIA) {
                $response = [
                    'codigo' => 400,
                    'status' => "error",
                    'message' => "La contrase??a no es v??lida, favor de verificar."
                ];
                return Response()->json($response);
            }

            if (
                $request->txtCorreo_RFC_Electronico == $ObjAuth->USUA_CCORREO_ELECTRONICO && crypt($request->txtContrasena_Actual, '$1$*$') == $ObjAuth->USUA_CCONTRASENIA
                || $request->txtCorreo_RFC_Electronico == $ObjAuth->USUA_CRFC && crypt($request->txtContrasena_Actual, '$1$*$') == $ObjAuth->USUA_CCONTRASENIA
            ) {
                $response = [
                    'codigo' => 200,
                    'status' => "success",
                    'message' => '????xito! Acci??n realizada con ??xito.'
                ];
            } else {
                $response = [
                    'codigo' => 400,
                    'status' => "error",
                    'message' => "Los datos ingresados no corresponden a los datos del usuario logueado."
                ];
            }
        } catch (Exception $e) {
            $response = [
                'codigo' => 400,
                'status' => "error",
                'message' => "Ocurri?? una excepci??n, favor de contactar al administrador del sistema , " . $e->getMessage()
            ];
        }
        return Response()->json($response);
    }

    function confirmarServidor(Request $request)
    {
        $response = [];
        $ObjAuth = Auth::user();

        try {
            if (
                $request->txtCorreo_RFC_Electronico !=  $ObjAuth->USUA_CCORREO_ELECTRONICO
                && $request->txtCorreo_RFC_Electronico != $ObjAuth->USUA_CUSUARIO
            ) {
                $response = [
                    'codigo' => 400,
                    'status' => "error",
                    'message' => "Los datos ingresados no corresponden a los datos del usuario logueado."
                ];
                return Response()->json($response);
            }

            if (crypt($request->txtContrasena_Actual, '$1$*$') != $ObjAuth->USUA_CCONTRASENIA) {
                $response = [
                    'codigo' => 400,
                    'status' => "error",
                    'message' => "La contrase??a no es v??lida, favor de verificar."
                ];
                return Response()->json($response);
            }

            if (
                $request->txtCorreo_RFC_Electronico == $ObjAuth->USUA_CCORREO_ELECTRONICO && crypt($request->txtContrasena_Actual, '$1$*$') == $ObjAuth->USUA_CCONTRASENIA
                || $request->txtCorreo_RFC_Electronico == $ObjAuth->USUA_CUSUARIO && crypt($request->txtContrasena_Actual, '$1$*$') == $ObjAuth->USUA_CCONTRASENIA
            ) {
                $response = [
                    'codigo' => 200,
                    'status' => "success",
                    'message' => '????xito! Acci??n realizada con ??xito.'
                ];
            } else {
                $response = [
                    'codigo' => 400,
                    'status' => "error",
                    'message' => "Los datos ingresados no corresponden a los datos del usuario logueado."
                ];
            }
        } catch (Exception $e) {
            $response = [
                'codigo' => 400,
                'status' => "error",
                'message' => "Ocurri?? una excepci??n, favor de contactar al administrador del sistema , " . $e->getMessage()
            ];
        }
        return Response()->json($response);
    }

    public function guardarDocs( Request $request){
        $servicio   = new VariosService();
        $archivo    = $servicio->subeArchivo($request->documento, 'files/documentosUser/');
        $docsUser   = Cls_Usuario::guardarDocs($request, Auth::user()->USUA_NIDUSUARIO, $archivo);
       
        return 'El documento ha sido guardado con ??xito!';
    }

    public function eliminarDoc(Request $request){
        $delete = Cls_DocumentosBase::find($request->id)->update(['isDelete' => true]);
        return $delete ? 'Documento eliminado con ??xito!' : 'EL documento no se pudo eliminar';
    }

    public function getDocsHistory(){
        $ObjAuth    = Auth::user();
        $rspt       = Cls_Usuario::getHistoryDocs($ObjAuth->USUA_NIDUSUARIO);
        $data       = array();
        foreach ($rspt as $key => $i) {
             $nombre= explode("/", $i->USDO_CRUTADOC);
             $ultimo = count($nombre) - 1;
             $numero = $key + 1;
             $P_NESTATUS =  $i->USDO_NESTATUS;
             if($P_NESTATUS==0){$TXT_STAT='Pendiente revisi??n';};
             if($P_NESTATUS==1){$TXT_STAT='Rechazado';};
             if($P_NESTATUS==2){$TXT_STAT='';};
            $data[] = array(
                '0' => $numero,
                '1' => '<a href="'.asset('').$i->USDO_CRUTADOC. '" target="_blank">'.$i->USDO_CDOCNOMBRE.'</a>',
                '2' => $TXT_STAT,
                '3' => ''
            );
        }
        $results = array(
            "sEcho"=>1, //Informaci??n para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);

        return json_encode($results);
    }
    public function getDocsHistoryExpediente($id)
    {
        $ObjAuth = Auth::user();
        //$rspt = Cls_Usuario::getHistoryExpe($id, $ObjAuth->USUA_NIDUSUARIO);
        $rspt = Cls_Usuario::getEXPtram($id, $ObjAuth->USUA_NIDUSUARIO);
        $data = array();
        foreach ($rspt as $key => $i) {
            $nombre = explode("/", $i->ruta);
            $ultimo = count($nombre) - 1;
            $numero = $key + 1;
            $fecha = new DateTime($i->create_at);
            $data[] = array(
                '0' => $numero,
                '1' => '<a href="' . asset('').$i->ruta . '" target="_blank">'. $nombre[$ultimo] . '</a>',
                '2' => $fecha->format('d-m-Y'),
            );
        }
        $results = array(
            "sEcho" => 1, //Informaci??n para el datatables
            "iTotalRecords" => count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
            "aaData" => $data
        );

        return json_encode($results);
    }
    public function setActual(Request $request){
        $result = Cls_Usuario::setActual($request->id);
        return $result ? 'Documento seleccionado' : 'El documento no se pudo actualizar';
        //echo json_encode($request->id);
    }
}
