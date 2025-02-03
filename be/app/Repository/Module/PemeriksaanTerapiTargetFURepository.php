<?php

namespace App\Repository\Module;

use App\Models\Module\PemeriksaanTerapiTargetFUModel;
use App\Models\User;
use App\Repository\BaseRepository;

class PemeriksaanTerapiTargetFURepository extends BaseRepository
{
    public function __construct()
    {
        $this->query = new PemeriksaanTerapiTargetFUModel();
    }
    
    public function filterByTargetId($id)
    {
        $this->query = $this->query->where('target_id', $id);
        return $this;
    }
}
