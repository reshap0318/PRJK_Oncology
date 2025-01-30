<?php

namespace App\Repository\Module;

use App\Models\Module\PemeriksaanKemoterapiFUModel;
use App\Models\User;
use App\Repository\BaseRepository;

class PemeriksaanKemoterapiFURepository extends BaseRepository
{
    public function __construct()
    {
        $this->query = new PemeriksaanKemoterapiFUModel();
    }
    
    public function filterByKemoId($id)
    {
        $this->query = $this->query->where('kemo_id', $id);
        return $this;
    }

    public function filterByInitData()
    {
        $this->query = $this->query->orderBy('id', 'asc')->take(1);
        return $this;
    }
}
