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
                'name' => "user.dokter",
                'keterangan' => "melihat data User hanya Data Pribadi",
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
            //pasien
            [
                'name' => "pasien.index",
                'keterangan' => "melihat data Pasien",
            ],
            [
                'name' => "pasien.show",
                'keterangan' => "melihat detail data Pasien",
            ],
            [
                'name' => "pasien.create",
                'keterangan' => "menambahkan data Pasien",
            ],
            [
                'name' => "pasien.edit",
                'keterangan' => "mengubah data Pasien",
            ],
            [
                'name' => "pasien.delete",
                'keterangan' => "menghapus data Pasien",
            ],
            //pasien
            [
                'name' => "pasien-pemeriksaan.index",
                'keterangan' => "melihat data Pemeriksaan Pasien",
            ],
            [
                'name' => "pasien-pemeriksaan.admin",
                'keterangan' => "menambah atau mengedit seluruh data Pemeriksaan Pasien",
            ],
            [
                'name' => "pasien-pemeriksaan.all",
                'keterangan' => "melihat seluruh data Pemeriksaan Pasien",
            ],
            [
                'name' => "pasien-pemeriksaan.show",
                'keterangan' => "melihat detail data Pemeriksaan Pasien",
            ],
            [
                'name' => "pasien-pemeriksaan.inspection",
                'keterangan' => "menambah atau mengedit data Pemeriksaan Pasien",
            ],
            [
                'name' => "pasien-pemeriksaan.delete",
                'keterangan' => "menghapus data Pemeriksaan Pasien",
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
            ],
            [
                'name'              => "Dokter",
                'permissions'       => ['pasien.index', 'pasien.show', 'pasien-pemeriksaan.index', 'pasien-pemeriksaan.show', 'pasien-pemeriksaan.inspection', 'user.dokter']
            ],
            [
                'name'              => "Mahasiswa",
                'permissions'       => ['pasien.index', 'pasien.show', 'pasien-pemeriksaan.index', 'pasien-pemeriksaan.show', 'pasien-pemeriksaan.all']
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
