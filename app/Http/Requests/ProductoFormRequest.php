<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductoFormRequest extends FormRequest
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
            'nomProducto' => 'required|regex:/^[a-zA-Z0-9-ZÀ-ÿ\_\-\ ]{4,40}$/|max:40|unique:producto,nomProducto,'.$this->codProducto. ',codProducto' ,
            'Precio' => 'required|numeric|regex:/^[\d]{0,11}(\.[\d]{1,2})?$/',
            'stock' => 'required|numeric',
            'descripcion' => 'max:400',
            'imagen' => 'mimes:mimes:jpg,jpeg,bmp,png'
        ];
    }
    public function messages()
    {
        return [
            'nomProducto.required' => 'El Nombre de Producto es un campo requerido.',
            'nomProducto.unique' => 'El Nombre de Producto ya esta registrado.',
            'nomProducto.regex' => 'Nombre de Producto invalido , verifique el caracter ingresado.',
            'nomProducto.max' => 'El Tamaño del campo Producto no debe ser mayor a 40 caracteres.',
            'stock.numeric' => 'Stock debe ser un valor numérico.',
            'stock.required' => 'Stock es un campo requerido.',
            'Precio.numeric' => 'Precio debe ser un valor numérico ó decimal.',
            'Precio.required' => 'Precio es un campo requerido.',
            'Precio.regex' => 'Ingrese un Precio Valido.',
            'descripcion.max' => 'El Tamaño del campo Descripción no debe ser mayor a 400 caracteres.',
            'imagen.mimes' => 'Ingrese un archivo con formato de imagen'
        ];
    }
}
