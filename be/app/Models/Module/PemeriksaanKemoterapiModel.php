<?php

namespace App\Models\Module;

use App\Helpers\Authorization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class PemeriksaanKemoterapiModel extends Model
{
    use HasFactory;
    protected $table = 'i_kemoterapi';
    protected $primaryKey = 'id';

    protected $fillable = [
        "inspection_id",
        "date",
        "lini",
        "platinum_detail",
        "combination_detail",
        "dose",
    ];

    protected $casts = [
        'date'                  => 'date:d-m-Y',
        "lini"                  => "integer",
        "platinum_detail"       => "array",
        "combination_detail"    => "array",
    ];

    protected function actionModel(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                return [
                    'follow' => [
                        'isCan' => Authorization::hasPermission('pasien-pemeriksaan.show'),
                        'link'  => null,
                    ],
                    'edit' => [
                        'isCan' => Authorization::hasPermission('pasien-pemeriksaan.inspection'),
                        'link'  => null,
                    ],
                    'delete' => [
                        'isCan' => Authorization::hasPermission('pasien-pemeriksaan.inspection'),
                        'link'  => null,
                    ],
                ];
            }
        );
    }

    protected function platinumDetailText(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $list = [
                    1 => 'Karboplatin',
                    2 => 'Sisplatin'
                ];
                return array_map(function ($val) use ($list) {
                    return $list[$val] ?? '-';
                }, $this->platinum_detail);
            }
        );
    }

    protected function combinationDetailText(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $list = [
                    1 => 'Paklitaksel',
                    2 => 'Pemetreksed',
                    3 => 'Gemsitabin',
                    4 => 'Venorelbin',
                    5 => 'Dosetaksel'
                ];
                return array_map(function ($val) use ($list) {
                    return $list[$val] ?? '-';
                }, $this->combination_detail);
            }
        );
    }

    public function inspection()
    {
        return $this->belongsTo(PasienPemeriksaanModel::class, 'inspection_id', 'id');
    }

    public function fus()
    {
        return $this->hasMany(PemeriksaanKemoterapiFUModel::class, 'kemo_id', 'id');
    }
}
