<?php

namespace App\Repository\Module;

use App\Models\Module\PasienPemeriksaanModel;
use App\Repository\BaseRepository;

class PasienPemeriksaanRepository extends BaseRepository
{
    public function __construct()
    {
        $this->query = new PasienPemeriksaanModel();
    }

    public function filterByPasienId($id)
    {
        $this->query = $this->query->where('pasien_id', $id);
        return $this;
    }
}
