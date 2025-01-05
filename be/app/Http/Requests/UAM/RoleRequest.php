<?php

namespace App\Http\Requests\UAM;

use App\Models\UAM\PermissionModel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    
    public function rules(): array
    {
        $prmTbl = (new PermissionModel())->getTableCon();
        return [
            'name'          => 'required',
            'permissions'   => ['required','array'],
            'permissions.*' => [
                Rule::exists($prmTbl, 'id')
            ]
        ];
    }

    public function attributes(): array
    {
        return [
            'permissions'    =>  'permissions',
            'permissions.*'  =>  'permissions',
        ];
    }
}
