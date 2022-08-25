<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\TramiteService;

class Cls_Citas_Calendario extends Model{
    protected $table = 'citas_tramites_calendario';
    protected $fillable = [
        'CITA_IDUSUARIO', //Quiuen lo solicita
        'CITA_FECHA', //Fecha de la cita
        'CITA_HORA', //Hora de la cita
        'CITA_IDTRAMITE', //Trámite seleccionado
        'CITA_IDMODULO', //Módulo seleccionado
        'CITA_CONFIRMADO' //Confirmación de cita
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

        $horarios = DB::table('citas_tramites')
            ->where('tramiteId', '=', $idtramite)
            ->where('moduloId', '=', $idedificio)
            ->get();
        
        $inicio = date($anio."-".(strlen($mes) == 1 ? "0".$mes : $mes)."-01");
        $fin = date($anio."-".(strlen($mes) == 1 ? "0".$mes : $mes)."-t");

        $fechasDisponibles = array();

        for($i=strtotime(date($inicio)); $i<=strtotime(date($fin)); $i+=86400){
            $rowHorario = array();
            $rowOcupacion = DB::table('citas_tramites_calendario')->where('CITA_FECHA', date("Y-m-d", $i))->get();
            $ocupacion = count($rowOcupacion);           

            foreach ($horarios as $horario) {
                $rowDisponibles = array();
                if ($horario->dia == 'Lunes' && date("N", $i) == 1) {
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
                            $horario->ocupacion = $ocupacion;
                            $horario->porcentajeOcupacion = round(((count($rowOcupacion) * 100) / (count($rowDisponibles) * $horario->ventanillas)));
                    }
                    $horario->fecha = date("Y-m-d", $i);
                    $rowHorario = $horario;
                } elseif ($horario->dia == 'Martes' && date("N", $i) == 2) {
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
                            $horario->ocupacion = $ocupacion;
                            $horario->porcentajeOcupacion = round(((count($rowOcupacion) * 100) / (count($rowDisponibles) * $horario->ventanillas)));
                    }
                    $horario->fecha = date("Y-m-d", $i);
                    $rowHorario = $horario;
                } elseif ($horario->dia == 'Miercoles' && date("N", $i) == 3) {
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
                            $horario->ocupacion = $ocupacion;
                            $horario->porcentajeOcupacion = round(((count($rowOcupacion) * 100) / (count($rowDisponibles) * $horario->ventanillas)));
                    }
                    $horario->fecha = date("Y-m-d", $i);
                    $rowHorario = $horario;
                } elseif ($horario->dia == 'Jueves' && date("N", $i) == 4) {
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
                            $horario->ocupacion = $ocupacion;
                            $horario->porcentajeOcupacion = round(((count($rowOcupacion) * 100) / (count($rowDisponibles) * $horario->ventanillas)));
                    }
                    $horario->fecha = date("Y-m-d", $i);
                    $rowHorario = $horario;
                } elseif ($horario->dia == 'Viernes' && date("N", $i) == 5) {
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
                            $horario->ocupacion = $ocupacion;
                            $horario->porcentajeOcupacion = round(((count($rowOcupacion) * 100) / (count($rowDisponibles) * $horario->ventanillas)));
                    }
                    $horario->fecha = date("Y-m-d", $i);
                    $rowHorario = $horario;
                } elseif ($horario->dia == 'Sabado' && date("N", $i) == 6) {
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
                            $horario->ocupacion = $ocupacion;
                            $horario->porcentajeOcupacion = round(((count($rowOcupacion) * 100) / (count($rowDisponibles) * $horario->ventanillas)));
                    }
                    $horario->fecha = date("Y-m-d", $i);
                    $rowHorario = $horario;
                } elseif ($horario->dia == 'Domingo' && date("N", $i) == 7) {
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
                            $horario->ocupacion = $ocupacion;
                            $horario->porcentajeOcupacion = round(((count($rowOcupacion) * 100) / (count($rowDisponibles) * $horario->ventanillas)));
                    }
                    $horario->fecha = date("Y-m-d", $i);
                    $rowHorario = $horario;
                }
            }

            array_push($fechasDisponibles, array(
                'dia' => date("N", $i),
                'fecha' => date("Y-m-d", $i),
                'horario' => $rowHorario,
                // 'ocupacion' => $rowOcupacion

            ));
        }

        return $fechasDisponibles;
    }
}