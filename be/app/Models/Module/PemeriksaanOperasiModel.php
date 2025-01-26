<?php

namespace App\Models\Module;

use App\Helpers\Authorization;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class PemeriksaanOperasiModel extends Model
{
    use HasFactory;

    protected $table = 'i_operasi';
    protected $primaryKey = 'id';

    protected $fillable = [
        "inspection_id",
        "dokter_id",
        "date",
        "category",
        "margin",
        "description",
    ];

    protected $casts = [
        'date'          => 'date:Y-m-d',
        'margin'        => 'array',
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

    public function dokter()
    {
        return $this->hasOne(User::class, 'id', 'dokter_id')->withDefault(['name' => 'tidak ditemukan']);
    }
}
