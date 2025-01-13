<?php

namespace App\Models\Module;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
