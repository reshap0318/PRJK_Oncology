<?php

namespace App\Http\Controllers\Module;

use App\Http\Controllers\Controller;
use App\Http\Requests\Module\PemeriksaanTerapiTargetRequest;
use App\Services\Module\PemeriksaanTerapiTargetService;
use Illuminate\Http\{
    Request,
    JsonResponse
};

class PemeriksaanTerapiTargetController extends Controller
{
    protected $mainService;
    public function __construct()
    {
        $this->mainService = new PemeriksaanTerapiTargetService();

        $this->middleware('permission:pasien-pemeriksaan.show')->only(['getData', 'datatable']);
        $this->middleware('permission:pasien-pemeriksaan.inspection')->only([
            'store', 'update', 'destroy'
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

    public function store(PemeriksaanTerapiTargetRequest $request)
    {
        return $this->mainService->transaction(function () use ($request) {
            return $this->mainService->create($request->all());
        })->responseResult();
    }


    public function update($id, PemeriksaanTerapiTargetRequest $request)
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
