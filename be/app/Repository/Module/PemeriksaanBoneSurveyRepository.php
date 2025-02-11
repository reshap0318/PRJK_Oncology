<?php

namespace App\Repository\Module;

use App\Models\Module\PasienModel;
use App\Models\Module\PemeriksaanBoneSurveyModel;
use App\Repository\BaseRepository;

class PemeriksaanBoneSurveyRepository extends BaseRepository
{
    public function __construct()
    {
        $this->query = new PemeriksaanBoneSurveyModel();
    }
}
