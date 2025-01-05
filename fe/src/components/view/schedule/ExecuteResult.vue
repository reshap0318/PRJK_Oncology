<template>
    <div class="row mt-7 mb-10">
        <div class="col-12">
            <h5 class="mb-3">EXECUTION RESULTS</h5>
            <div class="card card-border-outline">
                <div class="card-body" v-if="scheduleId">
                    <DataTable
                        :url="scheduleStore.resultDatatableLink(scheduleId)"
                        :columns="columns"
                        :options="options"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import DataTable from '@/components/utils/datatable/DataTable.vue'

import { ref } from 'vue'
import type { ConfigColumns, Config } from 'datatables.net'
import { useScheduleStore } from '@/stores/system/schedule'

const scheduleStore = useScheduleStore()
const columns = ref<Array<ConfigColumns>>([
    {
        data: 'run_at',
        name: 'run_at',
        title: 'Run At',
        className: 'text-start'
    },
    {
        data: 'duration',
        name: 'duration',
        title: 'Duration'
    },
    {
        data: 'result',
        name: 'result',
        title: 'Result'
    }
])
const options = ref<Config>({ order: [0, 'desc'], lengthChange: false, pageLength: 5 })

defineProps({
    scheduleId: {
        type: [String, Number]
    }
})
</script>
