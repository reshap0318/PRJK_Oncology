<?php

namespace App\Repository\Module;

use App\Helpers\Authorization;
use App\Models\Module\PasienModel;
use App\Models\Module\PasienPemeriksaanModel;
use App\Models\Module\PemeriksaanDiagnosaModel;
use App\Models\Module\PemeriksaanKemoterapiModel;
use App\Models\Module\PemeriksaanOperasiModel;
use App\Models\Module\PemeriksaanRadioterapiModel;
use App\Models\Module\PemeriksaanTerapiTargetModel;
use App\Models\User;
use App\Repository\BaseRepository;
use Illuminate\Support\Facades\Auth;

class PasienPemeriksaanRepository extends BaseRepository
{
    public function __construct()
    {
        $this->query = new PasienPemeriksaanModel();
    }

    public function filterByPasienId($id)
    {
        $this->query = $this->query->where('pasien_id', $id);
        return $this;
    }

    public function datatable()
    {
        $tbl = (new PasienPemeriksaanModel())->getTable();
        $this->query = $this->query->from("$tbl as pm")
            ->select(['pm.*', 'd.name as dokter_name', 'p.name as pasien_name'])
            ->join((new User())->getTable() . " as d", "d.id", "pm.user_id")
            ->join((new PasienModel())->getTable() . " as p", "p.id", "pm.pasien_id");
        return $this;
    }

    public function datatableFilterByJenisSel($tbl, $value)
    {
        $tbl = $tbl ?? (new PasienPemeriksaanModel())->getTable();
        $this->query = $this->query->when($value, function ($q) use ($value, $tbl) {
            return $q->whereIn(
                $tbl . ".id",
                PemeriksaanDiagnosaModel::select('id')->whereJsonContains('jenis_sel', "$value")
            );
        });

        return $this;
    }

    public function datatableFilterByTatalaksana($tbl, $value)
    {
        $tbl = $tbl ?? (new PasienPemeriksaanModel())->getTable();
        if ($value == 1) {
            $this->query = $this->query->whereIn($tbl . ".id", PemeriksaanKemoterapiModel::select('inspection_id')->whereNotNull('category'));
        } else if ($value == 2) {
            $this->query = $this->query->whereIn($tbl . ".id", PemeriksaanOperasiModel::select('inspection_id')->whereNotNull('margin'));
        } else if ($value == 3) {
            $this->query = $this->query->whereIn($tbl . ".id", PemeriksaanTerapiTargetModel::select('inspection_id')->whereNotNull('category'));
        } else if ($value == 4) {
            $this->query = $this->query->whereIn($tbl . ".id", PemeriksaanRadioterapiModel::select('inspection_id')->whereNotNull('category'));
        }
        return $this;
    }

    public function getDetailData()
    {
        $this->query = $this->query->with([
            'pasien',
            'dokter',
            'diagnosa',
            'outcome',
            'vital',
            'riskFactors',
            'smokingHistory',
            'complains:id,description,duration,tag,inspection_id',
            'sickness:id,description,inspection_id',
            'paalParu',
            'bronkoskopi',
            'sitologis',
            'laboratoryResult'
        ]);
        return $this;
    }

    public function filterByRole($tbl = null)
    {
        $tbl = $tbl ?? (new PasienPemeriksaanModel())->getTable();
        $this->query = $this->query->when(
            !Authorization::hasPermission('pasien-pemeriksaan.all'),
            function ($q) use ($tbl) {
                return $q->where($tbl . ".user_id", Auth::id());
            }
        );
        return $this;
    }

    public function laporanExcel(array $payload = [])
    {
        $this->query = $this->query->with([
            'pasien',
            'diagnosa',
            'outcome',
            'complains',

            'operasis:id,inspection_id',
            'kemoterapis:id,inspection_id',
            'radioterapi:id,date',
            'terapis:id,inspection_id',
            'sitologis:id,inspection_id,type',

            'torakFotos:id,inspection_id',
            'torakScans:id,inspection_id',
            'boneSurveys:id,inspection_id',
            'mris:id,inspection_id',
            'torakUsgs:id,inspection_id',
            'laboratoryResult:id,date',
            'bronkoskopi:id,vocal_cords',
            'paalParu:id,kvp_ml',
            'lainnya:id,inspection_id',
        ])
            ->when(isset($payload['dokter']) && $payload['dokter'] != "null", function ($q) use ($payload) {
                return $q->where('user_id', $payload['dokter']);
            })
            ->when(isset($payload['startDate']), function ($q) use ($payload) {
                return $q->where('inspection_at', '>=', $payload['startDate']);
            })
            ->when(isset($payload['endDate']), function ($q) use ($payload) {
                return $q->where('inspection_at', '<=', $payload['endDate']);
            });
        return $this;
    }
}
