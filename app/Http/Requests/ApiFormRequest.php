<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class ApiFormRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        // Se retorna una excepción
        throw new HttpResponseException(response()->json([
            "message" => "Validation error",
            "errors" => $validator->errors()
        ],Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}