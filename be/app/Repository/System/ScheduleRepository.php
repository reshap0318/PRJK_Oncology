<?php

namespace App\Repository\System;

use App\Models\System\ScheduleModel;
use App\Repository\BaseRepository;

class ScheduleRepository extends BaseRepository
{
    public function __construct() {
        $this->query = new ScheduleModel();
    }

    public function getData()
    {
        $this->query = $this->query->query()
            ->with([
                'frequencies' => function ($q)
                {
                    return $q->select(['schedule_id', 'interval', 'param_1', 'param_2']);
                }
            ])
            ->active();
        return $this;
    }

    public function getDataTable()
    {
        $this->query = $this->query->with([
            'frequencies' => function ($q)
            {
                return $q->select(['schedule_id', 'interval', 'param_1', 'param_2']);
            }
        ]);
        return $this;
    }
    
    public function getById($id)
    {
        $this->query = $this->query->with([
                'results' => function($q)
                {
                    return $q->orderBy('run_at', 'desc')->limit(1);
                },
                'frequencies' => function ($q)
                {
                    return $q->select(['schedule_id', 'interval', 'param_1', 'param_2']);
                }
            ])
            ->where('id', $id);
        return $this;
    }
}