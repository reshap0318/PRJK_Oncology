<?php

namespace App\Http\Requests\Module;

use App\Models\Module\PemeriksaanRadioterapiModel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PemeriksaanRadioterapiFURequest extends FormRequest
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
        $radioTbl = (new PemeriksaanRadioterapiModel())->getTable();
        return [
            "radio_id"      => ["required", Rule::exists($radioTbl, "id")],
            "date"          => "required|date_format:Y-m-d",
            "ct_scan"       => [
                "nullable",
                Rule::requiredIf(!in_array($this->method(), ['PUT', 'PATCH'])),
                "mimes:pdf,jpg,jpeg,png",
                "max:2048",
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            "date"              => "tanggal",
        ];
    }
}
