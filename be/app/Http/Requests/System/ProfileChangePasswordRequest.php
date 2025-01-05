<?php

namespace App\Http\Requests\System;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ProfileChangePasswordRequest extends FormRequest
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
            'password' => [
                in_array($this->method(), ['PUT', 'PATCH']) ? "nullable" : "required", 
                "string", 
                "min:8", 
                "max:16", 
                Password::min(6)->letters()->numbers()//->uncompromised()
            ],
            'confirm_password'  => [
                in_array($this->method(), ['PUT', 'PATCH']) ? "nullable" : "required", 
                "same:password"
            ],
        ];
    }
}
