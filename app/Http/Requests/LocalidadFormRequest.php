<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LocalidadFormRequest extends FormRequest
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
            'nomLocalidad' => 'required|regex:/^[a-zA-Z0-9-ZÀ-ÿ\_\-\ ]{4,40}$/|max:40|unique:localidad,nomLocalidad,'.$this->codLocalidad.',codLocalidad',
            'precioDia' => 'required|numeric',
            'precioNoche' => 'required|numeric',
            // 'telefono' => 'required|numeric',
            // 'logo' => 'mimes:mimes:jpg,jpeg,bmp,png'
        ];
    }
    public function messages()
    {
        return [
            'nomLocalidad.required' => 'El Nombre de Localidad es un campo requerido.',
            'nomLocalidad.unique' => 'El Nombre de Localidad ya esta registrado.',
            'nomLocalidad.regex' => 'Nombre de Localidad invalido , verifique el caracter ingresado.',
            'nomLocalidad.max' => 'El Tamaño del campo Localidad no debe ser mayor a 40 caracteres.',
            'precioDia.numeric' => 'El precio de día debe ser un valor numérico.',
            'precioNoche.numeric' => 'El precio de noche debe ser un valor numérico.',
            // 'telefono.required' => 'Telefono es un campo requerido.',
            // 'logo.mimes' => 'Ingrese un archivo con formato de imagen'
        ];
    }
}
