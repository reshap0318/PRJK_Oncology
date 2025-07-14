<?php

namespace App\Models\Module;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemeriksaanFisikModel extends Model
{
    use HasFactory;

    protected $table = 'i_vital';
    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $fillable = [
        "id",
        "awareness",
        "condition",
        "td",
        "nadi",
        "rr",
        "suhu",
        "sp_o2",
        "vas",
        "description",
        "kgb",
        "inspeksi_statis",
        "inspeksi_dinamis",
        "auskultasi",
        "palpasi",
        "abdomen",
        "perkusi",
        "ekstemitas",
        "lainnya",
    ];

    protected $casts = [
        "condition"     => 'integer',
        // "td"            => 'integer',
        "nadi"          => 'integer',
        "rr"            => 'integer',
        "suhu"          => 'float:3,2',
        // "sp_o2"         => 'float:3,2',
        "vas"           => 'integer',
    ];
}
