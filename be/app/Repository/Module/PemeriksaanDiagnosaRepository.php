<?php

namespace App\Repository\Module;

use App\Models\Module\PasienModel;
use App\Models\Module\PemeriksaanDiagnosaModel;
use App\Repository\BaseRepository;

class PemeriksaanDiagnosaRepository extends BaseRepository
{
    public function __construct()
    {
        $this->query = new PemeriksaanDiagnosaModel();
    }
}
