<?php

namespace App\Repository\Module;

use App\Models\Module\PemeriksaanKemoterapiFUModel;
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
        $sub = PemeriksaanKemoterapiFUModel::select('kemo_id', 'date', 'description')
            ->orderBy('date', 'asc')
            ->groupBy('kemo_id');

        $this->query = $this->query->from((new PemeriksaanKemoterapiModel)->getTable() . ' as kemo')
            ->select('kemo.*', 'fu.date as fu_date', 'fu.description as fu_description')
            ->leftJoinSub($sub, 'fu', 'fu.kemo_id', 'kemo.id');
        return $this;
    }
}
