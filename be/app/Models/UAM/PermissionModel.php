<?php

namespace App\Models\UAM;


use App\Helpers\Authorization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class PermissionModel extends Model
{
    use HasFactory;

    protected $table = 'permissions';

    protected $fillable = [
        'name',
        'keterangan',
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
                        'isCan' => Authorization::hasPermission('permission.edit'),
                        'link'  => null,
                    ],
                    'delete' => [
                        'isCan' => Authorization::hasPermission('permission.delete'),
                        'link'  => null,
                    ],
                ];
            }
        );
    }

    public function roles()
    {
        return $this->belongsToMany(
            RoleModel::class, 
            'role_has_permissions',
            'permission_id',
            'role_id',
            'id', //permission.id
            'id', //role.id
        );
    }
}
