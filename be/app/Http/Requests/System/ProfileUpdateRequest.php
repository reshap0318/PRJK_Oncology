<?php

namespace App\Http\Requests\System;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    
    public function rules(): array
    {
        $userTbl = (new User())->getTableCon();
        return [
            'email' => [
                'required',
                'email',
                Rule::unique($userTbl, "email")->ignore(Auth::id())
            ],
            'username' => [
                'required',
                Rule::unique($userTbl, "username")->ignore(Auth::id())
            ],
            'name'          => [ 'required' ],
            'avatar'        => 'nullable|image|mimes:png,jpeg,jpg|max:2048',
            'no_telp'       => 'nullable',
            'alamat'        => 'nullable'
        ];
    }
}
