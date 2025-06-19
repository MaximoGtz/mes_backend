<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class InsertionRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Necesitas cambiarlo a true para que entre a tu método
        return true;
        // return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'recipe_number' => 'required|integer',
            'profile_length' => 'required|numeric',
            'distance_between_holes' => 'required|integer',
            'length_before_reset' => 'required|numeric',
            'good_piece' => 'required|boolean',
            'cicle_time' => 'required|integer',
            'machine_number' => 'required|exists:profilers,number'
        ];
    }
    // Añades la funcion para retornar los mensajes personalizados
    public function messages(): array
    {
        return [
            'recipe_number.required' => 'El numero de la receta es requerido.',
            'recipe_number.integer' => 'El numero de la receta necesita ser un entero.',
            'profile_length.required' => 'La longitud del perfil es requerida.',
            'profile_length.integer' => 'La longitud del perfil necesita ser un entero.',
            'distance_between_holes.required' => 'La distancia entre los agujeros es requerida.',
            'distance_between_holes.integer' => 'La distancia entre los agujeros necesita ser un entero.',
            'length_before_reset.required' => 'La longitud antes del reinicio es requerida.',
            'length_before_reset.numeric' => 'La longitud antes del reinicio necesita ser numérico.',
            'good_piece.required' => 'El booleano es pieza buena es requerido.',
            'good_piece.boolean' => 'El boolean es pieza buena necesitar ser un booleano.',
            'cicle_time.required' => 'El tiempo de ciclo es requerido',
            'cicle_time.integer' => 'El tiempo de ciclo necesita ser un numero entero.',
            'machine_number.required' => 'El numero de la máquina es requerido.',
            'machine_number.exists' => 'El numero de la máquina no coinicide con ninguna perfiladora registrada.',
        ];
    }
    // Esto sobreescribe la funcion para la validación y retorno de error en caso de fallo
    //Recibe esta clase como parámetro (Validator) de import arriba

}
