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

        $paparan_asap_rokok = $data->riskFactors->firstWhere('category', PFS::K_PAPARAN_ASAP_ROKOK)?->only(['id', 'own', 'value']);
        $pekerjaan_beresiko = $data->riskFactors->firstWhere('category', PFS::K_PEKERJAAN_BERESIKO)?->only(['id', 'own', 'value']);
        $tempat_tinggal_pabrik = $data->riskFactors->firstWhere('category', PFS::K_TEMPAT_TINGGAL_SEKITAR_PABRIK)?->only(['id', 'own', 'value']);
        $riwayat_keganasan_organ_lain = $data->riskFactors->firstWhere('category', PFS::K_RIWAYAT_KEGANASAN_ORGAN_LAIN)?->only(['id', 'own', 'value']);
        $paparan_radon = $data->riskFactors->firstWhere('category', PFS::K_PAPARAN_RADON)?->only(['id', 'own', 'value']);
        if (!$paparan_radon['value']) $paparan_radon['value'] = [];
        $biomess = $data->riskFactors->firstWhere('category', PFS::K_BIOMESS)?->only(['id', 'own', 'value']);
        if (!$biomess['value']) $biomess['value'] = [];
        $riwayat_ppok = $data->riskFactors->firstWhere('category', PFS::K_RIWAYAT_PPOK)?->only(['id', 'own', 'value']);
        if (!$riwayat_ppok['value']) $riwayat_ppok['value'] = now()->format("Y");
        $riwayat_tb = $data->riskFactors->firstWhere('category', PFS::K_RIWAYAT_TB)?->only(['id', 'own', 'value']);
        if (!$riwayat_tb['value']) $riwayat_tb['value'] = [
            'tahun' => now()->format("Y"),
            'oat'   => null
        ];
        $riwayat_kaganasan_keluarga = $data->riskFactors->firstWhere('category', PFS::K_RIWAYAT_KEGANASAN_DALAM_KELUARGA)?->only(['id', 'own', 'value']);
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
        if ($payload['anemnesis']['kategori_perokok']['history'] == 2) {
            $pemeriksaan->smokingHistory()->create([
                'history'    => $payload['anemnesis']['kategori_perokok']['history'],
                'count_year' => $payload['anemnesis']['kategori_perokok']['count_year']
            ]);
        } else if ($payload['anemnesis']['kategori_perokok']['history'] == 3) {
            $pemeriksaan->smokingHistory()->create([
                'history'    => $payload['anemnesis']['kategori_perokok']['history']
            ]);
        } else {
            $pemeriksaan->smokingHistory()->create($payload['anemnesis']['kategori_perokok'] ?? []);
        }

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
        $pemeriksaan->riskFactors()
            ->create([
                'own' => $payload['anemnesis']['paparan_asap_rokok']['own'],
                'value' => null,
                'category' => PFS::K_PAPARAN_ASAP_ROKOK
            ]);

        $pemeriksaan->riskFactors()
            ->create([
                'own' => $payload['anemnesis']['pekerjaan_beresiko']['own'],
                'value' => $payload['anemnesis']['pekerjaan_beresiko']['own'] == 0 ? null : $payload['anemnesis']['pekerjaan_beresiko']['value'],
                'category' => PFS::K_PEKERJAAN_BERESIKO
            ]);

        $pemeriksaan->riskFactors()
            ->create([
                'own' => $payload['anemnesis']['tempat_tinggal_sekitar_pabrik']['own'],
                'value' => $payload['anemnesis']['tempat_tinggal_sekitar_pabrik']['own'] == 0 ? null : $payload['anemnesis']['tempat_tinggal_sekitar_pabrik']['value'],
                'category' => PFS::K_TEMPAT_TINGGAL_SEKITAR_PABRIK
            ]);

        $pemeriksaan->riskFactors()
            ->create([
                'own' => $payload['anemnesis']['riwayat_keganasan_organ_lain']['own'],
                'value' => $payload['anemnesis']['riwayat_keganasan_organ_lain']['own'] == 0 ? null : $payload['anemnesis']['riwayat_keganasan_organ_lain']['value'],
                'category' => PFS::K_RIWAYAT_KEGANASAN_ORGAN_LAIN
            ]);

        $pemeriksaan->riskFactors()
            ->create([
                'own' => $payload['anemnesis']['paparan_radon']['own'],
                'value' => $payload['anemnesis']['paparan_radon']['own'] == 0 ? null : $payload['anemnesis']['paparan_radon']['value'],
                'category' => PFS::K_PAPARAN_RADON
            ]);

        $pemeriksaan->riskFactors()
            ->create([
                'own' => $payload['anemnesis']['biomess']['own'],
                'value' => $payload['anemnesis']['biomess']['own'] == 0 ? null : $payload['anemnesis']['biomess']['value'],
                'category' => PFS::K_BIOMESS
            ]);

        $pemeriksaan->riskFactors()
            ->create([
                'own' => $payload['anemnesis']['riwayat_ppok']['own'],
                'value' => $payload['anemnesis']['riwayat_ppok']['own'] == 0 ? null : $payload['anemnesis']['riwayat_ppok']['value'],
                'category' => PFS::K_RIWAYAT_PPOK
            ]);

        $pemeriksaan->riskFactors()
            ->create([
                'own' => $payload['anemnesis']['riwayat_tb']['own'],
                'value' => $payload['anemnesis']['riwayat_tb']['own'] == 0 ? null : $payload['anemnesis']['riwayat_tb']['value'],
                'category' => PFS::K_RIWAYAT_TB
            ]);

        $pemeriksaan->riskFactors()
            ->create([
                'own' => $payload['anemnesis']['riwayat_kaganasan_keluarga']['own'],
                'value' => $payload['anemnesis']['riwayat_kaganasan_keluarga']['own'] == 0 ? null : $payload['anemnesis']['riwayat_kaganasan_keluarga']['value'],
                'category' => PFS::K_RIWAYAT_KEGANASAN_DALAM_KELUARGA
            ]);

        return $pemeriksaan;
    }

    public function update($id, $payload)
    {
        $data = $this->mainRepository->filterById($id)->first();
        abort_if(!$data, 404, "halaman tidak ditemukan");

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
        foreach ($keluhans as $keluhan) {
            if ($keluhan['id'] == 0) continue;
            $data->complains()->where('id', $keluhan['id'])->update([
                'description'   => $keluhan['description'],
                'duration'      => $keluhan['duration']
            ]);
        }

        $gejalas = ($payload['anemnesis']['gejalas'] ?? []);
        foreach ($gejalas as $gejala) {
            if ($gejala['id'] == 0) continue;
            $data->complains()->where('id', $gejala['id'])->update([
                'description'   => $gejala['description'],
                'duration'      => $gejala['duration']
            ]);
        }

        $data->complains()->whereNotIn('id', array_merge(array_column($keluhans, 'id'), array_column($gejalas, 'id')))->delete();

        $penyakits = ($payload['anemnesis']['penyakits'] ?? []);
        foreach ($penyakits as $penyakit) {
            if ($penyakit['id'] == 0) continue;
            $data->sickness()->where('id', $penyakit['id'])->update([
                'description'   => $penyakit['description'],
            ]);
        }

        $data->sickness()->whereNotIn('id', array_column($penyakits, 'id'))->delete();

        $data->riskFactors()
            ->where('id', $payload['anemnesis']['paparan_asap_rokok']['id'])
            ->update([
                'own' => $payload['anemnesis']['paparan_asap_rokok']['own'],
                'value' => null,
                'category' => PFS::K_PAPARAN_ASAP_ROKOK
            ]);

        $data->riskFactors()
            ->where('id', $payload['anemnesis']['pekerjaan_beresiko']['id'])
            ->update([
                'own' => $payload['anemnesis']['pekerjaan_beresiko']['own'],
                'value' => $payload['anemnesis']['pekerjaan_beresiko']['own'] == 0 ? null : json_encode($payload['anemnesis']['pekerjaan_beresiko']['value']),
                'category' => PFS::K_PEKERJAAN_BERESIKO
            ]);

        $data->riskFactors()
            ->where('id', $payload['anemnesis']['tempat_tinggal_sekitar_pabrik']['id'])
            ->update([
                'own' => $payload['anemnesis']['tempat_tinggal_sekitar_pabrik']['own'],
                'value' => $payload['anemnesis']['tempat_tinggal_sekitar_pabrik']['own'] == 0 ? null : json_encode($payload['anemnesis']['tempat_tinggal_sekitar_pabrik']['value']),
                'category' => PFS::K_TEMPAT_TINGGAL_SEKITAR_PABRIK
            ]);

        $data->riskFactors()
            ->where('id', $payload['anemnesis']['riwayat_keganasan_organ_lain']['id'])
            ->update([
                'own' => $payload['anemnesis']['riwayat_keganasan_organ_lain']['own'],
                'value' => $payload['anemnesis']['riwayat_keganasan_organ_lain']['own'] == 0 ? null : json_encode($payload['anemnesis']['riwayat_keganasan_organ_lain']['value']),
                'category' => PFS::K_RIWAYAT_KEGANASAN_ORGAN_LAIN
            ]);

        $data->riskFactors()
            ->where('id', $payload['anemnesis']['paparan_radon']['id'])
            ->update([
                'own' => $payload['anemnesis']['paparan_radon']['own'],
                'value' => $payload['anemnesis']['paparan_radon']['own'] == 0 ? null : $payload['anemnesis']['paparan_radon']['value'],
                'category' => PFS::K_PAPARAN_RADON
            ]);

        $data->riskFactors()
            ->where('id', $payload['anemnesis']['biomess']['id'])
            ->update([
                'own' => $payload['anemnesis']['biomess']['own'],
                'value' => $payload['anemnesis']['biomess']['own'] == 0 ? null : $payload['anemnesis']['biomess']['value'],
                'category' => PFS::K_BIOMESS
            ]);

        $data->riskFactors()
            ->where('id', $payload['anemnesis']['riwayat_ppok']['id'])
            ->update([
                'own' => $payload['anemnesis']['riwayat_ppok']['own'],
                'value' => $payload['anemnesis']['riwayat_ppok']['own'] == 0 ? null : json_encode($payload['anemnesis']['riwayat_ppok']['value']),
                'category' => PFS::K_RIWAYAT_PPOK
            ]);

        $data->riskFactors()
            ->where('id', $payload['anemnesis']['riwayat_tb']['id'])
            ->update([
                'own' => $payload['anemnesis']['riwayat_tb']['own'],
                'value' => $payload['anemnesis']['riwayat_tb']['own'] == 0 ? null : $payload['anemnesis']['riwayat_tb']['value'],
                'category' => PFS::K_RIWAYAT_TB
            ]);

        $data->riskFactors()
            ->where('id', $payload['anemnesis']['riwayat_kaganasan_keluarga']['id'])
            ->update([
                'own' => $payload['anemnesis']['riwayat_kaganasan_keluarga']['own'],
                'value' => $payload['anemnesis']['riwayat_kaganasan_keluarga']['own'] == 0 ? null : $payload['anemnesis']['riwayat_kaganasan_keluarga']['value'],
                'category' => PFS::K_RIWAYAT_KEGANASAN_DALAM_KELUARGA
            ]);

        return $data;
    }

    public function delete($id)
    {
        return $this->mainRepository->delete($id);
    }
}
