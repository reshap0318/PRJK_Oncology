<?php

namespace Database\Seeders;

use App\Models\Module\SatkerModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SatkerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            [
                'name' => "Universitas Andalas",
                'childrens' => [
                    [
                        'name' => "Dummy Fakultas",
                        'childrens' => [
                            [
                                'name' => "Dummy Jurusan",
                            ]
                        ],
                    ]
                ]
            ]
        ];

        $this->created($datas);
    }

    public function created(array $datas = [], $parentId = null)
    {
        foreach ($datas as $data) {
            $satker = SatkerModel::create([
                'name'      => $data['name'],
                'parent_id' => $parentId
            ]);

            if (isset($data['childrens']) && count($data['childrens']) > 0) {
                $this->created($data['childrens'], $satker->id);
            }
        }
    }
}
