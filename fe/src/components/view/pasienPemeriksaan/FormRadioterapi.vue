<template>
    <div class="row">
        <div class="col-12 col-sm-6 mb-4">
            <div class="fv-row">
                <label class="form-label fs-6 text-dark">
                    <span class=""> Tanggal </span>
                </label>
                <input type="date" class="form-control" v-model="formInput.date" />
                <form-error :err="formInputValidated.radioterapi.date" name="radioterapi.date" />
            </div>
        </div>
        <div class="col-12 col-sm-6 mb-4">
            <div class="fv-row">
                <label class="form-label fs-6 text-dark">
                    <span class=""> Jenis Radioterapi </span>
                </label>
                <select class="form-control" v-model="formInput.category">
                    <option :value="null">pilihan</option>
                    <option :value="1">Radioterapi Emergensi</option>
                    <option :value="2">Radioterapi Kepala</option>
                    <option :value="3">Radioterapi Kuratif</option>
                </select>
                <form-error
                    :err="formInputValidated.radioterapi.category"
                    name="radioterapi.category"
                />
            </div>
        </div>
        <div class="col-12 col-sm-6 mb-4">
            <div class="fv-row">
                <label class="form-label fs-6 text-dark">
                    <span class=""> Dosis </span>
                </label>
                <input
                    type="text"
                    class="form-control"
                    v-model="formInput.dose"
                    placeholder="dosis"
                />
                <form-error :err="formInputValidated.radioterapi.dose" name="radioterapi.dose" />
            </div>
        </div>
        <div class="col-12 col-sm-6 mb-4">
            <div class="fv-row">
                <label class="form-label fs-6 text-dark">
                    <span class=""> Fraksi </span>
                </label>
                <input
                    type="text"
                    class="form-control"
                    v-model="formInput.fraksi"
                    placeholder="fraksi"
                />
                <form-error
                    :err="formInputValidated.radioterapi.fraksi"
                    name="radioterapi.fraksi"
                />
            </div>
        </div>
        <div class="col-12 mb-4">
            <div class="fv-row">
                <label class="form-label fs-6 text-dark">
                    <span class=""> CT-Scan Baseline </span>
                </label>
                <InputFile
                    v-model="formInput.ct_scan"
                    :accept="['.pdf', '.jpg', '.jpeg', '.png']"
                />
                <a
                    v-if="formInput.ct_scan_url"
                    class="text-info"
                    target="_blank"
                    :href="formInput.ct_scan_url"
                    v-html="formInput.ct_scan_url"
                ></a>
                <form-error
                    :err="formInputValidated.radioterapi.ct_scan"
                    name="radioterapi.ct_scan"
                />
            </div>
        </div>
        <div class="col-12 mb-4">
            <div class="fv-row">
                <label class="form-label fs-6 text-dark"> Resume </label>
                <textarea
                    v-model="formInput.description"
                    cols="30"
                    rows="3"
                    class="form-control"
                    placeholder="resume"
                ></textarea>
                <form-error
                    :err="formInputValidated.radioterapi.description"
                    name="radioterapi.description"
                />
            </div>
        </div>
    </div>

    <div class="d-flex align-items-center justify-content-between mt-5">
        <h3 class="mb-0 me-4">Follow Up</h3>
        <button
            class="btn btn-info btn-sm"
            v-if="hasData"
            @click="formModal.show({ radio_id: id })"
        >
            Tambah
        </button>
    </div>

    <DataTable
        ref="table"
        :url="fuStore.datatableLink"
        :data="{ radio_id: id }"
        :columns="columns"
        :options="options"
        @onEdit="handleBtnEdit"
        @onDelete="handleBtnDelete"
    />

    <FollowUpForm ref="formModal" @onSubmit="actionUpSert" />
</template>
<script lang="ts" setup>
import FormError from '@/components/utils/error/FormError.vue'
import InputFile from '@/components/utils/form/InputFile.vue'
import DataTable from '@/components/utils/datatable/DataTable.vue'
import FollowUpForm from '@/components/view/pasienPemeriksaan/radioterapi/FollowUpForm.vue'

import { usePemeriksaanRadioterapiStore } from '@/stores/module/pemeriksaanRadioterapi'
import { usePemeriksaanRadioterapiFUStore } from '@/stores/module/pemeriksaanRadioterapiFU'
import { usePasienPemeriksaanStore } from '@/stores/module/pasienPemeriksaan'

import type { ConfigColumns, Config } from 'datatables.net'
import { btnAction } from '@/core/helpers/datatable'
import { computed, onMounted, ref } from 'vue'
import { useRoute } from 'vue-router'

const table = ref()
const route = useRoute()
const radioStore = usePemeriksaanRadioterapiStore()
const fuStore = usePemeriksaanRadioterapiFUStore()

const id = computed(() => route.params.id as string)
const pemeriksaanStore = usePasienPemeriksaanStore()

const formInput = ref(pemeriksaanStore.formUpdate.radioterapi)
const formInputValidated = ref(pemeriksaanStore.formUpdateValidated)
const formModal = ref()
const hasData = ref(false)

const columns = ref<Array<ConfigColumns>>([
    {
        data: 'id',
        name: 'id',
        title: 'No'
    },
    {
        data: 'date',
        name: 'date',
        title: 'Tanggal',
        className: 'w-30p text-start'
    },
    {
        data: 'ct_scan_path',
        name: 'ct_scan_path',
        title: 'CT Scan',
        className: 'w-70p',
        render: (data, meta, full) => {
            return `<a href="${full.ct_scan_url}" target="_blank">${full.ct_scan_url}</a>`
        }
    },
    {
        data: 'action',
        title: '',
        render(data: any, type, row: any, meta) {
            return btnAction(data, row.id)
        }
    }
])

const options = ref<Config>({
    order: [[1, 'asc']]
})

function handleBtnEdit(row: any): void {
    delete row.created_at
    delete row.updated_at
    const ref = {
        ct_scan: row.ct_scan_url
    }
    formModal.value.show(row, ref)
}

function handleBtnDelete(id: number): void {
    fuStore.actionDelete(id).then(() => {
        table.value.reload()
    })
}

function actionUpSert(data: any): void {
    fuStore.actionUpSertFile(data).then(() => {
        formModal.value.hide()
        table.value.reload()
    })
}

onMounted(() => {
    radioStore.getDetail(id.value).then(() => {
        hasData.value = true
    })
})
</script>
