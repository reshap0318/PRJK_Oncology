<?php

namespace App\Services\System;

use App\Repository\System\{
    ScheduleResultRepository
};
use App\Services\BaseService;
use Yajra\DataTables\Facades\DataTables;

class ScheduleResultService extends BaseService
{
    protected $mainRepository;
    public function __construct() {
        $this->mainRepository = new ScheduleResultRepository();
    }

    public function datatatable($id)
    {
        $query = $this->mainRepository->getDataByScheduleId($id)->getQuery();
        
        return DataTables::eloquent($query)
            ->editColumn('run_at', function($data)
            {
                return $data->run_at ? $data->run_at->format('Y-m-d H:i:s') : null;
            })
            ->editColumn('duration', function($data)
            {
                return round($data->duration, 2)." Second";
            })
            ->make(true);
    }
}