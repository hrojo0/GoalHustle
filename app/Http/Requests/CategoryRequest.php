<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; //true para que las validaciones se rezlicen desde este request
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $slug = request()->isMethod('put') ? 'required|unique:categories,slug,'.$this->id : 'required|unique:categories';
        // método put para actualizar articulo ? 'accion para no modificar slug porque ya existe' : 'accion porque no existe slug y debe ser unico'
        
        $image = request()->isMethod('put') ? 'nullable|image' : 'required|image';
        return [
            //Reglas de validaciones
            'name' => 'required|min:5|max:255',
            'slug' => $slug,
            'image' => $image,
            'is_featured' => 'required|boolean',
            'status' => 'required|boolean',
        ];
    }
}
