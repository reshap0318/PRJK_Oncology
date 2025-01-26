<?php

namespace App\Http\Controllers\Module;

use App\Http\Controllers\Controller;
use App\Http\Requests\Module\PemeriksaanOperasiRequest;
use App\Services\Module\PemeriksaanOperasiService;
use Illuminate\Http\{
    Request,
    JsonResponse
};


class PemeriksaanOperasiController extends Controller
{
    protected $mainService;
    public function __construct()
    {
        $this->mainService = new PemeriksaanOperasiService();

        $this->middleware('permission:pasien-pemeriksaan.inspection')->only([
            'datatableByPasienId'
        ]);
    }

    public function getData($id)
    {
        return $this->mainService->transaction(function () use ($id) {
            return $this->mainService->getById($id);
        })->responseResult();
    }

    public function datatable(Request $request)
    {
        return $this->mainService->datatable($request->all());
    }

    public function store(PemeriksaanOperasiRequest $request)
    {
        return $this->mainService->transaction(function () use ($request) {
            return $this->mainService->create($request->all());
        })->responseResult();
    }


    public function update($id, PemeriksaanOperasiRequest $request)
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
