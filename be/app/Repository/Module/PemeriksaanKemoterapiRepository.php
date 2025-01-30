<?php

namespace App\Repository\Module;

use App\Models\Module\PemeriksaanKemoterapiModel;
use App\Models\User;
use App\Repository\BaseRepository;

class PemeriksaanKemoterapiRepository extends BaseRepository
{
    public function __construct()
    {
        $this->query = new PemeriksaanKemoterapiModel();
    }
    
    public function datatable()
    {
        $this->query = $this->query;
        return $this;
    }
}
