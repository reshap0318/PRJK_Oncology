<?php

namespace App\Services\Module;

use App\Repository\Module\PemeriksaanKemoterapiFURepository;
use App\Services\BaseService;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class PemeriksaanKemoterapiFUService extends BaseService
{
    protected $mainRepository;
    public function __construct()
    {
        $this->mainRepository = new PemeriksaanKemoterapiFURepository();
    }

    public function getById($id)
    {
        $data = $this->mainRepository->filterById($id)->first();
        abort_if(!$data, 404, "halaman tidak ditemukan");

        $data->rontgen_url = $data->rontgen_url;
        $data->ct_scan_url = $data->ct_scan_url;
        
        return $data;
    }

    public function datatable(array $payload = [])
    {
        $kemoId = $payload['kemo_id'] ?? null;
        $query = $this->mainRepository
            ->getQuery()
            ->when($kemoId, function($query) use ($kemoId) {
                return $query->where('kemo_id', $kemoId);
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
            "kemo_id"       => $payload['kemo_id'],
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
        ]);

        $update = [];
        if(isset($payload['rontgen']) && $payload['rontgen']->isValid()) {
            $fileName = $data->id . "-rontgen." . $payload['rontgen']->extension();
            $update['rontgen_path'] = $payload['rontgen']->storeAs('kemoterapi', $fileName);
        }

        if(isset($payload['ct_scan']) && $payload['ct_scan']->isValid()) {
            $fileName = $data->id . "-ct-scan." . $payload['ct_scan']->extension();
            $update['ct_scan_path'] = $payload['ct_scan']->storeAs('kemoterapi', $fileName);
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

        $data->update($update);
        return $data;
    }

    public function delete($id)
    {
        $data = $this->mainRepository->filterById($id)->first();
        abort_if(!$data, 404, "halaman tidak ditemukan");

        $fuInit = (new PemeriksaanKemoterapiFURepository)->filterByKemoId($data->kemo_id)->filterByInitData()->first();
        abort_if($fuInit->id == $id, 400, "data tidak bisa dihapus");
        
        $data->delete();
        if ($data->rontgen_path) Storage::delete($data->rontgen_path);
        if ($data->ct_scan_path) Storage::delete($data->ct_scan_path);

        return $data;
    }
}
