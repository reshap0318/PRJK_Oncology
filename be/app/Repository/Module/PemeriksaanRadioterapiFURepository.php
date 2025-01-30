<?php

namespace App\Repository\Module;

use App\Models\Module\PemeriksaanRadioterapiFUModel;
use App\Models\User;
use App\Repository\BaseRepository;

class PemeriksaanRadioterapiFURepository extends BaseRepository
{
    public function __construct()
    {
        $this->query = new PemeriksaanRadioterapiFUModel();
    }
    
    public function filterByRadioId($id)
    {
        $this->query = $this->query->where('radio_id', $id);
        return $this;
    }
}
