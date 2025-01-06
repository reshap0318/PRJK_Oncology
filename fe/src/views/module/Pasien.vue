<template>
    <div class="mb-5 mb-xl-8 card card-border-outline">
        <div class="card-body">
            <DataTable
                ref="table"
                :url="pasienStore.datatableLink"
                :columns="columns"
                :options="options"
                @onEdit="handleBtnEdit"
                @onDelete="handleBtnDelete"
                @onDetail="handleBtnDetail"
            />
        </div>
    </div>
    <FAB @click="formModal.show()" v-if="StrgService.hasPermission('pasien.create')" />
    <FormModal ref="formModal" @onSubmit="actionUpSert" />
</template>
<script lang="ts" setup>
import DataTable from '@/components/utils/datatable/DataTable.vue'
import FAB from '@/components/utils/button/FAB.vue'
import FormModal from '@/components/view/pasien/Form.vue'
import StrgService from '@/core/services/StrgService'

import type { ConfigColumns, Config } from 'datatables.net'
import { usePasienStore } from '@/stores/module/pasien'
import { btnAction } from '@/core/helpers/datatable'
import { useRouter } from 'vue-router'
import { ref } from 'vue'

const pasienStore = usePasienStore()
const table = ref()
const formModal = ref()
const router = useRouter()

const columns = ref<Array<ConfigColumns>>([
    {
        data: 'no_mr',
        className: 'w-100px',
        title: 'No. MR'
    },
    {
        data: 'name',
        title: 'Name',
        className: 'w-20p'
    },
    {
        data: 'gender',
        title: 'Jenis Kelamin'
    },
    {
        data: 'phone',
        title: 'Telepon',
        defaultContent: '-'
    },
    {
        data: 'pob',
        title: 'TTL',
        render(data, type, row, meta) {
            return `${data}, ${row.dob}`
        }
    },
    {
        data: 'action',
        title: '',
        render(data: any, type, row: any, meta) {
            return btnAction(data, row.id)
        }
    },
    {
        data: 'dob',
        visible: false
    }
])

const options = ref<Config>({
    order: [[0, 'asc']]
})

function handleBtnEdit(row: any): void {
    const payload = { ...row }
    payload.gender = row.gender === 'Perempuan' ? 0 : 1
    formModal.value.show(payload)
}

function handleBtnDelete(id: number): void {
    pasienStore.actionDelete(id).then(() => {
        table.value.reload()
    })
}

function handleBtnDetail(id: any): void {
    router.push({ name: 'pasien.show', params: { id: id } })
}

function actionUpSert(data: any): void {
    pasienStore.actionUpSert(data).then(() => {
        formModal.value.hide()
        table.value.reload()
    })
}
</script>
