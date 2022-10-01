<?php

namespace App\Models;

use DateTime;
use Carbon\Carbon;
use App\Services\TramiteService;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cls_Citas_Calendario extends Model {
    use SoftDeletes;
    protected $table        = 'citas_tramites_calendario';
    protected $primaryKey   = 'idcitas_tramites_calendario';
    public $timestamps      = false;

    protected $fillable = [
        'idcitas_tramites_calendario',
        'CITA_IDUSUARIO', //Quiuen lo solicita
        'CITA_FECHA', //Fecha de la cita
        'CITA_HORA', //Hora de la cita
        'CITA_IDTRAMITE', //Trámite seleccionado
        'CITA_IDMODULO', //Módulo seleccionado
        'CITA_CONFIRMADO', //Confirmación de cita
        'CITA_FOLIO' //Folio de la cita
    ];

    public static function getAll(){
        return Cls_Citas_Calendario::all();
    }

    /**
     * 
     */
    public static function getByFiltro($tramite,$idedificio,$anio,$mes,$tipo){
        $toDay          = Carbon::now()->format('Y-m-d');

        $arrayInhabil   = array();
        $fecha_inicio   = date($anio."-".(strlen($mes) == 1 ? "0".$mes : $mes)."-01");
        $fecha_final    = date($anio."-".(strlen($mes) == 1 ? "0".$mes : $mes)."-t");

        //Dias Inhabiles
        $inicio_inhabil = new DateTime($fecha_inicio);
        $inicio_inhabil->modify("-2 month");
        $final_inhabil = new DateTime($fecha_final);
        $final_inhabil->modify("2 month");

        $inhabiles = DB::table('tram_dia_inhabil')->where('fecha_inicio', '>=', $inicio_inhabil->format('Y-m-d'))
                        ->where('fecha_inicio', '<=', $final_inhabil->format('Y-m-d'))->where('activo', true )->get();

        foreach($inhabiles as $dia){
            $dependencias = explode(",", $dia->dependencias);
            
            foreach($dependencias as $dependencia){
                if($tramite->TRAM_NIDCENTRO == (int)$dependencia){
                    array_push($arrayInhabil, ["fecha_inicio" => $dia->fecha_inicio, "fecha_final" => $dia->fecha_final]);
                }
            }
        }

        //Comienzo a crear los dias con sus respectivos horarios
        $fechasDisponibles = array();
        for($i=strtotime(date($fecha_inicio)); $i<=strtotime(date($fecha_final)); $i+=86400){
            $rowHorario = array();
            $diaSemana  = "";
            $fecha      = date("Y-m-d", $i);
            $aplica     =  $tipo == 'usuario' && $fecha_inicio < $toDay ? false : true;

            if($aplica ){
                $rowOcupacion = DB::table('citas_tramites_calendario')->where([
                                    'CITA_FECHA'        => $fecha,
                                    'CITA_IDTRAMITE'    => $tramite->TRAM_NIDTRAMITE,
                                    'CITA_IDMODULO'     => $idedificio,
                                    'deleted_at'        => null
                                ])->get();
    
                switch (date("N", $i)) {
                    case '1': $diaSemana = "Lunes";   break;
                    case '2': $diaSemana = "Martes";  break;
                    case '3': $diaSemana = "Miercoles"; break;
                    case '4': $diaSemana = "Jueves";  break;
                    case '5': $diaSemana = "Viernes"; break;
                    case '6': $diaSemana = "Sabado";  break;
                    case '7': $diaSemana = "Domingo"; break;
                }
    
                $horario = Cls_DiasCitaTramite::where([
                                'tramiteId' => $tramite->TRAM_NIDTRAMITE,
                                'moduloId'  => $idedificio,
                                'dia'       => $diaSemana
                            ])->first();
    
                foreach($arrayInhabil as $value){
                    if($fecha >= $value['fecha_inicio'] && $fecha <= $value['fecha_final'] ){
                        $horario = null;
                    }
                }
    
                $rowDisponibles = array();
                if (!is_null($horario)) {
                    for( $j=strtotime($fecha.' '.$horario->horarioInicial); $j<=strtotime($fecha.' '.$horario->horarioFinal); $j+=($horario->tiempoAtencion * 60)){
                            $hora       = date("H:i:s", $j);
                            $ocupado    = 0;
                            $reservas   = 0;
    
                            foreach ($rowOcupacion as $ocupacion) {
                                if ($ocupacion->CITA_HORA == $hora) {
                                    $ocupado = 1;
                                    $reservas++;
                                }
                            }
                            array_push($rowDisponibles,array(
                                'horario' => $hora,
                                'ocupado' => $ocupado,
                                'recervas' => $reservas
                            ));
    
                        $horario->disponibles       = $rowDisponibles;
                        $horario->disponibilidad    = count($rowDisponibles) * $horario->ventanillas;
                        $horario->ocupacion         = count($rowOcupacion);
                        $horario->porcentajeOcupacion = round(((count($rowOcupacion) * 100) / (count($rowDisponibles) * $horario->ventanillas)));
                    }
                    $rowHorario = $horario;
                }
            }

            array_push($fechasDisponibles, array(
                'dia'       => date("N", $i),
                'fecha'     => $fecha,
                'horario'   => $rowHorario,
            ));
        }

        return $fechasDisponibles;
    }
    public static function validaNueva($cita) {
        $result = DB::table('citas_tramites_calendario')
            ->where('CITA_IDUSUARIO', $cita->CITA_IDUSUARIO)
            ->where('CITA_IDTRAMITE', $cita->CITA_IDTRAMITE)
            ->get();
        return ($result->count() == 0 ? true : false);
    }

    public static function deleteCita($pk) {
        return Cls_Citas_Calendario::find($pk)->delete();
        // return Cls_Citas_Calendario::where("idcitas_tramites_calendario", $pk)->delete();
        // return DB::table('citas_tramites_calendario')->where("idcitas_tramites_calendario", $pk)->delete();
    }

    public static function aprobarCita($pk) {
        return Cls_Citas_Calendario::where('idcitas_tramites_calendario', $pk)->update([
            'CITA_CONFIRMADO' => 1
        ]);
    }
}