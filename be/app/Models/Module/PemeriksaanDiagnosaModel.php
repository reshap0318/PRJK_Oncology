<?php

namespace App\Models\Module;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemeriksaanDiagnosaModel extends Model
{
    use HasFactory;

    protected $table = 'i_diagnosa';
    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $fillable = [
        "id",
        "jenis_sel",
        "paru",
        "stage",
        "staging",
        "ps",
        "mutasi",
        "whild_type",
        "pdl1",
        "alk",
        "komorbid",
    ];

    protected $casts = [
        'jenis_sel'     => 'array',
        "paru"          => 'array',
        "stage"         => 'array',
        "staging"       => 'array',
        "ps"            => 'array',
        "alk"           => 'array',
        'whild_type'    => 'integer'
    ];
}
