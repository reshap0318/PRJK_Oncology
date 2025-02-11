<?php

namespace App\Repository\Module;

use App\Models\Module\PasienModel;
use App\Models\Module\PemeriksaanMriKepalaModel;
use App\Repository\BaseRepository;

class PemeriksaanMriKepalaRepository extends BaseRepository
{
    public function __construct()
    {
        $this->query = new PemeriksaanMriKepalaModel();
    }
}
