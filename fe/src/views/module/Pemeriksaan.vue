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
        @click="formCreate.show({ tag: 'create' })"
        v-if="StrgService.hasPermission('pasien-pemeriksaan.inspection')"
    />
    <FormCreate ref="formCreate" @onSave="tableReload()" />
</template>
<script lang="ts" setup>
import DataTable from '@/components/utils/datatable/DataTable.vue'
import FAB from '@/components/utils/button/FAB.vue'
import FormCreate from '@/components/view/pasienPemeriksaan/Create.vue'
import StrgService from '@/core/services/StrgService'

import type { ConfigColumns, Config } from 'datatables.net'
import { usePasienPemeriksaanStore } from '@/stores/module/pasienPemeriksaan'
import { btnAction } from '@/core/helpers/datatable'
import { onMounted, ref } from 'vue'
import { useRouter } from 'vue-router'

const pemeriksaanStore = usePasienPemeriksaanStore()
const table = ref()
const router = useRouter()
const formCreate = ref()

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
        className: 'w-50p'
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
        router.push({ name: 'pemeriksaaan.edit', params: { id: id } })
    })
})
</script>
