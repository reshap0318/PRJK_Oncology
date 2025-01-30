<template>
    <BaseModal modalId="followup" ref="modal" width="mw-800px">
        <template #title>
            <div class="d-flex align-items-center">
                <h3 class="mb-0 me-4">Follow Up</h3>
                <button class="btn btn-info btn-sm" @click="formModal.show({ kemo_id: id })">
                    Tambah
                </button>
            </div>
        </template>
        <template v-if="id != 0">
            <DataTable
                ref="table"
                :url="fuStore.datatableLink"
                :data="{ kemo_id: id }"
                :columns="columns"
                :options="options"
                @onEdit="handleBtnEdit"
                @onDelete="handleBtnDelete"
            />
        </template>

        <FollowUpForm ref="formModal" @onSubmit="actionUpSert" />
    </BaseModal>
</template>
<script lang="ts" setup>
import BaseModal from '@/components/utils/modal/BaseModal.vue'
import DataTable from '@/components/utils/datatable/DataTable.vue'
import FollowUpForm from './FollowUpForm.vue'
import { usePemeriksaanKemoterapiFUStore } from '@/stores/module/pemeriksaanKemoterapiFU'

import type { ConfigColumns, Config } from 'datatables.net'
import { btnAction } from '@/core/helpers/datatable'
import { ref } from 'vue'

const fuStore = usePemeriksaanKemoterapiFUStore()
const modal = ref()
const formModal = ref()
const table = ref()
const id = ref(0)

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
        data: 'subjective',
        name: 'subjective',
        title: 'Subjective',
        className: 'w-60p'
    },
    // {
    //     data: 'hb',
    //     name: 'hb',
    //     title: 'Hb'
    // },
    // {
    //     data: 'leukosit',
    //     name: 'leukosit',
    //     title: 'Leukosit'
    // },
    // {
    //     data: 'trombosit',
    //     name: 'trombosit',
    //     title: 'Trombosit'
    // },
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
        rontgen: row.rontgen_url,
        ct_scan: row.ct_scan_url
    }
    formModal.value.show(row, ref)
}

function handleBtnDelete(id: number): void {
    fuStore.actionDelete(id).then(() => {
        table.value.reload()
    })
}

function actionUpSert(data: any): void {
    console.log(data)

    fuStore.actionUpSertFile(data).then(() => {
        formModal.value.hide()
        table.value.reload()
    })
}

function show(kemoId: number = 0) {
    id.value = kemoId
    modal.value.show()
}

function hide() {
    id.value = 0
    modal.value.hide()
}

defineExpose({
    show,
    hide
})
</script>
