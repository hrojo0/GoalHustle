<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeamRequest extends FormRequest
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
        $slug = request()->isMethod('put') ? 'required|unique:teams,slug,'.$this->id : 'required|unique:teams';
        // método put para actualizar articulo ? 'accion para no modificar slug porque ya existe' : 'accion porque no existe slug y debe ser unico'
        
        $logo = request()->isMethod('put') ? 'nullable|mimes:jpeg,jpg,png,gif,svg|max:8000' : 'required|image';
        return [
            //Reglas de validaciones
            'name' => 'required|min:5|max:255',
            'slug' => $slug,
            'logo' => $logo
        ];
    }
}
