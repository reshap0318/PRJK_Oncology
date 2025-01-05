<?php

namespace App\Http\Controllers\UAM;

use App\Http\Controllers\Controller;
use App\Http\Requests\UAM\UserRequest;
use App\Services\UAM\UserService;
use Illuminate\Http\{
    Request,
    JsonResponse
};

class UserController extends Controller
{
    protected $mainService;
    public function __construct() {
        $this->mainService = new UserService();

        $this->middleware('permission:user.index')->only(['getData', 'datatable']);
        $this->middleware('permission:user.create')->only(['store']);
        $this->middleware('permission:user.edit')->only(['update']);
        $this->middleware('permission:user.delete')->only(['destroy']);
    }

    public function getData($id)
    {
        return $this->mainService->transaction(function() use ($id) {
            return $this->mainService->getById($id);
        })->responseResult();
    }

    public function datatable(Request $request)
    {
        return $this->mainService->datatable($request->all());
    }

    public function store(UserRequest $request): JsonResponse
    {
        return $this->mainService->transaction(function() use ($request) {
            return $this->mainService->create($request->all());
        })->responseResult();
    }

    public function update($id, UserRequest $request): JsonResponse
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
