<?php

namespace Database\Seeders;

use App\Models\Module\PasienModel;
use App\Models\Module\PasienPemeriksaanModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DummySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pasients = [
            [
                "no_mr"         => "OJT04123",
                "name"          => "Alfin Satria Pratama",
                "gender"        => 1,
                "dob"           => "1994-03-27",
                "pob"           => "Bengkulu",
                "phone"         => "0822xxxxxxxx",
                "email"         => "pasien01@gmail.com",
                "address"       => "Jln yang terletak di Bengkulu timur, Bengkulu",
                "education"     => "S1 Ekonomi",
                "job"           => "Sellest",
                "ethnic"        => "rahasia",
                'inspections'   => [
                    [
                        'inspection_at' => '2025-01-05',
                        'user_id'       => 3
                    ]
                ]
            ],
            [
                "no_mr"         => "OJT04124",
                "name"          => "Prada Eko Putra",
                "gender"        => 1,
                "dob"           => "1991-08-13",
                "pob"           => "Jakarta",
                "phone"         => "0823xxxxxxxx",
                "email"         => "pasien02@gmail.com",
                "address"       => "Jln yang terletak di Jakarta Selatan, jakarta",
                "education"     => "S1 Biologi",
                "job"           => "Guru",
                "ethnic"        => "rahasia",
                "inspections"   => []
            ]
        ];

        foreach ($pasients as $pasient) {
            $inspections = $pasient['inspections'];
            unset($pasient['inspections']);
            $pasientObj = PasienModel::create($pasient);

            foreach ($inspections as $inspection) {
                $pemeriksaanObj = PasienPemeriksaanModel::create(array_merge($inspection, ['pasien_id' => $pasientObj->id]));
            }
        }
    }
}
