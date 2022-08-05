<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ServidoresService
{
    /**
     *
     */
    public function getDependencias(){
        $query = DB::connection('mysql2')->table('dependencies')
                    ->select()
                    ->get();
        return $query;     
    }

    public function getUnidadesAdministrativas($request){
        $registros = [];
        if(isset($request->tipo) && $request->tipo == 'multiple'){
            $registros = DB::connection('mysql2')->table('administrativeunits')
            ->select()
            ->get();
        }else{
            $registros = DB::connection('mysql2')->table('administrativeunits')
            ->select()
            ->where('IdDependency', $request->dependencia_id)
            ->get();
        }
        if(isset($request->tipo) && $request->tipo == 'multiple'){
            $final          = [];
            $dependencias   = explode(",", $request->dependencia_id);

            foreach  ($dependencias as $dependencia) {
                foreach ($registros as $registro) {
                    if($dependencia == $registro->IdDependency)
                        array_push($final, $registro);
                }
            }
            return $final;
        }
        
        return $registros;     
    }

    public function getTramites($request){
        $final      = [];
        $unidades   = explode(",", $request->unidad_id);

        $registros = DB::connection('mysql2')->table('procedures')
            ->select()
            ->where('ProcedureState', 4)
            ->get();

        foreach  ($unidades as $unidad) {
            foreach ($registros as $registro) {
                if ($unidad == $registro->IdAdministrativeUnit)
                    array_push($final, $registro);
            }
        }

        if(isset($request->tipo) && $request->tipo == 'all')
            return response()->json($registros, 200);

        return $final;
    }

}