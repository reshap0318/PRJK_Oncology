<?php

namespace App\Services\Module;

use App\Helpers\Authorization;
use App\Models\Module\{
    PemeriksaanComplainModel,
    PemeriksaanFaktorResikoModel as PFS,
    PemeriksaanSitologiModel
};
use App\Repository\Module\{
    PasienPemeriksaanRepository,
    PemeriksaanSicknessRepository,
    PemeriksaanSitologiRepository
};
use App\Services\BaseService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class PasienPemeriksaanService extends BaseService
{
    protected $mainRepository;
    public function __construct()
    {
        $this->mainRepository = new PasienPemeriksaanRepository();
    }

    public function getById($id, $tag = null)
    {
        $data = $this->mainRepository->filterById($id)->getDetailData()->first();
        abort_if(!$data, 404, "halaman tidak ditemukan");

        $data['vital']['kgb_option'] = $data['vital']['kgb'] == null ? 0 : 1;

        $defaultAnamnesis = [
            'id' => 0,
            'own' => 0,
            'value' => null
        ];

        $paparan_asap_rokok = $data->riskFactors->firstWhere('category', PFS::K_PAPARAN_ASAP_ROKOK)?->only(['id', 'own', 'value']) ?? $defaultAnamnesis;
        $pekerjaan_beresiko = $data->riskFactors->firstWhere('category', PFS::K_PEKERJAAN_BERESIKO)?->only(['id', 'own', 'value']) ?? $defaultAnamnesis;
        $tempat_tinggal_pabrik = $data->riskFactors->firstWhere('category', PFS::K_TEMPAT_TINGGAL_SEKITAR_PABRIK)?->only(['id', 'own', 'value']) ?? $defaultAnamnesis;
        $riwayat_keganasan_organ_lain = $data->riskFactors->firstWhere('category', PFS::K_RIWAYAT_KEGANASAN_ORGAN_LAIN)?->only(['id', 'own', 'value']) ?? $defaultAnamnesis;
        $paparan_radon = $data->riskFactors->firstWhere('category', PFS::K_PAPARAN_RADON)?->only(['id', 'own', 'value']) ?? $defaultAnamnesis;
        if ($paparan_radon && !$paparan_radon['value']) $paparan_radon['value'] = [];
        $biomess = $data->riskFactors->firstWhere('category', PFS::K_BIOMESS)?->only(['id', 'own', 'value']) ?? $defaultAnamnesis;
        if ($biomess && !$biomess['value']) $biomess['value'] = [];
        $riwayat_ppok = $data->riskFactors->firstWhere('category', PFS::K_RIWAYAT_PPOK)?->only(['id', 'own', 'value']) ?? $defaultAnamnesis;
        if ($riwayat_ppok && !$riwayat_ppok['value']) $riwayat_ppok['value'] = now()->format("Y");
        $riwayat_tb = $data->riskFactors->firstWhere('category', PFS::K_RIWAYAT_TB)?->only(['id', 'own', 'value']) ?? $defaultAnamnesis;
        if ($riwayat_tb && !$riwayat_tb['value']) $riwayat_tb['value'] = [
            [
                'id' => 0,
                'tahun' => null,
                'oat'   => null
            ]
        ];
        $riwayat_kaganasan_keluarga = $data->riskFactors->firstWhere('category', PFS::K_RIWAYAT_KEGANASAN_DALAM_KELUARGA)?->only(['id', 'own', 'value']) ?? $defaultAnamnesis;
        if ($riwayat_kaganasan_keluarga && !$riwayat_kaganasan_keluarga['value']) $riwayat_kaganasan_keluarga['value'] = [
            [
                'id' => 0,
                'siapa' => null,
                'apa'   => null,
                'tahun' => null
            ]
        ];
        $keluhans = $data->complains->where('tag', PemeriksaanComplainModel::T_KELUHAN)->toArray();
        if (!$keluhans) $keluhans = [["id" => 0, "description" => null, "duration" => null]];
        $gejalas = $data->complains->where('tag', PemeriksaanComplainModel::T_GEJALA)->toArray();
        if (!$gejalas) $gejalas = [["id" => 0, "description" => null, "duration" => null]];

        $sitologis = [];
        foreach (PemeriksaanSitologiModel::CATEGORY_LIST as $key => $value) {
            $tmp = [
                "label"         => $value,
                "category"      => $key,
                "date"          => null,
                "type_text"     => null,
                "type"          => null,
                "type_detail"   => null,
                "description"   => null
            ];
            $sitologi = $data->sitologis->firstWhere('category', $key);
            if ($sitologi) {
                $sitologi->setAppends(['category_text', 'type_text']);
                $tmp = array_merge($tmp, [
                    "date"          => $sitologi['date'] ? $sitologi['date']->format("Y-m-d") : null,
                    "type"          => $sitologi['type'],
                    "type_text"     => $sitologi['type_text'],
                    "type_detail"   => $sitologi['type_detail'],
                    "description"   => $sitologi['description']
                ]);
            }
            array_push($sitologis, $tmp);
        }

        $sickness_history = (new PemeriksaanSicknessRepository())
            ->filterByHistory($data->pasien_id, $data->id)
            ->getQuery()
            ->select(['id', 'description'])
            ->get();

        if ($tag == 'laporan') {
            $data->smokingHistory->append(['history_text', 'category_text', 'suck_text']);
            $data->diagnosa->append(['jenis_sel_text', 'paru_text', 'stage_text', 'alk_text']);
            $paparan_radon['value_txt'] = array_map(function ($q) {
                $list = [
                    1 => 'Rumah Kayu',
                    2 => 'Lantai Retak',
                    3 => 'Sumur Dalam Rumah',
                ];
                return $list[$q] ?? '-';
            }, $paparan_radon['value']);

            $biomess['value_txt'] = array_map(function ($q) {
                $list = [
                    1 => 'Kayu Bakar',
                    2 => 'Minyak Tanah',
                    3 => 'Breket',
                ];
                return $list[$q] ?? '-';
            }, $biomess['value']);
        }

        $data['laboratoryResult']['result'] = null;
        $data['radioterapi']['ct_scan'] = null;


        return [
            'id' => $id,
            'overview'  => [
                'dokter_id' => $data->user_id,
                'pasien_id' => $data->pasien_id,
                'tanggal'   => $data->inspection_at->format("Y-m-d"),
                'perubahan_terakhir' => $data->updated_at->format("Y-m-d"),
                'dokter'    => $data->dokter->toArray(),
                'pasien'    => $data->pasien->toArray(),
            ],
            'diagnosa'  => $data['diagnosa']->toArray(),
            'outcome'   => $data['outcome']->toArray(),
            'pemeriksaan_fisik' => $data['vital']->toArray(),
            'anemnesis' => [
                "keluhans" => array_values($keluhans),
                "gejalas" => array_values($gejalas),
                "penyakit_riwayats" => $sickness_history->toArray(),
                "penyakits" => count($data->sickness) != 0 ? $data->sickness->toArray() : [['description' => null]],
                "kategori_perokok" => $data->smokingHistory->toArray(),
                "paparan_asap_rokok" => $paparan_asap_rokok,
                "pekerjaan_beresiko" => $pekerjaan_beresiko,
                "tempat_tinggal_sekitar_pabrik" => $tempat_tinggal_pabrik,
                "riwayat_keganasan_organ_lain" => $riwayat_keganasan_organ_lain,
                "paparan_radon" => $paparan_radon,
                "biomess" => $biomess,
                "riwayat_ppok" => $riwayat_ppok,
                "riwayat_tb" => $riwayat_tb,
                "riwayat_kaganasan_keluarga" => $riwayat_kaganasan_keluarga,
            ],
            "paal_paru" => $data->paalParu->toArray(),
            "bronkoskopi" => $data->bronkoskopi->toArray(),
            'sitologis'   => $sitologis,
            'laboratory' => $data->laboratoryResult->toArray(),
            'radioterapi' => $data->radioterapi->toArray(),
        ];
    }

    public function datatableByPasienId($id)
    {
        $query = $this->mainRepository->filterByPasienId($id)->getQuery();
        return DataTables::eloquent($query)
            ->addColumn('action', function ($data) {
                return $data->actionModel;
            })
            ->make(true);
    }

    public function datatable(array $param = [])
    {
        $tata_laksana = $param['tata_laksana'] ?? null;
        $jenis_sel = $param['jenis_sel'] ?? null;


        $query = $this->mainRepository->datatable()
            ->filterByRole('pm')
            ->datatableFilterByJenisSel('pm', $jenis_sel)
            ->datatableFilterByTatalaksana('pm', $tata_laksana)
            ->getQuery();

        return DataTables::eloquent($query)
            ->addColumn('action', function ($data) {
                return $data->actionModel;
            })
            ->make(true);
    }

    public function store($payload)
    {
        $pemeriksaan = $this->mainRepository->create([
            'user_id'       => $payload['dokter_id'],
            "pasien_id"     => $payload['pasien_id'],
            "inspection_at" => $payload['tanggal'],
            "type"          => 0
        ]);

        return $pemeriksaan;
    }

    public function update($id, $payload)
    {
        $data = $this->mainRepository->filterById($id)->first();
        abort_if(!$data, 404, "halaman tidak ditemukan");
        abort_if(!Authorization::hasPermission('pasien-pemeriksaan.admin') && $data->user_id != Auth::id(), 403, "anda tidak memiliki akses");

        $data->update([
            'user_id'       => $payload['overview']['dokter_id'],
            "pasien_id"     => $payload['overview']['pasien_id'],
            "inspection_at" => $payload['overview']['tanggal'],
        ]);

        $data->diagnosa()->delete();
        $data->diagnosa()->create($payload['diagnosa'] ?? []);

        $data->outcome()->delete();
        $data->outcome()->create($payload['outcome'] ?? []);

        $data->vital()->delete();
        $data->vital()->create($payload['pemeriksaan_fisik'] ?? []);

        $data->smokingHistory()->delete();
        if ($payload['anemnesis']['kategori_perokok']['history'] == 2) {
            $data->smokingHistory()->create([
                'history'    => $payload['anemnesis']['kategori_perokok']['history'],
                'count_year' => $payload['anemnesis']['kategori_perokok']['count_year']
            ]);
        } else if ($payload['anemnesis']['kategori_perokok']['history'] == 3) {
            $data->smokingHistory()->create([
                'history'    => $payload['anemnesis']['kategori_perokok']['history']
            ]);
        } else {
            $data->smokingHistory()->create($payload['anemnesis']['kategori_perokok'] ?? []);
        }

        $keluhans = ($payload['anemnesis']['keluhans'] ?? []);
        foreach ($keluhans as $key => $keluhan) {
            if (isset($keluhan['id']) && $keluhan['id'] != 0) {
                $data->complains()->where('id', $keluhan['id'])->update([
                    'description'   => $keluhan['description'],
                    'duration'      => $keluhan['duration']
                ]);
            } else if (isset($keluhan['description'])) {
                $obj = $data->complains()->create([
                    'description'   => $keluhan['description'] ?? null,
                    'duration'      => $keluhan['duration'] ?? null,
                    'tag'           => PemeriksaanComplainModel::T_KELUHAN
                ]);
                $keluhans[$key]['id'] = $obj->id;
            }
        }

        $gejalas = ($payload['anemnesis']['gejalas'] ?? []);
        foreach ($gejalas as $key => $gejala) {
            if (isset($gejala['id']) && $gejala['id'] != 0) {
                $data->complains()->where('id', $gejala['id'])->update([
                    'description'   => $gejala['description'],
                    'duration'      => $gejala['duration']
                ]);
            } else if (isset($gejala['description'])) {
                $obj = $data->complains()->create([
                    'description'   => $gejala['description'],
                    'duration'      => $gejala['duration'],
                    'tag'           => PemeriksaanComplainModel::T_GEJALA
                ]);
                $gejalas[$key]['id'] = $obj->id;
            }
        }

        $data->complains()->whereNotIn('id', array_merge(array_column($keluhans, 'id'), array_column($gejalas, 'id')))->delete();

        $penyakits = ($payload['anemnesis']['penyakits'] ?? []);
        foreach ($penyakits as $key => $penyakit) {
            if (isset($penyakit['id']) && $penyakit['id'] != 0) {
                $data->sickness()->where('id', $penyakit['id'])->update([
                    'description'   => $penyakit['description'],
                ]);
            } else if (!isset($penyakit['description'])) {
                $obj = $data->sickness()->create([
                    'description'   => $penyakit['description']
                ]);
                $penyakits[$key]['id'] = $obj->id;
            }
        }

        $data->sickness()->whereNotIn('id', array_column($penyakits, 'id'))->delete();

        $this->insertRiskFactorLogic($data->riskFactors(), array_merge($payload['anemnesis']['paparan_asap_rokok'], ['category' => PFS::K_PAPARAN_ASAP_ROKOK]));
        $this->insertRiskFactorLogic($data->riskFactors(), array_merge($payload['anemnesis']['pekerjaan_beresiko'], ['category' => PFS::K_PEKERJAAN_BERESIKO]));
        $this->insertRiskFactorLogic($data->riskFactors(), array_merge($payload['anemnesis']['tempat_tinggal_sekitar_pabrik'], ['category' => PFS::K_TEMPAT_TINGGAL_SEKITAR_PABRIK]));
        $this->insertRiskFactorLogic($data->riskFactors(), array_merge($payload['anemnesis']['riwayat_keganasan_organ_lain'], ['category' => PFS::K_RIWAYAT_KEGANASAN_ORGAN_LAIN]));
        $this->insertRiskFactorLogic($data->riskFactors(), array_merge($payload['anemnesis']['paparan_radon'], ['category' => PFS::K_PAPARAN_RADON]));
        $this->insertRiskFactorLogic($data->riskFactors(), array_merge($payload['anemnesis']['biomess'], ['category' => PFS::K_BIOMESS]));
        $this->insertRiskFactorLogic($data->riskFactors(), array_merge($payload['anemnesis']['riwayat_ppok'], ['category' => PFS::K_RIWAYAT_PPOK]));
        $this->insertRiskFactorLogic($data->riskFactors(), array_merge($payload['anemnesis']['riwayat_tb'], ['category' => PFS::K_RIWAYAT_TB]));
        $this->insertRiskFactorLogic($data->riskFactors(), array_merge($payload['anemnesis']['riwayat_kaganasan_keluarga'], ['category' => PFS::K_RIWAYAT_KEGANASAN_DALAM_KELUARGA]));

        $data->paalParu()->delete();
        $data->paalParu()->create($payload['paal_paru'] ?? []);

        $data->bronkoskopi()->delete();
        $data->bronkoskopi()->create($payload['bronkoskopi'] ?? []);

        $sitologis = array_map(function ($q) use ($data) {
            $type = $q['type'] ?? null;
            return [
                'inspection_id'     => $data->id,
                "category"          => $q['category'],
                "date"              => $q['date'] ?? null,
                "type"              => $type,
                "type_detail"       => $type ? ($q['type_detail'] ?? null) : null,
                "description"       => $q['description'] ?? null,
            ];
        }, $payload['sitologis'] ?? []);
        (new PemeriksaanSitologiRepository())->upsert($sitologis, ['inspection_id', 'category'], ['date', 'type', 'type_detail', 'description']);

        $data->laboratoryResult()->delete();
        if(isset($payload['laboratory']) && isset($payload['laboratory']['result']) && $payload['laboratory']['result']->isValid()) {
            $fileResult = $payload['laboratory']['result'];
            $fileName = $data->id . "-laboratory-result." . $fileResult->extension();
            $payload['laboratory']['result_path'] = $fileResult->storeAs('laboratory-result', $fileName);
        }
        $data->laboratoryResult()->create($payload['laboratory'] ?? []);

        $data->radioterapi()->delete();
        if(isset($payload['radioterapi']) && isset($payload['radioterapi']['ct_scan']) && $payload['radioterapi']['ct_scan']->isValid()) {
            $fileResult = $payload['radioterapi']['ct_scan'];
            $fileName = $data->id . "-ct-scan." . $fileResult->extension();
            $payload['radioterapi']['ct_scan_path'] = $fileResult->storeAs('radioterapi', $fileName);
        }
        $data->radioterapi()->create($payload['radioterapi'] ?? []);

        return $data;
    }

    public function delete($id)
    {
        $data = $this->mainRepository->filterById($id)->first();
        abort_if(!$data, 404, "halaman tidak ditemukan");
        abort_if(!Authorization::hasPermission('pasien-pemeriksaan.admin') && $data->user_id != Auth::id(), 403, "anda tidak memiliki akses");

        if ($data->laboratoryResult->result_path) Storage::delete($data->laboratoryResult->result_path);
        if ($data->radioterapi->ct_scan_path) Storage::delete($data->radioterapi->ct_scan_path);
        
        return $data->delete($id);
    }

    private function insertRiskFactorLogic($riskFactors, $payload = [])
    {
        $input = [
            'own' => $payload['own'],
            'value' => $payload['own'] == 0 ? null : json_encode($payload['value']),
            'category' => $payload['category']
        ];
        if (isset($payload['id']) && $payload['id'] != 0) {
            $riskFactors->where('id', $payload['id'])->update($input);
        } else {
            $riskFactors->create($input);
        }
    }
}
