<?php

namespace App\Repository\System;

use App\Models\System\ScheduleResultModel;
use App\Repository\BaseRepository;

class ScheduleResultRepository extends BaseRepository
{
    public function __construct() {
        $this->query = new ScheduleResultModel();
    }

    public function getDataByScheduleId($scheduleId)
    {
        $this->query = $this->query->where('schedule_id', $scheduleId);
        return $this;
    }
}
