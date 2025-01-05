<?php

namespace Database\Seeders;

use App\Models\Module\AMI\KategoriModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InstrumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // new instrumen
        $datas = [
            [
                'name' => 'Mutu Akademik',
                'mutus' => [
                    [
                        'name' => 'Standar Pendidikan',
                        'standars' => [
                            [
                                "name" => "Profil dan Kompetensi Lulusan",
                                "komponens" => [
                                    [
                                        'name' => "Komponen 1",
                                        "pernyataans" => [
                                            [
                                                "name" => "Wakil Rektor IV menjalankan sisitem perencanaan yang mencakup penganggaran berdasarkan analisis kebutuhan.",
                                                "jawabans" => [
                                                    [
                                                        "keterangan" => "Menjalankan sisitem perencanaan yang mencakup penganggaran berdasarkan analisis kebutuhan.",
                                                        "nilai" => "4",
                                                        "informasi" => "no",
                                                    ],
                                                    [
                                                        "keterangan" => "Menjalankan sisitem perencanaan yang mencakup penganggaran baru sebahagian berdasarkan analisis kebutuhan.",
                                                        "nilai" => "3",
                                                        "informasi" => "no",
                                                    ],
                                                    [
                                                        "keterangan" => "Menjalankan sisitem perencanaan yang mencakup penganggaran tidak berdasarkan analisis kebutuhan.",
                                                        "nilai" => "2",
                                                        "informasi" => "no",
                                                    ],
                                                    [
                                                        "keterangan" => "Tidak menjalankan sisitem perencanaan yang mencakup penganggaran berdasarkan analisis kebutuhan.",
                                                        "nilai" => "1",
                                                        "informasi" => "no",
                                                    ],
                                                    [
                                                        "keterangan" => "Tidak ada nilai nol",
                                                        "nilai" => "0",
                                                        "informasi" => "no",
                                                    ]
                                                ],
                                            ],
                                        ],
                                    ]
                                ],
                            ],
                            [
                                "name" => "Evaluasi dan Pengembangan Kurikulum",
                                "komponens" => [
                                    [
                                        "name" => "Komponen 1",
                                        "pernyataans" => [
                                            [
                                                "name" => "Rektor memastikan memiliki kapasitas bandwitch yang mampu mendukung layanan informasi dan komunikasi bagi internal dan external stakeholders. Kapasitas internet dengan rasio bandwidth permahasiswa yang memadai (KBPM).",
                                                "jawabans" => [
                                                    [
                                                        "keterangan" => "KBPM ≥ 0.75",
                                                        "nilai" => "4",
                                                        "informasi" => "no",
                                                    ],
                                                    [
                                                        "keterangan" => "0.50 ≤ KBPM < 0.75",
                                                        "nilai" => "3",
                                                        "informasi" => "no",
                                                    ],
                                                    [
                                                        "keterangan" => "0.25 ≤ KBPM < 0.50",
                                                        "nilai" => "2",
                                                        "informasi" => "no",
                                                    ],
                                                    [
                                                        "keterangan" => "KBPM < 0.25",
                                                        "nilai" => "1",
                                                        "informasi" => "no",
                                                    ],
                                                    [
                                                        "keterangan" => "Tidak ada nilai nol.",
                                                        "nilai" => "0",
                                                        "informasi" => "no",
                                                    ]
                                                ],
                                            ],
                                            [
                                                "name" => "Rektor menyediakan sistim TIK (Teknologi, Informasi dan Komunikasi) untuk mengumpulkan data yang akurat, dapat di pertanggungjawabkan dan terjaga kerahasiannya.",
                                                "jawabans" => [
                                                    [
                                                        "keterangan" => "menyediakan sistim TIK (Teknologi, Informasi dan Komunikasi) untuk mengumpulkan data yang akurat, dapat di pertanggungjawabkan, terjaga kerahasiannya dan dapat diakses oleh pihak yang berkepentingan.",
                                                        "nilai" => "4",
                                                        "informasi" => "no",
                                                    ],
                                                    [
                                                        "keterangan" => "menyediakan sistim TIK (Teknologi, Informasi dan Komunikasi) untuk mengumpulkan data yang akurat, dapat di pertanggungjawabkan, terjaga kerahasiannya dan belum dapat diakses oleh pihak yang berkepentingan.",
                                                        "nilai" => "3",
                                                        "informasi" => "no",
                                                    ],
                                                    [
                                                        "keterangan" => "menyediakan sistim TIK (Teknologi, Informasi dan Komunikasi) untuk mengumpulkan data yang akurat, dapat di pertanggungjawabkan, dan terjaga kerahasiannya.",
                                                        "nilai" => "2",
                                                        "informasi" => "no",
                                                    ],
                                                    [
                                                        "keterangan" => "menyediakan sistim TIK (Teknologi, Informasi dan Komunikasi) untuk mengumpulkan data belum yang akurat, dapat di pertanggungjawabkan, dan terjaga kerahasiannya.",
                                                        "nilai" => "1",
                                                        "informasi" => "no",
                                                    ],
                                                    [
                                                        "keterangan" => "belum menyediakan TIK.",
                                                        "nilai" => "0",
                                                        "informasi" => "no",
                                                    ]
                                                ],
                                            ],
                                            [
                                                "name" => "UNAND memiliki pangkalan data secara terintegrasi yang dapat membantu efisiensi dan efektivitas dalam proses evaluasi diri.",
                                                "jawabans" => [
                                                    [
                                                        "keterangan" => "telah memiliki pangkalan data secara terintegrasi yang dapat membantu efisiensi dan efektivitas dalam proses evaluasi diri.",
                                                        "nilai" => "4",
                                                        "informasi" => "no",
                                                    ],
                                                    [
                                                        "keterangan" => "telah memiliki pangkalan data secara terintegrasi yang belum dapat membantu efisiensi dan efektivitas dalam proses evaluasi diri.",
                                                        "nilai" => "3",
                                                        "informasi" => "no",
                                                    ],
                                                    [
                                                        "keterangan" => "telah memiliki pangkalan data tetapi belum terintegrasi",
                                                        "nilai" => "2",
                                                        "informasi" => "no",
                                                    ],
                                                    [
                                                        "keterangan" => "telah memiliki pangkalan data tetapi belum terintegrasi",
                                                        "nilai" => "1",
                                                        "informasi" => "no",
                                                    ],
                                                    [
                                                        "keterangan" => "Tidak ada nilai nol.",
                                                        "nilai" => "0",
                                                        "informasi" => "no",
                                                    ]
                                                ],
                                            ],
                                            [
                                                "name" => "UNAND memiliki sisitem informasi untuk layanan administrasi yang terbukti efektif memenuhi aspek aspek tersebut : (1) mencakup layanan akademik, keuangan, SDM, dan sarana dan prasarana (aset), (2) mudah diakses oleh seluruh unit kerja dalam lingkup institusi, (3) lengkap dan mutakhir, (4) Seluruh jenis layanan telah terintegrasi dan digunakan untuk pengambilan keputusan, dan (5) Seluruh jenis layanan yang terintegrasi dievaluasi secara berkala dan hasilnya ditindaklanjuti untuk penyempurnaan sistem informasi.",
                                                "jawabans" => [
                                                    [
                                                        "keterangan" => "memiliki sisitem informasi untuk layanan administrasi yang terbukti efektif memenuhi aspek aspek tersebut : (1) mencakup layanan akademik, keuangan, SDM, dan sarana dan prasarana (aset), (2) mudah diakses oleh seluruh unit kerja dalam lingkup institusi, (3) lengkap dan mutakhir, (4) Seluruh jenis layanan telah terintegrasi dan digunakan untuk pengambilan keputusan, dan (5) Seluruh jenis layanan yang terintegrasi dievaluasi secara berkala dan hasilnya ditindaklanjuti untuk penyempurnaan sistem informasi.",
                                                        "nilai" => "4",
                                                        "informasi" => "no",
                                                    ],
                                                    [
                                                        "keterangan" => "memiliki sisitem informasi untuk layanan administrasi yang terbukti efektif memenuhi aspek aspek tersebut : (1) mencakup layanan akademik, keuangan, SDM, dan sarana dan prasarana (aset), (2) mudah diakses oleh seluruh unit kerja dalam lingkup institusi, (3) lengkap dan mutakhir, dan (4) Seluruh jenis layanan telah terintegrasi dan digunakan untuk pengambilan keputusan.",
                                                        "nilai" => "3",
                                                        "informasi" => "no",
                                                    ],
                                                    [
                                                        "keterangan" => "memiliki sisitem informasi untuk layanan administrasi yang terbukti efektif memenuhi aspek aspek tersebut : (1) mencakup layanan akademik, keuangan, SDM, dan sarana dan prasarana (aset), (2) mudah diakses oleh seluruh unit kerja dalam lingkup institusi, dan (3) lengkap dan mutakhir",
                                                        "nilai" => "2",
                                                        "informasi" => "no",
                                                    ],
                                                    [
                                                        "keterangan" => "memiliki sisitem informasi untuk layanan administrasi yang memenuhi aspek aspek tersebut : (1) mencakup layanan akademik, keuangan, SDM, dan sarana dan prasarana (aset), (2) mudah diakses oleh seluruh unit kerja dalam lingkup institusi, dan (3) lengkap dan mutakhir.",
                                                        "nilai" => "1",
                                                        "informasi" => "no",
                                                    ],
                                                    [
                                                        "keterangan" => "tidak memiliki sisitem informasi untuk layanan administrasi",
                                                        "nilai" => "0",
                                                        "informasi" => "no",
                                                    ]
                                                ],
                                            ],
                                            [
                                                "name" => "UNAND memiliki sistem informasi untuk layanan proses pembelajaran, penelitian , dan PkM yang terbukti efektif memenuhi aspek-aspek berikut : (1) ketersediaan layanan e-learning, perpustakaan (e-journal, e-book, eresository, dll), (2) mudah diakses oleh sivitas akademika, dan (3) seluruh jenis layanan dievaluasi secara berkala yang hasilnya ditindak lanjuti untuk penyempurnaan sistem informasi.",
                                                "jawabans" => [
                                                    [
                                                        "keterangan" => "memiliki sistem informasi untuk layanan proses pembelajaran, penelitian , dan PkM yang terbukti efektif memenuhi aspek-aspek berikut : (1) ketersediaan layanan e-learning, perpustakaan (e-journal, e-book, eresository, dll), (2) mudah diakses oleh sivitas akademika, dan (3) seluruh jenis layanan dievaluasi secara berkala yang hasilnya ditindak lanjuti untuk penyempurnaan sistem informasi.",
                                                        "nilai" => "4",
                                                        "informasi" => "no",
                                                    ],
                                                    [
                                                        "keterangan" => "memiliki sistem informasi untuk layanan proses pembelajaran, penelitian , dan PkM yang terbukti efektif memenuhi aspek-aspek berikut : (1) ketersediaan layanan e-learning, perpustakaan (e-journal, e-book, eresository, dll), (2) mudah diakses oleh sivitas akademika, dan (3) seluruh jenis layanan dievaluasi secara berkala",
                                                        "nilai" => "3",
                                                        "informasi" => "no",
                                                    ],
                                                    [
                                                        "keterangan" => "memiliki sistem informasi untuk layanan proses pembelajaran, penelitian , dan PkM yang terbukti efektif memenuhi aspek-aspek berikut : (1) ketersediaan layanan e-learning, perpustakaan (e-journal, e-book, eresository, dll), (2) mudah diakses oleh sivitas akademika.",
                                                        "nilai" => "2",
                                                        "informasi" => "no",
                                                    ],
                                                    [
                                                        "keterangan" => "memiliki sistem informasi untuk layanan proses pembelajaran, penelitian , dan PkM namun belum lengkap.",
                                                        "nilai" => "1",
                                                        "informasi" => "no",
                                                    ],
                                                    [
                                                        "keterangan" => "tidak memiliki sistem informasi untuk layanan proses pembelajaran, penelitian , dan PkM.",
                                                        "nilai" => "0",
                                                        "informasi" => "no",
                                                    ]
                                                ],
                                            ],
                                        ]
                                    ],
                                ],
                            ],
                            [
                                "name" => "Isi Pembelajaran",
                                "komponens" => [
                                    [
                                        "name" => "Komponen 1",
                                        "pernyataans" => [
                                            [
                                                "name" => "Rektor harus memiliki blue print pengembangan, pengelolaan, dan pemanfaatan sistem informasi yang lengkap.",
                                                "jawabans" => [
                                                    [
                                                        "keterangan" => "telah memiliki blue print pengembangan, pengelolaan, dan pemanfaatan sistem informasi yang lengkap.",
                                                        "nilai" => "4",
                                                        "informasi" => "no",
                                                    ],
                                                    [
                                                        "keterangan" => "telah memiliki blue print pengembangan, pengelolaan, dan pemanfaatan sistem informasi yang kurang lengkap.",
                                                        "nilai" => "3",
                                                        "informasi" => "no",
                                                    ],
                                                    [
                                                        "keterangan" => "sedang membuat memiliki blue print pengembangan, pengelolaan, dan pemanfaatan sistem informasi",
                                                        "nilai" => "2",
                                                        "informasi" => "no",
                                                    ],
                                                    [
                                                        "keterangan" => "belum memiliki blue print pengembangan, pengelolaan, dan pemanfaatan sistem informasi.",
                                                        "nilai" => "1",
                                                        "informasi" => "no",
                                                    ],
                                                    [
                                                        "keterangan" => "Tidak ada nilai nol",
                                                        "nilai" => "0",
                                                        "informasi" => "no",
                                                    ]
                                                ],
                                            ],
                                        ]
                                    ],
                                ],
                            ],
                            [
                                "name" => "Proses Pembelajaran",
                                "komponens" => [
                                    [
                                        "name" => "Komponen 1",
                                        "pernyataans" => [
                                            [
                                                "name" => "Ketua DTIK harus mendiseminasikan setiap sistem informasi yang dimiliki kepada seluruh sivitas akademika.",
                                                "jawabans" => [
                                                    [
                                                        "keterangan" => "telah mendiseminasikan setiap sistem informasi yang dimiliki kepada seluruh sivitas akademika.",
                                                        "nilai" => "4",
                                                        "informasi" => "no",
                                                    ],
                                                    [
                                                        "keterangan" => "hanya mendiseminasikan sebagian besar sistem informasi yang dimiliki kepada seluruh sivitas akademika.",
                                                        "nilai" => "3",
                                                        "informasi" => "no",
                                                    ],
                                                    [
                                                        "keterangan" => "hanya mendiseminasikan sebagian kecil sistem informasi yang dimiliki kepada seluruh sivitas akademika.",
                                                        "nilai" => "2",
                                                        "informasi" => "no",
                                                    ],
                                                    [
                                                        "keterangan" => "belum pernah mendiseminasikan setiap sistem informasi yang dimiliki kepada seluruh sivitas akademika.",
                                                        "nilai" => "1",
                                                        "informasi" => "no",
                                                    ],
                                                    [
                                                        "keterangan" => "Tidak ada nilai nol.",
                                                        "nilai" => "0",
                                                        "informasi" => "no",
                                                    ],
                                                ],
                                            ],
                                        ]
                                    ],
                                ],
                            ],
                            [
                                "name" => "Penilaian Pembelajaran",
                            ],
                            [
                                "name" => "Dosen dan Tenaga Kependidikan dalam Pembelajaran",
                            ],
                            [
                                "name" => "Sarana dan Prasarana Pembelajaran",
                            ],
                            [
                                "name" => "Pengelolaan Pembelajaran",
                            ],
                            [
                                "name" => "Pembiayaan Pembelajaran",
                            ],
                            [
                                "name" => "Suasana Akademik",
                            ],
                            [
                                "name" => "Input Mahasiswa",
                            ],
                            [
                                "name" => "Output Pendidikan",
                            ],
                            [
                                "name" => "Outcomes Pendidikan",
                            ],
                            [
                                "name" => "Impact Pembelajaran",
                            ],
                        ]
                    ],
                    [
                        'name' => 'Standar Penelitian',
                        'standars' => [
                            [
                                "name" => "Perencanaan Penelitian",
                            ],
                            [
                                "name" => "Isi Penelitian",
                            ],
                            [
                                "name" => "Proses Penelitian",
                            ],
                            [
                                "name" => "Penilaian Penelitian",
                            ],
                            [
                                "name" => "Peneliti",
                            ],
                            [
                                "name" => "Sarana Prasarana Penelitian",
                            ],
                            [
                                "name" => "Pengelolaan Penelitian",
                            ],
                            [
                                "name" => "Pendanaan dan Pembiayaan Penelitian",
                            ],
                            [
                                "name" => "Output Penelitian",
                            ],
                            [
                                "name" => "Outcomes Penelitian",
                            ],
                            [
                                "name" => "Impact Penelitian",
                            ],
                        ]
                    ],
                    [
                        'name' => 'Standar Pengabdian Kepada Masyarakat',
                        'standars' => [
                            [
                                "name" => "Rencana Pengabdian Kepada Masyarakat",
                            ],
                            [
                                "name" => "Isi Pengabdian Kepada Masyarakat",
                            ],
                            [
                                "name" => "Proses Pengabdian Kepada Masyarakat",
                            ],
                            [
                                "name" => "Penilaian Pengabdian Kepada Masyarakat",
                            ],
                            [
                                "name" => "Pengabdi",
                            ],
                            [
                                "name" => "Sarana Prasarana Pengabdian Kepada Masyarakat",
                            ],
                            [
                                "name" => "Sarana Pengelolaan Pengabdian Kepada Masyarakat",
                            ],
                            [
                                "name" => "Pendanaan dan Pembiayaan Pengabdian Kepada Masyarakat",
                            ],
                            [
                                "name" => "Output Pengabdian Kepada Masyarakat",
                            ],
                            [
                                "name" => "Outcomes Pengabdian Kepada Masyarakat",
                            ],
                            [
                                "name" => "Impact Pengabdian Kepada Masyarakat",
                            ],
                        ]
                    ]
                ],
            ],
            [
                'name' => 'Mutu Non Akademik',
                'mutus' => [
                    [
                        'name' => "Mutu Non Akademik",
                        "standars" => [
                            [
                                'name' => 'Standar Visi, Misi, dan Tujuan',
                                "komponens" => [
                                    [
                                        "name" => "Standar Visi, Misi, dan Tujuan",
                                        "pernyataans" => [
                                            [
                                                "name" => "Rektor memiliki dokumen formal rencana strategis dan bukti mekanisme penyusunan serta persetujuannya, yang mencakup 5 aspek (1). perencanaan (planning), 2. pengorganisasian (organizing), penempatan personil (staffing), 4. Pengarahan (leading), dan 5. Pengawasan (controlling) dan ada benchmark dengan perguruan tinggi sejenis tingkat internasional.",
                                                "jawabans" => [
                                                    [
                                                        "keterangan" => "Memiliki dokumen formal rencana strategis dan bukti mekanisme penyusunan serta persetujuannya, yang mencakup 5 aspek (1). perencanaan (planning), 2. pengorganisasian (organizing), penempatan personil (staffing), 4. Pengarahan (leading), dan 5. Pengawasan (controlling) dan ada benchmark dengan perguruan tinggi sejenis tingkat internasional.",
                                                        "nilai" => "4",
                                                        "informasi" => "no",
                                                    ],
                                                    [
                                                        "keterangan" => "Memiliki dokumen formal rencana strategis dan bukti mekanisme penyusunan serta persetujuannya, yang mencakup 5 aspek (1). perencanaan (planning), 2. pengorganisasian (organizing), penempatan personil (staffing), 4. Pengarahan (leading), dan 5. Pengawasan (controlling) dan ada benchmark dengan perguruan tinggi sejenis tingkat nasional.",
                                                        "nilai" => "3",
                                                        "informasi" => "no",
                                                    ],
                                                    [
                                                        "keterangan" => "Memiliki dokumen formal rencana strategis dan bukti mekanisme penyusunan serta persetujuannya, yang mencakup 5 aspek (1). perencanaan (planning), 2. pengorganisasian (organizing), penempatan personil (staffing), 4. Pengarahan (leading), dan 5. Pengawasan (controlling).",
                                                        "nilai" => "2",
                                                        "informasi" => "no",
                                                    ],
                                                    [
                                                        "keterangan" => "Memiliki dokumen formal rencana strategis dan bukti mekanisme penyusunan serta persetujuannya, yang belum mencakup semua aspek (1). perencanaan (planning), 2. pengorganisasian (organizing), penempatan personil (staffing), 4. Pengarahan (leading), dan 5. Pengawasan (controlling).",
                                                        "nilai" => "1",
                                                        "informasi" => "no",
                                                    ],
                                                    [
                                                        "keterangan" => "Tidak memiliki dokumen formal rencana strategis dan bukti mekanisme penyusunan serta persetujuannya.",
                                                        "nilai" => "0",
                                                        "informasi" => "no",
                                                    ]
                                                ],
                                            ],
                                            [
                                                "name" => "Rektor melakukan Analisis keberhasilan dan/atau tidak berhasilan pencapaian kinerja yang telah ditetapkan institusi yang memenuhi 2 aspek sebagai berikut: 1). Capaian kinerja harus diukur dengan metode yang tepat, dan hasilnya dianalisis serta dievaluasi, dan (2) analisis terhadap capaian kinerja mencakup identitas akar masalah, faktor pendukung keberhasilan dan fator penghambat ketercapaian standar, dan deskripsi singkat tindak lanjut yang akan dilakukan institusi.",
                                                "jawabans" => [
                                                    [
                                                        "keterangan" => "Melakukan Analisis keberhasilan dan/atau tidak berhasilan pencapaian kinerja yang telah ditetapkan institusi yang memenuhi 2 aspek sebagai berikut: 1). Capaian kinerja harus diukur dengan metode yang tepat, dan hasilnya dianalisis serta dievaluasi, dan (2) analisis terhadap capaian kinerja mencakup identitas akar masalah, faktor pendukung keberhasilan dan fator penghambat ketercapaian standar, dan deskripsi singkat tindak lanjut yang akan dilakukan institusi.",
                                                        "nilai" => "4",
                                                        "informasi" => "no",
                                                    ],
                                                    [
                                                        "keterangan" => "Melakukan Analisis keberhasilan dan/atau tidak berhasilan pencapaian kinerja yang telah ditetapkan institusi yang memenuhi 2 aspek sebagai berikut: 1). Capaian kinerja harus diukur dengan metode yang tepat, dan hasilnya dianalisis serta dievaluasi, dan (2) analisis terhadap capaian kinerja mencakup identitas akar masalah, faktor pendukung keberhasilan dan fator penghambat ketercapaian standar, dan belum ada deskripsi singkat tindak lanjut yang akan dilakukan institusi.",
                                                        "nilai" => "3",
                                                        "informasi" => "no",
                                                    ],
                                                    [
                                                        "keterangan" => "Melakukan Analisis keberhasilan dan/atau tidak berhasilan pencapaian kinerja yang telah ditetapkan institusi yang memenuhi 2 aspek sebagai berikut: 1). Capaian kinerja harus diukur dengan metode yang tepat, dan hasilnya belum dianalisis serta dievaluasi, dan (2) analisis terhadap capaian kinerja mencakup identitas akar masalah, faktor pendukung keberhasilan dan fator penghambat ketercapaian standar, dan belum ada deskripsi singkat tindak lanjut yang akan dilakukan institusi.",
                                                        "nilai" => "2",
                                                        "informasi" => "no",
                                                    ],
                                                    [
                                                        "keterangan" => "Melakukan Analisis keberhasilan dan/atau tidak berhasilan pencapaian kinerja yang telah ditetapkan institusi yang memenuhi 2 aspek sebagai berikut: 1). Capaian kinerja harus belum diukur dengan metode yang tepat, dan hasilnya belum dianalisis serta dievaluasi, dan (2) analisis terhadap capaian kinerja mencakup identitas akar masalah, faktor pendukung keberhasilan dan fator penghambat ketercapaian standar, dan belum ada deskripsi singkat tindak lanjut yang akan dilakukan institusi.",
                                                        "nilai" => "1",
                                                        "informasi" => "no",
                                                    ],
                                                    [
                                                        "keterangan" => "Belum melakukan analisis keberhasilan.",
                                                        "nilai" => "0",
                                                        "informasi" => "no",
                                                    ]
                                                ],
                                            ],
                                        ],
                                    ],
                                    [
                                        "name" => "Standar Sasaran, Strategi, dan Program serta Indikator Kinerja",
                                    ],
                                ],
                            ],
                            [
                                'name' => 'Standar Tata Pamong, Tata Kelola, Penjaminan Mutu Dan Kerjasama',
                                "komponens" => [
                                    [
                                        "name" => "Sistem Tata Pamong",
                                        "pernyataans" => [
                                            [
                                                "name" => "Rektor memiliki dokumen formal rencana strategis dan bukti mekanisme penyusunan serta persetujuannya, yang mencakup 5 aspek (1). perencanaan (planning), 2. pengorganisasian (organizing), penempatan personil (staffing), 4. Pengarahan (leading), dan 5. Pengawasan (controlling) dan ada benchmark dengan perguruan tinggi sejenis tingkat internasional.",
                                                "jawabans" => [
                                                    [
                                                        "keterangan" => "Memiliki dokumen formal rencana strategis dan bukti mekanisme penyusunan serta persetujuannya, yang mencakup 5 aspek (1). perencanaan (planning), 2. pengorganisasian (organizing), penempatan personil (staffing), 4. Pengarahan (leading), dan 5. Pengawasan (controlling) dan ada benchmark dengan perguruan tinggi sejenis tingkat internasional.",
                                                        "nilai" => "4",
                                                        "informasi" => "no",
                                                    ],
                                                    [
                                                        "keterangan" => "Memiliki dokumen formal rencana strategis dan bukti mekanisme penyusunan serta persetujuannya, yang mencakup 5 aspek (1). perencanaan (planning), 2. pengorganisasian (organizing), penempatan personil (staffing), 4. Pengarahan (leading), dan 5. Pengawasan (controlling) dan ada benchmark dengan perguruan tinggi sejenis tingkat nasional.",
                                                        "nilai" => "3",
                                                        "informasi" => "no",
                                                    ],
                                                    [
                                                        "keterangan" => "Memiliki dokumen formal rencana strategis dan bukti mekanisme penyusunan serta persetujuannya, yang mencakup 5 aspek (1). perencanaan (planning), 2. pengorganisasian (organizing), penempatan personil (staffing), 4. Pengarahan (leading), dan 5. Pengawasan (controlling).",
                                                        "nilai" => "2",
                                                        "informasi" => "no",
                                                    ],
                                                    [
                                                        "keterangan" => "Memiliki dokumen formal rencana strategis dan bukti mekanisme penyusunan serta persetujuannya, yang belum mencakup semua aspek (1). perencanaan (planning), 2. pengorganisasian (organizing), penempatan personil (staffing), 4. Pengarahan (leading), dan 5. Pengawasan (controlling).",
                                                        "nilai" => "1",
                                                        "informasi" => "no",
                                                    ],
                                                    [
                                                        "keterangan" => "Tidak memiliki dokumen formal rencana strategis dan bukti mekanisme penyusunan serta persetujuannya.",
                                                        "nilai" => "0",
                                                        "informasi" => "no",
                                                    ]
                                                ],
                                            ],
                                            [
                                                "name" => "Rektor melakukan Analisis keberhasilan dan/atau tidak berhasilan pencapaian kinerja yang telah ditetapkan institusi yang memenuhi 2 aspek sebagai berikut: 1). Capaian kinerja harus diukur dengan metode yang tepat, dan hasilnya dianalisis serta dievaluasi, dan (2) analisis terhadap capaian kinerja mencakup identitas akar masalah, faktor pendukung keberhasilan dan fator penghambat ketercapaian standar, dan deskripsi singkat tindak lanjut yang akan dilakukan institusi.",
                                                "jawabans" => [
                                                    [
                                                        "keterangan" => "Melakukan Analisis keberhasilan dan/atau tidak berhasilan pencapaian kinerja yang telah ditetapkan institusi yang memenuhi 2 aspek sebagai berikut: 1). Capaian kinerja harus diukur dengan metode yang tepat, dan hasilnya dianalisis serta dievaluasi, dan (2) analisis terhadap capaian kinerja mencakup identitas akar masalah, faktor pendukung keberhasilan dan fator penghambat ketercapaian standar, dan deskripsi singkat tindak lanjut yang akan dilakukan institusi.",
                                                        "nilai" => "4",
                                                        "informasi" => "no",
                                                    ],
                                                    [
                                                        "keterangan" => "Melakukan Analisis keberhasilan dan/atau tidak berhasilan pencapaian kinerja yang telah ditetapkan institusi yang memenuhi 2 aspek sebagai berikut: 1). Capaian kinerja harus diukur dengan metode yang tepat, dan hasilnya dianalisis serta dievaluasi, dan (2) analisis terhadap capaian kinerja mencakup identitas akar masalah, faktor pendukung keberhasilan dan fator penghambat ketercapaian standar, dan belum ada deskripsi singkat tindak lanjut yang akan dilakukan institusi.",
                                                        "nilai" => "3",
                                                        "informasi" => "no",
                                                    ],
                                                    [
                                                        "keterangan" => "Melakukan Analisis keberhasilan dan/atau tidak berhasilan pencapaian kinerja yang telah ditetapkan institusi yang memenuhi 2 aspek sebagai berikut: 1). Capaian kinerja harus diukur dengan metode yang tepat, dan hasilnya belum dianalisis serta dievaluasi, dan (2) analisis terhadap capaian kinerja mencakup identitas akar masalah, faktor pendukung keberhasilan dan fator penghambat ketercapaian standar, dan belum ada deskripsi singkat tindak lanjut yang akan dilakukan institusi.",
                                                        "nilai" => "2",
                                                        "informasi" => "no",
                                                    ],
                                                    [
                                                        "keterangan" => "Melakukan Analisis keberhasilan dan/atau tidak berhasilan pencapaian kinerja yang telah ditetapkan institusi yang memenuhi 2 aspek sebagai berikut: 1). Capaian kinerja harus belum diukur dengan metode yang tepat, dan hasilnya belum dianalisis serta dievaluasi, dan (2) analisis terhadap capaian kinerja mencakup identitas akar masalah, faktor pendukung keberhasilan dan fator penghambat ketercapaian standar, dan belum ada deskripsi singkat tindak lanjut yang akan dilakukan institusi.",
                                                        "nilai" => "1",
                                                        "informasi" => "no",
                                                    ],
                                                    [
                                                        "keterangan" => "Belum melakukan analisis keberhasilan.",
                                                        "nilai" => "0",
                                                        "informasi" => "no",
                                                    ]
                                                ],
                                            ],
                                        ]
                                    ],
                                    [
                                        "name" => "Kepemimpinan",
                                    ],
                                    [
                                        "name" => "Sistem  Pengelolaan",
                                        "pernyataans" => [
                                            [
                                                "name" => "Rektor menjalankan penyebaran informasi yang efektif untuk: a) visi, misi dan tujuan melalui banner untuk pihak berkepentingan internal dan website untuk pihak berkepentingan eksternal; dan b) promosi program studi melalui brosur/leaflet dan website.",
                                                "jawabans" => [
                                                    [
                                                        "keterangan" => "Telah penyebaran informasi yang efektif untuk: a) visi, misi dan tujuan melalui banner untuk pihak berkepentingan internal dan website untuk pihak berkepentingan eksternal; dan b) promosi program studi melalui brosur/leaflet dan website.",
                                                        "nilai" => "4",
                                                        "informasi" => "no",
                                                    ],
                                                    [
                                                        "keterangan" => "Telah penyebaran informasi yang efektif untuk: a) visi, misi dan tujuan melalui banner untuk pihak berkepentingan internal dan website untuk pihak berkepentingan eksternal; dan b) promosi program studi hanya melalui website.",
                                                        "nilai" => "3",
                                                        "informasi" => "no",
                                                    ],
                                                    [
                                                        "keterangan" => "Telah penyebaran informasi yang efektif untuk: a) visi, misi dan tujuan melalui website dan b) promosi program studi hanya melalui website.",
                                                        "nilai" => "2",
                                                        "informasi" => "no",
                                                    ],
                                                    [
                                                        "keterangan" => "Telah penyebaran informasi yang belum efektif untuk: a) visi, misi dan tujuan melalui website dan b) promosi program studi hanya melalui website.",
                                                        "nilai" => "1",
                                                        "informasi" => "no",
                                                    ],
                                                    [
                                                        "keterangan" => "Belum ada upaya penyebaran informasi.",
                                                        "nilai" => "0",
                                                        "informasi" => "no",
                                                    ]
                                                ],
                                            ],
                                            [
                                                "name" => "Pusat Studi/kelompok kepakaran/perorangan harus melaporkan sumber dan jumlah dana penelitian, pengabdian kepada masyarakat ataupun jasa kepakaran yang bersumber dari luar universitas dan Menristek kepada universitas/fakultas/program studi.",
                                                "jawabans" => [
                                                    [
                                                        "keterangan" => "Telah melaporkan sumber dan jumlah dana penelitian, pengabdian kepada masyarakat ataupun jasa kepakaran yang bersumber dari luar universitas dan Menristek kepada universitas/fakultas/program studi setiap tahun.",
                                                        "nilai" => "4",
                                                        "informasi" => "no",
                                                    ],
                                                    [
                                                        "keterangan" => "Telah melaporkan sumber dan jumlah dana penelitian, pengabdian kepada masyarakat ataupun jasa kepakaran yang bersumber dari luar universitas dan Menristek kepada universitas/fakultas/program studi belum setiap tahun.",
                                                        "nilai" => "3",
                                                        "informasi" => "no",
                                                    ],
                                                    [
                                                        "keterangan" => "Telah melaporkan sumber dan jumlah dana penelitian dan pengabdian kepada masyarakat.",
                                                        "nilai" => "2",
                                                        "informasi" => "no",
                                                    ],
                                                    [
                                                        "keterangan" => "Telah melaporkan sumber dan jumlah dana penelitian.",
                                                        "nilai" => "1",
                                                        "informasi" => "no",
                                                    ],
                                                    [
                                                        "keterangan" => "Belum melaporkan sumber dan jumlah dana penelitian.",
                                                        "nilai" => "0",
                                                        "informasi" => "no",
                                                    ]
                                                ],
                                            ],
                                            [
                                                "name" => "Rektor memiliki mekanisme penetapan biaya operasional pendidikan, penelitian dan pengabdian kepada masyarakat.",
                                                "jawabans" => [
                                                    [
                                                        "keterangan" => "Telah memiliki mekanisme penetapan biaya operasional pendidikan, penelitian dan pengabdian kepada masyarakat dan telah dilaksanakan.",
                                                        "nilai" => "4",
                                                        "informasi" => "no",
                                                    ],
                                                    [
                                                        "keterangan" => "Telah memiliki mekanisme penetapan biaya operasional pendidikan, penelitian dan pengabdian kepada masyarakat dan belum dilaksanakan.",
                                                        "nilai" => "3",
                                                        "informasi" => "no",
                                                    ],
                                                    [
                                                        "keterangan" => "Telah memiliki mekanisme penetapan biaya operasional pendidikan dan penelitian.",
                                                        "nilai" => "2",
                                                        "informasi" => "no",
                                                    ],
                                                    [
                                                        "keterangan" => "Telah memiliki mekanisme penetapan biaya operasional pendidikan.",
                                                        "nilai" => "1",
                                                        "informasi" => "no",
                                                    ],
                                                    [
                                                        "keterangan" => "Belum memiliki mekanisme penetapan biaya operasional pendidikan.",
                                                        "nilai" => "0",
                                                        "informasi" => "no",
                                                    ]
                                                ],
                                            ],
                                            [
                                                "name" => "Rektor mengalokasikan sekurang-kurangnya 25% dari total dana operasional untuk kegiatan penelitian dan pengabdian kepada masyarakat termasuk bantuan seminar dan publikasi.",
                                                "jawabans" => [
                                                    [
                                                        "keterangan" => "Mengalokasikan > 25% dari total dana operasional untuk kegiatan penelitian dan pengabdian kepada masyarakat termasuk bantuan seminar dan publikasi.",
                                                        "nilai" => "4",
                                                        "informasi" => "no",
                                                    ],
                                                    [
                                                        "keterangan" => "Mengalokasikan ≤ 25% dari total dana operasional untuk kegiatan penelitian dan pengabdian kepada masyarakat termasuk bantuan seminar dan publikasi.",
                                                        "nilai" => "3",
                                                        "informasi" => "no",
                                                    ],
                                                    [
                                                        "keterangan" => "Mengalokasikan ≤ 15% dari total dana operasional untuk kegiatan penelitian dan pengabdian kepada masyarakat termasuk bantuan seminar dan publikasi.",
                                                        "nilai" => "2",
                                                        "informasi" => "no",
                                                    ],
                                                    [
                                                        "keterangan" => "Mengalokasikan ≤ 10% dari total dana operasional untuk kegiatan penelitian dan pengabdian kepada masyarakat termasuk bantuan seminar dan publikasi.",
                                                        "nilai" => "1",
                                                        "informasi" => "no",
                                                    ],
                                                    [
                                                        "keterangan" => "Mengalokasikan ≤ 5% dari total dana operasional untuk kegiatan penelitian dan pengabdian kepada masyarakat termasuk bantuan seminar dan publikasi.",
                                                        "nilai" => "0",
                                                        "informasi" => "no",
                                                    ]
                                                ],
                                            ],
                                            [
                                                "name" => "Rektor mengupayakan mengalokasikan dana bantuan bagi dosen yang sudah terputus beasiswanya.",
                                                "jawabans" => [
                                                    [
                                                        "keterangan" => "Mengalokasikan dana bantuan bagi dosen yang sudah terputus beasiswanya (tuition fee dan biaya hidup).",
                                                        "nilai" => "4",
                                                        "informasi" => "no",
                                                    ],
                                                    [
                                                        "keterangan" => "Mengalokasikan dana bantuan bagi dosen yang sudah terputus beasiswanya (hanya tuition fee).",
                                                        "nilai" => "3",
                                                        "informasi" => "no",
                                                    ],
                                                    [
                                                        "keterangan" => "Mengalokasikan dana bantuan bagi dosen yang sudah terputus beasiswanya (hanya 50%).",
                                                        "nilai" => "2",
                                                        "informasi" => "no",
                                                    ],
                                                    [
                                                        "keterangan" => "Tidak pernah mengalokasikan dana bantuan bagi dosen yang sudah terputus beasiswanya (hanya 50%)",
                                                        "nilai" => "1",
                                                        "informasi" => "no",
                                                    ],
                                                    [
                                                        "keterangan" => "Tidak ada nilai nol.",
                                                        "nilai" => "0",
                                                        "informasi" => "no",
                                                    ]
                                                ],
                                            ],
                                        ]
                                    ],
                                    [
                                        "name" => "Penjaminan Mutu",
                                    ],
                                    [
                                        "name" => "Umpan Balik Pihak Berkepentingan (Stakeholders)",
                                    ],
                                    [
                                        "name" => "Keberlanjutan",
                                    ],
                                    [
                                        "name" => "Lingkup dan Luaran Kerjasama",
                                    ],
                                    [
                                        "name" => "Kepuasan Mitra Kerjasama",
                                    ],
                                ],
                            ],
                            [
                                'name' => 'Etik',
                                "komponens" => [
                                    [
                                        "name" => "Dokumen Etik",
                                    ],
                                    [
                                        "name" => "Penegakan Etik",
                                    ],
                                ]
                            ],
                            [
                                'name' => 'Kemahasiswaan',
                                "komponens" => [
                                    [
                                        "name" => "Hak dan Kewajiban Mahasiswa",
                                    ],
                                    [
                                        "name" => "Pendampingan dan Pelayanan Kegiatan Kemahasiswaan",
                                    ],
                                    [
                                        "name" => "Organisasi Kemahasiswaan",
                                    ],
                                    [
                                        "name" => "Prestasi Mahasiswa",
                                    ],
                                ]
                            ],
                            [
                                'name' => 'Sumber Daya Manusia',
                                "komponens" => [
                                    [
                                        "name" => "Kualifikasi Dosen",
                                    ],
                                    [
                                        "name" => "Pengembangan Dosen",
                                    ],
                                    [
                                        "name" => "Kualifikasi Tenaga Kependidikan",
                                    ],
                                    [
                                        "name" => "Pengembangan Tenaga Kependidikan",
                                    ],
                                ]
                            ],
                            [
                                'name' => 'Sarana, Prasarana, Dan Dana',
                                "komponens" => [
                                    [
                                        "name" => "Sumber dan Penggunaan Dana",
                                    ],
                                    [
                                        "name" => "Teknologi, Informasi, dan Komunikasi",
                                    ],
                                    [
                                        "name" => "Prasarana dan Sarana",
                                    ],
                                ],
                            ],
                            [
                                'name' => 'Keselamatan, Kesehatan, Keamanan, Dan Lingkungan',
                                "komponens" => [
                                    [
                                        "name" => "Keamanan",
                                    ],
                                    [
                                        "name" => "Pengelolaan Lingkungan",
                                    ],
                                ],
                            ],
                        ]
                    ],
                ]
            ]
        ];

        foreach ($datas as $kategori) {
            $km = KategoriModel::create(['name' => $kategori['name']]); // kategori
            if (isset($kategori['mutus'])) {
                foreach ($kategori['mutus'] as $mutu) {
                    $mm = $km->mutus()->create(['name' => $mutu['name']]); // mutu
                    if (isset($mutu['standars'])) {
                        foreach ($mutu['standars'] as $standar) {
                            $sm = $mm->standars()->create(['name' => $standar['name']]);
                            if (isset($standar['komponens'])) {
                                foreach ($standar['komponens'] as $komponen) {
                                    $kom = $sm->komponens()->create(['name' => $komponen['name']]);
                                    // if (isset($komponen['pernyataans'])) {
                                    //     foreach ($komponen['pernyataans'] as $pernyataan) {
                                    //         $pm = $kom->pernyataans()->create(['name' => $pernyataan['name']]);
                                    //         if (isset($pernyataan['jawabans'])) {
                                    //             foreach ($pernyataan['jawabans'] as $jawaban) {
                                    //                 $pm->jawabans()->create([
                                    //                     "keterangan" => $jawaban['keterangan'],
                                    //                     "nilai"     => $jawaban['nilai'],
                                    //                     "informasi" => $jawaban['informasi'],
                                    //                 ]);
                                    //             }
                                    //         }
                                    //     }
                                    // }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
