<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PagoRequest extends FormRequest
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
            'metodoPago' => 'required|max:91',
            'importePago' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'metodoPago.required' => 'El método de pago es requerido.',
            'metodoPago.max' => 'El método de pago no debe exceder los 91 caracteres.',
            'importePago.required' => 'El importe del pago es requerido.',
            'importePago.numeric' => 'El importe del pago debe ser un número.',

        ];
    }
}
