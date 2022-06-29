<?php

namespace App\Exports;

use App\Cls_reportes;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Export_TipoTramite implements FromCollection, WithHeadings
{
    var $rol = "";
    var $init_date = "";
    var $finish_date = "";
    
    public function __construct($rol, $init_date, $finish_date)
    {
        $this->rol = $rol;
        $this->init_date = $init_date;
        $this->finish_date = $finish_date;
    }

    public function headings(): array
    {
        return [
            'Folio de trámite',
            'Fecha de envío de carga inicial',
            'Fecha de última modificación',
            'Nombre del trámite',
            'ID del trámite',
            'Unidad Administrativa',
            'Estatus del trámite'
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 30,
            'C' => 30,
            'D' => 70,
            'E' => 15,
            'F' => 35,
            'G' => 20,
        ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $reporte = '';
        if ($this->rol == 'Administrador' || $this->rol == 'Consultor') {
            $reporte = Cls_reportes::obtenerprimerreporteadmincon();
        } elseif ($this->rol == 'Enlace Oficial' || $this->rol == 'Admin-CT' || $this->rol == 'Editor') {
            $dependencia = Cls_reportes::determinardependenciausuario($idusuario);
            $reporte = Cls_reportes::reporte_enlace_adminct_editor($dependencia);
        }

        foreach($reporte as $key){
            $status = '';
            if($key->TRAM_NESTATUS == 0){ $status = 'No iniciado'; }
            elseif($key->TRAM_NESTATUS == 1){ $status = 'Captura inicial'; }
            elseif($key->TRAM_NESTATUS == 2){ $status = 'Pendiente de revisión'; }
            elseif($key->TRAM_NESTATUS == 3){ $status = 'Recibido'; }
            elseif($key->TRAM_NESTATUS == 4){ $status = 'Información incompleta'; }
            elseif($key->TRAM_NESTATUS == 5){ $status = 'Iniciado'; }
            elseif($key->TRAM_NESTATUS == 6){ $status = 'Acción requerida'; }
            elseif($key->TRAM_NESTATUS == 7){ $status = 'En proceso'; }
            elseif($key->TRAM_NESTATUS == 8){ $status = 'Terminado'; }
            elseif($key->TRAM_NESTATUS == 9){ $status = 'Rechazado'; }

            $key->TRAM_NESTATUS = $status;
        }

        return collect($reporte);
    }
}
