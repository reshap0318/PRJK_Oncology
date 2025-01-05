<?php

namespace App\Http\Requests\UAM;

use App\Models\UAM\PermissionModel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PermissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    
    public function rules(): array
    {
        $tbl = (new PermissionModel())->getTableCon();
        return [
            'name'          => [
                'required', 
                Rule::unique($tbl, "name")->when(in_array($this->method(), ['PUT', 'PATCH']), function($q)
                {
                    $id = $this->route()->parameter('id');
                    return $q->ignore($id);
                })
            ],
            'keterangan'    => 'required'
        ];
    }
}
