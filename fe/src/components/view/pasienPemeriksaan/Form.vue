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
                        <div
                            class="row my-3 rounded"
                            v-for="d in menus"
                            :class="formActive == d.code ? 'bg-info' : 'bg-gray-200'"
                            :key="d.code"
                            @click="formActive = d.code"
                        >
                            <div
                                class="col-12 p-5 d-flex flex-row align-items-center cursor-pointer"
                            >
                                <div class="me-4">
                                    <i
                                        class="fa fa-check-circle fs-2"
                                        :class="formActive == d.code ? 'text-white' : ''"
                                    ></i>
                                </div>
                                <span
                                    class="fw-bolder fs-4 text-uppercase pb-1"
                                    :class="formActive == d.code ? 'text-white' : 'text-gray-800'"
                                    v-html="d.label"
                                />
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
                        <template v-else-if="formActive == 'ONC003'">C</template>
                        <template v-else-if="formActive == 'ONC004'">
                            <FormDiagnosa />
                        </template>
                        <template v-else-if="formActive == 'ONC005'">E</template>
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

import { onMounted, ref } from 'vue'
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
        label: 'Penunjang'
    },
    {
        code: 'ONC004',
        label: 'Diagnosa'
    },
    {
        code: 'ONC005',
        label: 'Tatalaksana'
    },
    {
        code: 'ONC006',
        label: 'Outcome'
    }
])

function show(param: any = {}) {
    formActive.value = 'ONC000'
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
            const newForm = { ...pemeriksaanStore.formDefault, ...res.data }
            pemeriksaanStore.formInput = newForm
            formActive.value = 'ONC001'

            pasienStore.getDetail(res.data.overview.pasien_id).then((pasien) => {
                title.value = `Edit Pemeriksaan ${pasien.data.name} (${res.data.overview.tanggal})`
                Swal.close()
            })
        })
    } else {
        pasienStore.itemDetail = {}
        pemeriksaanStore.formInput = pemeriksaanStore.formDefault
        if (param.pasien_id) {
            pasienStore.getDetail(param.pasien_id)
            pemeriksaanStore.formInput.overview.pasien_id = param.pasien_id
        }
        title.value = 'Tambah Pemeriksaan'
    }
    modal.value.show()
}

function simpan() {
    pemeriksaanStore.formInputValidated.$validate().then((res) => {
        if (res) {
            console.log(pemeriksaanStore.formInput)

            pemeriksaanStore.create(pemeriksaanStore.formInput).then((res: any) => {
                Swal.fire({
                    title: 'Success!',
                    text: res.message,
                    icon: 'success'
                }).then(() => {
                    modal.value.hide()
                })
            })
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
