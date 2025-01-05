<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleResultModel extends Model
{
    use HasFactory;

    protected $table = 'schedule_results';
    protected $primaryKey = 'id';

    protected $fillable = [
        'schedule_id',
        'duration',
        'result',
    ];

    protected $casts = [
        'run_at' => 'datetime',
    ];

    public function schedule()
    {
        return $this->hasOne(ScheduleModel::class, 'id', 'schedule_id');
    }
}
