<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProveedorFormRequest extends FormRequest
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

            'nomPro' => 'required|string|max:91',
            'telPro' => 'nullable|string|max:15',
        ];
    }
    public function messages()
    {
        return [

            'nomPro.required' => 'Por favor, introduce el nombre del proveedor',
            'nomPro.max' => 'El nombre del proveedor debe tener como máximo 91 caracteres',
            'telPro.max' => 'El número de teléfono del proveedor debe tener como máximo 15 caracteres',
        ];
    }
}
