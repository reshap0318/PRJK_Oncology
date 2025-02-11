<?php

namespace App\Repository\Module;

use App\Models\Module\PasienModel;
use App\Models\Module\PemeriksaanToraksUsgModel;
use App\Repository\BaseRepository;

class PemeriksaanToraksUsgRepository extends BaseRepository
{
    public function __construct()
    {
        $this->query = new PemeriksaanToraksUsgModel();
    }
}
