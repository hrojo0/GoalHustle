<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
 
class ProfileRequest extends FormRequest
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
        return [
            'name' => 'required',
            'email' => 'required',
            'photo' => 'nullable',

            'profession' => 'nullable|max:255',
            'about' => 'nullable|max:255',
            'birthday' => 'nullable|date',
            'website' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'facebook' => 'nullable|url',
            'twitter' => 'nullable|url',
        ];
    }
}
