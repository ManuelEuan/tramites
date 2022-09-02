<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
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
    public static function getByFiltro($idtramite,$idedificio,$anio,$mes){
        //Obtener detalles del tramite
        // $tramiteService = new TramiteService();
        // $objTramite     = $tramiteService->getTramite($idtramite);
        // $result = $tramiteService->getDetalle($objTramite->Id);

        // $modulos = $result['oficinas'];
        // $horarios = $result['horario'];
        //Fin obtener detalles del tramite

        $inicio = date($anio."-".(strlen($mes) == 1 ? "0".$mes : $mes)."-01");
        $fin = date($anio."-".(strlen($mes) == 1 ? "0".$mes : $mes)."-t");

        $fechasDisponibles = array();

        for($i=strtotime(date($inicio)); $i<=strtotime(date($fin)); $i+=86400){
            $rowHorario = array();
            $rowOcupacion = DB::table('citas_tramites_calendario')
                ->where('CITA_FECHA', date("Y-m-d", $i))
                ->where('CITA_IDTRAMITE', $idtramite)
                ->where('CITA_IDMODULO', $idedificio)
                ->where('deleted_at', null)
                ->get();
            $ocupacion = count($rowOcupacion);
            $dia = "";
            switch (date("N", $i)) {
                case '1':
                    $dia = "Lunes";
                    break;
                case '2':
                    $dia = "Martes";
                    break;
                case '3':
                    $dia = "Miercoles";
                    break;
                case '4':
                    $dia = "Jueves";
                    break;
                case '5':
                    $dia = "Viernes";
                    break;
                case '6':
                    $dia = "Sabado";
                    break;
                case '7':
                    $dia = "Domingo";
                    break;
            }

            $horario = DB::table('citas_tramites')
                ->where('tramiteId', '=', $idtramite)
                ->where('moduloId', '=', $idedificio)
                ->where('dia', '=', $dia)
                ->get();

            $rowDisponibles = array();
            if ($horario->count() > 0) {
                $horario = $horario[0];
                for($j=strtotime(date("Y-m-d", $i).' '.$horario->horarioInicial);
                    $j<=strtotime(date("Y-m-d", $i).' '.$horario->horarioFinal);
                    $j+=($horario->tiempoAtencion * 60)){
                        $hora = date("H:i:s", $j);
                        $disponibilidad = 0;
                        $ocupado = 0;
                        $reservas = 0;
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
                    $horario->disponibles = $rowDisponibles;
                    $horario->disponibilidad = count($rowDisponibles) * $horario->ventanillas;
                    $horario->ocupacion = count($rowOcupacion);
                    $horario->porcentajeOcupacion = round(((count($rowOcupacion) * 100) / (count($rowDisponibles) * $horario->ventanillas)));
                }
                $rowHorario = $horario;
            }

            array_push($fechasDisponibles, array(
                'dia' => date("N", $i),
                'fecha' => date("Y-m-d", $i),
                'horario' => $rowHorario,
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
}