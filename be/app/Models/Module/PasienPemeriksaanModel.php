<?php

namespace App\Models\Module;

use App\Helpers\Authorization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

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
                return [
                    'detail' => [
                        'isCan' => Authorization::hasPermission('pasien-pemeriksaan.show'),
                        'link'  => null,
                    ],
                    'periksa' => [
                        'isCan' => Authorization::hasPermission('pasien-pemeriksaan.inspection'),
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
        return $this->hasOne(PasienModel::class, 'id', 'user_id')->withDefault(['name' => 'tidak ditemukan']);
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
            "whild_type"    => 0,
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

    public function fisik()
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
}
