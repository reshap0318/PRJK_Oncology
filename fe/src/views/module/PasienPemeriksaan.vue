<template>
    <div class="mb-5 mb-xl-8 card card-border-outline">
        <div class="card-body">
            <DataTable
                ref="table"
                :url="pemeriksaanStore.datatableLink"
                :columns="columns"
                :options="options"
                @onEdit="handleBtnEdit"
                @onDelete="handleBtnDelete"
            />
        </div>
    </div>
    <FAB
        @click="formModal.show()"
        v-if="StrgService.hasPermission('pasien-pemeriksaan.inspection')"
    />
    <FormModal ref="formModal" />
</template>
<script lang="ts" setup>
import DataTable from '@/components/utils/datatable/DataTable.vue'
import FAB from '@/components/utils/button/FAB.vue'
import FormModal from '@/components/view/pasienPemeriksaan/Form.vue'
import StrgService from '@/core/services/StrgService'

import type { ConfigColumns, Config } from 'datatables.net'
import { usePasienPemeriksaanStore } from '@/stores/module/pasienPemeriksaan'
import { btnAction } from '@/core/helpers/datatable'
import { ref } from 'vue'

const pemeriksaanStore = usePasienPemeriksaanStore()
const table = ref()
const formModal = ref()

const columns = ref<Array<ConfigColumns>>([
    {
        data: 'id',
        title: 'No'
    },
    {
        data: 'inspection_at',
        name: 'pm.inspection_at',
        title: 'Tanggal',
        className: 'w-10p text-start'
    },
    {
        data: 'dokter_name',
        name: 'd.name',
        title: 'Dokter',
        className: 'w-30p'
    },
    {
        data: 'pasien_name',
        name: 'p.name',
        title: 'Pasien',
        className: 'w-30p'
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
    pemeriksaanStore.actionDelete(id).then(() => {
        table.value.reload()
    })
}

function actionUpSert(data: any): void {
    pemeriksaanStore.actionUpSert(data).then(() => {
        formModal.value.hide()
        table.value.reload()
    })
}
</script>
