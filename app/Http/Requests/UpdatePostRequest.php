<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UpdatePostRequest extends FormRequest
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
            'id' => 'required|exists:post',
            'titulo' => 'required|max:150',
            'slug' => [
                'required',
                'max:150',
                Rule::unique('post')->ignore($this->id),
              ],
            'descripcion' => 'required|max:10000',
            'deleteImagen' => 'required_if:selectIsRequired,==,true|in:true,false', //solo es required cuando había una imagen en el post
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
            'exists' => 'El :attribute ingresado es incorrecto',
            'min' => 'El campo :attribute debe tener al menos :min caracteres',
            'max' => 'El campo :attribute no bebe superar :max caracteres',
            'unique' => 'Ingrese un :attribute válido. Ya existe un Post con dicho :attribute',
            'in' => 'Dicha opción no es válida',
            'image' => 'El archivo debe ser una Imagen',
        ];
    }
}
