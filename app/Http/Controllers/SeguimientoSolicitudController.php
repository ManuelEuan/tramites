<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Cls_Usuario_Tramite;
use Illuminate\Support\Facades\Auth;

class SeguimientoSolicitudController extends Controller
{
    public function index()
    {
        return view('MST_SEGUIMIENTO.index');
    }

    public function consultar(Request $request)
    {
        // $list = [];

        // for ($i = 0; $i < 25; $i++) {

        //     //Generate a timestamp using mt_rand.
        //     $timestamp = mt_rand(1, time());

        //     //Format that timestamp into a readable date string.
        //     $randomDate = date("d M, Y", $timestamp);

        //     $item = $i + 1;

        //     $list[$i]['id'] = $item;
        //     $list[$i]['nombre'] = "Trámite " . $item;
        //     $list[$i]['dependencia'] = $request->cmbDependenciaEntidad > 0 ? "Dependencia " . $request->cmbDependenciaEntidad : "Dependencia " . rand(1, 5);
        //     $list[$i]['fecha'] = is_null($request->dteFechaInicio) ? $randomDate : date("d M, Y", strtotime($request->dteFechaInicio));
        //     $list[$i]['estatus'] = $request->cmbEstatus > 0 ? $request->cmbEstatus : rand(1, 9);
        // }

        //dd($request);

        $response = [
            'data' =>  Cls_Usuario_Tramite::TRAM_SP_CONSULTAR_SEGUIMIENTO_TRAMITE_USUARIO(Auth::user()->USUA_NIDUSUARIO, $request->txtNombre, $request->cmbEstatus, $request->cmbDependenciaEntidad, $request->dteFechaInicio),
        ];

        return response()->json($response);
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
        $tramite['nombre'] = "Expedición de licencia de conducir para chofer particular (renovación)";
        $tramite['responsable'] = "Fiscalía General del Estado de Chihuahua";
        $tramite['descripcion'] = "Es la autorización que expide la Fiscalía General del Estado para conducir vehículos particulares destinados al
        transporte hasta de veintidós plazas y con peso máximo de diez toneladas, una vez que ha concluido su vigencia o en caso de perdida; previo
        cumplimiento de los requisitos previstos en la Ley de Vialidad y Tránsito para el Estado de Chihuahua.";

        $tramite['oficinas'] = [
            [
                "id" => 1,
                "nombre"=> "Delegación regional",
                "direccion"=> "Morelos y 23, #2300 17",
                "horario"=> "Lunes a viernes: 8:00 a 15:00 horas.",
                "latitud"=> 0,
                "longitud"=> 0,
                "responsable"=> "Johnny Depp",
                "contacto_telefono"=> "9911229988 Ext. 123, 456",
                "contacto_email"=> "Jhon_Deep@gmail.com",
                "informacion_adicional"=> "Acudir con cubrebocas para su atención. Ok",
            ],
            [
                "id" => 2,
                "nombre"=> "Módulo Niños Héroes",
                "direccion"=> "Palacio Mitla 2 , locales 4, 5 y 6, #1151 37",
                "horario"=> "Lunes a viernes: 8:00 a 15:00 horas.",
                "latitud"=> 0,
                "longitud"=> 0,
                "responsable"=> "Juan Bautista Pascasio Escutia y Martínez",
                "contacto_telefono"=> "9911229988 Ext. 123, 456",
                "contacto_email"=> "juan_bandera@gmail.com",
                "informacion_adicional"=> "Acudir con cubrebocas para su atención. Oki",
            ],
            [
                "id" => 3,
                "nombre"=> "Módulo de Licencias Mitla",
                "direccion"=> "Palacio Mitla 6 , locales 4, 5 y 6, #1151 37",
                "horario"=> "Lunes a viernes: 8:00 a 15:00 horas.",
                "latitud"=> 0,
                "longitud"=> 0,
                "responsable"=> "Michael Jackson",
                "contacto_telefono"=> "9911229988 Ext. 123, 456",
                "contacto_email"=> "mike@gmail.com",
                "informacion_adicional"=> "Acudir con cubrebocas para su atención. Va",
            ],
        ];

        $tramite['informacion_general'] = [
            [
                "titulo"=> "Periodo en que puedo realizar el trámite",
                "descripcion"=> "02/01/2020 al 31/12/2020",
                "opciones" => [],
            ],
            [
                "titulo"=> "Usuario a quien está dirigido el trámite:",
                "descripcion"=> "Persona mayor de edad que quiera renovar su licencia.",
                "opciones" => [],
            ],
            [
                "titulo"=> "Tipo de persona:",
                "descripcion"=> "Física",
                "opciones" => [],
            ],
            [
                "titulo"=> "Tipo de documento entregado:",
                "descripcion"=> "Licencia de conducir.",
                "opciones" => [],
            ],
            [
                "titulo"=> "Tiempo hábil promedio de resolución:",
                "descripcion"=> "20 minutos",
                "opciones" => [],
            ],
            [
                "titulo"=> "Vigencias de los documentos:",
                "descripcion"=> "1, 3 o 6 años.",
                "opciones" => [],
            ],
            [
                "titulo"=> "Audiencia",
                "descripcion"=> "General",
                "opciones" => [],
            ],
            [
                "titulo"=> "Clasificación",
                "descripcion"=> "Seguridad, legalidad y justicia",
                "opciones" => [],
            ],
            [
                "titulo"=> "Beneficio del usuario:",
                "descripcion"=> "Al tener la licencia de conducir, le autoriza conducir vehículos particulares con peso máximo de diez toneladas.",
                "opciones" => [],
            ],
            [
                "titulo"=> "Derechos del usuario:",
                "descripcion"=> "Circular en la vía pública en el tipo de vehículo que corresponda a la modalidad mencionada en la licencia de conducir.",
                "opciones" => [],
            ]
        ];

        $tramite['requerimientos'] = [
            [
                "titulo" => "Casos en que se debe realizar el trámite:",
                "descripcion" => "En caso de renovación, robo o extravío de licencia.",
                "opciones" => [],
                "documentos" => []
            ],
            [
                "titulo" => "Requisitos:",
                "descripcion" => "",
                "opciones" => [
                    "1. Ser mayor de edad.",
                    "2. Aprobar el examen médico de aptitudes físicas y mentales para la conducción.",
                    "Si la licencia es ".'"Polaroid"'.", deberá realizar el trámite de Expedición de licencia de conducir para primera vez, cumpliendo con toda la documentación y requisitos respectivos."
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
                        "observaciones"=> "Únicamente en caso de personas extranjeras.",
                    ],
                    [
                        "nombre"=> "Acta de nacimiento",
                        "presentacion"=> "Original",
                        "observaciones"=> "En caso que la licencia sea foránea, federal o extranjera.",
                    ],
                    [
                        "nombre"=> "Licencia de conducir",
                        "presentacion"=> "Original vencida",
                        "observaciones"=> "De tramitar por robo, deberá presentar el Reporte de extravío de documento o la denuncia, expedido por la Fiscalía de Distrito por Zona.",
                    ],
                    [
                        "nombre"=> "Comprobante de domicilio",
                        "presentacion"=> "Original",
                        "observaciones"=> "A su nombre, de fecha de expedición no mayor a 3 meses (agua, luz, teléfono, gas o predial). En caso de no estar a su nombre, acompañarlo
                        de algún estado de cuenta bancario, servicio de tv por cable, estado de cuenta de tienda departamental u otro comprobante que llegue al domicilio a su nombre.",
                    ]
                ]
            ],
            [
                "titulo" => "¿Puede hacer el trámite alguien más?:",
                "descripcion" => "No",
                "opciones" => [],
                "documentos" => []
            ],
            [
                "titulo" => "Casos de rechazo:",
                "descripcion" => "Falta de documentación, por no saber leer ni escribir, por mandato judicial, en caso de comprobar que ha dejado de tener la aptitud física y/o mental para
                conducir, cuando se comprueba que la información proporcionada para la obtención de la Licencia de Conducir es falsa o que algunos de los documentos exhibidos sean falsificados.",
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
                "titulo"=> "¿Hay información en línea?:",
                "descripcion"=> "No",
                "opciones" => [],
                "documentos" => []
            ],
            [
                "titulo"=> "¿Se pueden recibir solicitudes en línea?:",
                "descripcion"=> "No",
                "opciones" => [],
                "documentos" => []
            ],
            [
                "titulo"=> "Solicitud en línea ¿Requiere formato?:",
                "descripcion"=> "No",
                "opciones" => [],
                "documentos" => []
            ]
        ];

        $tramite['costo'] = [
            [
                "titulo"=> "¿Tiene costo?:",
                "descripcion"=> "Si",
                "opciones" => [],
                "documentos" => []
            ],
            [
                "titulo"=> "Costos",
                "descripcion"=> "",
                "opciones" => ["Con vigencia a 6 años: $1,412 MXN", "Con vigencia a 3 años: $1,053 MXN", "Con vigencia a 1 años: $417 MXN"],
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
                        "titulo" => " Fundamento que da origen al trámite",
                        "descripcion" => "Ley de Vialidad y Tránsito para el Estado de Chihuahua",
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
        $tramite['nombre'] = "Expedición de licencia de conducir para chofer particular (renovación)";
        $tramite['responsable'] = "Fiscalía General del Estado de Chihuahua";
        $tramite['descripcion'] = "Es la autorización que expide la Fiscalía General del Estado para conducir vehículos particulares destinados al
        transporte hasta de veintidós plazas y con peso máximo de diez toneladas, una vez que ha concluido su vigencia o en caso de perdida; previo
        cumplimiento de los requisitos previstos en la Ley de Vialidad y Tránsito para el Estado de Chihuahua.";

        $tramite['oficinas'] = [
            [
                "id" => 1,
                "nombre"=> "Delegación regional",
                "direccion"=> "Morelos y 23, #2300 17",
                "horario"=> "Lunes a viernes: 8:00 a 15:00 horas.",
                "latitud"=> 0,
                "longitud"=> 0,
                "responsable"=> "Johnny Depp",
                "contacto_telefono"=> "9911229988 Ext. 123, 456",
                "contacto_email"=> "Jhon_Deep@gmail.com",
                "informacion_adicional"=> "Acudir con cubrebocas para su atención. Ok",
            ],
            [
                "id" => 2,
                "nombre"=> "Módulo Niños Héroes",
                "direccion"=> "Palacio Mitla 2 , locales 4, 5 y 6, #1151 37",
                "horario"=> "Lunes a viernes: 8:00 a 15:00 horas.",
                "latitud"=> 0,
                "longitud"=> 0,
                "responsable"=> "Juan Bautista Pascasio Escutia y Martínez",
                "contacto_telefono"=> "9911229988 Ext. 123, 456",
                "contacto_email"=> "juan_bandera@gmail.com",
                "informacion_adicional"=> "Acudir con cubrebocas para su atención. Oki",
            ],
            [
                "id" => 3,
                "nombre"=> "Módulo de Licencias Mitla",
                "direccion"=> "Palacio Mitla 6 , locales 4, 5 y 6, #1151 37",
                "horario"=> "Lunes a viernes: 8:00 a 15:00 horas.",
                "latitud"=> 0,
                "longitud"=> 0,
                "responsable"=> "Michael Jackson",
                "contacto_telefono"=> "9911229988 Ext. 123, 456",
                "contacto_email"=> "mike@gmail.com",
                "informacion_adicional"=> "Acudir con cubrebocas para su atención. Va",
            ],
        ];

        $tramite['informacion_general'] = [
            [
                "titulo"=> "Periodo en que puedo realizar el trámite",
                "descripcion"=> "02/01/2020 al 31/12/2020",
                "opciones" => [],
            ],
            [
                "titulo"=> "Usuario a quien está dirigido el trámite:",
                "descripcion"=> "Persona mayor de edad que quiera renovar su licencia.",
                "opciones" => [],
            ],
            [
                "titulo"=> "Tipo de persona:",
                "descripcion"=> "Física",
                "opciones" => [],
            ],
            [
                "titulo"=> "Tipo de documento entregado:",
                "descripcion"=> "Licencia de conducir.",
                "opciones" => [],
            ],
            [
                "titulo"=> "Tiempo hábil promedio de resolución:",
                "descripcion"=> "20 minutos",
                "opciones" => [],
            ],
            [
                "titulo"=> "Vigencias de los documentos:",
                "descripcion"=> "1, 3 o 6 años.",
                "opciones" => [],
            ],
            [
                "titulo"=> "Audiencia",
                "descripcion"=> "General",
                "opciones" => [],
            ],
            [
                "titulo"=> "Clasificación",
                "descripcion"=> "Seguridad, legalidad y justicia",
                "opciones" => [],
            ],
            [
                "titulo"=> "Beneficio del usuario:",
                "descripcion"=> "Al tener la licencia de conducir, le autoriza conducir vehículos particulares con peso máximo de diez toneladas.",
                "opciones" => [],
            ],
            [
                "titulo"=> "Derechos del usuario:",
                "descripcion"=> "Circular en la vía pública en el tipo de vehículo que corresponda a la modalidad mencionada en la licencia de conducir.",
                "opciones" => [],
            ]
        ];

        $tramite['requerimientos'] = [
            [
                "titulo" => "Casos en que se debe realizar el trámite:",
                "descripcion" => "En caso de renovación, robo o extravío de licencia.",
                "opciones" => [],
                "documentos" => []
            ],
            [
                "titulo" => "Requisitos:",
                "descripcion" => "",
                "opciones" => [
                    "1. Ser mayor de edad.",
                    "2. Aprobar el examen médico de aptitudes físicas y mentales para la conducción.",
                    "Si la licencia es ".'"Polaroid"'.", deberá realizar el trámite de Expedición de licencia de conducir para primera vez, cumpliendo con toda la documentación y requisitos respectivos."
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
                        "observaciones"=> "Únicamente en caso de personas extranjeras.",
                    ],
                    [
                        "nombre"=> "Acta de nacimiento",
                        "presentacion"=> "Original",
                        "observaciones"=> "En caso que la licencia sea foránea, federal o extranjera.",
                    ],
                    [
                        "nombre"=> "Licencia de conducir",
                        "presentacion"=> "Original vencida",
                        "observaciones"=> "De tramitar por robo, deberá presentar el Reporte de extravío de documento o la denuncia, expedido por la Fiscalía de Distrito por Zona.",
                    ],
                    [
                        "nombre"=> "Comprobante de domicilio",
                        "presentacion"=> "Original",
                        "observaciones"=> "A su nombre, de fecha de expedición no mayor a 3 meses (agua, luz, teléfono, gas o predial). En caso de no estar a su nombre, acompañarlo
                        de algún estado de cuenta bancario, servicio de tv por cable, estado de cuenta de tienda departamental u otro comprobante que llegue al domicilio a su nombre.",
                    ]
                ]
            ],
            [
                "titulo" => "¿Puede hacer el trámite alguien más?:",
                "descripcion" => "No",
                "opciones" => [],
                "documentos" => []
            ],
            [
                "titulo" => "Casos de rechazo:",
                "descripcion" => "Falta de documentación, por no saber leer ni escribir, por mandato judicial, en caso de comprobar que ha dejado de tener la aptitud física y/o mental para
                conducir, cuando se comprueba que la información proporcionada para la obtención de la Licencia de Conducir es falsa o que algunos de los documentos exhibidos sean falsificados.",
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
                "titulo"=> "¿Hay información en línea?:",
                "descripcion"=> "No",
                "opciones" => [],
                "documentos" => []
            ],
            [
                "titulo"=> "¿Se pueden recibir solicitudes en línea?:",
                "descripcion"=> "No",
                "opciones" => [],
                "documentos" => []
            ],
            [
                "titulo"=> "Solicitud en línea ¿Requiere formato?:",
                "descripcion"=> "No",
                "opciones" => [],
                "documentos" => []
            ]
        ];

        $tramite['costo'] = [
            [
                "titulo"=> "¿Tiene costo?:",
                "descripcion"=> "Si",
                "opciones" => [],
                "documentos" => []
            ],
            [
                "titulo"=> "Costos",
                "descripcion"=> "",
                "opciones" => ["Con vigencia a 6 años: $1,412 MXN", "Con vigencia a 3 años: $1,053 MXN", "Con vigencia a 1 años: $417 MXN"],
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
                        "titulo" => " Fundamento que da origen al trámite",
                        "descripcion" => "Ley de Vialidad y Tránsito para el Estado de Chihuahua",
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
        $tramite['nombre'] = "Expedición de licencia de conducir para chofer particular (renovación)";
        $tramite['responsable'] = "Fiscalía General del Estado de Chihuahua";
        $tramite['descripcion'] = "Es la autorización que expide la Fiscalía General del Estado para conducir vehículos particulares destinados al
        transporte hasta de veintidós plazas y con peso máximo de diez toneladas, una vez que ha concluido su vigencia o en caso de perdida; previo
        cumplimiento de los requisitos previstos en la Ley de Vialidad y Tránsito para el Estado de Chihuahua.";

        $tramite['oficinas'] = [
            [
                "id" => 1,
                "nombre"=> "Delegación regional",
                "direccion"=> "Morelos y 23, #2300 17",
                "horario"=> "Lunes a viernes: 8:00 a 15:00 horas.",
                "latitud"=> 0,
                "longitud"=> 0,
                "responsable"=> "Johnny Depp",
                "contacto_telefono"=> "9911229988 Ext. 123, 456",
                "contacto_email"=> "Jhon_Deep@gmail.com",
                "informacion_adicional"=> "Acudir con cubrebocas para su atención. Ok",
            ],
            [
                "id" => 2,
                "nombre"=> "Módulo Niños Héroes",
                "direccion"=> "Palacio Mitla 2 , locales 4, 5 y 6, #1151 37",
                "horario"=> "Lunes a viernes: 8:00 a 15:00 horas.",
                "latitud"=> 0,
                "longitud"=> 0,
                "responsable"=> "Juan Bautista Pascasio Escutia y Martínez",
                "contacto_telefono"=> "9911229988 Ext. 123, 456",
                "contacto_email"=> "juan_bandera@gmail.com",
                "informacion_adicional"=> "Acudir con cubrebocas para su atención. Oki",
            ],
            [
                "id" => 3,
                "nombre"=> "Módulo de Licencias Mitla",
                "direccion"=> "Palacio Mitla 6 , locales 4, 5 y 6, #1151 37",
                "horario"=> "Lunes a viernes: 8:00 a 15:00 horas.",
                "latitud"=> 0,
                "longitud"=> 0,
                "responsable"=> "Michael Jackson",
                "contacto_telefono"=> "9911229988 Ext. 123, 456",
                "contacto_email"=> "mike@gmail.com",
                "informacion_adicional"=> "Acudir con cubrebocas para su atención. Va",
            ],
        ];

        $tramite['informacion_general'] = [
            [
                "titulo"=> "Periodo en que puedo realizar el trámite",
                "descripcion"=> "02/01/2020 al 31/12/2020",
                "opciones" => [],
            ],
            [
                "titulo"=> "Usuario a quien está dirigido el trámite:",
                "descripcion"=> "Persona mayor de edad que quiera renovar su licencia.",
                "opciones" => [],
            ],
            [
                "titulo"=> "Tipo de persona:",
                "descripcion"=> "Física",
                "opciones" => [],
            ],
            [
                "titulo"=> "Tipo de documento entregado:",
                "descripcion"=> "Licencia de conducir.",
                "opciones" => [],
            ],
            [
                "titulo"=> "Tiempo hábil promedio de resolución:",
                "descripcion"=> "20 minutos",
                "opciones" => [],
            ],
            [
                "titulo"=> "Vigencias de los documentos:",
                "descripcion"=> "1, 3 o 6 años.",
                "opciones" => [],
            ],
            [
                "titulo"=> "Audiencia",
                "descripcion"=> "General",
                "opciones" => [],
            ],
            [
                "titulo"=> "Clasificación",
                "descripcion"=> "Seguridad, legalidad y justicia",
                "opciones" => [],
            ],
            [
                "titulo"=> "Beneficio del usuario:",
                "descripcion"=> "Al tener la licencia de conducir, le autoriza conducir vehículos particulares con peso máximo de diez toneladas.",
                "opciones" => [],
            ],
            [
                "titulo"=> "Derechos del usuario:",
                "descripcion"=> "Circular en la vía pública en el tipo de vehículo que corresponda a la modalidad mencionada en la licencia de conducir.",
                "opciones" => [],
            ]
        ];

        $tramite['requerimientos'] = [
            [
                "titulo" => "Casos en que se debe realizar el trámite:",
                "descripcion" => "En caso de renovación, robo o extravío de licencia.",
                "opciones" => [],
                "documentos" => []
            ],
            [
                "titulo" => "Requisitos:",
                "descripcion" => "",
                "opciones" => [
                    "1. Ser mayor de edad.",
                    "2. Aprobar el examen médico de aptitudes físicas y mentales para la conducción.",
                    "Si la licencia es ".'"Polaroid"'.", deberá realizar el trámite de Expedición de licencia de conducir para primera vez, cumpliendo con toda la documentación y requisitos respectivos."
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
                        "observaciones"=> "Únicamente en caso de personas extranjeras.",
                    ],
                    [
                        "nombre"=> "Acta de nacimiento",
                        "presentacion"=> "Original",
                        "observaciones"=> "En caso que la licencia sea foránea, federal o extranjera.",
                    ],
                    [
                        "nombre"=> "Licencia de conducir",
                        "presentacion"=> "Original vencida",
                        "observaciones"=> "De tramitar por robo, deberá presentar el Reporte de extravío de documento o la denuncia, expedido por la Fiscalía de Distrito por Zona.",
                    ],
                    [
                        "nombre"=> "Comprobante de domicilio",
                        "presentacion"=> "Original",
                        "observaciones"=> "A su nombre, de fecha de expedición no mayor a 3 meses (agua, luz, teléfono, gas o predial). En caso de no estar a su nombre, acompañarlo
                        de algún estado de cuenta bancario, servicio de tv por cable, estado de cuenta de tienda departamental u otro comprobante que llegue al domicilio a su nombre.",
                    ]
                ]
            ],
            [
                "titulo" => "¿Puede hacer el trámite alguien más?:",
                "descripcion" => "No",
                "opciones" => [],
                "documentos" => []
            ],
            [
                "titulo" => "Casos de rechazo:",
                "descripcion" => "Falta de documentación, por no saber leer ni escribir, por mandato judicial, en caso de comprobar que ha dejado de tener la aptitud física y/o mental para
                conducir, cuando se comprueba que la información proporcionada para la obtención de la Licencia de Conducir es falsa o que algunos de los documentos exhibidos sean falsificados.",
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
                "titulo"=> "¿Hay información en línea?:",
                "descripcion"=> "No",
                "opciones" => [],
                "documentos" => []
            ],
            [
                "titulo"=> "¿Se pueden recibir solicitudes en línea?:",
                "descripcion"=> "No",
                "opciones" => [],
                "documentos" => []
            ],
            [
                "titulo"=> "Solicitud en línea ¿Requiere formato?:",
                "descripcion"=> "No",
                "opciones" => [],
                "documentos" => []
            ]
        ];

        $tramite['costo'] = [
            [
                "titulo"=> "¿Tiene costo?:",
                "descripcion"=> "Si",
                "opciones" => [],
                "documentos" => []
            ],
            [
                "titulo"=> "Costos",
                "descripcion"=> "",
                "opciones" => ["Con vigencia a 6 años: $1,412 MXN", "Con vigencia a 3 años: $1,053 MXN", "Con vigencia a 1 años: $417 MXN"],
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
                        "titulo" => " Fundamento que da origen al trámite",
                        "descripcion" => "Ley de Vialidad y Tránsito para el Estado de Chihuahua",
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
        $tramite['nombre'] = "Expedición de licencia de conducir para chofer particular (renovación)";
        $tramite['responsable'] = "Fiscalía General del Estado de Chihuahua";
        $tramite['descripcion'] = "Es la autorización que expide la Fiscalía General del Estado para conducir vehículos particulares destinados al
        transporte hasta de veintidós plazas y con peso máximo de diez toneladas, una vez que ha concluido su vigencia o en caso de perdida; previo
        cumplimiento de los requisitos previstos en la Ley de Vialidad y Tránsito para el Estado de Chihuahua.";

        $tramite['oficinas'] = [
            [
                "id" => 1,
                "nombre"=> "Delegación regional",
                "direccion"=> "Morelos y 23, #2300 17",
                "horario"=> "Lunes a viernes: 8:00 a 15:00 horas.",
                "latitud"=> 0,
                "longitud"=> 0,
                "responsable"=> "Johnny Depp",
                "contacto_telefono"=> "9911229988 Ext. 123, 456",
                "contacto_email"=> "Jhon_Deep@gmail.com",
                "informacion_adicional"=> "Acudir con cubrebocas para su atención. Ok",
            ],
            [
                "id" => 2,
                "nombre"=> "Módulo Niños Héroes",
                "direccion"=> "Palacio Mitla 2 , locales 4, 5 y 6, #1151 37",
                "horario"=> "Lunes a viernes: 8:00 a 15:00 horas.",
                "latitud"=> 0,
                "longitud"=> 0,
                "responsable"=> "Juan Bautista Pascasio Escutia y Martínez",
                "contacto_telefono"=> "9911229988 Ext. 123, 456",
                "contacto_email"=> "juan_bandera@gmail.com",
                "informacion_adicional"=> "Acudir con cubrebocas para su atención. Oki",
            ],
            [
                "id" => 3,
                "nombre"=> "Módulo de Licencias Mitla",
                "direccion"=> "Palacio Mitla 6 , locales 4, 5 y 6, #1151 37",
                "horario"=> "Lunes a viernes: 8:00 a 15:00 horas.",
                "latitud"=> 0,
                "longitud"=> 0,
                "responsable"=> "Michael Jackson",
                "contacto_telefono"=> "9911229988 Ext. 123, 456",
                "contacto_email"=> "mike@gmail.com",
                "informacion_adicional"=> "Acudir con cubrebocas para su atención. Va",
            ],
        ];

        $tramite['informacion_general'] = [
            [
                "titulo"=> "Periodo en que puedo realizar el trámite",
                "descripcion"=> "02/01/2020 al 31/12/2020",
                "opciones" => [],
            ],
            [
                "titulo"=> "Usuario a quien está dirigido el trámite:",
                "descripcion"=> "Persona mayor de edad que quiera renovar su licencia.",
                "opciones" => [],
            ],
            [
                "titulo"=> "Tipo de persona:",
                "descripcion"=> "Física",
                "opciones" => [],
            ],
            [
                "titulo"=> "Tipo de documento entregado:",
                "descripcion"=> "Licencia de conducir.",
                "opciones" => [],
            ],
            [
                "titulo"=> "Tiempo hábil promedio de resolución:",
                "descripcion"=> "20 minutos",
                "opciones" => [],
            ],
            [
                "titulo"=> "Vigencias de los documentos:",
                "descripcion"=> "1, 3 o 6 años.",
                "opciones" => [],
            ],
            [
                "titulo"=> "Audiencia",
                "descripcion"=> "General",
                "opciones" => [],
            ],
            [
                "titulo"=> "Clasificación",
                "descripcion"=> "Seguridad, legalidad y justicia",
                "opciones" => [],
            ],
            [
                "titulo"=> "Beneficio del usuario:",
                "descripcion"=> "Al tener la licencia de conducir, le autoriza conducir vehículos particulares con peso máximo de diez toneladas.",
                "opciones" => [],
            ],
            [
                "titulo"=> "Derechos del usuario:",
                "descripcion"=> "Circular en la vía pública en el tipo de vehículo que corresponda a la modalidad mencionada en la licencia de conducir.",
                "opciones" => [],
            ]
        ];

        $tramite['requerimientos'] = [
            [
                "titulo" => "Casos en que se debe realizar el trámite:",
                "descripcion" => "En caso de renovación, robo o extravío de licencia.",
                "opciones" => [],
                "documentos" => []
            ],
            [
                "titulo" => "Requisitos:",
                "descripcion" => "",
                "opciones" => [
                    "1. Ser mayor de edad.",
                    "2. Aprobar el examen médico de aptitudes físicas y mentales para la conducción.",
                    "Si la licencia es ".'"Polaroid"'.", deberá realizar el trámite de Expedición de licencia de conducir para primera vez, cumpliendo con toda la documentación y requisitos respectivos."
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
                        "observaciones"=> "Únicamente en caso de personas extranjeras.",
                    ],
                    [
                        "nombre"=> "Acta de nacimiento",
                        "presentacion"=> "Original",
                        "observaciones"=> "En caso que la licencia sea foránea, federal o extranjera.",
                    ],
                    [
                        "nombre"=> "Licencia de conducir",
                        "presentacion"=> "Original vencida",
                        "observaciones"=> "De tramitar por robo, deberá presentar el Reporte de extravío de documento o la denuncia, expedido por la Fiscalía de Distrito por Zona.",
                    ],
                    [
                        "nombre"=> "Comprobante de domicilio",
                        "presentacion"=> "Original",
                        "observaciones"=> "A su nombre, de fecha de expedición no mayor a 3 meses (agua, luz, teléfono, gas o predial). En caso de no estar a su nombre, acompañarlo
                        de algún estado de cuenta bancario, servicio de tv por cable, estado de cuenta de tienda departamental u otro comprobante que llegue al domicilio a su nombre.",
                    ]
                ]
            ],
            [
                "titulo" => "¿Puede hacer el trámite alguien más?:",
                "descripcion" => "No",
                "opciones" => [],
                "documentos" => []
            ],
            [
                "titulo" => "Casos de rechazo:",
                "descripcion" => "Falta de documentación, por no saber leer ni escribir, por mandato judicial, en caso de comprobar que ha dejado de tener la aptitud física y/o mental para
                conducir, cuando se comprueba que la información proporcionada para la obtención de la Licencia de Conducir es falsa o que algunos de los documentos exhibidos sean falsificados.",
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
                "titulo"=> "¿Hay información en línea?:",
                "descripcion"=> "No",
                "opciones" => [],
                "documentos" => []
            ],
            [
                "titulo"=> "¿Se pueden recibir solicitudes en línea?:",
                "descripcion"=> "No",
                "opciones" => [],
                "documentos" => []
            ],
            [
                "titulo"=> "Solicitud en línea ¿Requiere formato?:",
                "descripcion"=> "No",
                "opciones" => [],
                "documentos" => []
            ]
        ];

        $tramite['costo'] = [
            [
                "titulo"=> "¿Tiene costo?:",
                "descripcion"=> "Si",
                "opciones" => [],
                "documentos" => []
            ],
            [
                "titulo"=> "Costos",
                "descripcion"=> "",
                "opciones" => ["Con vigencia a 6 años: $1,412 MXN", "Con vigencia a 3 años: $1,053 MXN", "Con vigencia a 1 años: $417 MXN"],
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
                        "titulo" => " Fundamento que da origen al trámite",
                        "descripcion" => "Ley de Vialidad y Tránsito para el Estado de Chihuahua",
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
                echo 'Error de conexión';
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
