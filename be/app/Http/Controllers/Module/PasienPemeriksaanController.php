<?php

namespace App\Http\Controllers\Module;

use App\Http\Controllers\Controller;
use App\Http\Requests\Module\{
    PemeriksaanCreateRequest,
    PemeriksaanUpdateRequest
};
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
        $this->middleware('permission:pasien-pemeriksaan.inspection, permission:pasien-pemeriksaan.admin')->only(['store', 'update']);
        $this->middleware('permission:pasien-pemeriksaan.delete, permission:pasien-pemeriksaan.admin')->only(['destroy']);
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

    public function datatable(Request $request)
    {
        return $this->mainService->datatable($request->all());
    }

    public function store(PemeriksaanCreateRequest $request)
    {
        return $this->mainService->transaction(function () use ($request) {
            return $this->mainService->store($request->all());
        })->responseResult();
    }


    public function update($id, PemeriksaanUpdateRequest $request)
    {
        return $this->mainService->transaction(function () use ($id, $request) {
            return $this->mainService->update($id, $request->all());
        })->responseResult();
    }

    public function destroy($id): JsonResponse
    {
        return $this->mainService->transaction(function () use ($id) {
            return $this->mainService->delete($id);
        })->responseResult();
    }
}
