<?php

namespace App\Models\Module;

use App\Helpers\Authorization;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use PharIo\Manifest\Author;

class PemeriksaanOperasiModel extends Model
{
    use HasFactory;

    protected $table = 'i_operasi';
    protected $primaryKey = 'id';

    protected $fillable = [
        "inspection_id",
        "dokter",
        "date",
        "category",
        "margin",
        "description",
    ];

    protected $casts = [
        'date'          => 'date:d-m-Y',
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
}
