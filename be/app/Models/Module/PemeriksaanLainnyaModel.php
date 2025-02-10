<?php

namespace App\Models\Module;

use App\Helpers\Authorization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class PemeriksaanLainnyaModel extends Model
{
    use HasFactory;

    protected $table = 'i_other';
    protected $primaryKey = 'id';

    protected $fillable = [
        "inspection_id",
        // "date",
        "inspector_name",
        "result",
        "description",
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

    public function inspection()
    {
        return $this->belongsTo(PasienPemeriksaanModel::class, 'inspection_id', 'id');
    }
}
