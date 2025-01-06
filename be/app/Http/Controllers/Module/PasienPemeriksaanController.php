<?php

namespace App\Http\Controllers\Module;

use App\Http\Controllers\Controller;
use App\Services\Module\PasienPemeriksaanService;
use Illuminate\Http\{
    Request,
    JsonResponse
};

class PasienPemeriksaanController extends Controller
{
    protected $mainService;
    public function __construct()
    {
        $this->mainService = new PasienPemeriksaanService();

        $this->middleware('permission:pasien.show')->only(['datatableByPasienId']);
        $this->middleware('permission:pasien-pemeriksaan.index')->only(['datatable']);
        // $this->middleware('permission:pasien-pemeriksaan.show')->only(['getData']);
        // $this->middleware('permission:pasien-pemeriksaan.create')->only(['detail']);
        // $this->middleware('permission:pasien-pemeriksaan.edit')->only(['update']);
        $this->middleware('permission:pasien-pemeriksaan.delete')->only(['destroy']);
    }

    public function getData($id)
    {
        return $this->mainService->transaction(function () use ($id) {
            return $this->mainService->getById($id);
        })->responseResult();
    }

    public function datatableByPasienId($id)
    {
        return $this->mainService->datatableByPasienId($id);
    }

    public function datatable()
    {
        return $this->mainService->datatable();
    }

    public function destroy($id): JsonResponse
    {
        return $this->mainService->transaction(function () use ($id) {
            return $this->mainService->delete($id);
        })->responseResult();
    }
}
