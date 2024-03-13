<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Public;

use App\DTO\RegistrationDTO;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
{
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
                'min:6', 'max:20',
                'confirmed',
            ],
        ];
    }

    public function getRegistrationDTO(): RegistrationDTO
    {
        return new RegistrationDTO(
            $this->input('email'),
            $this->input('password')
        );
    }
}
