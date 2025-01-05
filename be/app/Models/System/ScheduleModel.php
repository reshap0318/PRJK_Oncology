<?php

namespace App\Models\System;

use App\Helpers\Authorization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Notifications\Notifiable;

class ScheduleModel extends Model
{
    use HasFactory, Notifiable;

    protected $table = "schedulers";
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'description',
        'command',
        'parameters',
        'expression',
        'timezone',
        'is_active',
        'dont_overlap',
        'run_in_maintenance',
        'run_in_background',
        'notification_email',
        'notification_webhook',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    protected function actionModel(): Attribute
    {
        return Attribute::make(
            get: function($value)
            {
                return [
                    'edit' => [
                        'isCan' => Authorization::hasPermission('schedule.edit'),
                        'link'  => null,
                    ],
                    'delete' => [
                        'isCan' => Authorization::hasPermission('schedule.delete'),
                        'link'  => null,
                    ],
                    'executed' => [
                        'isCan' => Authorization::hasPermission('schedule.execution'),
                        'link'  => null,
                    ],
                ];
            }
        );
    }

    public function frequencies()
    {
        return $this->hasMany(ScheduleFrequencyModel::class, 'schedule_id', 'id');
    }

    public function results()
    {
        return $this->hasMany(ScheduleResultModel::class, 'schedule_id', 'id');
    }

    public function routeNotificationForMail(): string
    {
        return $this->notification_email;
    }

    public function routeNotificationForWebhook(): string
    {
        return $this->notification_webhook;
    }
}
