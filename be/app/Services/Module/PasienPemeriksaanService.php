<?php

namespace App\Services\Module;

use App\Models\Module\{
    PemeriksaanComplainModel,
    PemeriksaanFaktorResikoModel as PFS
};
use App\Repository\Module\PasienPemeriksaanRepository;
use App\Repository\Module\PemeriksaanSicknessRepository;
use App\Services\BaseService;
use Yajra\DataTables\Facades\DataTables;

class PasienPemeriksaanService extends BaseService
{
    protected $mainRepository;
    public function __construct()
    {
        $this->mainRepository = new PasienPemeriksaanRepository();
    }

    public function getById($id)
    {
        $data = $this->mainRepository->filterById($id)->getDetailData()->first();
        abort_if(!$data, 404, "halaman tidak ditemukan");

        $data['vital']['kgb_option'] = $data['vital']['kgb'] == null ? 0 : 1;

        $paparan_asap_rokok = $data->riskFactors->firstWhere('category', PFS::K_PAPARAN_ASAP_ROKOK)?->only(['own', 'value']);
        $pekerjaan_beresiko = $data->riskFactors->firstWhere('category', PFS::K_PEKERJAAN_BERESIKO)?->only(['own', 'value']);
        $tempat_tinggal_pabrik = $data->riskFactors->firstWhere('category', PFS::K_TEMPAT_TINGGAL_SEKITAR_PABRIK)?->only(['own', 'value']);
        $riwayat_keganasan_organ_lain = $data->riskFactors->firstWhere('category', PFS::K_RIWAYAT_KEGANASAN_ORGAN_LAIN)?->only(['own', 'value']);
        $paparan_radon = $data->riskFactors->firstWhere('category', PFS::K_PAPARAN_RADON)?->only(['own', 'value']);
        if (!$paparan_radon['value']) $paparan_radon['value'] = [];
        $biomess = $data->riskFactors->firstWhere('category', PFS::K_BIOMESS)?->only(['own', 'value']);
        if (!$biomess['value']) $biomess['value'] = [];
        $riwayat_ppok = $data->riskFactors->firstWhere('category', PFS::K_RIWAYAT_PPOK)?->only(['own', 'value']);
        if (!$riwayat_ppok['value']) $riwayat_ppok['value'] = now()->format("Y");
        $riwayat_tb = $data->riskFactors->firstWhere('category', PFS::K_RIWAYAT_TB)?->only(['own', 'value']);
        if (!$riwayat_tb['value']) $riwayat_tb['value'] = [
            'tahun' => now()->format("Y"),
            'oat'   => null
        ];
        $riwayat_kaganasan_keluarga = $data->riskFactors->firstWhere('category', PFS::K_RIWAYAT_KEGANASAN_DALAM_KELUARGA)?->only(['own', 'value']);
        if (!$riwayat_kaganasan_keluarga['value']) $riwayat_kaganasan_keluarga['value'] = [
            'siapa' => null,
            'apa'   => null,
            'tahun' => now()->format("Y")
        ];
        $keluhans = $data->complains->where('tag', PemeriksaanComplainModel::T_KELUHAN)->toArray();
        if (!$keluhans) $keluhans = [["description" => null, "long" => 0]];
        $gejalas = $data->complains->where('tag', PemeriksaanComplainModel::T_GEJALA)->toArray();
        if (!$gejalas) $gejalas = [["description" => null, "long" => 0]];

        $sickness_history = (new PemeriksaanSicknessRepository())
            ->filterByHistory($data->pasien_id, $data->id)
            ->getQuery()
            ->select(['id', 'description'])
            ->get();

        return [
            'id' => $id,
            'overview'  => [
                'dokter_id' => $data->user_id,
                'pasien_id' => $data->pasien_id,
                'tanggal'   => $data->inspection_at->format("Y-m-d")
            ],
            'diagnosa'  => $data['diagnosa'],
            'outcome'   => $data['outcome'],
            'pemeriksaan_fisik' => $data['vital'],
            'anemnesis' => [
                "keluhans" => array_values($keluhans),
                "gejalas" => array_values($gejalas),
                "penyakit_riwayats" => $sickness_history,
                "penyakits" => $data->sickness,
                "kategori_perokok" => $data->smokingHistory,
                "paparan_asap_rokok" => $paparan_asap_rokok,
                "pekerjaan_beresiko" => $pekerjaan_beresiko,
                "tempat_tinggal_sekitar_pabrik" => $tempat_tinggal_pabrik,
                "riwayat_keganasan_organ_lain" => $riwayat_keganasan_organ_lain,
                "paparan_radon" => $paparan_radon,
                "biomess" => $biomess,
                "riwayat_ppok" => $riwayat_ppok,
                "riwayat_tb" => $riwayat_tb,
                "riwayat_kaganasan_keluarga" => $riwayat_kaganasan_keluarga
            ]
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

    public function datatable()
    {
        $query = $this->mainRepository->datatable()->getQuery();
        return DataTables::eloquent($query)
            ->addColumn('action', function ($data) {
                return $data->actionModel;
            })
            ->make(true);
    }

    public function store($payload)
    {
        $pemeriksaan = $this->mainRepository->create([
            'user_id'       => $payload['overview']['dokter_id'],
            "pasien_id"     => $payload['overview']['pasien_id'],
            "inspection_at" => $payload['overview']['tanggal'],
            "type"          => 0
        ]);

        $pemeriksaan->diagnosa()->create($payload['diagnosa'] ?? []);
        $pemeriksaan->outcome()->create($payload['outcome'] ?? []);
        $pemeriksaan->vital()->create($payload['pemeriksaan_fisik'] ?? []);
        $pemeriksaan->smokingHistory()->create($payload['anemnesis']['kategori_perokok'] ?? []);

        $pemeriksaan->complains()->createMany(
            array_map(function ($d) {
                return array_merge($d, ['tag' => PemeriksaanComplainModel::T_KELUHAN]);
            }, ($payload['anemnesis']['keluhans'] ?? []))
        );

        $pemeriksaan->complains()->createMany(
            array_map(function ($d) {
                return array_merge($d, ['tag' => PemeriksaanComplainModel::T_GEJALA]);
            }, ($payload['anemnesis']['gejalas'] ?? []))
        );

        $pemeriksaan->sickness()->createMany(($payload['anemnesis']['penyakits'] ?? []));

        //FACTOR RESIKO
        $pemeriksaan->riskFactors()->create(
            array_merge(($payload['anemnesis']['paparan_asap_rokok'] ?? []), ['category' => PFS::K_PAPARAN_ASAP_ROKOK])
        );
        $pemeriksaan->riskFactors()->create(
            array_merge(($payload['anemnesis']['pekerjaan_beresiko'] ?? []), ['category' => PFS::K_PEKERJAAN_BERESIKO])
        );
        $pemeriksaan->riskFactors()->create(
            array_merge(($payload['anemnesis']['tempat_tinggal_sekitar_pabrik'] ?? []), ['category' => PFS::K_TEMPAT_TINGGAL_SEKITAR_PABRIK])
        );
        $pemeriksaan->riskFactors()->create(
            array_merge(($payload['anemnesis']['riwayat_keganasan_organ_lain'] ?? []), ['category' => PFS::K_RIWAYAT_KEGANASAN_ORGAN_LAIN])
        );
        $pemeriksaan->riskFactors()->create(
            array_merge(($payload['anemnesis']['paparan_radon'] ?? []), ['category' => PFS::K_PAPARAN_RADON])
        );
        $pemeriksaan->riskFactors()->create(
            array_merge(($payload['anemnesis']['biomess'] ?? []), ['category' => PFS::K_BIOMESS])
        );
        $pemeriksaan->riskFactors()->create(
            array_merge(($payload['anemnesis']['riwayat_ppok'] ?? []), ['category' => PFS::K_RIWAYAT_PPOK])
        );
        $pemeriksaan->riskFactors()->create(
            array_merge(($payload['anemnesis']['riwayat_tb'] ?? []), ['category' => PFS::K_RIWAYAT_TB])
        );
        $pemeriksaan->riskFactors()->create(
            array_merge(($payload['anemnesis']['riwayat_kaganasan_keluarga'] ?? []), ['category' => PFS::K_RIWAYAT_KEGANASAN_DALAM_KELUARGA])
        );

        return $pemeriksaan;
    }

    public function delete($id)
    {
        return $this->mainRepository->delete($id);
    }
}
