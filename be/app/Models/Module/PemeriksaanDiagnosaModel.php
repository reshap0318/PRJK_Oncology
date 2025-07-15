<?php

namespace App\Models\Module;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class PemeriksaanDiagnosaModel extends Model
{
    use HasFactory;

    protected $table = 'i_diagnosa';
    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $fillable = [
        "id",
        "jenis_sel",
        "paru",
        "stage",
        "staging_t",
        "staging_n",
        "staging_m",
        "ps",
        "mutasi",
        "pdl1",
        "alk",
        "komorbid",
        "complication"
    ];

    protected $casts = [
        'jenis_sel'     => 'array',
        "paru"          => 'array',
        "stage"         => 'array',
        "ps"            => 'array',
        "alk"           => 'array',
    ];

    protected function jenisSelText(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $list = [
                    1 => 'Sel Kecil',
                    2 => 'Sel Besar',
                    3 => 'Adenokarsenoma',
                    4 => 'KSS',
                    5 => 'KPKBSK',
                ];
                if (is_array($this->jenis_sel)) {
                    return array_map(function ($val) use ($list) {
                        return $list[$val] ?? '-';
                    }, $this->jenis_sel);
                }
                return [];
            }
        );
    }

    protected function alkText(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $list = [
                    1 => 'Fusi(-)',
                    2 => 'Fusi(+)',
                ];
                if (is_array($this->alk)) {
                    return array_map(function ($val) use ($list) {
                        return $list[$val] ?? '-';
                    }, $this->alk);
                }
                return [];
            }
        );
    }

    protected function stageText(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $list = [
                    1 => 'IA',
                    2 => 'IIA',
                    3 => 'IIIA',
                    4 => 'IVA',

                    5 => 'IB',
                    6 => 'IIB',
                    7 => 'IIIB',
                    8 => 'IVB',

                    9 => 'IIIC',
                ];

                if (is_array($this->stage)) {
                    return array_map(function ($val) use ($list) {
                        return $list[$val] ?? '-';
                    }, $this->stage);
                }
                return [];
            }
        );
    }

    protected function paruText(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $list = [
                    1 => 'Kiri',
                    2 => 'Kanan',
                ];
                if (is_array($this->paru)) {
                    return array_map(function ($val) use ($list) {
                        return $list[$val] ?? '-';
                    }, $this->paru);
                }
                return [];
            }
        );
    }
}
