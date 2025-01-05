<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Helpers\Authorization;
use App\Models\System\LogUserModel;
use App\Models\UAM\RoleModel;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'name',
        'email',
        'password',
        'avatar_path',
        'is_active',
        'no_telp',
        'alamat',
        'last_login',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'is_active'
    ];

    protected $appends = [
        'status'
    ];

    protected function casts(): array
    {
        return [
            'last_login'        => 'datetime',
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'is_active'         => 'boolean'
        ];
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
            'email' => $this->email,
        ];
    }

    const S_NON_ACTIVE  = 0;
    const S_ACTIVE      = 1;

    const R_SUPER_ADMIN = 1;
    const R_ADMIN       = 2;
    const R_DOKTER      = 3;
    const R_MAHASISWA   = 4;

    public function getTableCon(): string
    {
        return $this->getConnectionName() . "." . $this->getTable();
    }

    protected function actionModel(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $isNotMe = $this->id != Auth::id();
                $isNotSuAdmin = $this->id != 1;
                return [
                    'edit' => [
                        'isCan' => Authorization::hasAnyPermission(['user.edit']) && $isNotMe && $isNotSuAdmin,
                        'link'  => null,
                    ],
                    'delete' => [
                        'isCan' => Authorization::hasPermission('user.delete') && $isNotMe && $isNotSuAdmin,
                        'link'  => null,
                    ],
                ];
            }
        );
    }

    protected function avatarUrl(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                return $this->avatar_path ? route('file.index', ['name' => str_replace("/", "_", $this->avatar_path)]) : asset('custom/images/avatar.png');
            }
        );
    }

    protected function status(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $this->is_active == self::S_ACTIVE ? "active" : "deactive",
        );
    }

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn($value) => parseDateTimeId($value)->format("l, d-m-Y H:i"),
        );
    }

    protected function lastLogin(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value != null ? parseDateTimeId($value)->format("l, d-m-Y H:i") : null,
        );
    }

    public function roles()
    {
        return $this->belongsToMany(
            RoleModel::class,
            'user_has_roles',
            'user_id',
            'role_id',
            'id', //permission.id
            'id', //role.id
        );
    }

    public function logs()
    {
        return $this->hasMany(LogUserModel::class, 'user_id', 'id');
    }
}
