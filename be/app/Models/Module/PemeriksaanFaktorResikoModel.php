<?php

namespace App\Models\Module;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemeriksaanFaktorResikoModel extends Model
{
    use HasFactory;

    protected $table = 'i_risk_factor';
    protected $primaryKey = 'id';

    protected $fillable = [
        "inspection_id",
        "category",
        "own",
        "value"
    ];

    protected $casts = [
        "value"         => 'json',
        "category"      => 'integer',
        'own'           => 'integer'
    ];

    // const K_RIWAYAT_ROKOK = 1;
    const K_PAPARAN_ASAP_ROKOK = 1;
    const K_PEKERJAAN_BERESIKO = 2;
    const K_TEMPAT_TINGGAL_SEKITAR_PABRIK = 3;
    const K_RIWAYAT_KEGANASAN_ORGAN_LAIN = 4;
    const K_PAPARAN_RADON = 5;
    const K_BIOMESS = 6;
    const K_RIWAYAT_PPOK = 7;
    const K_RIWAYAT_TB = 8;
    const K_RIWAYAT_KEGANASAN_DALAM_KELUARGA = 9;
}
