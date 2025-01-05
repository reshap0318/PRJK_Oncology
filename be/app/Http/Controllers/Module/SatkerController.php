<?php

namespace App\Http\Controllers\Module;

use App\Http\Controllers\Controller;
use App\Http\Requests\Module\SatkerRequest;
use App\Services\Module\SatkerService;
use Illuminate\Http\{
    Request,
    JsonResponse
};

class SatkerController extends Controller
{
    protected $mainService;
    public function __construct() {
        $this->mainService = new SatkerService();

        $this->middleware('permission:satker.index')->only(['getData', 'datatable']);
        $this->middleware('permission:satker.create')->only(['store']);
        $this->middleware('permission:satker.edit')->only(['update']);
        $this->middleware('permission:satker.delete')->only(['destroy']);
    }

    public function getData($id): JsonResponse
    {
        return $this->mainService->transaction(function () use ($id) {
            return $this->mainService->getData($id);
        })->responseResult();
    }

    public function datatable()
    {
        return $this->mainService->datatable();
    }

    public function store(SatkerRequest $request): JsonResponse
    {
        return $this->mainService->transaction(function() use ($request) {
            return $this->mainService->create($request->all());
        })->responseResult();
    }

    public function update($id, SatkerRequest $request): JsonResponse
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
