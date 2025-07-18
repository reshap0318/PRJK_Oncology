<template>
    <div class="mb-5 mb-xl-8 card card-border-outline">
        <div class="card-body mt-2 hide-search-bar">
            <div class="row justify-content-sm-end">
                <div class="col-sm-6">
                    <button
                        type="button"
                        class="btn btn-info"
                        @click="formExport.show()"
                        v-if="StrgService.hasPermission('pasien-pemeriksaan.report')"
                    >
                        Export
                    </button>
                </div>
                <div class="col-sm-2">
                    <Multiselect
                        class="multiselect-form-control"
                        placeholder="Select Tatalaksana"
                        mode="single"
                        v-model="filterTable.tata_laksana"
                        :options="filterList.tata_laksana"
                        :clear-on-selected="false"
                    />
                </div>
                <div class="col-sm-2">
                    <Multiselect
                        class="multiselect-form-control"
                        placeholder="Select Jenis Sel"
                        mode="single"
                        v-model="filterTable.jenis_sel"
                        :options="filterList.jenis_sel"
                        :clear-on-selected="false"
                    />
                </div>
                <div class="col-sm-2">
                    <input
                        class="form-control"
                        type="search"
                        autocomplete="off"
                        placeholder="search"
                        v-model="filterTable.search"
                    />
                </div>
            </div>
            <DataTable
                ref="table"
                :url="pemeriksaanStore.datatableLink"
                :columns="columns"
                :options="options"
                :data="{
                    jenis_sel: filterTable.jenis_sel,
                    tata_laksana: filterTable.tata_laksana
                }"
                @onDelete="handleBtnDelete"
            />
        </div>
    </div>
    <FAB
        @click="formCreate.show({ tag: 'create' })"
        v-if="
            StrgService.hasAnyPermission([
                'pasien-pemeriksaan.inspection',
                'pasien-pemeriksaan.admin'
            ])
        "
    />
    <FormCreate ref="formCreate" @onSave="tableReload()" />
    <ExportExcel ref="formExport" />
</template>
<script lang="ts" setup>
import Multiselect from '@vueform/multiselect'
import DataTable from '@/components/utils/datatable/DataTable.vue'
import FormCreate from '@/components/view/pasienPemeriksaan/Create.vue'
import StrgService from '@/core/services/StrgService'
import FAB from '@/components/utils/button/FAB.vue'
import ExportExcel from '@/components/view/pasienPemeriksaan/ExportExcel.vue'

import type { ConfigColumns, Config } from 'datatables.net'
import { usePasienPemeriksaanStore } from '@/stores/module/pasienPemeriksaan'
import { useExportLaporanStore } from '@/stores/module/exportLaporan'
import { btnAction } from '@/core/helpers/datatable'
import { nextTick, onMounted, ref, watch } from 'vue'
import { useRouter } from 'vue-router'
import Swal from 'sweetalert2'

const pemeriksaanStore = usePasienPemeriksaanStore()
const exportLaporan = useExportLaporanStore()
const table = ref()
const formExport = ref()
const router = useRouter()
const formCreate = ref()
const filterTable = ref({
    search: '',
    jenis_sel: null,
    tata_laksana: null
})
const filterList = ref({
    jenis_sel: [
        {
            value: 1,
            label: 'Sel Kanker'
        },
        {
            value: 2,
            label: 'Sel Besar'
        },
        {
            value: 3,
            label: 'Adenokarsenoma'
        },
        {
            value: 4,
            label: 'KSS'
        },
        {
            value: 5,
            label: 'KPKBSK'
        }
    ],
    tata_laksana: [
        {
            value: 1,
            label: 'Kemoterapi'
        },
        {
            value: 2,
            label: 'Operasi'
        },
        {
            value: 3,
            label: 'Terapi Target'
        },
        {
            value: 4,
            label: 'Radio Terapi'
        }
    ]
})

const columns = ref<Array<ConfigColumns>>([
    {
        data: 'id',
        title: 'No'
    },
    {
        data: 'inspection_at',
        name: 'pm.inspection_at',
        title: 'Tanggal',
        className: 'w-10p text-start'
    },
    {
        data: 'dokter_name',
        name: 'd.name',
        title: 'Dokter',
        className: 'w-30p'
    },
    {
        data: 'pasien_name',
        name: 'p.name',
        title: 'Pasien',
        className: 'w-50p'
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
    order: [[1, 'asc']],
    lengthChange: false,
    searching: true
})

function handleBtnDelete(id: number): void {
    pemeriksaanStore.actionDelete(id).then(() => {
        tableReload()
    })
}

function handleBtnDownload(id: number): void {
    const row = table.value
        .getDT()
        .rows()
        .data()
        .toArray()
        .find((elm: any) => elm.id == id || elm.code == id)

    Swal.fire({
        icon: 'info',
        title: 'Tunggu sebentar yaa...',
        timerProgressBar: true,
        allowOutsideClick: false,
        allowEscapeKey: false,
        didOpen: () => {
            Swal.showLoading()
        }
    })

    exportLaporan
        .downloadPDF(id)
        .then((res: any) => {
            const url = window.URL.createObjectURL(new Blob([res]))
            const link = document.createElement('a')
            link.href = url
            link.setAttribute(
                'download',
                `Pemeriksaan Pasien ${row.inspection_at} ${row.pasien_name}.pdf`
            )
            document.body.appendChild(link)
            link.click()
            link.remove()
        })
        .finally(() => {
            Swal.close()
        })
}

function exportModal() {}

function tableReload(): void {
    table.value.reload()
}

watch(
    () => filterTable.value.search,
    (val) => {
        const dt = table.value.getDT()
        dt.search(val)
        dt.table().draw()
    }
)

watch(
    () => filterTable.value.jenis_sel,
    (val) => {
        nextTick(() => {
            tableReload()
        })
    }
)

watch(
    () => filterTable.value.tata_laksana,
    (val) => {
        nextTick(() => {
            tableReload()
        })
    }
)

onMounted(() => {
    table.value.getDT().on('click', '.btn-periksa', function (e: any) {
        e.preventDefault()
        const id = e.currentTarget.getAttribute('data-id')
        router.push({ name: 'pemeriksaaan.edit', params: { id: id } })
    })

    table.value.getDT().on('click', '.btn-download', function (e: any) {
        e.preventDefault()
        const id = e.currentTarget.getAttribute('data-id')
        handleBtnDownload(id)
    })
})
</script>

<style>
.hide-search-bar .dt-search {
    visibility: hidden;
    display: none;
}
</style>
