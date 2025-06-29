<?php

namespace App\Models\Module;

use App\Helpers\Authorization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class PemeriksaanRadioterapiFUModel extends Model
{
    use HasFactory;
    protected $table = 'i_radioterapi_fu';
    protected $primaryKey = 'id';

    protected $fillable = [
        "radio_id",
        "date",
        "ct_scan_path"
    ];

    protected $casts = [
        'date'          => 'date:d-m-Y',
    ];

    protected $appends = [
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

    protected function ctScanUrl(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                return $this->ct_scan_path ? route('file.index', ['name' => str_replace("/", "_", $this->ct_scan_path)]) : null;
            }
        );
    }
}
