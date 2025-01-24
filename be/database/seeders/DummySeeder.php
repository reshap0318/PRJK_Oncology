<?php

namespace Database\Seeders;

use App\Models\Module\{
    PasienModel,
    PasienPemeriksaanModel,
    PemeriksaanFaktorResikoModel as PFR
};
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DummySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dokters = [
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
                'username'  => 'dokter02',
                'name'      => 'Dokter 02',
                'email'     => 'dokter02@unand.ac.id',
                'password'  => 'dokter02#123',
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
            [
                'username'  => 'mahasiswa02',
                'name'      => 'Mahasiswa 02',
                'email'     => 'mahasiswa02@unand.ac.id',
                'password'  => 'mahasiswa02#123',
                'is_active' => User::S_ACTIVE,
                'no_telp'   => null,
                'alamat'    => null,
                'roles'     => [User::R_MAHASISWA]
            ],
        ];

        foreach ($dokters as $data) {
            $role = $data['roles'];
            if (isset($data['roles'])) unset($data['roles']);

            $user = User::create($data);
            $user->roles()->sync($role);
        }


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
                        'inspection_at'     => '2025-01-05',
                        'user_id'           => 3,
                        'inspection_vital'  => [
                            "awareness"     => "Testing Kesadaran",
                            "condition"     => 3,
                            "td"            => 80,
                            "nadi"          => 111,
                            "rr"            => 100,
                            "suhu"          => 27,
                            "sp_o2"         => 98,
                            "vas"           => 10,
                            "description"   => "Testing Keterangan",
                            "kgb"           => "Testing Lokasi KGB",
                            "inspeksi_statis"   => "Testing Statis",
                            "inspeksi_dinamis"  => "Testing Dinamis",
                            "palpasi"       => "Testing Palpasi",
                            "perkusi"       => "Testing Perkusi",
                            "auskultasi"    => "Testing Auskultasi",
                            "abdomen"       => "Testing Abdomen",
                            "ekstemitas"    => "Testing Ekstemitas"
                        ],
                        'diagnosa'          => [
                            "jenis_sel" => [2, 3],
                            "paru"      => [2],
                            "staging"   => [2, 3],
                            "stage"     => [2, 3, 5, 8],
                            "ps"        => [2],
                            "egfr"      => "Testing EGFR",
                            "mutasi"    => "Testing Mutasi",
                            "whild_type" => 1,
                            "pdl1"      => "Testing PD-L1",
                            "alk"       => [1, 2],
                            "komorbid"  => "Testing Komorbid"
                        ],
                        'outcome'           => [
                            "progress"      =>  "2025-01-11",
                            "dead"          =>  "2025-01-11",
                            "description"   =>  "Testing Sebab Kematian",
                        ],
                        'risk_factors'       => [
                            [
                                "category"  => PFR::K_PAPARAN_ASAP_ROKOK,
                                "own"       => 0,
                                "value"     => null
                            ],
                            [
                                "category"  => PFR::K_PEKERJAAN_BERESIKO,
                                "own"       => 1,
                                "value"     => "Testing Pekerjaan Beresiko"
                            ],
                            [
                                "category"  => PFR::K_TEMPAT_TINGGAL_SEKITAR_PABRIK,
                                "own"       => 0,
                                "value"     => null
                            ],
                            [
                                "category"  => PFR::K_RIWAYAT_KEGANASAN_ORGAN_LAIN,
                                "own"       => 1,
                                "value"     => "Testing Riwayat Keganasan Organ Lain"
                            ],
                            [
                                "category"  => PFR::K_PAPARAN_RADON,
                                "own"       => 1,
                                "value"     => [2, 3]
                            ],
                            [
                                "category"  => PFR::K_BIOMESS,
                                "own"       => 1,
                                "value"     => [1]
                            ],
                            [
                                "category"  => PFR::K_RIWAYAT_PPOK,
                                "own"       => 0,
                                "value"     => null
                            ],
                            [
                                "category"  => PFR::K_RIWAYAT_TB,
                                "own"       => 0,
                                "value"     => null
                            ],
                            [
                                "category"  => PFR::K_RIWAYAT_KEGANASAN_DALAM_KELUARGA,
                                "own"       => 1,
                                "value"     => [
                                    'siapa' => "Kakek - Kakek Dahulu",
                                    'apa'   => "Tumor Otak",
                                    'tahun' => 2025
                                ]
                            ]
                        ],
                        'smoking_history'    => [
                            "history"       => 1,
                            "stick_day"     => 20,
                            "count_year"    => 5,
                            "ib"            => 3,
                            "category"      => 2,
                            "suck"          => 1
                        ],
                        'complains'       => [
                            [
                                "description"   => "Testing Keluhan 1",
                                "duration"      => 851,
                                "tag"           => 1
                            ],
                            [
                                "description"   => "Testing Keluhan 2",
                                "duration"      => 666,
                                "tag"           => 1
                            ],
                            [
                                "description"   => "Testing Gejala 1",
                                "duration"      => 765,
                                "tag"           => 2
                            ],
                            [
                                "description"   => "Testing Gejala 2",
                                "duration"      => 497,
                                "tag"           => 2
                            ],
                            [
                                "description"   => "Testing Gejala 3",
                                "duration"      => 20,
                                "tag"           => 2
                            ]
                        ],
                        'sickness'       => [
                            [
                                "description"   => "Testing Penyakit 1",
                            ],
                            [
                                "description"   => "Testing Penyakit 2",
                            ],
                        ],
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
                $vital = $inspection['inspection_vital'];
                unset($inspection['inspection_vital']);

                $diagnosa = $inspection['diagnosa'];
                unset($inspection['diagnosa']);

                $outcome = $inspection['outcome'];
                unset($inspection['outcome']);

                $riskFactors = $inspection['risk_factors'];
                unset($inspection['risk_factors']);

                $smokingHistory = $inspection['smoking_history'];
                unset($inspection['smoking_history']);

                $complains = $inspection['complains'];
                unset($inspection['complains']);

                $sickness = $inspection['sickness'];
                unset($inspection['sickness']);

                $pemeriksaanObj = PasienPemeriksaanModel::create(array_merge($inspection, ['pasien_id' => $pasientObj->id]));

                $pemeriksaanObj->vital()->create($vital);
                $pemeriksaanObj->diagnosa()->create($diagnosa);
                $pemeriksaanObj->outcome()->create($outcome);
                $pemeriksaanObj->smokingHistory()->create($smokingHistory);
                $pemeriksaanObj->riskFactors()->createMany($riskFactors);
                $pemeriksaanObj->complains()->createMany($complains);
                $pemeriksaanObj->sickness()->createMany($sickness);
            }
        }
    }
}
