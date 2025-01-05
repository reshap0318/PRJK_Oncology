<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use App\Http\Responses\{
    Error,
    Success
};
use App\Services\System\{
    ScheduleResultService,
    ScheduleService
};
use App\Http\Controllers\Controller;
use App\Http\Requests\System\ScheduleRequest;

class ScheduleController extends Controller
{
    protected $scheduleService, $scheduleResultService;

    public function __construct() {
        $this->scheduleService = new ScheduleService();
        $this->scheduleResultService = new ScheduleResultService();

        $this->middleware('permission:schedule.index')->only(['datatable']);
        $this->middleware('permission:schedule.show')->only(['show', 'result']);
        $this->middleware('permission:schedule.create')->only(['store']);
        $this->middleware('permission:schedule.edit')->only(['update']);
        $this->middleware('permission:schedule.delete')->only(['destroy']);
        $this->middleware('permission:schedule.execution')->only(['execute']);
    }

    public function datatable()
    {
        return $this->scheduleService->getDataTable();
    }

    public function show($id)
    {
        return $this->scheduleService->transaction(function() use ($id) {
            return $this->scheduleService->getById($id);
        })->responseResult();
    }

    public function store(ScheduleRequest $request)
    {
        return $this->scheduleService->transaction(function() use ($request) {
            return $this->scheduleService->create($request->all());
        })->responseResult();
    }

    public function update($id, ScheduleRequest $request)
    {
        return $this->scheduleService->transaction(function() use ($id, $request) {
            return $this->scheduleService->update($id, $request->all());
        })->responseResult();
    }

    public function destroy($id)
    {
        return $this->scheduleService->transaction(function() use ($id) {
            return $this->scheduleService->delete($id);
        })->responseResult();
    }

    public function execute($id)
    {
        return $this->scheduleService->transaction(function() use ($id) {
            $this->scheduleService->execute($id);
        })->responseResult();
    }

    public function result($id)
    {
        return $this->scheduleResultService->datatatable($id);
    }
}
