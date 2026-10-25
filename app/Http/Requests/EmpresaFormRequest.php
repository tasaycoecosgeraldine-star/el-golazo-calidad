<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmpresaFormRequest extends FormRequest
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
            // 'idEmpresa'=>'max:11',
            'nombre' => 'max:80|required|unique:empresa,nombre,' . $this->idEmpresa . ',idEmpresa',
            'Direccion' => 'max:50',
            'Logo' => 'mimes:jpg,jpeg,bmp,png',
        ];
    }

    public function messages()
    {

        return [
            'nombre.required' => 'Tiene que ingresar el Nombre de la Empresa.',
            'nombre.unique' => 'El nombre de la empresa ' . $this->idEmpresa . ' ya está en uso.',
        ];
    }
}