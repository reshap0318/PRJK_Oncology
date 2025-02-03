<?php

namespace App\Repository\Module;

use App\Models\Module\PemeriksaanLainnyaModel;
use App\Models\User;
use App\Repository\BaseRepository;

class PemeriksaanLainnyaRepository extends BaseRepository
{
    public function __construct()
    {
        $this->query = new PemeriksaanLainnyaModel();
    }
    
    public function datatable()
    {
        $this->query = $this->query;
        return $this;
    }
}
