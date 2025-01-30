<?php

namespace App\Services\Module;

use App\Repository\Module\PemeriksaanKemoterapiFURepository;
use App\Repository\Module\PemeriksaanKemoterapiRepository;
use App\Services\BaseService;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class PemeriksaanKemoterapiService extends BaseService
{
    protected $mainRepository;
    public function __construct()
    {
        $this->mainRepository = new PemeriksaanKemoterapiRepository();
    }

    public function getById($id)
    {
        $data = $this->mainRepository->filterById($id)->first();
        abort_if(!$data, 404, "halaman tidak ditemukan");
        
        $fuInit = (new PemeriksaanKemoterapiFURepository)->filterByKemoId($id)->filterByInitData()->first();
        $fuInit->rontgen_url = $fuInit->rontgen_url;
        $fuInit->ct_scan_url = $fuInit->ct_scan_url;
        
        return array_merge($fuInit->toArray(), $data->toArray());
    }

    public function datatable(array $payload = [])
    {
        $pemeriksaanId = $payload['pemeriksaan_id'] ?? null;
        $query = $this->mainRepository->datatable()
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
        $data = $this->mainRepository->create([
            "inspection_id" => $payload['inspection_id'],
            "lini"          => $payload['lini'],
            "category"      => $payload['category'],
            "dose"          => $payload['dose'],
            "description"   => $payload['description'],
        ]);

        $fu = $data->fus()->create($payload);

        if(isset($payload['rontgen']) && $payload['rontgen']->isValid()) {
            $fileName = $fu->id . "-rontgen." . $payload['rontgen']->extension();
            $payload['rontgen_path'] = $payload['rontgen']->storeAs('kemoterapi', $fileName);
        }

        if(isset($payload['ct_scan']) && $payload['ct_scan']->isValid()) {
            $fileName = $fu->id . "-ct-scan." . $payload['ct_scan']->extension();
            $payload['ct_scan_path'] = $payload['ct_scan']->storeAs('kemoterapi', $fileName);
        }

        $fu->update($payload);

        return $data;
    }

    public function update($id, $payload)
    {
        $data = $this->mainRepository->filterById($id)->first();
        abort_if(!$data, 404, "halaman tidak ditemukan");

        $data->update([
            "lini"          => $payload['lini'],
            "category"      => $payload['category'],
            "dose"          => $payload['dose'],
            "description"   => $payload['description'],
        ]);

        $update = [
            "date"          => $payload['date'],
            "subjective"    => $payload['subjective'],
            "semi_ps"       => $payload['semi_ps'],
            "semi_bb"       => $payload['semi_bb'],
            "toxity"        => $payload['toxity'],
            "toxity_detail" => $payload['toxity_detail'],
            "grade"         => $payload['grade'],
            "hb"            => $payload['hb'],
            "leukosit"      => $payload['leukosit'],
            "trombosit"     => $payload['trombosit'],
            "sgot"          => $payload['sgot'],
            "sgpt"          => $payload['sgpt'],
            "urine"         => $payload['urine'],
            "dc"            => $payload['dc'],
        ];

        if(isset($payload['rontgen']) && $payload['rontgen']->isValid()) {
            $fileName = $data->id . "-rontgen." . $payload['rontgen']->extension();
            $update['rontgen_path'] = $payload['rontgen']->storeAs('kemoterapi', $fileName);
        }

        if(isset($payload['ct_scan']) && $payload['ct_scan']->isValid()) {
            $fileName = $data->id . "-ct-scan." . $payload['ct_scan']->extension();
            $update['ct_scan_path'] = $payload['ct_scan']->storeAs('kemoterapi', $fileName);
        }
        unset($payload['inspection_id']);

        $fuInit = (new PemeriksaanKemoterapiFURepository)->filterByKemoId($id)->filterByInitData()->first();
        $fuInit->update($update);
        return $data;
    }

    public function delete($id)
    {
        $data = $this->mainRepository->filterById($id)->first();
        abort_if(!$data, 404, "halaman tidak ditemukan");
        $fuInits = (new PemeriksaanKemoterapiFURepository)->filterByKemoId($id)->get();
        
        $data->delete();
        foreach ($fuInits as $fu) {
            if ($fu->rontgen_path) Storage::delete($fu->rontgen_path);
            if ($fu->ct_scan_path) Storage::delete($fu->ct_scan_path);
        }

        return $data;
    }
}
