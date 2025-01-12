<?php

namespace App\Models\Module;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemeriksaanOutcomeModel extends Model
{
    use HasFactory;

    protected $table = 'outcome';
    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $fillable = [
        "id",
        "keadaan_pulang",
        "cara_pulang",
        "lama_dirawat",
        "tanggal_meninggal",
        "sebab_kematian",
        "waktu_meninggal",
    ];

    protected $casts = [
        "tanggal_meninggal"     => 'date:Y-m-d',
        'waktu_meninggal'       => 'boolean'
    ];
}
