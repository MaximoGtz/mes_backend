<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JustificationRequest extends ApiFormRequest
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
            'worker' => 'required|string|max:100',
            'minutes_off' => 'required|max:60',
            'justification' => 'required|string|max:255',
            'date_justified' => 'required|date',
            'hour' => 'required|integer',
            'machine_number' => 'required|exists:profilers,number'
        ];
    }
    public function messages():array{
        return [

        ];
    }
}
