import client from 'api-client'
import { defineStore } from 'pinia'
import { baseStore } from '@/core/helpers/store'
import { useVuelidate } from '@vuelidate/core'
import { required, requiredIf } from '@vuelidate/validators'
import { useAuthStore } from '@/stores/auth'
import { computed, ref } from 'vue'

const basePath = '/api/pasien-pemeriksaan'
const base = baseStore(basePath)

export const year = new Date().getFullYear()
export const usePasienPemeriksaanStore = defineStore('pasien-pemeriksaan', () => {
    const formInput = ref({
        overview: {
            dokter_id: 0,
            pasien_id: null,
            tanggal: null
        },
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
            kgb_option: 0,
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
            cara_pulang: null,
            lama_dirawat: null,
            tanggal_meninggal: null,
            sebab_kematian: null,
            waktu_meninggal: null
        }
    })

    const rules = computed(() => {
        return {
            overview: {
                dokter_id: { required },
                pasien_id: { required },
                tanggal: { required }
            },
            pemeriksaan_fisik: {
                kesadaran: { required },
                keadaan_umum: { required },
                td: { required },
                nadi: { required },
                rr: { required },
                suhu: { required },
                spo2: { required },
                vas: { required },
                description: { required },
                kgb_option: {},
                kgb: {
                    required: requiredIf(() => formInput.value.pemeriksaan_fisik.kgb_option == 1)
                },
                inspeksi_statis: { required },
                inspeksi_dinamis: { required },
                palpasi: { required },
                perkusi: { required },
                auskultasi: { required },
                abdomen: { required },
                ekstemitas: { required }
            },
            diagnosa: {
                jenis_sel: { required },
                paru: { required },
                stagging: { required },
                stage: { required },
                ps: { required },
                egfr: { required },
                mutasi: { required },
                whild_type: { required },
                pdl1: { required },
                alk: { required },
                komorbid: { required }
            },
            outcome: {
                keadaan_pulang: { required },
                cara_pulang: { required },
                lama_dirawat: { required },
                tanggal_meninggal: {
                    required: requiredIf(() => formInput.value.outcome.cara_pulang == 5)
                },
                sebab_kematian: {
                    required: requiredIf(() => formInput.value.outcome.cara_pulang == 5)
                },
                waktu_meninggal: {
                    required: requiredIf(() => formInput.value.outcome.cara_pulang == 5)
                }
            }
        }
    })

    const formInputValidated = useVuelidate(rules, formInput)

    async function create(request: any) {
        const utils = useAuthStore()
        base.loading.value['create'] = true
        return new Promise((resolve, reject) => {
            client()
                .post(basePath, request, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then((res: any) => {
                    utils.setFormErrorEmpty()
                    return resolve(res)
                })
                .catch((err: any) => reject(err))
                .finally(() => (base.loading.value['create'] = false))
        })
    }

    async function update(id: number, request: any) {
        const utils = useAuthStore()
        request._method = 'PATCH'
        base.loading.value['update'] = true
        return new Promise((resolve, reject) => {
            client()
                .post(`${basePath}/${id}`, request, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then((res: any) => {
                    utils.setFormErrorEmpty()
                    return resolve(res)
                })
                .catch((err: any) => reject(err))
                .finally(() => (base.loading.value['update'] = false))
        })
    }

    return {
        ...base,
        formInput,
        formInputValidated,
        create,
        update
    }
})
