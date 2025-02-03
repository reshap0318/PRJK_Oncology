<?php

namespace App\Services\Module;

use App\Repository\Module\PemeriksaanTerapiTargetFURepository;
use App\Services\BaseService;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class PemeriksaanTerapiTargetFUService extends BaseService
{
    protected $mainRepository;
    public function __construct()
    {
        $this->mainRepository = new PemeriksaanTerapiTargetFURepository();
    }

    public function getById($id)
    {
        $data = $this->mainRepository->filterById($id)->first();
        abort_if(!$data, 404, "halaman tidak ditemukan");
        
        return $data;
    }

    public function datatable(array $payload = [])
    {
        $targetId = $payload['target_id'] ?? null;
        $query = $this->mainRepository
            ->getQuery()
            ->when($targetId, function($query) use ($targetId) {
                return $query->where('target_id', $targetId);
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

        if(isset($payload['ct_scan']) && $payload['ct_scan']->isValid()) {
            $fileName = $data->id . "-ct-scan-fu." . $payload['ct_scan']->extension();
            $data->update([
                'ct_scan_path' => $payload['ct_scan']->storeAs('terapi-target', $fileName)
            ]);
        }
        return $data;
    }

    public function update($id, $payload)
    {
        $data = $this->mainRepository->filterById($id)->first();
        abort_if(!$data, 404, "halaman tidak ditemukan");

        if(isset($payload['ct_scan']) && $payload['ct_scan']->isValid()) {
            $fileName = $data->id . "-ct-scan-fu." . $payload['ct_scan']->extension();
            $payload['ct_scan_path'] = $payload['ct_scan']->storeAs('terapi-target', $fileName);
        }

        $data->update($payload);
        return $data;
    }

    public function delete($id)
    {
        $data = $this->mainRepository->filterById($id)->first();
        abort_if(!$data, 404, "halaman tidak ditemukan");
        
        $data->delete();
        if ($data->ct_scan_path) Storage::delete($data->ct_scan_path);

        return $data;
    }
}
