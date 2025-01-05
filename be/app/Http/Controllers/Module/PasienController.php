<?php

namespace App\Http\Controllers\Module;

use App\Http\Controllers\Controller;
use App\Http\Requests\Module\PasienRequest;
use App\Services\Module\PasienService;
use Illuminate\Http\{
    Request,
    JsonResponse
};

class PasienController extends Controller
{
    protected $mainService;
    public function __construct() {
        $this->mainService = new PasienService();

        $this->middleware('permission:pasien.index')->only(['datatable']);
        $this->middleware('permission:pasien.show')->only(['getData']);
        $this->middleware('permission:pasien.create')->only(['detail']);
        $this->middleware('permission:pasien.edit')->only(['update']);
        $this->middleware('permission:pasien.delete')->only(['destroy']);
    }

    public function getData($id)
    {
        return $this->mainService->transaction(function() use ($id) {
            return $this->mainService->getById($id);
        })->responseResult();
    }

    public function datatable()
    {
        return $this->mainService->datatable();
    }

    public function store(PasienRequest $request): JsonResponse
    {
        return $this->mainService->transaction(function() use ($request) {
            return $this->mainService->create($request->all());
        })->responseResult();
    }

    public function update($id, PasienRequest $request): JsonResponse
    {
        return $this->mainService->transaction(function() use ($id, $request) {
            return $this->mainService->update($id, $request->all());
        })->responseResult();
    }

    public function destroy($id): JsonResponse
    {
        return $this->mainService->transaction(function() use ($id) {
            return $this->mainService->delete($id);
        })->responseResult();
    }
}
