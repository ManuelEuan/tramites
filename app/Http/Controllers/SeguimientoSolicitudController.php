<?php

namespace App\Http\Controllers;

use App\Cls_Usuario_Tramite;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Services\TramiteService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SeguimientoSolicitudController extends Controller
{
    public function index()
    {
        return view('MST_SEGUIMIENTO.index');
    }

    public function consultar(Request $request) {
        $servicio   = new TramiteService();
        $data       = $servicio->consultarSeguimiento($request);
        //$data       = Cls_Usuario_Tramite::TRAM_SP_CONSULTAR_SEGUIMIENTO_TRAMITE_USUARIO(Auth::user()->USUA_NIDUSUARIO, $request->txtNombre, $request->cmbEstatus, $request->cmbDependenciaEntidad, $request->dteFechaInicio);
        
        foreach ($data as $key => $t) {
            $diasH = $t->USTR_NDIASHABILESRESOLUCION;
            $hoy = date('Y-m-d');
            $fechaFinal = date('Y-m-d', strtotime($t->USTR_DFECHACREACION. ' + '.$diasH.' days'));
            if($t->USTR_NESTATUS == 4){ 
                if(!empty($t->USTR_DFECHAESTATUS)){
                    $diasN = $t->USTR_NDIASHABILESNOTIFICACION;
                    $fechaFinalNotificacion = date('Y-m-d', strtotime($t->USTR_DFECHAESTATUS. ' + '.$diasN.' days'));
                    if($hoy > $fechaFinalNotificacion){
                        Cls_Usuario_Tramite::ACTUALIZAR_STATUS($t->USTR_CFOLIO);
                    }
                }elseif($t->USTR_NESTATUS != 10){
                    /* if($hoy > $fechaFinal){
                        //$tramite_seguimiento->ACTUALIZAR_STATUS($t->USTR_CFOLIO);
                    }*/
                }
            }else{
                /*if($hoy > $fechaFinal){
                    Cls_Usuario_Tramite::ACTUALIZAR_STATUS_VENCIDO($t->USTR_CFOLIO);
                }*/
            }
        }

        /* $response = [
            'data' =>  Cls_Usuario_Tramite::TRAM_SP_CONSULTAR_SEGUIMIENTO_TRAMITE_USUARIO(70, $request->txtNombre, $request->cmbEstatus, $request->cmbDependenciaEntidad, $request->dteFechaInicio),
        ]; */

        return response()->json($data);
    }

    public function obtener_dependencias_unidad()
    {
        $collection = collect();

        for ($i = 0; $i < 5; $i++) {
            $data = [
                'id' => $i + 1,
                'nombre' => "Dependencia " . ($i + 1)
            ];
            $collection->push($data);
        }

        return Response()->json($collection);
    }

    public function obtener_detalle_seguimiento()
    {

        $tramite = [];
        $tramite['nombre'] = "Expedici??n de licencia de conducir para chofer particular (renovaci??n)";
        $tramite['responsable'] = "Fiscal??a General del Estado de Chihuahua";
        $tramite['descripcion'] = "Es la autorizaci??n que expide la Fiscal??a General del Estado para conducir veh??culos particulares destinados al
        transporte hasta de veintid??s plazas y con peso m??ximo de diez toneladas, una vez que ha concluido su vigencia o en caso de perdida; previo
        cumplimiento de los requisitos previstos en la Ley de Vialidad y Tr??nsito para el Estado de Chihuahua.";

        $tramite['oficinas'] = [
            [
                "id" => 1,
                "nombre"=> "Delegaci??n regional",
                "direccion"=> "Morelos y 23, #2300 17",
                "horario"=> "Lunes a viernes: 8:00 a 15:00 horas.",
                "latitud"=> 0,
                "longitud"=> 0,
                "responsable"=> "Johnny Depp",
                "contacto_telefono"=> "9911229988 Ext. 123, 456",
                "contacto_email"=> "Jhon_Deep@gmail.com",
                "informacion_adicional"=> "Acudir con cubrebocas para su atenci??n. Ok",
            ],
            [
                "id" => 2,
                "nombre"=> "M??dulo Ni??os H??roes",
                "direccion"=> "Palacio Mitla 2 , locales 4, 5 y 6, #1151 37",
                "horario"=> "Lunes a viernes: 8:00 a 15:00 horas.",
                "latitud"=> 0,
                "longitud"=> 0,
                "responsable"=> "Juan Bautista Pascasio Escutia y Mart??nez",
                "contacto_telefono"=> "9911229988 Ext. 123, 456",
                "contacto_email"=> "juan_bandera@gmail.com",
                "informacion_adicional"=> "Acudir con cubrebocas para su atenci??n. Oki",
            ],
            [
                "id" => 3,
                "nombre"=> "M??dulo de Licencias Mitla",
                "direccion"=> "Palacio Mitla 6 , locales 4, 5 y 6, #1151 37",
                "horario"=> "Lunes a viernes: 8:00 a 15:00 horas.",
                "latitud"=> 0,
                "longitud"=> 0,
                "responsable"=> "Michael Jackson",
                "contacto_telefono"=> "9911229988 Ext. 123, 456",
                "contacto_email"=> "mike@gmail.com",
                "informacion_adicional"=> "Acudir con cubrebocas para su atenci??n. Va",
            ],
        ];

        $tramite['informacion_general'] = [
            [
                "titulo"=> "Periodo en que puedo realizar el tr??mite",
                "descripcion"=> "02/01/2020 al 31/12/2020",
                "opciones" => [],
            ],
            [
                "titulo"=> "Usuario a quien est?? dirigido el tr??mite:",
                "descripcion"=> "Persona mayor de edad que quiera renovar su licencia.",
                "opciones" => [],
            ],
            [
                "titulo"=> "Tipo de persona:",
                "descripcion"=> "F??sica",
                "opciones" => [],
            ],
            [
                "titulo"=> "Tipo de documento entregado:",
                "descripcion"=> "Licencia de conducir.",
                "opciones" => [],
            ],
            [
                "titulo"=> "Tiempo h??bil promedio de resoluci??n:",
                "descripcion"=> "20 minutos",
                "opciones" => [],
            ],
            [
                "titulo"=> "Vigencias de los documentos:",
                "descripcion"=> "1, 3 o 6 a??os.",
                "opciones" => [],
            ],
            [
                "titulo"=> "Audiencia",
                "descripcion"=> "General",
                "opciones" => [],
            ],
            [
                "titulo"=> "Clasificaci??n",
                "descripcion"=> "Seguridad, legalidad y justicia",
                "opciones" => [],
            ],
            [
                "titulo"=> "Beneficio del usuario:",
                "descripcion"=> "Al tener la licencia de conducir, le autoriza conducir veh??culos particulares con peso m??ximo de diez toneladas.",
                "opciones" => [],
            ],
            [
                "titulo"=> "Derechos del usuario:",
                "descripcion"=> "Circular en la v??a p??blica en el tipo de veh??culo que corresponda a la modalidad mencionada en la licencia de conducir.",
                "opciones" => [],
            ]
        ];

        $tramite['requerimientos'] = [
            [
                "titulo" => "Casos en que se debe realizar el tr??mite:",
                "descripcion" => "En caso de renovaci??n, robo o extrav??o de licencia.",
                "opciones" => [],
                "documentos" => []
            ],
            [
                "titulo" => "Requisitos:",
                "descripcion" => "",
                "opciones" => [
                    "1. Ser mayor de edad.",
                    "2. Aprobar el examen m??dico de aptitudes f??sicas y mentales para la conducci??n.",
                    "Si la licencia es ".'"Polaroid"'.", deber?? realizar el tr??mite de Expedici??n de licencia de conducir para primera vez, cumpliendo con toda la documentaci??n y requisitos respectivos."
                ],
                "documentos" => []
            ],
            [
                "titulo" => "Documentos requeridos:",
                "descripcion" => "",
                "opciones" => [],
                "documentos" => [
                    [
                        "nombre"=> "FM3 o FM2",
                        "presentacion"=> "Original",
                        "observaciones"=> "??nicamente en caso de personas extranjeras.",
                    ],
                    [
                        "nombre"=> "Acta de nacimiento",
                        "presentacion"=> "Original",
                        "observaciones"=> "En caso que la licencia sea for??nea, federal o extranjera.",
                    ],
                    [
                        "nombre"=> "Licencia de conducir",
                        "presentacion"=> "Original vencida",
                        "observaciones"=> "De tramitar por robo, deber?? presentar el Reporte de extrav??o de documento o la denuncia, expedido por la Fiscal??a de Distrito por Zona.",
                    ],
                    [
                        "nombre"=> "Comprobante de domicilio",
                        "presentacion"=> "Original",
                        "observaciones"=> "A su nombre, de fecha de expedici??n no mayor a 3 meses (agua, luz, tel??fono, gas o predial). En caso de no estar a su nombre, acompa??arlo
                        de alg??n estado de cuenta bancario, servicio de tv por cable, estado de cuenta de tienda departamental u otro comprobante que llegue al domicilio a su nombre.",
                    ]
                ]
            ],
            [
                "titulo" => "??Puede hacer el tr??mite alguien m??s?:",
                "descripcion" => "No",
                "opciones" => [],
                "documentos" => []
            ],
            [
                "titulo" => "Casos de rechazo:",
                "descripcion" => "Falta de documentaci??n, por no saber leer ni escribir, por mandato judicial, en caso de comprobar que ha dejado de tener la aptitud f??sica y/o mental para
                conducir, cuando se comprueba que la informaci??n proporcionada para la obtenci??n de la Licencia de Conducir es falsa o que algunos de los documentos exhibidos sean falsificados.",
                "opciones" => [],
                "documentos" => []
            ]
        ];

        $tramite['en_linea'] = [
            [
                "titulo"=> "Tiempo promedio de espera en fila",
                "descripcion"=> "5 minutos.",
                "opciones" => [],
                "documentos" => []
            ],
            [
                "titulo"=> "??Hay informaci??n en l??nea?:",
                "descripcion"=> "No",
                "opciones" => [],
                "documentos" => []
            ],
            [
                "titulo"=> "??Se pueden recibir solicitudes en l??nea?:",
                "descripcion"=> "No",
                "opciones" => [],
                "documentos" => []
            ],
            [
                "titulo"=> "Solicitud en l??nea ??Requiere formato?:",
                "descripcion"=> "No",
                "opciones" => [],
                "documentos" => []
            ]
        ];

        $tramite['costo'] = [
            [
                "titulo"=> "??Tiene costo?:",
                "descripcion"=> "Si",
                "opciones" => [],
                "documentos" => []
            ],
            [
                "titulo"=> "Costos",
                "descripcion"=> "",
                "opciones" => ["Con vigencia a 6 a??os: $1,412 MXN", "Con vigencia a 3 a??os: $1,053 MXN", "Con vigencia a 1 a??os: $417 MXN"],
                "documentos" => []
            ],
            [
                "titulo"=> "Oficinas donde se puede realizar el pago:",
                "descripcion"=> "",
                "opciones" => [],
                "documentos" => []
            ]
        ];

        $tramite['fundamento_legal'] = [
            [
                "titulo" => "",
                "descripcion" => "",
                "opciones" => [],
                "adicional" => [
                    [
                        "titulo" => " Fundamento que da origen al tr??mite",
                        "descripcion" => "Ley de Vialidad y Tr??nsito para el Estado de Chihuahua",
                        "opciones" => []
                    ],
                    [
                        "titulo" => "Costo",
                        "descripcion" => "Ley de Ingresos para el Estado de Chihuahua para el Ejercicio Fiscal 2020",
                        "opciones" => []
                    ],
                ]
            ],
        ];

        return view('MST_SEGUIMIENTO.DET_SEGUIMIENTO', compact('tramite'));
    }

    public function detalle_notificacion()
    {
        $tramite = [];
        $tramite['nombre'] = "Expedici??n de licencia de conducir para chofer particular (renovaci??n)";
        $tramite['responsable'] = "Fiscal??a General del Estado de Chihuahua";
        $tramite['descripcion'] = "Es la autorizaci??n que expide la Fiscal??a General del Estado para conducir veh??culos particulares destinados al
        transporte hasta de veintid??s plazas y con peso m??ximo de diez toneladas, una vez que ha concluido su vigencia o en caso de perdida; previo
        cumplimiento de los requisitos previstos en la Ley de Vialidad y Tr??nsito para el Estado de Chihuahua.";

        $tramite['oficinas'] = [
            [
                "id" => 1,
                "nombre"=> "Delegaci??n regional",
                "direccion"=> "Morelos y 23, #2300 17",
                "horario"=> "Lunes a viernes: 8:00 a 15:00 horas.",
                "latitud"=> 0,
                "longitud"=> 0,
                "responsable"=> "Johnny Depp",
                "contacto_telefono"=> "9911229988 Ext. 123, 456",
                "contacto_email"=> "Jhon_Deep@gmail.com",
                "informacion_adicional"=> "Acudir con cubrebocas para su atenci??n. Ok",
            ],
            [
                "id" => 2,
                "nombre"=> "M??dulo Ni??os H??roes",
                "direccion"=> "Palacio Mitla 2 , locales 4, 5 y 6, #1151 37",
                "horario"=> "Lunes a viernes: 8:00 a 15:00 horas.",
                "latitud"=> 0,
                "longitud"=> 0,
                "responsable"=> "Juan Bautista Pascasio Escutia y Mart??nez",
                "contacto_telefono"=> "9911229988 Ext. 123, 456",
                "contacto_email"=> "juan_bandera@gmail.com",
                "informacion_adicional"=> "Acudir con cubrebocas para su atenci??n. Oki",
            ],
            [
                "id" => 3,
                "nombre"=> "M??dulo de Licencias Mitla",
                "direccion"=> "Palacio Mitla 6 , locales 4, 5 y 6, #1151 37",
                "horario"=> "Lunes a viernes: 8:00 a 15:00 horas.",
                "latitud"=> 0,
                "longitud"=> 0,
                "responsable"=> "Michael Jackson",
                "contacto_telefono"=> "9911229988 Ext. 123, 456",
                "contacto_email"=> "mike@gmail.com",
                "informacion_adicional"=> "Acudir con cubrebocas para su atenci??n. Va",
            ],
        ];

        $tramite['informacion_general'] = [
            [
                "titulo"=> "Periodo en que puedo realizar el tr??mite",
                "descripcion"=> "02/01/2020 al 31/12/2020",
                "opciones" => [],
            ],
            [
                "titulo"=> "Usuario a quien est?? dirigido el tr??mite:",
                "descripcion"=> "Persona mayor de edad que quiera renovar su licencia.",
                "opciones" => [],
            ],
            [
                "titulo"=> "Tipo de persona:",
                "descripcion"=> "F??sica",
                "opciones" => [],
            ],
            [
                "titulo"=> "Tipo de documento entregado:",
                "descripcion"=> "Licencia de conducir.",
                "opciones" => [],
            ],
            [
                "titulo"=> "Tiempo h??bil promedio de resoluci??n:",
                "descripcion"=> "20 minutos",
                "opciones" => [],
            ],
            [
                "titulo"=> "Vigencias de los documentos:",
                "descripcion"=> "1, 3 o 6 a??os.",
                "opciones" => [],
            ],
            [
                "titulo"=> "Audiencia",
                "descripcion"=> "General",
                "opciones" => [],
            ],
            [
                "titulo"=> "Clasificaci??n",
                "descripcion"=> "Seguridad, legalidad y justicia",
                "opciones" => [],
            ],
            [
                "titulo"=> "Beneficio del usuario:",
                "descripcion"=> "Al tener la licencia de conducir, le autoriza conducir veh??culos particulares con peso m??ximo de diez toneladas.",
                "opciones" => [],
            ],
            [
                "titulo"=> "Derechos del usuario:",
                "descripcion"=> "Circular en la v??a p??blica en el tipo de veh??culo que corresponda a la modalidad mencionada en la licencia de conducir.",
                "opciones" => [],
            ]
        ];

        $tramite['requerimientos'] = [
            [
                "titulo" => "Casos en que se debe realizar el tr??mite:",
                "descripcion" => "En caso de renovaci??n, robo o extrav??o de licencia.",
                "opciones" => [],
                "documentos" => []
            ],
            [
                "titulo" => "Requisitos:",
                "descripcion" => "",
                "opciones" => [
                    "1. Ser mayor de edad.",
                    "2. Aprobar el examen m??dico de aptitudes f??sicas y mentales para la conducci??n.",
                    "Si la licencia es ".'"Polaroid"'.", deber?? realizar el tr??mite de Expedici??n de licencia de conducir para primera vez, cumpliendo con toda la documentaci??n y requisitos respectivos."
                ],
                "documentos" => []
            ],
            [
                "titulo" => "Documentos requeridos:",
                "descripcion" => "",
                "opciones" => [],
                "documentos" => [
                    [
                        "nombre"=> "FM3 o FM2",
                        "presentacion"=> "Original",
                        "observaciones"=> "??nicamente en caso de personas extranjeras.",
                    ],
                    [
                        "nombre"=> "Acta de nacimiento",
                        "presentacion"=> "Original",
                        "observaciones"=> "En caso que la licencia sea for??nea, federal o extranjera.",
                    ],
                    [
                        "nombre"=> "Licencia de conducir",
                        "presentacion"=> "Original vencida",
                        "observaciones"=> "De tramitar por robo, deber?? presentar el Reporte de extrav??o de documento o la denuncia, expedido por la Fiscal??a de Distrito por Zona.",
                    ],
                    [
                        "nombre"=> "Comprobante de domicilio",
                        "presentacion"=> "Original",
                        "observaciones"=> "A su nombre, de fecha de expedici??n no mayor a 3 meses (agua, luz, tel??fono, gas o predial). En caso de no estar a su nombre, acompa??arlo
                        de alg??n estado de cuenta bancario, servicio de tv por cable, estado de cuenta de tienda departamental u otro comprobante que llegue al domicilio a su nombre.",
                    ]
                ]
            ],
            [
                "titulo" => "??Puede hacer el tr??mite alguien m??s?:",
                "descripcion" => "No",
                "opciones" => [],
                "documentos" => []
            ],
            [
                "titulo" => "Casos de rechazo:",
                "descripcion" => "Falta de documentaci??n, por no saber leer ni escribir, por mandato judicial, en caso de comprobar que ha dejado de tener la aptitud f??sica y/o mental para
                conducir, cuando se comprueba que la informaci??n proporcionada para la obtenci??n de la Licencia de Conducir es falsa o que algunos de los documentos exhibidos sean falsificados.",
                "opciones" => [],
                "documentos" => []
            ]
        ];

        $tramite['en_linea'] = [
            [
                "titulo"=> "Tiempo promedio de espera en fila",
                "descripcion"=> "5 minutos.",
                "opciones" => [],
                "documentos" => []
            ],
            [
                "titulo"=> "??Hay informaci??n en l??nea?:",
                "descripcion"=> "No",
                "opciones" => [],
                "documentos" => []
            ],
            [
                "titulo"=> "??Se pueden recibir solicitudes en l??nea?:",
                "descripcion"=> "No",
                "opciones" => [],
                "documentos" => []
            ],
            [
                "titulo"=> "Solicitud en l??nea ??Requiere formato?:",
                "descripcion"=> "No",
                "opciones" => [],
                "documentos" => []
            ]
        ];

        $tramite['costo'] = [
            [
                "titulo"=> "??Tiene costo?:",
                "descripcion"=> "Si",
                "opciones" => [],
                "documentos" => []
            ],
            [
                "titulo"=> "Costos",
                "descripcion"=> "",
                "opciones" => ["Con vigencia a 6 a??os: $1,412 MXN", "Con vigencia a 3 a??os: $1,053 MXN", "Con vigencia a 1 a??os: $417 MXN"],
                "documentos" => []
            ],
            [
                "titulo"=> "Oficinas donde se puede realizar el pago:",
                "descripcion"=> "",
                "opciones" => [],
                "documentos" => []
            ]
        ];

        $tramite['fundamento_legal'] = [
            [
                "titulo" => "",
                "descripcion" => "",
                "opciones" => [],
                "adicional" => [
                    [
                        "titulo" => " Fundamento que da origen al tr??mite",
                        "descripcion" => "Ley de Vialidad y Tr??nsito para el Estado de Chihuahua",
                        "opciones" => []
                    ],
                    [
                        "titulo" => "Costo",
                        "descripcion" => "Ley de Ingresos para el Estado de Chihuahua para el Ejercicio Fiscal 2020",
                        "opciones" => []
                    ],
                ]
            ],
        ];
        return view('MST_SEGUIMIENTO.DET_NOTIFICACION', compact('tramite'));
    }

    public function consultar_ventanilla()
    {
        $tramite = [];
        $tramite['nombre'] = "Expedici??n de licencia de conducir para chofer particular (renovaci??n)";
        $tramite['responsable'] = "Fiscal??a General del Estado de Chihuahua";
        $tramite['descripcion'] = "Es la autorizaci??n que expide la Fiscal??a General del Estado para conducir veh??culos particulares destinados al
        transporte hasta de veintid??s plazas y con peso m??ximo de diez toneladas, una vez que ha concluido su vigencia o en caso de perdida; previo
        cumplimiento de los requisitos previstos en la Ley de Vialidad y Tr??nsito para el Estado de Chihuahua.";

        $tramite['oficinas'] = [
            [
                "id" => 1,
                "nombre"=> "Delegaci??n regional",
                "direccion"=> "Morelos y 23, #2300 17",
                "horario"=> "Lunes a viernes: 8:00 a 15:00 horas.",
                "latitud"=> 0,
                "longitud"=> 0,
                "responsable"=> "Johnny Depp",
                "contacto_telefono"=> "9911229988 Ext. 123, 456",
                "contacto_email"=> "Jhon_Deep@gmail.com",
                "informacion_adicional"=> "Acudir con cubrebocas para su atenci??n. Ok",
            ],
            [
                "id" => 2,
                "nombre"=> "M??dulo Ni??os H??roes",
                "direccion"=> "Palacio Mitla 2 , locales 4, 5 y 6, #1151 37",
                "horario"=> "Lunes a viernes: 8:00 a 15:00 horas.",
                "latitud"=> 0,
                "longitud"=> 0,
                "responsable"=> "Juan Bautista Pascasio Escutia y Mart??nez",
                "contacto_telefono"=> "9911229988 Ext. 123, 456",
                "contacto_email"=> "juan_bandera@gmail.com",
                "informacion_adicional"=> "Acudir con cubrebocas para su atenci??n. Oki",
            ],
            [
                "id" => 3,
                "nombre"=> "M??dulo de Licencias Mitla",
                "direccion"=> "Palacio Mitla 6 , locales 4, 5 y 6, #1151 37",
                "horario"=> "Lunes a viernes: 8:00 a 15:00 horas.",
                "latitud"=> 0,
                "longitud"=> 0,
                "responsable"=> "Michael Jackson",
                "contacto_telefono"=> "9911229988 Ext. 123, 456",
                "contacto_email"=> "mike@gmail.com",
                "informacion_adicional"=> "Acudir con cubrebocas para su atenci??n. Va",
            ],
        ];

        $tramite['informacion_general'] = [
            [
                "titulo"=> "Periodo en que puedo realizar el tr??mite",
                "descripcion"=> "02/01/2020 al 31/12/2020",
                "opciones" => [],
            ],
            [
                "titulo"=> "Usuario a quien est?? dirigido el tr??mite:",
                "descripcion"=> "Persona mayor de edad que quiera renovar su licencia.",
                "opciones" => [],
            ],
            [
                "titulo"=> "Tipo de persona:",
                "descripcion"=> "F??sica",
                "opciones" => [],
            ],
            [
                "titulo"=> "Tipo de documento entregado:",
                "descripcion"=> "Licencia de conducir.",
                "opciones" => [],
            ],
            [
                "titulo"=> "Tiempo h??bil promedio de resoluci??n:",
                "descripcion"=> "20 minutos",
                "opciones" => [],
            ],
            [
                "titulo"=> "Vigencias de los documentos:",
                "descripcion"=> "1, 3 o 6 a??os.",
                "opciones" => [],
            ],
            [
                "titulo"=> "Audiencia",
                "descripcion"=> "General",
                "opciones" => [],
            ],
            [
                "titulo"=> "Clasificaci??n",
                "descripcion"=> "Seguridad, legalidad y justicia",
                "opciones" => [],
            ],
            [
                "titulo"=> "Beneficio del usuario:",
                "descripcion"=> "Al tener la licencia de conducir, le autoriza conducir veh??culos particulares con peso m??ximo de diez toneladas.",
                "opciones" => [],
            ],
            [
                "titulo"=> "Derechos del usuario:",
                "descripcion"=> "Circular en la v??a p??blica en el tipo de veh??culo que corresponda a la modalidad mencionada en la licencia de conducir.",
                "opciones" => [],
            ]
        ];

        $tramite['requerimientos'] = [
            [
                "titulo" => "Casos en que se debe realizar el tr??mite:",
                "descripcion" => "En caso de renovaci??n, robo o extrav??o de licencia.",
                "opciones" => [],
                "documentos" => []
            ],
            [
                "titulo" => "Requisitos:",
                "descripcion" => "",
                "opciones" => [
                    "1. Ser mayor de edad.",
                    "2. Aprobar el examen m??dico de aptitudes f??sicas y mentales para la conducci??n.",
                    "Si la licencia es ".'"Polaroid"'.", deber?? realizar el tr??mite de Expedici??n de licencia de conducir para primera vez, cumpliendo con toda la documentaci??n y requisitos respectivos."
                ],
                "documentos" => []
            ],
            [
                "titulo" => "Documentos requeridos:",
                "descripcion" => "",
                "opciones" => [],
                "documentos" => [
                    [
                        "nombre"=> "FM3 o FM2",
                        "presentacion"=> "Original",
                        "observaciones"=> "??nicamente en caso de personas extranjeras.",
                    ],
                    [
                        "nombre"=> "Acta de nacimiento",
                        "presentacion"=> "Original",
                        "observaciones"=> "En caso que la licencia sea for??nea, federal o extranjera.",
                    ],
                    [
                        "nombre"=> "Licencia de conducir",
                        "presentacion"=> "Original vencida",
                        "observaciones"=> "De tramitar por robo, deber?? presentar el Reporte de extrav??o de documento o la denuncia, expedido por la Fiscal??a de Distrito por Zona.",
                    ],
                    [
                        "nombre"=> "Comprobante de domicilio",
                        "presentacion"=> "Original",
                        "observaciones"=> "A su nombre, de fecha de expedici??n no mayor a 3 meses (agua, luz, tel??fono, gas o predial). En caso de no estar a su nombre, acompa??arlo
                        de alg??n estado de cuenta bancario, servicio de tv por cable, estado de cuenta de tienda departamental u otro comprobante que llegue al domicilio a su nombre.",
                    ]
                ]
            ],
            [
                "titulo" => "??Puede hacer el tr??mite alguien m??s?:",
                "descripcion" => "No",
                "opciones" => [],
                "documentos" => []
            ],
            [
                "titulo" => "Casos de rechazo:",
                "descripcion" => "Falta de documentaci??n, por no saber leer ni escribir, por mandato judicial, en caso de comprobar que ha dejado de tener la aptitud f??sica y/o mental para
                conducir, cuando se comprueba que la informaci??n proporcionada para la obtenci??n de la Licencia de Conducir es falsa o que algunos de los documentos exhibidos sean falsificados.",
                "opciones" => [],
                "documentos" => []
            ]
        ];

        $tramite['en_linea'] = [
            [
                "titulo"=> "Tiempo promedio de espera en fila",
                "descripcion"=> "5 minutos.",
                "opciones" => [],
                "documentos" => []
            ],
            [
                "titulo"=> "??Hay informaci??n en l??nea?:",
                "descripcion"=> "No",
                "opciones" => [],
                "documentos" => []
            ],
            [
                "titulo"=> "??Se pueden recibir solicitudes en l??nea?:",
                "descripcion"=> "No",
                "opciones" => [],
                "documentos" => []
            ],
            [
                "titulo"=> "Solicitud en l??nea ??Requiere formato?:",
                "descripcion"=> "No",
                "opciones" => [],
                "documentos" => []
            ]
        ];

        $tramite['costo'] = [
            [
                "titulo"=> "??Tiene costo?:",
                "descripcion"=> "Si",
                "opciones" => [],
                "documentos" => []
            ],
            [
                "titulo"=> "Costos",
                "descripcion"=> "",
                "opciones" => ["Con vigencia a 6 a??os: $1,412 MXN", "Con vigencia a 3 a??os: $1,053 MXN", "Con vigencia a 1 a??os: $417 MXN"],
                "documentos" => []
            ],
            [
                "titulo"=> "Oficinas donde se puede realizar el pago:",
                "descripcion"=> "",
                "opciones" => [],
                "documentos" => []
            ]
        ];

        $tramite['fundamento_legal'] = [
            [
                "titulo" => "",
                "descripcion" => "",
                "opciones" => [],
                "adicional" => [
                    [
                        "titulo" => " Fundamento que da origen al tr??mite",
                        "descripcion" => "Ley de Vialidad y Tr??nsito para el Estado de Chihuahua",
                        "opciones" => []
                    ],
                    [
                        "titulo" => "Costo",
                        "descripcion" => "Ley de Ingresos para el Estado de Chihuahua para el Ejercicio Fiscal 2020",
                        "opciones" => []
                    ],
                ]
            ],
        ];

        return view('MST_SEGUIMIENTO.DET_VENTANILLA', compact('tramite'));
    }

    public function consultar_cita()
    {
        $tramite = [];
        $tramite['nombre'] = "Expedici??n de licencia de conducir para chofer particular (renovaci??n)";
        $tramite['responsable'] = "Fiscal??a General del Estado de Chihuahua";
        $tramite['descripcion'] = "Es la autorizaci??n que expide la Fiscal??a General del Estado para conducir veh??culos particulares destinados al
        transporte hasta de veintid??s plazas y con peso m??ximo de diez toneladas, una vez que ha concluido su vigencia o en caso de perdida; previo
        cumplimiento de los requisitos previstos en la Ley de Vialidad y Tr??nsito para el Estado de Chihuahua.";

        $tramite['oficinas'] = [
            [
                "id" => 1,
                "nombre"=> "Delegaci??n regional",
                "direccion"=> "Morelos y 23, #2300 17",
                "horario"=> "Lunes a viernes: 8:00 a 15:00 horas.",
                "latitud"=> 0,
                "longitud"=> 0,
                "responsable"=> "Johnny Depp",
                "contacto_telefono"=> "9911229988 Ext. 123, 456",
                "contacto_email"=> "Jhon_Deep@gmail.com",
                "informacion_adicional"=> "Acudir con cubrebocas para su atenci??n. Ok",
            ],
            [
                "id" => 2,
                "nombre"=> "M??dulo Ni??os H??roes",
                "direccion"=> "Palacio Mitla 2 , locales 4, 5 y 6, #1151 37",
                "horario"=> "Lunes a viernes: 8:00 a 15:00 horas.",
                "latitud"=> 0,
                "longitud"=> 0,
                "responsable"=> "Juan Bautista Pascasio Escutia y Mart??nez",
                "contacto_telefono"=> "9911229988 Ext. 123, 456",
                "contacto_email"=> "juan_bandera@gmail.com",
                "informacion_adicional"=> "Acudir con cubrebocas para su atenci??n. Oki",
            ],
            [
                "id" => 3,
                "nombre"=> "M??dulo de Licencias Mitla",
                "direccion"=> "Palacio Mitla 6 , locales 4, 5 y 6, #1151 37",
                "horario"=> "Lunes a viernes: 8:00 a 15:00 horas.",
                "latitud"=> 0,
                "longitud"=> 0,
                "responsable"=> "Michael Jackson",
                "contacto_telefono"=> "9911229988 Ext. 123, 456",
                "contacto_email"=> "mike@gmail.com",
                "informacion_adicional"=> "Acudir con cubrebocas para su atenci??n. Va",
            ],
        ];

        $tramite['informacion_general'] = [
            [
                "titulo"=> "Periodo en que puedo realizar el tr??mite",
                "descripcion"=> "02/01/2020 al 31/12/2020",
                "opciones" => [],
            ],
            [
                "titulo"=> "Usuario a quien est?? dirigido el tr??mite:",
                "descripcion"=> "Persona mayor de edad que quiera renovar su licencia.",
                "opciones" => [],
            ],
            [
                "titulo"=> "Tipo de persona:",
                "descripcion"=> "F??sica",
                "opciones" => [],
            ],
            [
                "titulo"=> "Tipo de documento entregado:",
                "descripcion"=> "Licencia de conducir.",
                "opciones" => [],
            ],
            [
                "titulo"=> "Tiempo h??bil promedio de resoluci??n:",
                "descripcion"=> "20 minutos",
                "opciones" => [],
            ],
            [
                "titulo"=> "Vigencias de los documentos:",
                "descripcion"=> "1, 3 o 6 a??os.",
                "opciones" => [],
            ],
            [
                "titulo"=> "Audiencia",
                "descripcion"=> "General",
                "opciones" => [],
            ],
            [
                "titulo"=> "Clasificaci??n",
                "descripcion"=> "Seguridad, legalidad y justicia",
                "opciones" => [],
            ],
            [
                "titulo"=> "Beneficio del usuario:",
                "descripcion"=> "Al tener la licencia de conducir, le autoriza conducir veh??culos particulares con peso m??ximo de diez toneladas.",
                "opciones" => [],
            ],
            [
                "titulo"=> "Derechos del usuario:",
                "descripcion"=> "Circular en la v??a p??blica en el tipo de veh??culo que corresponda a la modalidad mencionada en la licencia de conducir.",
                "opciones" => [],
            ]
        ];

        $tramite['requerimientos'] = [
            [
                "titulo" => "Casos en que se debe realizar el tr??mite:",
                "descripcion" => "En caso de renovaci??n, robo o extrav??o de licencia.",
                "opciones" => [],
                "documentos" => []
            ],
            [
                "titulo" => "Requisitos:",
                "descripcion" => "",
                "opciones" => [
                    "1. Ser mayor de edad.",
                    "2. Aprobar el examen m??dico de aptitudes f??sicas y mentales para la conducci??n.",
                    "Si la licencia es ".'"Polaroid"'.", deber?? realizar el tr??mite de Expedici??n de licencia de conducir para primera vez, cumpliendo con toda la documentaci??n y requisitos respectivos."
                ],
                "documentos" => []
            ],
            [
                "titulo" => "Documentos requeridos:",
                "descripcion" => "",
                "opciones" => [],
                "documentos" => [
                    [
                        "nombre"=> "FM3 o FM2",
                        "presentacion"=> "Original",
                        "observaciones"=> "??nicamente en caso de personas extranjeras.",
                    ],
                    [
                        "nombre"=> "Acta de nacimiento",
                        "presentacion"=> "Original",
                        "observaciones"=> "En caso que la licencia sea for??nea, federal o extranjera.",
                    ],
                    [
                        "nombre"=> "Licencia de conducir",
                        "presentacion"=> "Original vencida",
                        "observaciones"=> "De tramitar por robo, deber?? presentar el Reporte de extrav??o de documento o la denuncia, expedido por la Fiscal??a de Distrito por Zona.",
                    ],
                    [
                        "nombre"=> "Comprobante de domicilio",
                        "presentacion"=> "Original",
                        "observaciones"=> "A su nombre, de fecha de expedici??n no mayor a 3 meses (agua, luz, tel??fono, gas o predial). En caso de no estar a su nombre, acompa??arlo
                        de alg??n estado de cuenta bancario, servicio de tv por cable, estado de cuenta de tienda departamental u otro comprobante que llegue al domicilio a su nombre.",
                    ]
                ]
            ],
            [
                "titulo" => "??Puede hacer el tr??mite alguien m??s?:",
                "descripcion" => "No",
                "opciones" => [],
                "documentos" => []
            ],
            [
                "titulo" => "Casos de rechazo:",
                "descripcion" => "Falta de documentaci??n, por no saber leer ni escribir, por mandato judicial, en caso de comprobar que ha dejado de tener la aptitud f??sica y/o mental para
                conducir, cuando se comprueba que la informaci??n proporcionada para la obtenci??n de la Licencia de Conducir es falsa o que algunos de los documentos exhibidos sean falsificados.",
                "opciones" => [],
                "documentos" => []
            ]
        ];

        $tramite['en_linea'] = [
            [
                "titulo"=> "Tiempo promedio de espera en fila",
                "descripcion"=> "5 minutos.",
                "opciones" => [],
                "documentos" => []
            ],
            [
                "titulo"=> "??Hay informaci??n en l??nea?:",
                "descripcion"=> "No",
                "opciones" => [],
                "documentos" => []
            ],
            [
                "titulo"=> "??Se pueden recibir solicitudes en l??nea?:",
                "descripcion"=> "No",
                "opciones" => [],
                "documentos" => []
            ],
            [
                "titulo"=> "Solicitud en l??nea ??Requiere formato?:",
                "descripcion"=> "No",
                "opciones" => [],
                "documentos" => []
            ]
        ];

        $tramite['costo'] = [
            [
                "titulo"=> "??Tiene costo?:",
                "descripcion"=> "Si",
                "opciones" => [],
                "documentos" => []
            ],
            [
                "titulo"=> "Costos",
                "descripcion"=> "",
                "opciones" => ["Con vigencia a 6 a??os: $1,412 MXN", "Con vigencia a 3 a??os: $1,053 MXN", "Con vigencia a 1 a??os: $417 MXN"],
                "documentos" => []
            ],
            [
                "titulo"=> "Oficinas donde se puede realizar el pago:",
                "descripcion"=> "",
                "opciones" => [],
                "documentos" => []
            ]
        ];

        $tramite['fundamento_legal'] = [
            [
                "titulo" => "",
                "descripcion" => "",
                "opciones" => [],
                "adicional" => [
                    [
                        "titulo" => " Fundamento que da origen al tr??mite",
                        "descripcion" => "Ley de Vialidad y Tr??nsito para el Estado de Chihuahua",
                        "opciones" => []
                    ],
                    [
                        "titulo" => "Costo",
                        "descripcion" => "Ley de Ingresos para el Estado de Chihuahua para el Ejercicio Fiscal 2020",
                        "opciones" => []
                    ],
                ]
            ],
        ];

        return view('MST_SEGUIMIENTO.DET_CITA', compact('tramite'));
    }

    public function conexion()
    {
        try {

            $conn = oci_connect("ESZ","wqKuq9LTKHH9uVs9", "10.18.29.107:1521/devinfo");
            echo 'Connected to database';

        } catch (\Throwable $e) {
            echo "Error: " . $e;
        }
    }
}







/*

            $tns = "
            (DESCRIPTION =
                (ADDRESS_LIST =
                (ADDRESS = (PROTOCOL = TCP)(HOST = 10.18.29.103)(PORT = 1521))
                )
                (CONNECT_DATA =
                (SERVICE_NAME = orcl)
                )
            )
        ";

            $db_username = "ESZ";
            $db_password = "wqKuq9LTKHH9uVs9";

            $conn = new \PDO("oci:dbname=" . $tns, $db_username, $db_password);

            if ($conn) {
                echo 'Conectado a Base de datos';
            } else {
                echo 'Error de conexi??n';
            }*/




            // $cadena_conexion = "10.18.29.103:1521/devinfo";
            // $conn = oci_connect('ESZ', 'wqKuq9LTKHH9uVs9', '10.18.29.103:1521/devinfo');
            // if (!$conn) {
            //     $e = oci_error();
            //     trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
            // }else{
            //     echo "Se pudo contectar :)";
            // }

            // if (DB::connection('oracle')) {
            //     echo "Se pudo contectar";
            // } else {
            //     echo "No se pudo conectar";
            // }
