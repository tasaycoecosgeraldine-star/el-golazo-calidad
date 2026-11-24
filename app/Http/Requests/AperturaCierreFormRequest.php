<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AperturaCierreFormRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if ($this->isMethod('post')) {
            return [
                'montoApertura' => 'required|numeric|min:0',
            ];
        }

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            return [
                'montoCierre' => 'required|numeric|min:0',
            ];
        }

        return [];
    }

    public function messages()
    {
        return [
            'montoApertura.required' =>
                'El monto de apertura es obligatorio.',
            'montoApertura.numeric' =>
                'El monto de apertura debe ser un número.',
            'montoApertura.min' =>
                'El monto de apertura no puede ser negativo.',

            'montoCierre.required' =>
                'El monto de cierre es obligatorio.',
            'montoCierre.numeric' =>
                'El monto de cierre debe ser un número.',
            'montoCierre.min' =>
                'El monto de cierre no puede ser negativo.',
        ];
    }
}