<?php

namespace App\Services\Module;

use App\Repository\Module\PemeriksaanLaboratoryRepository;
use App\Services\BaseService;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class PemeriksaanLaboratoryService extends BaseService
{
    protected $mainRepository;
    public function __construct()
    {
        $this->mainRepository = new PemeriksaanLaboratoryRepository();
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
        $query = $this->mainRepository
            ->getQuery()
            ->when($pemeriksaanId, function($query) use ($pemeriksaanId) {
                return $query->where('inspection_id', $pemeriksaanId);
            });

        return DataTables::eloquent($query)
            ->addColumn('action', function ($data) {
                return $data->actionModel;
            })
            ->make(true);
    }

    public function create($payload)
    {
        $data = $this->mainRepository->create($payload);

        if(isset($payload['result']) && $payload['result']->isValid()) {
            $fileName = $data->id . "-laboratory-result." . $payload['result']->extension();
            $data->update([
                'result_path' => $payload['result']->storeAs('laboratory-result', $fileName)
            ]);
        }
        return $data;
    }

    public function update($id, $payload)
    {
        $data = $this->mainRepository->filterById($id)->first();
        abort_if(!$data, 404, "halaman tidak ditemukan");

        if(isset($payload['result']) && $payload['result']->isValid()) {
            $fileName = $data->id . "-laboratory-result." . $payload['result']->extension();
            $payload['result_path'] = $payload['result']->storeAs('laboratory-result', $fileName);
        }

        $data->update($payload);
        return $data;
    }

    public function delete($id)
    {
        $data = $this->mainRepository->filterById($id)->first();
        abort_if(!$data, 404, "halaman tidak ditemukan");
        
        $data->delete();
        if ($data->result_path) Storage::delete($data->result_path);

        return $data;
    }
}
