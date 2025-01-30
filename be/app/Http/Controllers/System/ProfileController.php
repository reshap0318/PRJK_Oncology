<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Http\Requests\System\ProfileChangePasswordRequest;
use App\Http\Requests\System\ProfileUpdateRequest;
use App\Services\System\ProfileService;
use Illuminate\Http\{
    Request,
    JsonResponse
};

class ProfileController extends Controller
{
    protected $mainService;
    public function __construct() {
        $this->mainService = new ProfileService();
    }

    public function index()
    {
        return $this->mainService->transaction(function() {
            return $this->mainService->getProfile();
        })->responseResult();
    }

    public function validedToken()
    {
        return $this->mainService->transaction(function() {
            return $this->mainService->validedToken();
        })->responseResult();
    }

    public function access(): JsonResponse
    {
        return $this->mainService->transaction(function() {
            return $this->mainService->getAccess();
        })->responseResult();
    }

    public function logs(): JsonResponse
    {
        return $this->mainService->transaction(function() {
            return $this->mainService->getLogs();
        })->responseResult();
    }

    public function update(ProfileUpdateRequest $request): JsonResponse
    {
        return $this->mainService->transaction(function() use ($request) {
            return $this->mainService->updateProfile($request->except(['nik', 'email']));
        })->responseResult();
    }

    public function changePassword(ProfileChangePasswordRequest $request): JsonResponse
    {
        return $this->mainService->transaction(function() use ($request) {
            return $this->mainService->updateProfile($request->all());
        })->responseResult();
    }
}
