import { defineStore } from 'pinia'
import { ref } from 'vue'

const basePath = '/api/log'
export const useLogUserStore = defineStore('log-user', () => {
    const datatableLink = ref(basePath + '/datatable')
    return {
        datatableLink
    }
})
