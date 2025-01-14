<template>
    <div class="mb-5 mb-xl-8 card card-border-outline">
        <div class="card-body">
            <DataTable
                ref="table"
                :url="pemeriksaanStore.datatableLink"
                :columns="columns"
                :options="options"
                @onDelete="handleBtnDelete"
            />
        </div>
    </div>
    <FAB
        @click="formModal.show()"
        v-if="StrgService.hasPermission('pasien-pemeriksaan.inspection')"
    />
    <FormModal ref="formModal" @onSave="tableReload()" />
</template>
<script lang="ts" setup>
import DataTable from '@/components/utils/datatable/DataTable.vue'
import FAB from '@/components/utils/button/FAB.vue'
import FormModal from '@/components/view/pasienPemeriksaan/Form.vue'
import StrgService from '@/core/services/StrgService'

import type { ConfigColumns, Config } from 'datatables.net'
import { usePasienPemeriksaanStore } from '@/stores/module/pasienPemeriksaan'
import { btnAction } from '@/core/helpers/datatable'
import { onMounted, ref } from 'vue'

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

function handleBtnDelete(id: number): void {
    pemeriksaanStore.actionDelete(id).then(() => {
        tableReload()
    })
}

function tableReload(): void {
    table.value.reload()
}

onMounted(() => {
    table.value.getDT().on('click', '.btn-periksa', function (e: any) {
        e.preventDefault()
        const id = e.currentTarget.getAttribute('data-id')
        formModal.value.show({ id: id })
    })
})
</script>
