<?php

namespace App\Http\Requests\UAM;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    
    public function rules(): array
    {
        $userTbl = (new User())->getTableCon();
        return [
            'name'      => [ 'required' ],
            'username'  => [
                'required',
                Rule::unique($userTbl, "username")
                ->when(in_array($this->method(), ['PUT', 'PATCH']), function($q)
                {
                    $id = $this->route()->parameter('id');
                    return $q->ignore($id);
                })
            ],
            'email'     => [
                'required',
                'email',
                Rule::unique($userTbl, "email")
                ->when(in_array($this->method(), ['PUT', 'PATCH']), function($q)
                {
                    $id = $this->route()->parameter('id');
                    return $q->ignore($id);
                })
            ],
            'password'  => [
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
            'roles'          => 'required|array',
            'roles.*'       => [ 'required' ],
            'avatar'        => 'nullable|image|mimes:png,jpeg,jpg|max:2048',
            'no_telp'       => ['nullable', 'regex:/(0)[0-9]/'],
            'alamat'        => 'nullable',
        ];
    }

    public function attributes(): array
    {
        return [
            'name'          => 'nama',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active'          => $this->is_active ?? false,
            'roles'              => !is_array($this->roles) ? explode(",", $this->roles) : $this->roles,
        ]);
    }
}
