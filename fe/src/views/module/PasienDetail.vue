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
                @onDetail="handleBtnDetail"
            />
        </div>
    </div>

    <BaseModal modalId="default" ref="modal" width="modal-fullscreen">
        <div class="d-flex flex-column align-items-center" style="margin-top: 125px">
            <img
                src="https://media0.giphy.com/media/v1.Y2lkPTc5MGI3NjExd3J1azI3bWwwNWNhMjh3dm96bzJmdmxtbW1oOTl3enh2OW5oMGkwNyZlcD12MV9pbnRlcm5hbF9naWZfYnlfaWQmY3Q9Zw/UsR4o48xrjiZx6iOd6/giphy.webp"
                alt=""
            />
            <h1>Under Maintenance</h1>
        </div>
    </BaseModal>
</template>
<script lang="ts" setup>
import BaseModal from '@/components/utils/modal/BaseModal.vue'
import DataTable from '@/components/utils/datatable/DataTable.vue'
import Swal from 'sweetalert2'

import type { ConfigColumns, Config } from 'datatables.net'
import { usePasienStore } from '@/stores/module/pasien'
import { usePasienPemeriksaanStore } from '@/stores/module/pasienPemeriksaan'
import { computed, onMounted, watch, ref } from 'vue'
import { btnAction } from '@/core/helpers/datatable'
import { useRoute } from 'vue-router'

const pasienStore = usePasienStore()
const pasienPemeriksaanStore = usePasienPemeriksaanStore()
const route = useRoute()
const table = ref()
const modal = ref()

const id = computed(() => route.params.id as string)
const data = computed(() => pasienStore.itemDetail)
const columns = ref<Array<ConfigColumns>>([
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
    order: [0, 'desc'],
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

function handleBtnDelete(id: number): void {
    pasienPemeriksaanStore.actionDelete(id).then(() => {
        table.value.reload()
    })
}

function handleBtnDetail(id: any): void {
    pasienPemeriksaanStore.getDetail(id).then((res) => {
        modal.value.show()
    })
}

onMounted(() => {
    getData(id.value)
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
