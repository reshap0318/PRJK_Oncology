<?php

namespace App\Services\Module;

use App\Repository\Module\PemeriksaanRadioterapiFURepository;
use App\Repository\Module\PemeriksaanRadioterapiRepository;
use App\Services\BaseService;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class PemeriksaanRadioterapiService extends BaseService
{
    protected $mainRepository;
    public function __construct()
    {
        $this->mainRepository = new PemeriksaanRadioterapiRepository();
    }

    public function getById($id)
    {
        $data = $this->mainRepository->filterById($id)->first();
        abort_if(!$data, 404, "halaman tidak ditemukan");       
        $data->category_text = $data->category_text; 
        return $data;
    }

    public function getData(array $payload = [])
    {
        $pemeriksaanId = $payload['pemeriksaan_id'] ?? null;
        $query = $this->mainRepository->datatable()
            ->getQuery()
            ->when($pemeriksaanId, function($query) use ($pemeriksaanId) {
                return $query->where('id', $pemeriksaanId);
            });
        return $query;
    }

    public function datatable(array $payload = [])
    {
        $query = $this->getData($payload)->getQuery();

        return DataTables::eloquent($query)
            ->addColumn('action', function ($data) {
                return $data->actionModel;
            })
            ->addColumn('category_text', function ($data) {
                return $data->category_text;
            })
            ->make(true);
    }

    public function create($payload)
    {
        $data = $this->mainRepository->create([
            "inspection_id" => $payload['inspection_id'],
            "date"          => $payload['date'],
            "category"      => $payload['category'],
            "dose"          => $payload['dose'],
            "fraksi"        => $payload['fraksi'],
            "description"   => $payload['description'],
        ]);

        if(isset($payload['ct_scan']) && $payload['ct_scan']->isValid()) {
            $fileName = $data->id . "-ct-scan." . $payload['ct_scan']->extension();
            $data->update([
                'ct_scan_path' => $payload['ct_scan']->storeAs('radioterapi', $fileName)
            ]);
        }
        return $data;
    }

    public function update($id, $payload)
    {
        $data = $this->mainRepository->filterById($id)->first();
        abort_if(!$data, 404, "halaman tidak ditemukan");

        $update = [
            "inspection_id" => $payload['inspection_id'],
            "date"          => $payload['date'],
            "category"      => $payload['category'],
            "dose"          => $payload['dose'],
            "fraksi"        => $payload['fraksi'],
            "description"   => $payload['description'],
        ];

        if(isset($payload['ct_scan']) && $payload['ct_scan']->isValid()) {
            $fileName = $data->id . "-ct-scan." . $payload['ct_scan']->extension();
            $update['ct_scan_path'] = $payload['ct_scan']->storeAs('radioterapi', $fileName);
        }
        
        $data = $data->update($update);
        return $data;
    }

    public function delete($id)
    {
        $data = $this->mainRepository->filterById($id)->first();
        abort_if(!$data, 404, "halaman tidak ditemukan");
        
        $fus = (new PemeriksaanRadioterapiFURepository)->filterByRadioId($id)->get();
        $data->delete();

        if ($data->ct_scan_path) Storage::delete($data->ct_scan_path);
        foreach ($fus as $fu) {
            if ($fu->ct_scan_path) Storage::delete($fu->ct_scan_path);
        }

        return $data;
    }
}
