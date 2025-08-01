<template>
    <BaseModal modalId="followup" ref="modal" width="mw-800px">
        <template #title>
            <div class="d-flex align-items-center">
                <h3 class="mb-0 me-4">Follow Up</h3>
                <button class="btn btn-info btn-sm" @click="formModal.show({ target_id: id })">
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
                        <td>{{ target.date }}</td>
                    </tr>
                    <tr>
                        <th scope="row" style="width: 150px">Jenis Terapi Target</th>
                        <td style="width: 10px">:</td>
                        <td>
                            {{ target.category_text }}
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" style="width: 150px">Jenis</th>
                        <td style="width: 10px">:</td>
                        <td>{{ target.type }}</td>
                    </tr>
                    <tr>
                        <th scope="row" style="width: 150px">Lama (bulan)</th>
                        <td style="width: 10px">:</td>
                        <td>{{ target.long }}</td>
                    </tr>
                    <tr>
                        <th scope="row" style="width: 150px">CT-Scan Baseline</th>
                        <td style="width: 10px">:</td>
                        <td>
                            <a :href="target.ct_scan_url" target="_blank" v-if="target.ct_scan_url">
                                {{ target.ct_scan_url }}
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" style="width: 150px">Efek Samping</th>
                        <td style="width: 10px">:</td>
                        <td>{{ target.side_effect }}</td>
                    </tr>
                    <tr>
                        <th scope="row" style="width: 150px">Resume</th>
                        <td style="width: 10px">:</td>
                        <td>{{ target.description }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <template v-if="id != 0">
            <DataTable
                ref="table"
                :url="fuStore.datatableLink"
                :data="{ target_id: id }"
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
import { usePemeriksaanTerapiTargetFUStore } from '@/stores/module/pemeriksaanTerapiTargetFU'
import { usePemeriksaanTerapiTargetStore } from '@/stores/module/pemeriksaanTerapiTarget'

import type { ConfigColumns, Config } from 'datatables.net'
import { btnAction } from '@/core/helpers/datatable'
import { computed, ref } from 'vue'

const fuStore = usePemeriksaanTerapiTargetFUStore()
const targetStore = usePemeriksaanTerapiTargetStore()
const target = computed(() => targetStore.itemDetail)
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
            if (data == null || data == '') {
                return 'Tidak ada CT Scan'
            }
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

function show(targetId: number = 0) {
    id.value = targetId
    targetStore.getDetail(targetId).then(() => {
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
