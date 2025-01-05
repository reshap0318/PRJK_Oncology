<template>
    <div class="mb-5 mb-xl-8 card card-border-outline">
        <div class="card-body">
            <DataTable
                ref="table"
                :url="scheduleStore.datatableLink"
                :columns="columns"
                :options="options"
            />
        </div>
    </div>
    <FAB
        @click="router.push({ name: 'schedule.create' })"
        v-if="StrgService.hasPermission('schedule.create')"
    />
</template>
<script lang="ts" setup>
import DataTable from '@/components/utils/datatable/DataTable.vue'
import FAB from '@/components/utils/button/FAB.vue'
import StrgService from '@/core/services/StrgService'

import type { ConfigColumns, Config } from 'datatables.net'
import { ref, onMounted } from 'vue'
import { useScheduleStore } from '@/stores/system/schedule'
import { useRouter } from 'vue-router'
import { active } from '@/core/helpers/datatable'

const table = ref()
const router = useRouter()
const scheduleStore = useScheduleStore()
const columns = ref<Array<ConfigColumns>>([
    {
        data: 'description',
        title: 'Description',
        render: (data, type, row, meta) => {
            if (row.action.detail.isCan)
                return `<a href="javascript:void(0)" data-id="${row.id}" class="btn-detail">${data}</a>`
            return data
        }
    },
    {
        data: 'timezone',
        title: 'Timezone',
        render: (data) => {
            return `<span class="badge badge-success" style="color:white">${data}</span>`
        }
    },
    {
        data: 'last_run',
        className: 'text-start',
        title: 'Last Run'
    },
    {
        data: 'next_run',
        className: 'text-start',
        title: 'Next Run'
    },
    {
        data: 'is_active',
        title: 'Status',
        className: 'text-center',
        render: active
    }
])
const options = ref<Config>({
    order: [[3, 'asc']],
    serverSide: false
})

onMounted(() => {
    table.value.getDT().on('click', '.btn-detail', function (e: any) {
        e.preventDefault()
        const id = e.currentTarget.getAttribute('data-id')
        router.push({
            name: 'schedule.detail',
            params: { id: id }
        })
    })
})
</script>
