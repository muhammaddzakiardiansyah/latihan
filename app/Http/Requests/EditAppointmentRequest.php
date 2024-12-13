<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditAppointmentRequest extends FormRequest
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
            'patient_id' => ['required', 'integer'],
            'diagnose_id' => ['required', 'integer'],
            'status' => ['required', 'in:0,1'],
        ];
    }

    public function messages(): array
    {
        return [
            'patient_id.required' => 'patient_id is required!',
            'patient_id.integer' => 'patient_id must be integer!',
            'diagnose_id.required' => 'diagnose_id is required!',
            'diagnose_id.integer' => 'diagnose_id must be integer!',
            'status.required' => 'status is required!',
            'status.in' => 'status must be 0 or 1!',
        ];
    }
}
