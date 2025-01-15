import client from 'api-client'
import { defineStore } from 'pinia'
import { baseStore } from '@/core/helpers/store'
import { useVuelidate } from '@vuelidate/core'
import { required, requiredIf, helpers } from '@vuelidate/validators'
import { useAuthStore } from '@/stores/auth'
import { computed, ref } from 'vue'

const basePath = '/api/pasien-pemeriksaan'
const base = baseStore(basePath)

export const year = new Date().getFullYear()
export const usePasienPemeriksaanStore = defineStore('pasien-pemeriksaan', () => {
    const formInput = ref({
        id: 0,
        overview: {
            dokter_id: null,
            pasien_id: null,
            tanggal: null
        },
        anemnesis: {
            keluhans: [
                {
                    id: 0,
                    description: null,
                    duration: 0
                }
            ],
            gejalas: [
                {
                    id: 0,
                    description: null,
                    duration: 0
                }
            ],
            penyakit_riwayats: [
                {
                    id: 0,
                    description: null
                }
            ],
            penyakits: [
                {
                    id: 0,
                    description: null
                }
            ],
            kategori_perokok: {
                id: 0,
                history: 3,
                stick_day: null,
                count_year: null,
                ib: 3,
                category: null,
                suck: 0
            },
            paparan_asap_rokok: {
                id: 0,
                own: 0,
                value: null
            },
            pekerjaan_beresiko: {
                id: 0,
                own: 0,
                value: null
            },
            tempat_tinggal_sekitar_pabrik: {
                id: 0,
                own: 0,
                value: null
            },
            riwayat_keganasan_organ_lain: {
                id: 0,
                own: 0,
                value: null
            },
            paparan_radon: {
                id: 0,
                own: 0,
                value: []
            },
            biomess: {
                id: 0,
                own: 0,
                value: []
            },
            riwayat_ppok: {
                id: 0,
                own: 0,
                value: null
            },
            riwayat_tb: {
                id: 0,
                own: 0,
                value: {
                    tahun: null,
                    oat: null
                }
            },
            riwayat_kaganasan_keluarga: {
                id: 0,
                own: 0,
                value: {
                    siapa: null,
                    apa: null,
                    tahun: null
                }
            }
        },
        pemeriksaan_fisik: {
            awareness: null,
            condition: null,
            td: null,
            nadi: null,
            rr: null,
            suhu: null,
            sp_o2: null,
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
            staging: [],
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
            keadaan_pulang: null,
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
            anemnesis: {
                keluhans: {
                    $each: helpers.forEach({
                        description: { required },
                        duration: { required }
                    })
                },
                gejalas: {
                    $each: helpers.forEach({
                        description: { required },
                        duration: { required }
                    })
                },
                penyakits: {
                    $each: helpers.forEach({
                        description: { required }
                    })
                },
                kategori_perokok: {
                    history: { required },
                    count_year: {
                        required: requiredIf(() =>
                            [1, 2].includes(formInput.value.anemnesis.kategori_perokok.history)
                        )
                    },
                    stick_day: {
                        required: requiredIf(() =>
                            [1].includes(formInput.value.anemnesis.kategori_perokok.history)
                        )
                    },
                    ib: {
                        required: requiredIf(() =>
                            [1].includes(formInput.value.anemnesis.kategori_perokok.history)
                        )
                    },
                    category: {
                        required: requiredIf(() =>
                            [1].includes(formInput.value.anemnesis.kategori_perokok.history)
                        )
                    },
                    suck: {
                        required: requiredIf(() =>
                            [1].includes(formInput.value.anemnesis.kategori_perokok.history)
                        )
                    }
                },
                pekerjaan_beresiko: {
                    own: {},
                    value: {
                        required: requiredIf(
                            () => formInput.value.anemnesis.pekerjaan_beresiko.own == 1
                        )
                    }
                },
                tempat_tinggal_sekitar_pabrik: {
                    own: {},
                    value: {
                        required: requiredIf(
                            () => formInput.value.anemnesis.tempat_tinggal_sekitar_pabrik.own == 1
                        )
                    }
                },
                riwayat_keganasan_organ_lain: {
                    own: {},
                    value: {
                        required: requiredIf(
                            () => formInput.value.anemnesis.riwayat_keganasan_organ_lain.own == 1
                        )
                    }
                },
                paparan_radon: {
                    own: 0,
                    value: {
                        required: requiredIf(() => formInput.value.anemnesis.paparan_radon.own == 1)
                    }
                },
                biomess: {
                    own: 0,
                    value: {
                        required: requiredIf(() => formInput.value.anemnesis.biomess.own == 1)
                    }
                },
                riwayat_ppok: {
                    own: {},
                    value: {
                        required: requiredIf(() => formInput.value.anemnesis.riwayat_ppok.own == 1)
                    }
                },
                riwayat_tb: {
                    own: {},
                    value: {
                        tahun: {
                            required: requiredIf(
                                () => formInput.value.anemnesis.riwayat_tb.own == 1
                            )
                        },
                        oat: {
                            required: requiredIf(
                                () => formInput.value.anemnesis.riwayat_tb.own == 1
                            )
                        }
                    }
                },
                riwayat_kaganasan_keluarga: {
                    own: {},
                    value: {
                        siapa: {
                            required: requiredIf(
                                () => formInput.value.anemnesis.riwayat_kaganasan_keluarga.own == 1
                            )
                        },
                        apa: {
                            required: requiredIf(
                                () => formInput.value.anemnesis.riwayat_kaganasan_keluarga.own == 1
                            )
                        },
                        tahun: {
                            required: requiredIf(
                                () => formInput.value.anemnesis.riwayat_kaganasan_keluarga.own == 1
                            )
                        }
                    }
                }
            },
            pemeriksaan_fisik: {
                awareness: {}, //{ required },
                condition: {}, //{ required },
                td: {}, //{ required },
                nadi: {}, //{ required },
                rr: {}, //{ required },
                suhu: {}, //{ required },
                sp_o2: {}, //{ required },
                vas: {}, //{ required },
                description: {}, //{ required },
                kgb_option: {},
                kgb: {
                    required: requiredIf(() => formInput.value.pemeriksaan_fisik.kgb_option == 1)
                },
                inspeksi_statis: {}, //{ required },
                inspeksi_dinamis: {}, //{ required },
                palpasi: {}, //{ required },
                perkusi: {}, //{ required },
                auskultasi: {}, //{ required },
                abdomen: {}, //{ required },
                ekstemitas: {} //{ required }
            },
            diagnosa: {
                jenis_sel: {}, //{ required },
                paru: {}, //{ required },
                staging: {}, //{ required },
                stage: {}, //{ required },
                ps: {}, //{ required },
                egfr: {}, //{ required },
                mutasi: {}, //{ required },
                whild_type: {}, //{ required },
                pdl1: {}, //{ required },
                alk: {}, //{ required },
                komorbid: {} //{ required }
            },
            outcome: {
                keadaan_pulang: {}, //{ required },
                cara_pulang: {}, //{ required },
                lama_dirawat: {}, //{ required },
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
