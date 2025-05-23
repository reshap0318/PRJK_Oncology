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
        $data->category_text = $data->category_text;
        $data->category_detail_text = $data->category_detail_text;
        
        $fuInit = (new PemeriksaanKemoterapiFURepository)->filterByKemoId($id)->filterByInitData()->first();
        
        return array_merge($fuInit->toArray(), $data->toArray());
    }

    public function getData(array $payload = [])
    {
        $pemeriksaanId = $payload['pemeriksaan_id'] ?? null;
        $q = $this->mainRepository->datatable()
            ->getQuery()
            ->when($pemeriksaanId, function($query) use ($pemeriksaanId) {
                return $query->where('inspection_id', $pemeriksaanId);
            });
        return $q;
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
        $data = $this->mainRepository->create([
            "date"              => $payload['date'],
            "inspection_id"     => $payload['inspection_id'],
            "lini"              => $payload['lini'],
            "category"          => $payload['category'],
            "category_detail"   => $payload['category_detail'],
            "dose"              => $payload['dose'],
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
            "date"              => $payload['date'],
            "lini"              => $payload['lini'],
            "category"          => $payload['category'],
            "category_detail"   => $payload['category_detail'],
            "dose"              => $payload['dose'],
        ]);

        $update = [
            "date"          => $payload['date'],
            "siklus"        => $payload['siklus'],
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
            "description"   => $payload['description'],
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
