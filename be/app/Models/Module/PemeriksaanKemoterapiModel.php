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
        "category",
        "category_detail",
        "dose",
    ];

    protected $casts = [
        'date'              => 'date:Y-m-d',
        "lini"              => "integer",
        "category"          => "integer",
        "category_detail"   => "array",
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
    
    protected function categoryText(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $list = [
                    1 => 'Platinum',
                    2 => 'Kombinasi',
                ];
                return $list[$this->category] ?? 'Tidak Diketahui';
            }
        );
    }
    
    protected function categoryDetailText(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $list = [
                    1 => 'Anemia',
                    2 => 'Leukositosis',
                    3 => 'Trombositopemia',
                    4 => 'Allopesia',
                    5 => 'Neuropati Perifer',
                    6 => 'Lainnya',
                ];
                return array_map(function($val) use ($list) {
                    return $list[$val] ?? 'Tidak Diketahui';
                }, $this->category_detail);
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
