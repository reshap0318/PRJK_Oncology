<?php

namespace App\Repository\Module;

use App\Models\Module\PasienModel;
use App\Models\Module\PemeriksaanToraksFotoModel;
use App\Repository\BaseRepository;

class PemeriksaanToraksFotoRepository extends BaseRepository
{
    public function __construct()
    {
        $this->query = new PemeriksaanToraksFotoModel();
    }
}
