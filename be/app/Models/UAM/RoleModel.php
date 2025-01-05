<?php

namespace App\Models\UAM;

use App\Helpers\Authorization;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class RoleModel extends Model
{
    use HasFactory;

    protected $table = 'roles';

    protected $fillable = [
        'name',
    ];

    protected $hidden = ['pivot'];

    public function getTableCon(): string
    {
        return $this->getConnectionName().".".$this->getTable();
    }

    protected function actionModel(): Attribute
    {
        return Attribute::make(
            get: function($value)
            {
                return [
                    'edit' => [
                        'isCan' => Authorization::hasPermission('role.edit'),
                        'link'  => null,
                    ],
                    'delete' => [
                        'isCan' => Authorization::hasPermission('role.delete'),
                        'link'  => null,
                    ],
                ];
            }
        );
    }

    public function permissions()
    {
        return $this->belongsToMany(
            PermissionModel::class, 
            'role_has_permissions',
            'role_id',
            'permission_id',
            'id', //permission.id
            'id', //role.id
        );
    }

    public function users()
    {
        return $this->belongsToMany(
            User::class, 
            'user_has_roles',
            'role_id',
            'user_id',
            'id', //user.id
            'id', //role.id
        );
    }
}
