<?php 

namespace App\Services;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class VariosService {
    /**
     * Retorna el QR en base a la leyenda indicada
     * @param string $data
     * 
     */
    public function generaQR(string $data){
        try {
            $carpeta = public_path('codigosQR');
            if(!File::isDirectory($carpeta)) {
                if(!File::makeDirectory($carpeta, $mode = 0777, true, true))
                    $response = false;
            }

            $path = public_path('codigosQR/'.time().'.svg');
            \QrCode::generate($data, $path );
            return $path;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Sube archivos al servidor
     * @param File $request
     * @param string $path
     */
    public function subeArchivo($archivo, string $path='files/documentos/'){
        $extencion  = $archivo->getClientOriginalExtension();
        $tamaño     = $archivo->getSize();
        $nombre     = rand().'.'.$extencion;
        $archivo->move(siegy_path($path), $nombre);

        return [
            'message'   => 'correctamente',
            'path'      => $path.$nombre,
            'extension' => $extencion,
            'size'      => $tamaño,
            'status'    => 'success'
        ];
    }
}
