<?php

namespace App\Models\System;

use App\Casts\DatetimeID;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class LogUserModel extends Model
{
    use HasFactory;

    protected $table = "log_user";
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'ip_address',
        'description',
        'url',
        'method',
        'status',
        'request_payload',
        'response_payload',
        'server_time',
    ];

    protected $casts = [
        'server_time'       => 'datetime',
        'request_payload'   => 'json',
        'response_payload'  => 'json',
    ];

    // protected function serverTime(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn ($value) => parseDateTimeId($value)->format("l, d-m-Y H:i"),
    //     );
    // }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id')->withDefault(['name' => "SYSTEM"]);
    }
}
