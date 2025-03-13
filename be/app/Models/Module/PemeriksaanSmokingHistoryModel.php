<?php

namespace App\Models\Module;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class PemeriksaanSmokingHistoryModel extends Model
{
    use HasFactory;
    protected $table = 'i_smoking_history';
    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $fillable = [
        "history",
        "stick_day",
        "count_year",
        "ib",
        "category",
        "suck"
    ];

    protected $casts = [
        "history"       => 'integer',
        "stick_day"     => 'integer',
        "count_year"    => 'integer',
        "ib"            => 'integer',
        "category"      => 'integer',
        "suck"          => 'integer',
    ];

    protected function historyText(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $list = [
                    1 => 'Perokok',
                    2 => 'Bebas Perokok',
                    3 => 'Bukan Perokok',
                ];
                return $list[$this->history] ?? 'Bukan Perokok';
            }
        );
    }

    protected function categoryText(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $list = [
                    1 => 'Kretek',
                    2 => 'Filter',
                    3 => 'Cigar',
                ];
                return $list[$this->category] ?? 'Kretek';
            }
        );
    }

    protected function suckText(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $list = [
                    0 => 'Tidak Dalam',
                    1 => 'Dalam',
                ];
                return $list[$this->suck] ?? 'Tidak Dalam';
            }
        );
    }
}
