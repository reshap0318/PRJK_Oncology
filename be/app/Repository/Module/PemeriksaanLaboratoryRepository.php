<?php

namespace App\Repository\Module;

use App\Models\Module\PemeriksaanLaboratoryModel;
use App\Repository\BaseRepository;

class PemeriksaanLaboratoryRepository extends BaseRepository
{
    public function __construct()
    {
        $this->query = new PemeriksaanLaboratoryModel();
    }
}
