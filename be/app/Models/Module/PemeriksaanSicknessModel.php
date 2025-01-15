<?php

namespace App\Models\Module;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemeriksaanSicknessModel extends Model
{
    use HasFactory;

    protected $table = 'i_sickness';
    protected $primaryKey = 'id';

    protected $fillable = [
        "inspection_id",
        "description"
    ];
}
