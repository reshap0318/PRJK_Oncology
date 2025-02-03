<?php

namespace App\Http\Requests\Module;

use App\Models\Module\PasienPemeriksaanModel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PemeriksaanTerapiTargetRequest extends FormRequest
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
        $pemeriksaanTbl = (new PasienPemeriksaanModel())->getTable();
        return [
            "inspection_id" => ["required", Rule::exists($pemeriksaanTbl, "id")],
            "date"          => "required|date_format:Y-m-d",
            "category"      => "required",
            "type"          => "required",
            "long"          => "required",
            "ct_scan"       => [
                "nullable",
                Rule::requiredIf(!in_array($this->method(), ['PUT', 'PATCH'])),
                "mimes:pdf,jpg,jpeg,png",
                "max:2048",
            ],
            "side_effect"   => "nullable",
            "description"   => "nullable",
        ];
    }
}
