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

    public function datatable(array $payload = [])
    {
        $pemeriksaanId = $payload['pemeriksaan_id'] ?? null;
        $query = $this->mainRepository->datatable()
            ->when($pemeriksaanId, function($query) use ($pemeriksaanId) {
                return $query->where('o.inspection_id', $pemeriksaanId);
            })
            ->getQuery();

        return DataTables::eloquent($query)
            ->addColumn('action', function ($data) {
                return $data->actionModel;
            })
            ->make(true);
    }
}
