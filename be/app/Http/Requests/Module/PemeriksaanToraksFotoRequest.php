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
                "required",
                // Rule::requiredIf(!in_array($this->method(), ['PUT', 'PATCH'])),
                "mimes:pdf,jpg,jpeg,png",
                "max:2048",
            ],

            "pa_size"               => "required",
            "pa_lokasi"             => "required",
            "pa_efusi"              => "required",
            "pa_efusi_lainnya"      => ["nullable", Rule::requiredIf($this->pa_efusi == 3)],
            "pa_description"        => "nullable",

            "la_size"               => "required",
            "la_lokasi"             => "required",
            "la_efusi"              => "required",
            "la_efusi_lainnya"      => ["nullable", Rule::requiredIf($this->la_efusi == 3)],
            "la_description"        => "nullable",
        ];
    }
}
