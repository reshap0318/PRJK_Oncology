<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'username'  => 'reshap0318',
                'name'      => 'Reinaldo Shandev Pratama',
                'email'     => 'darkrenshandev@gmail.com',
                'password'  => '@dmin#123',
                'is_active' => User::S_ACTIVE,
                'no_telp'   => null,
                'alamat'    => null,
                'roles'     => [User::R_SUPER_ADMIN]
            ],
            [
                'username'  => 'admin',
                'name'      => 'Admin',
                'email'     => 'aldo.reshap@gmail.com',
                'password'  => 'admin#123',
                'is_active' => User::S_ACTIVE,
                'no_telp'   => null,
                'alamat'    => null,
                'roles'     => [User::R_ADMIN]
            ],
            [
                'username'  => 'dokter01',
                'name'      => 'Dokter 01',
                'email'     => 'dokter01@unand.ac.id',
                'password'  => 'dokter01#123',
                'is_active' => User::S_ACTIVE,
                'no_telp'   => null,
                'alamat'    => null,
                'roles'     => [User::R_DOKTER]
            ],
            [
                'username'  => 'mahasiswa01',
                'name'      => 'Mahasiswa 01',
                'email'     => 'mahasiswa01@unand.ac.id',
                'password'  => 'mahasiswa01#123',
                'is_active' => User::S_ACTIVE,
                'no_telp'   => null,
                'alamat'    => null,
                'roles'     => [User::R_MAHASISWA]
            ],
        ];

        foreach ($users as $data) {
            $role = $data['roles'];
            if(isset($data['roles'])) unset($data['roles']);

            $user = User::create($data);
            $user->roles()->sync($role);
        }
    }
}
