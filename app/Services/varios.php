<?php 

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\File;

class Varios {
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
            \QrCode::generate('Welcome to Makitweb', $path );
            return $path;
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}