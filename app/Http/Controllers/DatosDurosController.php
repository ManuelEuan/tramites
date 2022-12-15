<?php

namespace App\Http\Controllers;
use App\Cls_Tramite_Servicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DatosDurosController extends Controller
{
    public function edificios(){
        $data['VW_ACCEDE_EDIFICIOS'] = [
            [
                "ID_EDIFICIO" => 1,
                "NOMBRE" => "Delegación regional",
                "DESCRIPCION" => "Delegación regional",
                "CALLES" => "23 y 17",
                "NUMEROEXT" => "2300",
                "NUMEROINT" => "",
                "CP" => "",
                "LATITUD" => 0,
                "LONGITUD" => 0,
                "MUNICIPIO" => "Morelos",
            ],
            [
                "ID_EDIFICIO" => 2,
                "NOMBRE" => "Módulo Niños Héroes",
                "DESCRIPCION" => "Palacio Mitla 2 , locales 4, 5 y 6, #1151 37",
                "CALLES" => "37",
                "NUMEROEXT" => "1151",
                "NUMEROINT" => "",
                "CP" => "",
                "LATITUD" => 0,
                "LONGITUD" => 0,
                "MUNICIPIO" => "Morelos",
            ],
            [
                "ID_EDIFICIO" => 3,
                "NOMBRE" => "Módulo de Licencias Mitla",
                "DESCRIPCION" => "Palacio Mitla 6 , locales 4, 5 y 6, #1151 37",
                "CALLES" => "37",
                "NUMEROEXT" => "1151",
                "NUMEROINT" => "",
                "CP" => "",
                "LATITUD" => 0,
                "LONGITUD" => 0,
                "MUNICIPIO" => "Morelos",
            ],
        ];
        return response()->json($data);
    }

    public function unidades_administrativas($id){
        //die($id);
        // $aux = [];
        // $data = [
        //     [
        //         "ID_UNIDAD" => 1,
        //         "ID_CENTRO" => "",
        //         "ID_DEPENDENCIA" => 1,
        //         "CLAVE_UNIDAD" => "",
        //         "DESCRIPCION" => "Departamento de Atención Ciudadana."
        //     ],
        //     [
        //         "ID_UNIDAD" => 2,
        //         "ID_CENTRO" => "",
        //         "ID_DEPENDENCIA" => 2,
        //         "CLAVE_UNIDAD" => "",
        //         "DESCRIPCION" => "Departamento de Atención a Personas Adultas Mayores."
        //     ],
        //     [
        //         "ID_UNIDAD" => 3,
        //         "ID_CENTRO" => "",
        //         "ID_DEPENDENCIA" => 5,
        //         "CLAVE_UNIDAD" => "",
        //         "DESCRIPCION" => "Departamento de Atención a Personas Con Discapacidad y Prevensión a la Discriminación."
        //     ],
        //     [
        //         "ID_UNIDAD" => 4,
        //         "ID_CENTRO" => "",
        //         "ID_DEPENDENCIA" => 2,
        //         "CLAVE_UNIDAD" => "",
        //         "DESCRIPCION" => "Departamento de Centro de Servicios Comunitarios Integrados."
        //     ],
        //     [
        //         "ID_UNIDAD" => 5,
        //         "ID_CENTRO" => "",
        //         "ID_DEPENDENCIA" => 3,
        //         "CLAVE_UNIDAD" => "",
        //         "DESCRIPCION" => "Departamento de Chihuahua Crece Contigo."
        //     ],
        //     [
        //         "ID_UNIDAD" => 6,
        //         "ID_CENTRO" => "",
        //         "ID_DEPENDENCIA" => 4,
        //         "CLAVE_UNIDAD" => "",
        //         "DESCRIPCION" => "Departamento de Cohesión Social y Participación Ciudadana."
        //     ]
        // ];

        $unidades = DB::select(
            'SELECT * FROM tram_view_unidades where ID_DEPENDENCIA = ?',
            array($id)
        );

        // foreach($data as $value){
        //     if($value['ID_DEPENDENCIA'] == $id){
        //         array_push($aux, $value);
        //     }
        // }
        return response()->json($unidades);
    }

    public function dependencias(){
        $data = [];
        
        for ($i = 0; $i < 6; $i++) {
            $item = $i + 1;
            $data[$i]['id']         = $item;
            $data[$i]['nombre']     = "Dependencia " . $i;
        }
        
        return response()->json($data);
    }
    
    public function tramites($id){
        $data = DB::table('accede_lista_tramites')->where('ID_CENTRO', $id)->get();
        return response()->json($data);
    }

    public function encrypt(Request $request){
        $text = json_encode($request->data);
          
        $output = false;

        $encrypt_method = "AES-256-CBC";
        $secret_key = '13C036380E84D697DAF826DD4BC22F98';
        $secret_iv = 'HNG6I9CO4K7FVOTH';
    
        // hash
        $key = hash('sha256', $secret_key);
        
        // iv
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        $output = openssl_encrypt($text, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
        
        return response()->json(['encriptado'=> $output, 'vector' => $iv, 'key' => $key], 200);
        /* echo  "<textarea cols='100' rows='25'>" .$output. "</textarea>"; */
    }

    public function decrypt($text){
        $encrypt_method = "AES-256-CBC";
        $secret_key = '13C036380E84D697DAF826DD4BC22F98';
        $secret_iv = 'HNG6I9CO4K7FVOTH';
    
        // hash
        $key = hash('sha256', $secret_key);
        
        // iv
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        $decrypted = openssl_decrypt(base64_decode($text), $encrypt_method, $key, 0, $iv);
        $decrypted = json_decode($decrypted);
        //print_r($decrypted);

        return response()->json(['data'=> $decrypted], 200);
    }
}
