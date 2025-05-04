<template>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">CT-Scan Toraks</h3>
        <button
            class="btn btn-info btn-sm"
            v-if="StrgService.hasPermission('pasien-pemeriksaan.inspection')"
            @click="formModal.show({ inspection_id: id })"
        >
            Tambah
        </button>
    </div>
    <DataTable
        ref="table"
        :url="toraksScanStore.datatableLink"
        :data="{ pemeriksaan_id: id }"
        :columns="columns"
        :options="options"
        @onEdit="handleBtnEdit"
        @onDelete="handleBtnDelete"
    />
    <FormModal ref="formModal" @onSubmit="actionUpSert" />
</template>
<script lang="ts" setup>
import FormModal from './Form.vue'
import DataTable from '@/components/utils/datatable/DataTable.vue'
import StrgService from '@/core/services/StrgService'
import { usePemeriksaanToraksScanStore } from '@/stores/module/pemeriksaanToraksScan'

import type { ConfigColumns, Config } from 'datatables.net'
import { btnAction } from '@/core/helpers/datatable'
import { computed, ref } from 'vue'
import { useRoute } from 'vue-router'

const toraksScanStore = usePemeriksaanToraksScanStore()
const table = ref()
const formModal = ref()
const route = useRoute()
const id = computed(() => route.params.id as string)

const columns = ref<Array<ConfigColumns>>([
    {
        data: 'id',
        name: 'id',
        title: 'No'
    },
    {
        data: 'date',
        name: 'date',
        title: 'tanggal',
        className: 'w-20p text-start'
    },
    {
        data: 'file_path',
        name: 'file_path',
        title: 'File',
        className: 'w-60p text-start',
        render: (value, meta, full) => {
            return `<a href="${full.file_url}" target="_blank">${full.file_url}</a>`
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
    order: [[1, 'desc']]
})

function handleBtnEdit(row: any): void {
    delete row.created_at
    delete row.updated_at
    formModal.value.show(row, { file: row.file_url })
}

function handleBtnDelete(id: number): void {
    toraksScanStore.actionDelete(id).then(() => {
        table.value.reload()
    })
}

function actionUpSert(data: any): void {
    toraksScanStore.actionUpSertFile(data).then(() => {
        formModal.value.hide()
        table.value.reload()
    })
}
</script>
