<?php

namespace App\Models\Module;

use App\Helpers\Authorization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class PemeriksaanKemoterapiFUModel extends Model
{
    use HasFactory;
    protected $table = 'i_kemoterapi_fu';
    protected $primaryKey = 'id';

    protected $fillable = [
        "kemo_id",
        "date",
        "siklus",
        "subjective",
        "semi_ps",
        "semi_bb",
        "toxity",
        "toxity_detail",
        "grade",
        "rontgen_path",
        "ct_scan_path",
        "hb",
        "leukosit",
        "trombosit",
        "sgot",
        "sgpt",
        "urine",
        "dc",
        "description",
    ];

    protected $casts = [
        'date'          => 'date:d-m-Y',
        "semi_ps"       => 'float:5,2',
        "semi_bb"       => 'float:5,2',
        "hb"            => 'float:3,2',
        "leukosit"      => 'float:3,2',
        "trombosit"     => 'float:3,2',
        "sgot"          => 'float:3,2',
        "sgpt"          => 'float:3,2',
        "urine"         => 'float:3,2',
    ];

    protected $appends = [
        'rontgen_url',
        'ct_scan_url',
    ];

    protected function actionModel(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                return [
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

    protected function rontgenUrl(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                return $this->rontgen_path ? route('file.index', ['name' => str_replace("/", "_", $this->rontgen_path)]) : null;
            }
        );
    }

    protected function ctScanUrl(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                return $this->ct_scan_path ? route('file.index', ['name' => str_replace("/", "_", $this->ct_scan_path)]) : null;
            }
        );
    }

    public function kemo()
    {
        return $this->belongsTo(PemeriksaanKemoterapiModel::class, 'kemo_id', 'id');
    }
}
