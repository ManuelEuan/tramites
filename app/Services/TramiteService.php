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
                    ->select('p.id','p.CitizenDescription', 'p.name', 'd.name as nameDependencia', 'd.Description as descripcionDependencia', 'p.CreatedDate')
                    ->where('p.HasProcedureOnline', true);

        if(!is_null($data->palabraClave))
            $query->where('p.name', 'like','%'.$data->palabraClave.'%');
        if(!is_null($data->dependencia) && $data->dependencia != "")
            $query->where('d.id', $data->dependencia);
        if(!is_null($data->IntCantidadRegistros))
            $IntCantidadRegistros = $data->IntCantidadRegistros;
    
        $tramites = $query->paginate($IntCantidadRegistros);
        foreach ($tramites as $tramite) {
            $tramite->TRAM_NIDTRAMITE           = $tramite->id;
            $tramite->TRAM_NIDTRAMITE_CONFIG    = 0;
            $tramite->TRAM_CNOMBRE              = $tramite->name;
            $tramite->TRAM_CDESCRIPCION         = $tramite->CitizenDescription;
            $tramite->UNAD_CNID                 = $tramite->descripcionDependencia;
            $tramite->UNAD_CNOMBRE              = $tramite->nameDependencia;
            $tramite->TRAM_DFECHACREACION       = $tramite->CreatedDate;
            


            /* $objTram = DB::connection('mysql')->table('tram_mst_tramite as g')
                    ->where('g.TRAM_NIDTRAMITE_ACCEDE', 2222)
                    ->select('g.*')
                    ->get();
     
            if(sizeof($objTram) > 0){
                dd($objTram);
                $lol= $objTram[count($objTram) - 1]->TRAM_NIMPLEMENTADO;
                $lol22 = $objTram[count($objTram) - 1]->TRAM_NIDTRAMITE;
                
                
            }      */

            $tramite->TRAM_NIMPLEMENTADO = rand(0, 1);;
            $tramite->TRAM_DFECHAACTUALIZACION  = $tramite->CreatedDate;
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
     * Retorna el tramite en base a un UUID
     * @param String $tramiteID
     * @return object
     */
    public function getTramite(string $tramiteID){
        $query = DB::connection('mysql2')->table('procedures as p')
                    ->join('administrativeunits as a', 'p.IdAdministrativeUnit', '=', 'a.Id')
                    ->join('dependencies as d', 'a.IdDependency', '=', 'd.Id')
                    ->join('instruments as i', 'p.IdInstrument', '=', 'i.Id')
                    ->select('p.*','d.name as nameDependencia', 'i.Name as nameInstrumento')
                    ->where('p.Id', $tramiteID)->first();
     
        /* ->select('p.Id','p.CitizenDescription', 'p.name', 'p.description', 'p.Acronym' ,'d.name as nameDependencia', 'd.Description as descripcionDependencia', 'p.CreatedDate') */
        return $query;        
    }

    /**
     * Retorna los documentos asociados al tramite
     * @param String $tramiteID
     * @return array
     */
    public function getDetalle(string $tramiteID){
        $documentos = DB::connection('mysql2')->table('procedurerequisit as pr')
                            ->join('requisits as r', 'pr.RequisitId', '=', 'r.Id' )
                            ->select('r.*')
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

        $arrayHorario = "";
        foreach($horarios as $horario){
            $arrayHorario.= $horario->diaNombre.": ".date("h:i a", strtotime($horario->OpeningHour))." - ".date("h:i a", strtotime($horario->ClosingHour))." <br/>";
        }
        
        return ["documentos" => $documentos, "oficinas" => $oficinas, "horario" => $arrayHorario ];
    }

    /**
     * Retorna los horarios de cada oficina asociados al tramite
     * @param String $tramiteID
     * @return array
     */
    public function getHorario(){

    }
}