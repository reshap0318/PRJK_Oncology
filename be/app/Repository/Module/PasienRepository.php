<?php

namespace App\Repository\Module;

use App\Models\Module\PasienModel;
use App\Repository\BaseRepository;

class PasienRepository extends BaseRepository
{
    public function __construct()
    {
        $this->query = new PasienModel();
    }
}
