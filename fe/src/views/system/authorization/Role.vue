<template>
    <div class="mb-5 mb-xl-8 card card-border-outline">
        <div class="card-body">
            <DataTable
                ref="table"
                :url="roleStore.datatableLink"
                :columns="columns"
                :options="options"
                @onEdit="handleBtnEdit"
                @onDelete="handleBtnDelete"
            />
        </div>
    </div>
    <FAB @click="formModal.show()" v-if="StrgService.hasPermission('permission.create')" />
    <FormModal ref="formModal" @onSubmit="actionUpSert" />
</template>
<script lang="ts" setup>
import DataTable from '@/components/utils/datatable/DataTable.vue'
import FAB from '@/components/utils/button/FAB.vue'
import FormModal from '@/components/view/role/Form.vue'
import StrgService from '@/core/services/StrgService'

import type { ConfigColumns, Config } from 'datatables.net'
import { useRoleStore } from '@/stores/system/role'
import { btnAction } from '@/core/helpers/datatable'
import { ref } from 'vue'

const roleStore = useRoleStore()
const table = ref()
const formModal = ref()

const columns = ref<Array<ConfigColumns>>([
    {
        data: 'id',
        className: 'text-center w-number',
        title: 'ID'
    },
    {
        data: 'name',
        title: 'Name',
        className: 'w-20p'
    },
    {
        data: 'permissions',
        title: 'Permission',
        render: (data: any) => {
            let resp = ``
            data.forEach((d, i) => {
                resp += ` <span class="badge badge-light-success my-1" style="padding: 4px 8px">${d.name}</span> `
            })
            return resp
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
    order: [[0, 'asc']],
    serverSide: false
})

function handleBtnEdit(row: any): void {
    const payload = {
        id: row.id,
        name: row.name,
        permissions: row.permissions.map((p: any) => p.id)
    }
    formModal.value.show(payload)
}

function handleBtnDelete(id: number): void {
    roleStore.actionDelete(id).then(() => {
        table.value.reload()
    })
}

function actionUpSert(data: any): void {
    roleStore.actionUpSert(data).then(() => {
        formModal.value.hide()
        table.value.reload()
    })
}
</script>
