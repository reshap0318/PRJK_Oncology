<template>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Pemeriksaan Lainnya</h3>
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
        :url="lainnyaStore.datatableLink"
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
import { usePemeriksaanLainnyaStore } from '@/stores/module/pemeriksaanLainnya'

import type { ConfigColumns, Config } from 'datatables.net'
import { btnAction } from '@/core/helpers/datatable'
import { computed, ref } from 'vue'
import { useRoute } from 'vue-router'

const lainnyaStore = usePemeriksaanLainnyaStore()
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
        data: 'inspector_name',
        name: 'inspector_name',
        title: 'Nama Pemeriksa',
        className: 'w-80p text-start'
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
    formModal.value.show(row)
}

function handleBtnDelete(id: number): void {
    lainnyaStore.actionDelete(id).then(() => {
        table.value.reload()
    })
}

function actionUpSert(data: any): void {
    lainnyaStore.actionUpSertFile(data).then(() => {
        formModal.value.hide()
        table.value.reload()
    })
}
</script>
