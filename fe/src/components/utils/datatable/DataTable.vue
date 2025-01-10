<template>
    <div class="dt-responsive">
        <!-- @ts-ignore -->
        <DataTable
            class="table table-striped table-bordered align-middle"
            style="width: 100%"
            :ajax="ajaxRequest"
            :columns="realColumns"
            :options="realOptions"
            ref="table"
        >
            <thead>
                <tr class="fw-bold text-muted">
                    <th v-for="col in realColumns" :key="col.name"></th>
                </tr>
            </thead>
        </DataTable>
    </div>
</template>
<script lang="ts" setup>
import DataTable from 'datatables.net-vue3'
import DataTablesCore from 'datatables.net-bs5'
import DataTablesButton from 'datatables.net-buttons'
import Swal from 'sweetalert2'

import type { ConfigColumns, Config } from 'datatables.net'
import { computed, ref, type PropType, onMounted } from 'vue'
import { useAuthStore } from '@/stores/auth'
import StrgService from '@/core/services/StrgService'

DataTablesCore.ext.errMode = 'none'
DataTable.use(DataTablesCore, DataTablesButton)

const store = useAuthStore()
const emit = defineEmits(['onEdit', 'onDelete', 'onDetail'])

const prop = defineProps({
    url: {
        type: String,
        required: true
    },
    columns: {
        type: Array<ConfigColumns>,
        required: true
    },
    options: {
        type: Object as PropType<Config>,
        default() {
            return {}
        }
    },
    data: {
        type: Object
    }
})

const realColumns = computed((): Array<ConfigColumns> => {
    const columns = prop.columns
    const idxCol = columns.findIndex((col) => col.title?.toLowerCase() == 'no')
    if (idxCol > -1) {
        columns[idxCol] = {
            data: 'id',
            title: 'No',
            className: 'text-center w-number',
            orderable: true,
            searchable: false,
            render: function (data, type, row, meta: any) {
                return meta.row + meta.settings._iDisplayStart + 1
            },
            ...columns[idxCol]
        }
    }

    const actionCol = columns.findIndex((col) => col.data == 'action')
    if (actionCol > -1) {
        columns[actionCol] = {
            orderable: false,
            searchable: false,
            className: 'text-center w-action text-nowrap',
            ...columns[actionCol]
        }
    }
    return columns
})

const realOptions = computed((): Config => {
    return {
        ...{
            order: [[1, 'asc']],
            serverSide: true,
            processing: true
            // responsive: true
        },
        ...prop.options
    }
})

const ajaxRequest = computed(() => {
    const baseURL: string = import.meta.env.VITE_APP_API_URL
    return {
        url: baseURL + prop.url,
        type: 'POST',
        dataSrc: 'data',
        data: function (d: any) {
            const req = {
                ...d,
                ...prop.data
            }
            return JSON.stringify(req)
        },
        beforeSend: function (request: any) {
            request.setRequestHeader('Accept', 'application/json')
            request.setRequestHeader('Content-Type', 'application/json')
            request.setRequestHeader('App-Token', import.meta.env.VITE_APP_TOKEN)
            request.setRequestHeader('Authorization', 'Bearer ' + StrgService.getToken())
        },
        error: function (xhr, error, code) {
            if (xhr.status == 401) {
                Swal.fire({
                    title: 'Logout',
                    icon: 'warning'
                }).then(() => {
                    store.purgeAuth()
                    location.reload()
                })
            } else {
                Swal.fire({
                    title: 'Error',
                    text: 'internal server error',
                    icon: 'error'
                })
            }
        }
    }
})

const dt = ref()
const table = ref()

onMounted(() => {
    dt.value = table.value.dt
    // $.fn.dataTable.ext.errMode = 'none';
    dt.value.on('error.dt', function (e, settings, techNote, message) {
        console.log('An error has been reported by DataTables: ', message)
    })

    dt.value.on('click', '.btn-edit', function (e: any) {
        e.preventDefault()
        const id = e.currentTarget.getAttribute('data-id')
        const row = dt.value
            .rows()
            .data()
            .toArray()
            .find((elm: any) => elm.id == id || elm.code == id)
        emit('onEdit', row)
    })

    dt.value.on('click', '.btn-delete', function (e: any) {
        e.preventDefault()
        const id = e.currentTarget.getAttribute('data-id')
        emit('onDelete', id)
    })

    dt.value.on('click', '.btn-detail', function (e: any) {
        e.preventDefault()
        const id = e.currentTarget.getAttribute('data-id')
        emit('onDetail', id)
    })
})

function getDT() {
    return dt.value
}

function reload() {
    dt.value.ajax.reload()
}

defineExpose({
    getDT,
    reload
})
</script>
<style scoped>
.w-number {
    width: 3rem;
}

.w-action {
    width: 7rem;
}

.w-100px {
    width: 100px;
}

.w-200px {
    width: 200px;
}

.w-300px {
    width: 300px;
}

.w-400px {
    width: 400px;
}

.w-500px {
    width: 500px;
}

.w-600px {
    width: 600px;
}

.w-700px {
    width: 700px;
}

.w-800px {
    width: 800px;
}

.w-10p {
    width: 10%;
}

.w-20p {
    width: 20%;
}

.w-30p {
    width: 30%;
}

.w-40p {
    width: 40%;
}

.w-50p {
    width: 50%;
}

.w-60p {
    width: 60%;
}

.w-70p {
    width: 70%;
}

.w-80p {
    width: 80%;
}

.w-90p {
    width: 90%;
}
</style>
<style>
@import 'datatables.net-bs5';
/* @import 'datatables.net-buttons'; */

.align-middle td,
.align-middle th {
    vertical-align: middle !important;
}

.table > tbody > * > * {
    padding: 0.5rem 0.75rem !important;
}

.dt-layout-full {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

.dt-layout-full::-webkit-scrollbar {
    height: 4px;
    width: 4px;
    background: #bebebe;
}
.dt-layout-full::-webkit-scrollbar-thumb:horizontal {
    background: #000;
    border-radius: 10px;
}
</style>
