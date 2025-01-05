<?php

namespace App\Http\Requests\Module;

use App\Models\Module\PasienModel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PasienRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }
    
    public function rules(): array
    {
        $tbl = (new PasienModel())->getTableCon();
        return [
            "no_mr"     => [
                "required",
                "string",
                "max:10",
                Rule::unique($tbl, "no_mr")->when(in_array($this->method(), ['PUT', 'PATCH']), function($q)
                {
                    $id = $this->route()->parameter('id');
                    return $q->ignore($id);
                })
            ],
            "name"      => "required|string|max:100",
            "gender"    => "required|boolean",
            "dob"       => "required|date",
            "pob"       => "required",
            "phone"     => "nullable",
            "email"     => "nullable",
            "address"   => "nullable",
            "education" => "nullable",
            "job"       => "nullable",
            "ethnic"    => "nullable"
        ];
    }

    public function attributes(): array
    {
        return [
            "no_mr"     => "no. mr",
            "name"      => "nama",
            "gender"    => "jenis kelamin",
            "dob"       => "tanggal lahir",
            "pob"       => "tempat lahir",
            "phone"     => "telepon",
            "email"     => "email",
            "address"   => "alamat",
            "education" => "pendidikan",
            "job"       => "pekerja",
            "ethnic"    => "suku"
        ];
    }
}
