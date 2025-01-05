<?php

namespace App\Http\Requests\Module;

use App\Models\Module\SatkerModel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SatkerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'              => ['required'],
            'parent_id'         => ['required', Rule::exists((new SatkerModel())->getTable(), "id")],
        ];
    }

    public function attributes(): array
    {
        return [
            'name'              => 'nama',
            'parent_id'         => 'parent',
        ];
    }
}
