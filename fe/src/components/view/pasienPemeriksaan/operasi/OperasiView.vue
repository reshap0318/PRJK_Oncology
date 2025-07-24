<template>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Operasi</h3>
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
        :url="operasiStore.datatableLink"
        :data="{ pemeriksaan_id: id }"
        :columns="columns"
        :options="options"
        @onEdit="handleBtnEdit"
        @onDelete="handleBtnDelete"
    />
    <FormModal ref="formModal" @onSubmit="actionUpSert" />
</template>
<script lang="ts" setup>
import FormModal from './OperasiForm.vue'
import DataTable from '@/components/utils/datatable/DataTable.vue'
import StrgService from '@/core/services/StrgService'
import { usePemeriksaanOperasiStore } from '@/stores/module/pemeriksaanOperasi'

import type { ConfigColumns, Config } from 'datatables.net'
import { btnAction } from '@/core/helpers/datatable'
import { computed, ref } from 'vue'
import { useRoute } from 'vue-router'

const operasiStore = usePemeriksaanOperasiStore()
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
        title: 'Tanggal Operasi',
        className: 'w-30p text-start'
    },
    {
        data: 'category',
        name: 'category',
        title: 'Jenis Operasi',
        className: 'w-60p'
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
    const payload = { ...row }
    formModal.value.show(payload)
}

function handleBtnDelete(id: number): void {
    operasiStore.actionDelete(id).then(() => {
        table.value.reload()
    })
}

function actionUpSert(data: any): void {
    operasiStore.actionUpSert(data).then(() => {
        formModal.value.hide()
        table.value.reload()
    })
}
</script>
