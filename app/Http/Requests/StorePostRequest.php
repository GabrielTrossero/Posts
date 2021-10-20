<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
            'titulo' => 'required|max:150',
            'slug' => 'required|max:150|unique:post',
            'descripcion' => 'required|max:10000',
            'imagen' => 'image'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'required' => 'Debe completar el campo :attribute',
            'min' => 'El campo :attribute debe tener al menos :min caracteres',
            'max' => 'El campo :attribute no bebe superar :max caracteres',
            'unique' => 'Ingrese un :attribute válido. Ya existe un Post con dicho :attribute.',
            'image' => 'El archivo debe ser una Imagen',
        ];
    }
}
