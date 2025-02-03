<?php

namespace App\Http\Requests\Module;

use App\Models\Module\PasienPemeriksaanModel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PemeriksaanKemoterapiRequest extends FormRequest
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
            "lini"          => "required",
            "category"      => "required",
            "category_detail"=> "required|array",
            "dose"          => "required",
            "description"   => "nullable",

            "date"          => "required|date_format:Y-m-d",
            "siklus"        => "required",
            "subjective"    => "required",
            "semi_ps"       => "required",
            "semi_bb"       => "required",
            "toxity"        => "required",
            "toxity_detail" => "required",
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
            // "description_fu"=> "required",
        ];
    }

    public function attributes(): array
    {
        return [
            "lini"              => "lini",
            "category"          => "jenis kemoterapi",
            "category_detail"   => "",
            "dose"              => "dosis",
            "description"       => "deskripsi",

            "date"              => "tanggal",
            "siklus"            => "siklus",
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
