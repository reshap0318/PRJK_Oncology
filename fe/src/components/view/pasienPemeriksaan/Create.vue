<template>
    <BaseModal modalId="create" ref="modal" width="mw-600px" @onSubmit="save">
        <template #title> Tambah Pemeriksaan </template>
        <div class="row">
            <div class="col-12 mb-4">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span class="required">Dokter</span>
                    </label>
                    <Multiselect
                        class="multiselect-form-control"
                        placeholder="Select dokter"
                        v-model="formInput.dokter_id"
                        :options="selectStore.dokters"
                        :searchable="true"
                    />
                    <form-error :err="v$.dokter_id" name="dokter_id" />
                </div>
            </div>
            <div class="col-12 mb-4">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span class="required">Pasien</span>
                    </label>
                    <Multiselect
                        class="multiselect-form-control"
                        placeholder="Select pasien"
                        v-model="formInput.pasien_id"
                        :options="selectStore.pasiens"
                        :searchable="true"
                    />
                    <form-error :err="v$.pasien_id" name="pasien_id" />
                </div>
            </div>
            <div class="col-12 mb-4">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span class="required">Tanggal </span>
                    </label>
                    <input type="date" class="form-control" v-model="formInput.tanggal" />
                    <form-error :err="v$.tanggal" name="tanggal" />
                </div>
            </div>
            <div class="col-12" v-if="pasien.id">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-900">Informasi Pasien</span>
                </h3>
                <div class="row mt-3">
                    <div class="col-12">
                        <table width="100%" class="table">
                            <tbody>
                                <tr>
                                    <th scope="row" style="width: 150px">Nama Lengkap</th>
                                    <td style="width: 10px">:</td>
                                    <td>
                                        {{ pasien.name }} ( <b>{{ pasien.no_mr }}</b> )
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" style="width: 150px">Jenis Kelamin</th>
                                    <td style="width: 10px">:</td>
                                    <td>{{ pasien.gender }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" style="width: 150px">Tempat Tanggal Lahir</th>
                                    <td style="width: 10px">:</td>
                                    <td>{{ pasien.pob + ', ' + pasien.dob }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" style="width: 150px">No Telephone</th>
                                    <td style="width: 10px">:</td>
                                    <td>{{ pasien.phone ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" style="width: 150px">Email</th>
                                    <td style="width: 10px">:</td>
                                    <td>
                                        {{ pasien.email ?? '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" style="width: 150px">Pendidikan</th>
                                    <td style="width: 10px">:</td>
                                    <td>{{ pasien.education ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" style="width: 150px">Pekerjaan</th>
                                    <td style="width: 10px">:</td>
                                    <td>{{ pasien.job ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" style="width: 150px">Suku</th>
                                    <td style="width: 10px">:</td>
                                    <td>{{ pasien.ethnic ?? '-' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </BaseModal>
</template>
<script lang="ts" setup>
import BaseModal from '@/components/utils/modal/BaseFormModal.vue'
import FormError from '@/components/utils/error/FormError.vue'
import Multiselect from '@vueform/multiselect'

import { usePasienPemeriksaanStore } from '@/stores/module/pasienPemeriksaan'
import { usePasienStore } from '@/stores/module/pasien'
import { useSelectStore } from '@/stores/global/select'
import { computed, onMounted, ref, watch } from 'vue'
import Swal from 'sweetalert2'

const emit = defineEmits(['onSave'])

const pemeriksaanStore = usePasienPemeriksaanStore()
const pasienStore = usePasienStore()
const selectStore = useSelectStore()

const modal = ref()
const pasien = computed(() => pasienStore.itemDetail)

const formInput = ref(pemeriksaanStore.formCreate)
const v$ = ref(pemeriksaanStore.formCreateValidated)

function save(): void {
    Swal.fire({
        title: 'Loading',
        html: 'menyimpan data...',
        icon: 'info',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading()
        }
    })

    v$.value.$validate().then((result: any) => {
        if (!result) {
            Swal.close()
            return
        }
    })

    pemeriksaanStore.createFile(formInput.value).then((res: any) => {
        Swal.close()
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

function show(param: any = {}): void {
    formInput.value = {
        dokter_id: null,
        pasien_id: null,
        tanggal: null
    }
    if (param.tag == 'create') {
        pasienStore.itemDetail = {}
    }
    if (param.pasien_id) {
        formInput.value.pasien_id = param.pasien_id
    }
    v$.value.$reset()
    modal.value.show()
}

defineExpose({
    show
})

onMounted(() => {
    selectStore.getDokters().then((res: any) => {
        if (res.length == 1) formInput.value.dokter_id = res[0].id
    })
    selectStore.getPasiens()
})

watch(
    () => formInput.value.pasien_id,
    (val) => {
        if (val) {
            if (val != pasien.value.id) {
                Swal.fire({
                    title: 'Loading',
                    html: 'mengambil data...',
                    icon: 'info',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading()
                    }
                })
                pasienStore.getDetail(val).finally(() => {
                    Swal.close()
                })
            }
        } else {
            pasienStore.itemDetail = {}
        }
    }
)
</script>
