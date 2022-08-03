<?php

namespace App\Services;


use stdClass;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TramiteService
{
    /**
     * Retorna la busqueda de los tramites en base a lo solicitado
     * @param Request $data
     * @return array
     */
    public function busqueda(Request $data){
        $IntCantidadRegistros = 10;

        $query = DB::connection('mysql2')->table('procedures as p')
                    ->join('administrativeunits as a', 'p.IdAdministrativeUnit', '=', 'a.Id')
                    ->join('dependencies as d', 'a.IdDependency', '=', 'd.Id')
                    ->select('p.id','p.iId as remtisId','p.CitizenDescription', 'p.name', 'd.name as nameDependencia', 'd.Description as descripcionDependencia', 'p.CreatedDate')
                    ->where('p.HasProcedureOnline', true);

        if(!is_null($data->palabraClave))
            $query->where('p.name', 'like','%'.$data->palabraClave.'%');
        if(!is_null($data->dependencia) && $data->dependencia != "")
            $query->where('d.id', $data->dependencia);
        if(!is_null($data->IntCantidadRegistros))
            $IntCantidadRegistros = $data->IntCantidadRegistros;
    
        $tramites = $query->paginate($IntCantidadRegistros);
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

            $segundo = DB::table('tram_mst_tramite')->where('TRAM_NIDTRAMITE_ACCEDE',  $tramite->remtisId)->first();
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
                    ->join('daysrange as v','p.idVigencyRange', '=', 'v.id')
                    ->select('p.*', 'p.iId as remtisId','d.name as nameDependencia', 'p.CitizenDescription' ,'d.iId as dependenciaId' ,'i.Name as nameInstrumento', 'v.Name as tipoVigencia')
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
                            ->select('r.*', 'n.Name as tipoDocumento', 'np.Name as presentacion')
                            ->where(['pr.IdProcedure' => $tramiteID, 'r.IsDeleted' => false])->get();

        $oficinas   = DB::connection('mysql2')->table('procedureoffices as po')
                            ->join('administrativeunitbuildings as a', 'po.IdAdministrativeUnitBuilding', '=', 'a.Id' )
                            ->join('sepomex as s','a.SepomexId', "=" ,'s.Id')
                            ->select('a.*', 's.PostalCode', 's.Colony', 's.Municipality', 's.State')
                            ->where(['po.IdProcedure' => $tramiteID, 'a.isDeleted' => false])->get();
                            
        $horarios   =   DB::connection('mysql2')->table('procedureoffices as po')
                            ->join('administrativeunitbuildings as a', 'po.IdAdministrativeUnitBuilding', '=', 'a.Id' )
                            ->leftjoin('administrativeunitbuildingdays as ad', 'ad.IdAdministrativeUnitBuildingId', "=" ,'a.Id')
                            ->join('days as d', 'ad.DayId', 'd.Id')
                            ->select('a.*', 'd.Name as diaNombre')
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

        return ["documentos" => $documentos, "oficinas" => $oficinas, "horario" => $horarios, "funcionarios" => $funcionarios, "lugaresPago" => $lugaresPago ];
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

        ################ Horarios ################
        $horarios = "";
        foreach($arrayDetalle['horario'] as $horario){
            $horarios.= $horario->diaNombre.": ".date("h:i a", strtotime($horario->OpeningHour))." - ".date("h:i a", strtotime($horario->ClosingHour))." <br/>";
        }

        ################ Funcionarios ################
        $funcionarios = "";
        foreach($arrayDetalle['funcionarios']as $funcionario){
            $funcionarios .= $funcionario->Name."<br/> correo: " . $funcionario->Email. "<br/><hr>";
        }

        foreach($arrayDetalle['oficinas'] as $oficina){
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
            ],
            [
                "titulo"        => "Oficinas donde se puede realizar el pago:",
                "descripcion"   =>  $lugares,
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
                "titulo"        => "Usuario a quien está dirigido el trámite:",
                "descripcion"   => "dirigidoA", //$objTramite['dirigidoA'] ?? "",
                "opciones"      => [],
            ],
            [
                "titulo"        => "Tipo de persona:",
                "descripcion"   => "tipoPersonas", //$tipoPersonas,
                "opciones"      => [],
            ],
            [
                "titulo"        => "Tiempo hábil promedio de resolución:",
                "descripcion"   =>  $vigencia." ".$rango,
                "opciones"      => [],
            ],
            [
                "titulo"        => "Audiencia",
                "descripcion"   => "",
                "opciones"      => [],
            ],
            [
                "titulo"        => "Beneficio del usuario:",
                "descripcion"   => $objTramite->Benefit,
                "opciones"      => [],
            ],
            [
                "titulo"        => "Derechos del usuario:",
                "descripcion"   => "",
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

        return $tramite;
    }
}