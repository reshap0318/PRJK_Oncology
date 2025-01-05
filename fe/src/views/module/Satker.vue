<template>
    <div class="card card-border-outline">
        <div class="card-body">
            <DataTable
                ref="table"
                :url="satkerStore.datatableLink"
                :columns="columns"
                :options="options"
                @onEdit="handleBtnEdit"
                @onDelete="handleBtnDelete"
            />
        </div>
    </div>
    <FAB @click="formModal.show()" v-if="StrgService.hasPermission('satker.create')" />
    <FormModal ref="formModal" @onSubmit="actionUpSert" />
</template>
<script lang="ts" setup>
import DataTable from '@/components/utils/datatable/DataTable.vue'
import FAB from '@/components/utils/button/FAB.vue'
import FormModal from '@/components/view/satker/Form.vue'
import StrgService from '@/core/services/StrgService'
import Swal from 'sweetalert2'

import type { ConfigColumns, Config } from 'datatables.net'
import { useSatkerStore } from '@/stores/module/satker'
import { btnAction } from '@/core/helpers/datatable'
import { onMounted, ref } from 'vue'

const satkerStore = useSatkerStore()
const table = ref()
const formModal = ref()

const columns = ref<Array<ConfigColumns>>([
    {
        data: 'id',
        name: 'g1.id',
        className: 'text-center w-no',
        title: 'No'
    },
    {
        data: 'name',
        name: 'g1.name',
        title: 'Name',
        className: 'w-40p'
    },
    {
        data: 'parent_name',
        name: 'g2.name',
        title: 'Parent'
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
    order: [
        [2, 'asc'],
        [1, 'asc']
    ]
})

function handleBtnEdit(row: any): void {
    const param = {
        id: row.id,
        name: row.name,
        parent_id: row.parent_id
    }
    formModal.value.show(param)
}

function handleBtnDelete(id: number): void {
    satkerStore.actionDelete(id).then(() => {
        table.value.reload()
    })
}

function actionUpSert(data: any): void {
    satkerStore.actionUpSert(data).then(() => {
        formModal.value.hide()
        table.value.reload()
    })
}
</script>
