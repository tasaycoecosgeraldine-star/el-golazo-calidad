<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VentaFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return True;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // 'codVenta' => 'required',
            // 'totalVenta'=> 'required',
        ];
    }
    public function messages()
    {
        return [
            // 'codVenta.required' => 'es requerido.',
            // 'totalVenta.required' => 'El Nombre de Producto es un campo requerido.',
        ];
    }
}
