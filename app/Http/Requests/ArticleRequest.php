<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $slug = request()->isMethod('put') ? 'required|unique:articles,slug,'.$this->id : 'required|unique:articles';
        // método put para actualizar articulo ? 'accion para no modificar slug porque ya existe' : 'accion porque no existe slug y debe ser unico'
        
        $image = request()->isMethod('put') ? 'nullable|mimes:jpeg,jpg,png,gif,svg|max:8000' : 'required|image';
        return [
            //Reglas de validaciones
            'title' => 'required|min:5|max:255',
            'slug' => $slug,
            'introduction' => 'required|min:10|max:255',
            'image' => $image,
            'body' => 'required',
            'status' => 'required|boolean',
            'is_featured' => 'required|boolean',
            'category_id' => 'required|integer'
        ];
    }
}
