<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Public;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class TokenRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->guest();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'email'
            ],
            'password' => [
                'required',

            ],
        ];
    }

    public function getCredentials(): array
    {
        return [
            'email' => $this->input('email'),
            'password' => $this->input('password'),
        ];
    }
}
