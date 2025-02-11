<?php

namespace App\Models\Module;

use App\Helpers\Authorization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class PemeriksaanToraksScanModel extends Model
{
    use HasFactory;

    protected $table = 'i_toraks_scan';
    protected $primaryKey = 'id';

    protected $fillable = [
        "inspection_id",
        "date",
        "file_path",
        "description"
    ];

    protected $casts = [
        "date"          => 'date:Y-m-d',
    ];

    protected $appends = [
        'file_url',
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

    protected function fileUrl(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                return $this->file_path ? route('file.index', ['name' => str_replace("/", "_", $this->file_path)]) : null;
            }
        );
    }
}
