<?php

namespace App\Repository\Module;

use App\Models\Module\PemeriksaanRadioterapiModel;
use App\Models\User;
use App\Repository\BaseRepository;

class PemeriksaanRadioterapiRepository extends BaseRepository
{
    public function __construct()
    {
        $this->query = new PemeriksaanRadioterapiModel();
    }
    
    public function datatable()
    {
        $this->query = $this->query;
        return $this;
    }
}
