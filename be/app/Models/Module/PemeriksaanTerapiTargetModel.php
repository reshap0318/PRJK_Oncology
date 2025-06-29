<?php

namespace App\Models\Module;

use App\Helpers\Authorization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class PemeriksaanTerapiTargetModel extends Model
{
    use HasFactory;
    protected $table = 'i_terapeutic_target';
    protected $primaryKey = 'id';

    protected $fillable = [
        "inspection_id",
        "date",
        "category",
        "type",
        "long",
        "ct_scan_path",
        "side_effect",
        "description",
    ];

    protected $casts = [
        'date'          => 'date:d-m-Y',
        "category"      => "integer",
        "long"          => "integer",
    ];

    protected $appends = [
        'ct_scan_url',
    ];

    const C_TKI = 1;
    const C_ANTI_PD = 2;
    const C_ANTI_ALK = 3;

    const CATEGORY_LIST = [
        self::C_TKI   => 'TKI',
        self::C_ANTI_PD      => 'Anti PD-L1',
        self::C_ANTI_ALK     => 'Anti ALK'
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

    protected function ctScanUrl(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                return $this->ct_scan_path ? route('file.index', ['name' => str_replace("/", "_", $this->ct_scan_path)]) : null;
            }
        );
    }

    protected function categoryText(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                return self::CATEGORY_LIST[$this->category] ?? '-';
            }
        );
    }

    public function inspection()
    {
        return $this->belongsTo(PasienPemeriksaanModel::class, 'inspection_id', 'id');
    }

    public function fus()
    {
        return $this->hasMany(PemeriksaanTerapiTargetFUModel::class, 'radio_id', 'id');
    }
}
