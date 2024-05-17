<?php

namespace Jhonhdev\SecurityPe\Http\Requests\Security;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Jhonhdev\SecurityPe\SecurityPe;

class SecurityPeRequest extends FormRequest
{
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'username' => 'required',
            'password' => 'required'
        ];
    }

    public function messages(): array {
        return [
            'username.required' => 'El usuario es requerido.',
            'password.required' => 'La contraseña es requerida.',
        ];
    }

    protected function failedValidation(Validator $validator): array {
        throw new HttpResponseException(SecurityPe::response()->errors('Datos inválidos.', [
            'errors' => $validator->errors()
        ], 422));
    }
}
