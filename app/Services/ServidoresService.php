<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ServidoresService
{
    /**
     *  Retorna las dependencias de retys
     * @return array
     */
    public function getDependencias(){
        return DB::connection('mysql2')->table('dependencies')->select()->get();    
    }

    /**
     * Retornas las unidades administrativas de retys
     * @param Request $request
     * @return array
     */
    public function getUnidadesAdministrativas($request){
        $query = DB::connection('mysql2')->table('administrativeunits');

        if(!is_null($request->dependencia_id)){
            $array = explode(',',$request->dependencia_id );
            $query->whereIn( 'IdDependency',$array);
        }

        return $query->where('IsDeleted', false)->get();     
    }

    /**
     * Retornas los tramitres de retys
     * @param Request $request
     * @return array
     */
    public function getTramites($request){
        $unidades   = explode(",", $request->unidad_id);
        $query      = DB::connection('mysql2')->table('procedures as p')
                        ->select()->where(['p.ProcedureState'=> 5, 'p.IsDeleted' => 0]);

        if($request->tipo != "all")
            $query->whereIn( 'IdAdministrativeUnit', $unidades);

        return $query->get();;
    }

    /**
     * Retornas los edificios de retys
     * @param Request $request
     * @return array
     */
    public function getEdificios($request){
        $unidades   = explode(",", $request->unidad_id);
        $query      = DB::connection('mysql2')->table('administrativeunitbuildings as e')->select('e.*', 'u.AdministrativeUnitId')
                            ->join('administrativeunitbuildingsunits as u', 'e.Id', '=', 'u.AdministrativeUnitBuildingId');

        if($request->tipo != "all")
            $query->whereIn('u.AdministrativeUnitId', $unidades) ;
       
        return $query->where('e.IsDeleted', false)->get(); 
    }
}