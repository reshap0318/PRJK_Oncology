<?php

namespace App\Http\Controllers\UAM;

use App\Http\Controllers\Controller;
use App\Http\Requests\UAM\RoleRequest;
use App\Services\UAM\RoleService;
use Illuminate\Http\{
    Request,
    JsonResponse
};

class RoleController extends Controller
{
    protected $mainService;
    public function __construct() {
        $this->mainService = new RoleService();

        $this->middleware('permission:role.index')->only(['getData', 'datatable']);
        $this->middleware('permission:role.create')->only(['store']);
        $this->middleware('permission:role.edit')->only(['update']);
        $this->middleware('permission:role.delete')->only(['destroy']);
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

    public function store(RoleRequest $request): JsonResponse
    {
        return $this->mainService->transaction(function() use ($request) {
            return $this->mainService->create($request->all());
        })->responseResult();
    }

    public function update($id, RoleRequest $request): JsonResponse
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
