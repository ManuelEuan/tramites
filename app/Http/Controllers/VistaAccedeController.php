<?php

namespace App\Http\Controllers;
use App\Cls_Vista_Accede;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use PDO;
class VistaAccedeController extends Controller
{
    public function vw_accede_tramite(){
	    $response = Cls_Vista_Accede::VW_ACCEDE_TRAMITE();
        return Response()->json($response);
    }

    public function vw_accede_tramite_id($id){
	    $response = Cls_Vista_Accede::VW_ACCEDE_TRAMITE_ID($id);
        return Response()->json($response);
    }

    public function vw_accede_tramite_id_unidad($id){
	    $response = Cls_Vista_Accede::VW_ACCEDE_TRAMITE_ID_UNIDAD($id);
        return Response()->json($response);
    }

    public function vw_accede_tramite_edificio(){
	    $response = Cls_Vista_Accede::VW_ACCEDE_TRAMITEDIFICIO();
        return Response()->json($response);
    }

    public function vw_accede_edificios(){
	    $response = Cls_Vista_Accede::VW_ACCEDE_EDIFICIOS();
        return Response()->json($response);
    }

    public function vw_accede_edificios_id($id){
	    $response = Cls_Vista_Accede::VW_ACCEDE_EDIFICIOS_ID($id);
        return Response()->json($response);
    }

    public function vw_accede_tramite_documento(){
	    $response = Cls_Vista_Accede::VW_ACCEDE_TRAMITEDOCUMENTO();
        return Response()->json($response);
    }

    public function vw_accede_tramite_documento_tram_id($id){
	    $response = Cls_Vista_Accede::VW_ACCEDE_TRAMITEDOCUMENTO_TRAM_ID($id);
        return Response()->json($response);
    }

    public function vw_accede_documentos(){
	    $response = Cls_Vista_Accede::VW_ACCEDE_DOCUMENTOS();
        return Response()->json($response);
    }

    public function vw_accede_tramite_legal($id){
	    $response = Cls_Vista_Accede::VW_ACCEDE_TRAMLEGA($id);
        return Response()->json($response);
    }

    public function vw_accede_centro_trabajo(){
	    $response = Cls_Vista_Accede::VW_ACCEDE_CENTROTRABAJO();
        return Response()->json($response);
    }

    public function vw_accede_unidad_administrativa(){
	    $response = Cls_Vista_Accede::VW_ACCEDE_UNIDADADMINISTRATIVA();
        return Response()->json($response);
    }

    public function vw_accede_unidad_administrativa_centro_id($id){
	    $response = Cls_Vista_Accede::VW_ACCEDE_UNIDADADMINISTRATIVA_CENTRO_ID($id);
        return Response()->json($response);
    }

    public function vw_accede_paises(){
	    $response = Cls_Vista_Accede::VW_ACCEDE_PAISES();
        return Response()->json($response);
    }

    public function vw_accede_estados(){
	    $response = Cls_Vista_Accede::VW_ACCEDE_ESTADOS();
        return Response()->json($response);
    }

    public function vw_accede_municipios(){
	    $response = Cls_Vista_Accede::VW_ACCEDE_MUNICIPIOS();
        return Response()->json($response);
    }

    public function vw_accede_localidades(){
	    $response = Cls_Vista_Accede::VW_ACCEDE_LOCALIDADES();
        return Response()->json($response);
    }

    public function vw_accede_localidades_municipio($municipio){
	    $response = Cls_Vista_Accede::VW_ACCEDE_LOCALIDADES_MUNICIPIO($municipio);
        return Response()->json($response);
    }

    //Citas
    public function vw_sici_citas_disponibles(){
	    $response = Cls_Vista_Accede::SICI_VW_CITAS_DISPONIBLES();
        return Response()->json($response);
    }

    public function vw_sici_citas_disponibles_filtro($idtramite, $idedificio){
	    $response = Cls_Vista_Accede::SICI_VW_CITAS_DISPONIBLES_Filtrado($idtramite, $idedificio);
        return Response()->json($response);
    }

    public function vw_sici_citas_disponibles_filtro_tram($idtramite){
	    $response = Cls_Vista_Accede::SICI_VW_CITAS_DISPONIBLES_Filtrado_tram($idtramite);
        return Response()->json($response);
    }


	 public function sp_citalinea(Request $request){
        $response = Cls_Vista_Accede::TYS_SP_CITALINEA(
        $request->input('idtramite'),
        $request->input('tramitelinea'),
        $request->input('tramiteliga'),
        $request->input('tramitecita'),
		$request->input('tramiteedificio'));

        return Response()->json($response);
    }

    public function vw_sici_estatus_citas(){
	    $response = Cls_Vista_Accede::SICI_VW_ESTATUSCITAS();
        return Response()->json($response);
    }

    public function vw_sici_estatus_citas_filtro($edificio, $tramite, $agenda){
	    $response = Cls_Vista_Accede::SICI_VW_ESTATUSCITAS_Filtrado($edificio, $tramite, $agenda);
        return Response()->json($response);
    }

    public function vw_sici_tramite_edificio_con_citas(){
	    $response = Cls_Vista_Accede::SICI_VW_TRAM_EDIF_CON_CITAS();
        return Response()->json($response);
    }

    public function vw_sici_citas_reservadas(){
	    $response = Cls_Vista_Accede::SICI_VW_CITAS_RESERVADAS();
        return Response()->json($response);
    }

    public function vw_sici_citas_reservadas_filtro($idcita){
	    $response = Cls_Vista_Accede::SICI_VW_CITAS_RESERVADAS_Filtrado($idcita);
        return Response()->json($response);
    }

    public function sp_sici_guardar_cita(Request $request){
        $response = Cls_Vista_Accede::SICI_SP_GUARDARCITA(
        $request->input('nombre'),
        $request->input('primerapellido'),
        $request->input('segundoapellido'),
        $request->input('correo'),
        $request->input('celular'),
        $request->input('tramite'),
        $request->input('edificio'),
        $request->input('hora'),
        $request->input('fecha'));

        return Response()->json($response);
    }

    public function sp_sici_spu_agenda(Request $request){
        $response = Cls_Vista_Accede::SICI_SPU_AGENDA(
        $request->input('idasisten'),
        $request->input('idcancelan'),
        $request->input('idmotivocancelan'),
        $request->input('motivocancelan'),
        $request->input('usuario'),
        $request->input('hd'));

        return Response()->json($response);
    }

    public function vw_accede_tramite_filtro(Request $request)
    {
        $palabraClave = $request->palabraClave;
        $dependencia = $request->dependencia;
        $unidad = $request->unidad;
        $modalidad = $request->modalidad;
        $clasificacion = $request->clasificacion;
        $audiencia = $request->audiencia;
        $desde = $request->desde;
        $hasta = $request->hasta;
        $usuarioID = $request->usuarioID ?? 0;
        $estatus = $request->estatus;

        $response = Cls_Vista_Accede::VW_ACCEDE_TRAMITE_FILTRO($palabraClave, $dependencia, $modalidad, $clasificacion, $audiencia, $desde, $hasta, $usuarioID, $unidad, $estatus);
        return Response()->json($response);
    }

}
