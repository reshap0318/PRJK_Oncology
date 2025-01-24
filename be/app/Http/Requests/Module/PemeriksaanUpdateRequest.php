<?php

namespace App\Http\Requests\Module;

use App\Models\Module\PasienModel;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PemeriksaanUpdateRequest extends FormRequest
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
        $tblDokter = (new User())->getTableCon();
        $tblPasien = (new PasienModel())->getTable();
        return [
            'overview.dokter_id' => [
                'required',
                Rule::exists($tblDokter, 'id')->where(function ($q) {
                    return $q->whereRaw("id in (select user_id from user_has_roles where role_id = ?)", [User::R_DOKTER]);
                })
            ],
            'overview.pasien_id' => [
                'required',
                Rule::exists($tblPasien, "id")
            ],
            'overview.tanggal'   => 'required|date_format:Y-m-d',
        ];
    }

    public function attributes(): array
    {
        return [
            'overview.dokter_id' => 'dokter',
            'overview.pasien_id' => 'pasien',
            'overview.tanggal'   => 'tanggal',
        ];
    }
}
