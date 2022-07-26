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
}