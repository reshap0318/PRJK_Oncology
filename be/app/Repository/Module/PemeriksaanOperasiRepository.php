<?php

namespace App\Repository\Module;

use App\Models\Module\PasienPemeriksaanModel;
use App\Models\Module\PemeriksaanOperasiModel;
use App\Models\User;
use App\Repository\BaseRepository;

class PemeriksaanOperasiRepository extends BaseRepository
{
    public function __construct()
    {
        $this->query = new PemeriksaanOperasiModel();
    }

    public function filterByPasienId($id)
    {
        $this->query = $this->query->whereIn('inspection_id', PasienPemeriksaanModel::select(['id'])->where('pasien_id', $id));
        return $this;
    }

    public function datatable()
    {
        $this->query = $this->query;
        return $this;
    }
}
