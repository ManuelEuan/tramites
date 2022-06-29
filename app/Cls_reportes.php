<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class Cls_reportes extends Model
{
    static function obtenernombrerolreporte($id){
        return DB::select('call obtenernombrerolreporte(?)'
        , array($id));
    }

    static function obtenerprimerreporteadmincon(){
        return DB::select(
            'call obtenerprimerreporteadmincon()'
        );
    }

    static function determinardependenciausuario($id){
        /*return DB::select('call determinardependenciausuario(?)'
        , array($id));*/
        $result = DB::table('tram_aux_dependencia_usuario_pertenece')
        ->select('DEPUP_NIDDEPENCIA')->where('DEPUP_NIDUSUARIO','=',$id)->take(1)->get();
        $id_dep = isset($result[0]) ? $result[0]->DEPUP_NIDDEPENCIA : 0;
        return $id_dep;
    }

    static function reporte_enlace_adminct_editor($id){
        return DB::select('call reporte_enlace_adminct_editor(?)'
        , array($id));
    }

    static function obtener_reporte_tipo_tramite($rol, $init_date, $finish_date, $id_usuario){
        $result = '';
        if($rol == 'Administrador' || $rol == 'Consultor'){
            $result = DB::table('tram_mdv_usuariotramite as usr_tram')
            ->join('tram_mst_tramite as tram', 'usr_tram.USTR_NIDTRAMITE', '=', 'tram.TRAM_NIDTRAMITE')
            ->select(
                'usr_tram.USTR_CFOLIO',
                'usr_tram.created_at',
                'usr_tram.updated_at',
                'tram.TRAM_CNOMBRE',
                'tram.TRAM_NIDTRAMITE',
                'tram.TRAM_CUNIDADADMINISTRATIVA',
                'usr_tram.USTR_NBANDERA_PROCESO'
            )->whereBetween('usr_tram.updated_at', [$init_date, date("Y-m-d",strtotime($finish_date."+ 1 days"))])->get();
        }elseif($rol == 'Enlace Oficial' || $rol == 'Admin-CT' || $rol == 'Editor'){
            $dependencia = $this->determinardependenciausuario($id_usuario);
            $result = DB::table('tram_mdv_usuariotramite as usr_tram')
            ->join('tram_mst_tramite as tram', 'usr_tram.USTR_NIDTRAMITE', '=', 'tram.TRAM_NIDTRAMITE')
            ->select(
                'usr_tram.USTR_CFOLIO',
                'usr_tram.created_at',
                'usr_tram.updated_at',
                'tram.TRAM_CNOMBRE',
                'tram.TRAM_NIDTRAMITE',
                'tram.TRAM_CUNIDADADMINISTRATIVA',
                'usr_tram.USTR_NBANDERA_PROCESO'
            )->where('tram.TRAM_NIDCENTRO','=',$dependencia)
            ->whereBetween('usr_tram.updated_at', [$init_date, date("Y-m-d",strtotime($finish_date."+ 1 days"))])->get();
        }

        return $result;
    }

    static function reporte_caracteristicas_funcionarios($rol, $init_date, $finish_date, $id_usuario){
        /*return DB::select(
            'call reporte_caracteristicas_funcionarios()'
        );*/
        $result = '';
        if($rol == 'Administrador' || $rol == 'Consultor'){
            $result = DB::table('tram_mst_usuario as usr')
            ->join('tram_cat_rol as rol', 'rol.ROL_NIDROL', '=', 'usr.USUA_NIDROL')
            ->join('tram_aux_dependencia_usuario_pertenece as aux_dep', 'aux_dep.DEPUP_NIDUSUARIO', '=', 'usr.USUA_NIDUSUARIO')
            ->select(
                'usr.USUA_NIDUSUARIO',
                'usr.USUA_CNOMBRES',
                'usr.USUA_CPRIMER_APELLIDO',
                'usr.USUA_CSEGUNDO_APELLIDO',
                'usr.USUA_CUSUARIO',
                'usr.USUA_CCORREO_ELECTRONICO',
                'usr.USUA_NACTIVO',
                'rol.ROL_CNOMBRE',
                'usr.created_at')
            ->where('usr.USUA_NIDROL','<>',2)
            ->whereBetween('usr.created_at', [$init_date, date("Y-m-d",strtotime($finish_date."+ 1 days"))])->get();
        }elseif($rol == 'Enlace Oficial' || $rol == 'Admin-CT' || $rol == 'Editor'){
            $dependencia = $this->determinardependenciausuario($id_usuario);
            $result = DB::table('tram_mst_usuario as usr')
            ->join('tram_cat_rol as rol', 'rol.ROL_NIDROL', '=', 'usr.USUA_NIDROL')
            ->join('tram_aux_dependencia_usuario_pertenece as aux_dep', 'aux_dep.DEPUP_NIDUSUARIO', '=', 'usr.USUA_NIDUSUARIO')
            ->select(
                'usr.USUA_NIDUSUARIO',
                'usr.USUA_CNOMBRES',
                'usr.USUA_CPRIMER_APELLIDO',
                'usr.USUA_CSEGUNDO_APELLIDO',
                'usr.USUA_CUSUARIO',
                'usr.USUA_CCORREO_ELECTRONICO',
                'usr.USUA_NACTIVO',
                'rol.ROL_CNOMBRE',
                'usr.created_at')
            ->where('aux_dep.DEPUP_NIDDEPENCIA','=',$dependencia)->where('usr.USUA_NIDROL','<>',2)
            ->whereBetween('usr.created_at', [$init_date, date("Y-m-d",strtotime($finish_date."+ 1 days"))])->get();
        }
        foreach($result as $usr){
            //obtenemos la unidad administrativa
            $unidad = DB::table('tram_aux_unidad_usuario_pertenece as usr_unid')
            ->select('usr_unid.UNIDUP_NIDUNIDAD')->where('usr_unid.UNIDUP_NIDUSUARIO', '=', $usr->USUA_NIDUSUARIO)->get();
            
            $usr->UNIDAD = isset($unidad[0]) ? $unidad[0]->UNIDUP_NIDUNIDAD : 0;

            //obtenemos la secretaria
            $secretaria = DB::table('tram_aux_dependencia_usuario_pertenece as usr_edif')
            ->select('usr_edif.DEPUP_NIDDEPENCIA')->where('usr_edif.DEPUP_NIDUSUARIO', '=', $usr->USUA_NIDUSUARIO)->get();
            $usr->EDIFICIO = isset($secretaria[0]) ? $secretaria[0]->DEPUP_NIDDEPENCIA : 0;
        }
        return $result;
    }

    static function reporte_caracteristicas_fciudadanos($rol, $init_date, $finish_date, $id_usuario){
        /*return DB::select(
            'call reporte_caracteristicas_fciudadanos()'
        );*/
        $result = DB::table('tram_mst_usuario as usr')
        ->select('usr.USUA_NIDUSUARIO', 'usr.USUA_NTIPO_SEXO', 'usr.USUA_NTIPO_PERSONA', 'usr.created_at')
        ->where('usr.USUA_NIDROL','=',2)
        ->whereBetween('usr.created_at', [$init_date, date("Y-m-d",strtotime($finish_date."+ 1 days"))])->get();
        return $result;
    }

    static function dependencia_con_tramites($rol, $init_date, $finish_date, $id_usuario){
        /*return DB::select(
            'call dependencia_con_tramites()'
        );*/
        $result = '';
        if($rol == 'Administrador' || $rol == 'Consultor'){
            $result = DB::table('tram_mst_tramite as tram')
            ->select(
                'tram.TRAM_NIDCENTRO',
                'tram.TRAM_CCENTRO',
                'tram.TRAM_CUNIDADADMINISTRATIVA',
                'tram.TRAM_NIDTRAMITE',
                'tram.TRAM_CNOMBRE',
                'tram.created_at',
                'tram.updated_at'
            )->where('tram.TRAM_NIMPLEMENTADO', '=', 1)
            ->whereBetween('tram.created_at', [$init_date, date("Y-m-d",strtotime($finish_date."+ 1 days"))])->get();
        }elseif($rol == 'Enlace Oficial' || $rol == 'Admin-CT' || $rol == 'Editor'){
            $dependencia = $this->determinardependenciausuario($id_usuario);
            $result = DB::table('tram_mst_tramite as tram')
            ->select(
                'tram.TRAM_NIDCENTRO',
                'tram.TRAM_CCENTRO',
                'tram.TRAM_CUNIDADADMINISTRATIVA',
                'tram.TRAM_NIDTRAMITE',
                'tram.TRAM_CNOMBRE',
                'tram.created_at',
                'tram.updated_at'
            )->where('tram.TRAM_NIDCENTRO','=',$dependencia)->where('tram.TRAM_NIMPLEMENTADO', '=', 1)
            ->whereBetween('tram.created_at', [$init_date, date("Y-m-d",strtotime($finish_date."+ 1 days"))])->get();
        }
        
        foreach($result as $tram){
            //EDIFICIOS
            $edificios = "";
            $i = 1;
            $edi = DB::table('tram_mst_edificio')->select('EDIF_CNOMBRE')->where('EDIF_NIDTRAMITE','=',$tram->TRAM_NIDTRAMITE)->get();
            $total_edi = count($edi);
            foreach($edi as $ed){
                $coma = $total_edi == $i? '.':',';
                $edificios = $edificios.' '.$ed->EDIF_CNOMBRE.''.$coma;
                $i++;
            }
            $tram->edificios = $edificios;

            //Cantidad de módulos de pagos por trámite
            $tram->c_pagos = DB::table('tram_mdv_seccion_tramite')
            ->where([
                ['CONF_NIDTRAMITE', '=', $tram->TRAM_NIDTRAMITE],
                ['CONF_CNOMBRESECCION', 'like', '%Pago%']
            ])->count();

            //Cantidad de módulo de citas por trámite
            $tram->c_citas = DB::table('tram_mdv_seccion_tramite')
            ->where([
                ['CONF_NIDTRAMITE', '=', $tram->TRAM_NIDTRAMITE],
                ['CONF_CNOMBRESECCION', 'like', '%Citas%']
            ])->count();

            //Cantidad de módulos de ventanilla por trámite
            $tram->c_ventanilla = DB::table('tram_mdv_seccion_tramite')
            ->where([
                ['CONF_NIDTRAMITE', '=', $tram->TRAM_NIDTRAMITE],
                ['CONF_CNOMBRESECCION', 'like', '%Ventanilla%']
            ])->count();

            //Cantidad de módulos de resolutivo electrónico por trámite
            $tram->c_resolutivo = DB::table('tram_mdv_seccion_tramite')
            ->where([
                ['CONF_NIDTRAMITE', '=', $tram->TRAM_NIDTRAMITE],
                ['CONF_CNOMBRESECCION', 'like', '%Resolutivo%']
            ])->count();
        }

        return $result;
    }

    static function conteo_resolutivo($id){
        return DB::select('call conteo_resolutivo(?)'
        , array($id));
    }

    static function conteo_pagos($id){
        return DB::select('call conteo_pagos(?)'
        , array($id));
    }

    static function reporte_modulo_estado($rol, $init_date, $finish_date, $id_usuario){
        /*return DB::select(
            'call reporte_modulo_estado()'
        );*/
        //obtenemos el registro de ID y nombres de tramites
        $result = '';
        if($rol == 'Administrador' || $rol == 'Consultor'){
            $result = DB::table('tram_mdv_usuariotramite as tram_process')
            ->join('tram_mst_tramite as tram','tram_process.USTR_NIDTRAMITE','=','tram.TRAM_NIDTRAMITE')
            ->select(
                'tram_process.USTR_NIDTRAMITE',
                'tram.TRAM_CNOMBRE'
            )->whereBetween('tram_process.created_at', [$init_date, date("Y-m-d",strtotime($finish_date."+ 1 days"))])
            ->groupBy(['tram_process.USTR_NIDTRAMITE', 'tram.TRAM_CNOMBRE'])->get();
        }elseif($rol == 'Enlace Oficial' || $rol == 'Admin-CT' || $rol == 'Editor'){
            $dependencia = $this->determinardependenciausuario($id_usuario);
            $result = DB::table('tram_mdv_usuariotramite as tram_process')
            ->join('tram_mst_tramite as tram','tram_process.USTR_NIDTRAMITE','=','tram.TRAM_NIDTRAMITE')
            ->select(
                'tram_process.USTR_NIDTRAMITE',
                'tram.TRAM_CNOMBRE'
            )->where('tram.TRAM_NIDCENTRO','=',$dependencia)
            ->whereBetween('tram_process.created_at', [$init_date, date("Y-m-d",strtotime($finish_date."+ 1 days"))])
            ->groupBy(['tram_process.USTR_NIDTRAMITE', 'tram.TRAM_CNOMBRE'])->get();
        }

        foreach($result as $tram){
            //Total de iniciados
            $tram->total_iniciados = DB::table('tram_mdv_usuariotramite')
            ->where([
                ['USTR_NIDTRAMITE','=',$tram->USTR_NIDTRAMITE],
                ['USTR_NBANDERA_PROCESO','=',1]
            ])->count();

            //Total de cargas iniciales concluidas
            $tram->total_iniciados_concluidas = DB::table('tram_mdv_usuariotramite')
            ->where([
                ['USTR_NIDTRAMITE','=',$tram->USTR_NIDTRAMITE],
                ['USTR_NBANDERA_PROCESO','=',3]
            ])->count();

            //Total de subsanar información incompleta solicitadas
            $tram->total_info_incompleta_sol = DB::table('tram_mdv_usuariotramite')
            ->where([
                ['USTR_NIDTRAMITE','=',$tram->USTR_NIDTRAMITE],
                ['USTR_NBANDERA_PROCESO','=',6]
            ])->count();

            //Total de subsanar información incompleta finalizadas
            $tram->total_info_incompleta_fin = DB::table('tram_mdv_usuariotramite')
            ->where([
                ['USTR_NIDTRAMITE','=',$tram->USTR_NIDTRAMITE],
                ['USTR_NBANDERA_PROCESO','=',4]
            ])->count();

            //Total de pagos válidos
            $tram->total_pagos_validos = 'Sin Datos.';

            //Tota de citas programadas
            $tram->total_citas_programadas = DB::table('tram_mdv_usuariotramite as tram_process')
            ->join('tram_aux_citas_reservadas as citas', 'citas.CITA_IDUSUARIO', '=','tram_process.USTR_NIDUSUARIO')
            ->where([
                ['tram_process.USTR_NIDTRAMITE','=',$tram->USTR_NIDTRAMITE],
                ['citas.CITA_STATUS','=',1],
                ['tram_process.USTR_NBANDERA_PROCESO','=',7]
            ])->groupBy('citas.idtram_aux_citas_reservadas')->count();

            //Tota de citas realizadas
            $tram->total_citas_realizadas = DB::table('tram_mdv_usuariotramite as tram_process')
            ->join('tram_aux_citas_reservadas as citas', 'citas.CITA_IDUSUARIO', '=','tram_process.USTR_NIDUSUARIO')
            ->where([
                ['tram_process.USTR_NIDTRAMITE','=',$tram->USTR_NIDTRAMITE],
                ['citas.CITA_STATUS','=',2],
                ['tram_process.USTR_NBANDERA_PROCESO','>',6]//estado En proceso en adelante
            ])->groupBy('citas.idtram_aux_citas_reservadas')->count();
            
            //Total de ventanilla sin cita válidas
            $tram->total_vent_sin_cita = DB::table('tram_mdv_usuariotramite')
            ->where([
                ['USTR_NIDTRAMITE','=',$tram->USTR_NIDTRAMITE],
                ['USTR_NBANDERA_PROCESO','=',7],
                ['USTR_CMODULO','!=', NULL],
            ])->count();

            //Total de resolutivo electrónico emitidos
            $tram->total_resolutivo = DB::table('tram_mdv_usuariotramite as tram_process')
            ->join('tram_mdv_usuario_resolutivo as resolutivo', 'resolutivo.USRE_NIDUSUARIOTRAMITE', '=','tram_process.USTR_NIDUSUARIO')
            ->where([
                ['tram_process.USTR_NIDTRAMITE','=',$tram->USTR_NIDTRAMITE],
                ['tram_process.USTR_NBANDERA_PROCESO','>',6]//estado En proceso en adelante
            ])->groupBy('resolutivo.USRE_NIDUSUARIO_RESOLUTIVO')->count();

            //Total de trámites no finalizados
            $tram->total_no_finalizados = DB::table('tram_mdv_usuariotramite')
            ->where([
                ['USTR_NIDTRAMITE','=',$tram->USTR_NIDTRAMITE],
                ['USTR_NBANDERA_PROCESO','>',7]//despues de estado En proceso en adelante
            ])->count();

            //Total de trámites finalizados
            $tram->total_finalizados = DB::table('tram_mdv_usuariotramite')
            ->where([
                ['USTR_NIDTRAMITE','=',$tram->USTR_NIDTRAMITE],
                ['USTR_NBANDERA_PROCESO','=',8]
            ])->count();
        }
        return $result;
    }

    static function reporte_modulo_estado_tiniciado($id){
        return DB::select('call reporte_modulo_estado_tiniciado(?)'
        , array($id));
    }

    static function reporte_modulo_estado_tcarga($id){
        return DB::select('call reporte_modulo_estado_tcarga(?)'
        , array($id));
    }

    static function reporte_modulo_estado_tincompleta($id){
        return DB::select('call reporte_modulo_estado_tincompleta(?)'
        , array($id));
    }


    static function reporte_modulo_estado_tnofinalizados($id){
        return DB::select('call reporte_modulo_estado_tiniciado(?)'
        , array($id));
    }

    static function reporte_modulo_estado_tfinalizados($id){
        return DB::select('call reporte_modulo_estado_tiniciado(?)'
        , array($id));
    }

    static function reporte_campos_desplegados_contenido_tramites($rol, $init_date, $finish_date, $id_usuario){
        //obtenemos el registro principal
        $result = '';
        if($rol == 'Administrador' || $rol == 'Consultor'){
            $result = DB::table('tram_mdv_usuariotramite as usr_tram')
            ->join('tram_mst_tramite as tram', 'tram.TRAM_NIDTRAMITE', '=', 'usr_tram.USTR_NIDTRAMITE')
            ->select(
                'tram.TRAM_NIDTRAMITE',
                'tram.TRAM_CNOMBRE',
                'usr_tram.USTR_NIDUSUARIOTRAMITE',
                'tram.TRAM_CUNIDADADMINISTRATIVA',
                'tram.TRAM_CCENTRO',
                'tram.created_at',
                'tram.updated_at',
            )->whereBetween('tram.updated_at', [$init_date, date("Y-m-d",strtotime($finish_date."+ 1 days"))])
            ->get();
        }elseif($rol == 'Enlace Oficial' || $rol == 'Admin-CT' || $rol == 'Editor'){
            $dependencia = $this->determinardependenciausuario($id_usuario);
            $result = DB::table('tram_mdv_usuariotramite as usr_tram')
            ->join('tram_mst_tramite as tram', 'tram.TRAM_NIDTRAMITE', '=', 'usr_tram.USTR_NIDTRAMITE')
            ->select(
                'tram.TRAM_NIDTRAMITE',
                'tram.TRAM_CNOMBRE',
                'usr_tram.USTR_NIDUSUARIOTRAMITE',
                'tram.TRAM_CUNIDADADMINISTRATIVA',
                'tram.TRAM_CCENTRO',
                'tram.created_at',
                'tram.updated_at',
            )->where('tram.TRAM_NIDCENTRO','=',$dependencia)
            ->whereBetween('tram.updated_at', [$init_date, date("Y-m-d",strtotime($finish_date."+ 1 days"))])
            ->get();
        }

        
        //obtenemos los detalles de conteo
        foreach($result as $tram){
            //Tiene módulo de pagos y Número de módulos de pagos
            $tram->num_pagos = DB::table('tram_aux_seccion_seguimiento_tramite')
            ->where([
                ['SSEGTRA_NIDUSUARIOTRAMITE', '=', $tram->USTR_NIDUSUARIOTRAMITE],
                ['SSEGTRA_CNOMBRE_SECCION', 'like', '%Pago%']
            ])->count();

            //Tiene módulo de citas Número de módulos de citas
            $tram->num_citas = DB::table('tram_aux_seccion_seguimiento_tramite')
            ->where([
                ['SSEGTRA_NIDUSUARIOTRAMITE', '=', $tram->USTR_NIDUSUARIOTRAMITE],
                ['SSEGTRA_CNOMBRE_SECCION', 'like', '%Citas%']
            ])->count();

            //Tiene módulo de ventanilla y Número de módulos de ventanilla
            $tram->num_ventanilla = DB::table('tram_aux_seccion_seguimiento_tramite')
            ->where([
                ['SSEGTRA_NIDUSUARIOTRAMITE', '=', $tram->USTR_NIDUSUARIOTRAMITE],
                ['SSEGTRA_CNOMBRE_SECCION', 'like', '%Ventanilla%']
            ])->count();

            //Tiene resolutivo electrónico y Número de módulos de resolutivos
            $tram->num_resolutivo = DB::table('tram_aux_seccion_seguimiento_tramite')
            ->where([
                ['SSEGTRA_NIDUSUARIOTRAMITE', '=', $tram->USTR_NIDUSUARIOTRAMITE],
                ['SSEGTRA_CNOMBRE_SECCION', 'like', '%Resolutivo%']
            ])->count();
        }

        
        return $result;
    }

    static function reporte_encuesta_satisfaccion($rol, $init_date, $finish_date, $id_usuario){
        /*return DB::select('call reporte_encuesta_satisfaccion(?,?)'
        , array($init_date, $finish_date));*/
        $result = '';
        if($rol == 'Administrador' || $rol == 'Consultor'){
            $result = DB::table('tram_his_encuesta_satisfaccion as encuesta')
            ->join('tram_mdv_usuariotramite as usr_tram', 'usr_tram.USTR_NIDUSUARIOTRAMITE','=','encuesta.HENCS_NIDUSUARIOTRAMITE')
            ->join('tram_mst_tramite as tram','tram.TRAM_NIDTRAMITE','=','usr_tram.USTR_NIDTRAMITE')
            ->select(
                'usr_tram.USTR_NIDTRAMITE',
                'encuesta.created_at',
                'tram.TRAM_CNOMBRE',
                'usr_tram.USTR_CMODULO',
                'tram.TRAM_CCENTRO',
                'tram.TRAM_CUNIDADADMINISTRATIVA',
                'usr_tram.USTR_CMUNICIPIO',
                'encuesta.HENCS_CPRESPUESTA',
                'encuesta.HENCS_CPREGUNTA'
            )->whereBetween('usr_tram.updated_at', [$init_date, date("Y-m-d",strtotime($finish_date."+ 1 days"))])->get();
        }elseif($rol == 'Enlace Oficial' || $rol == 'Admin-CT' || $rol == 'Editor'){
            $dependencia = $this->determinardependenciausuario($id_usuario);
            $result = DB::table('tram_his_encuesta_satisfaccion as encuesta')
            ->join('tram_mdv_usuariotramite as usr_tram', 'usr_tram.USTR_NIDUSUARIOTRAMITE','=','encuesta.HENCS_NIDUSUARIOTRAMITE')
            ->join('tram_mst_tramite as tram','tram.TRAM_NIDTRAMITE','=','usr_tram.USTR_NIDTRAMITE')
            ->select(
                'usr_tram.USTR_NIDTRAMITE',
                'encuesta.created_at',
                'tram.TRAM_CNOMBRE',
                'usr_tram.USTR_CMODULO',
                'tram.TRAM_CCENTRO',
                'tram.TRAM_CUNIDADADMINISTRATIVA',
                'usr_tram.USTR_CMUNICIPIO',
                'encuesta.HENCS_CPRESPUESTA',
                'encuesta.HENCS_CPREGUNTA'
            )->where('tram.TRAM_NIDCENTRO','=',$dependencia)
            ->whereBetween('usr_tram.updated_at', [$init_date, date("Y-m-d",strtotime($finish_date."+ 1 days"))])->get();
        }

        return $result;
    }
}



?>