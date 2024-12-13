<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddPatientRequest extends FormRequest
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
            'name' => ['required', 'string', 'unique:patients,name'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'name patient is required!',
            'name.string' => 'name patient must contain text!',
            'name.unique' => 'name patient alredy exists!',
        ];
    }
}
