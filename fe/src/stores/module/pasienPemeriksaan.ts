import client from 'api-client'
import { defineStore } from 'pinia'
import { baseStore } from '@/core/helpers/store'
import { useVuelidate } from '@vuelidate/core'
import { required, requiredIf, helpers } from '@vuelidate/validators'
import { computed, ref } from 'vue'

const basePath = '/api/pasien-pemeriksaan'
const base = baseStore(basePath)

export const year = new Date().getFullYear()
export const usePasienPemeriksaanStore = defineStore('pasien-pemeriksaan', () => {
    const formCreate = ref({
        dokter_id: null,
        pasien_id: null,
        tanggal: null
    })

    const rulesCreate = computed(() => {
        return {
            dokter_id: { required },
            pasien_id: { required },
            tanggal: { required }
        }
    })

    const formCreateValidated = useVuelidate(rulesCreate, formCreate)

    const formUpdate = ref({
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
                    duration: null
                }
            ],
            gejalas: [
                {
                    id: 0,
                    description: null,
                    duration: null
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
                value: [
                    {
                        siapa: null,
                        apa: null,
                        tahun: null
                    }
                ]
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
            staging_t: '',
            staging_n: '',
            staging_m: '',
            stage: [],
            ps: [],
            mutasi: null,
            whild_type: 0,
            pdl1: null,
            alk: [],
            komorbid: null
        },
        outcome: {
            progress: null,
            dead: null,
            description: null
        },
        paal_paru: {
            kvp_ml: null,
            kvp_percent: null,
            vep_ml: null,
            vep_percent: null,
            vep_kvp: null,
            description: null
        },
        bronkoskopi: {
            vocal_cords: null,
            trachea: null,
            carina: null,

            r_bu: null,
            r_carina_second: null,
            r_la: null,
            r_lb: null,
            r_ti: null,
            r_lm: null,

            l_bu: null,
            l_carina_second: null,
            l_la: null,
            l_lb: null,
            l_ld: null
        },
        sitologis: [
            {
                label: null,
                category: null,
                date: null,
                type: null,
                type_detail: null,
                description: null
            }
        ]
    })

    const rulesUpdate = computed(() => {
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
                        description: { },
                        duration: { 
                            required: (value: number, item: any) => {
                                if(!item.description) return true
                                return value != null;
                            }
                        }
                    })
                },
                penyakits: {
                    $each: helpers.forEach({
                        description: { }
                    })
                },
                kategori_perokok: {
                    history: { required },
                    count_year: {
                        required: requiredIf(() =>
                            [1, 2].includes(formUpdate.value.anemnesis.kategori_perokok.history)
                        )
                    },
                    stick_day: {
                        required: requiredIf(() =>
                            [1].includes(formUpdate.value.anemnesis.kategori_perokok.history)
                        )
                    },
                    ib: {
                        required: requiredIf(() =>
                            [1].includes(formUpdate.value.anemnesis.kategori_perokok.history)
                        )
                    },
                    category: {
                        required: requiredIf(() =>
                            [1].includes(formUpdate.value.anemnesis.kategori_perokok.history)
                        )
                    },
                    suck: {
                        required: requiredIf(() =>
                            [1].includes(formUpdate.value.anemnesis.kategori_perokok.history)
                        )
                    }
                },
                paparan_asap_rokok: {
                    own: {},
                    value: {
                        required: requiredIf(
                            () => formUpdate.value.anemnesis.paparan_asap_rokok.own == 1
                        )
                    }
                },
                pekerjaan_beresiko: {
                    own: {},
                    value: {
                        required: requiredIf(
                            () => formUpdate.value.anemnesis.pekerjaan_beresiko.own == 1
                        )
                    }
                },
                tempat_tinggal_sekitar_pabrik: {
                    own: {},
                    value: {
                        required: requiredIf(
                            () => formUpdate.value.anemnesis.tempat_tinggal_sekitar_pabrik.own == 1
                        )
                    }
                },
                riwayat_keganasan_organ_lain: {
                    own: {},
                    value: {
                        required: requiredIf(
                            () => formUpdate.value.anemnesis.riwayat_keganasan_organ_lain.own == 1
                        )
                    }
                },
                paparan_radon: {
                    own: 0,
                    value: {
                        required: requiredIf(
                            () => formUpdate.value.anemnesis.paparan_radon.own == 1
                        )
                    }
                },
                biomess: {
                    own: 0,
                    value: {
                        required: requiredIf(() => formUpdate.value.anemnesis.biomess.own == 1)
                    }
                },
                riwayat_ppok: {
                    own: {},
                    value: {
                        required: requiredIf(() => formUpdate.value.anemnesis.riwayat_ppok.own == 1)
                    }
                },
                riwayat_tb: {
                    own: {},
                    value: {
                        tahun: {
                            required: requiredIf(
                                () => formUpdate.value.anemnesis.riwayat_tb.own == 1
                            )
                        },
                        oat: {
                            required: requiredIf(
                                () => formUpdate.value.anemnesis.riwayat_tb.own == 1
                            )
                        }
                    }
                },
                riwayat_kaganasan_keluarga: {
                    own: {},
                    value: {
                        $each: helpers.forEach({
                            siapa: {
                                required: requiredIf(
                                    () => formUpdate.value.anemnesis.riwayat_kaganasan_keluarga.own == 1
                                )
                            },
                            apa: {
                                required: requiredIf(
                                    () => formUpdate.value.anemnesis.riwayat_kaganasan_keluarga.own == 1
                                )
                            },
                            tahun: {
                                required: requiredIf(
                                    () => formUpdate.value.anemnesis.riwayat_kaganasan_keluarga.own == 1
                                )
                            }
                        })
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
                    required: requiredIf(() => formUpdate.value.pemeriksaan_fisik.kgb_option == 1)
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
                staging_t: {}, //{ required },
                staging_n: {}, //{ required },
                staging_m: {}, //{ required },
                stage: {}, //{ required },
                ps: {}, //{ required },
                mutasi: {}, //{ required },
                whild_type: {}, //{ required },
                pdl1: {}, //{ required },
                alk: {}, //{ required },
                komorbid: {} //{ required }
            },
            outcome: {
                progress: {}, //{ required },
                dead: {}, //{ required },
                description: {} //{ required }
            },
            paal_paru: {
                kvp_ml: {}, //{ required },
                kvp_percent: {}, //{ required },
                vep_ml: {}, //{ required },
                vep_percent: {}, //{ required },
                vep_kvp: {}, //{ required },
                description: {} //{ required },
            },
            bronkoskopi: {
                vocal_cords: {}, //{ required },
                trachea: {}, //{ required },
                carina: {}, //{ required },

                r_bu: {}, //{ required },
                r_carina_second: {}, //{ required },
                r_la: {}, //{ required },
                r_lb: {}, //{ required },
                r_ti: {}, //{ required },
                r_lm: {}, //{ required },

                l_bu: {}, //{ required },
                l_carina_second: {}, //{ required },
                l_la: {}, //{ required },
                l_lb: {}, //{ required },
                l_ld: {} //{ required },
            },
            sitologis: {
                $each: helpers.forEach({
                    type_detail: { 
                        required: (value: string, item: any) => {
                            if(!item.type) return true
                            return value != null;
                        }
                    }
                })
            }
        }
    })

    const formUpdateValidated = useVuelidate(rulesUpdate, formUpdate)

    return {
        ...base,
        formUpdate,
        formUpdateValidated,
        formCreate,
        formCreateValidated
    }
})
