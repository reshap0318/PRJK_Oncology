<?php

namespace App\Repository\Module;

use App\Models\Module\PemeriksaanFaktorResikoModel;
use App\Repository\BaseRepository;

class PemeriksaanFaktorResikoRepository extends BaseRepository
{
    public function __construct()
    {
        $this->query = new PemeriksaanFaktorResikoModel();
    }
}
