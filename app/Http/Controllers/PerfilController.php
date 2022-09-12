<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Cls_Rol;
use App\Cls_Usuario;
use App\Cls_Usuario_Documento;
use App\Cls_Sucursal;
use App\Cls_Bitacora;
use Exception;

class PerfilController extends Controller
{ 
    public function index(Request $request)
    {
        $ObjAuth = Auth::user();
        if ($ObjAuth == null) {
            return view('MSTP_LOGIN.index');
        }
        $docsUser = Cls_Usuario::getTipoDocs($ObjAuth->USUA_NTIPO_PERSONA);
        $docsUpdates = Cls_Usuario::getDocsUser($ObjAuth->USUA_NIDUSUARIO);
        $hoy = date('Y-m-d');
        $data = array();
        foreach ($docsUser as $key => $i) {
            $tiene = false;
            $peso = '';
            $estatus = '';
            $idDoc = '';
            foreach ($docsUpdates as $key => $j) {
                if ($j->ID_CDOCUMENTOS == $i->id) {
                    $tiene = true;
                    $peso = $j->PESO;
                    $estatus = $j->estatus;
                    $idDoc = $j->id;
                }
            }
            $data[] = array(
                'id' => $i->id,
                'tipo' => $i->NOMBRE,
                'extension' => 'pdf',
                'obligatorio' => '',
                'ruta' => '',
                'tiene' => $tiene,
                'peso' => $peso,
                'estatus' => $estatus,
                'idDoc' => $idDoc
            );
        }
        $ObjAuth['documentos'] = $data;
        // var_dump(($ObjAuth['documentos']));
        // exit();
        return view('MST_PERFIL.index', compact('ObjAuth')); 
    }
    public function listarDocs(){
        $ObjAuth = Auth::user();
        $docsUser = Cls_Usuario::getTipoDocs($ObjAuth->USUA_NTIPO_PERSONA);
        $docsUpdates = Cls_Usuario::getDocsUser($ObjAuth->USUA_NIDUSUARIO);
        $data = array();
        $hoy = date('Y-m-d');
        foreach ($docsUser as $key => $i) {
            $tiene = false;
            $peso = '';
            $estatus = '';
            $icono = '';
            $idDoc = '';
            $btnRemplazar = '';
            $vencido = '';

            
            foreach ($docsUpdates as $key => $j) {
                if ($j->ID_CDOCUMENTOS == $i->id) {
                    $tiene = true;
                    $peso = (intval($j->PESO) / 1024).' KB';
                    $estatus = $j->estatus;
                    $idDoc = $j->id;
                    
                    ///ESTATUS ultimo dosc actualizado
                    $estatusDOCSa='';$id_docs_ACT='';$idusrBase='';
                    $docs_u = Cls_Usuario::getTipoDocsACT($j->ID_USUARIO, $i->NOMBRE);
                    foreach ($docs_u as $key => $H) {
                        $estatusDOCSa = $H->USDO_NESTATUS;
                        $idusrBase = $H->USDO_NIDUSUARIOBASE;
                    }
                    if($estatusDOCSa!=''){$estatus=$estatusDOCSa;}
                    //////////////////////////////////////////////////////
                    $id_config = '';
                    $docs_con = Cls_Usuario::getVigDocsBASE($j->id);
                    foreach ($docs_con as $kys => $ks) {
                        $id_config = $ks->VIG;
                    }
                    //////////////////////////////////////////////////////
                    $vg_FIN = '<span style="color:#FF0000">'.$id_config.'</span>';

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
        }
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);

        return json_encode($results);
    }
    /**
     * 
     */
    public function listarResolutivos(){
        $ObjAuth = Auth::user();
        $docsUser = Cls_Usuario::getResolutivosUser($ObjAuth->USUA_NIDUSUARIO);
        $data = array();
        $hoy = date('Y-m-d');
        $host = $_SERVER["HTTP_HOST"];
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
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);

        return json_encode($results);
    }
    public function modificar(Request $request)
    {
        $response = [];
        try {
            //$request->txtRol = Cls_Rol::TRAM_SP_OBTENERROLPORCLAVE("CDNS");
            $request->txtRol = Auth::user()->TRAM_CAT_ROL->ROL_NIDROL; //ROL_NIDROL

            if (Auth::user()->TRAM_CAT_ROL->ROL_CCLAVE == "CDNS")
                //$request->txtTelefono = "";
                $request->txtExtension = "";
            $request->txtUsuario = "";

            Cls_Usuario::TRAM_SP_MODIFICARUSUARIO($request);

            //Eliminar sucursal actuales
            Cls_Sucursal::TRAM_SP_ELIMINARSUCURSAL_USUARIO($request->txtIdUsuario);

            //Agregar sucursales
            foreach ($request->lstSucursal as $value) {
                $ObjSucursal = array(
                    'txtUsuario' => $request->txtIdUsuario,
                    'txtCalle' => $value['txtCalle_Sucursal'],
                    'txtNumero_Interior' => $value['txtNumero_Interior_Sucursal'],
                    'txtNumero_Exterior' => $value['txtNumero_Exterior_Sucursal'],
                    'txtCP' => $value['txtCP_Sucursal'],
                    'cmbColonia' => $value['cmbColonia_Sucursal'],
                    'cmbMunicipio' => $value['cmbMunicipio_Sucursal'],
                    'cmbEstado' => $value['cmbEstado_Sucursal'],
                    'cmbPais' => $value['cmbPais_Sucursal']
                );
                Cls_Sucursal::TRAM_SP_AGREGARSUCURSAL($ObjSucursal);
            }

            //Insertar bitacora
            $ObjBitacora = new Cls_Bitacora();
            $ObjBitacora->BITA_NIDUSUARIO = Auth::user()->USUA_NIDUSUARIO;
            $ObjBitacora->BITA_CMOVIMIENTO = "Edición de perfil";
            $ObjBitacora->BITA_CTABLA = Auth::user()->TRAM_CAT_ROL->ROL_CCLAVE != "CDNS" ? "tram_mst_usuario" : "tram_mst_usuario y tram_mdv_sucursal";
            $ObjBitacora->BITA_CIP = $request->ip();
            Cls_Bitacora::TRAM_SP_AGREGARBITACORA($ObjBitacora);
        } catch (Exception $e) {
            $response = [
                'codigo' => 400,
                'status' => "error",
                'message' => "Ocurrió una excepción, favor de contactar al administrador del sistema , " . $e->getMessage()
            ];
        }
        $response = [
            'codigo' => 200,
            'status' => "success",
            'message' => '¡Éxito! Acción realizada con éxito.'
        ];

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
                    'message' => "La contraseña no es válida, favor de verificar."
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
                    'message' => '¡Éxito! Acción realizada con éxito.'
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
                'message' => "Ocurrió una excepción, favor de contactar al administrador del sistema , " . $e->getMessage()
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
                    'message' => "La contraseña no es válida, favor de verificar."
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
                    'message' => '¡Éxito! Acción realizada con éxito.'
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
                'message' => "Ocurrió una excepción, favor de contactar al administrador del sistema , " . $e->getMessage()
            ];
        }
        return Response()->json($response);
    }
    public function guardarDocs( Request $request){
        $ObjAuth = Auth::user();

        $nombre = $request->file('documento')->getClientOriginalName();
        $docsUser = Cls_Usuario::guardarDocs($request, $ObjAuth->USUA_NIDUSUARIO, $nombre);
        if($docsUser){

            //$request->file('documento')->storeAs('files/documentosUser/'.$ObjAuth->USUA_NIDUSUARIO, $nombre);
            $File = $request->file('documento');
            $IntSize = $File->getSize();
            $StrExtension = $File->getClientOriginalExtension();
            $File->move(public_path('files/documentosUser/' . $ObjAuth->USUA_NIDUSUARIO), $nombre);

        }

        return $docsUser ? 'El documento ha sido guardado con éxito!' : 'El documento no se pudo guardar';

    }
    public function eliminarDoc(Request $request){
        $rspt = Cls_Usuario::eliminarDoc($request);
        return $rspt ? 'Documento eliminado con éxito!' : 'EL documento no se pudo eliminar';
    }
    public function getDocsHistory(){
        $ObjAuth = Auth::user();
        $rspt = Cls_Usuario::getHistoryDocs($ObjAuth->USUA_NIDUSUARIO);
        $data = array();
        foreach ($rspt as $key => $i) {
             $nombre= explode("/", $i->USDO_CRUTADOC);
             $ultimo = count($nombre) - 1;
             $numero = $key + 1;
             $P_NESTATUS =  $i->USDO_NESTATUS;
             if($P_NESTATUS==0){$TXT_STAT='Pendiente revisión';};
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
            "sEcho"=>1, //Información para el datatables
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
            $data[] = array(
                '0' => $numero,
                '1' => '<a href="' . asset('').$i->ruta . '" target="_blank">'. $nombre[$ultimo] . '</a>',
                '2' => $i->create_at,
            );
        }
        $results = array(
            "sEcho" => 1, //Información para el datatables
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
