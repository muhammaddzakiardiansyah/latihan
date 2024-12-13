<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddDiagnoseRequest extends FormRequest
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
            'name' => ['required', 'string', 'unique:diagnoses,name'],
            'service' => ['required', 'json'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'name diagnose is required!',
            'name.string' => 'name diagnose must contain text!',
            'name.unique' => 'name diagnose alredy exists!',
            'service.required' => 'service is required!',
            'service.json' => 'service must be valid json!',
        ];
    }
}
