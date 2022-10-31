<?php

namespace App\Http\Controllers;



use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Cls_reportes;
use Exception;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Storage;
use \App\Exports\Export_TipoTramite;
use ZipArchive;
use File;
use App\Cls_Seguimiento_Servidor_Publico;
use App\Models\Cls_Formulario_Pregunta_Respuesta;
use App\Cls_Usuario_Respuesta;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class GenerarReportes extends Controller
{
    private $host = 'https://vucapacita.chihuahua.gob.mx/';
    private $dependencia = [];
    private $unidad = [];
    private $edificio = [];

    public function index(Request $request)
    {
        return view('REPORTES.reportes');
    }

    public function gentreporte(Request $request)
    {
        $treporte = $request->input("treporte");
        $inicio = $request->input("datestart");
        $fin = $request->input("dateend");
        $formato = $request->input("formato");

        $idusuario = Auth::user()->USUA_NIDUSUARIO;
        $result = Cls_reportes::obtenernombrerolreporte($idusuario);
        $rol = '';
        $reporte = '';
        foreach ($result as $value) {
        $rol = $value->ROL_CNOMBRE;
        }

        //Validamos que el rubro seleccionado en la vista para definir la informacion que mostraremos
        if ($treporte == 1) {
            //devuelve el directorio del archivo
            return $this->genReporte_1_1($rol, $formato, $idusuario, $inicio, $fin);
        } elseif ($treporte == 2) {
            //devuelve el directorio del archivo
            return $this->genReporte_2($rol, $formato, $inicio, $fin, $idusuario);
        } elseif ($treporte == 3) {
            //devuelve el directorio del archivo
            return $this->genReporte_3($rol, $formato, $inicio, $fin, $idusuario);
        } elseif ($treporte == 4) {
            //devuelve el directorio del archivo
            return $this->genReporte_4($rol, $formato, $inicio, $fin, $idusuario);
        } elseif ($treporte == 5) {
            //devuelve el directorio del archivo
            return $this->genReporte_5($rol, $formato, $inicio, $fin, $idusuario);
        } elseif ($treporte == 6) {
            //devuelve el directorio del archivo
            return $this->genReporte_6($rol, $formato, $inicio, $fin, $idusuario);
        } elseif ($treporte == 7) {
            //devuelve el directorio del archivo
            return $this->genReporte_7($rol, $formato, $inicio, $fin, $idusuario);
        } elseif ($treporte == 8) {

            return $this->genReporte_8($rol, $formato, $idusuario, $inicio, $fin);
        }
    }

    //1. Tipos de trámites  
    private function genReporte_1($rol, $formato, $idusuario, $inicio, $fin){
        /* obtenemos el id del usuario para poder verificar el rol que tiene en el sistema
                y determinar la informacion que podemos mostrar en el reporte */
            
        if ($rol == 'Administrador' || $rol == 'Consultor') {
            $reporte = Cls_reportes::obtenerprimerreporteadmincon();

            if($formato == 'XLS' || $formato == 'CSV'){
                //$spreadsheet = new Spreadsheet();
                $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
                $spreadsheet = $reader->load("reps/plantilla_tipotramites.xlsx");
                $sheet = $spreadsheet->getActiveSheet();
                $sheet->setCellValue('A1', 'Folio de trámite');
                $sheet->setCellValue('B1', 'Fecha de envío de carga inicial');
                $sheet->setCellValue('C1', 'Fecha de última modificación');
                $sheet->setCellValue('D1', 'Nombre del trámite');
                $sheet->setCellValue('E1', 'ID del trámite');
                $sheet->setCellValue('F1', 'Unidad Administrativa');
                $sheet->setCellValue('G1', 'Estatus del trámite');
                $i = 2;
                foreach($reporte as $key){
                    $sheet->setCellValue('A'.$i, $key->USTR_CFOLIO);
                    $sheet->setCellValue('B'.$i, $key->created_at);
                    $sheet->setCellValue('C'.$i, $key->updated_at);
                    $sheet->setCellValue('D'.$i, $key->TRAM_CNOMBRE);
                    $sheet->setCellValue('E'.$i, $key->TRAM_NIDTRAMITE);
                    $sheet->setCellValue('F'.$i, $key->TRAM_CUNIDADADMINISTRATIVA);
                    $sheet->setCellValue('G'.$i, $this->_getStatusProcedure($key->TRAM_NESTATUS));

                    $i++;
                }
                //$sheet->setCellValue('A1', 'Esto es una prueba');

                if($formato == 'XLS'){
                    $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
                    $writer->save("reps/Tipo_tramite.xlsx");
    
                    return 'reps/Tipo_tramite.xlsx';
                }elseif($formato == 'CSV'){
                    $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Csv");
                    $writer->save("reps/Tipo_tramite.csv");
    
                    return 'reps/Tipo_tramite.csv';
                }
            }elseif($formato == 'XML'){
                //creacion del documento
                $xml = new \DOMDocument( "1.0", "ISO-8859-15" );
                //elemento (padre) principal
                $xml_tipos_tramite = $xml->createElement( "Tipos_tramite" );

                foreach($reporte as $key){
                    //creamos el elemento tramite
                    $xml_tramite = $xml->createElement( "Tramite" );
                    //creamos y damos valor a los atributos.
                    $xml_folio = $xml->createElement( "Folio" , $key->USTR_CFOLIO );
                    $xml_fecha_envio = $xml->createElement( "Fecha_envio_carga_inicial" , $key->created_at );
                    $xml_fecha_modificacion = $xml->createElement( "Fecha_ultima_modificacion" , $key->updated_at );
                    $xml_nombre = $xml->createElement( "Nombre_tramite" , $key->TRAM_CNOMBRE );
                    $xml_id_tramite = $xml->createElement( "ID_tramite" , $key->TRAM_NIDTRAMITE );
                    $xml_unidad = $xml->createElement( "Unidad_Administrativa" , $key->TRAM_CUNIDADADMINISTRATIVA );
                    $xml_status = $xml->createElement( "Estatus" , $this->_getStatusProcedure($key->TRAM_NESTATUS) );

                    //agrupamos los elementos hijo
                    $xml_tramite->appendChild( $xml_folio );
                    $xml_tramite->appendChild( $xml_fecha_envio );
                    $xml_tramite->appendChild( $xml_fecha_modificacion );
                    $xml_tramite->appendChild( $xml_nombre );
                    $xml_tramite->appendChild( $xml_id_tramite );
                    $xml_tramite->appendChild( $xml_unidad );
                    $xml_tramite->appendChild( $xml_status );

                    //agregamos el elemento tramite al elemento principal
                    $xml_tipos_tramite->appendChild($xml_tramite);
                }

                $xml->appendChild( $xml_tipos_tramite );
                $xml->formatOutput = true;
                $xml->saveXML();
                $xml->save('reps/Tipo_tramite.xml');
                return 'reps/Tipo_tramite.xml';
            }
            

            
        } elseif ($rol == 'Enlace Oficial' || $rol == 'Admin-CT' || $rol == 'Editor') {
            $dependencia_1 = Cls_reportes::determinardependenciausuario($idusuario);
            $reporte = Cls_reportes::reporte_enlace_adminct_editor($dependencia_1);

            if($formato == 'XLS' || $formato == 'CSV'){
                //$spreadsheet = new Spreadsheet();
                $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
                $spreadsheet = $reader->load("reps/plantilla_tipotramites.xlsx");
                $sheet = $spreadsheet->getActiveSheet();
                $sheet->setCellValue('A1', 'Folio de trámite');
                $sheet->setCellValue('B1', 'Fecha de envío de carga inicial');
                $sheet->setCellValue('C1', 'Fecha de última modificación');
                $sheet->setCellValue('D1', 'Nombre del trámite');
                $sheet->setCellValue('E1', 'ID del trámite');
                $sheet->setCellValue('F1', 'Unidad Administrativa');
                $sheet->setCellValue('G1', 'Estatus del trámite');
                $i = 2;
                foreach($reporte as $key){
                    $sheet->setCellValue('A'.$i, $key->USTR_CFOLIO);
                    $sheet->setCellValue('B'.$i, $key->created_at);
                    $sheet->setCellValue('C'.$i, $key->updated_at);
                    $sheet->setCellValue('D'.$i, $key->TRAM_CNOMBRE);
                    $sheet->setCellValue('E'.$i, $key->TRAM_NIDTRAMITE);
                    $sheet->setCellValue('F'.$i, $key->TRAM_CUNIDADADMINISTRATIVA);
                    $sheet->setCellValue('G'.$i, $this->_getStatusProcedure($key->TRAM_NESTATUS));
                    
                    $i++;
                }
                //$sheet->setCellValue('A1', 'Esto es una prueba');

                if($formato == 'XLS'){
                    $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
                    $writer->save("reps/Tipo_tramite.xlsx");
    
                    return 'reps/Tipo_tramite.xlsx';
                }elseif($formato == 'CSV'){
                    $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Csv");
                    $writer->save("reps/Tipo_tramite.csv");
    
                    return 'reps/Tipo_tramite.csv';
                }

            }elseif($formato == 'XML'){
                //creacion del documento
                $xml = new \DOMDocument( "1.0", "ISO-8859-15" );
                //elemento (padre) principal
                $xml_tipos_tramite = $xml->createElement( "Tipos_tramite" );

                foreach($reporte as $key){
                    //creamos el elemento tramite
                    $xml_tramite = $xml->createElement( "Tramite" );
                    //creamos y damos valor a los atributos.
                    $xml_folio = $xml->createElement( "Folio" , $key->USTR_CFOLIO );
                    $xml_fecha_envio = $xml->createElement( "Fecha_envio_carga_inicial" , $key->created_at );
                    $xml_fecha_modificacion = $xml->createElement( "Fecha_ultima_modificacion" , $key->updated_at );
                    $xml_nombre = $xml->createElement( "Nombre_tramite" , $key->TRAM_CNOMBRE );
                    $xml_id_tramite = $xml->createElement( "ID_tramite" , $key->TRAM_NIDTRAMITE );
                    $xml_unidad = $xml->createElement( "Unidad_Administrativa" , $key->TRAM_CUNIDADADMINISTRATIVA );
                    $xml_status = $xml->createElement( "Estatus" , $this->_getStatusProcedure($key->TRAM_NESTATUS) );

                    //agrupamos los elementos hijo
                    $xml_tramite->appendChild( $xml_folio );
                    $xml_tramite->appendChild( $xml_fecha_envio );
                    $xml_tramite->appendChild( $xml_fecha_modificacion );
                    $xml_tramite->appendChild( $xml_nombre );
                    $xml_tramite->appendChild( $xml_id_tramite );
                    $xml_tramite->appendChild( $xml_unidad );
                    $xml_tramite->appendChild( $xml_status );

                    //agregamos el elemento tramite al elemento principal
                    $xml_tipos_tramite->appendChild($xml_tramite);
                }

                $xml->appendChild( $xml_tipos_tramite );
                $xml->formatOutput = true;
                $xml->saveXML();
                $xml->save('reps/Tipo_tramite.xml');
                return 'reps/Tipo_tramite.xml';
            }
        }

        //return $rol;

        /* if($formato == 'XLS'){

        }elseif($formato == 'CSV'){

        }elseif($formato == 'XML'){

        } */
        
    }

    private function genReporte_1_1($rol, $formato, $idusuario, $inicio, $fin){
        $reporte = Cls_reportes::obtener_reporte_tipo_tramite($rol, $inicio, $fin, $idusuario);

        if($formato == 'XLS' || $formato == 'CSV'){
            //$spreadsheet = new Spreadsheet();
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
            $spreadsheet = $reader->load("reps/plantilla_tipotramites.xlsx");
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', 'Folio de trámite');
            $sheet->setCellValue('B1', 'Fecha de envío de carga inicial');
            $sheet->setCellValue('C1', 'Fecha de última modificación');
            $sheet->setCellValue('D1', 'Nombre del trámite');
            $sheet->setCellValue('E1', 'ID del trámite');
            $sheet->setCellValue('F1', 'Unidad Administrativa');
            $sheet->setCellValue('G1', 'Estatus del trámite');
            $i = 2;
            foreach($reporte as $key){
                $sheet->setCellValue('A'.$i, $key->USTR_CFOLIO);
                $sheet->setCellValue('B'.$i, $key->created_at);
                $sheet->setCellValue('C'.$i, $key->updated_at);
                $sheet->setCellValue('D'.$i, $key->TRAM_CNOMBRE);
                $sheet->setCellValue('E'.$i, $key->TRAM_NIDTRAMITE);
                $sheet->setCellValue('F'.$i, $key->TRAM_CUNIDADADMINISTRATIVA);
                $sheet->setCellValue('G'.$i, $this->_getStatusProcedure($key->USTR_NBANDERA_PROCESO));

                $i++;
            }
            //$sheet->setCellValue('A1', 'Esto es una prueba');

            if($formato == 'XLS'){
                $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
                $writer->save("reps/Tipo_tramite.xlsx");

                return 'reps/Tipo_tramite.xlsx';
            }elseif($formato == 'CSV'){
                $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Csv");
                $writer->save("reps/Tipo_tramite.csv");

                return 'reps/Tipo_tramite.csv';
            }
        }elseif($formato == 'XML'){
            //creacion del documento
            $xml = new \DOMDocument( "1.0", "ISO-8859-15" );
            //elemento (padre) principal
            $xml_tipos_tramite = $xml->createElement( "Tipos_tramite" );

            foreach($reporte as $key){
                //creamos el elemento tramite
                $xml_tramite = $xml->createElement( "Tramite" );
                //creamos y damos valor a los atributos.
                $xml_folio = $xml->createElement( "Folio" , $key->USTR_CFOLIO );
                $xml_fecha_envio = $xml->createElement( "Fecha_envio_carga_inicial" , $key->created_at );
                $xml_fecha_modificacion = $xml->createElement( "Fecha_ultima_modificacion" , $key->updated_at );
                $xml_nombre = $xml->createElement( "Nombre_tramite" , $key->TRAM_CNOMBRE );
                $xml_id_tramite = $xml->createElement( "ID_tramite" , $key->TRAM_NIDTRAMITE );
                $xml_unidad = $xml->createElement( "Unidad_Administrativa" , $key->TRAM_CUNIDADADMINISTRATIVA );
                $xml_status = $xml->createElement( "Estatus" , $this->_getStatusProcedure($key->USTR_NBANDERA_PROCESO) );

                //agrupamos los elementos hijo
                $xml_tramite->appendChild( $xml_folio );
                $xml_tramite->appendChild( $xml_fecha_envio );
                $xml_tramite->appendChild( $xml_fecha_modificacion );
                $xml_tramite->appendChild( $xml_nombre );
                $xml_tramite->appendChild( $xml_id_tramite );
                $xml_tramite->appendChild( $xml_unidad );
                $xml_tramite->appendChild( $xml_status );

                //agregamos el elemento tramite al elemento principal
                $xml_tipos_tramite->appendChild($xml_tramite);
            }

            $xml->appendChild( $xml_tipos_tramite );
            $xml->formatOutput = true;
            $xml->saveXML();
            $xml->save('reps/Tipo_tramite.xml');
            return 'reps/Tipo_tramite.xml';
        }
    }

    //obtener el status del tipo de tramite
    private function _getStatusProcedure(int $status){
        $status_string = '';

        switch($status){
            case 0: $status_string = 'No iniciado'; break;
            case 1: $status_string = 'Captura inicial'; break;
            case 2: $status_string = 'Pendiente de revisión'; break;
            case 3: $status_string = 'Recibido'; break;
            case 4: $status_string = 'Información incompleta'; break;
            case 5: $status_string = 'Iniciado'; break;
            case 6: $status_string = 'Acción requerida'; break;
            case 7: $status_string = 'En proceso'; break;
            case 8: $status_string = 'Terminado'; break;
            case 9: $status_string = 'Rechazado'; break;
            default : $status_string = 'Sin estado'; break;
        }

        return $status_string;
    }

    //2. Información sobre las características de los usuarios (Funcionarios) 
    private function genReporte_2($rol, $formato, $inicio, $fin, $id_usuario){
        $reporte = Cls_reportes::reporte_caracteristicas_funcionarios($rol, $inicio, $fin, $id_usuario);
        $this->_getDependencia();
        $this->_getUnidadAdmin();
        if($formato == 'XLS' || $formato == 'CSV'){
            //$spreadsheet = new Spreadsheet();
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
            $spreadsheet = $reader->load("reps/plantilla_tipotramites.xlsx");
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', 'Id de usuario');
            $sheet->setCellValue('B1', 'Nombres');
            $sheet->setCellValue('C1', 'Primer apellido');
            $sheet->setCellValue('D1', 'Segundo apellido');
            $sheet->setCellValue('E1', 'Nombre de usuario');
            $sheet->setCellValue('F1', 'Correo electronico');
            $sheet->setCellValue('G1', 'Unidad administrativa');
            $sheet->setCellValue('H1', 'Secretaria o entidad');
            $sheet->setCellValue('I1', 'Estatus');
            $sheet->setCellValue('J1', 'Rol en el sistema');
            $sheet->setCellValue('K1', 'Fecha de alta');
            $i = 2;
            foreach($reporte as $key){
                $sheet->setCellValue('A'.$i, $key->USUA_NIDUSUARIO);
                $sheet->setCellValue('B'.$i, $key->USUA_CNOMBRES);
                $sheet->setCellValue('C'.$i, $key->USUA_CPRIMER_APELLIDO);
                $sheet->setCellValue('D'.$i, $key->USUA_CSEGUNDO_APELLIDO);
                $sheet->setCellValue('E'.$i, $key->USUA_CUSUARIO);
                $sheet->setCellValue('F'.$i, $key->USUA_CCORREO_ELECTRONICO);
                $name_unid = 'Sin dato.';
                if($key->UNIDAD != 0){
                    foreach($this->unidad as $u){
                        if($key->UNIDAD == $u['ID_UNIDAD']){
                            $name_unid = $u['DESCRIPCION'];
                        }
                    }
                }
                $sheet->setCellValue('G'.$i, $name_unid);
                $name_edif = 'Sin dato.';
                if($key->EDIFICIO != 0){
                    foreach($this->dependencia as $u){
                        if($key->EDIFICIO == $u['ID_CENTRO']){
                            $name_edif = $u['DESCRIPCION'];
                        }
                    }
                }
                $sheet->setCellValue('H'.$i, $name_edif);
                $sheet->setCellValue('I'.$i, $key->USUA_NACTIVO == 0 ? 'Activo' : 'Inactivo');
                $sheet->setCellValue('J'.$i, $key->ROL_CNOMBRE);
                $sheet->setCellValue('K'.$i, $key->created_at);
                
                $i++;
            }
            //$sheet->setCellValue('A1', 'Esto es una prueba');

            if($formato == 'XLS'){
                $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
                $writer->save("reps/Informacion_sobre_las_caracteristicas_de_los_usuarios-FUNCIONARIOS.xlsx");
    
                return 'reps/Informacion_sobre_las_caracteristicas_de_los_usuarios-FUNCIONARIOS.xlsx';
            }elseif($formato == 'CSV'){
                $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Csv");
                $writer->save("reps/Informacion_sobre_las_caracteristicas_de_los_usuarios-FUNCIONARIOS.csv");
    
                return 'reps/Informacion_sobre_las_caracteristicas_de_los_usuarios-FUNCIONARIOS.csv';
            }

        }elseif($formato == 'XML'){
            //creacion del documento
            $xml = new \DOMDocument( "1.0", "ISO-8859-15" );
            //elemento (padre) principal
            $xml_usuarios = $xml->createElement( "Usuarios_funcionarios" );

            foreach($reporte as $key){
                //creamos el elememto usario
                $xml_usuario = $xml->createElement( "Funcionario" );
                //creamos y damos valor a los atributos
                $xml_id_usuario = $xml->createElement( "ID_usuario", $key->USUA_NIDUSUARIO );
                $xml_nombre = $xml->createElement( "Nombres", $key->USUA_CNOMBRES );
                $xml_primer_apellido = $xml->createElement( "Primer_apellido", $key->USUA_CPRIMER_APELLIDO );
                $xml_segundo_apellido = $xml->createElement( "Segundo_apellido", $key->USUA_CSEGUNDO_APELLIDO );
                $xml_nom_usuario = $xml->createElement( "Nombre_usuario", $key->USUA_CUSUARIO );
                $xml_correo = $xml->createElement( "Correo_electronico", $key->USUA_CCORREO_ELECTRONICO );
                

                $name_unid = 'Sin dato.';
                if($key->UNIDAD != 0){
                    foreach($this->unidad as $u){
                        if($key->UNIDAD == $u['ID_UNIDAD']){
                            $name_unid = $u['DESCRIPCION'];
                        }
                    }
                }
                $xml_unidad = $xml->createElement( "Unidad_administrativa", $name_unid );
                $name_edif = 'Sin dato.';
                if($key->EDIFICIO != 0){
                    foreach($this->dependencia as $u){
                        if($key->EDIFICIO == $u['ID_CENTRO']){
                            $name_edif = $u['DESCRIPCION'];
                        }
                    }
                }
                $xml_entidad = $xml->createElement( "Entidad", $name_edif );
                $xml_estatus = $xml->createElement( "Estatus", $key->USUA_NACTIVO == 0 ? 'Activo' : 'Inactivo');
                $xml_rol = $xml->createElement( "Rol_sistema", $key->ROL_CNOMBRE );
                $xml_fecha_alta = $xml->createElement( "Fecha_alta", $key->created_at );

                //agregamos los atrobutos al elemento usuario
                $xml_usuario->appendChild( $xml_id_usuario );
                $xml_usuario->appendChild( $xml_nombre );
                $xml_usuario->appendChild( $xml_primer_apellido );
                $xml_usuario->appendChild( $xml_segundo_apellido );
                $xml_usuario->appendChild( $xml_nom_usuario );
                $xml_usuario->appendChild( $xml_correo );
                $xml_usuario->appendChild( $xml_unidad );
                $xml_usuario->appendChild( $xml_entidad );
                $xml_usuario->appendChild( $xml_estatus );
                $xml_usuario->appendChild( $xml_rol );
                $xml_usuario->appendChild( $xml_fecha_alta );

                //agregamos al componente principal
                $xml_usuarios->appendChild( $xml_usuario );
            }

            $xml->appendChild( $xml_usuarios );
            $xml->formatOutput = true;
            $xml->saveXML();
            $xml->save('reps/Informacion_sobre_las_caracteristicas_de_los_usuarios-FUNCIONARIOS.xml');
            return 'reps/Informacion_sobre_las_caracteristicas_de_los_usuarios-FUNCIONARIOS.xml';

        }
    }

    //3. Información sobre las características de los usuarios (Ciudadanos)
    private function genReporte_3($rol, $formato, $inicio, $fin, $id_usuario){
        $reporte = Cls_reportes::reporte_caracteristicas_fciudadanos($rol, $inicio, $fin, $id_usuario);

        if($formato == 'XLS' || $formato == 'CSV'){
            //$spreadsheet = new Spreadsheet();
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
            $spreadsheet = $reader->load("reps/plantilla_tipotramites.xlsx");
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', 'Id de usuario');
            $sheet->setCellValue('B1', 'Sexo');
            $sheet->setCellValue('C1', 'Tipo de persona');
            $sheet->setCellValue('D1', 'Fecha de alta');
            
            $i = 2;
            foreach($reporte as $key){
                $sheet->setCellValue('A'.$i, $key->USUA_NIDUSUARIO);
                $sheet->setCellValue('B'.$i, $key->USUA_NTIPO_SEXO != null ? $key->USUA_NTIPO_SEXO : '---');
                $sheet->setCellValue('C'.$i, $key->USUA_NTIPO_PERSONA);
                $sheet->setCellValue('D'.$i, $key->created_at);
                
                $i++;
            }
            //$sheet->setCellValue('A1', 'Esto es una prueba');
            if($formato == 'XLS'){
                $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
                $writer->save("reps/Informacion_sobre_las_caracteristicas_de_los_usuarios-CIUDADANOS.xlsx");
    
                return 'reps/Informacion_sobre_las_caracteristicas_de_los_usuarios-CIUDADANOS.xlsx';
            }elseif($formato == 'CSV'){
                $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Csv");
                $writer->save("reps/Informacion_sobre_las_caracteristicas_de_los_usuarios-CIUDADANOS.csv");
    
                return 'reps/Informacion_sobre_las_caracteristicas_de_los_usuarios-CIUDADANOS.csv';
            }

        }elseif($formato == 'XML'){
            //creacion del documento
            $xml = new \DOMDocument( "1.0", "ISO-8859-15" );
            //elemento (padre) principal
            $xml_usuarios = $xml->createElement( "Usuarios_ciudadanos" );

            foreach($reporte as $key){
                //creamos el elememto usario
                $xml_usuario = $xml->createElement( "Ciudadano" );

                //creamos y asignamos los atributos de usuario
                $xml_id_usuario = $xml->createElement( "ID_usuario", $key->USUA_NIDUSUARIO );
                $xml_sexo = $xml->createElement( "Sexo", $key->USUA_NTIPO_SEXO != null ? $key->USUA_NTIPO_SEXO : '---' );
                $xml_tipo = $xml->createElement( "Tipo_persona", $key->USUA_NTIPO_PERSONA );
                $xml_fecha_alta = $xml->createElement( "Fecha_alta", $key->created_at );

                //agregamos los atrobutos a usuario
                $xml_usuario->appendChild( $xml_id_usuario );
                $xml_usuario->appendChild( $xml_sexo );
                $xml_usuario->appendChild( $xml_tipo );
                $xml_usuario->appendChild( $xml_fecha_alta );

                //agregamos al componente principal
                $xml_usuarios->appendChild( $xml_usuario );
            }

            $xml->appendChild( $xml_usuarios );
            $xml->formatOutput = true;
            $xml->saveXML();
            $xml->save('reps/Informacion_sobre_las_caracteristicas_de_los_usuarios-CIUDADANOS.xml');
            return 'reps/Informacion_sobre_las_caracteristicas_de_los_usuarios-CIUDADANOS.xml';
        }
    }

    //4. Dependencias con trámites en ACCEDE
    private function genReporte_4($rol, $formato, $inicio, $fin, $id_usuario){
        $cpagos= '';
        $cresolutivo = '';
        $reporte = Cls_reportes::dependencia_con_tramites($rol ,$inicio, $fin, $id_usuario);

        if($formato == 'XLS' || $formato == 'CSV'){
            //$spreadsheet = new Spreadsheet();
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
            $spreadsheet = $reader->load("reps/plantilla_tipotramites.xlsx");
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', 'Id de dependencia');
            $sheet->setCellValue('B1', 'Dependencia');
            $sheet->setCellValue('C1', 'Unidad administrativa');
            $sheet->setCellValue('D1', 'Edificio(s)');
            $sheet->setCellValue('E1', 'Id de tramite');
            $sheet->setCellValue('F1', 'Tramite');
            $sheet->setCellValue('G1', 'Cantidad de módulos de pagos por trámite');
            $sheet->setCellValue('H1', 'Cantidad de módulo de citas por trámite');
            $sheet->setCellValue('I1', 'Cantidad de módulos de ventanilla por trámite');
            $sheet->setCellValue('J1', 'Cantidad de módulos de resolutivo electrónico por trámite');
            $sheet->setCellValue('K1', 'Fecha de última configuración en el SIGETYS');
            $sheet->setCellValue('L1', 'Fecha de última modificación');
            
            $i = 2;
            foreach($reporte as $key){
                $sheet->setCellValue('A'.$i, $key->TRAM_NIDCENTRO);
                $sheet->setCellValue('B'.$i, $key->TRAM_CCENTRO);
                $sheet->setCellValue('C'.$i, $key->TRAM_CUNIDADADMINISTRATIVA);
                $sheet->setCellValue('D'.$i, $key->edificios);
                $sheet->setCellValue('E'.$i, $key->TRAM_NIDTRAMITE);
                $sheet->setCellValue('F'.$i, $key->TRAM_CNOMBRE);
                $sheet->setCellValue('G'.$i, $key->c_pagos);
                $sheet->setCellValue('H'.$i, $key->c_citas);
                $sheet->setCellValue('I'.$i, $key->c_ventanilla);
                $sheet->setCellValue('J'.$i, $key->c_resolutivo);
                $sheet->setCellValue('K'.$i, $key->created_at);
                $sheet->setCellValue('L'.$i, $key->updated_at);
                
                $i++;
            }
            //$sheet->setCellValue('A1', 'Esto es una prueba');

            if($formato == 'XLS'){
                $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
                $writer->save("reps/Dependencias_con_tramites_en_SIGETYS.xlsx");
    
                return 'reps/Dependencias_con_tramites_en_SIGETYS.xlsx';
            }elseif($formato == 'CSV'){
                $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Csv");
                $writer->save("reps/Dependencias_con_tramites_en_SIGETYS.csv");
    
                return 'reps/Dependencias_con_tramites_en_SIGETYS.csv';
            }

        }elseif($formato == 'XML'){
            //creacion del documento
            $xml = new \DOMDocument( "1.0", "ISO-8859-15" );
            //elemento (padre) principal
            $xml_dependencias = $xml->createElement( "Dependencias_con_tramites" );

            foreach($reporte as $key){
                //creamos el elemento dependencia
                $xml_dependencia = $xml->createElement( "Dependencia" );

                //creamos y asignamos los actributos de dependencia
                $xml_id_dependencia = $xml->createElement( "ID_dependencia", $key->TRAM_NIDCENTRO );
                $xml_nom_dependencia = $xml->createElement( "Dependencia", $key->TRAM_CCENTRO );
                $xml_unidad = $xml->createElement( "Unidad_administrativa", $key->TRAM_CUNIDADADMINISTRATIVA );
                $xml_edificio = $xml->createElement( "Edificio", $key->edificios );
                $xml_id_tramite = $xml->createElement( "ID_tramite", $key->TRAM_NIDTRAMITE );
                $xml_tramite = $xml->createElement( "Tramite", $key->TRAM_CNOMBRE );

                $xml_pagos = $xml->createElement('Cantidad_modulos_pagos', $key->c_pagos );
                $xml_citas = $xml->createElement('Cantidad_modulos_citas', $key->c_citas );
                $xml_ventanilla = $xml->createElement('Cantidad_modulos_ventanilla', $key->c_ventanilla );
                $xml_resolutivo = $xml->createElement('Cantidad_modulos_pagos', $key->c_resolutivo );

                $xml_ultima_conf = $xml->createElement('Ultima_configuracion_SIGETYS', $key->created_at);
                $xml_ultima_mod = $xml->createElement('Ultima_modificacion', $key->updated_at);

                //agregamos los atributos a dependencia
                $xml_dependencia->appendChild( $xml_id_dependencia );
                $xml_dependencia->appendChild( $xml_nom_dependencia );
                $xml_dependencia->appendChild( $xml_unidad );
                $xml_dependencia->appendChild( $xml_edificio );
                $xml_dependencia->appendChild( $xml_id_tramite );
                $xml_dependencia->appendChild( $xml_tramite );
                $xml_dependencia->appendChild( $xml_pagos );
                $xml_dependencia->appendChild( $xml_citas );
                $xml_dependencia->appendChild( $xml_ventanilla );
                $xml_dependencia->appendChild( $xml_resolutivo );
                $xml_dependencia->appendChild( $xml_ultima_conf );
                $xml_dependencia->appendChild( $xml_ultima_mod );

                //agregamos al componente principal
                $xml_dependencias->appendChild( $xml_dependencia );
            }

            $xml->appendChild( $xml_dependencias );
            $xml->formatOutput = true;
            $xml->saveXML();
            $xml->save('reps/Dependencias_con_tramites_en_SIGETYS.xml');
            return 'reps/Dependencias_con_tramites_en_SIGETYS.xml';
        }
    }
    
    //5. Seguimiento de trámites por módulos y estatus
    private function genReporte_5($rol, $formato, $fecha_inicio, $fecha_fin, $idusuario){
        $reporte = Cls_reportes::reporte_modulo_estado($rol, $fecha_inicio, $fecha_fin,  $idusuario);
        
        if($formato == 'XLS' || $formato == 'CSV'){
            //$spreadsheet = new Spreadsheet();
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
            $spreadsheet = $reader->load("reps/plantilla_tipotramites.xlsx");
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', 'ID trámite');
            $sheet->setCellValue('B1', 'Nombre del trámite');
            $sheet->setCellValue('C1', 'Total de iniciados');
            $sheet->setCellValue('D1', 'Total de cargas iniciales concluidas');
            $sheet->setCellValue('E1', 'Total de subsanar información incompleta solicitadas');
            $sheet->setCellValue('F1', 'Total de subsanar información incompleta finalizadas');
            $sheet->setCellValue('G1', 'Total de pagos válidos');
            $sheet->setCellValue('H1', 'Tota de citas programadas');
            $sheet->setCellValue('I1', 'Tota de citas realizadas');
            $sheet->setCellValue('J1', 'Total de ventanilla sin cita válidas');
            $sheet->setCellValue('K1', 'Total de resolutivo electrónico emitidos');
            $sheet->setCellValue('L1', 'Total de trámites no finalizados');
            $sheet->setCellValue('M1', 'Total de trámites finalizados');
            
            $i = 2;
            foreach($reporte as $key){
                $sheet->setCellValue('A'.$i, $key->USTR_NIDTRAMITE);
                $sheet->setCellValue('B'.$i, $key->TRAM_CNOMBRE);
                $sheet->setCellValue('C'.$i, $key->total_iniciados);
                $sheet->setCellValue('D'.$i, $key->total_iniciados_concluidas);
                $sheet->setCellValue('E'.$i, $key->total_info_incompleta_sol);
                $sheet->setCellValue('F'.$i, $key->total_info_incompleta_fin);
                $sheet->setCellValue('G'.$i, $key->total_pagos_validos);
                $sheet->setCellValue('H'.$i, $key->total_citas_programadas);
                $sheet->setCellValue('I'.$i, $key->total_citas_realizadas);
                $sheet->setCellValue('J'.$i, $key->total_vent_sin_cita);
                $sheet->setCellValue('K'.$i, $key->total_resolutivo);
                $sheet->setCellValue('L'.$i, $key->total_no_finalizados);
                $sheet->setCellValue('M'.$i, $key->total_finalizados);
                $i++;
            }

            //$sheet->setCellValue('A1', 'Esto es una prueba');
            
            if($formato == 'XLS'){
                $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
                $writer->save("reps/Seguimiento_de_tramites_por_modulos_y_estatus.xlsx");

                return 'reps/Seguimiento_de_tramites_por_modulos_y_estatus.xlsx';
            }elseif($formato == 'CSV'){
                $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Csv");
                $writer->save("reps/Seguimiento_de_tramites_por_modulos_y_estatus.csv");

                return 'reps/Seguimiento_de_tramites_por_modulos_y_estatus.csv';
            }

        }elseif($formato == 'XML'){
            //creacion del documento
            $xml = new \DOMDocument( "1.0", "ISO-8859-15" );
            //elemento (padre) principal
            $xml_seguimiento = $xml->createElement( 'Seguimientos_tramites' );

            foreach($reporte as $key){
                //creamos el elemento tramite
                $xml_tramite = $xml->createElement( 'Tramite' );

                //creamos y asignamos los atributos de tramite
                $xml_id_tramite = $xml->createElement( 'ID_tramite', $key->USTR_NIDTRAMITE );
                $xml_nombre = $xml->createElement( 'Nombre_tramite', $key->TRAM_CNOMBRE );

                $xml_totales = $xml->createElement( 'Totales' );//Elemento que contendra los totales

                $xml_iniciados = $xml->createElement( 'Iniciados', $key->total_iniciados );
                $xml_iniciados_conluidos = $xml->createElement( 'Cargas_iniciales_concluidas', $key->total_iniciados_concluidas );
                $xml_subsanar_inc_sol = $xml->createElement( 'Subsanar_informacion_incompleta_solicitadas', $key->total_info_incompleta_sol );
                $xml_subsanar_inc_fin = $xml->createElement( 'Subsanar_informacion_incompleta_finalizadas', $key->total_info_incompleta_fin );
                $xml_pagos_val = $xml->createElement( 'Pagos_validos', $key->total_pagos_validos );
                $xml_citas_program = $xml->createElement( 'Citas_programadas', $key->total_citas_programadas );
                $xml_citas_real = $xml->createElement( 'Citas_realizadas', $key->total_citas_realizadas );
                $xml_vent_sin_cita = $xml->createElement( 'Ventanilla_sin_cita_validas', $key->total_vent_sin_cita);
                $xml_resolutivo = $xml->createElement( 'Resolutivo_electronico_emitidos', $key->total_resolutivo);
                $xml_no_finalizado = $xml->createElement( 'Tramites_no_finalizados', $key->total_no_finalizados);
                $xml_finalizado = $xml->createElement( 'Tramites_finalizados', $key->total_finalizados);


                //agregamos los atributos a totales
                $xml_totales->appendChild( $xml_iniciados );
                $xml_totales->appendChild( $xml_iniciados_conluidos );
                $xml_totales->appendChild( $xml_subsanar_inc_sol );
                $xml_totales->appendChild( $xml_subsanar_inc_fin );
                $xml_totales->appendChild( $xml_pagos_val );
                $xml_totales->appendChild( $xml_citas_program );
                $xml_totales->appendChild( $xml_citas_real );
                $xml_totales->appendChild( $xml_vent_sin_cita );
                $xml_totales->appendChild( $xml_resolutivo );
                $xml_totales->appendChild( $xml_no_finalizado );
                $xml_totales->appendChild( $xml_finalizado );

                //agregamos al componente tramite
                $xml_tramite->appendChild( $xml_id_tramite );
                $xml_tramite->appendChild( $xml_nombre );
                $xml_tramite->appendChild( $xml_totales );

                //agregamos al componente principal
                $xml_seguimiento->appendChild( $xml_tramite );
            }

            $xml->appendChild( $xml_seguimiento );
            $xml->formatOutput = true;
            $xml->saveXML();
            $xml->save('reps/Seguimiento_de_tramites_por_modulos_y_estatus.xml');
            return 'reps/Seguimiento_de_tramites_por_modulos_y_estatus.xml';
        }
    }
    
    //6. Campos desplegables contenidos en cada trámite
    private function genReporte_6($rol, $formato, $init_date, $finish_date, $id_usuario){
        $reporte = Cls_reportes::reporte_campos_desplegados_contenido_tramites($rol, $init_date, $finish_date, $id_usuario);
        //return $reporte;
        if($formato == 'XLS' || $formato == 'CSV'){
            //$spreadsheet = new Spreadsheet();
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
            $spreadsheet = $reader->load("reps/plantilla_tipotramites.xlsx");
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', 'ID trámite');
            $sheet->setCellValue('B1', 'Nombre del trámite');
            $sheet->setCellValue('C1', 'Fecha de ultima configuracion');
            $sheet->setCellValue('D1', 'Fecha de ultima actualizacion');
            $sheet->setCellValue('E1', 'Tiene modulos de pago');
            $sheet->setCellValue('F1', 'Numero de modulos de pago');
            $sheet->setCellValue('G1', 'Tiene modulos de citas');
            $sheet->setCellValue('H1', 'Numero de modulos de citas');
            $sheet->setCellValue('I1', 'Tiene modulos de ventanilla');
            $sheet->setCellValue('J1', 'Numero de modulos de ventanilla');
            $sheet->setCellValue('K1', 'Tiene resolutivo electronico');
            $sheet->setCellValue('L1', 'Numero de modulos de resolutivo');
            $sheet->setCellValue('M1', 'Unidad administrativa');
            $sheet->setCellValue('N1', 'Secretaria o entidad');
            
            $i = 2;
            foreach($reporte as $key){
                $sheet->setCellValue('A'.$i, $key->TRAM_NIDTRAMITE);
                $sheet->setCellValue('B'.$i, $key->TRAM_CNOMBRE);
                $sheet->setCellValue('C'.$i, $key->created_at);
                $sheet->setCellValue('D'.$i, $key->updated_at);
                //PAGOS
                $sheet->setCellValue('E'.$i, $key->num_pagos > 0 ? 'Si':'No');
                $sheet->setCellValue('F'.$i, $key->num_pagos);
                //CITAS
                $sheet->setCellValue('G'.$i, $key->num_citas > 0 ? 'Si':'No');
                $sheet->setCellValue('H'.$i, $key->num_citas);
                //VENTANILLA
                $sheet->setCellValue('I'.$i, $key->num_ventanilla > 0 ? 'Si':'No');
                $sheet->setCellValue('J'.$i, $key->num_ventanilla);
                //RESOLITUVO
                $sheet->setCellValue('K'.$i, $key->num_resolutivo > 0 ? 'Si':'No');
                $sheet->setCellValue('L'.$i, $key->num_resolutivo);

                $sheet->setCellValue('M'.$i, $key->TRAM_CUNIDADADMINISTRATIVA);
                $sheet->setCellValue('N'.$i, $key->TRAM_CCENTRO);
                $i++;
            }
            //$sheet->setCellValue('A1', 'Esto es una prueba');

            if($formato == 'XLS'){
                $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
                $writer->save("reps/Campos_desplegables_contenidos_en_cada_tramite.xlsx");
    
                return 'reps/Campos_desplegables_contenidos_en_cada_tramite.xlsx';
            }elseif($formato == 'CSV'){
                $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Csv");
                $writer->save("reps/Campos_desplegables_contenidos_en_cada_tramite.csv");
    
                return 'reps/Campos_desplegables_contenidos_en_cada_tramite.csv';
            }

        }elseif($formato == 'XML'){
            //creacion del documento
            $xml = new \DOMDocument( "1.0", "ISO-8859-15" );
            //elemento (padre) principal
            $xml_campos_desplegables = $xml->createElement( 'Campos_desplegables' );

            foreach($reporte as $key){
                //creamos el elemento tramite
                $xml_tramite = $xml->createElement( 'Tramite' );
                //asignamos valor a los atributos del tramite
                $xml_id_tramite = $xml->createElement( 'ID_tramite', $key->TRAM_NIDTRAMITE );
                $xml_nombre = $xml->createElement( 'Nombre', $key->TRAM_CNOMBRE );
                $xml_ult_conf = $xml->createElement( 'Ultima_configuracion', $key->created_at );
                $xml_ult_act = $xml->createElement( 'Ultima_actualizacion', $key->updated_at );
                $xml_unidad = $xml->createElement( 'Unidad_administrativa', $key->TRAM_CUNIDADADMINISTRATIVA );
                $xml_entidad = $xml->createElement( 'Entidad', $key->TRAM_CCENTRO );

                //elemento que contendra los datos del contenido del tramite
                $xml_contenido = $xml->createElement( 'Contenido' );

                $xml_mod_pagos = $xml->createElement( 'Modulo_pagos', $key->num_pagos > 0 ? 'Si':'No' );
                $xml_num_pagos = $xml->createElement( 'Numero_pagos', $key->num_pagos );

                $xml_mod_citas = $xml->createElement( 'Modulo_citas', $key->num_citas > 0 ? 'Si':'No' );
                $xml_num_citas = $xml->createElement( 'Numero_citas', $key->num_citas );

                $xml_mod_ventanilla = $xml->createElement( 'Modulo_ventanilla', $key->num_ventanilla > 0 ? 'Si':'No' );
                $xml_num_ventanilla = $xml->createElement( 'Numero_ventanilla', $key->num_ventanilla );

                $xml_mod_resolutivo = $xml->createElement( 'Modulo_resolutivo', $key->num_resolutivo > 0 ? 'Si':'No' );
                $xml_num_resolutivo = $xml->createElement( 'Numero_resolutivo', $key->num_resolutivo );

                //asignacion de elementos hijo de contenido
                $xml_contenido->appendChild( $xml_mod_pagos );
                $xml_contenido->appendChild( $xml_num_pagos );
                $xml_contenido->appendChild( $xml_mod_citas );
                $xml_contenido->appendChild( $xml_num_citas );
                $xml_contenido->appendChild( $xml_mod_ventanilla );
                $xml_contenido->appendChild( $xml_num_ventanilla );
                $xml_contenido->appendChild( $xml_mod_resolutivo );
                $xml_contenido->appendChild( $xml_num_resolutivo );

                //asignacion de componentes hijo a tramite
                $xml_tramite->appendChild( $xml_id_tramite );
                $xml_tramite->appendChild( $xml_nombre );
                $xml_tramite->appendChild( $xml_ult_conf );
                $xml_tramite->appendChild( $xml_ult_act );
                $xml_tramite->appendChild( $xml_contenido );
                $xml_tramite->appendChild( $xml_unidad );
                $xml_tramite->appendChild( $xml_entidad );

                //agregamos el tramite al elemento padre
                $xml_campos_desplegables->appendChild( $xml_tramite );
            }

            $xml->appendChild( $xml_campos_desplegables );
            $xml->formatOutput = true;
            $xml->saveXML();
            $xml->save('reps/Campos_desplegables_contenidos_en_cada_tramite.xml');
            return 'reps/Campos_desplegables_contenidos_en_cada_tramite.xml';
        }
    }
    //7. Resultado de encuestas de satisfacción
    private function genReporte_7($rol, $formato, $inicio, $fin, $id_usuario){
        $reporte = Cls_reportes::reporte_encuesta_satisfaccion($rol, $inicio, $fin, $id_usuario);

        if($formato == 'XLS' || $formato == 'CSV'){ //solo cuando sean esos formatos
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
            $spreadsheet = $reader->load("reps/plantilla_tipotramites.xlsx");
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', 'ID trámite');
            $sheet->setCellValue('B1', 'Fecha de encuenta');
            $sheet->setCellValue('C1', 'Nombre del tramite');
            $sheet->setCellValue('D1', 'Edificio');
            $sheet->setCellValue('E1', 'Ente público');
            $sheet->setCellValue('F1', 'Unidad Administrativa');
            $sheet->setCellValue('G1', 'Municipio');
            //$sheet->setCellValue('H1', 'Pregunta');
            //$sheet->setCellValue('I1', 'Respuesta');
            $sheet->setCellValue('H1', '1. ¿Cómo fue el servicio que recibió por parte de la persona que le atendió?');
            $sheet->setCellValue('I1', '2. De acuerdo a su visita, ¿se enfrentó con obstáculos, barreras o algún tipo de inconveniente?');
            $sheet->setCellValue('J1', '3. ¿Qué tan satisfecho se encuentra con el tiempo de atención del trámite o servicio?');
            $sheet->setCellValue('K1', '4. ¿Desea agregar algún comentario adicional?');

            $i = 2;
            for($j = 0; count($reporte) > $j; $j++){
                $sheet->setCellValue('A'.$i, $reporte[$j]->USTR_NIDTRAMITE);
                $sheet->setCellValue('B'.$i, $reporte[$j]->created_at);
                $sheet->setCellValue('C'.$i, $reporte[$j]->TRAM_CNOMBRE);
                $sheet->setCellValue('D'.$i, $reporte[$j]->USTR_CMODULO);
                $sheet->setCellValue('E'.$i, $reporte[$j]->TRAM_CCENTRO);
                $sheet->setCellValue('F'.$i, $reporte[$j]->TRAM_CUNIDADADMINISTRATIVA);
                $sheet->setCellValue('G'.$i, $reporte[$j]->USTR_CMUNICIPIO != null ? $key->USTR_CMUNICIPIO: '---');
                //$sheet->setCellValue('H'.$i, $key->HENCS_CPREGUNTA);
                $sheet->setCellValue('H'.$i, $reporte[$j]->HENCS_CPRESPUESTA);
                $j++;
                $sheet->setCellValue('j'.$i, $reporte[$j]->HENCS_CPRESPUESTA);
                $j++;
                $sheet->setCellValue('I'.$i, $reporte[$j]->HENCS_CPRESPUESTA);
                $j++;
                $sheet->setCellValue('K'.$i, $reporte[$j]->HENCS_CPRESPUESTA);
                $i++;
            }
        }

        if($formato == 'XLS'){
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
            $writer->save("reps/Resultados_encuestas_de_satisfaccion.xlsx");
            
            return "reps/Resultados_encuestas_de_satisfaccion.xlsx";
        }elseif($formato == 'CSV'){
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Csv");
            $writer->save("reps/Resultados_encuestas_de_satisfaccion.csv");

            return 'reps/Resultados_encuestas_de_satisfaccion.csv';
        }elseif($formato == 'XML'){
            //creacion del documento
            $xml = new \DOMDocument( "1.0", "ISO-8859-15" );
            //elemento (padre) principal
            $xml_encuestas = $xml->createElement( "Encuestas_de_satisfaccion" );
            
            for($j = 0; count($reporte) > $j; $j++){
                $xml_encuesta = $xml->createElement( "Encuesta" );
                $xml_ID_tramite = $xml->createElement( "ID_tramite", $reporte[$j]->USTR_NIDTRAMITE );
                $xml_fecha = $xml->createElement( "Fecha_encuesta", $reporte[$j]->created_at );
                $xml_nombre = $xml->createElement( "Nombre_tramite", $reporte[$j]->TRAM_CNOMBRE );
                $xml_edificio = $xml->createElement( "Edificio", $reporte[$j]->USTR_CMODULO );
                $xml_ente = $xml->createElement('Ente_publico', $reporte[$j]->TRAM_CCENTRO );
                $xml_unidad = $xml->createElement('Unidad_administrativa', $reporte[$j]->TRAM_CUNIDADADMINISTRATIVA );
                $xml_municipio = $xml->createElement('Municipio', $reporte[$j]->USTR_CMUNICIPIO != null ? $key->USTR_CMUNICIPIO: 'Sin dato.' );

                $xml_pregunta_1 = $xml->createElement('Pregunta_1', '1. ¿Cómo fue el servicio que recibió por parte de la persona que le atendió?');
                $xml_respuesta_1 = $xml->createElement('Respuesta_1', $reporte[$j]->HENCS_CPRESPUESTA);
                $j++;
                $xml_pregunta_2= $xml->createElement('Pregunta_2', '2. De acuerdo a su visita, ¿se enfrentó con obstáculos, barreras o algún tipo de inconveniente?');
                $xml_respuesta_2 = $xml->createElement('Respuesta_2', $reporte[$j]->HENCS_CPRESPUESTA );
                $j++;
                $xml_pregunta_3 = $xml->createElement('Pregunta_3', '3. ¿Qué tan satisfecho se encuentra con el tiempo de atención del trámite o servicio?');
                $xml_respuesta_3 = $xml->createElement('Respuesta_3', $reporte[$j]->HENCS_CPRESPUESTA );
                $j++;
                $xml_pregunta_4 = $xml->createElement('Pregunta_4', '4. ¿Desea agregar algún comentario adicional?');
                $xml_respuesta_4 = $xml->createElement('Respuesta_4', $reporte[$j]->HENCS_CPRESPUESTA );

                //agregamos los atributos hijos
                $xml_encuesta->appendChild( $xml_ID_tramite );
                $xml_encuesta->appendChild( $xml_fecha );
                $xml_encuesta->appendChild( $xml_nombre );
                $xml_encuesta->appendChild( $xml_edificio );
                $xml_encuesta->appendChild( $xml_ente );
                $xml_encuesta->appendChild( $xml_unidad );
                $xml_encuesta->appendChild( $xml_municipio );
                $xml_encuesta->appendChild( $xml_pregunta_1 );
                $xml_encuesta->appendChild( $xml_respuesta_1 );
                $xml_encuesta->appendChild( $xml_pregunta_2 );
                $xml_encuesta->appendChild( $xml_respuesta_2 );
                $xml_encuesta->appendChild( $xml_pregunta_3 );
                $xml_encuesta->appendChild( $xml_respuesta_3 );
                $xml_encuesta->appendChild( $xml_pregunta_4 );
                $xml_encuesta->appendChild( $xml_respuesta_4 );

                //agregamos la encuenta al componente principal de encuentas
                $xml_encuestas->appendChild( $xml_encuesta );
            }
            $xml->appendChild( $xml_encuestas );
            $xml->formatOutput = true;
            $xml->saveXML();
            $xml->save('reps/Resultados_encuestas_de_satisfaccion.xml');
            return 'reps/Resultados_encuestas_de_satisfaccion.xml';
        }
    }

    //8. Todos los rubros
    private function genReporte_8($rol, $formato, $idusuario, $inicio, $fin){
        //obtenemos las direcciones de los archivos
        $reporte_1 = $this->genReporte_1_1($rol, $formato, $idusuario, $inicio, $fin);
        $reporte_2 = $this->genReporte_2($rol, $formato, $inicio, $fin, $idusuario);
        $reporte_3 = $this->genReporte_3($rol, $formato, $inicio, $fin, $idusuario);
        $reporte_4 = $this->genReporte_4($rol, $formato, $inicio, $fin, $idusuario);
        $reporte_5 = $this->genReporte_5($rol, $formato, $inicio, $fin, $idusuario);
        $reporte_6 = $this->genReporte_6($rol, $formato, $inicio, $fin, $idusuario);
        $reporte_7 = $this->genReporte_7($rol, $formato, $inicio, $fin, $idusuario);
        
        $zip = new ZipArchive();
        $path = public_path();
        $fileName = 'Reportes.zip';

        //Eliminamos el archivo zip en caso de que exista
        File::delete(public_path('reps/'.$fileName));

        if ($zip->open(public_path('reps/'.$fileName), ZipArchive::CREATE) == TRUE) {
            //agregamos documentos
            if (file_exists(public_path($reporte_1))) { $zip->addFile(public_path($reporte_1), $reporte_1); }
            if (file_exists(public_path($reporte_2))) { $zip->addFile(public_path($reporte_2), $reporte_2); }
            if (file_exists(public_path($reporte_3))) { $zip->addFile(public_path($reporte_3), $reporte_3); }
            if (file_exists(public_path($reporte_4))) { $zip->addFile(public_path($reporte_4), $reporte_4); }
            if (file_exists(public_path($reporte_5))) { $zip->addFile(public_path($reporte_5), $reporte_5); }
            if (file_exists(public_path($reporte_6))) { $zip->addFile(public_path($reporte_6), $reporte_6); }
            if (file_exists(public_path($reporte_7))) { $zip->addFile(public_path($reporte_7), $reporte_7); }

            $zip->close();
        }

        return 'reps/'.$fileName;
    }

    private function _getUnidadAdmin(){
        $options = array( 'http' => array( 'method'  => 'GET' ));

        $url = $this->host.'api/vw_accede_unidad_administrativa';

        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        $registros = json_decode($result, true);

        $this->unidad = $registros;
    }

    private function _getDependencia(){
        $url = $this->host.'api/vw_accede_centro_trabajo';
        $options = array( 'http' => array( 'method'  => 'GET' ));

        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        $registros = json_decode($result, true);

        $this->dependencia =  $registros;
    }

    private function _getEdificio(){
        $url = $this->host.'api/vw_accede_edificios';
        $options = array( 'http' => array( 'method'  => 'GET' ));

        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        $registros = json_decode($result, true);

        $this->edificio = $registros;
    }

    public function generarZip(Request $request){
        $inicio = $request->input("datestart");
        $fin = $request->input("dateend");
        $idsTramites = Cls_Seguimiento_Servidor_Publico::OBTENER_ID_POR_FECHA($inicio, $fin);
        if(count($idsTramites) > 0){
            try {
                $zipPrincipal = new ZipArchive();
                $fecha = Carbon::now();
                $fecha = $fecha->toArray();
                $fecha = $fecha['timestamp'];
                $fileNamePrincipal = 'REPORTES_' . $inicio .'_'. $fin .'.zip';
                $fileName = "";
                $pathPdf        = public_path('tramites');
                $archivosBorrar = array();
        
                if ($zipPrincipal->open($pathPdf."/".$fileNamePrincipal, ZipArchive::CREATE) == TRUE) {
                    foreach ($idsTramites as $key => $id) {
                        $tramite_ = Cls_Seguimiento_Servidor_Publico::TRAM_CONSULTAR_CONFIGURACION_TRAMITE_PUBLICO($id->USTR_NIDUSUARIOTRAMITE);
                        $configuracion =  $tramite_;
                        $USTR_NIDUSUARIOTRAMITE = $tramite_['tramite'][0]->USTR_NIDUSUARIOTRAMITE;
                        $arrayPer['tipoPer'] = $tramite_['tramite'][0]->USTR_CTIPO_PERSONA;
        
                        $respuestas = Cls_Usuario_Respuesta::where('USRE_NIDUSUARIOTRAMITE', $USTR_NIDUSUARIOTRAMITE)->orderBy('USRE_NIDUSUARIORESP','DESC')->get();
        
        
                        foreach ($configuracion['formularios'] as $form) {
                            foreach ($form->secciones as $sec) {
                                foreach ($sec->preguntas as $preg) {
                                    foreach ($preg->respuestas as $resp) {
                                        $resp->FORM_CVALOR_RESPUESTA = "";
            
                                        foreach ($respuestas as $_resp) {
                                            if ($preg->FORM_NID == $_resp['USRE_NIDPREGUNTA']) {
                                                $preg->estatus = $_resp['USRE_NESTATUS'];
                                                $preg->observaciones = $_resp['USRE_COBSERVACION'];
                                            }
            
                                            switch ($preg->FORM_CTIPORESPUESTA) {
                                                case "multiple":
                                                    if ($resp->FORM_NID == $_resp['USRE_CRESPUESTA']) {
                                                        $resp->FORM_CVALOR_RESPUESTA = "checked";
                                                        break;
                                                    }
                                                    break;
                                                case "unica":
                                                    if ($resp->FORM_NID == $_resp['USRE_CRESPUESTA']) {
                                                        $resp->FORM_CVALOR_RESPUESTA = "checked";
                                                        break;
                                                    }
                                                    break;
                                                case "especial":
                                                    foreach ($resp->respuestas_especial as $esp) {
                                                        switch ($resp->FORM_CTIPORESPUESTAESPECIAL) {
                                                            case "opciones":
            
                                                                if ($esp->FORM_NPREGUNTARESPUESTAID == $_resp['USRE_NIDPREGUNTARESPUESTA']) {
                                                                    if ($esp->FORM_NID == $_resp['USRE_CRESPUESTA']) {
                                                                        $esp->FORM_CVALOR_RESPUESTA = "selected";
                                                                        break;
                                                                    }
                                                                }
                                                                break;
                                                            default:
                                                                if ($esp->FORM_NPREGUNTARESPUESTAID == $_resp['USRE_NIDPREGUNTARESPUESTA']) {
                                                                    $esp->FORM_CVALOR_RESPUESTA = $_resp['USRE_CRESPUESTA'];
                                                                    break;
                                                                }
                                                                break;
                                                        }
                                                    }
                                                    break;
                                                case "catalogo":
                                                    if ($preg->FORM_NID == $_resp['USRE_NIDPREGUNTA']){
                                                        $array = explode(",",$_resp->USRE_CRESPUESTA);
                                                        $valorRespuesta = DB::table($resp->FORM_CVALOR)->whereIn('id', $array)->get();
                                                        $resp->FORM_CVALOR_RESPUESTA = $valorRespuesta;
                                                    }
                                                    break;
                                                default:
                                                    if ($resp->FORM_NPREGUNTAID === $_resp['USRE_NIDPREGUNTA']) {
                                                        $resp->FORM_CVALOR_RESPUESTA = $_resp['USRE_CRESPUESTA'];
                                                        break;
                                                    }
                                                    break;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        $tramite        = $configuracion['tramite'][0];
                        $formularios    =  $configuracion['formularios'][0];
                        $nombreT = "Refrendo al Padrón de Proveedores y Prestadores de Servicios del Poder Ejecutivo del Estado de Querétaro (Personas Físicas)";
                        $nombreT2 = "Refrendo al Padrón de Proveedores y Prestadores de Servicios del Poder Ejecutivo del Estado de Querétaro (Persona Moral)";
                        $nombreT3 = "Inscripción al Padrón de Proveedores y Prestadores de Servicios del Poder Ejecutivo del Estado de Querétaro (Persona moral)";
                        $nombreT4 = "Inscripción al Padrón de Proveedores y Prestadores de Servicios del Poder Ejecutivo del Estado de Querétaro (Persona física)";
                        
                        //Creacion de pdf
                        $pdf = app('dompdf.wrapper');
                        $pdf->getDomPDF()->set_option("enable_php", true);
                        $pdf->setPaper("letter", "portrait");
                        //$pdf->loadHTML('<h1>Styde.net</h1>');
                        
                        if(($tramite->USTR_CNOMBRE_TRAMITE == $nombreT) || ($tramite->USTR_CNOMBRE_TRAMITE == $nombreT2) || ($tramite->USTR_CNOMBRE_TRAMITE == $nombreT3) || ($tramite->USTR_CNOMBRE_TRAMITE == $nombreT4) ){
                            $pdf->loadView('TEMPLATE.FORMULARIO_REFRENDO', compact('tramite', 'formularios', 'arrayPer'));
                        }else{
                            $pdf->loadView('TEMPLATE.REPORTE_FORMULARIO', compact('tramite', 'formulsarios', 'arrayPer'));
                        }
                        //return $pdf->download('Formulario.pdf');
        
                        //Se guardar el pdf
                        $pathPdf        = public_path('tramites');
                        $fileNamePdf    = Str::random(8) . '.pdf';
                        if(!File::isDirectory($pathPdf)) {
                            if(!File::makeDirectory($pathPdf, $mode = 0777, true, true))
                                $response = false;
                        }
        
                        $pdf->save($pathPdf . '/' . $fileNamePdf);
            
                        $zip = new ZipArchive();
                        $fecha = Carbon::now();
                        $fecha = $fecha->toArray();
                        $fecha = $fecha['timestamp'];
                        $folio = explode('/', $tramite->USTR_CFOLIO);
                        $folio = $folio[0] . '_' . $folio[1];
                        $fileName = 'TRAM_' . $folio. '_'.$tramite->USTR_CRFC . '.zip';
                        //$fileName = 'TRAM_' . $tramite->USTR_CRFC  . '.zip';
                        //$fileName = 'TRAM_' . $folio. '.zip';
                        $listDocumentos = DB::select('SELECT * FROM tram_mdv_usuariordocumento WHERE USDO_NIDUSUARIOTRAMITE = ?', array($id->USTR_NIDUSUARIOTRAMITE));
                        $listResolutivos = DB::select('SELECT * FROM tram_mdv_usuario_resolutivo WHERE USRE_NIDUSUARIOTRAMITE = ?', array($id->USTR_NIDUSUARIOTRAMITE));
                        if ($zip->open($pathPdf."/".$fileName, ZipArchive::CREATE) == TRUE) {
        
                            //Agregamos formulario
                            $zip->addFile($pathPdf."/".$fileNamePdf, 'FORMULARIO_' . $folio . '.pdf');
            
                            //Agregar documentos al zip
                            foreach ($listDocumentos as $key => $value) {
            
                                if ($value->USDO_CRUTADOC != null && $value->USDO_CRUTADOC != "") {
                                    if (file_exists(public_path($value->USDO_CRUTADOC))) {
                                        $fileNameDocumento = $value->USDO_CDOCNOMBRE . '.' . $value->USDO_CEXTENSION;
                                        $zip->addFile(public_path($value->USDO_CRUTADOC), $fileNameDocumento);
                                    }
                                }
                            }
            
                            //Agregar resolutivos
                            foreach ($listResolutivos as $key => $value) {
                                if ($value->USRE_CRUTADOC != null && $value->USRE_CRUTADOC != "") {
                                    if (file_exists(public_path($value->USRE_CRUTADOC))) {
                                        $fileNameDocumento = "R-" . $value->USRE_NIDUSUARIO_RESOLUTIVO . '.' . $value->USRE_CEXTENSION;
                                        $zip->addFile(public_path($value->USRE_CRUTADOC), $fileNameDocumento);
                                    }
                                }
                            }
                            $zip->close();
                        }
                        $zipPrincipal->addFile($pathPdf."/".$fileName, $fileName);
                        File::delete($pathPdf . '/' . $fileNamePdf);
                        array_push($archivosBorrar, $fileName);
                        
                    }
                    $zipPrincipal->close();
                    foreach ($archivosBorrar as $key => $nombre) {
                        File::delete($pathPdf . '/' . $nombre);
                    }
                    
                    
                }
                
                $response = [ 'name' => 'tramites/'.$fileNamePrincipal, 'status' => 'success'];
                return response()->json($response);
                } catch (\Throwable $th) {
                    echo $th;
                    //dd($ex->getMessage());
                    /*$response = [ 'name' => '', 'status' => $th];
                    return response()->json($response);*/
                }
        }else{
            $response = [ 'name' => '', 'status' => 'info'];
            return response()->json($response);
        }
        
    }
}
