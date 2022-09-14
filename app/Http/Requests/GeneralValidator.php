<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Http\FormRequest;


class GeneralValidator extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

    public function citas(Request $request, $accion ='add'){
        $params = [
            'usuario_id'   => 'nullable|integer',
            'fecha'        => 'required|date',
            'hora'         => 'required',
            'tramite_id'   => 'nullable|integer',
            'modulo_id'    => 'nullable|integer',
            'confirmado'   => 'nullable',
        ];

        if($accion != 'add')
            $params = array_merge($params, ['cita_Id' => 'required|integer|exists:citas_tramites_calendario,idcitas_tramites_calendario']);

        $validator = Validator::make($request->all(),$params);
        if ($validator->fails())
            return response()->json($validator->errors());

        return true;
    }

    public function disponibilidad(Request $request){
        $params = [
            'accede_id' => 'required|integer',
            'modulo_id' => 'required|integer',
            'fecha'     => 'required|date',
        ];

        $validator = Validator::make($request->all(),$params);
        if ($validator->fails())
            return response()->json($validator->errors());

        return true;
    }

    /**
     * Validadion usada para la valiudacion de curp y rfc
     * @param Request $request
     * @return bool|object
     */
    public function validaDuplicidad(Request $request){
        $validator  = Validator::make($request->all(),[
            'valor' => 'required|string|max:20', 
            'tipo'  => 'required',Rule::in([ "rfc", "curp"])
        ]);
       
        if ($validator->fails())
            return response()->json($validator->errors());

        return true;
    }

    public function giros(Request $request, $accion ='add'){
        $params = [
            'clave'         => 'required|string|max:20',
            'nombre'        => 'required|string|max:200',
            'descripcion'   => 'required|string',
            'activo'        => 'nullable|boolean'
        ];

        if($accion != 'add')
            $params = array_merge($params, ['id' => 'required|integer|exists:tram_cat_giros,id']);

        $validator = Validator::make($request->all(),$params);
        if ($validator->fails())
            return response()->json($validator->errors());

        return true;
    }
}
