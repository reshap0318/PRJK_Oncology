<?php

namespace App\Models\Module;

use App\Helpers\Authorization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class PemeriksaanRadioterapiModel extends Model
{
    use HasFactory;
    protected $table = 'i_radioterapi';
    protected $primaryKey = 'id';

    protected $fillable = [
        "inspection_id",
        "date",
        "category",
        "dose",
        "fraksi",
        "ct_scan_path",
        "description",
    ];

    protected $casts = [
        'date'          => 'date:Y-m-d',
        "category"      => "integer",
    ];

    protected $appends = [
        'ct_scan_url',
    ];

    const C_EMERGENCY = 1;
    const C_KEPALA = 2;
    const C_KURATIF = 3;

    const CATEGORY_LIST = [
        self::C_EMERGENCY   => 'Radioterapi Emergency',
        self::C_KEPALA      => 'Radioterapi Kepala',
        self::C_KURATIF     => 'Radioterapi Kuratif'
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
                return self::CATEGORY_LIST[$this->category] ?? 'Tidak Diketahui';
            }
        );
    }

    public function inspection()
    {
        return $this->belongsTo(PasienPemeriksaanModel::class, 'inspection_id', 'id');
    }

    public function fus()
    {
        return $this->hasMany(PemeriksaanRadioterapiFUModel::class, 'radio_id', 'id');
    }
}
