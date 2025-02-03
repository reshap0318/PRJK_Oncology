<template>
    <BaseModal modalId="followup" ref="modal" width="mw-800px">
        <template #title>
            <div class="d-flex align-items-center">
                <h3 class="mb-0 me-4">Follow Up</h3>
                <button class="btn btn-info btn-sm" @click="formModal.show({ radio_id: id })">
                    Tambah
                </button>
            </div>
        </template>
        <div style="margin-left: -6px">
            <table width="100%" class="table">
                <tbody>
                    <tr>
                        <th scope="row" style="width: 150px">Tangal</th>
                        <td style="width: 10px">:</td>
                        <td>{{ radio.date }}</td>
                    </tr>
                    <tr>
                        <th scope="row" style="width: 150px">Jenis Radioterapi</th>
                        <td style="width: 10px">:</td>
                        <td>
                            {{ radio.category_text }}
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" style="width: 150px">Dosis</th>
                        <td style="width: 10px">:</td>
                        <td>{{ radio.dose }}</td>
                    </tr>
                    <tr>
                        <th scope="row" style="width: 150px">Fraksi</th>
                        <td style="width: 10px">:</td>
                        <td>{{ radio.fraksi }}</td>
                    </tr>
                    <tr>
                        <th scope="row" style="width: 150px">CT-Scan Baseline</th>
                        <td style="width: 10px">:</td>
                        <td>
                            <a :href="radio.ct_scan_url" target="_blank">{{ radio.ct_scan_url }}</a>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" style="width: 150px">Resume</th>
                        <td style="width: 10px">:</td>
                        <td>{{ radio.description }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <template v-if="id != 0">
            <DataTable
                ref="table"
                :url="fuStore.datatableLink"
                :data="{ radio_id: id }"
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
import { usePemeriksaanRadioterapiFUStore } from '@/stores/module/pemeriksaanRadioterapiFU'
import { usePemeriksaanRadioterapiStore } from '@/stores/module/pemeriksaanRadioterapi'

import type { ConfigColumns, Config } from 'datatables.net'
import { btnAction } from '@/core/helpers/datatable'
import { computed, ref } from 'vue'

const fuStore = usePemeriksaanRadioterapiFUStore()
const radioStore = usePemeriksaanRadioterapiStore()
const radio = computed(() => radioStore.itemDetail)
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
        data: 'ct_scan_path',
        name: 'ct_scan_path',
        title: 'CT Scan',
        className: 'w-70p',
        render: (data, meta, full) => {
            return `<a href="${full.ct_scan_url}" target="_blank">${full.ct_scan_url}</a>`
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
    fuStore.actionDelete(id).then(() => {
        table.value.reload()
    })
}

function actionUpSert(data: any): void {
    fuStore.actionUpSertFile(data).then(() => {
        formModal.value.hide()
        table.value.reload()
    })
}

function show(radioId: number = 0) {
    id.value = radioId
    radioStore.getDetail(radioId).then(() => {
        modal.value.show()
    })
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
