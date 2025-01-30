<?php

namespace App\Http\Requests\Module;

use App\Models\Module\PemeriksaanKemoterapiModel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PemeriksaanKemoterapiFURequest extends FormRequest
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
        $kemoTbl = (new PemeriksaanKemoterapiModel())->getTable();
        return [
            "radio_id"      => ["required", Rule::exists($kemoTbl, "id")],
            "date"          => "required|date_format:Y-m-d",
            "subjective"    => "required",
            "semi_ps"       => "required",
            "semi_bb"       => "required",
            "toxity"        => "required",
            "grade"         => "required",
            "rontgen"       => [
                "nullable",
                Rule::requiredIf(!in_array($this->method(), ['PUT', 'PATCH'])),
                "mimes:pdf,jpg,jpeg,png",
                "max:2048",
            ],
            "ct_scan"       => [
                "nullable",
                Rule::requiredIf(!in_array($this->method(), ['PUT', 'PATCH'])),
                "mimes:pdf,jpg,jpeg,png",
                "max:2048",
            ],
            "hb"            => "required",
            "leukosit"      => "required",
            "trombosit"     => "required",
            "sgot"          => "required",
            "sgpt"          => "required",
            "urine"         => "required",
            "dc"            => "required",
        ];
    }

    public function attributes(): array
    {
        return [
            "date"              => "tanggal",
            "subjective"        => "subjektif",
            "semi_ps"           => "ps",
            "semi_bb"           => "bb",
            "toxity"            => "toksisitas",
            "toxity_detail"     => "toksisitas detail",
            "grade"             => "grade",
            "rontgen"           => "rontgen",
            "ct_scan"           => "ct scan",
            "hb"                => "hb",
            "leukosit"          => "leukosit",
            "trombosit"         => "trombosit",
            "sgot"              => "sgot",
            "sgpt"              => "sgpt",
            "urine"             => "urine",
            "dc"                => "dc",
            "description_fu"    => "deskripsi",
        ];
    }
}
