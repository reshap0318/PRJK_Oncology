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
            "kemo_id"       => ["required", Rule::exists($kemoTbl, "id")],
            "date"          => "nullable|date_format:Y-m-d",
            "siklus"        => "nullable",
            "subjective"    => "nullable",
            "semi_ps"       => "nullable",
            "semi_bb"       => "nullable",
            "toxity"        => "nullable",
            "grade"         => "nullable",
            "rontgen"       => [
                "nullable",
                // Rule::requiredIf(!in_array($this->method(), ['PUT', 'PATCH'])),
                "mimes:pdf,jpg,jpeg,png",
                "max:2048",
            ],
            "ct_scan"       => [
                "nullable",
                // Rule::requiredIf(!in_array($this->method(), ['PUT', 'PATCH'])),
                "mimes:pdf,jpg,jpeg,png",
                "max:2048",
            ],
            "hb"            => "nullable",
            "leukosit"      => "nullable",
            "trombosit"     => "nullable",
            "sgot"          => "nullable",
            "sgpt"          => "nullable",
            "urine"         => "nullable",
            "dc"            => "nullable",
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
