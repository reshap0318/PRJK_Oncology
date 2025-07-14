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
        $data->platinum_detail_text = $data->platinum_detail_text;
        $data->combination_detail_text = $data->combination_detail_text;

        $fuInit = (new PemeriksaanKemoterapiFURepository)->filterByKemoId($id)->filterByInitData()->first();

        return array_merge($fuInit->toArray(), $data->toArray());
    }

    public function getData(array $payload = [])
    {
        $pemeriksaanId = $payload['pemeriksaan_id'] ?? null;
        $q = $this->mainRepository->datatable()
            ->getQuery()
            ->when($pemeriksaanId, function ($query) use ($pemeriksaanId) {
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
            "date"              => $payload['date'] ?? null,
            "inspection_id"     => $payload['inspection_id'] ?? null,
            "lini"              => $payload['lini'],
            "platinum_detail"   => $payload['platinum_detail'] ?? [],
            "combination_detail" => $payload['combination_detail'] ?? [],
            "dose"              => $payload['dose'] ?? null,
        ]);

        $fu = $data->fus()->create($payload);

        if (isset($payload['rontgen']) && $payload['rontgen']->isValid()) {
            $fileName = $fu->id . "-rontgen." . $payload['rontgen']->extension();
            $payload['rontgen_path'] = $payload['rontgen']->storeAs('kemoterapi', $fileName);
        }

        if (isset($payload['ct_scan']) && $payload['ct_scan']->isValid()) {
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
            "date"              => $payload['date'] ?? null,
            "lini"              => $payload['lini'] ?? null,
            "platinum_detail"   => $payload['platinum_detail'] ?? [],
            "combination_detail" => $payload['combination_detail'] ?? [],
            "dose"              => $payload['dose'] ?? null,
        ]);

        $update = [
            "date"          => $payload['date'] ?? null,
            "siklus"        => $payload['siklus'] ?? null,
            "subjective"    => $payload['subjective'] ?? null,
            "semi_ps"       => $payload['semi_ps'] ?? null,
            "semi_bb"       => $payload['semi_bb'] ?? null,
            "toxity"        => $payload['toxity'] ?? null,
            "toxity_detail" => $payload['toxity_detail'] ?? null,
            "grade"         => $payload['grade'] ?? null,
            "hb"            => $payload['hb'] ?? null,
            "leukosit"      => $payload['leukosit'] ?? null,
            "trombosit"     => $payload['trombosit'] ?? null,
            "sgot"          => $payload['sgot'] ?? null,
            "sgpt"          => $payload['sgpt'] ?? null,
            "urine"         => $payload['urine'] ?? null,
            "dc"            => $payload['dc'] ?? null,
            "description"   => $payload['description'] ?? null,
        ];

        if (isset($payload['rontgen']) && $payload['rontgen']->isValid()) {
            $fileName = $data->id . "-rontgen." . $payload['rontgen']->extension();
            $update['rontgen_path'] = $payload['rontgen']->storeAs('kemoterapi', $fileName);
        }

        if (isset($payload['ct_scan']) && $payload['ct_scan']->isValid()) {
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
