<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfilerRequest extends ApiFormRequest
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
            "name" => "required|string",
            "status" => "required|in:automatic,manual,run,stop",
            "number" => "required|integer|unique:profilers,id",
            "model" => "required|string",
            "ip" => "required|string",
            "year_model" => "required|numeric|min:2000|max:" . date("Y"),
            "machine_speed" => "required|integer"
        ];
    }
}
