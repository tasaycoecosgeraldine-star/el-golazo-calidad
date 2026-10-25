<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoriaFormRequest extends FormRequest
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
            'nombre' => 'required|regex:/^[a-zA-Z0-9-ZÀ-ÿ\_\-\ ]{4,40}$/|max:40|unique:categoria,nombre,'.$this->codCategoria.',codCategoria',
            'descripcion' => 'max:400'
        ];
    }
    public function messages()
    {
        return [
            'nombre.required' => 'El Nombre de Categoría es un campo requerido.',
            'nombre.unique' => 'El Nombre de Categoría ya esta registrado.',
            'nombre.regex' => 'Nombre de Categoría invalido , verifique el caracter ingresado.',
            'nombre.max' => 'El Tamaño del campo Categoría no debe ser mayor a 40 caracteres.',
            'descripcion.max' => 'El Tamaño del campo Descripción no debe ser mayor a 400 caracteres.',
        ];
    }
}
