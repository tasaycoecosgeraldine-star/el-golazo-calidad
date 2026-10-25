<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuarioFormRequest extends FormRequest
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
            'nombres' => 'max:80|required|regex:/^[a-zA-Z0-9-ZÀ-ÿ\_\-\ ]{4,40}$/',
            'numDocumento' => 'max:15|required|regex:/^\d{1,14}$/|unique:usuario,numDocumento,' .  $this->codUsuario . ',codUsuario',
            'password' => 'max:200',
            'direccion' => 'max:40',
            'telefono' => 'max:15',
            'email' => 'required|max:50|email|unique:usuario,email,' .  $this->codUsuario . ',codUsuario',
            'estado' => 'max:20',
            'tipo' => 'max:20',
            'foto' => 'mimes:jpg,jpeg,bmp,png',
            'password' => !empty($this->password) ? ['required', 'string', 'min:4', 'confirmed'] : [''],
        ];
    }

    public function messages()
    {

        return [
            'nombres.required' => 'El Nombre de Usuario es un campo requerido.',
            'nombres.regex' => 'Nombre de Usuario inválido , verifique el nombre ingresado.',
            'nombres.max' => 'El Tamaño del campo Usuario no debe ser mayor a 80 caracteres.',
            'numDocumento.required' => 'El Número de Documento es un campo requerido.',
            'numDocumento.unique' => 'El Número de Documento ya esta registrado.',
            'numDocumento.regex' => 'Número de Documento inválido , verifique el Número de Documento ingresado.',
            'numDocumento.max' => 'El Tamaño del Número de Documento no debe ser mayor a 15 caracteres.',
            'password.max' => 'El Tamaño del password no debe ser mayor a 200 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden',
            'direccion.max' => 'El Tamaño de Dirección no debe ser mayor a 40 caracteres.',
            'telefono.regex' => 'Teléfono inválido , verifique el Teléfono ingresado.',
            'telefono.max' => 'El Tamaño de Teléfono no debe ser mayor a 15 caracteres.',
            'email.required' => 'Es obligatorio ingresar el correo electrónico.',
            'email.email' => 'Email inválido , verifique el email ingresado.',
            'email.max' => 'El Tamaño del Email no debe ser mayor a 50 caracteres.',
            'email.unique' => 'El Correo Electrónico ya esta registrado.',

        ];
    }
}
