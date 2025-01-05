<?php

namespace Database\Seeders;

use App\Models\UAM\PermissionModel;
use App\Models\UAM\RoleModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $programmers = [
            [
                'name' => "permission.index",
                'keterangan' => "melihat data Permission",
            ],
            [
                'name' => "permission.create",
                'keterangan' => "menambahkan data Permission",
            ],
            [
                'name' => "permission.edit",
                'keterangan' => "mengubah data Permission",
            ],
            [
                'name' => "permission.delete",
                'keterangan' => "menghapus data Permission",
            ],
            [
                'name' => "role.index",
                'keterangan' => "melihat data Role",
            ],
            [
                'name' => "role.create",
                'keterangan' => "menambahkan data Role",
            ],
            [
                'name' => "role.edit",
                'keterangan' => "mengubah data Role",
            ],
            [
                'name' => "role.delete",
                'keterangan' => "menghapus data Role",
            ],
            [
                'name' => "schedule.index",
                'keterangan' => "melihat data Schedule",
            ],
            [
                'name' => "schedule.show",
                'keterangan' => "melihat detail Schedule",
            ],
            [
                'name' => "schedule.create",
                'keterangan' => "menambahkan data Schedule",
            ],
            [
                'name' => "schedule.edit",
                'keterangan' => "mengubah data Schedule",
            ],
            [
                'name' => "schedule.delete",
                'keterangan' => "menghapus data Schedule",
            ],
            [
                'name' => "schedule.execution",
                'keterangan' => "menjalankan schedule secara manual",
            ],
            [
                'name' => "log.index",
                'keterangan' => "melihat data log user",
            ],
        ];

        $admins = [
            //user
            [
                'name' => "user.index",
                'keterangan' => "melihat data User",
            ],
            [
                'name' => "user.create",
                'keterangan' => "menambahkan data User",
            ],
            [
                'name' => "user.edit",
                'keterangan' => "mengubah data User",
            ],
            [
                'name' => "user.delete",
                'keterangan' => "menghapus data User",
            ],
            //satker
            [
                'name' => "satker.index",
                'keterangan' => "melihat data Satker",
            ],
            [
                'name' => "satker.show",
                'keterangan' => "melihat detail data Satker",
            ],
            [
                'name' => "satker.admin",
                'keterangan' => "melihat seluruh data",
            ],
            [
                'name' => "satker.create",
                'keterangan' => "menambahkan data Satker",
            ],
            [
                'name' => "satker.edit",
                'keterangan' => "mengubah data Satker",
            ],
            [
                'name' => "satker.delete",
                'keterangan' => "menghapus data Satker",
            ]
        ];

        $permissions = array_merge($programmers, $admins);

        foreach ($permissions as $permission) {
            PermissionModel::create($permission);
        }

        $roles = [
            [
                'name'              => 'SuAdmin',
                'permissions'       => array_column($permissions, 'name')
            ],
            [
                'name'              => "Admin",
                'permissions'       => array_column($admins, 'name')
            ]
        ];

        foreach ($roles as $role) {
            $item = RoleModel::create(['name' => $role['name']]);

            DB::table('role_has_permissions')
                ->insertUsing(
                    ['role_id', 'permission_id'],
                    PermissionModel::select([DB::raw($item->id . " as role_id"), 'id as permission_id'])->whereIn('name', $role['permissions'])
                );
        }
    }
}
