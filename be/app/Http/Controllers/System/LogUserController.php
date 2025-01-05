<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Services\System\LogUserService;
use Illuminate\Http\Request;

class LogUserController extends Controller
{
    protected $mainService;

    public function __construct() {
        $this->mainService = new LogUserService();
        $this->middleware('permission:log.index')->only(['datatable']);
    }

    public function datatable()
    {
        return $this->mainService->datatable();
    }
}
