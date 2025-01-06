<template>
    <div class="page-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-border-outline">
                    <div class="card-body">
                        <DataTable
                            ref="table"
                            :url="logUserStore.datatableLink"
                            :columns="columns"
                            :options="options"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script lang="ts" setup>
import DataTable from '@/components/utils/datatable/DataTable.vue'

import { onMounted, ref } from 'vue'
import type { ConfigColumns, Config } from 'datatables.net'
import { useLogUserStore } from '@/stores/system/logUser'

const logUserStore = useLogUserStore()
const table = ref()
const dt = ref()
const columns = ref<Array<ConfigColumns>>([
    {
        className: 'dt-control',
        orderable: false,
        searchable: false,
        data: null,
        title: '',
        defaultContent: ''
    },
    {
        data: 'id',
        title: 'No'
    },
    {
        data: 'status',
        name: 'status',
        title: 'Status',
        className: 'text-center w-100px',
        render: (data) => {
            let state = 'success'
            if (data >= 300 && data < 500) state = 'warning'
            else if (data >= 500) state = 'danger'

            return `<span class="badge badge-light-${state}">${data}</span>`
        }
    },
    {
        data: 'ip_address',
        className: 'w-200px',
        title: 'IP Address'
    },
    {
        data: 'url',
        className: 'w-200px',
        title: 'URL'
    },
    {
        data: 'user.name',
        name: 'user.name',
        title: 'User'
    },
    {
        data: 'description',
        title: 'Keterangan'
    },
    {
        data: 'server_time',
        title: 'Waktu Server'
    }
])
const options = ref<Config>({
    order: [[7, 'desc']],
    serverSide: true
})

function format(d: any) {
    var request = d.request_payload
    var response = d.response_payload
    try {
        return `<b>request : </b><pre> <code style="width: 98%">${JSON.stringify(
            request,
            null,
            6
        ).replace(/\n( *)/g, function (match, p1) {
            return '<br>' + '&nbsp;'.repeat(p1.length)
        })}</code> </pre> <br/> <b>response : </b><pre> <code style="width: 98%">${JSON.stringify(
            response,
            null,
            6
        ).replace(/\n( *)/g, function (match, p1) {
            return '<br>' + '&nbsp;'.repeat(p1.length)
        })}</code> </pre>`
    } catch (error) {
        return `<pre > <code style="width: 98%">${response}</pre>`
    }
}

onMounted(() => {
    dt.value = table.value.getDT()
    dt.value.on('click', 'td.dt-control', function (e) {
        let tr = e.target.closest('tr')
        let row = dt.value.row(tr)
        if (row.child.isShown()) {
            row.child.hide()
        } else {
            // Open this row
            row.child(format(row.data())).show()
        }
    })
})
</script>
