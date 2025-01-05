<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class ScheduleFrequencyModel extends Model
{
    use HasFactory;

    protected $table = "schedule_frequency";
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'schedule_id',
        'interval',
        'param_1',
        'param_2'
    ];

    protected $appends = [
        'label'
    ];

    protected function label(): Attribute
    {
        return Attribute::make(
            get: function($value)
            {
                $list = config('value.schedule.available_frequency', []);
                $key = array_search(
                    $this->interval, 
                    array_column($list, 'interval')
                );
                $title = "Tidak Ditemukan";
                if($key >= 0) $title = $list[$key]['label'];
                return $title;
            }
        );
    }

}
