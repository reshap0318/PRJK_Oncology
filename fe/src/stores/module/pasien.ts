import { defineStore } from 'pinia'
import { baseStore } from '@/core/helpers/store'
import { computed } from 'vue'

const basePath = '/api/pasien'
const base = baseStore(basePath)
export const usePasienStore = defineStore('pasien', () => {
    const pemeriksaanDatatableURL = computed(() => {
        return (id: string | number) => basePath + '/' + id + '/datatable-pemeriksaan'
    })

    return {
        ...base,
        pemeriksaanDatatableURL
    }
})
