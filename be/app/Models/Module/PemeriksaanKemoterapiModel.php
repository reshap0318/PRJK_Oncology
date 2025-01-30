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
        "lini",
        "category",
        "dose",
        "description"
    ];

    protected $casts = [
        "lini"          => "integer",
        "category"      => "integer",
        "dose"          => "array",
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

    public function inspection()
    {
        return $this->belongsTo(PasienPemeriksaanModel::class, 'inspection_id', 'id');
    }

    public function fus()
    {
        return $this->hasMany(PemeriksaanKemoterapiFUModel::class, 'kemo_id', 'id');
    }
}
