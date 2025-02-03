<?php

namespace App\Repository\Module;

use App\Models\Module\PemeriksaanTerapiTargetModel;
use App\Models\User;
use App\Repository\BaseRepository;

class PemeriksaanTerapiTargetRepository extends BaseRepository
{
    public function __construct()
    {
        $this->query = new PemeriksaanTerapiTargetModel();
    }
    
    public function datatable()
    {
        $this->query = $this->query;
        return $this;
    }
}
