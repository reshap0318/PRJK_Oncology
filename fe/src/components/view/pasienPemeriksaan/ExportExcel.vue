<template>
    <BaseModal modalId="download" ref="modal" width="mw-600px">
        <template #title> Filter Download </template>
        <form class="form" @submit.prevent="exportModal">
            <div class="row">
                <div class="col-12 my-2">
                    <label class="form-label fs-6 text-dark">
                        <span>Dokter</span>
                    </label>
                    <Multiselect
                        class="multiselect-form-control"
                        placeholder="Select Dokter"
                        mode="single"
                        v-model="filterExport.dokter"
                        :options="selectStore.dokters"
                        :clear-on-selected="false"
                    />
                    <form-error :err="v$.dokter" name="dokter" />
                </div>
                <div class="col-12 col-sm-6 my-2">
                    <label class="form-label fs-6 text-dark">
                        <span>Tanggal Mulai</span>
                    </label>
                    <input type="date" class="form-control" v-model="filterExport.startDate" />
                    <form-error :err="v$.startDate" name="startDate" />
                </div>
                <div class="col-12 col-sm-6 my-2">
                    <label class="form-label fs-6 text-dark">
                        <span>Tanggal Selesai</span>
                    </label>
                    <input type="date" class="form-control" v-model="filterExport.endDate" />
                    <form-error :err="v$.endDate" name="endDate" />
                </div>
            </div>
            <div class="text-end pt-5">
                <button type="button" class="btn btn-light me-3" @click="modal.hide()">
                    Batal
                </button>
                <button type="submit" class="btn btn-primary">Export</button>
            </div>
        </form>
    </BaseModal>
</template>

<script lang="ts" setup>
import BaseModal from '@/components/utils/modal/BaseModal.vue'
import Multiselect from '@vueform/multiselect'
import FormError from '@/components/utils/error/FormError.vue'

import { useVuelidate } from '@vuelidate/core'
import { required } from '@vuelidate/validators'
import { useSelectStore } from '@/stores/global/select'
import { useExportLaporanStore } from '@/stores/module/exportLaporan'
import { ref } from 'vue'

import Swal from 'sweetalert2'

const modal = ref()
const selectStore = useSelectStore()
const exportLaporan = useExportLaporanStore()
const filterExport = ref<any>({
    dokter: null,
    startDate: null,
    endDate: null
})
const rules = ref({
    dokter: {},
    startDate: { required },
    endDate: { required }
})

const v$ = useVuelidate(rules, filterExport, { $scope: false })

function exportModal() {
    v$.value.$validate().then((res) => {
        if (res) {
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
                .downloadExcel(filterExport.value)
                .then((res: any) => {
                    const url = window.URL.createObjectURL(new Blob([res]))
                    const link = document.createElement('a')
                    link.href = url
                    link.setAttribute('download', `Laporan Pemeriksaan.xlsx`)
                    document.body.appendChild(link)
                    link.click()
                    link.remove()
                })
                .finally(() => {
                    Swal.close()
                })
        }
    })
}

function show(): void {
    var date = new Date(),
        y = date.getFullYear(),
        m = date.getMonth()
    var firstDay = new Date(y, m, 1)
        .toLocaleString('id-ID', { year: 'numeric', month: '2-digit', day: '2-digit' })
        .replace(/(\d+)\/(\d+)\/(\d+)/, '$3-$2-$1')
    var lastDay = new Date(y, m + 1, 0)
        .toLocaleString('id-ID', { year: 'numeric', month: '2-digit', day: '2-digit' })
        .replace(/(\d+)\/(\d+)\/(\d+)/, '$3-$2-$1')

    filterExport.value = {
        dokter: null,
        startDate: firstDay,
        endDate: lastDay
    }
    modal.value.show()
}

defineExpose({
    show
})
</script>
