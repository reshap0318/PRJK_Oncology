<?php

namespace App\Http\Requests\Module;

use App\Models\Module\PasienPemeriksaanModel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PemeriksaanRadioterapiRequest extends FormRequest
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
        $pemeriksaanTbl = (new PasienPemeriksaanModel())->getTable();
        return [
            "inspection_id" => ["required", Rule::exists($pemeriksaanTbl, "id")],
            "date"          => "nullable|date_format:Y-m-d",
            "category"      => "nullable",
            "dose"          => "nullable",
            "fraksi"        => "nullable",
            "description"   => "nullable",

            "ct_scan"       => [
                "nullable",
                // Rule::requiredIf(!in_array($this->method(), ['PUT', 'PATCH'])),
                "mimes:pdf,jpg,jpeg,png",
                "max:2048",
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            "date"              => "tanggal",
            "category"          => "jenis radioterapi",
            "dose"              => "dosis",
            "fraksi"            => "fraksi",
            "description"       => "deskripsi",
            "ct_scan"           => "ct scan"
        ];
    }
}
