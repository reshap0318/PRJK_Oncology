<?php

namespace App\Repository\Module;

use App\Models\Module\PasienModel;
use App\Models\Module\PasienPemeriksaanModel;
use App\Models\User;
use App\Repository\BaseRepository;

class PasienPemeriksaanRepository extends BaseRepository
{
    public function __construct()
    {
        $this->query = new PasienPemeriksaanModel();
    }

    public function filterByPasienId($id)
    {
        $this->query = $this->query->where('pasien_id', $id);
        return $this;
    }

    public function datatable()
    {
        $tbl = (new PasienPemeriksaanModel())->getTable();
        $this->query = $this->query->from("$tbl as pm")
            ->select(['pm.*', 'd.name as dokter_name', 'p.name as pasien_name'])
            ->join((new User())->getTable() . " as d", "d.id", "pm.user_id")
            ->join((new PasienModel())->getTable() . " as p", "p.id", "pm.pasien_id");
        return $this;
    }

    public function getDetailData()
    {
        $this->query = $this->query->with([
            'diagnosa',
            'outcome',
            'vital',
            'riskFactors',
            'smokingHistory',
            'complains:id,description,duration,tag,inspection_id',
            'sickness:id,description,inspection_id',
            'paalParu',
        ]);
        return $this;
    }
}
