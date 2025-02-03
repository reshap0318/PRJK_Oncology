<?php

namespace App\Services\Module;

use App\Repository\Module\PemeriksaanRadioterapiFURepository;
use App\Services\BaseService;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class PemeriksaanRadioterapiFUService extends BaseService
{
    protected $mainRepository;
    public function __construct()
    {
        $this->mainRepository = new PemeriksaanRadioterapiFURepository();
    }

    public function getById($id)
    {
        $data = $this->mainRepository->filterById($id)->first();
        abort_if(!$data, 404, "halaman tidak ditemukan");
        
        return $data;
    }

    public function datatable(array $payload = [])
    {
        $radioId = $payload['radio_id'] ?? null;
        $query = $this->mainRepository
            ->getQuery()
            ->when($radioId, function($query) use ($radioId) {
                return $query->where('radio_id', $radioId);
            });

        return DataTables::eloquent($query)
            ->addColumn('action', function ($data) {
                return $data->actionModel;
            })
            ->make(true);
    }

    public function create($payload)
    {
        $data = $this->mainRepository->create([
            "radio_id"  => $payload['radio_id'],
            "date"      => $payload['date'],
        ]);

        $update = [];
        if(isset($payload['ct_scan']) && $payload['ct_scan']->isValid()) {
            $fileName = $data->id . "-ct-scan-fu." . $payload['ct_scan']->extension();
            $update['ct_scan_path'] = $payload['ct_scan']->storeAs('radioterapi', $fileName);
        }

        $data->update($update);
        return $data;
    }

    public function update($id, $payload)
    {
        $data = $this->mainRepository->filterById($id)->first();
        abort_if(!$data, 404, "halaman tidak ditemukan");

        $update = [
            "date"          => $payload['date'],
        ];

        if(isset($payload['ct_scan']) && $payload['ct_scan']->isValid()) {
            $fileName = $data->id . "-ct-scan-fu." . $payload['ct_scan']->extension();
            $update['ct_scan_path'] = $payload['ct_scan']->storeAs('radioterapi', $fileName);
        }

        $data->update($update);
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
