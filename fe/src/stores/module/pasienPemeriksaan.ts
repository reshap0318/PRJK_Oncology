import { defineStore } from 'pinia'
import { baseStore } from '@/core/helpers/store'
import { ref } from 'vue'

const basePath = '/api/pasien-pemeriksaan'
const base = baseStore(basePath)

export const year = new Date().getFullYear()
export const usePasienPemeriksaanStore = defineStore('pasien-pemeriksaan', () => {
    const formInput = ref({
        anemnesis: {
            keluhans: [
                {
                    description: null,
                    long: 0
                }
            ],
            gejalas: [
                {
                    description: null,
                    long: 0
                }
            ],
            penyakits: [
                {
                    description: null
                }
            ],
            kategori_perokok: {
                riwayat: 3,
                jumlah: null,
                lama: 0,
                ib: 3,
                jenis_rokok: '',
                cara_menghisap: 0
            },
            paparan_asap_rokok: {
              value: 0
            },
            pekerjaan_beresiko: {
                value: 0,
                description: null
            },
            tempat_tinggal_sekitar_pabrik: {
                value: 0,
                description: null
            },
            riwayat_keganasan_organ_lain: {
                value: 0,
                description: null
            },
            paparan_radon: {
                value: 0,
                description: {
                    rumah_kayu: 0,
                    lantai_retak: 0,
                    sumur_dalam_rumah: 0
                }
            },
            biomess: {
                value: 0,
                description: {
                    kayu_bakar: 0,
                    minyak_tanah: 0,
                    breket: 0
                }
            },
            riwayat_ppok: {
                value: 0,
                description: year
            },
            riwayat_tb: {
                value: 0,
                description: {
                    tahun: year,
                    oat: 0
                }
            },
            riwayat_kaganasan_keluarga: {
                value: 0,
                description: {
                    siapa: null,
                    apa: null,
                    tahun: year
                }
            }
        },
        pemeriksaan_fisik: {
            kesadaran: null,
            keadaan_umum: null,
            td: null,
            nadi: null,
            rr: null,
            suhu: null,
            spo2: null,
            vas: null,
            description: null,
            kgb: null,
            inspeksi_statis: null,
            inspeksi_dinamis: null,
            palpasi: null,
            perkusi: null,
            auskultasi: null,
            abdomen: null,
            ekstemitas: null
        },
        diagnosa: {
            jenis_sel: [],
            paru: [],
            stagging: [],
            stage: [],
            ps: [],
            egfr: null,
            mutasi: null,
            whild_type: 0,
            pdl1: null,
            alk: [],
            komorbid: null
        },
        outcome: {
            keadaan_pulang: '',
            cara_pulang: '',
            lama_dirawat: null,
            tanggal_meninggal: null,
            sebab_kematian: null,
            waktu_meninggal: null
        }
    })

    return {
        ...base,
        formInput
    }
})
