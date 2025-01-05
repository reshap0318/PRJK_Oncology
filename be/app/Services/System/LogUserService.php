<?php

namespace App\Services\System;

use App\Repository\System\LogUserRepository;
use App\Services\BaseService;
use Yajra\DataTables\Facades\DataTables;

class LogUserService extends BaseService
{
    protected $mainRepository;
    public function __construct() {
        $this->mainRepository = new LogUserRepository();
    }

    public function datatable()
    {
        $query = $this->mainRepository->withUser()->getQuery();
        return DataTables::eloquent($query)
            ->editColumn('server_time', function($d) {
                return parseDateTimeId($d->server_time)->format("l, d-m-Y H:i");
            })
            ->make(true);
    }
}