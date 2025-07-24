<?php

namespace App\Http\Requests\Module;

use App\Models\Module\PasienPemeriksaanModel;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PemeriksaanOperasiRequest extends FormRequest
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
            "dokter"        => "nullable",
            "date"          => "required|date_format:Y-m-d",
            "category"      => "nullable",
            "margin"        => "nullable",
            "description"   => "nullable",
        ];
    }

    public function attributes(): array
    {
        return [
            "dokter"            => "dokter",
            "date"              => "tanggal",
            "category"          => "kategori",
            "margin"            => "margin",
            "description"       => "deskripsi",
        ];
    }
}
