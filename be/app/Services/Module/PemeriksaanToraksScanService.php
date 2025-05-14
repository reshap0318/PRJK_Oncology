<?php

namespace App\Services\Module;

use App\Repository\Module\PemeriksaanToraksScanRepository;
use App\Services\BaseService;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class PemeriksaanToraksScanService extends BaseService
{
    protected $mainRepository;
    public function __construct()
    {
        $this->mainRepository = new PemeriksaanToraksScanRepository();
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
        $query = $this->mainRepository
            ->getQuery()
            ->when($pemeriksaanId, function($query) use ($pemeriksaanId) {
                return $query->where('inspection_id', $pemeriksaanId);
            });
        return $query;
    }

    public function datatable(array $payload = [])
    {
        $query = $this->getData($payload);
        return DataTables::eloquent($query)
            ->addColumn('action', function ($data) {
                return $data->actionModel;
            })
            ->make(true);
    }

    public function create($payload)
    {
        $data = $this->mainRepository->create($payload);

        if(isset($payload['file']) && $payload['file']->isValid()) {
            $fileName = $data->id . "-toraks-scan." . $payload['file']->extension();
            $data->update([
                'file_path' => $payload['file']->storeAs('toraks-scan', $fileName)
            ]);
        }
        return $data;
    }

    public function update($id, $payload)
    {
        $data = $this->mainRepository->filterById($id)->first();
        abort_if(!$data, 404, "halaman tidak ditemukan");

        if(isset($payload['file']) && $payload['file']->isValid()) {
            $fileName = $data->id . "-toraks-scan." . $payload['file']->extension();
            $payload['file_path'] = $payload['file']->storeAs('toraks-scan', $fileName);
        }

        $data->update($payload);
        return $data;
    }

    public function delete($id)
    {
        $data = $this->mainRepository->filterById($id)->first();
        abort_if(!$data, 404, "halaman tidak ditemukan");
        
        $data->delete();
        if ($data->file_path) Storage::delete($data->file_path);

        return $data;
    }
}
