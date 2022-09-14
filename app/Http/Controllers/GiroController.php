<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Http\Requests\GeneralValidator;

class GiroController extends Controller
{
    public function __construct() {
        $this->validator = new GeneralValidator();
    }

    /**
     * Crea un registros en la db
     * @param Request  $request
     * @return Response
     */
    public function store(Request $request){
        $statusCode = 200;
        
        try {
            $validacion = $this->validator->giros($request, 'add');
            if($validacion !== true)
                return response()->json(['error' => $validacion->original], 403);
            
            dd("paso");
            $result = $this->usuarioService->saveUserData((object)$request->all());
        } catch (Exception $ex) {
            $statusCode = 403;
            $result     = ['error' => $ex->getMessage()];
        }

        return response()->json($result, $statusCode);
    }
}
