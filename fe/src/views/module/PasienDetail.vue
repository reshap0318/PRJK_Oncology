<template>
    <div class="mb-5 mb-xl-8 card card-border-outline">
        <div class="card-header bg-light-success" style="min-height: 50px">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold text-gray-900">Informasi Pasien</span>
            </h3>
        </div>
        <div class="card-body" style="padding-top: 12px; padding-bottom: 12px">
            <div class="row">
                <div class="col-sm-6">
                    <table width="100%" class="table">
                        <tbody>
                            <tr>
                                <th scope="row" style="width: 150px">Nama Lengkap</th>
                                <td style="width: 10px">:</td>
                                <td>
                                    {{ data.name }} ( <b>{{ data.no_mr }}</b> )
                                </td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 150px">Jenis Kelamin</th>
                                <td style="width: 10px">:</td>
                                <td>{{ data.gender }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 150px">Tempat Tanggal Lahir</th>
                                <td style="width: 10px">:</td>
                                <td>{{ data.pob + ', ' + data.dob }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 150px">No Telephone</th>
                                <td style="width: 10px">:</td>
                                <td>{{ data.phone ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 150px">Kota & Province</th>
                                <td style="width: 10px">:</td>
                                <td>{{ data.city ?? '-' }} & {{ data.province ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-sm-6">
                    <table width="100%" class="table">
                        <tbody>
                            <tr>
                                <th scope="row" style="width: 150px">Email</th>
                                <td style="width: 10px">:</td>
                                <td>
                                    {{ data.email ?? '-' }}
                                </td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 150px">Pendidikan</th>
                                <td style="width: 10px">:</td>
                                <td>{{ data.education ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 150px">Pekerjaan</th>
                                <td style="width: 10px">:</td>
                                <td>{{ data.job ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 150px">Suku</th>
                                <td style="width: 10px">:</td>
                                <td>{{ data.ethnic ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 150px">Alamat</th>
                                <td style="width: 10px">:</td>
                                <td>{{ data.address ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-5 mb-xl-8 card card-border-outline">
        <div class="card-header bg-light-success" style="min-height: 50px">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold text-gray-900">Pemeriksaan Pasien</span>
            </h3>
        </div>
        <div class="card-body" style="padding-top: 12px; padding-bottom: 12px" v-if="id">
            <DataTable
                ref="table"
                :key="id"
                :url="pasienStore.pemeriksaanDatatableURL(id)"
                :columns="columns"
                :options="options"
                @onDelete="handleBtnDelete"
            />
        </div>
    </div>
    <FAB
        @click="formCreate.show({ pasien_id: id })"
        v-if="StrgService.hasPermission('pasien-pemeriksaan.inspection')"
    />
    <FormCreate ref="formCreate" @onSave="tableReload()" />
</template>
<script lang="ts" setup>
import DataTable from '@/components/utils/datatable/DataTable.vue'
import FormCreate from '@/components/view/pasienPemeriksaan/Create.vue'
import FAB from '@/components/utils/button/FAB.vue'
import StrgService from '@/core/services/StrgService'
import Swal from 'sweetalert2'

import type { ConfigColumns, Config } from 'datatables.net'
import { usePasienStore } from '@/stores/module/pasien'
import { usePasienPemeriksaanStore } from '@/stores/module/pasienPemeriksaan'
import { useExportLaporanStore } from '@/stores/module/exportLaporan'
import { computed, onMounted, watch, ref } from 'vue'
import { btnAction } from '@/core/helpers/datatable'
import { useRoute, useRouter } from 'vue-router'

const pasienStore = usePasienStore()
const pasienPemeriksaanStore = usePasienPemeriksaanStore()
const exportLaporan = useExportLaporanStore()
const route = useRoute()
const router = useRouter()
const table = ref()
const formCreate = ref()

const id = computed(() => route.params.id as string)
const data = computed(() => pasienStore.itemDetail)
const columns = ref<Array<ConfigColumns>>([
    {
        data: 'id',
        title: 'No'
    },
    {
        data: 'inspection_at',
        name: 'inspection_at',
        title: 'Tanggal Pemeriksaan',
        className: 'text-start'
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
    order: [1, 'desc'],
    pageLength: 5,
    lengthMenu: [5, 10, 25, 50, 100]
})

function getData(id: string): void {
    Swal.fire({
        title: 'Loading',
        html: 'mengambil data...',
        icon: 'info',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading()
        }
    })
    pasienStore.getDetail(id).finally(() => {
        Swal.close()
    })
}

function tableReload(): void {
    table.value.reload()
}

function handleBtnDelete(id: number): void {
    pasienPemeriksaanStore.actionDelete(id).then(() => {
        table.value.reload()
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

onMounted(() => {
    getData(id.value)

    table.value.getDT().on('click', '.btn-periksa', function (e: any) {
        e.preventDefault()
        const id = e.currentTarget.getAttribute('data-id')
        router.push({
            name: 'pemeriksaaan.edit',
            params: { id: id }
        })
    })

    table.value.getDT().on('click', '.btn-download', function (e: any) {
        e.preventDefault()
        const id = e.currentTarget.getAttribute('data-id')
        handleBtnDownload(id)
    })
})

watch(
    () => route.params.id as string,
    (val) => getData(val)
)
</script>

<style scoped>
table th,
td {
    padding: 4px 0px;
}
</style>
