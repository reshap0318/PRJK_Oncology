<?php

namespace App\Repository\Module;

use App\Models\Module\PasienPemeriksaanModel;
use App\Models\Module\PemeriksaanSicknessModel;
use App\Repository\BaseRepository;

class PemeriksaanSicknessRepository extends BaseRepository
{
    public function __construct()
    {
        $this->query = new PemeriksaanSicknessModel();
    }

    public function filterByPasienId($id)
    {
        $this->query = $this->query->whereIn('inspection_id', PasienPemeriksaanModel::select(['id'])->where('pasien_id', $id));
        return $this;
    }

    public function filterByHistory($pasien_id, $pemeriksaa_id = null)
    {
        $this->query = $this->query
            ->whereIn(
                'inspection_id',
                PasienPemeriksaanModel::select(['id'])
                    ->where('pasien_id', $pasien_id)
                    ->when($pemeriksaa_id, function ($q) use ($pemeriksaa_id) {
                        return $q->where('id', '<', $pemeriksaa_id);
                    })
            );
        return $this;
    }
}
