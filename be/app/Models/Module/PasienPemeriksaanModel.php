<?php

namespace App\Models\Module;

use App\Helpers\Authorization;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Auth;

class PasienPemeriksaanModel extends Model
{
    use HasFactory;

    protected $table = 'inspection';

    protected $fillable = [
        "user_id",
        "pasien_id",
        "inspection_at",
        "type",
    ];

    protected $casts = [
        'inspection_at'   => 'date:Y-m-d',
    ];

    public function getTableCon(): string
    {
        return $this->getConnectionName() . "." . $this->getTable();
    }

    protected function actionModel(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $isDokter = $this->user_id == Auth::id() || Authorization::hasPermission('pasien-pemeriksaan.all');
                return [
                    'detail' => [
                        'isCan' => Authorization::hasPermission('pasien-pemeriksaan.show'),
                        'link'  => null,
                    ],
                    'periksa' => [
                        'isCan' => Authorization::hasPermission('pasien-pemeriksaan.show') && $isDokter,
                        'link'  => null,
                    ],
                    'delete' => [
                        'isCan' => Authorization::hasPermission('pasien-pemeriksaan.delete'),
                        'link'  => null,
                    ],
                ];
            }
        );
    }

    public function pasien()
    {
        return $this->hasOne(PasienModel::class, 'id', 'pasien_id')->withDefault(['name' => 'tidak ditemukan']);
    }

    public function dokter()
    {
        return $this->hasOne(User::class, 'id', 'user_id')->withDefault(['name' => 'tidak ditemukan']);
    }

    public function diagnosa()
    {
        return $this->hasOne(PemeriksaanDiagnosaModel::class, 'id', 'id')->withDefault([
            "jenis_sel"     => [],
            "paru"          => [],
            "stage"         => [],
            "staging"       => [],
            "ps"            => [],
            "egfr"          => null,
            "mutasi"        => null,
            "pdl1"          => null,
            "alk"           => [],
            "komorbid"      => null,
        ]);
    }

    public function outcome()
    {
        return $this->hasOne(PemeriksaanOutcomeModel::class, 'id', 'id')->withDefault([
            "keadaan_pulang"        => null,
            "cara_pulang"           => null,
            "lama_dirawat"          => null,
            "tanggal_meninggal"     => null,
            "sebab_kematian"        => null,
            "waktu_meninggal"       => null,
        ]);
    }

    public function vital()
    {
        return $this->hasOne(PemeriksaanFisikModel::class, 'id', 'id')->withDefault([
            "awareness"         => null,
            "condition"         => null,
            "td"                => null,
            "nadi"              => null,
            "rr"                => null,
            "suhu"              => null,
            "sp_o2"             => null,
            "vas"               => null,
            "description"       => null,
            "kgb"               => null,
            "inspeksi_statis"   => null,
            "inspeksi_dinamis"  => null,
            "auskultasi"        => null,
            "palpasi"           => null,
            "abdomen"           => null,
            "perkusi"           => null,
            "ekstemitas"        => null,
        ]);
    }

    public function riskFactors()
    {
        return $this->hasMany(PemeriksaanFaktorResikoModel::class, 'inspection_id', 'id');
    }

    public function smokingHistory()
    {
        return $this->hasOne(PemeriksaanSmokingHistoryModel::class, 'id', 'id')->withDefault([
            "history"       => 3,
            "stick_day"     => null,
            "count_year"    => null,
            "ib"            => 3,
            "category"      => null,
            "suck"          => 0
        ]);
    }

    public function complains()
    {
        return $this->hasMany(PemeriksaanComplainModel::class, 'inspection_id', 'id');
    }

    public function sickness()
    {
        return $this->hasMany(PemeriksaanSicknessModel::class, 'inspection_id', 'id');
    }

    public function operasis()
    {
        return $this->hasMany(PemeriksaanOperasiModel::class, 'inspection_id', 'id');
    }

    public function paalParu()
    {
        return $this->hasOne(PemeriksaanPaalParuModel::class, 'id', 'id')->withDefault([
            "kvp_ml"        => null,
            "kvp_percent"   => null,
            "vep_ml"        => null,
            "vep_percent"   => null,
            "vep_kvp"       => null,
            "description"   => null
        ]);
    }

    public function bronkoskopi()
    {
        return $this->hasOne(PemeriksaanBronkoskopiModel::class, 'id', 'id')->withDefault([
            "vocal_cords"   => null,
            "trachea"       => null,
            "carina"        => null,

            "r_bu"          => null,
            "r_carina_second"   => null,
            "r_la"          => null,
            "r_lb"          => null,
            "r_ti"          => null,
            "r_lm"          => null,
            
            "l_bu"          => null,
            "l_carina_second"   => null,
            "l_la"          => null,
            "l_lb"          => null,
            "l_ld"          => null,
        ]);
    }

    public function sitologis()
    {
        return $this->hasMany(PemeriksaanSitologiModel::class, 'inspection_id', 'id');
    }

    public function laboratoryResult()
    {
        return $this->hasOne(PemeriksaanLaboratoryModel::class, 'id', 'id')->withDefault([
            "result_path"       => null,
            "hb"                => null,
            "leukosit"          => null,
            "ht"                => null,
            "tr"                => null,
            "dc"                => null,
            "liver_function"    => null,
            "procalsitonin"     => null,
            "ginjal_ur"         => null,
            "ginjal_cr"         => null,
            "ginjal_cct"        => null,
            "elektrolit_na"     => null,
            "elektrolit_k"      => null,
            "elektrolit_cl"     => null,
            "agd_ph"            => null,
            "agd_pco2"          => null,
            "agd_po2"           => null,
            "agd_hco3"          => null,
            "agd_be"            => null,
            "agd_so2"           => null,
            "gds"               => null,
            "description"       => null
        ]);
    }
}
