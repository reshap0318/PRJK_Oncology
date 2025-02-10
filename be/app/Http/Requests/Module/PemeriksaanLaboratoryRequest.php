<?php

namespace App\Http\Requests\Module;

use App\Models\Module\PasienPemeriksaanModel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PemeriksaanLaboratoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    
    public function rules(): array
    {
        $pemeriksaanTbl = (new PasienPemeriksaanModel())->getTable();
        return [
            "inspection_id"         => ["required", Rule::exists($pemeriksaanTbl, "id")],
            "date"                  => "required|date_format:Y-m-d",
            "result"                => [
                "required",
                "mimes:pdf,jpg,jpeg,png",
                "max:2048",
            ],
            "hb"                    => "required",
            "leukosit"              => "required",
            "ht"                    => "required",
            "tr"                    => "required",
            "dc"                    => "required",
            "liver_function"        => "required",
            "procalsitonin"         => "required",
            "ginjal_ur"             => "required",
            "ginjal_cr"             => "required",
            "elektrolit_na"         => "required",
            "elektrolit_k"          => "required",
            "elektrolit_cl"         => "required",
            "agd_ph"                => "required",
            "agd_pco2"              => "required",
            "agd_po2"               => "required",
            "agd_hco3"              => "required",
            "agd_be"                => "required",
            "agd_so2"               => "required",
            "gds"                   => "required",
            "description"           => "nullable",
        ];
    }
}
