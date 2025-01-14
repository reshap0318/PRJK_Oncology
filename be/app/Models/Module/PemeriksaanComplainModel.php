<?php

namespace App\Models\Module;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemeriksaanComplainModel extends Model
{
    use HasFactory;
    protected $table = 'i_complain';
    protected $primaryKey = 'id';

    protected $fillable = [
        "inspection_id",
        "description",
        "duration",
        "tag"
    ];

    protected $casts = [
        "duration"      => 'integer',
        "tag"           => 'integer',
    ];

    const T_KELUHAN = 1;
    const T_GEJALA = 2;
}
