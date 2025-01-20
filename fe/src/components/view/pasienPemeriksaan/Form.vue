<template>
    <BaseModal modalId="pemeriksaan" ref="modal" width="modal-fullscreen">
        <template #title>{{ title }}</template>
        <template #close>
            <div>
                <button class="btn btn-success btn-sm me-3" @click="simpan()">Simpan</button>
                <button class="btn btn-danger btn-sm" @click="cancel()">Batal</button>
            </div>
        </template>
        <div class="row">
            <div class="col-sm-3">
                <div class="card">
                    <div class="card-body py-4">
                        <div v-for="d in menus" :key="d.code" class="my-3">
                            <div
                                class="row rounded"
                                :class="checkActive(d) ? 'bg-info' : 'bg-gray-200'"
                                @click="setActive(d)"
                            >
                                <div
                                    class="col-12 p-5 d-flex flex-row align-items-center cursor-pointer"
                                >
                                    <div class="me-4">
                                        <i
                                            class="fa fa-check-circle fs-2"
                                            :class="checkActive(d) ? 'text-white' : ''"
                                        ></i>
                                    </div>
                                    <span
                                        class="fw-bolder fs-4 text-uppercase pb-1"
                                        :class="checkActive(d) ? 'text-white' : 'text-gray-800'"
                                        v-html="d.label"
                                    />
                                </div>
                            </div>
                            <div
                                v-if="checkActive(d)"
                                v-for="e in d.children ?? []"
                                @click="setActive(e)"
                                :key="e.code"
                                :class="checkActive(e) ? 'bg-info' : 'bg-gray-200'"
                                class="row rounded ms-4 mt-4"
                            >
                                <div
                                    class="col-12 p-5 d-flex flex-row align-items-center cursor-pointer"
                                >
                                    <div class="me-4">
                                        <i
                                            class="fa fa-check-circle fs-2"
                                            :class="checkActive(e) ? 'text-white' : ''"
                                        ></i>
                                    </div>
                                    <span
                                        class="fw-bolder fs-5 text-uppercase pb-1"
                                        :class="checkActive(e) ? 'text-white' : 'text-gray-800'"
                                        v-html="e.label"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-9">
                <div class="card">
                    <div class="card-body">
                        <template v-if="formActive == 'ONC000'">
                            <FormOverview />
                        </template>
                        <template v-if="formActive == 'ONC001'">
                            <FormAnemnesis />
                        </template>
                        <template v-else-if="formActive == 'ONC002'">
                            <FormPemeriksaanFisik />
                        </template>
                        <template v-else-if="formActive == 'ONC0031'">C1</template>
                        <template v-else-if="formActive == 'ONC0032'">C2</template>
                        <template v-else-if="formActive == 'ONC004'">
                            <FormDiagnosa />
                        </template>
                        <template v-else-if="formActive == 'ONC0051'">E1</template>
                        <template v-else-if="formActive == 'ONC0052'">E2</template>
                        <template v-else-if="formActive == 'ONC006'">
                            <FormOutcome />
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </BaseModal>
</template>

<script lang="ts" setup>
import BaseModal from '@/components/utils/modal/BaseModal.vue'
import FormOverview from './FormOverview.vue'
import FormAnemnesis from './FormAnemnesis.vue'
import FormPemeriksaanFisik from './FormPemeriksaanFisik.vue'
import FormDiagnosa from './FormDiagnosa.vue'
import FormOutcome from './FormOutcome.vue'
import Swal from 'sweetalert2'

import { nextTick, onMounted, ref } from 'vue'
import { usePasienPemeriksaanStore } from '@/stores/module/pasienPemeriksaan'
import { usePasienStore } from '@/stores/module/pasien'
import { useSelectStore } from '@/stores/global/select'

const pemeriksaanStore = usePasienPemeriksaanStore()
const selectStore = useSelectStore()
const pasienStore = usePasienStore()
const modal = ref()
const title = ref('')
const formActive = ref('ONC000')
const menus = ref([
    {
        code: 'ONC000',
        label: 'Overview'
    },
    {
        code: 'ONC001',
        label: 'Anemnesis'
    },
    {
        code: 'ONC002',
        label: 'Pemeriksaan Fisik'
    },
    {
        code: 'ONC003',
        label: 'Penunjang',
        children: [
            {
                code: 'ONC0031',
                label: 'Testing - 1'
            },
            {
                code: 'ONC0032',
                label: 'Testing - 2'
            },
            {
                code: 'ONC0033',
                label: 'Testing - 3'
            },
            {
                code: 'ONC0034',
                label: 'Testing - 4'
            },
            {
                code: 'ONC0035',
                label: 'Testing - 5'
            },
            {
                code: 'ONC0036',
                label: 'Testing - 6'
            }
        ]
    },
    {
        code: 'ONC004',
        label: 'Diagnosa'
    },
    {
        code: 'ONC005',
        label: 'Tatalaksana',
        children: [
            {
                code: 'ONC0051',
                label: 'Testing - 1'
            },
            {
                code: 'ONC0052',
                label: 'Testing - 2'
            }
        ]
    },
    {
        code: 'ONC006',
        label: 'Outcome'
    }
])

const emit = defineEmits(['onSave'])

function show(param: any = {}) {
    formActive.value = 'ONC999'
    pemeriksaanStore.formInputValidated.$reset()
    if (param.id) {
        Swal.fire({
            title: 'Loading',
            html: 'mengambil data...',
            icon: 'info',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading()
            }
        })
        pemeriksaanStore.getDetail(param.id).then((res) => {
            pemeriksaanStore.formInput = res.data
            pasienStore.getDetail(res.data.overview.pasien_id).then((pasien) => {
                title.value = `Edit Pemeriksaan ${pasien.data.name} (${res.data.overview.tanggal})`
                nextTick(() => {
                    formActive.value = 'ONC000'
                })
                Swal.close()
            })
        })
    } else {
        pemeriksaanStore.formInput = {
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
                penyakit_riwayats: [],
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
        }
        if (param.pasien_id) {
            if (param.pasien_id != pasienStore.itemDetail.id) {
                pasienStore.itemDetail = {}
                pasienStore.getDetail(param.pasien_id)
            }
            pemeriksaanStore.formInput.overview.pasien_id = param.pasien_id
        }
        title.value = 'Tambah Pemeriksaan'
        nextTick(() => {
            formActive.value = 'ONC000'
        })
    }
    modal.value.show()
}

function setActive(item: any): void {
    formActive.value = item.code
    if (item.children?.length > 0) {
        formActive.value = item.children[0].code
    }
}

function checkActive(item: any): boolean {
    if (item?.children)
        return item.children?.filter((d: any) => d.code == formActive.value).length > 0
    return formActive.value == item.code
}

function simpan() {
    pemeriksaanStore.formInputValidated.$validate().then((res) => {
        if (res) {
            console.log(pemeriksaanStore.formInput)
            if (pemeriksaanStore.formInput.pemeriksaan_fisik.kgb_option == 0) {
                pemeriksaanStore.formInput.pemeriksaan_fisik.kgb = null
            }

            if (pemeriksaanStore.formInput.id == 0) {
                pemeriksaanStore.create(pemeriksaanStore.formInput).then((res: any) => {
                    emit('onSave')
                    Swal.fire({
                        title: 'Success!',
                        text: res.message,
                        icon: 'success'
                    }).then(() => {
                        modal.value.hide()
                    })
                })
            } else {
                pemeriksaanStore
                    .update(pemeriksaanStore.formInput.id, pemeriksaanStore.formInput)
                    .then((res: any) => {
                        emit('onSave')
                        Swal.fire({
                            title: 'Success!',
                            text: res.message,
                            icon: 'success'
                        }).then(() => {
                            modal.value.hide()
                        })
                    })
            }
        } else {
            Swal.fire({
                title: 'Warning!',
                text: 'Form Belum Terisi dengan Lengkap, Silakan Periksa Kembali Form Anda',
                icon: 'warning'
            })
        }
    })
}

function cancel() {
    modal.value.hide()
}

defineExpose({
    show
})

onMounted(() => {
    selectStore.getDokters().then((res: any) => {
        if (res.length == 1) pemeriksaanStore.formInput.overview.dokter_id = res[0].id
    })
    selectStore.getPasiens()
})
</script>

<style>
#modal_pemeriksaan .modal-body {
    --bs-bg-rgb-color: var(--bs-gray-400-rgb);
    background-color: #ebedee;
}
</style>
