<template>
    <div
        class="d-flex justify-content-between align-items-center border-0 py-4 pe-4 bg-light-primary"
    >
        <h2 class="ps-4 my-1">{{ title }}</h2>
    </div>
    <div class="py-5 px-10">
        <div class="row">
            <div class="col-sm-3 mb-4">
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
                            <template v-for="e in d.children ?? []">
                                <div
                                    v-if="checkActive(d)"
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
                                <template v-for="f in e.children ?? []">
                                    <div
                                        v-if="checkActive(e)"
                                        @click="setActive(f)"
                                        :key="f.code"
                                        :class="checkActive(f) ? 'bg-info' : 'bg-gray-200'"
                                        class="row rounded ms-12 mt-4 bg-gray-200"
                                    >
                                        <div
                                            class="col-12 p-5 d-flex flex-row align-items-center cursor-pointer"
                                        >
                                            <div class="me-4">
                                                <i
                                                    class="fa fa-check-circle fs-2"
                                                    :class="checkActive(f) ? 'text-white' : ''"
                                                ></i>
                                            </div>
                                            <span
                                                class="fw-bolder fs-5 text-uppercase pb-1"
                                                :class="
                                                    checkActive(f) ? 'text-white' : 'text-gray-800'
                                                "
                                                v-html="f.label"
                                            />
                                        </div>
                                    </div>
                                </template>
                            </template>
                        </div>
                        <div
                            class="d-flex justify-content-center mt-4"
                            v-if="StrgService.hasPermission('pasien-pemeriksaan.inspection')"
                        >
                            <button class="btn btn-success btn-sm me-3" @click="simpan()">
                                Simpan
                            </button>
                            <button class="btn btn-danger btn-sm me-3" @click="back()">
                                Kembali
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-9 mb-4">
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
                        <template v-else-if="formActive == 'ONC00311'">
                            <FormTorakFoto />
                        </template>
                        <template v-else-if="formActive == 'ONC00312'">
                            <FormTorakScan />
                        </template>
                        <template v-else-if="formActive == 'ONC00313'">
                            <FormBoneSurvey />
                        </template>
                        <template v-else-if="formActive == 'ONC00314'">
                            <FormMriKepala />
                        </template>
                        <template v-else-if="formActive == 'ONC00315'">
                            <FormTorakUsg />
                        </template>
                        <template v-else-if="formActive == 'ONC0032'">
                            <FormLaboratory />
                        </template>
                        <template v-else-if="formActive == 'ONC0033'">
                            <FormBronkoskopi />
                        </template>
                        <template v-else-if="formActive == 'ONC0034'">
                            <FormSitologi />
                        </template>
                        <template v-else-if="formActive == 'ONC0035'">
                            <FormPaalParu />
                        </template>
                        <template v-else-if="formActive == 'ONC0036'">
                            <FormLainnya />
                        </template>
                        <template v-else-if="formActive == 'ONC004'">
                            <FormDiagnosa />
                        </template>
                        <template v-else-if="formActive == 'ONC0051'">
                            <FormOperasi />
                        </template>
                        <template v-else-if="formActive == 'ONC0052'">
                            <FormKemoterapi />
                        </template>
                        <template v-else-if="formActive == 'ONC0053'">
                            <FormRadioterapi />
                        </template>
                        <template v-else-if="formActive == 'ONC0054'">
                            <FormTerapiTarget />
                        </template>
                        <template v-else-if="formActive == 'ONC006'">
                            <FormOutcome />
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script lang="ts" setup>
import FormOverview from '@/components/view/pasienPemeriksaan/FormOverview.vue'
import FormAnemnesis from '@/components/view/pasienPemeriksaan/FormAnemnesis.vue'
import FormPemeriksaanFisik from '@/components/view/pasienPemeriksaan/FormPemeriksaanFisik.vue'
import FormDiagnosa from '@/components/view/pasienPemeriksaan/FormDiagnosa.vue'
import FormOutcome from '@/components/view/pasienPemeriksaan/FormOutcome.vue'
import FormOperasi from '@/components/view/pasienPemeriksaan/operasi/OperasiView.vue'
import FormKemoterapi from '@/components/view/pasienPemeriksaan/kemoterapi/View.vue'
import FormRadioterapi from '@/components/view/pasienPemeriksaan/radioterapi/View.vue'
import FormTerapiTarget from '@/components/view/pasienPemeriksaan/terapi/View.vue'

import FormLaboratory from '@/components/view/pasienPemeriksaan/laboratory/View.vue'
import FormBronkoskopi from '@/components/view/pasienPemeriksaan/FormBronkoskopi.vue'
import FormSitologi from '@/components/view/pasienPemeriksaan/FormSitologi.vue'
import FormPaalParu from '@/components/view/pasienPemeriksaan/FormPaalParu.vue'
import FormLainnya from '@/components/view/pasienPemeriksaan/lainnya/View.vue'

import FormTorakFoto from '@/components/view/pasienPemeriksaan/toraksFoto/View.vue'
import FormTorakScan from '@/components/view/pasienPemeriksaan/toraksScan/View.vue'
import FormBoneSurvey from '@/components/view/pasienPemeriksaan/boneSurvey/View.vue'
import FormMriKepala from '@/components/view/pasienPemeriksaan/mriKepala/View.vue'
import FormTorakUsg from '@/components/view/pasienPemeriksaan/toraksUsg/View.vue'
import Swal from 'sweetalert2'

import { usePasienPemeriksaanStore } from '@/stores/module/pasienPemeriksaan'
import { useRoute, useRouter } from 'vue-router'
import { usePasienStore } from '@/stores/module/pasien'
import { useSelectStore } from '@/stores/global/select'
import { computed, onMounted, ref, nextTick } from 'vue'
import StrgService from '@/core/services/StrgService'

const route = useRoute()
const router = useRouter()
const pemeriksaanStore = usePasienPemeriksaanStore()
const pasienStore = usePasienStore()
const selectStore = useSelectStore()

const id = computed(() => route.params.id as string)
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
                label: 'Radiologi',
                children: [
                    {
                        code: 'ONC00311',
                        label: 'RO.FOTO TORAKS'
                    },
                    {
                        code: 'ONC00312',
                        label: 'CT-SCAN TORAKS'
                    },
                    {
                        code: 'ONC00313',
                        label: 'BONE SURVEY'
                    },
                    {
                        code: 'ONC00314',
                        label: 'MRI'
                    },
                    {
                        code: 'ONC00315',
                        label: 'USG TORAKS'
                    }
                ]
            },
            {
                code: 'ONC0032',
                label: 'Hasil Laboratorium'
            },
            {
                code: 'ONC0033',
                label: 'Bronkoskopi'
            },
            {
                code: 'ONC0034',
                label: 'PA'
            },
            {
                code: 'ONC0035',
                label: 'Paal Paru'
            },
            {
                code: 'ONC0036',
                label: 'Pemeriksaan Lainnya'
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
                label: 'Operasi'
            },
            {
                code: 'ONC0052',
                label: 'Kemoterapi'
            },
            {
                code: 'ONC0053',
                label: 'Radioterapi'
            },
            {
                code: 'ONC0054',
                label: 'Terapi Target'
            }
        ]
    },
    {
        code: 'ONC006',
        label: 'Outcome'
    }
])

async function simpan() {
    return new Promise((resolve, reject) => {
        pemeriksaanStore.formUpdateValidated.$validate().then((res) => {
            if (res) {
                console.log(pemeriksaanStore.formUpdate)
                if (pemeriksaanStore.formUpdate.pemeriksaan_fisik.kgb_option == 0) {
                    pemeriksaanStore.formUpdate.pemeriksaan_fisik.kgb = null
                }
                pemeriksaanStore
                    .updateFile(pemeriksaanStore.formUpdate.id, pemeriksaanStore.formUpdate)
                    .then((res: any) => {
                        Swal.fire({
                            title: 'Success!',
                            text: res.message,
                            icon: 'success'
                        }).then(() => {
                            resolve(true)
                        })
                    })
            } else {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Form Belum Terisi dengan Lengkap, Silakan Periksa Kembali Form Anda',
                    icon: 'warning'
                })
                reject(false)
            }
        })
    })
}

function cancel(): void {
    if (router.options.history.state.back == null) {
        router.push({ name: 'pemeriksaaan.index' })
        return
    }
    router.back()
}

function back(): void {
    Swal.fire({
        title: 'Konfirmasi',
        text: 'Apakah Anda Yakin? Data yang Telah Diisi Akan Disimpan',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Simpan'
    }).then((res) => {
        if (res.isConfirmed) {
            simpan().then(() => {
                cancel()
            })
        }
    })
}

function setActive(item: any): void {
    formActive.value = item.code
    if (item.children?.length > 0) {
        formActive.value = item.children[0].code
        if (item.children[0].children?.length > 0) {
            formActive.value = item.children[0].children[0].code
        }
    }
}

function checkActive(item: any): boolean {
    if (item.children) {
        return (
            item.children.filter((d: any) => {
                return (
                    d.code == formActive.value ||
                    d.children?.filter((e: any) => e.code == formActive.value).length > 0
                )
            }).length > 0
        )
    }
    return formActive.value == item.code
}

onMounted(() => {
    selectStore.getDokters().then((res: any) => {
        if (res.length == 1) pemeriksaanStore.formUpdate.overview.dokter_id = res[0].id
    })
    selectStore.getPasiens()

    // init form
    formActive.value = 'ONC999'
    pemeriksaanStore.formUpdateValidated.$reset()
    Swal.fire({
        title: 'Loading',
        html: 'mengambil data...',
        icon: 'info',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading()
        }
    })
    pemeriksaanStore.getDetail(id.value).then(async (res) => {
        pemeriksaanStore.formUpdate = res.data
        if (res.data.overview.pasien_id != pasienStore.itemDetail.id) {
            await pasienStore.getDetail(res.data.overview.pasien_id)
        }
        title.value = `Edit Pemeriksaan ${pasienStore.itemDetail.name} (${res.data.overview.tanggal})`
        nextTick(() => {
            formActive.value = 'ONC000'
            // formActive.value = 'ONC00312'
        })
        Swal.close()
    })
})
</script>
