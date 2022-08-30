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
}
