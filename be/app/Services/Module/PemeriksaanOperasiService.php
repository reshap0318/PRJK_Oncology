<?php

namespace App\Services\Module;

use App\Repository\Module\PemeriksaanOperasiRepository;
use App\Services\BaseService;
use Yajra\DataTables\Facades\DataTables;

class PemeriksaanOperasiService extends BaseService
{
    protected $mainRepository;
    public function __construct()
    {
        $this->mainRepository = new PemeriksaanOperasiRepository();
    }

    public function getById($id)
    {
        $data = $this->mainRepository->filterById($id)->first();
        abort_if(!$data, 404, "halaman tidak ditemukan");
        return $data;
    }

    public function getData(array $payload = [])
    {
        $pemeriksaanId = $payload['pemeriksaan_id'] ?? null;
        $q = $this->mainRepository->datatable()
            ->when($pemeriksaanId, function ($query) use ($pemeriksaanId) {
                return $query->where('o.inspection_id', $pemeriksaanId);
            });
        return $q;
    }

    public function datatable(array $payload = [])
    {
        $query = $this->getData($payload)->getQuery();

        return DataTables::eloquent($query)
            ->addColumn('action', function ($data) {
                return $data->actionModel;
            })
            ->make(true);
    }
}
