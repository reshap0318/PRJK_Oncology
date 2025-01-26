<?php

namespace App\Repository\Module;

use App\Models\Module\PasienPemeriksaanModel;
use App\Models\Module\PemeriksaanOperasiModel;
use App\Models\User;
use App\Repository\BaseRepository;

class PemeriksaanOperasiRepository extends BaseRepository
{
    public function __construct()
    {
        $this->query = new PemeriksaanOperasiModel();
    }

    public function filterByPasienId($id)
    {
        $this->query = $this->query->whereIn('inspection_id', PasienPemeriksaanModel::select(['id'])->where('pasien_id', $id));
        return $this;
    }
    
    public function datatable()
    {
        $tbl = (new PemeriksaanOperasiModel())->getTable();
        $this->query = $this->query->from("$tbl as o")
            ->select(['o.*', 'd.name as dokter_name'])
            ->join((new User())->getTable() . " as d", "d.id", "o.dokter_id");
        return $this;
    }
}
