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
                'satker_id' => 1,
                'password'  => '@dmin#123',
                'is_active' => User::S_ACTIVE,
                'gender'    => 1,
                'no_telp'   => null,
                'alamat'    => null,
                'roles'     => [1]
            ],
            [
                'username'  => 'admin',
                'name'      => 'Admin',
                'email'     => 'aldo.reshap@gmail.com',
                'satker_id' => 1,
                'password'  => 'admin#123',
                'is_active' => User::S_ACTIVE,
                'gender'    => 1,
                'no_telp'   => null,
                'alamat'    => null,
                'roles'     => [2]
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
