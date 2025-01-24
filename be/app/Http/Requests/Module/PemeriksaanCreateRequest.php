<?php

namespace App\Http\Requests\Module;

use App\Models\Module\PasienModel;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PemeriksaanCreateRequest extends FormRequest
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
            'dokter_id' => [
                'required',
                Rule::exists($tblDokter, 'id')->where(function ($q) {
                    return $q->whereRaw("id in (select user_id from user_has_roles where role_id = ?)", [User::R_DOKTER]);
                })
            ],
            'pasien_id' => [
                'required',
                Rule::exists($tblPasien, "id")
            ],
            'tanggal'   => 'required|date_format:Y-m-d',
        ];
    }

    public function attributes(): array
    {
        return [
            'dokter_id' => 'dokter',
            'pasien_id' => 'pasien',
            'tanggal'   => 'tanggal',
        ];
    }
}
