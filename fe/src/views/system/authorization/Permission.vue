<template>
    <div class="mb-5 mb-xl-8 card card-border-outline">
        <div class="card-body">
            <DataTable
                ref="table"
                :url="permissionStore.datatableLink"
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
import FormModal from '@/components/view/permission/Form.vue'
import StrgService from '@/core/services/StrgService'

import type { ConfigColumns, Config } from 'datatables.net'
import { usePermissionStore } from '@/stores/system/permission'
import { btnAction } from '@/core/helpers/datatable'
import { ref } from 'vue'

const permissionStore = usePermissionStore()
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
        data: 'keterangan',
        title: 'Description'
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
    order: [[0, 'asc']]
    // layout: {
    //   topStart: {
    //     buttons: [
    //       {
    //         text: 'Reload',
    //         className: 'btn btn-info btn-sm',
    //         action: function (e, dt, node, config) {
    //           table.value.reload()
    //         }
    //       }
    //     ]
    //   }
    // }
})

function handleBtnEdit(row: any): void {
    formModal.value.show(row)
}

function handleBtnDelete(id: number): void {
    permissionStore.actionDelete(id).then(() => {
        table.value.reload()
    })
}

function actionUpSert(data: any): void {
    permissionStore.actionUpSert(data).then(() => {
        formModal.value.hide()
        table.value.reload()
    })
}
</script>
