<?php

namespace App\Repository\Module;

use App\Models\Module\PemeriksaanSitologiModel;
use App\Repository\BaseRepository;

class PemeriksaanSitologiRepository extends BaseRepository
{
    public function __construct()
    {
        $this->query = new PemeriksaanSitologiModel();
    }
}
