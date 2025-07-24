<?php

namespace App\Http\Requests\Module;

use App\Models\Module\PasienPemeriksaanModel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PemeriksaanToraksFotoRequest extends FormRequest
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
            "file"          => [
                "mimes:pdf,jpg,jpeg,png",
                "max:5120",
            ],

            "pa_size"               => "nullable",
            "pa_lokasi"             => "nullable",
            "pa_efusi"              => "nullable",
            "pa_description"        => "nullable",

            "la_size"               => "nullable",
            "la_lokasi"             => "nullable",
            "la_efusi"              => "nullable",
            "la_description"        => "nullable",
        ];
    }
}
