<?php

namespace App\Repository\Module;

use App\Models\Module\PasienModel;
use App\Models\Module\PemeriksaanToraksScanModel;
use App\Repository\BaseRepository;

class PemeriksaanToraksScanRepository extends BaseRepository
{
    public function __construct()
    {
        $this->query = new PemeriksaanToraksScanModel();
    }
}
