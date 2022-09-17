<?php

namespace App\Services;

use App\Models\Cls_Tramite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TramiteService
{
    /**
     * Retorna la busqueda de los tramites en base a lo solicitado
     * @param Request $data
     * @return array
     */
    public function busqueda(Request $data){
        $registros  = 10;
        $usuario    = Auth::user();
        $rol        = $usuario->TRAM_CAT_ROL;

        $query = DB::connection('mysql2')->table('procedures as p')
                    ->join('administrativeunits as a', 'p.IdAdministrativeUnit', '=', 'a.Id')
                    ->join('dependencies as d', 'a.IdDependency', '=', 'd.Id')
                    ->select('p.id','p.iId as remtisId','p.CitizenDescription', 'p.name', 'd.name as nameDependencia', 'd.Description as descripcionDependencia', 'p.CreatedDate')
                    ->where(['p.ProcedureState'=> 5, 'p.IsDeleted' => 0]);

        if($rol->ROL_CCLAVE != 'ADM'){
            $depPertenece   = DB::table('tram_aux_dependencia_usuario_pertenece')->where('DEPUP_NIDUSUARIO', $usuario->USUA_NIDUSUARIO)->get();
            $uniPertenece   = DB::table('tram_aux_unidad_usuario_pertenece')->where('UNIDUP_NIDUSUARIO', $usuario->USUA_NIDUSUARIO)->get();
            $tramPertenece  = DB::table('tram_aux_tramite_usuario_pertenece')->where('TRAMUP_NIDUSUARIO', $usuario->USUA_NIDUSUARIO)->get();
            
            $query->whereIn('d.iId', $depPertenece->pluck('DEPUP_NIDDEPENCIA'))
                    ->whereIn('a.iId', $uniPertenece->pluck('UNIDUP_NIDUNIDAD'))
                    ->whereIn('p.iId', $tramPertenece->pluck('TRAMUP_NIDTRAMITE'));
        }

        if(!is_null($data->palabraClave))
            $query->where('p.name', 'like','%'.$data->palabraClave.'%');
        if(!is_null($data->dependencia) && $data->dependencia != "")
            $query->where('d.id', $data->dependencia);
        if(!is_null($data->registros))
            $registros = $data->registros;

        $tramites = $query->paginate($registros);
        foreach ($tramites as $tramite) {
            $tramite->TRAM_NIDTRAMITE           = $tramite->remtisId;
            $tramite->TRAM_NIDTRAMITE_CONFIG    = 0;
            $tramite->TRAM_CNOMBRE              = $tramite->name;
            $tramite->TRAM_CDESCRIPCION         = $tramite->CitizenDescription;
            $tramite->UNAD_CNID                 = $tramite->descripcionDependencia;
            $tramite->UNAD_CNOMBRE              = $tramite->nameDependencia;
            $tramite->TRAM_DFECHACREACION       = $tramite->CreatedDate;
            $tramite->TRAM_DFECHAACTUALIZACION  = $tramite->CreatedDate;

            $tramite->TRAM_NIMPLEMENTADO = 1;

            $segundo = DB::table('tram_mst_tramite')->where(['TRAM_NIDTRAMITE_ACCEDE' => $tramite->remtisId, 'TRAM_NIMPLEMENTADO' => 1])->first();
            if(!is_null($segundo))
                $tramite->TRAM_NIDTRAMITE_CONFIG = $segundo->TRAM_NIDTRAMITE;
        }

        return [ 'data' => $tramites];
    }

    /**
     * Retorna la busqueda de los tramites en base a lo solicitado
     * @param Request $data
     * @return array
     */
    public function filtros(Request $data){
        $dependencias = DB::connection('mysql2')->table('dependencies')
                            ->select('Id as id', 'Name as name', 'Description as description', 'Acronym as acronym')
                            ->where('IsDeleted', false)->get();
        return [ 'dependencias' => $dependencias];
    }

    /**
     * Retorna el tramite en base al id indicado
     * @param int $tramiteID
     * @return Object
     */
    public function getTramite(int $tramiteID){
        $query = DB::connection('mysql2')->table('procedures as p')
                    ->join('administrativeunits as a', 'p.IdAdministrativeUnit', '=', 'a.Id')
                    ->join('dependencies as d', 'a.IdDependency', '=', 'd.Id')
                    ->join('instruments as i', 'p.IdInstrument', '=', 'i.Id')
                    ->join('procedurecommunities as prc', 'p.Id', '=', 'prc.ProcedureId')
                    ->join('communities as c', 'prc.CommunityId', '=', 'c.Id')
                    ->join('procedurecategories as prcat', 'p.Id', '=', 'prcat.ProcedureId')
                    ->join('categories as cat', 'prcat.CategoryId', '=', 'cat.Id')
                    ->join('requesttypes as retyp', 'p.IdRequestType', '=', 'retyp.Id')
                    ->join('targettypes as tartyp', 'p.IdTargetType', '=', 'tartyp.Id')
                    ->leftJoin('daysrange as v','p.idVigencyRange', '=', 'v.id')
                    ->select('p.*', 'p.iId as remtisId','d.name as nameDependencia', 'p.CitizenDescription' ,'d.iId as dependenciaId' 
                    ,'i.Name as nameInstrumento', 'v.Name as tipoVigencia', 'c.Name as community', 'cat.Name as categories'
                    , 'retyp.Name as requesttypes', 'tartyp.Name as targettypes')
                    ->where('p.iId', $tramiteID)->first();
        return $query;
    }

    /**
     * Retorna los documentos asociados al tramite
     * @param String $tramiteID
     * @return array
     */
    public function getDetalle(string $tramiteID){
        $documentos = DB::connection('mysql2')->table('procedurerequisit as pr')
                            ->join('requisits as r', 'pr.RequisitId', '=', 'r.Id')
                            ->join('naturetypes as n', 'pr.Nature', '=', 'n.Id')
                            ->join('naturepresentationtypes as np', 'pr.NatureHow', '=', 'np.Id')
                            ->select('r.*', 'r.iId as Id' ,'n.Name as tipoDocumento', 'np.Name as presentacion')
                            ->where(['pr.IdProcedure' => $tramiteID, 'r.IsDeleted' => false])
                            ->groupBy('r.Id','n.Name', 'np.Name')->get();

        $oficinas   = DB::connection('mysql2')->table('procedureoffices as po')
                            ->join('administrativeunitbuildings as a', 'po.IdAdministrativeUnitBuilding', '=', 'a.Id' )
                            ->join('sepomex as s','a.SepomexId', "=" ,'s.Id')
                            ->select('a.*', 's.PostalCode', 's.Colony', 's.Municipality', 's.State')
                            ->where(['po.IdProcedure' => $tramiteID, 'a.isDeleted' => false])->get();

        $horarios   =   DB::connection('mysql2')->table('procedureoffices as po')
                            ->join('administrativeunitbuildings as a', 'po.IdAdministrativeUnitBuilding', '=', 'a.Id' )
                            ->leftjoin('administrativeunitbuildingdays as ad', 'ad.IdAdministrativeUnitBuildingId', "=" ,'a.Id')
                            ->join('days as d', 'ad.DayId', 'd.Id')
                            ->select('a.*', 'd.Name as diaNombre','d.Id as diaId')
                            ->where(['po.IdProcedure' => $tramiteID, 'a.isDeleted' => false])->get();

        $funcionarios   = DB::connection('mysql2')->table('procedurecontacts as pc')
                                ->where(['IdProcedure' => $tramiteID, 'IsDeleted' => false])->get();

        $lugaresPago    = DB::connection('mysql2')->table('procedurechanges as pc')
                                ->where(['IdProcedure' => $tramiteID, 'IsDeleted' => false])
                                ->where(function ($query) {
                                    $query->where("pc.property", "like","%Banc%")
                                            ->orWhere("pc.property", "like","En línea%")
                                            ->orWhere("pc.property", "like","%Tienda%");
                                })->get();

        return ["documentos" => $documentos, "oficinas" => $oficinas, "horario" => $horarios, "funcionarios" => $funcionarios, "lugaresPago" => $lugaresPago];
    }

    /**
     * Retorna un conujto de array para el llenado de los tramites
     * @param array $arrayDetalle
     * @param object $objTramite
     * @return array
     */
    public function valoresDefaulTramite(array $arrayDetalle, object $objTramite){
        $tramite['oficinas'] = array();

        ################ Documentos ################
        $arrayDocumentos = [];
        foreach($arrayDetalle['documentos'] as $documento) {
            $array = array(
                "nombre"        => $documento->Name,
                "presentacion"  => $documento->presentacion,
                "observaciones" => $documento->Description,
                "tipo"          => $documento->tipoDocumento,
                "informacionComplementaria" => "." //"informacionComplementaria",
            );
            array_push($arrayDocumentos, $array);
        }

        ################ Funcionarios ################
        $funcionarios = "";
        foreach($arrayDetalle['funcionarios']as $funcionario){
            $funcionarios .= $funcionario->Name."<br/> correo: " . $funcionario->Email. "<br/><hr>";
        }

        foreach($arrayDetalle['oficinas'] as $oficina){
            ################ Horarios ################
            $horarios = "";
            foreach($arrayDetalle['horario'] as $horario){
                if($horario->Id == $oficina->Id)
                    $horarios.= $horario->diaNombre.": ".date("h:i a", strtotime($horario->OpeningHour))." - ".date("h:i a", strtotime($horario->ClosingHour))." <br/>";
            }

            $array = array(
                "id"            => $oficina->Id,
                "nombre"        => $oficina->Name,
                "direccion"     => "Calle ".$oficina->Street." No Exterior ".$oficina->ExternalNumber." No Interior ". strtoupper($oficina->InternalNumber)." colonia ".$oficina->Colony.", ".$oficina->Municipality.", ".$oficina->State,
                "horario"       => "</br> Horario: </br>".$horarios,
                "latitud"       => $oficina->Latitude,
                "longitud"      => $oficina->Longitude,
                "responsable"   => $funcionarios,
                "contacto_email"        => $oficina->Email,
                "informacion_adicional" => "",
                "contacto_telefono"     => "Télfono: ".$oficina->NumberPhone." Ext ".$oficina->Ext,
            );
            array_push($tramite['oficinas'], $array);
        }

        ################ Lugares donde pagar ################
        $lugares = "";
        foreach($arrayDetalle['lugaresPago']as $lugar){
            $lugares .= $lugar->Property. ", ";
        }
        $lugares    = substr($lugares, 0, -2).".";
        $monto      = !is_null($objTramite->StaticAmount) ? $objTramite->StaticAmount : 0;

        $tramite['costo'] = [
            [
                "titulo"        => "¿Tiene costo?",
                "descripcion"   => $monto > 0 ? "SI" : "NO",
                "opciones"      => [],
                "documentos"    => []
            ],
            [
                "titulo"        => "Costos",
                "descripcion"   => "$".number_format(round($monto, 2, PHP_ROUND_HALF_UP), 2, ".", ""),
                "opciones"      => [],
                "documentos"    => []
            ]
        ];

        $tramite['requerimientos'] = [
            [
                "titulo"        => "Casos en que se debe realizar el trámite:",
                "descripcion"   =>  "Manuel Euan",//$objTramite['casoRealizacion'] ?? "",
                "opciones"      => [],
                "documentos"    => []
            ],
            [
                "titulo" => "Requisitos:",
                "descripcion" => "",
                "opciones" => [],
                "documentos" => $arrayDocumentos
            ],
            [
                "titulo" => "¿Puede hacer el trámite alguien más?:",
                "descripcion" => "",
                "opciones" => [],
                "documentos" => []
            ],
            [
                "titulo" => "Casos de rechazo:",
                "descripcion" => "",
                "opciones" => [],
                "documentos" => []
            ]
        ];

        $vigencia   = $objTramite->VigencyNumber == 0 || is_null($objTramite->VigencyNumber) ? "" : $objTramite->VigencyNumber;
        $rango      = $objTramite->VigencyNumber == 1 ? substr($objTramite->tipoVigencia, 0, -1)  : $objTramite->tipoVigencia;
        
        $tramite['informacion_general'] = [
            [
                "titulo"        => "Homoclave:",
                "descripcion"   => $objTramite->Key,
                "opciones"      => [],
            ],
            [
                "titulo"        => "Palabras clave:",
                "descripcion"   => $objTramite->KeyWords,
                "opciones"      => [],
            ],
            [
                "titulo"        => "Tipo de trámite o servicio:",
                "descripcion"   => $objTramite->requesttypes,
                "opciones"      => [],
            ],
            [
                "titulo"        => "Usuario a quien está dirigido el trámite:",
                "descripcion"   => $objTramite->community, //"dirigidoA", //$objTramite['dirigidoA'] ?? "",
                "opciones"      => [],
            ],
            [
                "titulo"        => "Quien puede realizar el trámite:",
                "descripcion"   => $objTramite->targettypes, //"dirigidoA", //$objTramite['dirigidoA'] ?? "",
                "opciones"      => [],
            ],
            [
                "titulo"        => "Categoria:",
                "descripcion"   => $objTramite->categories,
                "opciones"      => [],
            ],
            [
                "titulo"        => "Beneficio del usuario:",
                "descripcion"   => $objTramite->Benefit,
                "opciones"      => [],
            ]
        ];

        $tramite['en_linea'] = [
            [
                "titulo"        => "Tiempo promedio de espera en fila",
                "descripcion"   =>  "",
                "opciones"      => [],
                "documentos"    => []
            ],
            [
                "titulo"        => "¿Hay información en línea?:",
                "descripcion"   => "",
                "opciones"      => [],
                "documentos"    => []
            ],
            [
                "titulo"        => "¿Se pueden recibir solicitudes en línea?:",
                "descripcion"   => "",
                "opciones"      => [],
                "documentos"    => []
            ],
            [
                "titulo"        => "Solicitud en línea ¿Requiere formato?:",
                "descripcion"   => "",
                "opciones"      => [],
                "documentos"    => []
            ]
        ];

        $tramite['fundamento_legal'] = [
            [
                "titulo" => "Nombre del Fundamento Jurídico", 
                "opciones" => [], 
                "adicional" => [], 
                "descripcion" => $objTramite->LegalBasisOriginName
            ],
            [
                "titulo" => "Artículo", 
                "opciones" => [], 
                "adicional" => [], 
                "descripcion" => $objTramite->LegalBasisOriginArticle
            ],
           
        ];
       

        

        return $tramite;
    }

    /**
     * Retorna el estado y municipio del tramite
     * @param int $dependenciaID
     * @return object
     */
    public function getEstadoandMunicipio(int $dependenciaID){
        $datos = DB::connection('mysql2')->table('dependencies as d')
                        ->join('states as s', 'd.IdState', '=', 's.Id')
                        ->join('municipalities as m', 'd.IdMunicipal', '=', 'm.Id')
                        ->select('s.Id as estadoId', 's.Name as estado', 'm.Id as municipioId', 'm.Name as municipio')
                        ->where('d.iId',$dependenciaID)->first();
        return $datos;
    }

    /**
     * Retorna los modoeulos en base al municipio seleccionado
     * @param int $dependenciaID
     * @return object
     */
    public function getModulo(int $dependenciaID){
        $datos = DB::connection('mysql2')->table('dependencies as d')
                        ->join('states as s', 'd.IdState', '=', 's.Id')
                        ->join('municipalities as m', 'd.IdMunicipal', '=', 'm.Id')
                        ->select('s.Id as estadoId', 's.Name as estado', 'm.Id as municipioId', 'm.Name as municipio')
                        ->where('d.iId',$dependenciaID)->first();
        return $datos;
    }

    /**
     * Retorna los tramites de siegy
     * @param int $tramiteAccedeId
     * @return Collection 
     */
    public function getTramitesSiegy($tramiteAccedeId = null){
        $query = Cls_Tramite::where('TRAM_NIMPLEMENTADO', true);

        if(!is_null($tramiteAccedeId))
            $query->where('TRAM_NIDTRAMITE_ACCEDE', $tramiteAccedeId);

        return !is_null($tramiteAccedeId) ? $query->first() : $query->get();
    }

    /**
     * retorna el registro de retys en base a la tabla que se indique
     * @param String $tabla
     * @param String $uuid
     * @return Object
     */
    public function getRetys($tabla, $uuid){
        return DB::connection('mysql2')->table($tabla)->where('Id', $uuid)->first();
    }
}
