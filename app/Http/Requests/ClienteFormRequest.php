<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class ClienteFormRequest extends FormRequest
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
            'nombres' => 'max:100|required|min:4',
            'numDocumento' => 'max:15|required|regex:/^\d{1,14}$/|unique:cliente,numDocumento,' .  $this->codCliente . ',codCliente',
            'password' => 'max:200',
            'direccion' => 'max:40',
            'telefono' => 'max:15',
            // 'correo' => 'max:50|unique:paciente,correo,' .  $this->codPaciente . ',codPaciente',
            'email' => 'max:50',
            'estado' => 'max:20',
            'tipo' => 'max:20',
            'foto' => 'mimes:jpg,jpeg,bmp,png'
        ];
    }

    public function messages()
    {

        return [
            'nombres.required' => 'El Nombre de Cliente es un campo requerido.',
            'nombres.regex' => 'Nombre de Cliente inválido , verifique el nombre ingresado.',
            'nombres.max' => 'El Tamaño del campo Cliente no debe ser mayor a 80 caracteres.',
            'nombres.min' => 'El valor de los nombres debe ser mayor a 4 caracteres.',
            'numDocumento.required' => 'El Número de Documento es un campo requerido.',
            'numDocumento.unique' => 'El Número de Documento ya esta registrado.',
            'numDocumento.regex' => 'Número de Documento inválido , verifique el Número de Documento ingresado.',
            'numDocumento.max' => 'El Tamaño del Número de Documento no debe ser mayor a 15 caracteres.',
            'password.max' => 'El Tamaño del password no debe ser mayor a 200 caracteres.',
            'direccion.max' => 'El Tamaño de Dirección no debe ser mayor a 40 caracteres.',
            'telefono.regex' => 'Teléfono inválido , verifique el Teléfono ingresado.',
            'telefono.max' => 'El Tamaño de Teléfono no debe ser mayor a 15 caracteres.',
            'correo.required' => 'correo es un campo requerido.',
            'correo.email' => 'correo inválido , verifique el correo ingresado.',
            'correo.max' => 'El Tamaño del correo no debe ser mayor a 50 caracteres.',
            'correo.unique' => 'El Correo Electrónico ya esta registrado.',
        ];
    }
}
