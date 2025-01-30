<template>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Radioterapi</h3>
        <button class="btn btn-info btn-sm" @click="formModal.show({ inspection_id: id })">
            Tambah
        </button>
    </div>
    <DataTable
        ref="table"
        :url="radioStore.datatableLink"
        :data="{ pemeriksaan_id: id }"
        :columns="columns"
        :options="options"
        @onEdit="handleBtnEdit"
        @onDelete="handleBtnDelete"
    />
    <FormModal ref="formModal" @onSubmit="actionUpSert" />
    <FollowUp ref="followUp" />
</template>
<script lang="ts" setup>
import FormModal from './Form.vue'
import DataTable from '@/components/utils/datatable/DataTable.vue'
import FollowUp from './FollowUp.vue'
import { usePemeriksaanRadioterapiStore } from '@/stores/module/pemeriksaanRadioterapi'

import type { ConfigColumns, Config } from 'datatables.net'
import { btnAction } from '@/core/helpers/datatable'
import { computed, onMounted, ref } from 'vue'
import { useRoute } from 'vue-router'

const radioStore = usePemeriksaanRadioterapiStore()
const table = ref()
const formModal = ref()
const followUp = ref()
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
        title: 'Tanggal',
        className: 'w-30p text-start'
    },
    {
        data: 'category',
        name: 'category',
        title: 'Jenis Terapi',
        className: 'w-60p text-start',
        render: (data, meta, full) => {
            return full.category_text
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
    radioStore.actionDelete(id).then(() => {
        table.value.reload()
    })
}

function actionUpSert(data: any): void {
    radioStore.actionUpSertFile(data).then(() => {
        formModal.value.hide()
        table.value.reload()
    })
}

onMounted(() => {
    table.value.getDT().on('click', '.btn-follow', function (e: any) {
        e.preventDefault()
        const id = e.currentTarget.getAttribute('data-id')
        followUp.value.show(id)
    })
})
</script>
