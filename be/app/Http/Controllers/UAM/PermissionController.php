<?php

namespace App\Http\Controllers\UAM;

use App\Http\Controllers\Controller;
use App\Http\Requests\UAM\PermissionRequest;
use App\Services\UAM\PermissionService;
use Illuminate\Http\{
    Request,
    JsonResponse
};

class PermissionController extends Controller
{
    protected $mainService;
    public function __construct() {
        $this->mainService = new PermissionService();

        $this->middleware('permission:permission.index')->only(['getData', 'datatable']);
        $this->middleware('permission:permission.create')->only(['store']);
        $this->middleware('permission:permission.edit')->only(['update']);
        $this->middleware('permission:permission.delete')->only(['destroy']);
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

    public function store(PermissionRequest $request): JsonResponse
    {
        return $this->mainService->transaction(function() use ($request) {
            return $this->mainService->create($request->all());
        })->responseResult();
    }

    public function update($id, PermissionRequest $request): JsonResponse
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
