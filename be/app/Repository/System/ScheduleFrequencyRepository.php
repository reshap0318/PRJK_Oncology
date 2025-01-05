<?php

namespace App\Repository\System;

use App\Models\System\ScheduleFrequencyModel;
use App\Repository\BaseRepository;

class ScheduleFrequencyRepository extends BaseRepository
{
    public function __construct() {
        $this->query = new ScheduleFrequencyModel();
    }

    public function deleteByScheduleId($scheduleId)
    {
        $res = $this->query->where('schedule_id', $scheduleId)->delete();
        return $res;
    }

    public function deleteByScheduleIdAndInterval($scheduleId, array $interval = [])
    {
        $res = $this->query->where('schedule_id', $scheduleId)->whereNotIn('interval', $interval)->delete();
        return $res;
    }
}
