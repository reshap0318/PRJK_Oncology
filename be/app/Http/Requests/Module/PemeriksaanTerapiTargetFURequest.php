<?php

namespace App\Http\Requests\Module;

use App\Models\Module\PemeriksaanTerapiTargetModel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PemeriksaanTerapiTargetFURequest extends FormRequest
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
        $terapiTbl = (new PemeriksaanTerapiTargetModel())->getTable();
        return [
            "target_id"         => ["required", Rule::exists($terapiTbl, "id")],
            "date"              => "required|date_format:Y-m-d",
            "subjective"        => "nullable",
            "semi_subjective"   => "nullable",
            "toxity"            => "nullable",
            "toxity_detail"     => "nullable",
            "grade"             => "nullable",
            "ct_scan"           => [
                "nullable",
                "mimes:pdf,jpg,jpeg,png",
                "max:2048",
            ],
            "side_effect"        => "nullable",
            "description"        => "nullable",
        ];
    }

    public function attributes(): array
    {
        return [
            "date"              => "tanggal",
            "subjective"        => "subjektif",
            "semi_subjective"   => "semi subjektif",
            "toxity"            => "toxity",
            "toxity_detail"     => "toksisitas detail",
            "grade"             => "grade",
            "side_effect"       => "side effect",
            "ct_scan"           => "ct scan",
            "description"       => "recist",
        ];
    }
}
